<?php
// vr_proxy.php

// Allow Storyline (or any browser) to access this endpoint
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Get the email parameter from query string
if (!isset($_GET['email'])) {
    http_response_code(400);
    echo "Missing email parameter.";
    exit;
}

$email = urlencode($_GET['email']);

// Build the target API URL
$targetUrl = "https://esamtac-training.org/webservices/api/vr_status/?email=" . $email;

// Initialize cURL
$ch = curl_init($targetUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Execute the request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Pass through the response code and body
http_response_code($httpCode);
echo $response;
