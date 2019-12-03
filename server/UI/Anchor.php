<?php
/**
 * @file Anchor.php
 * Contains the `Anchor` class.
 *
 * @version 1.0
 * @date    October 18, 2019 (3:38)
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
 * Represents an anchor element.
 */
class Anchor extends Element
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('a');
	}

	/**
	 * Sets the content.
	 *
	 * @param $value A string or an Element object.
	 * @return This instance.
	 */
	public function SetContent($value)
	{
		$this->SetChild($value);
		return $this;
	}

	/**
	 * Sets the `href` attribute.
	 *
	 * @param $value The URL that the hyperlink points to.
	 * @return This instance.
	 */
	public function SetUrl($value)
	{
		$this->SetAttribute('href', $value);
		return $this;
	}
}
?>
