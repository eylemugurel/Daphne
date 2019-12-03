<?php
/**
 * @file forgot-password.php
 * Contains the forgot password page.
 *
 * @version 2.1
 * @date    July 1, 2019 (04:40)
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
 * The global page object.
 *
 * The page is initialized with the special parameter of -1 which means that if
 * the user is already logged in, the current page is ignored and the browser is
 * automatically redirected to the home page.
 */
$gPage = new Core\Page(-1);
$gPage->SetTitle(Core\i18n::Get('FORGOT_PASSWORD'));
$gPage->AddLibrary('Form');
$gPage->AddScript('app, forgot-password');
$gPage->AddDialog('error, success');
$gPage->SetMasterpage('basic');
?>
<?php $gPage->BeginContents(); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-offset-4 col-md-4">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4><?php echo Core\i18n::Get('FORGOT_PASSWORD'); ?></h4>
						</div>
						<div class="panel-body">
							<p><?php echo Core\i18n::Get('PLEASE_ENTER_YOUR_EMAIL_ADDRESS_WE_WILL_SEND_YOU_A_LINK_TO_RESET_YOUR_PASSWORD'); ?></p>
							<?php (new UI\Form('ForgotPasswordForm'))
								->AddChild(new UI\FormToken)
								->AddChild((new UI\FormGroup)
									->SetLabel(Core\i18n::Get('EMAIL'))
									->SetInput((new UI\EmailInput)
										->SetName('Email')
										->SetRequired())
									->SetAddonIcon('glyphicon-envelope')
								)
								->AddChild((new UI\Row)
									->AddChild((new UI\Column(6))
										->SetOffset(6)
										->AddChild((new UI\SubmitButton)
											->SetId('ForgotPasswordForm_SubmitButton')
											->SetContextual('primary')
											->SetCaption(Core\i18n::Get('SEND'))
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
