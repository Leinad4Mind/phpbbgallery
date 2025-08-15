<?php
/**
*
* @package BBavatar+
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\avatarsplus;

class ext extends \phpbb\extension\base
{
	
	public function is_enableable()
	{
		if (!class_exists('Imagick', false) && !function_exists('imagefttext')) {
			$error = 'PHP Imagick] or [PHP GD Freetype';
		}
		else if (!function_exists('finfo_open')) {
			$error = 'PHP FileInfo';
		}
		else if (!class_exists('sitesplat\BBCore\event\listener', false)) {
			$error = 'BBCore';
		}
		else {
			return true;
		}

		global $module;
		trigger_error($this->container->get('language')->lang('EXTENSION_NOT_INSTALLED', "<strong>[{$error}]</strong>") . adm_back_link($module->module->u_action), E_USER_WARNING);
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
					$this->container->get('user')->add_lang_ext('sitesplat/avatarsplus', 'info_acp_avatarplus');
					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] . 
						(isset($this->container->get('user')->lang['BBAVATARPLUS_NOTICE']) ?
							sprintf($this->container->get('user')->lang['BBAVATARPLUS_NOTICE'],
									$this->container->get('user')->lang['UCP_UCP'],
									$this->container->get('user')->lang['UCP_PROFILE'],
									$this->container->get('user')->lang['UCP_PROFILE_AVATAR']) : ''));
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
