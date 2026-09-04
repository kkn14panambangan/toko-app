<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;

// Upload logo
$contents = file_get_contents(public_path('storage/logo.jpg'));
Storage::disk('s3')->put('logo.jpg', $contents, 'public');
echo "Logo baru diupload ke S3\n";
