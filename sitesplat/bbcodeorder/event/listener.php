<?php
/**
*
* BBcode Order+
*
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbcodeorder\event;

class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'							=> 'load_language_on_setup',
			'core.display_custom_bbcodes_modify_sql'	=> 'custom_bbcode_modify_sql',
			'core.display_custom_bbcodes_modify_row'	=> 'display_custom_bbcodes',
			'core.modify_bbcode_init'					=> 'allow_custom_bbcodes',
		);
	}

	protected $db;
	protected $user;
	protected $template;
	protected $default_bbcodes_table;
	protected $memberships;
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\template\template $template, $default_bbcodes_table)
	{
		$this->db = $db;
		$this->user = $user;
		$this->template = $template;
		$this->default_bbcodes_table = $default_bbcodes_table;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/bbcodeorder',
			'lang_set' => 'common',
			'lang_set' => 'common_posting',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function custom_bbcode_modify_sql($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['SELECT'] .= ', b.bbcode_order, b.bbcode_icon, b.bbcode_group, FALSE as bbcode_default';
		$sql_ary['WHERE'] .= '
							UNION ALL
							SELECT db.bbcode_id, db.bbcode_tag, "" as bbcode_helpline, db.bbcode_order, db.bbcode_icon, "" as bbcode_group, TRUE as bbcode_default
							FROM ' . $this->default_bbcodes_table . ' db
							WHERE display_on_posting = 1';
		$sql_ary['ORDER_BY'] = 'bbcode_order, bbcode_id';
		$event['sql_ary'] = $sql_ary;
	}

	public function display_custom_bbcodes($event)
	{
		$custom_tags = $event['custom_tags'];

		$custom_tags['BBCODE_ICON'] = $event['row']['bbcode_icon'];
		$custom_tags['S_BBCODE_ALLOWED'] = (!empty($event['row']['bbcode_group'])) ? $this->user_in_bbcode_group($event['row']['bbcode_group']) : true;

		$event['custom_tags'] = $custom_tags;

		$this->template->assign_vars(array(
			'S_BBCODEORDER'	=> true,
		));
	}

	public function allow_custom_bbcodes($event)
	{
		$bbcodes = $event['bbcodes'];

		foreach ($event['rowset'] as $row)
		{
			if (!$this->user_in_bbcode_group($row['bbcode_group']))
			{
				$bbcodes[$row['bbcode_tag']]['disabled'] = true;
			}
		}

		$event['bbcodes'] = $bbcodes;
	}

	protected function user_in_bbcode_group($group_ids = '')
	{
		if ($group_ids)
		{
			// Convert string to an array
			if (!is_array($group_ids))
			{
				$group_ids = explode(',', $group_ids);
			}

			// Load the user's group memberships
			$this->load_memberships();

			return (bool) sizeof(array_intersect($this->memberships, $group_ids));
		}

		// If we get here, there were no group restrictions so everyone can use this BBCode
		return true;
	}

	protected function load_memberships()
	{
		if (isset($this->memberships))
		{
			return;
		}

		$this->memberships = array();
		$sql = 'SELECT group_id
			FROM ' . USER_GROUP_TABLE . '
			WHERE user_id = ' . (int) $this->user->data['user_id'] . '
			AND user_pending = 0';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->memberships[] = $row['group_id'];
		}
		$this->db->sql_freeresult($result);
	}
}
