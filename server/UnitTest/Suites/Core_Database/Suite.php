<?php
namespace UnitTest\Suites\Core_Database;

class Suite extends \UnitTest\Core\TestSuite {
	public function __construct() {
		self::AddCase(new Cases\GetInstance());
	}
}
