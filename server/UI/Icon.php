<?php
/**
 * @file Icon.php
 * Contains the `Icon` class.
 *
 * @version 1.1
 * @date    October 12, 2019 (6:05)
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
 * Represents an icon element.
 */
class Icon extends Element
{
	/**
	 * Constructor.
	 *
	 * @param string $name The name of an icon from Glyphicon or Font Awesome
	 * icon sets, such as 'glyphicon-lock', 'fa-pencil', etc.
	 *
	 * @see https://getbootstrap.com/docs/3.3/components/#glyphicons
	 * @see https://fontawesome.com/v4.7.0/icons/
	 */
	public function __construct($name)
	{
		parent::__construct('i');
		// Find the position of first dash (-) character in $name. If found,
		// use the string up to the dash as the icon class. For example, if
		// 'fa-play' is specified, sets the class to 'fa fa-play'.
		$pos = strpos($name, '-');
		if ($pos !== false)
			$this->AddClass(sprintf('%s %s', substr($name, 0, $pos), $name));
	}
}
?>
