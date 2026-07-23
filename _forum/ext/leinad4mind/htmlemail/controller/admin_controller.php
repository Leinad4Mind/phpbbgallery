<?php
/**
 *
 * HTML email extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
 * @copyright (c) 2026 Leinad4Mind <https://leinad4mind.top>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\htmlemail\controller;

class admin_controller
{
	protected \leinad4mind\htmlemail\service\template_finder $template_finder;
	protected \leinad4mind\htmlemail\service\html_detector $html_detector;
	protected \leinad4mind\htmlemail\service\template_editor $template_editor;
	protected \phpbb\language\language $language;
	protected \phpbb\request\request $request;
	protected \phpbb\template\template $template;
	protected \phpbb\user $user;

	/** @var array|null Cached result of find_all() for current request */
	protected array|null $templates_cache = null;

	public function __construct(
		\leinad4mind\htmlemail\service\template_finder $template_finder,
		\leinad4mind\htmlemail\service\html_detector $html_detector,
		\leinad4mind\htmlemail\service\template_editor $template_editor,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\phpbb\user $user
	)
	{
		$this->template_finder = $template_finder;
		$this->html_detector = $html_detector;
		$this->template_editor = $template_editor;
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
	}

	public function handle(string $mode, string $u_action): void
	{
		$this->language->add_lang('acp/common');
		$this->language->add_lang('info_acp_htmlemail', 'leinad4mind/htmlemail');

		$action = $this->request->variable('action', '');
		$template_id = $this->request->variable('template_id', '');

		// Handle Form Submissions (POST actions)
		if ($this->request->is_set_post('submit') && check_form_key('htmlemail_edit'))
		{
			$this->save_template($template_id, $u_action);
			return;
		}

		if ($this->request->is_set_post('restore') && check_form_key('htmlemail_edit'))
		{
			$this->restore_template($template_id, $u_action);
			return;
		}

		// Routing (GET actions)
		if ($action === 'edit' && $template_id)
		{
			$this->show_edit($template_id, $u_action);
		}
		else
		{
			$this->show_overview($u_action);
		}
	}

	protected function show_overview(string $u_action): void
	{
		$templates = $this->get_all_templates();

		foreach ($templates as $tpl)
		{
			$content = $this->template_editor->read($tpl['absolute']);
			$is_html = $content !== false ? $this->html_detector->is_html($content) : false;

			$this->template->assign_block_vars('templates', [
				'ID'       => $tpl['id'],
				'ORIGIN'   => $tpl['origin'],
				'LANG'     => $tpl['lang'],
				'FILENAME' => $tpl['filename'],
				'PATH'     => $tpl['path'],
				'IS_HTML'  => $is_html,
				'U_EDIT'   => $u_action . '&amp;action=edit&amp;template_id=' . $tpl['id'],
			]);
		}

		$this->template->assign_vars([
			'S_OVERVIEW' => true,
		]);
	}

	protected function show_edit(string $template_id, string $u_action): void
	{
		$tpl = $this->get_template_by_id($template_id);

		if (!$tpl)
		{
			trigger_error($this->language->lang('ACP_HTMLEMAIL_NOT_FOUND') . adm_back_link($u_action), E_USER_WARNING);
			return;
		}

		$content = $this->template_editor->read($tpl['absolute']);

		add_form_key('htmlemail_edit');

		$this->template->assign_vars([
			'S_EDIT'      => true,
			'TEMPLATE_ID' => $tpl['id'],
			'FILENAME'    => $tpl['filename'],
			'ORIGIN'      => $tpl['origin'],
			'PATH'        => $tpl['path'],
			'CONTENT'     => $content !== false ? $content : '',
			'U_ACTION'    => $u_action . '&amp;action=edit&amp;template_id=' . $tpl['id'],
			'U_BACK'      => $u_action,
			'HAS_BACKUP'  => file_exists($tpl['absolute'] . '.bak'),
		]);
	}

	protected function save_template(string $template_id, string $u_action): void
	{
		$tpl = $this->get_template_by_id($template_id);

		if (!$tpl)
		{
			trigger_error($this->language->lang('ACP_HTMLEMAIL_NOT_FOUND') . adm_back_link($u_action), E_USER_WARNING);
			return;
		}

		$content = $this->request->variable('template_content', '', true);

		if ($this->template_editor->write($tpl['absolute'], $content))
		{
			trigger_error($this->language->lang('ACP_HTMLEMAIL_SAVED') . adm_back_link($u_action));
		}
		else
		{
			trigger_error($this->language->lang('ACP_HTMLEMAIL_SAVE_ERROR') . adm_back_link($u_action), E_USER_WARNING);
		}
	}

	protected function restore_template(string $template_id, string $u_action): void
	{
		$tpl = $this->get_template_by_id($template_id);

		if (!$tpl)
		{
			trigger_error($this->language->lang('ACP_HTMLEMAIL_NOT_FOUND') . adm_back_link($u_action), E_USER_WARNING);
			return;
		}

		if ($this->template_editor->restore($tpl['absolute']))
		{
			trigger_error($this->language->lang('ACP_HTMLEMAIL_RESTORED') . adm_back_link($u_action));
		}
		else
		{
			trigger_error($this->language->lang('ACP_HTMLEMAIL_RESTORE_ERROR') . adm_back_link($u_action), E_USER_WARNING);
		}
	}

	/**
	 * Get all templates with in-request caching to avoid multiple disk scans
	 *
	 * @return array
	 */
	protected function get_all_templates(): array
	{
		if ($this->templates_cache === null)
		{
			$this->templates_cache = $this->template_finder->find_all();
		}

		return $this->templates_cache;
	}

	protected function get_template_by_id(string $id): array|false
	{
		foreach ($this->get_all_templates() as $tpl)
		{
			if ($tpl['id'] === $id)
			{
				return $tpl;
			}
		}
		return false;
	}
}
