<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;

/**
 * Tests the `GetRange` static method.
 */
class GetRange extends \UnitTest\Core\TestCase {
	public function Run() {
		TestEntity::DeleteTable();
		$range = null;
		// Fails when the table doesn't exist.
		$range = TestEntity::GetRange('DoubleValue');
		self::verify($range instanceof \stdClass);
		self::verify($range->Min === null);
		self::verify($range->Max === null);
		// Now, create the table.
		TestEntity::CreateTable();
		// Returns false for 'BooleanValue' when the table doesn't exist.
		$range = TestEntity::GetRange('BooleanValue');
		self::verify($range instanceof \stdClass);
		self::verify($range->Min === false);
		self::verify($range->Max === false);
		// Returns 0 for 'IntegerValue' when the table doesn't exist.
		$range = TestEntity::GetRange('IntegerValue');
		self::verify($range instanceof \stdClass);
		self::verify($range->Min === 0);
		self::verify($range->Max === 0);
		// Returns 0.0 for 'DoubleValue' when the table doesn't exist.
		$range = TestEntity::GetRange('DoubleValue');
		self::verify($range instanceof \stdClass);
		self::verify($range->Min === 0.0);
		self::verify($range->Max === 0.0);
		// Returns '' for 'StringValue' when the table doesn't exist.
		$range = TestEntity::GetRange('StringValue');
		self::verify($range instanceof \stdClass);
		self::verify($range->Min === '');
		self::verify($range->Max === '');
		// Returns IsZero() true for 'TimeValue' when the table doesn't exist.
		$range = TestEntity::GetRange('TimeValue');
		self::verify($range instanceof \stdClass);
		self::verify($range->Min->IsZero());
		self::verify($range->Max->IsZero());
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
		$range = TestEntity::GetRange('BooleanValue');
		self::verify($range instanceof \stdClass);
		self::verify($range->Min === false);
		self::verify($range->Max === true);
		$range = TestEntity::GetRange('IntegerValue');
		self::verify($range instanceof \stdClass);
		self::verify($range->Min === 0);
		self::verify($range->Max === 9);
		$range = TestEntity::GetRange('DoubleValue');
		self::verify($range instanceof \stdClass);
		self::verify($range->Min === 0.0);
		self::verify($range->Max === 11.07);
		$range = TestEntity::GetRange('StringValue');
		self::verify($range instanceof \stdClass);
		self::verify($range->Min === '0');
		self::verify($range->Max === 'foo');
		$range = TestEntity::GetRange('TimeValue');
		self::verify($range instanceof \stdClass);
		self::verify($range->Min->ToMySQLString() === '2018-05-03 17:42:00');
		self::verify($range->Max->ToMySQLString() === '2018-05-03 17:42:09');
		TestEntity::DeleteTable();
	}
}
?>