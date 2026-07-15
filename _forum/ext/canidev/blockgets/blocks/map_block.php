<?php
/*
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

class map_block extends base
{
	static $icon = 'fa-globe';
	protected $google_api_url = 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=';

	public function init()
	{
		$this->tpl_name = 'map_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		$options = array(
			'zoom'		=> (int)$data['zoom'],
			'markers'	=> array(),
		);
		
		if($data['center'])
		{
			list($lat, $lng) = array_map('floatval', explode(',', $data['center']));
			
			if($lat && $lng)
			{
				$options += array(
					'latitude'	=> $lat,
					'longitude'	=> $lng,
				);
			}
		}
		
		// Build markers array
		if(!empty($data['list']))
		{
			$media = $this->helper->get_media(false, false);

			foreach($data['list'] as $marker)
			{
				list($lat, $lng) = array_map('floatval', explode(',', $marker['position']));

				$content = '';

				if(!empty($marker['text']))
				{
					$content = generate_text_for_display($marker['text'], $marker['bbcode_uid'], $marker['bbcode_bitfield'], OPTION_FLAG_BBCODE | OPTION_FLAG_SMILIES | BLG_FLAG_HTML);
				}

				$options['markers'][] = array(
					'image'		=> $media->get_full_path($marker['image'], true),
					'title'		=> $marker['title'],
					'content'	=> $content,
					'lat'		=> $lat,
					'lng'		=> $lng,
				);
			}
		}
		
		$this->template->assign_json_var('S_MAP_OPTIONS', $options);

		$this->template->append_asset('js', $this->google_api_url . base64_decode(BLG_GOOGLE_KEY), false, 'frontend');

		return true;
	}
	
	public function configure($mode, $block_row, &$new, &$submit)
	{
		if($mode == 'validate' && $submit)
		{
			$lat = floatval($this->request->variable('latitude', ''));
			$lng = floatval($this->request->variable('longitude', ''));

			$new['center'] = ($lat && $lng) ? $lat . ',' . $lng : '';
		}

		return true;
	}
	
	public function get_config()
	{
		$this->template->append_asset('js', $this->google_api_url . base64_decode(BLG_GOOGLE_KEY), false, 'admin');

		$this->display_vars = array(
			'center'		=> array('lang' => 'MAP_CENTER',		'type' => 'custom',		'function' => array($this, 'build_latlng_template'),	'params' => array('{CONFIG_VALUE}')),
			'zoom'			=> array('lang' => 'MAP_ZOOM',			'validate' => 'int',	'type' => 'number',	'default' => 5),
		);
		
		$this->list = $this->container->get('canidev.blockgets.admin.links');
		
		$this->list
			->set_options(array(
				'btn_title'	=> 'LOCATION_ADD',
				'title'		=> 'MAP_LOCATIONS',
				'type'		=> LIST_TYPE_NONE,
				'mask'		=> array(
					'title'		=> 'title',
					'subtitle'	=> 'position',
				)
			))
			->set_events(array(
				'edit.before'	=> array($this, 'list_edit_before'),
				'edit.after'	=> array($this, 'list_edit_after'),
			));

		return true;
	}
	
	public function build_latlng_template($value)
	{
		$lat = $lng = '';
		
		if($value)
		{
			list($lat, $lng) = array_map('floatval', explode(',', $value));
		}
		
		$this->template->assign_vars(array(
			'LATLNG_HELPER'		=> true,
			'HP_ID'				=> gen_rand_string(4),
			'HP_LAT'			=> $lat,
			'HP_LNG'			=> $lng,
		));

		$this->template->set_filenames(array(
			'helper'	=> '@canidev_blockgets/blocks/map_block.html'
		));
		
		return $this->template->assign_display('helper');
	}
	
	public function list_edit_after($event)
	{
		$lat = floatval($this->request->variable('latitude', ''));
		$lng = floatval($this->request->variable('longitude', ''));
		$row = $event['item_row'];

		if($lat && $lng)
		{
			$row['position'] = $lat . ',' . $lng;

			if($row['text'])
			{
				$bbcode_uid = $bbcode_bitfield = $flags = '';

				generate_text_for_storage($row['text'], $bbcode_uid, $bbcode_bitfield, $flags, true, true, true, true, false, true, true, 'blockgets');

				$row['bbcode_uid'] 		= $bbcode_uid;
				$row['bbcode_bitfield']	= $bbcode_bitfield;
			}

			$event['item_row'] = $row;
		}
		else
		{
			$error = $event['error'];
			$error[] = $this->lang->lang('LOCATION_INCORRECT');
			$event['error'] = $error;
		}
	}
	
	public function list_edit_before($event)
	{
		$media = $this->helper->get_media();

		$event['display_vars'] = array(
			'title'		=> array('lang' => 'LOCATION_TITLE',		'validate' => 'string:1:255',	'type' => 'text:40:255'),
			'position'	=> array('lang' => 'LOCATION_POSITION',		'type' => 'custom',				'function' => array($this, 'build_latlng_template'),	'params' => array('{CONFIG_VALUE}')),
			'image'		=> array('lang' => 'LOCATION_IMAGE',		'type' => 'custom',				'function' => array($media, 'build_selector'),			'params' => array('{KEY}', 'image', '{CONFIG_VALUE}', 1),	'default' => ''),
			'text'		=> array('lang' => 'LOCATION_TEXT',			'type' => 'custom',				'method' => 'helper',									'params' => array('build_editor', '{CONFIG_VALUE}', '{KEY}', 15, 50), 'default' => ''),
		);
		
		$event['dialog_title'] = ($event['action'] == 'edit') ? 'LOCATION_EDIT' : 'LOCATION_ADD';

		if(!empty($event['item_row']['text']))
		{
			$row = $event['item_row'];
			decode_message($row['text'], $row['bbcode_uid']);
			$event['item_row'] = $row;
		}
	}
}
