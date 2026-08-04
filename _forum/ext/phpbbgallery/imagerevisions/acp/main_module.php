<?php
/**
 * phpBB Gallery - Image Revisions Extension
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions\acp;

use phpbbgallery\imagerevisions\policy;

class main_module
{
	public string $u_action = '';
	public string $tpl_name = '';
	public string $page_title = '';

	public function main(string $id, string $mode): void
	{
		global $config, $request, $template, $user, $phpbb_container;

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

			$config->set('phpbb_gallery_imagerevisions_enabled', $request->variable('enabled', false) ? 1 : 0);
			$config->set('phpbb_gallery_imagerevisions_limit', policy::normalize_limit($request->variable('limit', 5)));
			trigger_error($user->lang('ACP_GALLERY_IMAGE_REVISIONS_UPDATED') . adm_back_link($this->u_action));
		}

		$template->assign_vars([
			'U_ACTION' => $this->u_action,
			'S_ENABLED' => !empty($config['phpbb_gallery_imagerevisions_enabled']),
			'REVISION_LIMIT' => policy::normalize_limit((int) ($config['phpbb_gallery_imagerevisions_limit'] ?? 5)),
		]);
		$policy = $phpbb_container->get('phpbbgallery.imagerevisions.policy');
		$gallery_url = $phpbb_container->get('phpbbgallery.core.url');
		foreach ($policy->get_album_rules() as $album)
		{
			$template->assign_block_vars('imagerevisions_albums', [
				'NAME' => (string) $album['album_name'],
				'PREFIX' => str_repeat("\u{2014} ", (int) $album['depth']),
				'ENABLED' => $album['enabled'] === null ? policy::INHERIT : (int) $album['enabled'],
				'LIMIT' => $album['revision_limit'] === null ? policy::INHERIT : (int) $album['revision_limit'],
				'EFFECTIVE_ENABLED' => (int) $album['effective_enabled'],
				'EFFECTIVE_LIMIT' => (int) $album['effective_revision_limit'],
				'U_EDIT' => $gallery_url->append_sid('admin', 'index',
					'i=-phpbbgallery-core-acp-albums_module&amp;mode=manage&amp;parent_id=' . (int) $album['parent_id']
					. '&amp;a=' . (int) $album['album_id'] . '&amp;action=edit'),
			]);
		}
	}
}
