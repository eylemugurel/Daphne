<?php
/**
 * @file FacebookComments.php
 * Contains the `FacebookComments` class.
 *
 * @version 1.0
 * @date    October 12, 2019 (7:16)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

namespace UI;

/**
 * Represents a Facebook Comments Plugin.
 *
 * Example of a rendered code:
 *
 *     <div class="fb-comments" data-href="http://example.com" data-width="100%" data-order-by="reverse_time" data-colorscheme="dark"></div>
 *
 * If the application is in the debug mode, the plugin is not displayed, instead
 * a warning text is rendered, such as:
 *
 *     <span class="text-warning">Facebook Comments Plugin is not available in the debug mode.</span>
 *
 * @note This element requires the `FacebookSDK` library to be added to the
 * page object. This can be done through the `Core::Page::AddLibrary` method.
 * The `Core::Config::FACEBOOK_APP_ID` variable must also contain a valid value.
 *
 * @see https://developers.facebook.com/docs/plugins/comments/
 */
class FacebookComments extends Element
{
	/**
	 * @brief Text to render in the debug mode.
	 */
	const DEBUG_MODE_TEXT = 'Facebook Comments Plugin is not available in the debug mode.';

	/**
	 * @brief The default order to use when displaying comments.
	 *
	 * This setting can be overriden by the `#SetOrderBy` method.
	 */
	const DEFAULT_ORDER_BY = 'reverse_time';

	/**
	 * @brief Constructor.
	 *
	 * Initializes the plugin with `data-width` attribute set to `"100%"` and
	 * `data-order-by` property set to the value of `#DEFAULT_ORDER_BY`.
	 */
	public function __construct()
	{
		if (\Core\Config::DEBUG) {
			parent::__construct('span');
			$this->AddClass('text-warning');
			$this->SetChild(self::DEBUG_MODE_TEXT);
		} else {
			parent::__construct('div');
			$this->AddClass('fb-comments');
			$this->SetAttribute('data-width', '100%');
			$this->SetAttribute('data-order-by', self::DEFAULT_ORDER_BY);
		}
	}

	/**
	 * @brief Sets the `data-href` attribute.
	 *
	 * @param $value The absolute URL that comments posted in the plugin will be
	 * permanently associated with.
	 * @return This instance.
	 *
	 * @remark This method has no effect if the application is in the debug mode.
	 */
	public function SetUrl($value)
	{
		if (!\Core\Config::DEBUG)
			$this->SetAttribute('data-href', $value);
		return $this;
	}

	/**
	 * @brief Sets the `data-order-by` attribute.
	 *
	 * @param string $value The order to use when displaying comments. Can be
	 * 'social' (Top), 'reverse_time' (Newest), or 'time' (Oldest). If not set,
	 * the default value is `#DEFAULT_ORDER_BY`.
	 * @return This instance.
	 *
	 * @remark This method has no effect if the application is in the debug mode.
	 */
	public function SetOrderBy($value)
	{
		if (!\Core\Config::DEBUG)
			$this->SetAttribute('data-order-by', $value);
		return $this;
	}

	/**
	 * @brief Sets the `data-colorscheme` attribute.
	 *
	 * @param string $value The color scheme used by the comments plugin. Can be
	 * 'light' or 'dark'. If not set, the default value is 'light'.
	 * @return This instance.
	 *
	 * @remark This method has no effect if the application is in the debug mode.
	 */
	public function SetColorScheme($value)
	{
		if (!\Core\Config::DEBUG)
			$this->SetAttribute('data-colorscheme', $value);
		return $this;
	}
}
?>
