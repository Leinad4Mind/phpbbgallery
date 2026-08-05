<?php

$phpbb_root = dirname(__DIR__, 4);

require_once $phpbb_root . '/vendor/autoload.php';
require_once $phpbb_root . '/phpbb/config/config.php';
require_once $phpbb_root . '/phpbb/db/driver/driver_interface.php';
require_once $phpbb_root . '/phpbb/db/tools/tools_interface.php';
require_once $phpbb_root . '/phpbb/db/migration/migration_interface.php';
require_once $phpbb_root . '/phpbb/db/migration/migration.php';
require_once $phpbb_root . '/phpbb/template/template.php';
require_once $phpbb_root . '/phpbb/language/language.php';
require_once $phpbb_root . '/phpbb/event/data.php';
require_once dirname(__DIR__) . '/event/listener.php';
require_once dirname(__DIR__) . '/migrations/forumicons_install.php';
require_once dirname(__DIR__) . '/migrations/forumicons_1_1_0.php';
require_once __DIR__ . '/template_noop_token_parser.php';
