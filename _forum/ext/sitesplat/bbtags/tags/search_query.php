<?php
/**
 *
 * BBTags
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbtags\tags;

/**
 * Build provider- and scope-aware topic tag match conditions.
 */
class search_query
{
	/**
	 * Build a correlated SQL condition for AND or OR tag matching.
	 *
	 * @param string $relation_table Table containing topic_id and tag_id
	 * @param array  $allowed_forums Forum identifiers indexed by tag identifier
	 * @param string $operator       and or or
	 * @param string $topic_alias    Outer topics table alias
	 *
	 * @return string
	 */
	public function build($relation_table, array $allowed_forums, $operator = 'and', $topic_alias = 'topics')
	{
		$operator = ($operator === 'or') ? 'or' : 'and';
		$conditions = array();
		foreach ($allowed_forums as $tag_id => $forum_ids)
		{
			$tag_id = (int) $tag_id;
			$forum_ids = array_values(array_unique(array_map('intval', $forum_ids)));
			if ($tag_id <= 0 || empty($forum_ids))
			{
				if ($operator === 'and')
				{
					return '1 = 0';
				}
				continue;
			}
			$conditions[] = 'tag_match.tag_id = ' . $tag_id . '
				AND ' . $topic_alias . '.forum_id IN (' . implode(', ', $forum_ids) . ')';
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
				WHERE tag_match.topic_id = ' . $topic_alias . '.topic_id
					AND ((' . implode(') OR (', $conditions) . '))
			)';
		}

		$exists = array();
		foreach ($conditions as $condition)
		{
			$exists[] = 'EXISTS (
				SELECT 1
				FROM ' . $relation_table . ' tag_match
				WHERE tag_match.topic_id = ' . $topic_alias . '.topic_id
					AND ' . $condition . '
			)';
		}

		return implode("\n\t\t\tAND ", $exists);
	}
}
