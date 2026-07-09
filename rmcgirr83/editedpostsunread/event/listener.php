<?php
/**
*
* @package Mark edited posts unread
* @copyright (c) 2015 RMcGirr83
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\editedpostsunread\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\db\driver\driver */
	protected $db;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpEx */
	protected $php_ext;

	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		$root_path,
		$php_ext)
	{
		$this->db		= $db;
		$this->root_path	= $root_path;
		$this->php_ext		= $php_ext;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.submit_post_end' => 'submit_post_end',
		);
	}

	public function submit_post_end($event)
	{
		if ($event['mode'] == 'edit')
		{
			// we need to ensure that what we are resetting is appropriate
			// do we care about when someone edits the first post of a topic?
			// $event['data']['topic_first_post_id'] == $event['data']['post_id'] $post_mode = 'edit_first_post'

			$ext_post_mode = '';
			if ($event['data']['topic_posts_approved'] + $event['data']['topic_posts_unapproved'] + $event['data']['topic_posts_softdeleted'] == 1)
			{
				$ext_post_mode = 'edit_topic';
			}
			else if ($event['data']['topic_last_post_id'] == $event['data']['post_id'])
			{
				$ext_post_mode = 'edit_last_post';
			}

			if ($ext_post_mode == 'edit_last_post' || $ext_post_mode == 'edit_topic')
			{
				$sql = 'UPDATE ' . POSTS_TABLE . '
					SET post_time = ' . time() . '
					WHERE post_id = ' . $event['data']['post_id'] . '
						AND topic_id = ' . $event['data']['topic_id'];
				$this->db->sql_query($sql);

				$sql = 'UPDATE ' . TOPICS_TABLE . '
					SET topic_last_post_time = ' . time() . '
					WHERE topic_id = ' . $event['data']['topic_id'];
				$this->db->sql_query($sql);

				if (!function_exists('update_post_information'))
				{
					include ($this->root_path . 'includes/functions_posting.' . $this->php_ext);
				}

				update_post_information('forum', $event['data']['forum_id']);
				markread('post', $event['data']['forum_id'], $event['data']['topic_id'], $event['data']['post_time']);
			}
		}
	}
}
