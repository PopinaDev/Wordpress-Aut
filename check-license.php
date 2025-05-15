<?php
header('Content-Type: application/json');

// Get parameters
$license = isset($_GET['license']) ? trim($_GET['license']) : '';
$domain = isset($_GET['domain']) ? trim($_GET['domain']) : '';

// Valid license configuration
$valid_licenses = [
    [
        'key' => 'PXLS-2025-AWPP-1234',
        'domain' => 'pixlistream.store',
        'expires' => '2026-05-15'
    ]
];

// Check license
$is_valid = false;
foreach ($valid_licenses as $valid_license) {
    if ($valid_license['key'] === $license && 
        $valid_license['domain'] === $domain) {
        $is_valid = true;
        break;
    }
}

if ($is_valid) {
    echo json_encode([
        'message' => 'License validated successfully'
    ]);
} else {
    echo json_encode([
        'error' => 'Invalid license or domain'
    ]);
}
