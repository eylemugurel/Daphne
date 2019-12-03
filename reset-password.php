<?php
/**
 * @file reset-password.php
 * Contains the reset password page.
 *
 * @version 2.1
 * @date    July 1, 2019 (4:43)
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
$passwordResetToken = Core\GETParameter::Find('token');
if ($passwordResetToken === null)
	exit(header('HTTP/1.1 400 Bad Request'));
/**
 * Holds the username associated with the value of #$passwordResetToken. If
 * the username cannot be not found, the server responds with '403 Forbidden'.
 */
$username = Model\PasswordReset::FindUsernameByToken($passwordResetToken);
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
$gPage->SetTitle(Core\i18n::Get('RESET_PASSWORD'));
$gPage->AddLibrary('Form');
$gPage->AddScript('app, reset-password');
$gPage->AddDialog('error');
$gPage->SetMasterpage('basic');
?>
<?php $gPage->BeginContents(); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-offset-4 col-md-4">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4><?php echo Core\i18n::Get('RESET_PASSWORD'); ?></h4>
						</div>
						<div class="panel-body">
							<p><?php echo Core\i18n::Get('HELLO_s_PLEASE_ENTER_YOUR_NEW_PASSWORD', $username); ?></p>
							<?php (new UI\Form('ResetPasswordForm'))
								->AddChild(new UI\FormToken)
								->AddChild((new UI\HiddenInput)
									->SetName('PasswordResetToken')
									->SetValue($passwordResetToken)
								)
								->AddChild((new UI\FormGroup)
									->SetLabel(Core\i18n::Get('PASSWORD'))
									->SetInput((new UI\PasswordInput)
										->SetName('Password')
										->SetRequired())
									->SetAddonIcon('glyphicon-lock')
								)
								->AddChild((new UI\Row)
									->AddChild((new UI\Column(6))
										->SetOffset(6)
										->AddChild((new UI\SubmitButton)
											->SetId('ResetPasswordForm_SubmitButton')
											->SetContextual('primary')
											->SetCaption(Core\i18n::Get('RESET_PASSWORD'))
										)
									)
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
