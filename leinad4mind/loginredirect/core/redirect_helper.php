<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\loginredirect\core;

class redirect_helper
{
	protected $root_path;
	protected $php_ext;

	public function __construct($root_path, $php_ext)
	{
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public function topic_url($topic_id)
	{
		return append_sid($this->root_path . 'viewtopic.' . $this->php_ext, 't=' . (int) $topic_id);
	}

	public function show_message($url, $message, $link_text)
	{
		$link_url = reapply_sid($url);
		$redirect_url = redirect($link_url, true);
		meta_refresh(2, $redirect_url);
		$link = '<a href="' . $link_url . '">';
		trigger_error($message . '<br><br>' . sprintf($link_text, $link, '</a>'));
	}
}
