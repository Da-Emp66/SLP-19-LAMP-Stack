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
		$userEmail = isset($_SERVER['HTTP_SESSION_TOKEN']) ? $_SERVER['HTTP_SESSION_TOKEN'] : '';
		$stmt = $conn->prepare("INSERT INTO Contacts (ContactUsername,ContactFirstName,ContactLastName,ContactEmail,ContactPhone,SourceUserEmail) VALUES (?,?,?,?,?,?);");
        $stmt->bind_param("ssssss", $inData["username"], $inData["firstName"], $inData["lastName"], $inData["email"], $inData["phoneNumber"], $userEmail);
		$stmt->execute();

		if ($stmt->affected_rows > 0) {
			$stmt->close();

			$successToken = 1;
			echo $successToken;

			$conn->close();
			exit();
		} else {
			$stmt->close();
			$conn->close();

			returnWithError("Add Contact Failed.");
		}

		$result = $stmt->get_result();
		$stmt->close();
		$conn->close();
	}
	
?>