<?php
/**
 * @file TokenGuard.php
 * Contains the `TokenGuard` class.
 *
 * @version 1.0
 * @date    October 27, 2019 (7:23)
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
 *
 */
class TokenGuard implements IGuard
{
	/** */
	private $tokenName = '';

	/**
	 *
	 */
	public function __construct($tokenName =Token::DEFAULT_NAME)
	{
		$this->tokenName = $tokenName;
	}

	/**
	 *
	 */
	public function Check()
	{
		$tokenValue = POSTParameter::Find($this->tokenName);
		if ($tokenValue === null)
			return false;
		$token = new Token($tokenValue);
		if (!Cookies::Has($this->tokenName))
			return false;
		return $token->MatchCookieValue(Cookies::Get($this->tokenName));
	}
}
?>