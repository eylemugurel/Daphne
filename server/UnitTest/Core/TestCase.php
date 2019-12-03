<?php
/**
 * @file TestCase.php
 * Contains the `TestCase` abstract class.
 *
 * @version 1.1
 * @date    October 23, 2019 (4:23)
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
 * Abstract class which extends the `ITestCase` interface, and also implements
 * several helper methods for the derived test case classes.
 */
abstract class TestCase implements ITestCase
{
	/**
	 * Throws `\Exception` if the given condition fails.
	 *
	 * @param bool $condition Condition to verify.
	 */
	protected static function verify($condition) {
		if (!$condition)
			throw new \Exception();
	}

	/**
	 * Throws `\Exception` if the given parameter does not evaluate to an
	 * empty array.
	 *
	 * @param $x Value to verify.
	 */
	protected static function verifyEmptyArray($x) {
		return self::verify(is_array($x) && count($x) === 0);
	}

	/**
	 * Gets the number of properties of the given object.
	 *
	 * @param object $object Instance of a user-defined class or the `stdClass`.
	 * @return Returns the number of properties in `$object`.
	 */
	protected static function getPropertyCount($object) {
		return count(get_object_vars($object));
	}

	/**
	 * Calls a given function for each element of an array of non-string
	 * values.
	 *
	 * @param function $callback A callback function with 1 parameter.
	 */
	protected static function forEachNonString($callback) {
		$a = array(42, 3.14, true, false, array(3,5,8), new \stdClass, null);
		foreach ($a as $e)
			$callback($e);
	}

	/**
	 * Calls a given function for each element of an array of non-integer
	 * values.
	 *
	 * @param function $callback A callback function with 1 parameter.
	 */
	protected static function forEachNonInteger($callback) {
		$a = array(3.14, true, false, array(3,5,8), new \stdClass, null);
		foreach ($a as $e)
			$callback($e);
	}

	/**
	 * Calls a given function for each element of an array of scalar
	 * values.
	 *
	 * @param function $callback A callback function with 1 parameter.
	 * @remark Scalar values are those containing an integer, float, string
	 * or boolean. Types array, object and resource are not scalar.
	 */
	protected static function forEachScalar($callback) {
		$a = array(42, 3.14, true, false, null);
		foreach ($a as $e)
			$callback($e);
	}
}
?>