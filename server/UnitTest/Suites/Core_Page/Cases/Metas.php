<?php
namespace UnitTest\Suites\Core_Page\Cases;

use UnitTest\Suites\Core_Page\Classes\TestPage;

/**
 * Tests the `metas` property.
 */
class Metas extends \UnitTest\Core\TestCase {
	public function Run() {
		$page = new TestPage();
		// Initial
		self::verify(is_array($page->GetMetas()));
		// Logged-in state
		if ($page->GetLoggedInAccount() !== null) {
			self::verify(count($page->GetMetas()) == 1);
			self::verify($page->GetFirstMetaName() === \Core\Page::LOGOUT_TOKEN_NAME);
			self::verify(preg_match('/^[a-z,0-9]{32}$/', $page->GetFirstMetaContent()) === 1);
		}
		// Non-string meta name
		self::forEachNonString(function($name) use($page) {
			$page->AddMeta($name, '');
			self::verify($page->GetLastMetaName() === '');
		});
		// Scalar meta content
		self::forEachScalar(function($content) use($page) {
			$page->AddMeta('', $content);
			self::verify($page->GetLastMetaContent() === (string)$content);
		});
		// Empty + space
		$page->AddMeta('', ' ');
		self::verify($page->GetLastMetaName() === '');
		self::verify($page->GetLastMetaContent() === ' ');
		// Normal; found
		$page->AddMeta('Foo', 'Bar');
		self::verify($page->FindMeta('Foo') === 'Bar');
		// Not found
		self::verify($page->FindMeta('Qux') === null);
	}
}
?>
