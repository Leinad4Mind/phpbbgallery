<?php
/**
*
* @package sitesplat BBcore
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
	/**
	* Single disable step that does nothing
	*
	* @param mixed $old_state State returned by previous call of this method
	* @return mixed Returns false after last step, otherwise temporary state
	*/
	public function disable_step($old_state)
	{
		$this->extensions = $this->container->get('ext.manager')->all_enabled();
		foreach($this->extensions as $key => $value)
		{
			if (strpos($value, 'sitesplat') === false)
			{
				unset($this->extensions[$key]);	
			}
		}
		
		unset($this->extensions['sitesplat/BBCore']);	
		if (sizeof($this->extensions))
		{
			$this->user = $this->container->get('user');
			trigger_error(sprintf($this->user->lang['BBCORE_ERROR_DISABLE'], implode('<br />', array_keys($this->extensions))), E_USER_WARNING);
		}
		
		return parent::disable_step($old_state);
	}
}
