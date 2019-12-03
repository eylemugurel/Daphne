<?php
namespace UnitTest\Suites\Core_Time\Cases;

/**
 * Tests `FromMySQLString` and `ToMySQLString` methods with a valid MySQL
 * datetime string.
 */
class MySQLString extends \UnitTest\Core\TestCase {
	public function Run() {
		$s1 = '2018-05-03 17:42:08';
		$time = \Core\Time::FromMySQLString($s1);
		$s2 = $time->ToMySQLString();
		self::verify($s1 === $s2);
	}
}
?>