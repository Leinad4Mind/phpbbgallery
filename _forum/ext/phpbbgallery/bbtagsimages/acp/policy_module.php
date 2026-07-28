<?php
/**
 * Gallery BBTags administrative policy module.
 *
 * This module configures availability. Suggestion moderation remains in MCP.
 *
 * @package   phpbbgallery/bbtagsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsimages\acp;

use phpbb\request\request_interface;
use phpbbgallery\bbtagsimages\image_tag_manager;

final class policy_module
{
	private const FORM_KEY = 'acp_bbtagsimages_policies';

	public string $u_action = '';
	public string $tpl_name = '';
	public string $page_title = '';

	public function main(string $id, string $mode): void
	{
		global $phpbb_container;

		$request = $phpbb_container->get('request');
		$template = $phpbb_container->get('template');
		$language = $phpbb_container->get('language');
		$tags = $phpbb_container->get('sitesplat.bbtags.manager');
		$scopes = $phpbb_container->get('phpbbgallery.bbtagsimages.album_scope_resolver');
		$language->add_lang('info_acp_bbtagsimages', 'phpbbgallery/bbtagsimages');

		$this->tpl_name = 'acp_bbtagsimages_policy';
		$this->page_title = 'ACP_BBTAGSIMAGES_POLICIES';
		add_form_key(self::FORM_KEY);

		$policies = $tags->get_provider_policies(image_tag_manager::PROVIDER);
		$policies_by_id = [];
		foreach ($policies as $policy)
		{
			$policies_by_id[(int) $policy['id']] = $policy;
		}
		$selected_id = $request->variable('tag_id', 0);
		if (!isset($policies_by_id[$selected_id]))
		{
			$selected_id = empty($policies) ? 0 : (int) $policies[0]['id'];
		}
		$albums = $scopes->get_album_tree();

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key(self::FORM_KEY) || $selected_id <= 0)
			{
				trigger_error($language->lang('FORM_INVALID'));
			}

			$scope_mode = $request->variable('scope_mode', 'restricted', false, request_interface::POST);
			$submitted_rules = $request->variable('rules', [0 => ''], false, request_interface::POST);
			if (!in_array($scope_mode, ['global', 'restricted'], true))
			{
				trigger_error($language->lang('FORM_INVALID'));
			}
			$rules = [];
			foreach ($albums as $album)
			{
				$album_id = (int) $album['album_id'];
				$rule = (string) ($submitted_rules[$album_id] ?? 'inherit');
				if (!in_array($rule, ['inherit', 'allow', 'deny'], true))
				{
					trigger_error($language->lang('FORM_INVALID'));
				}
				$rules[$album_id] = $rule;
			}

			$is_enabled = $request->variable('is_enabled', 0, false, request_interface::POST) === 1;
			if (!$tags->save_provider_policy(
				$selected_id,
				image_tag_manager::PROVIDER,
				$is_enabled,
				$scope_mode,
				$rules
			))
			{
				trigger_error($language->lang('ACP_BBTAGSIMAGES_SAVE_FAILED'));
			}

			trigger_error(
				$language->lang('ACP_BBTAGSIMAGES_SAVED')
				. adm_back_link($this->u_action . '&amp;tag_id=' . $selected_id)
			);
		}

		$selected = $policies_by_id[$selected_id] ?? null;
		$rules = $selected ? $tags->get_scope_rules($selected_id, image_tag_manager::PROVIDER) : [];
		$template->assign_vars([
			'U_ACTION' => $this->u_action,
			'S_HAS_BBTAGSIMAGES_TAGS' => !empty($policies),
			'S_BBTAGSIMAGES_TAG_SELECTED' => $selected !== null,
			'S_BBTAGSIMAGES_ENABLED' => !empty($selected['is_enabled']),
			'S_BBTAGSIMAGES_GLOBAL' => ($selected['scope_mode'] ?? '') === 'global',
			'S_BBTAGSIMAGES_RESTRICTED' => ($selected['scope_mode'] ?? 'restricted') === 'restricted',
		]);
		foreach ($policies as $policy)
		{
			$template->assign_block_vars('bbtagsimages_policy_tags', [
				'ID' => (int) $policy['id'],
				'NAME' => (string) $policy['tag'],
				'SELECTED' => (int) $policy['id'] === $selected_id,
			]);
		}
		foreach ($albums as $album)
		{
			$rule = $rules[(int) $album['album_id']] ?? 'inherit';
			$template->assign_block_vars('bbtagsimages_policy_albums', [
				'ID' => (int) $album['album_id'],
				'NAME' => (string) $album['album_name'],
				'PREFIX' => str_repeat("\u{2014} ", (int) $album['depth']),
				'S_INHERIT' => $rule === 'inherit',
				'S_ALLOW' => $rule === 'allow',
				'S_DENY' => $rule === 'deny',
			]);
		}
	}
}
