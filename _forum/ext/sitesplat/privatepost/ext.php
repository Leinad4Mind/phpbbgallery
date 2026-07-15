<?php
/**
*
* Private Post
*
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\privatepost;

class ext extends \phpbb\extension\base
{
	/**
	* Overwrite disable_step to soft-delete all private posts
	* before the extension is disabled to keep their secrets.
	*
	* @param mixed $old_state State returned by previous call of this method
	* @return mixed Returns false after last step, otherwise temporary state
	* @access public
	*/
	
	
	public function is_enableable()
	{
		if (!class_exists('sitesplat\BBCore\helper'))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/privatepost', 'info_acp_privatepost');
			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTY'], E_USER_WARNING);	
		}
		
		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore'))
		{
			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
		}

		return class_exists('sitesplat\BBCore\helper');
	}
	
	/**
	* Overwrite purge_step to purge board rules notifications before
	* any included and installed migrations are reverted.
	*
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
					$this->container->get('user')->add_lang_ext('sitesplat/privatepost', 'info_acp_privatepost');
					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] . 
						(isset($this->container->get('user')->lang['PRIVATEPOST_NOTICE']) ?
							sprintf($this->container->get('user')->lang['PRIVATEPOST_NOTICE'],
									$this->container->get('user')->lang['ACP_CAT_PERMISSIONS'],
									$this->container->get('user')->lang['ACP_GROUPS_FORUM_PERMISSIONS'],
									$this->container->get('user')->lang['ACP_PRIVATEPOST_PERMISSIONS']) : ''));
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
	
	public function disable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Soft-delete all private posts
				$phpbb_content_visibility = $this->container->get('content.visibility');
				$db = $this->container->get('dbal.conn');
				$user = $this->container->get('user');
				$posts_table = $this->container->getParameter('tables.posts');
				$topics_table = $this->container->getParameter('tables.topics');

				$sql = 'SELECT p.*, t.*
						FROM ' . $posts_table . ' p, ' . $topics_table . ' t
						WHERE post_private = 1';
				$result = $db->sql_query($sql);
				while($row = $db->sql_fetchrow($result))
				{
					$topic_id = (int) $row['topic_id'];
					$post_id = (int) $row['post_id'];

					$topic_info[$topic_id]['posts'][] = $post_id;
					$topic_info[$topic_id]['forum_id'] = (int) $row['forum_id'];

					if ($post_id == $row['topic_first_post_id'])
					{
						$topic_info[$topic_id]['first_post'] = true;
					}

					if ($post_id == $row['topic_last_post_id'])
					{
						$topic_info[$topic_id]['last_post'] = true;
					}
				}
				$db->sql_freeresult($result);

				if (!empty($topic_info))
				{
					foreach ($topic_info as $topic_id => $topic_data)
					{
						$phpbb_content_visibility->set_post_visibility(ITEM_DELETED, $topic_data['posts'], $topic_id, $topic_data['forum_id'], $user->data['user_id'], time(), 'Deleted by disabling Private Post extension.', isset($topic_data['first_post']), isset($topic_data['last_post']));
					}
				}

				return 'soft_delete_private_posts';

			break;

			default:

				// Run parent disable step method
				return parent::disable_step($old_state);

			break;
		}
	}

	
}
