<?php
	
	header("Access-Control-Allow-Origin: http://localhost:3000");
	header("Access-Control-Allow-Methods: GET, OPTIONS");
	header("Access-Control-Allow-Headers: Content-Type, Session-Token");

	require __DIR__ . '/HelperFunctions.php';

	$inData = isset($_GET["search"]) ? $_GET["search"] : '';
	
	$searchResults = array();
	$searchCount = 0;

	$conn = new mysqli("localhost", "asher", "AmazingPassword2789", "COP4331_SLP19");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$searchCriteria = "%" . $inData . "%";
		$stmt;
		$sourceEmail = isset($_SERVER["HTTP_SESSION_TOKEN"]) ? $_SERVER["HTTP_SESSION_TOKEN"] : '';

		if ($searchCriteria == "%%")
		{
			$stmt = $conn->prepare("SELECT * FROM Contacts WHERE SourceUserEmail =?;");
			$stmt->bind_param("s", $sourceEmail);
			$stmt->execute();
		}
		else
		{
			$stmt = $conn->prepare("SELECT * FROM Contacts WHERE (ContactUsername LIKE ? OR ContactFirstName LIKE ? OR ContactLastName LIKE ? OR ContactEmail LIKE ? OR ContactPhone LIKE ?) AND SourceUserEmail =?;");
			$stmt->bind_param("ssssss", $searchCriteria, $searchCriteria, $searchCriteria, $searchCriteria, $searchCriteria, $sourceEmail);
			$stmt->execute();
		}
		
		$result = $stmt->get_result();
		$searchCount = 0;
		while($row = $result->fetch_assoc())
		{
			$indData = array(
				"username"		=> $row["ContactUsername"],
				"firstName"		=> $row["ContactFirstName"],
				"lastName"		=> $row["ContactLastName"],
				"email"			=> $row["ContactEmail"],
				"phoneNumber"	=> $row["ContactPhone"]
			);

			$searchResults[$searchCount] = $indData;
			$searchCount++;

		}
		// echo(implode(" ", $searchResults[0]));
		// echo("\n");

		if( $searchCount == 0 )
		{
			returnWithError( "No Records Found" );
		}
		else
		{
			echo json_encode($searchResults);
		}
		
		$stmt->close();
		$conn->close();
	}
	
?>