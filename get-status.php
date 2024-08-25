<?php 
function getOrderStatus($labelId) {

    define('PORT', 3000);
    $url = "http://localhost:3000/api.php";
    $token = "api_token";
    
    // Data to be sent in the POST request
    $data = [
        'label_id' => $labelId
    ];

    // Headers
    $headers = [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ];

    // cURL INIT
    $curl = curl_init();

    // CURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data), // Convert data to JSON
        CURLOPT_HTTPHEADER => $headers,
    ));
    
    // Execute cURL
    $response = curl_exec($curl);

    // Error handling
    if (curl_errno($curl)) {
        curl_close($curl);
        return "Error: " . curl_error($curl);
    }

    // Close cURL connection
    curl_close($curl);

    // Decode the JSON response
    $responseData = json_decode($response, true);

    // Return the status if exists, otherwise an error message
    if (isset($responseData['status'])) {
        return $responseData['data']['status'];
    } else {
        return "Error: No se pudo obtener el status del pedido.";
    }
}

$labelId = "12345";
$status = getOrderStatus($labelId);

echo "El status del pedido es: " . $status;
?>
