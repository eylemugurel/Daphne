<?php
/**
 * @file FormGroup.php
 * Contains the `FormGroup` class.
 *
 * @version 2.2
 * @date    October 17, 2019 (4:30)
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
 * Represents a Bootstrap 'form-group' division.
 *
 * Example of a rendered code:
 *
 *     <div class="form-group">
 *         <label>Username</label>
 *         <div class="input-group">
 *             <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
 *             <input class="form-control" name="Username" pattern="\w+" required spellcheck="false" type="text">
 *         </div>
 *         <div class="help-block with-errors"></div>
 *     </div>
 */
class FormGroup extends Division
{
	/**
	 * The content of the label element.
	 */
	private $labelContent = null;

	/**
	 * The input element.
	 */
	private $input = null;

	/**
	 * The add-on icon name.
	 */
	private $addonIconName = '';

	/**
	 * The add-on button element.
	 */
	private $addonButton = null;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('form-group');
	}

	/**
	 * Sets the label.
	 *
	 * @param $value A string or an Element object.
	 * @return This instance.
	 */
	public function SetLabel($value)
	{
		$this->labelContent = $value;
		return $this;
	}

	/**
	 * Sets the input element.
	 *
	 * @param object $value An Element object.
	 * @return This instance.
	 */
	public function SetInput($value)
	{
		$this->input = $value;
		return $this;
	}

	/**
	 * Sets the add-on icon.
	 *
	 * @param string $value The name of an icon from Glyphicon or Font Awesome
	 * icon sets, such as 'glyphicon-lock', 'fa-pencil', etc.
	 * @return This instance.
	 */
	public function SetAddonIcon($value)
	{
		$this->addonIconName = $value;
		return $this;
	}

	/**
	 * Sets the add-on button element.
	 *
	 * @param $value A Button object.
	 * @return This instance.
	 */
	public function SetAddonButton($value)
	{
		$this->addonButton = $value;
		return $this;
	}

	/**
	 * @copydoc Element::Render
	 */
	public function Render()
	{
		$this->RemoveChildren();
		if ($this->labelContent !== null) {
			$label = new Label($this->labelContent);
			if ($this->input !== null) {
				$inputId = $this->input->GetId();
				if ($inputId !== null)
					$label->SetAttribute('for', $inputId);
			}
			$this->AddChild($label);
		}
		if ($this->input !== null) {
			if ($this->addonIconName !== '' || $this->addonButton !== null) {
				$inputGroup = new InputGroup;
				if ($this->addonIconName !== '')
					$inputGroup->AddChild((new InputGroupAddon)
						->AddChild(new Icon($this->addonIconName)));
				$inputGroup->AddChild($this->input);
				if ($this->addonButton !== null)
					$inputGroup->AddChild((new InputGroupAddonButton)
						->AddChild($this->addonButton));
				$this->AddChild($inputGroup);
			} else {
				$this->AddChild($this->input);
			}
		}
		$this->AddChild(new Division('help-block with-errors'));
		parent::Render();
	}
}
?>
