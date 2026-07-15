<?php
/**
*
* @package BBrandom
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbrandom\migrations\v31x;

class m1_initial_config extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
				'\phpbb\db\migration\data\v31x\v318rc1',
				'\sitesplat\BBCore\migrations\v32x\m1_initial_file'
		);
	}

	public function update_data()
	{
		return array(
			array('config.add', array('allow_avatar_rgravatar', 1)),
			array('config.add', array('default_rgravatar', 1)),
			array('config.add', array('default_cuavatar', 0)),
			array('custom', array(array($this, 'upload_directory')))
		);
	}

	public function upload_directory()
	{
		$directory = 'images/avatars/random';

		if (!is_dir($this->phpbb_root_path . $directory))
		{
			@mkdir($this->phpbb_root_path . $directory, 0755);
			@chmod($this->phpbb_root_path . $directory, 0755);
		}

		return true;
	}
}
