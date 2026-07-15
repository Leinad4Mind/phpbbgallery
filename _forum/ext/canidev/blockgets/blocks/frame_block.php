<?php
/*
* @name frame_block.php
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

class frame_block extends base
{
	static $icon = 'blg-icon-object-group';

	public function init()
	{
		$this->tpl_name = 'frame_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$this->template->assign_vars(array(
			'S_FRAME_MIMETYPE'	=> $data['frame_mimetype'],
			'S_FRAME_WIDTH'		=> ($data['frame_width']) ? $data['frame_width'] : '',
			'S_FRAME_HEIGHT'	=> ($data['frame_height']) ? $data['frame_height'] : '',
			'U_FRAME_URL'		=> $data['frame_url'],
		));

		unset($data);
		return true;
	}

	public function get_config()
	{
		$mimetypes = array(
			'text/plain'					=> 'MIME_PLAIN',
			'text/html'						=> 'MIME_HTML',
			'application/pdf'				=> 'MIME_PDF',
			'application/x-shockwave-flash'	=> 'MIME_FLASH',
		);

		$this->display_vars = array(
			'frame_mimetype' 	=> array('lang' => 'FRAME_MIMETYPE',	'validate' => 'string', 		'type' => 'select', 'method' => 'helper',	'params' => array('make_select', $mimetypes, '{CONFIG_VALUE}'),	'default' => 'text/html'),
			'frame_url'  		=> array('lang' => 'FRAME_URL',			'validate' => 'string:1:255',  	'type' => 'text:50:255'),
			'frame_width'  		=> array('lang' => 'FRAME_WIDTH',		'validate' => 'int',  			'type' => 'text:5:4'),
			'frame_height'  	=> array('lang' => 'FRAME_HEIGHT',		'validate' => 'int',  			'type' => 'text:5:4'),
		);

		return true;
	}
}
