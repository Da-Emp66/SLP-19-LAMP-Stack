<?php

	header("Access-Control-Allow-Origin: http://localhost:3000");
	header("Access-Control-Allow-Headers: Content-Type, Session-Token");
	header("Access-Control-Allow-Methods: POST, OPTIONS");

	require __DIR__ . '/HelperFunctions.php';

	$inData = getRequestInfo();
	
	$conn = new mysqli("localhost", "asher", "AmazingPassword2789", "COP4331_SLP19"); 	
	if( $conn->connect_error )
	{
		returnWithFirstnameLastnameError( $conn->connect_error );
	}
	else
	{

		$userEmail = isset($_SERVER['HTTP_SESSION_TOKEN']) ? $_SERVER['HTTP_SESSION_TOKEN'] : '';
		// Check for preliminary contacts of those specifications
        $stmt = $conn->prepare("SELECT * FROM Contacts WHERE ContactUsername = ? AND ContactFirstName = ? AND ContactLastName = ? AND ContactEmail = ? AND ContactPhone = ? AND SourceUserEmail = ?;");
		$stmt->bind_param("ssssss", $inData["newUsername"], $inData["newFirstName"], $inData["newLastName"], $inData["newEmail"], $inData["newPhoneNumber"], $userEmail);
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
			$stmt->bind_param("sssssssssss", $inData["newUsername"], $inData["newFirstName"], $inData["newLastName"], $inData["newEmail"], $inData["newPhoneNumber"], $inData["username"], $inData["firstName"], $inData["lastName"], $inData["email"], $inData["phoneNumber"], $userEmail);
			$stmt->execute();
			$result = $stmt->get_result();

			$stmt->close();


			// Check for newly set contact of those specifications
			$stmt = $conn->prepare("SELECT * FROM Contacts WHERE ContactUsername = ? AND ContactFirstName = ? AND ContactLastName = ? AND ContactEmail = ? AND ContactPhone = ? AND SourceUserEmail = ?;");
			$stmt->bind_param("ssssss", $inData["newUsername"], $inData["newFirstName"], $inData["newLastName"], $inData["newEmail"], $inData["newPhoneNumber"], $userEmail);
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