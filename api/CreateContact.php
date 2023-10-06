<?php

	require __DIR__ . '/HelperFunctions.php';

	setCORS();

	$credentials = getEnvDatabaseInfo();
	$inData = getRequestInfo();
	
	$conn = new mysqli($credentials["DB_HOST"], $credentials["DB_USER"], $credentials["DB_PASSWORD"], $credentials["DB_NAME"]); 	
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