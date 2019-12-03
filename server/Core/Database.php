<?php
/**
 * @file Database.php
 * Contains the `Database` class.
 *
 * @version 2.2
 * @date    July 1, 2019 (20:22)
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
 * Represents a MySQL database.
 */
class Database
{
	/**
	 * The singleton `Database` instance. It is instantiated on the first call
	 * to the `GetInstance` method.
	 */
	private static $instance = null;

	/**
	 * The `mysqli` instance which represents connection to the database server.
	 */
	private $handle = null;

	/**
	 * Opens a new connection to the MySQL server, based on the configured
	 * credentials.
	 *
	 * @param bool $withName (optional) This parameter is `true` by default
	 * which causes the configured database to be used when performing queries.
	 * If this parameter is `false`, then the connection is only made to the
	 * MySQL server (e.g. for creating a new database).
	 * @remark This magic method is declared as `private` to prevent creating a
	 * new instance outside of the class via the `new` operator. Use the static
	 * method `#GetInstance` instead.
	 */
	private function __construct($withName =true)
	{
		// Fix: Use '@' operator to supress errors.
		$this->handle = @new \mysqli(Config::DATABASE_HOST,
		                             Config::DATABASE_USERNAME,
		                             Config::DATABASE_PASSWORD,
		                             $withName ? Config::DATABASE_NAME : null);
		if ($this->handle->connect_errno !== 0) {
			if (Config::LOG)
				Log::Error($this->handle->connect_error);
			$this->handle = null; // required for null-checking inside methods.
		} else {
			$this->handle->set_charset('utf8mb4');
			if (Config::LOG)
				Log::Info('Connected to database ' . $this->handle->host_info);
		}
	}

	/**
	 * This magic method is declared as `private` to prevent cloning of an
	 * instance of the class via the `clone` operator.
	 */
	private function __clone() {}

	/**
	 * This magic method is declared as `private` to prevent serializing of an
	 * instance of the class via the `serialize` global function.
	 */
	private function __sleep() {}

	/**
	 * This magic method is declared as `private` to prevent unserializing of an
	 * instance of the class via the `unserialize` global function.
	 */
	private function __wakeup() {}

	/**
	 * Closes the connection.
	 */
	public function __destruct()
	{
		if ($this->handle !== null) {
			$this->handle->close();
			$this->handle = null;
		}
	}

	/**
	 * Returns the singleton `%Database` instance.
	 *
	 * @return A `%Database` object.
	 */
	public static function GetInstance()
	{
		if (self::$instance == null) {
			self::$instance = new Database();
		}
		return self::$instance;
	}

	/**
	 * Performs query using a given query string.
	 *
	 * @param string $qs A query string.
	 * @return Returns `false` on failure. The method returns a `mysqli_result`
	 * object for successful `SELECT`, `SHOW`, `DESCRIBE` or `EXPLAIN` queries.
	 * For other successful queries, the return value is `true`.
	 */
	public function Query($qs)
	{
		if ($this->handle === null)
			return false;

		if (Config::LOG)
			Log::Info($qs);

		// Fix: Use '@' operator to supress errors.
		$result = @$this->handle->query($qs);

		if ($this->handle->errno !== 0 && Config::LOG)
			Log::Error($this->handle->error);

		return $result;
	}

	/**
	 * Returns the auto generated id produced by the last `INSERT` query.
	 *
	 * @return If the method succeeds, the return value is a non-zero integer,
	 * otherwise it's `0`.
	 */
	public function GetLastInsertID()
	{
		if ($this->handle === null)
			return 0;
		return $this->handle->insert_id;
	}

	/**
	 * Returns the number of rows affected by the last `INSERT`, `UPDATE`,
	 * `REPLACE` or `DELETE` query.
	 *
	 * @return If the method succeeds, the return value is `0` or a positive
	 * integer, otherwise it's `-1`.
	 */
	public function GetLastAffectedRowCount()
	{
		if ($this->handle === null)
			return -1;
		return $this->handle->affected_rows;
	}

	/**
	 * Encodes unsafe characters as a prevention against SQL injections.
	 *
	 * @param string $s String to be encoded.
	 * @return If the method succeeds, the return value is an encoded string,
	 * otherwise it's an empty string.
	 * @remark The following table summarizes which characters are encoded:
	 * Code | Character  | Result
	 * ---: | ---------- | ------
	 *    0 | <i>NUL</i> | \\0
	 *   10 | <i>LF</i>  | \\n
	 *   13 | <i>CR</i>  | \\r
	 *   26 | <i>SUB</i> | \\Z
	 *   34 | \"         | \\\"
	 *   39 | '          | \\'
	 *   92 | \          | \\\\
	 */
	public function EscapeString($s)
	{
		if ($this->handle === null)
			return ''; // To be on the safe side, return '' instead of $s.
		return $this->handle->real_escape_string($s);
	}

	/**
	 * Starts a transaction.
	 *
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 */
	public function BeginTransaction()
	{
		if ($this->handle === null)
			return false;
		// Because mysqli::begin_transaction appeared in PHP 5.5.0, we have to
		// use mysqli::autocommit instead to support PHP <= 5.
		//
		// Just to be clear, `autocommit` not only turns on/off transactions,
		// but will also 'commit' any waiting queries.
		return $this->handle->autocommit(false);
	}

	/**
	 * Commits and stops the current transaction.
	 *
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 */
	public function Commit()
	{
		if ($this->handle === null)
			return false;
		// Please note that calling mysqli::commit() will NOT automatically set
		// mysqli::autocommit() back to 'true'.
		return $this->handle->commit() &&
		       $this->handle->autocommit(true);
	}

	/**
	 * Rolls back the current transaction.
	 *
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 */
	public function Rollback()
	{
		if ($this->handle === null)
			return false;
		// Please note that calling mysqli::rollback() will NOT automatically
		// set mysqli::autocommit() back to 'true'.
		return $this->handle->rollback() &&
		       $this->handle->autocommit(true);
	}

	/**
	 * Creates (if not exists) a new database in the MySQL server.
	 *
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 * @remark The `Create` method obtains the database name, character set, and
	 * the collation from Config::DATABASE_NAME, Config::DATABASE_CHARSET, and
	 * Config::DATABASE_COLLATION respectively.
	 */
	public static function Create()
	{
		$database = new Database(false); // just connect to the MySQL server.
		return $database->Query(sprintf(
			'CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET %s COLLATE %s;',
			Config::DATABASE_NAME,
			Config::DATABASE_CHARSET,
			Config::DATABASE_COLLATION));
	}
}
?>
