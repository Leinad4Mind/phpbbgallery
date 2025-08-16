<?php

/**
 *
 * @package phpBB Extension - Group Rules
 * @copyright (c) 2017-2018 Leinad4Mind - https://leinad4mind.top/forum
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\grouprules\controller;

use phpbb\config\db_text as config_text;
use phpbb\json_response;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class acp extends base
{
	/** @var user */
	protected $user;

	/** @var language */
	protected $lang;

	/** @var request_interface */
	protected $request;

	/** @var config_text */
	protected $config_text;

	/** @var template */
	protected $template;

	/** @var log_interface */
	protected $log;

	/**
	 * @param user				$user
	 * @param language			$lang
	 * @param request_interface	$request
	 * @param config_text		$config_text
	 * @param template			$template
	 * @param log_interface		$log
	 */
	public function __construct(
		user $user,
		language $lang,
		request_interface $request,
		config_text $config_text,
		template $template,
		log_interface $log
	)
	{
		$this->user			= $user;
		$this->lang			= $lang;
		$this->request		= $request;
		$this->config_text	= $config_text;
		$this->template		= $template;
		$this->log			= $log;
	}

	/**
	 * @param string $id
	 * @param string $mode
	 * @param string $u_action
	 */
	public function main($id, $mode, $u_action)
	{
		$ext_name = 'leinad4mind/grouprules';

		$this->tpl_name = 'acp_grouprules_body';
		$this->page_title = 'ACP_GROUPRULES_TITLE';

		$this->lang->add_lang('acp', 'leinad4mind/grouprules');

		add_form_key($ext_name);

		$group_actions = json_decode($this->config_text->get('grouprules_group_actions'), true);

		$id = $this->request->variable('id', -1);

		if ($this->request->variable('action', '') == 'delete' && isset($group_actions[$id]))
		{
			if (confirm_box(true))
			{
				unset($group_actions[$id]);
				$this->config_text->set('grouprules_group_actions', json_encode($group_actions));

				if ($this->request->is_ajax())
				{
					(new json_response())->send([
						'MESSAGE_TITLE'	=> $this->lang->lang('INFORMATION'),
						'MESSAGE_TEXT'	=> $this->lang->lang('ACP_GROUPRULES_RULE_REMOVED'),
						'REFRESH_DATA'	=> [
							'time'	=> 3,
						]
					]);
				}
			}
			else
			{
				confirm_box(false, $this->lang->lang('CONFIRM_OPERATION'), build_hidden_fields([
					'id'		=> $id,
					'action'	=> 'delete',
				]));
			}
		}

		if ($this->request->is_set_post('add') || $this->request->is_set_post('submit'))
		{
			if (!check_form_key($ext_name))
			{
				trigger_error($this->lang->lang('FORM_INVALID') . adm_back_link($u_action), E_USER_WARNING);
			}

			$group_actions = [];

			$when_action	= $this->request->variable('when-action', ['' => '']);
			$when_group		= $this->request->variable('when-group', ['' => 0]);
			$then_action	= $this->request->variable('then-action', ['' => '']);
			$then_group		= $this->request->variable('then-group', ['' => 0]);

			for ($i = 0; $i < count($when_action); $i++)
			{
				if (in_array($when_action[$i], ['add', 'del']) && $when_group[$i] && in_array($then_action[$i], ['add', 'del']) && $then_group[$i])
				{
					$group_actions[] = [
						'when'	=> [
							'action'	=> $when_action[$i],
							'group'		=> $when_group[$i],
						],
						'then'	=> [
							'action'	=> $then_action[$i],
							'group'		=> $then_group[$i],
							'default'	=> $this->request->variable('then-default-' . $i, 0),
						],
					];
				}
			}

			$this->config_text->set('grouprules_group_actions', json_encode($group_actions));
		}

		if ($this->request->is_set_post('add'))
		{
			$group_actions[] = [];
		}

		if ($this->request->is_set_post('submit'))
		{
			trigger_error($this->lang->lang('ACP_GROUPRULES_SETTINGS_SAVED') . adm_back_link($u_action));
		}

		foreach ($group_actions as $i => $group_action)
		{
			if (empty($group_action))
			{
				$group_action = [
					'when'	=> [
						'action'	=> '',
						'group'		=> 0,
					],
					'then'	=> [
						'action'	=> '',
						'group'		=> 0,
						'default'	=> false,
					],
				];
			}

			$block_vars = [
				'WHEN_ACTION_OPTIONS'	=> $this->build_option('', '', !$group_action['when']['action']) . $this->build_option($this->lang->lang('ACP_GROUPRULES_WHEN_ADD'), 'add', $group_action['when']['action'] == 'add') . $this->build_option($this->lang->lang('ACP_GROUPRULES_WHEN_DEL'), 'del', $group_action['when']['action'] == 'del'),
				'WHEN_GROUP_OPTIONS'	=> $this->build_option('', 0, !$group_action['when']['group']) . group_select_options($group_action['when']['group']),
				'THEN_ACTION_OPTIONS'	=> $this->build_option('', '', !$group_action['then']['action']) . $this->build_option($this->lang->lang('ACP_GROUPRULES_THEN_ADD'), 'add', $group_action['then']['action'] == 'add') . $this->build_option($this->lang->lang('ACP_GROUPRULES_THEN_DEL'), 'del', $group_action['then']['action'] == 'del'),
				'THEN_GROUP_OPTIONS'	=> $this->build_option('', 0, !$group_action['then']['group']) . group_select_options($group_action['then']['group']),
				'THEN_DEFAULT'			=> $group_action['then']['default'],
				'U_DELETE'				=> $u_action . '&amp;action=delete&amp;id=' . $i,
			];

			$this->template->assign_block_vars('grouprules', $block_vars);
		}

		$this->template->assign_vars([
			'U_ACTION'	=> $u_action,
		]);
	}

	/**
	 * @param string $text
	 * @param string $value
	 * @param bool $selected
	 * @return string
	 */
	protected function build_option($text, $value, $selected)
	{
		return '<option class="sep" value="' . $value . '" ' . ($selected ? 'selected' : '') . '>' . $text . '</option>';
	}
}
