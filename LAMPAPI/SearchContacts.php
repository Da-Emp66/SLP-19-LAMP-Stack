<?php
	
	require __DIR__ . '/HelperFunctions.php';

	$inData = getRequestInfo();
	
	$searchResults = "";
	$searchCount = 0;

	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$stmt = $conn->prepare("SELECT ContactUsername FROM CONTACTS WHERE (ContactUsername LIKE ? OR ContactUserFirstName LIKE ? OR ContactUserLastName LIKE ? OR ContactUserEmail LIKE ? OR ContactUserPhone LIKE ?) AND UserID = ?;");
		$searchCriteria = "%" . $inData["search"] . "%";
		$stmt->bind_param("ss", $searchCriteria, $searchCriteria, $searchCriteria, $searchCriteria, $searchCriteria, $inData["ID"]);
		$stmt->execute();
		
		$result = $stmt->get_result();
		
		while($row = $result->fetch_assoc())
		{
			if( $searchCount > 0 )
			{
				$searchResults .= ";";
			}
			$searchCount++;
			$searchResults .= '"' . $row["ContactUsername"] . '"';
		}
		
		if( $searchCount == 0 )
		{
			returnWithError( "No Records Found" );
		}
		else
		{
			returnWithInfo( $searchResults );
		}
		
		$stmt->close();
		$conn->close();
	}
	
?>