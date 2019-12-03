<?php
/**
 * @file Label.php
 * Contains the `Label` class.
 *
 * @version 1.0
 * @date    October 12, 2019 (6:09)
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
 * Represents a label element.
 */
class Label extends Element
{
	/**
	 * Constructor.
	 *
	 * @param $content (optional) A string or an Element object.
	 */
	public function __construct($content =null)
	{
		parent::__construct('label');
		if ($content !== null)
			$this->SetContent($content);
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
}
?>
