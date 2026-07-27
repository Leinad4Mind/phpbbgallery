<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\export\controller;

use phpbbgallery\export\archive;
use phpbbgallery\export\job_storage;

/**
 * Hand a finished archive to the member who asked for it.
 *
 * The export directory is closed to the web server, so this is the only way an
 * archive leaves the board, and every request through it is checked again: a job
 * identifier is not a capability.
 */
class download
{
	/** @var \phpbb\auth\auth */
	protected \phpbb\auth\auth $auth;

	/** @var \phpbb\language\language */
	protected \phpbb\language\language $language;

	/** @var \phpbb\user */
	protected \phpbb\user $user;

	/** @var \phpbbgallery\core\file\file */
	protected \phpbbgallery\core\file\file $tool;

	/** @var \phpbbgallery\export\job_storage */
	protected job_storage $storage;

	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth                 $auth     Auth object
	 * @param \phpbb\language\language         $language Language object
	 * @param \phpbb\user                      $user     User object
	 * @param \phpbbgallery\core\file\file     $tool     Gallery file tool
	 * @param \phpbbgallery\export\job_storage $storage  Job storage
	 */
	public function __construct(\phpbb\auth\auth $auth, \phpbb\language\language $language, \phpbb\user $user,
		\phpbbgallery\core\file\file $tool, job_storage $storage)
	{
		$this->auth = $auth;
		$this->language = $language;
		$this->user = $user;
		$this->tool = $tool;
		$this->storage = $storage;
	}

	/**
	 * Export Download Controller
	 *	Route: gallery/export/{job_id}/download
	 *
	 * @param string $job_id Job identifier
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse A Symfony Response object
	 * @throws \phpbb\exception\http_exception
	 */
	public function download(string $job_id): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		$this->language->add_lang('info_export', 'phpbbgallery/export');

		$state = $this->storage->read_state($job_id);
		if ($state === false || $state['status'] !== job_storage::STATUS_READY)
		{
			throw new \phpbb\exception\http_exception(404, 'EXPORT_JOB_NOT_FOUND');
		}

		// An export always belongs to a real account: guests never start one, so a
		// guest can never be the owner of one either.
		$is_owner = $this->user->data['is_registered'] && (int) $this->user->data['user_id'] === $state['owner_id'];
		if (!$is_owner && !$this->auth->acl_get('a_gallery_export'))
		{
			throw new \phpbb\exception\http_exception(403, 'NOT_AUTHORISED');
		}

		$archive_path = $this->storage->get_archive_path($state);
		if ($archive_path === false || !is_file($archive_path))
		{
			throw new \phpbb\exception\http_exception(404, 'EXPORT_ARCHIVE_MISSING');
		}

		$response = new \Symfony\Component\HttpFoundation\BinaryFileResponse($archive_path);
		$response->headers->set('Content-Type', 'application/zip');
		$response->headers->set('X-Content-Type-Options', 'nosniff');
		$response->headers->set('X-Download-Options', 'noopen');
		// The stored name is an opaque job id; the member gets a dated one instead.
		$response->headers->set('Content-Disposition', 'attachment; ' . $this->tool->header_filename(archive::server_archive_name('', $state['created'])));

		return $response;
	}
}
