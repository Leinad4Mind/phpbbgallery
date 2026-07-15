<?php
/*
* @name map_block.php
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

class map_block extends base
{
	static $icon = 'blg-icon-globe';

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
			foreach($data['list'] as $marker)
			{
				list($lat, $lng) = array_map('floatval', explode(',', $marker['position']));

				$options['markers'][] = array(
					'image'		=> $this->helper->build_image_filename($marker['image'], true),
					'title'		=> $marker['title'],
					'lat'		=> $lat,
					'lng'		=> $lng,
				);
			}
		}
		
		$this->template->assign_vars(array(
			'S_MAP_OPTIONS'	=> json_encode($options),
		));

		$this->template->append_asset('js', 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=' . base64_decode(BLG_GOOGLE_KEY), 'frontend');

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
		$this->template->append_asset('js', 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=' . base64_decode(BLG_GOOGLE_KEY), 'admin');

		$this->display_vars = array(
			'center'		=> array('lang' => 'MAP_CENTER',		'type' => 'custom',		'function' => array($this, 'build_latlng_template'),	'params' => array('{CONFIG_VALUE}')),
			'zoom'			=> array('lang' => 'MAP_ZOOM',			'validate' => 'int',	'type' => 'text:4:3',	'default' => 5),
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
			'IS_BLG_AJAX'		=> $this->request->is_ajax(),
			'LATLNG_HELPER'		=> true,
			'HP_ID'				=> gen_rand_string(4),
			'HP_LAT'			=> $lat,
			'HP_LNG'			=> $lng,
		));

		$this->template->set_filenames(array(
			'helper'	=> '../../styles/all/template/blocks/map_block.html'
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
			$event['item_row'] = $row;
		}
		else
		{
			$error = $event['error'];
			$error[] = $this->lang->get('LOCATION_INCORRECT');
			$event['error'] = $error;
		}
	}
	
	public function list_edit_before($event)
	{
		$event['display_vars'] = array(
			'title'		=> array('lang' => 'LOCATION_TITLE',		'validate' => 'string:1:255',	'type' => 'text:40:255'),
			'position'	=> array('lang' => 'LOCATION_POSITION',		'type' => 'custom',				'function' => array($this, 'build_latlng_template'),	'params' => array('{CONFIG_VALUE}')),
			'image'		=> array('lang' => 'LOCATION_IMAGE',		'validate' => 'string', 		'type' => 'custom',			'method' => 'helper',	'params' => array('icon_template', '{KEY}', '{CONFIG_VALUE}', 'image')),
		);
		
		$event['dialog_title'] = ($event['action'] == 'edit') ? 'LOCATION_EDIT' : 'LOCATION_ADD';
	}
}
