<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbpoints\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class admin_listener implements EventSubscriberInterface
{
	protected $db;
	protected $request;
	protected $template;
	protected $config;

	/**
	 * Constructor
	 *
	 * @access	public
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\config\config $config)
	{
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
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
			'core.acp_manage_forums_initialise_data'	=> 'acp_manage_forums_initialise_data',
			'core.acp_manage_forums_display_form'		=> 'acp_manage_forums_display_form',
			'core.acp_manage_forums_update_data_after'	=> 'acp_manage_forums_update_data_after',
		);
	}

	/**
	 * Initialize forum data before form display
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function acp_manage_forums_initialise_data($event)
	{
		if($event['action'] == 'add')
		{
			$event['forum_data'] = array_merge($event['forum_data'], array(
				'bbpoints_enabled'		=> $this->config['bbpoints_enabled'],
				'bbpoints_per_topic'	=> 0,
				'bbpoints_per_post'		=> 0,
				'bbpoints_per_word'		=> 0,
			));
		}
	}

	/**
	 * Add template data before form display
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function acp_manage_forums_display_form($event)
	{
		$this->template->assign_vars(array(
			'S_ENABLE_POINTS'	=> ($event['forum_data']['bbpoints_enabled']) ? true : false,
			'PERTOPIC'			=> $event['forum_data']['bbpoints_per_topic'],
			'PERPOST'			=> $event['forum_data']['bbpoints_per_post'],
			'PERWORD'			=> $event['forum_data']['bbpoints_per_word'],
		));
	}

	/**
	 * Update additional fields after forum add/edit
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function acp_manage_forums_update_data_after($event)
	{
		$sql = 'UPDATE ' . FORUMS_TABLE . '
				SET bbpoints_enabled = ' . $this->request->variable('forum_bbpoints_enabled', 1) . ',
					bbpoints_per_topic = ' . $this->request->variable('bbpoints_per_topic', 0) . ',
					bbpoints_per_post = ' . $this->request->variable('bbpoints_per_post', 0) . ',
					bbpoints_per_word = ' . $this->request->variable('bbpoints_per_word', 0) . '
				WHERE forum_id = ' . $event['forum_data']['forum_id'];
		$this->db->sql_query($sql);
	}
}
