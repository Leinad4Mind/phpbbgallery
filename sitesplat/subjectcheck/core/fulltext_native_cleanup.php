<?php
/**
*
* @package subjectcheck
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\subjectcheck\core;

class fulltext_native_cleanup extends \phpbb\search\fulltext_native
{
	protected $root_path;
	protected $php_ext;
	public function __construct($root_path, $php_ext)
	{
		$this->phpbb_root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public function cleanup($text, $allowed_chars = null, $encoding = 'utf-8')
	{
		if (!class_exists('utf_normalizer') && file_exists($this->phpbb_root_path . 'includes/utf/utf_normalizer.' . $this->php_ext))
		{
			include($this->phpbb_root_path . 'includes/utf/utf_normalizer.' . $this->php_ext);
		}

		return parent::cleanup($text, $allowed_chars, $encoding);
	}
}
