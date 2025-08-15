<?php
/**
*
* BBbbprofile. An extension for the phpBB Forum Software package.
* @copyright (c) 2016, SiteSplat
* @license Proprietary
*
*/

namespace sitesplat\bbprofile\migrations;

class v100 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['acme_demo_goodbye']);
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			array('permission.add', array('u_bbprofile')),
			array('permission.permission_set', array('REGISTERED', 'u_bbprofile', 'group')),

			array('config.add', array('bbprofile_position', 'ucp')),
			array('config_text.add', array('bbprofile_enabled', '["birthdate","signature","avatar","facebook","twitter","skype","youtube","googleplus","first_post"]')),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_BBPROFILE'
			)),
			array('module.add', array(
				'acp',
				'ACP_BBPROFILE',
				array(
					'module_basename'	=> '\sitesplat\bbprofile\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
