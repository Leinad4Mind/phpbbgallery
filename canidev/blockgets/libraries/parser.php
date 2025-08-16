<?php
/*
* @name parser.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\libraries;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class parser
{
	private $bbcodes = array();

	/**
	* Constructor
	*
	* @param \phpbb\event\dispatcher_interface			$phpbb_dispatcher	Event dispatcher
	* @param string										$root_path			phpBB root path
	* @param string										$php_ext			phpEx
	*
	* @access public
	*/
	public function __construct($phpbb_dispatcher, $root_path, $php_ext)
	{
		$this->dispatcher = $phpbb_dispatcher;

		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
		
		$this->bbcodes = array(
			'html' => array(
				'match'		=> '#\[html\](.*?)\[/html\]#s',
				'replace'	=> function($matches) {
					return htmlspecialchars_decode($matches[1], ENT_COMPAT);
				},
			),
			'center'	=> array('<div style="text-align:center;">', '</div>'),
			'font'		=> array(
				'match'		=> array('#\[font=(.*?)\]#', '#\[/font\]#'),
				'replace'	=> array('<span style="font-family:\\1;">', '</span>')
			),
			'justify'	=> array('<div style="text-align:justify;">', '</div>'),
			'right'		=> array('<div style="text-align:right;">', '</div>'),
			's'			=> 'strike',
			'youtube'	=> array(
				'match'		=> array('#\[youtube\]([\w\d\-]+)\[/youtube\]#'),
				'replace'	=> array('<iframe class="yt-video" width="560" height="315" src="https://www.youtube.com/embed/\\1" frameborder="0" allowfullscreen></iframe>')
			),
		);
	}
	
	public function parse_bbcode($message)
	{
		foreach($this->bbcodes as $bbcode => $row)
		{
			if(strpos($message, "[$bbcode") === false)
			{
				continue;
			}

			if(isset($row[0]) || is_string($row))
			{
				$match		= array('[' . $bbcode . ']', '[/' . $bbcode . ']');
				$replace	= (isset($row[0]) ? array($row[0], $row[1]) : array('<' . $row . '>', '</' . $row . '>'));
				
				$message = str_replace($match, $replace, $message);
			}
			else if(isset($row['match']))
			{
				if($row['replace'] instanceof \Closure)
				{
					$message = preg_replace_callback($row['match'], $row['replace'], $message);
				}
				else
				{
					$message = preg_replace($row['match'], $row['replace'], $message);
				}
			}
		}
		
		return $message;
	}
	
	public function decode_message(&$message, $bbcode_uid = '')
	{
		if($bbcode_uid)
		{
			$match 		= array('<br />', "[/*:m:$bbcode_uid]", ":u:$bbcode_uid", ":o:$bbcode_uid", ":$bbcode_uid");
			$replace	= array("\n", '', '', '', '');
		}
		else
		{
			$match 		= array('<br />');
			$replace	= array("\n");
		}

		/**
		* Use this event to modify the message before it is decoded
		*
		* @event core.decode_message_before
		* @var string	message_text	The message content
		* @var string	bbcode_uid		The message BBCode UID
		* @since 3.1.9-RC1
		*/
		$message_text = $message;
		$vars = array('message_text', 'bbcode_uid');
		extract($this->dispatcher->trigger_event('core.decode_message_before', compact($vars)));
		
		$message = $message_text;
		$message = str_replace($match, $replace, $message);

		$match 		= get_preg_expression('bbcode_htm');
		$replace	= array('\0', '\0', '\0', '\1', '\0', '\0');

		$message = preg_replace($match, $replace, $message);

		/**
		* Use this event to modify the message after it is decoded
		*
		* @event core.decode_message_after
		* @var string	message_text	The message content
		* @var string	bbcode_uid		The message BBCode UID
		* @since 3.1.9-RC1
		*/
		$message_text = $message;
		$vars = array('message_text', 'bbcode_uid');
		extract($this->dispatcher->trigger_event('core.decode_message_after', compact($vars)));
		$message = $message_text;
	}
	
	public function generate_text_for_display($text, $uid, $bitfield, $flags, $censor_text = true)
	{
		$board_url	= generate_board_url();
		
		// Clear line breaks on html tags
		$text = preg_replace_callback('#\[html\].*?\[/html\]#si', function($matches) {
			return str_replace(array('<br/>', "\n"), '', $matches[0]);
		}, $text);
		
		$text 		= generate_text_for_display($text, $uid, $bitfield, $flags, $censor_text);
		$text 		= $this->parse_bbcode($text);
		
		// Adjust the url of emoticons (phpBB < 3.1.11 has no event for this)
		$text = preg_replace_callback('#class\="smilies" src\="(.*?)(/images/.*?)"#', function($matches) use ($board_url) {
			return 'class="smilies" src="' . $board_url . $matches[2] . '"';
		}, $text);
		
		return $text;
	}

	public function generate_text_for_storage(&$text, &$uid, &$bitfield, &$flags, $allow_bbcode = true, $allow_urls = true, $allow_smilies = true)
	{
		/**
		* Use this event to modify the text before it is prepared for storage
		*
		* @event core.modify_text_for_storage_before
		* @var string	text			The text to parse
		* @var string	uid				The BBCode UID
		* @var string	bitfield		The BBCode Bitfield
		* @var int		flags			The BBCode Flags
		* @var bool		allow_bbcode	Whether or not to parse BBCode
		* @var bool		allow_urls		Whether or not to parse URLs
		* @var bool		allow_smilies	Whether or not to parse Smilies
		* @since 3.1.0-a1
		*/
		$vars = array(
			'text',
			'uid',
			'bitfield',
			'flags',
			'allow_bbcode',
			'allow_urls',
			'allow_smilies',
		);
		extract($this->dispatcher->trigger_event('core.modify_text_for_storage_before', compact($vars)));

		$uid = $bitfield = '';
		$flags = (($allow_bbcode) ? OPTION_FLAG_BBCODE : 0) + (($allow_smilies) ? OPTION_FLAG_SMILIES : 0) + (($allow_urls) ? OPTION_FLAG_LINKS : 0);

		if($text === '')
		{
			return;
		}

		if(!class_exists('parse_message', false))
		{
			include($this->phpbb_root_path . 'includes/message_parser.' . $this->php_ext);
		}

		$message_parser = new \parse_message($text);
		$message_parser->parse($allow_bbcode, false, $allow_smilies, $allow_bbcode, $allow_bbcode, $allow_bbcode, $allow_urls, true, 'blockgets');

		$text	= $message_parser->message;
		$uid	= $message_parser->bbcode_uid;

		// If the bbcode_bitfield is empty, there is no need for the uid to be stored.
		if(!$message_parser->bbcode_bitfield)
		{
			$uid = '';
		}

		$bitfield = $message_parser->bbcode_bitfield;

		/**
		* Use this event to modify the text after it is prepared for storage
		*
		* @event core.modify_text_for_storage_after
		* @var string	text			The text to parse
		* @var string	uid				The BBCode UID
		* @var string	bitfield		The BBCode Bitfield
		* @var int		flags			The BBCode Flags
		* @since 3.1.0-a1
		*/
		$vars = array('text', 'uid', 'bitfield', 'flags');
		extract($this->dispatcher->trigger_event('core.modify_text_for_storage_after', compact($vars)));

		return $message_parser->warn_msg;
	}
}
