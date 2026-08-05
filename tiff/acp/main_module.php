<?php
/**
 * phpBB Gallery - TIFF Extension
 *
 * @package   phpbbgallery/tiff
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\tiff\acp;

class main_module
{
	public string $u_action = '';
	public string $tpl_name = '';
	public string $page_title = '';

	public function main(string $id, string $mode): void
	{
		global $config, $request, $template, $user;

		$user->add_lang_ext('phpbbgallery/tiff', 'info_acp_tiff');
		$this->tpl_name = 'tiff_settings';
		$this->page_title = 'ACP_GALLERY_TIFF';
		add_form_key('acp_gallery_tiff');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_gallery_tiff'))
			{
				trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}
			if (!\phpbbgallery\tiff\processor::is_supported())
			{
				trigger_error($user->lang('GALLERY_TIFF_IMAGICK_REQUIRED') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$config->set('phpbb_gallery_tiff_enabled', $request->variable('enabled', false) ? 1 : 0);
			$config->set('phpbb_gallery_tiff_webp_quality', max(1, min(100, $request->variable('webp_quality', 82))));
			trigger_error($user->lang('ACP_GALLERY_TIFF_UPDATED') . adm_back_link($this->u_action));
		}

		$template->assign_vars([
			'U_ACTION' => $this->u_action,
			'S_TIFF_ENABLED' => !empty($config['phpbb_gallery_tiff_enabled']),
			'S_TIFF_SUPPORTED' => \phpbbgallery\tiff\processor::is_supported(),
			'TIFF_WEBP_QUALITY' => max(1, min(100, (int) ($config['phpbb_gallery_tiff_webp_quality'] ?? 82))),
		]);
	}
}
