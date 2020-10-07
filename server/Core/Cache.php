<?php
/**
 * @file Cache.php
 * Contains the `Cache` class.
 *
 * @version 1.1
 * @date    October 7, 2020 (12:06)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2020 Eylem Ugurel. All rights reserved.
 */

namespace Core;

/**
 * Class that implements the Cache-Aside Pattern.
 */
class Cache
{
	/**
	 * @brief Retrieves data associated with a given cache item name.
	 *
	 * The function first tries to get data from the cache. If the data is not
	 * in the cache or expired, gets it from the source, adds it to the cache,
	 * and returns it.
	 *
	 * @param string $key Name of the cache item.
	 * @param callable $callback A function/closure that generates data. It's
	 * called when a cache item does not exist or expired.
	 * @param integer $duration (optional) Max age (in seconds) of the cache
	 * item. Defaults to 1 min.
	 * @return The fetched data.
	 */
	public static function Get($key, $callback, $duration =60)
	{
		$filename = self::filenameOf($key);
		if (self::isHit($filename, $duration))
			return self::readFile($filename);
		$data = $callback();
		self::writeFile($filename, $data);
		return $data;
	}

	/**
	 * @brief Deletes a cache item.
	 *
	 * @param string $key Name of the cache item to remove.
	 */
	public static function Clear($key)
	{
		$filename = self::filenameOf($key);
		clearstatcache(false, $filename); // important!
		if (@is_file($filename))
			@unlink($filename);
	}

	/**
	 * @brief Calculates the filename of a cache item.
	 *
	 * @param string $key Name of the cache item to calculate filename for.
	 * @return A filename.
	 */
	private static function filenameOf($key)
	{
		return Config::GetCacheDirectory() . '/' . $key . '.cache';
	}

	/**
	 * @brief Checks whether a cache file exists and is not expired.
	 *
	 * @param string $filename Filename of the cache file.
	 * @param integer $duration Max age (in seconds) of the cache file.
	 * @return If the cache file exists and is not expired, the return value is
	 * `true`; otherwise, `false`.
	 */
	private static function isHit($filename, $duration)
	{
		clearstatcache(false, $filename); // important!
		if (!@is_file($filename))
			return false;
		return time() -  (integer)@filemtime($filename) < $duration;
	}

	/**
	 * @brief Reads data from a file.
	 *
	 * @param string $filename Path of the file to read data from.
	 * @return The read data.
	 */
	private static function readFile($filename)
	{
		$data = '';
		$handle = fopen($filename, 'r');
		if ($handle !== false) {
			if (flock($handle, LOCK_SH)) {
				$stat = fstat($handle);
				if ($stat !== false) {
					$size = $stat['size'];
					if ($size > 0)
						$data = fread($handle, $size);
				}
				flock($handle, LOCK_UN);
			}
			fclose($handle);
		}
		return $data;
	}

	/**
	 * @brief Writes data to a file.
	 *
	 * @param string $filename Path of the file to write data to.
	 * @param string $data Data to write.
	 */
	private static function writeFile($filename, $data)
	{
		@file_put_contents($filename, $data, LOCK_EX);
	}
}
?>
