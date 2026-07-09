<?php

/**
*
* @package phpBB Extension - ARBEITSTITEL
* @copyright (c) 2014 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace oxpus\notes\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup'						=> 'load_language_on_setup',
			'core.page_header'						=> 'add_page_header_links',
			'core.viewonline_overwrite_location'	=> 'add_viewonline',
			'core.delete_user_after'				=> 'delete_user',
			'core.permissions'						=> 'add_permission_cat',
		];
	}

	protected $db;
	protected $helper;
	protected $template;
	protected $user;
	protected $language;
	protected $notes_table;

	/**
	* Constructor
	*
	* @param \phpbb\db\driver\driver_interfacer		$db
	* @param \phpbb\controller\helper				$helper
	* @param \phpbb\template\template				$template
	* @param \phpbb\user							$user
	* @param \phpbb\language\language				$language
	* @param string									$notes_table
	*/
	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\controller\helper $helper,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\language\language $language,
		$notes_table
	)
	{
		$this->db 						= $db;
		$this->helper 					= $helper;
		$this->template 				= $template;
		$this->user 					= $user;
		$this->language					= $language;

		$this->notes_table 				= $notes_table;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'oxpus/notes',
			'lang_set' => 'common',
		];

		$event['lang_set_ext'] = $lang_set_ext;

	}

	public function add_page_header_links()
	{
		if ($this->user->data['is_registered'])
		{
			$ext_main_link = $this->helper->route('oxpus_notes_controller');

			if ($this->user->data['user_popup_notes'])
			{
				$u_notes_path	= "javascript:notes()";
				$u_notes_popup	= $ext_main_link;
			}
			else
			{
				$u_notes_path	= $ext_main_link;
				$u_notes_popup	= '';
			}

			$cur_time = time();

			$this->db->return_on_error = true;
			$sql = 'SELECT COUNT(note_id) AS total FROM ' . $this->notes_table . '
				WHERE note_user_id = ' . (int) $this->user->data['user_id'] . '
					AND note_mem <= ' . (int) $cur_time . '
					AND note_mem <> 0
					AND note_memx = 1';
			$result = $this->db->sql_query($sql);
			$total_note_mems = $this->db->sql_fetchfield('total');
			$this->db->sql_freeresult($result);
			$this->db->return_on_error = false;

			if ($total_note_mems)
			{
				$u_notes_path = (!$this->user->data['user_popup_notes']) ? $this->helper->route('oxpus_notes_controller', ['mem_drop' => 1, 'mem_time' => $cur_time]) : $u_notes_path;
				$u_notes_popup = ($this->user->data['user_popup_notes']) ? $this->helper->route('oxpus_notes_controller', ['mem_drop' => 1, 'mem_time' => $cur_time]) : '';

				$this->template->assign_var('S_NOTES_MEM', true);
				$this->template->assign_vars([
					'NOTES_MEM'		=> $this->language->lang('NOTES_MEMTEXT', '<a href="' . $u_notes_path . '">', '</a>'),
				]);
			}

			$this->template->assign_vars([
				'U_NOTES_PATH'	=> $u_notes_path,
				'U_NOTES_POPUP'	=> ($this->user->data['user_popup_notes']) ? str_replace('&amp;', '&', $u_notes_popup) : $u_notes_popup,
			]);
		}
	}

	public function add_viewonline($event)
	{
		if (strpos($event['row']['session_page'], 'notes') !== false)
		{
			$ext_link = $this->helper->route('oxpus_notes_controller');

			$event['location'] = $this->language->lang('NOTES');
			$event['location_url'] = $ext_link;
		}
	}

	public function delete_user($event)
	{
		$sql = 'DELETE FROM ' . $this->notes_table . '
			WHERE ' . $this->db->sql_in_set('note_user_id', $event['user_ids']);
		$this->db->sql_query($sql);
	}

	public function add_permission_cat($event)
	{
		$perm_cat = $event['categories'];
		$perm_cat['notes'] = 'ACP_NOTES';
		$event['categories'] = $perm_cat;

		$permission = $event['permissions'];
		$permission['a_notes'] = ['lang' => 'ACL_A_NOTES', 'cat' => 'notes'];
		$event['permissions'] = $permission;
	}
}
