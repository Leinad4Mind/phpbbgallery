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
	protected $phpbb_container;

	/** @var string */
	public $u_action;

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
				} else
				{
					$result = '<tr id="p'.$row['user_id'].'" class="'.(($row['status']) ? 'email_ok ' : '') . (($row['p'] % 2 == 0) ? 'cbEvenLine' : 'cbOddLine') . '">
						<td>'.$row['p'].'</td>
						<td><a href="' . $phpbb_container->getParameter('core.root_path') .  'adm/index.' . $phpbb_container->getParameter('core.php_ext') . 
										'?i=users&action=edit&u=' . $row['user_id'] . '&sid=' . $this->user->session_id . '">'.$row['username'].'</a></td>
						<td class="show"><div class="msg" style="display:none;">'.$row['responce'].'</div>'.$row['email'].'</td>
						<td style="text-align: center;">
							<a class="check_mail" href="#" data-options="url=../../'.$this->u_action.'&amp;action=email&u='.$row['user_id'] . '&p=' . $row['p'] .'" data-ajax="true" title="'.$this->user->lang['CHECK_MAIL_ADDRESS'].'"><i class="fa fa-envelope"></i></a>
						</td>
						</tr>';
					echo json_encode($result);
				}
				exit();
			break;
			
			default:
				$sql = 'SELECT GROUP_CONCAT(group_id SEPARATOR ",") AS ignore_group FROM ' . GROUPS_TABLE . " WHERE group_name = 'BOTS' OR group_name = 'GUESTS'";
				$result = $this->db->sql_query($sql);
				$ignore_group = $this->db->sql_fetchfield('ignore_group');

				$sql = 'SELECT COUNT(user_id) AS total_users FROM ' . $this->checkmail_table;
				$result = $this->db->sql_query($sql);
				$total_checked_users = (int) $this->db->sql_fetchfield('total_users');

				$sql = 'SELECT COUNT(user_id) AS total_users FROM ' . USERS_TABLE . ' WHERE group_id NOT IN (' . $ignore_group . ')';
				$result = $this->db->sql_query($sql);
				$total_users = (int) $this->db->sql_fetchfield('total_users');
	
				$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $total_users);
				$base_url = $this->u_action . '&sk=' . $sk . '&sd=' . $sd;
				$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $total_users, $this->config['topics_per_page'], $start);

				$sql = 'SELECT u.user_id, u.username, u.user_email, c.email, c.status, c.responce, c.timestamp FROM ' . USERS_TABLE . ' u 
						LEFT JOIN ' . $this->checkmail_table . ' c ON c.user_id = u.user_id
						WHERE u.group_id NOT IN (' . $ignore_group . ')
						ORDER BY c.status ASC, ' . $sk . (($sd == 'a') ? ' ASC' : ' DESC');
				$result = $this->db->sql_query_limit($sql, $this->config['topics_per_page'], $start);
				$i = $start;
				$not_checked = 0;
				while ($row = $this->db->sql_fetchrow($result))
				{
					$this->template->assign_block_vars('memberrow', array(
						'NUM'		=> ++$i,
						'ID'		=> $row['user_id'],
						'USERNAME'	=> $row['username'],
						'U_EDIT'	=> $phpbb_container->getParameter('core.root_path') .  'adm/index.' . $phpbb_container->getParameter('core.php_ext') . 
										'?i=users&action=edit&u=' . $row['user_id'] . '&sid=' . $this->user->session_id,
						'EMAIL'		=> $row['email'],
						'STATUS'	=> $row['status'],
						'RESPONCE'	=> $row['responce'],
						'U_CHECK'	=> '../../' . $this->u_action . '&amp;action=email&sk=' . $sk . '&sd=' . $sd . '&u=' . $row['user_id'] . '&p=' . $i
					));
					$not_checked = (!$not_checked && ($row['timestamp'] + 86400 < time()) && !$row['status']) ? '&u=' . $row['user_id'] . '&p=' . $i : $not_checked;
				}
				
				$template->assign_vars(array(
					'VIEW_TABLE'			=> $view_table,
					'U_ACTION'				=> $this->u_action,
					'U_NAME'				=> $sk, 
					'U_SORT' 				=> $sd,
					'CRON'					=> ($not_checked) ? $this->u_action . '&amp;action=email&type=cron' . $not_checked : 0,
					'TOTAL_USERS'			=> 100 - round(($total_checked_users / $total_users) * 100, 1),
					'TOTAL_CHECKED_USERS'	=> round(($total_checked_users / $total_users) * 100, 1)
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
		$sql = 'SELECT user_id, username, user_email FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$row['p'] = $p;

		$status = 0;
		if ($vmail->check($row['user_email'])) {
			$msg = $this->user->lang['EMAIL'] . $row['user_email'] . $this->user->lang['EXIST'];
			$status = 1;
		} elseif (verifyEmail::validate($row['user_email'])) {
			$msg = $this->user->lang['EMAIL'] . $row['user_email'] . $this->user->lang['VALID'];
		} else {
			$msg = $this->user->lang['EMAIL'] . $row['user_email'] . $this->user->lang['NOT_VALID'];
		}
		$sql_ary = array(
			'username'	=> $row['username'],
			'email'		=> $msg,
			'status'	=> $status,
			'responce'	=> $vmail->getStreamResponce()
		);
		$sql = 'REPLACE INTO ' . $this->checkmail_table . ' 
				VALUES (' . $user_id . ', "' . $sql_ary['email'] . '", ' . $sql_ary['status'] . ', "' . $this->db->sql_escape($sql_ary['responce']) . '", ' . time() . ')';
		$this->db->sql_query($sql);
		
		return array_merge($row, $sql_ary);
	}
}

