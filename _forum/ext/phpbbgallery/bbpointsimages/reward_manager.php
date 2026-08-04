<?php
/**
 * phpBB Gallery - BBPoints image rewards
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages;

use phpbb\db\driver\driver_interface;
use sitesplat\bbpoints\core\ledger;

/**
 * Award each approved original once and move its reward with its authorship.
 */
final class reward_manager
{
	public function __construct(
		private driver_interface $db,
		private policy $policy,
		private ledger $ledger,
		private string $rewards_table,
		private string $stats_table
	)
	{
	}

	public function reward(array $image_data, string $source_path): bool
	{
		$image_id = (int) ($image_data['image_id'] ?? 0);
		$album_id = (int) ($image_data['image_album_id'] ?? 0);
		$user_id = (int) ($image_data['image_user_id'] ?? 0);
		$status = (int) ($image_data['image_status'] ?? -1);
		if ($image_id < 1 || $album_id < 1 || !$this->is_registered_user($user_id)
			|| $status !== \phpbbgallery\core\block::STATUS_APPROVED || !is_file($source_path))
		{
			return false;
		}

		$source_hash = hash_file('sha256', $source_path);
		if (!is_string($source_hash) || strlen($source_hash) !== 64)
		{
			return false;
		}
		$this->store_source_hash($image_id, $source_hash);

		$existing = $this->find_reward_by_image($image_id);
		if ($existing)
		{
			return $this->complete_reserved_reward($existing);
		}
		if ($this->find_reward_by_hash($source_hash))
		{
			return false;
		}

		$amount = (int) $this->policy->resolve($album_id)['upload_reward'];
		if ($amount <= 0)
		{
			return false;
		}

		$operation_key = 'gallery:image:' . $image_id . ':reward';
		$reward = [
			'image_id'           => $image_id,
			'user_id'            => $user_id,
			'amount'             => $amount,
			'operation_key'      => $operation_key,
			'reward_time'        => time(),
			'source_sha256'      => $source_hash,
			'reassignment_count' => 0,
		];
		if (!$this->insert_safely($this->rewards_table, $reward))
		{
			$existing = $this->find_reward_by_image($image_id);
			if (!$existing)
			{
				return false;
			}
			$reward = $existing;
		}

		return $this->complete_reserved_reward($reward);
	}

	public function reassign(array $image_ids, int $new_user_id): int
	{
		$image_ids = array_values(array_unique(array_filter(
			array_map('intval', $image_ids),
			static fn (int $image_id): bool => $image_id > 0
		)));
		if (!$image_ids || !$this->is_registered_user($new_user_id))
		{
			return 0;
		}

		$sql = 'SELECT image_id, user_id, amount, operation_key, reassignment_count
			FROM ' . $this->rewards_table . '
			WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
		$result = $this->db->sql_query($sql);
		$changed = 0;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$old_user_id = (int) $row['user_id'];
			if ($old_user_id === $new_user_id)
			{
				continue;
			}
			$image_id = (int) $row['image_id'];
			$next_count = (int) $row['reassignment_count'] + 1;
			$this->ledger->credit(
				$old_user_id,
				(int) $row['amount'],
				'Gallery image upload reward',
				(string) $row['operation_key']
			);
			$this->ledger->transfer(
				$old_user_id,
				$new_user_id,
				(int) $row['amount'],
				'Gallery image reward reassigned',
				'gallery:image:' . $image_id . ':reward:reassign:' . $next_count,
				true
			);
			$sql = 'UPDATE ' . $this->rewards_table . '
				SET user_id = ' . (int) $new_user_id . ', reassignment_count = ' . (int) $next_count . '
				WHERE image_id = ' . (int) $image_id . '
					AND user_id = ' . (int) $old_user_id . '
					AND reassignment_count = ' . (int) ($next_count - 1);
			$this->db->sql_query($sql);
			$changed += (int) $this->db->sql_affectedrows();
		}
		$this->db->sql_freeresult($result);

		return $changed;
	}

	public function get_reward(int $image_id): array|false
	{
		return $image_id > 0 ? $this->find_reward_by_image($image_id) : false;
	}

	private function complete_reserved_reward(array $reward): bool
	{
		$operation = $this->ledger->credit(
			(int) $reward['user_id'],
			(int) $reward['amount'],
			'Gallery image upload reward',
			(string) $reward['operation_key']
		);
		return $operation->was_created();
	}

	private function store_source_hash(int $image_id, string $source_hash): void
	{
		$sql = 'UPDATE ' . $this->stats_table . "
			SET source_sha256 = '" . $this->db->sql_escape($source_hash) . "'
			WHERE image_id = " . (int) $image_id;
		$this->db->sql_query($sql);
		if ((int) $this->db->sql_affectedrows() > 0)
		{
			return;
		}

		$this->insert_safely($this->stats_table, [
			'image_id'       => $image_id,
			'source_sha256'  => $source_hash,
			'download_count' => 0,
		]);
	}

	private function find_reward_by_image(int $image_id): array|false
	{
		return $this->find_reward('image_id = ' . (int) $image_id);
	}

	private function find_reward_by_hash(string $source_hash): array|false
	{
		return $this->find_reward("source_sha256 = '" . $this->db->sql_escape($source_hash) . "'");
	}

	private function find_reward(string $where): array|false
	{
		$sql = 'SELECT image_id, user_id, amount, operation_key, reward_time,
				source_sha256, reassignment_count
			FROM ' . $this->rewards_table . '
			WHERE ' . $where;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return $row;
	}

	private function insert_safely(string $table, array $data): bool
	{
		$sql = 'INSERT INTO ' . $table . ' ' . $this->db->sql_build_array('INSERT', $data);
		$this->db->sql_return_on_error(true);
		$this->db->sql_query($sql);
		$failed = $this->db->get_sql_error_triggered();
		$this->db->sql_return_on_error(false);
		return !$failed;
	}

	private function is_registered_user(int $user_id): bool
	{
		$anonymous = defined('ANONYMOUS') ? (int) ANONYMOUS : 1;
		return $user_id > $anonymous;
	}
}
