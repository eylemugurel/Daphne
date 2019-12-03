<?php
/**
 * @file SubmitButton.php
 * Contains the `SubmitButton` class.
 *
 * @version 1.1
 * @date    October 26, 2019 (10:23)
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
 * Represents a submit button element.
 */
class SubmitButton extends Button
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('submit');
		$this->AddClass('form-control');
		$this->SetAttribute('data-loading-text', self::DEFAULT_LOADING_TEXT);
	}
}
?>
