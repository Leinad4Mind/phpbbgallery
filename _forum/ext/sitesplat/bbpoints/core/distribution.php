<?php
/**
 *
 * BBPoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015-2026 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbpoints\core;

/**
 * Immutable result of an atomic BBPoints distribution.
 */
final class distribution
{
	/**
	 * @param operation[] $operations
	 */
	public function __construct(
		private string $operation_key,
		private int $from_user_id,
		private int $amount,
		private array $operations,
		private int $timestamp,
		private bool $created
	)
	{
	}

	public function get_operation_key(): string
	{
		return $this->operation_key;
	}

	public function get_from_user_id(): int
	{
		return $this->from_user_id;
	}

	public function get_amount(): int
	{
		return $this->amount;
	}

	/**
	 * @return operation[]
	 */
	public function get_operations(): array
	{
		return $this->operations;
	}

	public function get_timestamp(): int
	{
		return $this->timestamp;
	}

	public function was_created(): bool
	{
		return $this->created;
	}
}
