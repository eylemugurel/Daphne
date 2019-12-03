<?php
/**
 * @file Button.php
 * Contains the `Button` class.
 *
 * @version 1.4
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
 * Represents a button element.
 */
class Button extends Element
{
	/**
	 * Contextual class names.
	 */
	const CONTEXTUAL_CLASSES = 'btn-default btn-primary btn-success btn-info btn-warning btn-danger btn-link';

	/**
	 * Size class names.
	 */
	const SIZE_CLASSES = 'btn-lg btn-sm btn-xs';

	/**
	 * Default value of the `data-loading-text` attribute.
	 */
	const DEFAULT_LOADING_TEXT = '<i class=\'fa fa-spinner fa-spin\'></i>';

	/**
	 * The icon name.
	 */
	private $iconName = '';

	/**
	 * The caption text.
	 */
	private $captionText = '';

	/**
	 * Constructor.
	 *
	 * @param string $type (optional) Value of the `type` attribute. Possible
	 * values are 'button', 'submit', and 'reset'.
	 */
	public function __construct($type ='button')
	{
		parent::__construct('button');
		$this->SetAttribute('type', $type);
		$this->AddClass('btn btn-default');
	}

	/**
	 * Sets the contextual class.
	 *
	 * @param string $value A contextual name which can be one of
	 * 'default', 'primary', 'success', 'info', 'warning', 'danger', or 'link'.
	 * @return This instance.
	 */
	public function SetContextual($value)
	{
		$this->RemoveClass(self::CONTEXTUAL_CLASSES);
		$this->AddClass(sprintf('btn-%s', $value));
		return $this;
	}

	/**
	 * Sets the size class.
	 *
	 * @param string $value A size name which can be one of 'lg', 'sm', or 'xs'.
	 * @return This instance.
	 */
	public function SetSize($value)
	{
		$this->RemoveClass(self::SIZE_CLASSES);
		$this->AddClass(sprintf('btn-%s', $value));
		return $this;
	}

	/**
	 * Sets the icon.
	 *
	 * @param string $value The name of an icon from Glyphicon or Font Awesome
	 * icon sets, such as 'glyphicon-lock', 'fa-pencil', etc.
	 * @return This instance.
	 */
	public function SetIcon($value)
	{
		$this->iconName = $value;
		return $this;
	}

	/**
	 * Sets the caption.
	 *
	 * @param string $value A caption text.
	 * @return This instance.
	 */
	public function SetCaption($value)
	{
		$this->captionText = $value;
		return $this;
	}

	/**
	 * Sets the `title` attribute.
	 *
	 * @param string $value A text to appear when the button is hovered with
	 * the mouse.
	 * @return This instance.
	 */
	public function SetTooltip($value)
	{
		$this->SetAttribute('title', $value);
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
	 * @copydoc Element::Render
	 */
	public function Render()
	{
		$this->RemoveChildren();
		if ($this->iconName !== '' && $this->captionText !== '') {
			$this->AddChild(new Icon($this->iconName));
			$this->AddChild('&ensp;');
			$this->AddChild($this->captionText);
		} else if ($this->iconName !== '') {
			$this->AddChild(new Icon($this->iconName));
		} else if ($this->captionText !== '') {
			$this->AddChild($this->captionText);
		} else {
			// Fix: If no icon or caption is set, the button collapses vertically.
			// To avoid, the content is set to the "zero-width non-joiner" entity.
			$this->AddChild('&zwnj;');
		}
		parent::Render();
	}
}
?>
