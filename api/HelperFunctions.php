<?php

	function getRequestInfo() {
		$rawData = file_get_contents("php://input");
		
		if ($rawData === false) {
			die("Failed to read request data.");
		}
		
		$requestData = json_decode($rawData, true);
		
		if ($requestData === null) {
			die("Failed to decode JSON data.");
		}
		
		return $requestData;
	}


	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError($message) {
		$response = array("error" => $message);
		echo json_encode($response);
	}	

	function returnWithFirstnameLastnameError( $err )
	{
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
    
	function returnWithInfo( $firstName, $lastName, $id )
	{
		$retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
		sendResultInfoAsJson( $retValue );
	}

	// very basic session token generator
	function generateSessionToken($len=16)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		$token = '';
		$characterCount = strlen($characters);

		// Generate a random session token of the specified length
		for ($i = 0; $i < $len; $i++) {
			$token .= $characters[rand(0, $characterCount - 1)];
		}

		return $token;
	}

?>