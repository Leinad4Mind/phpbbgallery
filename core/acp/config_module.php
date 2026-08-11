<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\acp;

class config_module
{
	/** ACP settings that were not active in the imported Gallery 3.4.0 configuration. */
	private const NEW_CORE_SETTINGS = [
		'title',
		'storage_layout',
		'auto_orient',
		'avif_quality',
		'allow_avif',
		'allow_bmp',
		'ajax_navigation',
		'disp_resolution',
		'forum_index_mode',
		'forum_index_recent_count',
		'forum_index_random_count',
		'forum_index_display',
		'forum_index_personal',
		'disp_new_image_count',
		'viewtopic_icon',
		'viewtopic_images',
		'viewtopic_link',
		'index_album_layout',
		'pegas_index_viewed_count',
		'pegas_index_rated_count',
	];

	private const NEW_CORE_ACCENT = '#0076b1';

	public string $u_action = '';
	public string $tpl_name = '';
	public string $page_title = '';
	public \phpbb\language\language $language;
	public array $new_config = [];

	/**
	* This function is called, when the main() function is called.
	* You can use this function to add your language files, check for a valid mode, unset config options and more.
	*
	* @param	string	$id		The ID of the module
	* @param	string	$mode	The name of the mode we want to display
	* @return	void
	*/
	public function main(string $id, string $mode): void
	{
		// Check whether the mode is allowed.
		if (!isset($this->display_vars[$mode]))
		{
			trigger_error('NO_MODE', E_USER_ERROR);
		}

		global $config, $db, $user, $template, $cache, $phpbb_container, $phpbb_gallery_url, $request, $table_prefix;

		$phpbb_gallery_url = $phpbb_container->get('phpbbgallery.core.url');
		$file_tool = $phpbb_container->get('phpbbgallery.core.file.tool');
		$this->language = $phpbb_container->get('language');
		$this->language->add_lang(['gallery', 'gallery_acp', 'gallery_title'], 'phpbbgallery/core');

		$submit = $request->is_set_post('submit');
		$form_key = 'acp_time';
		add_form_key($form_key);

		switch ($mode)
		{
			case 'main':
				$vars = $this->get_display_vars('main');
			break;
		}
		// Init gallery configs class
		$phpbb_gallery_configs = new \phpbbgallery\core\config($config);
		$this->new_config = $phpbb_gallery_configs->get_all();
		$cfg_array = ($request->is_set('config', \phpbb\request\request_interface::REQUEST)) ? utf8_normalize_nfc($request->variable('config', ['' => ''], true)) : $this->new_config;
		$error = [];

		// We validate the complete config if whished
		validate_config_vars($vars['vars'], $cfg_array, $error);
		if (isset($cfg_array['storage_layout'])
			&& !in_array($cfg_array['storage_layout'], [
				\phpbbgallery\core\storage\key_generator::LAYOUT_FLAT,
				\phpbbgallery\core\storage\key_generator::LAYOUT_DISTRIBUTED,
			], true))
		{
			$error[] = $this->language->lang('INVALID_STORAGE_LAYOUT');
		}
		if (isset($cfg_array['index_album_layout'])
			&& !in_array($cfg_array['index_album_layout'], \phpbbgallery\core\config::index_album_layouts(), true))
		{
			$error[] = $this->language->lang('INVALID_INDEX_ALBUM_LAYOUT');
		}
		if (!empty($cfg_array['allow_avif']) && !\phpbbgallery\core\file\file::supports_avif())
		{
			$error[] = $this->language->lang('AVIF_NOT_SUPPORTED');
		}
		if (!empty($cfg_array['allow_bmp']) && !\phpbbgallery\core\image\bmp_processor::is_supported())
		{
			$error[] = $this->language->lang('BMP_NOT_SUPPORTED');
		}
		if ($submit && !check_form_key($form_key))
		{
			$error[] = $this->language->lang('FORM_INVALID');
		}

		// Do not write values if there is an error
		if (sizeof($error))
		{
			$submit = false;
		}
		//now we display the variables
		foreach ($vars['vars'] as $config_name => $null)
		{
			if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}
			$this->new_config[$config_name] = $config_value = $cfg_array[$config_name];

			if ($submit)
			{
				if ($config_name === 'title')
				{
					$config_value = trim(strip_tags((string) $config_value));
				}
				// Check for RRC-display-options
				if (isset($null['method']) && (($null['method'] == 'rrc_display') || ($null['method'] == 'rrc_modes')))
				{
					// Changing the value, casted by int to not mess up anything
					$config_value = (int) array_sum($request->variable($config_name, [0]));
				}
				// Recalculate the Watermark-position
				if (isset($null['method']) && ($null['method'] == 'watermark_position'))
				{
					// Changing the value, casted by int to not mess up anything
					$config_value = $request->variable('watermark_position_x', 0) + $request->variable('watermark_position_y', 0);
				}
				if ($config_name == 'link_thumbnail')
				{
					$update_bbcode = $request->variable('update_bbcode', '');
					// Update the BBCode
					if ($update_bbcode)
					{
						if (!class_exists('acp_bbcodes'))
						{
							$phpbb_gallery_url->_include('acp/acp_bbcodes', 'phpbb');
						}
						$acp_bbcodes = new \acp_bbcodes();
						$bbcode_tpl = $this->bbcode_tpl($config_value);
						$image_bbcode_tag = strtolower((string) ($config['phpbb_gallery_bbcode_tag'] ?? 'image'));
						if (!in_array($image_bbcode_tag, ['image', 'galleryimage'], true))
						{
							$image_bbcode_tag = 'image';
						}
						$gallery_bbcodes = [$image_bbcode_tag => true];
						$gallery_bbcodes['album'] = false;
						foreach ($gallery_bbcodes as $bbcode_tag => $display_on_posting)
						{
							$bbcode_match = '[' . $bbcode_tag . ']{NUMBER}[/' . $bbcode_tag . ']';
							$bbcode_helpline = match ($bbcode_tag)
							{
								'galleryimage' => 'GALLERY_HELPLINE_GALLERYIMAGE',
								'album' => 'GALLERY_HELPLINE_IMAGE_LEGACY',
								default => 'GALLERY_HELPLINE_IMAGE',
							};
							$sql_ary = $acp_bbcodes->build_regexp($bbcode_match, $bbcode_tpl);
							$sql_ary = array_merge($sql_ary, [
								'bbcode_match'        => $bbcode_match,
								'bbcode_tpl'          => $bbcode_tpl,
								'display_on_posting'  => $display_on_posting,
								'bbcode_helpline'     => $bbcode_helpline,
							]);
							$sql = 'UPDATE ' . BBCODES_TABLE . '
								SET ' . $db->sql_build_array('UPDATE', $sql_ary) . "
								WHERE LOWER(bbcode_tag) = '" . $db->sql_escape($bbcode_tag) . "'
									AND bbcode_match = '" . $db->sql_escape($bbcode_match) . "'
									AND (
										bbcode_helpline = '" . $db->sql_escape($bbcode_helpline) . "'
										OR second_pass_replace LIKE '%/gallery/image/%'
									)";
							$db->sql_query($sql);
						}
						$cache->destroy('sql', BBCODES_TABLE);
						$phpbb_container->get('text_formatter.cache')->invalidate();
					}
				}
				if ((strpos($config_name, 'watermark') !== false) && ($phpbb_gallery_configs->get($config_name) != $config_value))
				{
					$phpbb_gallery_configs->set('watermark_changed', time());
					$this->purge_watermarked_images($db, $file_tool, $table_prefix . 'gallery_images');
				}
				$phpbb_gallery_configs->set($config_name, $config_value);
			}
		}
		if ($submit)
		{
			$cache->destroy('sql', CONFIG_TABLE);
			trigger_error($this->language->lang('GALLERY_CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		$this->tpl_name = 'acp_board';
		$this->page_title = $vars['title'];

		$template->assign_vars([
			'L_TITLE'			=> $this->language->lang($vars['title']),
			'L_TITLE_EXPLAIN'	=> $this->language->lang($vars['title'] . '_EXPLAIN'),
			'S_GALLERY_ACP_STORAGE_LAYOUT_HELP' => isset($vars['vars']['storage_layout']),

			'S_ERROR'			=> (sizeof($error)) ? true : false,
			'ERROR_MSG'			=> implode('<br />', $error),

			'U_ACTION'			=> $this->u_action]
		);

		// Output relevant page
		$addon_settings = [];
		foreach ($vars['vars'] as $config_key => $vars)
		{
			if (!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if (strpos($config_key, 'legend') !== false)
			{
				$legend_text = ($this->language->is_set($vars)) ? $this->language->lang($vars) : $vars;

				if (!empty($legend_text))
				{
					$template->assign_block_vars('options', [
						'S_LEGEND' => true,
						'LEGEND'   => $legend_text
					]);
				}

				continue;
			}

			if (isset($vars['append']))
			{
				$langs_var = $this->language->lang_raw($vars['append']);
				if (is_array($langs_var))
				{
					$vars['append'] = ' ' . substr($this->language->lang($vars['append'], 0), 1);
				}
				else
				{
					$vars['append'] = ' ' . $this->language->lang($vars['append']);
				}
			}

			$this->new_config[$config_key] = $phpbb_gallery_configs->get(
				$config_key,
				$vars['default'] ?? null
			);

			$type = explode(':', $vars['type']);

			$l_explain = '';
			if (isset($vars['explain']))
			{
				// lang() echoes the key back when it is missing, so ask before
				// translating, otherwise a raw key ends up on the settings page.
				foreach ([$vars['lang'] . '_EXPLAIN', $vars['lang'] . '_EXP'] as $explain_key)
				{
					if ($this->language->is_set($explain_key))
					{
						$l_explain = $this->language->lang($explain_key);
						break;
					}
				}
			}

			$content = build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);

			if (empty($content))
			{
				continue;
			}

			$template->assign_block_vars('options', [
				'KEY'			=> $config_key,
				'TITLE'			=> $this->language->lang($vars['lang']) ? $this->language->lang($vars['lang']) : $vars['lang'],
				'S_EXPLAIN'		=> (isset($vars['explain']) ? $vars['explain'] : ''),
				'TITLE_EXPLAIN'	=> $l_explain,
				'CONTENT'		=> $content,
			]);

			$setting_identity = null;
			$addon = $vars['addon'] ?? null;
			if (is_array($addon))
			{
				$addon_id = preg_replace('/[^a-z0-9_-]/', '', strtolower((string) ($addon['id'] ?? '')));
				$addon_name = trim((string) ($addon['name'] ?? ''));
				$addon_accent = (string) ($addon['accent'] ?? '');
				if ($this->language->is_set($addon_name))
				{
					$addon_name = $this->language->lang($addon_name);
				}
				if (!preg_match('/^#[0-9a-f]{6}$/i', $addon_accent))
				{
					$addon_accent = '#536d7a';
				}

				if ($addon_id !== '' && $addon_name !== '')
				{
					$setting_identity = [
						'key' => (string) $config_key,
						'id' => $addon_id,
						'name' => $addon_name,
						'accent' => strtolower($addon_accent),
						'badge' => $this->language->lang('GALLERY_ADDON_SETTING', $addon_name),
						'kind' => 'addon',
						'icon' => 'fa-puzzle-piece',
					];
				}
			}
			else if (in_array($config_key, self::NEW_CORE_SETTINGS, true))
			{
				$new_core_name = $this->language->lang('GALLERY_NEW_CORE_SETTING');
				$setting_identity = [
					'key' => (string) $config_key,
					'id' => 'new-core',
					'name' => $new_core_name,
					'accent' => self::NEW_CORE_ACCENT,
					'badge' => $new_core_name,
					'kind' => 'core',
					'icon' => 'fa-star',
				];
			}

			if ($setting_identity !== null)
			{
				$addon_settings[] = $setting_identity;
			}

			unset($this->display_vars['vars'][$config_key]);
		}

		if ($addon_settings)
		{
			$template->assign_vars([
				'S_GALLERY_ACP_ADDON_SETTINGS' => true,
				'GALLERY_ACP_ADDON_SETTINGS_JSON' => json_encode(
					$addon_settings,
					JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE
				),
			]);
		}
	}

	/**
	* Returns an array with the display_var array for the given mode
	* The returned display must have the two keys title and vars
	*		@key	string	title		The page title or lang key for the page title
	*		@key	array	vars		An array of tupels, one foreach config option we display:
	*					@key		The name of the config in the get_config_array() array.
	*								If the key starts with 'legend' a new box is opened with the value being the title of this box.
	*					@value		An array with several options:
	*						@key lang		Description for the config value (can be a language key)
	*						@key explain	Boolean whether the config has an explanation of not.
	*										If true, <lang>_EXP (and <lang>_EXPLAIN) is displayed as explanation
	*						@key validate	The config value can be validated as bool, int or string.
	*										Additional a min and max value can be specified for integers
	*										On strings the min and max value are the length of the string
	*										If your config value shall not be casted, remove the validate-key.
	*						@key type		The type of the config option:
	*										- Radio buttons:		Either with "Yes and No" (radio:yes_no) or "Enabled and Disabled" (radio:enabled_disabled) as description
	*										- Text/password field:	"text:<field-size>:<text-max-length>" and "password:<field-size>:<text-max-length>"
	*										- Select:				"select" requires the key "function" or "method" to be set which provides the html code for the options
	*										- Custom template:		"custom" requires the key "function" or "method" to be set which provides the html code
	*						@key function/method	Required when using type select and custom
	*						@key append		A language string that is appended after the config type (e.g. You can append 'px' to a pixel size field)
	*						@key addon		Optional add-on identity with id, translated name key and six-digit accent colour
	* New Core identities are assigned centrally to settings absent from the active 3.4.0 ACP configuration.
	* This last parameter is optional
	*		@key	string	tpl			Name of the template file we use to display the configs
	*
	* @param	string	$mode	The name of the mode we want to display
	* @return	array		See description above
	*/
	public function get_display_vars(string $mode): array
	{
		global $phpbb_dispatcher;

		$return_ary = $this->display_vars[$mode];

		/**
		* Event to send the display vars
		* @event phpbbgallery.core.acp.config.get_display_vars
		* @var	string	mode		Mode we are requesting for
		* @var	array	return_ary	Array we are sending back
		* @since 1.2.0
		*/
		$vars = ['mode', 'return_ary'];
		extract($phpbb_dispatcher->trigger_event('phpbbgallery.core.acp.config.get_display_vars', compact($vars)));

		$vars = [];
		$legend_count = 1;
		foreach ($return_ary['vars'] as $legend_name => $configs)
		{
			$vars['legend' . $legend_count] = $legend_name;
			foreach ($configs as $key => $options)
			{
				$vars[$key] = $options;
			}
			$legend_count++;
		}

		// Add one last legend for the buttons
		$vars['legend' . $legend_count] = '';
		$return_ary['vars'] = $vars;

		return $return_ary;
	}

	protected array $display_vars = [
		'main'	=> [
			'title'	=> 'GALLERY_CONFIG',
			'vars'	=> [
				'' => [],
				'GALLERY_CONFIG'	=> [
					'title'				=> ['lang' => 'GALLERY_TITLE',		'validate' => 'string',	'type' => 'text:40:255',	'explain' => true],
					'items_per_page'		=> ['lang' => 'ITEMS_PER_PAGE',		'validate' => 'int',	'type' => 'text:7:3',		'explain' => true],
					'allow_comments'		=> ['lang' => 'COMMENT_SYSTEM',		'validate' => 'bool',	'type' => 'radio:yes_no'],
					'comment_user_control'	=> ['lang' => 'COMMENT_USER_CONTROL',	'validate' => 'bool',	'type' => 'radio:yes_no',	'explain' => true],
					'comment_length'		=> ['lang' => 'COMMENT_MAX_LENGTH',	'validate' => 'int',	'type' => 'text:7:5',		'append' => 'CHARACTERS'],
					'allow_rates'			=> ['lang' => 'RATE_SYSTEM',			'validate' => 'bool',	'type' => 'radio:yes_no'],
					'max_rating'			=> ['lang' => 'RATE_SCALE',			'validate' => 'int',	'type' => 'text:7:2'],
					'allow_hotlinking'		=> ['lang' => 'HOTLINK_PREVENT',		'validate' => 'bool',	'type' => 'radio:yes_no'],
					'hotlinking_domains'	=> ['lang' => 'HOTLINK_ALLOWED',		'validate' => 'string',	'type' => 'text:40:255',	'explain' => true],
				],

				'ALBUM_SETTINGS'	=> [
					'album_display'			=> ['lang' => 'RRC_DISPLAY_OPTIONS',	'validate' => 'int',	'type' => 'custom',			'method' => 'rrc_display'],
					'default_sort_key'		=> ['lang' => 'DEFAULT_SORT_METHOD',	'validate' => 'string',	'type' => 'custom',			'method' => 'sort_method_select'],
					'default_sort_dir'		=> ['lang' => 'DEFAULT_SORT_ORDER',	'validate' => 'string',	'type' => 'custom',			'method' => 'sort_order_select'],
					'album_images'			=> ['lang' => 'MAX_IMAGES_PER_ALBUM',	'validate' => 'int',	'type' => 'text:7:7',		'explain' => true],
					'mini_thumbnail_disp'	=> ['lang' => 'DISP_FAKE_THUMB',		'validate' => 'bool',	'type' => 'radio:yes_no'],
					'mini_thumbnail_size'	=> ['lang' => 'FAKE_THUMB_SIZE',		'validate' => 'int',	'type' => 'text:7:4',		'explain' => true,	'append' => 'PIXELS'],
				],

				'SEARCH_SETTINGS'	=> [
					'search_display'		=> ['lang' => 'RRC_DISPLAY_OPTIONS',	'validate' => 'int',	'type' => 'custom',			'method' => 'rrc_display'],
				],

				'STORAGE_SETTINGS'	=> [
					'storage_layout'		=> ['lang' => 'STORAGE_LAYOUT',		'validate' => 'string',	'type' => 'custom',			'explain' => true,	'method' => 'storage_layout_select'],
				],

				'IMAGE_SETTINGS'	=> [
					'num_uploads'			=> ['lang' => 'UPLOAD_IMAGES',			'validate' => 'int',	'type' => 'text:7:2'],
					'max_filesize'			=> ['lang' => 'MAX_FILE_SIZE',			'validate' => 'int',	'type' => 'text:12:9',		'append' => 'BYTES'],
					'max_width'				=> ['lang' => 'MAX_WIDTH',				'validate' => 'int',	'type' => 'text:7:5',		'append' => 'PIXELS'],
					'max_height'			=> ['lang' => 'MAX_HEIGHT',			'validate' => 'int',	'type' => 'text:7:5',		'append' => 'PIXELS'],
					'allow_resize'			=> ['lang' => 'RESIZE_IMAGES',			'validate' => 'bool',	'type' => 'radio:yes_no'],
					'allow_rotate'			=> ['lang' => 'TRANSFORM_IMAGES',		'validate' => 'bool',	'type' => 'radio:yes_no',	'explain' => true],
					'auto_orient'			=> ['lang' => 'AUTO_ORIENT_IMAGES',	'validate' => 'bool',	'type' => 'radio:yes_no',	'explain' => true],
					'jpg_quality'			=> ['lang' => 'JPG_QUALITY',			'validate' => 'int:0:100',	'type' => 'number:0:100',	'explain' => true],
					'avif_quality'			=> ['lang' => 'AVIF_QUALITY',			'validate' => 'int:0:100',	'type' => 'number:0:100',	'explain' => true],
					//'medium_cache'			=> ['lang' => 'MEDIUM_CACHE',			'validate' => 'bool',	'type' => 'radio:yes_no'],
					'medium_width'			=> ['lang' => 'RSZ_WIDTH',				'validate' => 'int',	'type' => 'text:7:4',		'append' => 'PIXELS'],
					'medium_height'			=> ['lang' => 'RSZ_HEIGHT',			'validate' => 'int',	'type' => 'text:7:4',		'append' => 'PIXELS'],
					'allow_gif'				=> ['lang' => 'GIF_ALLOWED',			'validate' => 'bool',	'type' => 'radio:yes_no'],
					'allow_jpg'				=> ['lang' => 'JPG_ALLOWED',			'validate' => 'bool',	'type' => 'radio:yes_no'],
					'allow_png'				=> ['lang' => 'PNG_ALLOWED',			'validate' => 'bool',	'type' => 'radio:yes_no'],
					'allow_webp'			=> ['lang' => 'WEBP_ALLOWED',			'validate' => 'bool',	'type' => 'radio:yes_no'],
					'allow_avif'			=> ['lang' => 'AVIF_ALLOWED',			'validate' => 'bool',	'type' => 'radio:yes_no',	'explain' => true],
					'allow_bmp'			=> ['lang' => 'BMP_ALLOWED',			'validate' => 'bool',	'type' => 'radio:yes_no',	'explain' => true],
					'allow_zip'				=> ['lang' => 'ZIP_ALLOWED',			'validate' => 'bool',	'type' => 'radio:yes_no'],
					'description_length'	=> ['lang' => 'IMAGE_DESC_MAX_LENGTH',	'validate' => 'int',	'type' => 'text:7:5',		'append' => 'CHARACTERS'],
					'disp_nextprev_thumbnail'	=> ['lang' => 'DISP_NEXTPREV_THUMB','validate' => 'bool',	'type' => 'radio:yes_no'],
					'ajax_navigation'		=> ['lang' => 'AJAX_IMAGE_NAVIGATION',	'validate' => 'bool',	'type' => 'radio:yes_no',	'explain' => true],
					'disp_image_url'		=> ['lang' => 'VIEW_IMAGE_URL',		'validate' => 'bool',	'type' => 'radio:yes_no'],
					'disp_resolution'		=> ['lang' => 'DISP_RESOLUTION',		'validate' => 'bool',	'type' => 'radio:yes_no',	'explain' => true],
				],

				'THUMBNAIL_SETTINGS'	=> [
					//'thumbnail_cache'		=> ['lang' => 'THUMBNAIL_CACHE',		'validate' => 'bool',	'type' => 'radio:yes_no'],
					'gdlib_version'			=> ['lang' => 'GD_VERSION',			'validate' => 'int',	'type' => 'custom',			'method' => 'gd_radio'],
					'thumbnail_width'		=> ['lang' => 'THUMBNAIL_WIDTH',		'validate' => 'int',	'type' => 'text:7:3',		'append' => 'PIXELS'],
					'thumbnail_height'		=> ['lang' => 'THUMBNAIL_HEIGHT',		'validate' => 'int',	'type' => 'text:7:3',		'append' => 'PIXELS'],
					'thumbnail_quality'		=> ['lang' => 'THUMBNAIL_QUALITY',		'validate' => 'int',	'type' => 'text:7:3',		'explain' => true,	'append' => 'PERCENT'],
					//'thumbnail_infoline'	=> ['lang' => 'INFO_LINE',				'validate' => 'bool',	'type' => 'radio:yes_no'],
				],

				'WATERMARK_OPTIONS'	=> [
					'watermark_enabled'		=> ['lang' => 'WATERMARK_IMAGES',		'validate' => 'bool',	'type' => 'radio:yes_no'],
					'watermark_source'		=> ['lang' => 'WATERMARK_SOURCE',		'validate' => 'string',	'type' => 'custom',			'explain' => true,	'method' => 'watermark_source'],
					'watermark_height'		=> ['lang' => 'WATERMARK_HEIGHT',		'validate' => 'int',	'type' => 'text:7:4',		'explain' => true,	'append' => 'PIXELS'],
					'watermark_width'		=> ['lang' => 'WATERMARK_WIDTH',		'validate' => 'int',	'type' => 'text:7:4',		'explain' => true,	'append' => 'PIXELS'],
					'watermark_position'	=> ['lang' => 'WATERMARK_POSITION',	'validate' => '',		'type' => 'custom',			'method' => 'watermark_position'],
				],

				'UC_LINK_CONFIG'	=> [
					'link_thumbnail'		=> ['lang' => 'UC_THUMBNAIL',			'validate' => 'string',	'type' => 'custom',			'explain' => true,	'method' => 'uc_select'],
					'link_imagepage'		=> ['lang' => 'UC_IMAGEPAGE',			'validate' => 'string',	'type' => 'custom',			'explain' => true,	'method' => 'uc_select'],
					'link_image_name'		=> ['lang' => 'UC_IMAGE_NAME',			'validate' => 'string',	'type' => 'custom',			'method' => 'uc_select'],
					'link_image_icon'		=> ['lang' => 'UC_IMAGE_ICON',			'validate' => 'string',	'type' => 'custom',			'method' => 'uc_select'],
				],

				'RRC_GINDEX'	=> [
					'rrc_gindex_comments'	=> ['lang' => 'RRC_GINDEX_COMMENTS',	'validate' => 'bool',	'type' => 'radio:yes_no'],
					'rrc_gindex_display'	=> ['lang' => 'RRC_DISPLAY_OPTIONS',	'validate' => '',		'type' => 'custom',			'method' => 'rrc_display'],
					'rrc_gindex_pegas'		=> ['lang' => 'RRC_GINDEX_PGALLERIES',	'validate' => 'bool',	'type' => 'radio:yes_no'],
				],

				'FORUM_INDEX_IMAGES'	=> [
					'forum_index_mode'			=> ['lang' => 'RRC_GINDEX_MODE',			'validate' => 'int',		'type' => 'custom',			'explain' => true,	'method' => 'rrc_modes'],
					'forum_index_recent_count'	=> ['lang' => 'RECENT_ON_INDEX_COUNT',	'validate' => 'int:1:12',	'type' => 'text:7:2'],
					'forum_index_random_count'	=> ['lang' => 'RANDOM_ON_INDEX_COUNT',	'validate' => 'int:1:12',	'type' => 'text:7:2'],
					'forum_index_display'		=> ['lang' => 'RRC_DISPLAY_OPTIONS',		'validate' => 'int',		'type' => 'custom',			'method' => 'rrc_display'],
					'forum_index_personal'		=> ['lang' => 'RRC_GINDEX_PGALLERIES',	'validate' => 'bool',		'type' => 'radio:yes_no'],
				],

				'PHPBB_INTEGRATION'	=> [
					'disp_gallery_icon'			=> ['lang' => 'DISP_GALLERY_ICON',				'validate' => 'bool',	'type' => 'radio:yes_no',	'explain' => true],
					'disp_new_image_count'		=> ['lang' => 'DISP_NEW_IMAGE_COUNT',			'validate' => 'bool',	'type' => 'radio:yes_no',	'explain' => true],
					'disp_total_images'			=> ['lang' => 'DISP_TOTAL_IMAGES',				'validate' => 'bool',	'type' => 'radio:yes_no'],
					'profile_user_images'		=> ['lang' => 'DISP_USER_IMAGES_PROFILE',		'validate' => 'bool',	'type' => 'radio:yes_no'],
					'profile_pega'				=> ['lang' => 'DISP_PERSONAL_ALBUM_PROFILE',	'validate' => 'bool',	'type' => 'radio:yes_no'],
					'rrc_profile_mode'			=> ['lang' => 'RRC_PROFILE_MODE',				'validate' => 'int',	'type' => 'custom',			'explain' => true,	'method' => 'rrc_modes'],
					'rrc_profile_items'			=> ['lang' => 'RRC_PROFILE_ITEMS',				'validate' => 'int',	'type' => 'text:7:3'],
					'rrc_profile_display'		=> ['lang' => 'RRC_DISPLAY_OPTIONS',			'validate' => 'int',	'type' => 'custom',			'method' => 'rrc_display'],
					//'rrc_profile_pegas'			=> ['lang' => 'RRC_GINDEX_PGALLERIES',			'validate' => 'bool',	'type' => 'radio:yes_no'],
					'viewtopic_icon'			=> ['lang' => 'DISP_VIEWTOPIC_ICON',			'validate' => 'bool',	'type' => 'radio:yes_no'],
					'viewtopic_images'			=> ['lang' => 'DISP_VIEWTOPIC_IMAGES',			'validate' => 'bool',	'type' => 'radio:yes_no'],
					'viewtopic_link'			=> ['lang' => 'DISP_VIEWTOPIC_LINK',			'validate' => 'bool',	'type' => 'radio:yes_no'],
				],

				'INDEX_SETTINGS'	=> [
					'index_album_layout'	=> ['lang' => 'INDEX_ALBUM_LAYOUT',	'validate' => 'string',	'type' => 'custom',	'explain' => true,	'method' => 'index_album_layout_select'],
					'pegas_index_album'		=> ['lang' => 'PERSONAL_ALBUM_INDEX',	'validate' => 'bool',	'type' => 'radio:yes_no',	'explain' => true],
					'rrc_gindex_mode'		=> ['lang' => 'RRC_GINDEX_MODE',	'validate' => 'int',	'type' => 'custom',	'explain' => true,	'method' => 'rrc_modes'],
					//'pegas_index_random'	=> ['lang'	=> 'RANDOM_ON_INDEX',		'validate' => 'bool',	'type' => 'radio:yes_no',	'explain' => true],
					'pegas_index_rnd_count'	=> ['lang'	=> 'RANDOM_ON_INDEX_COUNT',	'validate' => 'int',	'type' => 'text:7:3'],
					//'pegas_index_recent'	=> ['lang'	=> 'RECENT_ON_INDEX',		'validate' => 'bool',	'type' => 'radio:yes_no',	'explain' => true],
					'pegas_index_rct_count'	=> ['lang'	=> 'RECENT_ON_INDEX_COUNT',	'validate' => 'int',	'type' => 'text:7:3'],
					'pegas_index_viewed_count' => ['lang' => 'VIEWED_ON_INDEX_COUNT',	'validate' => 'int',	'type' => 'text:7:3'],
					'pegas_index_rated_count'	=> ['lang' => 'RATED_ON_INDEX_COUNT',	'validate' => 'int',	'type' => 'text:7:3'],
					'disp_login'			=> ['lang' => 'DISP_LOGIN',			'validate' => 'bool',	'type' => 'radio:yes_no',	'explain' => true],
					'disp_whoisonline'		=> ['lang' => 'DISP_WHOISONLINE',		'validate' => 'bool',	'type' => 'radio:yes_no'],
					'disp_birthdays'		=> ['lang' => 'DISP_BIRTHDAYS',		'validate' => 'bool',	'type' => 'radio:yes_no'],
					'disp_statistic'		=> ['lang' => 'DISP_STATISTIC',		'validate' => 'bool',	'type' => 'radio:yes_no'],
				],
			],
		],
	];

	/**
	 * Disabled Radio Buttons
	 * @param mixed  $value
	 * @param string $key
	 * @return string
	 */
	public function disabled_boolean(mixed $value, string $key): string
	{
		global $phpbb_container;
		$this->language = $phpbb_container->get('language');

		$tpl = '';

		$tpl .= "<label><input type=\"radio\" name=\"config[$key]\" value=\"1\" disabled=\"disabled\" class=\"radio\" /> " . $this->language->lang('YES') . '</label>';
		$tpl .= "<label><input type=\"radio\" id=\"$key\" name=\"config[$key]\" value=\"0\" checked=\"checked\" disabled=\"disabled\"  class=\"radio\" /> " . $this->language->lang('NO') . '</label>';

		return $tpl;
	}

	/**
	 * Build the Gallery index album layout selector.
	 */
	public function index_album_layout_select(string $value, string $key): string
	{
		if (!isset($this->language))
		{
			global $phpbb_container;
			$this->language = $phpbb_container->get('language');
		}

		if (!in_array($value, \phpbbgallery\core\config::index_album_layouts(), true))
		{
			$value = \phpbbgallery\core\config::INDEX_ALBUM_LAYOUT_CARDS;
		}

		$options = '';
		foreach (\phpbbgallery\core\config::index_album_layouts() as $layout)
		{
			$selected = $layout === $value ? ' selected="selected"' : '';
			$options .= '<option value="' . $layout . '"' . $selected . '>'
				. $this->language->lang('INDEX_ALBUM_LAYOUT_' . strtoupper($layout)) . '</option>';
		}

		return '<select name="config[' . $key . ']" id="' . $key . '">' . $options . '</select>';
	}

	/**
	 * Select sort method
	 * @param string $value
	 * @param string $key
	 * @return string
	 */
	public function sort_method_select(string $value, string $key): string
	{
		global $phpbb_container, $phpbb_dispatcher;
		$this->language = $phpbb_container->get('language');

		$sort_by_text = [
			't' => $this->language->lang('IMAGE_UPLOAD_TIME'),
			'n' => $this->language->lang('IMAGE_NAME'),
			'vc' => $this->language->lang('GALLERY_VIEWS'),
			'u' => $this->language->lang('USERNAME'),
			'ra' => $this->language->lang('RATING'),
			'r' => $this->language->lang('RATES_COUNT'),
			'c' => $this->language->lang('COMMENTS'),
			'lc' => $this->language->lang('NEW_COMMENT'),
		];
		/**
		 * Allow add-ons to expose their image sort labels in the global default.
		 *
		 * @event phpbbgallery.core.image.sort_labels
		 * @var array sort_by_text Sort-key labels
		 * @since 4.1.0
		 */
		$vars = ['sort_by_text'];
		extract($phpbb_dispatcher->trigger_event(
			'phpbbgallery.core.image.sort_labels',
			compact($vars)
		));

		$sort_method_options = '';
		foreach ($sort_by_text as $sort_key => $sort_label)
		{
			$sort_method_options .= '<option' . (($value === $sort_key) ? ' selected="selected"' : '')
				. " value='" . utf8_htmlspecialchars((string) $sort_key) . "'>" . $sort_label . '</option>';
		}

		return "<select name=\"config[$key]\" id=\"$key\">$sort_method_options</select>";
	}

	/**
	 * Select sort order
	 * @param string $value
	 * @param string $key
	 * @return string
	 */
	public function sort_order_select(string $value, string $key): string
	{
		global $phpbb_container;
		$this->language = $phpbb_container->get('language');

		$sort_order_options = '';

		$sort_order_options .= '<option' . (($value == 'd') ? ' selected="selected"' : '') . " value='d'>" . $this->language->lang('SORT_DESCENDING') . '</option>';
		$sort_order_options .= '<option' . (($value == 'a') ? ' selected="selected"' : '') . " value='a'>" . $this->language->lang('SORT_ASCENDING') . '</option>';

		return "<select name=\"config[$key]\" id=\"$key\">$sort_order_options</select>";
	}

	/**
	 * Select the local storage layout used for newly written files.
	 */
	public function storage_layout_select(string $value, string $key): string
	{
		$options = '';
		$quote = chr(34);
		foreach ([
			\phpbbgallery\core\storage\key_generator::LAYOUT_FLAT => 'STORAGE_LAYOUT_FLAT',
			\phpbbgallery\core\storage\key_generator::LAYOUT_DISTRIBUTED => 'STORAGE_LAYOUT_DISTRIBUTED',
		] as $layout => $language_key)
		{
			$selected = $value === $layout ? ' selected=' . $quote . 'selected' . $quote : '';
			$options .= '<option value=' . $quote . $layout . $quote . $selected . '>' . $this->language->lang($language_key) . '</option>';
		}

		$help_id = 'gallery_storage_layout_help';
		$example_filename = '7127abfe9cf6b6d3eb0a523e6158e896.jpeg';
		$help_open = utf8_htmlspecialchars((string) $this->language->lang('STORAGE_LAYOUT_HELP_OPEN'));
		$help_title = utf8_htmlspecialchars((string) $this->language->lang('STORAGE_LAYOUT_HELP_TITLE'));
		$help_close = utf8_htmlspecialchars((string) $this->language->lang('STORAGE_LAYOUT_HELP_CLOSE'));
		$html = '<span class=' . $quote . 'gallery-storage-layout-control' . $quote . '>';
		$html .= '<select name=' . $quote . 'config[' . $key . ']' . $quote . ' id=' . $quote . $key . $quote . '>' . $options . '</select>';
		$html .= '<button class=' . $quote . 'gallery-storage-layout-help-button' . $quote;
		$html .= ' type=' . $quote . 'button' . $quote;
		$html .= ' data-gallery-storage-layout-help-open=' . $quote . $help_id . $quote;
		$html .= ' aria-controls=' . $quote . $help_id . $quote . ' aria-haspopup=' . $quote . 'dialog' . $quote;
		$html .= ' aria-label=' . $quote . $help_open . $quote . ' title=' . $quote . $help_open . $quote . '>';
		$html .= '<span aria-hidden=' . $quote . 'true' . $quote . '>i</span></button></span>';
		$html .= '<dialog class=' . $quote . 'gallery-storage-layout-help-dialog' . $quote . ' id=' . $quote . $help_id . $quote;
		$html .= ' aria-labelledby=' . $quote . $help_id . '_title' . $quote . '>';
		$html .= '<header class=' . $quote . 'gallery-storage-layout-help-dialog__header' . $quote . '>';
		$html .= '<h2 id=' . $quote . $help_id . '_title' . $quote . '>' . $help_title . '</h2>';
		$html .= '<button type=' . $quote . 'button' . $quote;
		$html .= ' class=' . $quote . 'gallery-storage-layout-help-dialog__close' . $quote;
		$html .= ' data-gallery-storage-layout-help-close aria-label=' . $quote . $help_close . $quote . '>&times;</button>';
		$html .= '</header>';
		$html .= '<div class=' . $quote . 'gallery-storage-layout-help-dialog__body' . $quote . '>';
		$html .= '<p>' . utf8_htmlspecialchars((string) $this->language->lang('STORAGE_LAYOUT_HELP_INTRO')) . '</p>';
		$html .= $this->storage_layout_help_section(
			'STORAGE_LAYOUT_FLAT',
			'STORAGE_LAYOUT_HELP_FLAT',
			$example_filename,
			[
				'files/phpbbgallery/core/source/' . $example_filename,
				'files/phpbbgallery/core/medium/' . $example_filename,
				'files/phpbbgallery/core/mini/' . $example_filename,
			]
		);
		$html .= $this->storage_layout_help_section(
			'STORAGE_LAYOUT_DISTRIBUTED',
			'STORAGE_LAYOUT_HELP_DISTRIBUTED',
			$example_filename,
			[
				'files/phpbbgallery/core/source/7/71/' . $example_filename,
				'files/phpbbgallery/core/medium/7/71/' . $example_filename,
				'files/phpbbgallery/core/mini/7/71/' . $example_filename,
			]
		);
		$html .= '<p>' . utf8_htmlspecialchars((string) $this->language->lang('STORAGE_LAYOUT_HELP_URLS')) . '</p>';
		$html .= '<div class=' . $quote . 'gallery-storage-layout-help-warning' . $quote . '>';
		$html .= utf8_htmlspecialchars((string) $this->language->lang('STORAGE_LAYOUT_HELP_CHANGE')) . '</div>';
		$html .= '<p class=' . $quote . 'submit-buttons' . $quote . '><button class=' . $quote . 'button2' . $quote;
		$html .= ' type=' . $quote . 'button' . $quote . ' data-gallery-storage-layout-help-close>' . $help_close . '</button></p>';
		$html .= '</div></dialog>';

		return $html;
	}

	/**
	 * Build one storage-layout explanation and its example paths.
	 *
	 * @param string       $title_key        Language key for the layout name
	 * @param string       $explanation_key  Language key for the explanation
	 * @param string       $example_filename Example storage filename
	 * @param list<string> $paths            Example paths
	 */
	private function storage_layout_help_section(
		string $title_key,
		string $explanation_key,
		string $example_filename,
		array $paths
	): string
	{
		$html = '<section class="gallery-storage-layout-help-section">';
		$html .= '<h3>' . utf8_htmlspecialchars((string) $this->language->lang($title_key)) . '</h3>';
		$html .= '<p>' . utf8_htmlspecialchars((string) $this->language->lang($explanation_key)) . '</p>';
		$html .= '<p><strong>' . utf8_htmlspecialchars((string) $this->language->lang(
			'STORAGE_LAYOUT_HELP_EXAMPLE',
			$example_filename
		)) . '</strong></p><ul class="gallery-storage-layout-help-paths">';
		foreach ($paths as $path)
		{
			$html .= '<li><code>' . utf8_htmlspecialchars($path) . '</code></li>';
		}

		return $html . '</ul></section>';
	}

	/**
	 * Radio Buttons for GD library
	 * @param int    $value
	 * @param string $key
	 * @return string
	 */
	public function gd_radio(int $value, string $key): string
	{
		global $phpbb_container;
		$phpbb_ext_gallery_core_file = $phpbb_container->get('phpbbgallery.core.file.tool');
		$key_gd1	= ($value == $phpbb_ext_gallery_core_file::GDLIB1) ? ' checked="checked"' : '';
		$key_gd2	= ($value == $phpbb_ext_gallery_core_file::GDLIB2) ? ' checked="checked"' : '';

		$tpl = '';

		$tpl .= "<label><input type=\"radio\" name=\"config[$key]\" value=\"" . $phpbb_ext_gallery_core_file::GDLIB1 . "\" $key_gd1 class=\"radio\" /> GD1</label>";
		$tpl .= "<label><input type=\"radio\" id=\"$key\" name=\"config[$key]\" value=\"" . $phpbb_ext_gallery_core_file::GDLIB2 . "\" $key_gd2  class=\"radio\" /> GD2</label>";

		return $tpl;
	}

	/**
	 * Display watermark
	 * @param string $value
	 * @param string $key
	 * @return string
	 */
	public function watermark_source(string $value, string $key): string
	{
		global $phpbb_container;
		$this->language = $phpbb_container->get('language');

		$value = utf8_htmlspecialchars($value);

		return generate_board_url() . "<br /><input type=\"text\" name=\"config[$key]\" id=\"$key\" value=\"$value\" size =\"40\" maxlength=\"125\" /><br /><img src=\"" . generate_board_url() . "/$value\" alt=\"" . $this->language->lang('WATERMARK') . '" />';
	}

	/**
	 * Display watermark
	 * @param int    $value
	 * @param string $key
	 * @return string
	 */
	public function watermark_position(int $value, string $key): string
	{
		global $phpbb_container;

		$this->language = $phpbb_container->get('language');

		$phpbb_ext_gallery_core_constants = new \phpbbgallery\core\constants();

		$x_position_options = $y_position_options = '';

		$x_position_options .= '<option' . (($value & $phpbb_ext_gallery_core_constants::WATERMARK_TOP) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_constants::WATERMARK_TOP . "'>" . $this->language->lang('WATERMARK_POSITION_TOP') . '</option>';
		$x_position_options .= '<option' . (($value & $phpbb_ext_gallery_core_constants::WATERMARK_MIDDLE) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_constants::WATERMARK_MIDDLE . "'>" . $this->language->lang('WATERMARK_POSITION_MIDDLE') . '</option>';
		$x_position_options .= '<option' . (($value & $phpbb_ext_gallery_core_constants::WATERMARK_BOTTOM) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_constants::WATERMARK_BOTTOM . "'>" . $this->language->lang('WATERMARK_POSITION_BOTTOM') . '</option>';

		$y_position_options .= '<option' . (($value & $phpbb_ext_gallery_core_constants::WATERMARK_LEFT) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_constants::WATERMARK_LEFT . "'>" . $this->language->lang('WATERMARK_POSITION_LEFT') . '</option>';
		$y_position_options .= '<option' . (($value & $phpbb_ext_gallery_core_constants::WATERMARK_CENTER) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_constants::WATERMARK_CENTER . "'>" . $this->language->lang('WATERMARK_POSITION_CENTER') . '</option>';
		$y_position_options .= '<option' . (($value & $phpbb_ext_gallery_core_constants::WATERMARK_RIGHT) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_constants::WATERMARK_RIGHT . "'>" . $this->language->lang('WATERMARK_POSITION_RIGHT') . '</option>';

		// Cheating is an evil-thing, but most times it's successful, that's why it is used.
		return "<input type='hidden' name='config[$key]' value='$value' /><select name='" . $key . "_x' id='" . $key . "_x'>$x_position_options</select><select name='" . $key . "_y' id='" . $key . "_y'>$y_position_options</select>";
	}

	/**
	 * Select the link destination
	 * @param string $value
	 * @param string $key
	 * @return string
	 */
	public function uc_select(string $value, string $key): string
	{
		global $phpbb_container;
		$this->language = $phpbb_container->get('language');

		$sort_order_options = '';

		if ($key != 'link_imagepage')
		{
			$sort_order_options .= '<option' . (($value == 'image_page') ? ' selected="selected"' : '') . " value='image_page'>" . $this->language->lang('UC_LINK_IMAGE_PAGE') . '</option>';
		}
		else
		{
			$sort_order_options .= '<option' . (($value == 'next') ? ' selected="selected"' : '') . " value='next'>" . $this->language->lang('UC_LINK_NEXT') . '</option>';
		}
		$sort_order_options .= '<option' . (($value == 'image') ? ' selected="selected"' : '') . " value='image'>" . $this->language->lang('UC_LINK_IMAGE') . '</option>';
		$sort_order_options .= '<option' . (($value == 'none') ? ' selected="selected"' : '') . " value='none'>" . $this->language->lang('UC_LINK_NONE') . '</option>';

		return "<select name='config[$key]' id='$key'>$sort_order_options</select>"
			. (($key == 'link_thumbnail') ? '<br /><input class="checkbox" type="checkbox" name="update_bbcode" id="update_bbcode" value="update_bbcode" /><label for="update_bbcode">' .  $this->language->lang('UPDATE_BBCODE') . '</label>' : '');
	}

	/**
	 * Select RRC-Config on gallery/index.php and in the profile
	 * @param int    $value
	 * @param string $key
	 * @return string
	 */
	public function rrc_modes(int $value, string $key): string
	{
		global $phpbb_container, $phpbb_dispatcher;

		$phpbb_ext_gallery_core_block = $phpbb_container->get('phpbbgallery.core.block');
		$this->language = $phpbb_container->get('language');

		$rrc_mode_options = '';

		$rrc_mode_options .= "<option value='" . $phpbb_ext_gallery_core_block::MODE_NONE . "'>" . $this->language->lang('RRC_MODE_NONE') . '</option>';
		$rrc_mode_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::MODE_RECENT) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::MODE_RECENT . "'>" . $this->language->lang('RRC_MODE_RECENT') . '</option>';
		$rrc_mode_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::MODE_RANDOM) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::MODE_RANDOM . "'>" . $this->language->lang('RRC_MODE_RANDOM') . '</option>';
		if ($key === 'rrc_gindex_mode')
		{
			$rrc_mode_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::MODE_MOST_VIEWED) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::MODE_MOST_VIEWED . "'>" . $this->language->lang('RRC_MODE_MOST_VIEWED') . '</option>';
			$rrc_mode_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::MODE_TOP_RATED) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::MODE_TOP_RATED . "'>" . $this->language->lang('RRC_MODE_TOP_RATED') . '</option>';
		}
		if (!in_array($key, ['rrc_profile_mode', 'forum_index_mode'], true))
		{
			$rrc_mode_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::MODE_COMMENT) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::MODE_COMMENT . "'>" . $this->language->lang('RRC_MODE_COMMENTS') . '</option>';
		}

		/**
		 * Allow add-ons to append Gallery-index image block modes.
		 *
		 * @event phpbbgallery.core.acp.config.rrc_mode_options
		 * @var int    value            Current mode bitmask
		 * @var string key              Configuration key being rendered
		 * @var string rrc_mode_options Rendered option elements
		 * @since 4.1.0
		 */
		$vars = ['value', 'key', 'rrc_mode_options'];
		extract($phpbb_dispatcher->trigger_event(
			'phpbbgallery.core.acp.config.rrc_mode_options',
			compact($vars)
		));

		// Cheating is an evil-thing, but most times it's successful, that's why it is used.
		return "<input type='hidden' name='config[$key]' value='$value' /><select name='" . $key . "[]' multiple='multiple' id='$key'>$rrc_mode_options</select>";
	}

	/**
	 * Select RRC display options
	 * @param int    $value
	 * @param string $key
	 * @return string
	 */
	public function rrc_display(int $value, string $key): string
	{
		global $phpbb_container, $phpbb_dispatcher;
		// Init gallery block class
		$phpbb_ext_gallery_core_block = $phpbb_container->get('phpbbgallery.core.block');
		$this->language = $phpbb_container->get('language');

		$rrc_display_options = '';

		$rrc_display_options .= "<option value='" . $phpbb_ext_gallery_core_block::DISPLAY_NONE . "'>" . $this->language->lang('RRC_DISPLAY_NONE') . '</option>';
		$rrc_display_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::DISPLAY_ALBUMNAME) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::DISPLAY_ALBUMNAME . "'>" . $this->language->lang('RRC_DISPLAY_ALBUMNAME') . '</option>';
		$rrc_display_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::DISPLAY_COMMENTS) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::DISPLAY_COMMENTS . "'>" . $this->language->lang('RRC_DISPLAY_COMMENTS') . '</option>';
		$rrc_display_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::DISPLAY_IMAGENAME) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::DISPLAY_IMAGENAME . "'>" . $this->language->lang('RRC_DISPLAY_IMAGENAME') . '</option>';
		$rrc_display_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::DISPLAY_IMAGETIME) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::DISPLAY_IMAGETIME . "'>" . $this->language->lang('RRC_DISPLAY_IMAGETIME') . '</option>';
		$rrc_display_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::DISPLAY_RESOLUTION) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::DISPLAY_RESOLUTION . "'>" . $this->language->lang('RRC_DISPLAY_RESOLUTION') . '</option>';
		$rrc_display_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::DISPLAY_SUBTITLE) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::DISPLAY_SUBTITLE . "'>" . $this->language->lang('RRC_DISPLAY_SUBTITLE') . '</option>';
		$rrc_display_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::DISPLAY_IMAGEVIEWS) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::DISPLAY_IMAGEVIEWS . "'>" . $this->language->lang('RRC_DISPLAY_IMAGEVIEWS') . '</option>';
		$rrc_display_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::DISPLAY_USERNAME) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::DISPLAY_USERNAME . "'>" . $this->language->lang('RRC_DISPLAY_USERNAME') . '</option>';
		$rrc_display_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::DISPLAY_RATINGS) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::DISPLAY_RATINGS . "'>" . $this->language->lang('RRC_DISPLAY_RATINGS') . '</option>';
		$rrc_display_options .= '<option' . (($value & $phpbb_ext_gallery_core_block::DISPLAY_IP) ? ' selected="selected"' : '') . " value='" . $phpbb_ext_gallery_core_block::DISPLAY_IP . "'>" . $this->language->lang('RRC_DISPLAY_IP') . '</option>';

		/**
		 * Allow add-ons to append display choices to Gallery image summaries.
		 *
		 * @event phpbbgallery.core.acp.config.rrc_display_options
		 * @var int    value               Current display bitmask
		 * @var string key                 Configuration key being rendered
		 * @var string rrc_display_options Rendered option elements
		 * @since 4.1.0
		 */
		$vars = ['value', 'key', 'rrc_display_options'];
		extract($phpbb_dispatcher->trigger_event(
			'phpbbgallery.core.acp.config.rrc_display_options',
			compact($vars)
		));

		// Cheating is an evil-thing, but most times it's successful, that's why it is used.
		return "<input type='hidden' name='config[$key]' value='$value' /><select name='" . $key . "[]' multiple='multiple' id='$key'>$rrc_display_options</select>";
	}

	/**
	 * BBCode-Template
	 * @param string $value
	 * @return string
	 */
	public function bbcode_tpl(string $value): string
	{
		global $phpbb_container;

		$helper = $phpbb_container->get('controller.helper');
		$gallery_url = $phpbb_container->get('phpbbgallery.core.url');
		$placeholder = 987654321;
		$image_page = $gallery_url->get_uri($helper->route('phpbbgallery_core_image', [
			'image_id' => $placeholder,
		]));
		$image_source = $gallery_url->get_uri($helper->route('phpbbgallery_core_image_file_source', [
			'image_id' => $placeholder,
		]));
		$image_mini = $gallery_url->get_uri($helper->route('phpbbgallery_core_image_file_mini', [
			'image_id' => $placeholder,
		]));
		$image_page = str_replace((string) $placeholder, '{NUMBER}', $image_page);
		$image_source = str_replace((string) $placeholder, '{NUMBER}', $image_source);
		$image_mini = str_replace((string) $placeholder, '{NUMBER}', $image_mini);

		if ($value == 'image_page')
		{
			$bbcode_tpl = '<a href="' . $image_page . '"><img src="' . $image_mini . '" alt="{NUMBER}" /></a>';
		}
		else if ($value == 'image')
		{
			$bbcode_tpl = '<a href="' . $image_source . '"><img src="' . $image_mini . '" alt="{NUMBER}" /></a>';
		}
		else
		{
			$bbcode_tpl = '<img src="' . $image_mini . '" alt="{NUMBER}" />';
		}

		return $bbcode_tpl;
	}

	private function purge_watermarked_images(
		\phpbb\db\driver\driver_interface $db,
		\phpbbgallery\core\file\file $file_tool,
		string $images_table
	): void
	{
		$sql = 'SELECT image_filename
			FROM ' . $images_table;
		$result = $db->sql_query($sql);
		$filenames = [];
		while ($row = $db->sql_fetchrow($result))
		{
			$filenames[] = (string) $row['image_filename'];
		}
		$db->sql_freeresult($result);
		if ($filenames)
		{
			$file_tool->delete_wm($filenames);
		}
	}
}
