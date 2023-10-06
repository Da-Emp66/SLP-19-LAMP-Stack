<?php

// TODO: Change localhost to front end domain once done
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

require __DIR__ . '/HelperFunctions.php';

$inData = getRequestInfo();

$id = 0;
$name = "";
$email = "";

$conn = new mysqli("localhost", "asher", "AmazingPassword2789", "COP4331_SLP19");
if ($conn->connect_error) {
    returnWithError($conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO Users (FullName, Email, Pass) VALUES (?, ?, SHA2(?, 512));");
    $stmt->bind_param("sss", $inData["name"], $inData["email"], $inData["password"]);
    $stmt->execute();

    // Check if registration was successful using new logic
    if ($stmt->affected_rows > 0) {
        // Registration successful
        $stmt->close();

        // Generate a session token
        $sessionToken = generateSessionToken($inData["email"]);

        // Send the session token as a response to the client
        echo $sessionToken;

        $conn->close();
        exit(); // Exit to prevent further execution of the script
    } else {
        // In case registration failed
        $stmt->close();
        $conn->close();

        returnWithError("Sign-up failed.");
    }
}
?>
