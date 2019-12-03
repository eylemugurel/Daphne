<?php
namespace UnitTest\Suites\Core_Page\Cases;

use UnitTest\Suites\Core_Page\Classes\TestPage;

/**
 * Tests the `title` property.
 */
class Title extends \UnitTest\Core\TestCase {
	public function Run() {
		$page = new TestPage();
		// Initial
		self::verify($page->GetTitle() === '');
		// Non-string
		self::forEachNonString(function($value) use($page) {
			$page->SetTitle($value);
			self::verify($page->GetTitle() === '');
		});
		// Empty + space
		$page->SetTitle('');
		self::verify($page->GetTitle() === '');
		$page->SetTitle(' ');
		self::verify($page->GetTitle() === ' ');
		$page->SetTitle('  ');
		self::verify($page->GetTitle() === '  ');
		// Normal
		$page->SetTitle('Foo');
		self::verify($page->GetTitle() === 'Foo');
		$page->SetTitle(' Foo');
		self::verify($page->GetTitle() === ' Foo');
		$page->SetTitle(' Foo ');
		self::verify($page->GetTitle() === ' Foo ');
	}
}
?>