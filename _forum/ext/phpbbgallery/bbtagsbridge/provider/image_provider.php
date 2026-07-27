<?php
/**
 * BBTags provider for phpBB Gallery images.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge\provider;

use phpbb\controller\helper;
use phpbbgallery\bbtagsbridge\image_tag_manager;
use sitesplat\bbtags\provider\provider_interface;

final class image_provider implements provider_interface
{
	private image_tag_manager $image_tags;
	private helper $helper;

	public function __construct(image_tag_manager $image_tags, helper $helper)
	{
		$this->image_tags = $image_tags;
		$this->helper = $helper;
	}

	public function get_name(): string
	{
		return image_tag_manager::PROVIDER;
	}

	public function get_language_key(): string
	{
		return 'BBTAGS_PROVIDER_GALLERY_IMAGES';
	}

	public function validate_subject(int $scope_id, int $item_id): bool
	{
		return $this->image_tags->image_matches_album($item_id, $scope_id);
	}

	public function apply_approved_tag(int $scope_id, int $item_id, int $tag_id): bool
	{
		return $this->image_tags->image_matches_album($item_id, $scope_id)
			&& $this->image_tags->attach_tag($item_id, $tag_id);
	}

	public function get_item_url(int $scope_id, int $item_id): string
	{
		return $item_id > 0 ? $this->helper->route('phpbbgallery_core_image', ['image_id' => $item_id]) : '';
	}
}
