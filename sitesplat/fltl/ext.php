<?php
/**
*
* Fancy Lazy Topics Loader
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\fltl;

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
	public function is_enableable()
	{
		$manager = $this->container->get('ext.manager');

		return $manager->is_enabled('sitesplat/BBCore');
	}
	
	public function enable_step($old_state)
	{
		if (empty($old_state))
		{
			global $user;
			$info = '<div style="width:80%;margin:20px auto;"><p>The Setting for this extension can be found in <strong>General » Board configuration » Board Settings Tab Fancy Lazy Topics loader</strong>.<br />Please note there is a min of 4 posts per page! Enjoy!</p></div>';
			$user->lang['EXTENSION_ENABLE_SUCCESS'] =  $user->lang['EXTENSION_ENABLE_SUCCESS'] . $info;
		}
		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
