<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\libraries;

class editor_plugin_html extends \canidev\core\editor_plugin
{
	/**
	 * {@inheritDoc}
	 */
	public function get_filename()
	{
		return '@canidev_blockgets/js/editor.plugin.html.js';
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_lang()
	{
		return ['HTML_TITLE', 'INSERT_HTML'];
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_name()
	{
		return 'html';
	}
}
