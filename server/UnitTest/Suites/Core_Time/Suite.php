<?php
namespace UnitTest\Suites\Core_Time;

class Suite extends \UnitTest\Core\TestSuite {
	public function __construct() {
		self::AddCase(new Cases\UnixTimestamp());
		self::AddCase(new Cases\AtomString1());
		self::AddCase(new Cases\AtomString2());
		self::AddCase(new Cases\AtomString3());
		self::AddCase(new Cases\MySQLString());
		self::AddCase(new Cases\DateString());
		self::AddCase(new Cases\DateTimeString());
		self::AddCase(new Cases\LocaleDateString());
	}
}
