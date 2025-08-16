<?php
/** 
* editor.php [English [En]]
*
* @package language cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

// Local Variables
$lang = array_merge($lang, array(
	// English language not need this so, it's empty
	'sceditor'			=> array()
));
