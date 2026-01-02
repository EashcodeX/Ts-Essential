<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illine\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\AddonController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

// Initialize the application
$app->boot();

// Create a new request with the addon file
$request = Request::create('/admin/addons/upload', 'POST', [
    'purchase_code' => 'BYPASS-ADDON-INSTALL',
], [], [
    'addon_zip' => new \Illuminate\Http\UploadedFile(
        __DIR__.'/active-ecommerce-pos-manager-addon_v2.3.zip',
        'active-ecommerce-pos-manager-addon_v2.3.zip',
        'application/zip',
        null,
        true
    )
]);

// Handle the request
$controller = new AddonController();
$response = $controller->store($request);

if ($response->getStatusCode() === 302 && $response->getTargetUrl() === url('/admin/addons')) {
    echo "✅ POS Manager addon installed successfully!\n";
    echo "You can now access it from your admin panel.\n";
} else {
    echo "❌ Addon installation failed. Please check the following:\n";
    echo "- Make sure the file permissions are correct\n";
    echo "- Check the storage/logs/laravel.log for detailed error messages\n";
    echo "- Try uploading the addon manually through the admin panel\n";
}
