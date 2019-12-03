<?php
/**
 * @file ButtonGroup.php
 * Contains the `ButtonGroup` class.
 *
 * @version 1.0
 * @date    October 20, 2019 (6:55)
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
 * Represents a Bootstrap 'btn-group' division.
 *
 * @see https://getbootstrap.com/docs/3.3/components/#btn-groups
 */
class ButtonGroup extends Division
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('btn-group');
	}
}
?>
