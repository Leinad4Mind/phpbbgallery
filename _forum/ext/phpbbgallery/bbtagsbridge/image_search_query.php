<?php
/**
 * Builds policy-aware Gallery image tag search conditions.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge;

final class image_search_query
{
	/**
	 * Build a correlated AND/OR relation condition for outer image alias i.
	 *
	 * @param string $relation_table Relation table containing image_id and tag_id
	 * @param array  $allowed_albums Album identifiers indexed by tag identifier
	 * @param string $operator       and or or
	 * @param string $image_alias    Outer image table alias
	 */
	public function build(
		string $relation_table,
		array $allowed_albums,
		string $operator = 'and',
		string $image_alias = 'i'
	): string
	{
		if (!preg_match('/^[a-zA-Z0-9_]+$/D', $relation_table)
			|| !preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/D', $image_alias))
		{
			return '1 = 0';
		}
		$operator = $operator === 'or' ? 'or' : 'and';
		$conditions = [];
		foreach ($allowed_albums as $tag_id => $album_ids)
		{
			$tag_id = (int) $tag_id;
			$album_ids = array_values(array_unique(array_filter(array_map('intval', (array) $album_ids))));
			if ($tag_id <= 0 || empty($album_ids))
			{
				if ($operator === 'and')
				{
					return '1 = 0';
				}
				continue;
			}
			$conditions[] = 'tag_match.tag_id = ' . $tag_id . '
					AND ' . $image_alias . '.image_album_id IN (' . implode(', ', $album_ids) . ')';
		}
		if (empty($conditions))
		{
			return '1 = 0';
		}
		if ($operator === 'or')
		{
			return 'EXISTS (
				SELECT 1
				FROM ' . $relation_table . ' tag_match
				WHERE tag_match.image_id = ' . $image_alias . '.image_id
					AND ((' . implode(') OR (', $conditions) . '))
			)';
		}

		$exists = [];
		foreach ($conditions as $condition)
		{
			$exists[] = 'EXISTS (
				SELECT 1
				FROM ' . $relation_table . ' tag_match
				WHERE tag_match.image_id = ' . $image_alias . '.image_id
					AND ' . $condition . '
			)';
		}

		return implode(PHP_EOL . '			AND ', $exists);
	}
}
