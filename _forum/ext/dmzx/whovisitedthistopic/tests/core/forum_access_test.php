<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic\tests\core;

use dmzx\whovisitedthistopic\core\forum_access;
use phpbb\auth\auth;
use phpbb\db\driver\driver_interface;
use PHPUnit\Framework\TestCase;

class forum_access_test extends TestCase
{
	public function test_only_readable_listable_and_unlocked_forums_are_returned()
	{
		$auth = $this->createMock(auth::class);
		$auth->method('acl_getf')->willReturnMap([
			['f_read', true, [2 => true, 3 => true, 4 => true]],
			['f_list_topics', true, [2 => true, 3 => true]],
		]);

		$db = $this->createMock(driver_interface::class);
		$db->expects(self::once())->method('sql_in_set')->with('f.forum_id', [2, 3])->willReturn('f.forum_id IN (2, 3)');
		$db->expects(self::once())->method('sql_query')->willReturn(42);
		$db->expects(self::exactly(3))->method('sql_fetchrow')->with(42)->willReturnOnConsecutiveCalls(
			['forum_id' => 2, 'forum_password' => '', 'access_user_id' => null],
			['forum_id' => 3, 'forum_password' => 'hash', 'access_user_id' => null],
			false
		);
		$db->expects(self::once())->method('sql_freeresult')->with(42);

		$access = new forum_access($auth, $db);
		self::assertSame([2, 0], $access->get_readable_forum_ids(9));
	}
}
