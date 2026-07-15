<?php
/*
* @package cBB Blockgets
* @version v2.0.2 12/01/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\libraries;

class editor_plugin_html extends \canidev\core\editor_plugin
{
	public function get_filename()
	{
		return '@canidev_blockgets/js/editor.plugin.html.js';
	}

	public function get_lang()
	{
		return array('HTML_TITLE', 'INSERT_HTML');
	}

	public function get_name()
	{
		return 'html';
	}
}
