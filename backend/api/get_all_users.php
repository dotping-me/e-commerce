<?php
$filepath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/users.xml";
$xml = simplexml_load_file($filepath);

foreach ($xml->user as $user) {
    unset($user->password); // Excludes password
}

header("Content-Type: application/xml; charset=utf-8");
echo $xml->asXML();
?>