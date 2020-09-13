<?php
/**
 * @file Disqus.php
 * Contains the `Disqus` class.
 *
 * @version 1.0
 * @date    September 13, 2020 (8:52)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2020 Eylem Ugurel. All rights reserved.
 */

namespace UI;

/**
 * Represents a Disqus plugin.
 *
 * Example of a rendered code:
 *
 *     <div id="disqus_thread"><script>var disqus_config=function(){this.page.url="https://example.com/index.php",this.page.identifier="index.php"};</script></div>
 *
 * If the application is in the debug mode, the plugin is not displayed, instead
 * a warning text is rendered, such as:
 *
 *     <span class="text-warning">Disqus plugin is not available in the debug mode.</span>
 *
 * @note This element requires the `Disqus` library to be added to the page
 * object. This can be done through the `Core::Page::AddLibrary` method. The
 * `Core::Config::DISQUS_SHORTNAME` variable must also contain a valid value.
 *
 * @see https://disqus.com/
 */
class Disqus extends Element
{
	/**
	 * @brief Text to render in the debug mode.
	 */
	const DEBUG_MODE_TEXT = 'Disqus plugin is not available in the debug mode.';

	/**
	 * @brief Javascipt code template of the configuration variables object.
	 */
	const CONFIG_SCRIPT_F = 'var disqus_config=function(){this.page.url="%s",this.page.identifier="%s"};';

	/**
	 * The URL.
	 */
	private $url = '';

	/**
	 * @brief Constructor.
	 */
	public function __construct()
	{
		if (\Core\Config::DEBUG) {
			parent::__construct('span');
			$this->AddClass('text-warning');
			$this->SetChild(self::DEBUG_MODE_TEXT);
		} else {
			parent::__construct('div');
			$this->SetId('disqus_thread');
		}
	}

	/**
	 * @brief Sets the URL.
	 *
	 * @param $value The absolute URL that comments posted in the plugin will be
	 * permanently associated with.
	 * @return This instance.
	 */
	public function SetUrl($value)
	{
		$this->url = $value;
		return $this;
	}

	/**
	 * @copydoc Element::Render
	 */
	public function Render()
	{
		if (!\Core\Config::DEBUG)
		{
			$this->RemoveChildren();
			// There are two variables in the config object. The first one is
			// the canonical page url, and the second one is a unique identifier.
			// Here we decided to use the file name portion of the url (including
			// any query parameters) as the identifier (e.g. song.php?id=123).
			$this->AddChild(new Script(
				sprintf(self::CONFIG_SCRIPT_F, $this->url, basename($this->url))
			));
		}
		parent::Render();
	}
}
?>
