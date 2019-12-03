<?php
namespace UnitTest\Suites\Core_Cookies\Cases;

class Get extends \UnitTest\Core\TestCase {
	public function Run() {
		$name = 'Foo';
		$value = 'Bar';
		$_COOKIE[$name] = $value;
		//
		self::verify(\Core\Cookies::Get($name) === $value);
		//
		unset($_COOKIE[$name]);
	}
}
?>