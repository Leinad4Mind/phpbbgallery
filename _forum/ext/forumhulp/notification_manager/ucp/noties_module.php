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
use phpbb\db\driver\driver_interface;
use phpbb\notification\manager;
use phpbb\pagination;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class noties_module
{
	private const FORM_KEY = 'ucp_notification_manager';

	public string $u_action = '';
	public string $page_title = '';
	public string $tpl_name = '';
	private config $config;
	private user $user;
	private driver_interface $db;
	private template $template;
	private request_interface $request;
	private manager $manager;
	private pagination $pagination;
	private string $user_notifications_table;
	private string $root;
	private string $phpex;

	private function setup(
		config $config,
		user $user,
		driver_interface $db,
		template $template,
		request_interface $request,
		manager $manager,
		pagination $pagination,
		string $user_notifications_table,
		string $phpbb_root_path,
		string $php_ex
	): void
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
		$this->phpex = $php_ex;
	}

	public function main(string $id, string $mode): void
	{
		global $config, $user, $db, $template;
		global $request, $phpbb_container;

		$this->setup(
			$config,
			$user,
			$db,
			$template,
			$request,
			$phpbb_container->get('notification_manager'),
			$phpbb_container->get('pagination'),
			$phpbb_container->getParameter('tables.notifications'),
			$phpbb_container->getParameter('core.root_path'),
			$phpbb_container->getParameter('core.php_ext')
		);

		$this->create_page();
	}

	private function create_page(): void
	{
		add_form_key(self::FORM_KEY);

		$this->tpl_name = 'ucp_noties';
		$this->page_title = 'UCP_NOTIES';

		if ($this->request->variable('mark', '') === 'all'
			&& check_link_hash($this->request->variable('token', ''), 'mark_all_notifications_read'))
		{
			$this->manager->mark_notifications(false, false, $this->user->data['user_id'], time());

			meta_refresh(3, $this->u_action);
			$message = $this->user->lang['NOTIFICATIONS_MARK_ALL_READ_SUCCESS'];

			if ($this->request->is_ajax())
			{
				$json_response = new \phpbb\json_response();
				$json_response->send([
					'MESSAGE_TITLE' => $this->user->lang['INFORMATION'],
					'MESSAGE_TEXT' => $message,
					'success' => true,
				]);
			}

			$message .= '<br /><br />' . $this->user->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>');
			trigger_error($message);
		}

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key(self::FORM_KEY))
			{
				trigger_error('FORM_INVALID');
			}

			$form_time = $this->request->variable('form_time', 0, false, request_interface::POST);
			$form_time = ($form_time <= 0 || $form_time > time()) ? time() : $form_time;
			$mark_ids = $this->normalise_notification_ids(
				$this->request->variable('mark', [0], false, request_interface::POST)
			);
			$unmark_ids = $this->normalise_notification_ids(
				$this->request->variable('unmark', [0], false, request_interface::POST)
			);
			$delete_ids = $this->normalise_notification_ids(
				$this->request->variable('delete', [0], false, request_interface::POST)
			);

			$this->set_notification_read_status($mark_ids, true, $form_time);
			$this->set_notification_read_status($unmark_ids, false, $form_time);
			$this->delete_notifications($delete_ids);

			redirect($this->u_action);
		}

		$start = $this->request->variable('start', 0);
		$notifications = $this->manager->load_notifications('notification.method.board', [
			'start' => $start,
			'limit' => $this->config['topics_per_page'],
			'count_total' => true,
		]);

		foreach ($notifications['notifications'] as $notification)
		{
			$this->template->assign_block_vars('notification_list', $notification->prepare_for_display());
		}

		$base_url = append_sid(
			"{$this->root}ucp.{$this->phpex}",
			'i=-forumhulp-notification_manager-ucp-noties_module&amp;mode=noties'
		);
		$start = $this->pagination->validate_start(
			$start,
			$this->config['topics_per_page'],
			$notifications['total_count']
		);
		$this->pagination->generate_template_pagination(
			$base_url,
			'pagination',
			'start',
			$notifications['total_count'],
			$this->config['topics_per_page'],
			$start
		);

		$this->template->assign_vars([
			'FORM_TIME' => time(),
			'TOTAL_COUNT' => $notifications['total_count'],
			'U_MARK_ALL' => $base_url . '&amp;mark=all&amp;token=' . generate_link_hash('mark_all_notifications_read'),
		]);
	}

	private function normalise_notification_ids(array $notification_ids): array
	{
		$normalised_ids = [];
		foreach ($notification_ids as $notification_id)
		{
			$notification_id = (int) $notification_id;
			if ($notification_id > 0)
			{
				$normalised_ids[$notification_id] = $notification_id;
			}
		}

		return array_values($normalised_ids);
	}

	private function set_notification_read_status(array $notification_ids, bool $mark_read, int $form_time): void
	{
		if (empty($notification_ids))
		{
			return;
		}

		$sql = 'UPDATE ' . $this->user_notifications_table . '
			SET ' . $this->db->sql_build_array('UPDATE', [
				'notification_read' => $mark_read ? 1 : 0,
			]) . '
			WHERE user_id = ' . (int) $this->user->data['user_id'] . '
				AND notification_time <= ' . $form_time . '
				AND ' . $this->db->sql_in_set('notification_id', $notification_ids);
		$this->db->sql_query($sql);
	}

	private function delete_notifications(array $notification_ids): void
	{
		if (empty($notification_ids))
		{
			return;
		}

		$sql = 'DELETE FROM ' . $this->user_notifications_table . '
			WHERE user_id = ' . (int) $this->user->data['user_id'] . '
				AND ' . $this->db->sql_in_set('notification_id', $notification_ids);
		$this->db->sql_query($sql);
	}
}
