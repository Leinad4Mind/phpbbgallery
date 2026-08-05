<?php

require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
require_once dirname(__DIR__, 4) . '/phpbb/db/migration/migration_interface.php';
require_once dirname(__DIR__, 4) . '/phpbb/db/migration/migration.php';
require_once __DIR__ . '/utf8_stub.php';
require_once __DIR__ . '/template_noop_token_parser.php';
require_once dirname(__DIR__) . '/core/title_helper.php';
require_once dirname(__DIR__) . '/core/functions_officialtopicindex.php';
require_once dirname(__DIR__) . '/controller/admin_controller.php';
require_once dirname(__DIR__) . '/controller/main.php';
require_once dirname(__DIR__) . '/event/listener.php';
require_once dirname(__DIR__) . '/migrations/officialtopicindex_schema.php';
require_once dirname(__DIR__) . '/migrations/officialtopicindex_data.php';
require_once dirname(__DIR__) . '/migrations/officialtopicindex_module.php';
require_once dirname(__DIR__) . '/migrations/officialtopicindex_1_0_3.php';
require_once dirname(__DIR__) . '/migrations/officialtopicindex_2_0_0.php';
require_once dirname(__DIR__, 3) . '/kasimi/topicindexbridge/core/bridge_manager.php';
require_once dirname(__DIR__, 3) . '/kasimi/topicindexbridge/event/main_listener.php';
