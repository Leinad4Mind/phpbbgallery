<?php
/**
 * phpBB Gallery - BBPoints image lifecycle listener
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\event;

use phpbb\event\data;
use phpbbgallery\bbpointsimages\reward_manager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class main_listener implements EventSubscriberInterface
{
	public function __construct(private reward_manager $rewards)
	{
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.upload.update_image_after' => 'uploaded',
			'phpbbgallery.core.image.approve_after' => 'approved',
			'phpbbgallery.core.image.change_author_after' => 'author_changed',
			'phpbbgallery.acpimport.insert_image_after' => 'imported',
		];
	}

	public function uploaded(data $event): void
	{
		$this->rewards->reward((array) $event['image_data'], (string) $event['file_link']);
	}

	public function approved(data $event): void
	{
		foreach ((array) $event['approved_images'] as $image_data)
		{
			$this->rewards->reward((array) $image_data, (string) $image_data['source_path']);
		}
	}

	public function imported(data $event): void
	{
		$this->rewards->reward((array) $event['image_data'], (string) $event['file_link']);
	}

	public function author_changed(data $event): void
	{
		$author = (array) $event['author'];
		$this->rewards->reassign((array) $event['image_ids'], (int) ($author['user_id'] ?? 0));
	}
}
