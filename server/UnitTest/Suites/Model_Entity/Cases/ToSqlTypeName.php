<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;

class ToSqlTypeName extends \UnitTest\Core\TestCase {
	public function Run() {
		// boolean
		self::verify(TestEntity::ToSqlTypeName(false) === 'BIT');
		self::verify(TestEntity::ToSqlTypeName(true) === 'BIT');
		// integer
		self::verify(TestEntity::ToSqlTypeName(-17) === 'INT');
		self::verify(TestEntity::ToSqlTypeName(0) === 'INT');
		self::verify(TestEntity::ToSqlTypeName(17) === 'INT');
		// double
		self::verify(TestEntity::ToSqlTypeName(-3.5) === 'DOUBLE');
		self::verify(TestEntity::ToSqlTypeName(0.0) === 'DOUBLE');
		self::verify(TestEntity::ToSqlTypeName(3.5) === 'DOUBLE');
		// string
		self::verify(TestEntity::ToSqlTypeName('') === 'TEXT');
		self::verify(TestEntity::ToSqlTypeName('Hello, World!') === 'TEXT');
		// Time
		self::verify(TestEntity::ToSqlTypeName(new \Core\Time) === 'DATETIME');
		// Unsupported types
		self::verify(TestEntity::ToSqlTypeName(new \DateTime) === '');
		self::verify(TestEntity::ToSqlTypeName(new \stdClass) === '');
		self::verify(TestEntity::ToSqlTypeName(array()) === '');
		self::verify(TestEntity::ToSqlTypeName(null) === '');
	}
}
?>