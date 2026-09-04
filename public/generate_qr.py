import qrcode
from qrcode.image.styledpil import StyledPilImage
from qrcode.image.styles.moduledrawers import RoundedModuleDrawer
from qrcode.image.styles.colormasks import RadialGradiantColorMask, VerticalGradiantColorMask
from PIL import Image, ImageDraw, ImageFont

# 1. Create the logo (Circle with 'KT')
logo_size = 120
logo = Image.new("RGBA", (logo_size, logo_size), (0, 0, 0, 0))
draw = ImageDraw.Draw(logo)

# Draw circle background (Dark Green)
draw.ellipse((0, 0, logo_size, logo_size), fill=(0, 136, 15, 255))

# Draw text
try:
    font = ImageFont.truetype("arial.ttf", 60)
except:
    font = ImageFont.load_default()

text = "KT"
# Get text bounding box for centering
bbox = draw.textbbox((0, 0), text, font=font)
text_w = bbox[2] - bbox[0]
text_h = bbox[3] - bbox[1]
draw.text(((logo_size - text_w) / 2, (logo_size - text_h) / 2 - 5), text, font=font, fill=(255, 255, 255, 255))

# 2. Generate QR Code
qr = qrcode.QRCode(
    version=5, # slightly larger to accommodate logo nicely
    error_correction=qrcode.constants.ERROR_CORRECT_H, # High error correction for logo
    box_size=15,
    border=2,
)
qr.add_data('https://toko-app-nine.vercel.app/')
qr.make(fit=True)

# 3. Create Styled Image
img = qr.make_image(
    image_factory=StyledPilImage,
    module_drawer=RoundedModuleDrawer(),
    color_mask=VerticalGradiantColorMask(
        back_color=(255, 255, 255),
        top_color=(0, 136, 15),     # Grab Green
        bottom_color=(139, 69, 19)   # Brown (Kembang Tahu)
    ),
    embeded_image_path=None
)

# 4. Embed Logo Manually (since embeded_image_path requires a file)
img = img.convert("RGBA")
img_w, img_h = img.size
pos = ((img_w - logo_size) // 2, (img_h - logo_size) // 2)

# Create a white background for the logo to separate it from QR modules
bg_size = logo_size + 20
logo_bg = Image.new("RGBA", (bg_size, bg_size), (255, 255, 255, 255))
draw_bg = ImageDraw.Draw(logo_bg)
draw_bg.ellipse((0, 0, bg_size, bg_size), fill=(255, 255, 255, 255))

# Paste white bg then logo
bg_pos = ((img_w - bg_size) // 2, (img_h - bg_size) // 2)
img.paste(logo_bg, bg_pos, logo_bg)
img.paste(logo, pos, logo)

# 5. Add a beautiful frame/border around the whole thing
final_size = img_w + 100
final_img = Image.new("RGBA", (final_size, final_size + 100), (249, 250, 251, 255)) # Light gray-bg
draw_final = ImageDraw.Draw(final_img)

# Paste QR
final_img.paste(img, (50, 50))

# Add "SCAN MENU" Text at bottom
try:
    font_bold = ImageFont.truetype("arial.ttf", 36)
    font_small = ImageFont.truetype("arial.ttf", 20)
except:
    font_bold = ImageFont.load_default()
    font_small = ImageFont.load_default()

title = "SCAN UNTUK MELIHAT MENU"
subtitle = "Kembang Tahu Pak Ujang"

bbox_t = draw_final.textbbox((0, 0), title, font=font_bold)
draw_final.text(((final_size - (bbox_t[2]-bbox_t[0])) / 2, img_h + 50), title, font=font_bold, fill=(17, 24, 39, 255))

bbox_s = draw_final.textbbox((0, 0), subtitle, font=font_small)
draw_final.text(((final_size - (bbox_s[2]-bbox_s[0])) / 2, img_h + 100), subtitle, font=font_small, fill=(107, 114, 128, 255))


final_img.save("qr-menu.png")
print("QR Code created successfully!")
