<?php
/**
 * @file Page.php
 * Contains the `Page` class.
 *
 * @version 2.4
 * @date    November 1, 2019 (3:31)
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
 * Manages the authorization and rendering of a typical server page.
 */
class Page
{
	/**
	 * Name of the log-out token.
	 */
	const LOGOUT_TOKEN_NAME = 'LogOutToken';

	/**
	 * The value of the `content` attribute of the 'viewport' meta tag.
	 */
	const VIEWPORT_META_CONTENT = 'width=device-width,maximum-scale=1,user-scalable=no';

	/**
	 * Holds the `Model::Account` object of the currently authenticated user,
	 * or `null` if the page is being visited anonymously.
	 */
	private $loggedInAccount = null;

	/**
	 * Holds the title of the page which is rendered in the `<title>` tag and
	 * the `content` value of the `<meta property="og:title">` tag.
	 */
	private $title = '';

	/**
	 * Holds the description of the page which is rendered as the `content` value
	 * of the `<meta name="description">` and `<meta property="og:description">`
	 * tags.
	 */
	private $description = '';

	/**
	 * URL of the image file to use with the social `<meta>` tags. This must be
	 * an absolute URL.
	 */
	private $socialImageUrl = '';

	/**
	 * Official query parameter name to be used while forming the canonical URL
	 * of the page.
	 */
	private $canonicalQueryKey = '';

	/**
	 * Contains an array of name/content pairs to be rendered as `<meta>` tags.
	 */
	private $metas = array();

	/**
	 * Contains an array of strings specifying the names of built-in client-side
	 * libraries to be rendered as `<link>` and/or `<script>` tags.
	 */
	private $libraries = array();

	/**
	 * Contains an array of strings specifying the names of user-defined
	 * client-side scripts to be rendered as `<link>` and `<script>` tags.
	 */
	private $scripts = array();

	/**
	 * Contains an array of strings specifying the names of built-in dialog
	 * boxes.
	 */
	private $dialogs = array();

	/**
	 * Holds the name of the master page.
	 */
	private $masterpage = '';

	/**
	 * Contains the HTML code to be rendered within the master page.
	 */
	private $contents = '';

	/**
	 * Returns a new `%Page` object after performing the following tasks:
	 * 1. Starts "output buffering".
	 * 2. Deletes all cookies except the session cookie (e.g. "PHPSESSID").
	 * 3. Initializes #$loggedInAccount.
	 * 4. Does the necessary redirection.
	 * 5. Adds built-in metadatas.
	 *
	 * @param bool $authorize (optional) Can take one of the following values:
	 * Value             | Meaning
	 * ------------------| -----------------------------------------------------
	 * `false` (default) | The page can be viewed anonymously.
	 * `true`            | If the user is not logged in, redirects to the login page.
	 * `-1` (internal)   | If the user is already logged in, redirects to the home page.
	 */
	public function __construct($authorize =false)
	{
		// Start first level of "output buffering".
		ob_start();

		// Delete all cookies (does not delete the session cookie, which is
		// "PHPSESSID").
		Cookies::RemoveAll();

		// This can be an `Account` object or `null`.
		$this->loggedInAccount = \Model\Account::GetLoggedIn();

		// Fix: Note that use of `switch` statement results the value of -1
		// match the true case because of loose comparison. Strict comparison
		// must be used here.
		if ($authorize === -1)
		{
			// The `-1` value is reserved for the internal use. If the account
			// is logged in, ignores the current page (e.g. `login.php`) and
			// issues a redirect to `index.php`. However, does not force user
			// to log out.
			if ($this->loggedInAccount !== null)
				exit(header('Location: index.php'));
		}
		else if ($authorize === true)
		{
			// If the account is not logged in, issues a redirect to `login.php`
			// with the current page name as the `referer` query parameter.
			if ($this->loggedInAccount === null) {
				// Special characters in the query parameter must be encoded to
				// make them valid values for the `referer` parameter (e.g.
				// `/page.php?id=42` becomes `referer=page.php%3Fid%3D42`).
				$referer = Server::GetPageFileName() . rawurlencode(Server::GetQueryString());
				exit(header('Location: login.php?referer=' . $referer));
			}
		}

		// If the account is logged in, then add the log-out token.
		if ($this->loggedInAccount !== null) {
			// Add a randomly generated token as meta tag and create its hash
			// value as a cookie. When the `LogOut` action takes place, this
			// token is sent as a POST parameter.
			//
			// Imagine a logged-in user has posted an image to your site such as:
			//
			//   <img src="http://example.com/action.php?action=LogOut">
			//
			// Then, every user viewing the image will eventually be logged out
			// from the site. Since this is an harmless example of a CSRF
			// attack, as a prevention, this token mechanism is developed.
			$this->AddToken(self::LOGOUT_TOKEN_NAME);
		}
	}

	/**
	 * Ends "output buffering" and flushes the page contents.
	 */
	public function __destruct()
	{
		ob_end_flush();
	}

	/**
	 * Retrieves the account object of the currently authenticated user.
	 *
	 * @return If the user is logged in, the return value is a `Model::Account`
	 * object; otherwise it's `null`.
	 */
	public function GetLoggedInAccount()
	{
		return $this->loggedInAccount;
	}

	/**
	 * Sets the title.
	 *
	 * @param string $title %Page's title.
	 */
	public function SetTitle($title)
	{
		$this->title = is_string($title) ? $title : '';
	}

	/**
	 * Gets the title.
	 *
	 * @return The title.
	 */
	public function GetTitle()
	{
		return $this->title;
	}

	/**
	 * Sets the description.
	 *
	 * @param string $description %Page's description.
	 */
	public function SetDescription($description)
	{
		$this->description = is_string($description) ? $description : '';
	}

	/**
	 * Gets the description.
	 *
	 * @return The description.
	 */
	public function GetDescription()
	{
		return $this->description;
	}

	/**
	 * Sets the social image URL.
	 *
	 * @param string $socialImageUrl %Page's social image URL. This must be an
	 * absolute URL.
	 * @remark PHP < 5.2.13 contains a bug in FILTER_VALIDATE_URL with dashes.
	 * Continuing with the `is_string` function.
	 */
	public function SetSocialImageUrl($socialImageUrl)
	{
		$this->socialImageUrl = is_string($socialImageUrl) ? $socialImageUrl : '';
	}

	/**
	 * Gets the social image URL.
	 *
	 * @return The social image URL.
	 */
	public function GetSocialImageUrl()
	{
		return $this->socialImageUrl;
	}

	/**
	 * Sets the canonical query key.
	 *
	 * @param string $value A query parameter name.
	 */
	public function SetCanonicalQueryKey($value)
	{
		$this->canonicalQueryKey = is_string($value) ? $value : '';
	}

	/**
	 * Gets the canonical query key.
	 *
	 * @return A query parameter name.
	 */
	public function GetCanonicalQueryKey()
	{
		return $this->canonicalQueryKey;
	}

	/**
	 * Adds a new name/content pair to the #$metas array.
	 *
	 * @param string $name Name of a metadata.
	 * @param scalar $content Value of the metadata.
	 */
	public function AddMeta($name, $content)
	{
		if (!is_string($name))
			$name = '';
		if (!is_scalar($content))
			$content = '';
		$this->metas[$name] = (string)$content;
	}

	/**
	 * Retrieves the content of a metadata.
	 *
	 * @param string $name Name of a metadata.
	 * @return If the specified metadata name exists, returns its content.
	 * Otherwise returns `null`.
	 */
	public function FindMeta($name)
	{
		if (!array_key_exists($name, $this->metas))
			return null;
		return $this->metas[$name];
	}

	/**
	 * Gets the metas array.
	 *
	 * @return An associative array.
	 */
	public function GetMetas()
	{
		return $this->metas;
	}

	/**
	 * Adds a new page-level token to be used against CSRF vulnerabilities.
	 *
	 * @param string $name (optional) Name of the token.
	 * @remark This method internally calls #AddMeta with the token name as the
	 * metadata name, and a randomly generated token as the metadata content.
	 * It also creates an hash value of the generated token and sends to the
	 * client as a cookie.
	 */
	public function AddToken($name =Token::DEFAULT_NAME)
	{
		$token = new Token;
		self::AddMeta($name, $token->GetValue());
		Cookies::Set($name, $token->GetCookieValue());
	}

	/**
	 * Adds built-in client-side libraries to the page.
	 *
	 * @param string $value A string or list of strings separated by commas.
	 */
	public function AddLibrary($value)
	{
		self::addToArray($this->libraries, $value);
	}

	/**
	 * Gets the names of built-in client-side libraries added to the page.
	 *
	 * @return An array of strings.
	 */
	public function GetLibraries()
	{
		return $this->libraries;
	}

	/**
	 * Adds user-defined client-side scripts to the page.
	 *
	 * @param string $value A string or list of strings separated by commas.
	 */
	public function AddScript($value)
	{
		self::addToArray($this->scripts, $value);
	}

	/**
	 * Gets the names of user-defined client-side scripts added to the page.
	 *
	 * @return An array of strings.
	 */
	public function GetScripts()
	{
		return $this->scripts;
	}

	/**
	 * Adds built-in dialog boxes to the page.
	 *
	 * @param string $value A string or list of strings separated by commas.
	 */
	public function AddDialog($value)
	{
		self::addToArray($this->dialogs, $value);
	}

	/**
	 * Gets the names of built-in dialog boxes added to the page.
	 *
	 * @return An array of strings.
	 */
	public function GetDialogs()
	{
		return $this->dialogs;
	}

	/**
	 * Sets the name of the master page.
	 */
	public function SetMasterpage($masterpage)
	{
		$this->masterpage = is_string($masterpage) ? $masterpage : '';
	}

	/**
	 * Gets the masterpage name.
	 *
	 * @return A string.
	 */
	public function GetMasterpage()
	{
		return $this->masterpage;
	}

	/**
	 * Starts capturing page contents.
	 */
	public function BeginContents()
	{
		ob_start();
	}

	/**
	 * Ends capturing page contents.
	 */
	public function EndContents()
	{
		$this->contents = ob_get_clean();
	}

	/**
	 * Gets the page contents.
	 *
	 * @return A string.
	 */
	public function GetContents()
	{
		return $this->contents;
	}

	/**
	 * Returns the full URL of the current page, including canonical query
	 * parameters, if any.
	 *
	 * @return The absolute URL of the page.
	 */
	public function GetCanonicalURL()
	{
		// Start with the full URL of the current page.
		$result = Server::GetBaseURL() . Server::GetPageFileName();
		// Obtain the query parameters string. Here, `false` tells the function
		// not to include the leading question mark (?).
		$query = Server::GetQueryString(false);
		// If not empty, process and append query string to the result.
		if ($query !== '') {
			// Split query parameters into an associative array.
			parse_str($query, $parameters);
			// Filter-out unofficial query parameters (e.g. fbclid is unwanted)
			foreach ($parameters as $name => $value)
				if ($name !== $this->canonicalQueryKey)
					unset($parameters[$name]);
			// Concatenate resulting query parameters with '&' and append to the
			// canonical URL.
			if (count($parameters)) {
				$query = http_build_query($parameters);
				$result .= '?' . $query;
			}
		}
		return $result;
	}

	/**
	 * Renders the page.
	 */
	public function Render()
	{
		echo "<!DOCTYPE html>\n";
		echo sprintf("<html lang=\"%s\">\n", Config::LANGUAGE);
		echo "\t<head>\n";
		echo "\t\t<meta charset=\"utf-8\"/>\n";
		$this->renderTitle();
		$this->renderMetaTags();
		echo "\t\t<link rel=\"shortcut icon\" href=\"favicon.ico\">\n";
		$this->renderStylesheetLinks();
		echo "\t</head>\n";
		echo "\t<body>\n";
		$this->renderContents();
		$this->renderDialogs();
		$this->renderJavascriptLinks();
		echo "\t</body>\n";
		echo "</html>";
	}

	/**
	 * Adds a string, or one more strings separated by commas, to an array.
	 *
	 * @param array $array Reference to an array to add to.
	 * @param string $value A string or list of strings separated by commas.
	 */
	private static function addToArray(&$array, $value)
	{
		if (!is_string($value))
			return;
		if (strpos($value, ',') === false)
			array_push($array, $value);
		else
			$array = array_merge($array, Helper::Split($value, ','));
	}

	/**
	 * Renders the title.
	 */
	private function renderTitle()
	{
		$title = $this->title;
		if ($title !== '')
			$title .= ' | ';
		$title .= Config::TITLE;
		echo sprintf("\t\t<title>%s</title>\n", $title);
	}

	/**
	 * Renders meta tags.
	 */
	private function renderMetaTags()
	{
		// Description and viewport meta tags.
		self::renderMetaTag('description', $this->description === '' ? Config::DESCRIPTION : $this->description);
		self::renderMetaTag('viewport', self::VIEWPORT_META_CONTENT);
		// Custom meta tags.
		foreach ($this->metas as $name => $content)
			self::renderMetaTag($name, $content);
		// Open Graph (social) meta tags.
		if (Config::FACEBOOK_APP_ID !== '')
			self::renderOgMetaTag('fb:app_id', Config::FACEBOOK_APP_ID);
		self::renderOgMetaTag('og:url', $this->GetCanonicalURL());
		self::renderOgMetaTag('og:title', $this->title === '' ? Config::TITLE : $this->title);
		self::renderOgMetaTag('og:description', $this->description === '' ? Config::DESCRIPTION : $this->description);
		self::renderOgMetaTag('og:image', $this->socialImageUrl === '' ? Config::GetLogoImageURL(true) : $this->socialImageUrl);
		self::renderOgMetaTag('og:type', 'website');
		self::renderOgMetaTag('og:locale', Config::LANGUAGE_EX);
	}

	/**
	 * Renders a `meta` tag with `name` and `content` attributes.
	 *
	 * @param string $name Value of the `name` attribute.
	 * @param string $content Value of the `content` attribute.
	 */
	private static function renderMetaTag($name, $content)
	{
		echo sprintf("\t\t<meta name=\"%s\" content=\"%s\"/>\n", $name, $content);
	}

	/**
	 * Renders a `meta` tag with `property` and `content` attributes.
	 *
	 * @param string $property Value of the `property` attribute.
	 * @param string $content Value of the `content` attribute.
	 */
	private static function renderOgMetaTag($property, $content)
	{
		echo sprintf("\t\t<meta property=\"%s\" content=\"%s\"/>\n", $property, $content);
	}

	/**
	 * Renders contents.
	 */
	private function renderContents()
	{
		if ($this->masterpage === '') {
			echo $this->contents;
		} else {
			$filename = sprintf('%s/%s.php', Config::GetMasterpageDirectory(), $this->masterpage);
			if (!is_file($filename)) {
				if (Config::LOG)
					Log::Warning(sprintf('Masterpage file not found: %s', $filename));
			} else {
				include $filename;
			}
		}
	}

	/**
	 * Renders built-in dialog boxes.
	 */
	private function renderDialogs()
	{
		foreach ($this->dialogs as $name) {
			$filename = sprintf('%s/%s.php', Config::GetDialogDirectory(), $name);
			if (!is_file($filename)) {
				if (Config::LOG)
					Log::Warning(sprintf('Dialog file not found: %s', $filename));
			} else {
				include $filename;
			}
		}
	}

	/**
	 * Renders links to Cascading Style Sheet (css) files.
	 */
	private function renderStylesheetLinks()
	{
		// First, core items...
		self::renderLibraryStylesheetLink('jquery-ui-1.12.1.custom/jquery-ui');
		self::renderLibraryStylesheetLink('bootstrap-3.3.7/css/bootstrap');
		self::renderLibraryStylesheetLink('fontAwesome-4.7.0/css/font-awesome');
		// Then, optionals...
		foreach ($this->libraries as $name) {
			switch ($name)
			{
			case 'MultiSelect':
				self::renderLibraryStylesheetLink('bootstrap-multiselect-0.9.15/css/bootstrap-multiselect');
				break;
			case 'DateInput':
				self::renderLibraryStylesheetLink('bootstrap-datepicker-1.6.4/css/bootstrap-datepicker3');
				break;
			case 'DateTimeInput':
				self::renderLibraryStylesheetLink('bootstrap-datetimepicker-4.17.47/css/bootstrap-datetimepicker');
				break;
			case 'Slider':
				self::renderLibraryStylesheetLink('ion.rangeSlider-2.2.0/css/ion.rangeSlider');
				self::renderLibraryStylesheetLink('ion.rangeSlider-2.2.0/css/ion.rangeSlider.skinFlat.mod');
				break;
			case 'VerticalTabs':
				self::renderLibraryStylesheetLink('bootstrap-vertical-tabs-1.2.2/bootstrap.vertical-tabs');
				break;
			case 'Rating':
				self::renderLibraryStylesheetLink('rateyo-2.3.3/jquery.rateyo');
				break;
			case 'Table':
				self::renderLibraryStylesheetLink('dataTables-1.10.15/core/css/dataTables.bootstrap');
				self::renderLibraryStylesheetLink('dataTables-1.10.15/extensions/Responsive/css/responsive.bootstrap');
				self::renderLibraryStylesheetLink('dataTables-1.10.15/plugins/searching/mark/datatables.mark.mod');
				break;
			case 'Table:Buttons':
				self::renderLibraryStylesheetLink('dataTables-1.10.15/extensions/Buttons/css/buttons.bootstrap');
				break;
			case 'Table:Checkboxes':
				self::renderLibraryStylesheetLink('dataTables-1.10.15/extensions/Checkboxes/css/dataTables.checkboxes');
				break;
			case 'Map':
				self::renderLibraryStylesheetLink('leaflet-1.2.0/leaflet');
				break;
			case 'Map:LocateControl':
				self::renderLibraryStylesheetLink('leaflet-1.2.0/plugins/LocateControl/L.Control.Locate');
				break;
			case 'Map:ContextMenu':
				self::renderLibraryStylesheetLink('leaflet-1.2.0/plugins/ContextMenu/leaflet.contextmenu');
				break;
			case 'Map:MarkerCluster':
				self::renderLibraryStylesheetLink('leaflet-1.2.0/plugins/MarkerCluster/MarkerCluster');
				self::renderLibraryStylesheetLink('leaflet-1.2.0/plugins/MarkerCluster/MarkerCluster.Default');
				break;
			}
		}
		// Finally...
		self::renderStylesheetLink('Daphne', Config::GetClientScriptDirectory());
		foreach ($this->scripts as $scriptName)
			self::renderStylesheetLink($scriptName, Config::GetClientScriptDirectory());
	}

	/**
	 * Renders a link to a Cascading Style Sheet (css) file from the client-side
	 * library.
	 *
	 * @param string $name The name of the file, without the `css` extension.
	 */
	private static function renderLibraryStylesheetLink($name)
	{
		self::renderStylesheetLink($name, Config::GetClientLibraryDirectory());
	}

	/**
	 * Renders a link to a Cascading Style Sheet (css) file.
	 *
	 * @param string $name The name of the file, without the `css` extension.
	 * @param string $directory Path to the directory where the file is located.
	 */
	private static function renderStylesheetLink($name, $directory)
	{
		if (!Config::DEBUG) $name .= '.min';
		$filename = sprintf('%s/%s.css', $directory, $name);
		if (!is_file($filename)) {
			if (Config::LOG)
				Log::Warning(sprintf('Stylesheet file not found: %s', $filename));
			return;
		}
		echo sprintf("\t\t<link rel=\"stylesheet\" href=\"%s?v=%d\">\n",
			$filename, Config::CLIENT_SCRIPT_VERSION);
	}

	/**
	 * Renders links to JavaScript (js) files.
	 */
	private function renderJavascriptLinks()
	{
		// First, shims...
		echo "\t\t<!--[if lt IE 9]>\n";
		self::renderLibraryJavascriptLink('html5shiv-3.7.3/html5shiv');
		self::renderLibraryJavascriptLink('respond-1.4.2/respond');
		echo "\t\t<![endif]-->\n";
		// Secondly, core items...
		self::renderLibraryJavascriptLink('jquery-3.2.1/jquery');
		self::renderLibraryJavascriptLink('jquery-ui-1.12.1.custom/jquery-ui');
		self::renderLibraryJavascriptLink('bootstrap-3.3.7/js/bootstrap');
		// Then, optionals...
		foreach ($this->libraries as $name) {
			switch ($name)
			{
			case 'FacebookSDK':
				if (Config::DEBUG) break; // Not available in the debug mode.
				echo sprintf("\t\t<div id='fb-root'></div><script id='facebook-jssdk' src='https://connect.facebook.net/%s/sdk.js#xfbml=1&version=v3.2&appId=%s'></script>\n",
					Config::LANGUAGE_EX, Config::FACEBOOK_APP_ID);
				break;
			case 'GoogleAnalytics':
				if (Config::DEBUG) break; // Not available in the debug mode.
				echo sprintf("\t\t<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');ga('create','%s','auto');ga('send','pageview');</script>\n",
					Config::GOOGLE_ANALYTICS_TRACKING_ID);
				break;
			case 'MultiSelect':
				self::renderLibraryJavascriptLink('bootstrap-multiselect-0.9.15/js/bootstrap-multiselect');
				break;
			case 'FileInput':
				self::renderLibraryJavascriptLink('bootstrap-filestyle-1.2.3/bootstrap-filestyle');
				break;
			case 'DateInput':
				self::renderLibraryJavascriptLink('bootstrap-datepicker-1.6.4/js/bootstrap-datepicker');
				self::renderLibraryJavascriptLink('bootstrap-datepicker-1.6.4/locales/bootstrap-datepicker.tr');
				break;
			case 'DateTimeInput':
				self::renderLibraryJavascriptLink('moment-2.18.1/moment-with-locales'); // dependency
				self::renderLibraryJavascriptLink('bootstrap-datetimepicker-4.17.47/js/bootstrap-datetimepicker');
				break;
			case 'Slider':
				self::renderLibraryJavascriptLink('ion.rangeSlider-2.2.0/js/ion.rangeSlider');
				break;
			case 'Autocomplete':
				self::renderLibraryJavascriptLink('bootstrap3-typeahead-4.0.2/bootstrap3-typeahead');
				break;
			case 'Flip':
				self::renderLibraryJavascriptLink('jquery.flip-1.1.2/jquery.flip');
				break;
			case 'Rating':
				self::renderLibraryJavascriptLink('rateyo-2.3.3/jquery.rateyo');
				break;
			case 'Table':
				self::renderLibraryJavascriptLink('dataTables-1.10.15/core/js/jquery.dataTables.mod');
				self::renderLibraryJavascriptLink('dataTables-1.10.15/core/js/dataTables.bootstrap');
				self::renderLibraryJavascriptLink('dataTables-1.10.15/extensions/Responsive/js/dataTables.responsive');
				self::renderLibraryJavascriptLink('dataTables-1.10.15/extensions/Responsive/js/responsive.bootstrap');
				self::renderLibraryJavascriptLink('dataTables-1.10.15/plugins/searching/mark/jquery.mark.mod');
				self::renderLibraryJavascriptLink('dataTables-1.10.15/plugins/searching/mark/datatables.mark');
				break;
			case 'Table:Buttons':
				self::renderLibraryJavascriptLink('dataTables-1.10.15/extensions/Buttons/js/dataTables.buttons');
				self::renderLibraryJavascriptLink('dataTables-1.10.15/extensions/Buttons/js/buttons.bootstrap');
				break;
			case 'Table:Buttons:Excel':
				self::renderLibraryJavascriptLink('jszip-3.1.3/jszip'); // dependency
				self::renderLibraryJavascriptLink('dataTables-1.10.15/extensions/Buttons/js/buttons.html5');
				break;
			case 'Table:Buttons:ColVis':
				self::renderLibraryJavascriptLink('dataTables-1.10.15/extensions/Buttons/js/buttons.colVis');
				break;
			case 'Table:Checkboxes':
				self::renderLibraryJavascriptLink('dataTables-1.10.15/extensions/Checkboxes/js/dataTables.checkboxes');
				break;
			case 'Table:TurkishDate':
				self::renderLibraryJavascriptLink('dataTables-1.10.15/plugins/sorting/date-turkish');
				break;
			case 'Table:TurkishDateTime':
				self::renderLibraryJavascriptLink('dataTables-1.10.15/plugins/sorting/datetime-turkish');
				break;
			case 'Table:TurkishString':
				self::renderLibraryJavascriptLink('dataTables-1.10.15/plugins/sorting/string-turkish');
				break;
			case 'Table:RowsGroup':
				self::renderLibraryJavascriptLink('dataTables-1.10.15/plugins/rowsGroup/dataTables.rowsGroup');
				break;
			case 'Table:Processing':
				self::renderLibraryJavascriptLink('dataTables-1.10.15/plugins/processing/processing');
				break;
			case 'Form':
				self::renderLibraryJavascriptLink('bootstrap-validator-0.11.9/validator');
				break;
			case 'Map':
				self::renderLibraryJavascriptLink('leaflet-1.2.0/leaflet');
				break;
			case 'Map:LocateControl':
				self::renderLibraryJavascriptLink('leaflet-1.2.0/plugins/LocateControl/L.Control.Locate');
				break;
			case 'Map:ContextMenu':
				self::renderLibraryJavascriptLink('leaflet-1.2.0/plugins/ContextMenu/leaflet.contextmenu');
				break;
			case 'Map:MarkerCluster':
				self::renderLibraryJavascriptLink('leaflet-1.2.0/plugins/MarkerCluster/leaflet.markercluster');
				break;
			// ----------------------------------------------------------------
			// SheetJS (https://sheetjs.com/)
			//
			// There are 3 minified source files:
			//
			// xlsx.min.js is the minified version of this library.
			// xlsx.core.min.js includes dependencies .
			// xlsx.full.min.js also includes optional modules.
			//
			// XLSX, XLSB and ODS support requires a zip reader/writer. The
			// default xlsx.min.js does not include it, so you have to include
			// jszip.js before xlsx.min.js. However, both xlsx.core.min.js and
			// xlsx.full.min.js embed the zip library in the source, so you can
			// use one of those as your only include.
			//
			// The full file also includes a codepage library that allows you
			// to read international files generated by older versions of Excel
			// as well as some third party libraries. It is a pretty hefty
			// dependency and isn't necessary for a strictly English US based
			// audience, so it's not included in the core distribution.
			//
			// Warning: Non minified versions of xlsx.core and xlsx.full do not
			// exist.
			// ----------------------------------------------------------------
			case 'Excel:XSL':
				self::renderLibraryJavascriptLink('js-xlsx-0.11.3/xlsx');
				break;
			case 'Excel:XLSX': // jszip-3.1.3 is not compatiple, xlsx.core embeds an older working version.
				self::renderLibraryJavascriptLink('js-xlsx-0.11.3/xlsx.core');
				break;
			case 'Excel':
				self::renderLibraryJavascriptLink('js-xlsx-0.11.3/xlsx.full');
				break;
			// ----------------------------------------------------------------
			// JsDiff (https://cdnjs.com/libraries/jsdiff)
			// ----------------------------------------------------------------
			case 'Diff':
				self::renderLibraryJavascriptLink('jsdiff-3.5.0/diff');
				break;
			// ----------------------------------------------------------------
			// Postscribe (https://github.com/krux/postscribe)
			// ----------------------------------------------------------------
			case 'Postscribe':
				self::renderLibraryJavascriptLink('postscribe-2.0.8/postscribe');
				break;
			// ----------------------------------------------------------------
			// TimeAgo (https://github.com/rmm5t/jquery-timeago)
			// ----------------------------------------------------------------
			case 'TimeAgo':
				self::renderLibraryJavascriptLink('jquery-timeago-1.6.3/jquery.timeago');
				self::renderLibraryJavascriptLink(sprintf('jquery-timeago-1.6.3/locales/jquery.timeago.%s', Config::LANGUAGE));
				break;
			}
		}
		// Finally...
		self::renderJavascriptLink('Daphne', Config::GetClientScriptDirectory());
		foreach ($this->scripts as $scriptName)
			self::renderJavascriptLink($scriptName, Config::GetClientScriptDirectory());
	}

	/**
	 * Renders a link to a JavaScript (js) file from the client-side library.
	 *
	 * @param string $name The name of the file, without the `js` extension.
	 */
	private static function renderLibraryJavascriptLink($name)
	{
		self::renderJavascriptLink($name, Config::GetClientLibraryDirectory());
	}

	/**
	 * Renders a link to a JavaScript (js) file.
	 *
	 * @param string $name The name of the file, without the `js` extension.
	 * @param string $directory Path to the directory where the file is located.
	 */
	private static function renderJavascriptLink($name, $directory)
	{
		if (!Config::DEBUG) $name .= '.min';
		$filename = sprintf('%s/%s.js', $directory, $name);
		if (!is_file($filename)) {
			if (Config::LOG)
				Log::Warning(sprintf('Javascript file not found: %s', $filename));
			return;
		}
		echo sprintf("\t\t<script type=\"text/javascript\" src=\"%s?v=%d\"></script>\n",
			$filename, Config::CLIENT_SCRIPT_VERSION);
	}
}
?>
