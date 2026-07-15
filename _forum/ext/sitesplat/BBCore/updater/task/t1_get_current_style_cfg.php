<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2021 SiteSplat All rights reserved
* @license Proprietary
*
*/
namespace sitesplat\BBCore\updater\task;
class t1_get_current_style_cfg { protected $root_path; public function __construct($root_path) { $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path) { $this->root_path = $root_path; $updater_config['cfg_data'] = parse_cfg_file($this->root_path . 'styles/' . strtoupper($style_name) . '/style.cfg'); $updater_config['last_step'] = 't1_get_current_style_cfg'; return $updater_config; } }