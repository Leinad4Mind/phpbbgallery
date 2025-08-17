<?php
/**
 *
 * @package ReplyToUnihde
 * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
 * @license Proprietary
 *
 */

namespace sitesplat\replytounhide\core;

use phpbb\db\driver\driver_interface;
use phpbb\request\request;
use phpbb\user;

/**
 * Replytounhide ACP manager class
 */
class acp_manager
{
	protected $db;
	protected $request;
	protected $user;

	/**
	 * Constructor
	 */
	public function __construct(driver_interface $db, request $request, user $user)
	{
		$this->db = $db;
		$this->request = $request;
		$this->user = $user;
	}

	/**
	 * Retrieve the maximum value from the bbcode_order field stored in the db
	 */
	public function get_max_bbcode_order()
	{
		return $this->get_max_column_value('bbcode_order');
	}

	/**
	 * Retrieve the maximum value in a column from the bbcodes table
	 */
	protected function get_max_column_value($column)
	{
		$sql = 'SELECT MAX(' . $this->db->sql_escape($column) . ') AS maximum
			FROM ' . BBCODES_TABLE;
		$result = $this->db->sql_query($sql);
		$maximum = $this->db->sql_fetchfield('maximum');
		$this->db->sql_freeresult($result);

		return (int) $maximum;
	}

	/**
	 * Send a JSON response
	 */
	protected function send_json_response($content)
	{
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'success' => (bool) $content,
			));
		}
	}
}
