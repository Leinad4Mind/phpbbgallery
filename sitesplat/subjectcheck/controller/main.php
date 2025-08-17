<?php
/**
*
* @package subjectcheck
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\subjectcheck\controller;

use Symfony\Component\HttpFoundation\Response;

class main
{
	protected $request;
	protected $db;
	protected $subject_check;
	protected $forums_table;
	public function __construct(\phpbb\request\request $request, \phpbb\db\driver\driver_interface $db, \sitesplat\subjectcheck\core\subject_check $subject_check, $forums_table)
	{
		$this->request = $request;
		$this->db = $db;
		$this->subject_check = $subject_check;
		$this->forums_table = $forums_table;
	}

	public function handle($forum_id)
	{
		$sql = 'SELECT forum_subject_check
				FROM ' . $this->forums_table . '
				WHERE forum_id = ' . (int) $forum_id;
		$this->db->sql_query($sql);
		$forum_subject_check = $this->db->sql_fetchfield('forum_subject_check');

		$event = array(
			'post_data'	=> array(
				'post_subject'			=> $this->request->variable('subject', '', true),
				'forum_subject_check'	=> (int) $forum_subject_check,
			),
			'mode'		=> 'post',
			'forum_id'	=> $forum_id,
			'error'		=> array(),
		);
		list($subject, $bypass) = $this->subject_check->look_for_posts($event);

		die((empty($event['error'][0]) ? '' : $event['error'][0]) . '&subject=' . htmlspecialchars_decode($subject) . '&bypass=' . ($bypass ? 1 : 0));
	}
}
