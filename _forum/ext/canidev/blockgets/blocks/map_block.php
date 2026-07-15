<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

use canidev\blockgets\libraries\constants;
use canidev\core\TextParser;

class map_block extends base
{
	static $icon = 'fa-globe';
	protected $google_api_url = 'https://maps.googleapis.com/maps/api/js?v=3.exp&callback=nothing&key=';

	/**
	 * {@inheritDoc}
	 */
	public function init()
	{
		$this->tpl_name = 'map_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		$options = [
			'zoom'		=> (int)$data['zoom'],
			'markers'	=> [],
		];
		
		if($data['center'])
		{
			list($lat, $lng) = array_map('floatval', explode(',', $data['center']));
			
			if($lat && $lng)
			{
				$options += [
					'latitude'	=> $lat,
					'longitude'	=> $lng,
				];
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
					$content = $this->text_parser->generateForDisplay($marker['text'], TextParser::FLAG_CENSOR_TEXT, $marker['bbcode_uid'], $marker['bbcode_bitfield'], constants::FLAG_HTML);
				}

				$options['markers'][] = [
					'image'		=> $media->getFullPath($marker['image'], true),
					'title'		=> $marker['title'],
					'content'	=> $content,
					'lat'		=> $lat,
					'lng'		=> $lng,
				];
			}
		}
		
		$this->template->assign_json_var('S_MAP_OPTIONS', $options);

		$this->template->append_asset('js', $this->google_api_url . base64_decode(constants::GOOGLE_KEY), false, 'frontend');

		return true;
	}
	
	/**
	 * {@inheritDoc}
	 */
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
	
	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$this->template->append_asset('js', $this->google_api_url . base64_decode(constants::GOOGLE_KEY), false, 'admin');

		$this->display_vars = [
			'center'		=> ['lang' => 'MAP_CENTER',		'type' => 'custom',		'function' => [$this, 'build_latlng_template'],	'params' => ['{CONFIG_VALUE}']],
			'zoom'			=> ['lang' => 'MAP_ZOOM',		'validate' => 'int',	'type' => 'number',	'default' => 5],
		];
		
		$this->list = $this->container->get('canidev.blockgets.admin.links');
		
		$this->list
			->set_options([
				'btn_title'	=> 'LOCATION_ADD',
				'title'		=> 'MAP_LOCATIONS',
				'type'		=> constants::LIST_TYPE_NONE,
				'mask'		=> [
					'title'		=> 'title',
					'subtitle'	=> 'position',
				]
			])
			->set_events([
				'edit.before'	=> [$this, 'list_edit_before'],
				'edit.after'	=> [$this, 'list_edit_after'],
			]);

		return true;
	}
	
	/**
	 * Build template for lat/lng
	 * 
	 * @param string $value
	 * @return string
	 */
	public function build_latlng_template($value)
	{
		$lat = $lng = '';
		
		if($value)
		{
			list($lat, $lng) = array_map('floatval', explode(',', $value));
		}
		
		$this->template->assign_vars([
			'LATLNG_HELPER'		=> true,
			'HP_ID'				=> gen_rand_string(4),
			'HP_LAT'			=> $lat,
			'HP_LNG'			=> $lng,
		]);

		$this->template->set_filenames([
			'helper'	=> '@canidev_blockgets/blocks/map_block.html'
		]);
		
		return $this->template->assign_display('helper');
	}
	
	/**
	 * Event for list
	 * @param \phpbb\event\data 	$event
	 */
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
			$error[] = $this->language->lang('LOCATION_INCORRECT');
			$event['error'] = $error;
		}
	}
	
	/**
	 * Event for list
	 * @param \phpbb\event\data 	$event
	 */
	public function list_edit_before($event)
	{
		$media = $this->helper->get_media();

		$event['display_vars'] = [
			'title'		=> ['lang' => 'LOCATION_TITLE',			'validate' => 'string:1:255',	'type' => 'text:40:255'],
			'position'	=> ['lang' => 'LOCATION_POSITION',		'type' => 'custom',				'function' => [$this, 'build_latlng_template'],		'params' => ['{CONFIG_VALUE}']],
			'image'		=> ['lang' => 'LOCATION_IMAGE',			'type' => 'custom',				'function' => [$media, 'buildSelector'],			'params' => ['{KEY}', 'image', '{CONFIG_VALUE}', 1],	'default' => ''],
			'text'		=> ['lang' => 'LOCATION_TEXT',			'type' => 'custom',				'function' => ['helper_acp', 'build_editor'],		'params' => ['{CONFIG_VALUE}', '{KEY}', 15, 50], 'default' => ''],
		];
		
		$event['dialog_title'] = ($event['action'] == 'edit') ? 'LOCATION_EDIT' : 'LOCATION_ADD';

		if(!empty($event['item_row']['text']))
		{
			$row = $event['item_row'];
			decode_message($row['text'], $row['bbcode_uid']);
			$event['item_row'] = $row;
		}
	}
}
