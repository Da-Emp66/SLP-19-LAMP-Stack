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
		$stmt = $conn->prepare("DELETE FROM Contacts WHERE SourceUserID = " . $inData["ID"] . " AND ContactUsername = " . $inData["contactUsername"] . " AND ContactUserFirstName = " . $inData["contactUserFirstName"] . " AND ContactUserLastName = " . $inData["contactUserLastName"] . " AND ContactUserEmail = " . $inData["contactUserEmail"] . " AND ContactUserPhone = " . $inData["contactUserPhone"] . ";");
		$stmt->bind_param("ss", $inData["username"], $inData["password"]);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		$conn->close();
	}
	
?>