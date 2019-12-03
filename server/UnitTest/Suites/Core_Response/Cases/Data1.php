<?php
namespace UnitTest\Suites\Core_Response\Cases;

/**
 * Tests the `Data` static method with an integer.
 */
class Data1 extends \UnitTest\Core\TestCase {
	public function Run() {
		$data = 42;
		$s = \Core\Response::Data($data);
		$j = json_decode($s);
		self::verify($j->data === $data);
	}
}
?>