<?php
/**
 *
 * HTML email extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
 * @copyright (c) 2026 Leinad4Mind <https://leinad4mind.top>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\htmlemail\service;

class template_finder
{
	protected string $phpbb_root_path;

	public function __construct(string $phpbb_root_path)
	{
		$this->phpbb_root_path = $phpbb_root_path;
	}

	/**
	 * Find all email .txt templates in phpBB core and extensions
	 *
	 * @return array
	 */
	public function find_all(): array
	{
		$templates = [];

		// 1. Scan phpBB Core language directories
		$core_lang_dir = $this->phpbb_root_path . 'language/';
		if (is_dir($core_lang_dir))
		{
			foreach (scandir($core_lang_dir) as $lang)
			{
				if ($lang !== '.' && $lang !== '..' && is_dir($core_lang_dir . $lang))
				{
					$email_dir = $core_lang_dir . $lang . '/email/';
					if (is_dir($email_dir))
					{
						$files = $this->scan_email_dir($email_dir);
						foreach ($files as $file)
						{
							$templates[] = [
								'id'       => md5('core_' . $lang . '_' . $file),
								'origin'   => 'Core',
								'lang'     => $lang,
								'filename' => $file,
								'path'     => 'language/' . $lang . '/email/' . $file,
								'absolute' => $email_dir . $file,
							];
						}
					}
				}
			}
		}

		// 2. Scan Extensions language directories
		$ext_dir = $this->phpbb_root_path . 'ext/';
		if (is_dir($ext_dir))
		{
			foreach (scandir($ext_dir) as $vendor)
			{
				if ($vendor !== '.' && $vendor !== '..' && is_dir($ext_dir . $vendor))
				{
					foreach (scandir($ext_dir . $vendor) as $ext)
					{
						if ($ext !== '.' && $ext !== '..' && is_dir($ext_dir . $vendor . '/' . $ext))
						{
							$ext_lang_dir = $ext_dir . $vendor . '/' . $ext . '/language/';
							if (is_dir($ext_lang_dir))
							{
								foreach (scandir($ext_lang_dir) as $lang)
								{
									if ($lang !== '.' && $lang !== '..' && is_dir($ext_lang_dir . $lang))
									{
										$email_dir = $ext_lang_dir . $lang . '/email/';
										if (is_dir($email_dir))
										{
											$files = $this->scan_email_dir($email_dir);
											foreach ($files as $file)
											{
												$templates[] = [
													'id'       => md5($vendor . '_' . $ext . '_' . $lang . '_' . $file),
													'origin'   => $vendor . '/' . $ext,
													'lang'     => $lang,
													'filename' => $file,
													'path'     => 'ext/' . $vendor . '/' . $ext . '/language/' . $lang . '/email/' . $file,
													'absolute' => $email_dir . $file,
												];
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

		return $templates;
	}

	protected function scan_email_dir(string $dir): array
	{
		$files = [];
		foreach (scandir($dir) as $file)
		{
			if ($file !== '.' && $file !== '..' && !is_dir($dir . $file) && substr($file, -4) === '.txt')
			{
				$files[] = $file;
			}
		}
		return $files;
	}
}
