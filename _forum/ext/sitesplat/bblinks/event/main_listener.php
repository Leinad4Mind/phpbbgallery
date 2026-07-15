<?php
/**
*
* @package sitesplat BBlinks
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bblinks\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'								=> 'load_language_on_setup',
			'core.page_header_after'						=> 'enable_bblinks',
			'core.modify_text_for_display_before'			=> 'text_flag',
			'core.modify_text_for_display_after'			=> 'apply_bblinks',
			'core.modify_format_display_text_before'		=> 'text_flag',
			'core.modify_format_display_text_after'			=> 'apply_bblinks',
			'core.display_forums_modify_template_vars'		=> 'forum_apply_bblinks',
			'core.generate_profile_fields_template_data'	=> 'modify_custom_profile_field_data',
			'core.ucp_profile_modify_signature'				=> 'next_sig',
			'core.viewtopic_modify_post_data'				=> 'viewtopic_sig_prepare',
			'core.viewtopic_modify_post_row'				=> 'viewtopic_sig',
			'core.memberlist_view_profile'					=> 'viewprofile_sig',
		);
	}

	protected $bblinks;
	protected $config;
	protected $template;
	protected $dispatcher;
	protected $db;
	protected $is_rt = false;
	protected $next_is_signature = false;
	
	public function __construct(\sitesplat\bblinks\core\bblinks $bblinks, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\event\dispatcher $dispatcher, \phpbb\db\driver\driver_interface $db)
	{
		$this->bblinks = $bblinks;
		$this->config = $config;
		$this->template = $template;
		$this->dispatcher = $dispatcher;
		$this->db = $db;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/bblinks',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function enable_bblinks()
	{
		$this->template->assign_var('BBLINKS_ENABLED', $this->config['bblinks_enable']);
		$this->template->assign_var('BBLINKS_MODAL_ENABLED', $this->config['bblinks_enable_modal']);
	}

	public function text_flag($event)
	{
		if ($this->config['bblinks_enable'] && preg_match('#^<[rt][ >]#', $event['text']))
		{
			$this->is_rt = true;
		}
	}

	public function next_sig($event)
	{
		if ($this->config['bblinks_enable'] && !$this->config['bblinks_signature'])
		{
			$this->next_is_signature = true;
		}
	}

	public function apply_bblinks($event)
	{
		if ($this->config['bblinks_enable'] && $this->is_rt)
		{
			if (!$this->config['bblinks_signature'] && $this->next_is_signature)
			{
				$this->next_is_signature = false;
			}
			else
			{
				$event['text'] = $this->bblinks->local_url_to_text($event['text']);
				$event['text'] = $this->bblinks->modify_links($event['text']);

				$topic_title = $event['text'];

				/**
				 * This event enables you to edit topic title before it is
				 * displayed in viewtopic.
				 *
				 * @event sitesplat.bblinks.display
				 * @var	string	topic_title	Topic title
				 */
				$vars = array(
					'topic_title',
				);
				extract($this->dispatcher->trigger_event('sitesplat.bblinks.display', compact($vars)));

				$event['text'] = $topic_title;
				$this->is_rt = false;
			}
		}
	}

	public function forum_apply_bblinks($event)
	{
		if ($this->config['bblinks_enable'])
		{
			$u_viewforum = $event['forum_row']['U_VIEWFORUM'];
			if ($event['forum_row']['S_IS_LINK'] && !$this->bblinks->is_link_local($u_viewforum))
			{
				$event['forum_row'] = array_merge($event['forum_row'], array(
					'U_VIEWFORUM'	=> $u_viewforum . '" target="' . $this->config['bblinks_external_link_target'] . '" rel="' . $this->config['bblinks_external_link_rel'],
				));
			}
		}
	}

	public function modify_custom_profile_field_data($event)
	{
		$profile_data = $event['tpl_fields'];

		if (isset($profile_data) && isset($profile_data['blockrow']))
		{
			foreach ($profile_data['blockrow'] as $idx => $row)
			{
				if ($this->config['bblinks_urltotext_cpf'] && $row['PROFILE_FIELD_TYPE'] == 'profilefields.type.url')
				{
					$profile_data['blockrow'][$idx]['PROFILE_FIELD_VALUE'] = $this->bblinks->local_url_to_text($row['PROFILE_FIELD_VALUE']);
				}

				if ($this->config['bblinks_cpf_link_new_window'] && !empty($row['PROFILE_FIELD_CONTACT']))
				{
					$profile_data['blockrow'][$idx]['PROFILE_FIELD_CONTACT'] = $profile_data['blockrow'][$idx]['PROFILE_FIELD_CONTACT'] . '" target="_blank';
				}
			}
		}

		$event['tpl_fields'] = $profile_data;
	}

	public function viewtopic_sig_prepare($event)
	{
		if ($this->config['bblinks_enable'] && !$this->config['bblinks_signature'])
		{
			$user_cache = $event['user_cache'];
			foreach ($user_cache as &$user)
			{
				$user['sig_parsed'] = true;
			}
			$event['user_cache'] = $user_cache;
		}
	}

	public function viewtopic_sig($event)
	{
		if ($this->config['bblinks_enable'] && !$this->config['bblinks_signature'])
		{
			$signature = '';
			if ($event['user_poster_data']['sig'] && $event['row']['enable_sig'])
			{
				$this->is_rt = true;
				$this->next_is_signature = true;
				$signature = generate_text_for_display($event['user_poster_data']['sig'], $event['user_poster_data']['sig_bbcode_uid'], $event['user_poster_data']['sig_bbcode_bitfield'],  ($event['user_poster_data']['sig_bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES, true);
			}
			$post_row = $event['post_row'];
			$post_row['SIGNATURE'] = $signature;
			$event['post_row'] = $post_row;
		}
	}

	public function viewprofile_sig($event)
	{
		if ($this->config['bblinks_enable'] && !$this->config['bblinks_signature'])
		{
			$this->is_rt = true;
			$this->next_is_signature = true;

			$sql = 'SELECT user_sig, user_sig_bbcode_uid, user_sig_bbcode_bitfield
					FROM ' . USERS_TABLE . '
					WHERE user_id = ' . (int) $event['member']['user_id'];
			$result = $this->db->sql_query($sql);
			$sig = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			$member = $event['member'];
			$member['user_sig'] = generate_text_for_display($sig['user_sig'], $sig['user_sig_bbcode_uid'], $sig['user_sig_bbcode_bitfield'], ($sig['user_sig_bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES, true);
			$event['member'] = $member;
		}
	}
}
