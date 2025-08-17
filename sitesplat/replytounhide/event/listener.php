<?php
/**
 *
 * @package ReplyToUnihde
 * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
 * @license Proprietary
 *
 */

namespace sitesplat\replytounhide\event;

use phpbb\controller\helper;
use phpbb\template\template;
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
	protected $user;
	protected $db;
	protected $ext_root_path;

	/**
	 * Constructor
	 *
	 */
	public function __construct(bbcodes_parser $bbcodes_parser, helper $helper, template $template, user $user, driver_interface $db, $ext_root_path)
	{
		$this->bbcodes_parser = $bbcodes_parser;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->db = $db;
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
			'core.viewtopic_assign_template_vars_before'	=> 'find_replies',
			'core.bbtranslate_translate_vars_before'		=> 'find_replies',
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
	 * Find topic_id of topic
	 */
	public function find_replies($event)
	{
		$sql = 'SELECT COUNT(post_id) AS replied FROM ' . POSTS_TABLE . ' WHERE topic_id = ' . $event['topic_id'] . ' AND poster_id = ' . $this->user->data['user_id'];
		$result = $this->db->sql_query($sql);
		$this->bbcodes_parser->replied = $this->db->sql_fetchfield('replied');
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
			$post_row['DECODED_MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!ies', '', $post_row['DECODED_MESSAGE']);
			$event['post_row'] = $post_row;
		}
	}

	/**
	 * Delete hidden at quote time
	 */
	public function delete_hidden($event)
	{
		if ($event['mode'] == 'quote')
		{
			$page_data  = $event['page_data'];
			$page_data['MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!ies', '', $page_data['MESSAGE']);
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
