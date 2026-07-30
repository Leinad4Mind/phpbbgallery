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
 * Immutable result of a BBPoints ledger operation.
 */
final class operation
{
	public function __construct(
		private int $id,
		private int $from_user_id,
		private int $to_user_id,
		private int $amount,
		private string $reason,
		private string $operation_key,
		private int $timestamp,
		private bool $created
	)
	{
	}

	public function get_id(): int
	{
		return $this->id;
	}

	public function get_from_user_id(): int
	{
		return $this->from_user_id;
	}

	public function get_to_user_id(): int
	{
		return $this->to_user_id;
	}

	public function get_amount(): int
	{
		return $this->amount;
	}

	public function get_reason(): string
	{
		return $this->reason;
	}

	public function get_operation_key(): string
	{
		return $this->operation_key;
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
