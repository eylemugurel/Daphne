<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;

class ToTableName extends \UnitTest\Core\TestCase {
	public function Run() {
		self::verify(TestEntity::ToTableName('') === '');
		self::verify(TestEntity::ToTableName('Foo') === 'Foo');
		self::verify(TestEntity::ToTableName('Bar\Foo') === 'Foo');
		self::verify(TestEntity::ToTableName('Qux\Bar\Foo') === 'Foo');
	}
}
?>