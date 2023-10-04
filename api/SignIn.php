<?php

	require __DIR__ . '/HelperFunctions.php';

	$inData = getRequestInfo();
	
	$id = 0;
	$name = "";
	$email = "";

	$conn = new mysqli("localhost", "asher", "AmazingPassword2789", "COP4331_SLP19"); 	
	if( $conn->connect_error )
	{
		returnWithFirstnameLastnameError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("SELECT ID,Email FROM Users WHERE Email =? AND Password =?");
		$stmt->bind_param("ss", $inData["email"], $inData["password"]);
		$stmt->execute();
		$result = $stmt->get_result();

		if( $row = $result->fetch_assoc()  )
		{
			returnWithInfo( $row['FullName'], $row['Email'], $row['ID'] );
		}
		else
		{
			returnWithFirstnameLastnameError("No Records Found");
		}

		$stmt->close();
		$conn->close();
	}
	
?>