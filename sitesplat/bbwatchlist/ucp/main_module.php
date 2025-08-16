<?php
/**
 *
 * BBwatchlist. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbwatchlist\ucp;

/**
 * BBwatchlist UCP module.
 */
class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;
	const FORM_KEY = 'sitesplat/bbwatchlist';

	protected $request;
	protected $db;
	protected $language;
	protected $user;
	protected $template;
	protected $watch_keywords_table;
	public function __construct()
	{
		global $phpbb_container;

		$this->request = $phpbb_container->get('request');
		$this->db = $phpbb_container->get('dbal.conn');
		$this->language = $phpbb_container->get('language');
		$this->user = $phpbb_container->get('user');
		$this->template = $phpbb_container->get('template');
		$this->watch_keywords_table = $phpbb_container->getParameter('tables.watch_keywords');

		$this->tpl_name = 'ucp_bbwatchlist';
		$this->page_title = $this->language->lang('UCP_SITESPLAT_BBWATCHLIST');
		add_form_key(self::FORM_KEY);
	}

	function main($id, $mode)
	{
		switch ($this->request->variable('action', ''))
		{
			case 'add':

				$keyword = $this->request->variable('keyword', '', true);
				$search_type = $this->request->variable('search_type', false);

				if (empty($keyword))
				{
					trigger_error('KEYWORD_EMPTY');
				}

				if (strlen($keyword) > 255)
				{
					trigger_error('KEYWORD_TOO_LONG');
				}

				$sql = 'SELECT keyword_id
						FROM ' . $this->watch_keywords_table . '
						WHERE user_id = ' .(int) $this->user->data['user_id'] . "
							AND LOWER(keyword) = '" . $this->db->sql_escape(strtolower($keyword)) . "'
							AND search_type = " . (int) $search_type;
				$this->db->sql_query($sql);
				if ($this->db->sql_affectedrows())
				{
					trigger_error('KEYWORD_EXISTS');
				}

				$sql_ary = [
					'user_id'		=> (int) $this->user->data['user_id'],
					'keyword'		=> $keyword,
					'search_type'	=> (int) $search_type,
				];
				$this->db->sql_query('INSERT INTO ' . $this->watch_keywords_table . $this->db->sql_build_array('INSERT', $sql_ary));

				if ($this->request->is_ajax())
				{
					$keyword_id = $this->db->sql_nextid();

					$json_response = new \phpbb\json_response();
					$json_response->send(array(
						'ID'		=> $keyword_id,
						'U_DELETE'	=> $this->u_action . '&amp;action=delete&amp;id=' . $keyword_id,
						'success'	=> true,
					));
				}
				trigger_error($this->language->lang('KEYWORD_ADDED') . '<br /><br />' . $this->language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>'));

			break;

			case 'delete':

				$sql = 'DELETE FROM ' . $this->watch_keywords_table . '
						WHERE keyword_id = ' . (int) $this->request->variable('id', 0) . '
							AND user_id = ' . (int) $this->user->data['user_id'];
				$this->db->sql_query($sql);

				$message = $this->language->lang('KEYWORD_DELETED');
				if (!$this->request->is_ajax())
				{
					$message .= '<br /><br />' . $this->language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>');
				}
				trigger_error($message);

			break;

			default:

				$sql = 'SELECT *
						FROM ' . $this->watch_keywords_table . '
						WHERE user_id = ' . $this->user->data['user_id'];
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$this->template->assign_block_vars('keywords', [
						'ID'		=> $row['keyword_id'],
						'KEYWORD'	=> $row['keyword'],
						'TYPE'		=> $row['search_type'],
						'U_DELETE'	=> $this->u_action . '&amp;action=delete&amp;id=' . $row['keyword_id'],
					]);
				}
				$this->db->sql_freeresult($result);

			break;
		}

		$this->template->assign_var('S_UCP_ACTION', $this->u_action);
	}
}
