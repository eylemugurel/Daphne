<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;

/**
 * Tests the `FindMany` static method.
 */
class FindMany extends \UnitTest\Core\TestCase {
	public function Run() {
		TestEntity::DeleteTable();
		// Returns empty array when the table doesn't exist.
		self::verifyEmptyArray(TestEntity::FindMany());
		// Now, create the table.
		TestEntity::CreateTable();
		// Returns empty array when the table is empty.
		self::verifyEmptyArray(TestEntity::FindMany());
		// Save some dummy entities and verify.
		$e = new TestEntity();
		for ($i = 0; $i < 100; ++$i) {
			$e->ID = 0; // makes it insertable.
			self::verify($e->Save());
		}
		$es = TestEntity::FindMany();
		self::verify(is_array($es) && count($es) === 100);
		$es = TestEntity::FindMany('ID >= 17 AND ID < 42');
		self::verify(is_array($es) && count($es) === 25);
		$es = TestEntity::FindMany('', 'ID DESC');
		self::verify(is_array($es) && count($es) === 100);
		self::verify($es[0]->ID === 100);
		$es = TestEntity::FindMany('', '', 33);
		self::verify(is_array($es) && count($es) === 33);
		TestEntity::DeleteTable();
	}
}
?>