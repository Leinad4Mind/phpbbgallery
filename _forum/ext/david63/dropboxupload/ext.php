<?php
/**
 * @package Dropbox Upload
 * @copyright (c) 2016 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\dropboxupload;

use phpbb\extension\base;

class ext extends base
{
	public function is_enableable()
	{
		if (phpbb_version_compare(PHP_VERSION, '7.2.0', '<'))
		{
			return $this->language_error('EXT_PHP_ERROR', '7.2.0', PHP_VERSION);
		}
		if (!phpbb_version_compare(PHPBB_VERSION, '3.3.0', '>=') || !phpbb_version_compare(PHPBB_VERSION, '4.0.0@dev', '<'))
		{
			$config = $this->container->get('config');
			return $this->language_error('EXT_ENABLE_ERROR', '3.3.0', '4.0.0@dev', $config['version']);
		}
		if (!$this->container->get('ext.manager')->is_enabled('david63/autodbbackup'))
		{
			return $this->language_error('EXT_AUTODB_ERROR');
		}
		return true;
	}

	protected function language_error($key)
	{
		$language = $this->container->get('language');
		$language->add_lang('ext_enable_error', 'david63/dropboxupload');
		$arguments = func_get_args();
		return call_user_func_array(array($language, 'lang'), $arguments);
	}
}
