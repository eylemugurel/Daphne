<?php
/**
 * @file TextInput.php
 * Contains the `TextInput` class.
 *
 * @version 1.0
 * @date    September 8, 2019 (11:09)
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
 * Represents a text input element.
 */
class TextInput extends Input
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('text');
		$this->AddClass('form-control');
		$this->SetAttribute('spellcheck', 'false');
	}

	/**
	 * Sets the `pattern` attribute.
	 *
	 * @param string $value A regular expression pattern that the input value
	 * is checked against on form submission.
	 * @return This instance.
	 */
	public function SetPattern($value)
	{
		$this->SetAttribute('pattern', $value);
		return $this;
	}
}
?>
