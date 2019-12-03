<?php
/**
 * @file MemberGuard.php
 * Contains the `MemberGuard` class.
 *
 * @version 1.0
 * @date    October 27, 2019 (7:23)
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
 *
 */
class MemberGuard implements IGuard
{
	/**
	 *
	 */
	public function Check()
	{
		return \Model\Account::IsLoggedIn();
	}
}
?>