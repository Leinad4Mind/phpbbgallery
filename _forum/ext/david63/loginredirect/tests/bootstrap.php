<?php
// phpcs:disable PSR1.Files.SideEffects

$autoloaders = array(
	dirname(__DIR__, 4) . '/vendor/autoload.php',
	dirname(__DIR__, 3) . '/_forum/vendor/autoload.php',
);

foreach ($autoloaders as $autoloader)
{
	if (is_file($autoloader))
	{
		require $autoloader;
		$phpbb_root_path = dirname($autoloader, 2) . '/';
		break;
	}
}

if (!isset($phpbb_root_path) || !is_file($phpbb_root_path . 'phpbb/class_loader.php'))
{
	throw new \RuntimeException('Unable to locate the phpBB installation.');
}

require_once $phpbb_root_path . 'phpbb/class_loader.php';
$phpbb_class_loader = new \phpbb\class_loader('phpbb\\', $phpbb_root_path . 'phpbb/');
$phpbb_class_loader->register();

foreach (array('ITEM_APPROVED' => 1, 'POST_ANNOUNCE' => 2, 'POST_GLOBAL' => 3, 'USER_FOUNDER' => 3) as $constant => $value)
{
	if (!defined($constant))
	{
		define($constant, $value);
	}
}

require_once dirname(__DIR__) . '/core/redirect_policy.php';
require_once dirname(__DIR__) . '/core/topic_repository.php';
require_once dirname(__DIR__) . '/core/redirect_helper.php';
require_once dirname(__DIR__) . '/controller/main_controller.php';
