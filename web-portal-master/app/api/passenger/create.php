<?php
namespace TeamAlpha\Web;
// HTTP headers for response
header('Access-Control-Allow-Orgin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/passenger.php';
// Check if request method is correct
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Reply with error response
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(array('message' => 'Request method is not allowed.'));
    return;
}
// Extract request body
$data = json_decode(file_get_contents("php://input"));
if (is_null($data)) {
    // Request body is null
    // Reply with error response
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('message' => 'Passenger details are empty.'));
} else {
    // Request body is not null
    // TO DO: Actual insert
    $passenger = new Passenger();
    $passenger->id = rand();
    $passenger->firstname = $data->firstname;
    $passenger->lastname = $data->lastname;
    $passenger->email = $data->email;
    $passenger->password = $data->password;
    $passenger->address = $data->address;
    $passenger->mobile = $data->mobile;
    $response = $data;
    // Reply with successful response
    header('HTTP/1.1 201 Created');
    header('Location: /api/passenger/get.php?id=' . $passenger->id);
    echo json_encode(array('message' => 'Passenger record created.', 'passengerId' => $passenger->id));
}