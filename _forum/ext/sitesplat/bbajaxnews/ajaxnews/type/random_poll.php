<?php
/**
 *
 * BBajaxnews. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\bbajaxnews\ajaxnews\type;

class random_poll extends base
{
	protected $user;
	protected $topics_table;
	protected $poll_votes_table;
	public function set_dependencies(\phpbb\user $user, $topics_table, $poll_votes_table)
	{
		$this->user = $user;
		$this->topics_table = $topics_table;
		$this->poll_votes_table = $poll_votes_table;
	}

	public function get_type()
	{
		return 'sitesplat.bbajaxnews.ajaxnews.type.random_poll';
	}

	public function get_lang_array($data)
	{
		$forums_f_read = array_keys($this->auth->acl_getf('f_read', true));
		$forums_f_vote = array_keys($this->auth->acl_getf('f_vote', true));
		$forums = array_intersect($forums_f_read, $forums_f_vote);

		if (empty($forums))
		{
			return false;
		}

		$sql = 'SELECT t.topic_id, t.poll_title
				FROM ' . $this->topics_table . ' t
				WHERE t.poll_start <> 0
					AND ( (t.poll_length + t.poll_start) = poll_start 
						OR (t.poll_length + t.poll_start) < ' . time() . ' )
					AND ' . $this->db->sql_in_set('t.forum_id', $forums) . '
					AND (
						SELECT COUNT(pv.vote_user_id)
						FROM ' . $this->poll_votes_table . ' pv
						WHERE pv.topic_id = t.topic_id
							AND pv.vote_user_id = ' . $this->user->data['user_id'] . '
					) = 0
				ORDER BY ' . $this->sql_random();
		$result = $this->db->sql_query_limit($sql, 1);
		$poll = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$poll)
		{
			return false;
		}

		return [
			'<a href="' . generate_board_url() . '/' . append_sid('viewtopic.' . $this->php_ext, 't=' . $poll['topic_id']) . '">' . $poll['poll_title'] . '</a>',
		];
	}

	public function get_content($data = [])
	{
		$lang_ary = $this->get_lang_array($data);
		if ($lang_ary)
		{
			return $this->language->lang_array('SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_RANDOM_POLL', $lang_ary);
		}
		return $this->language->lang('SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_RANDOM_POLL_NONE');
	}

	public function is_special()
	{
		return false;
	}

	protected function sql_random()
	{
		switch ($this->db->get_sql_layer())
		{
			case 'oracle':
				return 'VALUE()';

			case 'postgres':
				return 'RANDOM()';

			// https://stackoverflow.com/a/35369410/2908600
			case 'sqlite':
			case 'sqlite3':
				return '(0.5 - RANDOM() / CAST(-9223372036854775808 AS REAL) / 2)';

			default:
				return 'RAND()';
		}
	}
}
