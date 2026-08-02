<?php

namespace david63\loginredirect\tests;

use david63\loginredirect\controller\main_controller;
use david63\loginredirect\core\redirect_helper;
use david63\loginredirect\core\topic_repository;
use phpbb\config\config;
use phpbb\language\language;
use phpbb\user;
use PHPUnit\Framework\TestCase;

class main_controller_test extends TestCase
{
	public function test_disabled_extension_leaves_core_redirect_untouched()
	{
		list($controller, $topics, $helper) = $this->controller(array('loginredirect_enabled' => 0));
		$topics->expects($this->never())->method('find_topic');
		$helper->expects($this->never())->method('topic_url');
		$event = $this->event();
		$controller->login_redirect($event);
		$this->assertSame('index.php', $event['redirect']);
	}

	public function test_acp_login_is_never_redirected()
	{
		list($controller, $topics) = $this->controller(array('loginredirect_enabled' => 1, 'loginredirect_always' => 1));
		$topics->expects($this->never())->method('find_topic');
		$event = $this->event(true);
		$controller->login_redirect($event);
		$this->assertSame('index.php', $event['redirect']);
	}

	public function test_selected_announcement_option_is_honoured()
	{
		list($controller, $topics, $helper) = $this->controller(array(
			'loginredirect_enabled' => 1,
			'loginredirect_any_announce' => 1,
			'loginredirect_announce_topic_id' => 42,
		));
		$topics->expects($this->once())->method('find_topic')->with(42, true)->willReturn(array('topic_id' => 42, 'topic_time' => 200));
		$helper->expects($this->once())->method('topic_url')->with(42)->willReturn('viewtopic.php?t=42');
		$helper->expects($this->never())->method('show_message');
		$event = $this->event();
		$controller->login_redirect($event);
		$this->assertSame('viewtopic.php?t=42', $event['redirect']);
	}

	public function test_deleted_welcome_topic_falls_back_to_phpbb_redirect()
	{
		list($controller, $topics, $helper) = $this->controller(array(
			'loginredirect_enabled' => 1,
			'loginredirect_always' => 1,
			'loginredirect_welcome_topic_id' => 7,
		));
		$topics->expects($this->once())->method('find_topic')->with(7)->willReturn(null);
		$helper->expects($this->never())->method('topic_url');
		$event = $this->event();
		$controller->login_redirect($event);
		$this->assertSame('index.php', $event['redirect']);
	}

	public function test_pending_or_missing_group_membership_does_not_redirect()
	{
		list($controller, $topics, $helper) = $this->controller(array(
			'loginredirect_enabled' => 1,
			'loginredirect_group' => 1,
			'loginredirect_group_id' => 5,
			'loginredirect_group_topic_id' => 8,
		));
		$topics->expects($this->once())->method('user_in_group')->with(12, 5)->willReturn(false);
		$topics->expects($this->never())->method('find_topic');
		$helper->expects($this->never())->method('topic_url');
		$event = $this->event();
		$controller->login_redirect($event);
		$this->assertSame('index.php', $event['redirect']);
	}

	protected function controller(array $overrides)
	{
		$defaults = array(
			'loginredirect_always' => 0,
			'loginredirect_announce' => 0,
			'loginredirect_announce_priority' => 1,
			'loginredirect_announce_refresh' => 0,
			'loginredirect_announce_topic_id' => 0,
			'loginredirect_any_announce' => 0,
			'loginredirect_enabled' => 0,
			'loginredirect_global' => 0,
			'loginredirect_group' => 0,
			'loginredirect_group_all' => 0,
			'loginredirect_group_id' => 0,
			'loginredirect_group_refresh' => 0,
			'loginredirect_group_topic_id' => 0,
			'loginredirect_welcome' => 0,
			'loginredirect_welcome_refresh' => 0,
			'loginredirect_welcome_topic_id' => 0,
		);
		$config = new config(array_replace($defaults, $overrides));
		$user = $this->createMock(user::class);
		$user->data = array('user_id' => 12, 'user_lastvisit' => 100, 'user_type' => 0);
		$language = $this->createMock(language::class);
		$topics = $this->createMock(topic_repository::class);
		$helper = $this->createMock(redirect_helper::class);
		return array(new main_controller($config, $user, $language, $topics, $helper), $topics, $helper);
	}

	protected function event($admin = false)
	{
		return new \ArrayObject(array(
			'redirect' => 'index.php',
			'admin' => $admin,
			'result' => array('user_row' => array('user_type' => 0)),
		));
	}
}
