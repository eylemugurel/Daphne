<?php
namespace UnitTest\Suites\Core_Page\Cases;

use UnitTest\Suites\Core_Page\Classes\TestPage;

/**
 * Tests the `AddToken` method.
 *
 * @remark Because the unit test script `echo` with flushing, the response
 * headers are already sent at this point, and no cookie could be set by
 * `Core::Page::AddToken`. Therefore the token hash cannot be obtained.
 */
class AddToken extends \UnitTest\Core\TestCase {
	public function Run() {
		$page = new TestPage();
		// With default name.
		$page->AddToken();
		self::verify($page->GetLastMetaName() === \Core\Token::DEFAULT_NAME);
		// With custom name.
		$page->AddToken('Foo');
		self::verify($page->GetLastMetaName() === 'Foo');
	}
}
?>