<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\loginredirect\core;

class redirect_policy
{
	public static function is_unseen($topic, $last_visit)
	{
		return is_array($topic) && isset($topic['topic_time']) && (int) $topic['topic_time'] > (int) $last_visit;
	}

	public static function choose_announcement($latest, $selected, $latest_has_priority)
	{
		if ($latest_has_priority)
		{
			return $latest ?: $selected;
		}
		return $selected ?: $latest;
	}
}
