<?php
/**
 * @file login.php
 * Contains the login page.
 *
 * @version 2.1
 * @date    July 1, 2019 (04:42)
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
$gPage->SetTitle(Core\i18n::Get('LOG_IN'));
$gPage->AddLibrary('Form');
$gPage->AddScript('app, login');
$gPage->AddDialog('error');
$gPage->SetMasterpage('basic');
?>
<?php $gPage->BeginContents(); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-offset-4 col-md-4">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-6">
									<h4><?php echo Core\i18n::Get('LOG_IN'); ?></h4>
								</div>
								<div class="col-xs-6 forgot-password">
									<a class="pull-right" href="forgot-password.php"><?php echo Core\i18n::Get('FORGOT_PASSWORD'); ?></a>
								</div>
							</div>
						</div>
						<div class="panel-body">
							<?php (new UI\Form('LogInForm'))
								->AddChild(new UI\FormToken)
								->AddChild((new UI\FormGroup)
									->SetLabel(Core\i18n::Get('USERNAME'))
									->SetInput((new UI\TextInput)
										->SetName('Username')
										->SetPattern('\w+')
										->SetRequired())
									->SetAddonIcon('glyphicon-user')
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
										->AddClass('register')
										->AddChild((new UI\Anchor)
											->SetContent(Core\i18n::Get('REGISTER'))
											->SetUrl('register.php')
										)
									)
									->AddChild((new UI\Column(6))
										->AddChild((new UI\SubmitButton)
											->SetId('LogInForm_SubmitButton')
											->SetContextual('primary')
											->SetCaption(Core\i18n::Get('LOG_IN'))
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
