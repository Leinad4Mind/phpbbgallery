<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\auth;

class set
{
	protected int $bits = 0;

	protected array $counts = [
		'i_count'	=> 0,
		'a_count'	=> 0,
	];

	public function __construct(int $bits = 0, int $i_count = 0, int $a_count = 0)
	{
		$this->bits = $bits;

		$this->counts = [
			'i_count'	=> $i_count,
			'a_count'	=> $a_count,
		];
	}

	public function set_bit(int $bit, bool $set): void
	{
		$this->bits = phpbb_optionset($bit, $set, $this->bits);
	}

	public function get_bit(int $bit): bool
	{
		return phpbb_optionget($bit, $this->bits);
	}

	public function get_bits(): int
	{
		return $this->bits;
	}

	public function set_count(string $data, int $set): void
	{
		$this->counts[$data] = (int) $set;
	}

	public function get_count(string $data): int
	{
		return (int) $this->counts[$data];
	}
}
