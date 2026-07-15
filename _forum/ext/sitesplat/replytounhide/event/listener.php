<?php
/**
 *
 * @package ReplyToUnhide
 * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
 * @license Proprietary
 *
 */

namespace sitesplat\replytounhide\event;

use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\auth\auth;
use phpbb\user;
use phpbb\db\driver\driver_interface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use sitesplat\replytounhide\core\bbcodes_parser;
use sitesplat\replytounhide\ext;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	protected $bbcodes_parser;
	protected $helper;
	protected $template;
	protected $auth;
	protected $user;
	protected $db;
	protected $table_likes;
	protected $ext_root_path;

	/**
	 * Constructor
	 *
	 */
	public function __construct(bbcodes_parser $bbcodes_parser, helper $helper, template $template, auth $auth, user $user, driver_interface $db, $table_likes, $ext_root_path)
	{
		$this->bbcodes_parser = $bbcodes_parser;
		$this->helper = $helper;
		$this->template = $template;
		$this->auth = $auth;
		$this->user = $user;
		$this->db = $db;
		$this->table_likes = $table_likes;
		$this->ext_root_path = $ext_root_path;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'								=> 'load_language_on_setup',

			// functions_content events
			'core.modify_text_for_display_before'			=> 'parse_bbcodes_before',
			'core.modify_text_for_display_after'			=> 'parse_bbcodes_after',

			// functions_display events
			'core.viewtopic_assign_template_vars_before'	=> 'find_replies_for_topic',
			'core.bbtranslate_translate_vars_before'		=> 'find_replies_for_topic',
			'core.posting_modify_message_text'				=> 'find_replies_for_post',

			'core.posting_modify_template_vars'				=> 'delete_hidden',
			'core.topic_review_modify_row'					=> 'delete_hidden_review',

			// message_parser events
			'core.modify_format_display_text_after'			=> 'parse_bbcodes_after',
		);
	}

	/**
	 * Load common files during user setup
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/replytounhide',
			'lang_set' => 'replytounhide',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Check if can skip
	 */
	public function check_can_skip($event, $type = 'topic')
	{
		$idAdmin = (bool) $this->auth->acl_get('a_');
		$isModerator = (bool) $this->auth->acl_get('m_', $event['forum_id']);
		$isSpecialGroup = ($this->user->data['group_id'] == 18 && in_array($event['forum_id'], array(127, 128, 129, 130, 131, 132, 175, 198)));
		$isPoster = (
			(int) $this->user->data['user_id'] === (
				$type === 'topic'
					? (int) (
						isset($event['topic_data'])
							? $event['topic_data']['topic_poster']
							: $event['row']['poster_id']
					)
					: (int) $event['post_data']['poster_id']
			)
		);

		if ($isSpecialGroup || $idAdmin || $isModerator || $isPoster) {
			$this->bbcodes_parser->replied = 1;
			return true;
		}

		return false;
	}

	/**
	 * Find post_id of post
	 */
	public function find_replies_for_topic($event)
	{
		$this->find_replies($event, 'topic');
	}

	/**
	 * Find post_id of post
	 */
	public function find_replies_for_post($event)
	{
		$this->find_replies($event, 'post');
	}

	/**
	 * Find post_id of topic or preview
	 */
	public function find_replies($event, $type = 'topic')
	{
		if (!$this->check_can_skip($event, $type) && $this->user->data['user_id'] != ANONYMOUS) {
			$post_id = $this->determine_post_id($event, $type);

			//Replies
			//$sql = 'SELECT COUNT(post_id) AS replied FROM ' . POSTS_TABLE . ' WHERE topic_id = ' . $event['topic_id'] . ' AND poster_id = ' . $this->user->data['user_id'];
			//Thanks For Posts
			//$sql = 'SELECT COUNT(post_id) AS replied FROM ' . $this->table_thanks . ' WHERE post_id = ' . $post_id . ' AND user_id = ' . $this->user->data['user_id'];
			//Like BB
			$sql = 'SELECT COUNT(post_id) AS replied FROM ' . $this->table_likes . ' WHERE post_id = ' . $post_id . ' AND user_id = ' . $this->user->data['user_id'];

			$result = $this->db->sql_query($sql);
			$this->bbcodes_parser->replied = $this->db->sql_fetchfield('replied');
		}
	}

	/**
	 * Determine post_id based on event data
	 */
	protected function determine_post_id($event, $type = 'topic')
	{
		if (empty($event[$type . '_data']['topic_first_post_id'])) {
			if (empty($event['post_data']['topic_first_post_id'])) {
				return $event['topic_id'];
			}
			return $event['post_data']['topic_first_post_id'];
		}
		return $event[$type . '_data']['topic_first_post_id'];
	}

	/**
	 * Delete hidden at review time
	 */
	public function delete_hidden_review($event)
	{
		if ($event['mode'] == 'topic_review')
		{
			(!$this->bbcodes_parser->replied) ? $this->find_replies($event) : null;
			$post_row  = $event['post_row'];
			$post_row['DECODED_MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!is', '- Conteúdo Protegido -', $post_row['DECODED_MESSAGE']);
			$event['post_row'] = $post_row;
		}
	}

	/**
	 * Delete hidden at quote time
	 */
	public function delete_hidden($event)
	{
		if ($event['mode'] == 'quote' && !$this->check_can_skip($event, 'post'))
		{
			$page_data  = $event['page_data'];
			$page_data['MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!is', '- Conteúdo Protegido -', $page_data['MESSAGE']);
			$event['page_data'] = $page_data;
		}
	}

	/**
	 * Alter BBCodes before they are processed by phpBB
	 */
	public function parse_bbcodes_before($event)
	{
		$event['text'] = $this->bbcodes_parser->pre_parse_bbcodes($event['text'], $event['uid']);
	}

	/**
	 * Alter BBCodes after they are processed by phpBB
	 */
	public function parse_bbcodes_after($event)
	{
		$event['text'] = $this->bbcodes_parser->post_parse_bbcodes($event['text']);
	}
}
