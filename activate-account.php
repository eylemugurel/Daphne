<?php
/**
 * @file activate-account.php
 * Contains the account activation page.
 *
 * @version 2.2
 * @date    July 1, 2019 (04:38)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

require 'autoload.php';

/**
 * Holds the value of the query parameter 'token'. If this parameter is not
 * specified, the server responds with '400 Bad Request'.
 */
$accountActivateToken = Core\GETParameter::Find('token');
if ($accountActivateToken === null)
	exit(header('HTTP/1.1 400 Bad Request'));
/**
 * Holds the username associated with the value of #$accountActivateToken. If
 * the username cannot be not found, the server responds with '403 Forbidden'.
 */
$username = Model\AccountActivate::FindUsernameByToken($accountActivateToken);
if ($username === '')
	exit(header('HTTP/1.1 403 Forbidden'));
/**
 * The global page object.
 *
 * The page is initialized with the special parameter of -1 which means that if
 * the user is already logged in, the current page is ignored and the browser is
 * automatically redirected to the home page.
 */
$gPage = new Core\Page(-1);
$gPage->SetTitle(Core\i18n::Get('ACTIVATE_ACCOUNT'));
$gPage->AddLibrary('Form');
$gPage->AddScript('app, activate-account');
$gPage->AddDialog('error');
$gPage->SetMasterpage('basic');
?>
<?php $gPage->BeginContents(); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-offset-4 col-md-4">
					<div class="panel panel-info">
						<div class="panel-body alert-info">
							<span><?php echo Core\i18n::Get('HELLO_s_YOUR_ACCOUNT_IS_BEING_ACTIVATED', $username); ?></span>
							<?php (new UI\Form('ActivateAccountForm'))
								->AddChild(new UI\FormToken)
								->AddChild((new UI\HiddenInput)
									->SetName('AccountActivateToken')
									->SetValue($accountActivateToken)
								)
								->Render(); echo PHP_EOL;
							?>
						</div>
					</div>
				</div>
			</div>
		</div><!--.container-->
<?php $gPage->EndContents(); ?>
<?php $gPage->Render(); ?>
