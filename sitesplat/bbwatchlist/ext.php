<?php
/**
 *
 * BBwatchlist. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\bbwatchlist;

/**
 * BBwatchlist Extension base
 *
 * It is recommended to remove this file from
 * an extension if it is not going to be used.
 */
class ext extends \phpbb\extension\base
{
	const SEARCH_TYPE_TOPIC_SUBJECT = 0;
	const SEARCH_TYPE_POST_CONTENT = 1;

	public function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->enable_notifications('sitesplat.bbwatchlist.notification.type.subject_keyword');
				$phpbb_notifications->enable_notifications('sitesplat.bbwatchlist.notification.type.content_keyword');
				return 'notification';

			break;

			default:

				return parent::enable_step($old_state);

			break;
		}
	}

	public function disable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->disable_notifications('sitesplat.bbwatchlist.notification.type.subject_keyword');
				$phpbb_notifications->disable_notifications('sitesplat.bbwatchlist.notification.type.content_keyword');
				return 'notification';

			break;

			default:

				return parent::disable_step($old_state);

			break;
		}
	}

	public function purge_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->purge_notifications('sitesplat.bbwatchlist.notification.type.subject_keyword');
				$phpbb_notifications->purge_notifications('sitesplat.bbwatchlist.notification.type.content_keyword');
				return 'notification';

			break;

			default:

				return parent::purge_step($old_state);

			break;
		}
	}
}
