<?php
/**
 * BBlivechat
 * @copyright (c) 2020 SiteSplat. All rights reserved.
 * @license Proprietary
 */

define('BBLC_ROOT_DIR', __DIR__);
define('PHPBB_ROOT_DIR', dirname(__DIR__));
$bblc = PHPBB_ROOT_DIR . '/ext/sitesplat/bblivechat/chat/';

require("{$bblc}bblivechat.php");
require("ajaxchat.php");
require("{$bblc}bblc_init.php");

new BBlivechat;
