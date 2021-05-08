<?php
/**
 * @file Entity.php
 * Contains the `Entity` class.
 *
 * @version 6.2
 * @date    October 8, 2020 (12:30)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2020 Eylem Ugurel. All rights reserved.
 */

namespace Model;

/**
 * Abstract base class for all model classes.
 *
 * The `%Entity` class implements the Active Record Pattern to easily retrieve,
 * update, and delete rows of database tables without struggling with raw SQL
 * query strings.
 */
abstract class Entity
{
	/**
	 * Integer that represents the primary key of the associated table record in
	 * the database.
	 */
	public $ID = 0;

	/**
	 * Add a new row to the associated database table.
	 *
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 * @remark On successful insertion, the `#$ID` property is set to the value
	 * of the auto-generated row id.
	 */
	private function insert()
	{
		$qs = sprintf('INSERT INTO %s(', self::toTableName(get_class($this)));
		foreach ($this as $pn => $pv)
			if ($pn !== 'ID')
				$qs .= $pn . ',';
		$qs = rtrim($qs, ','); // remove excess comma.
		$qs .= ')VALUES(';
		foreach ($this as $pn => $pv)
			if ($pn !== 'ID')
				$qs .= self::toSqlLiteral($pv) . ',';
		$qs = rtrim($qs, ','); // remove excess comma.
		$qs .= ');';
		if (!\Core\Database::GetInstance()->Query($qs))
			return false;
		$this->ID = \Core\Database::GetInstance()->GetLastInsertID();
		return true;
	}

	/**
	 * Modifies an existing row of the associated database table.
	 *
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 */
	private function update()
	{
		$qs = sprintf('UPDATE %s SET ', self::toTableName(get_class($this)));
		foreach ($this as $pn => $pv)
			if ($pn !== 'ID')
				$qs .= $pn . '=' . self::toSqlLiteral($pv) . ',';
		$qs = rtrim($qs, ','); // remove excess comma.
		$qs .= sprintf(' WHERE ID=%d;', $this->ID);
		if (!\Core\Database::GetInstance()->Query($qs))
			return false;
		// Fix: The UPDATE statement succeeds even if the WHERE condition fails.
		// As a workaround, the `affected_rows` property of mysqli must also be
		// checked.
		if (\Core\Database::GetInstance()->GetLastAffectedRowCount() === -1)
			return false;
		return true;
	}

	/**
	 * Determines whether the entity is insertable by checking if `#$ID` equals
	 * to `0`.
	 *
	 * @return If the entity is insertable, the return value is `true`, otherwise
	 * it's `false`.
	 */
	private function isInsertable()
	{
		return $this->ID === 0;
	}

	/**
	 * Determines whether the entity is updateable by checking if the entity is
	 * saved in the associated database table.
	 *
	 * @return If the entity is updateable, the return value is `true`, otherwise
	 * it's `false`.
	 */
	private function isUpdateable()
	{
		$result = false;
		$qs = sprintf('SELECT COUNT(ID) FROM %s WHERE ID=%d LIMIT 1;',
			self::toTableName(get_class($this)), $this->ID);
		$qr = \Core\Database::GetInstance()->Query($qs);
		if ($qr) {
			$row = $qr->fetch_assoc();
			if ($row !== null)
				$result = (int)reset($row) === 1;
			$qr->free();
		}
		return $result;
	}

	/**
	 * Executes a given query string resulting a single entity.
	 *
	 * @param string $selectStatement A `SELECT` statement.
	 * @return If the method succeeds, the return value is an `%Entity` instance.
	 * @return If the method fails, the return value is `null`.
	 */
	private static function selectOne($selectStatement)
	{
		$e = null;
		$qr = \Core\Database::GetInstance()->Query($selectStatement);
		if ($qr) {
			$row = $qr->fetch_assoc(); // expecting single row, or null.
			if ($row !== null) {
				$e = new static();
				foreach ($e as $pn => $pv)
					if (array_key_exists($pn, $row))
						$e->$pn = self::toTargetValue($row[$pn], $pv);
			}
			$qr->free();
		}
		return $e;
	}

	/**
	 * Executes a given query string resulting an array of entities.
	 *
	 * @param string $selectStatement A `SELECT` statement.
	 * @return If the method succeeds, the return value is an array of `%Entity`
	 * instances.
	 * @return If the method fails, the return value is an empty array.
	 */
	private static function selectMany($selectStatement)
	{
		$ae = array();
		$qr = \Core\Database::GetInstance()->Query($selectStatement);
		if ($qr) {
			while ($row = $qr->fetch_assoc()) {
				$e = new static();
				foreach ($e as $pn => $pv)
					if (array_key_exists($pn, $row))
						$e->$pn = self::toTargetValue($row[$pn], $pv);
				array_push($ae, $e);
			}
			$qr->free();
		}
		return $ae;
	}

	/**
	 * Saves contents to the associated database table.
	 *
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 * @remarks If `#$ID` equals to `0`, the `Save` method adds a new row.
	 * Otherwise, it modifies an existing row.
	 */
	public function Save()
	{
		if ($this->isInsertable())
			return $this->insert();
		if ($this->isUpdateable())
			return $this->update();
		return false;
	}

	/**
	 * Deletes the row from the associated database table.
	 *
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 * @remark On successful deletion, the `#$ID` property is set to `0`.
	 */
	public function Delete()
	{
		$qs = sprintf('DELETE FROM %s WHERE ID=%d;',
			self::toTableName(get_class($this)), $this->ID);
		if (!\Core\Database::GetInstance()->Query($qs))
			return false;
		// Fix: The DELETE statement succeeds even if the WHERE condition fails.
		// As a workaround, the `affected_rows` property of mysqli must also be
		// checked.
		if (\Core\Database::GetInstance()->GetLastAffectedRowCount() !== 1)
			return false;
		$this->ID = 0;
		return true;
	}

	/**
	 * Retrieves an entity by its id, from the associated database table.
	 *
	 * @param integer $id An entity identifier.
	 * @return If the method succeeds, the return value is an `%Entity` instance.
	 * @return If the method fails, the return value is `null`.
	 */
	public static function FindById($id)
	{
		$qs = sprintf('SELECT * FROM %s WHERE ID=%d LIMIT 1;',
			self::toTableName(get_called_class()), $id);
		return self::selectOne($qs);
	}

	/**
	 * Retrieves an entity matching a given condition from the associated
	 * database table.
	 *
	 * @param string $condition (optional) A condition. If not specified, the
	 * first entity is returned.
	 * @param string $orderBy (optional) Column name followed by optional `ASC`
	 * or `DESC` keywords. The resulting array is first sorted by the given
	 * column in ascending or descending order (if no `ASC` or `DESC` keyword
	 * follows the column name, sorts in ascending order by default. If this
	 * parameter is not specified, no sorting takes place), then the first
	 * entity from the result is returned.
	 * @return If the method succeeds, the return value is an `%Entity` instance.
	 * @return If the method fails, the return value is `null`.
	 * @todo Implement `orderBy` parameter.
	 */
	public static function FindOne($condition ='', $orderBy ='')
	{
		$qs = sprintf('SELECT * FROM %s',
			self::toTableName(get_called_class()));
		if ($condition !== '')
			$qs .= ' WHERE ' . $condition;
		if ($orderBy !== '')
			$qs .= ' ORDER BY ' . $orderBy;
		$qs .= ' LIMIT 1;';
		return self::selectOne($qs);
	}

	/**
	 * Retrieves an array of entities matching a given condition, in a given
	 * order, and with a limit on the number of the resulting set, from the
	 * associated database table.
	 *
	 * @param string $condition (optional) A condition. If not specified, all
	 * entities are returned.
	 * @param string $orderBy (optional) Column name followed by optional `ASC`
	 * or `DESC` keywords. The resulting array is sorted by the given column in
	 * ascending or descending order. If no `ASC` or `DESC` keyword follows the
	 * column name, sorts in ascending order by default. If this parameter is
	 * not specified, no sorting takes place.
	 * @param integer $limit (optional) Number of entities to retrieve. If not
	 * specified, there is no limit on the number of entities.
	 * @return The method returns an array of `%Entity` instances. There is no
	 * error return.
	 */
	public static function FindMany($condition ='', $orderBy ='', $limit =-1)
	{
		$qs = sprintf('SELECT * FROM %s',
			self::toTableName(get_called_class()));
		if ($condition !== '')
			$qs .= ' WHERE ' . $condition;
		if ($orderBy !== '')
			$qs .= ' ORDER BY ' . $orderBy;
		if ($limit !== -1)
			$qs .= ' LIMIT ' . $limit;
		$qs .= ';';
		return self::selectMany($qs);
	}

	/**
	 * Returns the number of rows from the associated database table, matching a
	 * given condition.
	 *
	 * @param string $condition (optional) The condition. If not specified, all
	 * rows are counted.
	 * @return If the method succeeds, the return value is an integer specifying
	 * number of rows.
	 * @return If the method fails, the return value is `0`.
	 */
	public static function GetCount($condition ='')
	{
		$count = 0;
		$qs = sprintf('SELECT COUNT(ID) FROM %s',
			self::toTableName(get_called_class()));
		if ($condition !== '')
			$qs .= ' WHERE ' . $condition;
		$qs .= ';';
		$qr = \Core\Database::GetInstance()->Query($qs);
		if ($qr) {
			$row = $qr->fetch_assoc();
			if ($row !== null)
				$count = (int)reset($row);
			$qr->free();
		}
		return $count;
	}

	/**
	 * Returns the average value of a given column from the associated database
	 * table, matching a given condition.
	 *
	 * @param string $columnName Column name, which also equals to a property
	 * name of the entity class.
	 * @param string $condition (optional) The condition. If not specified, the
	 * average of all rows is calculated.
	 * @return If the method succeeds, the return value is a floating-point
	 * value specifying the average.
	 * @return If the method fails, the return value is `0.0`.
	 */
	public static function GetAverage($columnName, $condition ='')
	{
		$average = 0.0;
		$qs = sprintf('SELECT AVG(%s) FROM %s',
			$columnName, self::toTableName(get_called_class()));
		if ($condition !== '')
			$qs .= ' WHERE ' . $condition;
		$qs .= ';';
		$qr = \Core\Database::GetInstance()->Query($qs);
		if ($qr) {
			$row = $qr->fetch_assoc();
			if ($row !== null)
				$average = (double)reset($row);
			$qr->free();
		}
		return $average;
	}

	/**
	 * Returns the range (minimum and maximum) values of a given column from the
	 * associated database table, matching a given condition.
	 *
	 * @param string $columnName Column name, which also equals to a property
	 * name of the entity class.
	 * @param string $condition (optional) The condition. If not specified, the
	 * range for all rows is calculated.
	 * @return If the method succeeds, the return value is an object with the
	 * properties `Min` and `Max`, where each has a type same as the type of the
	 * specified column.
	 * @return If the method fails, the return value is an object with the
	 * properties `Min` and `Max` with `null` values.
	 */
	public static function GetRange($columnName, $condition ='')
	{
		$range = new \stdClass();
		$range->Min = null;
		$range->Max = null;
		$qs = sprintf('SELECT MIN(%s) AS Min,MAX(%s) AS Max FROM %s',
			$columnName, $columnName, self::toTableName(get_called_class()));
		if ($condition !== '')
			$qs .= ' WHERE ' . $condition;
		$qs .= ';';
		$qr = \Core\Database::GetInstance()->Query($qs);
		if ($qr) {
			$row = $qr->fetch_assoc();
			if ($row !== null) {
				$e = new static(); // temporary entity for introspection.
				$min = $row['Min'];
				$max = $row['Max'];
				// Fix: If the type of column is `BIT`, then `MIN` and `MAX`
				// returns "48" and "49" for `true` and `false` respectively.
				// These are character codes for "0" and "1" and must be
				// converted beforehands.
				if (self::toSqlTypeName($e->$columnName) === 'BIT') {
					if ($min !== null) $min = chr($min);
					if ($max !== null) $max = chr($max);
				}
				$range->Min = self::toTargetValue($min, $e->$columnName);
				$range->Max = self::toTargetValue($max, $e->$columnName);
			}
			$qr->free();
		}
		return $range;
	}

	/**
	 * @brief Removes specified properties from the object.
	 *
	 * @param string|array $pns Name, or array of names of properties to remove.
	 * To remove all properties, specify an empty string or an empty array.
	 * @remark The `ID` property cannot be removed.
	 */
	public function RemoveProperties($pns)
	{
		if (is_string($pns)) {
			foreach ($this as $pn => $pv)
				if ($pn !== 'ID' && $pn === $pns)
					unset($this->$pn);
		} else if (is_array($pns)) {
			foreach ($this as $pn => $pv)
				if ($pn !== 'ID' && in_array($pn, $pns))
					unset($this->$pn);
		}
	}

	/**
	 * @brief Removes properties from the object except the specified ones.
	 *
	 * @param string|array $pns Name, or array of names of properties to exclude
	 * from removal.
	 * @remark Because the `ID` property cannot be removed, it's unnecessary to
	 * specify it in the parameter.
	 */
	public function RemovePropertiesExcept($pns)
	{
		if (is_string($pns)) {
			foreach ($this as $pn => $pv)
				if ($pn !== 'ID' && $pn !== $pns)
					unset($this->$pn);
		} else if (is_array($pns)) {
			foreach ($this as $pn => $pv)
				if ($pn !== 'ID' && !in_array($pn, $pns))
					unset($this->$pn);
		}
	}

	/**
	 * Creates (if not exists) the associated database table.
	 *
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 */
	public static function CreateTable()
	{
		$qs = sprintf('CREATE TABLE IF NOT EXISTS %s(ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY',
			self::toTableName(get_called_class()));
		foreach (new static() as $pn => $pv) // temporary entity for introspection.
			if ($pn !== 'ID')
				$qs .= sprintf(',%s %s', $pn, self::toSqlTypeName($pv));
		$qs .= ')ENGINE=InnoDB;';
		return \Core\Database::GetInstance()->Query($qs);
	}

	/**
	 * Deletes (if exists) the associated database table.
	 *
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 */
	public static function DeleteTable()
	{
		$qs = sprintf('DROP TABLE IF EXISTS %s;',
			self::toTableName(get_called_class()));
		return \Core\Database::GetInstance()->Query($qs);
	}

	/**
	 * Resets (truncates) the associated database table.
	 *
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 */
	public static function ResetTable()
	{
		$qs = sprintf('TRUNCATE TABLE %s;',
			self::toTableName(get_called_class()));
		return \Core\Database::GetInstance()->Query($qs);
	}

	/**
	 * Creates a new, or replaces an existing view, defined by a given `SELECT`
	 * statement.
	 *
	 * @param string $selectStatement A `SELECT` statement that defines the
	 * view. The statement doesn't have to end with a semicolon (;).
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 * @remark Since this method requires a `SELECT` statement, implement a
	 * static method named `CreateView` in derived class and call this method,
	 * e.g. `parent::createViewWith`, passing a valid `SELECT` statement.
	 */
	protected static function createViewWith($selectStatement)
	{
		$qs = sprintf('CREATE OR REPLACE VIEW %s AS %s;',
			self::toTableName(get_called_class()), $selectStatement);
		return \Core\Database::GetInstance()->Query($qs);
	}

	/**
	 * Deletes (if exists) the associated database view.
	 *
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 */
	public static function DeleteView()
	{
		$qs = sprintf('DROP VIEW IF EXISTS %s;',
			self::toTableName(get_called_class()));
		return \Core\Database::GetInstance()->Query($qs);
	}

	/**
	 * Returns MySQL data type name of a PHP value.
	 *
	 * @param $value A value which can be of the types: `boolean`, `integer`,
	 * `double`, `string`, or `Time`.
	 * @return If the method succeeds, the return value is one of: `BIT`, `INT`,
	 * `DOUBLE`, `TEXT`, or `DATETIME`.
	 * @return If the method fails because `$value` has an unsupported type,
	 * the return value is an empty string.
	 */
	protected static function toSqlTypeName($value)
	{
		switch (gettype($value))
		{
		case 'boolean': return 'BIT';
		case 'integer': return 'INT';
		case 'double' : return 'DOUBLE';
		case 'string' : return 'TEXT';
		case 'object' :
			// Note that the PHP `DateTime` class is not supported.
			if ($value instanceof \Core\Time)
				return 'DATETIME';
		}
		return ''; // unsupported type
	}

	/**
	 * Converts a given value to a MySQL literal.
	 *
	 * The `toSqlLiteral` method gives derived classes a convenient and safe way
	 * of using PHP values inside SQL statements. It does it so my converting
	 * PHP values to equivalent MySQL literals while preventing SQL injections.
	 *
	 * @param $value A value which can be of the types: `boolean`, `integer`,
	 * `double`, `string`, or `Time`.
	 * @return If the method succeeds, the return value is a MySQL literal.
	 * @return If the method fails because `$value` has an unsupported type,
	 * the return value is an empty string.
	 * @remark The `toSqlLiteral` method prevents SQL injections by escaping
	 * special characters in a string using
	 * <a href="https://www.php.net/manual/en/mysqli.real-escape-string.php" target="_blank">real_escape_string</a>.
	 */
	protected static function toSqlLiteral($value)
	{
		switch (self::toSqlTypeName($value))
		{
		case 'BIT':
			return $value ? 1 : 0;
		case 'INT':
		case 'DOUBLE':
			return $value;
		case 'TEXT':
			// Filter SQL injections using `real_escape_string`, then enclose
			// with single quotes.
			return "'" . \Core\Database::GetInstance()->EscapeString($value) . "'";
		case 'DATETIME':
			return "'" . $value->ToMySQLString() . "'";
		}
		return ''; // unsupported type
	}

	/**
	 * Converts a given value to the value of an entity property where the
	 * resulting type is obtained from a given "hint" value, which normally
	 * equals to the existing value of that property.
	 *
	 * @param $value Value to convert.
	 * @param $hint Value from which the resulting type is obtained.
	 * @return If the method succeeds, the return value can be of the types:
	 * `boolean`, `integer`, `double`, `string`, or `Time`.
	 * @return If the method fails because `$hint` has an unsupported type,
	 * the return value is `null`.
	 * @remark The `toTargetValue` method prevents Cross Site Scripting (XSS)
	 * attacks by removing HTML and PHP tags from a string using
	 * <a href="https://www.php.net/manual/en/function.strip-tags.php" target="_blank">strip_tags</a>,
	 * and by converting special characters to HTML entities using
	 * <a href="https://www.php.net/manual/en/function.htmlspecialchars.php" target="_blank">htmlspecialchars</a>.
	 */
	protected static function toTargetValue($value, $hint)
	{
		switch (self::toSqlTypeName($hint))
		{
		case 'BIT':
			return (bool)$value;
		case 'INT':
			return (integer)$value;
		case 'DOUBLE':
			return (double)$value;
		case 'TEXT':
			// Fix: To be on the safe side, no HTML tags are rendered. However
			// they still exist in the database.
			$value = strip_tags($value);
			// Fix: Filter the output data. Storing special characters (& ' " < >)
			// in the database will not cause any problems, so `toSqlLiteral`
			// only filters against MySQL injections using `real_escape_string`.
			// However during rendering, `htmlspecialchars` is used to convert
			// special characters to HTML entities (e.g. &amp; &apos; &quot;
			// &lt; &gt;).
			$value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
			//
			return $value;
		case 'DATETIME':
			return \Core\Time::FromMySQLString($value);
		}
		return null; // unsupported type
	}

	/**
	 * Returns the table name of a given class name.
	 *
	 * @param $className A fully qualified class name, that can contain one or
	 * more namespaces in it, e.g. `"Model\Account"`.
	 * @return Table name, e.g. `"Account"` for the example above.
	 */
	protected static function toTableName($className)
	{
		$iSlash = strrpos($className, '\\');
		if ($iSlash === false)
			return $className;
		return substr($className, $iSlash + 1);
	}

	/**
	 *
	 */
	protected static function prepareSql($format/*, ...*/)
	{
		$args = func_get_args();
		if (count($args) > 1) {
			array_shift($args); // remove the first parameter, which is `$format`.
			$i = 1;
			foreach ($args as $arg)
				$format = str_replace('@'.$i++, self::toSqlLiteral($arg), $format);
		}
		return $format;
	}
}
?>
