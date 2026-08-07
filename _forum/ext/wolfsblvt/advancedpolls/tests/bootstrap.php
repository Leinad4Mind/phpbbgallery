<?php
/**
 *
 * Advanced Polls tests
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

// phpcs:disable PSR1.Files.SideEffects

error_reporting(E_ALL & ~E_DEPRECATED);

$project_root = dirname(__DIR__, 5);

require_once $project_root . '/vendor/autoload.php';
require_once $project_root . '/_forum/vendor/autoload.php';
require_once $project_root . '/_forum/phpbb/class_loader.php';

$phpbb_class_loader = new \phpbb\class_loader('phpbb\\', $project_root . '/_forum/phpbb/');
$phpbb_class_loader->register();

if (!defined('IN_PHPBB'))
{
	define('IN_PHPBB', true);
}
if (!defined('TOPICS_TABLE'))
{
	define('TOPICS_TABLE', 'phpbb_topics');
}
if (!defined('POLL_VOTES_TABLE'))
{
	define('POLL_VOTES_TABLE', 'phpbb_poll_votes');
}
if (!defined('POLL_OPTIONS_TABLE'))
{
	define('POLL_OPTIONS_TABLE', 'phpbb_poll_options');
}
if (!defined('POSTS_TABLE'))
{
	define('POSTS_TABLE', 'phpbb_posts');
}
if (!defined('FORUMS_TABLE'))
{
	define('FORUMS_TABLE', 'phpbb_forums');
}
if (!defined('USERS_TABLE'))
{
	define('USERS_TABLE', 'phpbb_users');
}
if (!defined('ANONYMOUS'))
{
	define('ANONYMOUS', 1);
}
if (!defined('OPTION_FLAG_BBCODE'))
{
	define('OPTION_FLAG_BBCODE', 1);
}
if (!defined('OPTION_FLAG_SMILIES'))
{
	define('OPTION_FLAG_SMILIES', 2);
}
if (!defined('ITEM_APPROVED'))
{
	define('ITEM_APPROVED', 1);
}

require_once __DIR__ . '/../core/poll_options.php';
require_once __DIR__ . '/../core/ranked_vote.php';
require_once __DIR__ . '/../core/vote_validator.php';
require_once __DIR__ . '/../core/score_distribution.php';
require_once __DIR__ . '/../core/vote_user_lifecycle.php';
require_once __DIR__ . '/../core/multi_question_payload.php';
require_once __DIR__ . '/../core/multi_question_vote.php';
require_once __DIR__ . '/../core/multi_question_manager.php';
require_once __DIR__ . '/../core/poll_option_appender.php';
require_once __DIR__ . '/../core/compatibility.php';
require_once __DIR__ . '/../core/advancedpolls.php';
require_once __DIR__ . '/../controller/infopoll.php';
require_once __DIR__ . '/../controller/multi_question.php';
require_once __DIR__ . '/../controller/poll_list.php';
require_once __DIR__ . '/../event/listener.php';
require_once __DIR__ . '/../cron/task/pollend.php';
require_once __DIR__ . '/../notification/pollended.php';
require_once __DIR__ . '/../notification/optionsadded.php';
require_once __DIR__ . '/testable_poll_option_appender.php';
require_once __DIR__ . '/testable_optionsadded.php';
require_once __DIR__ . '/../migrations/v1_3_0_schema.php';
require_once __DIR__ . '/../migrations/v1_3_0_data.php';
require_once __DIR__ . '/../migrations/v1_4_0_schema.php';
require_once __DIR__ . '/../migrations/v1_4_0_data.php';
require_once __DIR__ . '/../migrations/v1_5_0_schema.php';
require_once __DIR__ . '/../migrations/v1_6_0_schema.php';
require_once __DIR__ . '/../migrations/v1_6_0_data.php';
require_once __DIR__ . '/../acp/advancedpolls_module.php';
require_once __DIR__ . '/../ext.php';
