<?php
/**
 * @file POSTParameter.php
 * Contains the `POSTParameter` class.
 *
 * @version 1.0
 * @date    November 12, 2019 (2:38)
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
class POSTParameter extends RequestParameter
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
	public static function Find($name)
	{
		if (!array_key_exists($name, $_POST))
			return null;
		return $_POST[$name];
	}
}
?>