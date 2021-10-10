<?php 

namespace Aprobank\Libraries;

use Response;

########################################
#                Errors                # 
########################################
define('DEFAULT_ERROR', ApiReturn::ErrorMessage());

########################################
#               Success                # 
########################################
define('DEFAULT_SUCCESS', ApiReturn::SuccessMessage());



class ApiReturn{

	const DefaultError = DEFAULT_ERROR;

	const DefaultSuccess = DEFAULT_SUCCESS;
	

	public static function ErrorMessage($message = 'Ops, algo deu errado...', $code = 409, $status = false){
		return Response::json([
			'error' => [
				'status' => $status,
				'description' => $message
			]
		], $code);
	}

	public static function SuccessMessage($message = 'Success', $code = 200, $data = [], $status = true){
		$response = [
			'status' => $status,
			'description' => $message	
		];

		if(!empty($data))
			$response['data'] = $data;

		return  Response::json($response, $code);
	}
}