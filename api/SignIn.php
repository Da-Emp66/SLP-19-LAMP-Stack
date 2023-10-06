<?php

require __DIR__ . '/HelperFunctions.php';

setCORS();

$inData = getRequestInfo();

$conn = new mysqli("localhost", "asher", "AmazingPassword2789", "COP4331_SLP19"); 	
if( $conn->connect_error )
{
	returnWithError( $conn->connect_error );
}
else
{
	$stmt = $conn->prepare("SELECT Email, Pass FROM Users WHERE Email =? AND Pass = SHA2(?,512)");
	$stmt->bind_param("ss", $inData["email"], $inData["password"]);
	$stmt->execute();
	$result = mysqli_fetch_array($stmt->get_result());

	$flag = ($result != NULL) ? array_key_exists("Email", $result) : false;

	// echo $flag ? "T" : "F";

	$found = false;
	if ($flag) {
		$found = ($result["Email"] === $inData["email"]) ? true : false;
	}

	if($found)
	{
		// Login Successful
		$stmt->close();
            
		// Update DateLastLoggedIn to the current date and time
		$updateQuery = "UPDATE Users SET DateLastLoggedIn = NOW() WHERE Email = ?";
		$updateStmt = $conn->prepare($updateQuery);
		$updateStmt->bind_param("s", $inData["email"]);
		$updateStmt->execute();
		$updateStmt->close();

		$sessionToken = generateSessionToken($result["Email"]);
		echo $sessionToken;
	}
	else
	{
		$stmt->close();
		$conn->close();
		returnWithError("No Records Found");
	}

}
	
?>