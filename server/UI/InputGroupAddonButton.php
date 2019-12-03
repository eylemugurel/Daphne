<?php
/**
 * @file InputGroupAddonButton.php
 * Contains the `InputGroupAddonButton` class.
 *
 * @version 1.0
 * @date    October 15, 2019 (5:14)
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
 * Represents a Bootstrap 'input-group-btn' span.
 */
class InputGroupAddonButton extends Span
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('input-group-btn');
	}
}
?>
