<?php
namespace UnitTest\Suites\Core_Cookies\Cases;

class Has extends \UnitTest\Core\TestCase {
	public function Run() {
		$name = 'Foo';
		$value = 'Bar';
		$_COOKIE[$name] = $value;
		//
		self::verify(\Core\Cookies::Has($name));
		//
		unset($_COOKIE[$name]);
	}
}
?>