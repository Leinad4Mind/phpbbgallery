<?php
/**
 *
 * Notification_manager for the phpBB Forum Software package.
 *
 * @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
 * @license Proprietary
 *
 */

namespace forumhulp\notification_manager\ucp;

class noties_info
{
	public function module(): array
	{
		return [
			'filename' => '\forumhulp\notification_manager\ucp\noties_module',
			'title' => 'UCP_NOTIES',
			'version' => '1.0.0',
			'modes' => [
				'noties' => [
					'title' => 'UCP_NOTIES',
					'auth' => 'ext_forumhulp/notification_manager && cfg_allow_board_notifications',
					'cat' => ['UCP_MAIN'],
				],
			],
		];
	}

	public function install(): void
	{
	}

	public function uninstall(): void
	{
	}
}
