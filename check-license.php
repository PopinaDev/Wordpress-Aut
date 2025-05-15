<?php
header('Content-Type: application/json');

// Your valid license
$valid_licenses = [
    [
        'key' => 'PXLS-2025-AWPP-1234',
        'domain' => 'pixlistream.store',
        'expires' => '2026-05-15'
    ]
];

// Get POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate request
if (!isset($data['license']) || !isset($data['domain'])) {
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

$license = trim($data['license']);
$domain = trim($data['domain']);

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
    echo json_encode(['message' => 'License validated successfully']);
} else {
    echo json_encode(['error' => 'Invalid license or domain']);
}
