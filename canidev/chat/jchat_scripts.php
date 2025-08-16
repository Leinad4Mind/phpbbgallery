<?php
/*
* @name jchat_scripts.php
* @package cBB Chat
* @version v1.1.1 01/07/2015
*
* @copyright (c) 2015 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
define('IN_PHPBB', true);
define('IN_JSCRIPT', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../../../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

header('Content-type: text/javascript; charset=UTF-8');
header('Pragma: public');
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

$paths = array_merge($template->get_user_style(), array('all'));

foreach($paths as $path_name)
{
	$filename = $phpbb_root_path . 'ext/canidev/chat/styles/' . $path_name . '/template/jchat-options.js';
	
	if(file_exists($filename))
	{
		echo @file_get_contents($filename);
		break;
	}
}

$compatibility	= $phpbb_container->get('canidev.chat.compatibility.manager');
$js_events_code	= $compatibility->get_js_events();

if(trim($js_events_code))
{
	echo "
/*
 * Events to load in the chat
 */
jchat(function($) {
$js_events_code

});
";
}

garbage_collection();
