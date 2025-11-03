<?php
    header("Content-Type: application/json");
    
    $xmlFile = __DIR__ . "/../data/users.xml";
    
    if ( $_SERVER["REQUEST_METHOD"] === "POST" ) {
        $email    = trim($_POST["email"]);
        $password = trim($_POST["password"]);
    
        if ( !file_exists($xmlFile) ) {
            echo json_encode(["success" => false, "message" => "No users found."]);
            exit;
        }
    
        $xml = simplexml_load_file($xmlFile);
    
        foreach ( $xml->user as $user ) {
            if ( (string)$user->email === $email && password_verify($password, (string)$user->password) ) {
                session_start();
                $_SESSION["user"] = [
                    "firstName" => (string)$user->firstName,
                    "lastName" => (string)$user->lastName,
                    "email"     => $email,
                    "phone" => (string)$user->phone,

                    // To recognize an admin
                    "isAdmin"   => ((string)$user->admin === "1")
                ];

                // Check if admin
                if ($_SESSION["user"]["isAdmin"]) {
                    echo json_encode([
                        "success" => true,
                        "message" => "Admin logged in successfully!",
                        "isAdmin" => true
                    ]);

                } else {
                    echo json_encode([
                        "success" => true,
                        "message" => "Logged in successfully!",
                        "isAdmin" => false
                    ]);
                }
                exit;
            }
        }
        echo json_encode(["success" => false, "message" => "Invalid Credentials."]);
        exit;
    }
    
?>