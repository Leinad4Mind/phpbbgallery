<?php
/**
*
* BBcode Order+
*
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbcodeorder\migrations;

class v100_m1_install_schema extends \phpbb\db\migration\container_aware_migration
{
	/**
	 * @var array An array of bbcodes data to install
	 */
	public $bbcode_data = array(
		array(
			'bbcode_tag'	=> 'b',
			'bbcode_icon'	=> 'bold',
		),
		array(
			'bbcode_tag'	=> 'i',
			'bbcode_icon'	=> 'italic',
		),
		array(
			'bbcode_tag'	=> 'u',
			'bbcode_icon'	=> 'underline',
		),
		array(
			'bbcode_tag'	=> '-',
			'bbcode_icon'	=> '',
		),
		array(
			'bbcode_tag'	=> 'list',
			'bbcode_icon'	=> 'list',
		),
		array(
			'bbcode_tag'	=> 'list=',
			'bbcode_icon'	=> 'list-ol',
		),
		array(
			'bbcode_tag'	=> '*',
			'bbcode_icon'	=> 'asterisk',
		),
		array(
			'bbcode_tag'	=> '-',
			'bbcode_icon'	=> '',
		),
		array(
			'bbcode_tag'	=> 'code',
			'bbcode_icon'	=> 'code',
		),
		array(
			'bbcode_tag'	=> 'quote',
			'bbcode_icon'	=> 'comment',
		),
		array(
			'bbcode_tag'	=> 'img',
			'bbcode_icon'	=> 'picture-o',
		),
		array(
			'bbcode_tag'	=> 'url',
			'bbcode_icon'	=> 'link',
		),
		array(
			'bbcode_tag'	=> '-',
			'bbcode_icon'	=> '',
		),
		array(
			'bbcode_tag'	=> 'flash=',
			'bbcode_icon'	=> 'font',
		),
		array(
			'bbcode_tag'	=> 'color=',
			'bbcode_icon'	=> 'tint',
		),
		array(
			'bbcode_tag'	=> '-',
			'bbcode_icon'	=> '',
		),
		array(
			'bbcode_tag'	=> 'size=',
			'bbcode_icon'	=> 'font',
		),
		array(
			'bbcode_tag'	=> '--',
			'bbcode_icon'	=> '',
		),
	);

	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'bbcodes', 'bbcode_order');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'default_bbcodes'	=> array(
					'COLUMNS'	=> array(
						'bbcode_id'				=> array('USINT', 0),
						'bbcode_tag'			=> array('VCHAR:16', ''),
						'display_on_posting'	=> array('BOOL', 0),
						'bbcode_order'			=> array('USINT', 0),
						'bbcode_icon'			=> array('VCHAR:255', ''),
					),
					'PRIMARY_KEY'	=> 'bbcode_id',
				),
			),
			'add_columns'	=> array(
				$this->table_prefix . 'bbcodes'	=> array(
					'bbcode_order'		=> array('USINT', 0),
					'bbcode_icon'		=> array('VCHAR:255', ''),
					'bbcode_group'		=> array('VCHAR:255', ''),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables' => array(
				$this->table_prefix . 'default_bbcodes',
			),
			'drop_columns'	=> array(
				$this->table_prefix . 'bbcodes'	=> array(
					'bbcode_order',
					'bbcode_icon',
					'bbcode_group',
				),
			),
		);
	}

	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'install_bbcodeorder_bbcodes'))),
		);
	}

	public function install_bbcodeorder_bbcodes()
	{
		$acp_manager = new \sitesplat\bbcodeorder\core\acp_manager($this->db, $this->container->get('request'), $this->container->get('user'), $this->table_prefix . 'default_bbcodes');

		$bbcode_id = BBCODE_LIMIT;

		foreach ($this->bbcode_data as $bbcode_data)
		{
			$bbcode_id = $bbcode_id + 1;

			$bbcode_data['bbcode_id'] = $bbcode_id;
			$bbcode_data['display_on_posting'] = true;
			$this->db->sql_query('INSERT INTO ' . $this->table_prefix . 'default_bbcodes' . ' ' . $this->db->sql_build_array('INSERT', $bbcode_data));
		}

		// push custom bbcodes at the end of the ordering
		$sql = 'UPDATE ' . BBCODES_TABLE . '
				SET bbcode_order = ' . ($bbcode_id + 1);
		$this->db->sql_query($sql);

		$acp_manager->resynchronize_bbcode_order();
	}
}
