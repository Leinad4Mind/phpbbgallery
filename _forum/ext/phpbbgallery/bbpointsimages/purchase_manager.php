<?php
/**
 * phpBB Gallery - BBPoints original-source purchases
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages;

use phpbb\db\driver\driver_interface;
use sitesplat\bbpoints\core\ledger;

/**
 * Authorize permanent source access and distribute each purchase atomically.
 */
final class purchase_manager
{
	public function __construct(
		private driver_interface $db,
		private policy $policy,
		private ledger $ledger,
		private string $contributors_table,
		private string $purchases_table,
		private string $stats_table
	)
	{
	}

	/**
	 * @return array{cost: int, contributors: int[], complimentary: bool, purchased: bool, requires_purchase: bool}
	 */
	public function quote(array $image_data, int $buyer_id): array
	{
		$image_id = (int) ($image_data['image_id'] ?? 0);
		$album_id = (int) ($image_data['image_album_id'] ?? $image_data['album_id'] ?? 0);
		$author_id = (int) ($image_data['image_user_id'] ?? 0);
		if ($image_id < 1 || $album_id < 1)
		{
			throw new \OutOfBoundsException('A valid Gallery image is required.');
		}

		$cost = (int) $this->policy->resolve($album_id)['source_cost'];
		$contributors = $this->load_contributors($image_id, $author_id);
		$complimentary = $cost === 0
			|| ($this->is_registered_user($buyer_id) && $buyer_id === $author_id)
			|| in_array($buyer_id, $contributors, true);
		$purchased = $this->is_registered_user($buyer_id) && $this->find_purchase($image_id, $buyer_id) !== false;

		return [
			'cost' => $cost,
			'contributors' => $contributors,
			'complimentary' => $complimentary,
			'purchased' => $purchased,
			'requires_purchase' => !$complimentary && !$purchased,
		];
	}

	public function purchase(array $image_data, int $buyer_id): bool
	{
		if (!$this->is_registered_user($buyer_id))
		{
			throw new \InvalidArgumentException('A registered Gallery member is required.');
		}

		$quote = $this->quote($image_data, $buyer_id);
		if (!$quote['requires_purchase'])
		{
			return false;
		}

		$image_id = (int) $image_data['image_id'];
		$author_id = (int) $image_data['image_user_id'];
		$recipients = $this->split_recipients($author_id, $quote['contributors'], $quote['cost']);
		if (!$recipients)
		{
			throw new \RuntimeException('The image has no registered BBPoints beneficiary.');
		}

		$operation_key = 'gallery:image:' . $image_id . ':source:buyer:' . $buyer_id;
		$this->ledger->distribute(
			$buyer_id,
			$recipients,
			'Gallery original source purchase',
			$operation_key
		);

		$purchase = [
			'image_id' => $image_id,
			'buyer_id' => $buyer_id,
			'amount' => $quote['cost'],
			'operation_key' => $operation_key,
			'purchase_time' => time(),
			'last_download_time' => 0,
			'download_count' => 0,
		];
		if (!$this->insert_safely($this->purchases_table, $purchase)
			&& $this->find_purchase($image_id, $buyer_id) === false)
		{
			throw new \RuntimeException('The Gallery source purchase could not be recorded.');
		}

		return true;
	}

	public function record_download(int $image_id, int $buyer_id): void
	{
		if ($image_id < 1)
		{
			return;
		}

		$sql = 'UPDATE ' . $this->stats_table . '
			SET download_count = download_count + 1
			WHERE image_id = ' . $image_id;
		$this->db->sql_query($sql);
		if ((int) $this->db->sql_affectedrows() === 0)
		{
			$inserted = $this->insert_safely($this->stats_table, [
				'image_id' => $image_id,
				'source_sha256' => '',
				'download_count' => 1,
			]);
			if (!$inserted)
			{
				$this->db->sql_query($sql);
			}
		}

		if ($this->is_registered_user($buyer_id))
		{
			$sql = 'UPDATE ' . $this->purchases_table . '
				SET last_download_time = ' . time() . ', download_count = download_count + 1
				WHERE image_id = ' . $image_id . '
					AND buyer_id = ' . $buyer_id;
			$this->db->sql_query($sql);
		}
	}

	public function get_download_count(int $image_id): int
	{
		if ($image_id < 1)
		{
			return 0;
		}
		$sql = 'SELECT download_count
			FROM ' . $this->stats_table . '
			WHERE image_id = ' . $image_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return max(0, (int) ($row['download_count'] ?? 0));
	}

	/** @return int[] */
	private function load_contributors(int $image_id, int $author_id): array
	{
		$sql = 'SELECT user_id
			FROM ' . $this->contributors_table . '
			WHERE image_id = ' . $image_id . '
			ORDER BY contributor_order ASC, user_id ASC';
		$result = $this->db->sql_query($sql);
		$contributors = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_id = (int) $row['user_id'];
			if ($user_id !== $author_id && $this->is_registered_user($user_id))
			{
				$contributors[$user_id] = $user_id;
			}
		}
		$this->db->sql_freeresult($result);
		return array_values($contributors);
	}

	/**
	 * @param int[] $contributors
	 * @return array<int, int>
	 */
	private function split_recipients(int $author_id, array $contributors, int $cost): array
	{
		$beneficiaries = $this->is_registered_user($author_id) ? [$author_id] : [];
		$beneficiaries = array_values(array_unique([...$beneficiaries, ...$contributors]));
		if (!$beneficiaries || $cost < 1)
		{
			return [];
		}

		$share = intdiv($cost, count($beneficiaries));
		$remainder_recipient = in_array($author_id, $beneficiaries, true) ? $author_id : $beneficiaries[0];
		$recipients = [];
		foreach ($beneficiaries as $user_id)
		{
			$amount = $share + ($user_id === $remainder_recipient ? $cost - ($share * count($beneficiaries)) : 0);
			if ($amount > 0)
			{
				$recipients[$user_id] = $amount;
			}
		}
		return $recipients;
	}

	private function find_purchase(int $image_id, int $buyer_id): array|false
	{
		$sql = 'SELECT image_id, buyer_id, amount, operation_key, purchase_time,
				last_download_time, download_count
			FROM ' . $this->purchases_table . '
			WHERE image_id = ' . $image_id . '
				AND buyer_id = ' . $buyer_id;
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
