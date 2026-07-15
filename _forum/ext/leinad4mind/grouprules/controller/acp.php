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

		$action = $this->request->variable('action', '');
		$rule_id = $this->request->variable('rule_id', -1);

		if ($action == 'rule_delete' && isset($group_actions[$rule_id]))
		{
			if (confirm_box(true))
			{
				unset($group_actions[$rule_id]);
				$this->config_text->set('grouprules_group_actions', json_encode($group_actions));

				if ($this->request->is_ajax())
				{
					(new json_response())->send([
						'MESSAGE_TITLE'	=> $this->lang->lang('INFORMATION'),
						'MESSAGE_TEXT'	=> $this->lang->lang('ACP_GROUPRULES_RULE_REMOVED'),
						'REFRESH_DATA'	=> ['time' => 3],
					]);
				}
			}
			else
			{
				confirm_box(false, $this->lang->lang('CONFIRM_OPERATION'), build_hidden_fields([
					'rule_id'	=> $rule_id,
					'action'	=> 'rule_delete',
				]));
			}
		}

		if ($this->request->is_set_post('rule_add') || $this->request->is_set_post('submit'))
		{
			if (!check_form_key($ext_name))
			{
				trigger_error($this->lang->lang('FORM_INVALID') . adm_back_link($u_action), E_USER_WARNING);
			}

			$group_actions = [];

			$when_action	= $this->request->variable('when-action', ['' => '']);
			$when_group		= $this->request->variable('when-group', ['' => 0]);

			for ($i = 0; $i < count($when_action); $i++)
			{
				$group_action = [
					'when'	=> [
						'action'	=> $when_action[$i],
						'group'		=> $when_group[$i],
					],
					'then'	=> [],
				];

				$then_action	= $this->request->variable('then-action-' . $i, ['' => '']);
				$then_group		= $this->request->variable('then-group-' . $i, ['' => 0]);
				$then_stop		= $this->request->variable('then-stop-' . $i, [0]);

				for ($j = 0; $j < count($then_action); $j++)
				{
					if ($then_action[$j] && $then_group[$j])
					{
						$group_action['then'][] = [
							'action'	=> $then_action[$j],
							'group'		=> $then_group[$j],
							'stop'		=> in_array($j, $then_stop),
						];
					}
				}

				if ($group_action['when']['action'] && $group_action['when']['group'] && $group_action['then'])
				{
					$group_actions[] = $group_action;
				}
			}

			$this->config_text->set('grouprules_group_actions', json_encode($group_actions));
		}

		if ($this->request->is_set_post('rule_add'))
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
						[
							'action'	=> '',
							'group'		=> 0,
							'stop'		=> 0,
						],
					],
				];
			}

			$this->template->assign_block_vars('grouprules', [
				'WHEN_ACTION_OPTIONS'	=> $this->build_option('', '', !$group_action['when']['action']) . $this->action_select_options('ACP_GROUPRULES_WHEN_', $group_action['when']['action'], ['add', 'del', 'default', 'promote', 'demote']),
				'WHEN_GROUP_OPTIONS'	=> $this->build_option('', 0, !$group_action['when']['group']) . group_select_options($group_action['when']['group']),
				'U_RULE_DELETE'			=> $u_action . '&amp;action=rule_delete&amp;rule_id=' . $i,
			]);

			foreach ($group_action['then'] as $then_action)
			{
				$this->template->assign_block_vars('grouprules.then', [
					'THEN_ACTION_OPTIONS'	=> $this->build_option('', '', !$then_action['action']) . $this->action_select_options('ACP_GROUPRULES_THEN_', $then_action['action'], ['add', 'del', 'default', 'promote', 'demote']),
					'THEN_GROUP_OPTIONS'	=> $this->build_option('', 0, !$then_action['group']) . group_select_options($then_action['group']),
					'THEN_STOP'				=> $then_action['stop'],
				]);
			}
		}

		$this->template->assign_var('U_ACTION', $u_action);
	}

	/**
	 * @param string $lang_prefix
	 * @param mixed $selected
	 * @param array $actions
	 * @return string
	 */
	protected function action_select_options($lang_prefix, $selected, array $actions)
	{
		$action_options = [];

		foreach ($actions as $action)
		{
			$action_options[] = $this->build_option($this->lang->lang($lang_prefix . strtoupper($action)), $action, $action == $selected);
		}

		return implode('', $action_options);
	}

	/**
	 * @param string $text
	 * @param string $value
	 * @param bool $selected
	 * @return string
	 */
	protected function build_option($text, $value, $selected)
	{
		return '<option class="sep" value="' . $value . '"' . ($selected ? ' selected' : '') . '>' . $text . '</option>';
	}
}
