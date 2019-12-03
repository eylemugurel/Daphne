<?php
/**
 * @file autoload.php
 * Defines and registers project-specific autoloader function.
 *
 * @version 1.4
 * @date    May 18, 2019 (7:51)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

/**
 * Path format of a class filename.
 */
const DAPHNE_CLASS_PATH_F = 'server/%s.php';

/**
 * Loads a class.
 *
 * After this function is registered with <a href="http://php.net/manual/en/function.spl-autoload-register.php"
 * target="_blank">spl_autoload_register</a>, the following line for example:
 *
 * @code
 * new Model\Account();
 * @endcode
 *
 * would cause the function to attempt to load a class named `%Model\Account`
 * from filename `%server/Model/Account.php`.
 *
 * @param string $fqcn A fully-qualified class name.
 * @return The function returns `true` if the specified class is successfully
 * loaded. Otherwise, it returns `false`.
 */
function Daphne_Autoload($fqcn)
{
	$filename = sprintf(DAPHNE_CLASS_PATH_F, str_replace('\\', '/', $fqcn));
	if (!is_file($filename)) {
		if (Core\Config::LOG)
			Core\Log::Error(sprintf('Class file not found: %s', $filename));
		return false;
	}
	require $filename;
	return true;
}

spl_autoload_register('Daphne_Autoload');
?>