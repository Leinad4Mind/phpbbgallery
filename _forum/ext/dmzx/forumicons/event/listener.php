<?php
/**
 *
 * @package phpBB Extension - Forum Icons
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @license https://opensource.org/license/gpl-2-0 GNU General Public License v2
 *
 */

namespace dmzx\forumicons\event;

use phpbb\language\language;
use phpbb\template\template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	const MAX_DIRECTORY_ENTRIES = 5000;
	const MAX_ICONS = 500;

	/** @var template */
	protected $template;

	/** @var language */
	protected $language;

	/** @var string phpBB root path */
	protected $phpbb_root_path;

	/**
	 * Constructor.
	 *
	 * @param template $template        Template service
	 * @param language $language        Language service
	 * @param string   $phpbb_root_path phpBB root path
	 */
	public function __construct(template $template, language $language, $phpbb_root_path)
	{
		$this->template = $template;
		$this->language = $language;
		$this->phpbb_root_path = $phpbb_root_path;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.acp_manage_forums_display_form' => 'acp_manage_forums_display_form',
		];
	}

	/**
	 * Add the forum icon selector to the ACP forum form.
	 *
	 * @param \phpbb\event\data $event Event data
	 */
	public function acp_manage_forums_display_form($event)
	{
		$this->language->add_lang('acp/info_acp_forumicons', 'dmzx/forumicons');

		list($icons, $directory_available, $limit_reached) = $this->find_icons();
		$this->template->destroy_block_vars('forum_img_file_name');

		if ($icons)
		{
			$this->template->assign_block_vars_array('forum_img_file_name', $icons);
		}

		$template_data = $event['template_data'];
		$template_data['FORUMICONS_ACP'] = true;
		$template_data['FORUMICONS_DIRECTORY_AVAILABLE'] = $directory_available;
		$template_data['FORUMICONS_LIMIT_REACHED'] = $limit_reached;
		$event['template_data'] = $template_data;
	}

	/**
	 * Return safe icon metadata from the forum icon directory.
	 *
	 * @return array Array containing icon rows, directory status and limit status
	 */
	protected function find_icons()
	{
		$directory = $this->phpbb_root_path . 'images/forumicons';

		if (!is_dir($directory) || !is_readable($directory))
		{
			return [[], false, false];
		}

		$filenames = [];
		$entries_scanned = 0;
		$limit_reached = false;

		try
		{
			$iterator = new \FilesystemIterator($directory, \FilesystemIterator::SKIP_DOTS);

			foreach ($iterator as $file)
			{
				$entries_scanned++;
				if ($entries_scanned > self::MAX_DIRECTORY_ENTRIES)
				{
					$limit_reached = true;
					break;
				}

				if ($file->isLink() || !$file->isFile())
				{
					continue;
				}

				$filename = $file->getFilename();
				if (preg_match('//u', $filename) !== 1 || preg_match('/[\x00-\x1F\x7F]/u', $filename))
				{
					continue;
				}

				$extension = strtolower($file->getExtension());
				if (!in_array($extension, ['gif', 'png'], true))
				{
					continue;
				}

				$filenames[] = $filename;
			}
		}
		catch (\UnexpectedValueException $exception)
		{
			return [[], false, false];
		}

		usort($filenames, 'strnatcasecmp');

		if (count($filenames) > self::MAX_ICONS)
		{
			$filenames = array_slice($filenames, 0, self::MAX_ICONS);
			$limit_reached = true;
		}

		$icons = [];
		foreach ($filenames as $filename)
		{
			$relative_path = 'images/forumicons/' . $filename;
			$icons[] = [
				'FORUM_IMAGE_NAME' => $filename,
				'FORUM_IMAGE_PATH' => $relative_path,
				'FORUM_IMAGE_URL'  => $this->phpbb_root_path . 'images/forumicons/' . rawurlencode($filename),
			];
		}

		return [$icons, true, $limit_reached];
	}
}
