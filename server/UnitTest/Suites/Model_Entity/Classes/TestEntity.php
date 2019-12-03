<?php
namespace UnitTest\Suites\Model_Entity\Classes;

class TestEntity extends \Model\Entity
{
	public $BooleanValue = false;
	public $IntegerValue = 0;
	public $DoubleValue = 0.0;
	public $StringValue = '';
	public $TimeValue = null;

	public function __construct() {
		$this->TimeValue = new \Core\Time();
	}

	/**
	 * Allows public access to protected parent method.
	 */
	public static function ToSqlTypeName($value) {
		return parent::toSqlTypeName($value);
	}

	/**
	 * Allows public access to protected parent method.
	 */
	public static function ToSqlLiteral($value) {
		return parent::toSqlLiteral($value);
	}

	/**
	 * Allows public access to protected parent method.
	 */
	public static function ToTargetValue($value, $hint) {
		return parent::toTargetValue($value, $hint);
	}

	/**
	 * Allows public access to protected parent method.
	 */
	public static function ToTableName($className) {
		return parent::toTableName($className);
	}
}
?>