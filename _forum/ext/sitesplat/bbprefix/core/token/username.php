<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\core\token;

class username extends token
{
	const TOKEN_REGEX = '/{USERNAME}/';

	/**
	 * @inheritdoc
	 */
	public function get_token_data($prefix_text, $topic_id, $prefix_id, $forum_id)
	{
		if (false === $this->match_token($prefix_text))
		{
			return false;
		}

		return [
			// We store the service name so that there's no guesswork later
			'service' => 'bbprefix.token.username',
			// The current user is the one who applied the prefix
			'data' => $this->user->data['username'],
		];
	}
}
