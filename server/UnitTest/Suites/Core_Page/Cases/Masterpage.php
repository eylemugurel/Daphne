<?php
namespace UnitTest\Suites\Core_Page\Cases;

use UnitTest\Suites\Core_Page\Classes\TestPage;

/**
 * Tests the `masterpage` property.
 */
class Masterpage extends \UnitTest\Core\TestCase {
	public function Run() {
		$page = new TestPage();
		// Initial
		self::verify($page->GetMasterpage() === '');
		// Non-string
		self::forEachNonString(function($value) use($page) {
			$page->SetMasterpage($value);
			self::verify($page->GetMasterpage() === '');
		});
		// Normal
		$page->SetMasterpage('starter');
		self::verify($page->GetMasterpage() === 'starter');
	}
}
?>