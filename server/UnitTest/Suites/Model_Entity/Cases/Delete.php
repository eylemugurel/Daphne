<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;

/**
 * Tests the `Delete` method.
 */
class Delete extends \UnitTest\Core\TestCase {
	public function Run() {
		TestEntity::DeleteTable();
		// Instantiate object under test.
		$e = new TestEntity();
		// Fails when the table doesn't exist.
		self::verify($e->Delete() === false);
		// Now, create the table.
		TestEntity::CreateTable();
		// Fails when the row doesn't exist.
		self::verify($e->Delete() === false);
		// Save & delete.
		self::verify($e->Save() == true);
		self::verify(TestEntity::GetCount() === 1);
		self::verify($e->Delete() === true);
		self::verify(TestEntity::GetCount() === 0);
		TestEntity::DeleteTable();
	}
}
?>