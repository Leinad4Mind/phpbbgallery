<?php

error_reporting(E_ALL & ~E_DEPRECATED);

$project_root = dirname(__DIR__, 5);
require_once $project_root . '/vendor/autoload.php';
require_once $project_root . '/_forum/vendor/autoload.php';
require_once $project_root . '/_forum/includes/utf/utf_tools.php';
require_once dirname(__DIR__) . '/event/listener.php';
require_once dirname(__DIR__) . '/acp/searchresults_module.php';
require_once __DIR__ . '/template_noop_token_parser.php';
