<?php
/**
 * phpBB Gallery - Image Revisions Extension
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions\acp;

class main_module
{
	public string $u_action = '';
	public string $tpl_name = '';
	public string $page_title = '';

	public function main(string $id, string $mode): void
	{
		global $config, $request, $template, $user;

		$user->add_lang_ext('phpbbgallery/imagerevisions', 'info_acp_imagerevisions');
		$this->tpl_name = 'imagerevisions_settings';
		$this->page_title = 'ACP_GALLERY_IMAGE_REVISIONS';
		add_form_key('acp_gallery_imagerevisions');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_gallery_imagerevisions'))
			{
				trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$config->set('phpbb_gallery_imagerevisions_enabled', $request->variable('enabled', 0));
			$config->set('phpbb_gallery_imagerevisions_limit', max(1, min(50, $request->variable('limit', 5))));
			trigger_error($user->lang('ACP_GALLERY_IMAGE_REVISIONS_UPDATED') . adm_back_link($this->u_action));
		}

		$template->assign_vars([
			'U_ACTION' => $this->u_action,
			'S_ENABLED' => !empty($config['phpbb_gallery_imagerevisions_enabled']),
			'REVISION_LIMIT' => max(1, min(50, (int) ($config['phpbb_gallery_imagerevisions_limit'] ?? 5))),
		]);
	}
}
