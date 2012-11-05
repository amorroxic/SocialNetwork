<?php

class SocialException extends Exception
{

	const USER_NOT_FOUND 			= 1010;
	const USER_NOT_SPECIFIED 		= 1011;

	const ONLY_POST 				= 1020;
	const ONLY_AJAX 				= 1021;

	const API_FORMAT_NOT_SUPPORTED 	= 1030;

	const IMPORTER_CHECK_ERROR 		= 1040;
	const IMPORTER_DATASET_EMPTY 	= 1041;
	const IMPORTER_DATASET_ABSENT 	= 1042;

	const OK 						= 1000;
	const UNKNOWN_ERROR 			= 1050;

	private $messages;

	public function SocialException($code = 0, Exception $previous = null) {

		$this->messages = array(
			self::OK 						=> "Ok.",
			self::USER_NOT_FOUND 			=> "There is no such user.",
			self::USER_NOT_SPECIFIED 		=> "Please submit a valid user name.",
			self::ONLY_POST 				=> "Please submit data via POST.",
			self::ONLY_AJAX 				=> "Please submit data via an XML HTTP Request.",
			self::API_FORMAT_NOT_SUPPORTED	=> "The current version of the API does not support the requested format.",
			self::UNKNOWN_ERROR 			=> "Unknown error occured.",
			self::IMPORTER_CHECK_ERROR 		=> "Import: Source data is compromised.",
			self::IMPORTER_DATASET_EMPTY 	=> "Import: Source data is empty.",
			self::IMPORTER_DATASET_ABSENT 	=> "Import: Could not find a dataset file."
		);
		if (isset($this->messages[$code])) {
			parent::__construct($this->messages[$code], $code);
		} else {
			parent::__construct($this->messages[SocialException::UNKNOWN_ERROR], $code);
		}

	}

}
