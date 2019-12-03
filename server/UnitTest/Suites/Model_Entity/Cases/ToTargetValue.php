<?php
namespace UnitTest\Suites\Model_Entity\Cases;

use UnitTest\Suites\Model_Entity\Classes\TestEntity;

class ToTargetValue extends \UnitTest\Core\TestCase {
	public function Run() {
		$booleanValue = false;
		$integerValue = 0;
		$doubleValue = 0.0;
		$stringValue = '';
		$timeValue = new \Core\Time();
		// Empty string
		self::verify(TestEntity::ToTargetValue('', $booleanValue) === false);
		self::verify(TestEntity::ToTargetValue('', $integerValue) === 0);
		self::verify(TestEntity::ToTargetValue('', $doubleValue) === 0.0);
		self::verify(TestEntity::ToTargetValue('', $stringValue) === '');
		self::verify(TestEntity::ToTargetValue('', $timeValue)->IsZero());
		// '0'
		self::verify(TestEntity::ToTargetValue('0', $booleanValue) === false);
		self::verify(TestEntity::ToTargetValue('0', $integerValue) === 0);
		self::verify(TestEntity::ToTargetValue('0', $doubleValue) === 0.0);
		self::verify(TestEntity::ToTargetValue('0', $stringValue) === '0');
		self::verify(TestEntity::ToTargetValue('0', $timeValue)->IsZero());
		// 0
		self::verify(TestEntity::ToTargetValue(0, $booleanValue) === false);
		self::verify(TestEntity::ToTargetValue(0, $integerValue) === 0);
		self::verify(TestEntity::ToTargetValue(0, $doubleValue) === 0.0);
		self::verify(TestEntity::ToTargetValue(0, $stringValue) === '0');
		self::verify(TestEntity::ToTargetValue(0, $timeValue)->IsZero());
		// '1'
		self::verify(TestEntity::ToTargetValue('1', $booleanValue) === true);
		self::verify(TestEntity::ToTargetValue('1', $integerValue) === 1);
		self::verify(TestEntity::ToTargetValue('1', $doubleValue) === 1.0);
		self::verify(TestEntity::ToTargetValue('1', $stringValue) === '1');
		self::verify(TestEntity::ToTargetValue('1', $timeValue)->IsZero());
		// 1
		self::verify(TestEntity::ToTargetValue(1, $booleanValue) === true);
		self::verify(TestEntity::ToTargetValue(1, $integerValue) === 1);
		self::verify(TestEntity::ToTargetValue(1, $doubleValue) === 1.0);
		self::verify(TestEntity::ToTargetValue(1, $stringValue) === '1');
		self::verify(TestEntity::ToTargetValue(1, $timeValue)->IsZero());
		// '42'
		self::verify(TestEntity::ToTargetValue('42', $booleanValue) === true);
		self::verify(TestEntity::ToTargetValue('42', $integerValue) === 42);
		self::verify(TestEntity::ToTargetValue('42', $doubleValue) === 42.0);
		self::verify(TestEntity::ToTargetValue('42', $stringValue) === '42');
		self::verify(TestEntity::ToTargetValue('42', $timeValue)->IsZero());
		// 42
		self::verify(TestEntity::ToTargetValue(42, $booleanValue) === true);
		self::verify(TestEntity::ToTargetValue(42, $integerValue) === 42);
		self::verify(TestEntity::ToTargetValue(42, $doubleValue) === 42.0);
		self::verify(TestEntity::ToTargetValue(42, $stringValue) === '42');
		self::verify(TestEntity::ToTargetValue(42, $timeValue)->IsZero());
		// '3.14159'
		self::verify(TestEntity::ToTargetValue('3.14159', $booleanValue) === true);
		self::verify(TestEntity::ToTargetValue('3.14159', $integerValue) === 3);
		self::verify(TestEntity::ToTargetValue('3.14159', $doubleValue) === 3.14159);
		self::verify(TestEntity::ToTargetValue('3.14159', $stringValue) === '3.14159');
		self::verify(TestEntity::ToTargetValue('3.14159', $timeValue)->IsZero());
		// 3.14159
		self::verify(TestEntity::ToTargetValue(3.14159, $booleanValue) === true);
		self::verify(TestEntity::ToTargetValue(3.14159, $integerValue) === 3);
		self::verify(TestEntity::ToTargetValue(3.14159, $doubleValue) === 3.14159);
		self::verify(TestEntity::ToTargetValue(3.14159, $stringValue) === '3.14159');
		self::verify(TestEntity::ToTargetValue(3.14159, $timeValue)->IsZero());
		// HTML tags
		self::verify(TestEntity::ToTargetValue('<h1>Good&ensp;Title</h1><p>Some <span class="nice">paragraph</span></p>', $stringValue) === 'Good&amp;ensp;TitleSome paragraph');
		// HTML special chars
		self::verify(TestEntity::ToTargetValue('this & that', $stringValue) === 'this &amp; that');
		self::verify(TestEntity::ToTargetValue("The 'single' quote", $stringValue) === 'The &apos;single&apos; quote');
		self::verify(TestEntity::ToTargetValue('The "double" quote', $stringValue) === 'The &quot;double&quot; quote');
		self::verify(TestEntity::ToTargetValue('-1 is < 0 but > -2', $stringValue) === '-1 is &lt; 0 but &gt; -2');
		// Time: success
		self::verify(TestEntity::ToTargetValue('2018-05-03 17:42:08', $timeValue)->ToMySQLString() === '2018-05-03 17:42:08');
		// Time: errors
		self::verify(TestEntity::ToTargetValue('2019-01-15T20:34:14+03:00', $timeValue)->IsZero());
		self::verify(TestEntity::ToTargetValue('03.05.2018', $timeValue)->IsZero());
		self::verify(TestEntity::ToTargetValue('03.05.2018 17:42:08', $timeValue)->IsZero());
		// Unsupported types
		self::verify(TestEntity::ToTargetValue(0, array()) === null);
		self::verify(TestEntity::ToTargetValue(0, new \stdClass) === null);
		self::verify(TestEntity::ToTargetValue(0, null) === null);
	}
}
?>