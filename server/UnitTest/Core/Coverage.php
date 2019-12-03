<?php
/**
 * @file Coverage.php
 * Contains the `Coverage` class.
 *
 * @version 1.1
 * @date    June 23, 2019 (10:40)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

namespace UnitTest\Core;

class Coverage
{
	const NOT_COVERED    =  0;
	const NOT_EXECUTABLE = -2;
	const NOT_EXECUTED   = -1;
	const EXECUTED       =  1;

	const COLOR_GREY   = 'grey';
	const COLOR_YELLOW = 'papayawhip';
	const COLOR_RED    = 'pink';
	const COLOR_GREEN  = 'greenyellow';

	private $extensionLoaded = false;
	private $excludedDirectoryPaths = array();
	private $excludedFilePaths = array();
	private $minimumPercentage = 85;
	private $data = null;

	public function __construct()
	{
		$this->extensionLoaded = extension_loaded('xdebug');
	}

	public function AddExcludedDirectoryPath($value)
	{
		array_push($this->excludedDirectoryPaths, self::normalizeSlashes(
			self::getAbsolutePath($value)));
	}

	public function AddExcludedFilePath($value)
	{
		array_push($this->excludedFilePaths, self::normalizeSlashes(
			self::getAbsolutePath($value)));
	}

	public function SetMinimumPercentage($value)
	{
		$this->minimumPercentage = $value;
	}

	public function Start()
	{
		if (!$this->extensionLoaded)
			return false;
		xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
		return true;
	}

	public function Stop()
	{
		if (!$this->extensionLoaded)
			return false;
		$data = xdebug_get_code_coverage();
		xdebug_stop_code_coverage();

		$this->data = array();
		foreach ($data as $filename => $fileData) {
			$filename = self::normalizeSlashes($filename);
			if (!self::isExcluded($filename)) {
				$o = new \stdClass;
				$o->data = $fileData;
				$o->anchor = self::makeAnchor($filename);
				$this->data[$filename] = $o;
			}
		}
		uksort($this->data, 'self::filenameComparer');

		return true;
	}

	public function Render()
	{
		echo '<style>';
		echo 'th{text-align:left}';
		echo 'td:nth-child(2){border:thin solid grey}';
		echo '.x{color:'.self::COLOR_GREY.'}';
		echo '.y{background-color:'.self::COLOR_YELLOW.'}';
		echo '.r{background-color:'.self::COLOR_RED.'}';
		echo '.g{background-color:'.self::COLOR_GREEN.'}';
		echo '</style>';
		echo '<h2>Coverage Report</h2>';
		$this->renderPercentages();
		$this->renderFiles();
	}

	private function renderPercentages()
	{
		echo '<table>';
		echo '<tr><th>Filename</th><th>Percentage</th></tr>';
		foreach ($this->data as $filename => $o) {
			$fPercentage = -1.0;
			$file = @fopen($filename, 'r');
			if ($file !== false) {
				$nTotal = 0;
				$nCovered = 0;
				$nLine = 1;
				while (!feof($file)) {
					fgets($file);
					$nMode = array_key_exists($nLine, $o->data) ? $o->data[$nLine] : 0;
					if ($nMode === self::EXECUTED) {
						++$nCovered;
						++$nTotal;
					} else if ($nMode === self::NOT_EXECUTED)
						++$nTotal;
					++$nLine;
				}
				if ($nTotal !== 0)
					$fPercentage = $nCovered * 100.0 / $nTotal;
			}
			$color = $fPercentage < $this->minimumPercentage
				? self::COLOR_RED : self::COLOR_GREEN;
			$fPercentage .= '%';
			echo '<tr>';
			echo '<td><a href="#'.$o->anchor.'">' . $filename . '</a></td>';
			echo '<td style="background-color:'.$color.';display:block;width:'.$fPercentage.'">'.$fPercentage.'</td>';
			echo '</tr>';
		}
		echo '</table>';
	}

	private function renderFiles()
	{
		foreach ($this->data as $filename => $o) {
			echo '<h4 id="'.$o->anchor.'">' . $filename . '</h4>';
			$file = @fopen($filename, 'r');
			if ($file !== false) {
				$nLine = 1;
				echo "<pre>\n";
				while (!feof($file)) {
					$nMode = array_key_exists($nLine, $o->data) ? $o->data[$nLine] : 0;
					switch ($nMode)
					{
					case self::NOT_COVERED   : echo '<span class="x">'; break;
					case self::NOT_EXECUTABLE: echo '<span class="y">'; break;
					case self::NOT_EXECUTED  : echo '<span class="r">'; break;
					case self::EXECUTED      : echo '<span class="g">'; break;
					}
					$sLine = rtrim(fgets($file));
					if ($sLine !== '')
						echo htmlspecialchars($sLine, ENT_QUOTES | ENT_HTML5, 'UTF-8');
					echo "</span>\n";
					++$nLine;
				}
				echo '</pre>';
			}
		}
	}

	private function isExcluded($filename)
	{
		$s = dirname($filename);
		foreach ($this->excludedDirectoryPaths as $ss)
			if (\Core\Helper::StartsWith($s, $ss))
				return true;
		foreach ($this->excludedFilePaths as $ss)
			if ($filename === $ss)
				return true;
		return false;
	}

	private function getAbsolutePath($value)
	{
		// `getcwd` returns current working directory without an ending slash
		// e.g. "C:\wamp64\www" in Windows.
		return getcwd() . '/' . $value ;
	}

	private static function normalizeSlashes($x)
	{
		$x = str_replace('\\', '/', $x);
		$x = rtrim($x, '/');
		return $x;
	}

	private static function makeAnchor($filename)
	{
		return str_replace(array(':', '/', '.'), '-', $filename);
	}

	private static function filenameComparer($a, $b)
	{
		$i = substr_count($a, '/');
		$j = substr_count($b, '/');
		if ($j < $i) return -1;
		if ($j > $i) return 1;
		if ($a < $b) return -1;
		if ($a > $b) return 1;
		return 0;
	}
}
?>
