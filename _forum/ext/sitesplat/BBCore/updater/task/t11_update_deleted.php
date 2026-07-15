<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2021 SiteSplat All rights reserved
* @license Proprietary
*
*/
namespace sitesplat\BBCore\updater\task;
class t11_update_deleted { protected $filesystem; protected $root_path; public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path) { $this->filesystem = $filesystem; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path, $fs) { $this->root_path = $root_path; $current_files_path = $this->root_path . 'styles/' . $style_name . '/'; if (!empty($updater_config['update_info']['deleted'])) { foreach ($updater_config['update_info']['deleted'] as $file_path) { $fs->delete($current_files_path . $file_path); } unset($updater_config['update_info']['deleted']); } if (!empty($updater_config['update_info']['deleted_dirs'])) { foreach ($updater_config['update_info']['deleted_dirs'] as $file_path) { $fs->rmdir($current_files_path . $file_path); } unset($updater_config['update_info']['deleted_dirs']); } $updater_config['last_step'] = 't11_update_deleted'; return $updater_config; } }