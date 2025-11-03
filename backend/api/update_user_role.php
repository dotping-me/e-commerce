<?php
header("Content-Type: application/json; charset=utf-8");

// Catching payload
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Validation
if (!isset($data["email"]) || !isset($data["admin"])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}

$email = trim($data["email"]);
$admin = $data["admin"];

$filepath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/users.xml";
$xml = simplexml_load_file($filepath);

// Finds and updates user
$userFound = false;
foreach ($xml->user as $user) {
    if ((string)$user->email == $email) {
        $user->admin = $admin; // Updates role
        $userFound = true;
        
        break;
    }
}

if (!$userFound) {
    http_response_code(404);
    echo json_encode(["error" => "User with email " . $email . " not found"]);
    exit;
}

// Saves XML
if ($xml->asXML($filepath)) {
    http_response_code(200);
    echo json_encode(["message" => "User role updated successfully"]);
    exit();
}

http_response_code(500);
echo json_encode(["error" => "Failed to save user data"]);
?>