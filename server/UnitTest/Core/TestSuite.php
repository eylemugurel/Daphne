<?php
/**
 * @file TestSuite.php
 * Contains the `TestSuite` abstract class.
 *
 * @version 1.1
 * @date    October 7, 2020 (8:30)
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
 * Abstract class which extends the `ITestSuite` interface.
 */
abstract class TestSuite implements ITestSuite
{
	/**
	 * Text message format to display when running a case.
	 */
	const RUNNING_CASE_F = '&emsp;Running case <i>%s</i>...';
	/**
	 * Text message format to display when a case fails.
	 */
	const CASE_FAILED_F = '&emsp;&emsp;<font color="red">Case failed at line <i>%d</i> in <i>%s</i>.</font>';

	/**
	 * Array of `TestCase` derived instances which can be populated through the
	 * `AddCase` method.
	 */
	private $cases = array();

	/**
	 * Extracts case name from a fully qualified class name.
	 *
	 * @param object $case Instance of a class which must be derived from the
	 * `TestCase` abstract class.
	 * @return String specifying a case name.
	 * @remark For example, the class name `"UnitTest\Suites\Entity\Cases\GetRange"`
	 * yields the string `"GetRange"`.
	 */
	private static function getCaseName($case) {
		return basename(get_class($case));
	}

	/**
	 * @copydoc ITestSuite::AddCase
	 */
	public function AddCase($case) {
		array_push($this->cases, $case);
	}

	/**
	 * Runs the suite.
	 */
	public function Run() {
		foreach ($this->cases as $case) {
			\Core\Helper::Output(self::RUNNING_CASE_F, self::getCaseName($case));
			try {
				$case->Run();
			} catch (\Exception $ex) {
				// Fix: In case the exception is thrown from `TestCase.php`,
				// scan the callstack to find the file right after TestCase.php
				// and dump error message for that file only.
				foreach ($ex->getTrace() as $t) {
					$fileName = basename($t['file']);
					if ($fileName === 'TestCase.php')
						continue;
					\Core\Helper::Output(self::CASE_FAILED_F, $t['line'], $fileName);
					break;
				}
			}
		}
	}
}
?>