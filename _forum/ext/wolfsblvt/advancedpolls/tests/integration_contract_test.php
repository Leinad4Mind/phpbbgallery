<?php
/**
 *
 * Advanced Polls tests
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\tests;

use PHPUnit\Framework\TestCase;
use wolfsblvt\advancedpolls\acp\advancedpolls_module;
use wolfsblvt\advancedpolls\core\poll_options;
use wolfsblvt\advancedpolls\event\listener;
use wolfsblvt\advancedpolls\ext;
use wolfsblvt\advancedpolls\migrations\v1_3_0_data;
use wolfsblvt\advancedpolls\migrations\v1_3_0_schema;
use wolfsblvt\advancedpolls\migrations\v1_4_0_data;
use wolfsblvt\advancedpolls\migrations\v1_4_0_schema;

class integration_contract_test extends TestCase
{
	public function test_listener_subscribes_every_required_phpbb_event()
	{
		$this->assertSame(array(
			'core.permissions' => 'adv_polls_permissions',
			'core.user_setup' => 'load_language_on_setup',
			'core.delete_user_before' => 'delete_user_before',
			'core.delete_topics_before_query' => 'delete_topics_before',
			'core.posting_modify_submission_errors' => 'check_config_for_polls',
			'core.posting_modify_template_vars' => 'config_for_polls_to_template',
			'core.submit_post_modify_sql_data' => 'save_config_for_polls',
			'core.submit_post_end' => 'save_multi_questions',
			'core.viewtopic_modify_poll_data' => 'do_poll_voting_modifications',
			'core.viewtopic_modify_poll_ajax_data' => 'do_poll_ajax_modifications',
			'core.viewtopic_modify_poll_template_data' => 'do_poll_template_modifications',
		), listener::getSubscribedEvents());
	}

	public function test_listener_forwards_phpbb_user_deletion_policy()
	{
		$lifecycle = $this->createMock(\wolfsblvt\advancedpolls\core\vote_user_lifecycle::class);
		$lifecycle->expects($this->once())
			->method('handle')
			->with('retain', array(7), 'Former user', array(7 => array('username' => 'Former user')));
		$listener = $this->create_listener(null, $lifecycle);

		$listener->delete_user_before(new \ArrayObject(array(
			'mode' => 'retain',
			'user_ids' => array(7),
			'retain_username' => 'Former user',
			'user_rows' => array(7 => array('username' => 'Former user')),
		)));
	}

	public function test_listener_adds_permissions_and_language_catalogues()
	{
		$listener = $this->create_listener();
		$event = new \ArrayObject(array('permissions' => array('f_vote' => array())));
		$listener->adv_polls_permissions($event);
		$this->assertSame('polls', $event['permissions']['f_seevoters']['cat']);
		$this->assertSame('misc', $event['permissions']['m_seevoters']['cat']);

		$event = new \ArrayObject(array('lang_set_ext' => array()));
		$listener->load_language_on_setup($event);
		$this->assertSame('wolfsblvt/advancedpolls', $event['lang_set_ext'][0]['ext_name']);
		$this->assertSame(array('advancedpolls', 'advancedpolls_common'), $event['lang_set_ext'][0]['lang_set']);
	}

	public function test_listener_forwards_posting_errors_and_ajax_redaction()
	{
		$core = $this->createMock(\wolfsblvt\advancedpolls\core\advancedpolls::class);
		$core->expects($this->once())
			->method('check_config_for_polls')
			->willReturn(array('invalid poll'));
		$core->expects($this->once())
			->method('do_poll_ajax_modifications')
			->willReturnCallback(function ($topic, &$data) {
				$data['results_hidden'] = true;
			});
		$listener = $this->create_listener($core);
		$event = new \ArrayObject(array(
			'poll' => array('poll_title' => 'Question'),
			'submit' => true,
			'error' => array('existing'),
		));
		$listener->check_config_for_polls($event);
		$this->assertSame(array('existing', 'invalid poll'), $event['error']);

		$event = new \ArrayObject(array(
			'topic_data' => array('topic_id' => 2),
			'data' => array('total_votes' => 9),
		));
		$listener->do_poll_ajax_modifications($event);
		$this->assertTrue($event['data']['results_hidden']);
	}

	public function test_acp_selectors_escape_labels_and_select_only_requested_value()
	{
		$module = new advancedpolls_module();
		$user = $this->createMock(\phpbb\user::class);
		$user->lang = array(
			'AP_VISIBILITY_PUBLIC' => 'Public <open>',
			'AP_VISIBILITY_DEFAULT' => 'Default',
			'AP_VISIBILITY_VOTE_COMPLETED' => 'Completed',
			'AP_VISIBILITY_PRIVATE' => 'Private',
			'AP_VOTE_MODE_NO_CHANGE' => 'No change',
			'AP_VOTE_MODE_INCREMENTAL' => 'Incremental',
			'AP_VOTE_MODE_CHANGE' => 'Change',
		);
		$property = new \ReflectionProperty($module, 'user');
		$property->setAccessible(true);
		$property->setValue($module, $user);

		$visibility = $module->select_poll_visibility(poll_options::VISIBILITY_PRIVATE, 'unused');
		$this->assertStringContainsString('Public &lt;open&gt;', $visibility);
		$this->assertStringContainsString('<option value="3" selected="selected">Private</option>', $visibility);
		$this->assertSame(1, substr_count($visibility, 'selected="selected"'));

		$vote_mode = $module->select_poll_vote_mode(poll_options::VOTE_MODE_INCREMENTAL, 'unused');
		$this->assertStringContainsString('<option value="1" selected="selected">Incremental</option>', $vote_mode);
		$this->assertSame(1, substr_count($vote_mode, 'selected="selected"'));
	}

	public function test_released_v1_3_schema_remains_stable()
	{
		$migration = $this->create_schema_migration(v1_3_0_schema::class);
		$schema = $migration->update_schema()['add_columns'];
		$columns = $schema['phpbb_topics'];

		$this->assertSame(array('UINT:1', 1), $columns['wolfsblvt_poll_visibility']);
		$this->assertSame(array('UINT:1', 0), $columns['wolfsblvt_poll_vote_mode']);
		$this->assertSame(array('UINT:1', 0), $columns['wolfsblvt_poll_type']);
		$this->assertSame(array('VCHAR:255', ''), $columns['wolfsblvt_poll_rank_points']);
		$this->assertSame(array('BOOL', 0), $columns['wolfsblvt_poll_notified']);
		$this->assertSame(array('VCHAR_UNI:255', ''), $schema['phpbb_poll_votes']['wolfsblvt_vote_user_name']);
		$this->assertArrayNotHasKey('add_tables', $migration->update_schema());
	}

	public function test_v1_4_schema_adds_and_reverts_new_feature_storage()
	{
		$migration = $this->create_schema_migration(v1_4_0_schema::class);
		$schema = $migration->update_schema()['add_columns'];
		$columns = $schema['phpbb_topics'];

		$this->assertSame(array('UINT:4', 1), $columns['wolfsblvt_poll_min_value']);
		$this->assertSame(array('BOOL', 1), $columns['wolfsblvt_poll_required']);
		$this->assertSame(array('BOOL', 0), $columns['wolfsblvt_poll_collapsible']);
		foreach (array_keys($columns) as $column)
		{
			$this->assertLessThanOrEqual(30, strlen($column), $column . ' exceeds phpBB portable identifier length');
		}
		$this->assertSame(array_keys($columns), $migration->revert_schema()['drop_columns']['phpbb_topics']);
		$this->assertSame(array('VCHAR:64', ''), $schema['phpbb_poll_votes']['wolfsblvt_vote_guest_token']);
		$this->assertSame(
			array('wolfsblvt_vote_guest_token'),
			$migration->revert_schema()['drop_columns']['phpbb_poll_votes']
		);
		$tables = $migration->update_schema()['add_tables'];
		$this->assertArrayHasKey('phpbb_advancedpolls_ballots', $tables);
		$this->assertArrayHasKey('phpbb_advancedpolls_questions', $tables);
		$this->assertSame('question_id', $tables['phpbb_advancedpolls_questions']['PRIMARY_KEY']);
	}

	public function test_v1_4_data_enables_collapsible_polls_when_categories_extension_is_installed()
	{
		$this->assert_collapsible_migration_default(array('ext_name' => 'phpbb/collapsiblecategories'), 1);
	}

	public function test_v1_4_data_disables_collapsible_polls_without_categories_extension()
	{
		$this->assert_collapsible_migration_default(false, 0);
	}

	public function test_data_migration_maps_legacy_options_and_initialises_cron()
	{
		$config = new \phpbb\config\config(array(
			'wolfsblvt.advancedpolls.default_poll_votes_hide' => 1,
			'wolfsblvt.advancedpolls.default_poll_votes_change' => 0,
			'wolfsblvt.advancedpolls.activate_incremental_votes' => 1,
		));
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$queries = array();
		$db->expects($this->exactly(5))->method('sql_query')->willReturnCallback(function ($sql) use (&$queries) {
			$queries[] = $sql;
			return true;
		});
		$migration = new v1_3_0_data(
			$config,
			$db,
			$this->createMock(\phpbb\db\tools\tools_interface::class),
			'./',
			'php',
			'phpbb_'
		);
		$steps = $migration->update_data();

		$this->assertSame(poll_options::VISIBILITY_PRIVATE, $steps[1][1][1]);
		$this->assertSame(poll_options::VOTE_MODE_INCREMENTAL, $steps[2][1][1]);
		$migration->migrate_poll_options();
		$migration->initialise_notification_cron();

		$this->assertStringContainsString('wolfsblvt_poll_visibility = 3', $queries[0]);
		$this->assertStringContainsString('wolfsblvt_poll_vote_mode = 2', $queries[1]);
		$this->assertStringContainsString('wolfsblvt_poll_vote_mode = 1', $queries[2]);
		$this->assertStringContainsString('wolfsblvt_poll_type = 1', $queries[3]);
		$this->assertStringContainsString('wolfsblvt_poll_notified = 1', $queries[4]);
		$this->assertSame(60, $config['wolfsblvt.advancedpolls.pollend_gc']);
		$this->assertGreaterThan(0, (int) $config['wolfsblvt.advancedpolls.pollend_last_gc']);
	}

	public function test_extension_lifecycle_registers_notification_type()
	{
		$container = $this->createMock(\Symfony\Component\DependencyInjection\ContainerInterface::class);
		$notifications = $this->createMock(\phpbb\notification\manager::class);
		$language = $this->createMock(\phpbb\language\language::class);
		$language->expects($this->once())
			->method('add_lang')
			->with(array('info_acp_advancedpolls', 'permissions_advancedpolls'), 'wolfsblvt/advancedpolls');
		$language->method('is_set')->willReturn(true);
		$language->method('lang')->willReturnCallback(function ($key) {
			return $key === 'AP_ENABLE_NOTICE' ? '<div>Next steps and permissions</div>' : $key;
		});
		$language_property = new \ReflectionProperty(\phpbb\language\language::class, 'lang');
		$language_property->setAccessible(true);
		$language_property->setValue($language, array('EXTENSION_ENABLE_SUCCESS' => 'Enabled'));
		$container->method('get')->willReturnCallback(function ($service) use ($notifications, $language) {
			return $service === 'notification_manager' ? $notifications : $language;
		});

		$finder = $this->createMock(\phpbb\finder::class);
		$finder->method('extension_directory')->willReturnSelf();
		$finder->method('find_from_extension')->willReturn(array());
		$finder->method('get_classes_from_files')->willReturn(array());
		$migrator = $this->createMock(\phpbb\db\migrator::class);
		$migrator->method('get_migrations')->willReturn(array());
		$migrator->method('finished')->willReturn(true);
		$extension = new ext(
			$container,
			$finder,
			$migrator,
			'wolfsblvt/advancedpolls',
			'ext/wolfsblvt/advancedpolls/'
		);

		$notifications->expects($this->once())->method('enable_notifications')
			->with('wolfsblvt.advancedpolls.notification.type.pollended');
		$this->assertSame('notifications', $extension->enable_step(''));
		$this->assertFalse($extension->enable_step('notifications'));
		$loaded_language = $language_property->getValue($language);
		$this->assertSame('Enabled<div>Next steps and permissions</div>', $loaded_language['EXTENSION_ENABLE_SUCCESS']);

		$notifications->expects($this->once())->method('disable_notifications')
			->with('wolfsblvt.advancedpolls.notification.type.pollended');
		$this->assertSame('notifications', $extension->disable_step(''));

		$notifications->expects($this->once())->method('purge_notifications')
			->with('wolfsblvt.advancedpolls.notification.type.pollended');
		$this->assertSame('notifications', $extension->purge_step(''));
	}

	private function create_listener($advancedpolls = null, $lifecycle = null)
	{
		return new listener(
			$advancedpolls ?: $this->createMock(\wolfsblvt\advancedpolls\core\advancedpolls::class),
			$lifecycle ?: $this->createMock(\wolfsblvt\advancedpolls\core\vote_user_lifecycle::class),
			$this->createMock(\wolfsblvt\advancedpolls\core\multi_question_manager::class),
			$this->createMock(\phpbb\request\request_interface::class),
			$this->createMock(\phpbb\controller\helper::class),
			new \phpbb\config\config(array('cookie_name' => 'phpbb')),
			$this->createMock(\phpbb\auth\auth::class),
			$this->createMock(\phpbb\path_helper::class),
			$this->createMock(\phpbb\template\template::class),
			$this->createMock(\phpbb\user::class)
		);
	}

	private function create_schema_migration($class)
	{
		return new $class(
			new \phpbb\config\config(array()),
			$this->createMock(\phpbb\db\driver\driver_interface::class),
			$this->createMock(\phpbb\db\tools\tools_interface::class),
			'./',
			'php',
			'phpbb_'
		);
	}

	private function assert_collapsible_migration_default($installed_row, $expected)
	{
		$config = new \phpbb\config\config(array());
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_query_limit')
			->with($this->stringContains("ext_name = 'phpbb/collapsiblecategories'"), 1)
			->willReturn('result');
		$db->expects($this->once())->method('sql_fetchrow')->with('result')->willReturn($installed_row);
		$db->expects($this->once())->method('sql_freeresult')->with('result');
		$migration = new v1_4_0_data(
			$config,
			$db,
			$this->createMock(\phpbb\db\tools\tools_interface::class),
			'./',
			'php',
			'phpbb_'
		);

		$this->assertSame('wolfsblvt.advancedpolls.activate_poll_collapsible', $migration->update_data()[0][1][0]);
		$migration->initialise_collapsible_default();
		$this->assertSame($expected, (int) $config['wolfsblvt.advancedpolls.activate_poll_collapsible']);
		$this->assertSame('wolfsblvt.advancedpolls.activate_poll_collapsible', $migration->revert_data()[0][1][0]);
	}
}
