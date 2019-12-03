<?php
/**
 * @file PasswordReset.php
 * Contains the `PasswordReset` class.
 *
 * @version 1.4
 * @date    July 1, 2019 (05:48)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

namespace Model;

/**
 * A model class derived from `Entity` which maps to the `passwordreset` table
 * in the database.
 *
 * The `passwordreset` table is used by the self-service password reset operation.
 * If a user has forgotten their password and wants to reset it, then the user
 * is prompted to enter their email address and is sent a link in which they
 * will need to open in order to reset their password. Once the link is opened,
 * the user is prompted to enter a new password.
 */
class PasswordReset extends Entity
{
	/**
	 * Equals to the `ID` field of the `account` record of which the password is
	 * to be reset. `AccountID` is a unique field across the `passwordreset`
	 * table.
	 */
	public $AccountID = 0;
	/**
	 * Unique alpha-numeric string of 32 characters in length, e.g.
	 * '48a582f16d06f99d34ffe7c238c6c55b'.
	 *
	 * The password reset link contains this token which is used to identify the
	 * record in the `passwordreset` table.
	 */
	public $Token = '';
	/**
	 * Time that identifies when the password reset link was last sent to the
	 * user.
	 */
	public $Time = null;

	/**
	 * Default constructor which initializes the #$Time member with the current
	 * time.
	 */
	public function __construct()
	{
		$this->Time = new \Core\Time();
	}

	/**
	 * Inserts or updates a `passwordreset` record.
	 *
	 * @param string $accountID %Account's identifier.
	 * @param string $token Password reset token.
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 */
	public static function Upsert($accountID, $token)
	{
		$me = self::FindOne(self::prepareSql('AccountID=@1', $accountID));
		if ($me === null) {
			$me = new self();
			$me->AccountID = $accountID;
		} else
			$me->Time = new \Core\Time(); // update with the current time.
		$me->Token = $token;
		return $me->Save();
	}

	/**
	 *
	 */
	public static function FindByToken($token)
	{
		return self::FindOne(self::prepareSql('Token=@1', $token));
	}

	/**
	 * Looks up the `passwordreset` table, then the `account` table to retrieve
	 * username associated with a given token.
	 *
	 * @param string $token %Account's password reset token to retrieve username
	 * for.
	 * @return If the function succeeds, the return value is a string that
	 * specifies a username.
	 * @return If the function fails because the `passwordreset` table does
	 * not contain the given token, or the `account` table does not contain the
	 * account identifier, the return value is an empty string.
	 */
	public static function FindUsernameByToken($token)
	{
		$me = self::FindByToken($token);
		if ($me === null)
			return '';
		return Account::FindUsernameById($me->AccountID);
	}
}
?>
