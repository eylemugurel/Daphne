<?php
namespace UnitTest\Suites\Model_Entity;

class Suite extends \UnitTest\Core\TestSuite {
	public function __construct() {
		self::AddCase(new Cases\Save());
		self::AddCase(new Cases\Delete());
		self::AddCase(new Cases\FindById());
		self::AddCase(new Cases\FindOne());
		self::AddCase(new Cases\FindMany());
		self::AddCase(new Cases\GetCount());
		self::AddCase(new Cases\GetAverage());
		self::AddCase(new Cases\GetRange());
		self::AddCase(new Cases\CreateTable());
		self::AddCase(new Cases\DeleteTable());
		self::AddCase(new Cases\ResetTable());
		self::AddCase(new Cases\CreateView());
		self::AddCase(new Cases\DeleteView());
		self::AddCase(new Cases\ToSqlTypeName());
		self::AddCase(new Cases\ToSqlLiteral());
		self::AddCase(new Cases\ToTargetValue());
		self::AddCase(new Cases\ToTableName());
	}
}
