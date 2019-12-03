<?php
/**
 * @file test-f.php
 * Contains the functional test script.
 *
 * @version 1.1
 * @date    July 1, 2019 (05:59)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

require 'autoload.php';

$gPage = new Core\Page();
$gPage->SetTitle('Functional Test');
// Most actions require a token with the default name.
$gPage->AddToken();
// Fix: Because the Page class automatically adds a log-out token, in case the
// user is already logged in, be careful not to overwrite the existing one.
if ($gPage->FindMeta(Core\Page::LOGOUT_TOKEN_NAME) === null)
	$gPage->AddToken(Core\Page::LOGOUT_TOKEN_NAME);
// Required by the UpdatePassword test.
$gPage->AddToken('PasswordToken');
$gPage->AddScript('app, test-f');
$gPage->AddDialog('error, success');
$gPage->SetMasterpage('basic');
?>
<?php $gPage->BeginContents(); ?>
		<div class="container">
			<h3>Functional Test</h3>
			<div class="pull-right">
				<?php (new UI\Button)
					->SetId('RunButton')
					->SetIcon('fa-play')
					->SetTooltip('Run all tests')
					->SetAttribute('data-loading-text', UI\Button::DEFAULT_LOADING_TEXT)
					->Render(); echo PHP_EOL;
				?>
			</div>
			<hr>
			<div id="Output"></div>
		</div><!--.container-->
<?php $gPage->EndContents(); ?>
<?php $gPage->Render(); ?>
