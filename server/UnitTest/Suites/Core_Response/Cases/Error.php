<?php
namespace UnitTest\Suites\Core_Response\Cases;

/**
 * Tests the `Error` static method.
 */
class Error extends \UnitTest\Core\TestCase {
	public function Run() {
		$e = new \Core\Error(\Core\Error::UNEXPECTED);
		$s = \Core\Response::Error($e->getCode());
		$j = json_decode($s);
		self::verify($j->error->code === $e->getCode());
		self::verify($j->error->message === $e->getMessage());
		self::verifyEmptyArray($j->data);
	}
}
?>