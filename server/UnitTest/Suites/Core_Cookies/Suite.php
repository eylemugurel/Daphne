<?php
namespace UnitTest\Suites\Core_Cookies;

class Suite extends \UnitTest\Core\TestSuite {
	public function __construct() {
		self::AddCase(new Cases\Has());
		self::AddCase(new Cases\Get());
	}
}
