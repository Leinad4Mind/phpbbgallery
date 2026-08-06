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
use wolfsblvt\advancedpolls\controller\infopoll;

class infopoll_controller_test extends TestCase
{
	public function test_non_ajax_request_is_rejected_without_querying_topic()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$request = $this->createMock(\phpbb\request\request_interface::class);
		$request->method('is_ajax')->willReturn(false);
		$controller = new infopoll($db, $this->createMock(\phpbb\auth\auth::class), $this->user(), $request);

		$response = $controller->details(12);

		$this->assertSame(400, $response->getStatusCode());
		$this->assertSame(array('error' => 'Invalid operation'), json_decode($response->getContent(), true));
		$this->assertStringContainsString('private', $response->headers->get('Cache-Control'));
		$this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
		$this->assertSame('nosniff', $response->headers->get('X-Content-Type-Options'));
	}

	public function test_ajax_request_requires_read_and_moderator_voter_permissions()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_query')
			->with($this->stringContains('WHERE topic_id = 12'))
			->willReturn(true);
		$db->expects($this->once())->method('sql_fetchrow')->with(true)->willReturn(array(
			'topic_id' => 12,
			'forum_id' => 2,
			'topic_first_post_id' => 24,
			'poll_title' => 'Question',
			'poll_max_options' => 1,
			'wolfsblvt_poll_max_value' => 1,
		));
		$db->expects($this->once())->method('sql_freeresult')->with(true);

		$auth = $this->createMock(\phpbb\auth\auth::class);
		$auth->expects($this->exactly(2))
			->method('acl_get')
			->willReturnCallback(function ($permission, $forum_id) {
				$this->assertSame(2, $forum_id);
				return $permission === 'f_read';
			});
		$request = $this->createMock(\phpbb\request\request_interface::class);
		$request->method('is_ajax')->willReturn(true);
		$controller = new infopoll($db, $auth, $this->user(), $request);

		$response = $controller->details(12);

		$this->assertSame(403, $response->getStatusCode());
		$this->assertSame(array('error' => 'Not authorised'), json_decode($response->getContent(), true));
	}

	private function user()
	{
		$user = $this->createMock(\phpbb\user::class);
		$user->lang = array(
			'NO_AUTH_OPERATION' => 'Invalid operation',
			'NO_TOPIC' => 'No topic',
			'NOT_AUTHORISED' => 'Not authorised',
		);

		return $user;
	}
}
