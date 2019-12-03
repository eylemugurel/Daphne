<?php
/**
 * @file Time.php
 * Contains the `Time` class.
 *
 * @version 1.7
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
 * Represents time in the current timezone and the locale.
 *
 * @note The `Time` class obtains the timezone and the locale from Config::TIMEZONE
 * and Config::LANGUAGE_EX respectively. It does not rely on the OS settings.
 */
class Time extends \DateTime
{
	/**
	 * The start of time, in ISO 8601 format.
	 */
	const EPOCH = '1970-01-01T00:00:00Z';
	/**
	 * The date format, e.g. `03.05.2018`
	 */
	const DATE_FORMAT = 'd.m.Y';
	/**
	 * The date/time format, e.g. `03.05.2018 17:42:08`
	 */
	const DATETIME_FORMAT = 'd.m.Y H:i:s';
	/**
	 * The date/time format that MySQL uses, e.g. `2018-05-03 17:42:08`
	 */
	const DATETIME_FORMAT_MYSQL = 'Y-m-d H:i:s';

	/**
	 * Returns a new `DateTimeZone` object based on the configured timezone.
	 *
	 * @return A `DateTimeZone` object.
	 */
	private static function timeZone()
	{
		return new \DateTimeZone(Config::TIMEZONE);
	}

	/**
	 * Returns a new `Time` object based on the configured timezone.
	 *
	 * @param string $time (optional) A date/time string. Valid formats are
	 * explained in <a href="http://php.net/manual/en/datetime.formats.php" target="_blank">Date and Time Formats</a>.
	 * The "now" is the default value which obtains the current time.
	 */
	public function __construct($time ="now")
	{
		// Quoting http://php.net/manual/en/datetime.construct.php
		// Enter "now" here to obtain the current time when using the $timezone
		// parameter.
		parent::__construct($time, self::timeZone());
	}

	/**
	 * Parses a time string according to a specified format.
	 *
	 * @param string $format The format that the `$time` parameter should be in.
	 * @param string $time String representing the time.
	 * @param string $timezone (unused) Although this` parameter is not used,
	 * it's here to prevent the strict standards error saying "Declaration
	 * should be compatible ...".
	 * @return A `Time` object based on the configured timezone. There is no error
	 * return. If the parent method fails, returns the epoch time.
	 * @note This method is implemented for internal use. Explicit usage may
	 * yield unexpected results.
	 */
	public static function createFromFormat($format, $time, $timezone =null)
	{
		$dt = parent::createFromFormat($format, $time, self::timeZone());
		if ($dt === false)
			return new self(self::EPOCH);
		// Because late static bindings is not implemented in DateTime::
		// createFromFormat (e.g. new static), the returning part is fixed as:
		return new self($dt->format(parent::ATOM));
	}

	/**
	 * Returns a new `Time` object from a Unix timestamp string.
	 *
	 * @param string $s A Unix timestamp (e.g. "309445456").
	 * @return A `Time` object based on the configured timezone.
	 */
	public static function FromUnixTimestamp($s)
	{
		// Quoting http://php.net/manual/en/datetime.createfromformat.php
		// The timezone parameter and the current timezone are ignored when
		// the time parameter either contains a UNIX timestamp (e.g. 946684800)
		// or specifies a timezone (e.g. 2010-01-28T15:00:00+02:00).
		$me = self::createFromFormat('U', $s);
		// Quting again, if you want to change the timezone, you have to use
		// `setTimezone` after the object is created.
		$me->setTimezone(self::timeZone());
		return $me;
	}

	/**
	 * Returns a new `Time` object from an `ISO 8601` date/time string.
	 *
	 * @param string $s An `ISO 8601` date/time (e.g. "2019-01-15T20:34:14+03:00").
	 * @return A `Time` object.
	 * @remark The configured timezone is ignored because the incoming string
	 * already contains its own timezone information.
	 */
	public static function FromAtomString($s)
	{
		return self::createFromFormat(parent::ATOM, $s);
	}

	/**
	 * Returns a new `Time` object from a MySQL date/time string.
	 *
	 * @param string $s A MySQL date/time (e.g. "2018-05-03 17:42:08").
	 * @return A `Time` object based on the configured timezone.
	 */
	public static function FromMySQLString($s)
	{
		return self::createFromFormat(self::DATETIME_FORMAT_MYSQL, $s);
	}

	/**
	 * Returns a new `Time` object from a date string.
	 *
	 * @param string $s A date (e.g. "03.05.2018").
	 * @return A `Time` object based on the configured timezone.
	 */
	public static function FromDateString($s)
	{
		$me = self::createFromFormat(self::DATE_FORMAT, $s);
		// Because only the date part is in concern, zero-out the time part.
		$me->setTime(0, 0);
		return $me;
	}

	/**
	 * Returns a new `Time` object from a date/time string.
	 *
	 * @param string $s A date/time (e.g. "03.05.2018 17:42:08").
	 * @return A `Time` object based on the configured timezone.
	 */
	public static function FromDateTimeString($s)
	{
		return self::createFromFormat(self::DATETIME_FORMAT, $s);
	}

	/**
	 * Gets the value in the Unix timestamp format.
	 *
	 * @return A Unix timestamp string, e.g. "309445456".
	 */
	public function ToUnixTimestamp()
	{
		return $this->format('U');
	}

	/**
	 * Gets the value in the `ISO 8601` format.
	 *
	 * @return A string formatted according to the `ISO 8601` format, e.g.
	 * "2019-01-15T20:34:14+03:00".
	 */
	public function ToAtomString()
	{
		return $this->format(parent::ATOM);
	}

	/**
	 * Gets the value in the MySQL format.
	 *
	 * @return A string formatted according to the MySQL format, e.g.
	 * "2018-05-03 17:42:08".
	 */
	public function ToMySQLString()
	{
		return $this->format(self::DATETIME_FORMAT_MYSQL);
	}

	/**
	 * Gets the value in the date format.
	 *
	 * @return A string formatted according to the date format,
	 * e.g. "03.05.2018".
	 */
	public function ToDateString()
	{
		return $this->format(self::DATE_FORMAT);
	}

	/**
	 * Gets the value in the date/time format.
	 *
	 * @return A string formatted according to the date/time format,
	 * e.g. "03.05.2018 17:42:08".
	 */
	public function ToDateTimeString()
	{
		return $this->format(self::DATETIME_FORMAT);
	}

	/**
	 * Gets the value in the locale date format.
	 *
	 * @return A string formatted according to locale date format including full
	 * month name based on the configured language, e.g. "May 3, 2018".
	 */
	public function ToLocaleDateString()
	{
		$idf = new \IntlDateFormatter(
			Config::LANGUAGE_EX,
			\IntlDateFormatter::LONG,
			\IntlDateFormatter::NONE,
			Config::TIMEZONE // Fix: Read comments bellow.
		);
		// When using the `format` method, if a `DateTime` object is passed, its
		// timezone is NOT considered. The object will be formatted using the
		// formater's configured timezone. To use the timezone of the `DateTime`
		// object, pass it in the 3rd parameter to the constructor above.
		return $idf->format($this);
	}

	/**
	 * Checks if the value is zero.
	 *
	 * @return The method returns `true` if the timestamp value equals to zero,
	 * which is the Epoch time. Otherwise it returns `false.`
	 * @remark Epoch is the number of seconds that have elapsed since January 1,
	 * 1970 at 00:00:00 GMT.
	 */
	public function IsZero()
	{
		return $this->getTimestamp() === 0;
	}
}
?>
