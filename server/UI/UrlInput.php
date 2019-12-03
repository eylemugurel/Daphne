<?php
/**
 * @file UrlInput.php
 * Contains the `UrlInput` class.
 *
 * @version 1.0
 * @date    October 12, 2019 (17:30)
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
 * Represents a URL input element.
 */
class UrlInput extends Input
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('url');
		$this->AddClass('form-control');
		$this->SetAttribute('spellcheck', 'false');
	}
}
?>
