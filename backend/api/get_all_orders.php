<?php
$filepath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/orders.json";
$json = file_get_contents($filepath);

header("Content-Type: application/json; charset=utf-8");
echo $json;
?>