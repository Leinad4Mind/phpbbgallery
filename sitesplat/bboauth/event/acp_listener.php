<?php
/**
*
* BBOAuth
*
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bboauth\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class acp_listener implements EventSubscriberInterface 
{
	protected $db;
	protected $group_helper;
	protected $groups_table;
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\group\helper $group_helper, $groups_table)
	{
		$this->db = $db;
		$this->group_helper = $group_helper;
		$this->groups_table = $groups_table;
	}
	
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_board_config_edit_add'	=> 'display_bboauth_options',
		);
	}

	public function display_bboauth_options($event)
	{
		if ($event['mode'] === 'registration')
		{
			$display_vars = $event['display_vars'];

			$vars = $display_vars['vars'];
			$bboauth_vars = [
				'legend_sitesplat_bboauth'				=> 'ACP_BBOAUTH',
				'sitesplat_bboauth_autoregistration'	=> [
					'lang'		=> 'BBOAUTH_AUTOREGISTER',
					'validate'	=> 'bool',
					'type'		=> 'radio:yes_no',
					'explain'	=> true,
				],
				'sitesplat_bboauth_group'				=> [
					'lang'		=> 'BBOAUTH_GROUP',
					'validate'	=> 'int',
					'type'		=> 'select',
					'function'	=> [$this, 'select_groups'],
					'explain'	=> true,
				],
			];
			$display_vars['vars'] = array_slice($vars, 0, count($vars) - 1) + $bboauth_vars + array_slice($vars, count($vars) - 1, 1);

			$event['display_vars'] = $display_vars;
		}
	}

	public function select_groups($selected_value, $key)
	{
		$groups = '<option value="0"' . ($selected_value == 0 ? ' selected' : '') . '>--</option>';

		$sql = 'SELECT group_id, group_name
				FROM ' . $this->groups_table . '
				WHERE ' . $this->db->sql_in_set('group_name', ['GUESTS', 'BOTS'], true);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$groups .= '<option value="' . $row['group_id'] . '"' . ($selected_value == $row['group_id'] ? ' selected' : '') . '>' . $this->group_helper->get_name($row['group_name']) . '</option>';
		}
		$this->db->sql_freeresult($result);

		return $groups;
	}
}
