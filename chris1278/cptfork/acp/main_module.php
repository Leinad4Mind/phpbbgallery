<?php
/**
 *
 * CF Change Post Time
 *
 * @copyright (c) 2024 chris1278
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
 */

namespace chris1278\cptfork\acp;

class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container;
		$acp_controller 	= $phpbb_container->get('chris1278.cptfork.controller.acp');
		$language			= $phpbb_container->get('language');
		$acp_controller->set_page_url($this->u_action);

		switch ($mode)
		{
			case 'settings':
				$this->page_title = $language->lang('CF_CPT_TITLE');
				$this->tpl_name = 'acp_cptfork_settings';
				$acp_controller->general_modul();
			break;
		}
	}
}
