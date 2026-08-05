<?php
/**
*
* @package Check mail
* @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\checkmail\acp;

use \forumhulp\checkmail\core\verifyEmail;

class checkmail_module
{
	protected $config;
	protected $db;
	protected $request;
	protected $template;
	protected $user;
	protected $pagination;
	protected $checkmail_table;

	/** @var string */
	public $u_action;
	public $tpl_name;
	public $page_title;

	public function main($id, $mode)
	{
		global $config, $db, $request, $template, $user, $phpbb_container;

		$this->config = $config;
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->pagination = $phpbb_container->get('pagination');
		$this->checkmail_table = $phpbb_container->getParameter('forumhulp.checkmail.tables.checkmail');

		// Load a template from adm/style for our ACP page
		$this->tpl_name = 'checkmail';

		$start = $this->request->variable('start', 0);
		$action = $this->request->variable('action', '');
		$sk = $this->request->variable('sk', 'username');
		$sd = $this->request->variable('sd', 'a');

		$view_table = $this->request->variable('table', false);

		switch ($action)
		{
			case 'details':
				$this->user->add_lang_ext('forumhulp/checkmail', 'info_acp_checkmail');
				$phpbb_container->get('forumhulp.helper')->detail('forumhulp/checkmail');
				$this->tpl_name = 'acp_ext_details';
			break;

			case 'email':
				if (!check_link_hash($this->request->variable('hash', ''), 'checkmail'))
				{
					trigger_error('FORM_INVALID');
				}

				$user_id = $this->request->variable('u', 0);
				$p = $this->request->variable('p', 0);

				$row = $this->check_address($user_id, $p);

				if ($this->request->variable('type', '') == 'cron')
				{
					header('Cache-Control: no-cache');
					header('Content-type: image/gif');
					header('Content-length: 43');

					echo base64_decode('R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');
					flush();

					garbage_collection();
					exit_handler();
				}

				$result = '<tr id="p'.$row['user_id'].'" class="'.(($row['status'] == 1) ? 'email_ok ' : '') . (($row['p'] % 2 == 0) ? 'cbEvenLine' : 'cbOddLine') . '">
					<td>'.$row['p'].'</td>
					<td><a href="' . $phpbb_container->getParameter('core.root_path') .  'adm/index.' . $phpbb_container->getParameter('core.php_ext') .
									'?i=users&action=edit&u=' . $row['user_id'] . '&sid=' . $this->user->session_id . '">'.$row['username'].'</a></td>
					<td class="show"><div class="msg" style="display:none;">'.$row['responce'].'</div>'.$this->format_check_result($row['email'], $row['status']).'</td>
					<td style="text-align: center;">
						<a class="check_mail" href="#" data-options="url=../../'.$this->u_action.'&amp;action=email&u='.$row['user_id'] . '&p=' . $row['p'] . '&hash=' . generate_link_hash('checkmail') .'" data-ajax="true" title="'.$this->user->lang['CHECK_MAIL_ADDRESS'].'"><i class="fa fa-envelope"></i></a>
					</td>
					</tr>';

				$json_response = new \phpbb\json_response();
				$json_response->send($result);
			break;

			default:
				$sql = 'SELECT group_id FROM ' . GROUPS_TABLE . ' WHERE ' . $this->db->sql_in_set('group_name', array('BOTS', 'GUESTS'));
				$result = $this->db->sql_query($sql);
				$ignore_group = array();
				while ($group_row = $this->db->sql_fetchrow($result))
				{
					$ignore_group[] = (int) $group_row['group_id'];
				}
				$this->db->sql_freeresult($result);

				$sql = 'SELECT COUNT(user_id) AS total_users FROM ' . $this->checkmail_table;
				$result = $this->db->sql_query($sql);
				$total_checked_users = (int) $this->db->sql_fetchfield('total_users');
				$this->db->sql_freeresult($result);

				$sql = 'SELECT COUNT(user_id) AS total_users FROM ' . USERS_TABLE . ' WHERE ' . $this->db->sql_in_set('group_id', $ignore_group, true);
				$result = $this->db->sql_query($sql);
				$total_users = (int) $this->db->sql_fetchfield('total_users');
				$this->db->sql_freeresult($result);

				$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $total_users);
				$base_url = $this->u_action . '&sk=' . $sk . '&sd=' . $sd;
				$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $total_users, $this->config['topics_per_page'], $start);

				$sort_key_map = array('username' => 'u.username_clean', 'status' => 'c.status');
				$order_by = isset($sort_key_map[$sk]) ? $sort_key_map[$sk] : $sort_key_map['username'];

				$sql = 'SELECT u.user_id, u.username, u.user_email, c.email, c.status, c.responce, c.timestamp FROM ' . USERS_TABLE . ' u
						LEFT JOIN ' . $this->checkmail_table . ' c ON c.user_id = u.user_id
						WHERE ' . $this->db->sql_in_set('u.group_id', $ignore_group, true) . '
						ORDER BY c.status ASC, ' . $order_by . (($sd == 'a') ? ' ASC' : ' DESC');
				$result = $this->db->sql_query_limit($sql, $this->config['topics_per_page'], $start);
				$i = $start;
				$not_checked = 0;
				$hash = generate_link_hash('checkmail');
				while ($row = $this->db->sql_fetchrow($result))
				{
					$this->template->assign_block_vars('memberrow', array(
						'NUM'		=> ++$i,
						'ID'		=> $row['user_id'],
						'USERNAME'	=> $row['username'],
						'U_EDIT'	=> $phpbb_container->getParameter('core.root_path') .  'adm/index.' . $phpbb_container->getParameter('core.php_ext') .
										'?i=users&action=edit&u=' . $row['user_id'] . '&sid=' . $this->user->session_id,
						'EMAIL'		=> ($row['email'] !== null) ? $this->format_check_result($row['email'], $row['status']) : '',
						'STATUS'	=> ($row['status'] == 1),
						'RESPONCE'	=> $row['responce'],
						'U_CHECK'	=> '../../' . $this->u_action . '&amp;action=email&sk=' . $sk . '&sd=' . $sd . '&u=' . $row['user_id'] . '&p=' . $i . '&hash=' . $hash
					));
					$not_checked = (!$not_checked && ($row['timestamp'] + 86400 < time()) && $row['status'] != 1) ? '&u=' . $row['user_id'] . '&p=' . $i . '&hash=' . $hash : $not_checked;
				}
				$this->db->sql_freeresult($result);

				$this->template->assign_vars(array(
					'VIEW_TABLE'			=> $view_table,
					'U_ACTION'				=> $this->u_action,
					'U_NAME'				=> $sk,
					'U_SORT' 				=> $sd,
					'CRON'					=> ($not_checked) ? $this->u_action . '&amp;action=email&type=cron' . $not_checked : 0,
					'TOTAL_USERS'			=> $total_users ? 100 - round(($total_checked_users / $total_users) * 100, 1) : 0,
					'TOTAL_CHECKED_USERS'	=> $total_users ? round(($total_checked_users / $total_users) * 100, 1) : 0
				));

			break;
		}

		// Set the page title for our ACP page
		$this->page_title = 'ACP_CHECKMAIL';
	}

	protected function check_address($user_id, $p)
	{
		$vmail = new verifyEmail();
		$vmail->setStreamTimeoutWait(5);
		$vmail->setPort(($this->config['smtp_delivery']) ? $this->config['smtp_port'] : 25);

		$vmail->setEmailFrom(($this->config['smtp_delivery']) ? $this->config['smtp_username'] : $this->config['board_email']);
		$sql = 'SELECT user_id, username, user_email FROM ' . USERS_TABLE . ' WHERE user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$row)
		{
			trigger_error('No such user', E_USER_WARNING);
		}

		$row['p'] = $p;

		if ($vmail->check($row['user_email']))
		{
			$status = 1;
		}
		else if (verifyEmail::validate($row['user_email']))
		{
			$status = 2;
		}
		else
		{
			$status = 0;
		}

		$sql_ary = array(
			'user_id'	=> (int) $user_id,
			'email'		=> $row['user_email'],
			'status'	=> $status,
			'responce'	=> $vmail->getStreamResponce(),
			'timestamp'	=> time(),
		);

		$this->db->sql_query('DELETE FROM ' . $this->checkmail_table . ' WHERE user_id = ' . (int) $user_id);
		$this->db->sql_query('INSERT INTO ' . $this->checkmail_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary));

		return array_merge($row, $sql_ary);
	}

	/**
	* Composes the check-result sentence for an email address in the active language
	*
	* @param	string	$email	The raw email address that was checked
	* @param	int		$status	0 = not valid, 1 = exists, 2 = valid but doesn't exist
	*
	* @return	string
	*/
	protected function format_check_result($email, $status)
	{
		switch ($status)
		{
			case 1:
				return $this->user->lang['EMAIL'] . $email . $this->user->lang['EXIST'];

			case 2:
				return $this->user->lang['EMAIL'] . $email . $this->user->lang['VALID'];

			default:
				return $this->user->lang['EMAIL'] . $email . $this->user->lang['NOT_VALID'];
		}
	}
}
