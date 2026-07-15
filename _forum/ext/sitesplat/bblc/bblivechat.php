<?php
/**
 * BBlivechat Sidebar HTML Addon
 * @copyright (c) 2020 SiteSplat. All rights reserved.
 * @license Proprietary
 */

namespace sitesplat\bblc_sidebar_html;
class bblivechat { protected $sbhtml = ''; public function __construct() { \sitesplat\add_filter('bblivechat_sidebar_html', [$this, 'sbhtml_display'], 1); \sitesplat\add_filter('bblc_handle_acp_settings', [$this, 'sbhtml_handle'], 1); \sitesplat\add_filter('bblc_display_acp_settings', [$this, 'sbhtml_form'], 1); } public function sbhtml_display($html) { return htmlspecialchars_decode($this->get_html()); } public function sbhtml_handle($error) { global $cache, $db, $language, $request; $sbhtml = \sitesplat\emoji_convert($request->variable('bblc_sbhtml', '', true)); if (strlen($sbhtml) > 32768) { $error[] = sprintf($language->lang('SETTING_TOO_LONG'), 'bblc_sidebar_html', 32768); $this->sbhtml = $sbhtml; } else { $sbhtml = $db->sql_escape($sbhtml); $db->sql_query('REPLACE INTO ' . CONFIG_TEXT_TABLE . " VALUES('bblc_sidebar_html', '$sbhtml')"); $cache->destroy('_bblc_sidebar_html'); } return $error; } public function sbhtml_form($html) { global $language; $label = $language->lang('BBLC_SBHTML') . $language->lang('COLON'); $explain = $language->lang('BBLC_SBHTML_EXPLAIN'); $sbhtml = $this->get_html(); return $html . <<<EOT
<dl> <dt style="width:auto;border-right:none"><label>$label</label><span>$explain</span></dt> <div style="clear:both;height:8px"></div> <textarea name="bblc_sbhtml" rows="8" cols="80" style="width:90%">$sbhtml</textarea> </dl> <hr />
EOT;
} private function get_html() { global $cache, $db; $sbhtml = $cache->get('_bblc_sidebar_html'); if ($sbhtml === false) { $sql = 'SELECT config_value FROM ' . CONFIG_TEXT_TABLE . " WHERE config_name = 'bblc_sidebar_html'"; $result = $db->sql_query($sql); $sbhtml = (string) $db->sql_fetchfield('config_value'); $db->sql_freeresult($result); $cache->put('_bblc_sidebar_html', $sbhtml); } return $sbhtml; } }