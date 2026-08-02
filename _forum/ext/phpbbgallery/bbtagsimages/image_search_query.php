<?php
/**
 * Builds policy-aware Gallery image tag search conditions.
 *
 * @package   phpbbgallery/bbtagsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsimages;

final class image_search_query
{
	/**
	 * Build a correlated AND/OR relation condition for outer image alias i.
	 *
	 * @param string $relation_table Relation table containing image_id and tag_id
	 * @param array  $allowed_albums Album identifiers indexed by tag identifier
	 * @param string $operator       and or or
	 */
	public function build(
		string $relation_table,
		array $allowed_albums,
		string $operator = 'and'
	): string
	{
		if (!preg_match('/^[a-zA-Z0-9_]+$/D', $relation_table))
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
			$conditions[] = 'tag_match.tag_id = ' . (int) $tag_id . '
					AND i.image_album_id IN (' . implode(', ', $album_ids) . ')';
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
				WHERE tag_match.image_id = i.image_id
					AND ((' . implode(') OR (', $conditions) . '))
			)';
		}

		$exists = [];
		foreach ($conditions as $get_sql_where)
		{
			$exists[] = 'EXISTS (
				SELECT 1
				FROM ' . $relation_table . ' tag_match
				WHERE tag_match.image_id = i.image_id
					AND ' . $get_sql_where . '
			)';
		}

		return implode(PHP_EOL . '			AND ', $exists);
	}
}
