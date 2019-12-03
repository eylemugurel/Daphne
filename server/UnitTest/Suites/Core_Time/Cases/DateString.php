<?php
namespace UnitTest\Suites\Core_Time\Cases;

/**
 * Tests `FromDateString` and `ToDateString` methods with a valid date string.
 */
class DateString extends \UnitTest\Core\TestCase {
	public function Run() {
		$s1 = '03.05.2018';
		$time = \Core\Time::FromDateString($s1);
		$s2 = $time->ToDateString();
		self::verify($s1 === $s2);
	}
}
?>