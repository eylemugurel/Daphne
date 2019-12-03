<?php
namespace UnitTest\Suites\Core_Time\Cases;

/**
 * Tests `FromDateTimeString` and `ToDateTimeString` methods with a valid
 * datetime string.
 */
class DateTimeString extends \UnitTest\Core\TestCase {
	public function Run() {
		$s1 = '03.05.2018 17:42:08';
		$time = \Core\Time::FromDateTimeString($s1);
		$s2 = $time->ToDateTimeString();
		self::verify($s1 === $s2);
	}
}
?>