<?php
namespace UnitTest\Suites\Core_Response;

class Suite extends \UnitTest\Core\TestSuite {
	public function __construct() {
		self::AddCase(new Cases\Success());
		self::AddCase(new Cases\Error());
		self::AddCase(new Cases\Data1());
		self::AddCase(new Cases\Data2());
	}
}
