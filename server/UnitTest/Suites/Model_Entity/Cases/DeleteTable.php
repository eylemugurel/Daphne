<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;

class DeleteTable extends \UnitTest\Core\TestCase {
	public function Run() {
		// 1. Method should succeed even when the table doesn't exist.
		self::verify(true === TestEntity::DeleteTable());
		self::verify(true === TestEntity::DeleteTable());
		// 2. Method should succeed when the table exist.
		self::verify(true === TestEntity::CreateTable());
		self::verify(true === TestEntity::DeleteTable());
		// Cleanup
		TestEntity::DeleteTable();
	}
}
?>