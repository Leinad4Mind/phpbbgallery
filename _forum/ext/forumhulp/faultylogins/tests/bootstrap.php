<?php

define('IN_PHPBB', true);
error_reporting(E_ALL & ~E_DEPRECATED);

$project_root = dirname(__DIR__, 5);
require_once $project_root . '/vendor/autoload.php';
require_once $project_root . '/_forum/vendor/autoload.php';
require_once $project_root . '/_forum/phpbb/config/config.php';
require_once dirname(__DIR__) . '/core/crypto_manager.php';
