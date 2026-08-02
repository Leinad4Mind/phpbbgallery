<?php

namespace feneck91\introduciator;

/**
 * Class used to check the phpBB version before beeing able to install it.
 *
 * In fact, one event does not exists before the 3.2.8-RC1 version. Should have a look to https://tracker.phpbb.com/browse/PHPBB3-15946.
 * The 3.2.8-RC1 is a release candidate, so the first version accepted for this extension is 3.2.8.
 */

class ext extends \phpbb\extension\base
{
	/**
	 * Directory, relative to the phpBB root, holding the posting claim files used to
	 * guard against duplicate introductions. Kept in sync with
	 * introduciator_helper::CLAIM_DIR (that class is not loaded yet at this point,
	 * since the extension's own services are not registered until it is enabled).
	 */
	const CLAIM_DIR = 'store/feneck91_introduciator';

	public function is_enableable()
	{
		$language = $this->container->get('language');
		$language->add_lang('ext_enable_error', 'feneck91/introduciator');

		$errors = [];

		$config = $this->container->get('config');
		if (!phpbb_version_compare($config['version'], '3.2.8', '>='))
		{
			$errors[] = $language->lang('INTRODUCIATOR_ENABLE_ERROR_PHPBB_VERSION');
		}

		// The protection against duplicate introductions needs to write here.
		$dir = rtrim($this->container->getParameter('core.root_path'), '/') . '/' . self::CLAIM_DIR;
		if (!is_dir($dir))
		{
			@mkdir($dir, 0777, true);
		}
		if (!is_dir($dir) || !is_writable($dir))
		{
			$errors[] = $language->lang('INTRODUCIATOR_ENABLE_ERROR_STORE', $dir);
		}

		return empty($errors) ? true : $errors;
	}
}