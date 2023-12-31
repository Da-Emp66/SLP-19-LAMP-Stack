<?php

	require __DIR__ . '/HelperFunctions.php';

	setCORS();

	$credentials = getEnvDatabaseInfo();
	$inData = getRequestInfo();
	
	$conn = new mysqli($credentials["DB_HOST"], $credentials["DB_USER"], $credentials["DB_PASSWORD"], $credentials["DB_NAME"]);
	if( $conn->connect_error )
	{
		returnWithFirstnameLastnameError( $conn->connect_error );
	}
	else
	{
		$originalContact = $inData["original"];
		$updatedContact = $inData["new"];

		$userEmail = isset($_SERVER['HTTP_SESSION_TOKEN']) ? $_SERVER['HTTP_SESSION_TOKEN'] : '';
		// Check for preliminary contacts of those specifications
        $stmt = $conn->prepare("SELECT * FROM Contacts WHERE ContactUsername = ? AND ContactFirstName = ? AND ContactLastName = ? AND ContactEmail = ? AND ContactPhone = ? AND SourceUserEmail = ?;");
		$stmt->bind_param("ssssss", $updatedContact["username"], $updatedContact["firstName"], $updatedContact["lastName"], $updatedContact["email"], $updatedContact["phoneNumber"], $userEmail);
		$stmt->execute();
		$result = $stmt->get_result();

		$count = 0;
		while ($row = $result->fetch_assoc())
		{
			$count++;
		}
		
		if ($count > 0)
		{
			returnWithError("A contact with those specifications already exists in your contacts list!");
			$stmt->close();
		}
		else
		{
			$stmt->close();

			$stmt = $conn->prepare("UPDATE Contacts SET ContactUsername = ?, ContactFirstName = ?, ContactLastName = ?, ContactEmail = ?, ContactPhone = ? WHERE ContactUsername = ? AND ContactFirstName = ? AND ContactLastName = ? AND ContactEmail = ? AND ContactPhone = ? AND SourceUserEmail = ?;");
			$stmt->bind_param("sssssssssss", $updatedContact["username"], $updatedContact["firstName"], $updatedContact["lastName"], $updatedContact["email"], $updatedContact["phoneNumber"], $originalContact["username"], $originalContact["firstName"], $originalContact["lastName"], $originalContact["email"], $originalContact["phoneNumber"], $userEmail);
			$stmt->execute();
			$result = $stmt->get_result();

			$stmt->close();


			// Check for newly set contact of those specifications
			$stmt = $conn->prepare("SELECT * FROM Contacts WHERE ContactUsername = ? AND ContactFirstName = ? AND ContactLastName = ? AND ContactEmail = ? AND ContactPhone = ? AND SourceUserEmail = ?;");
			$stmt->bind_param("ssssss", $updatedContact["username"], $updatedContact["firstName"], $updatedContact["lastName"], $updatedContact["email"], $updatedContact["phoneNumber"], $userEmail);
			$stmt->execute();
			$result = $stmt->get_result();

			$count = 0;
			while ($row = $result->fetch_assoc())
			{
				$count++;
			}
			
			if ($count < 1)
			{
				returnWithError("Failed to update contact!");
			}
			else
			{
				echo json_encode(array("success"=>1));
			}


			$stmt->close();
			$conn->close();

		}
	}
	
?>