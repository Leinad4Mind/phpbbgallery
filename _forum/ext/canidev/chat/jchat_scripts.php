<?php
/*
* @name jchat_scripts.php
* @package cBB Chat
* @version v1.1.3 10/03/2017
*
* @copyright (c) 2017 CaniDev
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

$compatibility	= $phpbb_container->get('canidev.chat.compatibility.manager');
$paths			= array_merge($template->get_user_style(), array('all'));
$base_folder	= 'ext/canidev/chat/styles/';
$js_filename	= 'jchat-options.js';

/**
* Event to modify the custom JavaScript file
*
* @event chat.before_load_js
* @var	array	paths			Array with the style paths to search the file
* @var	string	base_folder		Folder to the styles path
* @var	string	filename		Filename of javascript file
* @since 1.1.3
*/
$vars = array('paths', 'base_folder', 'js_filename');
extract($phpbb_dispatcher->trigger_event('chat.before_load_js', compact($vars)));

foreach($paths as $path_name)
{
	$filename = $phpbb_root_path . $base_folder . $path_name . '/template/js/' . $js_filename;
	
	if(file_exists($filename))
	{
		echo @file_get_contents($filename);
		break;
	}
}

if($js_events_code = $compatibility->get_js_events())
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
