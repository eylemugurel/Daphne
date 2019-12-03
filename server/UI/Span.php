<?php
/**
 * @file Span.php
 * Contains the `Span` class.
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
 * Represents a span element.
 */
class Span extends Element
{
	/**
	 * Constructor.
	 *
	 * @param string $class (optional) Value of the `class` attribute.
	 */
	public function __construct($class ='')
	{
		parent::__construct('span');
		if ($class !== '')
			$this->AddClass($class);
	}
}
?>
