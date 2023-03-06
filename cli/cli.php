<?php

use Framework\Application;
use Framework\Enums\AppType;

include_once '../autoload.php';

$app = Application::registerApp(AppType::CLI, []);