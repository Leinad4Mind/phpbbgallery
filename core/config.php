<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core;

class config
{
	public const INDEX_ALBUM_LAYOUT_CLASSIC = 'classic';
	public const INDEX_ALBUM_LAYOUT_MODERN = 'modern';
	public const INDEX_ALBUM_LAYOUT_CARDS = 'cards';

	private \phpbb\config\config $config;

	private array $configs_array = [
		'title'				=> '',
		'album_display'		=> 254,
		'album_images'		=> 2500,
		'allow_comments'	=> true,
		'allow_gif'			=> true,
		'allow_hotlinking'	=> true,
		'allow_jpg'			=> true,
		'allow_png'			=> true,
		'allow_webp'		=> true,
		'allow_avif'		=> false,
		'allow_bmp'			=> false,
		'allow_rates'		=> true,
		'allow_resize'		=> true,
		'allow_rotate'		=> true,
		'auto_orient'		=> true,
		'allow_zip'			=> false,
		'ajax_navigation'	=> false,
		'bbcode_tag'		=> 'image',
		'album_bbcode_tag'	=> 'album',

		'captcha_comment'		=> true,
		'captcha_upload'		=> true,
		'comment_length'		=> 2000,
		'comment_user_control'	=> true,
		'current_upload_dir_size'	=> 0,
		'current_upload_dir'	=> 0,

		'default_sort_dir'	=> 'd',
		'default_sort_key'	=> 't',
		'description_length'=> 2000,
		'disp_birthdays'			=> false,
		'disp_image_url'			=> true,
		'disp_login'				=> true,
		'disp_nextprev_thumbnail'	=> false,
		'disp_resolution'			=> true,
		'disp_statistic'			=> true,
		'disp_total_images'			=> true,
		'disp_whoisonline'			=> true,
		'disp_gallery_icon'			=> true,
		'disp_new_image_count'		=> true,

		'gdlib_version'		=> 2,

		'forum_index_display'		=> 45,
		'forum_index_mode'			=> 0,
		'forum_index_personal'		=> false,
		'forum_index_random_count'	=> 4,
		'forum_index_recent_count'	=> 4,

		'hotlinking_domains'	=> 'anavaro.com',

		'items_per_page'		=> 15,
		'index_album_layout'	=> self::INDEX_ALBUM_LAYOUT_CARDS,

		'jpg_quality'			=> 100,
		'avif_quality'			=> 75,

		'link_thumbnail'		=> 'image_page',
		'link_imagepage'		=> 'image',
		'link_image_name'		=> 'image_page',
		'link_image_icon'		=> 'image_page',

		'max_filesize'			=> 512000,
		'max_height'			=> 1024,
		'max_rating'			=> 10,
		'max_width'				=> 1280,
		'medium_cache'			=> true,
		'medium_height'			=> 600,
		'medium_width'			=> 800,
		'mini_thumbnail_disp'	=> true,
		'mini_thumbnail_size'	=> 70,
		'mvc_ignore'			=> 0,
		'mvc_time'				=> 0,
		'mvc_version'			=> '',

		'newest_pega_user_id'	=> 0,
		'newest_pega_username'	=> '',
		'newest_pega_user_colour'	=> '',
		'newest_pega_album_id'	=> 0,
		'num_comments'			=> 0,
		'num_images'			=> 0,
		'num_pegas'				=> 0,
		'num_views'				=> 0,
		'num_uploads'			=> 10,

		'pegas_index_album'		=> false,
		//'pegas_index_random'	=> true,
		'pegas_index_rnd_count'	=> 4,
		//'pegas_index_recent'	=> true,
		'pegas_index_rct_count'	=> 4,
		'pegas_index_viewed_count'	=> 4,
		'pegas_index_rated_count'	=> 4,
		'profile_user_images'	=> true,
		'profile_pega'			=> true,
		'prune_orphan_time'		=> 0,

		'rrc_gindex_comments'	=> false,
		'rrc_gindex_display'	=> 173,
		'rrc_gindex_mode'		=> 7,
		'rrc_gindex_pegas'		=> true,
		'rrc_profile_display'	=> 141,
		'rrc_profile_items'	=> 4,
		'rrc_profile_mode'		=> 3,
		//'rrc_profile_pegas'		=> true,

		'search_display'		=> 45,
		'storage_layout'		=> 'flat',
		'storage_migration_source'	=> '',
		'storage_migration_target'	=> '',
		'storage_provider'		=> 'local',

		//'thumbnail_cache'		=> true,
		'thumbnail_height'		=> 160,
		//'thumbnail_infoline'	=> false,
		'thumbnail_quality'		=> 50,
		'thumbnail_width'		=> 240,

		'viewtopic_icon'		=> true,
		'viewtopic_images'		=> true,
		'viewtopic_link'		=> false,

		'watermark_changed'		=> 0,
		'watermark_enabled'		=> true,
		'watermark_height'		=> 50,
		'watermark_position'	=> 20,
		'watermark_source'		=> 'gallery/images/watermark.png',
		'watermark_width'		=> 200,

		'version'				=> '',
	];

	/**
	 * Constructor
	 * @param \phpbb\config\config $config
	 */
	public function __construct(\phpbb\config\config $config)
	{
		$this->config = $config;

	}

	public function get_all(): array
	{
		$config_ary = [];
		foreach ($this->configs_array as $option => $default)
		{
			if (isset($this->config['phpbb_gallery_' . $option]))
			{
				$config_ary[$option] = $this->config['phpbb_gallery_' . $option];
			}
			else
			{
				$config_ary[$option] = $default;
			}
		}
		return $config_ary;
	}

	public function get(string $key, mixed $default = null): mixed
	{
		if (isset($this->config['phpbb_gallery_' . $key]))
		{
			return $this->config['phpbb_gallery_' . $key];
		}

		return array_key_exists($key, $this->configs_array)
			? $this->configs_array[$key]
			: $default;
	}

	public function get_bbcode_tag(): string
	{
		$tag = strtolower(trim((string) $this->get('bbcode_tag')));

		return in_array($tag, ['image', 'galleryimage'], true) ? $tag : 'image';
	}

	public function get_album_bbcode_tag(): string
	{
		$tag = strtolower(trim((string) $this->get('album_bbcode_tag')));

		return in_array($tag, ['album', 'galleryalbum'], true) ? $tag : 'album';
	}

	/**
	 * Return the supported Gallery index album layouts in ACP order.
	 *
	 * @return string[]
	 */
	public static function index_album_layouts(): array
	{
		return [
			self::INDEX_ALBUM_LAYOUT_CLASSIC,
			self::INDEX_ALBUM_LAYOUT_MODERN,
			self::INDEX_ALBUM_LAYOUT_CARDS,
		];
	}

	/**
	 * Return a safe Gallery index album layout.
	 */
	public function get_index_album_layout(): string
	{
		$layout = (string) $this->get('index_album_layout');

		return in_array($layout, self::index_album_layouts(), true)
			? $layout
			: self::INDEX_ALBUM_LAYOUT_CARDS;
	}

	/**
	 * Return the configured public Gallery title or its translated default.
	 *
	 * @param \phpbb\language\language $language Language service
	 * @return string
	 */
	public function get_title(\phpbb\language\language $language): string
	{
		$title = trim(strip_tags((string) $this->get('title')));

		return $title !== ''
			? utf8_htmlspecialchars($title)
			: $language->lang('GALLERY');
	}

	public function set(string $name, mixed $value, bool $use_cache = true): void
	{
		$this->config->set('phpbb_gallery_' . $name, $value, $use_cache);
	}

	public function inc(string $name, int $value, bool $use_cache = true): void
	{
		if (!$this->config->offsetGet('phpbb_gallery_' . $name))
		{
			$this->config->set('phpbb_gallery_' . $name, 0, $use_cache);
		}
		$this->config->increment('phpbb_gallery_' . $name, (int) $value, $use_cache);
	}

	public function dec(string $name, int $value, bool $use_cache = true): void
	{
		if (!$this->config->offsetGet('phpbb_gallery_' . $name))
		{
			$this->config->set('phpbb_gallery_' . $name, 0, $use_cache);
		}
		$this->config->increment('phpbb_gallery_' . $name, (int) $value * -1, $use_cache);
	}
}
