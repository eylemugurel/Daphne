<?php
/**
 * @file PasswordInput.php
 * Contains the `PasswordInput` class.
 *
 * @version 1.1
 * @date    November 2, 2019 (8:14)
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
 * Represents a password input element.
 */
class PasswordInput extends Input
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('password');
		$this->AddClass('form-control');
		$this->SetAttribute('minlength', \Core\Config::MIN_PASSWORD_LENGTH);
		$this->SetAttribute('maxlength', \Core\Password::MAX_LENGTH);
	}

	/**
	 * Sets the `minlength` attribute.
	 *
	 * @param int $value Minimum number of characters allowed.
	 * @return This instance.
	 */
	public function SetMinLength($value)
	{
		$this->SetAttribute('minlength', $value);
		return $this;
	}
}
?>
