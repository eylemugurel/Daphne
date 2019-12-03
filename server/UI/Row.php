<?php
/**
 * @file Row.php
 * Contains the `Row` class.
 *
 * @version 1.0
 * @date    October 18, 2019 (19:53)
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
 * Represents a Bootstrap 'row' division.
 */
class Row extends Division
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('row');
	}
}
?>
