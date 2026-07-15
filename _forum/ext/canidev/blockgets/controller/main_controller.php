<?php
/*
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\controller;

use Symfony\Component\HttpFoundation\Response;

/**
* Main controller
*/
class main_controller implements main_interface
{
	protected $blockgets;
	protected $db;
	protected $template;
	protected $user;

	/**
	* Constructor
	*
	* @param \canidev\blockgets\libraries\blockgets		$blockgets		Blockgets Object
	* @param \phpbb\db\driver\driver_interface			$db				DB Object
	* @param \phpbb\template\template					$template     	Template object
	* @param \phpbb\user								$user			User object
	*
	* @access public
	*/
	public function __construct(
		\canidev\blockgets\libraries\blockgets $blockgets,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\template\template $template,
		\phpbb\user $user)
	{
		$this->blockgets	= $blockgets;
		$this->db 			= $db;
		$this->template		= $template;
		$this->user			= $user;
	}

	/**
	* Display the portal
	* @access public
	*/
	public function display($page = '')
	{
		define('BLG_HOME_PAGE', true);

		$this->blockgets->set_page($page);

		$page_data = $this->blockgets->load_page(true);

		// Set the page style
		if(!empty($page_data['style']) && $page_data['style'] != $this->user->style['style_id'])
		{
			$sql = 'SELECT *
				FROM ' . STYLES_TABLE . ' s
				WHERE s.style_id = ' . (int)$page_data['style'];
			$result = $this->db->sql_query($sql, 3600);
			$style_data = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			
			if($style_data)
			{
				$this->user->style = $style_data;
				$this->template->set_style(array('ext/canidev/blockgets/styles', 'styles'));
			}
		}
		
		page_header('');

		$this->template->set_filenames(array(
			'body'	=> '@canidev_blockgets/custom_body.html',
		));

		page_footer(true, false, false);

		$headers = !empty($this->user->data['is_bot']) ? array('X-PHPBB-IS-BOT' => 'yes') : array();

		return new Response($this->template->assign_display('body'), 200, $headers);
	}
}
