<?php
/**
 * @file Select.php
 * Contains the `Select` class.
 *
 * @version 1.0
 * @date    December 1, 2019 (12:57)
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
 * Represents a select (combo box) element.
 */
class Select extends Element
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('select');
		$this->AddClass('form-control');
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
	 * Sets or removes the `multiple` attribute.
	 *
	 * @param bool $value The multiple state.
	 * @return This instance.
	 */
	public function SetMultiple($value =true)
	{
		if ($value === true)
			$this->SetAttribute('multiple');
		else
			$this->RemoveAttribute('multiple');
		return $this;
	}

	/**
	 * Adds a new option.
	 *
	 * @param string $key The key of the option.
	 * @param string $value The value of the option.
	 * @return This instance.
	 */
	public function AddOption($key, $value)
	{
		$this->AddChild(new Option($key, $value));
		return $this;
	}
}
?>