<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;

/**
 * Tests the `FindOne` static method.
 */
class FindOne extends \UnitTest\Core\TestCase {
	public function Run() {
		// Fails when the table doesn't exist.
		TestEntity::DeleteTable();
		self::verify(TestEntity::FindOne() === null);
		// Fails when the row doesn't exist.
		TestEntity::CreateTable();
		self::verify(TestEntity::FindOne() === null);
		// Save a dummy entity and obtain its id.
		$e = new TestEntity();
		$e->BooleanValue = true;
		$e->IntegerValue = 42;
		$e->DoubleValue = 3.14;
		$e->StringValue = 'Hello, World!';
		$e->TimeValue = \Core\Time::FromDateTimeString('03.05.2018 17:42:08');
		self::verify($e->Save() === true);
		$id = $e->ID;
		// Retrive saved entity and verify.
		$e = TestEntity::FindOne("StringValue='Hello, World!'");
		self::verify($e !== null);
		self::verify($e instanceof TestEntity);
		self::verify($e->ID === $id);
		self::verify($e->BooleanValue === true);
		self::verify($e->IntegerValue === 42);
		self::verify($e->DoubleValue === 3.14);
		self::verify($e->StringValue === 'Hello, World!');
		self::verify($e->TimeValue->ToDateTimeString() === '03.05.2018 17:42:08');
		// Save some dummy entities and verify.
		$e = new TestEntity();
		for ($i = 0; $i < 10; ++$i) {
			$e->ID = 0;
			self::verify($e->Save());
		}
		$e = TestEntity::FindOne('ID > 7');
		self::verify($e !== null);
		self::verify($e instanceof TestEntity);
		self::verify($e->ID === 8);
		// Verify the order.
		TestEntity::ResetTable();
		$e = new TestEntity();
		for ($i = 0; $i < 10; ++$i) {
			$e->ID = 0;
			self::verify($e->Save());
		}
		$e = TestEntity::FindOne('', 'ID DESC');
		self::verify($e !== null);
		self::verify($e instanceof TestEntity);
		self::verify($e->ID === 10);
		//
		TestEntity::DeleteTable();
	}
}
?>