<?php
/**
 * @file Config.php
 * Contains the `Config` class.
 *
 * @version 3.7
 * @date    November 1, 2019 (19:55)
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
 * Contains application-wide configuration options.
 */
class Config
{
	/**
	 * The application title (or name).
	 *
	 * The title is referenced from various places including:
	 * 1. HTML page titles, appearing as a suffix following the page title, e.g.
	 * "SomePage | MyApp".
	 * 2. The brand name on the navigation bar.
	 * 3. The "from" name in sent emails.
	 */
	const TITLE = 'Daphne';

	/**
	 * The description.
	 */
	const DESCRIPTION = 'A full-stack framework for web applications';

	/**
	 * The application language identifier.
	 *
	 * This value has effect on:
	 * 1. Loading corresponding internationalization (i18n) class which defines
	 * the translations.
	 * 2. The `lang` attribute of the `html` tag.
	 * 3. Locale of the plugins.
	 *
	 * @see <a href="https://www.iso.org/iso-639-language-codes.html" target="_blank">Language codes - ISO 639</a>
	 */
	const LANGUAGE = 'en';

	/**
	 * The application language identifier in extended syntax.
	 *
	 * It's similar to #LANGUAGE, and in use by:
	 * 1. The `Time` class.
	 * 2. Social plugins.
	 *
	 * @remark This identifier uses the format ll_CC, where ll is a two-letter
	 * language code, and CC is a two-letter country code. For instance, en_US
	 * represents U.S. English.
	 * @see <a href="https://www.iso.org/iso-639-language-codes.html" target="_blank">Language codes - ISO 639</a>
	 * @see <a href="https://www.iso.org/iso-3166-country-codes.html" target="_blank">Country Codes - ISO 3166</a>
	 */
	const LANGUAGE_EX = 'en_US';

	/**
	 * The timezone which the main audience is in.
	 *
	 * The application relies on this value to calculate the local time.
	 *
	 * @see <a href="https://www.php.net/manual/en/timezones.php" target="_blank">List of Supported Timezones</a>
	 */
	const TIMEZONE = 'Europe/Istanbul';

	/**
	 * The directory from which the application is served.
	 *
	 * Normally this value equals to '/' which means that the application files
	 * are installed on the root of your domain. However there are circumstances
	 * where the application files have to be located under a subdirectory (e.g.
	 * "example.com/my/base/path/"). In such a case, specify your subdirectory
	 * path here (e.g. '/my/base/path/').
	 *
	 * @note The path <i>must</i> start and end with slash character (/).
	 */
	const BASE_PATH = '/';

	/**
	 * Turns on or off the debug mode.
	 *
	 * For the convenience of the developer, when this value is `true`, the
	 * following happens:
	 * 1. Non-minified versions of stylesheet and javascript files are used.
	 * 2. The mailer is blocked, but email contents are dumped to the log file.
	 * 3. Social plugins are blocked.
	 *
	 * @note This value <i>should</i> be `false` when releasing the application.
	 */
	const DEBUG = true;

	/**
	 * Turns on or off the logging facility.
	 *
	 * When this value is `true`, the application logs various information to
	 * the log file, including notices, warnings, and errors.
	 *
	 * @see Log::FILENAME
	 * @note This value <i>should</i> be `false` when releasing the application.
	 */
	const LOG = true;

	/**
	 * Domain name or IP of the database server.
	 */
	const DATABASE_HOST = 'localhost';

	/**
	 * Name of the database.
	 */
	const DATABASE_NAME = 'Daphne';

	/**
	 * Username of the database.
	 */
	const DATABASE_USERNAME = 'root';

	/**
	 * Password of the database.
	 */
	const DATABASE_PASSWORD = '';

	/**
	 * Character set of the database.
	 */
	const DATABASE_CHARSET = 'utf8mb4';

	/**
	 * Collation of the database.
	 */
	const DATABASE_COLLATION = 'utf8mb4_unicode_ci';

	/**
	 * Domain name or IP of the mail server.
	 */
	const MAILER_HOST = 'localhost';

	/**
	 * Username of the mail account.
	 */
	const MAILER_USERNAME = 'noreply@example.com';

	/**
	 * Password of the mail account.
	 */
	const MAILER_PASSWORD = '';

	/**
	 * Path to directory where the client-side resources are located.
	 *
	 * @note The path <i>must not</i> end with slash character (/).
	 */
	const DIRECTORY_CLIENT = 'client';

	/**
	 * Path to directory where the server-side resources are located.
	 *
	 * @note The path <i>must not</i> end with slash character (/).
	 */
	const DIRECTORY_SERVER = 'server';

	/**
	 * List of words that are prohibited in usernames.
	 *
	 * @note Words specified here <i>must</i> be in lower case.
	 */
	private static $RESTRICTED_USERNAME_WORDS = array(
		'admin',
		'moderator'
	);

	/**
	 * Allowed minimum length of a password.
	 */
	const MIN_PASSWORD_LENGTH = 6;

	/**
	 * To emulate hard-refresh (Ctrl+F5) on a web browser, increment this number.
	 * This value will be rendered as the query parameter as `v` for the all
	 * stylesheet and javascript files (e.g. 'index.min.js?v=42').
	 */
	const CLIENT_SCRIPT_VERSION = 1;

	/**
	 * Facebook app id to be used by Facebook SDK.
	 */
	const FACEBOOK_APP_ID = '';

	/**
	 * Google Analytics tracking id to be used by Google Analytics SDK.
	 */
	const GOOGLE_ANALYTICS_TRACKING_ID = '';

	/**
	 * Gets the path to the client-side image directory.
	 *
	 * @return A string specifying a directory path.
	 */
	public static function GetClientImageDirectory() {
		return self::DIRECTORY_CLIENT . '/image';
	}

	/**
	 * Gets the path to the client-side third-party library directory.
	 *
	 * @return A string specifying a directory path.
	 */
	public static function GetClientLibraryDirectory() {
		return self::DIRECTORY_CLIENT . '/library';
	}

	/**
	 * Gets the path to the client-side script directory.
	 *
	 * @return A string specifying a directory path.
	 */
	public static function GetClientScriptDirectory() {
		return self::DIRECTORY_CLIENT . '/script';
	}

	/**
	 * Gets the URL of the logo image file.
	 *
	 * @param bool $isAbsolute If this parameter is `true`, then the function
	 * returns a full URL, one which starts with a scheme followed by the host
	 * name (e.g. "http://example.com/client/image/logo.jpg"). Otherwise, the
	 * return value is relative to the base path (e.g. "client/image/logo.jpg").
	 * @return A string specifying an URL.
	 */
	public static function GetLogoImageURL($isAbsolute =false) {
		$result = $isAbsolute ? Server::GetBaseURL() : '';
		$result .= self::GetClientImageDirectory() . '/logo.png';
		return $result;
	}

	/**
	 * Gets the path to the masterpage directory.
	 *
	 * @return A string specifying a directory path.
	 */
	public static function GetMasterpageDirectory() {
		return self::DIRECTORY_SERVER . '/masterpage';
	}

	/**
	 * Gets the path to the dialog directory.
	 *
	 * @return A string specifying a directory path.
	 */
	public static function GetDialogDirectory() {
		return self::DIRECTORY_SERVER . '/dialog';
	}

	/**
	 * Gets the list of words that are prohibited in usernames.
	 *
	 * @return An array of strings.
	 */
	public static function GetRestrictedUsernameWords() {
		return self::$RESTRICTED_USERNAME_WORDS;
	}
}
?>
