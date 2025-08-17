<?php
/**
 *
 * @package ReplyToUnihde
 * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
 * @license Proprietary
 *
 */

namespace sitesplat\replytounhide\core;

use phpbb\user;
use sitesplat\replytounhide\ext;

/**
 * Thanks2unhide core BBCodes parser class
 */
class bbcodes_parser
{
	protected $user;

	/**
	 * Constructor
	 */
	public function __construct(user $user)
	{
		$this->user = $user;
		$this->replied = 0;
	}

	/**
	 * Pre-Parser for special custom BBCodes
	 */
	public function pre_parse_bbcodes($text, $uid)
	{
		return $text;
	}

	/**
	 * Post-Parser for special custom BBCodes
	 */
	public function post_parse_bbcodes($text)
	{
		// hide BBCode
		$text = preg_replace_callback('#<!-- BBCODE_HIDE -->(.*?)<!-- BBCODE_HIDE -->#s', array($this, 'hidden_pass'), $text);

		return $text;
	}

	/**
	 * Convert Hide BBCode into its final appearance
	 */
	protected function hidden_pass($matches)
	{
		if (!$this->replied || $this->user->data['user_id'] == ANONYMOUS || $this->user->data['is_bot'])
		{
			$replacements = array(
				$this->user->lang('HIDE_ON'),
				$this->user->lang('HIDE_EXPLAIN'),
				'hidebox_hidden',
			);
		}
		else
		{
			$replacements = array(
				$this->user->lang('HIDE_OFF'),
				$matches[1],
				'hidebox_visible',
			);
		}

		return vsprintf('<div class="hidebox %3$s"><div class="hidebox_title %3$s">%1$s</div><div class="%3$s">%2$s</div></div>', $replacements);
	}
}
