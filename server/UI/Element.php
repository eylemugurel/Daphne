<?php
/**
 * @file Element.php
 * Contains the `Element` class.
 *
 * @version 1.6
 * @date    October 23, 2019 (19:15)
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
 * Represents a UI element.
 */
class Element
{
	/**
	 * The HTML element name used in start and end tags.
	 */
	private $tag = '';

	/**
	 * If `true`, children and the end tag are not rendered.
	 */
	private $isSelfClosing = false;

	/**
	 * List of attributes.
	 *
	 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Attributes
	 */
	private $attributes = array();

	/**
	 * List of child strings or elements. Only rendered if the element is not
	 * self-closing.
	 */
	private $children = array();

	/**
	 * Constructor.
	 *
	 * @param string $tag The HTML element name used in start and end tags.
	 * @param bool $isSelfClosing (optional) If `true`, children and the end tag
	 * are not rendered.
	 */
	public function __construct($tag, $isSelfClosing =false)
	{
		$this->tag = $tag;
		$this->isSelfClosing = $isSelfClosing;
	}

	/**
	 * Sets an attribute.
	 *
	 * @param string $name Name of the attribute.
	 * @param string $value Value of the attribute. If empty, then the attribute
	 * is treated as a "boolean attribute" and only its name is rendered.
	 * @return This instance.
	 *
	 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Attributes#Boolean_Attributes
	 */
	public function SetAttribute($name, $value ='')
	{
		$this->attributes[$name] = $value;
		return $this;
	}

	/**
	 * Gets the value of an attribute.
	 *
	 * @param string $name Name of the attribute.
	 * @return string Value of the attribute if it exists; otherwise, `null`.
	 */
	public function GetAttribute($name)
	{
		if (!array_key_exists($name, $this->attributes))
			return null;
		return $this->attributes[$name];
	}

	/**
	 * Adds a new attribute.
	 *
	 * @param string $name Name of the attribute.
	 * @param string $value Value of the attribute. If empty, then the attribute
	 * is treated as a "boolean attribute" and only its name is rendered.
	 * @return This instance.
	 *
	 * @remark If a same name attribute already exists, then the new value is
	 * appended to the end of the existing value separated with a space. This is
	 * useful when specifying multiple values for an attribute, such as the
	 * `class` attribute.
	 */
	public function AddAttribute($name, $value ='')
	{
		if (array_key_exists($name, $this->attributes)) {
			if ($value !== '')
				$this->attributes[$name] .= ' ' . $value;
		} else {
			$this->SetAttribute($name, $value);
		}
		return $this;
	}

	/**
	 * Removes an attribute, or value(s) from an attribute.
	 *
	 * @param string $name Name of the attribute.
	 * @param string $value (optional) A single value, or multiple values
	 * separated with spaces, to remove from the attribute. If not specified,
	 * the attribute is removed.
	 * @return This instance.
	 */
	public function RemoveAttribute($name, $value =null)
	{
		if ($value === null) {
			unset($this->attributes[$name]);
		} else {
			$kalue = $this->GetAttribute($name); // current value
			if ($kalue !== null)
				$this->SetAttribute($name, join(' ',
					array_diff(explode(' ', $kalue), explode(' ', $value))));
		}
		return $this;
	}

	/**
	 * Adds a new child.
	 *
	 * @param $child A string or an Element object.
	 * @return This instance.
	 */
	public function AddChild($child)
	{
		array_push($this->children, $child);
		return $this;
	}

	/**
	 * Sets the child.
	 *
	 * @param $child A string or an Element object.
	 * @return This instance.
	 */
	public function SetChild($child)
	{
		$this->children = array($child);
		return $this;
	}

	/**
	 * Removes children.
	 * @return This instance.
	 */
	public function RemoveChildren()
	{
		if (count($this->children) > 0)
			$this->children = array();
		return $this;
	}

	/**
	 * Sets the `id` attribute.
	 *
	 * @param string $value An identifier.
	 * @return This instance.
	 */
	public function SetId($value)
	{
		$this->SetAttribute('id', $value);
		return $this;
	}

	/**
	 * Gets the `id` attribute.
	 *
	 * @return The value of the `id` attribute if it exists; otherwise, `null`.
	 */
	public function GetId()
	{
		return $this->GetAttribute('id');
	}

	/**
	 * Adds a new `class` attribute.
	 *
	 * @param string $value A class name.
	 * @return This instance.
	 */
	public function AddClass($value)
	{
		$this->AddAttribute('class', $value);
		return $this;
	}

	/**
	 * Removes a 'class' attribute.
	 *
	 * @param string $value A class name.
	 * @return This instance.
	 */
	public function RemoveClass($value)
	{
		$this->RemoveAttribute('class', $value);
		return $this;
	}

	/**
	 * Renders the UI object.
	 */
	public function Render()
	{
		echo sprintf('<%s', $this->tag);
		ksort($this->attributes, SORT_STRING); // sort by attribute names.
		foreach ($this->attributes as $name => $value) {
			echo ' ';
			if ($value === '')
				echo $name;
			else
				echo sprintf('%s="%s"', $name, $value);
		}
		if ($this->isSelfClosing === true) {
			echo '/>';
		} else {
			echo '>';
			foreach ($this->children as $child)
				if (is_string($child))
					echo $child;
				else
					$child->Render();
			echo sprintf('</%s>', $this->tag);
		}
	}
}
?>
