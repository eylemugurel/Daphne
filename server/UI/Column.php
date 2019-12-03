<?php
/**
 * @file Column.php
 * Contains the `Column` class.
 *
 * @version 1.0
 * @date    October 18, 2019 (20:10)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

namespace UI;

/**
 * Represents a Bootstrap 'col-*' division.
 *
 * @see https://getbootstrap.com/docs/3.3/css/#grid-options
 */
class Column extends Division
{
	/**
	 * Minimum width of a column.
	 */
	const MIN_WIDTH = 1;

	/**
	 * Maximum width of a column.
	 */
	const MAX_WIDTH = 12;

	/**
	 * Format of class name.
	 */
	const CLASS_F = 'col-%s-%d';

	/**
	 * Format of offset class name.
	 */
	const OFFSET_CLASS_F = 'col-%s-offset-%d';

	/**
	 * The size name.
	 */
	private $size = '';

	/**
	 * Constructor.
	 *
	 * @param integer $width An integer in between MIN_WIDTH and MAX_WIDTH.
	 * @param string $size (optional) A size name which can be one of 'xs'
	 * (default), 'sm', 'md', or 'lg'.
	 */
	public function __construct($width, $size ='xs')
	{
		parent::__construct(sprintf(self::CLASS_F, $size, $width));
		// Keep the size in case an offset is set later.
		$this->size = $size;
	}

	/**
	 * Sets the offset.
	 *
	 * @param integer $value An integer in between MIN_WIDTH and MAX_WIDTH.
	 * @return This instance.
	 */
	public function SetOffset($value)
	{
		$this->RemoveClass($this->getOffsetClasses());
		$this->AddClass(sprintf(self::OFFSET_CLASS_F, $this->size, $value));
		return $this;
	}

	/**
	 * Builds offset class names.
	 *
	 * @return A string containing offset class names for the current size,
	 * where each class name is separated with a space.
	 */
	private function getOffsetClasses()
	{
		$classes = '';
		for ($i = self::MIN_WIDTH; $i <= self::MAX_WIDTH; ++$i) {
			if ($i > self::MIN_WIDTH)
				$classes .= ' ';
			$classes .= sprintf(self::OFFSET_CLASS_F, $this->size, $i);
		}
		return $classes;
	}
}
?>
