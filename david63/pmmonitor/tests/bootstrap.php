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

foreach (array(
	'IN_PHPBB' => true,
	'PRIVMSGS_HOLD_BOX' => -4,
	'PRIVMSGS_NO_BOX' => -3,
	'PRIVMSGS_OUTBOX' => -2,
	'PRIVMSGS_SENTBOX' => -1,
	'PRIVMSGS_INBOX' => 0,
) as $constant => $value)
{
	if (!defined($constant))
	{
		define($constant, $value);
	}
}

require_once dirname(__DIR__) . '/core/selection_parser.php';
require_once dirname(__DIR__) . '/core/sort_policy.php';
require_once dirname(__DIR__) . '/core/message_repository.php';
