<?php
/**
 * @file TableHead.php
 * Contains the `TableHead` class.
 *
 * @version 1.1
 * @date    December 14, 2019 (16:42)
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
 * Represents a table head element.
 */
class TableHead extends Element
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('thead');
	}
}
?>