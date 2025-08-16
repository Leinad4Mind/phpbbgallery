<?php
/**
 *
 * No DEA Emails. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Picaron, https://github.com/picaronin/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace pikaron\nodeaemails\migrations;

class v100_rc4 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			// Add new config table settings
			array('config.add', array('nodeaemails_version', '1.0.0-RC4')),
			array('config.add', array('nodeaemails_counter', 0)),
			array('config.add', array('nodeaemails_cron_last_gc', 0)),
			array('config.add', array('nodeaemails_cron_gc', 900)),

			// ACP module
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'LOG_NO_DEA_EMAILS'
			)),
			array('module.add', array(
				'acp',
				'LOG_NO_DEA_EMAILS',
				array(
					'module_basename'	=> '\pikaron\nodeaemails\acp\acp_nodeaemails_module',
					'modes'				=> array('configuration', 'locals', 'users'),
				),
			)),
		);
	}

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'nodeaemails'	=> array(
					'COLUMNS'			=> array(
						'id'			=> array('UINT:11', null, 'auto_increment'),
						'dea_emails'	=> array('MTEXT_UNI', null),
						'source'		=> array('VCHAR:10', null),
					),
					'PRIMARY_KEY'	=> 'id',
				),
			),
		);
	}

	public function revert_schema()
	{
		return	array(
			'drop_tables' => array(
				$this->table_prefix . 'nodeaemails',
			),
		);
	}
}
