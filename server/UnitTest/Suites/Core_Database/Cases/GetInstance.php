<?php
namespace UnitTest\Suites\Core_Database\Cases;

class GetInstance extends \UnitTest\Core\TestCase {
	public function Run() {
		$db = \Core\Database::GetInstance();
		self::verify($db instanceof \Core\Database);
		// Verify that the both reference to the same singleton instance.
		self::verify($db === \Core\Database::GetInstance());
	}
}
?>