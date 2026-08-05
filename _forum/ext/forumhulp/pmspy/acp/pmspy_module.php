<?php
/**
*
* @package PM SPy
* @copyright (c) 2016 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\pmspy\acp;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\user;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\pagination;

class pmspy_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	private $config;
	private $db;
	private $user;
	private $request;
	private $template;
	private $pagination;
	private $phpbb_root_path;
	private $php_ext;

	private function setup(config $config, driver_interface $db, user $user, request_interface $request, template $template, pagination $pagination, $phpbb_root_path, $phpEx)
	{
		$this->config 			= $config;
		$this->db 				= $db;
		$this->user 			= $user;
		$this->request 			= $request;
		$this->template 		= $template;
		$this->pagination		= $pagination;
		$this->phpbb_root_path	= $phpbb_root_path;
		$this->php_ext			= $phpEx;
	}

	function main($id, $mode)
	{
		global $config, $db, $user, $request, $template, $phpbb_container, $phpbb_root_path, $phpEx;

		$this->setup($config, $db, $user, $request, $template, $phpbb_container->get('pagination'), $phpbb_root_path, $phpEx);

		$this->tpl_name			= 'acp_pm_spy';
		$this->page_title		= 'ACP_PM_SPY';

		if ($this->request->variable('action', '') == 'details')
		{
			$this->user->add_lang_ext('forumhulp/pmspy', 'info_acp_pmspy');
			$phpbb_container->get('forumhulp.helper')->detail('forumhulp/pmspy');
			$this->tpl_name = 'acp_ext_details';
		} else if ($this->request->variable('action', '') == 'keyword')
		{
			$return_ary = array();
			$term = utf8_strtolower($this->request->variable('term', '', true));
			$sql_lower = $this->db->sql_lower_text('x.username');
			$sql = 'SELECT x.* FROM
					(
						SELECT p.user_id AS result, u.username
						FROM ' . PRIVMSGS_TO_TABLE . ' p
						LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = p.user_id
						UNION DISTINCT
						SELECT t.author_id, u.username
						FROM ' . PRIVMSGS_TO_TABLE . ' t
						LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = t.author_id
					) x
					WHERE ' . $sql_lower . ' ' . $this->db->sql_like_expression($term . $this->db->get_any_char()) . '
					ORDER BY x.username';
			$result = $this->db->sql_query_limit($sql, 10);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$return_ary[] = array(
					'value'		=> $row['result'],
					'label'		=> $row['username'],
				);
			}
			$this->db->sql_freeresult($result);

			$json_response = new \phpbb\json_response();
			$json_response->send($return_ary);
		} else
		{
			// Start initial var setup
			$start			= $this->request->variable('start', 0);
			$sk				= $this->request->variable('sk', 'd');
			$sd				= $this->request->variable('sd', 'd');
			$delete			= $this->request->is_set_post('delete');
			$filter			= $this->request->is_set_post('filter');
			$keywords		= $this->request->variable('keywords', '', true);
			$userid			= $this->request->variable('userid', 0);
			$sql_keywords	= $keywords_param = '';

			add_form_key('forumhulp_pmspy');

			if ($delete)
			{
				if (!check_form_key('forumhulp_pmspy'))
				{
					trigger_error('FORM_INVALID');
				}

				$pm_spy_list = $this->request->variable('mark', array(''));
				$pm_list = array();

				foreach ($pm_spy_list as $pm_id)
				{
					$pm_id_ary = explode(':', $pm_id);

					if (sizeof($pm_id_ary) !== 3)
					{
						continue;
					}

					list($msg_id, $pm_user_id, $folder_id) = array_map('intval', $pm_id_ary);
					$pm_list[] = array('msg_ids' => $msg_id, 'user_id' => $pm_user_id, 'folder_id' => $folder_id);
				}

				if (!sizeof($pm_list))
				{
					trigger_error($this->user->lang['NO_PM_SELECTED']);
				}

				if (!function_exists('delete_pm'))
				{
					include($this->phpbb_root_path . 'includes/functions_privmsgs.' . $this->php_ext);
				}

				foreach ($pm_list as $row)
				{
					delete_pm($row['user_id'], $row['msg_ids'], $row['folder_id']);
				}

				add_log('admin', 'LOG_PM_SPY');
			} else if ($filter || $keywords)
			{
				$keywords_param = !empty($keywords) ? '&amp;keywords=' . urlencode(htmlspecialchars_decode($keywords)) : '';
				$sql_keywords = $this->generate_sql_keyword($keywords);
			} else if ($userid)
			{
				$sql_keywords = ' WHERE t.user_id = ' . $userid . ' OR t.author_id = ' . $userid;
			}

			$sort_dir = ($sd == 'd') ? ' DESC' : ' ASC';

			switch ($sk)
			{
				case 'b':
					$order_by = 'u.username_clean' . $sort_dir;
				break;

				case 'f':
					$order_by = 'uu.username_clean' . $sort_dir;
				break;

				case 'i':
					$order_by = 'p.author_ip' . $sort_dir. ', u.username_clean ASC';
				break;

				case 'p':
					$order_by = 't.folder_id' . $sort_dir. ', u.username_clean ASC';
				break;

				case 't':
					$order_by = 'u.username_clean' . $sort_dir;
				break;

				case 'd':
				default:
					$order_by = 'p.message_time' . $sort_dir;
				break;
			}

			// Get PM count for pagination
			$sql = 'SELECT COUNT(t.msg_id) AS total_pm FROM ' . PRIVMSGS_TO_TABLE. ' t
					JOIN ' . PRIVMSGS_TABLE . ' p ON p.msg_id = t.msg_id ' . $sql_keywords;
			$result = $this->db->sql_query($sql);
			$total_pm = (int) $this->db->sql_fetchfield('total_pm');
			$this->db->sql_freeresult($result);

			if ($total_pm == 0)
			{
				trigger_error($this->user->lang['NO_PM_DATA']);
			}

			$pm_box_ary = array(
				PRIVMSGS_HOLD_BOX	=> $this->user->lang['PM_HOLDBOX'],
				PRIVMSGS_NO_BOX		=> $this->user->lang['PM_NOBOX'],
				PRIVMSGS_OUTBOX		=> $this->user->lang['PM_OUTBOX'],
				PRIVMSGS_SENTBOX	=> $this->user->lang['PM_SENTBOX'],
				PRIVMSGS_INBOX		=> $this->user->lang['PM_INBOX'],
			);

			$flags = (($this->config['auth_bbcode_pm']) ? OPTION_FLAG_BBCODE : 0) +
					(($this->config['auth_smilies_pm']) ? OPTION_FLAG_SMILIES : 0) +
					(($this->config['allow_post_links']) ? OPTION_FLAG_LINKS : 0);

			$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $total_pm);

			$sql = 'SELECT p.msg_id, p.message_subject, p.message_text, p.bbcode_uid, p.bbcode_bitfield, p.message_time, p.bcc_address, p.to_address, p.author_ip, t.user_id,
					t.author_id, t.folder_id
					FROM ' . PRIVMSGS_TO_TABLE . ' t
					RIGHT  JOIN ' . PRIVMSGS_TABLE . ' p ON p.msg_id = t.msg_id
					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = t.user_id
					LEFT JOIN ' . USERS_TABLE . ' uu ON uu.user_id = t.author_id
					' . $sql_keywords . '
					ORDER BY ' . $order_by;
			$result = $this->db->sql_query_limit($sql, $this->config['topics_per_page'], $start);

			$rowset = array();
			$pm_user_ids = array();
			while ($row = $this->db->sql_fetchrow($result))
			{
				$rowset[] = $row;

				if ($row['author_id'])
				{
					$pm_user_ids[] = (int) $row['author_id'];
				}

				if ($row['user_id'])
				{
					$pm_user_ids[] = (int) $row['user_id'];
				}
			}
			$this->db->sql_freeresult($result);

			$pm_user_data = $this->get_pm_user_data(array_unique($pm_user_ids));

			foreach ($rowset as $row)
			{
				$this->template->assign_block_vars('pm_row', array(
					'AUTHOR_IP'		=> $row['author_ip'],
					'FROM'			=> ($row['author_id'] && isset($pm_user_data[$row['author_id']])) ? $pm_user_data[$row['author_id']] : '',
					'TO'			=> ($row['to_address'] && ($row['folder_id'] < PRIVMSGS_OUTBOX || !$row['folder_id']) && $row['user_id'] && isset($pm_user_data[$row['user_id']])) ? $pm_user_data[$row['user_id']] : '',
					'BCC'			=> ($row['bcc_address'] && ($row['folder_id'] < PRIVMSGS_OUTBOX || !$row['folder_id']) && $row['user_id'] && isset($pm_user_data[$row['user_id']])) ? $pm_user_data[$row['user_id']] : '',
					'DATE'			=> $this->user->format_date($row['message_time']),
					'FOLDER'		=> ($row['folder_id'] > PRIVMSGS_INBOX) ? $this->user->lang['PM_SAVED'] : $pm_box_ary[$row['folder_id']],
					'IS_GROUP'		=> (strstr($row['to_address'], 'g')) ? $this->get_pm_group($row['to_address']) : '',
					'PM_ID'			=> $row['msg_id'] . ':' . $row['user_id'] . ':' . $row['folder_id'],
					'PM_KEY'		=> $row['msg_id'] . $row['user_id'],
					'PM_SUBJECT'	=> $row['message_subject'],
					'PM_TEXT'		=> generate_text_for_display($row['message_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $flags),
				));
			}

			$base_url = $this->u_action . '&sk=' . $sk . '&sd=' . $sd . $keywords_param . (($userid) ? '&userid=' . $userid : '');
			$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $total_pm, $this->config['topics_per_page'], $start);

			$this->template->assign_vars(array(
				'MESSAGE_COUNT'		=> $total_pm,
				'U_NAME'			=> $sk,
				'U_SORT'			=> $sd,
				'S_KEYWORDS'		=> $keywords,
				'UNAME'				=> (($userid) ? $this->get_username($userid) : ''),
				'UID'				=> $userid,
				'U_ACTION'			=> $this->u_action,
			));
		}
	}

	private function get_pm_group($group)
	{
		$group = str_replace('g_', '', $group);
		$group = str_replace('u_', '', $group);
		$group = array_filter(array_map('intval', explode(':', $group)));

		if (!sizeof($group))
		{
			return '';
		}

		$sql = 'SELECT group_name FROM ' . GROUPS_TABLE . ' WHERE ' . $this->db->sql_in_set('group_id', $group);
		$result = $this->db->sql_query($sql);
		$groupname = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$groupname[] = (isset($this->user->lang['G_' . utf8_strtoupper($row['group_name'])])) ? $this->user->lang['G_' . utf8_strtoupper($row['group_name'])] : $row['group_name'];
		}
		$this->db->sql_freeresult($result);
		return implode(', ', $groupname);
	}

	private function get_username($userid)
	{
		$sql = 'SELECT username FROM ' . USERS_TABLE . ' WHERE user_id = ' . $userid;
		$result = $this->db->sql_query($sql);
		$username = $this->db->sql_fetchfield('username');
		$this->db->sql_freeresult($result);
		return $username;
	}

	/**
	* Batch-loads last-online info for a set of PM participants (avoids one query per row)
	*
	* @param	array	$pm_user_ids	Unique user ids to look up
	*
	* @return	array	Map of user_id => formatted user info string
	*/
	private function get_pm_user_data(array $pm_user_ids)
	{
		$pm_user_data = array();

		if (!sizeof($pm_user_ids))
		{
			return $pm_user_data;
		}

		$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_lastvisit, MAX(s.session_time) AS session_time
				FROM ' . USERS_TABLE . ' u
				LEFT JOIN ' . SESSIONS_TABLE . ' s ON s.session_user_id = u.user_id
				WHERE ' . $this->db->sql_in_set('u.user_id', $pm_user_ids) . '
				GROUP BY u.user_id, u.username, u.user_colour, u.user_lastvisit';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_info = get_username_string('full', (int) $row['user_id'], $row['username'], $row['user_colour']);
			$last_visit = $this->user->format_date(max($row['user_lastvisit'], $row['session_time']));
			$user_info = str_replace('<a href', '<a' . ((max($row['user_lastvisit'], $row['session_time'])) ? ' title="' . $this->user->lang['LAST_ONLINE'] . ' ' . $last_visit . '"' : '')  . ' href', $user_info);
			$pm_user_data[(int) $row['user_id']] = $user_info;
		}
		$this->db->sql_freeresult($result);

		return $pm_user_data;
	}

	/**
	* Generates a sql condition for the specified keywords
	*
	* @param	string	$keywords			The keywords the user specified to search for
	* @param	string	$table_alias		The alias of the logs' table ('l.' by default)
	* @param	string	$statement_operator	The operator used to prefix the statement ('AND' by default)
	*
	* @return	string		Returns the SQL condition searching for the keywords
	*/
	protected function generate_sql_keyword($keywords, $table_alias = 'p.', $statement_operator = 'WHERE')
	{
		// Use no preg_quote for $keywords because this would lead to sole
		// backslashes being added. We also use an OR connection here for
		// spaces and the | string. Currently, regex is not supported for
		// searching (but may come later).
		$keywords = preg_split('#[\s|]+#u', utf8_strtolower($keywords), 0, PREG_SPLIT_NO_EMPTY);
		$sql_keywords = '';

		if (!empty($keywords))
		{
			$keywords_pattern = array();

			// Build pattern and keywords...
			for ($i = 0, $num_keywords = count($keywords); $i < $num_keywords; $i++)
			{
				$keywords_pattern[] = preg_quote($keywords[$i], '#');
				$keywords[$i] = $this->db->sql_like_expression($this->db->get_any_char() . $keywords[$i] . $this->db->get_any_char());
			}

			$keywords_pattern = '#' . implode('|', $keywords_pattern) . '#ui';

			$operations = array();
			foreach ($this->user->lang as $key => $value)
			{
				if (substr($key, 0, 4) == 'LOG_')
				{
					if (is_array($value))
					{
						foreach ($value as $plural_value)
						{
							if (preg_match($keywords_pattern, $plural_value))
							{
								$operations[] = $key;
								break;
							}
						}
					}
					else if (preg_match($keywords_pattern, $value))
					{
						$operations[] = $key;
					}
				}
			}

			$sql_keywords = ' ' . $statement_operator . ' (';
			if (!empty($operations))
			{
				$sql_keywords .= $this->db->sql_in_set($table_alias . 'message_text', $operations) . ' OR ';
			}
			$sql_lower = $this->db->sql_lower_text($table_alias . 'message_text');
			$sql_keywords .= " $sql_lower " . implode(" OR $sql_lower ", $keywords) . ')';
		}

		return $sql_keywords;
	}
}
