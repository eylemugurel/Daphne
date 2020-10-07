<?php
namespace UnitTest\Suites\Core_Page\Cases;

use UnitTest\Suites\Core_Page\Classes\TestPage;

/**
 * Tests the `libraries` property.
 */
class Libraries extends \UnitTest\Core\TestCase {
	public function Run() {
		// Initial: Must contain 4 standard libraries.
		$page = new TestPage();
		$libraries = $page->GetLibraries();
		self::verify(count($libraries) === 4);
		self::verify($libraries[0] === 'JQuery');
		self::verify($libraries[1] === 'Bootstrap');
		self::verify($libraries[2] === 'FontAwesome');
		self::verify($libraries[3] === 'Daphne');
		// Non-string
		$page = new TestPage();
		$page->RemoveLibrary('JQuery');
		$page->RemoveLibrary('Bootstrap');
		$page->RemoveLibrary('FontAwesome');
		$page->RemoveLibrary('Daphne');
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
		$page->RemoveLibrary('JQuery');
		$page->RemoveLibrary('Bootstrap');
		$page->RemoveLibrary('FontAwesome');
		$page->RemoveLibrary('Daphne');
		$page->AddLibrary('   Foo, ,Bar , Baz,,  Zoo  ');
		$libraries = $page->GetLibraries();
		self::verify(count($libraries) === 4);
		self::verify($libraries[0] === 'Foo');
		self::verify($libraries[1] === 'Bar');
		self::verify($libraries[2] === 'Baz');
		self::verify($libraries[3] === 'Zoo');
		// Normal
		$page = new TestPage(); // start from scratch
		$page->RemoveLibrary('JQuery');
		$page->RemoveLibrary('Bootstrap');
		$page->RemoveLibrary('FontAwesome');
		$page->RemoveLibrary('Daphne');
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