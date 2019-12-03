<?php
namespace UnitTest\Suites\Core_Time\Cases;

/**
 * Tests `FromAtomString` and `ToAtomString` methods with an invalid atom string.
 */
class AtomString2 extends \UnitTest\Core\TestCase {
	public function Run() {
		$time = \Core\Time::FromAtomString('2019-01-15T20:34:14');
		$s = $time->ToAtomString();
		self::verify('1970-01-01T00:00:00+00:00' === $s);
	}
}
?>