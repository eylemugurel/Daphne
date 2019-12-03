<?php
/**
 * @file Response.php
 * Contains the `Response` class.
 *
 * @version 1.4
 * @date    June 28, 2019 (19:22)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

namespace Core;

/**
 * Generates response in JSON format.
 */
class Response
{
	/**
	 * Sets `Content-Type` field of response header to `application/json`.
	 */
	private static function setContentType()
	{
		if (!headers_sent())
			header('Content-Type: application/json');
	}

	/**
	 * Generates a json string representing the success.
	 *
	 * @return A string of the form:
	 * @code
	 * {}
	 * @endcode
	 */
	public static function Success()
	{
		self::setContentType();

		return '{}';
	}

	/**
	 * Generates a json string representing an error.
	 *
	 * @param integer $code Error code.
	 * @return A string of the form:
	 * @code
	 * {"error":{"code":0,"message":""},"data":[]}
	 * @endcode
	 * @see `Error` class.
	 */
	public static function Error($code)
	{
		self::setContentType();

		// Construct an `Error` object to obtain the message.
		$error = new Error($code);

		return \json_encode(array(
			'error' => array(
				'code' => $error->getCode(),
				'message' => $error->getMessage()
			),
			// Fix: Specify a 'data' key with an empty array to prevent Datatables
			// js runtime error saying 'Uncaught TypeError: Cannot read property
			// 'length' of undefined'.
			'data' => array()
		));
	}

	/**
	 * Generates a json string containing data.
	 *
	 * @param $data Any value.
	 * @return A string of the form:
	 * @code
	 * {"data":*}
	 * @endcode
	 */
	public static function Data($data)
	{
		self::setContentType();

		return \json_encode(array(
			'data' => $data
		));
	}
}
?>
