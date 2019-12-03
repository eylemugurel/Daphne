<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;

class ResetTable extends \UnitTest\Core\TestCase {
	public function Run() {
		// 1. When the table doesn't exits, the method should fails.
		self::verify(true === TestEntity::DeleteTable());
		self::verify(false === TestEntity::ResetTable());
		// 2. After the table is created, the method should succeed.
		self::verify(true === TestEntity::CreateTable());
		self::verify(true === TestEntity::ResetTable());
		// 3. Save some dummy entities, then reset the table. The table should
		// be emptied.
		$e = new TestEntity();
		for ($i = 0; $i < 10; ++$i) {
			$e->ID = 0; // makes it insertable.
			self::verify($e->Save());
		}
		self::verify(TestEntity::GetCount() === 10);
		self::verify(true === TestEntity::ResetTable());
		self::verify(TestEntity::GetCount() === 0);
		// 4. On a reset table, the first entity inserted should have ID of 1.
		$e->ID = 0; // makes it insertable.
		self::verify($e->Save());
		self::verify($e->ID === 1);
		// Cleanup
		TestEntity::DeleteTable();
	}
}
?>