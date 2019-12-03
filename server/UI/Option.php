<?php
/**
 * @file Option.php
 * Contains the `Option` class.
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
 * Represents an option element.
 */
class Option extends Element
{
	/**
	 * Constructor.
	 *
	 * @param string $key Represents the `value` attribute.
	 * @param string $value Represents the content.
	 */
	public function __construct($key, $value)
	{
		parent::__construct('option');
		$this->AddAttribute('value', $key);
		$this->SetChild($value);
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
	 * Sets or removes the `selected` attribute.
	 *
	 * @param bool $value The selected state.
	 * @return This instance.
	 */
	public function SetSelected($value =true)
	{
		if ($value === true)
			$this->SetAttribute('selected');
		else
			$this->RemoveAttribute('selected');
		return $this;
	}
}
?>