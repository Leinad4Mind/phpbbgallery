<?php
/**
 *
 * @package phpBB Extension - Username Colour Changer
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\usernamecolourchanger\core;

class colour_helper
{
	/**
	 * Validate and normalise a phpBB username colour.
	 *
	 * @param string $colour Colour supplied by a user
	 * @return string|false Canonical six-digit colour, an empty string, or false
	 */
	public function normalise($colour)
	{
		$colour = trim((string) $colour);

		if ($colour === '')
		{
			return '';
		}

		if ($colour[0] === '#')
		{
			$colour = substr($colour, 1);
		}

		if (!preg_match('/\A(?:[0-9a-f]{3}|[0-9a-f]{6})\z/iD', $colour))
		{
			return false;
		}

		if (strlen($colour) === 3)
		{
			$colour = $colour[0] . $colour[0]
				. $colour[1] . $colour[1]
				. $colour[2] . $colour[2];
		}

		return strtoupper($colour);
	}
}
