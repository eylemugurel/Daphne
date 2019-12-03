<?php
/**
 * @file Installer.php
 * Contains the `Installer` class.
 *
 * @version 1.1
 * @date    November 27, 2019 (15:58)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

namespace Core;

/**
 * Installs the application to the database.
 */
class Installer
{
	/**
	 * Text message to display when the installer is started.
	 */
	const INSTALLER_STARTED = '<b>Installer started.</b>';
	/**
	 * Text message format to display when creating the database.
	 */
	const CREATING_DATABASE_F = 'Creating database <i>%s</i>...';
	/**
	 * Text message format to display when creating a table.
	 */
	const CREATING_TABLE_F = 'Creating table <i>%s</i>...';
	/**
	 * Text message format to display when creating a view.
	 */
	const CREATING_VIEW_F = 'Creating view <i>%s</i>...';
	/**
	 * Text message format to display when resetting a table with data.
	 */
	const RESETTING_TABLE_DATA_F = 'Resetting table <i>%s</i> with <i>%d</i> row(s) of data...';
	/**
	 * Text message to display when something goes wrong.
	 */
	const FAILED = '&emsp;<font color="red">Failed!</font>';
	/**
	 * Text message format to display the installer is finished.
	 */
	const INSTALLER_FINISHED = '<b>Installer finished.</b>';

	/**
	 * Array of table names which can be populated through the `AddTable` method.
	 */
	private $tableNames = array();

	/**
	 * Array of view names which can be populated through the `AddView` method.
	 */
	private $viewNames = array();

	/**
	 * Array of table names associated with predefined data, which can be
	 * populated through the `AddTableResetData` method.
	 */
	private $tableResetData = array();

	/**
	 * Adds a table to be created.
	 *
	 * @param string $name Fully-qualified name of an `Entity` derived class,
	 * e.g. '%Model\\\\Person'. Note that the scope symbol (\\) must be
	 * escaped (\\\\).
	 */
	public function AddTable($name)
	{
		array_push($this->tableNames, $name);
	}

	/**
	 * Adds a view to be created.
	 *
	 * @param string $name Fully-qualified name of an `Entity` derived class,
	 * e.g. '%Model\\\\PersonView'. Note that the scope symbol (\\) must be
	 * escaped (\\\\).
	 */
	public function AddView($name)
	{
		array_push($this->viewNames, $name);
	}

	/**
	 * Adds a table to be truncated and initialized with given data.
	 *
	 * @param string $name Fully-qualified name of an `Entity` derived class,
	 * e.g. '%Model\\\\Person'. Note that the scope symbol (\\) must be
	 * escaped (\\\\).
	 * @param array $data Array of rows where each row consisting of an array of
	 * column name/value pairs.
	 */
	public function AddTableResetData($name, $data)
	{
		$this->tableResetData[$name] = $data;
	}

	/**
	 * Runs the installer.
	 */
	public function Run()
	{
		Helper::Output(self::INSTALLER_STARTED);
		if (!self::createDatabase()) {
			return;
		}
		foreach ($this->tableNames as $tableName) {
			if (!self::createTable($tableName)) {
				return;
			}
		}
		foreach ($this->viewNames as $viewName) {
			if (!self::createView($viewName)) {
				return;
			}
		}
		foreach ($this->tableResetData as $tableName => $data) {
			if (!self::resetTableData($tableName, $data)) {
				return;
			}
		}
		Helper::Output(self::INSTALLER_FINISHED);
	}

	/**
	 * Creates (if not exists) the configured database.
	 *
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 * @see Config::DATABASE_NAME
	 */
	private static function createDatabase()
	{
		Helper::Output(self::CREATING_DATABASE_F, Config::DATABASE_NAME);
		if (!Database::Create()) {
			Helper::Output(self::FAILED);
			return false;
		}
		return true;
	}

	/**
	 * Creates (if not exists) the given table.
	 *
	 * @param string $name Fully-qualified name of an `Entity` derived class.
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 */
	private static function createTable($name)
	{
		Helper::Output(self::CREATING_TABLE_F, $name);
		if (!$name::CreateTable()) {
			Helper::Output(self::FAILED);
			return false;
		}
		return true;
	}

	/**
	 * Creates (if not exists) the given view.
	 *
	 * @param string $name Fully-qualified name of an `Entity` derived class.
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 */
	private static function createView($name)
	{
		Helper::Output(self::CREATING_VIEW_F, $name);
		if (!$name::CreateView()) {
			Helper::Output(self::FAILED);
			return false;
		}
		return true;
	}

	/**
	 * Resets (truncates) the given table and populates with the given data.
	 *
	 * @param string $name Fully-qualified name of an `Entity` derived class.
	 * @param array $data Array of rows where each row consisting of an array of
	 * column name/value pairs.
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 */
	private static function resetTableData($name, $data)
	{
		Helper::Output(self::RESETTING_TABLE_DATA_F, $name, count($data));
		if (!$name::ResetTable()) {
			Helper::Output(self::FAILED);
			return false;
		}
		$e = new $name();
		foreach ($data as $row) {
			$e->ID = 0;
			foreach ($e as $pn => $pv) {
				if (array_key_exists($pn, $row)) {
					$e->$pn = $row[$pn];
				}
			}
			if (!$e->Save()) {
				return false;
			}
		}
		return true;
	}
}
?>
