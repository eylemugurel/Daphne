<?php
/**
 * @file EmailInput.php
 * Contains the `EmailInput` class.
 *
 * @version 1.0
 * @date    September 10, 2019 (5:48)
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
 * Represents an email input element.
 */
class EmailInput extends Input
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('email');
		$this->AddClass('form-control');
		$this->SetAttribute('spellcheck', 'false');
	}
}
?>
