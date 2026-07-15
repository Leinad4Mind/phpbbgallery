<?php
/**
*
* Force https extension for the phpBB Forum Software package.
* @copyright (c) 2017 sitesplat.com <http://sitesplat.com>
* @license Proprietary
*
*/

namespace sitesplat\forcehttps;

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
		if (!class_exists('sitesplat\BBCore\helper'))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/forcehttps', 'info_acp_forcehttps');
			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTY'], E_USER_WARNING);	
		}
		
		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore'))
		{
			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
		}

		return class_exists('sitesplat\BBCore\helper');
	}

	function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				if (empty($old_state))
				{
					// Enable https force
					$this->force_http_handler('enable');
					
					$this->container->get('user')->add_lang_ext('sitesplat/forcehttps', 'info_acp_forcehttps');
					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] . 
						(isset($this->container->get('user')->lang['FORCEHTTPS_NOTICE']) ? $this->container->get('user')->lang['FORCEHTTPS_NOTICE'] : ''));
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


	/**
	 * Overwrite disable_step to disable Auto Groups notifications
	 * before the extension is disabled.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	public function disable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Disable Auto Groups notifications
				return $this->force_http_handler('disable');

			break;

			default:

				// Run parent disable step method
				return parent::disable_step($old_state);

			break;
		}
	}


	protected function force_http_handler($mode)
	{
		$config = $this->container->get('config');
		
		if (!isset($config['forcehttps_oldconfig']) && empty($config['forcehttps_oldconfig']))
		{
			$config->set('forcehttps_oldconfig', '{
				"server_port":"' . $config['server_port'] . '",
				"server_protocol":"' . $config['server_protocol'] . '",
				"force_server_vars":"' . $config['force_server_vars'] . '",
				"cookie_secure":"' . $config['cookie_secure'] . '",
				"allow_avatar_remote":"' . $config['allow_avatar_remote'] . '"
				}');
		}
		
		$oldconfig = json_decode($config['forcehttps_oldconfig']);
		$config->set('server_port', (($mode == 'enable') ? 443 : $oldconfig->server_port));
		$config->set('server_protocol', (($mode == 'enable') ? 'https://' : $oldconfig->server_protocol));
		$config->set('force_server_vars', (($mode == 'enable') ? 0 : $oldconfig->force_server_vars));
		$config->set('cookie_secure', (($mode == 'enable') ? 1 : $oldconfig->cookie_secure));
		$config->set('allow_avatar_remote', (($mode == 'enable') ? 0 : $oldconfig->allow_avatar_remote));

		return 'forced';
	}
}
