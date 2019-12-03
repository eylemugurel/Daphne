<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;

class ToSqlLiteral extends \UnitTest\Core\TestCase {
	public function Run() {
		// boolean
		self::verify(TestEntity::ToSqlLiteral(false) === 0);
		self::verify(TestEntity::ToSqlLiteral(true) === 1);
		// integer
		self::verify(TestEntity::ToSqlLiteral(-17) === -17);
		self::verify(TestEntity::ToSqlLiteral(0) === 0);
		self::verify(TestEntity::ToSqlLiteral(17) === 17);
		// double
		self::verify(TestEntity::ToSqlLiteral(-3.5) === -3.5);
		self::verify(TestEntity::ToSqlLiteral(0.0) === 0.0);
		self::verify(TestEntity::ToSqlLiteral(3.5) === 3.5);
		// string
		self::verify(TestEntity::ToSqlLiteral('Hello, World!') === "'Hello, World!'");
		self::verify(TestEntity::ToSqlLiteral("\0")   === "'\\0'");  // '\0'
		self::verify(TestEntity::ToSqlLiteral("\n")   === "'\\n'");  // '\n'
		self::verify(TestEntity::ToSqlLiteral("\r")   === "'\\r'");  // '\r'
		self::verify(TestEntity::ToSqlLiteral("\x1a") === "'\\Z'");  // '\Z'
		self::verify(TestEntity::ToSqlLiteral('"')    === "'\\\"'"); // '\"'
		self::verify(TestEntity::ToSqlLiteral("'")    === "'\\''");  // '\''
		self::verify(TestEntity::ToSqlLiteral("\\")   === "'\\\\'"); // '\\'
		// Time
		self::verify(TestEntity::ToSqlLiteral(\Core\Time::FromMySQLString(
			'2018-05-03 17:42:08')) === "'2018-05-03 17:42:08'");
		// Unsupported types
		self::verify(TestEntity::ToSqlLiteral(new \DateTime) === '');
		self::verify(TestEntity::ToSqlLiteral(new \stdClass) === '');
		self::verify(TestEntity::ToSqlLiteral(array()) === '');
		self::verify(TestEntity::ToSqlLiteral(null) === '');
	}
}
?>