<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\core\token;

class poster extends token
{
	const TOKEN_REGEX = '/{POSTER}/';

	/**
	 * @inheritdoc
	 */
	public function get_token_data($prefix_text, $topic_id, $prefix_id, $forum_id)
	{
		if (false === $this->match_token($prefix_text))
		{
			return false;
		}

		// Get the poster of the topic
		$sql = 'SELECT u.username FROM ' . USERS_TABLE .  ' u
			LEFT JOIN ' . TOPICS_TABLE . ' t ON t.topic_poster = u.user_id
			WHERE t.topic_id = ' . (int) $topic_id;
		$result = $this->db->sql_query($sql);
		$poster_username = $this->db->sql_fetchfield('username');
		$this->db->sql_freeresult();

		if (!$poster_username)
		{
			return false;
		}

		return [
			// We store the service name so that there's no guesswork later
			'service' => 'bbprefix.token.poster',
			'data' => $poster_username,
		];
	}
}
