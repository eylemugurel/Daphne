<?php
namespace UnitTest\Suites\Dummy;

class Suite extends \UnitTest\Core\TestSuite {
	public function __construct() {
		self::AddCase(new Cases\Dummy());
	}
}
