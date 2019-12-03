<?php
/**
 * @file AccountActivate.php
 * Contains the `AccountActivate` class.
 *
 * @version 1.3
 * @date    July 1, 2019 (05:37)
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
 * A model class derived from `Entity` which maps to the `accountactivate` table
 * in the database.
 *
 * The `accountactivate` table is used in registering a new user account. When
 * filling out the form for registering, the information is temporarily stored
 * in this table. After the registration is done, an email is sent to the
 * specified email address containing a link which needs to be opened in order
 * to activate the account. The link contains a randomly generated token which
 * is used to identify which record needs to be moved to the `account` table
 * from this table. Until this is done, the account cannot be used to log in.
 */
class AccountActivate extends Entity
{
	/**
	 * Email address that the user has entered while registering. An activation
	 * link is sent to this email after successful registration.
	 *
	 * The email must conform to the syntax described in
	 * <a href="https://www.ietf.org/rfc/rfc822.txt" target="_blank">RFC 822</a>,
	 * with the exception that dotless domain names are not supported. `Email`
	 * is a unique field across the `accountactivate` table.
	 */
	public $Email = '';

	/**
	 * Username that the user has entered while registering.
	 *
	 * The username can be at least 1 character long, can only contain characters
	 * from a-z, A-Z, 0-9, the `_` (underscore), and cannot contain any of the
	 * restricted words as provided by Core::Config::GetRestrictedUsernameWords().
	 * `Username` is a unique field across the `accountactivate` table.
	 */
	public $Username = '';

	/**
	 * Cryptographic (one-way) hash value of the actual password.
	 *
	 * The application does not store passwords in plain text. Instead, it
	 * stores an encrypted version of them. When a user logs in, the password
	 * provided is hashed and compared to this stored value.
	 */
	public $PasswordHash = '';

	/**
	 * Unique alpha-numeric string of 32 characters in length, e.g.
	 * '48a582f16d06f99d34ffe7c238c6c55b'.
	 *
	 * The activation link contains this token which is used to identify the
	 * record in the `accountactivate` table. Upon the link in user's inbox is
	 * opened, the account details are moved to the `account` table.
	 */
	public $Token = '';

	/**
	 * Time that identifies when the account activation link was last sent to
	 * the user.
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
	 * Inserts or updates an `accountactivate` record.
	 *
	 * @param string $email %Account's email address.
	 * @param string $username %Account's username.
	 * @param string $passwordHash Hash value of %Account's password.
	 * @param string $token %Account's activation token.
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 */
	public static function Upsert($email, $username, $passwordHash, $token)
	{
		$me = self::FindOne(self::prepareSql('Email=@1', $email));
		if ($me === null) {
			$me = new self();
			$me->Email = $email;
		} else
			$me->Time = new \Core\Time(); // update with the current time.
		$me->Username = $username;
		$me->PasswordHash = $passwordHash;
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
	 * Looks up the `accountactivate` table to retrieve username associated with
	 * a given token.
	 *
	 * @param string $token %Account activation token to retrieve username for.
	 * @return If the function succeeds, the return value is a string that
	 * specifies a username.
	 * @return If the function fails because the `accountactivation` table does
	 * not contain the given token, the return value is an empty string.
	 */
	public static function FindUsernameByToken($token)
	{
		$me = self::FindByToken($token);
		if ($me === null)
			return '';
		return $me->Username;
	}
}
?>
