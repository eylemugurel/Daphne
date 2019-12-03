<?php
/**
 * @file RequestParameter.php
 * Contains the `RequestParameter` abstract class.
 *
 * @version 1.2
 * @date    November 12, 2019 (2:37)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

namespace Core;

/**
 *
 */
abstract class RequestParameter implements IParameter
{
	/** */
	const TYPE_STRING = 0;
	/** */
	const TYPE_INTEGER = 1;
	/** */
	const TYPE_DECIMAL = 2;

	/** */
	private $name;
	/** */
	private $type;

	/**
	 *
	 */
	protected function __construct($name, $type =self::TYPE_STRING)
	{
		$this->name = $name;
		$this->type = $type;
	}

	/**
	 * @copydoc IParameter::GetValue
	 */
	public function GetValue()
	{
		// Calls the static method in the derived class (late static binding).
		$value = static::Find($this->name);
		if ($value !== null)
			switch ($this->type)
			{
			case self::TYPE_STRING:
				// The Find method already returns a string.
				break;
			case self::TYPE_INTEGER:
				$value = (int)$value;
				break;
			case self::TYPE_DECIMAL:
				$value = (double)$value;
				break;
			}
		return $value;
	}
}
?>