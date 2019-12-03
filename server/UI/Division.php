<?php
/**
 * @file Division.php
 * Contains the `Division` class.
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
 * Represents a div element.
 */
class Division extends Element
{
	/**
	 * Constructor.
	 *
	 * @param string $class (optional) Value of the `class` attribute.
	 */
	public function __construct($class ='')
	{
		parent::__construct('div');
		if ($class !== '')
			$this->AddClass($class);
	}
}
?>
