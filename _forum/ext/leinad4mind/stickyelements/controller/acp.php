<?php

/**
 *
 * Sticky Elements. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\stickyelements\controller;

use leinad4mind\stickyelements\includes\helper;
use phpbb\json_response;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\textformatter\parser_interface;
use phpbb\textformatter\renderer_interface;
use phpbb\textformatter\utils_interface;
use phpbb\user;

class acp extends base
{
	/** @var user */
	protected $user;

	/** @var language */
	protected $lang;

	/** @var request_interface */
	protected $request;

	/** @var template */
	protected $template;

	/** @var parser_interface */
	protected $parser;

	/** @var renderer_interface */
	protected $renderer;

	/** @var utils_interface */
	protected $utils;

	/** @var log_interface */
	protected $log;

	/** @var helper */
	protected $helper;

	/**
	 * @param user					$user
	 * @param language				$lang
	 * @param request_interface		$request
	 * @param template				$template
	 * @param parser_interface		$parser
	 * @param renderer_interface	$renderer
	 * @param utils_interface		$utils
	 * @param log_interface			$log
	 * @param helper				$helper
	 */
	public function __construct(
		user $user,
		language $lang,
		request_interface $request,
		template $template,
		parser_interface $parser,
		renderer_interface $renderer,
		utils_interface $utils,
		log_interface $log,
	 	helper $helper
	)
	{
		$this->user			= $user;
		$this->lang			= $lang;
		$this->request		= $request;
		$this->template		= $template;
		$this->parser		= $parser;
		$this->renderer		= $renderer;
		$this->utils		= $utils;
		$this->log			= $log;
		$this->helper		= $helper;
	}

	/**
	 * @param string $id
	 * @param string $mode
	 * @param string $u_action
	 */
	public function main($id, $mode, $u_action)
	{
		$ext_name = 'leinad4mind/stickyelements';

		$this->tpl_name = 'acp_main_body';
		$this->page_title = 'ACP_STICKYELEMENTS_TITLE';

		$this->lang->add_lang('acp', $ext_name);

		$action	= $this->request->variable('action', '');
		$stickyelement_id = $this->request->variable('stickyelement', 0);

		add_form_key($ext_name);

		switch ($action)
		{
			case 'add':

				$this->tpl_name = 'acp_add_edit_body';

				$this->template->assign_vars([
					'ACTION'	=> 'ADD',
					'U_BACK'	=> $u_action,
					'U_ACTION'	=> $u_action . '&amp;action=create',
				]);

				return;

			break;

			case 'create':

				if (!check_form_key($ext_name))
				{
					trigger_error($this->lang->lang('FORM_INVALID') . adm_back_link($u_action), E_USER_WARNING);
				}

				$stickyelement = $this->get_stickyelement_from_request($this->helper->get_next_stickyelement_id());

				if ($this->helper->add_stickyelement($stickyelement))
				{
					$this->log('LOG_STICKYELEMENTS_CREATED');

					trigger_error($this->lang->lang('STICKYELEMENTS_CREATED') . adm_back_link($u_action));
				}

			break;

			case 'edit':

				$this->tpl_name = 'acp_add_edit_body';

				$stickyelement = $this->helper->get_stickyelement($stickyelement_id);

				if ($stickyelement)
				{
					$this->template->assign_vars([
						'STICKYELEMENT_ONLY_INDEX'	=> $stickyelement['only_index'],
						'STICKYELEMENT_TEXT'			=> $this->utils->unparse($stickyelement['text']),
						'STICKYELEMENT_COLOR'		=> $stickyelement['color'],
					]);
				}

				$this->template->assign_vars([
					'ACTION'			=> 'EDIT',
					'U_BACK'			=> $u_action,
					'U_ACTION'			=> $u_action . '&amp;action=modify&amp;stickyelement=' . $stickyelement_id,
				]);

				return;

			break;

			case 'modify':

				if (!check_form_key($ext_name))
				{
					trigger_error($this->lang->lang('FORM_INVALID') . adm_back_link($u_action), E_USER_WARNING);
				}

				$stickyelement = $this->get_stickyelement_from_request($stickyelement_id);

				if ($this->helper->set_stickyelement($stickyelement))
				{
					$this->log('LOG_STICKYELEMENTS_MODIFIED');

					trigger_error($this->lang->lang('STICKYELEMENTS_MODIFIED') . adm_back_link($u_action));
				}

			break;

			case 'up':
			case 'down':

				if (!check_link_hash($this->request->variable('hash', ''), 'stickyelements'))
				{
					trigger_error($this->lang->lang('FORM_INVALID') . adm_back_link($u_action), E_USER_WARNING);
				}

				$move_result = $this->helper->move_stickyelement($stickyelement_id, $action == 'up' ? -1 : 1);

				if ($this->request->is_ajax())
				{
					(new json_response())->send([
						'success' => $move_result,
					]);
				}

			break;

			case 'delete':

				if (confirm_box(true))
				{
					$delete_stickyelement = $this->helper->delete_stickyelement($stickyelement_id);

					if ($delete_stickyelement)
					{
						$this->log('LOG_STICKYELEMENTS_DELETED');
					}

					if ($this->request->is_ajax())
					{
						(new json_response())->send([
							'MESSAGE_TITLE'	=> $this->lang->lang('INFORMATION'),
							'MESSAGE_TEXT'	=> $this->lang->lang('STICKYELEMENTS_DELETED'),
							'REFRESH_DATA'	=> ['time' => 3],
						]);
					}
				}
				else
				{
					confirm_box(false, $this->lang->lang('CONFIRM_OPERATION'), build_hidden_fields([
						'action'			=> 'delete',
						'stickyelement_id'	=> $stickyelement_id,
					]));
				}

			break;
		}

		$stickyelements = $this->helper->get_stickyelements();

		$hash = generate_link_hash('stickyelements');

		foreach ($stickyelements as $stickyelement)
		{
			$this->template->assign_block_vars('stickyelements', [
				'ONLY_INDEX'	=> $stickyelement['only_index'],
				'TEXT'			=> $this->renderer->render($stickyelement['text']),
				'COLOR'			=> $stickyelement['color'],
				'U_MOVE_UP'		=> $u_action . '&amp;action=up&amp;stickyelement=' . $stickyelement['id'] . '&amp;hash=' . $hash,
				'U_MOVE_DOWN'	=> $u_action . '&amp;action=down&amp;stickyelement=' . $stickyelement['id'] . '&amp;hash=' . $hash,
				'U_EDIT'		=> $u_action . '&amp;action=edit&amp;stickyelement=' . $stickyelement['id'],
				'U_DELETE'		=> $u_action . '&amp;action=delete&amp;stickyelement=' . $stickyelement['id'],
			]);
		}

		$this->template->assign_var('U_ACTION', $u_action . '&amp;action=add');
	}

	/**
	 * @param int $stickyelement_id
	 * @return array
	 */
	protected function get_stickyelement_from_request($stickyelement_id)
	{
		return [
			'id'			=> $stickyelement_id,
			'only_index'	=> $this->request->variable('stickyelement_only_index', false),
			'text'			=> $this->parser->parse($this->request->variable('stickyelement_text', '', true)),
			'color'			=> $this->validate_stickyelement_color($this->request->variable('stickyelement_color', '')),
		];
	}

	/**
	 * @param string $color
	 * @return string
	 */
	protected function validate_stickyelement_color($color)
	{
		return $color && preg_match('/^#[a-f0-9]{6}$/i', $color) ? $color : '';
	}

	/**
	 * @param string $log_operation
	 */
	protected function log($log_operation)
	{
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, $log_operation);
	}
}
