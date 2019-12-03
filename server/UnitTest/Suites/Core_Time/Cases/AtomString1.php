<?php
namespace UnitTest\Suites\Core_Time\Cases;

/**
 * Tests `FromAtomString` and `ToAtomString` methods with a valid atom string.
 */
class AtomString1 extends \UnitTest\Core\TestCase {
	public function Run() {
		$s1 = '2019-01-15T20:34:14+03:00';
		$time = \Core\Time::FromAtomString($s1);
		$s2 = $time->ToAtomString();
		self::verify($s1 === $s2);
	}
}
?>