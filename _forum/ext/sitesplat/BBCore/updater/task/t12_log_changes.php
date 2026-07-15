<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2021 SiteSplat All rights reserved
* @license Proprietary
*
*/
namespace sitesplat\BBCore\updater\task;
class t12_log_changes { protected $log; protected $user; public function __construct(\phpbb\log\log_interface $log, \phpbb\user $user) { $this->log = $log; $this->user = $user; } public function run($style_name, $updater_config) { $this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_STYLE_UPDATED', false, [ $style_name, !empty($updater_config['log_data']['edited']) ? implode('<br />&emsp;', $updater_config['log_data']['edited']) : '-', !empty($updater_config['log_data']['added']) ? implode('<br />&emsp;', $updater_config['log_data']['added']) : '-', !empty($updater_config['log_data']['deleted']) ? implode('<br />&emsp;', $updater_config['log_data']['deleted']) : '-', ]); $updater_config['last_step'] = 't12_log_changes'; return $updater_config; } }