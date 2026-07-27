<?php
/**
 * Built-in BBTags provider for forum topics.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\provider;

use sitesplat\bbtags\tags\manager;

class forum_provider implements provider_interface
{
	private manager $manager;
	private string $phpbb_root_path;
	private string $php_ext;

	public function __construct(manager $manager, string $phpbb_root_path, string $php_ext)
	{
		$this->manager = $manager;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}

	public function get_name(): string
	{
		return manager::FORUM_PROVIDER;
	}

	public function get_language_key(): string
	{
		return 'BBTAGS_PROVIDER_FORUM_TOPICS';
	}

	public function validate_subject(int $scope_id, int $item_id): bool
	{
		return $this->manager->topic_matches_scope($item_id, $scope_id);
	}

	public function apply_approved_tag(int $scope_id, int $item_id, int $tag_id): bool
	{
		return $this->manager->attach_tag_to_topic($tag_id, $item_id, $scope_id);
	}

	public function get_item_url(int $scope_id, int $item_id): string
	{
		if ($item_id <= 0)
		{
			return '';
		}

		return append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, 't=' . $item_id);
	}
}
