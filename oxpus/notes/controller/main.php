<?php

/**
*
* @package phpBB Extension - Personal notes
* @copyright (c) 2014 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace oxpus\notes\controller;

use Symfony\Component\DependencyInjection\Container;

class main
{
	/* @var string phpBB root path */
	protected $root_path;

	/* @var string phpEx */
	protected $php_ext;

	/* @var string table_prefix */
	protected $table_prefix;

	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\config\config */
	protected $config;

	/* @var \phpbb\log\log_interface */
	protected $log;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\auth\auth */
	protected $auth;

	/* @var \phpbb\request\request_interface */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language $language Language object */
	protected $language;

	/**
	* Constructor
	*
	* @param string									$root_path
	* @param string									$php_ext
	* @param string									$table_prefix
	* @param \phpbb\db\driver\driver_interfacer		$db
	* @param \phpbb\config\config					$config
	* @param \phpbb\log\log_interface 				$log
	* @param \phpbb\controller\helper				$helper
	* @param \phpbb\auth\auth						$auth
	* @param \phpbb\request\request_interface 		$request
	* @param \phpbb\template\template				$template
	* @param \phpbb\user							$user
	*/
	public function __construct($root_path, $php_ext, $table_prefix, \phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, \phpbb\log\log_interface $log, \phpbb\controller\helper $helper, \phpbb\auth\auth $auth, \phpbb\request\request_interface $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\language\language $language)
	{
		$this->root_path				= $root_path;
		$this->php_ext 					= $php_ext;
		$this->table_prefix 			= $table_prefix;
		$this->db 						= $db;
		$this->config 					= $config;
		$this->phpbb_log 				= $log;
		$this->helper 					= $helper;
		$this->auth						= $auth;
		$this->request					= $request;
		$this->template 				= $template;
		$this->user 					= $user;
		$this->language					= $language;
	}

	public function handle($view = '')
	{
		/*
		* Prevent unauthorised access
		*/
		if (!$this->auth->acl_get('u_notes'))
		{
			throw new \phpbb\exception\http_exception(404, 'PAGE_NOT_FOUND');
		}

		include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);
		include_once($this->root_path . 'includes/functions_display.' . $this->php_ext);
		include_once($this->root_path . 'includes/bbcode.' . $this->php_ext);

		$this->template->assign_block_vars('navlinks', [
			'U_VIEW_FORUM'	=> $this->helper->route('oxpus_notes_controller'),
			'FORUM_NAME'	=> $this->language->lang('NOTES'),
		]);

		/*
		* Get the variable contents
		*/
		$submit				= $this->request->variable('submit', '');
		$cancel				= $this->request->variable('cancel', '');
		$sql_order			= $this->request->variable('sort_order', 'ASC');
		$sql_order_by		= $this->request->variable('sort_by', 'note_time');
		$search_keywords	= $this->request->variable('search_string', '', true);
		$sql_search_in		= $this->request->variable('search_in', '');
		$mode				= $this->request->variable('mode', '');
		$note_id			= $this->request->variable('note_id', 0);
		$note_subject		= $this->request->variable('subject', '', true);
		$note_message		= $this->request->variable('message', '', true);
		$note_mem_day		= $this->request->variable('mem_day', 0);
		$note_mem_month		= $this->request->variable('mem_month', 0);
		$note_mem_year		= $this->request->variable('mem_year', 0);
		$note_mem_hour		= $this->request->variable('mem_hour', 0);
		$note_mem_minute	= $this->request->variable('mem_minute', 0);
		$note_mem_yesno		= $this->request->variable('mem_yesno', 0);
		$note_mem_drop		= $this->request->variable('mem_drop', 0);
		$note_mem_time		= $this->request->variable('mem_time', 0);

		if ($cancel)
		{
			$mode = '';
		}

		$notes_data = [];
		$display_notes = 0;

		/*
		* Output page header
		*/
		if ( $this->user->data['user_popup_notes'] == true )
		{
			$this->template->assign_var('S_NOTES_POPUP', true);
		}

		if ($mode == 'delete')
		{
			if (confirm_box(true))
			{
				$sql = 'DELETE FROM ' . $this->table_prefix . 'notes
						WHERE ' . $this->db->sql_build_array('SELECT', [
							'note_id' => $note_id,
							'note_user_id' => $this->user->data['user_id'],
						]);
				$this->db->sql_query($sql);
			}
			else 
			{
				confirm_box(false, $this->language->lang('NOTES_DELETE_CONFIRM'), '', 'note_confirm_body.html');
			}

			$mode = '';
		}

		/*
		* Check the number of notes for this user
		*/
		$sql = 'SELECT count(note_id) AS total FROM ' . $this->table_prefix . 'notes
			WHERE note_user_id = ' . (int)$this->user->data['user_id'];
		$result = $this->db->sql_query($sql);
		$total_notes = intval($this->db->sql_fetchfield('total'));
		$this->db->sql_freeresult($result);

		if ($total_notes < $this->config['notes'])
		{
			$this->template->assign_var('S_NEW_NOTE', true);
			$allow_new_note = true;
		}
		else
		{
			$allow_new_note = false;
		}

		/*
		* Load needed template
		*/
		if ($mode == 'new_note' || $mode == 'edit_note')
		{
			$body = 'note_edit_body.html';
		}
		else
		{
			$body = 'note_list_body.html';

			/*
			* Prepare sort, search and filter
			*/
			$sort_order = '<select name="sort_order" class="selectpicker" data-width="auto">';
			$sort_order .= '<option value="ASC">'.$this->language->lang('ASCENDING').'</option>';
			$sort_order .= '<option value="DESC">'.$this->language->lang('DESCENDING').'</option>';
			$sort_order .= '</select>';
			$sort_order = str_replace('value="'.$sql_order.'">', 'value="'.$sql_order.'" selected="selected">', $sort_order);

			$sort_by = '<select name="sort_by" class="selectpicker" data-width="auto">';
			$sort_by .= '<option value="note_subject">'.$this->language->lang('SUBJECT').'</option>';
			$sort_by .= '<option value="note_time">'.$this->language->lang('TIME').'</option>';
			$sort_by .= '<option value="note_mem">'.$this->language->lang('NOTES_MEM').'</option>';
			$sort_by .= '</select>';
			$sort_by = str_replace('value="'.$sql_order_by.'">', 'value="'.$sql_order_by.'" selected="selected">', $sort_by);

			$search_in = '<select name="search_in" class="selectpicker" data-width="auto" data-style="btn btn-default form-control">';
			$search_in .= '<option value="note_subject">'.$this->language->lang('SUBJECT').'</option>';
			$search_in .= '<option value="note_text">'.$this->language->lang('POST').'</option>';
			$search_in .= '</select>';

			$search_in = str_replace('value="'.$sql_search_in.'">', 'value="'.$sql_search_in.'" selected="selected">', $search_in);

			$sql_search = '';

			/*
			* Prepare search terms
			*/
			if ( $search_keywords != '' )
			{
				$split_search = [];
				$sql_search_terms = [];
				$split_search = explode(' ', $search_keywords);

				$any_char = $this->db->get_any_char();

				foreach($split_search as $search_word)
				{
					$sql_search_terms[] = ' LOWER(' . $sql_search_in . ') ' . $this->db->sql_like_expression($any_char . strtolower($search_word) . $any_char);
				}

				$sql_search = ' AND (' . implode(' OR ', $sql_search_terms) . ')';
			}
			else
			{
				$sql_search = '';
			}

			$sql_search .= ($sql_order_by == 'note_mem') ? ' AND (note_mem <> 0) ' : '';
			$sql_search .= ($note_mem_time) ? " AND (note_mem <= $note_mem_time AND note_mem <> 0 AND note_memx = 1) " : '';

			/*
			* Go ahead and pull all data for the notes
			*/
			$sql = 'SELECT * FROM ' . $this->table_prefix . 'notes
				WHERE note_user_id = ' . (int) $this->user->data['user_id'] . $sql_search . '
				ORDER BY ' . $this->db->sql_escape($sql_order_by) . ' ' . $this->db->sql_escape($sql_order);
			$sql = str_replace('#', "'", $sql);
			$result = $this->db->sql_query($sql);

			$display_notes = $this->db->sql_affectedrows($result);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$notes_data[] = $row;
			}

			$this->db->sql_freeresult($result);
		}

		if ($mode == 'save' && $allow_new_note)
		{
			// check form
			if (!check_form_key('posting'))
			{
				trigger_error($this->language->lang('FORM_INVALID'), E_USER_WARNING);
			}

			// prepare note before save
			$allow_bbcode	= ($this->config['allow_bbcode']) ? true : false;
			$allow_urls		= true;
			$allow_smilies	= ($this->config['allow_smilies']) ? true : false;
			$uid = $bitfield = '';
			$flags = 0;

			generate_text_for_storage($note_message, $uid, $bitfield, $flags, $allow_bbcode, $allow_urls, $allow_smilies);

			if ($note_mem_yesno)
			{
				$note_mem = gmmktime($note_mem_hour, $note_mem_minute, 0, $note_mem_month, $note_mem_day, $note_mem_year);
				$user_time_offset = $this->user->create_datetime()->getOffset();
				$note_mem = $note_mem - $user_time_offset;
			}
			else
			{
				$note_mem = 0;
			}

			// Save new/edited note
			if ($note_id)
			{
				$sql = 'UPDATE ' . $this->table_prefix . 'notes SET ' . $this->db->sql_build_array('UPDATE', [
					'note_subject' => $note_subject,
					'note_text' => utf8_encode_ucr($note_message),
					'note_uid' => $uid,
					'note_bitfield' => $bitfield,
					'note_flags' => $flags,
					'note_mem' => $note_mem,
					'note_memx' => (($note_mem) ? 1 : 0)]) .
					' WHERE note_id = ' . (int) $note_id;
			}
			else
			{
				$sql = 'SELECT MAX(note_id) AS max_id FROM ' . $this->table_prefix . 'notes';
				$result = $this->db->sql_query($sql);
				$note_id = $this->db->sql_fetchfield('max_id') + 1;
				$this->db->sql_freeresult($result);

				$sql = 'INSERT INTO ' . $this->table_prefix . 'notes ' . $this->db->sql_build_array('INSERT', [
					'note_id' => $note_id,
					'note_user_id' => $this->user->data['user_id'],
					'note_subject' => utf8_encode_ucr($note_subject),
					'note_text' => $note_message,
					'note_time' => time(),
					'note_uid' => $uid,
					'note_bitfield' => $bitfield,
					'note_flags' => (int) $flags,
					'note_mem' => $note_mem,
					'note_memx' => (($note_mem) ? 1 : 0)
				]);
			}

			$this->db->sql_query($sql);

			redirect($this->helper->route('oxpus_notes_controller'));
		}

		if (($mode == 'new_note' && $allow_new_note) || $mode == 'edit_note')
		{
			$tpl_filename = '@oxpus_notes/note_edit_body.html';

			// First secure the form ...
			add_form_key('posting');

			// Status for HTML, BBCode, Smilies, Images and Flash,
			$bbcode_status	= ($this->config['allow_bbcode']) ? true : false;
			$smilies_status	= ($bbcode_status && $this->config['allow_smilies']) ? true : false;
			$img_status		= false;
			$url_status		= ($this->config['allow_post_links']) ? true : false;
			$flash_status	= false;
			$quote_status	= true;

			// Smilies Block,
			if ($smilies_status)
			{
				if (!function_exists('generate_smilies'))
				{
					include_once($this->root_path . 'includes/functions_posting.' . $this->php_ext);
				}
				generate_smilies('inline', 0);
			}

			// BBCode-Block,
			$this->language->add_lang('posting');
			display_custom_bbcodes();

			// Hidden Fields,
			$s_hidden_fields = ['mode' => 'save'];

			$s_note_mem_day = '<select name="mem_day" class="selectpicker" data-width="auto">';
			for ($i = 1; $i <= 31; $i++)
			{
				$s_note_mem_day .= '<option value="' . $i . '">' . $i . '</option>';
			}
			$s_note_mem_day .= '</select>';

			$s_note_mem_month = '<select name="mem_month" class="selectpicker" data-width="auto">';
			for ($i = 1; $i < 13; $i++)
			{
				$s_note_mem_month .= '<option value="' . $i . '">' . $i . '</option>';
			}
			$s_note_mem_month .= '</select>';

			$s_note_mem_year = '<select name="mem_year" class="selectpicker" data-width="auto">';
			$current_year = intval($this->user->format_date(time(), 'Y'));
			for ($i = $current_year; $i <= $current_year + 9; $i++)
			{
				$s_note_mem_year .= '<option value="' . $i . '">' . $i . '</option>';
			}
			$s_note_mem_year .= '</select>';

			$s_note_mem_hour = '<select name="mem_hour" class="selectpicker" data-width="auto">';
			for ($i = 0; $i <= 23; $i++)
			{
				$s_note_mem_hour .= '<option value="' . $i . '">' . $i . '</option>';
			}
			$s_note_mem_hour .= '</select>';

			$s_note_mem_minute = '<select name="mem_minute" class="selectpicker" data-width="auto">';
			for ($i = 0; $i <= 59; $i++)
			{
				if ($i < 10)
				{
					$s_note_mem_minute .= '<option value="0' . $i . '">' . $i . '</option>';
				}
				else
				{
					$s_note_mem_minute .= '<option value="' . $i . '">' . $i . '</option>';
				}
			}
			$s_note_mem_minute .= '</select>';

			if ($mode == 'edit_note')
			{
				$s_hidden_fields = array_merge($s_hidden_fields, ['note_id' => $note_id]);

				// At least get the post content for note to edit, if wanted...
				$sql = 'SELECT * FROM ' . $this->table_prefix . 'notes
					WHERE note_id = ' . (int) $note_id;
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				$subject	= $row['note_subject'];
				$message	= $row['note_text'];
				$uid		= $row['note_uid'];
				$flags		= $row['note_flags'];

				if ($row['note_mem'])
				{
					$cur_time = $row['note_mem'];
				}
				else
				{
					$cur_time = time();
				}

				$s_check = ($row['note_mem']) ? 'checked="checked"' : '';

				$text_ary = generate_text_for_edit($message, $uid, $flags);
				$message = $text_ary['text'];
			}
			else
			{
				$subject = '';
				$message = '';

				$cur_time = time();

				$s_check = '';
			}

			$sort_order = '';
			$sort_by = '';
			$search_in = '';

			$date_j = $this->user->format_date($cur_time, 'j', true);
			$date_n = $this->user->format_date($cur_time, 'n', true);
			$date_Y = $this->user->format_date($cur_time, 'Y', true);
			$date_g = $this->user->format_date($cur_time, 'G', true);
			$date_i = $this->user->format_date($cur_time, 'i', true);

			$s_note_mem_day		= str_replace('value="' . $date_j . '">', 'value="' . $date_j . '" selected="selected">', $s_note_mem_day);
			$s_note_mem_month	= str_replace('value="' . $date_n . '">', 'value="' . $date_n . '" selected="selected">', $s_note_mem_month);
			$s_note_mem_year	= str_replace('value="' . $date_Y . '">', 'value="' . $date_Y . '" selected="selected">', $s_note_mem_year);
			$s_note_mem_hour	= str_replace('value="' . $date_g . '">', 'value="' . $date_g . '" selected="selected">', $s_note_mem_hour);
			$s_note_mem_minute	= str_replace('value="' . $date_i . '">', 'value="' . $date_i . '" selected="selected">', $s_note_mem_minute);

			// ... and now prepare the posting form for edit/post the note
			$this->template->assign_vars([
				'NOTE_MODE'			=> ($mode == 'new_note') ? $this->language->lang('NEW_POST') : $this->language->lang('EDIT_POST'),

				'NOTES_SUBJECT'		=> $subject,
				'NOTES_MESSAGE'		=> $message,

				'MEM_CHECKED'		=> $s_check,

				'S_NOTE_MEM_HOUR'	=> $s_note_mem_hour,
				'S_NOTE_MEM_MIN'	=> $s_note_mem_minute,
				'S_NOTE_MEM_DAY'	=> $s_note_mem_day,
				'S_NOTE_MEM_MONTH'	=> $s_note_mem_month,
				'S_NOTE_MEM_YEAR'	=> $s_note_mem_year,

				'S_BBCODE_ALLOWED'	=> $bbcode_status,
				'S_BBCODE_IMG'		=> $img_status,
				'S_BBCODE_URL'		=> $url_status,
				'S_BBCODE_FLASH'	=> $flash_status,
				'S_BBCODE_QUOTE'	=> $quote_status,
				'S_LINKS_ALLOWED'	=> $url_status,

				'S_FORM_ACTION'		=> $this->helper->route('oxpus_notes_controller'),
				'S_HIDDEN_FIELDS'	=> build_hidden_fields($s_hidden_fields),

				'U_MORE_SMILIES'	=> append_sid($this->root_path . 'posting.' . $this->php_ext, 'mode=smilies'),
			]);
		}

		$this->language->add_lang('search');

		if ($this->user->data['user_slide_notes'])
		{
			$notes_slide = true;
		}
		else
		{
			$notes_slide = false;
		}

		/*
		* Send vars to template
		*/
		$this->template->assign_vars([
			'L_SEARCH'			=> ($search_keywords == '') ? $this->language->lang('SEARCH') : $this->language->lang('SEARCH') . '*',
			'L_FILTER'			=> ($search_keywords != '' || $sql_order_by == 'note_mem') ? $this->language->lang('FILTER_NOTES') : '',
			'L_NO_NOTES'		=> ($total_notes) ? $this->language->lang('NO_SEARCH_RESULTS') : $this->language->lang('NO_NOTES'),

			'L_CLOSE'			=> $this->language->lang('CLOSE_WINDOW'),

			'NOTES_TOTAL'		=> $total_notes . ' / ' . $this->config['notes'],
			'SLIDE_MODE'		=> $notes_slide,

			'SORT_ORDER'		=> $sort_order,
			'SORT_BY'			=> $sort_by,
			'SEARCH_IN'			=> $search_in,

			'S_FORM_ACTION'		=> $this->helper->route('oxpus_notes_controller'),

			'U_NEW_NOTE'		=> $this->helper->route('oxpus_notes_controller', ['mode' => 'new_note']),
				
			'S_SHOW_BUTTON'		=> ($total_notes) ? true : false,
		]);

		/*
		* And now put the notes out ... Yeah let the notes out ... bump bump bump ...
		*/
		if ($mode == '' || !$allow_new_note)
		{
			$tpl_filename = '@oxpus_notes/note_list_body.html';

			if ($display_notes)
			{
				for($i = 0; $i < $display_notes; $i++)
				{
					$note_date	= $this->user->format_date($notes_data[$i]['note_time']);
					$note_id	= $notes_data[$i]['note_id'];
					$subject	= $notes_data[$i]['note_subject'];
					$message	= $notes_data[$i]['note_text'];

					$uid		= $notes_data[$i]['note_uid'];
					$bitfield	= $notes_data[$i]['note_bitfield'];
					$flags		= $notes_data[$i]['note_flags'];

					$message	= censor_text($message);
					$subject	= censor_text($subject);

					$message	= generate_text_for_display($message, $uid, $bitfield, $flags);

					if ($search_keywords != '')
					{
						foreach($split_search as $search_word)
						{
							$message = preg_replace('#(?!<.*)(' . utf8_normalize_nfc($search_word) . ')(?![^<>]*>)#is', '<span class="posthilit">\1</span>', $message);
						}
					}

					$u_edit		= $this->helper->route('oxpus_notes_controller', ['mode' => 'edit_note', 'note_id' => $note_id]);
					$u_del		= $this->helper->route('oxpus_notes_controller', ['mode' => 'delete', 'note_id' => $note_id]);

					if ($notes_data[$i]['note_mem'])
					{
						$notes_mem = $this->user->format_date($notes_data[$i]['note_mem'], false, true);
					}
					else
					{
						$notes_mem = '';
					}

					$this->template->assign_block_vars('notes_row', [
						'NOTE_ID'		=> $note_id,
						'NOTE_DATE' 	=> $note_date,
						'NOTE_SUBJECT'	=> $subject,
						'NOTE_TEXT' 	=> $message,
						'NOTES_MEM'		=> $notes_mem,
						'U_DELETE_NOTE'	=> $u_del,
						'U_EDIT_NOTE'	=> $u_edit,
					]);
				}
				$this->template->assign_var('S_SHOW_BUTTON', false);
			}
			else
			{
				$this->template->assign_var('S_NO_NOTES', true);
			}

			if ($note_mem_drop)
			{
				$sql = 'UPDATE ' . $this->table_prefix . 'notes SET ' . $this->db->sql_build_array('UPDATE', [
					'note_memx' => 0
				]) . ' WHERE note_mem <= ' . (int) $note_mem_time . ' AND note_user_id = ' . (int) $this->user->data['user_id'];
				$this->db->sql_query($sql);
			}
		}

		return $this->helper->render($tpl_filename, $this->language->lang('NOTES'));
	}
}
