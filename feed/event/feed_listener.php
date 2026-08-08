<?php
/**
 * phpBB Gallery - Feed Extension
 *
 * @package   phpbbgallery/feed
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\feed\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Wires the feed into the ACP and advertises it to feed readers.
 */
class feed_listener implements EventSubscriberInterface
{
	/* @var \phpbb\controller\helper */
	protected \phpbb\controller\helper $helper;

	/* @var \phpbb\language\language */
	protected \phpbb\language\language $language;

	/* @var \phpbb\request\request */
	protected \phpbb\request\request $request;

	/* @var \phpbb\template\template */
	protected \phpbb\template\template $template;

	/* @var \phpbbgallery\core\config */
	protected \phpbbgallery\core\config $gallery_config;

	/**
	 * Constructor
	 *
	 * @param \phpbb\controller\helper  $helper         Controller helper object
	 * @param \phpbb\language\language  $language       Language object
	 * @param \phpbb\request\request    $request        Request object
	 * @param \phpbb\template\template  $template       Template object
	 * @param \phpbbgallery\core\config $gallery_config Gallery config object
	 */
	public function __construct(\phpbb\controller\helper $helper, \phpbb\language\language $language,
		\phpbb\request\request $request, \phpbb\template\template $template, \phpbbgallery\core\config $gallery_config)
	{
		$this->helper = $helper;
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
		$this->gallery_config = $gallery_config;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			'core.page_header'									=> 'page_header',
			'phpbbgallery.core.acp.config.get_display_vars'		=> 'acp_config_get_display_vars',
			'phpbbgallery.core.acp.albums.default_data'			=> 'acp_albums_default_data',
			'phpbbgallery.core.acp.albums.request_data'			=> 'acp_albums_request_data',
			'phpbbgallery.core.acp.albums.send_to_template'		=> 'acp_albums_send_to_template',
		];
	}

	/**
	 * Advertise the feed so browsers and readers can discover it.
	 *
	 * @return void
	 */
	public function page_header(): void
	{
		if (!$this->gallery_config->get('feed_enable'))
		{
			return;
		}

		$this->language->add_lang('info_feed', 'phpbbgallery/feed');

		$this->template->assign_vars([
			'S_GALLERY_FEED'	=> true,
			'U_GALLERY_FEED'	=> $this->helper->route('phpbbgallery_feed'),
		]);
	}

	/**
	 * Add the feed settings to the gallery ACP configuration page.
	 *
	 * @param \phpbb\event\data $event Event object
	 * @return void
	 */
	public function acp_config_get_display_vars(\phpbb\event\data $event): void
	{
		if ($event['mode'] !== 'main')
		{
			return;
		}

		$return_ary = $event['return_ary'];

		if (!isset($return_ary['vars']['FEED_SETTINGS']))
		{
			$this->language->add_lang('info_feed', 'phpbbgallery/feed');

			$addon = ['id' => 'feed', 'name' => 'FEED', 'accent' => '#2e7d32'];
			$return_ary['vars']['FEED_SETTINGS'] = [
				'feed_enable'		=> ['lang' => 'FEED_ENABLED', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true, 'addon' => $addon],
				'feed_enable_pegas'	=> ['lang' => 'FEED_ENABLED_PEGAS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true, 'addon' => $addon],
				'feed_limit'		=> ['lang' => 'FEED_LIMIT', 'validate' => 'int:1:999', 'type' => 'text:7:3', 'explain' => true, 'addon' => $addon],
			];

			$event['return_ary'] = $return_ary;
		}
	}

	/**
	 * New albums are published in the feed by default.
	 *
	 * @param \phpbb\event\data $event Event object
	 * @return void
	 */
	public function acp_albums_default_data(\phpbb\event\data $event): void
	{
		$album_data = $event['album_data'];
		$album_data['album_feed'] = true;
		$event['album_data'] = $album_data;
	}

	/**
	 * Read the per-album feed toggle from the ACP form.
	 *
	 * @param \phpbb\event\data $event Event object
	 * @return void
	 */
	public function acp_albums_request_data(\phpbb\event\data $event): void
	{
		$album_data = $event['album_data'];
		$album_data['album_feed'] = $this->request->variable('album_feed', false);
		$event['album_data'] = $album_data;
	}

	/**
	 * Send the per-album feed toggle to the ACP form.
	 *
	 * @param \phpbb\event\data $event Event object
	 * @return void
	 */
	public function acp_albums_send_to_template(\phpbb\event\data $event): void
	{
		$this->language->add_lang('info_feed', 'phpbbgallery/feed');

		$album_data = $event['album_data'];

		$this->template->assign_vars([
			'S_ALBUM_FEED'	=> !empty($album_data['album_feed']),
		]);
		$this->template->assign_block_vars('gallery_acp_addons', [
			'ID' => 'feed',
			'NAME' => $this->language->lang('FEED'),
			'ACCENT' => '#2e7d32',
		]);
	}
}
