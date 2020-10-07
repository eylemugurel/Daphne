<?php
/**
 * @file GETParameter.php
 * Contains the `GETParameter` class.
 *
 * @version 1.1
 * @date    October 4, 2020 (10:08)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2020 Eylem Ugurel. All rights reserved.
 */

namespace Core;

/**
 *
 */
class GETParameter extends RequestParameter
{
	/**
	 *
	 */
	public function __construct($name, $type =self::TYPE_STRING)
	{
		parent::__construct($name, $type);
	}

	/**
	 *
	 */
	public static function Find($name, $defaultValue =null)
	{
		if (!array_key_exists($name, $_GET))
			return $defaultValue;
		return $_GET[$name];
	}
}
?>
