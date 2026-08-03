<?php

namespace devspace\userdefaults\tests;

use devspace\userdefaults\core\settings_policy;
use devspace\userdefaults\core\notification_defaults;
use devspace\userdefaults\event\listener;
use phpbb\config\config;
use phpbb\event\data;
use phpbb\extension\manager as extension_manager;
use phpbb\notification\manager;
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

		(new listener($config, new settings_policy(), $this->notifications(), $this->extension_manager()))->modify_user_defaults($event);

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

		(new listener(new config(array()), new settings_policy(), $this->notifications(), $this->extension_manager()))->modify_user_defaults($event);
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

		(new listener($config, new settings_policy(), $this->notifications(), $this->extension_manager()))->modify_user_defaults($event);
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

		(new listener(new config(array()), new settings_policy(), $this->notifications(), $this->extension_manager()))->modify_user_defaults($event);
		$this->assertSame(array('user_allow_pm' => 7), $event['sql_ary']);
		$this->assertNull($event['notifications_data']);
	}

	public function test_default_notification_methods_are_explicitly_applied_after_creation()
	{
		$manager = $this->manager();
		$manager->expects($this->exactly(2))->method('add_subscription');
		$manager->expects($this->once())->method('delete_subscription');
		$listener = new listener(new config(array()), new settings_policy(), new notification_defaults($manager), $this->extension_manager());
		$event = new data(array(
			'user_row' => array('user_type' => 0),
			'sql_ary' => array(),
			'notifications_data' => null,
		));

		$listener->modify_user_defaults($event);
		$listener->apply_notification_defaults(new data(array('user_id' => 42)));
	}

	public function test_conflicting_extension_disables_mutation()
	{
		$event = new data(array(
			'user_row' => array('user_type' => 0),
			'sql_ary' => array('user_allow_pm' => 7),
			'notifications_data' => null,
		));
		$listener = new listener(new config(array()), new settings_policy(), $this->notifications(), $this->extension_manager(true));

		$listener->modify_user_defaults($event);
		$this->assertSame(array('user_allow_pm' => 7), $event['sql_ary']);
		$this->assertNull($event['notifications_data']);
	}

	protected function notifications()
	{
		return new notification_defaults($this->manager());
	}

	protected function manager()
	{
		$manager = $this->createMock(manager::class);
		$manager->method('get_subscription_types')->willReturn(array(
			'NOTIFICATION_GROUP_MISCELLANEOUS' => array(
				'notification.type.pm' => array('lang' => 'NOTIFICATION_TYPE_PM'),
				'notification.type.post' => array('lang' => 'NOTIFICATION_TYPE_POST'),
				'notification.type.topic' => array('lang' => 'NOTIFICATION_TYPE_TOPIC'),
			),
		));
		$manager->method('get_subscription_methods')->willReturn(array(
			'email' => array('id' => 'notification.method.email', 'lang' => 'NOTIFICATION_METHOD_EMAIL'),
		));
		return $manager;
	}

	protected function extension_manager($conflict = false)
	{
		$manager = $this->createMock(extension_manager::class);
		$manager->method('is_enabled')->willReturn($conflict);
		return $manager;
	}
}
