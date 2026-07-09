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

class acp_listener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_bbcodes_display_form'		=> 'acp_bbcodes_custom_sorting',
			'core.acp_bbcodes_display_bbcodes'	=> 'acp_bbcodes_custom_sorting_buttons',
			'core.acp_bbcodes_modify_create'	=> 'acp_bbcodes_modify_create',
			'core.acp_bbcodes_edit_add'			=> 'acp_bbcodes_group_select_box',
		);
	}

	protected $acp_manager;
	protected $request;
	protected $db;
	protected $user;
	protected $default_bbcodes_table;
	protected $root_path;
	public function __construct(\sitesplat\bbcodeorder\core\acp_manager $acp_manager, $request, $db, $user, $default_bbcodes_table, $root_path)
	{
		$this->acp_manager = $acp_manager;
		$this->request = $request;
		$this->db = $db;
		$this->user = $user;
		$this->default_bbcodes_table = $default_bbcodes_table;
		$this->root_path = $root_path;
	}

	public function acp_bbcodes_custom_sorting($event)
	{
		// Move up/down action
		switch ($event['action'])
		{
			case 'new_divider':
				$this->acp_manager->add_new_divider();
			break;

			case 'delete':
				$this->acp_manager->delete_divider();
			break;

			case 'show':
				$this->acp_manager->show_default_bbcode();
			break;

			case 'move_up':
			case 'move_down':
				$this->acp_manager->move($event['action']);
			break;

			case 'drag_drop':
				$this->acp_manager->drag_drop();
			break;
		}

		// Add some additional template variables
		$template_data = $event['template_data'];
		$template_data['ICON_HIDE'] = '<img src="' . htmlspecialchars($this->root_path) . '/ext/sitesplat/bbcodeorder/adm/images/icon_hide.gif" alt="' . $this->user->lang['HIDE'] . '" title="' . $this->user->lang['HIDE'] . '" />';
		$template_data['ICON_SHOW'] = '<img src="' . htmlspecialchars($this->root_path) . '/adm/images/file_new.gif" alt="' . $this->user->lang['SHOW'] . '" title="' . $this->user->lang['SHOW'] . '" />';
		$template_data['U_NEW_DIVIDER'] = $event['u_action'] . '&amp;action=new_divider';
		$template_data['UA_DRAG_DROP'] = str_replace('&amp;', '&', $event['u_action'] . '&action=drag_drop');
		$event['template_data'] = $template_data;

		// Change SQL so that it orders by bbcode_order
		$sql_ary = $event['sql_ary'];
		$sql_ary['SELECT'] = 'display_on_posting, bbcode_order, bbcode_id, bbcode_tag, bbcode_icon, FALSE as bbcode_default';
		$sql_ary['WHERE'] = '1=1
							UNION ALL
							SELECT display_on_posting, bbcode_order, bbcode_id, bbcode_tag, bbcode_icon, TRUE as bbcode_default
							FROM ' . $this->default_bbcodes_table . ' db';
		$sql_ary['ORDER_BY'] = 'bbcode_order, bbcode_id';
		$event['sql_ary'] = $sql_ary;
	}

	public function acp_bbcodes_custom_sorting_buttons($event)
	{
		$row = $event['row'];
		$bbcodes_array = $event['bbcodes_array'];

		// Add icon if available
		if ($row['bbcode_icon'])
		{
			$bbcodes_array['BBCODE_TAG'] = '<span style="float: left" class="fa fa-' . $row['bbcode_icon'] . '"></span> ' . $bbcodes_array['BBCODE_TAG'];
		}
		$bbcodes_array['S_IS_DEFAULT'] = (bool) $row['bbcode_default'];
		$bbcodes_array['S_IS_HIDDEN'] = !((bool) $row['display_on_posting']);
		$bbcodes_array['S_IS_DIVIDER'] = $row['bbcode_tag'] == '-';
		$bbcodes_array['U_MOVE_UP'] = $event['u_action'] . '&amp;action=move_up&amp;id=' . $row['bbcode_id'] . '&amp;hash=' . generate_link_hash('move_up' . $row['bbcode_id']) . '&amp;is_default=' . $row['bbcode_default'];
		$bbcodes_array['U_MOVE_DOWN'] = $event['u_action'] . '&amp;action=move_down&amp;id=' . $row['bbcode_id'] . '&amp;hash=' . generate_link_hash('move_down' . $row['bbcode_id']) . '&amp;is_default=' . $row['bbcode_default'];
		$bbcodes_array['U_SHOW'] = $event['u_action'] . '&amp;action=show&amp;id=' . $row['bbcode_id'];

		$event['bbcodes_array'] = $bbcodes_array;
	}

	public function acp_bbcodes_modify_create($event)
	{
		$sql_ary = $event['sql_ary'];

		// Set a new BBCode order value on create
		if ($event['action'] == 'create')
		{
			$sql_ary['bbcode_order'] = $this->acp_manager->get_max_bbcode_order() + 1;
		}

		$sql_ary['bbcode_icon'] = $this->request->variable('bbcode_icon', '');

		// Get the BBCode groups from the form
		$bbcode_group = $this->acp_manager->get_bbcode_group_form_data();
		$sql_ary['bbcode_group'] = $bbcode_group;

		// Return sql_ary array
		$event['sql_ary'] = $sql_ary;

		// Supply BBCode groups to hidden form fields
		$hidden_fields = $event['hidden_fields'];
		$hidden_fields['bbcode_group'] = $bbcode_group;
		$event['hidden_fields'] = $hidden_fields;
	}

	public function acp_bbcodes_group_select_box($event)
	{
		$sql = 'SELECT bbcode_icon
				FROM ' . BBCODES_TABLE . '
				WHERE bbcode_id = ' . (int) $event['bbcode_id'];
		$this->db->sql_query($sql);
		$bbcode_icon = $this->db->sql_fetchfield('bbcode_icon');

		$bbcode_group = ($event['action'] == 'edit') ? $this->acp_manager->get_bbcode_group_data($event['bbcode_id']) : false;

		$tpl_ary = $event['tpl_ary'];
		$tpl_ary['BBCODE_ICON'] = $bbcode_icon;
		$tpl_ary['S_GROUP_OPTIONS'] = $this->acp_manager->bbcode_group_select_options($bbcode_group);
		$event['tpl_ary'] = $tpl_ary;
	}
}
