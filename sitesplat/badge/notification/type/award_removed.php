<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\notification\type;

class award_removed extends \sitesplat\badge\notification\type\award_added
{
	/**
	 * {@inheritdoc}
	 */
	public function get_type()
	{
		return 'sitesplat.badge.notification.type.award_removed';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_title()
	{
		return $this->user->lang('BADGE_NOTIFICATION_EVENT_REMOVED', $this->user->lang[$this->get_data('rule_name')]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_url()
	{
		return '';
	}
}
