<?php
/**
 * @file Token.php
 * Contains the `Token` class.
 *
 * @version 1.0
 * @date    October 29, 2019 (3:04)
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
 * Implementation of Double Submit Cookie pattern as a prevention against Cross-
 * Site Request Forgeries (CSRF).
 */
class Token
{
	/**
	 * The default token name.
	 */
	const DEFAULT_NAME = 'Token';

	/**
	 * The token value.
	 */
	private $value = '';

	/**
	 * Constructor.
	 *
	 * @param string $value (optional) A token value. If not specified, then a
	 * random value is internally generated.
	 */
	public function __construct($value ='')
	{
		if ($value !== '')
			$this->value = $value;
		else
			$this->value = self::generate();
	}

	/**
	 * Gets the token value.
	 *
	 * @return The token value.
	 */
	public function GetValue()
	{
		return $this->value;
	}

	/**
	 * Creates a cookie value from the token value.
	 *
	 * @return The created cookie value.
	 * @todo Comment-in the strrev implementation after the new routing
	 * mechanism is introduced.
	 */
	public function GetCookieValue()
	{
		return /*strrev(*/base64_encode(Password::Hash($this->value))/*)*/;
	}

	/**
	 * Verifies that the token value matches a given cookie value.
	 *
	 * @return If the token value and cookie value match, the function returns
	 * `true`; otherwise, `false`.
	 * @todo Comment-in the strrev implementation after the new routing
	 * mechanism is introduced.
	 */
	public function MatchCookieValue($cookieValue)
	{
		return Password::Verify($this->value, base64_decode(/*strrev(*/$cookieValue/*)*/));
	}

	/**
	 * Generates a unique alpha-numeric string of 32 characters in length, e.g.
	 * '48a582f16d06f99d34ffe7c238c6c55b'.
	 *
	 * @return The generated token value.
	 * @remark The token conforms the regular expression pattern: `/^[a-z,0-9]{32}$/`
	 */
	private static function generate()
	{
		return md5(
			uniqid(
				mt_rand(), // prefix: integer between 0 and 2^31-1
				true       // more_entropy: results 23 characters
			)
		);
	}
}
?>