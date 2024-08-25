<?php
header('Content-Type: application/json');

// Respond with an error if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'error' => 'Invalid request method'
    ]);
    exit;
}

// Get the Authorization header
$headers = getallheaders();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';
// Respond with an error if Authorization header is missing or invalid
if (strpos($authHeader, 'Bearer ') !== 0) {
    echo json_encode([
        'error' => 'Authorization header missing or invalid'
    ]);
    exit;
}

// Define your API token
$validToken = "api_token";
$token = substr($authHeader, 7);  // Extract the token part

// Check if the token is valid
if ($token !== $validToken) {
    // Respond with an error if the token is invalid
    echo json_encode([
        'error' => 'Invalid token'
    ]);
    exit;
}

// Sample data to simulate a database lookup (you would typically query your database)
$orders = [
    '12345' => 'Shipped',
    '67890' => 'In Transit',
    '54321' => 'Delivered',
    '09876' => 'Processing'
];

// Get the incoming request data
$input = json_decode(file_get_contents('php://input'), true);

// Check if label_id is provided
if ( !isset($input['label_id']) ) {
    // Respond with an error if label_id is missing ib the request body
    echo json_encode([
        'error' => 'Missing label_id'
    ]);
    exit;
}

// Check if the order exists in the sample data
if ( !isset($orders[$input['label_id']]) ) {
    // Respond with an error if the order does not exist
    echo json_encode([
        'error' => 'Order not found'
    ]);
    exit;
}

// Respond with the order status
echo json_encode([
    'error' => null,
    'data' => [
        'label_id' => $input['label_id'],
        'status' => $orders[$input['label_id']]
    ],
]);

    

