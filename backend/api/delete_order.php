<?php
header("Content-Type: application/json; charset=utf-8");

$data = json_decode(file_get_contents("php://input"), true);
$orderId = $data["id"];

if (empty($orderId)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing order ID"]);
    exit;
}

$filepath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/orders.json";
$allOrders = json_decode(file_get_contents($filepath), true);

// Deletes order
foreach ($allOrders["all_orders"] as $key => $order) {
    if ($order["id"] === $orderId) {
        unset($allOrders["all_orders"][$key]);
        if (file_put_contents($filepath, json_encode($allOrders, JSON_PRETTY_PRINT))) {
            http_response_code(200);
            echo json_encode(["message" => "Order deleted successfully"]);
            exit();

        } else {
            http_response_code(500);
            echo json_encode(["error" => "Failed to save changes"]);
            exit();
        }
    }
}

http_response_code(404);
echo json_encode(["error" => "Order not found"]);
?>