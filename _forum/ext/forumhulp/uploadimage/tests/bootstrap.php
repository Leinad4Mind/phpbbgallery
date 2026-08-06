<?php

error_reporting(E_ALL & ~E_DEPRECATED);

$project_root = dirname(__DIR__, 5);
require_once $project_root . '/vendor/autoload.php';
require_once $project_root . '/_forum/vendor/autoload.php';
require_once $project_root . '/_forum/phpbb/class_loader.php';
$phpbb_class_loader = new \phpbb\class_loader('phpbb\\', $project_root . '/_forum/phpbb/');
$phpbb_class_loader->register();

require_once dirname(__DIR__) . '/controller/admin_controller.php';
require_once dirname(__DIR__) . '/acp/uploadimage_module.php';
require_once __DIR__ . '/template_noop_token_parser.php';
