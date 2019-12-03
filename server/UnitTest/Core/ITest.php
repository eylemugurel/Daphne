<?php
/**
 * @file ITest.php
 * Contains the `ITest` interface.
 *
 * @version 1.0
 * @date    June 8, 2019 (15:43)
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
 * Interface which extends the `IRunnable` interface, and besides the parent
 * interface, forces derived classes to implement the `#AddSuite` method.
 */
interface ITest extends IRunnable
{
	/**
	 * Adds a test suite.
	 *
	 * @param object $suite Instance of a class which must be derived from the
	 * `TestSuite` abstract class.
	 */
	function AddSuite($suite);
}
?>