<?php
$context = stream_context_create(['http' => ['ignore_errors' => true]]);
$result = file_get_contents('https://vmbeqfvinubobtatzsin.supabase.co/storage/v1/object/public/toko-app-images/qr-menu.png', false, $context);
echo $result;
