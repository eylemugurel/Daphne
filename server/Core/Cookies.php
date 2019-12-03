<?php
/**
 * @file Cookies.php
 * Contains the `Cookies` class.
 *
 * @version 1.4
 * @date    October 22, 2019 (20:24)
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
 * Represents an array of HTTP cookies.
 */
class Cookies
{
	/**
	 * Determines whether a value associated with a given name exists in the
	 * cookie array.
	 *
	 * @param string $name The name of the cookie.
	 * @return If a value exists associated with $name, the method returns
	 * `true`. Otherwise, it returns `false`.
	 */
	public static function Has($name)
	{
		return array_key_exists($name, $_COOKIE);
	}

	/**
	 * Inserts a new name-value pair to the cookie array.
	 *
	 * @param string $name The name of the cookie.
	 * @param string $value The value of the cookie.
	 * @param int $expire The time the cookie expires. This is a Unix timestamp
	 * so is in number of seconds since the epoch.
	 */
	public static function Set($name, $value, $expire =0)
	{
		if (headers_sent())
			return;
		setcookie($name, $value, $expire, '/', '', Server::IsSecure(), true);
	}

	/**
	 * Retrieves the value associated with a given name from the cookie array.
	 *
	 * @param string $name The name of the cookie.
	 * @return If $name exists in the cookie array, the method returns its
	 * associated value. Otherwise, the system reports an "Undefined index"
	 * notice.
	 * @remark You should always call the #Has method to be sure if a name exists
	 * before calling this method.
	 */
	public static function Get($name)
	{
		return $_COOKIE[$name];
	}

	/**
	 * Deletes a name-value pair from the cookie array.
	 *
	 * @param string $name The name of the cookie.
	 */
	public static function Remove($name)
	{
		if (headers_sent())
			return;
		setcookie($name, false, -1, '/', '', Server::IsSecure(), true);
		unset($_COOKIE[$name]);
	}

	/**
	 * Deletes all cookies from the cookie array, except the session cookie.
	 */
	public static function RemoveAll()
	{
		// If cookie names are in array notation, eg: user[username] Then PHP
		// will automatically create a corresponding array in $_COOKIE. Instead
		// use $_SERVER['HTTP_COOKIE'] as it mirrors the actual HTTP Request
		// headers with which we can perform string operations.
		if (!array_key_exists('HTTP_COOKIE', $_SERVER))
			return;
		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		$sn = session_name();
		foreach ($cookies as $cookie) {
			$parts = explode('=', $cookie);
			$name = trim($parts[0]);
			if ($name !== $sn)
				self::Remove($name);
		}
	}
}
?>
