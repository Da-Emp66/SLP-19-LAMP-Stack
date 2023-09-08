<?php

	require __DIR__ . '/HelperFunctions.php';

	$inData = getRequestInfo();
	
	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331"); 	
	if( $conn->connect_error )
	{
		returnWithFirstnameLastnameError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("INSERT INTO Contacts (SourceUserID,ContactUsername,ContactUserFirstName,ContactUserLastName,ContactUserEmail,ContactUserPhone) VALUES (" . $inData["ID"] . "," . $inData["contactUsername"] . "," . $inData["contactUserFirstName"] . "," . $inData["contactUserLastName"] . "," . $inData["contactUserEmail"] . "," . $inData["contactUserPhone"]");");
		$stmt->bind_param("ss", $inData["username"], $inData["password"]);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		$conn->close();
	}
	
?>