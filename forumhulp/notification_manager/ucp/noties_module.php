<?php
/**
*
* Notification_manager for the phpBB Forum Software package.
*
* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\notification_manager\ucp;

use phpbb\config\config;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use phpbb\db\driver\driver_interface;
use phpbb\notification\manager;
use phpbb\pagination;

class noties_module
{
	public $u_action;
	public $page_title;
	public $tpl_name;
	private $config;
	private $user;
	private $db;
	private $template;
	private $request;
	private $manager;
	private $pagination;
	private $user_notifications_table;

	/**
	 * {@inheritdoc}
	 */
	private function setup(config $config, user $user, driver_interface $db, template $template, request_interface $request, manager $manager, pagination $pagination, $user_notifications_table, $phpbb_root_path, $phpEx)
	{
		$this->config = $config;
		$this->user = $user;
		$this->db = $db;
		$this->template = $template;
		$this->request = $request;
		$this->manager = $manager;
		$this->pagination = $pagination;
		$this->user_notifications_table = $user_notifications_table;
		$this->root = $phpbb_root_path;
		$this->phpex = $phpEx;
	}

	/**
	 * {@inheritdoc}
	 */
	public function main($id, $mode)
	{
		global $config, $user, $db, $template;
		global $request, $phpbb_container, $phpbb_root_path, $phpEx;

		$this->setup($config, $user, $db, $template, $request, $phpbb_container->get('notification_manager'), $phpbb_container->get('pagination'), $phpbb_container->getParameter('tables.notifications'), $phpbb_root_path, $phpEx);

		$this->createPage();
	}

	/**
	 * {@inheritdoc}
	 */
	private function createPage()
	{
		$error = array();
		$s_hidden_fields = '';

		add_form_key('ucp_tfa_keys');

		$module_row = $this->request->variable('md', 'tfa', true, \phpbb\request\request_interface::POST);

		$mark = $this->request->variable('mark', array(0));
		$delete = $this->request->variable('delete', array(0));
		$unmark = $this->request->variable('unmark', array(0));

		// Set desired template
		$this->tpl_name = 'ucp_noties';
		$this->page_title = 'UCP_NOTIES';

		if ($this->request->variable('mark', '') == 'all' && check_link_hash($this->request->variable('token', ''), 'mark_all_notifications_read'))
		{
			$this->manager->mark_notifications(false, false, $this->user->data['user_id'], time());

			meta_refresh(3, $this->u_action);
			$message = $this->user->lang['NOTIFICATIONS_MARK_ALL_READ_SUCCESS'];

			if ($this->request->is_ajax())
			{
				$json_response = new \phpbb\json_response();
				$json_response->send(array(
					'MESSAGE_TITLE'	=> $this->user->lang['INFORMATION'],
					'MESSAGE_TEXT'	=> $message,
					'success'		=> true,
				));
			}
			$message .= '<br /><br />' . $this->user->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>');

			trigger_error($message);
		}
		
		if (!empty($module_row))
		{
			if (!empty($mark))
			{
				$this->manager->mark_notifications_by_id('notification.method.board', $mark, time());
			}

			if (!empty($delete))
			{
				foreach($delete as $del_id)
				{
					$sql = 'DELETE FROM ' . $this->user_notifications_table . ' WHERE notification_id = ' . $del_id;
					$this->db->sql_query($sql);
				}
			}
			
			if (!empty($unmark))
			{
				$this->manager->mark_notifications_by_id('notification.method.board', $unmark, time(), false);
			}
		}

		// Replace "error" strings with their real, localised form
		$error = array_map(array(
			$this->user,
			'lang',
		), $error);



		$start = $this->request->variable('start', 0);
		$notifications = $this->manager->load_notifications('notification.method.board', array(
			'start'			=> $start,
			'limit'			=> $this->config['topics_per_page'],
			'count_total'	=> true,
		));
		
		foreach ($notifications['notifications'] as $notification)
		{
			$this->template->assign_block_vars('notification_list', $notification->prepare_for_display());
		}
		
		$base_url = append_sid("{$this->root}ucp.$this->phpex", "i=-forumhulp-notification_manager-ucp-noties_module&amp;mode=noties");
		$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $notifications['total_count']);
		$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $notifications['total_count'], $this->config['topics_per_page'], $start);
		
		$this->template->assign_vars(array(
			'TOTAL_COUNT'	=> $notifications['total_count'],
			'U_MARK_ALL'	=> $base_url . '&amp;mark=all&amp;token=' . generate_link_hash('mark_all_notifications_read'),
		));
	}
	
	
	
		/**
	* Output all the notification methods to the template
	*
	* @param \phpbb\notification\manager $phpbb_notifications
	* @param \phpbb\template\template $template
	* @param \phpbb\user $user
	* @param string $block
	*/
	public function output_notification_methods(\phpbb\notification\manager $phpbb_notifications, \phpbb\template\template $template, \phpbb\user $user, $block = 'notification_methods')
	{
		$notification_methods = $phpbb_notifications->get_subscription_methods();

		foreach ($notification_methods as $method => $method_data)
		{
			$this->template->assign_block_vars($block, array(
				'METHOD'	=> $method_data['id'],
				'NAME'		=> $this->user->lang($method_data['lang']),
			));
		}
	}

}
