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

namespace leinad4mind\htmlemail;

/**
 * This ext class is optional and can be omitted if left empty.
 * However you can add special (un)installation commands in the
 * methods enable_step(), disable_step() and purge_step(). As it is,
 * these methods are defined in \phpbb\extension\base, which this
 * class extends, but you can overwrite them to give special
 * instructions for those cases.
 */
class ext extends \phpbb\extension\base
{


	public function enable_step($old_state)
	{
		if (empty($old_state))
		{
			$this->container->get('user')->add_lang_ext('leinad4mind/htmlemail', 'info_acp_htmlemail');
			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] .
				(isset($this->container->get('user')->lang['HTML_EMAIL_NOTICE']) ? $this->container->get('user')->lang['HTML_EMAIL_NOTICE'] : ''));
		}
		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
