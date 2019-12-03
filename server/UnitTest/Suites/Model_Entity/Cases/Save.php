<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;

/**
 * Tests the `Save` method.
 */
class Save extends \UnitTest\Core\TestCase {
	public function Run() {
		TestEntity::DeleteTable();
		// Instantiate object under test.
		$e = new TestEntity();
		// Fails when the table doesn't exist.
		self::verify($e->Save() === false);
		// Now, create the table.
		TestEntity::CreateTable();
		// Insert, then update; the row count must be 1.
		self::verify($e->Save() === true);
		self::verify($e->Save() === true);
		self::verify(TestEntity::GetCount() === 1);
		// Insert another; the row count must be 2.
		$e->ID = 0;
		self::verify($e->Save() === true);
		self::verify(TestEntity::GetCount() === 2);
		// Fails when trying to update a non-existing row.
		$e->ID = 99;
		self::verify($e->Save() === false);
		TestEntity::DeleteTable();
	}
}
?>