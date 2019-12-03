<?php
namespace UnitTest\Suites\Core_Page;

class Suite extends \UnitTest\Core\TestSuite {
	public function __construct() {
		self::AddCase(new Cases\Title());
		self::AddCase(new Cases\Description());
		self::AddCase(new Cases\CanonicalQueryKey());
		self::AddCase(new Cases\Metas());
		self::AddCase(new Cases\AddToken());
		self::AddCase(new Cases\Libraries());
		self::AddCase(new Cases\Scripts());
		self::AddCase(new Cases\Masterpage());
		self::AddCase(new Cases\Contents());
		self::AddCase(new Cases\CanonicalURL());
	}
}
