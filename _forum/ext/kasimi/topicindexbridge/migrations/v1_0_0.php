<?php
/**
 *
 * Topic Index Bridge. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kasimi\topicindexbridge\migrations;

class v1_0_0 extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return [
			['config.add', ['topicindex_bridge_foruminfo', 1]],
			['config.add', ['topicindex_bridge_qte', 1]],
			['config.add', ['topicindex_bridge_bbprefix', 1]],
			['config.add', ['topicindex_bridge_bbemoji', 1]],
			['config.add', ['topicindex_bridge_topicimagepreview', 1]],
			['config.add', ['topicindex_bridge_usertopics', 1]],
			['config.add', ['topicindex_bridge_profile_list', 0]],
			['config.add', ['topicindex_bridge_self_list', 0]],
		];
	}
}
