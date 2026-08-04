<?php

require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
require_once __DIR__ . '/utf8_stub.php';
require_once __DIR__ . '/template_noop_token_parser.php';
require_once dirname(__DIR__) . '/core/title_helper.php';
require_once dirname(__DIR__) . '/core/functions_topicindex.php';
require_once dirname(__DIR__) . '/controller/admin_controller.php';
require_once dirname(__DIR__) . '/controller/main.php';
require_once dirname(__DIR__) . '/event/listener.php';
require_once dirname(__DIR__, 3) . '/kasimi/topicindexbridge/core/bridge_manager.php';
require_once dirname(__DIR__, 3) . '/kasimi/topicindexbridge/event/main_listener.php';
