<?php
/**
*
* BBAwards extension for the phpBB Forum Software package.
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
	* Language key used to output the text
	*
	* @var string
	*/
	protected $language_key = 'NOTIFICATION_BADGE';

	/**
	* Notification option data (for outputting to the user)
	*
	* @var bool|array False if the service should use it's default data
	* 					Array of data (including keys 'id', 'lang', and 'group')
	*/
	static public $notification_option = array(
		'lang'	=> 'NOTIFICATION_TYPE_AWARD_REMOVED',
		'group'	=> 'NOTIFICATION_GROUP_POSTING',
	);

	/**
	 * {@inheritdoc}
	 */
	public function get_title()
	{
		return $this->user->lang('BADGE_NOTIFICATION_EVENT_REMOVED', $this->user->lang[$this->get_data('rule_name')]);
	}
}
