<?php
/**
 * @file ToggleButton.php
 * Contains the `ToggleButton` class.
 *
 * @version 1.0
 * @date    October 5, 2019 (5:06)
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
 * Represents a toggle button element.
 */
class ToggleButton extends Button
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->SetAttribute('data-toggle', 'button');
		$this->SetAttribute('aria-pressed', 'false');
	}

	/**
	 * Sets whether the toggle button is pressed or not.
	 *
	 * @param bool $value The pressed state.
	 * @return This instance.
	 */
	public function SetPressed($value =true)
	{
		$this->RemoveClass('active');
		if ($value === true) {
			$this->AddClass('active');
			$this->SetAttribute('aria-pressed', 'true');
		} else {
			$this->SetAttribute('aria-pressed', 'false');
		}
		return $this;
	}
}
?>
