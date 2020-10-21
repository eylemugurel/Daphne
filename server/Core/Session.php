<?php
/**
 * @file Session.php
 * Contains the `Session` class.
 *
 * @version 1.6
 * @date    June 8, 2019 (14:01)
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
 * Persists the state of a user between page requests.
 */
class Session
{
	/**
	 * Starts a new, or resumes an existing session.
	 *
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 * @remark The `Activate` method must be first to call before using any of
	 * the methods.
	 */
	public static function Activate()
	{
		// Fix: Since `session_status` requires PHP >= 5.4.0, `session_id` is
		// used instead to be compatible with PHP <= 5.3.3. This is same as
		// `session_status() === PHP_SESSION_ACTIVE`.
		if (session_id() !== '') // already started?
			return true;

		// Set session cookie to be HttpOnly so that PHPSESSID is not visible
		// inside document.cookie. Also set cookie as secure if HTTPS is
		// specified.
		$cp = session_get_cookie_params();
		session_set_cookie_params($cp['lifetime'],
		                          $cp['path'],
		                          $cp['domain'],
		                          Server::IsSecure(),
		                          true);
		// Fix: Using '@' operator supresses errors like `Failed to decode
		// session object. Session has been destroyed`.
		return @session_start();
	}

	/**
	 * Destroys the data associated with the current session, and deletes the
	 * session file from the server.
	 */
	public static function Destroy()
	{
		// Unset all of the session variables.
		$_SESSION = array();
		// Fix: If the output is flushed meanwhile, this check prevents the
		// "headers already sent" error.
		if (!headers_sent()) {
			// Remove the session cookie. Fix: The cookie must be removed with
			// the same parameters as it was created.
			$cp = session_get_cookie_params();
			setcookie(session_name(),
			          false,
			          -1,
			          $cp['path'],
			          $cp['domain'],
			          Server::IsSecure(),
			          true);
		}
		// Remove session cookie from the superglobal.
		unset($_COOKIE[session_name()]);
		// Finally, destroy the session.
		session_destroy();
	}

	/**
	 * Determines whether a value associated with a given key exists in the
	 * current session.
	 *
	 * @param string $key String specifying a key.
	 * @return If a value exists associated with $key, the method returns
	 * `true`. Otherwise, it returns `false`.
	 */
	public static function Has($key)
	{
		return array_key_exists($key, $_SESSION);
	}

	/**
	 * Inserts a new key-value pair, or updates an existing value associated
	 * with a given key in the current session.
	 *
	 * @param string $key String specifying a key.
	 * @param $value Any value.
	 */
	public static function Set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	/**
	 * Retrieves the value associated with a given key from the current session.
	 *
	 * @param string $key String specifying a key.
	 * @return If $key exists in the current session, the method returns its
	 * associated value. Otherwise, the system reports an "Undefined index"
	 * notice.
	 * @remark You should always call the #Has method to be sure if a key exists
	 * before calling this method.
	 */
	public static function Get($key)
	{
		return $_SESSION[$key];
	}

	/**
	 * Inserts a new key-object pair, or updates an existing object associated
	 * with a given key in the current session.
	 *
	 * @param string $key String specifying a key.
	 * @param $object Instance of a class.
	 */
	public static function SetObject($key, $object)
	{
		self::Set($key, serialize($object));
	}

	/**
	 * Retrieves the object associated with a given key from the current session.
	 *
	 * @param string $key String specifying a key.
	 * @return If $key exists in the current session, the method returns its
	 * associated object. Otherwise, the system reports an "Undefined index"
	 * notice.
	 * @remark You should always call the #Has method to be sure if a key exists
	 * before calling this method.
	 */
	public static function GetObject($key)
	{
		return unserialize(self::Get($key));
	}

	/**
	 * Deletes a key-value pair from the current session.
	 *
	 * @param string $key String specifying a key.
	 */
	public static function Remove($key)
	{
		unset($_SESSION[$key]);
	}
}
?>
