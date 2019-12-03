<?php
namespace UnitTest\Suites\Core_Page\Cases;

use UnitTest\Suites\Core_Page\Classes\TestPage;

/**
 * Tests the `libraries` property.
 */
class Libraries extends \UnitTest\Core\TestCase {
	public function Run() {
		$page = new TestPage();
		// Initial
		self::verifyEmptyArray($page->GetLibraries());
		// Non-string
		self::forEachNonString(function($value) use($page) {
			$page->AddLibrary($value);
			self::verifyEmptyArray($page->GetLibraries());
		});
		// Non comma-separated
		$page->AddLibrary('Foo;Bar');
		$libraries = $page->GetLibraries();
		self::verify(count($libraries) === 1);
		self::verify($libraries[0] === 'Foo;Bar');
		// Comma-separated with empty items and spaces
		$page = new TestPage(); // start from scratch
		$page->AddLibrary('   Foo, ,Bar , Baz,,  Zoo  ');
		$libraries = $page->GetLibraries();
		self::verify(count($libraries) === 4);
		self::verify($libraries[0] === 'Foo');
		self::verify($libraries[1] === 'Bar');
		self::verify($libraries[2] === 'Baz');
		self::verify($libraries[3] === 'Zoo');
		// Normal
		$page = new TestPage(); // start from scratch
		$page->AddLibrary('Table, Table:TurkishString, Table:TurkishDateTime, Rating');
		$libraries = $page->GetLibraries();
		self::verify(count($libraries) === 4);
		self::verify($libraries[0] === 'Table');
		self::verify($libraries[1] === 'Table:TurkishString');
		self::verify($libraries[2] === 'Table:TurkishDateTime');
		self::verify($libraries[3] === 'Rating');
	}
}
?>