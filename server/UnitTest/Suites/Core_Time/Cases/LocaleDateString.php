<?php
namespace UnitTest\Suites\Core_Time\Cases;

/**
 * Tests `ToLocaleDateString` assuming that `Core::Config::LANGUAGE_EX` is 'en_US'.
 */
class LocaleDateString extends \UnitTest\Core\TestCase {
	public function Run() {
		$time = \Core\Time::FromDateString('03.05.2018');
		self::verify($time->ToLocaleDateString() === 'May 3, 2018');
	}
}
?>