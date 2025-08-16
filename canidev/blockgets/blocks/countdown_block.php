<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class countdown_block extends base
{
	static $icon = 'fa-history';

	protected $date_regexp = '#([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})(?:$|\s([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}))#';

	/**
	 * {@inheritDoc}
	 */
	public function init($method = '')
	{
		$this->tpl_name = 'countdown_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$target_time = (int)@strtotime($data['target']);

		if(!$target_time)
		{
			return false;
		}

		$is_expired 	= ($target_time < time());
		$message_key 	= ($method == 'submit' || $is_expired) ? 'complete_msg' : 'running_msg';

		$this->template->assign_vars(array(
			'COUNTOWN_EXPIRED'		=> $is_expired,
			'S_COUNTDOWN_MESSAGE' 	=> $this->generate_text_display($data[$message_key])
		));

		$this->template->assign_json_var('COUNTDOWN_OPTIONS', array(
			'module'		=> $this->data['block_id'],
			'targetTime'	=> (int)@strtotime($data['target']),
		));

		$this->template->set_js_lang(array(
			'DAYS',
			'HOURS',
			'MINUTES',
			'SECONDS',
		));

		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function configure($mode, $block_row, &$new, &$submit)
	{
		$bbcode = $this->bbcode('get');

		switch($mode)
		{
			case 'validate':
				decode_message($new['running_msg'], $bbcode['uid']);
				decode_message($new['complete_msg'], $bbcode['uid']);
			break;

			case 'submit':
				$this->language->add_lang('posting');

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
				if($new['running_msg'])
				{
					$message_parser->message = \canidev\core\tools::html_truncate($new['running_msg'], 4000, '', true);
					$message_parser->parse(true, true, true);
					$bbcode_bitfield = $bbcode_bitfield | $message_parser->bbcode_bitfield;
					
					$new['running_msg'] = $message_parser->message;
				}
				
				// Parse member message
				if($new['complete_msg'])
				{
					$message_parser->message = \canidev\core\tools::html_truncate($new['complete_msg'], 4000, '', true);
					$message_parser->parse(true, true, true);
					$bbcode_bitfield = $bbcode_bitfield | $message_parser->bbcode_bitfield;
					
					$new['complete_msg'] = $message_parser->message;
				}
				
				$this->bbcode('set', $message_parser->bbcode_uid, $bbcode_bitfield);
			break;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$this->display_vars = array(
			'target'			=> array('lang' => 'COUNTDOWN_TARGET',			'type' => 'text:25:20', 		'validate' => 'regexp',		'regexp' => $this->date_regexp, 	'default' => ''),
			'running_msg'		=> array('lang' => 'COUNTDOWN_RUNNING_MSG',		'type' => 'custom',				'method' => 'helper',		'params' => array('build_editor', '{CONFIG_VALUE}', '{KEY}', 10, 5),	'default' => ''),
			'complete_msg'		=> array('lang' => 'COUNTDOWN_COMPLETE_MSG',	'type' => 'custom',				'method' => 'helper',		'params' => array('build_editor', '{CONFIG_VALUE}', '{KEY}', 10, 5),	'default' => ''),
		);

		return true;
	}
}
