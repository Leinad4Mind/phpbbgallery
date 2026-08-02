<?php
/**
 * phpBB Gallery image-visibility policy boundary.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\policy;

/**
 * Combines privacy restrictions supplied by optional Gallery add-ons.
 */
class image_visibility
{
	private \phpbb\event\dispatcher_interface $dispatcher;

	public function __construct(\phpbb\event\dispatcher_interface $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}

	public function hides_private_data(array $image_data, int $viewer_id, bool $can_moderate): bool
	{
		$hidden = false;
		$vars = ['image_data', 'viewer_id', 'can_moderate', 'hidden'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.image_visibility.private_data',
			compact($vars)
		));

		return (bool) $hidden;
	}

	public function hides_results(array $image_data, bool $can_moderate): bool
	{
		$hidden = false;
		$vars = ['image_data', 'can_moderate', 'hidden'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.image_visibility.results',
			compact($vars)
		));

		return (bool) $hidden;
	}

	public function private_data_sql(string $alias, int $viewer_id, array $moderated_album_ids): string
	{
		$this->validate_alias($alias);
		$conditions = [];
		$vars = ['alias', 'viewer_id', 'moderated_album_ids', 'conditions'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.image_visibility.private_data_sql',
			compact($vars)
		));

		return $this->combine_conditions((array) $conditions);
	}

	public function results_sql(string $alias, array $moderated_album_ids): string
	{
		$this->validate_alias($alias);
		$conditions = [];
		$vars = ['alias', 'moderated_album_ids', 'conditions'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.image_visibility.results_sql',
			compact($vars)
		));

		return $this->combine_conditions((array) $conditions);
	}

	private function validate_alias(string $alias): void
	{
		if ($alias !== '' && !preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $alias))
		{
			throw new \InvalidArgumentException('Invalid SQL alias.');
		}
	}

	private function combine_conditions(array $conditions): string
	{
		$conditions = array_values(array_filter(
			array_map('strval', $conditions),
			static fn(string $condition): bool => $condition !== ''
		));

		return $conditions ? '(' . implode(') AND (', $conditions) . ')' : '1 = 1';
	}
}
