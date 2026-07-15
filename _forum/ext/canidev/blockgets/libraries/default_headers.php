<?php
/*
* @name default_headers.php
* @package cBB Blockgets
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

$overall_headers = array(
	array('css', '@canidev_blockgets/../theme/common.css'),
	array('css', '@canidev_blockgets/../theme/31x.css'),
	array('css', '@canidev_blockgets/../theme/blockgets.css', 'frontend'),
	array('css', 'acp.css', 'admin'),
	array('css', array('colorPickerMod', 'color-picker.css'), 'admin'),

	array('js', '@canidev_blockgets/js/jquery-ui-custom.min.js', 'admin'),
	array('js', '@canidev_blockgets/js/jquery-color-picker.min.js', 'admin'),
	
	array('js', '@canidev_blockgets/js/jblockgets.js'),
	array('js', 'js/jblockgets-acp.js', 'admin'),
);
