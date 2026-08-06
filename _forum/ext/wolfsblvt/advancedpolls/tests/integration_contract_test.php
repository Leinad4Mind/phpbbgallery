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

class integration_contract_test extends TestCase
{
	public function test_listener_subscribes_every_required_phpbb_event()
	{
		$this->assertSame(array(
			'core.permissions' => 'adv_polls_permissions',
			'core.user_setup' => 'load_language_on_setup',
			'core.posting_modify_submission_errors' => 'check_config_for_polls',
			'core.posting_modify_template_vars' => 'config_for_polls_to_template',
			'core.submit_post_modify_sql_data' => 'save_config_for_polls',
			'core.viewtopic_modify_poll_data' => 'do_poll_voting_modifications',
			'core.viewtopic_modify_poll_ajax_data' => 'do_poll_ajax_modifications',
			'core.viewtopic_modify_poll_template_data' => 'do_poll_template_modifications',
		), listener::getSubscribedEvents());
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

	public function test_schema_migration_adds_and_reverts_portable_topic_columns()
	{
		$migration = $this->create_schema_migration();
		$columns = $migration->update_schema()['add_columns']['phpbb_topics'];

		$this->assertSame(array('UINT:1', 1), $columns['wolfsblvt_poll_visibility']);
		$this->assertSame(array('UINT:1', 0), $columns['wolfsblvt_poll_vote_mode']);
		$this->assertSame(array('BOOL', 0), $columns['wolfsblvt_poll_notified']);
		foreach (array_keys($columns) as $column)
		{
			$this->assertLessThanOrEqual(30, strlen($column), $column . ' exceeds phpBB portable identifier length');
		}
		$this->assertSame(array_keys($columns), $migration->revert_schema()['drop_columns']['phpbb_topics']);
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
		$db->expects($this->exactly(4))->method('sql_query')->willReturnCallback(function ($sql) use (&$queries) {
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
		$this->assertStringContainsString('wolfsblvt_poll_notified = 1', $queries[3]);
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

	private function create_listener($advancedpolls = null)
	{
		return new listener(
			$advancedpolls ?: $this->createMock(\wolfsblvt\advancedpolls\core\advancedpolls::class),
			$this->createMock(\phpbb\path_helper::class),
			$this->createMock(\phpbb\template\template::class),
			$this->createMock(\phpbb\user::class)
		);
	}

	private function create_schema_migration()
	{
		return new v1_3_0_schema(
			new \phpbb\config\config(array()),
			$this->createMock(\phpbb\db\driver\driver_interface::class),
			$this->createMock(\phpbb\db\tools\tools_interface::class),
			'./',
			'php',
			'phpbb_'
		);
	}
}
