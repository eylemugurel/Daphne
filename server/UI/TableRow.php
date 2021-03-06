<?php
/**
 * @file TableRow.php
 * Contains the `TableRow` class.
 *
 * @version 1.0
 * @date    November 30, 2019 (7:35)
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
 * Represents a table row element.
 */
class TableRow extends Element
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('tr');
	}
}
?>