<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;

/**
 * Tests the `GetAverage` static method.
 */
class GetAverage extends \UnitTest\Core\TestCase {
	public function Run() {
		TestEntity::DeleteTable();
		// Fails when the table doesn't exist.
		self::verify(TestEntity::GetAverage('DoubleValue') === 0.0);
		// Now, create the table.
		TestEntity::CreateTable();
		// Return 0.0 when the table is empty.
		self::verify(TestEntity::GetAverage('DoubleValue') === 0.0);
		// Save some dummy entities.
		$e = new TestEntity();
		for ($i = 0; $i < 10; ++$i) {
			$e->ID = 0;
			$e->BooleanValue = $i % 3 ? true : false;
			$e->IntegerValue = $i;
			$e->DoubleValue = $i * 1.23;
			if ($i === 8)
				$e->StringValue = 'foo'; // evaluates to zero during averaging.
			else
				$e->StringValue = (string)$e->DoubleValue;
			$e->TimeValue = \Core\Time::FromMySQLString('2018-05-03 17:42:0' . $i);
			self::verify($e->Save());
		}
		// Verify.
		self::verify(TestEntity::GetAverage('BooleanValue') === 0.6);
		self::verify(TestEntity::GetAverage('IntegerValue') === 4.5);
		self::verify(TestEntity::GetAverage('DoubleValue') === 5.535);
		self::verify(TestEntity::GetAverage('StringValue') === 4.551);
		self::verify(TestEntity::GetAverage('TimeValue') === 20180503174204.5);
		TestEntity::DeleteTable();
	}
}
?>