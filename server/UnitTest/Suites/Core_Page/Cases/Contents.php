<?php
namespace UnitTest\Suites\Core_Page\Cases;

use UnitTest\Suites\Core_Page\Classes\TestPage;

/**
 * Tests the `contents` property.
 */
class Contents extends \UnitTest\Core\TestCase {
	public function Run() {
		$page = new TestPage();
		// Initial
		self::verify($page->GetContents() === '');
		// Empty
		$page->BeginContents();
		$page->EndContents();
		self::verify($page->GetContents() === '');
		// Normal
		$hello_world = "\t\t<p>Hello, World!</p>\n";
		$page->BeginContents();
		echo $hello_world;
		$page->EndContents();
		self::verify($page->GetContents() === $hello_world);
	}
}
?>