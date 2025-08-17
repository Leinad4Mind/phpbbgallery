<?php
/**
*
* @package phpBB Extension - Topic Index
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\topicindex\controller;

use dmzx\topicindex\core\functions_topicindex;
use phpbb\template\template;
use phpbb\user;
use phpbb\auth\auth;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\request\request_interface;
use phpbb\controller\helper;
use phpbb\config\config;
use phpbb\exception\http_exception;

class main
{
	/** @var functions_topicindex */
	protected $functions_topicindex;

	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/** @var auth */
	protected $auth;

	/** @var db_interface */
	protected $db;

	/** @var request_interface */
	protected $request;

	/** @var helper */
	protected $helper;

	/** @var config */
	protected $config;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/**
	* The database table
	*
	* @var string
	*/
	protected $forum_lists_table;

	/**
	* Constructor
	*
	* @param functions_topicindex	$functions_topicindex
	* @param template		 		$template
	* @param user					$user
	* @param auth					$auth
	* @param db_interface			$db
	* @param request_interface		$request
	* @param helper		 			$helper
	* @param config					$config
	* @param string 				$root_path
	* @param string 				$php_ext
	* @param string 				$forum_lists_table
	*/
	public function __construct(
		functions_topicindex $functions_topicindex,
		template $template,
		user $user,
		auth $auth,
		db_interface $db,
		request_interface $request,
		helper $helper,
		config $config,
		$root_path,
		$php_ext,
		$forum_lists_table
	)
	{
		$this->functions_topicindex	= $functions_topicindex;
		$this->template 			= $template;
		$this->user 				= $user;
		$this->auth 				= $auth;
		$this->db 					= $db;
		$this->request 				= $request;
		$this->helper 				= $helper;
		$this->config				= $config;
		$this->root_path 			= $root_path;
		$this->php_ext 				= $php_ext;
		$this->forum_lists_table 	= $forum_lists_table;
	}

	public function handle_topicindex()
	{
		if (!$this->auth->acl_get('u_topicindex_view'))
		{
			throw new http_exception(403, 'NOT_AUTHORISED');
		}

		$list		= $this->request->variable('list', 0);
		$iremove	= $this->request->variable('iremove', 0);
		$ilimiter	= $this->request->variable('ilimit', '');
		$zurl		= $this->helper->route('dmzx_topicindex_controller', array('list' => $list));

		// Action add / remove topics
		if (!empty($iremove))
		{
			// Get the relative forum
			$sql	= 'SELECT topic_id, forum_id
				FROM ' . TOPICS_TABLE . '
				WHERE topic_id = ' . $iremove;
			$result	= $this->db->sql_query_limit($sql,1);
			$row	= $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			$this->functions_topicindex->remove_from_ilist($row['forum_id'], $iremove);
			redirect($zurl, false, true);
		}

		// Navigation
		$this->template->assign_block_vars('navlinks', array(
			'FORUM_NAME'	=> $this->user->lang['OIINDEX_HEADER'],
			'U_VIEW_FORUM'	=> $zurl
		));

		if (empty($list))
		{
			// This is the main page

			// Grab crated list for select
			$s_list_options = '';
			$sql	= 'SELECT *
				FROM ' . $this->forum_lists_table . '
				ORDER BY list_name ASC';
			$result	= $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$s_list_options .= '<option value="' . $row['list_id'] . '">' . $row['list_name'] . '</option>';
			}
			$this->db->sql_freeresult($result);

			$this->template->assign_vars(array(
				'S_SHOWLIST'	 	=> false,
				'U_ACTION'			=> $zurl,
				'S_LIST_OPTIONS'	=> $s_list_options
			));
		}
		else
		{
			// This is for the real list

			// Grab crated list for select
			$s_list_options = '';
			$sql	= 'SELECT *
				FROM ' . $this->forum_lists_table . '
				ORDER BY list_name ASC';
			$result	= $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$s_list_options .= '<option value="' . $row['list_id'] . '"' . (($list == $row['list_id']) ? ' selected="selected"' : '') . '>' . $row['list_name'] . '</option>';
			}
			$this->db->sql_freeresult($result);

			$this->template->assign_vars(array(
				'S_SHOWLIST'	 	=> true,
				'U_ACTION'			=> $zurl,
				'S_LIST_OPTIONS'	=> $s_list_options,
				'U_MCP'				=> ($this->auth->acl_getf_global('m_')) ? true : false
			));

			// Get relative list data
			$sql1 		= 'SELECT *
				FROM ' . $this->forum_lists_table . '
				WHERE list_id = ' . $list;
			$result1	= $this->db->sql_query($sql1);
			$row1		= $this->db->sql_fetchrow($result1);
			$this->db->sql_freeresult($result1);

			$forumsari 	= json_decode($row1['list_forum']);
			$filtrini	= range('a', 'z');
			$indexlist	= array();

			foreach ($forumsari as $forum_id)
			{
				$forum_id			= (int) $forum_id;
				$forum_data			= $this->functions_topicindex->get_ForumBasedata($forum_id);
				$indexlist_temp		= $this->functions_topicindex->get_topic_index($forum_id, 0, $forum_data['inindex'], $forum_data['filter']);
				$indexlist			= array_merge($indexlist, $indexlist_temp);
			}

			// Order the topics
			if (count($indexlist) > 0)
			{
				foreach ($indexlist as $key => $row)
				{
					$order_in_category[$key]	= $row['keybig'];
				}
				array_multisort($order_in_category, SORT_ASC, $indexlist);
			}

			$fixa 		= $this->functions_topicindex->create_key_list($indexlist);
			$fixedlist	= $this->functions_topicindex->filter_topiclist($indexlist, $ilimiter);
			$bulo		= (!$ilimiter) ? $fixa : array($ilimiter);

			// Create data for template
			foreach ($filtrini as $filtrino)
			{
				// Build menu
				$this->template->assign_block_vars('block_filtrino', array(
					'U_FILTER'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit' => $filtrino)),
					'FILTRINO'	=> $filtrino,
					'S_ISWITH'	=> (in_array($filtrino, $fixa)) ? true : false
				));
			}

			// Build template data
			foreach ($fixa as $realfilter)
			{
				$this->template->assign_block_vars('block_list', array(
					'FILTRINO'	=> ($realfilter == '_') ? $this->user->lang['SYMB'] : strtoupper($realfilter),
					'S_ISWITH2'	=> (in_array($realfilter, $bulo)) ? true : false
				));

				$nums = 0;
				foreach ($fixedlist as $indexdata)
				{
					if ($realfilter == $indexdata['key'])
					{
						$this->template->assign_block_vars('block_list.block_topic_index', array(
							'ITOPIC_URL'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$indexdata['id']}"),
							'ITOPIC_TITLE'	=> $indexdata['title'],
							'ITOPIC_POSTER'	=> get_username_string('full', $indexdata['posterid'], $indexdata['poster'], $indexdata['postercol']),
							'ITOPIC_TOTREP'	=> $indexdata['posts'],
							'U_REMOVE_FROM'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'iremove' => $indexdata['id'])),
							'ITOPIC_CLASS'	=> ($nums % 2) ? 'row bg1' : 'row bg2'
						));
						$nums++;
					}
				}
			}

			// Others data for menu
			$this->template->assign_block_vars('block_nofiltrino', array(
				'U_TUTTI'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list)),
				'U_09'		=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit=09')),
				'U_SYMB'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit=_')),
				'S_09'		=> (in_array('09', $fixa)) ? true : false,
				'S_SYMB'	=> (in_array('_', $fixa)) ? true : false
			));
		}

		$this->functions_topicindex->assign_authors();

		$this->template->assign_var('TOPICINDEX_FOOTER_VIEW', true);

		// Send all data to the template file
		return $this->helper->render('topiclist.html', $this->user->lang['OIINDEX_HEADER']);
	}
}
