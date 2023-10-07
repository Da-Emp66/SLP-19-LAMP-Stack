<?php

	require __DIR__ . '/HelperFunctions.php';

	setCORS();

	$credentials = getEnvDatabaseInfo();
	$inData = isset($_GET["search"]) ? $_GET["search"] : '';
	
	$searchResults = array();
	$searchCount = 0;

	$conn = new mysqli($credentials["DB_HOST"], $credentials["DB_USER"], $credentials["DB_PASSWORD"], $credentials["DB_NAME"]);
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$searchInData = str_replace(" ", "|", $inData);
		$lastCharacter = strlen($searchInData) - 1;

		if ($searchInData[$lastCharacter] === '|')
		{
			$searchInData = substr($searchInData, 0, $lastCharacter);
		}

		$searchCriteria = "(" . $searchInData . ".*)";
		$stmt;
		$sourceEmail = isset($_SERVER["HTTP_SESSION_TOKEN"]) ? $_SERVER["HTTP_SESSION_TOKEN"] : '';

		$stmt = $conn->prepare("SELECT * FROM Contacts WHERE (ContactUsername RLIKE ? OR ContactFirstName RLIKE ? OR ContactLastName RLIKE ? OR ContactEmail RLIKE ? OR ContactPhone RLIKE ?) AND SourceUserEmail =?;");
		$stmt->bind_param("ssssss", $searchCriteria, $searchCriteria, $searchCriteria, $searchCriteria, $searchCriteria, $sourceEmail);
		$stmt->execute();
		
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

		if( $searchCount == 0 )
		{
			echo "[]";
		}
		else
		{
			echo json_encode($searchResults);
		}
		
		$stmt->close();
		$conn->close();
	}
	
?>