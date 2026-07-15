<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015-2022 SiteSplat All rights reserved
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
		return [
			'core.acp_manage_forums_initialise_data'	=> 'acp_manage_forums_initialise_data',
			'core.acp_manage_forums_display_form'		=> 'acp_manage_forums_display_form',
			'core.acp_manage_forums_update_data_after'	=> 'acp_manage_forums_update_data_after',
		];
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
			$event['forum_data']['bbpoints_enabled'] = $this->config['bbpoints_enabled'];
			$event['forum_data']['bbpoints_per_topic'] = 0;
			$event['forum_data']['bbpoints_per_post'] = 0;
			$event['forum_data']['bbpoints_per_word'] = 0;
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
		$row = null;
		if ($event['action'] !== 'add') {
			$sql = 'SELECT bbpoints_per_topic, bbpoints_per_post, bbpoints_per_word FROM ' . FORUMS_TABLE . ' WHERE forum_id = '. $event['forum_data']['forum_id'] .' and bbpoints_enabled = 1';
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
		}

		$this->template->assign_vars([
			'S_ENABLE_POINTS' => $this->request->variable('forum_bbpoints_enabled', $event['forum_data']['bbpoints_enabled'] ?? false),
			'PERTOPIC' => $this->request->variable('bbpoints_per_topic', isset($row) && is_array($row) ? $row['bbpoints_per_topic'] : $event['forum_data']['bbpoints_per_topic'] ?? 0),
			'PERPOST' => $this->request->variable('bbpoints_per_post', isset($row) && is_array($row) ? $row['bbpoints_per_post'] : $event['forum_data']['bbpoints_per_post'] ?? 0),
			'PERWORD' => $this->request->variable('bbpoints_per_word', isset($row) && is_array($row) ? $row['bbpoints_per_word'] : $event['forum_data']['bbpoints_per_word'] ?? 0),
		]);
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