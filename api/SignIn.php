<?php

// TODO: Change localhost to front end domain once done
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

require __DIR__ . '/HelperFunctions.php';

$inData = getRequestInfo();

$conn = new mysqli("localhost", "asher", "AmazingPassword2789", "COP4331_SLP19"); 	
if( $conn->connect_error )
{
	returnWithError( $conn->connect_error );
}
else
{
	$stmt = $conn->prepare("SELECT Email, Pass FROM Users WHERE Email =? AND Pass =?");
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

		$sessionToken = generateSessionToken();
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