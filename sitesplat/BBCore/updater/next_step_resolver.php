<?php

/**
 *
 * @package sitesplat BBcore
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\BBCore\updater;

class next_step_resolver
{
	protected $config_text;
	protected $filesystem;
	protected $container;
	protected $root_path;
	protected $real_root_path;
	protected $old_handler;
	protected $phperror = '';
	protected $start_time;
	protected $max_execution_time;
	protected $memory_limit;
	public function __construct(\phpbb\config\db_text $config_text, \phpbb\filesystem\filesystem_interface $filesystem, \Symfony\Component\DependencyInjection\ContainerInterface $container, \bantu\IniGetWrapper\IniGetWrapper $php_ini, $root_path)
	{
		$this->config_text = $config_text;
		$this->filesystem = $filesystem;
		$this->container = $container;
		$this->root_path = $root_path;
		$this->real_root_path = realpath($root_path) . '/';
		$this->start_time = microtime(true);
		$execution_time = $php_ini->getNumeric('max_execution_time');
		$this->max_execution_time = min(15, $execution_time / 2);
		$this->memory_limit = $php_ini->getBytes('memory_limit');
	}
	public function msg_handler($errno, $msg_text, $errfile, $errline)
	{
		if (error_reporting() != 0 && ($errno == E_NOTICE || $errno == E_WARNING)) {
			$errfile = phpbb_filter_root_path($errfile);
			$msg_text = phpbb_filter_root_path($msg_text);
			$error_name = ($errno === E_WARNING) ? 'PHP Warning' : 'PHP Notice';
			$this->phperror .= "<b>$error_name</b> in file <b>$errfile</b> on line <b>$errline</b>: <b>$msg_text</b><br />\n";
			return true;
		} else if (!empty($this->old_handler)) {
			return call_user_func_array($this->old_handler, [$errno, $msg_text, $errfile, $errline]);
		}
		return false;
	}
	public function run_task($fs, $style_name)
	{
		$this->old_handler = set_error_handler([$this, 'msg_handler']);
		$updater_config = json_decode($this->config_text->get('sitesplat_bbcore_updater'), true);
		if (empty($updater_config['last_step'])) {
			$updater_config['last_step'] = '';
			$updater_config['merge_conflicts'] = false;
			$this->filesystem->remove($this->real_root_path . 'store/merge_conflicts_' . $style_name);
		}
		try {
			while ($this->has_enought_time() && $this->has_enough_memory()) {
				switch ($updater_config['last_step']) {
					case '':
						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t0_backup')->run($style_name, $updater_config, $this->real_root_path);
						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
						break;
					case 't0_backup':
						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t1_get_current_style_cfg')->run($style_name, $updater_config, $this->real_root_path);
						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
						break;
					case 't1_get_current_style_cfg':
						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t2_get_newest_style_cfg')->run($style_name, $updater_config);
						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
						break;
					case 't2_get_newest_style_cfg':
						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t3_check_problems')->run($style_name, $updater_config);
						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
						break;
					case 't3_check_problems':
						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t4_download_newest_version')->run($style_name, $updater_config, $this->real_root_path);
						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
						break;
					case 't4_download_newest_version':
						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t5_unzip_new_version')->run($style_name, $updater_config, $this->real_root_path, $fs);
						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
						break;
					case 't5_unzip_new_version':
						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t6_load_list_of_changes')->run($style_name, $updater_config);
						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
						break;
					case 't6_load_list_of_changes':
						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t7_merge_edits')->run($style_name, $updater_config, $this->real_root_path);
						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
						break;
					case 't7_merge_edits':
						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t8_check_additions')->run($style_name, $updater_config, $this->real_root_path);
						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
						break;
					case 't8_check_additions':
						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t9_update_edits')->run($style_name, $updater_config, $this->real_root_path, $fs);
						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
						break;
					case 't9_update_edits':
						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t10_update_added')->run($style_name, $updater_config, $this->real_root_path, $fs);
						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
						break;
					case 't10_update_added':
						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t11_update_deleted')->run($style_name, $updater_config, $this->real_root_path, $fs);
						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
						break;
					case 't11_update_deleted':
						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t12_log_changes')->run($style_name, $updater_config);
						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
						break;
					case 't12_log_changes':
						$this->config_text->set('sitesplat_bbcore_updater', '');
						return true;
						break;
				}
				return $this->phperror ?: false;
			}
		} catch (\Exception $e) {
			$this->config_text->set('sitesplat_bbcore_updater', '');
			return $e->getMessage();
		}
		return false;
	}
	protected function has_enought_time()
	{
		return (($this->start_time + $this->max_execution_time) - microtime(true)) > 0;
	}
	protected function has_enough_memory()
	{
		if ($this->memory_limit <= 0) {
			return true;
		}
		if (function_exists('memory_get_usage')) {
			return ($this->memory_limit - memory_get_usage()) > 0;
		}
		return true;
	}
}
