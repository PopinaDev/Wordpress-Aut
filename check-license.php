<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Get parameters
$license = isset($_GET['license']) ? trim($_GET['license']) : '';
$domain = isset($_GET['domain']) ? trim($_GET['domain']) : '';

// Log request for debugging
error_log("License check request - License: $license, Domain: $domain");

// Hardcoded valid license
$valid_license = array(
    'key' => 'PXLS-2025-AWPP-1234',
    'domain' => 'pixlistream.store'
);

// Simple validation
if ($license === $valid_license['key']) {
    echo json_encode(array(
        'message' => 'License validated successfully'
    ));
} else {
    echo json_encode(array(
        'error' => 'Invalid license key'
    ));
}
