<?php
/**
 * @package cBB Blockgets
 * @version 2.0.6 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class scroll_message_block extends base
{
	static $icon = 'fa-film';

	/**
	 * {@inheritDoc}
	 */
	public function init()
	{
		$this->tpl_name = 'scroll_message_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$this->template->assign_var('S_MARQUEE_TEXT', $this->generate_text_display($data['marquee_text']));

		$this->template->assign_json_var('S_MARQUEE_OPTIONS', [
			'direction' 	=> $data['marquee_direction'],
			'align' 		=> $data['marquee_align'],
			'height' 		=> (($data['marquee_direction'] == 'left' || $data['marquee_direction'] == 'right') ? 'auto' : $data['marquee_height']),
			'delay' 		=> $data['marquee_scrolldelay'],
			'fps' 			=> $data['marquee_speed'],
			'background' 	=> $data['marquee_bgcolor'],
			'padding' 		=> $data['marquee_padding']
		]);

		unset($data);
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
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
				$this->language->add_lang('posting');

				$new['marquee_text'] = \canidev\core\TextParser::truncate($new['marquee_text'], 2000);

				generate_text_for_storage($new['marquee_text'], $uid, $bitfield, $flags, true, false, true, true, false, true, true, 'blockgets');
				$this->bbcode('set', $uid, $bitfield);
			break;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$this->display_vars = [
			'marquee_direction' 	=> ['lang' => 'MARQUEE_DIRECTION',		'validate' => 'string', 'type' => 'select', 		'method' => 'helper',	'params' => ['scroll_select', '{CONFIG_VALUE}', 'direction'],	'default' => 'left'],
			'marquee_speed'  		=> ['lang' => 'MARQUEE_SPEED',			'validate' => 'int',  	'type' => 'number',			'default' => 2],
			'marquee_scrolldelay'  	=> ['lang' => 'MARQUEE_SCROLLDELAY',	'validate' => 'int',  	'type' => 'number',			'default' => 50],
			'marquee_align'  		=> ['lang' => 'MARQUEE_ALIGN', 			'validate' => 'string', 'type' => 'select', 		'method' => 'helper',	'params' => ['scroll_select', '{CONFIG_VALUE}', 'align'],	'default' => 'center'],
			'marquee_bgcolor'  		=> ['lang' => 'MARQUEE_BGCOLOR',		'validate' => 'string', 'type' => 'text:12:10',		'default' => ''],
			'marquee_height'  		=> ['lang' => 'MARQUEE_HEIGHT',			'validate' => 'int', 	'type' => 'number',			'default' => 20],
			'marquee_padding'  		=> ['lang' => 'MARQUEE_PADDING',		'validate' => 'string', 'type' => 'text:25:24',		'default' => '2px'],
			'marquee_text'			=> ['lang' => 'MARQUEE_TEXT',			'type' => 'custom',		'method' => 'helper',		'params' => ['build_editor', '{CONFIG_VALUE}', '{KEY}', 15, 5],	'default' => ''],
		];

		return true;
	}
}
