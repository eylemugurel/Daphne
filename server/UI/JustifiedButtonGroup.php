<?php
/**
 * @file JustifiedButtonGroup.php
 * Contains the `JustifiedButtonGroup` class.
 *
 * @version 1.0
 * @date    October 20, 2019 (6:55)
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
 * Represents a Bootstrap 'btn-group btn-group-justified' division.
 *
 * @see https://getbootstrap.com/docs/3.3/components/#btn-groups-justified
 *
 * @todo Extend from ButtonGroup
 */
class JustifiedButtonGroup extends Division
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('btn-group btn-group-justified');
	}

	/**
	 * Adds a button.
	 *
	 * @param object $button A button element.
	 * @return This instance.
	 */
	public function AddButton($button)
	{
		$this->AddChild((new ButtonGroup)
			->AddChild($button)
		);
		return $this;
	}
}
?>
