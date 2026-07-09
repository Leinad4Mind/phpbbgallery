<?php

/**
 *
 * Sticky Elements. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\stickyelements\includes;


use phpbb\config\db_text as config_text;

class helper
{
	/** @var config_text */
	protected $config_text;

	/**
	 * @param config_text $config_text
	 */
	public function __construct(
		config_text $config_text
	)
	{
		$this->config_text = $config_text;
	}

	/**
	 * @param int $stickyelement_id
	 * @param array $stickyelements
	 * @return bool|int
	 */
	public function find_index($stickyelement_id, array $stickyelements)
	{
		foreach ($stickyelements as $i => $stickyelement)
		{
			if ($stickyelement['id'] == $stickyelement_id)
			{
				return $i;
			}
		}

		return false;
	}

	/**
	 * @param array $stickyelement
	 * @return bool|array
	 */
	public function add_stickyelement(array $stickyelement)
	{
		$stickyelements = $this->get_stickyelements();

		if ($this->find_index($stickyelement['id'], $stickyelements) !== false)
		{
			return false;
		}

		$stickyelements[] = $stickyelement;

		$this->set_stickyelements($stickyelements);

		return $stickyelement;
	}

	/**
	 * @param int $stickyelement_id
	 * @return bool|array
	 */
	public function delete_stickyelement($stickyelement_id)
	{
		$stickyelements = $this->get_stickyelements();

		$index = $this->find_index($stickyelement_id, $stickyelements);

		if ($index === false)
		{
			return false;
		}

		$deleted_stickyelement = $stickyelements[$index];

		unset($stickyelements[$index]);

		$this->set_stickyelements($stickyelements);

		return $deleted_stickyelement;
	}

	/**
	 * @param int $stickyelement_id
	 * @return bool|array
	 */
	public function get_stickyelement($stickyelement_id)
	{
		$stickyelements = $this->get_stickyelements();

		$index = $this->find_index($stickyelement_id, $stickyelements);

		return $index === false ? false : $stickyelements[$index];
	}

	/**
	 * @return array
	 */
	public function get_stickyelements()
	{
		return array_values(@json_decode($this->config_text->get('sticky_buttons'), true)) ?: [];
	}

	/**
	 * @param array $stickyelement
	 * @return bool|array
	 */
	public function set_stickyelement(array $stickyelement)
	{
		$stickyelements = $this->get_stickyelements();

		$index = $this->find_index($stickyelement['id'], $stickyelements);

		if ($index === false)
		{
			return false;
		}

		$stickyelements[$index] = $stickyelement;

		$this->set_stickyelements($stickyelements);

		return $stickyelement;
	}

	/**
	 * @param array $stickyelements
	 */
	public function set_stickyelements(array $stickyelements)
	{
		$this->config_text->set('sticky_buttons', @json_encode(array_values($stickyelements) ?: []));
	}

	/**
	 * @param int $stickyelement_id
	 * @param int $offset
	 * @return bool|array
	 */
	public function move_stickyelement($stickyelement_id, $offset)
	{
		$stickyelements = $this->get_stickyelements();

		$index = $this->find_index($stickyelement_id, $stickyelements);

		if ($index === false)
		{
			return false;
		}

		$stickyelement = $stickyelements[$index];

		$temp = array_splice($stickyelements, $index, 1);

		array_splice($stickyelements, max(0, $index + $offset), 0, $temp);

		$this->set_stickyelements($stickyelements);

		return $stickyelement;
	}

	/**
	 * @return int
	 */
	public function get_next_stickyelement_id()
	{
		$stickyelements = $this->get_stickyelements();

		$next_id = 0;

		foreach ($stickyelements as $stickyelement)
		{
			$next_id = max($stickyelement['id'], $next_id);
		}

		return $next_id + 1;
	}

	/**
	 * @return string
	 */
	public static function get_empty_stickyelements()
	{
		return json_encode([]);
	}
}
