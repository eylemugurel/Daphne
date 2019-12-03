<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;
use UnitTest\Suites\Model_Entity\Classes\TestEntityView;

class DeleteView extends \UnitTest\Core\TestCase {
	public function Run() {
		// 1. Method should succeed even when the view doesn't exist.
		self::verify(true === TestEntityView::DeleteView());
		self::verify(true === TestEntityView::DeleteView());
		// 2. Method should succeed when the view exist.
		self::verify(true === TestEntity::CreateTable());
		self::verify(true === TestEntityView::CreateView());
		self::verify(true === TestEntityView::DeleteView());
		// Cleanup
		TestEntityView::DeleteView();
		TestEntity::DeleteTable();
	}
}
?>