<?php
/**
 * @file Script.php
 * Contains the `Script` class.
 *
 * @version 1.0
 * @date    September 13, 2020 (10:09)
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
 * Represents a script element.
 */
class Script extends Element
{
	/**
	 * Constructor.
	 *
	 * @param $content (optional) A string containing script code.
	 */
	public function __construct($content =null)
	{
		parent::__construct('script');
		if ($content !== null)
			$this->SetChild($content);
	}
}
?>
