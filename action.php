<?php
/**
 * @file action.php
 * Contains the action dispatcher script.
 *
 * The action dispatcher is a mechanism in which incoming requests are marshalled
 * to corresponding functions based on given action names. The following table
 * shows the available actions:
 *
 * Action Name           | Member Guard | Token Guard                 | Handler Function                             | Parameter(s)
 * --------------------- | ------------ | --------------------------- | ---------------------------------------------| ----------------------------
 * Dummy                 | No           | No                          | Core::Response::Success                      | -
 * LogIn                 | No           | <b>Yes</b>                  | Model::Account::Action_LogIn                 | Username, Password
 * LogOut                | <b>Yes</b>   | <b>Yes</b> (LogOutToken)    | Model::Account::Action_LogOut                | -
 * RegisterAccount       | No           | <b>Yes</b>                  | Model::Account::Action_Register              | Email, Username, Password
 * ActivateAccount       | No           | <b>Yes</b>                  | Model::Account::Action_Activate              | AccountActivateToken
 * SendPasswordResetLink | No           | <b>Yes</b>                  | Model::Account::Action_SendPasswordResetLink | Email
 * ResetPassword         | No           | <b>Yes</b>                  | Model::Account::Action_ResetPassword         | PasswordResetToken, Password
 * UpdatePassword        | <b>Yes</b>   | <b>Yes</b> (PasswordToken)  | Model::Account::Action_UpdatePassword        | Password, NewPassword
 *
 * @note If a specified action name is not in the list, the server responds
 * with Core::Error::INVALID_ACTION_NAME in the form of Core::Response::Error.
 *
 * @version 2.8
 * @date    June 7, 2020 (23:06)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2020 Eylem Ugurel. All rights reserved.
 */

require 'autoload.php';

$action = null;

switch (Core\GETParameter::Find('action'))
{
case 'Dummy':
	$action = (new Core\Action)
		->SetHandler('Core\Response::Success');
	break;
case 'LogIn':
	$action = (new Core\Action)
		->AddGuard(new Core\TokenGuard)
		->SetHandler('Model\Account::Action_LogIn')
		->AddPOSTParameter('Username')
		->AddPOSTParameter('Password');
	break;
case 'LogOut':
	$action = (new Core\Action)
		->AddGuard(new Core\MemberGuard)
		->AddGuard(new Core\TokenGuard(Core\Page::LOGOUT_TOKEN_NAME))
		->SetHandler('Model\Account::Action_LogOut');
	break;
case 'RegisterAccount':
	$action = (new Core\Action)
		->AddGuard(new Core\TokenGuard)
		->SetHandler('Model\Account::Action_Register')
		->AddPOSTParameter('Email')
		->AddPOSTParameter('Username')
		->AddPOSTParameter('Password');
	break;
case 'ActivateAccount':
	$action = (new Core\Action)
		->AddGuard(new Core\TokenGuard)
		->SetHandler('Model\Account::Action_Activate')
		->AddPOSTParameter('AccountActivateToken');
	break;
case 'SendPasswordResetLink':
	$action = (new Core\Action)
		->AddGuard(new Core\TokenGuard)
		->SetHandler('Model\Account::Action_SendPasswordResetLink')
		->AddPOSTParameter('Email');
	break;
case 'ResetPassword':
	$action = (new Core\Action)
		->AddGuard(new Core\TokenGuard)
		->SetHandler('Model\Account::Action_ResetPassword')
		->AddPOSTParameter('PasswordResetToken')
		->AddPOSTParameter('Password');
	break;
case 'UpdatePassword':
	$action = (new Core\Action)
		->AddGuard(new Core\MemberGuard)
		->AddGuard(new Core\TokenGuard('PasswordToken'))
		->SetHandler('Model\Account::Action_UpdatePassword')
		->AddPOSTParameter('Password')
		->AddPOSTParameter('NewPassword');
	break;
}

if ($action !== null)
	echo $action->Dispatch();
else
	echo Core\Response::Error(Core\Error::INVALID_ACTION_NAME);
?>
