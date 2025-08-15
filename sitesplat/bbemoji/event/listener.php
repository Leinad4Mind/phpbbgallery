<?php

/**
* @package   BBemoji
* @copyright (c) 2015 SiteSplat All rights reserved
*/
namespace sitesplat\bbemoji\event;

use ReflectionClass;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $fallback;
	protected $generator;
	protected $template;
	protected $request;
	protected $user;
	protected $db;
	protected $emoji_icons_table;

	private $icons;

	public function __construct(array $generators, \phpbb\path_helper $pathHelper, \phpbb\template\template $template, \phpbb\request\request $request, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, $emoji_icons_table)
	{
		$webRootPath = $pathHelper->get_web_root_path();
		foreach ($generators as $k => $generator)
		{
			$generators[$k][1] = str_replace('$web_root_path$', $webRootPath, $generator[1]);
		}

		$this->generator = array_shift($generators);
		$this->fallback  = $generators;
		$this->template  = $template;
		$this->request  = $request;
		$this->user  = $user;
		$this->db  = $db;
		$this->emoji_icons_table  = $emoji_icons_table;
	}

	public static function getSubscribedEvents()
	{
		return array(
			'core.viewforum_get_topic_data'			  => array(array('loadIcons'), array('retrieve_enable_subject_emoji')),
			'core.viewtopic_before_f_read_check'	  => 'loadIcons',
			'core.message_parser_check_message'       => 'onCheck',
			'core.modify_format_display_text_after'   => 'onPreview',
			'core.posting_modify_template_vars'		  => array(array('onPreviewSubject'), array('replaceTopicIcons')),
			'core.modify_submit_post_data'            => 'onSubmit',
			'core.modify_text_for_display_after'      => 'onDisplay',
			'core.viewtopic_modify_page_title'		  => 'onViewtopicDisplayTopicSubject',
			'core.viewtopic_modify_post_row'		  => 'onViewtopicDisplayPostSubject',
			'core.display_forums_modify_template_vars'=> 'onLastPostDisplayPostSubject',
			'core.viewforum_modify_topicrow'		  => 'onViewforumDisplayPostSubject',
			'core.search_modify_tpl_ary'			  => 'onSearchDisplaySubject',
			'core.mcp_topic_review_modify_row'		  => 'onMcpDisplaySubject',
			'core.mcp_post_template_data'		 	  => 'onMcpPostDisplaySubject',
			'core.mcp_queue_get_posts_for_posts_query_before'	=> 'onMcpQueuePostQuery',
			'core.mcp_queue_get_posts_modify_post_row'			=> 'onMcpQueuePostDisplaySubject',
			'core.mcp_queue_get_posts_for_topics_query_before'	=> 'onMcpQueueTopicQuery',
			'core.modify_text_for_storage_after'      => 'onStorage',
			'core.text_formatter_s9e_configure_after' => 'onConfigure',
			'core.text_formatter_s9e_parser_setup'    => 'onParserSetup',
			'core.submit_pm_before'                   => 'onPmStorage',
			'core.ucp_main_topiclist_topic_modify_template_vars'	=> 'onBookmarks',
			'core.posting_modify_post_data'				=> 'allow_subject_emoji',
			'core.viewtopic_post_rowset_data'		=> 'keep_icons',
			'core.topic_review_modify_row'			=> 'topic_review',
			'core.display_user_activity_modify_actives'	=> 'memberlist_view_parse_topic',

			'core.acp_manage_forums_request_data'		=> 'acp_request_enable_subject_emoji',
			'core.acp_manage_forums_initialise_data'	=> 'acp_init_enable_subject_emoji',
			'core.acp_manage_forums_display_form'		=> 'acp_tpl_enable_subject_emoji',

			'core.viewforum_get_announcement_topic_ids_data'	=> 'remove_duplicate_forum_join',
			'core.search_get_posts_data'						=> 'retrieve_search_post_enable_subject_emoji',
			'core.search_get_topic_data'						=> 'retrieve_search_topic_enable_subject_emoji',
		);
	}

	public function memberlist_view_parse_topic($event)
	{
		$active_t_row = $event['active_t_row'];
		$active_t_row['topic_title'] = $this->render($this->parse($active_t_row['topic_title']));
		$event['active_t_row'] = $active_t_row;
	}

	public function topic_review($event)
	{
		$post_row = $event['post_row'];
		$post_row['POST_SUBJECT'] = $this->render($this->parse($post_row['POST_SUBJECT']));
		$event['post_row'] = $post_row;
	}

	public function keep_icons($event)
	{
		$rowset_data = $event['rowset_data'];
		$rowset_data['emoji_icon_id'] = $event['row']['icon_id'];
		$event['rowset_data'] = $rowset_data;
	}

	public function allow_subject_emoji($event)
	{
		if ($event['post_data']['enable_subject_emoji'])
		{
			$this->template->assign_var('S_SUBJECT_EMOJI', true);
		}
	}

	public function acp_request_enable_subject_emoji($event)
	{
		$forum_data = $event['forum_data'];
		$forum_data['enable_subject_emoji'] = $this->request->variable('enable_subject_emoji', false);
		$event['forum_data'] = $forum_data;
	}

	public function acp_init_enable_subject_emoji($event)
	{
		$forum_data = $event['forum_data'];
		$forum_data['enable_subject_emoji'] = isset($event['forum_data']['enable_subject_emoji']) ? $event['forum_data']['enable_subject_emoji'] : false;
		$event['forum_data'] = $forum_data;
	}

	public function acp_tpl_enable_subject_emoji($event)
	{
		$template_data = $event['template_data'];
		$template_data['S_SUBJECT_EMOJI'] = ($event['forum_data']['enable_subject_emoji']) ? true : false;
		$event['template_data'] = $template_data;
	}

	public function retrieve_enable_subject_emoji($event)
	{
		$sql_array = $event['sql_array'];
		$sql_array['SELECT'] .= ', f.enable_subject_emoji';
		$sql_array['LEFT_JOIN'][] = array('FROM' => array(FORUMS_TABLE => 'f'), 'ON' => 't.forum_id = f.forum_id');
		$event['sql_array'] = $sql_array;
	}

	public function remove_duplicate_forum_join($event)
	{
		$sql_ary = $event['sql_ary'];
		unset($sql_ary['LEFT_JOIN'][0]);
		$event['sql_ary'] = $sql_ary;
	}

	public function retrieve_search_post_enable_subject_emoji($event)
	{
		$sql_array = $event['sql_array'];
		$sql_array['SELECT'] .= ', f.enable_subject_emoji';
		$event['sql_array'] = $sql_array;
	}

	public function retrieve_search_topic_enable_subject_emoji($event)
	{
		$event['sql_select'] .= ', f.enable_subject_emoji';
	}

	public function loadIcons()
	{
		$sql = 'SELECT *
				FROM ' . $this->emoji_icons_table;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			if (substr($row['icons_emoji'], 0, 1) !== ':')
			{
				$img_src = generate_board_url() . '/' . $row['icons_emoji'];
			}
			else
			{
				$parsed = $this->parse($row['icons_emoji']);
				preg_match('/<!-- sitesplat:bbemoji:([-0-9a-f]+) -->/', $parsed, $match);
				$img_src = $this->getUrl($match[1], $this->generator);
			}

			$this->icons[$row['icons_id']] = $img_src;
		}

		$this->template->assign_var('S_BBEMOJI', true);
	}

	public function replaceTopicIcons($event)
	{
		$this->template->destroy_block_vars('topic_icon');

		$sql = 'SELECT *
				FROM ' . $this->emoji_icons_table . '
				WHERE display_on_posting = 1';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			if (substr($row['icons_emoji'], 0, 1) !== ':')
			{
				$img_src = generate_board_url() . '/' . $row['icons_emoji'];
			}
			else
			{
				$parsed = $this->parse($row['icons_emoji']);
				preg_match('/<!-- sitesplat:bbemoji:([-0-9a-f]+) -->/', $parsed, $match);
				$img_src = $this->getUrl($match[1], $this->generator);
			}
			
			$this->template->assign_block_vars('topic_icon', array(
				'ICON_ID'		=> $row['icons_id'],
				'ICON_IMG'		=> $img_src,
				'ICON_WIDTH'	=> 20,
				'ICON_HEIGHT'	=> 20,
				'ICON_ALT'		=> $row['icons_emoji'],

				'S_CHECKED'			=> ($row['icons_id'] == $event['post_data']['icon_id']) ? true : false,
				'S_ICON_CHECKED'	=> ($row['icons_id'] == $event['post_data']['icon_id']) ? ' checked="checked"' : '',
			));
		}
	}

	public function onCheck($event)
	{
		if (phpbb_version_compare(PHPBB_VERSION, '3.2', '<'))
		{
			$event['message'] = self::encodeUnicodeSupplementaryCharacters($event['message']);
		}
	}

	public function onConfigure($event)
	{
		$tag = $event['configurator']->Emoji->getTag();
		$tag->template = '<xsl:choose><xsl:when test="$S_VIEWSMILIES">' . $this->renderEmoji('{@seq}', '{.}', true) . '</xsl:when><xsl:otherwise><xsl:value-of select="."/></xsl:otherwise></xsl:choose>';
	}

	public function onDisplay($event)
	{
		$event['text'] = $this->render($event['text']);
	}

	public function onViewtopicDisplayTopicSubject($event)
	{
		if ($event['topic_data']['enable_subject_emoji'])
		{
			$this->template->assign_vars(array(
				'TOPIC_TITLE'			=> $this->render($this->parse($event['topic_data']['topic_title'])),
				'TOPIC_TITLE_UNPARSED'	=> $event['topic_data']['topic_title'],
			));
		}
	}

	public function onViewtopicDisplayPostSubject($event)
	{
		$post_row = $event['post_row'];
		if ($event['topic_data']['enable_subject_emoji'])
		{
			$post_row['POST_SUBJECT'] = $this->render($this->parse($post_row['POST_SUBJECT']));
		}
		if (!empty($post_row['POST_ICON_IMG']))
		{
			$post_row['POST_ICON_IMG'] = !empty($this->icons[$event['row']['emoji_icon_id']]) ? $this->icons[$event['row']['emoji_icon_id']] : '';
			$post_row['POST_ICON_IMG_WIDTH'] = 20;
			$post_row['POST_ICON_IMG_HEIGHT'] = 20;
			$post_row['POST_ICON_IMG_ALT'] = '';
		}
		$event['post_row'] = $post_row;
	}

	public function onLastPostDisplayPostSubject($event)
	{
		if ($event['row']['enable_subject_emoji'])
		{
			$forum_row = $event['forum_row'];
			$last_post_subject = $this->render($this->parse($forum_row['LAST_POST_SUBJECT']));
			if ($forum_row['LAST_POST_SUBJECT'] != $last_post_subject) // we have emoji in subject!
			{
				$forum_row['LAST_POST_SUBJECT'] = $forum_row['LAST_POST_SUBJECT'];
				// We don't truncate subject. This is a price to have emoji in subject.
				$forum_row['LAST_POST_SUBJECT_TRUNCATED'] = $last_post_subject;
			}
			$event['forum_row'] = $forum_row;
		}
	}

	public function onViewforumDisplayPostSubject($event)
	{
		$topic_row = $event['topic_row'];
		if ($event['row']['enable_subject_emoji'])
		{
			$topic_row['TOPIC_TITLE'] = $this->render($this->parse($topic_row['TOPIC_TITLE']));
		}
		$topic_row['TOPIC_ICON_IMG'] = !empty($this->icons[$event['row']['icon_id']]) ? $this->icons[$event['row']['icon_id']] : '';
		$topic_row['TOPIC_ICON_IMG_WIDTH'] = 20;
		$topic_row['TOPIC_ICON_IMG_HEIGHT'] = 20;
		$event['topic_row'] = $topic_row;
	}

	public function onSearchDisplaySubject($event)
	{
		if ($event['row']['enable_subject_emoji'])
		{
			$tpl_ary = $event['tpl_ary'];
			if (isset($event['row']['post_subject']))
			{
				$tpl_ary['POST_SUBJECT'] = $this->render($this->parse($event['row']['post_subject']));
			}
			$tpl_ary['TOPIC_TITLE'] = $this->render($this->parse($event['topic_title']));
			$event['tpl_ary'] = $tpl_ary;
		}
	}

	public function onMcpDisplaySubject($event)
	{
		if ($event['topic_info']['enable_subject_emoji'])
		{
			$post_row = $event['post_row'];
			$post_row['POST_SUBJECT'] = $this->render($this->parse($post_row['POST_SUBJECT']));
			$event['post_row'] = $post_row;
	
			$topic_info = $event['topic_info'];
			$topic_info['topic_title'] = $this->render($this->parse($topic_info['topic_title']));
			$event['topic_info'] = $topic_info;
		}
	}

	public function onMcpPostDisplaySubject($event)
	{
		if ($event['post_info']['enable_subject_emoji'])
		{
			$mcp_post_template_data = $event['mcp_post_template_data'];
			$mcp_post_template_data['POST_SUBJECT'] = $this->render($this->parse($event['post_info']['post_subject']));
			$event['mcp_post_template_data'] = $mcp_post_template_data;
		}
	}

	public function onMcpQueuePostQuery($event)
	{
		$event['sql'] = str_replace('u.user_colour', 'u.user_colour, f.enable_subject_emoji', $event['sql']);
		$event['sql'] = str_replace(TOPICS_TABLE . ' t', TOPICS_TABLE . ' t, ' . FORUMS_TABLE . ' f', $event['sql']);
		$event['sql'] = str_replace('AND u.user_id = p.poster_id', 'AND u.user_id = p.poster_id AND p.forum_id = f.forum_id', $event['sql']);
	}

	public function onMcpQueuePostDisplaySubject($event)
	{
		if ($event['row']['enable_subject_emoji'])
		{
			$post_row = $event['post_row'];
			$post_row['POST_SUBJECT'] = $this->render($this->parse($post_row['POST_SUBJECT']));
			$post_row['TOPIC_TITLE'] = $this->render($this->parse($post_row['TOPIC_TITLE']));
			$event['post_row'] = $post_row;
		}
	}

	public function onMcpQueueTopicQuery($event)
	{
		$event['sql'] = str_replace('AS user_colour', 'AS user_colour, f.enable_subject_emoji', $event['sql']);
		$event['sql'] = str_replace(TOPICS_TABLE . ' t', TOPICS_TABLE . ' t, ' . FORUMS_TABLE . ' f', $event['sql']);
		$event['sql'] = str_replace('AND topic_delete_user <> 0', 'AND topic_delete_user <> 0 AND t.forum_id = f.forum_id', $event['sql']);
		// fix ambiguity
		$event['sql'] = str_replace('WHERE forum_id', 'WHERE t.forum_id', $event['sql']);
	}

	public function onParserSetup($event)
	{
		$className = 's9e\\TextFormatter\\Plugins\\Emoji\\Parser';
		$propName  = 'map';
		if (!class_exists($className))
		{
			return;
		}

		$reflectionClass = new ReflectionClass($className);
		if ($reflectionClass->hasProperty($propName))
		{
			$reflectionProp = $reflectionClass->getProperty($propName);
			$reflectionProp->setAccessible(true);
			$reflectionProp->setValue($reflectionProp->getValue() + self::$map);
		}
	}

	public function onPmStorage($event)
	{
		$data = $event['data'];
		$data['message'] = $this->parse($data['message']);
		$event['data'] = $data;
	}

	public function onPreview($event)
	{
		$event['text'] = $this->render($this->parse($event['text']));
	}

	public function onPreviewSubject($event)
	{
		if ($event['post_data']['enable_subject_emoji'])
		{
			if ($event['preview'])
			{
				$this->template->assign_vars(array(
					'PREVIEW_SUBJECT'	=> $this->render($this->parse($this->request->variable('subject', '', true))),
				));
			}

			$page_data = $event['page_data'];
			$page_data['TOPIC_TITLE'] = $this->render($this->parse($page_data['TOPIC_TITLE']));
			$event['page_data'] = $page_data;
		}
	}

	public function onStorage($event)
	{
		$event['text'] = $this->parse($event['text']);
	}

	public function onSubmit($event)
	{
		$data = $event['data'];
		$data['message'] = $this->parse($data['message']);
		$event['data'] = $data;
	}

	public function onBookmarks($event)
	{
		$template_vars = $event['template_vars'];
		$template_vars['LAST_POST_SUBJECT'] = $this->render($this->parse($template_vars['LAST_POST_SUBJECT']));
		$template_vars['TOPIC_TITLE'] = $this->render($this->parse($template_vars['TOPIC_TITLE']));
		$event['template_vars'] = $template_vars;
	}

	protected static function decodeNumericEntities($text)
	{
		if (strpos($text, "&#") === false)
		{
			return $text;
		}

		return preg_replace_callback(
			'(&#[0-9]+;)',
			__CLASS__ . '::decodeNumericEntitiesCallback',
			$text
		);
	}

	protected static function decodeNumericEntitiesCallback($m)
	{
		return html_entity_decode($m[0], ENT_NOQUOTES, 'UTF-8');
	}

	protected static function encodeUnicodeSupplementaryCharacters($str)
	{
		return preg_replace_callback(
			'([\\xF0-\\xF4]...)S',
			__CLASS__ . '::encodeUnicodeSupplementaryCharactersCallback',
			$str
		);
	}

	protected static function encodeUnicodeSupplementaryCharactersCallback(array $m)
	{
		$utf8 = $m[0];
		$cp   = ((ord($utf8[0]) & 7)  << 18)
		      | ((ord($utf8[1]) & 63) << 12)
		      | ((ord($utf8[2]) & 63) << 6)
		      | (ord($utf8[3]) & 63);

		return '&#' . $cp . ';';
	}

	protected function getEmojiOneFilename($seq, $ext)
	{
		if (strpos($seq, '-20e3') !== false || $seq === 'a9' || $seq === 'ae')
		{
			$seq = '00' . $seq;
		}

		return $seq . '.' . $ext;
	}

	protected function getErrorHandler($seq, $fallback)
	{
		$onerror = '';
		foreach ($fallback as $generator)
		{
			$onerror .= "src='" . $this->getUrl($seq, $generator) . "';onerror=function(){";
		}
		$onerror .= 'parentNode.replaceChild(document.createTextNode(alt),this)' . str_repeat('}', count($fallback));

		return $onerror;
	}

	protected function getGemojiFilename($seq, $ext)
	{
		if (strpos($seq, '-20e3') !== false || $seq === 'a9' || $seq === 'ae')
		{
			$seq = '00' . $seq;
		}

		return $seq . '.' . $ext;
	}

	protected function getSequence($str)
	{
		$str = str_replace("\xEF\xB8\x8F", '', $str);
		$seq = array();
		$i   = 0;
		do
		{
			$cp = ord($str[$i]);
			if ($cp >= 240)
			{
				$cp = (($cp & 7) << 18) | ((ord($str[++$i]) & 63) << 12) | ((ord($str[++$i]) & 63) << 6) | (ord($str[++$i]) & 63);
			}
			elseif ($cp >= 224)
			{
				$cp = (($cp & 15) << 12) | ((ord($str[++$i]) & 63) << 6) | (ord($str[++$i]) & 63);
			}
			elseif ($cp >= 192)
			{
				$cp = (($cp & 15) << 6) | (ord($str[++$i]) & 63);
			}
			$seq[] = dechex($cp);
		}
		while (++$i < strlen($str));

		return implode('-', $seq);
	}

	protected function getTwemojiFilename($seq, $ext)
	{
		return $seq . '.' . $ext;
	}

	protected function getUrl($seq, $generator)
	{
		list($set, $url, $ext) = $generator;
		$methodName = 'get' . $set . 'Filename';

		return $url . call_user_func(array($this, $methodName), $seq, $ext);
	}

	public function parse($text)
	{
		if (preg_match('(^<[rt][ />])', $text))
		{
			return $text;
		}

		$text = $this->replaceAsciiEmoji($text);
		$text = $this->replaceUnicodeEmoji($text);

		return $this->encodeUnicodeSupplementaryCharacters($text);
	}

	public function render($text)
	{
		global $user;
		if (strpos($text, '<!-- sitesplat:bbemoji') === false || !$user->optionget('viewsmilies'))
		{
			return $text;
		}

		return preg_replace_callback(
			'(<!-- sitesplat:bbemoji:([-0-9a-f]+) -->(.*?)<!-- /sitesplat:bbemoji -->)',
			array($this, 'renderCallback'),
			$text
		);
	}

	protected function unparse($text)
	{
		return preg_replace(
			'(<!-- sitesplat:bbemoji:([-0-9a-f]+) -->(.*?)<!-- /sitesplat:bbemoji -->)',
			'\2',
			$text
		);
	}

	protected function renderCallback($m)
	{
		return $this->renderEmoji($m[1], $m[2]);
	}

	protected function renderEmoji($seq, $alt, $xsl = false)
	{
		$src     = $this->getUrl($seq, $this->generator);
		$onerror = $this->getErrorHandler($seq, $this->fallback);

		if ($xsl)
		{
			$onerror = str_replace('function(){', 'function(){{', $onerror) . '}';
		}

		return '<img alt="' . $alt . '" class="emoji" draggable="false" height="20" onerror="' . $onerror . '" src="' . $src . '" width="20"' . (($xsl) ? '/>' : '>');
	}

	protected function replaceAsciiEmoji($text)
	{
		if (strpos($text, ':') === false)
		{
			return $text;
		}

		return preg_replace_callback(
			'(:([-+_a-z0-9]+):(?!\\w|[^<>]*(?=>|</code>)))',
			array($this, 'replaceAsciiEmojiCallback'),
			$text
		);
	}

	protected function replaceAsciiEmojiCallback($m)
	{
		$shortName = $m[1];
		if (!isset(self::$map[$shortName]))
		{
			return $m[0];
		}

		return '<!-- sitesplat:bbemoji:' . self::$map[$shortName] . ' -->' . $m[0] . '<!-- /sitesplat:bbemoji -->';
	}

	protected function replaceUnicodeEmoji($text)
	{
		$text = self::decodeNumericEntities($text);
		if (strpos($text, "\xE2") === false && strpos($text, "\xEF") === false && strpos($text, "\xF0") === false)
		{
			return $text;
		}
		$text = preg_replace_callback(
			$this->unicodeRegexp,
			array($this, 'replaceUnicodeEmojiCallback'),
			$text
		);

		return $this->encodeUnicodeSupplementaryCharacters($text);
	}

	protected function replaceUnicodeEmojiCallback($m)
	{
		$seq = $this->getSequence($m[0]);

		return '<!-- sitesplat:bbemoji:' . $seq . ' -->' . $m[0] . '<!-- /sitesplat:bbemoji -->';
	}

	protected static $map = array('-1'=>'1f44e','+1'=>'1f44d','8ball'=>'1f3b1','a'=>'1f170','ab'=>'1f18e','abc'=>'1f524','abcd'=>'1f521','ac'=>'1f1e6-1f1e8','accept'=>'1f251','ad'=>'1f1e6-1f1e9','admission_tickets'=>'1f39f','ae'=>'1f1e6-1f1ea','aerial_tramway'=>'1f6a1','af'=>'1f1e6-1f1eb','ag'=>'1f1e6-1f1ec','ai'=>'1f1e6-1f1ee','airplane'=>'2708','airplane_arriving'=>'1f6ec','airplane_departure'=>'1f6eb','airplane_northeast'=>'1f6ea','airplane_small'=>'1f6e9','airplane_small_up'=>'1f6e8','airplane_up'=>'1f6e7','al'=>'1f1e6-1f1f1','alarm_clock'=>'23f0','alien'=>'1f47d','am'=>'1f1e6-1f1f2','ambulance'=>'1f691','anchor'=>'2693','angel'=>'1f47c','anger'=>'1f4a2','anger_left'=>'1f5ee','anger_right'=>'1f5ef','angry'=>'1f620','anguished'=>'1f627','ant'=>'1f41c','ao'=>'1f1e6-1f1f4','apple'=>'1f34e','aquarius'=>'2652','ar'=>'1f1e6-1f1f7','aries'=>'2648','arrow_backward'=>'25c0','arrow_double_down'=>'23ec','arrow_double_up'=>'23eb','arrow_down'=>'2b07','arrow_down_small'=>'1f53d','arrow_forward'=>'25b6','arrow_heading_down'=>'2935','arrow_heading_up'=>'2934','arrow_left'=>'2b05','arrow_lower_left'=>'2199','arrow_lower_right'=>'2198','arrow_right'=>'27a1','arrow_right_hook'=>'21aa','arrow_up'=>'2b06','arrow_up_down'=>'2195','arrow_up_small'=>'1f53c','arrow_upper_left'=>'2196','arrow_upper_right'=>'2197','arrows_clockwise'=>'1f503','arrows_counterclockwise'=>'1f504','art'=>'1f3a8','articulated_lorry'=>'1f69b','ascending_notes'=>'1f39c','astonished'=>'1f632','at'=>'1f1e6-1f1f9','athletic_shoe'=>'1f45f','atm'=>'1f3e7','au'=>'1f1e6-1f1fa','aw'=>'1f1e6-1f1fc','az'=>'1f1e6-1f1ff','b'=>'1f171','ba'=>'1f1e7-1f1e6','baby'=>'1f476','baby_bottle'=>'1f37c','baby_chick'=>'1f424','baby_symbol'=>'1f6bc','back'=>'1f519','back_of_envelope'=>'1f582','baggage_claim'=>'1f6c4','balloon'=>'1f388','ballot_box'=>'1f5f3','ballot_box_check'=>'1f5f9','ballot_box_with_ballot'=>'1f5f3','ballot_box_with_bold_check'=>'1f5f9','ballot_box_with_check'=>'2611','ballot_box_with_script_x'=>'1f5f5','ballot_box_x'=>'1f5f5','ballot_script_x'=>'1f5f4','ballot_x'=>'1f5f4','bamboo'=>'1f38d','banana'=>'1f34c','bangbang'=>'203c','bank'=>'1f3e6','bar_chart'=>'1f4ca','barber'=>'1f488','baseball'=>'26be','basketball'=>'1f3c0','bath'=>'1f6c0','bathtub'=>'1f6c1','battery'=>'1f50b','bb'=>'1f1e7-1f1e7','bd'=>'1f1e7-1f1e9','be'=>'1f1e7-1f1ea','beach'=>'1f3d6','beach_with_umbrella'=>'1f3d6','bear'=>'1f43b','bed'=>'1f6cf','bee'=>'1f41d','beer'=>'1f37a','beers'=>'1f37b','beetle'=>'1f41e','beginner'=>'1f530','bell'=>'1f514','bellhop'=>'1f6ce','bellhop_bell'=>'1f6ce','bento'=>'1f371','bf'=>'1f1e7-1f1eb','bg'=>'1f1e7-1f1ec','bh'=>'1f1e7-1f1ed','bi'=>'1f1e7-1f1ee','bicyclist'=>'1f6b4','bike'=>'1f6b2','bikini'=>'1f459','bird'=>'1f426','birthday'=>'1f382','bj'=>'1f1e7-1f1ef','black_circle'=>'26ab','black_hard_shell_floppy_disk'=>'1f5aa','black_joker'=>'1f0cf','black_large_square'=>'2b1b','black_medium_small_square'=>'25fe','black_medium_square'=>'25fc','black_nib'=>'2712','black_pennant'=>'1f3f2','black_skull_and_crossbones'=>'1f571','black_small_square'=>'25aa','black_square_button'=>'1f532','black_touchtone_telephone'=>'1f57f','blossom'=>'1f33c','blowfish'=>'1f421','blue_book'=>'1f4d8','blue_car'=>'1f699','blue_heart'=>'1f499','blush'=>'1f60a','bm'=>'1f1e7-1f1f2','bn'=>'1f1e7-1f1f3','bo'=>'1f1e7-1f1f4','boar'=>'1f417','boat'=>'26f5','bomb'=>'1f4a3','book'=>'1f4d6','book2'=>'1f56e','bookmark'=>'1f516','bookmark_tabs'=>'1f4d1','books'=>'1f4da','boom'=>'1f4a5','boot'=>'1f462','bouquet'=>'1f490','bouquet2'=>'1f395','bouquet_of_flowers'=>'1f395','bow'=>'1f647','bowling'=>'1f3b3','boy'=>'1f466','boys_symbol'=>'1f6c9','br'=>'1f1e7-1f1f7','bread'=>'1f35e','bride_with_veil'=>'1f470','bridge_at_night'=>'1f309','briefcase'=>'1f4bc','broken_heart'=>'1f494','bs'=>'1f1e7-1f1f8','bt'=>'1f1e7-1f1f9','bug'=>'1f41b','building_construction'=>'1f3d7','bulb'=>'1f4a1','bullettrain_front'=>'1f685','bullettrain_side'=>'1f684','bullhorn'=>'1f56b','bullhorn_waves'=>'1f56c','bullhorn_with_sound_waves'=>'1f56c','bus'=>'1f68c','busstop'=>'1f68f','bust_in_silhouette'=>'1f464','busts_in_silhouette'=>'1f465','bw'=>'1f1e7-1f1fc','by'=>'1f1e7-1f1fe','bz'=>'1f1e7-1f1ff','ca'=>'1f1e8-1f1e6','cactus'=>'1f335','cake'=>'1f370','calculator'=>'1f5a9','calendar'=>'1f4c6','calendar_spiral'=>'1f5d3','calling'=>'1f4f2','camel'=>'1f42b','camera'=>'1f4f7','camera_with_flash'=>'1f4f8','camping'=>'1f3d5','cancellation_x'=>'1f5d9','cancer'=>'264b','candle'=>'1f56f','candy'=>'1f36c','capital_abcd'=>'1f520','capricorn'=>'2651','car'=>'1f697','card_box'=>'1f5c3','card_file_box'=>'1f5c3','card_index'=>'1f4c7','card_index_dividers'=>'1f5c2','carousel_horse'=>'1f3a0','cartridge'=>'1f5ad','cat'=>'1f431','cat2'=>'1f408','cd'=>'1f4bf','celtic_cross'=>'1f548','cf'=>'1f1e8-1f1eb','cg'=>'1f1e8-1f1ec','ch'=>'1f1e8-1f1ed','chart'=>'1f4b9','chart_with_downwards_trend'=>'1f4c9','chart_with_upwards_trend'=>'1f4c8','checkered_flag'=>'1f3c1','cherries'=>'1f352','cherry_blossom'=>'1f338','chestnut'=>'1f330','chicken'=>'1f414','children_crossing'=>'1f6b8','chile'=>'1f1e8-1f1f1','chipmunk'=>'1f43f','chocolate_bar'=>'1f36b','christmas_tree'=>'1f384','church'=>'26ea','ci'=>'1f1e8-1f1ee','cinema'=>'1f3a6','circled_information_source'=>'1f6c8','circus_tent'=>'1f3aa','city_dusk'=>'1f306','city_sunrise'=>'1f307','city_sunset'=>'1f306','cityscape'=>'1f3d9','cl'=>'1f191','clamshell_mobile_phone'=>'1f581','clap'=>'1f44f','clapper'=>'1f3ac','classical_building'=>'1f3db','clipboard'=>'1f4cb','clock'=>'1f570','clock1'=>'1f550','clock10'=>'1f559','clock1030'=>'1f565','clock11'=>'1f55a','clock1130'=>'1f566','clock12'=>'1f55b','clock1230'=>'1f567','clock130'=>'1f55c','clock2'=>'1f551','clock230'=>'1f55d','clock3'=>'1f552','clock330'=>'1f55e','clock4'=>'1f553','clock430'=>'1f55f','clock5'=>'1f554','clock530'=>'1f560','clock6'=>'1f555','clock630'=>'1f561','clock7'=>'1f556','clock730'=>'1f562','clock8'=>'1f557','clock830'=>'1f563','clock9'=>'1f558','clock930'=>'1f564','clockwise_arrows'=>'1f5d8','clockwise_right_and_left_semicircle_arrows'=>'1f5d8','closed_book'=>'1f4d5','closed_lock_with_key'=>'1f510','closed_umbrella'=>'1f302','cloud'=>'2601','cloud_lightning'=>'1f329','cloud_rain'=>'1f327','cloud_snow'=>'1f328','cloud_tornado'=>'1f32a','cloud_with_lightning'=>'1f329','cloud_with_rain'=>'1f327','cloud_with_snow'=>'1f328','cloud_with_tornado'=>'1f32a','clubs'=>'2663','cm'=>'1f1e8-1f1f2','cn'=>'1f1e8-1f1f3','co'=>'1f1e8-1f1f4','cocktail'=>'1f378','coffee'=>'2615','cold_sweat'=>'1f630','collision'=>'1f4a5','compression'=>'1f5dc','computer'=>'1f4bb','computer_old'=>'1f5b3','confetti_ball'=>'1f38a','confounded'=>'1f616','confused'=>'1f615','congo'=>'1f1e8-1f1e9','congratulations'=>'3297','construction'=>'1f6a7','construction_worker'=>'1f477','control_knobs'=>'1f39b','contruction_site'=>'1f3d7','convenience_store'=>'1f3ea','cookie'=>'1f36a','cool'=>'1f192','cop'=>'1f46e','copyright'=>'a9','corn'=>'1f33d','couch'=>'1f6cb','couch_and_lamp'=>'1f6cb','couple'=>'1f46b','couple_mm'=>'1f468-2764-1f468','couple_with_heart'=>'1f491','couple_with_heart_mm'=>'1f468-2764-1f468','couple_with_heart_ww'=>'1f469-2764-1f469','couple_ww'=>'1f469-2764-1f469','couplekiss'=>'1f48f','couplekiss_mm'=>'1f468-2764-1f48b-1f468','couplekiss_ww'=>'1f469-2764-1f48b-1f469','cow'=>'1f42e','cow2'=>'1f404','cr'=>'1f1e8-1f1f7','crayon'=>'1f58d','credit_card'=>'1f4b3','crescent_moon'=>'1f319','crocodile'=>'1f40a','cross_heavy'=>'1f547','cross_white'=>'1f546','crossbones'=>'1f571','crossed_flags'=>'1f38c','crown'=>'1f451','cruise_ship'=>'1f6f3','cry'=>'1f622','crying_cat_face'=>'1f63f','crystal_ball'=>'1f52e','cu'=>'1f1e8-1f1fa','cupid'=>'1f498','curly_loop'=>'27b0','currency_exchange'=>'1f4b1','curry'=>'1f35b','custard'=>'1f36e','customs'=>'1f6c3','cv'=>'1f1e8-1f1fb','cy'=>'1f1e8-1f1fe','cyclone'=>'1f300','cz'=>'1f1e8-1f1ff','dagger'=>'1f5e1','dagger_knife'=>'1f5e1','dancer'=>'1f483','dancers'=>'1f46f','dango'=>'1f361','dark_sunglasses'=>'1f576','dart'=>'1f3af','dash'=>'1f4a8','date'=>'1f4c5','de'=>'1f1e9-1f1ea','deciduous_tree'=>'1f333','department_store'=>'1f3ec','derelict_house_building'=>'1f3da','descending_notes'=>'1f39d','desert'=>'1f3dc','desert_island'=>'1f3dd','desktop'=>'1f5a5','desktop_computer'=>'1f5a5','desktop_window'=>'1f5d4','diamond_shape_with_a_dot_inside'=>'1f4a0','diamonds'=>'2666','diesel_locomotive'=>'1f6f2','disappointed'=>'1f61e','disappointed_relieved'=>'1f625','dividers'=>'1f5c2','dizzy'=>'1f4ab','dizzy_face'=>'1f635','dj'=>'1f1e9-1f1ef','dk'=>'1f1e9-1f1f0','dm'=>'1f1e9-1f1f2','do'=>'1f1e9-1f1f4','do_not_litter'=>'1f6af','document'=>'1f5ce','document_text'=>'1f5b9','document_with_text'=>'1f5b9','dog'=>'1f436','dog2'=>'1f415','dollar'=>'1f4b5','dolls'=>'1f38e','dolphin'=>'1f42c','door'=>'1f6aa','doughnut'=>'1f369','dove'=>'1f54a','dove_of_peace'=>'1f54a','dragon'=>'1f409','dragon_face'=>'1f432','dress'=>'1f457','dromedary_camel'=>'1f42a','droplet'=>'1f4a7','dvd'=>'1f4c0','dz'=>'1f1e9-1f1ff','e-mail'=>'1f4e7','ear'=>'1f442','ear_of_rice'=>'1f33e','earth_africa'=>'1f30d','earth_americas'=>'1f30e','earth_asia'=>'1f30f','ec'=>'1f1ea-1f1e8','ee'=>'1f1ea-1f1ea','eg'=>'1f1ea-1f1ec','egg'=>'1f373','eggplant'=>'1f346','eh'=>'1f1ea-1f1ed','eight'=>'38-20e3','eight_pointed_black_star'=>'2734','eight_spoked_asterisk'=>'2733','electric_plug'=>'1f50c','elephant'=>'1f418','email'=>'2709','empty_note_pad'=>'1f5c7','empty_note_page'=>'1f5c6','end'=>'1f51a','envelope'=>'2709','envelope_back'=>'1f582','envelope_flying'=>'1f585','envelope_stamped'=>'1f583','envelope_stamped_pen'=>'1f586','envelope_with_arrow'=>'1f4e9','er'=>'1f1ea-1f1f7','es'=>'1f1ea-1f1f8','et'=>'1f1ea-1f1f9','euro'=>'1f4b6','european_castle'=>'1f3f0','european_post_office'=>'1f3e4','evergreen_tree'=>'1f332','exclamation'=>'2757','expressionless'=>'1f611','eye'=>'1f441','eyeglasses'=>'1f453','eyes'=>'1f440','facepunch'=>'1f44a','factory'=>'1f3ed','fallen_leaf'=>'1f342','family'=>'1f46a','family_mmb'=>'1f468-1f468-1f466','family_mmbb'=>'1f468-1f468-1f466-1f466','family_mmg'=>'1f468-1f468-1f467','family_mmgb'=>'1f468-1f468-1f467-1f466','family_mmgg'=>'1f468-1f468-1f467-1f467','family_mwbb'=>'1f468-1f469-1f466-1f466','family_mwg'=>'1f468-1f469-1f467','family_mwgb'=>'1f468-1f469-1f467-1f466','family_mwgg'=>'1f468-1f469-1f467-1f467','family_wwb'=>'1f469-1f469-1f466','family_wwbb'=>'1f469-1f469-1f466-1f466','family_wwg'=>'1f469-1f469-1f467','family_wwgb'=>'1f469-1f469-1f467-1f466','family_wwgg'=>'1f469-1f469-1f467-1f467','fast_forward'=>'23e9','fax'=>'1f4e0','fearful'=>'1f628','feet'=>'1f43e','ferris_wheel'=>'1f3a1','fi'=>'1f1eb-1f1ee','file_cabinet'=>'1f5c4','file_folder'=>'1f4c1','film_frames'=>'1f39e','film_projector'=>'1f4fd','finger_pointing_down'=>'1f597','finger_pointing_down2'=>'1f59f','finger_pointing_left'=>'1f598','finger_pointing_right'=>'1f599','finger_pointing_up'=>'1f59e','fire'=>'1f525','fire_engine'=>'1f692','fire_engine_oncoming'=>'1f6f1','fireworks'=>'1f386','first_quarter_moon'=>'1f313','first_quarter_moon_with_face'=>'1f31b','fish'=>'1f41f','fish_cake'=>'1f365','fishing_pole_and_fish'=>'1f3a3','fist'=>'270a','five'=>'35-20e3','fj'=>'1f1eb-1f1ef','fk'=>'1f1eb-1f1f0','flag_ac'=>'1f1e6-1f1e8','flag_ad'=>'1f1e6-1f1e9','flag_ae'=>'1f1e6-1f1ea','flag_af'=>'1f1e6-1f1eb','flag_ag'=>'1f1e6-1f1ec','flag_ai'=>'1f1e6-1f1ee','flag_al'=>'1f1e6-1f1f1','flag_am'=>'1f1e6-1f1f2','flag_ao'=>'1f1e6-1f1f4','flag_ar'=>'1f1e6-1f1f7','flag_at'=>'1f1e6-1f1f9','flag_au'=>'1f1e6-1f1fa','flag_aw'=>'1f1e6-1f1fc','flag_az'=>'1f1e6-1f1ff','flag_ba'=>'1f1e7-1f1e6','flag_bb'=>'1f1e7-1f1e7','flag_bd'=>'1f1e7-1f1e9','flag_be'=>'1f1e7-1f1ea','flag_bf'=>'1f1e7-1f1eb','flag_bg'=>'1f1e7-1f1ec','flag_bh'=>'1f1e7-1f1ed','flag_bi'=>'1f1e7-1f1ee','flag_bj'=>'1f1e7-1f1ef','flag_black'=>'1f3f4','flag_bm'=>'1f1e7-1f1f2','flag_bn'=>'1f1e7-1f1f3','flag_bo'=>'1f1e7-1f1f4','flag_br'=>'1f1e7-1f1f7','flag_bs'=>'1f1e7-1f1f8','flag_bt'=>'1f1e7-1f1f9','flag_bw'=>'1f1e7-1f1fc','flag_by'=>'1f1e7-1f1fe','flag_bz'=>'1f1e7-1f1ff','flag_ca'=>'1f1e8-1f1e6','flag_cd'=>'1f1e8-1f1e9','flag_cf'=>'1f1e8-1f1eb','flag_cg'=>'1f1e8-1f1ec','flag_ch'=>'1f1e8-1f1ed','flag_ci'=>'1f1e8-1f1ee','flag_cl'=>'1f1e8-1f1f1','flag_cm'=>'1f1e8-1f1f2','flag_cn'=>'1f1e8-1f1f3','flag_co'=>'1f1e8-1f1f4','flag_cr'=>'1f1e8-1f1f7','flag_cu'=>'1f1e8-1f1fa','flag_cv'=>'1f1e8-1f1fb','flag_cy'=>'1f1e8-1f1fe','flag_cz'=>'1f1e8-1f1ff','flag_de'=>'1f1e9-1f1ea','flag_dj'=>'1f1e9-1f1ef','flag_dk'=>'1f1e9-1f1f0','flag_dm'=>'1f1e9-1f1f2','flag_do'=>'1f1e9-1f1f4','flag_dz'=>'1f1e9-1f1ff','flag_ec'=>'1f1ea-1f1e8','flag_ee'=>'1f1ea-1f1ea','flag_eg'=>'1f1ea-1f1ec','flag_eh'=>'1f1ea-1f1ed','flag_er'=>'1f1ea-1f1f7','flag_es'=>'1f1ea-1f1f8','flag_et'=>'1f1ea-1f1f9','flag_fi'=>'1f1eb-1f1ee','flag_fj'=>'1f1eb-1f1ef','flag_fk'=>'1f1eb-1f1f0','flag_fm'=>'1f1eb-1f1f2','flag_fo'=>'1f1eb-1f1f4','flag_fr'=>'1f1eb-1f1f7','flag_ga'=>'1f1ec-1f1e6','flag_gb'=>'1f1ec-1f1e7','flag_gd'=>'1f1ec-1f1e9','flag_ge'=>'1f1ec-1f1ea','flag_gh'=>'1f1ec-1f1ed','flag_gi'=>'1f1ec-1f1ee','flag_gl'=>'1f1ec-1f1f1','flag_gm'=>'1f1ec-1f1f2','flag_gn'=>'1f1ec-1f1f3','flag_gq'=>'1f1ec-1f1f6','flag_gr'=>'1f1ec-1f1f7','flag_gt'=>'1f1ec-1f1f9','flag_gu'=>'1f1ec-1f1fa','flag_gw'=>'1f1ec-1f1fc','flag_gy'=>'1f1ec-1f1fe','flag_hk'=>'1f1ed-1f1f0','flag_hn'=>'1f1ed-1f1f3','flag_hr'=>'1f1ed-1f1f7','flag_ht'=>'1f1ed-1f1f9','flag_hu'=>'1f1ed-1f1fa','flag_id'=>'1f1ee-1f1e9','flag_ie'=>'1f1ee-1f1ea','flag_il'=>'1f1ee-1f1f1','flag_in'=>'1f1ee-1f1f3','flag_iq'=>'1f1ee-1f1f6','flag_ir'=>'1f1ee-1f1f7','flag_is'=>'1f1ee-1f1f8','flag_it'=>'1f1ee-1f1f9','flag_je'=>'1f1ef-1f1ea','flag_jm'=>'1f1ef-1f1f2','flag_jo'=>'1f1ef-1f1f4','flag_jp'=>'1f1ef-1f1f5','flag_ke'=>'1f1f0-1f1ea','flag_kg'=>'1f1f0-1f1ec','flag_kh'=>'1f1f0-1f1ed','flag_ki'=>'1f1f0-1f1ee','flag_km'=>'1f1f0-1f1f2','flag_kn'=>'1f1f0-1f1f3','flag_kp'=>'1f1f0-1f1f5','flag_kr'=>'1f1f0-1f1f7','flag_kw'=>'1f1f0-1f1fc','flag_ky'=>'1f1f0-1f1fe','flag_kz'=>'1f1f0-1f1ff','flag_la'=>'1f1f1-1f1e6','flag_lb'=>'1f1f1-1f1e7','flag_lc'=>'1f1f1-1f1e8','flag_li'=>'1f1f1-1f1ee','flag_lk'=>'1f1f1-1f1f0','flag_lr'=>'1f1f1-1f1f7','flag_ls'=>'1f1f1-1f1f8','flag_lt'=>'1f1f1-1f1f9','flag_lu'=>'1f1f1-1f1fa','flag_lv'=>'1f1f1-1f1fb','flag_ly'=>'1f1f1-1f1fe','flag_ma'=>'1f1f2-1f1e6','flag_mc'=>'1f1f2-1f1e8','flag_md'=>'1f1f2-1f1e9','flag_me'=>'1f1f2-1f1ea','flag_mg'=>'1f1f2-1f1ec','flag_mh'=>'1f1f2-1f1ed','flag_mk'=>'1f1f2-1f1f0','flag_ml'=>'1f1f2-1f1f1','flag_mm'=>'1f1f2-1f1f2','flag_mn'=>'1f1f2-1f1f3','flag_mo'=>'1f1f2-1f1f4','flag_mr'=>'1f1f2-1f1f7','flag_ms'=>'1f1f2-1f1f8','flag_mt'=>'1f1f2-1f1f9','flag_mu'=>'1f1f2-1f1fa','flag_mv'=>'1f1f2-1f1fb','flag_mw'=>'1f1f2-1f1fc','flag_mx'=>'1f1f2-1f1fd','flag_my'=>'1f1f2-1f1fe','flag_mz'=>'1f1f2-1f1ff','flag_na'=>'1f1f3-1f1e6','flag_nc'=>'1f1f3-1f1e8','flag_ne'=>'1f1f3-1f1ea','flag_ng'=>'1f1f3-1f1ec','flag_ni'=>'1f1f3-1f1ee','flag_nl'=>'1f1f3-1f1f1','flag_no'=>'1f1f3-1f1f4','flag_np'=>'1f1f3-1f1f5','flag_nr'=>'1f1f3-1f1f7','flag_nu'=>'1f1f3-1f1fa','flag_nz'=>'1f1f3-1f1ff','flag_om'=>'1f1f4-1f1f2','flag_pa'=>'1f1f5-1f1e6','flag_pe'=>'1f1f5-1f1ea','flag_pf'=>'1f1f5-1f1eb','flag_pg'=>'1f1f5-1f1ec','flag_ph'=>'1f1f5-1f1ed','flag_pk'=>'1f1f5-1f1f0','flag_pl'=>'1f1f5-1f1f1','flag_pr'=>'1f1f5-1f1f7','flag_ps'=>'1f1f5-1f1f8','flag_pt'=>'1f1f5-1f1f9','flag_pw'=>'1f1f5-1f1fc','flag_py'=>'1f1f5-1f1fe','flag_qa'=>'1f1f6-1f1e6','flag_ro'=>'1f1f7-1f1f4','flag_rs'=>'1f1f7-1f1f8','flag_ru'=>'1f1f7-1f1fa','flag_rw'=>'1f1f7-1f1fc','flag_sa'=>'1f1f8-1f1e6','flag_sb'=>'1f1f8-1f1e7','flag_sc'=>'1f1f8-1f1e8','flag_sd'=>'1f1f8-1f1e9','flag_se'=>'1f1f8-1f1ea','flag_sg'=>'1f1f8-1f1ec','flag_sh'=>'1f1f8-1f1ed','flag_si'=>'1f1f8-1f1ee','flag_sk'=>'1f1f8-1f1f0','flag_sl'=>'1f1f8-1f1f1','flag_sm'=>'1f1f8-1f1f2','flag_sn'=>'1f1f8-1f1f3','flag_so'=>'1f1f8-1f1f4','flag_sr'=>'1f1f8-1f1f7','flag_st'=>'1f1f8-1f1f9','flag_sv'=>'1f1f8-1f1fb','flag_sy'=>'1f1f8-1f1fe','flag_sz'=>'1f1f8-1f1ff','flag_td'=>'1f1f9-1f1e9','flag_tg'=>'1f1f9-1f1ec','flag_th'=>'1f1f9-1f1ed','flag_tj'=>'1f1f9-1f1ef','flag_tl'=>'1f1f9-1f1f1','flag_tm'=>'1f1f9-1f1f2','flag_tn'=>'1f1f9-1f1f3','flag_to'=>'1f1f9-1f1f4','flag_tr'=>'1f1f9-1f1f7','flag_tt'=>'1f1f9-1f1f9','flag_tv'=>'1f1f9-1f1fb','flag_tw'=>'1f1f9-1f1fc','flag_tz'=>'1f1f9-1f1ff','flag_ua'=>'1f1fa-1f1e6','flag_ug'=>'1f1fa-1f1ec','flag_us'=>'1f1fa-1f1f8','flag_uy'=>'1f1fa-1f1fe','flag_uz'=>'1f1fa-1f1ff','flag_va'=>'1f1fb-1f1e6','flag_vc'=>'1f1fb-1f1e8','flag_ve'=>'1f1fb-1f1ea','flag_vi'=>'1f1fb-1f1ee','flag_vn'=>'1f1fb-1f1f3','flag_vu'=>'1f1fb-1f1fa','flag_wf'=>'1f1fc-1f1eb','flag_white'=>'1f3f3','flag_ws'=>'1f1fc-1f1f8','flag_xk'=>'1f1fd-1f1f0','flag_ye'=>'1f1fe-1f1ea','flag_za'=>'1f1ff-1f1e6','flag_zm'=>'1f1ff-1f1f2','flag_zw'=>'1f1ff-1f1fc','flags'=>'1f38f','flame'=>'1f525','flashlight'=>'1f526','flip_phone'=>'1f581','flipper'=>'1f42c','floppy_black'=>'1f5aa','floppy_disk'=>'1f4be','floppy_white'=>'1f5ab','flower_playing_cards'=>'1f3b4','flushed'=>'1f633','flying_envelope'=>'1f585','fm'=>'1f1eb-1f1f2','fo'=>'1f1eb-1f1f4','fog'=>'1f32b','foggy'=>'1f301','folder'=>'1f5c0','folder_open'=>'1f5c1','football'=>'1f3c8','footprints'=>'1f463','fork_and_knife'=>'1f374','fork_and_knife_with_plate'=>'1f37d','fork_knife_plate'=>'1f37d','fountain'=>'26f2','four'=>'34-20e3','four_leaf_clover'=>'1f340','fr'=>'1f1eb-1f1f7','frame_photo'=>'1f5bc','frame_tiles'=>'1f5bd','frame_with_an_x'=>'1f5be','frame_with_picture'=>'1f5bc','frame_with_tiles'=>'1f5bd','frame_x'=>'1f5be','free'=>'1f193','fried_shrimp'=>'1f364','fries'=>'1f35f','frog'=>'1f438','frowning'=>'1f626','fuelpump'=>'26fd','full_moon'=>'1f315','full_moon_with_face'=>'1f31d','ga'=>'1f1ec-1f1e6','game_die'=>'1f3b2','gb'=>'1f1ec-1f1e7','gd'=>'1f1ec-1f1e9','ge'=>'1f1ec-1f1ea','gem'=>'1f48e','gemini'=>'264a','gh'=>'1f1ec-1f1ed','ghost'=>'1f47b','gi'=>'1f1ec-1f1ee','gift'=>'1f381','gift_heart'=>'1f49d','girl'=>'1f467','girls_symbol'=>'1f6ca','gl'=>'1f1ec-1f1f1','globe_with_meridians'=>'1f310','gm'=>'1f1ec-1f1f2','gn'=>'1f1ec-1f1f3','goat'=>'1f410','golf'=>'26f3','golfer'=>'1f3cc','gq'=>'1f1ec-1f1f6','gr'=>'1f1ec-1f1f7','grandma'=>'1f475','grapes'=>'1f347','green_apple'=>'1f34f','green_book'=>'1f4d7','green_heart'=>'1f49a','grey_exclamation'=>'2755','grey_question'=>'2754','grimacing'=>'1f62c','grin'=>'1f601','grinning'=>'1f600','gt'=>'1f1ec-1f1f9','gu'=>'1f1ec-1f1fa','guardsman'=>'1f482','guitar'=>'1f3b8','gun'=>'1f52b','gw'=>'1f1ec-1f1fc','gy'=>'1f1ec-1f1fe','haircut'=>'1f487','hamburger'=>'1f354','hammer'=>'1f528','hammer_and_wrench'=>'1f6e0','hamster'=>'1f439','hand'=>'270b','hand_splayed'=>'1f590','hand_splayed_reverse'=>'1f591','hand_victory'=>'1f594','handbag'=>'1f45c','hankey'=>'1f4a9','hard_disk'=>'1f5b4','hash'=>'23-20e3','hatched_chick'=>'1f425','hatching_chick'=>'1f423','headphones'=>'1f3a7','hear_no_evil'=>'1f649','heart'=>'2764','heart_decoration'=>'1f49f','heart_eyes'=>'1f60d','heart_eyes_cat'=>'1f63b','heart_tip'=>'1f394','heart_with_tip_on_the_left'=>'1f394','heartbeat'=>'1f493','heartpulse'=>'1f497','hearts'=>'2665','heavy_check_mark'=>'2714','heavy_division_sign'=>'2797','heavy_dollar_sign'=>'1f4b2','heavy_exclamation_mark'=>'2757','heavy_latin_cross'=>'1f547','heavy_minus_sign'=>'2796','heavy_multiplication_x'=>'2716','heavy_plus_sign'=>'2795','helicopter'=>'1f681','herb'=>'1f33f','hibiscus'=>'1f33a','high_brightness'=>'1f506','high_heel'=>'1f460','hk'=>'1f1ed-1f1f0','hn'=>'1f1ed-1f1f3','hocho'=>'1f52a','hole'=>'1f573','homes'=>'1f3d8','honey_pot'=>'1f36f','honeybee'=>'1f41d','horse'=>'1f434','horse_racing'=>'1f3c7','hospital'=>'1f3e5','hot_pepper'=>'1f336','hotel'=>'1f3e8','hotsprings'=>'2668','hourglass'=>'231b','hourglass_flowing_sand'=>'23f3','house'=>'1f3e0','house_abandoned'=>'1f3da','house_buildings'=>'1f3d8','house_with_garden'=>'1f3e1','hr'=>'1f1ed-1f1f7','ht'=>'1f1ed-1f1f9','hu'=>'1f1ed-1f1fa','hushed'=>'1f62f','ice_cream'=>'1f368','icecream'=>'1f366','id'=>'1f194','ideograph_advantage'=>'1f250','ie'=>'1f1ee-1f1ea','il'=>'1f1ee-1f1f1','imp'=>'1f47f','in'=>'1f1ee-1f1f3','inbox_tray'=>'1f4e5','incoming_envelope'=>'1f4e8','indonesia'=>'1f1ee-1f1e9','info'=>'1f6c8','information_desk_person'=>'1f481','information_source'=>'2139','innocent'=>'1f607','interrobang'=>'2049','iphone'=>'1f4f1','iq'=>'1f1ee-1f1f6','ir'=>'1f1ee-1f1f7','is'=>'1f1ee-1f1f8','island'=>'1f3dd','it'=>'1f1ee-1f1f9','izakaya_lantern'=>'1f3ee','jack_o_lantern'=>'1f383','japan'=>'1f5fe','japanese_castle'=>'1f3ef','japanese_goblin'=>'1f47a','japanese_ogre'=>'1f479','je'=>'1f1ef-1f1ea','jeans'=>'1f456','jet_up'=>'1f6e6','jm'=>'1f1ef-1f1f2','jo'=>'1f1ef-1f1f4','joy'=>'1f602','joy_cat'=>'1f639','joystick'=>'1f579','jp'=>'1f1ef-1f1f5','ke'=>'1f1f0-1f1ea','key'=>'1f511','key2'=>'1f5dd','keyboard'=>'1f5ae','keyboard_and_mouse'=>'1f5a6','keyboard_mouse'=>'1f5a6','keyboard_with_jacks'=>'1f398','keycap_ten'=>'1f51f','kg'=>'1f1f0-1f1ec','kh'=>'1f1f0-1f1ed','ki'=>'1f1f0-1f1ee','kimono'=>'1f458','kiss'=>'1f48b','kiss_mm'=>'1f468-2764-1f48b-1f468','kiss_ww'=>'1f469-2764-1f48b-1f469','kissing'=>'1f617','kissing_cat'=>'1f63d','kissing_closed_eyes'=>'1f61a','kissing_heart'=>'1f618','kissing_smiling_eyes'=>'1f619','km'=>'1f1f0-1f1f2','kn'=>'1f1f0-1f1f3','knife'=>'1f52a','koala'=>'1f428','koko'=>'1f201','kp'=>'1f1f0-1f1f5','kr'=>'1f1f0-1f1f7','kw'=>'1f1f0-1f1fc','ky'=>'1f1f0-1f1fe','kz'=>'1f1f0-1f1ff','la'=>'1f1f1-1f1e6','label'=>'1f3f7','lantern'=>'1f3ee','large_blue_circle'=>'1f535','large_blue_diamond'=>'1f537','large_orange_diamond'=>'1f536','last_quarter_moon'=>'1f317','last_quarter_moon_with_face'=>'1f31c','laughing'=>'1f606','lb'=>'1f1f1-1f1e7','lc'=>'1f1f1-1f1e8','leaves'=>'1f343','ledger'=>'1f4d2','left_anger_bubble'=>'1f5ee','left_hand_telephone_receiver'=>'1f57b','left_luggage'=>'1f6c5','left_receiver'=>'1f57b','left_right_arrow'=>'2194','left_speech_bubble'=>'1f5e8','left_thought_bubble'=>'1f5ec','left_writing_hand'=>'1f58e','leftwards_arrow_with_hook'=>'21a9','lemon'=>'1f34b','leo'=>'264c','leopard'=>'1f406','level_slider'=>'1f39a','levitate'=>'1f574','li'=>'1f1f1-1f1ee','libra'=>'264e','lifter'=>'1f3cb','light_check_mark'=>'1f5f8','light_mark'=>'1f5f8','light_rail'=>'1f688','lightning_mood'=>'1f5f2','lightning_mood_bubble'=>'1f5f1','link'=>'1f517','linked_paperclips'=>'1f587','lips'=>'1f444','lips2'=>'1f5e2','lipstick'=>'1f484','lk'=>'1f1f1-1f1f0','lock'=>'1f512','lock_with_ink_pen'=>'1f50f','lollipop'=>'1f36d','loop'=>'27bf','loud_sound'=>'1f50a','loudspeaker'=>'1f4e2','love_hotel'=>'1f3e9','love_letter'=>'1f48c','low_brightness'=>'1f505','lower_left_ballpoint_pen'=>'1f58a','lower_left_crayon'=>'1f58d','lower_left_fountain_pen'=>'1f58b','lower_left_paintbrush'=>'1f58c','lower_left_pencil'=>'1f589','lr'=>'1f1f1-1f1f7','ls'=>'1f1f1-1f1f8','lt'=>'1f1f1-1f1f9','lu'=>'1f1f1-1f1fa','lv'=>'1f1f1-1f1fb','ly'=>'1f1f1-1f1fe','m'=>'24c2','ma'=>'1f1f2-1f1e6','mag'=>'1f50d','mag_right'=>'1f50e','mahjong'=>'1f004','mailbox'=>'1f4eb','mailbox_closed'=>'1f4ea','mailbox_with_mail'=>'1f4ec','mailbox_with_no_mail'=>'1f4ed','man'=>'1f468','man_in_business_suit_levitating'=>'1f574','man_with_gua_pi_mao'=>'1f472','man_with_turban'=>'1f473','mans_shoe'=>'1f45e','mantlepiece_clock'=>'1f570','map'=>'1f5fa','maple_leaf'=>'1f341','mask'=>'1f637','massage'=>'1f486','mc'=>'1f1f2-1f1e8','md'=>'1f1f2-1f1e9','me'=>'1f1f2-1f1ea','meat_on_bone'=>'1f356','medal'=>'1f3c5','mega'=>'1f4e3','melon'=>'1f348','memo'=>'1f4dd','mens'=>'1f6b9','metro'=>'1f687','mg'=>'1f1f2-1f1ec','mh'=>'1f1f2-1f1ed','microphone'=>'1f3a4','microphone2'=>'1f399','microscope'=>'1f52c','middle_finger'=>'1f595','military_medal'=>'1f396','milky_way'=>'1f30c','minibus'=>'1f690','minidisc'=>'1f4bd','mk'=>'1f1f2-1f1f0','ml'=>'1f1f2-1f1f1','mm'=>'1f1f2-1f1f2','mn'=>'1f1f2-1f1f3','mo'=>'1f1f2-1f1f4','mobile_phone_off'=>'1f4f4','money_with_wings'=>'1f4b8','moneybag'=>'1f4b0','monkey'=>'1f412','monkey_face'=>'1f435','monorail'=>'1f69d','mood_bubble'=>'1f5f0','mood_bubble_lightning'=>'1f5f1','mood_lightning'=>'1f5f2','moon'=>'1f314','mortar_board'=>'1f393','motorboat'=>'1f6e5','motorcycle'=>'1f3cd','motorway'=>'1f6e3','mount_fuji'=>'1f5fb','mountain_bicyclist'=>'1f6b5','mountain_cableway'=>'1f6a0','mountain_railway'=>'1f69e','mountain_snow'=>'1f3d4','mouse'=>'1f42d','mouse2'=>'1f401','mouse_one'=>'1f5af','movie_camera'=>'1f3a5','moyai'=>'1f5ff','mr'=>'1f1f2-1f1f7','ms'=>'1f1f2-1f1f8','mt'=>'1f1f2-1f1f9','mu'=>'1f1f2-1f1fa','muscle'=>'1f4aa','mushroom'=>'1f344','musical_keyboard'=>'1f3b9','musical_keyboard_with_jacks'=>'1f398','musical_note'=>'1f3b5','musical_score'=>'1f3bc','mute'=>'1f507','mv'=>'1f1f2-1f1fb','mw'=>'1f1f2-1f1fc','mx'=>'1f1f2-1f1fd','my'=>'1f1f2-1f1fe','mz'=>'1f1f2-1f1ff','na'=>'1f1f3-1f1e6','nail_care'=>'1f485','name_badge'=>'1f4db','national_park'=>'1f3de','nc'=>'1f1f3-1f1e8','ne'=>'1f1f3-1f1ea','necktie'=>'1f454','negative_squared_cross_mark'=>'274e','network'=>'1f5a7','neutral_face'=>'1f610','new'=>'1f195','new_moon'=>'1f311','new_moon_with_face'=>'1f31a','newspaper'=>'1f4f0','newspaper2'=>'1f5de','ng'=>'1f196','ni'=>'1f1f3-1f1ee','nigeria'=>'1f1f3-1f1ec','night_with_stars'=>'1f303','nine'=>'39-20e3','nl'=>'1f1f3-1f1f1','no'=>'1f1f3-1f1f4','no_bell'=>'1f515','no_bicycles'=>'1f6b3','no_entry'=>'26d4','no_entry_sign'=>'1f6ab','no_good'=>'1f645','no_mobile_phones'=>'1f4f5','no_mouth'=>'1f636','no_pedestrians'=>'1f6b7','no_piracy'=>'1f572','no_smoking'=>'1f6ad','non-potable_water'=>'1f6b1','northeast_pointing_airplane'=>'1f6ea','nose'=>'1f443','note'=>'1f5c9','note_empty'=>'1f5c6','note_pad'=>'1f5ca','note_page'=>'1f5c9','notebook'=>'1f4d3','notebook_with_decorative_cover'=>'1f4d4','notepad'=>'1f5ca','notepad_empty'=>'1f5c7','notepad_spiral'=>'1f5d2','notes'=>'1f3b6','np'=>'1f1f3-1f1f5','nr'=>'1f1f3-1f1f7','nu'=>'1f1f3-1f1fa','nut_and_bolt'=>'1f529','nz'=>'1f1f3-1f1ff','o'=>'2b55','o2'=>'1f17e','ocean'=>'1f30a','octopus'=>'1f419','oden'=>'1f362','office'=>'1f3e2','oil'=>'1f6e2','oil_drum'=>'1f6e2','ok'=>'1f197','ok_hand'=>'1f44c','ok_woman'=>'1f646','old_key'=>'1f5dd','old_personal_computer'=>'1f5b3','older_man'=>'1f474','older_woman'=>'1f475','om'=>'1f1f4-1f1f2','om_symbol'=>'1f549','on'=>'1f51b','oncoming_automobile'=>'1f698','oncoming_bus'=>'1f68d','oncoming_fire_engine'=>'1f6f1','oncoming_police_car'=>'1f694','oncoming_taxi'=>'1f696','one'=>'31-20e3','one_button_mouse'=>'1f5af','open_book'=>'1f4d6','open_file_folder'=>'1f4c2','open_folder'=>'1f5c1','open_hands'=>'1f450','open_mouth'=>'1f62e','ophiuchus'=>'26ce','optical_disc_icon'=>'1f5b8','optical_disk'=>'1f5b8','orange_book'=>'1f4d9','outbox_tray'=>'1f4e4','ox'=>'1f402','pa'=>'1f1f5-1f1e6','package'=>'1f4e6','page'=>'1f5cf','page_facing_up'=>'1f4c4','page_with_curl'=>'1f4c3','pager'=>'1f4df','pages'=>'1f5d0','paintbrush'=>'1f58c','palm_tree'=>'1f334','panda_face'=>'1f43c','paperclip'=>'1f4ce','paperclips'=>'1f587','park'=>'1f3de','parking'=>'1f17f','part_alternation_mark'=>'303d','partly_sunny'=>'26c5','passenger_ship'=>'1f6f3','passport_control'=>'1f6c2','paw_prints'=>'1f43e','pe'=>'1f1f5-1f1ea','peach'=>'1f351','pear'=>'1f350','pen_ballpoint'=>'1f58a','pen_fountain'=>'1f58b','pen_over_stamped_envelope'=>'1f586','pencil'=>'1f4dd','pencil2'=>'270f','pencil3'=>'1f589','penguin'=>'1f427','pennant_black'=>'1f3f2','pennant_white'=>'1f3f1','pensive'=>'1f614','performing_arts'=>'1f3ad','persevere'=>'1f623','person_frowning'=>'1f64d','person_with_blond_hair'=>'1f471','person_with_pouting_face'=>'1f64e','pf'=>'1f1f5-1f1eb','pg'=>'1f1f5-1f1ec','ph'=>'1f1f5-1f1ed','phone'=>'260e','pig'=>'1f437','pig2'=>'1f416','pig_nose'=>'1f43d','pill'=>'1f48a','pineapple'=>'1f34d','piracy'=>'1f572','pisces'=>'2653','pizza'=>'1f355','pk'=>'1f1f5-1f1f0','pl'=>'1f1f5-1f1f1','pocket_calculator'=>'1f5a9','point_down'=>'1f447','point_left'=>'1f448','point_right'=>'1f449','point_up'=>'261d','point_up_2'=>'1f446','police_car'=>'1f693','poo'=>'1f4a9','poodle'=>'1f429','poop'=>'1f4a9','portable_stereo'=>'1f4fe','post_office'=>'1f3e3','postal_horn'=>'1f4ef','postbox'=>'1f4ee','potable_water'=>'1f6b0','pouch'=>'1f45d','poultry_leg'=>'1f357','pound'=>'1f4b7','pouting_cat'=>'1f63e','pr'=>'1f1f5-1f1f7','pray'=>'1f64f','princess'=>'1f478','printer'=>'1f5a8','prohibited'=>'1f6c7','prohibited_sign'=>'1f6c7','projector'=>'1f4fd','ps'=>'1f1f5-1f1f8','pt'=>'1f1f5-1f1f9','punch'=>'1f44a','purple_heart'=>'1f49c','purse'=>'1f45b','pushpin'=>'1f4cc','pushpin_black'=>'1f588','put_litter_in_its_place'=>'1f6ae','pw'=>'1f1f5-1f1fc','py'=>'1f1f5-1f1fe','qa'=>'1f1f6-1f1e6','question'=>'2753','rabbit'=>'1f430','rabbit2'=>'1f407','race_car'=>'1f3ce','racehorse'=>'1f40e','racing_car'=>'1f3ce','racing_motorcycle'=>'1f3cd','radio'=>'1f4fb','radio_button'=>'1f518','rage'=>'1f621','railroad_track'=>'1f6e4','railway_car'=>'1f683','railway_track'=>'1f6e4','rainbow'=>'1f308','raised_hand'=>'270b','raised_hand_with_fingers_splayed'=>'1f590','raised_hand_with_part_between_middle_and_ring_fingers'=>'1f596','raised_hands'=>'1f64c','raising_hand'=>'1f64b','ram'=>'1f40f','ramen'=>'1f35c','rat'=>'1f400','recycle'=>'267b','red_car'=>'1f697','red_circle'=>'1f534','registered'=>'ae','relaxed'=>'263a','relieved'=>'1f60c','reminder_ribbon'=>'1f397','repeat'=>'1f501','repeat_one'=>'1f502','restroom'=>'1f6bb','reversed_hand_with_middle_finger_extended'=>'1f595','reversed_raised_hand_with_fingers_splayed'=>'1f591','reversed_thumbs_down_sign'=>'1f593','reversed_thumbs_up_sign'=>'1f592','reversed_victory_hand'=>'1f594','revolving_hearts'=>'1f49e','rewind'=>'23ea','ribbon'=>'1f380','rice'=>'1f35a','rice_ball'=>'1f359','rice_cracker'=>'1f358','rice_scene'=>'1f391','right_anger_bubble'=>'1f5ef','right_speaker'=>'1f568','right_speaker_one'=>'1f569','right_speaker_three'=>'1f56a','right_speaker_with_one_sound_wave'=>'1f569','right_speaker_with_three_sound_waves'=>'1f56a','right_speech_bubble'=>'1f5e9','right_thought_bubble'=>'1f5ed','ring'=>'1f48d','ringing_bell'=>'1f56d','ro'=>'1f1f7-1f1f4','rocket'=>'1f680','rolled_up_newspaper'=>'1f5de','roller_coaster'=>'1f3a2','rooster'=>'1f413','rose'=>'1f339','rosette'=>'1f3f5','rosette_black'=>'1f3f6','rotating_light'=>'1f6a8','round_pushpin'=>'1f4cd','rowboat'=>'1f6a3','rs'=>'1f1f7-1f1f8','ru'=>'1f1f7-1f1fa','rugby_football'=>'1f3c9','runner'=>'1f3c3','running'=>'1f3c3','running_shirt_with_sash'=>'1f3bd','rw'=>'1f1f7-1f1fc','sa'=>'1f202','sagittarius'=>'2650','sailboat'=>'26f5','sake'=>'1f376','sandal'=>'1f461','santa'=>'1f385','satellite'=>'1f4e1','satellite_orbital'=>'1f6f0','satisfied'=>'1f606','saudi'=>'1f1f8-1f1e6','saudiarabia'=>'1f1f8-1f1e6','saxophone'=>'1f3b7','sb'=>'1f1f8-1f1e7','sc'=>'1f1f8-1f1e8','school'=>'1f3eb','school_satchel'=>'1f392','scissors'=>'2702','scorpius'=>'264f','scream'=>'1f631','scream_cat'=>'1f640','scroll'=>'1f4dc','sd'=>'1f1f8-1f1e9','se'=>'1f1f8-1f1ea','seat'=>'1f4ba','secret'=>'3299','see_no_evil'=>'1f648','seedling'=>'1f331','seven'=>'37-20e3','sg'=>'1f1f8-1f1ec','sh'=>'1f1f8-1f1ed','shaved_ice'=>'1f367','sheep'=>'1f411','shell'=>'1f41a','shield'=>'1f6e1','ship'=>'1f6a2','shirt'=>'1f455','shit'=>'1f4a9','shoe'=>'1f45e','shopping_bags'=>'1f6cd','shower'=>'1f6bf','si'=>'1f1f8-1f1ee','sideways_white_down_pointing_index'=>'1f59f','sideways_white_left_pointing_index'=>'1f598','sideways_white_right_pointing_index'=>'1f599','sideways_white_up_pointing_index'=>'1f59e','signal_strength'=>'1f4f6','six'=>'36-20e3','six_pointed_star'=>'1f52f','sk'=>'1f1f8-1f1f0','skeleton'=>'1f480','ski'=>'1f3bf','skull'=>'1f480','sl'=>'1f1f8-1f1f1','sleeping'=>'1f634','sleeping_accommodation'=>'1f6cc','sleepy'=>'1f62a','sleuth_or_spy'=>'1f575','slight_frown'=>'1f641','slight_smile'=>'1f642','slightly_frowning_face'=>'1f641','slightly_smiling_face'=>'1f642','slot_machine'=>'1f3b0','sm'=>'1f1f8-1f1f2','small_airplane'=>'1f6e9','small_blue_diamond'=>'1f539','small_orange_diamond'=>'1f538','small_red_triangle'=>'1f53a','small_red_triangle_down'=>'1f53b','smile'=>'1f604','smile_cat'=>'1f638','smiley'=>'1f603','smiley_cat'=>'1f63a','smiling_imp'=>'1f608','smirk'=>'1f60f','smirk_cat'=>'1f63c','smoking'=>'1f6ac','sn'=>'1f1f8-1f1f3','snail'=>'1f40c','snake'=>'1f40d','snow_capped_mountain'=>'1f3d4','snowboarder'=>'1f3c2','snowflake'=>'2744','snowman'=>'26c4','so'=>'1f1f8-1f1f4','sob'=>'1f62d','soccer'=>'26bd','soon'=>'1f51c','sos'=>'1f198','sound'=>'1f509','space_invader'=>'1f47e','spades'=>'2660','spaghetti'=>'1f35d','sparkle'=>'2747','sparkler'=>'1f387','sparkles'=>'2728','sparkling_heart'=>'1f496','speak_no_evil'=>'1f64a','speaker'=>'1f508','speaking_head'=>'1f5e3','speaking_head_in_silhouette'=>'1f5e3','speech_balloon'=>'1f4ac','speech_left'=>'1f5e8','speech_right'=>'1f5e9','speech_three'=>'1f5eb','speech_two'=>'1f5ea','speedboat'=>'1f6a4','spider'=>'1f577','spider_web'=>'1f578','spiral_calendar_pad'=>'1f5d3','spiral_note_pad'=>'1f5d2','sports_medal'=>'1f3c5','spy'=>'1f575','sr'=>'1f1f8-1f1f7','st'=>'1f1f8-1f1f9','stadium'=>'1f3df','stamped_envelope'=>'1f583','star'=>'2b50','star2'=>'1f31f','stars'=>'1f320','station'=>'1f689','statue_of_liberty'=>'1f5fd','steam_locomotive'=>'1f682','stereo'=>'1f4fe','stew'=>'1f372','stock_chart'=>'1f5e0','straight_ruler'=>'1f4cf','strawberry'=>'1f353','stuck_out_tongue'=>'1f61b','stuck_out_tongue_closed_eyes'=>'1f61d','stuck_out_tongue_winking_eye'=>'1f61c','studio_microphone'=>'1f399','sun_with_face'=>'1f31e','sunflower'=>'1f33b','sunglasses'=>'1f60e','sunny'=>'2600','sunrise'=>'1f305','sunrise_over_mountains'=>'1f304','surfer'=>'1f3c4','sushi'=>'1f363','suspension_railway'=>'1f69f','sv'=>'1f1f8-1f1fb','sweat'=>'1f613','sweat_drops'=>'1f4a6','sweat_smile'=>'1f605','sweet_potato'=>'1f360','swimmer'=>'1f3ca','sy'=>'1f1f8-1f1fe','symbols'=>'1f523','syringe'=>'1f489','sz'=>'1f1f8-1f1ff','tada'=>'1f389','tanabata_tree'=>'1f38b','tangerine'=>'1f34a','tape_cartridge'=>'1f5ad','taurus'=>'2649','taxi'=>'1f695','td'=>'1f1f9-1f1e9','tea'=>'1f375','telephone'=>'260e','telephone_black'=>'1f57f','telephone_receiver'=>'1f4de','telephone_white'=>'1f57e','telescope'=>'1f52d','tennis'=>'1f3be','tent'=>'26fa','tg'=>'1f1f9-1f1ec','th'=>'1f1f9-1f1ed','thermometer'=>'1f321','thought_balloon'=>'1f4ad','thought_left'=>'1f5ec','thought_right'=>'1f5ed','three'=>'33-20e3','three_networked_computers'=>'1f5a7','three_speech_bubbles'=>'1f5eb','thumbs_down_reverse'=>'1f593','thumbs_up_reverse'=>'1f592','thumbsdown'=>'1f44e','thumbsup'=>'1f44d','ticket'=>'1f3ab','tickets'=>'1f39f','tiger'=>'1f42f','tiger2'=>'1f405','tired_face'=>'1f62b','tj'=>'1f1f9-1f1ef','tl'=>'1f1f9-1f1f1','tm'=>'2122','tn'=>'1f1f9-1f1f3','to'=>'1f1f9-1f1f4','toilet'=>'1f6bd','tokyo_tower'=>'1f5fc','tomato'=>'1f345','tongue'=>'1f445','tools'=>'1f6e0','top'=>'1f51d','tophat'=>'1f3a9','tr'=>'1f1f9-1f1f7','trackball'=>'1f5b2','tractor'=>'1f69c','traffic_light'=>'1f6a5','train'=>'1f68b','train2'=>'1f686','train_diesel'=>'1f6f2','tram'=>'1f68a','triangle_round'=>'1f6c6','triangle_with_rounded_corners'=>'1f6c6','triangular_flag_on_post'=>'1f6a9','triangular_ruler'=>'1f4d0','trident'=>'1f531','triumph'=>'1f624','trolleybus'=>'1f68e','trophy'=>'1f3c6','tropical_drink'=>'1f379','tropical_fish'=>'1f420','truck'=>'1f69a','trumpet'=>'1f3ba','tshirt'=>'1f455','tt'=>'1f1f9-1f1f9','tulip'=>'1f337','turkmenistan'=>'1f1f9-1f1f2','turned_ok_hand'=>'1f58f','turned_ok_hand_sign'=>'1f58f','turtle'=>'1f422','tuvalu'=>'1f1f9-1f1fb','tv'=>'1f4fa','tw'=>'1f1f9-1f1fc','twisted_rightwards_arrows'=>'1f500','two'=>'32-20e3','two_hearts'=>'1f495','two_men_holding_hands'=>'1f46c','two_speech_bubbles'=>'1f5ea','two_women_holding_hands'=>'1f46d','tz'=>'1f1f9-1f1ff','u5272'=>'1f239','u5408'=>'1f234','u55b6'=>'1f23a','u6307'=>'1f22f','u6708'=>'1f237','u6709'=>'1f236','u6e80'=>'1f235','u7121'=>'1f21a','u7533'=>'1f238','u7981'=>'1f232','u7a7a'=>'1f233','ua'=>'1f1fa-1f1e6','ug'=>'1f1fa-1f1ec','uk'=>'1f1ec-1f1e7','umbrella'=>'2614','unamused'=>'1f612','underage'=>'1f51e','unlock'=>'1f513','up'=>'1f199','up_pointing_airplane'=>'1f6e7','up_pointing_military_airplane'=>'1f6e6','up_pointing_small_airplane'=>'1f6e8','us'=>'1f1fa-1f1f8','uy'=>'1f1fa-1f1fe','uz'=>'1f1fa-1f1ff','v'=>'270c','va'=>'1f1fb-1f1e6','vc'=>'1f1fb-1f1e8','ve'=>'1f1fb-1f1ea','vertical_traffic_light'=>'1f6a6','vhs'=>'1f4fc','vi'=>'1f1fb-1f1ee','vibration_mode'=>'1f4f3','video_camera'=>'1f4f9','video_game'=>'1f3ae','violin'=>'1f3bb','virgo'=>'264d','vn'=>'1f1fb-1f1f3','volcano'=>'1f30b','vs'=>'1f19a','vu'=>'1f1fb-1f1fa','vulcan'=>'1f596','walking'=>'1f6b6','waning_crescent_moon'=>'1f318','waning_gibbous_moon'=>'1f316','warning'=>'26a0','wastebasket'=>'1f5d1','watch'=>'231a','water_buffalo'=>'1f403','watermelon'=>'1f349','wave'=>'1f44b','waving_black_flag'=>'1f3f4','waving_white_flag'=>'1f3f3','wavy_dash'=>'3030','waxing_crescent_moon'=>'1f312','waxing_gibbous_moon'=>'1f314','wc'=>'1f6be','weary'=>'1f629','wedding'=>'1f492','weight_lifter'=>'1f3cb','wf'=>'1f1fc-1f1eb','whale'=>'1f433','whale2'=>'1f40b','wheelchair'=>'267f','white_check_mark'=>'2705','white_circle'=>'26aa','white_down_pointing_left_hand_index'=>'1f597','white_flower'=>'1f4ae','white_hard_shell_floppy_disk'=>'1f5ab','white_large_square'=>'2b1c','white_latin_cross'=>'1f546','white_medium_small_square'=>'25fd','white_medium_square'=>'25fb','white_pennant'=>'1f3f1','white_small_square'=>'25ab','white_square_button'=>'1f533','white_touchtone_telephone'=>'1f57e','wind_blowing_face'=>'1f32c','wind_chime'=>'1f390','wine_glass'=>'1f377','wink'=>'1f609','wired_keyboard'=>'1f5ae','wolf'=>'1f43a','woman'=>'1f469','womans_clothes'=>'1f45a','womans_hat'=>'1f452','womens'=>'1f6ba','world_map'=>'1f5fa','worried'=>'1f61f','wrench'=>'1f527','writing_hand'=>'1f58e','ws'=>'1f1fc-1f1f8','x'=>'274c','xk'=>'1f1fd-1f1f0','ye'=>'1f1fe-1f1ea','yellow_heart'=>'1f49b','yen'=>'1f4b4','yum'=>'1f60b','za'=>'1f1ff-1f1e6','zap'=>'26a1','zero'=>'30-20e3','zm'=>'1f1ff-1f1f2','zw'=>'1f1ff-1f1fc','zzz'=>'1f4a4','100'=>'1f4af','1234'=>'1f522');

	protected $unicodeRegexp = '((?:(?:\\xE2(?:\\x8C[\\x9A\\x9B]|\\x8F[\\xA9-\\xAC\\xB0\\xB3]|\\x97[\\xBD\\xBE]|\\x98[\\x94\\x95]|\\x99[\\x88-\\x93\\xBF]|\\x9A[\\x93\\xA1\\xAA\\xAB\\xBD\\xBE]|\\x9B[\\x84\\x85\\x8E\\x94\\xAA\\xB2\\xB3\\xB5\\xBA\\xBD]|\\x9C[\\x85\\x8A\\x8B\\xA8]|\\x9D[\\x8C\\x8E\\x93-\\x95\\x97]|\\x9E[\\x95-\\x97\\xB0\\xBF]|\\xAC[\\x9B\\x9C]|\\xAD[\\x90\\x95])|\\xF0\\x9F(?:\\x80\\x84|\\x83\\x8F|\\x86[\\x8E\\x91-\\x9A]|\\x87[\\xA6-\\xBF]\\xF0\\x9F\\x87[\\xA6-\\xBF]|\\x88[\\x81\\x9A\\xAF\\xB2-\\xB6\\xB8-\\xBA]|\\x89[\\x90\\x91]|\\x8C[\\x80-\\xA0\\xB0-\\xB5\\xB7-\\xBF]|\\x8D[\\x80-\\xBC]|\\x8E[\\x80-\\x93\\xA0-\\xBF]|\\x8F[\\x80-\\x8A\\xA0-\\xB0\\xB4]|\\x90[\\x80-\\xBE]|\\x91[\\x80\\x82-\\xBF]|\\x92[\\x80-\\xBF]|\\x93[\\x80-\\xBC]|\\x94[\\x80-\\xBD]|\\x95[\\x90-\\xA7]|\\x96[\\x95\\x96]|\\x97[\\xBB-\\xBF]|\\x98[\\x80-\\xBF]|\\x99[\\x80-\\x82\\x85-\\x8F]|\\x9A[\\x80-\\xBF]|\\x9B[\\x80-\\x85\\x8C\\xAB\\xAC]))(?!\\xEF\\xB8\\x8E)(?:\\xEF\\xB8\\x8F)?|(?:\\xC2[\\xA9\\xAE]|\\xE2(?:\\x80\\xBC|\\x81\\x89|\\x84[\\xA2\\xB9]|\\x86[\\x94-\\x99\\xA9\\xAA]|\\x93\\x82|\\x96[\\xAA\\xAB\\xB6]|\\x97[\\x80\\xBB\\xBC]|\\x98[\\x80\\x81\\x8E\\x91\\x9D\\xBA]|\\x99[\\xA0\\xA3\\xA5\\xA6\\xA8\\xBB]|\\x9A\\xA0|\\x9C[\\x82\\x88\\x89\\x8C\\x8F\\x92\\x94\\x96\\xB3\\xB4]|\\x9D[\\x84\\x87\\xA4]|\\x9E\\xA1|\\xA4[\\xB4\\xB5]|\\xAC[\\x85-\\x87])|\\xE3(?:\\x80[\\xB0\\xBD]|\\x8A[\\x97\\x99])|\\xF0\\x9F(?:\\x85[\\xB0\\xB1\\xBE\\xBF]|\\x88[\\x82\\xB7]|\\x8C[\\xA1\\xA7-\\xAC\\xB6]|\\x8D\\xBD|\\x8E[\\x96\\x97\\x99-\\x9B\\x9E\\x9F]|\\x8F[\\x8B-\\x8E\\x94-\\x9F\\xB3\\xB5\\xB7]|\\x90\\xBF|\\x91\\x81|\\x93\\xBD|\\x95[\\x89\\x8A\\xAF\\xB0\\xB3-\\xB9]|\\x96[\\x87\\x8A-\\x8D\\x90\\xA5\\xA8\\xB2\\xBC]|\\x97[\\x82-\\x84\\x91-\\x93\\x9C-\\x9E\\xA1\\xA3\\xAF\\xB3\\xBA]|\\x9B[\\x8B\\x8D-\\x8F\\xA0-\\xA5\\xA9\\xB0\\xB3]))|[#0-9](?:\\xEF\\xB8\\x8F)?\\xE2\\x83\\xA3)(?![^<>]*(?=>|</code>)))S';
}