<?php

$repository_root = __DIR__;
while (dirname($repository_root) !== $repository_root && !is_dir($repository_root . '/.git'))
{
	$repository_root = dirname($repository_root);
}

$yaml_roots = array(
	$repository_root . '/_forum/vendor/symfony/yaml/',
	dirname(__DIR__, 4) . '/vendor/symfony/yaml/',
);
spl_autoload_register(function ($class_name) use ($yaml_roots)
{
	$prefix = 'Symfony\\Component\\Yaml\\';
	if (strpos($class_name, $prefix) !== 0)
	{
		return;
	}

	foreach ($yaml_roots as $yaml_root)
	{
		$file = $yaml_root . str_replace('\\', '/', substr($class_name, strlen($prefix))) . '.php';
		if (is_file($file))
		{
			require $file;

			return;
		}
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
