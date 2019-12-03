<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;
use UnitTest\Suites\Model_Entity\Classes\TestEntityView;

class CreateView extends \UnitTest\Core\TestCase {
	public function Run() {
	// Because TestEntityView depends on TestEntity, without it, the view
	// shouldn't be created.
		self::verify(true === TestEntity::DeleteTable());
		self::verify(true === TestEntityView::DeleteView());
		self::verify(false === TestEntityView::CreateView());
	// After the TestEntity table is created, the view should be successfully
	// created.
		self::verify(true === TestEntity::CreateTable());
		self::verify(true === TestEntityView::CreateView());
	// Save dummy entities with IntegerValue ranging from -10 to +10 randomly.
		$e = new TestEntity();
		for ($i = 0; $i < 20; ++$i) {
			$e->ID = 0;
			$e->IntegerValue = rand(-10, +10);
			self::verify($e->Save());
		}
	// Number of TestEntity with negative IntegerValue should match number of
	// TestEntityView with HasNegativeInteger of 1.
		$c1 = TestEntity::GetCount('IntegerValue < 0');
		$c2 = TestEntityView::GetCount('HasNegativeInteger = 1');
		self::verify($c1 === $c2);
	// Cleanup
		TestEntityView::DeleteView();
		TestEntity::DeleteTable();
	}
}
?>