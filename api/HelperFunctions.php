<?php

	function CORS_setup() {
		header("Access-Control-Allow-Origin: *");

		// Allow all HTTP methods (GET, POST, PUT, DELETE, etc.)
		header("Access-Control-Allow-Methods: *");

		// Allow all headers (you can specify specific headers if needed)
		header("Access-Control-Allow-Headers: *");

		// Allow credentials (cookies) to be sent in the request (not recommended for all scenarios)
		header("Access-Control-Allow-Credentials: true");

		// Set the max age for preflight requests (in seconds)
		header("Access-Control-Max-Age: 3600");

		// Respond to preflight requests
		if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			http_response_code(204);
			exit();
		}
	}

	function getRequestInfo() {
		$rawData = file_get_contents("php://input");
		
		if ($rawData === false) {
			die("Failed to read request data.");
		}
		
		$requestData = json_decode($rawData, true);
		
		if ($requestData === null) {
			die("Failed to decode JSON data." . json_last_error_msg());
		}
		
		return $requestData;
	}


	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError($message) {
		http_response_code(404);
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

	function generateSessionToken($email)
	{
		$retValue = array("sessionToken"=>$email);

		return json_encode($retValue);
	}

?>