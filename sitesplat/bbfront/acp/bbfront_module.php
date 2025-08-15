<?php
/**
*
* @package BBfront
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbfront\acp;

class bbfront_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $config, $db, $request, $template, $user, $phpbb_container;

		$this->config = $config;
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->phpbb_container = $phpbb_container;
		$this->config_text = $phpbb_container->get('config_text');

		if ($this->request->variable('action', '') == 'details')
		{
			$this->user->add_lang_ext('sitesplat/bbfront', 'info_acp_bbfront');
			$this->phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/bbfront');
			$this->tpl_name = 'acp_ext_details';
		} else
		{
			if (check_link_hash($this->request->variable('hash', ''), 'close_notice'))
			{
				$this->close_notice();
			}
			
			$this->user->add_lang('acp/common');
			$this->tpl_name = 'acp_bbfront';
			$this->page_title = $user->lang('ACP_BBFRONT');
			$this->check_ext();
			add_form_key('bbfront');
	
			if ($this->request->is_set_post('submit'))
			{
				if (!check_form_key('bbfront'))
				{
					trigger_error('FORM_INVALID');
				}
	
				$this->config->set('bbfront_inc_forums', json_encode($this->request->variable('bbfront_inc_forums', array(0))));
				$this->config->set('bbfront_inc_groups', json_encode($this->request->variable('bbfront_inc_groups', array(0))));
				$this->config->set('bbfront_settings', json_encode($this->request->variable('bbfront_settings', array('' => ''))));
				$this->config->set('sitesplat_bbfront_grid_layout', $this->request->variable('bbfront_grid_layout', '4-l'));
				$this->config->set('sitesplat_bbfront_grid_fx_first', $this->request->variable('bbfront_grid_fx_first', 'Hapi'));
				$this->config->set('sitesplat_bbfront_grid_fx_load', $this->request->variable('bbfront_grid_fx_load', 'Hapi'));
				$this->config->set('sitesplat_bbfront_per_page_load', $this->request->variable('bbfront_per_page_load', 5));
				$this->config->set('sitesplat_bbfront_infinite_scroll', $this->request->variable('bbfront_infinite_scroll', false));
				$this->config->set('sitesplat_bbfront_ajax_new_posts', $this->request->variable('bbfront_ajax_new_posts', false));
				$this->config->set('sitesplat_bbfront_ad_frequency', $this->request->variable('bbfront_ad_frequency', 0));
				$this->config_text->set('sitesplat_bbfront_ad_content', $this->request->variable('bbfront_ad_content', '', true));
	
				trigger_error($this->user->lang('ACP_BBFRONT_SETTING_SAVED') . adm_back_link($this->u_action));
			}
	
			$forum_inc_aray = json_decode($this->config['bbfront_inc_forums'], true);
			$forum_options = '';
			
			$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE . ' WHERE forum_type = 1 ORDER BY forum_name';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result)) 
			{
				$forum_options .= '<option value="' . $row['forum_id'] . '"' . 
									((in_array($row['forum_id'], $forum_inc_aray)) ? ' selected="selected"' : '') . '>' . $row['forum_name'] . '</option>';
			}
	
			$group_inc_aray = json_decode($this->config['bbfront_inc_groups'], true);
			$group_options = '';
			$sql = 'SELECT group_id, group_type, group_name	FROM ' . GROUPS_TABLE . ' ORDER BY group_name ASC';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$group_name = ($row['group_type'] == GROUP_SPECIAL) ? $this->user->lang('G_' . $row['group_name']) : $row['group_name'];
				$group_options .= '<option value="' . $row['group_id'] . '"' . 
									((in_array($row['group_id'], $group_inc_aray)) ? ' selected="selected"' : '') . '>' . $group_name . '</option>';
			}
			
			$config_aray = json_decode($this->config['bbfront_settings'], true);
	
			$this->template->assign_vars(array(
				'INC_FORUMS'				=> $forum_options,
				'INC_GROUPS'				=> $group_options,
				'U_ACTION'					=> $this->u_action,
				'BBFRONT_NAME'				=> $config_aray['name'],
				'BBFRONT_CHARS'				=> $config_aray['chars'],
				'BBFRONT_PER_PAGE'			=> $config_aray['per_page'],
				'USE_AVATAR'				=> $config_aray['use_avatar'],
				'BBFRONT_GRID_LAYOUT'		=> $this->config['sitesplat_bbfront_grid_layout'],
				'BBFRONT_GRID_FX_FIRST'		=> $this->config['sitesplat_bbfront_grid_fx_first'],
				'BBFRONT_GRID_FX_LOAD'		=> $this->config['sitesplat_bbfront_grid_fx_load'],
				'BBFRONT_PER_PAGE_LOAD'		=> $this->config['sitesplat_bbfront_per_page_load'],
				'BBFRONT_INFINITE_SCROLL'	=> $this->config['sitesplat_bbfront_infinite_scroll'],
				'BBFRONT_AD_FREQUENCY'		=> $this->config['sitesplat_bbfront_ad_frequency'],
				'BBFRONT_AD_CONTENT'		=> $this->config_text->get('sitesplat_bbfront_ad_content'),
			));
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function check_ext()
	{
		$ext_manager = $this->phpbb_container->get('ext.manager');
		$cookie = $this->request->variable($this->config['cookie_name'] . '_bbfront', '', true, \phpbb\request\request_interface::COOKIE);
		$this->template->assign_vars(array(
			'S_NOTICE_BBTAGS'		=> (!$ext_manager->is_enabled('sitesplat/bbtags') && !$cookie) ? $this->user->lang['NOTICE_BBTAGS'] : '',
			'S_NOTICE_BBEMBED'		=> (!$ext_manager->is_enabled('phpbb/mediaembed') && !$cookie) ? $this->user->lang['BBNOTICE_EMBED'] : '',
			'S_NOTICE_LIKEBB'		=> (!$ext_manager->is_enabled('sitesplat/likedd') && !$cookie) ? $this->user->lang['NOTICE_LIKEBB'] : '',
			'U_BBFRONT_NOTICE_CLOSE'	=> "{$this->u_action}&amp;hash=" . generate_link_hash('close_notice')
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function close_notice()
	{
		$response = $this->set_close_notice_cookie();

		// Send a JSON response if an AJAX request was used
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'success' => $response,
			));
		}
		exit();
	}

	/**
	 * {@inheritdoc}
	 */
	protected function set_close_notice_cookie()
	{
		// Store the close_notice in a cookie with a 1 year expiration
		$this->user->set_cookie('bbfront', 'bbfront_notice_closed', time() + 31536000);

		return true;
	}}
