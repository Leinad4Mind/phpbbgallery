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
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'load_language_on_setup',
			'core.page_header'						=> 'add_page_header_links',
			'core.viewonline_overwrite_location'	=> 'add_viewonline',
			'core.delete_user_after'				=> 'delete_user',
			'core.permissions'						=> 'add_permission_cat',
		);
	}

	/* @var string phpbb_root_path */
	protected $root_path;

	/* @var string phpEx */
	protected $php_ext;

	/* @var string table_prefix */
	protected $table_prefix;

	/* @var \phpbb\extension\manager */
	protected $phpbb_extension_manager;

	/* @var \phpbb\path_helper */
	protected $phpbb_path_helper;

	/* @var Container */
	protected $phpbb_container;

	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\config\config */
	protected $config;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\auth\auth */
	protected $auth;

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
	* @param \phpbb\extension\manager				$phpbb_extension_manager
	* @param \phpbb\path_helper						$phpbb_path_helper
	* @param Container								$phpbb_container
	* @param \phpbb\db\driver\driver_interfacer		$db
	* @param \phpbb\config\config					$config
	* @param \phpbb\controller\helper				$helper
	* @param \phpbb\auth\auth						$auth
	* @param \phpbb\template\template				$template
	* @param \phpbb\user							$user
	*/
	public function __construct($root_path, $php_ext, $table_prefix, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\path_helper $phpbb_path_helper, Container $phpbb_container, \phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\auth\auth $auth, \phpbb\template\template $template, \phpbb\user $user, \phpbb\language\language $language)
	{
		$this->root_path				= $root_path;
		$this->php_ext 					= $php_ext;
		$this->table_prefix 			= $table_prefix;
		$this->phpbb_extension_manager	= $phpbb_extension_manager;
		$this->phpbb_path_helper		= $phpbb_path_helper;
		$this->phpbb_container 			= $phpbb_container;
		$this->db 						= $db;
		$this->config 					= $config;
		$this->helper 					= $helper;
		$this->auth						= $auth;
		$this->template 				= $template;
		$this->user 					= $user;
		$this->language					= $language;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'oxpus/notes',
			'lang_set' => 'common',
		);

		if (defined('ADMIN_START'))
		{
			$lang_set_ext[] = array(
				'ext_name' => 'oxpus/notes',
				'lang_set' => 'permissions_notes',
			);
		}

		$event['lang_set_ext'] = $lang_set_ext;

	}

	public function add_page_header_links($event)
	{
		if ($this->user->data['is_registered'])
		{
			$ext_path					= $this->phpbb_extension_manager->get_extension_path('oxpus/notes', true);
			$this->phpbb_path_helper	= $this->phpbb_container->get('path_helper');
			$ext_path_web				= $this->phpbb_path_helper->update_web_root_path($ext_path);

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
			$sql = 'SELECT COUNT(note_id) AS total FROM ' . $this->table_prefix . 'notes
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
				$u_notes_path = (!$this->user->data['user_popup_notes']) ? $this->helper->route('oxpus_notes_controller', array('mem_drop' => 1, 'mem_time' => $cur_time)) : $u_notes_path;
				$u_notes_popup = ($this->user->data['user_popup_notes']) ? $this->helper->route('oxpus_notes_controller', array('mem_drop' => 1, 'mem_time' => $cur_time)) : '';

				$this->template->assign_var('S_NOTES_MEM', true);
				$this->template->assign_vars(array(
					'NOTES_MEM'		=> $this->language->lang('NOTES_MEMTEXT', '<a href="' . $u_notes_path . '">', '</a>'),
				));
			}

			$this->template->assign_vars(array(
				'U_NOTES_PATH'	=> $u_notes_path,
				'U_NOTES_POPUP'	=> ($this->user->data['user_popup_notes']) ? str_replace('&amp;', '&', $u_notes_popup) : $u_notes_popup,
			));
		}
	}

	public function add_viewonline($event)
	{
		if ($event['row']['session_page'] === 'app.php/notes' || $event['row']['session_page'] === 'app.' . $this->php_ext . '/notes.php')
		{
			$ext_link = $this->helper->route('oxpus_notes_controller');

			$event['location'] = $this->language->lang('NOTES');
			$event['location_url'] = $ext_link;
		}
	}

	public function delete_user($event)
	{
		$sql = 'DELETE FROM ' . $this->table_prefix . 'notes
			WHERE ' . $this->db->sql_in_set('note_user_id', $event['user_ids']);
		$this->db->sql_query($sql);
	}

	public function add_permission_cat($event)
	{
		$perm_cat = $event['categories'];
		$perm_cat['notes'] = 'ACP_NOTES';
		$event['categories'] = $perm_cat;

		$permission = $event['permissions'];
		$permission['a_notes'] = array('lang' => 'ACL_A_NOTES', 'cat' => 'notes');
		$event['permissions'] = $permission;
	}
}
