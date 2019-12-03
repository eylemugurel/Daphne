<?php
/**
 * @file Helper.php
 * Contains the `Helper` class.
 *
 * @version 3.6
 * @date    June 25, 2019 (21:01)
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
 * A utility class which contains miscellaneous assisting functions.
 */
class Helper
{
	/**
	 * Returns the value of a key in an array, or if not found, returns the
	 * provided default value.
	 *
	 * @param array $array The array to return the value from.
	 * @param $key The key to lookup.
	 * @param $defaultValue The default value to return if the key does not exist.
	 * @return The found value or the provided default value.
	 * @todo Rename to `GetArrayValueOrDefault`.
	 */
	public static function ArrayValueOrDefault($array, $key, $defaultValue ='')
	{
		return is_array($array) && array_key_exists($key, $array)
			? $array[$key]
			: $defaultValue;
	}

	/**
	 * Checks whether a string starts with another string.
	 *
	 * @param string $string The string to check.
	 * @param string $startString The string to search for at the beginning of
	 * $string.
	 * @return `true` or `false`.
	 */
	public static function StartsWith($string, $startString)
	{
		return substr($string, 0, strlen($startString)) === $startString;
	}

	/**
	 * Splits a string into an array of substrings, based on a given delimiter.
	 *
	 * @param string $string The string to split.
	 * @param string $delimiter The delimiter string which denotes the points at
	 * which each split should occur.
	 * @return An array of substrings split at each point where the delimiter
	 * occurs in the given string.
	 * @remark Each substring is whitespace-trimmed and excluded from the
	 * result if found to be empty.
	 */
	public static function Split($string, $delimiter)
	{
		$array = array();
		foreach (explode($delimiter, $string) as $substring) {
			$substring = trim($substring);
			if ($substring !== '')
				array_push($array, $substring);
		}
		return $array;
	}

	/**
	 * Echoes a text line immediately by flushing the output buffer.
	 *
	 * @param string $line The text line to output. The line can contain format
	 * specifiers where the rest of the arguments are substitutes.
	 * @note This method immediately flushes the output buffer, which means that
	 * the response headers are sent on the first call, e.g. the `headers_sent`
	 * function will return `true`.
	 */
	public static function Output($line/*, ...*/)
	{
		$args = func_get_args();
		if (count($args) > 1) {
			array_shift($args); // remove the first parameter, which is `$line`.
			$line = vsprintf($line, $args);
		}
		echo $line . '<br>'; // note that '\n' does not work.
		ob_flush();
		flush();
	}
}
?>
