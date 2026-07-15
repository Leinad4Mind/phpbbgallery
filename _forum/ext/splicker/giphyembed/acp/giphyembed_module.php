<?php
/**
* @package Splicker Giphy Embed
* @copyright (c) 2021 SplickerSnap.com
* @author Splicker
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace splicker\giphyembed\acp;

class giphyembed_module
{
var $u_action;

	function main($id, $mode)
	{
		global $user, $template, $request;
		global $config, $phpbb_container;

		$this->tpl_name = 'acp_giphyembed_config';
		$this->page_title = 'Splicker Giphy Embed Settings';

		add_form_key('acp_giphyembed_config');
		$config_text = $phpbb_container->get('config_text');
		$submit = $request->is_set_post('submit');
		if ($submit)
		{
			if (!check_form_key('acp_giphyembed_config'))
			{
				trigger_error('FORM_INVALID');
			}
			$config->set('giphyembed_enable', $request->variable('giphyembed_enable', 0));
			$config->set('giphyembed_apikey', $request->variable('giphyembed_apikey', ''));
			$config->set('giphyembed_rating', $request->variable('giphyembed_rating', 'g'));
			$config->set('giphyembed_scroll', $request->variable('giphyembed_scroll', 0));
			
			trigger_error($user->lang('ACP_GE_SETTINGS_SAVED') . adm_back_link($this->u_action));
		}

		$template->assign_vars(array(
			'GE_ENABLED'		   => $config['giphyembed_enable'],
			'GE_APIKEY'		   => $config['giphyembed_apikey'],
			'GE_RATING'		   => $config['giphyembed_rating'],
			'GE_SCROLL'		   => $config['giphyembed_scroll'],
			'U_ACTION'				   => $this->u_action,
			
		));
	}
}