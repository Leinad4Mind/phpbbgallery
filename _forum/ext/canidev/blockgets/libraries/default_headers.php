<?php
/*
* @package cBB Blockgets
* @version v2.0.2 12/01/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

$overall_headers = array(
	array('css', '@canidev_blockgets/../theme/common.css'),
	array('css', '@canidev_blockgets/acp.css', false, 'admin'),

	array('js', '@canidev_core/js/jquery-ui.min.js', false, 'admin'),
	array('js', '@canidev_blockgets/js/jblockgets.min.js'),
	array('js', '@canidev_blockgets/js/jblockgets-acp.js', false, 'admin'),
);
