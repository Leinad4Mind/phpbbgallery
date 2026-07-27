<?php
/**
 * BBTags provider-independent tag suggestion moderation.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\tags;

use phpbb\db\driver\driver_interface;
use sitesplat\bbtags\provider\provider_registry;

class moderation
{
	public const STATUS_PENDING = 'pending';
	public const STATUS_APPROVED = 'approved';
	public const STATUS_REJECTED = 'rejected';
	public const STATUS_CANCELLED = 'cancelled';

	private driver_interface $db;
	private provider_registry $providers;
	private manager $manager;
	private string $table_suggestions;

	public function __construct(
		driver_interface $db,
		provider_registry $providers,
		manager $manager,
		string $table_suggestions
	)
	{
		$this->db = $db;
		$this->providers = $providers;
		$this->manager = $manager;
		$this->table_suggestions = $table_suggestions;
	}

	/**
	 * Store one invisible suggestion after the provider validates its subject.
	 *
	 * @return int|false Existing or newly-created suggestion identifier
	 */
	public function suggest(
		string $tag,
		string $provider,
		int $scope_id,
		int $item_id,
		int $user_id
	): int|false
	{
		$tag = $this->manager->clean_tag($tag);
		$tag_clean = $this->manager->canonical_tag($tag);
		$provider = $this->normalize_provider($provider);
		$scope_id = max(0, $scope_id);
		$item_id = max(0, $item_id);
		$user_id = max(0, $user_id);
		if ($tag === '' || $tag_clean === '' || $provider === '' || $item_id === 0 || $user_id === 0)
		{
			return false;
		}
		if (!$this->provider_accepts_subject($provider, $scope_id, $item_id))
		{
			return false;
		}

		$dedupe_key = $this->pending_key($provider, $scope_id, $item_id, $tag_clean);
		$sql = 'SELECT suggestion_id
			FROM ' . $this->table_suggestions . "
			WHERE dedupe_key = '" . $this->db->sql_escape($dedupe_key) . "'";
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if ($row)
		{
			return (int) $row['suggestion_id'];
		}

		$tag_id = 0;
		$existing = $this->manager->get_existing_tags([$tag]);
		if (!empty($existing))
		{
			$tag_id = (int) $existing[0]['id'];
		}
		$sql_ary = [
			'tag_id'       => $tag_id,
			'tag'          => $tag,
			'tag_clean'    => $tag_clean,
			'provider'     => $provider,
			'scope_id'     => $scope_id,
			'item_id'      => $item_id,
			'suggested_by' => $user_id,
			'suggested_at' => time(),
			'status'       => self::STATUS_PENDING,
			'reviewed_by'  => 0,
			'reviewed_at'  => 0,
			'dedupe_key'   => $dedupe_key,
		];
		$sql = 'INSERT INTO ' . $this->table_suggestions . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
		if ($this->db->sql_query($sql) === false)
		{
			return false;
		}

		return (int) $this->db->sql_nextid();
	}

	/**
	 * Replace the current user's pending suggestions for one provider item.
	 */
	public function sync_item_suggestions(
		array $tags,
		string $provider,
		int $scope_id,
		int $item_id,
		int $user_id
	): bool
	{
		$provider = $this->normalize_provider($provider);
		if ($provider === '' || $item_id <= 0 || $user_id <= 0)
		{
			return false;
		}

		$wanted = [];
		foreach ($tags as $tag)
		{
			$tag = $this->manager->clean_tag($tag);
			$tag_clean = $this->manager->canonical_tag($tag);
			if ($tag !== '' && $tag_clean !== '')
			{
				$wanted[$tag_clean] = $tag;
			}
		}

		$sql = 'SELECT suggestion_id, tag_clean
			FROM ' . $this->table_suggestions . "
			WHERE provider = '" . $this->db->sql_escape($provider) . "'
				AND item_id = " . (int) $item_id . "
				AND status = '" . self::STATUS_PENDING . "'";
		$result = $this->db->sql_query($sql);
		$cancel_ids = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			if (!isset($wanted[$row['tag_clean']]))
			{
				$cancel_ids[] = (int) $row['suggestion_id'];
			}
		}
		$this->db->sql_freeresult($result);
		foreach ($cancel_ids as $suggestion_id)
		{
			if (!$this->set_status($suggestion_id, self::STATUS_CANCELLED, 0))
			{
				return false;
			}
		}

		foreach ($wanted as $tag)
		{
			if ($this->suggest($tag, $provider, $scope_id, $item_id, $user_id) === false)
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Return pending tag labels so an interrupted edit can display them again.
	 */
	public function get_item_pending_tags(string $provider, int $item_id): array
	{
		$provider = $this->normalize_provider($provider);
		if ($provider === '' || $item_id <= 0)
		{
			return [];
		}

		$sql = 'SELECT tag
			FROM ' . $this->table_suggestions . "
			WHERE provider = '" . $this->db->sql_escape($provider) . "'
				AND item_id = " . (int) $item_id . "
				AND status = '" . self::STATUS_PENDING . "'
			ORDER BY suggested_at ASC, suggestion_id ASC";
		$result = $this->db->sql_query($sql);
		$tags = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$tags[] = (string) $row['tag'];
		}
		$this->db->sql_freeresult($result);

		return $tags;
	}

	public function get_pending_suggestions(int $start = 0, int $limit = 50): array
	{
		$sql = 'SELECT *
			FROM ' . $this->table_suggestions . "
			WHERE status = '" . self::STATUS_PENDING . "'
			ORDER BY suggested_at ASC, suggestion_id ASC";
		$result = $this->db->sql_query_limit($sql, max(1, min(100, $limit)), max(0, $start));
		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		return $rows;
	}

	public function count_pending_suggestions(): int
	{
		$sql = 'SELECT COUNT(suggestion_id) AS total
			FROM ' . $this->table_suggestions . "
			WHERE status = '" . self::STATUS_PENDING . "'";
		$result = $this->db->sql_query($sql);
		$total = (int) $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);

		return $total;
	}

	/**
	 * Approve a suggestion atomically and let its provider attach the tag.
	 */
	public function approve(int $suggestion_id, int $reviewer_id): bool
	{
		$suggestion = $this->get_pending_suggestion($suggestion_id);
		if (!$suggestion || $reviewer_id <= 0)
		{
			return false;
		}
		$provider = (string) $suggestion['provider'];
		$scope_id = (int) $suggestion['scope_id'];
		$item_id = (int) $suggestion['item_id'];
		if (!$this->provider_accepts_subject($provider, $scope_id, $item_id))
		{
			return false;
		}

		$this->db->sql_transaction('begin');
		try
		{
			$tag_id = $this->manager->ensure_catalog_tag((string) $suggestion['tag'], (int) $suggestion['suggested_by']);
			if ($tag_id === false
				|| !$this->manager->ensure_provider_context($tag_id, $provider, 'restricted')
				|| !$this->manager->set_scope_rule($tag_id, $provider, $scope_id, 'allow')
				|| !$this->provider_applies_approval($provider, $scope_id, $item_id, $tag_id)
				|| !$this->set_status($suggestion_id, self::STATUS_APPROVED, $reviewer_id, $tag_id))
			{
				$this->db->sql_transaction('rollback');
				return false;
			}
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}

		$this->db->sql_transaction('commit');
		return true;
	}

	public function reject(int $suggestion_id, int $reviewer_id): bool
	{
		if ($reviewer_id <= 0 || !$this->get_pending_suggestion($suggestion_id))
		{
			return false;
		}

		return $this->set_status($suggestion_id, self::STATUS_REJECTED, $reviewer_id);
	}

	/**
	 * Cancel pending suggestions whose provider items were deleted.
	 */
	public function cancel_items(string $provider, array $item_ids): bool
	{
		$provider = $this->normalize_provider($provider);
		$item_ids = array_values(array_unique(array_filter(array_map('intval', $item_ids))));
		if ($provider === '' || empty($item_ids))
		{
			return true;
		}

		$sql = 'SELECT suggestion_id
			FROM ' . $this->table_suggestions . "
			WHERE provider = '" . $this->db->sql_escape($provider) . "'
				AND " . $this->db->sql_in_set('item_id', $item_ids) . "
				AND status = '" . self::STATUS_PENDING . "'";
		$result = $this->db->sql_query($sql);
		$ids = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ids[] = (int) $row['suggestion_id'];
		}
		$this->db->sql_freeresult($result);

		foreach ($ids as $suggestion_id)
		{
			if (!$this->set_status($suggestion_id, self::STATUS_CANCELLED, 0))
			{
				return false;
			}
		}

		return true;
	}

	private function get_pending_suggestion(int $suggestion_id): array|false
	{
		if ($suggestion_id <= 0)
		{
			return false;
		}
		$sql = 'SELECT *
			FROM ' . $this->table_suggestions . '
			WHERE suggestion_id = ' . $suggestion_id . "
				AND status = '" . self::STATUS_PENDING . "'";
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $row ?: false;
	}

	private function set_status(int $suggestion_id, string $status, int $reviewer_id, int $tag_id = 0): bool
	{
		if (!in_array($status, [self::STATUS_APPROVED, self::STATUS_REJECTED, self::STATUS_CANCELLED], true))
		{
			return false;
		}
		$sql_ary = [
			'status'      => $status,
			'reviewed_by' => max(0, $reviewer_id),
			'reviewed_at' => time(),
			'dedupe_key'  => 'resolved-' . $suggestion_id,
		];
		if ($tag_id > 0)
		{
			$sql_ary['tag_id'] = $tag_id;
		}
		$sql = 'UPDATE ' . $this->table_suggestions . '
			SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE suggestion_id = ' . $suggestion_id . "
				AND status = '" . self::STATUS_PENDING . "'";

		if ($this->db->sql_query($sql) === false)
		{
			return false;
		}

		return $this->db->sql_affectedrows() === 1;
	}

	private function provider_accepts_subject(string $provider, int $scope_id, int $item_id): bool
	{
		$provider_service = $this->providers->get($provider);

		return $provider_service !== null && $provider_service->validate_subject($scope_id, $item_id);
	}

	private function provider_applies_approval(string $provider, int $scope_id, int $item_id, int $tag_id): bool
	{
		$provider_service = $this->providers->get($provider);

		return $provider_service !== null && $provider_service->apply_approved_tag($scope_id, $item_id, $tag_id);
	}

	private function normalize_provider(string $provider): string
	{
		return preg_match('/^[a-z][a-z0-9_]{1,31}$/D', $provider) ? $provider : '';
	}

	private function pending_key(string $provider, int $scope_id, int $item_id, string $tag_clean): string
	{
		return hash('sha256', $provider . ':' . $scope_id . ':' . $item_id . ':' . $tag_clean);
	}
}
