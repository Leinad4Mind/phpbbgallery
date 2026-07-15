<?php
/*
* @package Ext Common Core
* @version v1.0.4 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\core;

use Symfony\Component\DependencyInjection\ContainerInterface;

class editor
{
	protected $config;
	protected $container;
	protected $core;
	protected $db;
	protected $dispatcher;
	protected $language;
	protected $path;
	protected $request;
	protected $template;
	protected $user;
	protected $phpbb_root_path;
	protected $php_ext;

	protected $resources_loaded = false;
	protected $plugins 			= array();

	private $bbcodes 			= null;
	private $smilies 			= null;
	private $smilies_per_page 	= 50;

	static $instance;

	public function __construct(ContainerInterface $container)
	{
		$this->config 			= $container->get('config');
		$this->container 		= $container;
		$this->core 			= \canidev\core\lib::get_instance($container);
		$this->db 				= $container->get('dbal.conn');
		$this->dispatcher 		= $container->get('dispatcher');
		$this->language 		= $container->get('language');
		$this->path				= $container->get('path_helper');
		$this->request 			= $container->get('request');
		$this->template 		= \canidev\core\template::get_instance($container);
		$this->user 			= $container->get('user');
		$this->phpbb_root_path	= $container->getParameter('core.root_path');
		$this->php_ext			= $container->getParameter('core.php_ext');

		$this->language->add_lang('posting');
		$this->language->add_lang('editor', 'canidev/core');
	}

	public function add_plugin($plugin_filename, $is_global = false)
	{
		$class_name	= str_replace('/', '\\', $plugin_filename);

		if(!class_exists($class_name))
		{
			return false;
		}

		$plugin = new $class_name($this);
		$plugin->is_global($is_global);

		$plugin_name = $plugin->get_name();

		if(!isset($this->plugins[$plugin_name]))
		{
			$this->plugins[$plugin_name] = $plugin;
		}
	}

	public function build($options, $return_data = false)
	{
		if(!function_exists('display_custom_bbcodes'))
		{
			include($this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext);
		}

		$default_options = array(
			'id'					=> gen_rand_string(4),
			'name'					=> '',
			'value'					=> '',
			'type'					=> 'basic',
			'rows'					=> '',
			'showRemoveFormat' 		=> true,
			'plugins' 				=> array(),	
		);

		$editor_options = array();

		$options = array_merge($default_options, $options);

		if(is_string($options['plugins']))
		{
			$options['plugins'] = explode(',', $options['plugins']);
		}

		// Load default resources
		if(!$this->resources_loaded)
		{
			$this->bbcodes_to_template();

			if($options['type'] == 'advanced')
			{
				$this->template->append_asset('css', '@canidev_core/../theme/editor.css');
				$this->template->append_asset('js', '@canidev_core/js/editor.min.js');
			}

			$this->core->set_js_lang(array(
				'AUTHOR',
				'CODE',
				'DATE',
				'DESCRIPTION_OPTIONAL',
				'INSERT',
				'MAXIMIZE',
				'PRINT',
				'REMOVE_FORMAT',
				'UNLINK',
				'URL',
				'VIEW_SOURCE',
			));

			$this->resources_loaded = true;
		}

		// Load plugins
		foreach($this->plugins as $plugin_name => $plugin)
		{
			if($plugin->is_global() || in_array($plugin_name, $options['plugins']))
			{
				$options['plugins'][] = $plugin_name;

				if($plugin->get_lang())
				{
					$this->core->set_js_lang($plugin->get_lang());
				}

				$this->template->append_asset('js', $plugin->get_filename());
			}
		}

		// Editor and template variables
		$options['plugins'] = array_unique($options['plugins']);

		if($options['type'] == 'advanced')
		{
			$editor_options = array(
				'emoticons'	=> $this->generate_editor_emoticons(),
				'style'		=> $this->template->append_asset('css', '@canidev_core/../theme/editor.css', true),
				'additionalStyles'	=> array(
					$this->template->append_asset('css', '../theme/stylesheet.css', true),
					$this->template->append_asset('css', (!empty($this->config['allow_cdn']) && !empty($this->config['load_font_awesome_url'])) ? $this->config['load_font_awesome_url'] : './assets/css/font-awesome.min.css', true),
				)
			);
		}

		$this->template->assign_vars(array(
			'S_EDITOR_CONTENT'		=> $options['value'],
			'S_EDITOR_ID'			=> $options['id'],
			'S_EDITOR_NAME'			=> $options['name'],
			'S_EDITOR_ROWS'			=> $options['rows'],

			'MAX_FONT_SIZE'			=> (int)$this->config['max_post_font_size'],
			'S_BBCODE_URL'			=> ($this->config['allow_post_links']) ? true : false,
			'S_SHOW_REMOVEFORMAT'	=> $options['showRemoveFormat'],
		));

		unset($options['value'], $options['name'], $options['rows']);

		$this->template->assign_json_var('S_EDITOR_OPTIONS', array_merge($editor_options, $options));

		if($return_data)
		{
			$this->template->set_filenames(array(
				'editor'	=> '@canidev_core/editor_body.html'
			));

			return array(
				'id'		=> $options['id'],
				'template' 	=> $this->template->assign_display('editor'),
			);
		}
	}

	private function generate_smilies()
	{
		if($this->smilies !== null)
		{
			return;
		}

		$root_path		= (defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? generate_board_url() . '/' : $this->path->get_web_root_path();
		$i 				= 0;
		$smiley_ary 	= array();

		$this->smilies = array(
			'items' 	=> array(),
			'current' 	=> array(),
			'start'		=> $this->request->variable('smiley_start', 0),
		);

		if(!$this->config['allow_smilies'])
		{
			return;
		}

		$sql = 'SELECT *
			FROM ' . SMILIES_TABLE . '
			ORDER BY smiley_order';
		$result = $this->db->sql_query($sql, 3600);
		while($row = $this->db->sql_fetchrow($result))
		{
			$row['smiley_full_url'] = $root_path . $this->config['smilies_path'] . '/' . $row['smiley_url'];
			
			if(!in_array($row['smiley_full_url'], $smiley_ary))
			{
				$i++;

				if($i > $this->smilies['start'] && sizeof($this->smilies['current']) < $this->smilies_per_page)
				{
					$this->smilies['current'][$i] = $row['code'];
				}

				$this->smilies['items'][$i] = $row;

				$smiley_ary[] = $row['smiley_full_url'];
			}
		}
		$this->db->sql_freeresult($result);

		unset($smiley_ary);
	}

	private function generate_editor_emoticons()
	{
		$this->generate_smilies();

		$result = array(
			'hidden' => array(),
		);

		foreach($this->smilies['items'] as $i => $row)
		{
			$result['hidden'][$row['code']] = $row['smiley_full_url'];
		}

		return $result;
	}

	public function bbcodes_to_template()
	{
		if($this->bbcodes === null)
		{
			$this->bbcodes = array();

			$sql_ary = array(
				'SELECT'	=> 'b.bbcode_id, b.bbcode_tag, b.bbcode_helpline',
				'FROM'		=> array(BBCODES_TABLE => 'b'),
				'WHERE'		=> 'b.display_on_posting = 1',
				'ORDER_BY'	=> 'b.bbcode_tag',
			);

			/*
			* @event canidev.core.editor_bbcodes_modify_sql
			* @var	array	sql_ary		The SQL array to get the bbcode data
			* @since 1.0.4
			*/
			$vars = array('sql_ary');
			extract($this->dispatcher->trigger_event('canidev.core.editor_bbcodes_modify_sql', compact($vars)));

			$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
			while ($row = $this->db->sql_fetchrow($result))
			{
				$this->bbcodes[] = $row;
			}
			$this->db->sql_freeresult($result);
		}

		foreach($this->bbcodes as $i => $row)
		{
			// If the helpline is defined within the language file, we will use the localised version, else just use the database entry...
			if($this->language->is_set(strtoupper($row['bbcode_helpline'])))
			{
				$row['bbcode_helpline'] = $this->language->lang(strtoupper($row['bbcode_helpline']));
			}

			$custom_tag = array(
				'BBCODE_CODE'		=> $row['bbcode_tag'],
				'BBCODE_TAG'		=> str_replace('=', '', $row['bbcode_tag']),
				'BBCODE_HELPLINE'	=> $row['bbcode_helpline'],
			);

			/*
			* @event canidev.core.editor_bbcodes_modify_row
			* @var	array	custom_tag		Template data of the bbcode
			* @var	array	row				The data of the bbcode
			* @since 1.0.4
			*/
			$vars = array('custom_tag', 'row');
			extract($this->dispatcher->trigger_event('canidev.core.editor_bbcodes_modify_row', compact($vars)));

			$this->template->assign_block_vars('editor_custom_tag', $custom_tag);
		}
	}

	public function smilies_to_template($use_pagination = true)
	{
		$this->generate_smilies();

		$this->template->destroy_block_vars('smileyrow');
		$this->template->destroy_block_vars('smiley_pagination');

		foreach($this->smilies['items'] as $i => $row)
		{
			if($use_pagination && !isset($this->smilies['current'][$i]))
			{
				continue;
			}

			$this->template->assign_block_vars('smileyrow', array(
				'SMILEY_CODE'	=> $row['code'],
				'A_SMILEY_CODE'	=> addslashes($row['code']),
				'SMILEY_IMG'	=> $row['smiley_full_url'],
				'SMILEY_WIDTH'	=> $row['smiley_width'],
				'SMILEY_HEIGHT'	=> $row['smiley_height'],
				'SMILEY_DESC'	=> $row['emotion']
			));
		}

		// Generate pagination
		$total_smiley_count = sizeof($this->smilies['items']);

		if($use_pagination && $total_smiley_count > $this->smilies_per_page)
		{
			$pagination = $this->container->get('pagination');
			
			// Make sure $start is set to the last page if it exceeds the amount
			$this->smilies['start'] = $pagination->validate_start($this->smilies['start'], $this->smilies_per_page, $total_smiley_count);
			
			$pagination->generate_template_pagination('#?cbbModule=editor', 'smiley_pagination', 'smiley_start', $total_smiley_count, $this->smilies_per_page, $this->smilies['start']);
		}
	}

	public function do_actions()
	{
		if(!($this->request->variable('cbbModule', '') == 'editor') && ($this->request->is_ajax() || $this->request->variable('ajaxRequest', false)))
		{
			return false;
		}

		if($this->request->variable('pagination', false))
		{
			$this->smilies_to_template();

			$this->template->set_filenames(array(
				'smiley'	=> '@canidev_core/smiley_box.html'
			));

			\canidev\core\json_response::get_instance()->send(array(
				'htmlContent'	=> $this->template->assign_display('smiley')
			));
		}
	}

	static public function get_instance($container)
	{
		if(!self::$instance)
		{
			self::$instance = new self($container);
		}

		return self::$instance;
	}
}
