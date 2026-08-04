<?php
/**
 * phpBB Gallery - recoverable image deletion requests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;
use phpbbgallery\core\block;

class image_deletion_requests extends migration
{
	public static function depends_on(): array
	{
		return ['\\phpbbgallery\\core\\migrations\\contest_creation'];
	}

	public function update_schema(): array
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'gallery_images' => [
					'image_delete_previous_status' => ['UINT:3', block::STATUS_APPROVED],
					'image_delete_request_user_id' => ['UINT:10', 0],
					'image_delete_request_time' => ['UINT:11', 0],
				],
			],
			'add_index' => [
				$this->table_prefix . 'gallery_images' => [
					'delete_status_time' => ['image_status', 'image_delete_request_time'],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_keys' => [
				$this->table_prefix . 'gallery_images' => [
					'delete_status_time',
				],
			],
			'drop_columns' => [
				$this->table_prefix . 'gallery_images' => [
					'image_delete_previous_status',
					'image_delete_request_user_id',
					'image_delete_request_time',
				],
			],
		];
	}

	public function revert_data(): array
	{
		return [
			['custom', [[$this, 'restore_pending_images']]],
		];
	}

	public function restore_pending_images(): void
	{
		$sql = 'UPDATE ' . $this->table_prefix . 'gallery_images
			SET image_status = image_delete_previous_status
			WHERE image_status = ' . (int) block::STATUS_DELETE_REQUESTED;
		$this->db->sql_query($sql);
	}
}
