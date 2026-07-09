<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr;

class ext extends \phpbb\extension\base
{
	const COOKIE_NOT_YET = 0;
	const COOKIE_ACCEPTED = 1;
	const COOKIE_DENIED = 2;

	/**
	 * {@inheritdoc}
	 */
	public function is_enableable()
	{
	    if (!class_exists('sitesplat\BBCore\helper'))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/bbgdpr', 'info_acp_bbgdpr');
			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTY'], E_USER_WARNING);	
		}
		
		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore'))
		{
			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
		}

		return class_exists('sitesplat\BBCore\helper');
	//	return phpbb_version_compare(PHPBB_VERSION, '3.2.0', '>=');
	}

	public function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
			    if (empty($old_state))
				{
					$this->container->get('user')->add_lang_ext('sitesplat/bbgdpr', 'info_acp_bbgdpr');
					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] . 
						(isset($this->container->get('user')->lang['BBGDPR_NOTICE']) ?
							sprintf($this->container->get('user')->lang['BBGDPR_NOTICE'],
									$this->container->get('user')->lang['ACP_CAT_POSTING'],
									$this->container->get('user')->lang['ACP_MESSAGES'],
									$this->container->get('user')->lang['ACP_BBGDPR']) : ''));
				}
				// Enable other stuff
				return $this->notification_handler('enable', array(
					'sitesplat.bbgdpr.notification.type.user_deleted',
				));
			break;
			default:
				// Run parent enable step method
				return parent::enable_step($old_state);
			break;
		}
	}

	public function disable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				return $this->notification_handler('disable', array(
					'sitesplat.bbgdpr.notification.type.user_deleted',
				));
			break;
			default:
				// Run parent disable step method
				return parent::disable_step($old_state);
			break;
		}
	}

	public function purge_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				return $this->notification_handler('purge', array(
					'sitesplat.bbgdpr.notification.type.user_deleted',
				));
			break;
			default:
				// Run parent purge step method
				return parent::purge_step($old_state);
			break;
		}
	}

	protected function notification_handler($step, $notification_types)
	{
		$phpbb_notifications = $this->container->get('notification_manager');
		foreach ($notification_types as $notification_type)
		{
			$phpbb_notifications->{$step . '_notifications'}($notification_type);
		}
		return 'notifications';
	}
}