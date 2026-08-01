<?php
/**
 * BBPoints Images purchase database test double
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

final class purchase_fake_db implements \phpbb\db\driver\driver_interface
{
	public array $policy_rows = [];
	public array $contributors = [];
	public array $purchases = [];
	public array $stats = [];
	private array $pending = [];
	private array $built = [];
	private int $affected = 0;
	private bool $error = false;

	public function sql_query(string $sql): string|false
	{
		$this->pending = [];
		$this->affected = 0;
		if (str_contains($sql, ' current_album'))
		{
			$this->pending = $this->policy_rows;
		}
		else if (preg_match('/FROM contributors\s+WHERE image_id = (\d+)/s', $sql, $matches))
		{
			foreach ($this->contributors[(int) $matches[1]] ?? [] as $user_id)
			{
				$this->pending[] = ['user_id' => $user_id];
			}
		}
		else if (preg_match('/FROM purchases\s+WHERE image_id = (\d+)\s+AND buyer_id = (\d+)/s', $sql, $matches))
		{
			$key = $matches[1] . ':' . $matches[2];
			if (isset($this->purchases[$key]))
			{
				$this->pending[] = $this->purchases[$key];
			}
		}
		else if (preg_match('/FROM stats\s+WHERE image_id = (\d+)/s', $sql, $matches))
		{
			$image_id = (int) $matches[1];
			if (isset($this->stats[$image_id]))
			{
				$this->pending[] = $this->stats[$image_id];
			}
		}
		else if (str_starts_with($sql, 'UPDATE stats'))
		{
			preg_match('/image_id = (\d+)/', $sql, $matches);
			$image_id = (int) ($matches[1] ?? 0);
			if (isset($this->stats[$image_id]))
			{
				$this->stats[$image_id]['download_count']++;
				$this->affected = 1;
			}
		}
		else if (str_starts_with($sql, 'UPDATE purchases'))
		{
			preg_match('/image_id = (\d+)\s+AND buyer_id = (\d+)/s', $sql, $matches);
			$key = ($matches[1] ?? 0) . ':' . ($matches[2] ?? 0);
			if (isset($this->purchases[$key]))
			{
				$this->purchases[$key]['download_count']++;
				$this->purchases[$key]['last_download_time'] = time();
				$this->affected = 1;
			}
		}
		else if (str_starts_with($sql, 'INSERT INTO purchases'))
		{
			$key = $this->built['image_id'] . ':' . $this->built['buyer_id'];
			if (isset($this->purchases[$key]))
			{
				$this->error = true;
				return false;
			}
			$this->purchases[$key] = $this->built;
			$this->affected = 1;
		}
		else if (str_starts_with($sql, 'INSERT INTO stats'))
		{
			$image_id = (int) $this->built['image_id'];
			if (isset($this->stats[$image_id]))
			{
				$this->error = true;
				return false;
			}
			$this->stats[$image_id] = $this->built;
			$this->affected = 1;
		}
		return 'result';
	}

	public function sql_build_array(string $query, array $data): string
	{
		$this->built = $data;
		return 'VALUES (test)';
	}

	public function sql_fetchrow(string $result): array|false
	{
		return array_shift($this->pending) ?? false;
	}

	public function sql_freeresult(string $result): void
	{
		$this->pending = [];
	}

	public function sql_affectedrows(): int
	{
		return $this->affected;
	}

	public function sql_return_on_error(bool $enabled): void
	{
		if ($enabled)
		{
			$this->error = false;
		}
	}

	public function get_sql_error_triggered(): bool
	{
		return $this->error;
	}
}
