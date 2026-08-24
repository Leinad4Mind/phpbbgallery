<?php
/**
 * phpBB Gallery - Featured Images event listener.
 *
 * @package   phpbbgallery/featured
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\featured\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	public function __construct(
		protected \phpbb\controller\helper $helper,
		protected \phpbb\language\language $language,
		protected \phpbb\template\template $template,
		protected \phpbb\user $user,
		protected \phpbbgallery\core\auth\auth $gallery_auth,
		protected \phpbbgallery\core\config $gallery_config,
		protected \phpbbgallery\core\search $search,
		protected \phpbbgallery\featured\manager $manager
	)
	{
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.acp.config.get_display_vars' => 'acp_settings',
			'phpbbgallery.core.index.image_blocks' => 'index_block',
			'phpbbgallery.core.viewimage' => 'viewimage',
			'phpbbgallery.core.image.delete_images' => 'delete_images',
			'phpbbgallery.acpcleanup.cleanup_finished' => 'cleanup_finished',
		];
	}

	public function index_block(): void
	{
		if (!(bool) $this->gallery_config->get('featured_enable'))
		{
			return;
		}
		$this->language->add_lang('featured', 'phpbbgallery/featured');
		$count = max(1, min(20, (int) $this->gallery_config->get('featured_count')));
		$slideshow = (bool) $this->gallery_config->get('featured_slideshow');
		$rendered = $this->search->curated(
			$this->manager->get_image_ids(min(500, $count * 10)),
			$this->language->lang('FEATURED_IMAGES'),
			false,
			$count,
			(bool) $this->gallery_config->get('featured_include_personal'),
			$slideshow
		);
		if ($slideshow && $rendered > 0)
		{
			$this->template->assign_vars([
				'S_FEATURED_SLIDESHOW' => true,
				'S_FEATURED_AUTOPLAY' => (bool) $this->gallery_config->get('featured_autoplay'),
				'FEATURED_INTERVAL_MS' => max(3, min(30, (int) $this->gallery_config->get('featured_interval'))) * 1000,
			]);
		}
	}

	public function viewimage(\phpbb\event\data $event): void
	{
		$image_data = (array) $event['image_data'];
		$album_data = (array) $event['album_data'];
		$album_id = (int) $image_data['image_album_id'];
		$this->gallery_auth->load_user_permissions((int) $this->user->data['user_id']);
		if (!$this->gallery_auth->acl_check('m_edit', $album_id, (int) $album_data['album_user_id']))
		{
			return;
		}
		$this->language->add_lang('featured', 'phpbbgallery/featured');
		$image_id = (int) $event['image_id'];
		$featured = $this->manager->is_featured($image_id);
		$this->template->assign_vars([
			'S_IMAGE_FEATURED' => $featured,
			'U_FEATURE_IMAGE' => $this->helper->route($featured ? 'phpbbgallery_featured_remove' : 'phpbbgallery_featured_add', [
				'image_id' => $image_id,
				'hash' => generate_link_hash(($featured ? 'unfeature' : 'feature') . '_' . $image_id),
			]),
			'U_FEATURE_IMAGE_TOGGLE' => $this->helper->route($featured ? 'phpbbgallery_featured_add' : 'phpbbgallery_featured_remove', [
				'image_id' => $image_id,
				'hash' => generate_link_hash(($featured ? 'feature' : 'unfeature') . '_' . $image_id),
			]),
			'FEATURE_IMAGE_LABEL' => $this->language->lang($featured ? 'UNFEATURE_IMAGE' : 'FEATURE_IMAGE'),
			'FEATURE_IMAGE_TOGGLE_LABEL' => $this->language->lang($featured ? 'FEATURE_IMAGE' : 'UNFEATURE_IMAGE'),
		]);
	}

	public function delete_images(\phpbb\event\data $event): void
	{
		$this->manager->delete_images((array) $event['images']);
	}

	public function cleanup_finished(): void
	{
		$this->manager->reconcile_orphans();
	}

	public function acp_settings(\phpbb\event\data $event): void
	{
		if ($event['mode'] !== 'main')
		{
			return;
		}
		$return_ary = (array) $event['return_ary'];
		$this->language->add_lang('featured', 'phpbbgallery/featured');
		$addon = ['id' => 'featured', 'name' => 'FEATURED_IMAGES', 'accent' => '#7c3aed'];
		$return_ary['vars']['FEATURED_SETTINGS'] = [
			'featured_enable' => ['lang' => 'FEATURED_ENABLE', 'explain' => true, 'validate' => 'bool', 'type' => 'radio:yes_no', 'addon' => $addon],
			'featured_count' => ['lang' => 'FEATURED_COUNT', 'explain' => true, 'validate' => 'int:1:20', 'type' => 'number:1:20', 'addon' => $addon],
			'featured_slideshow' => ['lang' => 'FEATURED_SLIDESHOW', 'explain' => true, 'validate' => 'bool', 'type' => 'radio:yes_no', 'addon' => $addon],
			'featured_autoplay' => ['lang' => 'FEATURED_AUTOPLAY', 'explain' => true, 'validate' => 'bool', 'type' => 'radio:yes_no', 'addon' => $addon],
			'featured_interval' => ['lang' => 'FEATURED_INTERVAL', 'explain' => true, 'validate' => 'int:3:30', 'type' => 'number:3:30', 'append' => ' ' . $this->language->lang('SECONDS'), 'addon' => $addon],
			'featured_include_personal' => ['lang' => 'FEATURED_INCLUDE_PERSONAL', 'explain' => true, 'validate' => 'bool', 'type' => 'radio:yes_no', 'addon' => $addon],
		];
		$event['return_ary'] = $return_ary;
	}
}
