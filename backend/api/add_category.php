<?php

// Handler function for insertion in XML
header("Content-Type: application/json; charset=utf-8");

// Catching JSON payload
$json = file_get_contents("php://input");
$data = json_decode($json, true);

if (!isset($data["categoryName"]) || empty(trim($data["categoryName"]))) {
    http_response_code(400);
    echo json_encode(["error" => "Category name is required"]);
    exit;
}

$categoryName = trim($data["categoryName"]);

// Creates new category
$filepath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/products.xml";
$xml = simplexml_load_file($filepath);

// Avoid duplicates
foreach ($xml->children() as $category) {
    if ((string)$category["name"] === $categoryName) {
        http_response_code(400);
        echo json_encode(["error" => "Category already exists"]);
        exit;
    }
}

// Adds new category (No duplicates found)
$newCategory = $xml->addChild("category");
$newCategory->addAttribute("name", htmlspecialchars($categoryName));

// Save XML
if ($xml->asXML($filepath)) {
    http_response_code(200);
    echo json_encode(["message" => "Category created successfully"]);
    exit;
}

http_response_code(500);
echo json_encode(["error" => "Failed to create category"]);
?>