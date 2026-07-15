<?php
/**
 * BBlivechat
 * @copyright (c) 2021 SiteSplat. All rights reserved.
 * @license Proprietary
 */

namespace sitesplat\bblivechat\cron;
class bblc_cron extends \phpbb\cron\task\base { protected $config, $db, $lastnow, $now; public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\language\language $language) { $this->config = $config; $this->db = $db; $this->language = $language; $this->now = time(); if (!isset($config['bblivechat_cron'])) { $this->lastnow = 0; } else { $this->lastnow = intval($config['bblivechat_cron']) + 1; } } public function run() { if ($this->lastnow) { $deltime = date('Y-m-d H:i:s', $this->now - (30 * 86400)); $this->db->sql_query("DELETE FROM bblc_messages WHERE `dateTime` < '{$deltime}'"); } $this->config->set('bblivechat_cron', $this->now); } public function is_runnable() { return true; } public function should_run() { return $this->now > $this->lastnow + 86400; } }