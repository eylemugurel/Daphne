<?php
/**
 * @file HiddenInput.php
 * Contains the `HiddenInput` class.
 *
 * @version 1.0
 * @date    October 6, 2019 (8:00)
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
 * Represents an hidden input element.
 */
class HiddenInput extends Input
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('hidden');
	}
}
?>
