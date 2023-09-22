<?php

	require __DIR__ . '/HelperFunctions.php';

	$inData = getRequestInfo();
	
	$id = 0;
	$firstName = "";
	$lastName = "";

	$conn = new mysqli("localhost", "asher", "AmazingPassword2789", "COP4331_SLP19"); 	
	if( $conn->connect_error )
	{
		returnWithFirstnameLastnameError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("SELECT ID,firstName,lastName FROM Users WHERE Username=? AND Password =?");
		$stmt->bind_param("ss", $inData["username"], $inData["password"]);
		$stmt->execute();
		$result = $stmt->get_result();

		if( $row = $result->fetch_assoc()  )
		{
			returnWithInfo( $row['firstName'], $row['lastName'], $row['ID'] );
		}
		else
		{
			returnWithFirstnameLastnameError("No Records Found");
		}

		$stmt->close();
		$conn->close();
	}
	
?>