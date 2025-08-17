<?php
/**
*
* BBlightbox
* @copyright (c) 2017 sitesplat.com All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bblightbox\acp;

class bblightbox_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $user, $template, $cache, $request;
		global $config, $phpbb_container;

		
		$this->settings = json_decode($config['bblightbox'], true);
		$user->add_lang_ext('sitesplat/bblightbox', 'info_acp_bblightbox');
		$this->tpl_name = 'bblightbox';
		$this->page_title = $user->lang('ACP_BBLIGHTBOX_TITLE');
		add_form_key('sitesplat/bblightbox');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('sitesplat/bblightbox'))
			{
				trigger_error('FORM_INVALID');
			}
			
			$bblightbox = $request->variable('bblightbox', array('' => ''));
			
			$this->settings = $bblightbox;
			$config->set('bblightbox', json_encode($bblightbox));

			trigger_error($user->lang('ACP_BBLIGHTBOX_SETTING_SAVED') . adm_back_link($this->u_action));
		}


		if ($request->variable('action', '') == 'details')
		{
			$phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/bblightbox');
			$this->tpl_name = 'acp_ext_details';
		} else
		{
			foreach (array('------', 'baguetteBox', 'fancybox', 'Chocolat', 'jsOnlyLightbox') as $plugin)
			{
				$template->assign_block_vars('plugins', array(
					'NAME'		=> $plugin,
					'SELECTED'	=> ($plugin == $this->settings['plugin']) ? ' selected="selected"' : ''
				));
			}
	
			$template->assign_vars(array(
				'U_ACTION'					=> $this->u_action,
				'BBLIGHTBOX_PLUGIN'			=> $this->settings['plugin'],
				'BBLIGHTBOX_BBCODE_ALLOW'	=> $this->settings['bbcode_allow'],
				'BBLIGHTBOX_CAPTIONS'		=> $this->settings['captions'],
				'BBLIGHTBOX_ANIMATION'		=> $this->settings['animationeffect'],
				'BBLIGHTBOX_SLIDE'			=> $this->settings['slide'],
				
				'FANCYBOX_PROTECT'			=> $this->settings['protect'],
	
				'CHOCOLAT_ENABLEZOOM'		=> $this->settings['enablezoom'],
				'QUOTED_IMAGES'				=> $this->settings['qimages'],
				'RESIZED_IMAGES'			=> $this->settings['resize'],
				'BBLIGHTBOX_COLUMN_LAYOUT'	=> $this->settings['collums']
			));
		}
	}
}
