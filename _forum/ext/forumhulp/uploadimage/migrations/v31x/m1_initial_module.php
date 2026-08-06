<?php

namespace forumhulp\uploadimage\migrations\v31x;

use phpbb\db\migration\migration;

class m1_initial_module extends migration
{
	public static function depends_on(): array
	{
		return ['\\phpbb\\db\\migration\\data\\v310\\gold'];
	}

	public function update_data(): array
	{
		return [
			['module.add', ['acp', 'ACP_CAT_CUSTOMISE', 'ACP_UPLOAD_IMAGE_TITLE']],
			['module.add', [
				'acp',
				'ACP_UPLOAD_IMAGE_TITLE',
				[
					'module_basename' => '\\forumhulp\\uploadimage\\acp\\uploadimage_module',
					'modes' => ['main'],
				],
			]],
		];
	}
}
