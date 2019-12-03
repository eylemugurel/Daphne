<?php
namespace UnitTest\Suites\Core_Time\Cases;

/**
 * Tests `FromAtomString` and `ToAtomString` methods with an atom string ending
 * with 'Z'.
 *
 * @remark The `ToAtomString` method should return a string in which the ending
 * 'Z' is replaced with the timezone '+00:00'.
 */
class AtomString3 extends \UnitTest\Core\TestCase {
	public function Run() {
		$s1 = '2019-01-15T20:34:14';
		$time = \Core\Time::FromAtomString($s1 . 'Z');
		$s2 = $time->ToAtomString();
		self::verify($s1 . '+00:00' === $s2);
	}
}
?>