<?php

// Handler function to delete a category and all its products from XML
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

// Load XML
$filepath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/products.xml";
$xml = simplexml_load_file($filepath);

// Deletes category
$categoryFound = false;

foreach ($xml->children() as $category) {
    if ((string)$category["name"] === $categoryName) {
        $categoryFound = true;
        
        // Deletes the category
        $dom = dom_import_simplexml($category);
        $dom->parentNode->removeChild($dom);
        break;
    }
}

if (!$categoryFound) {
    http_response_code(404);
    echo json_encode(["error" => "Category not found"]);
    exit;
}

// Saves XML
if ($xml->asXML($filepath)) {
    http_response_code(200);
    echo json_encode(["message" => "Category deleted successfully"]);
    exit;
}

http_response_code(500);
echo json_encode(["error" => "Failed to delete category"]);
?>