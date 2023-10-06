<?php

require __DIR__ . '/HelperFunctions.php';

setCORS();

$credentials = getEnvDatabaseInfo();
$inData = getRequestInfo();

$id = 0;
$name = "";
$email = "";

$conn = new mysqli($credentials["DB_HOST"], $credentials["DB_USER"], $credentials["DB_PASSWORD"], $credentials["DB_NAME"]);
if ($conn->connect_error) {
    returnWithError($conn->connect_error);
} else {
    $emailCheckQuery = "SELECT * FROM Users WHERE Email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param("s", $inData["email"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists, display an error message
        $stmt->close();
        $conn->close();
        returnWithError("Email already exists in the database.");
    } else {
        // Email doesn't exist, proceed with the insertion
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO Users (FullName, Email, Pass) VALUES (?, ?, SHA2(?,512));");
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
}
?>
