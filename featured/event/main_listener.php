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

function featured_location_options(string $value, string $key): string
{
	global $phpbb_container;
	$language = $phpbb_container->get('language');
	$options = [
		main_listener::LOCATION_NONE => 'FEATURED_LOCATION_NONE',
		main_listener::LOCATION_GALLERY => 'FEATURED_LOCATION_GALLERY',
		main_listener::LOCATION_FORUM => 'FEATURED_LOCATION_FORUM',
		main_listener::LOCATION_BOTH => 'FEATURED_LOCATION_BOTH',
	];
	return featured_select_options($options, (int) $value, $language);
}

function featured_position_options(string $value, string $key): string
{
	global $phpbb_container;
	$language = $phpbb_container->get('language');
	return featured_select_options([
		main_listener::POSITION_TOP => 'FEATURED_POSITION_TOP',
		main_listener::POSITION_BOTTOM => 'FEATURED_POSITION_BOTTOM',
	], (int) $value, $language);
}

function featured_select_options(array $options, int $selected, \phpbb\language\language $language): string
{
	$html = '';
	foreach ($options as $value => $label)
	{
		$html .= '<option value="' . (int) $value . '"' . ((int) $value === $selected ? ' selected="selected"' : '') . '>' . utf8_htmlspecialchars($language->lang($label)) . '</option>';
	}
	return $html;
}

class main_listener implements EventSubscriberInterface
{
	public const LOCATION_NONE = 0;
	public const LOCATION_GALLERY = 1;
	public const LOCATION_FORUM = 2;
	public const LOCATION_BOTH = 3;
	public const POSITION_TOP = 0;
	public const POSITION_BOTTOM = 1;

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
			'phpbbgallery.core.index.image_blocks' => 'gallery_index_block',
			'core.index_modify_page_title' => 'forum_index_block',
			'phpbbgallery.core.viewimage' => 'viewimage',
			'phpbbgallery.core.image.delete_images' => 'delete_images',
			'phpbbgallery.acpcleanup.cleanup_finished' => 'cleanup_finished',
		];
	}

	public function gallery_index_block(): void
	{
		if (($this->display_location() & self::LOCATION_GALLERY) === 0)
		{
			return;
		}
		$this->render_index_block('GALLERY');
	}

	public function forum_index_block(): void
	{
		if (($this->display_location() & self::LOCATION_FORUM) === 0)
		{
			return;
		}
		$this->render_index_block('FORUM');
	}

	private function render_index_block(string $context): void
	{
		$this->language->add_lang('featured', 'phpbbgallery/featured');
		$count = max(1, min(20, (int) $this->gallery_config->get('featured_count')));
		$slideshow = (bool) $this->gallery_config->get('featured_slideshow');
		$rendered = $this->search->curated(
			$this->manager->get_image_ids(min(500, $count * 10)),
			$this->language->lang('FEATURED_IMAGES'),
			false,
			$count,
			(bool) $this->gallery_config->get('featured_include_personal'),
			$slideshow,
			false,
			'featuredslide'
		);
		if ($rendered <= 0)
		{
			return;
		}
		$position = (int) $this->gallery_config->get('featured_position') === self::POSITION_TOP ? 'TOP' : 'BOTTOM';
		$this->template->assign_vars([
			'S_FEATURED_IMAGES' => true,
			'S_FEATURED_SLIDESHOW' => $slideshow,
			'S_FEATURED_AUTOPLAY' => $slideshow && (bool) $this->gallery_config->get('featured_autoplay'),
			'FEATURED_INTERVAL_MS' => max(3, min(30, (int) $this->gallery_config->get('featured_interval'))) * 1000,
			'GALLERY_INDEX_ALBUM_LAYOUT' => (string) $this->gallery_config->get('index_album_layout'),
			'S_FEATURED_' . $context . '_INDEX_' . $position => true,
		]);
	}

	private function display_location(): int
	{
		$location = (int) $this->gallery_config->get('featured_location');
		if ($location < self::LOCATION_NONE || $location > self::LOCATION_BOTH)
		{
			return self::LOCATION_GALLERY;
		}
		return $location;
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
			'featured_location' => ['lang' => 'FEATURED_LOCATION', 'explain' => true, 'validate' => 'int:0:3', 'type' => 'select', 'function' => __NAMESPACE__ . '\\featured_location_options', 'addon' => $addon],
			'featured_position' => ['lang' => 'FEATURED_POSITION', 'explain' => true, 'validate' => 'int:0:1', 'type' => 'select', 'function' => __NAMESPACE__ . '\\featured_position_options', 'addon' => $addon],
			'featured_count' => ['lang' => 'FEATURED_COUNT', 'explain' => true, 'validate' => 'int:1:20', 'type' => 'number:1:20', 'addon' => $addon],
			'featured_slideshow' => ['lang' => 'FEATURED_SLIDESHOW', 'explain' => true, 'validate' => 'bool', 'type' => 'radio:yes_no', 'addon' => $addon],
			'featured_autoplay' => ['lang' => 'FEATURED_AUTOPLAY', 'explain' => true, 'validate' => 'bool', 'type' => 'radio:yes_no', 'addon' => $addon],
			'featured_interval' => ['lang' => 'FEATURED_INTERVAL', 'explain' => true, 'validate' => 'int:3:30', 'type' => 'number:3:30', 'append' => ' ' . $this->language->lang('SECONDS'), 'addon' => $addon],
			'featured_include_personal' => ['lang' => 'FEATURED_INCLUDE_PERSONAL', 'explain' => true, 'validate' => 'bool', 'type' => 'radio:yes_no', 'addon' => $addon],
		];
		$event['return_ary'] = $return_ary;
	}
}
