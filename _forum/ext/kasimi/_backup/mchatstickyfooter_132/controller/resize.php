<?php

/**
 *
 * @package phpBB Extension - mChat Sticky Footer
 * @copyright (c) 2017 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatstickyfooter\controller;

use phpbb\db\driver\driver_interface as db_interface;
use phpbb\request\request_interface;
use phpbb\user;
use Symfony\Component\HttpFoundation\JsonResponse;

class resize
{
	const STICKY_DEFAULT_WIDTH = 400;
	const STICKY_DEFAULT_HEIGHT = 500;

	/** @var user */
	protected $user;

	/** @var request_interface */
	protected $request;

	/** @var db_interface */
	protected $db;

	/** @var string */
	protected $talbe_users;

	/**
	 *  Constructor
	 *
	 * @param user				$user
	 * @param request_interface	$request
	 * @param db_interface		$db
	 * @param string			$table_users
	 */
	public function __construct(
		user $user,
		request_interface $request,
		db_interface $db,
		$table_users
	)
	{
		$this->user			= $user;
		$this->request		= $request;
		$this->db			= $db;
		$this->table_users	= $table_users;
	}

	/**
	 * @return JsonResponse
	 */
	public function main()
	{
		if ($this->user->data['is_registered'])
		{
			$sticky_size = array(
				'mchat_sticky_width'	=> $this->request->variable('width', self::STICKY_DEFAULT_WIDTH),
				'mchat_sticky_height'	=> $this->request->variable('height', self::STICKY_DEFAULT_HEIGHT),
			);

			$sql = 'UPDATE ' . $this->table_users . '
				SET ' . $this->db->sql_build_array('UPDATE', $sticky_size) . '
				WHERE user_id = ' . (int) $this->user->data['user_id'];
			$this->db->sql_query($sql);
		}

		return new JsonResponse(array());
	}
}
