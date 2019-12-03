<?php
namespace UnitTest\Suites\Core_Time\Cases;

/**
 * Tests `FromUnixTimestamp` and `ToUnixTimestamp` methods with a valid Unix
 * timestamp string.
 */
class UnixTimestamp extends \UnitTest\Core\TestCase {
	public function Run() {
		$s1 = '309445456';
		$time = \Core\Time::FromUnixTimestamp($s1);
		$s2 = $time->ToUnixTimestamp();
		self::verify($s1 === $s2);
	}
}
?>