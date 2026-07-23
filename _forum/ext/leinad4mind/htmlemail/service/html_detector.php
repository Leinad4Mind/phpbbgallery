<?php
/**
 *
 * HTML email extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
 * @copyright (c) 2026 Leinad4Mind <https://leinad4mind.top>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\htmlemail\service;

class html_detector
{
	/**
	 * Check if content contains HTML
	 *
	 * @param string $content
	 * @return bool
	 */
	public function is_html(string $content): bool
	{
		return (bool) preg_match('/<\s*(html|body|div|p|span|a|table|tr|td|b|i|strong|em|br|img|h[1-6])\b[^>]*>/i', $content);
	}
}
