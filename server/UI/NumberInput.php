<?php
/**
 * @file NumberInput.php
 * Contains the `NumberInput` class.
 *
 * @version 1.0
 * @date    November 16, 2019 (12:55)
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
 * Represents a number input element.
 */
class NumberInput extends Input
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('number');
		$this->AddClass('form-control');
	}

	/**
	 * Sets the `min` attribute.
	 *
	 * @param int $value The minimum value to accept.
	 * @return This instance.
	 */
	public function SetMin($value)
	{
		$this->SetAttribute('min', $value);
		return $this;
	}

	/**
	 * Sets the `max` attribute.
	 *
	 * @param int $value The maximum value to accept.
	 * @return This instance.
	 */
	public function SetMax($value)
	{
		$this->SetAttribute('max', $value);
		return $this;
	}

	/**
	 * Sets the `step` attribute.
	 *
	 * @param int $value A stepping interval to use when using up and down
	 * arrows to adjust the value. A string value of 'any' means that no
	 * stepping is implied.
	 * @return This instance.
	 */
	public function SetStep($value)
	{
		$this->SetAttribute('step', $value);
		return $this;
	}
}
?>
