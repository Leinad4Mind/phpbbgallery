<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\core\token;

class date extends token
{
	const DEFAULT_DATE_FORMAT = 'm/d/Y';
	const TOKEN_REGEX = '/{DATE(\|[a-zA-Z-\/\. ]+)?}/';

	/**
	 * @inheritdoc
	 */
	public function get_token_data($prefix_text, $topic_id, $prefix_id, $forum_id)
	{
		// @TODO - figure out how to handle if they change the date format
		// any old prefix instances will stop showing the replacement for the token

		// Allow date format to be passed
		// {DATE} is defaults to: m/d/Y
		// Format can be
		if (false === $this->match_token($prefix_text))
		{
			return false;
		}

		return [
			// We store the service name so that there's no guesswork later
			'service' => 'bbprefix.token.date',
			'data' => time(),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function apply_token_data($prefix_text, $data)
	{
		if (false === ($matches = $this->match_token($prefix_text)))
		{
			return false;
		}

		// if the token is {DATE|m/d/y}
		// $matches[1] will contain the string '|m/d/y'
		// We want to remove the | and use the rest in the date() function
		$format = (sizeof($matches) > 1) ? ltrim($matches[1], '|') : self::DEFAULT_DATE_FORMAT;
		// $data should contain the timestamp
		return preg_replace(self::TOKEN_REGEX, date($format, $data), $prefix_text);
	}
}
