<?php

namespace leinad4mind\userdefaults\tests;

use leinad4mind\userdefaults\core\settings_policy;
use leinad4mind\userdefaults\event\listener;
use phpbb\config\config;
use phpbb\event\data;
use PHPUnit\Framework\TestCase;

class listener_test extends TestCase
{
	public function test_defaults_are_applied_to_new_users()
	{
		$config = new config(array_merge((new settings_policy())->defaults(), array(
			'ud_type_pm' => 1,
		)));
		$event = new data(array(
			'user_row' => array('user_type' => 0),
			'sql_ary' => array('username' => 'new-user'),
			'notifications_data' => null,
		));

		(new listener($config, new settings_policy()))->modify_user_defaults($event);

		$sql = $event['sql_ary'];
		$this->assertSame('new-user', $sql['username']);
		$this->assertSame(1, $sql['user_allow_pm']);
		$this->assertSame('d M Y H:i', $sql['user_dateformat']);
		$this->assertSame('d', $sql['user_topic_sortby_dir']);
		$this->assertSame(array(
			array('item_type' => 'notification.type.pm', 'method' => 'notification.method.email'),
			array('item_type' => 'notification.type.post', 'method' => 'notification.method.email'),
			array('item_type' => 'notification.type.topic', 'method' => 'notification.method.email'),
		), $event['notifications_data']);
	}

	public function test_explicit_notification_choices_are_preserved()
	{
		$explicit = array(array('item_type' => 'custom.type', 'method' => 'custom.method'));
		$event = new data(array(
			'user_row' => array('user_type' => 0),
			'sql_ary' => array(),
			'notifications_data' => $explicit,
		));

		(new listener(new config(array()), new settings_policy()))->modify_user_defaults($event);
		$this->assertSame($explicit, $event['notifications_data']);
	}

	public function test_invalid_stored_values_fall_back_before_user_creation()
	{
		$event = new data(array(
			'user_row' => array('user_type' => 0),
			'sql_ary' => array(),
			'notifications_data' => null,
		));
		$config = new config(array(
			'ud_post_sd' => 'invalid',
			'ud_topic_st' => 999,
			'ud_allow_pm' => 9,
		));

		(new listener($config, new settings_policy()))->modify_user_defaults($event);
		$this->assertSame('a', $event['sql_ary']['user_post_sortby_dir']);
		$this->assertSame(0, $event['sql_ary']['user_topic_show_days']);
		$this->assertSame(0, $event['sql_ary']['user_allow_pm']);
	}

	public function test_ignored_users_keep_core_values()
	{
		$event = new data(array(
			'user_row' => array('user_type' => USER_IGNORE),
			'sql_ary' => array('user_allow_pm' => 7),
			'notifications_data' => null,
		));

		(new listener(new config(array()), new settings_policy()))->modify_user_defaults($event);
		$this->assertSame(array('user_allow_pm' => 7), $event['sql_ary']);
		$this->assertNull($event['notifications_data']);
	}
}
