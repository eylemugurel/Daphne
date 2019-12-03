<?php
/**
 * @file InputGroup.php
 * Contains the `InputGroup` class.
 *
 * @version 1.0
 * @date    October 12, 2019 (6:30)
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
 * Represents a Bootstrap 'input-group' division.
 *
 * @see https://getbootstrap.com/docs/3.3/components/#input-groups
 */
class InputGroup extends Division
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('input-group');
	}
}
?>
