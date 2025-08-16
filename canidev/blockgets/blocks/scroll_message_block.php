<?php
/*
* @package cBB Blockgets
* @version v2.0.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class scroll_message_block extends base
{
	static $icon = 'fa-film';

	public function init()
	{
		$this->tpl_name = 'scroll_message_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$this->template->assign_var('S_MARQUEE_TEXT', $this->generate_text_display($data['marquee_text']));

		$this->template->assign_json_var('S_MARQUEE_OPTIONS', array(
			'direction' 	=> $data['marquee_direction'],
			'align' 		=> $data['marquee_align'],
			'height' 		=> (($data['marquee_direction'] == 'left' || $data['marquee_direction'] == 'right') ? 'auto' : $data['marquee_height']),
			'delay' 		=> $data['marquee_scrolldelay'],
			'fps' 			=> $data['marquee_speed'],
			'background' 	=> $data['marquee_bgcolor'],
			'padding' 		=> $data['marquee_padding']
		));

		unset($data);
		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		switch($mode)
		{
			case 'validate':
				if(!empty($new['marquee_text']))
				{
					$bbcode = $this->bbcode('get');
					decode_message($new['marquee_text'], $bbcode['uid']);
				}
			break;

			case 'submit':
				$this->lang->add_lang('posting');

				$new['marquee_text'] = \canidev\core\tools::html_truncate($new['marquee_text'], 2000);

				generate_text_for_storage($new['marquee_text'], $uid, $bitfield, $flags, true, false, true, true, false, true, true, 'blockgets');
				$this->bbcode('set', $uid, $bitfield);
			break;
		}
	}

	public function get_config()
	{
		$this->display_vars = array(
			'marquee_direction' 	=> array('lang' => 'MARQUEE_DIRECTION',		'validate' => 'string', 'type' => 'select', 	'method' => 'helper',	'params' => array('scroll_select', '{CONFIG_VALUE}', 'direction'),	'default' => 'left'),
			'marquee_speed'  		=> array('lang' => 'MARQUEE_SPEED',			'validate' => 'int',  	'type' => 'text:3:2',	'default' => 2),
			'marquee_scrolldelay'  	=> array('lang' => 'MARQUEE_SCROLLDELAY',	'validate' => 'int',  	'type' => 'text:3:2',	'default' => 50),
			'marquee_align'  		=> array('lang' => 'MARQUEE_ALIGN', 		'validate' => 'string', 'type' => 'select', 	'method' => 'helper',	'params' => array('scroll_select', '{CONFIG_VALUE}', 'align'),	'default' => 'center'),
			'marquee_bgcolor'  		=> array('lang' => 'MARQUEE_BGCOLOR',		'validate' => 'string', 'type' => 'text:12:10',	'default' => ''),
			'marquee_height'  		=> array('lang' => 'MARQUEE_HEIGHT',		'validate' => 'int', 	'type' => 'text:4:3',	'default' => 20),
			'marquee_padding'  		=> array('lang' => 'MARQUEE_PADDING',		'validate' => 'string', 'type' => 'text:25:24',	'default' => '2px'),
			'marquee_text'			=> array('lang' => 'MARQUEE_TEXT',			'type' => 'custom',		'method' => 'helper',	'params' => array('build_editor', '{CONFIG_VALUE}', '{KEY}', 15, 5),	'default' => ''),
		);

		return true;
	}
}
