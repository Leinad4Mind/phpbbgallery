<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2021 SiteSplat All rights reserved
* @license Proprietary
*
*/
namespace sitesplat\BBCore\updater\task;
class t8_check_additions { protected $language; protected $root_path; public function __construct(\phpbb\language\language $language, $root_path) { $this->language = $language; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path) { $updater_config['last_step'] = 't8_check_additions'; return $updater_config; } }