<?php
/**
*
* BBOOTS Mini CMS extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
* @license SiteSplat 2015 all rights reserved
*
*/

namespace sitesplat\bbootsminicms\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string The database table the auto group rules are stored in */
	protected $bboots_style_menu_table;

	/** @var string The database table the auto group rules are stored in */
	protected $bboots_style_config_table;

	/** @var string The database table the auto group rules are stored in */
	protected $bboots_style_links_table;

	/** @var string The database table the auto group rules are stored in */
	protected $bboots_style_social_table;

	/**
	 * Constructor
	 *
	 * TODO: Add proper docblock
	 *
	 * @access	public
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user, $root_path, $bboots_style_menu_table, $bboots_style_config_table, $bboots_style_links_table, $bboots_style_social_table)
	{
		$this->db = $db;
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->bboots_style_menu_table = $bboots_style_menu_table;
		$this->bboots_style_config_table = $bboots_style_config_table;
		$this->bboots_style_links_table = $bboots_style_links_table;
		$this->bboots_style_social_table = $bboots_style_social_table;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header_after'	=> 'add_common_template_variables',
			'core.get_avatar_after'		=> 'set_avatar_effect',
		);
	}

	/**
	 * Adds customized template variables
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function add_common_template_variables($event)
	{
		if ($this->user->style['style_name'] == 'BBOOTS')
		{
			// obtain access to assigned template variables
			global $phpbb_container;
			$context = $phpbb_container->get('template_context');
			$rootref = &$context->get_root_ref();

			// Load buttons
			$sql = 'SELECT *
					FROM ' . $this->bboots_style_menu_table . '
					WHERE button_display = 1
						AND parent_id = 0
					ORDER BY left_id';
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				if (($row['button_only_registered'] && $this->user->data['user_id'] == ANONYMOUS) || ($row['button_only_guest'] && $this->user->data['user_id'] != ANONYMOUS))
				{
					continue;
				}

				if (preg_match("/\{(.*)\}/", $row['button_url']))
				{
					$brackets = array("{", "}");
					$var_name = strtoupper(str_replace($brackets, '', $row['button_url']));
					$row['button_url'] = $rootref[$var_name];
				}

				if (preg_match("/\{(.*)\}/", $row['button_name']))
				{
					$brackets = array("{L_", "}");
					$var_name = strtoupper(str_replace($brackets, '', $row['button_name']));
					$row['button_name'] = $this->user->lang[$var_name];
				}

				if (preg_match("/\{(.*)\}/", $row['button_desc']))
				{
					$brackets = array("{L_", "}");
					$var_name = strtoupper(str_replace($brackets, '', $row['button_desc']));
					$row['button_desc'] = $this->user->lang[$var_name];
				}

				$this->template->assign_block_vars('menu', array(
					'ID'          => $row['button_id'],
					'URL'         => $row['button_url'],
					'NAME'        => $row['button_name'],
					'DESC'        => $row['button_desc'],
					'EXTERNAL'    => $row['button_external'],
					'ICON'    		=> $row['icon'],
				));

				// Load sub-buttons
				$sub_sql = 'SELECT *
						FROM ' . $this->bboots_style_menu_table . '
						WHERE button_display = 1
							AND parent_id = ' . $row['button_id'] . '
						ORDER BY left_id';
				$sub_result = $this->db->sql_query($sub_sql);

				while ($sub_row = $this->db->sql_fetchrow($sub_result)) {
					if (($sub_row['button_only_registered'] && $this->user->data['user_id'] == ANONYMOUS) || ($sub_row['button_only_guest'] && $user->data['user_id'] != ANONYMOUS))
					{
						continue;
					}

					if (preg_match("/\{(.*)\}/", $sub_row['button_url']))
					{
						$brackets = array("{", "}");
						$var_name = strtoupper(str_replace($brackets, '', $sub_row['button_url']));
						$sub_row['button_url'] = $rootref[$var_name];
					}

					if (preg_match("/\{(.*)\}/", $sub_row['button_name']))
					{
						$brackets = array("{L_", "}");
						$var_name = strtoupper(str_replace($brackets, '', $sub_row['button_name']));
						$sub_row['button_name'] = $this->user->lang[$var_name];
					}

					$this->template->assign_block_vars('menu.sub', array(
						'ID'            => $sub_row['button_id'],
						'URL'           => $sub_row['button_url'],
						'NAME'          => $sub_row['button_name'],
						'EXTERNAL'  	=> $sub_row['button_external'],
						'ICON'    		=> $sub_row['icon'],
					));
				}
				$this->db->sql_freeresult($sub_result);
			}
			$this->db->sql_freeresult($result);

			// Load Config values
			$sql = 'SELECT *
					FROM ' . $this->bboots_style_config_table;
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				if ($row['config_name'] == 'about_us' || $row['config_name'] == 'google_analytics' || $row['config_name'] == 'adsense_header' || $row['config_name'] == 'adsense_footer' || $row['config_name'] == 'adsense_topic')
				{
					$row['config_value'] = htmlspecialchars_decode($row['config_value']);
				}

				$this->template->assign_vars(array(
					strtoupper($row['config_name'])	=> ($row['config_value'] != '') ? $row['config_value'] : false,
				));
			}
			$this->db->sql_freeresult($result);

			// Load Favorite Links
			$sql = 'SELECT *
					FROM ' . $this->bboots_style_links_table . '
					WHERE button_display = 1
					ORDER BY left_id';
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				if (($row['button_only_registered'] && $user->data['user_id'] == ANONYMOUS) || ($row['button_only_guest'] && $user->data['user_id'] != ANONYMOUS) )
				{
					continue;
				}

				if (preg_match("/\{(.*)\}/", $row['button_url']))
				{
					$brackets = array("{", "}");
					$var_name = strtoupper(str_replace($brackets, '', $row['button_url']));
					$row['button_url'] = $rootref[$var_name];
				}

				if (preg_match("/\{(.*)\}/", $row['button_name']))
				{
					$brackets = array("{L_", "}");
					$var_name = strtoupper(str_replace($brackets, '', $row['button_name']));
					$row['button_name'] = $this->user->lang[$var_name];
				}

				$this->template->assign_block_vars('links', array(
					'URL'           => $row['button_url'],
					'NAME'          => $row['button_name'],
					'EXTERNAL'      => $row['button_external'],
					'ICON'    		=> $row['icon'],
				));
			}
			$this->db->sql_freeresult($result);

			// Load Social networks
			$sql = 'SELECT *
					FROM ' . $this->bboots_style_social_table . '
					WHERE button_display = 1
					ORDER BY left_id';
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result)) {
				if (($row['button_only_registered'] && $user->data['user_id'] == ANONYMOUS) || ($row['button_only_guest'] && $user->data['user_id'] != ANONYMOUS))
				{
					continue;
				}

				if (preg_match("/\{(.*)\}/", $row['button_url']))
				{
					$brackets = array("{", "}");
					$var_name = strtoupper(str_replace($brackets, '', $row['button_url']));
					$row['button_url'] = $rootref[$var_name];
				}

				if (preg_match("/\{(.*)\}/", $row['button_name']))
				{
					$brackets = array("{L_", "}");
					$var_name = strtoupper(str_replace($brackets, '', $row['button_name']));
					$row['button_name'] = $this->user->lang[$var_name];
				}

				$row['color'] = substr($row['icon'], 6) . '-color';      

				$this->template->assign_block_vars('social', array(
					'URL'           => $row['button_url'],
					'NAME'          => $row['button_name'],
					'ICON'    			=> $row['icon'],
					'COLOR'    			=> $row['color'],
				));
			}
			$this->db->sql_freeresult($result);

			// Does logo image exist?
			$logo_exist = false;
			$logo_filename = '';
			$files = glob($this->root_path . 'ext/sitesplat/bbootsminicms/images/logo/*');

			if ($files && sizeof($files))
			{
				foreach($files as $file)
				{
					if(is_file($file))
					{
						$temp = explode(".", $file);
						if (end($temp) == 'png' || end($temp) == 'jpg' || end($temp) == 'jpeg' || end($temp) == 'gif')
						{
							$logo_exist = true;
							$logo_filename = basename($file);
						}
					}
				}
			}

			// Does background image exist?
			$bg_exist = false;
			$bg_filename = '';
			$files = glob($this->root_path . 'ext/sitesplat/bbootsminicms/images/bg/*');

			if ($files && sizeof($files))
			{
				foreach($files as $file)
				{
					if(is_file($file))
					{
						$temp = explode(".", $file);
						if (end($temp) == 'png' || end($temp) == 'jpg' || end($temp) == 'jpeg' || end($temp) == 'gif')
						{
							$bg_exist = true;
							$bg_filename = basename($file);
						}
					}
				}
			}

			// Uploaded images
			$this->template->assign_vars(array(
				'BBOOTS_MINI_CMS_ENABLED'	=> true,
				'LOGO_IMAGE_EXIST'	        	=> $logo_exist,
				'BACKGROUND_IMAGE_EXIST'		=> $bg_exist,
				'LOGO_FILENAME'	            	=> $logo_filename,
				'BACKGROUND_FILENAME'	    	=> $bg_filename,

				// custom CSS
				'S_ALLOW_CUSTOMCSS'				=> $this->config['bboots_enable_custom_css'],
				// custom links on off
				'S_ALLOW_CUSTOMLINKS'			=> $this->config['bboots_enable_custom_links'],
			));
		}
	}

	/**
	 * Adds class to set avatar effect
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function set_avatar_effect($event)
	{
		$html = $event['html'];
		$html = str_replace('class="', 'class="' . (( isset($this->config['bboots_avatar_effect']) && $this->config['bboots_avatar_effect'] != '' && $this->config['bboots_avatar_effect'] != 'none') ? $this->config['bboots_avatar_effect'] : '') . ' ', $html);
		$event['html'] = $html;
	}
}
