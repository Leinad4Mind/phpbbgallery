<?php

namespace forumhulp\uploadimage;

use phpbb\extension\base;

class ext extends base
{
	public function is_enableable(): bool
	{
		if (!class_exists('forumhulp\\helper\\helper'))
		{
			$user = $this->container->get('user');
			$user->add_lang_ext('forumhulp/uploadimage', 'info_acp_uploadimage');
			trigger_error($user->lang['FH_HELPER_NOTICE'], E_USER_WARNING);
			return false;
		}

		return $this->container->get('ext.manager')->is_enabled('forumhulp/helper');
	}

	public function enable_step($old_state)
	{
		if (empty($old_state))
		{
			$user = $this->container->get('user');
			$user->add_lang_ext('forumhulp/uploadimage', 'info_acp_uploadimage');
			$notice = isset($user->lang['UPLOADIMAGE_NOTICE'])
				? sprintf(
					$user->lang['UPLOADIMAGE_NOTICE'],
					$user->lang['ACP_CAT_CUSTOMISE'],
					$user->lang['ACP_UPLOAD_IMAGE_TITLE'],
					$user->lang['ACP_IMAGE_TITLE']
				)
				: '';
			$this->container->get('template')->assign_var(
				'L_EXTENSION_ENABLE_SUCCESS',
				$user->lang['EXTENSION_ENABLE_SUCCESS'] . $notice
			);
		}

		return parent::enable_step($old_state);
	}
}
