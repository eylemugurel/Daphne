<h2>Daphne Installer</h2>
<?php
/**
 * @file install.php
 * Contains the installation script.
 *
 * @version 2.0
 * @date    July 10, 2019 (20:08)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

require 'autoload.php';

$installer = new Core\Installer();

$installer->AddTable('Model\\Account');
$installer->AddTable('Model\\AccountActivate');
$installer->AddTable('Model\\PasswordReset');
$installer->AddTableResetData('Model\\Account', array(
	array(
		'Email' => 'testuser@example.com',
		'Username' => 'testuser',
		'PasswordHash' => '$2a$08$Qu5NdZZ6Hy4.uahE98PI4OIV1aLcuZsPJQm.Thu4PMP1zx.44mgzu' // 724Abc!
	)
));

$installer->Run();
?>
