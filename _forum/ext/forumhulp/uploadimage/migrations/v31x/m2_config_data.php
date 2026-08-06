<?php

namespace forumhulp\uploadimage\migrations\v31x;

use phpbb\db\migration\migration;

class m2_config_data extends migration
{
	public static function depends_on(): array
	{
		return ['\\forumhulp\\uploadimage\\migrations\\v31x\\m1_initial_module'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['uploadimage_folder', 'ui']],
		];
	}
}
