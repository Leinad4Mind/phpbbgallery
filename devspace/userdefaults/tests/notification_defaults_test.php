<?php

namespace devspace\userdefaults\tests;

use devspace\userdefaults\core\notification_defaults;
use phpbb\notification\manager;
use PHPUnit\Framework\TestCase;

class notification_defaults_test extends TestCase
{
	public function test_legacy_values_are_migrated_to_stable_type_and_method_names()
	{
		$policy = new notification_defaults($this->manager());
		$defaults = $policy->normalise_stored(null, array(
			'ud_type_post' => 1,
			'ud_type_topic' => 0,
		));

		$this->assertSame(array(
			'notification.type.post' => array('notification.method.board', 'notification.method.email'),
			'notification.type.topic' => array('notification.method.board'),
		), $defaults);
	}

	public function test_submission_rejects_unknown_indexes_and_normalises_selection()
	{
		$policy = new notification_defaults($this->manager());
		$defaults = $policy->normalise_submission(array(
			0 => array(0 => 1, 1 => 0, 99 => 1),
			1 => array(1 => 1),
			99 => array(0 => 1),
		));

		$this->assertSame(array(
			'notification.type.post' => array('notification.method.board'),
			'notification.type.topic' => array('notification.method.email'),
		), $defaults);
		$this->assertSame($defaults, json_decode($policy->encode($defaults), true));
	}

	public function test_apply_to_user_sets_selected_and_unselected_methods()
	{
		$manager = $this->manager();
		$manager->expects($this->once())
			->method('add_subscription')
			->with('notification.type.post', 0, 'notification.method.email', 17);
		$manager->expects($this->exactly(3))->method('delete_subscription');
		$policy = new notification_defaults($manager);

		$policy->apply_to_user(17, array(
			'notification.type.post' => array('notification.method.email'),
		));
	}

	protected function manager()
	{
		$manager = $this->createMock(manager::class);
		$manager->method('get_subscription_types')->willReturn(array(
			'NOTIFICATION_GROUP_POSTING' => array(
				'notification.type.post' => array('lang' => 'NOTIFICATION_TYPE_POST'),
				'notification.type.topic' => array('lang' => 'NOTIFICATION_TYPE_TOPIC'),
			),
		));
		$manager->method('get_subscription_methods')->willReturn(array(
			'board' => array('id' => 'notification.method.board', 'lang' => 'NOTIFICATION_METHOD_BOARD'),
			'email' => array('id' => 'notification.method.email', 'lang' => 'NOTIFICATION_METHOD_EMAIL'),
		));
		return $manager;
	}
}
