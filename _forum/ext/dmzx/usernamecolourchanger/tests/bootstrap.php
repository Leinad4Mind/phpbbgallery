<?php
// phpcs:disable PSR1.Files.SideEffects

$phpbb_root_path = dirname(__DIR__, 4) . '/';

require_once $phpbb_root_path . 'vendor/autoload.php';
require_once $phpbb_root_path . 'phpbb/class_loader.php';

$phpbb_class_loader = new \phpbb\class_loader('phpbb\\', $phpbb_root_path . 'phpbb/');
$phpbb_class_loader->register();

require_once __DIR__ . '/config_stub.php';

if (!defined('TOPICS_TABLE'))
{
	define('TOPICS_TABLE', 'phpbb_topics');
}

if (!defined('FORUMS_TABLE'))
{
	define('FORUMS_TABLE', 'phpbb_forums');
}

require_once dirname(__DIR__) . '/core/colour_helper.php';
require_once dirname(__DIR__) . '/event/listener.php';
