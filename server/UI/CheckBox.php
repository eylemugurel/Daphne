<?php
/**
 * @file CheckBox.php
 * Contains the `CheckBox` class.
 *
 * @version 1.0
 * @date    December 20, 2019 (3:41)
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
 * Represents a Bootstrap checkbox element.
 *
 * Example of a rendered code:
 *
 *     <div class="checkbox">
 *         <label>
 *             <input type="checkbox"/>Create shortcut on the Desktop
 *         </label>
 *     </div>
 *
 * @see https://getbootstrap.com/docs/3.3/css/#checkboxes-and-radios
 */
class CheckBox extends Division
{
    /**
     * The input element with `checkbox` type.
     */
    private $input = null;

    /**
     * The text of the label element.
     */
    private $labelText = '';

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct('checkbox');
        $this->input = new Input('checkbox');
    }

    /**
     * Sets the `id` attribute of the input element.
     *
     * @param string $value An identifier.
     * @return This instance.
     */
    public function SetId($value)
    {
        $this->input->SetId($value);
        return $this;
    }

    /**
     * Sets the `name` attribute of the input element.
     *
     * @param string $value A name.
     * @return This instance.
     */
    public function SetName($value)
    {
        $this->input->SetName($value);
        return $this;
    }

    /**
     * Sets the label.
     *
     * @param string $value A label text.
     * @return This instance.
     */
    public function SetLabel($value)
    {
        if (is_string($value))
            $this->labelText = $value;
        return $this;
    }

    /**
     * Sets or unsets the disabled state.
     *
     * @param bool $value The disabled state.
     * @return This instance.
     */
    public function SetDisabled($value =true)
    {
        if ($value === true) {
            $this->AddClass('disabled');
            $this->input->SetAttribute('disabled');
        } else {
            $this->RemoveClass('disabled');
            $this->input->RemoveAttribute('disabled');
        }
        return $this;
    }

    /**
     * @copydoc Element::Render
     */
    public function Render()
    {
        $this->RemoveChildren();
        $label = new Label($this->input);
        $label->AddChild($this->labelText);
        $this->AddChild($label);
        parent::Render();
    }
}
?>