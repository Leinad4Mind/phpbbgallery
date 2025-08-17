<?php
/**
*
* @package User Defaults Extension
* @copyright (c) 2016 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\userdefaults\event;
use \phpbb\config\config;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use david63\userdefaults\core\constants;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/**
	* Constructor for listener
	*
	* @param \phpbb\config\config	$config	phpBB config
	* @access public
	*/
	public function __construct(config $config)
	{
		$this->config = $config;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_add_modify_data' => 'modify_user_defaults',
		);
	}

	/**
	* Update the user default settings
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function modify_user_defaults($event)
	{
		// Set the required notifications
		$notifications_data = array();
		if ($this->config['ud_moderation_queue'] != constants::NOTIFICATION)
		{
			$notifications_data[] = array('item_type' => 'moderation_queue', 'method' => 'notification.method.email',);
		}

		if ($this->config['ud_type.bookmark'] != constants::NOTIFICATION)
		{
			$notifications_data[] = array('item_type' => 'notification.type.bookmark', 'method' => 'notification.method.email',);
		}

		if ($this->config['ud_type.group_request'] != constants::NOTIFICATION)
		{
			$notifications_data[] = array('item_type' => 'notification.type.group_request', 'method' => 'notification.method.email',);
		}

		if ($this->config['ud_type.needs_approval'] != constants::NOTIFICATION)
		{
			$notifications_data[] = array('item_type' => 'notification.type.needs_approval', 'method' => 'notification.method.email',);
		}

		if ($this->config['ud_type.pm'] != constants::NOTIFICATION)
		{
			$notifications_data[] = array('item_type' => 'notification.type.pm', 'method' => 'notification.method.email',);
		}

		if ($this->config['ud_type.post'] != constants::NOTIFICATION)
		{
			$notifications_data[] = array('item_type' => 'notification.type.post', 'method' => 'notification.method.email',);
		}

		if ($this->config['ud_type.quote'] != constants::NOTIFICATION)
		{
			$notifications_data[] = array('item_type' => 'notification.type.quote', 'method' => 'notification.method.email',);
		}

		if ($this->config['ud_type.report'] != constants::NOTIFICATION)
		{
			$notifications_data[] = array('item_type' => 'notification.type.report', 'method' => 'notification.method.email',);
		}

		if ($this->config['ud_type.topic'] != constants::NOTIFICATION)
		{
			$notifications_data[] = array('item_type' => 'notification.type.topic', 'method' => 'notification.method.email',);
		}

		$event->offsetSet('notifications_data', $notifications_data);

		$sql_ary = $event['sql_ary'];

		$sql_ary['user_allow_massemail']	= $this->config['ud_allow_massemail'];
		$sql_ary['user_allow_pm']			= $this->config['ud_allow_pm'];
		$sql_ary['user_allow_viewemail']	= $this->config['ud_allow_viewemail'];
		$sql_ary['user_allow_viewonline']	= $this->config['ud_allow_viewonline'];
		$sql_ary['user_dateformat'] 		= $this->config['ud_date_format'];
		$sql_ary['user_notify']				= $this->config['ud_notify'];
		$sql_ary['user_notify_pm']   		= $this->config['ud_notify_pm'];
		$sql_ary['user_options'] 			= $this->config['ud_options'];
		$sql_ary['user_post_show_days'] 	= $this->config['ud_post_st'];
		$sql_ary['user_post_sortby_dir'] 	= $this->config['ud_post_sd'];
		$sql_ary['user_post_sortby_type'] 	= $this->config['ud_post_sk'];
		$sql_ary['user_topic_show_days'] 	= $this->config['ud_topic_st'];
		$sql_ary['user_topic_sortby_dir'] 	= $this->config['ud_topic_sd'];
		$sql_ary['user_topic_sortby_type'] 	= $this->config['ud_topic_sk'];

		$event['sql_ary'] = $sql_ary;

		return $event;
	}
}
