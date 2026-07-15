<?php
/**
*
* UserDefaults extension for the phpBB Forum Software package.
*
* @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\userdefault\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $config;
	protected $entity;
	protected $db;
	protected $container;

	/**
	* Constructor
	*
	*/
	public function __construct(config $config, $entity, driver_interface $db, ContainerInterface $container)
	{
		$this->config = $config;
		$this->entity = $entity;
		$this->db = $db;
		$this->container = $container;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_add_modify_data'		=> 'user_default',
			'core.user_add_after'			=> 'no_noti'
		);
	}

	public function no_noti($event)
	{
		$userid = $event['user_id'];
		list($options, $postsettings, $generalsettings, $noti_setup) = explode('~', $this->config['user_default_options']);
		$noti_setup = json_decode($noti_setup, true);
		$this->noti_manager = $this->container->get('notification_manager');
		
		$default_types = array();
		if (isset($noti_setup['board']) && sizeof($noti_setup['board']))
		{
			$sql = 'SELECT * FROM ' . NOTIFICATION_TYPES_TABLE . ' 
					WHERE notification_type_name LIKE "%notification.type.%" AND notification_type_id NOT IN (' . implode(',', $noti_setup['board']) . ')';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				(in_array($row['notification_type_name'], array('notification.type.post_in_queue', 'notification.type.topic_in_queue', 'notification.type.approve_post', 'notification.type.approve_topic'))) ? 
				$row['notification_type_name'] = 'notification.type.needs_approval' : null;

				(in_array($row['notification_type_name'], array('notification.type.report_pm', 'notification.type.report_post'))) ? 
				$row['notification_type_name'] = 'notification.type.report' : null;
								
				$this->noti_manager->delete_subscription($row['notification_type_name'], 0, 'notification.method.board', $userid);
			}
		}
	
	}
	
	public function user_default($event)
	{
		list($options, $postsettings, $generalsettings, $noti_setup) = explode('~', $this->config['user_default_options']);
		$postsettings  = str_split($postsettings);
		$generalsettings  = str_split($generalsettings);
		$noti_setup = json_decode($noti_setup, true);

		$default_types = array();
		
		if (isset($noti_setup['email']) && sizeof($noti_setup['email']))
		{
			$sql = 'SELECT * FROM ' . NOTIFICATION_TYPES_TABLE . ' 
					WHERE notification_type_name LIKE "%notification.type.%" AND notification_type_id IN (' . implode(',', $noti_setup['email']) . ')';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				(in_array($row['notification_type_name'], array('notification.type.post_in_queue', 'notification.type.topic_in_queue', 'notification.type.approve_post', 'notification.type.approve_topic'))) ? 
				$row['notification_type_name'] = 'notification.type.needs_approval' : null;

				(in_array($row['notification_type_name'], array('notification.type.report_pm', 'notification.type.report_post'))) ? 
				$row['notification_type_name'] = 'notification.type.report' : null;

				$default_types[] = array('item_type' => $row['notification_type_name'], 'method' => 'notification.method.email');
			}
		}
		$subscriptions = (sizeof($noti_setup)) ? $default_types : array();

		$event->offsetSet('notifications_data', $subscriptions);

		$sql_ary = $event['sql_ary'];
		$sql_ary['user_options'] = $options;

		$sql_ary['user_allow_viewemail']	= $generalsettings[0];
		$sql_ary['user_allow_massemail']	= $generalsettings[1];
		$sql_ary['user_allow_pm']			= $generalsettings[2];
		$sql_ary['user_notify']				= $generalsettings[3];
		$sql_ary['user_notify_type']		= $generalsettings[4];
		$sql_ary['user_notify_pm']			= $generalsettings[5];
		$sql_ary['user_allow_viewonline']	= $generalsettings[6];
		
		$sql_ary['user_topic_show_days'] = $this->entity->Index($postsettings[0], 'limit_days');
		$sql_ary['user_post_show_days'] = $this->entity->Index($postsettings[1], 'limit_days');

		$sql_ary['user_topic_sortby_type'] = $this->entity->Index($postsettings[2], 'sort_by_topic_text');
		$sql_ary['user_post_sortby_type'] = $this->entity->Index($postsettings[3], 'sort_by_post_text');

		$sql_ary['user_topic_sortby_dir'] = $this->entity->Index($postsettings[4], 'sort_dir_text');
		$sql_ary['user_post_sortby_dir'] = $this->entity->Index($postsettings[5], 'sort_dir_text');
		
		$event['sql_ary'] = $sql_ary;
	}
}
