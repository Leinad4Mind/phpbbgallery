<?php
/**
 * phpBB Gallery - TIFF Extension
 *
 * @package   phpbbgallery/tiff
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\tiff\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class listener implements EventSubscriberInterface
{
	private \phpbb\config\config $config;
	private \phpbb\language\language $language;

	public function __construct(\phpbb\config\config $config, \phpbb\language\language $language)
	{
		$this->config = $config;
		$this->language = $language;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.image_format.collect' => 'register_formats',
		];
	}

	public function register_formats(\phpbb\event\data $event): void
	{
		if (!\phpbbgallery\tiff\processor::is_supported())
		{
			return;
		}
		$upload_enabled = !empty($this->config['phpbb_gallery_tiff_enabled']);
		if ($upload_enabled)
		{
			$this->language->add_lang('tiff', 'phpbbgallery/tiff');
		}
		$formats = $event['formats'];
		foreach (['tif', 'tiff'] as $extension)
		{
			$formats[$extension] = [
				'service' => 'phpbbgallery.tiff.processor',
				'mime' => 'image/tiff',
				'label' => 'FILETYPES_TIFF',
				'upload' => $upload_enabled,
			];
		}
		$event['formats'] = $formats;
	}
}
