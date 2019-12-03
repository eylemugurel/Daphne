<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;

/**
 * Tests the `GetCount` static method.
 */
class GetCount extends \UnitTest\Core\TestCase {
	public function Run() {
		TestEntity::DeleteTable();
		// Returns 0 when the table doesn't exist.
		self::verify(TestEntity::GetCount() === 0);
		// Now, create the table.
		TestEntity::CreateTable();
		// Returns 0 when the table is empty.
		self::verify(TestEntity::GetCount() === 0);
		// Save some dummy entities.
		$e = new TestEntity();
		for ($e->IntegerValue = 0; $e->IntegerValue < 100; ++$e->IntegerValue) {
			$e->ID = 0;
			self::verify($e->Save());
		}
		// Verify.
		self::verify(TestEntity::GetCount() === 100);
		self::verify(TestEntity::GetCount('IntegerValue >= 17 AND IntegerValue < 42') === 25);
		TestEntity::DeleteTable();
	}
}
?>