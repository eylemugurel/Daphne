<?php
namespace UnitTest\Suites\Core_Response\Cases;

/**
 * Tests the `Success` static method.
 */
class Success extends \UnitTest\Core\TestCase {
	public function Run() {
		self::verify(\Core\Response::Success() === '{}');
	}
}
?>