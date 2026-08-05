<?php

namespace dmzx\usernamecolourchanger\tests;

use dmzx\usernamecolourchanger\core\colour_helper;
use dmzx\usernamecolourchanger\event\listener;
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use PHPUnit\Framework\TestCase;

class listener_test extends TestCase
{
	public function test_unauthorised_ucp_request_cannot_change_colour()
	{
		$request = $this->createMock(request_interface::class);
		$request->expects($this->never())->method('variable');

		$template = $this->createMock(template::class);
		$template->expects($this->once())
			->method('assign_var')
			->with('USE_USERNAMECOLOURCHANGER', false);

		$auth = $this->createMock(auth::class);
		$auth->expects($this->exactly(3))
			->method('acl_get')
			->with('u_usernamecolourchanger_use')
			->willReturn(false);

		$db = $this->createMock(driver_interface::class);
		$db->expects($this->never())->method('sql_query');

		$language = $this->createMock(language::class);
		$language->expects($this->once())
			->method('add_lang')
			->with('common', 'dmzx/usernamecolourchanger');

		$listener = $this->listener($request, $template, $auth, $db, new config([]), $language, 7, '112233');
		$display_event = new data(['data' => ['jabber' => ''], 'submit' => true]);
		$listener->ucp_modify_profile($display_event);
		$this->assertArrayNotHasKey('user_colour', $display_event['data']);

		$validation_event = new data([
			'data' => ['user_colour' => 'AABBCC'],
			'error' => [],
		]);
		$listener->ucp_validate_profile($validation_event);
		$this->assertSame([], $validation_event['error']);

		$sql_event = new data([
			'data' => ['user_colour' => 'AABBCC'],
			'sql_ary' => [],
		]);
		$listener->ucp_modify_sql_ary($sql_event);
		$this->assertSame([], $sql_event['sql_ary']);
	}

	public function test_invalid_colour_is_rejected_and_valid_colour_is_canonicalised()
	{
		$listener = $this->listener();
		$invalid_event = new data([
			'data' => ['user_colour' => 'red;display:block'],
			'error' => [],
		]);
		$listener->acp_validate_profile($invalid_event);
		$this->assertSame(['USERNAMECOLOURCHANGER_INVALID_COLOUR'], $invalid_event['error']);

		$valid_event = new data([
			'data' => ['user_colour' => '#a0f'],
			'error' => [],
		]);
		$listener->acp_validate_profile($valid_event);
		$this->assertSame('AA00FF', $valid_event['data']['user_colour']);
		$this->assertSame([], $valid_event['error']);
	}

	public function test_acp_updates_the_selected_user_not_the_logged_in_admin()
	{
		$queries = [];
		$db = $this->createMock(driver_interface::class);
		$db->expects($this->exactly(3))
			->method('sql_build_array')
			->with('UPDATE', $this->callback(function ($sql_ary)
			{
				return count($sql_ary) === 1 && in_array('AABBCC', $sql_ary, true);
			}))
			->willReturn('colour = AABBCC');
		$db->expects($this->exactly(3))
			->method('sql_query')
			->willReturnCallback(function ($sql) use (&$queries)
			{
				$queries[] = $sql;
				return true;
			});

		$config = $this->getMockBuilder(config::class)
			->setConstructorArgs([['newest_user_id' => 42]])
			->onlyMethods(['set'])
			->getMock();
		$config->expects($this->once())
			->method('set')
			->with('newest_user_colour', 'AABBCC', false);

		$event = new data([
			'data' => ['user_colour' => '#abc'],
			'user_id' => 42,
			'user_row' => ['user_colour' => '112233'],
			'sql_ary' => [],
		]);
		$this->listener(null, null, null, $db, $config, null, 7, '778899')->acp_modify_sql_ary($event);

		$this->assertSame('AABBCC', $event['sql_ary']['user_colour']);
		$this->assertCount(3, $queries);
		foreach ($queries as $sql)
		{
			$this->assertMatchesRegularExpression('/(?:id|poster) = 42\z/', trim($sql));
			$this->assertStringNotContainsString(' = 7', $sql);
		}
	}

	public function test_unchanged_colour_skips_database_updates()
	{
		$db = $this->createMock(driver_interface::class);
		$db->expects($this->never())->method('sql_query');

		$event = new data([
			'data' => ['user_colour' => '#abc'],
			'user_id' => 42,
			'user_row' => ['user_colour' => 'aabbcc'],
			'sql_ary' => ['user_jabber' => ''],
		]);
		$this->listener(null, null, null, $db)->acp_modify_sql_ary($event);

		$this->assertSame(['user_jabber' => ''], $event['sql_ary']);
	}

	private function listener(
		$request = null,
		$template = null,
		$auth = null,
		$db = null,
		$config = null,
		$language = null,
		$user_id = 7,
		$user_colour = '112233'
	)
	{
		$user = $this->createMock(user::class);
		$user->data = [
			'user_id' => $user_id,
			'user_colour' => $user_colour,
		];

		return new listener(
			$request ?: $this->createMock(request_interface::class),
			$template ?: $this->createMock(template::class),
			$user,
			$auth ?: $this->createMock(auth::class),
			$db ?: $this->createMock(driver_interface::class),
			$config ?: new config([]),
			$language ?: $this->createMock(language::class),
			new colour_helper()
		);
	}
}
