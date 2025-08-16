<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2021, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation\controller;

use leinad4mind\invitation\includes\config as ext_config;
use leinad4mind\invitation\includes\functions_admin;
use phpbb\language\language;
use phpbb\pagination;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class mcp extends controller_base
{
	/** @var user */
	protected $user;

	/** @var language */
	protected $language;

	/** @var request_interface */
	protected $request;

	/** @var template */
	protected $template;

	/** @var pagination */
	protected $pagination;

	/** @var ext_config */
	protected $ext_config;

	/** @var functions_admin */
	protected $functions_admin;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/**
	 * mcp constructor.
	 *
	 * @param \phpbb\user                                       $user
	 * @param \phpbb\language\language                          $language
	 * @param \phpbb\request\request_interface                  $request
	 * @param \phpbb\template\template                          $template
	 * @param \phpbb\pagination                                 $pagination
	 * @param \leinad4mind\invitation\includes\config           $ext_config
	 * @param \leinad4mind\invitation\includes\functions_admin  $functions_admin
	 * @param string                                            $root_path
	 * @param string                                            $php_ext
	 */
	public function __construct(user $user, language $language, request_interface $request, template $template, pagination $pagination, ext_config $ext_config, functions_admin $functions_admin, $root_path, $php_ext)
	{
		$this->user = $user;
		$this->language = $language;
		$this->request = $request;
		$this->pagination = $pagination;
		$this->ext_config = $ext_config;
		$this->functions_admin = $functions_admin;
		$this->template = $template;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * @param string $id
	 * @param string $mode
	 * @param string $u_action
	 */
	public function main($id, $mode, $u_action)
	{
		$this->language->add_lang('info_acp_invite', 'leinad4mind/invitation');
		$this->tpl_name = 'mcp_invite';
		$this->page_title = 'ACP_INVITE_CLAIMING';

		if (!$this->ext_config['invite_enable'])
		{
			meta_refresh(3, append_sid("{$this->root_path}mcp.$this->php_ext"));
			trigger_error($this->language->lang('MCP_INVITE_DISABLED', '<a href="' . append_sid("{$this->root_path}mcp.$this->php_ext") . '">', '</a>'));
		}

		$action		= $this->request->is_set_post('allocate') ? 'allocate' : $this->request->is_set_post('deny') ? 'deny' : $this->request->variable('action', '');
		$marked		= $this->request->variable('mark'	, array(0));
		$start		= $this->request->variable('start'	, 0);
		$sort_days	= $this->request->variable('st'	, 0);
		$sort_key	= $this->request->variable('sk'	,'date');
		$sort_dir	= $this->request->variable('sd'	,'d');

		$list_invite = $this->ext_config['invite_page_list'];

		if ($action == 'allocate' || $action == 'deny')
		{
			$back = $this->language->lang('MCP_INVITE_BACK', '<a href="' . $u_action . '">', '</a>');

			if (confirm_box(true))
			{
				$this->functions_admin->handling($action, $marked, false);
				meta_refresh(5, $u_action);
				trigger_error($this->language->lang('ACP_INVITE_PETITION_' . ($action == 'allocate' ? 'Y' : 'N') . 'SUCCESS' . (sizeof($marked) == 1 ? '' : 'S')) . $back);
			}
			else
			{
				if (!sizeof($marked))
				{
					meta_refresh(5, $u_action);
					trigger_error($this->language->lang('ACP_INVITE_NO_MARKED') . $back);
				}

				confirm_box(false, $this->language->lang('CONFIRM_OPERATION'), build_hidden_fields(array(
					'i'			=> $id,
					'mode'		=> $mode,
					'mark'		=> $marked,
					'action'	=> $action,
				)));
			}
		}

		$limit_days = array(
			0	=> $this->language->lang('ALL_ENTRIES'),
			1	=> $this->language->lang('1_DAY'),
			7	=> $this->language->lang('7_DAYS'),
			14	=> $this->language->lang('2_WEEKS'),
			30	=> $this->language->lang('1_MONTH'),
			90	=> $this->language->lang('3_MONTHS'),
			180	=> $this->language->lang('6_MONTHS'),
			365	=> $this->language->lang('1_YEAR'),
		);

		$sort_by_text = array(
			'name'	=> $this->language->lang('SORT_USERNAME'),
			'db'	=> $this->language->lang('ACP_INVITE_SEND_DB_NUM'),
			'date'	=> $this->language->lang('SORT_DATE'),
		);

		$sort_by_sql = array(
			'name'	=> 'u.username_clean',
			'db'	=> 'i.db',
			'date'	=> 'i.message_time',
		);

		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

		$sql_where = ($sort_days) ? (time() - ($sort_days * 86400)) : 0;
		$sql_sort  = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');

		$petition = array();
		$petition_count = 0;

		$this->functions_admin->requesting($petition, $petition_count, $list_invite, $start, $sql_where, $sql_sort);

		$this->pagination->generate_template_pagination($u_action . '&amp;' . $u_sort_param, 'pagination', 'start', $petition_count, $list_invite, $start, true);

		$this->template->assign_vars(array(
			'S_INVITE_PETITION'	=> true,
			'U_ACTION'			=> $u_action,
			'S_ON_PAGE'			=> $this->pagination->on_page($petition_count, $list_invite, $start),
			'S_LIMIT_DAYS'		=> str_replace('<select', '<select onchange="this.form.submit();"', $s_limit_days),
			'S_SORT_KEY'		=> str_replace('<select', '<select onchange="this.form.submit();"', $s_sort_key),
			'S_SORT_DIR'		=> str_replace('<select', '<select onchange="this.form.submit();"', $s_sort_dir),
			'TOTAL_COUNT'		=> $this->language->lang('ACP_INVITE_USERS_COUNT', $petition_count),
		));

		foreach ($petition as $row)
		{
			$this->template->assign_block_vars('petition', array(
				'P_USER_ID'			=> $row['user_id'],
				'P_USERNAME'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'P_DB'				=> $row['db'],
				'P_MESSAGE'			=> $row['message'],
				'P_MESSAGE_TIME'	=> $this->user->format_date($row['message_time']),
			));
		}
	}
}
