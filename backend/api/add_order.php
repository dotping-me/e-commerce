<?php

// Set headers for JSON response
header("Content-Type: application/json; charset=utf-8");
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Validate that order data exists
if (!isset($data["order"])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing order"]);
    exit;
}

$filepath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/orders.json";

// Load existing orders or initialize empty array
$ordersJson = file_get_contents($filepath);
$orders = json_decode($ordersJson, true);

// Generate unique order ID
$uniqueId = uniqid("order_", true);
$toSave = [
    "id" => $uniqueId,
    "email" => trim($data["email"]),
    "total" => (int)$data["total"],
    "order" => $data["order"],
];
    
$orders["all_orders"][] = $toSave; // Appends to JSON    
if (file_put_contents($filepath, json_encode($orders, JSON_PRETTY_PRINT))) {
    http_response_code(200);
    echo json_encode(["message" => "Order added successfully"]);
    exit();
}

http_response_code(500);
echo json_encode(["error" => "Failed to save order"]);
?>