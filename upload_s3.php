<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

$localPath = public_path('storage');
if (File::exists($localPath)) {
    $files = File::allFiles($localPath);

    foreach ($files as $file) {
        $relativePath = str_replace('\\', '/', $file->getRelativePathname());
        echo "Uploading " . $relativePath . "...\n";
        $contents = file_get_contents($file->getPathname());
        // Upload to S3 with public visibility
        Storage::disk('s3')->put($relativePath, $contents, 'public');
        echo "Uploaded " . $relativePath . "\n";
    }
    echo "Done!\n";
} else {
    echo "Path $localPath does not exist\n";
}
