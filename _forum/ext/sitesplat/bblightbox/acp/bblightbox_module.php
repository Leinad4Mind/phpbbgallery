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
		global $user, $template, $cache, $request, $db;
		global $config, $phpbb_container;
		global $phpbb_root_path, $phpEx;


		$this->settings = json_decode(stripslashes($config['bblightbox']), true);
		$user->add_lang_ext('sitesplat/bblightbox', 'info_acp_bblightbox');
		$this->tpl_name = 'bblightbox';
		$this->page_title = $user->lang('ACP_BBLIGHTBOX_TITLE');
		add_form_key('sitesplat/bblightbox');

		$action = $request->variable('action', '');

		switch ($action)
		{
			case 'ria':

				if (confirm_box(true))
				{
					redirect($this->u_action . '&action=ria_process');
				}
				else
				{
					confirm_box(false, $user->lang('CONFIRM_OPERATION'), build_hidden_fields(array(
						'i'			=> $id,
						'mode'		=> $mode,
						'action'	=> 'ria',
					)));
				}

			break;

			case 'ria_process':

				$sql = 'SELECT COUNT(post_id) as post_count
						FROM ' . POSTS_TABLE . '
						WHERE post_text ' . $db->sql_like_expression($db->get_any_char() . '</ATTACHMENT>' . $db->get_any_char());
				$result = $db->sql_query($sql);
				$post_count = $db->sql_fetchfield('post_count');
				$db->sql_freeresult($result);

				$start = $request->variable('start', 0);
				$sql = 'SELECT post_id, post_text
						FROM ' . POSTS_TABLE . '
						WHERE post_text ' . $db->sql_like_expression($db->get_any_char() . '</ATTACHMENT>' . $db->get_any_char()) . '
						ORDER BY post_id ASC';
				$result = $db->sql_query_limit($sql, 50, $start);

				if ($db->sql_affectedrows())
				{
					while ($row = $db->sql_fetchrow($result))
					{
						$text = preg_replace('$<ATTACHMENT(.*)</ATTACHMENT>$U', '', $row['post_text']);
						$sql = 'UPDATE ' . POSTS_TABLE . '
								SET post_text = "' . $db->sql_escape($text) . '"
								WHERE post_id = ' . (int) $row['post_id'];
						$db->sql_query($sql);
					}
					$db->sql_freeresult($result);

					$next_start = $start + 50;
					$json_response = new \phpbb\json_response;
					$json_response->send(array(
						'NEXT_URL'		=> str_replace('&amp;', '&', $this->u_action) . '&action=ria_process&start=' . $next_start,
						'PROGRESS' 		=> $user->lang('BBLIGHTBOX_PROGRESS', $next_start, $post_count),
					));
				}
				else
				{
					trigger_error($user->lang('ACP_BBLIGHTBOX_INLINE_REMOVED') . adm_back_link($this->u_action));
				}

			break;

			case 'remove_thumbnails':

				if (confirm_box(true))
				{
					redirect($this->u_action . '&action=remove_thumbnails_process');
				}
				else
				{
					confirm_box(false, $user->lang('CONFIRM_OPERATION'), build_hidden_fields(array(
						'i'			=> $id,
						'mode'		=> $mode,
						'action'	=> 'remove_thumbnails',
					)));
				}

			break;

			case 'remove_thumbnails_process':

				$attachment_manager = $phpbb_container->get('attachment.manager');

				$sql = 'SELECT physical_filename
						FROM ' . ATTACHMENTS_TABLE . '
						WHERE thumbnail = 1';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$attachment_manager->unlink($row['physical_filename'], 'thumbnail');
				}
				$db->sql_freeresult($result);

				$sql = 'UPDATE ' . ATTACHMENTS_TABLE . '
						SET thumbnail = 0
						WHERE thumbnail = 1';
				$result = $db->sql_query($sql);

				trigger_error($user->lang('ACP_BBLIGHTBOX_THUMBNAILS_REMOVED') . adm_back_link($this->u_action));

			break;

			case 'rt':

				if (confirm_box(true))
				{
					redirect($this->u_action . '&action=rt_process');
				}
				else
				{
					confirm_box(false, $user->lang('CONFIRM_OPERATION'), build_hidden_fields(array(
						'i'			=> $id,
						'mode'		=> $mode,
						'action'	=> 'rt',
					)));
				}

			break;

			case 'rt_process':

				if (!function_exists('create_thumbnail'))
				{
					include $phpbb_root_path . 'includes/functions_posting.' . $phpEx;
				}

				$extensions = $processed = [];
				$upload_path = $phpbb_root_path . $config['upload_path'] . '/';

				$sql = 'SELECT extension
						FROM ' . EXTENSIONS_TABLE . '
						WHERE group_id = (SELECT group_id FROM ' . EXTENSION_GROUPS_TABLE . ' WHERE group_name = "IMAGES")';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$extensions[] = $row['extension'];
				}
				$db->sql_freeresult($result);

				$sql = 'SELECT COUNT(attach_id) AS total
						FROM ' . ATTACHMENTS_TABLE . '
						WHERE thumbnail = 0 AND filesize > ' . $config['img_min_thumb_filesize'] . ' AND ' . $db->sql_in_set('extension', $extensions);
				$result = $db->sql_query($sql);
				$total = (int) $db->sql_fetchfield('total');
				$db->sql_freeresult($result);

				$start = $request->variable('start', 0);
				$sql = 'SELECT attach_id, physical_filename, mimetype
						FROM ' . ATTACHMENTS_TABLE . '
						WHERE thumbnail = 0 AND filesize > ' . $config['img_min_thumb_filesize'] . ' AND ' . $db->sql_in_set('extension', $extensions);
				$result = $db->sql_query_limit($sql, 10, $start);
				if ($db->sql_affectedrows())
				{
					while ($row = $db->sql_fetchrow($result))
					{
						$source_file = $upload_path . $row['physical_filename'];
						$thumb_file_name = 'thumb_' . $row['physical_filename'];
						if (file_exists($source_file))
						{
							create_thumbnail($source_file, $upload_path . $thumb_file_name, $row['mimetype']);
							$processed[] = $row['attach_id'];
						}
					}
					$db->sql_freeresult($result);

					$db->sql_query('UPDATE ' . ATTACHMENTS_TABLE . ' SET thumbnail = 1 WHERE ' . $db->sql_in_set('attach_id', $processed));

					$next_start = $start + 10;
					$json_response = new \phpbb\json_response;
					$json_response->send(array(
						'NEXT_URL'		=> str_replace('&amp;', '&', $this->u_action) . '&action=rt_process&start=' . $next_start,
						'PROGRESS' 		=> $user->lang('BBLIGHTBOX_PROGRESS', $next_start, $total),
					));
				}
				else
				{
					trigger_error($user->lang('ACP_BBLIGHTBOX_THUMBS_REASSIGNED') . adm_back_link($this->u_action));
				}

			break;
		}

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('sitesplat/bblightbox'))
			{
				trigger_error('FORM_INVALID');
			}

			$bblightbox = $request->variable('bblightbox', array('' => ''));
//			$this->settings = $bblightbox;
			$config->set('bblightbox', json_encode($bblightbox));

			trigger_error($user->lang('ACP_BBLIGHTBOX_SETTING_SAVED') . adm_back_link($this->u_action));
		}


		if ($request->variable('action', '') == 'details')
		{
			$phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/bblightbox');
			$this->tpl_name = 'acp_ext_details';
		}
		else
		{
			foreach (array('------', 'baguetteBox', 'fancybox', 'Chocolat', 'jsOnlyLightbox', 'lightgallery') as $plugin)
			{
				$template->assign_block_vars('plugins', array(
					'NAME'		=> $plugin,
					'SELECTED'	=> (!empty($this->settings) && $plugin == $this->settings['plugin']) ? ' selected="selected"' : ''
				));
			}

			if (!empty($this->settings)) {
				$template->assign_vars(array(
					'BBLIGHTBOX_PLUGIN'			=> $this->settings['plugin'],
					'BBLIGHTBOX_BBCODE_ALLOW'	=> $this->settings['bbcode_allow'],
					'BBLIGHTBOX_CAPTIONS'		=> $this->settings['captions'],
					'BBLIGHTBOX_ANIMATION'		=> $this->settings['animationeffect'],
					'BBLIGHTBOX_SLIDE'			=> $this->settings['slide'],

					'FANCYBOX_PROTECT'			=> $this->settings['protect'],

					'CHOCOLAT_ENABLEZOOM'		=> $this->settings['enablezoom'],
					'QUOTED_IMAGES'				=> $this->settings['qimages'],
					'RESIZED_IMAGES'			=> $this->settings['resize'],
					'BBLIGHTBOX_COLUMN_LAYOUT'	=> $this->settings['collums'],
				));
			}
		}

		$template->assign_vars(array(
			'U_ACTION'						=> $this->u_action,
			'U_REMOVE_INLINE_ATTACHMENTS'	=> $this->u_action . '&action=ria',
			'U_REMOVE_THUMBNAILS'			=> $this->u_action . '&action=remove_thumbnails',
			'U_REASSIGN_THUMBNAILS'			=> $this->u_action . '&action=rt',
		));
	}
}
