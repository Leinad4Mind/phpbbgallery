<?php
/**
 * phpBB Gallery - BBPoints Images ACP
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\acp;

use phpbb\request\request_interface;
use phpbb\language\language;
use phpbbgallery\bbpointsimages\policy;
use phpbbgallery\bbpointsimages\retro_sync;

final class main_module
{
	private const FORM_KEY = 'acp_gallery_bbpointsimages';
	private const SYNC_HASH = 'gallery_bbpointsimages_sync';

	public string $u_action = '';
	public string $tpl_name = '';
	public string $page_title = '';

	public function main(string $id, string $mode): void
	{
		global $phpbb_container;

		$config = $phpbb_container->get('config');
		$request = $phpbb_container->get('request');
		$template = $phpbb_container->get('template');
		$language = $phpbb_container->get('language');
		$policies = $phpbb_container->get('phpbbgallery.bbpointsimages.policy');
		$language->add_lang('info_acp_bbpointsimages', 'phpbbgallery/bbpointsimages');
		$this->tpl_name = 'bbpointsimages_settings';
		$this->page_title = 'ACP_BBPOINTSIMAGES_SETTINGS';
		add_form_key(self::FORM_KEY);

		$action = $request->variable('action', '');
		if ($action === 'save' && $request->is_set_post('submit'))
		{
			if (!check_form_key(self::FORM_KEY))
			{
				trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}
			$config->set('phpbb_gallery_bbpoints_upload_reward', policy::normalize_amount(
				$request->variable('upload_reward', 0, false, request_interface::POST)
			));
			$config->set('phpbb_gallery_bbpoints_source_cost', policy::normalize_amount(
				$request->variable('source_cost', 0, false, request_interface::POST)
			));
			$config->set('phpbb_gallery_bbpoints_contributors_enabled',
				$request->variable('contributors_enabled', false, false, request_interface::POST) ? 1 : 0
			);
			$submitted = $request->variable('album_rules', [0 => ['upload_reward' => -1, 'source_cost' => -1]], false, request_interface::POST);
			$policies->save_album_rules($submitted);
			trigger_error($language->lang('ACP_BBPOINTSIMAGES_SAVED') . adm_back_link($this->u_action));
		}

		if ($action === 'sync')
		{
			$this->synchronize($request, $language, $phpbb_container->get('phpbbgallery.bbpointsimages.retro_sync'));
		}

		$template->assign_vars([
			'U_ACTION' => $this->u_action . '&amp;action=save',
			'U_SYNC' => $this->u_action . '&amp;action=sync',
			'UPLOAD_REWARD' => policy::normalize_amount((int) $config['phpbb_gallery_bbpoints_upload_reward']),
			'SOURCE_COST' => policy::normalize_amount((int) $config['phpbb_gallery_bbpoints_source_cost']),
			'S_CONTRIBUTORS_ENABLED' => !empty($config['phpbb_gallery_bbpoints_contributors_enabled']),
		]);
		foreach ($policies->get_album_rules() as $album)
		{
			$template->assign_block_vars('bbpointsimages_albums', [
				'ID' => (int) $album['album_id'],
				'NAME' => (string) $album['album_name'],
				'PREFIX' => str_repeat("\u{2014} ", (int) $album['depth']),
				'UPLOAD_REWARD' => $album['upload_reward'] === null ? policy::INHERIT : (int) $album['upload_reward'],
				'SOURCE_COST' => $album['source_cost'] === null ? policy::INHERIT : (int) $album['source_cost'],
			]);
		}
	}

	private function synchronize(request_interface $request, language $language, retro_sync $sync): void
	{
		$start = max(0, $request->variable('start', 0));
		$scanned = max(0, $request->variable('scanned', 0));
		$rewarded = max(0, $request->variable('rewarded', 0));
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
				confirm_box(false, $language->lang('ACP_BBPOINTSIMAGES_SYNC_CONFIRM'), build_hidden_fields([
					'action' => 'sync',
				]));
				return;
			}
		}

		$result = $sync->run_batch($start);
		$scanned += $result['scanned'];
		$rewarded += $result['rewarded'];
		if ($result['has_more'])
		{
			$url = $this->u_action . '&amp;action=sync&amp;start=' . $result['last_id']
				. '&amp;scanned=' . $scanned . '&amp;rewarded=' . $rewarded
				. '&amp;hash=' . generate_link_hash(self::SYNC_HASH);
			meta_refresh(1, $url);
			trigger_error($language->lang(
				'ACP_BBPOINTSIMAGES_SYNC_PROGRESS',
				$scanned,
				$rewarded
			) . adm_back_link($this->u_action));
		}

		trigger_error($language->lang(
			'ACP_BBPOINTSIMAGES_SYNC_COMPLETE',
			$scanned,
			$rewarded
		) . adm_back_link($this->u_action));
	}
}
