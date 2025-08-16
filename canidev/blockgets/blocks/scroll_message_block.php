<?php
/*
* @name scroll_message_block.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class scroll_message_block extends base
{
	static $icon = 'blg-icon-film';

	public function init()
	{
		$this->tpl_name = 'scroll_message_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('message');

		$this->template->assign_block_vars('message', array(
			'DIRECTION' 	=> $data['marquee_direction'],
			'SPEED' 	    => $data['marquee_speed'],
			'SCROLLDELAY' 	=> $data['marquee_scrolldelay'], 
			'ALIGN' 		=> $data['marquee_align'],        
			'BGCOLOR' 		=> $data['marquee_bgcolor'],  
			'HEIGHT' 		=> (($data['marquee_direction'] == 'left' || $data['marquee_direction'] == 'right') ? 'auto' : $data['marquee_height']),
			'PADDING'		=> $data['marquee_padding'],
			'TEXT'			=> $this->generate_text_display($data['marquee_text']),
		));

		unset($data);
		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		$parser = $this->container->get('canidev.blockgets.parser');

		switch($mode)
		{
			case 'validate':
				if(!empty($new['marquee_text']))
				{
					$bbcode = $this->bbcode('get');
					$parser->decode_message($new['marquee_text'], $bbcode['uid']);
				}
			break;

			case 'submit':
				$this->lang->add('posting');

				$new['marquee_text'] = $this->helper->html_truncate($new['marquee_text'], 2000);

				$parser->generate_text_for_storage($new['marquee_text'], $uid, $bitfield, $flags);
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
