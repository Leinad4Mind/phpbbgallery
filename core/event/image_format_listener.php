<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/** Register Core image formats which use browser-safe derivatives. */
final class image_format_listener implements EventSubscriberInterface
{
	private \phpbbgallery\core\config $config;
	private \phpbb\language\language $language;

	public function __construct(\phpbbgallery\core\config $config, \phpbb\language\language $language)
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
		if (!\phpbbgallery\core\image\bmp_processor::is_supported())
		{
			return;
		}

		$upload_enabled = (bool) $this->config->get('allow_bmp');
		if ($upload_enabled)
		{
			$this->language->add_lang('gallery', 'phpbbgallery/core');
		}
		$formats = $event['formats'];
		$formats['bmp'] = [
			'service' => 'phpbbgallery.core.image.bmp_processor',
			'mime' => 'image/bmp',
			'label' => 'FILETYPES_BMP',
			'upload' => $upload_enabled,
		];
		$event['formats'] = $formats;
	}
}
