<?php
/**
*
* BBadblock extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbadblock\acp;

class bbadblock_module
{
	var $u_action;

	public function main($id, $mode)
	{
		global $db, $u_action, $phpbb_container, $request, $user, $config, $template, $phpbb_path_helper, $phpbb_extension_manager, $phpbb_root_path;
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->phpbb_path_helper = $phpbb_path_helper;
		$this->extension_manager = $phpbb_extension_manager;
		$this->phpbb_container = $phpbb_container;

		// Load a template from adm/style for our extension
		$this->tpl_name = 'bbadblock';

		if ($this->request->variable('action', '') == 'details')
		{
			$this->user->add_lang_ext('sitesplat/bbadblock', 'info_acp_bbadblock');
			$this->phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/bbadblock');
			$this->tpl_name = 'acp_ext_details';
		}
		
		// Quick-submit settings from the general options form
		if ($this->request->is_set_post('set_config'))
		{
			$this->config->set('bbadblock_classname', ($this->extension_manager->is_enabled('sitesplat/ads')) ? 'ad_postbody' : $this->request->variable('bbadblock_classname', ''));		
			$this->config->set('bbadblock_message', utf8_normalize_nfc($this->request->variable('bbadblock_message', '', true)));
			$this->config->set('bbadblock_redirect', $this->request->variable('bbadblock_redirect', ''));
			$this->config->set('bbadblock_autoreset', $this->request->variable('bbadblock_autoreset', 0));
			$this->config->set('bbadblock_hide_forums', json_encode($this->request->variable('bbadblock_hide_forums', array(0))));
			$this->config->set('bbadblock_modal_alert', $this->request->variable('bbadblock_modal_alert', 0));
			$this->config->set('bbadblock_group', ($this->extension_manager->is_enabled('sitesplat/bbmembership')) ? $this->request->variable('bbadblock_group', 0) : 0);
			$this->show_result('Changes saved');
		}

		if (check_link_hash($this->request->variable('hash', ''), 'close_notice'))
		{
			$this->close_notice();
		}

		$cookie = $this->request->variable($this->config['cookie_name'] . '_bbadblocknotice', '', true, \phpbb\request\request_interface::COOKIE);
		$this->template->assign_vars(array(
			'S_NOTICE_BBMEMBERSHIP'			=> (!$this->extension_manager->is_enabled('sitesplat/bbmembership') && !$cookie) ? $this->user->lang['NOTICE_BBMEMBERSHIP'] : '',
			'S_NOTICE_MINICMS'			    => (!$this->extension_manager->is_enabled('sitesplat/flatbootsminicms') && !$cookie) ? $this->user->lang['NOTICE_BBADBLOCK_MINICMS'] : '',
			'U_BBMEMBERSHIP_NOTICE_CLOSE'	=> $this->u_action . '&amp;hash=' . generate_link_hash('close_notice')
		));

		// Set the page title for our ACP bbadblock
		$this->page_title = $user->lang('ACP_BBADBLOCK_INDEX_TITLE');

		if ($this->request->variable('action', '') == 'delete')
		{
			$sql = 'UPDATE ' . USERS_TABLE . ' SET bbadblock = 0 WHERE user_id = ' .  $this->request->variable('id', 0);
			$this->db->sql_query($sql);
		}

		$start		= $this->request->variable('start', 0);
		$per_page	= 10;
		$sk = ($this->request->variable('sk', 'username') == 'hits') ? 'hits' : (($this->request->variable('sk', 'username') == 'username') ? 'username' : 'timestamp');
		$sd = ($this->request->variable('sd', 'd') == 'd') ? 'd' : 'a';

		$sql = 'SELECT COUNT(user_id) AS total FROM ' . USERS_TABLE . ' WHERE bbadblock <> 0';
		$result = $this->db->sql_query($sql);
		$total_users = $this->db->sql_fetchfield('total');

		$sql = 'SELECT user_id, username, SUBSTRING_INDEX(SUBSTRING_INDEX(bbadblock, "~", 1), "~", -1) as timestamp, 
				SUBSTRING_INDEX(SUBSTRING_INDEX(bbadblock, "~", 2), "~", -1) as hits
				FROM ' . USERS_TABLE . ' 
				WHERE bbadblock <> 0
				ORDER BY ' . (($sk == 'hits') ? 'hits': (($sk == 'username') ? 'username': 'timestamp')) . ' ' . (($sd == 'd') ? 'DESC': 'ASC');
		$result = $this->db->sql_query_limit($sql, $per_page, $start);
		$i = $start;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('records', array(
				'NUM'		=> ++$i,
				'ID'		=> $row['user_id'],
				'USER'		=> $row['username'],
				'COUNT'		=> $row['hits'],
				'SINCE'		=> $this->user->format_date($row['timestamp'])
			));
		}

		if ($this->extension_manager->is_enabled('sitesplat/bbmembership'))
		{
			$sql = 'SELECT group_id, group_type, group_name	FROM ' . GROUPS_TABLE . ' ORDER BY group_name ASC';
			$result = $this->db->sql_query($sql);
			$group_ary[0] = '----';
			while ($row = $this->db->sql_fetchrow($result))
			{
				$this->template->assign_block_vars('usergroups', array(
					'GROUP_ID'		=> $row['group_id'],
					'GROUP_NAME'	=> ($row['group_type'] == GROUP_SPECIAL) ? $this->user->lang('G_' . $row['group_name']) : $row['group_name'],
					'SELECTED'		=> ($row['group_id'] == $this->config['bbadblock_group']) ? ' selected="selected"' : ''
				));
			}
		}
		
		// Display setup
		$this->template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
			'EXT_PATH'				=> $this->phpbb_path_helper->update_web_root_path($this->extension_manager->get_extension_path('sitesplat/bbadblock', true)),
			'BBADBLOCK_S_CLASSNAME'	=> ($this->extension_manager->is_enabled('sitesplat/ads')),
			'BBADBLOCK_CLASSNAME'	=> $this->config['bbadblock_classname'],
			'BBADBLOCK_MESSAGE'		=> $this->config['bbadblock_message'],
			'BBADBLOCK_REDIRECT'	=> $this->config['bbadblock_redirect'],
			'BBADBLOCK_AUTO_RESET'	=> $this->config['bbadblock_autoreset'],
			'BBADBLOCK_HIDE_FORUMS' => make_forum_select(json_decode($this->config['bbadblock_hide_forums'], true), 0, 0, 1),
			'BBADBLOCK_MODAL_ALERT'	=> $this->config['bbadblock_modal_alert'],
			'U_SORT'	=> $sd,
			'U_NAME'	=> ($sk == 'timestamp') ? 'since' : $sk,
			'NEXTURL'	=> ($start > (floor($total_users / $per_page) * $per_page) - $per_page) ? '' : $this->u_action . '&start=' . ($start + $per_page) . '&sd=' . $sd . '&sk=' . $sk,
			'PREVURL'	=> (($start - $per_page) < 0) ? '' : $this->u_action . '&start=' . ($start - $per_page) . '&sd=' . $sd . '&sk=' . $sk
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function show_result($message)
	{
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'MESSAGE_TITLE'	=> $this->user->lang['INFORMATION'],
				'MESSAGE_TEXT'	=> $message,
				'REFRESH_DATA'	=> array(
					'time'	=> 3,
					'url'	=> $this->u_action
				)
			));
		} else
		{
			trigger_error($message . adm_back_link($this->u_action), E_USER_NOTICE);
		}
	}

	/**
	* BBadblock Close Notice
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
		$this->user->set_cookie('bbadblocknotice', 'bbadblock_notice_closed', time() + 31536000);

		return true;
	}
}
