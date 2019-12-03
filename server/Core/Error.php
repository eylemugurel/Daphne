<?php
/**
 * @file Error.php
 * Contains the `Error` class.
 *
 * @version 1.1
 * @date    February 19, 2019 (21:11)
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
 * A throwable class that is derived from PHP's <a href="https://www.php.net/manual/en/class.exception.php" target="_blank">Exception</a> class.
 * The following codes are valid:
 * Code | Meaning
 * ---: | -------
 * -1   | Unexpected error
 * -2   | Access denied
 * -3   | Not implemented yet
 * -4   | Data could not be loaded
 * -5   | Data could not be saved
 * -6   | Data could not be deleted
 * -7   | Invalid username
 * -8   | Username already exists
 * -9   | Username not found
 * -10  | Invalid email
 * -11  | Email already exists
 * -12  | Email not found
 * -13  | Email could not be sent
 * -14  | Invalid password length
 * -15  | Incorrect password
 * -16  | Invalid input
 */
class Error extends \Exception
{
	/** An unexpected error has occurred. */
	const UNEXPECTED                = -1;
	/** Access is denied to a requested resource. */
	const ACCESS_DENIED             = -2;
	/** A specified action name was not valid. */
	const INVALID_ACTION_NAME       = -3;
	/** Some data could not be loaded. */
	const DATA_COULD_NOT_BE_LOADED  = -4;
	/** Some data could not be saved. */
	const DATA_COULD_NOT_BE_SAVED   = -5;
	/** Some data could not be deleted. */
	const DATA_COULD_NOT_BE_DELETED = -6;
	/** A specified username does not have a valid syntax. */
	const INVALID_USERNAME          = -7;
	/** A specified username is already registered with the system. */
	const USERNAME_ALREADY_EXISTS   = -8;
	/** A specified username was not found in the system. */
	const USERNAME_NOT_FOUND        = -9;
	/** A specified email address does not have a valid syntax. */
	const INVALID_EMAIL             = -10;
	/** A specified email address is already registered with the system. */
	const EMAIL_ALREADY_EXISTS      = -11;
	/** A specified email address was not found in the system. */
	const EMAIL_NOT_FOUND           = -12;
	/** An email could not be sent to recipient(s) because of a mail server failure. */
	const EMAIL_COULD_NOT_BE_SENT   = -13;
	/** A specified password does not have a length within the valid range. */
	const INVALID_PASSWORD_LENGTH   = -14;
	/** A specified password does not match the registered password. */
	const INCORRECT_PASSWORD        = -15;
	/** A specified user input was not valid. */
	const INVALID_INPUT             = -16;

	/**
	 * Returns a new `%Error` object containing the given code and a message
	 * based on that error code, translated to the current language.
	 *
	 * @param integer $code An error code.
	 * @remark If the parameter $code is not among the valid codes, then the
	 * returned object will contain a message (in the current language) telling
	 * that the error was unknown.
	 */
	public function __construct($code)
	{
		$message = '';
		switch ($code)
		{
		case self::UNEXPECTED:
			$message = i18n::Get('ERROR_UNEXPECTED');
			break;
		case self::ACCESS_DENIED:
			$message = i18n::Get('ERROR_ACCESS_DENIED');
			break;
		case self::INVALID_ACTION_NAME:
			$message = i18n::Get('ERROR_INVALID_ACTION_NAME');
			break;
		case self::DATA_COULD_NOT_BE_LOADED:
			$message = i18n::Get('ERROR_DATA_COULD_NOT_BE_LOADED');
			break;
		case self::DATA_COULD_NOT_BE_SAVED:
			$message = i18n::Get('ERROR_DATA_COULD_NOT_BE_SAVED');
			break;
		case self::DATA_COULD_NOT_BE_DELETED:
			$message = i18n::Get('ERROR_DATA_COULD_NOT_BE_DELETED');
			break;
		case self::INVALID_USERNAME:
			$message = i18n::Get('ERROR_INVALID_USERNAME');
			break;
		case self::USERNAME_ALREADY_EXISTS:
			$message = i18n::Get('ERROR_USERNAME_ALREADY_EXISTS');
			break;
		case self::USERNAME_NOT_FOUND:
			$message = i18n::Get('ERROR_USERNAME_NOT_FOUND');
			break;
		case self::INVALID_EMAIL:
			$message = i18n::Get('ERROR_INVALID_EMAIL');
			break;
		case self::EMAIL_ALREADY_EXISTS:
			$message = i18n::Get('ERROR_EMAIL_ALREADY_EXISTS');
			break;
		case self::EMAIL_NOT_FOUND:
			$message = i18n::Get('ERROR_EMAIL_NOT_FOUND');
			break;
		case self::EMAIL_COULD_NOT_BE_SENT:
			$message = i18n::Get('ERROR_EMAIL_COULD_NOT_BE_SENT');
			break;
		case self::INVALID_PASSWORD_LENGTH:
			$message = i18n::Get('ERROR_INVALID_PASSWORD_LENGTH');
			break;
		case self::INCORRECT_PASSWORD:
			$message = i18n::Get('ERROR_INCORRECT_PASSWORD');
			break;
		case self::INVALID_INPUT:
			$message = i18n::Get('ERROR_INVALID_INPUT');
			break;
		default:
			$message = i18n::Get('ERROR_UNKNOWN_d', $code);
		}
		parent::__construct($message, $code);
	}
}
?>
