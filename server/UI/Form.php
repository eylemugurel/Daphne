<?php
/**
 * @file Form.php
 * Contains the `Form` class.
 *
 * @version 1.1
 * @date    October 18, 2019 (20:48)
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
 * Represents a form element.
 */
class Form extends Element
{
	/**
	 * Constructor.
	 */
	public function __construct($id ='')
	{
		parent::__construct('form');
		$this->SetAttribute('autocomplete', 'off');
		if ($id !== '')
			$this->SetId($id);
	}
}
?>
