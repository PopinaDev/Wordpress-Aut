<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Function to handle the OpenRouter API call
function callOpenRouter($prompt, $model = 'meta-llama/llama-3-8b-instruct:free') {
    $api_url = 'https://openrouter.ai/api/v1/chat/completions';
    
    $data = array(
        'model' => $model,
        'messages' => array(
            array(
                'role' => 'user',
                'content' => $prompt
            )
        )
    );

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer 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',
        'HTTP-Referer: https://pixlistream.store',
        'X-Title: AutoWP Plugin'
    ));

    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        return array('error' => curl_error($ch));
    }
    
    curl_close($ch);
    
    $result = json_decode($response, true);
    
    // Return the response in the format the plugin expects
    if (isset($result['choices'][0]['message']['content'])) {
        return array(
            'result' => $result['choices'][0]['message']['content']
        );
    }
    
    return array(
        'error' => isset($result['error']) ? $result['error'] : 'Unknown error'
    );
}

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);

// License validation
$valid_license = array(
    'key' => 'PXLS-2025-AWPP-1234',
    'domain' => 'pixlistream.store'
);

$license = isset($input['license']) ? $input['license'] : '';
if ($license !== $valid_license['key']) {
    echo json_encode(array('error' => 'Invalid license key'));
    exit;
}

// Get prompt from request
$prompt = isset($input['prompt']) ? $input['prompt'] : '';
if (empty($prompt)) {
    echo json_encode(array('error' => 'No prompt provided'));
    exit;
}

// Call OpenRouter and return result
$result = callOpenRouter($prompt);
echo json_encode($result);
