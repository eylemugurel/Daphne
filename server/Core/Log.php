<?php
/**
 * @file Log.php
 * Contains the `Log` class.
 *
 * @version 3.4
 * @date    July 26, 2019 (19:15)
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
 * Contains methods for sending output to the log file.
 */
class Log
{
	/**
	 * The name of the log file.
	 *
	 * @note During destruction of an object, the current directory is autmatically
	 * changed to Apache's `bin` directory. Therefore, also look for a log file
	 * at that location, e.g. `C:\wamp64\bin\apache\apache2.4.33`.
	 */
	const FILENAME = 'default.log';

	/**
	 * The timestamp format.
	 */
	const TIMESTAMP_FORMAT = 'Y.m.d H:i:s';

	/**
	 * The format of each line written to the log file.
	 */
	const LINE_FORMAT = '[%s | %s] %s';

	/**
	 * Writes an information line to the log file.
	 *
	 * @param string $text The text to log.
	 */
	public static function Info($text)
	{
		$dtz = date_default_timezone_get(); // backup
		date_default_timezone_set(Config::TIMEZONE);
		$line = sprintf(self::LINE_FORMAT,
			date(self::TIMESTAMP_FORMAT),
			$_SERVER['REMOTE_ADDR'],
			$text);
		file_put_contents(self::FILENAME, $line . PHP_EOL, FILE_APPEND);
		date_default_timezone_set($dtz); // restore
	}

	/**
	 * Writes a warning line to the log file.
	 *
	 * @param string $text The text to log.
	 */
	public static function Warning($text)
	{
		self::Info('[Warning] ' . $text);
	}

	/**
	 * Writes an error line to the log file.
	 *
	 * @param string $text The text to log.
	 */
	public static function Error($text)
	{
		self::Info('[Error] ' . $text);
	}
}
?>
