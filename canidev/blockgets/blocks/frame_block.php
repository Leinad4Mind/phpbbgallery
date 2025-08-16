<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class frame_block extends base
{
	static $icon = 'fa-object-group';

	/**
	 * {@inheritDoc}
	 */
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

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$mimetypes = array(
			'text/plain'		=> 'MIME_PLAIN',
			'text/html'			=> 'MIME_HTML',
			'application/pdf'	=> 'MIME_PDF',
		);

		$this->display_vars = array(
			'frame_mimetype' 	=> array('lang' => 'FRAME_MIMETYPE',	'validate' => 'string', 		'type' => 'select', 'method' => 'helper',	'params' => array('make_select', $mimetypes, false,'{CONFIG_VALUE}'),	'default' => 'text/html'),
			'frame_url'  		=> array('lang' => 'FRAME_URL',			'validate' => 'string:1:255',  	'type' => 'text:50:255'),
			'frame_width'  		=> array('lang' => 'FRAME_WIDTH',		'validate' => 'int',  			'type' => 'number'),
			'frame_height'  	=> array('lang' => 'FRAME_HEIGHT',		'validate' => 'int',  			'type' => 'number'),
		);

		return true;
	}
}
