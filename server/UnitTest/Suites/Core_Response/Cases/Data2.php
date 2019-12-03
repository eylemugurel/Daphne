<?php
namespace UnitTest\Suites\Core_Response\Cases;

/**
 * Tests the `Data` static method with a `Time`.
 */
class Data2 extends \UnitTest\Core\TestCase {
	public function Run() {
		$data = new \Core\Time();
		$s = \Core\Response::Data($data);
		$j = json_decode($s);
		self::verify($j->data->date === $data->date);
		self::verify($j->data->timezone_type === $data->timezone_type);
		self::verify($j->data->timezone === $data->timezone);
	}
}
?>