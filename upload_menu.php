<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use App\Models\Product;

// Upload menu image
$contents = file_get_contents(public_path('storage/menu.jpg'));
Storage::disk('s3')->put('menu.jpg', $contents, 'public');
echo "Menu image uploaded to S3\n";

// Update database
Product::where('id', '>', 0)->update(['gambar' => 'menu.jpg']);
echo "Database updated to use menu.jpg\n";
