<?php
namespace UnitTest\Suites\Core_Page\Cases;

use UnitTest\Suites\Core_Page\Classes\TestPage;

/**
 * Tests the `scripts` property.
 */
class Scripts extends \UnitTest\Core\TestCase {
	public function Run() {
		$page = new TestPage();
		// Initial
		self::verifyEmptyArray($page->GetScripts());
		// Non-string
		self::forEachNonString(function($value) use($page) {
			$page->AddScript($value);
			self::verifyEmptyArray($page->GetScripts());
		});
		// Non comma-separated
		$page->AddScript('Foo;Bar');
		$scripts = $page->GetScripts();
		self::verify(count($scripts) === 1);
		self::verify($scripts[0] === 'Foo;Bar');
		// Comma-separated with empty items and spaces
		$page = new TestPage(); // start from scratch
		$page->AddScript('   Foo, ,Bar , Baz,,  Zoo  ');
		$scripts = $page->GetScripts();
		self::verify(count($scripts) === 4);
		self::verify($scripts[0] === 'Foo');
		self::verify($scripts[1] === 'Bar');
		self::verify($scripts[2] === 'Baz');
		self::verify($scripts[3] === 'Zoo');
		// Normal
		$page = new TestPage(); // start from scratch
		$page->AddScript('app, index, Transposer');
		$scripts = $page->GetScripts();
		self::verify(count($scripts) === 3);
		self::verify($scripts[0] === 'app');
		self::verify($scripts[1] === 'index');
		self::verify($scripts[2] === 'Transposer');
	}
}
?>