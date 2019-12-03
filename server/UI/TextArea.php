<?php
/**
 * @file TextArea.php
 * Contains the `TextArea` class.
 *
 * @version 1.1
 * @date    October 20, 2019 (14:05)
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
 * Represents a textarea element.
 */
class TextArea extends Element
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('textarea');
		$this->AddClass('form-control');
		$this->SetAttribute('spellcheck', 'false');
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
	 * Sets the `rows` attribute.
	 *
	 * @param int $value The number of rows.
	 * @return This instance.
	 */
	public function SetRowCount($value)
	{
		$this->SetAttribute('rows', $value);
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
}
?>
