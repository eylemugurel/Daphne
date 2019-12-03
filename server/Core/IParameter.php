<?php
/**
 * @file IParameter.php
 * Contains the `IParameter` interface.
 *
 * @version 1.0
 * @date    November 8, 2019 (20:23)
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
interface IParameter
{
	/**
	 * Gets the value of the parameter.
	 *
	 * @return The value of the parameter.
	 */
	function GetValue();
}
?>