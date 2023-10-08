<?php

	function setCORS() {
		header("Access-Control-Allow-Origin: *");

		header("Access-Control-Allow-Methods: *");

		header("Access-Control-Allow-Headers: *");

		header("Access-Control-Allow-Credentials: true");

		header("Access-Control-Max-Age: 3600");

		if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			http_response_code(204);
			exit();
		}
	}

	function getEnvDatabaseInfo() {
		require '../vendor/autoload.php';
		$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
		$dotenv->load();

		$credentials = array(
			"DB_HOST"		=> getenv("DB_HOST"),
			"DB_NAME"		=> getenv("DB_NAME"),
			"DB_USER"		=> getenv("DB_USER"),
			"DB_PASSWORD"	=> getenv("DB_PASSWORD")
		);

		return $credentials;
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