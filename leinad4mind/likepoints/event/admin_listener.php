<?php
namespace oreolek\likepoints\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class admin_listener implements EventSubscriberInterface
{
	protected $db;
	protected $request;
	protected $template;

	/**
	 * Constructor
	 *
	 * @access	public
	 */
	public function __construct(\phpbb\request\request $request, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template)
  {
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
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
   * Initialize forum options.
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function acp_manage_forums_initialise_data($event)
	{
		if($event['action'] === 'add')
		{
			$event['forum_data'] = array_merge($event['forum_data'], array(
        'likepoints_enabled' => true,
        'likepoints_amount' => 1,
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
			'LIKEPOINTS_ENABLED' => ($event['forum_data']['likepoints_enabled']) ? true : false,
      'LIKEPOINTS_AMOUNT' => $event['forum_data']['likepoints_amount'],
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
    $likepoints_enabled = $this->request->variable('likepoints_enabled', 1);
    $amount = $this->request->variable('likepoints_amount', 1);
		$sql = 'UPDATE ' . FORUMS_TABLE . '
				SET likepoints_enabled = ' . $likepoints_enabled . ',
					likepoints_amount = ' . $amount .'
				WHERE forum_id = ' . $event['forum_data']['forum_id'];
		$this->db->sql_query($sql);
	}
}
