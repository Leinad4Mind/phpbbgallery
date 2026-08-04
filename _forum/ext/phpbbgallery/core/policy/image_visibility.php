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
		$covered_markers = [];
		$vars = ['image_data', 'viewer_id', 'can_moderate', 'hidden', 'covered_markers'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.image_visibility.private_data',
			compact($vars)
		));

		return (bool) $hidden || $this->has_uncovered_active_marker($image_data, (array) $covered_markers);
	}

	/**
	 * Resolve the public label used when an image owner's identity is hidden.
	 *
	 * Optional add-ons may replace the neutral Core label with wording that
	 * describes their own privacy state without leaking that feature into Core.
	 */
	public function private_data_label(array $image_data, int $viewer_id, bool $can_moderate, string $fallback): string
	{
		$label = $fallback;
		$vars = ['image_data', 'viewer_id', 'can_moderate', 'label'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.image_visibility.private_data_label',
			compact($vars)
		));

		$label = trim((string) $label);

		return $label !== '' ? $label : $fallback;
	}

	/**
	 * Resolve the message shown instead of a protected image description.
	 */
	public function private_data_description(
		array $image_data,
		array $album_data,
		int $viewer_id,
		bool $can_moderate,
		string $fallback
	): string
	{
		$description = $fallback;
		$vars = ['image_data', 'album_data', 'viewer_id', 'can_moderate', 'description'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.image_visibility.private_data_description',
			compact($vars)
		));

		$description = trim((string) $description);

		return $description !== '' ? $description : $fallback;
	}

	public function hides_results(array $image_data, bool $can_moderate): bool
	{
		$hidden = false;
		$covered_markers = [];
		$vars = ['image_data', 'can_moderate', 'hidden', 'covered_markers'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.image_visibility.results',
			compact($vars)
		));

		return (bool) $hidden || $this->has_uncovered_active_marker($image_data, (array) $covered_markers);
	}

	/**
	 * Resolve the message presented in place of results hidden by an add-on.
	 */
	public function hidden_results_message(
		array $image_data,
		array $album_data,
		bool $can_moderate,
		bool $detailed,
		string $fallback
	): string
	{
		$message = $fallback;
		$vars = ['image_data', 'album_data', 'can_moderate', 'detailed', 'message'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.image_visibility.hidden_results_message',
			compact($vars)
		));

		$message = trim((string) $message);

		return $message !== '' ? $message : $fallback;
	}

	/**
	 * Return sort keys that would expose private add-on data in an album.
	 */
	public function restricted_sort_keys(array $album_data, bool $can_moderate): array
	{
		$sort_keys = [];
		$vars = ['album_data', 'can_moderate', 'sort_keys'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.image_visibility.restricted_sort_keys',
			compact($vars)
		));

		return array_values(array_unique(array_filter(
			array_map('strval', (array) $sort_keys),
			static fn(string $sort_key): bool => $sort_key !== ''
		)));
	}

	/**
	 * Resolve optional award presentation data for an image.
	 *
	 * @return array{rank: int, label: string, title: string}
	 */
	public function award(array $image_data): array
	{
		$rank = 0;
		$label = '';
		$title = '';
		$vars = ['image_data', 'rank', 'label', 'title'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.image_visibility.award',
			compact($vars)
		));

		return [
			'rank' => max(0, (int) $rank),
			'label' => trim((string) $label),
			'title' => trim((string) $title),
		];
	}

	public function get_visibility_sql_for_private_data(string $alias, int $viewer_id, array $moderated_album_ids): string
	{
		$this->validate_alias($alias);
		$conditions = [];
		$covered_markers = [];
		$vars = ['alias', 'viewer_id', 'moderated_album_ids', 'conditions', 'covered_markers'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.image_visibility.private_data_sql',
			compact($vars)
		));
		$conditions = $this->append_uncovered_marker_sql($alias, (array) $conditions, (array) $covered_markers);

		return $this->combine_conditions((array) $conditions);
	}

	public function get_visibility_sql_for_results(string $alias, array $moderated_album_ids): string
	{
		$this->validate_alias($alias);
		$conditions = [];
		$covered_markers = [];
		$vars = ['alias', 'moderated_album_ids', 'conditions', 'covered_markers'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.image_visibility.results_sql',
			compact($vars)
		));
		$conditions = $this->append_uncovered_marker_sql($alias, (array) $conditions, (array) $covered_markers);

		return $this->combine_conditions((array) $conditions);
	}

	/**
	 * @deprecated Use get_visibility_sql_for_private_data().
	 */
	public function private_data_sql(string $alias, int $viewer_id, array $moderated_album_ids): string
	{
		return $this->get_visibility_sql_for_private_data($alias, $viewer_id, $moderated_album_ids);
	}

	/**
	 * @deprecated Use get_visibility_sql_for_results().
	 */
	public function results_sql(string $alias, array $moderated_album_ids): string
	{
		return $this->get_visibility_sql_for_results($alias, $moderated_album_ids);
	}

	/**
	 * Project the historical visibility marker without exposing its storage name
	 * to Core readers. This compatibility boundary can be removed with the
	 * legacy column once every persisted row has an add-on-owned state.
	 */
	public function projection_sql(string $table_alias, string $projection_alias): string
	{
		$this->validate_alias($table_alias);
		$this->validate_projection_alias($projection_alias);

		return ($table_alias !== '' ? $table_alias . '.' : '')
			. 'image_contest AS ' . $projection_alias;
	}

	/**
	 * Hydrate policy input from a projected historical visibility marker.
	 */
	public function projected_data(array $row, string $projection_alias, array $image_data = []): array
	{
		$this->validate_projection_alias($projection_alias);
		$image_data['image_contest'] = (int) ($row[$projection_alias] ?? 0);

		return $image_data;
	}

	/**
	 * Keep persisted optional-feature data private when its provider is absent.
	 */
	private function has_uncovered_active_marker(array $image_data, array $covered_markers): bool
	{
		return (int) ($image_data['image_contest'] ?? 0) !== 0
			&& !in_array('image_contest', $covered_markers, true);
	}

	/**
	 * Exclude persisted optional-feature rows when no active provider owns them.
	 */
	private function append_uncovered_marker_sql(string $alias, array $conditions, array $covered_markers): array
	{
		if (!in_array('image_contest', $covered_markers, true))
		{
			$conditions[] = ($alias !== '' ? $alias . '.' : '') . 'image_contest = 0';
		}

		return $conditions;
	}

	private function validate_alias(string $alias): void
	{
		if ($alias !== '' && !preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $alias))
		{
			throw new \InvalidArgumentException('Invalid SQL alias.');
		}
	}

	private function validate_projection_alias(string $alias): void
	{
		if ($alias === '')
		{
			throw new \InvalidArgumentException('A projection alias is required.');
		}

		$this->validate_alias($alias);
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
