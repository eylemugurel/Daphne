<?php
namespace UnitTest\Suites\Core_Page\Cases;

use UnitTest\Suites\Core_Page\Classes\TestPage;

/**
 * Tests the `canonicalQueryKey` property.
 */
class CanonicalQueryKey extends \UnitTest\Core\TestCase {
	public function Run() {
		$page = new TestPage();
		// Initial
		self::verify($page->GetCanonicalQueryKey() === '');
		// Non-string
		self::forEachNonString(function($value) use($page) {
			$page->SetCanonicalQueryKey($value);
			self::verify($page->GetCanonicalQueryKey() === '');
		});
		// Empty + space
		$page->SetCanonicalQueryKey('');
		self::verify($page->GetCanonicalQueryKey() === '');
		$page->SetCanonicalQueryKey(' ');
		self::verify($page->GetCanonicalQueryKey() === ' ');
		$page->SetCanonicalQueryKey('  ');
		self::verify($page->GetCanonicalQueryKey() === '  ');
		// Normal
		$page->SetCanonicalQueryKey('Foo');
		self::verify($page->GetCanonicalQueryKey() === 'Foo');
		$page->SetCanonicalQueryKey(' Foo');
		self::verify($page->GetCanonicalQueryKey() === ' Foo');
		$page->SetCanonicalQueryKey(' Foo ');
		self::verify($page->GetCanonicalQueryKey() === ' Foo ');
	}
}
?>