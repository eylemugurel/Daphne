<?php
/**
 * @file index.php
 * Contains the home page.
 *
 * @version 2.3
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
 * @brief The global page object.
 *
 * The object is initialized without any authorization, which means that it's
 * available for both logged-in and anonymous users.
 *
 * @note The name "gPage" for this variable is mandatory because it's referenced
 * by other components of the framework.
 */
$gPage = new Core\Page();
$gPage->SetDescription(Core\Config::DESCRIPTION);
$gPage->SetSocialImageUrl(Core\Config::GetLogoImageURL(true));
$gPage->AddScript('app, index');
$gPage->AddDialog('error');
$gPage->SetMasterpage('starter');

/**
 * @brief Holds the `Model::Account` object of the logged-in user, or `null` if
 * the page is being visited anonymously.
 *
 * Parts of the page get rendered conditionally according to this value.
 */
$loggedInAccount = $gPage->GetLoggedInAccount();
?>
<?php $gPage->BeginContents(); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
<?php if ($loggedInAccount !== null): ?>
					<p><?php echo Core\i18n::Get('HELLO_s', $loggedInAccount->Username); ?></p>
<?php else: ?>
					<p><?php echo Core\i18n::Get('HELLO_WORLD'); ?></p>
<?php endif; ?>
				</div>
			</div>
		</div><!--.container-->
<?php $gPage->EndContents(); ?>
<?php $gPage->Render(); ?>
