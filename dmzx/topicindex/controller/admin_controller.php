<?php
/**
*
* @package phpBB Extension - Topic Index
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\topicindex\controller;

use phpbb\config\config;
use phpbb\template\template;
use phpbb\log\log_interface;
use phpbb\user;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\request\request_interface;

class admin_controller
{
	/** @var config */
	protected $config;

	/** @var template */
	protected $template;

	/** @var log_interface */
	protected $log;

	/** @var user */
	protected $user;

	/** @var db_interface */
	protected $db;

	/** @var request_interface */
	protected $request;

	/**
	* The database table
	*
	* @var string
	*/
	protected $forum_lists_table;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor
	 *
	 * @param config				$config
	 * @param template				$template
	 * @param log_interface			$log
	 * @param user					$user
	 * @param db_interface			$db
	 * @param request_interface		$request
	 * @param string 				$forum_lists_table
	 */
	public function __construct(
		config $config,
		template $template,
		log_interface $log,
		user $user,
		db_interface $db,
		request_interface $request,
		$forum_lists_table
	)
	{
		$this->config 				= $config;
		$this->template 			= $template;
		$this->log 					= $log;
		$this->user 				= $user;
		$this->db 					= $db;
		$this->request 				= $request;
		$this->forum_lists_table 	= $forum_lists_table;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		$this->user->add_lang_ext('dmzx/topicindex', 'acp_topicindex');

		add_form_key('acp_topicindex');

		$error		= array();
		$submit		= $this->request->is_set_post('submit');
		$setcfg		= $this->request->is_set_post('setcfg');
		$delete		= $this->request->variable('del', 0);

		// Get forums list
		$forum_list = make_forum_select(false, false, true, false, false, false, true);

		// Build forum options
		$s_forum_options = '';
		foreach ($forum_list as $f_id => $f_row)
		{
			$s_forum_options .= '<option value="' . $f_id . '"' . (($f_row['disabled'] || $f_row['forum_type'] != 1) ? ' disabled="disabled" class="disabled-option"' : '') . '>' . $f_row['padding'] . $f_row['forum_name'] . '</option>';
		}

		$this->template->assign_vars(array(
			'S_SELECT_FORUM'		=> true,
			'S_FORUM_OPTIONS'		=> $s_forum_options,
			'U_ACTION'				=> $this->u_action,
			'S_OVERFLOW'			=> (!empty($this->config['oindex_overflow'])) ? ' checked="checked"' : '',
			'S_FORUM_MULTIPLE'		=> true,
			'TOPICINDEX_VERSION'	=> $this->config['topicindex_version'],
		));

		// Get saved lists
		$sql = 'SELECT *
			FROM ' . $this->forum_lists_table . '
				ORDER BY list_name ASC';
		$result	= $this->db->sql_query($sql);
		$i = 0;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$forumari = json_decode($row['list_forum']);

			$this->template->assign_block_vars('list', array(
				'LIST_NAME'		=> $row['list_name'],
				'LIST_FORUMS'	=> (sizeof($forumari)) ? implode(', ', $forumari) : '',
				'U_REMOVE'		=> $this->u_action . "i=oindex&amp;mode=main&amp;del=" . $row['list_id'],
			));
			$i++;
		}
		$this->db->sql_freeresult($result);

		$this->template->assign_vars(array(
			'S_LIST'	=> ($i > 0) ? true : false,
			'ERROR'		=> (sizeof($error)) ? implode('<br />', $error) : ''
		));

		if ($submit)
		{
			if (!check_form_key('acp_topicindex'))
			{
				trigger_error($this->user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
			}

			unset ($error);
			$error		= array();
			$listname	= $this->request->variable('list_name', '', true);
			$forumlist	= $this->request->variable('forum_id', array(0));

			if (empty($listname))
			{
				$error[] = $this->user->lang['NAME_FORUM_LIST_EMPTY'];
			}

			if (empty($forumlist))
			{
				$error[] = $this->user->lang['SELECT_FORUM_LIST_EMPTY'];
			}

			if (!sizeof($error))
			{
				$sql_array	= array(
					'list_name'		=> $listname,
					'list_forum'	=> json_encode($forumlist),
				);
				$sql = "INSERT INTO " . $this->forum_lists_table . " " . $this->db->sql_build_array('INSERT', $sql_array);
				$this->db->sql_query($sql);

				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_OINDEX_ADDLIST', false, array($this->user->data['username']));
				trigger_error($this->user->lang['OINDEX_ADDED_LIST'] . adm_back_link($this->u_action));
			}

			$this->template->assign_vars(array(
				'ERROR'		=> (sizeof($error)) ? implode('<br />', $error) : '')
			);
		}

		if (!empty($delete))
		{
			$sql = "DELETE FROM " . $this->forum_lists_table . "
				WHERE list_id = " . $delete;
			$this->db->sql_query($sql);

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_OINDEX_DELETELIST', false, array($this->user->data['username']));
			trigger_error($this->user->lang['OINDEX_DELETED_LIST'] . adm_back_link($this->u_action));
		}

		if ($setcfg)
		{
			$overflow = $this->request->variable('overflow', 0);
			$this->config->set('oindex_overflow', $overflow);

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_OINDEX_EDITCFG', false, array($this->user->data['username']));
			trigger_error($this->user->lang['OINDEX_EDIT_CFG'] . adm_back_link($this->u_action));
		}
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
