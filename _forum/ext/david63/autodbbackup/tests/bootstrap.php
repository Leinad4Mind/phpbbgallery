<?php

$yaml_root = dirname(__DIR__, 4) . '/vendor/symfony/yaml/';
spl_autoload_register(function ($class_name) use ($yaml_root)
{
	$prefix = 'Symfony\\Component\\Yaml\\';
	if (strpos($class_name, $prefix) !== 0)
	{
		return;
	}

	$file = $yaml_root . str_replace('\\', '/', substr($class_name, strlen($prefix))) . '.php';
	if (is_file($file))
	{
		require $file;
	}
});

require __DIR__ . '/stubs/db_text.php';
require __DIR__ . '/stubs/filesystem.php';
require __DIR__ . '/stubs/cron_base.php';
require __DIR__ . '/stubs/version_compare.php';
require dirname(__DIR__) . '/core/backup_policy.php';
require dirname(__DIR__) . '/core/backup_registry.php';
require dirname(__DIR__) . '/core/functions.php';
require dirname(__DIR__) . '/cron/task/auto_db_backup.php';
