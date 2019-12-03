<?php
/**
 * @file settings.php
 * Contains the settings page.
 *
 * @version 2.1
 * @date    July 1, 2019 (05:52)
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
 * The page is initialized with authorization, which means that it's only
 * available for logged-in users. For anonymous users, the browser is
 * automatically redirected to the login page.
 */
$gPage = new Core\Page(true);
$gPage->SetTitle(Core\i18n::Get('SETTINGS'));
$gPage->AddLibrary('VerticalTabs, Form');
$gPage->AddScript('app, settings');
$gPage->AddDialog('error, success');
$gPage->SetMasterpage('starter');
?>
<?php $gPage->BeginContents(); ?>
		<div class="container">
			<h3><?php echo Core\i18n::Get('SETTINGS'); ?></h3>
			<br>
			<div class="row">
				<div class="col-md-2">
					<ul class="nav nav-tabs tabs-left">
						<li class="active"><a href="#Tab1" data-toggle="tab"><?php echo Core\i18n::Get('PASSWORD'); ?></a></li>
						<!--
						<li><a href="#Tab2" data-toggle="tab">Tab 2</a></li>
						-->
					</ul>
				</div><!--.col-md-2-->
				<div class="col-md-10">
					<div class="tab-content">
						<div id="Tab1" class="tab-pane active">
							<div class = "row">
							<div class="col-md-4">
								<form id="PasswordForm" class="form-horizontal" autocomplete="off">
									<?php (new UI\FormToken('PasswordToken'))
										->Render(); echo PHP_EOL;
									?>
									<div class="form-group">
										<label class="col-xs-3 control-label"><?php echo Core\i18n::Get('CURRENT'); ?></label>
										<div class="col-xs-9">
											<?php (new UI\PasswordInput)
												->SetName('Password')
												->SetRequired()
												->Render(); echo PHP_EOL;
											?>
											<div class="help-block with-errors"></div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-xs-3 control-label"><?php echo Core\i18n::Get('NEW'); ?></label>
										<div class="col-xs-9">
											<?php (new UI\PasswordInput)
												->SetName('NewPassword')
												->SetRequired()
												->Render(); echo PHP_EOL;
											?>
											<div class="help-block with-errors"></div>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-offset-8 col-xs-4">
											<?php (new UI\SubmitButton)
												->SetId('PasswordForm_SubmitButton')
												->SetContextual('success')
												->SetCaption(Core\i18n::Get('UPDATE'))
												->Render(); echo PHP_EOL;
											?>
										</div>
									</div>
								</form>
							</div><!--.col-md-4-->
							</div>
						</div><!--#Tab1-->
						<!--
						<div id="Tab2" class="tab-pane">
							<p>Tab 2</p>
						</div>
						-->
					</div><!--.tab-content-->
				</div><!--.col-md-10-->
				<div class="clearfix"></div>
			</div><!--.row-->
		</div><!--.container-->
<?php $gPage->EndContents(); ?>
<?php $gPage->Render(); ?>
