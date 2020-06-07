<?php
/**
 * @file LoggedInAccountIdParameter.php
 * Contains the `LoggedInAccountIdParameter` class.
 *
 * @version 1.0
 * @date    June 7, 2020 (23:30)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2020 Eylem Ugurel. All rights reserved.
 */

namespace Core;

/**
 * Class that fixes 'Trying to get property of non-object' error when an hacker
 * calls an action method which tries to reach the `ID` property of a `null`
 * object returned from `GetLoggedIn` method.
 */
class LoggedInAccountIdParameter implements IParameter
{
	/**
	 * @copydoc IParameter::GetValue
	 */
	public function GetValue()
	{
		$loggedInAccount = \Model\Account::GetLoggedIn();
		if ($loggedInAccount === null)
			return 0;
		return $loggedInAccount->ID;
	}
}
?>