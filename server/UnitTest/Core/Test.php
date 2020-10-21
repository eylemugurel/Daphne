<?php
/**
 * @file Test.php
 * Contains the `Test` class.
 *
 * @version 1.0
 * @date    June 8, 2019 (16:01)
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
 * Class which extends the `ITest` interface.
 */
class Test implements ITest
{
	/**
	 * Text message to display when the test is started.
	 */
	const TEST_STARTED = '<b>Test started.</b>';
	/**
	 * Text message format to display when running a suite.
	 */
	const RUNNING_SUITE_F = 'Running suite <i>%s</i>...';
	/**
	 * Text message format to display the test is completed.
	 */
	const TEST_COMPLETED_F = '<b>Test completed in <i>%.3f</i> seconds.</b>';

	/**
	 * Array of `TestSuite` derived instances which can be populated through the
	 * `AddSuite` method.
	 */
	private $suites = array();

	/**
	 * Extracts suite name from a fully qualified class name.
	 *
	 * @param object $suite Instance of a class which must be derived from the
	 * `TestSuite` abstract class.
	 * @return String specifying a suite name.
	 * @remark For example, the class name `"UnitTest\Suites\Entity\Suite"`
	 * yields the string `"Entity"`.
	 */
	private static function getSuiteName($suite) {
		$x = explode ('\\' , get_class($suite));
		array_pop($x); // throw away the "Suite" string.
		return array_pop($x);
	}

	/**
	 * @copydoc ITest::AddSuite
	 */
	public function AddSuite($suite) {
		array_push($this->suites, $suite);
	}

	/**
	 * Runs the test.
	 */
	public function Run() {
		\Core\Helper::Output(self::TEST_STARTED);
		$st = microtime(true);
		foreach ($this->suites as $suite) {
			\Core\Helper::Output(self::RUNNING_SUITE_F, self::getSuiteName($suite));
			$suite->Run();
		}
		$et = microtime(true);
		\Core\Helper::Output(self::TEST_COMPLETED_F, $et - $st);
	}
}
?>