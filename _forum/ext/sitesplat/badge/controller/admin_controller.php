<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\controller;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\log\log;
use sitesplat\badge\conditions\manager;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\pagination;
use Symfony\Component\DependencyInjection\Container;

/**
 * Admin controller
 */
class admin_controller implements admin_interface
{
	/** @var \phpbb\cache\driver\driver_interface */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var ContainerInterface */
	protected $phpbb_container;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \sitesplat\badge\conditions\manager */
	protected $manager;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	protected $pagination;
	
	protected $phpbb_root_path;

	/** @var string The database table the badge rules are stored in */
	protected $badge_rules_table;

	/** @var string The database table the badge types are stored in */
	protected $badge_types_table;

	/** @var string The database table the badge events are stored in */
	protected $badge_events_table;

	/** @var string The database table the badges are stored in */
	protected $badge_badges_table;

	/** @var string Custom form action */
	protected $u_action;

	public function __construct(config $config, driver_interface $db, Container $phpbb_container, log $log, manager $manager, request $request, template $template, user $user, pagination $pagination, $phpbb_root_path, $badge_rules_table, $badge_types_table, $badge_events_table, $badge_badges_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->log = $log;
		$this->phpbb_container = $phpbb_container;
		$this->manager = $manager;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->pagination = $pagination;
		$this->root_path = $phpbb_root_path;
		$this->badge_rules_table = $badge_rules_table;
		$this->badge_types_table = $badge_types_table;
		$this->badge_events_table = $badge_events_table;
		$this->badge_badges_table = $badge_badges_table;
	}

	/**
	 * {@inheritdoc}
	 */
	public function check_ext()
	{
		$ext_manager = $this->phpbb_container->get('ext.manager');
		$cookie = $this->request->variable($this->config['cookie_name'] . '_banc', '', true, \phpbb\request\request_interface::COOKIE);
		$this->template->assign_vars(array(
			'S_NOTICE_LIKEDD'		=> (!$ext_manager->is_enabled('sitesplat/likedd') && !$cookie) ? $this->user->lang['NOTICE_LIKEDD'] : '',
			'S_NOTICE_DONATION'		=> (!$ext_manager->is_enabled('sitesplat/donations') && !$cookie) ? $this->user->lang['NOTICE_DONATIONS'] : '',
			'S_NOTICE_PROFILEWALL'	=> (!$ext_manager->is_enabled('sitesplat/profilewall') && !$cookie) ? $this->user->lang['NOTICE_PROFILEWALL'] : '',
			'S_NOTICE_PREMIUM'	    => (!$ext_manager->is_enabled('sitesplat/badgepremium') && !$cookie) ? $this->user->lang['NOTICE_PREMIUM'] : '',
			'S_PREMIUM'				=> ($ext_manager->is_enabled('sitesplat/badgepremium')) ? true : false,
			'U_BADGE_NOTICE_CLOSE'	=> "{$this->u_action}&amp;hash=" . generate_link_hash('close_notice')
		));
	}

	/**
	* Badge Award Close Notice
	*
	* @return null
	* @access public
	*/
	public function close_notice()
	{
		$response = $this->set_close_notice_cookie();

		// Send a JSON response if an AJAX request was used
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'success' => $response,
			));
		}
		exit();
	}

	/**
	* Set a cookie to keep an notice closed
	*
	* @return bool True
	* @access protected
	*/
	protected function set_close_notice_cookie()
	{
		// Store the close_notice in a cookie with a 1 year expiration
		$this->user->set_cookie('banc', 'badge_award_notice_closed', time() + 31536000);

		return true;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function display_badge_rules()
	{

		if (check_link_hash($this->request->variable('hash', ''), 'close_notice'))
		{
			$this->close_notice();
		}
		
		$type_ids = $this->manager->get_rule_type_ids();
		array_walk($type_ids, function(&$value, $key, $return) {
			$value = $value[$return];
		}, 'id');

		// Get all badge rules from the database
		$rule_rows = $this->get_all_rules($type_ids);

		// Process all badge data for display in the template
		$ext_manager = $this->phpbb_container->get('ext.manager');

		$start = $this->request->variable('start', 0);
		$per_page = 10;
		$start = $this->pagination->validate_start($start, $per_page, sizeof($rule_rows));
		$base_url = $this->u_action;
		$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', sizeof($rule_rows), $per_page, $start);

		for($i = $start; $i < sizeof($rule_rows) && $i < $start + $per_page; $i++)
		{

				$this->template->assign_block_vars('rules', array(
					'RULE_ID'			=> $rule_rows[$i]['rule_id'],
					'BADGE'				=> $this->root_path . 'ext/sitesplat/badge/badges/' . $rule_rows[$i]['badge'],
					'GROUP_NAME'		=> $rule_rows[$i]['rule_name'],
					'CONDITION_NAME'	=> $this->manager->get_condition_lang($rule_rows[$i]['rule_type_name']),
					'CONDITION_BOOL'	=> $this->manager->get_condition_bool($rule_rows[$i]['rule_type_name']),
	
					'MIN_VALUE'			=> $rule_rows[$i]['rule_min_value'],
					'MAX_VALUE'			=> $rule_rows[$i]['rule_max_value'],
	
					'S_NOTIFY'			=> $rule_rows[$i]['rule_notify'],
					'S_AVAILABLE'		=> ($rule_rows[$i]['rule_type_name'] == 'sitesplat.badge.type.likedd' || $rule_rows[$i]['rule_type_name'] == 'sitesplat.badge.type.donations' || $rule_rows[$i]['rule_type_name'] == 'sitesplat.badge.type.profilewall') ? 
											$ext_manager->is_enabled('sitesplat/' . str_replace('sitesplat.badge.type.', '', $rule_rows[$i]['rule_type_name'])) : true,			
					
					'U_EDIT'	=> "{$this->u_action}&amp;action=edit&amp;rule_id=" . $rule_rows[$i]['rule_id'],
					'U_DELETE'	=> "{$this->u_action}&amp;action=delete&amp;rule_id=" . $rule_rows[$i]['rule_id'],
					'U_SYNC'	=> ($rule_rows[$i]['rule_type_name'] != 'sitesplat.badge.type.custom') ? 
									"{$this->u_action}&amp;action=sync&amp;rule_id=" . $rule_rows[$i]['rule_id'] . '&amp;hash=' . generate_link_hash('sync' . $rule_rows[$i]['rule_id']) : '',
				));

		}

		$this->template->assign_vars(array(
			'BADGE_RANDOM'	=> $this->config['badgeaward_random'],
			'BADGE_AMOUNT'	=> $this->config['badgeaward_amount'],
			'U_ACTION'		=> $this->u_action,
		));

		// Display available badges
		$this->display_available_badges();
	}

	/**
	 * {@inheritdoc}
	 */
	public function submit_badge_options()
	{
		$this->config->set('badgeaward_random', $this->request->variable('badgerandom', 0));
		$this->config->set('badgeaward_amount', $this->request->variable('badgeamount', 5));
		
		$delete_badges = $this->request->variable('deletebadge', array(0));
		if (sizeof($delete_badges))
		{
			foreach($delete_badges as $delete_badge)
			{	
				$sql = 'SELECT badge FROM ' . $this->badge_badges_table . ' WHERE badge_id = ' . (int) $delete_badge;
				$result = $this->db->sql_query($sql);
				$badge = $this->db->sql_fetchfield('badge');
				$this->db->sql_freeresult($result);
				
				if (@unlink($this->root_path . '/ext/sitesplat/badge/badges' . '/' . $badge))
				{
					// Only delete record if success
					$sql = 'DELETE FROM ' . $this->badge_badges_table . ' WHERE badge_id = ' . (int) $delete_badge;;
					$this->db->sql_query($sql);

					// Log the action
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_BADGE_IMG_DELETE_LOG', time());
				}
			}
		}

		$upload = $this->phpbb_container->get('files.factory')->get('upload')
							->set_error_prefix('FILE_')
							->set_allowed_extensions(array('jpg', 'gif', 'svg', 'jpeg', 'png'))
							->set_max_filesize(0)
							->set_allowed_dimensions(0,0,0,0)
							->set_disallowed_content((isset($this->config['mime_triggers']) ? explode('|', $this->config['mime_triggers']) : false));
							
		$upload_dir = $this->root_path . 'ext/sitesplat/badge/badges/';

		$file = $upload->handle_upload('files.types.form', 'fileupload');
		if ($file->get('realname') != '' && !sizeof($file->error))
		{
			$file->clean_filename('real');
			$file->move_file(str_replace($this->root_path, '', $upload_dir), true, true, '0775');
			chmod($upload_dir . $file->get('realname'), 0775);

			if ($file->is_uploaded())
			// https://area51.phpbb.com/docs/dev/32x/files/overview.html	
		//	echo ($file->is_uploaded()) ? 'yes' : 'no';	
			// weird weird weird world 
			{
				$sql = 'INSERT INTO ' . $this->badge_badges_table . ' (badge_id, badge) VALUES(null, "' . $file->get('realname') . '")
				 		ON DUPLICATE KEY UPDATE badge = "' . $file->get('realname') . '"';
				$this->db->sql_query($sql);
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_BADGE_IMG_UPLOAD_LOG', time());
			}
		}
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function save_badge_rule($rule_id = 0)
	{
		// Process badge rule form data if form was submitted
		if ($this->request->is_set_post('submit'))
		{
			$this->submit_badge_rule($rule_id);
		}
		
		// Get data for the badge rule so we can display it
		$rule_data = $this->get_rule_data($rule_id);

		// Process the badge data for display in the template
		if ($rule_data) {
			$rule_data['options'] = str_pad(decbin((int) $rule_data['options']), 2, '0', STR_PAD_LEFT);
			$this->build_rules_list($rule_id);
		}
		
		$this->build_user_list($rule_id);
		$this->display_available_badges($rule_data['badge_id'] ?? 0);
		$this->build_type_menu($rule_data['rule_type_id'] ?? 0);

		$this->template->assign_vars(array(
			'S_ADD'				=> (bool) !$rule_id,
			'S_EDIT'			=> (bool) $rule_id,

			'BADGE_TYPE_EXPLAIN'=> isset($rule_data['rule_type_name']) ? $this->user->lang[strtoupper(str_replace('sitesplat.badge.type.', '', $rule_data['rule_type_name'])) . '_EXPLAIN'] : $this->user->lang['AVATAR_EXPLAIN'],
			'RULE_NAME'			=> isset($rule_data['rule_name']) ? $rule_data['rule_name'] : '',
			'RULE_DESCRIPTION'	=> isset($rule_data['rule_description']) ? $rule_data['rule_description'] : '',
			'BADGE'				=> ($rule_id) ? $this->root_path . 'ext/sitesplat/badge/badges/' . $rule_data['badge'] : 
									$this->root_path . 'ext/sitesplat/badge/badges/ace.png',
			'CONDITION_BOOL'	=> isset($rule_data['rule_name']) ? $this->manager->get_condition_bool($rule_data['rule_type_name']) : '',
			'DISPLAY_USERLIST'	=> (isset($rule_data['rule_name']) && $rule_data['rule_type_name'] == 'sitesplat.badge.type.custom') ? true : false,
			'DISPLAY_RULESLIST'	=> (isset($rule_data['rule_name']) && $rule_data['rule_type_name'] == 'sitesplat.badge.type.cross_badge') ? true : false,
			'MIN_VALUE'			=> isset($rule_data['rule_min_value']) ? (int) $rule_data['rule_min_value'] : '',
			'MAX_VALUE'			=> isset($rule_data['rule_max_value']) ? (int) $rule_data['rule_max_value'] : '',

			'S_NOTIFY'			=> isset($rule_data['rule_name']) ? (bool) $rule_data['rule_notify'] : false,
			
			'S_OPTION1'			=> (isset($rule_data['rule_name']) && ($rule_data['rule_type_name'] == 'sitesplat.badge.type.likedd')) ? true : false,
			'S_OPTION_SWITCH'	=> (isset($rule_data['rule_name']) && $rule_data['rule_type_name'] == 'sitesplat.badge.type.likedd') ? (substr($rule_data['options'], 0, 1) ? true : false) : '',
			'S_OPTION1_SWITCH'	=> (isset($rule_data['rule_name']) && $rule_data['rule_type_name'] == 'sitesplat.badge.type.likedd') ? (substr($rule_data['options'], 1, 2) ? true : false) : '',

			'S_OPTION2'			=> (isset($rule_data['rule_name']) && ($rule_data['rule_type_name'] == 'sitesplat.badge.type.profilewall')) ? true : false,
			'S_OPTION2_SWITCH'	=> (isset($rule_data['rule_name']) && $rule_data['rule_type_name'] == 'sitesplat.badge.type.profilewall') ? (substr($rule_data['options'], 1, 2) ? true : false) : '',
			
			'U_FORM_ACTION'		=> $this->u_action . '&amp;action=' . (($rule_id) ? "edit&amp;rule_id=$rule_id" : 'add'),
			'U_ACTION'			=> $this->u_action,
			'U_BACK'			=> $this->u_action,
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete_badge_rule($rule_id)
	{
		// Delete badge rule
		$sql = 'DELETE FROM ' . $this->badge_rules_table . '
			WHERE rule_id = ' . (int) $rule_id;
		$this->db->sql_query($sql);

		$this->manager->purge_badge_events($rule_id);
		
		// Log the action
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_BADGE_DELETE_LOG', time());

		// If AJAX was used, show user a result message
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'MESSAGE_TITLE'	=> $this->user->lang['INFORMATION'],
				'MESSAGE_TEXT'	=> $this->user->lang('ACP_BADGE_DELETE_SUCCESS'),
				'REFRESH_DATA'	=> array(
					'time'	=> 3
				)
			));
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function resync_badge_rule($rule_id)
	{
		// If the link hash is invalid, stop and show an error message to the user
		if (!check_link_hash($this->request->variable('hash', ''), 'sync' . $rule_id))
		{
			trigger_error($this->user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
		}

		try
		{
			$data = $this->get_rule_data($rule_id);
			$this->manager->sync_badge($rule_id, $data['options']);
		}
		catch (\Exception $e)
		{
			trigger_error($e->getMessage() . adm_back_link($this->u_action), E_USER_WARNING);
		}
	}

	/**
	 * Submit badge rule form data
	 *
	 * @param int $rule_id An badge rule identifier
	 *                           A value of 0 is new, otherwise we're updating
	 * @return null
	 * @access protected
	 */
	protected function submit_badge_rule($rule_id = 0)
	{
		$rule_type_name = $this->manager->get_rule_type_name($this->request->variable('rule_type_id', 0), $rule_id);
		$isbool = $this->manager->get_condition_bool($rule_type_name);
		$ruleslist = $this->request->variable('ruleslist', array(''));

		$data = array(
			'rule_type_id'		=> $this->request->variable('rule_type_id', 0),
			'rule_min_value'	=> ($isbool) ? 1 : $this->request->variable('rule_min_value', 0),
			'rule_max_value'	=> ($isbool) ? 0 : $this->request->variable('rule_max_value', 0),
			'badge_id'			=> $this->request->variable('badge_id', 0),
			'rule_name'			=> utf8_normalize_nfc($this->request->variable('rule_name', '', true)),
			'rule_description'	=> utf8_normalize_nfc($this->request->variable('rule_description', '', true)),
			'rule_notify'		=> $this->request->variable('rule_notify', false),
			'options'			=> ($rule_type_name == 'sitesplat.badge.type.cross_badge') ? json_encode($ruleslist) :
									(($rule_type_name == 'sitesplat.badge.type.profilewall') ? $this->request->variable('options3', '0') : 
									bindec($this->request->variable('options', '0') . $this->request->variable('options2', '0'))),
		);

		// Prevent form submit when no badge is available or selected
		if (!$data['badge_id'])
		{
			trigger_error($this->user->lang('ACP_BADGE_NO_IMAGE') . adm_back_link('javascript:history.back()'), E_USER_WARNING);
		}

		if ($data['rule_max_value'] && ($data['rule_max_value'] <= $data['rule_min_value']))
		{
			trigger_error($this->user->lang('ACP_BADGE_INVALID_VALUE') . adm_back_link('javascript:history.back()'), E_USER_WARNING);
		}

		$sql = 'SELECT rule_name FROM ' . $this->badge_rules_table . ' WHERE rule_id <> ' . $rule_id;
		$result = $this->db->sql_query($sql);
		$rule_names = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		
		if ($data['rule_name'] == '' || (is_array($rule_names) && in_array($data['rule_name'], $rule_names)))
		{
			trigger_error($this->user->lang('ACP_BADGE_NAME_USED') . adm_back_link('javascript:history.back()'), E_USER_WARNING);
		}

		if ($rule_id != 0) // Update existing badge rule data
		{
			$sql = 'UPDATE ' . $this->badge_rules_table . '
				SET ' . $this->db->sql_build_array('UPDATE', $data) . '
				WHERE rule_id = ' . (int) $rule_id;
			$this->db->sql_query($sql);
		} else // Insert new badge rule data
		{
			$sql = 'INSERT INTO ' . $this->badge_rules_table . ' ' . $this->db->sql_build_array('INSERT', $data);
			$this->db->sql_query($sql);
			$rule_id = $this->db->sql_nextid();
		}

		// Apply the badge rule to all users
		if ($rule_type_name != 'sitesplat.badge.type.custom')
		{
			$this->manager->sync_badge($rule_id, $data['options']);
		} else
		{
			$sql = 'DELETE FROM ' . $this->badge_events_table . ' WHERE rule_id = ' . $rule_id;
			$this->db->sql_query($sql);
			
			$this->manager->sync_badge($rule_id);
		}

		// Log the action
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, (($rule_id) ? 'ACP_BADGE_SAVED_LOG' : 'ACP_BADGE_ADD_LOG'), time());

		// Output message to user after submitting the form
		meta_refresh(3, $this->u_action);
		trigger_error($this->user->lang('ACP_BADGE_SUBMIT_SUCCESS') . adm_back_link($this->u_action));
	}

	/**
	 * Get one badge rule from the database
	 *
	 * @param int $id An badgep rule identifier
	 * @return array An badge rule and it's associated data
	 * @access public
	 */
	protected function get_rule_data($id = 0)
	{
		$rule_data = false;
		if ($id) {
			$sql = 'SELECT r.*, b.badge, t.rule_type_name
				FROM ' . $this->badge_rules_table . ' r
				LEFT JOIN ' . $this->badge_badges_table . ' b ON b.badge_id = r.badge_id
				LEFT JOIN ' . $this->badge_types_table . ' t ON t.rule_type_id = r.rule_type_id
				WHERE rule_id = ' . (int) $id;
			$result = $this->db->sql_query($sql);
			$rule_data = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
		}

		return $rule_data;
	}

	/**
	 * Get all badge rules from the database
	 *
	 * @return array Array of badge rules and their associated data
	 * @access public
	 */
	protected function get_all_rules($type_ids = array())
	{
		$sql = 'SELECT br.*, bt.rule_type_name, badge
				FROM ' . $this->badge_rules_table .' br
				LEFT JOIN ' . $this->badge_types_table .' bt ON br.rule_type_id = bt.rule_type_id
				LEFT JOIN ' . $this->badge_badges_table .' bb ON br.badge_id = bb.badge_id
				WHERE br.rule_type_id IN (' . implode(',', $type_ids) . ')
				ORDER BY br.rule_type_id, br.rule_name, br.rule_min_value ASC';
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		return $rows ?: [];
	}

	/**
	 * Display available badges
	 *
	 * @return null
	 * @access protected
	 */
	protected function display_available_badges($selected = 0)
	{
		$sql = 'SELECT b.badge_id, b.badge, GROUP_CONCAT(rule_name SEPARATOR "\n") AS rules 
			FROM ' . $this->badge_badges_table . ' b
			LEFT JOIN ' . $this->badge_rules_table . ' r ON r.badge_id = b.badge_id  
			GROUP BY badge_id
			ORDER BY badge';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('badges', array(
				'BADGE_ID'		=> $row['badge_id'],
				'BADGE_IMG'		=> $this->root_path . 'ext/sitesplat/badge/badges/' . $row['badge'],
				'BADGE_NAME'	=> $row['badge'],
				'BADGE_RULES'	=> $row['badge'] . "\n" . $row['rules'],
				'BADGE_DEL'		=> ($row['rules'] == '') ? $row['badge_id'] : '',
				'S_SELECTED'	=> ($selected == $row['badge_id']) ? true : false,
			));
		}

		$this->db->sql_freeresult($result);
	}

	/**
	 * Build template vars for a select menu of badge types
	 *
	 * @param int $selected An identifier for the selected badge type
	 * @return null
	 * @access protected
	 */
	protected function build_type_menu($selected)
	{
		$conditions = $this->manager->get_rule_type_ids();
		$boolean_condition = array();
		foreach ($conditions as $condition_name => $type_id)
		{
			$this->template->assign_block_vars('conditions', array(
				'CONDITION_ID'			=> $type_id['id'],
				'CONDITION'				=> $type_id['type'],
				'CONDITION_NAME'		=> $condition_name,
				'CONDITION_EXPLANATION'	=> $this->user->lang[strtoupper(str_replace('sitesplat.badge.type.', '' ,$type_id['type'])) . '_EXPLAIN'],
				'S_SELECTED'			=> $type_id['id'] == $selected,
			));
			$boolean_condition[$type_id['id']] = ($this->manager->get_condition_bool($type_id['type'])) ? 1 : 0;
		}
		$this->template->assign_vars(array('BOOL_CONDITION' => implode(',', $boolean_condition)));
	}

	/**
	 * Build template vars for a select menu of users
	 *
	 * @param int $selected An identifier for the selected user(s)
	 * @return null
	 * @access protected
	 */
	protected function build_user_list($rule_id)
	{
		$sql = 'SELECT u.user_id, u.username, IFNULL(e.rule_id, 0) AS selected 
			FROM ' . USERS_TABLE . ' u
			LEFT JOIN ' . $this->badge_events_table . ' e ON e.user_id = u.user_id AND e.rule_id = ' . $rule_id . '
			WHERE ' . $this->db->sql_in_set('u.user_type', array(USER_INACTIVE, USER_IGNORE), true) . ' ORDER BY u.username ASC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('userlist', array(
				'USER_ID'		=> $row['user_id'],
				'USERNAME'		=> $row['username'],

				'S_SELECTED'	=> ($row['selected'] && $row['selected'] == $rule_id) ? true : false,
			));
		}

		$this->db->sql_freeresult($result);
	}

	/**
	 * Build template vars for a select menu of rules
	 *
	 * @param int $selected An identifier for the selected user(s)
	 * @return null
	 * @access protected
	 */
	protected function build_rules_list($rule_id)
	{
		$sql = 'SELECT options FROM ' . $this->badge_rules_table . ' WHERE rule_id = ' . $rule_id;
		$result = $this->db->sql_query($sql);
		$options = json_decode($this->db->sql_fetchfield('options'));

		$sql = 'SELECT rule_id, rule_name 
			FROM ' . $this->badge_rules_table . ' 
			WHERE rule_type_id <> (SELECT rule_type_id FROM ' . $this->badge_types_table . ' WHERE rule_type_name = "sitesplat.badge.type.cross_badge")
			ORDER BY rule_name ASC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('ruleslist', array(
				'USER_ID'		=> $row['rule_id'],
				'USERNAME'		=> $row['rule_name'],

				'S_SELECTED'	=> (is_array($options) && in_array($row['rule_id'], $options)) ? true : false,
			));
		}

		$this->db->sql_freeresult($result);
	}

	/**
	 * {@inheritdoc}
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
