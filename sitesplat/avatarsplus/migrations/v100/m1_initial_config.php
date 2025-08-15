<?php
/**
*
* @package BBrandom
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\avatarsplus\migrations\v100;

class m1_initial_config extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('allow_avatar_generator', 1)),
			array('config.add', array('allow_avatar_material', 1)),
			array('custom', array(array($this, 'upload_directory')))
		);
	}

	public function upload_directory()
	{
		$directory = $this->phpbb_root_path . 'images/avatars/generator';
		if (!is_dir($directory))
		{
			@mkdir($directory, 0755);
			@chmod($directory, 0755);
		}

		$directory = $this->phpbb_root_path . 'images/avatars/material';
		if (!is_dir($directory))
		{
			@mkdir($directory, 0755);
			@chmod($directory, 0755);
		}

		return true;
	}
}
