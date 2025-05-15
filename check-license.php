<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Get parameters from either GET or POST
$license = isset($_REQUEST['license']) ? trim($_REQUEST['license']) : '';
$domain = isset($_REQUEST['domain']) ? trim($_REQUEST['domain']) : '';

// Valid license configuration
$valid_licenses = array(
    array(
        'key' => 'PXLS-2025-AWPP-1234',
        'domain' => 'pixlistream.store',
        'expires' => '2026-05-15'
    )
);

// Check license
$is_valid = false;
foreach ($valid_licenses as $license_data) {
    if ($license_data['key'] === $license) {
        $is_valid = true;
        break;
    }
}

if ($is_valid) {
    echo json_encode(array(
        'message' => 'License validated successfully'
    ));
} else {
    echo json_encode(array(
        'error' => 'Invalid license'
    ));
}
