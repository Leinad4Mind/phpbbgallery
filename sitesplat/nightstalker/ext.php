<?php
/**
*
* Nightstalker
*
* @copyright (c) 2015 sitesplat.com <http://sitesplat.com>
* @license Proprietary
*
*/

namespace sitesplat\nightstalker;

class ext extends \phpbb\extension\base
{
	public function enable_step($old_state)
	{
		if (empty($old_state))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/nightstalker', 'nightstalker');
			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] . 
				(isset($this->container->get('user')->lang['NIGHTSTALKER_NOTICE']) ? $this->container->get('user')->lang['NIGHTSTALKER_NOTICE'] : ''));
		}
		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
