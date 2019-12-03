<?php
namespace UnitTest\Suites\Core_Page\Cases;

use UnitTest\Suites\Core_Page\Classes\TestPage;

/**
 * Tests the `GetCanonicalURL` method.
 *
 * @remark To mimic visit to `test.php` with query parameters, the `$_SERVER`
 * array is internally set, but then restored to original state.
 */
class CanonicalURL extends \UnitTest\Core\TestCase {
	public function Run() {
		$page = new TestPage();
		$barePageUrl = \Core\Server::GetBaseURL() . \Core\Server::GetPageFileName();
		// 1. Without any canonical query key set, the canonical url should be
		// equal to the bare page url.
		self::verify($page->GetCanonicalURL() === $barePageUrl);
		// 2. Back up the original query string; we'll modify it.
		$originalQueryString = $_SERVER['QUERY_STRING'];
		// 3. Set a mock query parameter. The behaviour should be the same as
		// subcase 1.
		$_SERVER['QUERY_STRING'] = 'foo=bar';
		self::verify($page->GetCanonicalURL() === $barePageUrl);
		// 4. Now, set a canonical query key. Using the same mock query
		// parameter. The url now should contain the query parameter.
		$page->SetCanonicalQueryKey('foo');
		self::verify($page->GetCanonicalURL() === $barePageUrl . '?foo=bar');
		// 5. Add an extra mock query parameter. The behaviour should be the
		// same as subcase 4.
		$_SERVER['QUERY_STRING'] = 'foo=bar&qux=42';
		self::verify($page->GetCanonicalURL() === $barePageUrl . '?foo=bar');
		// 6. Restore the original query string, and exit.
		$_SERVER['QUERY_STRING'] = $originalQueryString;
	}
}
?>