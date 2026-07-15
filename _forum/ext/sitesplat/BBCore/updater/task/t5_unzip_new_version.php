<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2021 SiteSplat All rights reserved
* @license Proprietary
*
*/
namespace sitesplat\BBCore\updater\task;
class t5_unzip_new_version { protected $filesystem; protected $root_path; public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path) { $this->filesystem = $filesystem; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path, $fs) { $tmp_path = $fs->phpbb_root_dir . '/store/'; $tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip'; $updater_config['tmp_dir'] = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '/'; $fs_type = $fs->fs_type; $fs->fs_type = 'direct'; if (file_exists($updater_config['tmp_dir'])) { $this->filesystem->remove($updater_config['tmp_dir']); } $this->filesystem->mkdir($updater_config['tmp_dir']); $result = $fs->zip_extract($tmp_file, $updater_config['tmp_dir']); if ($result === false) { throw new \Exception($fs->ftp_error); } $this->filesystem->remove($tmp_file); $fs->fs_type = $fs_type; $updater_config['last_step'] = 't5_unzip_new_version'; return $updater_config; } }