<?php
/**
 *
 * Time to Read. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\timetoread\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Time to Read Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewforum_get_topic_data'		=> 'add_word_count_to_query',
			'core.viewforum_modify_topicrow'	=> 'calculate_time_to_read',
		);
	}

	/* @var \phpbb\user */
	protected $user;

	/* @var string */
	protected $post_table;

	/**
	 * Constructor
	 *
	 * @param \phpbb\user	$user			User object
	 * @param string 		$posts_table	Posts table
	 */
	public function __construct(\phpbb\user $user, $posts_table)
	{
		$this->user = $user;
		$this->posts_table = $posts_table;
	}

	/**
	 * Modify SQL query to return topic word count
	 * Additionally, load language file
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function add_word_count_to_query($event)
	{
		$this->user->add_lang_ext('senky/timetoread', 'common');

		// roughly calculate word count for each topic
		$sql_array = $event['sql_array'];
		$sql_array['SELECT'] .= ', (
			SELECT SUM(LENGTH(p.post_text) - LENGTH(REPLACE(p.post_text, " ", "")) + 1)
			FROM ' . $this->posts_table . ' p
			WHERE p.topic_id = t.topic_id
		) as word_count';
		$event['sql_array'] = $sql_array;
	}

	/**
	 * Assign topicrow.TIME_TO_READ template variable
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function calculate_time_to_read($event)
	{
		$topic_row = $event['topic_row'];
		$topic_row['TIME_TO_READ'] = $this->user->lang('TIME_TO_READ', round($event['row']['word_count'] / 275));
		$event['topic_row'] = $topic_row;
	}
}
