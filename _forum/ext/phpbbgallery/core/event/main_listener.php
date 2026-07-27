<?php
/**
 *
 * @package phpBB Gallery
 * @copyright (c) 2014 nickvergessen
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */
namespace phpbbgallery\core\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents(): array
	{
		return [
			'core.permissions'                      => 'add_permissions',
			'core.user_setup'						=> 'load_language_on_setup',
			'core.page_header'						=> 'add_page_header_link',
			'core.memberlist_view_profile'	       => 'user_profile_galleries',
			'core.ucp_profile_info_modify_sql_ary' => 'preserve_personal_album_profile_field',
			//'core.generate_profile_fields_template_data_before'	       => 'profile_fields',
			//'core.viewonline_overwrite_location'	=> 'add_newspage_viewonline',
		];
	}
	/** @var \phpbb\controller\helper */
	protected \phpbb\controller\helper $helper;
	/** @var \phpbb\template\template */
	protected \phpbb\template\template $template;
	/** @var \phpbb\user */
	protected \phpbb\user $user;

	/** @var \phpbb\language\language  */
	protected \phpbb\language\language $language;

	/** @var \phpbbgallery\core\search  */
	protected \phpbbgallery\core\search $gallery_search;

	/** @var \phpbbgallery\core\config  */
	protected \phpbbgallery\core\config $gallery_config;
	/** @var \phpbb\db\driver\driver_interface  */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var string */
	protected string $users_table;

	/**
	 * Constructor
	 *
	 * @param \phpbb\controller\helper $helper Newspage helper object
	 * @param \phpbb\template\template $template Template object
	 * @param \phpbb\user $user User object
	 * @param \phpbb\language\language $lang
	 * @param \phpbbgallery\core\search $gallery_search
	 * @param \phpbbgallery\core\config $gallery_config
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param string $users_table
	 */
	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user,
								\phpbb\language\language $lang, \phpbbgallery\core\search $gallery_search,
								\phpbbgallery\core\config $gallery_config, \phpbb\db\driver\driver_interface $db,
								string $users_table)
	{
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->language = $lang;
		$this->gallery_search = $gallery_search;
		$this->gallery_config = $gallery_config;
		$this->db = $db;
		$this->users_table = $users_table;
	}
	/**
	 * Register the Gallery administrator permissions in phpBB's permission UI.
	 *
	 * The database auth options use their a_* identifiers. The acl_* prefix is
	 * reserved for module_auth expressions and must not be registered here.
	 *
	 * @param \phpbb\event\data $event phpBB permissions event
	 * @return void
	 */
	public function add_permissions(\phpbb\event\data $event): void
	{
		$event->update_subarray('permissions', 'a_gallery_manage', [
			'lang' => 'ACL_A_GALLERY_MANAGE',
			'cat'  => 'settings',
		]);
		$event->update_subarray('permissions', 'a_gallery_albums', [
			'lang' => 'ACL_A_GALLERY_ALBUMS',
			'cat'  => 'permissions',
		]);
	}

	public function load_language_on_setup(\phpbb\event\data $event): void
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name'	=> 'phpbbgallery/core',
			'lang_set'	=> ['info_acp_gallery', 'gallery', 'gallery_notifications'/*, 'permissions_gallery'*/],
		];
		$event['lang_set_ext'] = $lang_set_ext;
		if ($this->gallery_config->get('disp_total_images') == 1)
		{
			$this->template->assign_vars([
				'PHPBBGALLERY_INDEX_STATS'	=> $this->gallery_config->get('num_images'),
			]);
		}
	}
	public function add_page_header_link(\phpbb\event\data $event): void
	{
		if ($this->gallery_config->get('disp_gallery_icon') == 1)
		{
			$this->template->assign_vars([
				'U_GALLERY'	=> $this->helper->route('phpbbgallery_core_index'),
			]);
		}
	}

	/**
	 * Prevent UCP profile updates from changing the Gallery-managed album identifier.
	 *
	 * @param \phpbb\event\data $event phpBB profile update event
	 * @return void
	 */
	public function preserve_personal_album_profile_field(\phpbb\event\data $event): void
	{
		$cp_data = $event['cp_data'];
		if (!array_key_exists('pf_gallery_palbum', $cp_data))
		{
			return;
		}

		$sql = 'SELECT personal_album_id
			FROM ' . $this->users_table . '
			WHERE user_id = ' . (int) $this->user->data['user_id'];
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$cp_data['pf_gallery_palbum'] = $row && (int) $row['personal_album_id'] > 0
			? (int) $row['personal_album_id']
			: '';
		$event['cp_data'] = $cp_data;
	}
	public function user_profile_galleries(\phpbb\event\data $event): void
	{
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$this->language->add_lang('search');
		$random = $recent = false;
		$show_parts = $this->gallery_config->get('rrc_profile_mode');
		if ($show_parts >= 2)
		{
			$random = true;
			$show_parts = $show_parts - 2;
		}
		if ($show_parts == 1)
		{
			$recent = true;
		}
		if ($recent)
		{
			$block_name	= $this->language->lang('RECENT_IMAGES');
			$u_block = ' ';
			$this->gallery_search->recent($this->gallery_config->get('rrc_profile_items'), -1, $event['member']['user_id'], 'rrc_profile_display', $block_name, $u_block);
		}
		if ($random)
		{
			$block_name	= $this->language->lang('RANDOM_IMAGES');
			$u_block = ' ';
			$this->gallery_search->random($this->gallery_config->get('rrc_profile_items'), $event['member']['user_id'], 'rrc_profile_display', $block_name, $u_block);
		}

		// Now - do we show statistics
		if ($this->gallery_config->get('profile_user_images') == 1)
		{
			$sql = 'SELECT * FROM ' . $this->users_table . ' WHERE user_id = ' . (int) $event['member']['user_id'];
			$result = $this->db->sql_query($sql);
			$user_info = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			if ($user_info)
			{
				$this->template->assign_vars([
					'U_GALLERY_IMAGES_ALLOW'	=> true,
					'U_GALLERY_IMAGES'	=> $user_info['user_images'],
				]);
			}
			else
			{
				$this->template->assign_vars([
					'U_GALLERY_IMAGES_ALLOW'	=> true,
					'U_GALLERY_IMAGES'	=> 0,
				]);
			}
		}
	}
}
