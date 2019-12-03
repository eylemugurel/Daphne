<?php
/**
 * @file IRunnable.php
 * Contains the `IRunnable` interface.
 *
 * @version 1.0
 * @date    June 8, 2019 (15:41)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

namespace UnitTest\Core;

/**
 * Interface which forces derived classes to implement the `#Run` method.
 */
interface IRunnable
{
	/**
	 * Runs a specific operation.
	 */
	function Run();
}
?>