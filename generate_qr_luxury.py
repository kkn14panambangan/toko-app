import os
import urllib.request
import qrcode
from qrcode.image.styledpil import StyledPilImage
from qrcode.image.styles.moduledrawers import RoundedModuleDrawer
from qrcode.image.styles.colormasks import SolidFillColorMask
from PIL import Image, ImageDraw, ImageFont, ImageFilter

# 1. Download Fonts
fonts_dir = "fonts"
os.makedirs(fonts_dir, exist_ok=True)
font_title_path = os.path.join(fonts_dir, "GreatVibes-Regular.ttf")
font_body_path = os.path.join(fonts_dir, "Montserrat-Regular.ttf")
font_bold_path = os.path.join(fonts_dir, "Montserrat-Bold.ttf")

if not os.path.exists(font_title_path):
    try:
        urllib.request.urlretrieve("https://raw.githubusercontent.com/google/fonts/main/ofl/greatvibes/GreatVibes-Regular.ttf", font_title_path)
    except:
        font_title_path = "arial.ttf"

font_body_path = "arial.ttf"
font_bold_path = "arialbd.ttf"

# Load Fonts
try:
    font_title = ImageFont.truetype(font_title_path, 240)
except:
    font_title = ImageFont.load_default()

try:
    font_subtitle = ImageFont.truetype(font_body_path, 32)
    font_social = ImageFont.truetype(font_body_path, 26)
    font_social_bold = ImageFont.truetype(font_bold_path, 26)
except:
    font_subtitle = font_social = font_social_bold = ImageFont.load_default()

# 2. Base Image setup (1200x1800 - Poster 2:3 ratio)
WIDTH, HEIGHT = 1200, 1800
bg_color = (70, 44, 29, 255) # Warm brown matching logo
gold_color = (212, 175, 55, 255)
white_color = (255, 255, 255, 255)

img = Image.new("RGBA", (WIDTH, HEIGHT), bg_color)
draw = ImageDraw.Draw(img)

# 3. Draw Gold Border Frame
border_margin = 60
border_width = 3
draw.rectangle(
    [border_margin, border_margin, WIDTH - border_margin, HEIGHT - border_margin],
    outline=gold_color,
    width=border_width
)
# Inner thin border
draw.rectangle(
    [border_margin + 15, border_margin + 15, WIDTH - border_margin - 15, HEIGHT - border_margin - 15],
    outline=(212, 175, 55, 100),
    width=1
)

# 4. Draw "Menu" Text
title_text = "Menu"
bbox_title = draw.textbbox((0, 0), title_text, font=font_title)
title_w = bbox_title[2] - bbox_title[0]
title_h = bbox_title[3] - bbox_title[1]
title_y = 180
draw.text(((WIDTH - title_w) / 2, title_y), title_text, font=font_title, fill=gold_color)

# Draw Subtitle
subtitle_text = "SCAN QR CODE UNTUK MELIHAT MENU"
bbox_sub = draw.textbbox((0, 0), subtitle_text, font=font_subtitle)
sub_w = bbox_sub[2] - bbox_sub[0]
sub_y = title_y + 260
draw.text(((WIDTH - sub_w) / 2, sub_y), subtitle_text, font=font_subtitle, fill=gold_color)

# 5. Prepare the Logo
logo_path = r"C:\Users\Adin Nugraha\.gemini\antigravity-ide\brain\9e5c5e75-dc3c-4eae-991b-723707e811bf\.user_uploaded\media_1788557306164.jpg"
logo_size = 240
raw_logo = Image.open(logo_path).convert("RGBA")
# Crop logo to circle
raw_logo = raw_logo.resize((logo_size, logo_size), Image.Resampling.LANCZOS)
mask = Image.new("L", (logo_size, logo_size), 0)
draw_mask = ImageDraw.Draw(mask)
draw_mask.ellipse((0, 0, logo_size, logo_size), fill=255)
logo_circle = Image.new("RGBA", (logo_size, logo_size), (0,0,0,0))
logo_circle.paste(raw_logo, (0, 0), mask=mask)

# Add gold border to logo
logo_with_border = Image.new("RGBA", (logo_size + 16, logo_size + 16), (0,0,0,0))
draw_lb = ImageDraw.Draw(logo_with_border)
draw_lb.ellipse((0, 0, logo_size + 16, logo_size + 16), fill=gold_color)
draw_lb.ellipse((4, 4, logo_size + 12, logo_size + 12), fill=white_color)
logo_with_border.paste(logo_circle, (8, 8), logo_circle)

# 6. Generate QR Code
qr = qrcode.QRCode(
    version=6, 
    error_correction=qrcode.constants.ERROR_CORRECT_H, 
    box_size=15,
    border=2,
)
qr.add_data('https://toko-app-nine.vercel.app/')
qr.make(fit=True)

qr_img = qr.make_image(
    image_factory=StyledPilImage,
    module_drawer=RoundedModuleDrawer(),
    color_mask=SolidFillColorMask(front_color=(40, 20, 10), back_color=(255, 255, 255))
).convert("RGBA")

# Embed logo in QR
qr_w, qr_h = qr_img.size
qr_img.paste(logo_with_border, ((qr_w - logo_with_border.width) // 2, (qr_h - logo_with_border.height) // 2), logo_with_border)

# Put QR in a nice gold-bordered box
box_padding = 40
qr_box_size = qr_w + (box_padding * 2)
qr_box = Image.new("RGBA", (qr_box_size, qr_box_size), white_color)
draw_qb = ImageDraw.Draw(qr_box)
draw_qb.rectangle([0, 0, qr_box_size-1, qr_box_size-1], outline=gold_color, width=6)
qr_box.paste(qr_img, (box_padding, box_padding))

# Paste QR box onto main image
qr_y = sub_y + 100
qr_x = (WIDTH - qr_box_size) // 2
img.paste(qr_box, (qr_x, qr_y))

# 7. Add Social Media Info
info_y = qr_y + qr_box_size + 110

socials = [
    ("WhatsApp", "0822 1306 6810"),
    ("Instagram", "@kknpanambangan14_umc"),
    ("TikTok", "kkn.panambangan_umc"),
    ("YouTube", "KKNPANAMBANGAN14UMC")
]

# Draw dotted divider
divider_w = 400
divider_x = (WIDTH - divider_w) // 2
draw.line((divider_x, info_y, divider_x + divider_w, info_y), fill=gold_color, width=2)

info_y += 50

for platform, handle in socials:
    # Measure platform
    bbox_p = draw.textbbox((0,0), platform.upper() + ": ", font=font_social_bold)
    pw = bbox_p[2] - bbox_p[0]
    
    # Measure handle
    bbox_h = draw.textbbox((0,0), handle, font=font_social)
    hw = bbox_h[2] - bbox_h[0]
    
    total_w = pw + hw
    start_x = (WIDTH - total_w) // 2
    
    draw.text((start_x, info_y), platform.upper() + ": ", font=font_social_bold, fill=gold_color)
    draw.text((start_x + pw, info_y), handle, font=font_social, fill=white_color)
    
    info_y += 45

# Draw bottom divider
info_y += 15
draw.line((divider_x, info_y, divider_x + divider_w, info_y), fill=gold_color, width=2)


img = img.convert("RGB")
img.save("public/qr-menu.png", quality=95)
print("Luxury QR Menu generated successfully!")
