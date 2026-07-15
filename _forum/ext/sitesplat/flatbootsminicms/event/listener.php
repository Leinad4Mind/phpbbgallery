<?php
/**
*
* FLATBOOTS Mini CMS extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
* @license SiteSplat 2015 all rights reserved
*
*/

namespace sitesplat\flatbootsminicms\event;

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

	/** @var string phpBB php ext */
	protected $php_ext;

	/** @var string The database table the auto group rules are stored in */
	protected $flatboots_style_menu_table;

	/** @var string The database table the auto group rules are stored in */
	protected $flatboots_style_config_table;

	/** @var string The database table the auto group rules are stored in */
	protected $flatboots_style_links_table;

	/** @var string The database table the auto group rules are stored in */
	protected $flatboots_style_social_table;

	/**
	 * Constructor
	 *
	 * TODO: Add proper docblock
	 *
	 * @access	public
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user, $root_path, $php_ext, $flatboots_style_menu_table, $flatboots_style_config_table, $flatboots_style_links_table, $flatboots_style_social_table)
	{
		$this->db = $db;
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->flatboots_style_menu_table = $flatboots_style_menu_table;
		$this->flatboots_style_config_table = $flatboots_style_config_table;
		$this->flatboots_style_links_table = $flatboots_style_links_table;
		$this->flatboots_style_social_table = $flatboots_style_social_table;
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
		$enable_popup_login = false;

		if ($this->user->style['style_name'] == 'FLATBOOTS')
		{
			// obtain access to assigned template variables
			global $phpbb_container;
			$context = $phpbb_container->get('template_context');
			$rootref = &$context->get_root_ref();

			// Load buttons
			$sql_ary = array(
				'SELECT'	=> 'fsm.*',
				'FROM'		=> array(
					$this->flatboots_style_menu_table	=> 'fsm',
				),
				'WHERE'		=> 'button_display = 1 AND parent_id = 0',
				'ORDER_BY'	=> 'left_id',
			);
			$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
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
					if ($var_name == 'U_MARK_FORUMS')
					{
						$row['button_url'] = ($this->user->data['is_registered'] || $this->config['load_anon_lastread']) ? append_sid("{$this->root_path}index.{$this->php_ext}", 'hash=' . generate_link_hash('global') . '&mark=forums&mark_time=' . time()) : '';
					}
					else
					{
						$row['button_url'] = isset($rootref[$var_name]) ? $rootref[$var_name] : '#';
					}
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
				$sql_ary = array(
					'SELECT'	=> 'fsm.*',
					'FROM'		=> array(
						$this->flatboots_style_menu_table	=> 'fsm',
					),
					'WHERE'		=> 'button_display = 1 AND parent_id = ' . $row['button_id'],
					'ORDER_BY'	=> 'left_id',
				);
				$sub_result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
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
			$sql_ary = array(
				'SELECT'	=> 'fsc.*',
				'FROM'		=> array(
					$this->flatboots_style_config_table	=> 'fsc',
				),
			);
			$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
			while ($row = $this->db->sql_fetchrow($result))
			{
				if ($row['config_name'] == 'about_us' || $row['config_name'] == 'google_analytics' || $row['config_name'] == 'adsense_header' || $row['config_name'] == 'adsense_footer' || $row['config_name'] == 'adsense_topic')
				{
					$row['config_value'] = htmlspecialchars_decode($row['config_value']);
				}
				else if ($row['config_name'] == 'enable_popup_login')
				{
					$enable_popup_login = true;
				}

				$this->template->assign_vars(array(
					strtoupper($row['config_name'])	=> ($row['config_value'] != '') ? $row['config_value'] : false,
				));
			}
			$this->db->sql_freeresult($result);

			// Load Favorite Links
			$sql_ary = array(
				'SELECT'	=> 'fsl.*',
				'FROM'		=> array(
					$this->flatboots_style_links_table	=> 'fsl',
				),
				'WHERE'		=> 'button_display = 1',
				'ORDER_BY'	=> 'left_id',
			);
			$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
			while ($row = $this->db->sql_fetchrow($result))
			{
				if (($row['button_only_registered'] && $this->user->data['user_id'] == ANONYMOUS) || ($row['button_only_guest'] && $this->user->data['user_id'] != ANONYMOUS) )
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
			$sql_ary = array(
				'SELECT'	=> 'fss.*',
				'FROM'		=> array(
					$this->flatboots_style_social_table	=> 'fss',
				),
				'WHERE'		=> 'button_display = 1',
				'ORDER_BY'	=> 'left_id',
			);
			$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
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
			$files = glob($this->root_path . 'ext/sitesplat/flatbootsminicms/images/logo/*');

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
			$files = glob($this->root_path . 'ext/sitesplat/flatbootsminicms/images/bg/*');

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
				'FLATBOOTS_MINI_CMS_ENABLED'	=> true,
				'LOGO_IMAGE_EXIST'	        	=> $logo_exist,
				'BACKGROUND_IMAGE_EXIST'		=> $bg_exist,
				'LOGO_FILENAME'	            	=> $logo_filename,
				'BACKGROUND_FILENAME'	    	=> $bg_filename,

				// custom CSS
				'S_ALLOW_CUSTOMCSS'				=> $this->config['flatboots_enable_custom_css'],
				// custom links on off
				'S_ALLOW_CUSTOMLINKS'			=> $this->config['flatboots_enable_custom_links'],
			));

			// BBauth in modal
			if ($enable_popup_login && !isset($rootref['PROVIDER_TEMPLATE_FILE']))
			{
				$provider_collection = $phpbb_container->get('auth.provider_collection');
				$auth_provider = $provider_collection->get_provider();

				$auth_provider_data = $auth_provider->get_login_data();
				if ($auth_provider_data)
				{
					if (isset($auth_provider_data['VARS']))
					{
						$this->template->assign_vars($auth_provider_data['VARS']);
					}

					if (isset($auth_provider_data['BLOCK_VAR_NAME']))
					{
						foreach ($auth_provider_data['BLOCK_VARS'] as $block_vars)
						{
							// fix REDIRECT_URL
							$url_split = explode('&login=external', $block_vars['REDIRECT_URL']);
							$block_vars['REDIRECT_URL'] = generate_board_url() . '/ucp.php?mode=login&login=external' . $url_split[1];

							$this->template->assign_block_vars($auth_provider_data['BLOCK_VAR_NAME'], $block_vars);
						}
					}

					$this->template->assign_vars(array(
						'PROVIDER_TEMPLATE_FILE' => $auth_provider_data['TEMPLATE_FILE'],
					));
				}
			}
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
		$html = str_replace('class="', 'class="' . (( isset($this->config['flatboots_avatar_effect']) && $this->config['flatboots_avatar_effect'] != '' && $this->config['flatboots_avatar_effect'] != 'none') ? $this->config['flatboots_avatar_effect'] : '') . ' ', $html);
		$event['html'] = $html;
	}
}
