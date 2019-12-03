<?php
/**
 * @file Input.php
 * Contains the `Input` class.
 *
 * @version 1.3
 * @date    October 18, 2019 (4:43)
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
 * Represents an input element.
 */
class Input extends Element
{
	/**
	 * Constructor.
	 *
	 * @param string $type Value of the `type` attribute.
	 *
	 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input#Form_%3Cinput%3E_types
	 */
	public function __construct($type)
	{
		parent::__construct('input', true);
		$this->SetAttribute('type', $type);
	}

	/**
	 * Sets the `name` attribute.
	 *
	 * @param string $value A name.
	 * @return This instance.
	 */
	public function SetName($value)
	{
		$this->SetAttribute('name', $value);
		return $this;
	}

	/**
	 * Gets the `name` attribute.
	 *
	 * @return The value of the `name` attribute if it exists; otherwise, `null`.
	 */
	public function GetName()
	{
		return $this->GetAttribute('name');
	}

	/**
	 * Sets the `value` attribute.
	 *
	 * @param string $value A value.
	 * @return This instance.
	 */
	public function SetValue($value)
	{
		$this->SetAttribute('value', $value);
		return $this;
	}

	/**
	 * Gets the `value` attribute.
	 *
	 * @return The value of the `value` attribute if it exists; otherwise, `null`.
	 */
	public function GetValue()
	{
		return $this->GetAttribute('value');
	}

	/**
	 * Sets or removes the `disabled` attribute.
	 *
	 * @param bool $value The disabled state.
	 * @return This instance.
	 */
	public function SetDisabled($value =true)
	{
		if ($value === true)
			$this->SetAttribute('disabled');
		else
			$this->RemoveAttribute('disabled');
		return $this;
	}

	/**
	 * Sets or removes the `required` attribute.
	 *
	 * @param bool $value The required state.
	 * @return This instance.
	 */
	public function SetRequired($value =true)
	{
		if ($value === true)
			$this->SetAttribute('required');
		else
			$this->RemoveAttribute('required');
		return $this;
	}

	/**
	 * Sets or removes the `readonly` attribute.
	 *
	 * @param bool $value The read-only state.
	 * @return This instance.
	 */
	public function SetReadonly($value =true)
	{
		if ($value === true)
			$this->SetAttribute('readonly');
		else
			$this->RemoveAttribute('readonly');
		return $this;
	}
}
?>
