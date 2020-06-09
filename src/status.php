<?php
require_once 'autoload.php';

use Application\Utils\DbTest;

$dbTest = new DbTest();
$dbTest->getStatus();