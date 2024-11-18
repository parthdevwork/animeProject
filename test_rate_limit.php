<?php

// Include Laravel's bootstrap file to initialize the application
require_once '/opt/lampp/htdocs/anime-app-2/vendor/autoload.php';
$app = require_once '/opt/lampp/htdocs/anime-app-2/bootstrap/app.php';

// Get the Laravel service container
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap(); // Bootstrap Laravel

// Use necessary Laravel Facades
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

// Fetch all slugs from the database (Anime table)
$slugs = DB::table('anime')->pluck('slug'); // Adjust if the table name is different

// Loop through each slug and make the API requests
foreach ($slugs as $index => $slug) {
    $url = "http://127.0.0.1:8000/api/anime/$slug"; // API URL with dynamic slug

    // Fetch the response from the API
    $response = @file_get_contents($url);  // Use @ to suppress warning if URL fails

    if ($response === FALSE) {
        // In case the request failed, output the error
        echo "Request failed for slug '$slug' (Request $index)\n";
    } else {
        echo "Response for slug '$slug' (Request $index): " . $http_response_header[0] . "\n";
    }

    // Add a delay between requests to respect rate limiting
    usleep(333333); // 333ms delay between requests (this is ~3 requests per second)
}