<?php
/**
 * @file Password.php
 * Contains the `Password` class.
 *
 * @version 1.0
 * @date    November 2, 2019 (9:21)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

namespace Core;

require_once __DIR__ . '/../library/phpass/PasswordHash.php';

/**
 * @brief Wrapper around the `phpass` library.
 *
 * PHP's native `password_hash` and `password_verify` functions are available
 * only in PHP >= 5.5.0. If you have to support older versions of PHP, then
 * this class is a useful tool for you.
 *
 * @see https://www.openwall.com/phpass/
 */
class Password
{
	/**
	 * @brief Maximum number of characters allowed in a password string.
	 *
	 * The underlying bcrypt function has an upper limit of 72 characters. This
	 * limit comes from the Blowfish P-Box size, which is 18 DWORDs (18 x 4
	 * bytes = 72 bytes).
	 */
	const MAX_LENGTH = 72;

	/**
	 * @brief The singleton `PasswordHash` instance of the `phpass` library.
	 *
	 * This instance is instantiated on the first call to the `#getHasher`
	 * method.
	 */
	private static $hasher = null;

	/**
	 * @brief Creates a hash from a given password.
	 *
	 * @param string $password The password to hash.
	 * @return The created hash string.
	 * @return If the given password exceeds the maximum allowed length, the
	 * function returns empty string.
	 */
	public static function Hash($password)
	{
		if (self::exceedsMaxLength($password))
			return '';
		return self::getHasher()->HashPassword($password);
	}

	/**
	 * @brief Verifies that a password matches a given hash.
	 *
	 * @param string $password The password to verify.
	 * @param string $hash A hash string created by the `#Hash` function.
	 * @return If the password and the hash match, the function returns `true`;
	 * otherwise, `false`.
	 * @return If the given password exceeds the maximum allowed length, the
	 * function returns `false`.
	 */
	public static function Verify($password, $hash)
	{
		if (self::exceedsMaxLength($password))
			return false;
		return self::getHasher()->CheckPassword($password, $hash);
	}

	/**
	 * @brief Checks if a given password exceeds the maximum allowed length.
	 *
	 * @param string $password A password.
	 * @return If the number of characters in password exceeds `#MAX_LENGTH`,
	 * the function returns `true`; otherwise, `false`.
	 */
	private static function exceedsMaxLength($password)
	{
		return strlen($password) > self::MAX_LENGTH;
	}

	/**
	 * @brief Returns the singleton `PasswordHash` instance.
	 *
	 * @return A `PasswordHash` object.
	 */
	private static function getHasher()
	{
		if (self::$hasher == null)
			self::$hasher = new \PasswordHash(8, false);
		return self::$hasher;
	}
}
?>