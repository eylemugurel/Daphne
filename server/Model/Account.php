<?php
/**
 * @file Account.php
 * Contains the `Account` class.
 *
 * @version 4.6
 * @date    November 22, 2019 (19:41)
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
 * A model class derived from `Entity` which maps to the `account` table in the
 * database.
 */
class Account extends Entity
{
	/**
	 * String that represents the logged-in account object in the session file.
	 */
	const SESSION_KEY = 'Daphne_Account';

	/**
	 * Email address that is used for account activation and password reset
	 * operations.
	 *
	 * The email must conform to the syntax described in
	 * <a href="https://www.ietf.org/rfc/rfc822.txt" target="_blank">RFC 822</a>,
	 * with the exception that dotless domain names are not supported. `Email`
	 * is a unique field across the `account` table.
	 */
	public $Email = '';

	/**
	 * Identifies an account with access to the application.
	 *
	 * The username can be at least 1 character long, can only contain characters
	 * from a-z, A-Z, 0-9, the `_` (underscore), and cannot contain any of the
	 * restricted words as provided by Core::Config::GetRestrictedUsernameWords().
	 * `Username` is a unique field across the `account` table.
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
	 * Time that identifies when the account was activated.
	 */
	public $TimeCreated = null;

	/**
	 * Time that identifies when the account was last logged in.
	 */
	public $TimeLastLogIn = null;

	/**
	 * Default constructor which initializes members #$TimeCreated and
	 * #$TimeLastLogIn with the current time.
	 */
	public function __construct()
	{
		$this->TimeCreated = new \Core\Time();
		$this->TimeLastLogIn = new \Core\Time();
	}

	/**
	 * Looks up the `account` table to retrieve username associated with a given
	 * account identifier.
	 *
	 * @param integer $id %Account identifier to retrieve username for.
	 * @return If the method succeeds, the return value is a string that
	 * specifies a username.
	 * @return If the method fails because the `account` table does not
	 * contain the given identifier, the return value is an empty string.
	 */
	public static function FindUsernameById($id)
	{
		$me = self::FindById($id);
		if ($me === null)
			return '';
		return $me->Username;
	}

	/**
	 * Determines whether the current user's account is authenticated.
	 *
	 * @return If the account has been authenticated, the return value is
	 * `true`; otherwise it's `false`.
	 */
	public static function IsLoggedIn()
	{
		if (!\Core\Session::Activate())
			return false;

		if (!\Core\Session::Has(self::SESSION_KEY)) {
			\Core\Session::Destroy();
			// Fix: Remove redundant 'Set-Cookie' headers created by `session_start`
			// and `session_destroy` (e.g. `PHPSESSID`). Since these headers are
			// not sent to the browser yet, all can be deleted safely.
			if (!headers_sent()) {
				// 1. Collect all 'Set-Cookie' headers stripping the
				// 'Set-Cookie:' part.
				$cookies = array();
				foreach (headers_list() as $header)
					if (stripos($header, 'Set-Cookie:') === 0)
						array_push($cookies, ltrim(substr($header, 11)));
				// 2. Delete all 'Set-Cookie' headers.
				header_remove('Set-Cookie');
				// 3. Put back headers where cookie name differs from the
				// session name.
				$sessionName = session_name();
				foreach ($cookies as $cookie)
					if ($sessionName !== strtok($cookie, '='))
						header('Set-Cookie: ' . $cookie, false);
			}
			return false;
		}

		// Fix: Add extra security by checking whether the user really exists in
		// the database. This must be done because the user may be deleted from
		// the database but can still exist in the session file.
		$a1 = \Core\Session::GetObject(self::SESSION_KEY);
		$a2 = self::FindById($a1->ID);
		if ($a2 === null
		 || $a2->Email !== $a1->Email
		 || $a2->Username !== $a1->Username
		 || $a2->PasswordHash !== $a1->PasswordHash)
		{
			\Core\Session::Remove(self::SESSION_KEY);
			\Core\Session::Destroy();
			return false;
		}

		return true;
	}

	/**
	 * Retrieves the Account object of the currently authenticated user.
	 *
	 * @return If the account has been authenticated, the return value is an
	 * Account object; otherwise it's `null`.
	 */
	public static function GetLoggedIn()
	{
		if (!self::IsLoggedIn())
			return null;
		return \Core\Session::GetObject(self::SESSION_KEY);
	}

	/**
	 * Authenticates and logs in a user with supplied credentials.
	 *
	 * @param string $username %Account's username.
	 * @param string $password %Account's password.
	 * @return If the method succeeds, the return value is Core::Response::Success.
	 * @return If the method fails, the return value is a Core::Response::Error
	 * which can contain one of the following error codes:
	 * Code | Meaning
	 * ---: | -------
	 * -1   | Unexpected error
	 * -5   | Data could not be saved
	 * -7   | Invalid username
	 * -9   | Username not found
	 * -14  | Invalid password length
	 * -15  | Incorrect password
	 */
	public static function Action_LogIn($username, $password)
	{
		// 1. Check if username is in valid format.
		if (!self::validateUsernameSyntax($username))
			return \Core\Response::Error(\Core\Error::INVALID_USERNAME);
		// 2. Check if password length is in valid range; prevents DoS attacks.
		if (!self::validatePasswordLength($password))
			return \Core\Response::Error(\Core\Error::INVALID_PASSWORD_LENGTH);
		// 3. Check if username exists.
		$me = self::FindOne(self::prepareSql('Username=@1', $username));
		if ($me === null)
			return \Core\Response::Error(\Core\Error::USERNAME_NOT_FOUND);
		// 4. Check if password is correct.
		if (!\Core\Password::Verify($password, $me->PasswordHash))
			return \Core\Response::Error(\Core\Error::INCORRECT_PASSWORD);

		if (!\Core\Database::GetInstance()->BeginTransaction())
			return \Core\Response::Error(\Core\Error::UNEXPECTED);
		try
		{
			// 5. Keep track of the log in time.
			$me->TimeLastLogIn = new \Core\Time();
			if (!$me->Save())
				throw new \Core\Error(\Core\Error::DATA_COULD_NOT_BE_SAVED);
			// 6. Save Account object in the session.
			if (!\Core\Session::Activate())
				throw new \Core\Error(\Core\Error::UNEXPECTED);
			\Core\Session::SetObject(self::SESSION_KEY, $me);
		}
		catch (\Core\Error $error)
		{
			if (!\Core\Database::GetInstance()->Rollback())
				return \Core\Response::Error(\Core\Error::UNEXPECTED);
			return \Core\Response::Error($error->getCode());
		}
		if (!\Core\Database::GetInstance()->Commit())
			return \Core\Response::Error(\Core\Error::UNEXPECTED);

		return \Core\Response::Success();
	}

	/**
	 * Terminates a login session.
	 *
	 * Invoking `Action_LogOut` will remove the account information from the
	 * session file and deletes the session file.
	 *
	 * @return If the method succeeds, the return value is Core::Response::Success.
	 * @return If the method fails, the return value is a Core::Response::Error
	 * which can contain one of the following error codes:
	 * Code | Meaning
	 * ---: | -------
	 * -1   | Unexpected error
	 */
	public static function Action_LogOut()
	{
		if (!\Core\Session::Activate())
			return \Core\Response::Error(\Core\Error::UNEXPECTED);
		\Core\Session::Remove(self::SESSION_KEY);
		\Core\Session::Destroy();
		return \Core\Response::Success();
	}

	/**
	 * Inserts a new AccountActivate record to the `accountactivate` table, and
	 * sends an activation link to the user's email address.
	 *
	 * @param string $email %Account's email address.
	 * @param string $username %Account's username.
	 * @param string $password %Account's password.
	 * @return If the method succeeds, the return value is Core::Response::Data
	 * containing a message string.
	 * @return If the method fails, the return value is a Core::Response::Error
	 * which can contain one of the following error codes:
	 * Code | Meaning
	 * ---: | -------
	 * -1   | Unexpected error
	 * -5   | Data could not be saved
	 * -7   | Invalid username
	 * -8   | Username already exists
	 * -10  | Invalid email
	 * -14  | Invalid password length
	 * -11  | Email already exists
	 * -13  | Email could not be sent
	 */
	public static function Action_Register($email, $username, $password)
	{
		// 1. Check if email is in valid format.
		if (!self::validateEmailAddressSyntax($email))
			return \Core\Response::Error(\Core\Error::INVALID_EMAIL);
		// 2. Check if username is in valid format.
		if (!self::validateUsernameSyntax($username))
			return \Core\Response::Error(\Core\Error::INVALID_USERNAME);
		// 3. Check if password length is in valid range; prevents DoS attacks.
		if (!self::validatePasswordLength($password))
			return \Core\Response::Error(\Core\Error::INVALID_PASSWORD_LENGTH);
		// 4. Check if email is not taken.
		if (null !== self::FindOne(self::prepareSql('Email=@1', $email)))
			return \Core\Response::Error(\Core\Error::EMAIL_ALREADY_EXISTS);
		// 5. Check if username is not taken.
		if (null !== self::FindOne(self::prepareSql('Username=@1', $username)))
			return \Core\Response::Error(\Core\Error::USERNAME_ALREADY_EXISTS);

		if (!\Core\Database::GetInstance()->BeginTransaction())
			return \Core\Response::Error(\Core\Error::UNEXPECTED);
		try
		{
			// 6. Generate activation token and save the `AccountActivate` record.
			$token = new \Core\Token;
			if (!AccountActivate::Upsert($email,
			                             $username,
			                             \Core\Password::Hash($password),
			                             $token->GetValue()))
				throw new \Core\Error(\Core\Error::DATA_COULD_NOT_BE_SAVED);
			// 7. Send activation link.
			$mailer = new \Core\Mailer();
			if (!$mailer->Send($email, \Core\i18n::Get('ACTIVATE_ACCOUNT'),
					\Core\Server::GetBaseURL() . 'activate-account.php?token='
					. $token->GetValue()))
				throw new \Core\Error(\Core\Error::EMAIL_COULD_NOT_BE_SENT);
		}
		catch (\Core\Error $error)
		{
			if (!\Core\Database::GetInstance()->Rollback())
				return \Core\Response::Error(\Core\Error::UNEXPECTED);
			return \Core\Response::Error($error->getCode());
		}
		if (!\Core\Database::GetInstance()->Commit())
			return \Core\Response::Error(\Core\Error::UNEXPECTED);

		return \Core\Response::Data(\Core\i18n::Get('AN_ACCOUNT_ACTIVATION_LINK_HAS_BEEN_SENT_TO_YOUR_EMAIL_ADDRESS'));
	}

	/**
	 * Activates an account by moving AccountActivate record from the `accountactivate`
	 * table to the `account` table.
	 *
	 * @param string $accountActivateToken A unique alpha-numeric string of 32
	 * characters in length, e.g. '48a582f16d06f99d34ffe7c238c6c55b'.
	 * @return If the method succeeds, the return value is Core::Response::Success.
	 * @return If the method fails, the return value is a Core::Response::Error
	 * which can contain one of the following error codes:
	 * Code | Meaning
	 * ---: | -------
	 * -1   | Unexpected error
	 * -2   | Access denied
	 * -5   | Data could not be saved
	 * -6   | Data could not be deleted
	 */
	public static function Action_Activate($accountActivateToken)
	{
		// 1. Obtain `AccountActivate` object from its Token.
		$aa = AccountActivate::FindByToken($accountActivateToken);
		if ($aa === null)
			return \Core\Response::Error(\Core\Error::ACCESS_DENIED);

		if (!\Core\Database::GetInstance()->BeginTransaction())
			return \Core\Response::Error(\Core\Error::UNEXPECTED);
		try
		{
			// 2. Create a new `Account` object, copy properties from the
			// `AccountActivate` object, and save `Account` object.
			$me = new self();
			$me->Email = $aa->Email;
			$me->Username = $aa->Username;
			$me->PasswordHash = $aa->PasswordHash;
			if (!$me->Save())
				throw new \Core\Error(\Core\Error::DATA_COULD_NOT_BE_SAVED);
			// 3. Delete the `AccountActivate` record.
			if (!$aa->Delete())
				throw new \Core\Error(\Core\Error::DATA_COULD_NOT_BE_DELETED);
		}
		catch (\Core\Error $error)
		{
			if (!\Core\Database::GetInstance()->Rollback())
				return \Core\Response::Error(\Core\Error::UNEXPECTED);
			return \Core\Response::Error($error->getCode());
		}
		if (!\Core\Database::GetInstance()->Commit())
			return \Core\Response::Error(\Core\Error::UNEXPECTED);

		return \Core\Response::Success();
	}

	/**
	 * Inserts a new PasswordReset record to the `passwordreset` table, and
	 * sends a password reset link to the user's email address.
	 *
	 * @param string $email %Account's email address.
	 * @return If the method succeeds, the return value is Core::Response::Data
	 * containing a message string.
	 * @return If the method fails, the return value is a Core::Response::Error
	 * which can contain one of the following error codes:
	 * Code | Meaning
	 * ---: | -------
	 * -1   | Unexpected error
	 * -5   | Data could not be saved
	 * -10  | Invalid email
	 * -12  | Email not found
	 * -13  | Email could not be sent
	 */
	public static function Action_SendPasswordResetLink($email)
	{
		// 1. Check if email is in valid format.
		if (!self::validateEmailAddressSyntax($email))
			return \Core\Response::Error(\Core\Error::INVALID_EMAIL);
		// 2. Check if email exists.
		$me = self::FindOne(self::prepareSql('Email=@1', $email));
		if ($me === null)
			return \Core\Response::Error(\Core\Error::EMAIL_NOT_FOUND);

		if (!\Core\Database::GetInstance()->BeginTransaction())
			return \Core\Response::Error(\Core\Error::UNEXPECTED);
		try
		{
			// 3. Generate password reset token and save `PasswordReset` record.
			$token = new \Core\Token;
			if (!PasswordReset::Upsert($me->ID, $token->GetValue()))
				throw new \Core\Error(\Core\Error::DATA_COULD_NOT_BE_SAVED);
			// 4. Send password reset link.
			$mailer = new \Core\Mailer();
			if (!$mailer->Send($email, \Core\i18n::Get('RESET_PASSWORD'),
					\Core\Server::GetBaseURL() . 'reset-password.php?token='
					. $token->GetValue()))
				throw new \Core\Error(\Core\Error::EMAIL_COULD_NOT_BE_SENT);
		}
		catch (\Core\Error $error)
		{
			if (!\Core\Database::GetInstance()->Rollback())
				return \Core\Response::Error(\Core\Error::UNEXPECTED);
			return \Core\Response::Error($error->getCode());
		}
		if (!\Core\Database::GetInstance()->Commit())
			return \Core\Response::Error(\Core\Error::UNEXPECTED);

		return \Core\Response::Data(\Core\i18n::Get('A_PASSWORD_RESET_LINK_HAS_BEEN_SENT_TO_YOUR_EMAIL_ADDRESS'));
	}

	/**
	 * Updates the password of an account via a password reset link.
	 *
	 * @param string $passwordResetToken A unique alpha-numeric string of 32
	 * characters in length, e.g. '48a582f16d06f99d34ffe7c238c6c55b'.
	 * @param string $newPassword %Account's new password.
	 * @return If the method succeeds, the return value is Core::Response::Success.
	 * @return If the method fails, the return value is a Core::Response::Error
	 * which can contain one of the following error codes:
	 * Code | Meaning
	 * ---: | -------
	 * -1   | Unexpected error
	 * -2   | Access denied
	 * -5   | Data could not be saved
	 * -6   | Data could not be deleted
	 * -14  | Invalid password length
	 */
	public static function Action_ResetPassword($passwordResetToken, $newPassword)
	{
		// 1. Obtain `PasswordReset` object from its Token.
		$pr = PasswordReset::FindByToken($passwordResetToken);
		if ($pr === null)
			return \Core\Response::Error(\Core\Error::ACCESS_DENIED);
		// 2. Obtain `Account` object from its ID.
		$me = self::FindById($pr->AccountID);
		if ($me === null)
			return \Core\Response::Error(\Core\Error::ACCESS_DENIED);
		// 3. Check if password length is in valid range; prevents DoS attacks.
		if (!self::validatePasswordLength($newPassword))
			return \Core\Response::Error(\Core\Error::INVALID_PASSWORD_LENGTH);

		if (!\Core\Database::GetInstance()->BeginTransaction())
			return \Core\Response::Error(\Core\Error::UNEXPECTED);
		try
		{
			// 3. Update password of `Account` object.
			$me->PasswordHash = \Core\Password::Hash($newPassword);
			if (!$me->Save())
				throw new \Core\Error(\Core\Error::DATA_COULD_NOT_BE_SAVED);
			// 4. Delete the `PasswordReset` record.
			if (!$pr->Delete())
				throw new \Core\Error(\Core\Error::DATA_COULD_NOT_BE_DELETED);
		}
		catch (\Core\Error $error)
		{
			if (!\Core\Database::GetInstance()->Rollback())
				return \Core\Response::Error(\Core\Error::UNEXPECTED);
			return \Core\Response::Error($error->getCode());
		}
		if (!\Core\Database::GetInstance()->Commit())
			return \Core\Response::Error(\Core\Error::UNEXPECTED);

		return \Core\Response::Success();
	}

	/**
	 * Updates the password of a logged-in user account.
	 *
	 * @param string $password %Account's current password.
	 * @param string $newPassword %Account's new password.
	 * @return If the method succeeds, the return value is Core::Response::Data
	 * containing a message string.
	 * @return If the method fails, the return value is a Core::Response::Error
	 * which can contain one of the following error codes:
	 * Code | Meaning
	 * ---: | -------
	 * -1   | Unexpected error
	 * -5   | Data could not be saved
	 * -14  | Invalid password length
	 * -15  | Incorrect password
	 */
	public static function Action_UpdatePassword($password, $newPassword)
	{
		// 1. Obtain the account object from the session file.
		$me = self::GetLoggedIn();
		// 2. Check if password lengths are in valid range; prevents DoS attacks.
		if (!self::validatePasswordLength($password)
		 || !self::validatePasswordLength($newPassword))
			return \Core\Response::Error(\Core\Error::INVALID_PASSWORD_LENGTH);
		// 3. Check if the current password is correct.
		if (!\Core\Password::Verify($password, $me->PasswordHash))
			return \Core\Response::Error(\Core\Error::INCORRECT_PASSWORD);

		if (!\Core\Database::GetInstance()->BeginTransaction())
			return \Core\Response::Error(\Core\Error::UNEXPECTED);
		try
		{
			// 4. Save the account with the new password.
			$me->PasswordHash = \Core\Password::Hash($newPassword);
			if (!$me->Save())
				throw new \Core\Error(\Core\Error::DATA_COULD_NOT_BE_SAVED);
			// 5. Update the Account object inside the session.
			\Core\Session::SetObject(self::SESSION_KEY, $me);
		}
		catch (\Core\Error $error)
		{
			if (!\Core\Database::GetInstance()->Rollback())
				return \Core\Response::Error(\Core\Error::UNEXPECTED);
			return \Core\Response::Error($error->getCode());
		}
		if (!\Core\Database::GetInstance()->Commit())
			return \Core\Response::Error(\Core\Error::UNEXPECTED);

		return \Core\Response::Data(\Core\i18n::Get('PASSWORD_UPDATED'));
	}

	/**
	 * Validates a given e-mail address against the syntax in RFC 822, with the
	 * exceptions that comments and whitespace folding and dotless domain names
	 * are not supported.
	 *
	 * @param string $emailAddress The email address to validate.
	 * @return If the email address is valid, the return value is `true`;
	 * otherwise, `false`.
	 */
	private static function validateEmailAddressSyntax($emailAddress)
	{
		return filter_var($emailAddress, FILTER_VALIDATE_EMAIL) !== false;
	}

	/**
	 * Validates if a given username contains only and at least one word
	 * character, and contains none of the restricted words.
	 *
	 * @remark A word character is a character from a-z, A-Z, 0-9, including the
	 * underscore (_) character.
	 *
	 * @param string $username The username to validate.
	 * @return If the username is valid, the return value is `true`; otherwise,
	 * `false`.
	 */
	private static function validateUsernameSyntax($username)
	{
		// Check if the username contains only and at least one word character.
		if (preg_match('/^\w+$/', $username) !== 1)
			return false;
		// Normalize the username by removing any underscore in it and make it
		// lowercased.
		$username_n = str_replace('_', '', strtolower($username));
		// Check if the username does not contain any of the restricted words.
		// Note that e.g. `ad_min` was normalized to `admin` above.
		foreach (\Core\Config::GetRestrictedUsernameWords() as $word)
			if (strpos($username_n, strtolower($word)) !== false)
				return false;
		return true;
	}

	/**
	 * Validates if the length of a password is within the allowed range.
	 *
	 * @param string $password The password to validate the length.
	 * @return If the password length is valid, the return value is `true`;
	 * otherwise, `false`.
	 */
	private static function validatePasswordLength($password)
	{
		$length = strlen($password);
		return $length >= \Core\Config::MIN_PASSWORD_LENGTH &&
		       $length <= \Core\Password::MAX_LENGTH;
	}
}
?>
