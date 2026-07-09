<?php
/**
*
* Notification_manager for the phpBB Forum Software package.
*
* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\notification_manager;

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		if (!class_exists('forumhulp\helper\helper'))
		{
			$this->container->get('user')->add_lang_ext('forumhulp/notification_manager', 'info_acp_notification_manager');
			trigger_error($this->container->get('user')->lang['FH_HELPER_NOTICE'], E_USER_WARNING);	
		}
		
		if (!$this->container->get('ext.manager')->is_enabled('forumhulp/helper'))
		{
			$this->container->get('ext.manager')->enable('forumhulp/helper');
		}

		return class_exists('forumhulp\helper\helper');
	}

	function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				if (empty($old_state))
				{
					$this->container->get('user')->add_lang_ext('forumhulp/notification_manager', 'info_acp_notification_manager');
					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] . 
						(isset($this->container->get('user')->lang['NOTIFICATION_MANAGER_NOTICE']) ?
							sprintf($this->container->get('user')->lang['NOTIFICATION_MANAGER_NOTICE']) : ''));
				}
				$this->restore_config('enable');
				return parent::enable_step($old_state);
			
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

				// Restore old .htaccess
				return $this->restore_config();

			break;

			default:

				// Run parent disable step method
				return parent::disable_step($old_state);

			break;
		}
	}


	protected function restore_config($mode = false)
	{
		
		$this->db = $this->container->get('dbal.conn');
		$sql = 'UPDATE ' . MODULES_TABLE . ' SET module_enabled = ' . (($mode) ? 0 : 1) . " WHERE module_langname = 'UCP_NOTIFICATION_LIST'";
		$this->db->sql_query($sql);
		$sql = 'UPDATE ' . MODULES_TABLE . ' SET module_enabled = ' . (($mode) ? 1 : 0) . " WHERE module_langname = 'UCP_NOTIES'";
		$this->db->sql_query($sql);
		return 'forced';
	}
}
