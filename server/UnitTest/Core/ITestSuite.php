<?php
/**
 * @file ITestSuite.php
 * Contains the `ITestSuite` interface.
 *
 * @version 1.0
 * @date    June 8, 2019 (15:47)
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
 * interface, forces derived classes to implement the `#AddCase` method.
 */
interface ITestSuite extends IRunnable
{
	/**
	 * Adds a test case.
	 *
	 * @param object $case Instance of a class which must be derived from the
	 * `TestCase` abstract class.
	 */
	function AddCase($case);
}
?>