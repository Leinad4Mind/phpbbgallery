<?php
/*
* @package cBB Blockgets
* @version v2.0.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class attachments_block extends base
{
	private $preview_path 	= 'images/attach/';
	static $icon 			= 'fa-paperclip';

	public function init()
	{
		$this->tpl_name = 'attachments_block';

		if(($data = $this->unserialize()) === false || !$this->auth->acl_get('u_download'))
		{
			return false;
		}
		
		$extensions = array();
			
		$sql_ary = array(
			'SELECT'	=> 'a.*, t.forum_id',
			'FROM'		=> array(ATTACHMENTS_TABLE => 'a'),
			
			'LEFT_JOIN'	=> array(
				array('FROM' => array(TOPICS_TABLE => 't'),	'ON' => 't.topic_id = a.topic_id')
			),
			
			'WHERE'	=> 'a.is_orphan = 0
				AND a.filesize > 0'
		);

		if($data['filename'])
		{
			$sql_ary['WHERE'] .= " AND a.real_filename = '" . $this->db->sql_escape($data['filename']) . "'";
		}
		else
		{
			if(!empty($data['extension']))
			{
				// Get and trim extensions
				$sql_ary['WHERE'] .= ' AND ' . $this->db->sql_in_set('a.extension', array_map('trim', explode(',', $data['extension'])));
			}

			if(!empty($data['forums']))
			{
				$sql_ary['WHERE'] .= ' AND ' . $this->db->sql_in_set('t.forum_id', $data['forums']);
			}

			$sql_ary['ORDER_BY'] = 'RAND()';
		}

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('attach');

		/*
		* @event block.attachments_query
		* @var array	sql_ary		The SQL data
		* @var	array	data		Block Configuration
		* @since 2.0.0
		*/
		$vars = array('sql_ary', 'data');
		extract($this->dispatcher->trigger_event('block.attachments_query', compact($vars)));

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query_limit($sql, (int)$data['num']);
		while($row = $this->db->sql_fetchrow($result))
		{
			if($this->auth->acl_get('f_download', $row['forum_id']))
			{
				if(!extension_allowed($row['forum_id'], $row['extension'], $extensions))
				{
					continue;
				}

				$l_downloaded_viewed	= 'DOWNLOAD';
				$display_cat			= $extensions[$row['extension']]['display_cat'];
				$download_link			= $this->helper->url('download/file', array('id' => $row['attach_id']));

				switch($display_cat)
				{
					// Images
					case ATTACHMENT_CATEGORY_IMAGE:
					case ATTACHMENT_CATEGORY_THUMB:
						$download_link .= '&amp;mode=view';
					
					// no break

					// Windows Media Streams, Real Media Streams,  Macromedia Flash Files
					case ATTACHMENT_CATEGORY_WM:
					case ATTACHMENT_CATEGORY_RM:
					case ATTACHMENT_CATEGORY_QUICKTIME:
					case ATTACHMENT_CATEGORY_FLASH:
						$l_downloaded_viewed = 'VIEW';
					break;
				}

				$attach_img_preview = $this->preview_path . 'image_' . $row['extension'] . '.png';
				
				if(!file_exists($this->helper->get_ext_path() . $attach_img_preview))
				{
					$attach_img_preview = $this->preview_path . 'no_extension.png';
				}

				$attach_row = array(
					'S_DATE'			=> $this->helper->format_short_date($row['filetime']),
					'S_FILESIZE'		=> get_formatted_filesize($row['filesize']),
					'S_DOWNLOAD_LABEL'	=> $this->lang->lang("ATTACH_$l_downloaded_viewed"),
					'S_DOWNLOAD_COUNT'	=> $this->lang->lang('ATTACH_COUNT', $row['download_count']),
					'S_IMG'				=> '<img src="' . $this->helper->get_ext_path(true) . $attach_img_preview . '" width="60" alt="" />',
					'REAL_FILENAME'		=> truncate_string(str_replace(array('_', '-', '.' . $row['extension']), ' ', $row['real_filename']), 20, 255, '...'),
					'U_FILE'			=> $download_link,
					'U_FILELINK'		=> $this->helper->url('viewtopic', array('f' => $row['forum_id'], 'p' => $row['post_msg_id'], '#' => 'p' . $row['post_msg_id'])),
				);

				/*
				* @event block.attachments_row
				* @var array	attach_row		The output array
				* @var array	row				The original data
				* @var int		display_cat		The attachment category
				* @var	array	data			Block Configuration
				* @since 2.0.0
				*/
				$vars = array('attach_row', 'row', 'display_cat', 'data');
				extract($this->dispatcher->trigger_event('block.attachments_row', compact($vars)));
				
				$this->template->assign_block_vars('attach', $attach_row);
			}
		}
		$this->db->sql_freeresult($result);

		unset($data, $row);
		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		if($mode == 'validate' && $submit)
		{
			$new['forums'] = $this->request->variable('forums', array(0));
		}

		return true;
	}

	public function get_config()
	{
		$this->display_vars = array(
			'filename'		=> array('lang' => 'ATTACH_SPECIFIC',	'validate' => 'string',	'type' => 'text:50:255'),
			'forums'		=> array('lang' => 'ATTACH_FORUM',		'type' => 'custom',		'method' => 'helper',		'params' => array('forums_select', 'forums', '{CONFIG_VALUE}', 1),	'default' => array()),
			'num'			=> array('lang' => 'ATTACH_NUM',		'validate' => 'int',	'type' => 'number:0:999',	'default' => 1),
			'extension'		=> array('lang' => 'ATTACH_EXTENSION',	'validate' => 'string',	'type' => 'text:25:255'),
		);

		return true;
	}
}
