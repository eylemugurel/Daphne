<?php
namespace UnitTest\Suites\Core_Page\Classes;

class TestPage extends \Core\Page
{
	/**
	 * Gets the name of the first element in the metas array.
	 *
	 * @return A string.
	 */
	public function GetFirstMetaName() {
		// Fix: Define a local variable to prevent error saying "Strict
		// standards: Only variables should be passed by reference".
		$metas = $this->GetMetas();
		// Moves the internal pointer to the start of the array.
		reset($metas);
		// Fetches the key of the element pointed to by the internal pointer.
		return key($metas);
	}

	/**
	 * Gets the content of the first element in the metas array.
	 *
	 * @return A string.
	 */
	public function GetFirstMetaContent() {
		// Fix: Define a local variable to prevent error saying "Strict
		// standards: Only variables should be passed by reference".
		$metas = $this->GetMetas();
		// Moves the internal pointer to the start of the array and fetches the
		// value of the element pointed to by the internal pointer.
		return reset($metas);
	}

	/**
	 * Gets the name of the last element in the metas array.
	 *
	 * @return A string.
	 */
	public function GetLastMetaName() {
		// Fix: Define a local variable to prevent error saying "Strict
		// standards: Only variables should be passed by reference".
		$metas = $this->GetMetas();
		// Moves the internal pointer to the end of the array.
		end($metas);
		// Fetches the key of the element pointed to by the internal pointer.
		return key($metas);
	}

	/**
	 * Gets the content of the last element in the metas array.
	 *
	 * @return A string.
	 */
	public function GetLastMetaContent() {
		// Fix: Define a local variable to prevent error saying "Strict
		// standards: Only variables should be passed by reference".
		$metas = $this->GetMetas();
		// Moves the internal pointer to the end of the array and fetches the
		// value of the element pointed to by the internal pointer.
		return end($metas);
	}
}
?>