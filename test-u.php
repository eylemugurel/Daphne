<h2>Daphne Unit Test</h2>
<?php
/**
 * @file test-u.php
 * Contains the unit test script.
 *
 * @version 1.6
 * @date    July 1, 2019 (05:54)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

require 'autoload.php';

$coverage = new UnitTest\Core\Coverage;
$coverage->AddExcludedDirectoryPath('server/library');
$coverage->AddExcludedDirectoryPath('server/UnitTest');
$coverage->AddExcludedFilePath('test-u.php');
$coverage->AddExcludedFilePath('autoload.php');
$coverage->SetMinimumPercentage(85);

$test = new UnitTest\Core\Test;
$test->AddSuite(new UnitTest\Suites\Dummy\Suite);
$test->AddSuite(new UnitTest\Suites\Core_Cookies\Suite);
$test->AddSuite(new UnitTest\Suites\Core_Database\Suite);
$test->AddSuite(new UnitTest\Suites\Core_Page\Suite);
$test->AddSuite(new UnitTest\Suites\Core_Time\Suite);
$test->AddSuite(new UnitTest\Suites\Core_Response\Suite);
$test->AddSuite(new UnitTest\Suites\Model_Entity\Suite);

$coverage->Start();
$test->Run();
$coverage->Stop();
$coverage->Render();
?>
