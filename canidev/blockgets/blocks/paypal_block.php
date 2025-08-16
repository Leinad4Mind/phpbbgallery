<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class paypal_block extends base
{
	static $icon = 'fa-paypal';

	/**
	 * {@inheritDoc}
	 */
	public function init()
	{
		$this->tpl_name = 'paypal_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$default_img = 'https://www.paypal.com/' . $this->helper->locale_lang(false, 'iso') . '/i/btn/btn_donate_LG.gif';
		
		$amount_options = $s_currency_options = '';

		if(!empty($data['amounts']))
		{
			$amounts = explode(';', $data['amounts']);
			
			foreach($amounts as $amount)
			{
				$amount_options .= sprintf('<option value="%1$.2f">%1$.2f</option>', $amount);
			}
		}
		
		if(!empty($data['currencies']))
		{
			foreach($data['currencies'] as $value)
			{
				if($this->language->is_set(array('currencies', $value)))
				{
					$selected = ($value == $data['default_currency']) ? ' selected="selected"' : '';
					$s_currency_options .= '<option value="' . $value . '"' . $selected . '>' . $this->language->lang(array('currencies', $value)) . '</option>';
				}
			}
		}
		
		$this->template->assign_vars(array(
			'S_PAYPAL_MSG'				=> $this->generate_text_display($data['msg']),
			'S_PAYPAL_IMG'				=> (!empty($data['button_img']) ? $data['button_img'] : $default_img),
			'S_PAYPAL_AMOUNTS'			=> $amount_options,
			'S_PAYPAL_CURRENCY_OPTIONS'	=> $s_currency_options,
			
			'S_BLOCK_HIDDEN_FIELDS'	=> build_hidden_fields(array(
				'business'	=> $data['account'],
				'cmd'		=> '_donations',
				'item_name'	=> $data['item']
			))
		));
		
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
				if(!empty($new['msg']))
				{
					$bbcode = $this->bbcode('get');
					decode_message($new['msg'], $bbcode['uid']);
				}
				
				if(!empty($new['default_currency']) && !$submit)
				{
					$this->request->overwrite('default_currency', $new['default_currency']);
				}
			break;

			case 'submit':
				$this->language->add_lang('posting');

				generate_text_for_storage($new['msg'], $uid, $bitfield, $flags, true, false, true, true, false, true, true, 'blockgets');
				$this->bbcode('set', $uid, $bitfield);
				
				$new['currencies'] 			= $this->request->variable('currency', array(0 => ''));
				$new['default_currency']	= $this->request->variable('default_currency', '');
			break;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$this->display_vars = array(
			'item'				=> array('lang' => 'PAYPAL_ITEM',		'validate' => 'string:5:100',	'type' => 'text:40:100',			'default' => 'paypal'),
			'account'			=> array('lang' => 'PAYPAL_ACCOUNT',	'validate' => 'string:6:100',	'type' => 'text:30:100',			'default' => 'account@paypal.com'),
			'msg'				=> array('lang' => 'PAYPAL_MSG',		'type' => 'custom',				'method' => 'helper',				'params' => array('build_editor', '{CONFIG_VALUE}', '{KEY}', 10, 5),	'default' => ''),
			'button_img'		=> array('lang' => 'PAYPAL_IMG',		'validate' => 'string:0:255',	'type' => 'custom',		'method' => 'helper',	'params' => array('easy_input_template', '{KEY}', '{CONFIG_VALUE}', 1),	'default' => ''),
			'amounts'			=> array('lang' => 'PAYPAL_AMOUNTS',	'validate' => 'string:0:255',	'type' => 'text:50:255',			'default' => '5;10;15;20;25;30;40;50;75;100;200;300;400;500;750;1000'),
			'currencies'		=> array('lang' => 'PAYPAL_CURRENCIES',	'type' => 'custom',	'function' => array($this, 'build_currency'),	'params' => array('{CONFIG_VALUE}'),	'default' => []),
			'default_currency'	=> false,
		);

		return true;
	}
	
	/**
	 * Build currency template
	 * 
	 * @param array 	$selected_ary
	 */
	public function build_currency($selected_ary = [])
	{
		$output = '';

		if($this->language->is_set('currencies'))
		{
			$default = $this->request->variable('default_currency', '');

			foreach($this->language->lang_raw('currencies') as $value => $title)
			{
				$default_checked = ($value == $default) ? ' checked="checked"' : '';
				$checked = (in_array($value, $selected_ary) ? ' checked="checked"' : '');

				$output .= '<div><input type="radio" class="radio" name="default_currency" value="' . $value . '"' . $default_checked . ' />&nbsp;';
				$output .= '<label><input type="checkbox" class="radio" name="currency[]" value="' . $value . '"' . $checked . ' /> ' . $title . '</label></div>';
			}
		}
		
		return $output;
	}
}
