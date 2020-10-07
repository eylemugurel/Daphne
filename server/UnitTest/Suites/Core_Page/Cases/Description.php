<?php
namespace UnitTest\Suites\Core_Page\Cases;

use UnitTest\Suites\Core_Page\Classes\TestPage;

/**
 * Tests the `description` property.
 */
class Description extends \UnitTest\Core\TestCase {
	public function Run() {
		$page = new TestPage();
		// Initial: Must contain the default description.
		self::verify($page->GetDescription() === \Core\Config::DESCRIPTION);
		// Non-string
		self::forEachNonString(function($value) use($page) {
			$page->SetDescription($value);
			self::verify($page->GetDescription() === '');
		});
		// Empty + space
		$page->SetDescription('');
		self::verify($page->GetDescription() === '');
		$page->SetDescription(' ');
		self::verify($page->GetDescription() === ' ');
		$page->SetDescription('  ');
		self::verify($page->GetDescription() === '  ');
		// Normal
		$page->SetDescription('Foo');
		self::verify($page->GetDescription() === 'Foo');
		$page->SetDescription(' Foo');
		self::verify($page->GetDescription() === ' Foo');
		$page->SetDescription(' Foo ');
		self::verify($page->GetDescription() === ' Foo ');
	}
}
?>