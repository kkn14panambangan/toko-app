<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;

// Upload QR image
$contents = file_get_contents(public_path('storage/qr.png'));
Storage::disk('s3')->put('qr-menu.png', $contents, 'public');
echo "QR image uploaded to S3\n";
