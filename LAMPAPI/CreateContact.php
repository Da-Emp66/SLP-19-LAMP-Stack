<?php

	require __DIR__ . '/HelperFunctions.php';

	$inData = getRequestInfo();
	
	$conn = new mysqli("localhost", "asher", "AmazingPassword2789", "COP4331_SLP19"); 	
	if( $conn->connect_error )
	{
		returnWithFirstnameLastnameError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("INSERT INTO Contacts (SourceUserID,ContactUsername,ContactUserFirstName,ContactUserLastName,ContactUserEmail,ContactUserPhone) VALUES (?,?,?,?,?,?);");
		$stmt->bind_param("ss", $inData["ID"], $inData["contactUsername"], $inData["contactUserFirstName"], $inData["contactUserLastName"], $inData["contactUserEmail"], $inData["contactUserPhone"]);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		$conn->close();
	}
	
?>