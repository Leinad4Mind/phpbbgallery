<?php
/**
*
* BBCore.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore;

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
		//	global $user;
		//	$user->lang['EXTENSION_ENABLE_SUCCESS'] =  $user->lang['EXTENSION_ENABLE_SUCCESS'];
		}
		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
