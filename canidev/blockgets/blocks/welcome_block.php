<?php
/*
* @package cBB Blockgets
* @version v2.0.2 12/01/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class welcome_block extends base
{
	static $icon = 'fa-heart';

	public function init()
	{
		$this->tpl_name = 'welcome_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$label	= (!empty($this->user->data['is_registered']) ? 'member' : 'guest');

		$this->template->assign_var('S_WELCOME_CONTENT', $this->generate_text_display($data["{$label}_text"]));

		unset($data);
		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		$bbcode = $this->bbcode('get');

		switch($mode)
		{
			case 'validate':
				decode_message($new['guest_text'], $bbcode['uid']);
				decode_message($new['member_text'], $bbcode['uid']);
			break;

			case 'submit':
				$this->lang->add_lang('posting');

				$bbcode_bitfield = '';
				
				if(!class_exists('parse_message', false))
				{
					include($this->phpbb_root_path . 'includes/message_parser.' . $this->php_ext);
				}

				$message_parser = new \parse_message();
				
				if($bbcode['uid'])
				{
					$message_parser->bbcode_uid = $bbcode['uid'];
				}

				// Parse guest message
				if($new['guest_text'])
				{
					$message_parser->message = \canidev\core\tools::html_truncate($new['guest_text'], 4000, '', true);
					$message_parser->parse(true, true, true);
					$bbcode_bitfield = $bbcode_bitfield | $message_parser->bbcode_bitfield;
					
					$new['guest_text'] = $message_parser->message;
				}
				
				// Parse member message
				if($new['member_text'])
				{
					$message_parser->message = \canidev\core\tools::html_truncate($new['member_text'], 4000, '', true);
					$message_parser->parse(true, true, true);
					$bbcode_bitfield = $bbcode_bitfield | $message_parser->bbcode_bitfield;
					
					$new['member_text'] = $message_parser->message;
				}
				
				$this->bbcode('set', $message_parser->bbcode_uid, $bbcode_bitfield);
			break;
		}
	}

	public function get_config()
	{
		$this->display_vars = array(
			'guest_text'	=> array('lang' => 'WELCOME_GUEST',		'type' => 'custom',	'method' => 'helper',	'params' => array('build_editor', '{CONFIG_VALUE}', '{KEY}', 20, 50), 'default' => ''),
			'member_text'	=> array('lang' => 'WELCOME_MEMBER',	'type' => 'custom',	'method' => 'helper',	'params' => array('build_editor', '{CONFIG_VALUE}', '{KEY}', 20, 50), 'default' => ''),
		);

		return true;
	}
}
