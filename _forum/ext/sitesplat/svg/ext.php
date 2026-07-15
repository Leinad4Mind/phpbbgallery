<?php
/**
*
* @package BBsvg
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\svg;

class ext extends \phpbb\extension\base
{
	
	public function is_enableable()
	{
		if (!class_exists('sitesplat\BBCore\helper'))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/svg', 'info_acp_svg');
			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTY'], E_USER_WARNING);	
		}
		
		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore'))
		{
			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
		}

		return class_exists('sitesplat\BBCore\helper');
	}

	/**
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				if (empty($old_state))
				{
					$this->container->get('user')->add_lang_ext('sitesplat/svg', 'info_acp_svg');
					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] .
						(isset($this->container->get('user')->lang['BBSVG_NOTICE']) ? 
							sprintf($this->container->get('user')->lang['BBSVG_NOTICE'], 
							$this->container->get('user')->lang['ACP_CAT_FORUMS'], 
							$this->container->get('user')->lang['ACP_MANAGE_FORUMS'], 
							$this->container->get('user')->lang['ACP_BBSVG_FORUMS']) : ''));
				}

				// Run parent enable step method
				return parent::enable_step($old_state);
			
			break;
			
			default:
			
				// Run parent enable step method
				return parent::enable_step($old_state);
				
			break;
		}
	}
}
