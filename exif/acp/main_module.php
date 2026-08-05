<?php
/**
 * phpBB Gallery - EXIF ACP
 *
 * @package   phpbbgallery/exif
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif\acp;

use phpbb\request\request_interface;
use phpbbgallery\exif\capture_sync;

final class main_module
{
	private const FORM_KEY = 'acp_gallery_exif';
	private const SYNC_HASH = 'gallery_exif_capture_sync';

	public string $u_action = '';
	public string $tpl_name = '';
	public string $page_title = '';

	public function main(string $id, string $mode): void
	{
		global $phpbb_container;

		$request = $phpbb_container->get('request');
		$template = $phpbb_container->get('template');
		$language = $phpbb_container->get('language');
		$language->add_lang('info_exif', 'phpbbgallery/exif');
		$this->tpl_name = 'exif_settings';
		$this->page_title = 'ACP_GALLERY_EXIF';
		add_form_key(self::FORM_KEY);

		if ($request->variable('action', '') === 'sync')
		{
			$this->synchronize($request, $phpbb_container->get('phpbbgallery.exif.capture_sync'));
		}

		$template->assign_vars([
			'U_SYNC' => $this->u_action . '&amp;action=sync',
			'INDEXED_IMAGES' => $phpbb_container->get('phpbbgallery.exif.capture_index')->count(),
		]);
	}

	private function synchronize(request_interface $request, capture_sync $sync): void
	{
		global $phpbb_container;

		$language = $phpbb_container->get('language');
		$start = max(0, $request->variable('start', 0));
		$scanned = max(0, $request->variable('scanned', 0));
		$indexed = max(0, $request->variable('indexed', 0));
		$unavailable = max(0, $request->variable('unavailable', 0));
		$hash = $request->variable('hash', '');
		$is_continuation = $start > 0 && check_link_hash($hash, self::SYNC_HASH);
		if (!$is_continuation)
		{
			if ($request->is_set_post('sync') && !check_form_key(self::FORM_KEY))
			{
				trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}
			if (!confirm_box(true))
			{
				confirm_box(false, $language->lang('ACP_EXIF_SYNC_CONFIRM'), build_hidden_fields([
					'action' => 'sync',
				]));

				return;
			}
		}

		$result = $sync->run_batch($start);
		$scanned += $result['scanned'];
		$indexed += $result['indexed'];
		$unavailable += $result['unavailable'];
		if ($result['has_more'])
		{
			$url = $this->u_action . '&amp;action=sync&amp;start=' . $result['last_id']
				. '&amp;scanned=' . $scanned . '&amp;indexed=' . $indexed
				. '&amp;unavailable=' . $unavailable
				. '&amp;hash=' . generate_link_hash(self::SYNC_HASH);
			meta_refresh(1, $url);
			trigger_error($language->lang('ACP_EXIF_SYNC_PROGRESS', $scanned, $indexed, $unavailable)
				. adm_back_link($this->u_action));
		}

		trigger_error($language->lang('ACP_EXIF_SYNC_COMPLETE', $scanned, $indexed, $unavailable)
			. adm_back_link($this->u_action));
	}
}
