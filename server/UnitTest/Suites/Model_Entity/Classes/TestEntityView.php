<?php
namespace UnitTest\Suites\Model_Entity\Classes;

class TestEntityView extends \Model\Entity
{
	public $HasNegativeInteger = false;

	public static function CreateView() {
		return parent::createViewWith("
			SELECT
				TestEntity.ID,
				CASE WHEN
					TestEntity.IntegerValue < 0 THEN 1
					ELSE 0
				END AS HasNegativeInteger
			FROM
				TestEntity
		");
	}
}
?>