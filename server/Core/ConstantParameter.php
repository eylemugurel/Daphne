<?php
/**
 * @file ConstantParameter.php
 * Contains the `ConstantParameter` class.
 *
 * @version 1.0
 * @date    November 8, 2019 (21:08)
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
class ConstantParameter implements IParameter
{
	/** */
	private $value = '';

	/**
	 *
	 */
	public function __construct($value)
	{
		$this->value = $value;
	}

	/**
	 * @copydoc IParameter::GetValue
	 */
	public function GetValue()
	{
		return $this->value;
	}
}
?>