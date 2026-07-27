<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\export\acp;

use phpbbgallery\export\job_storage;

class main_module
{
	/** @var string URL of this module */
	public string $u_action = '';

	/** @var string Template file to render */
	public string $tpl_name = '';

	/** @var string Page title */
	public string $page_title = '';

	/**
	 * Export the gallery images to a ZIP archive.
	 *
	 * @param string $id   Module identifier
	 * @param string $mode Module mode
	 * @return void
	 */
	public function main(string $id, string $mode): void
	{
		global $request, $user, $phpbb_container;

		$language = $phpbb_container->get('language');
		$language->add_lang(['gallery_acp', 'gallery', 'gallery_zip'], 'phpbbgallery/core');
		$language->add_lang(['info_export', 'info_acp_gallery_export'], 'phpbbgallery/export');

		$this->tpl_name = 'gallery_export';
		$this->page_title = $language->lang('ACP_GALLERY_EXPORT');
		add_form_key('acp_gallery');

		$storage = $phpbb_container->get('phpbbgallery.export.storage');
		$runner = $phpbb_container->get('phpbbgallery.export.runner');

		$user_id = (int) $user->data['user_id'];

		// A job already under way carries its identifier in the URL, the way the
		// importer carries its schema, and continues one batch per request.
		$job_id = $request->variable('job_id', '');
		if ($job_id !== '')
		{
			$this->run_batch($job_id, $user_id, $storage, $runner, $language);
			return;
		}

		if ($request->is_set_post('delete_job'))
		{
			$this->delete_job($storage, $language);
		}

		if ($request->is_set_post('submit'))
		{
			$this->start_job($user_id, $runner, $language);
		}

		$this->display_form($storage, $runner, $language);
	}

	/**
	 * Add the next batch of images to a running job.
	 *
	 * @param string                           $job_id   Job identifier
	 * @param int                              $user_id  Administrator running the export
	 * @param \phpbbgallery\export\job_storage $storage  Job storage
	 * @param \phpbbgallery\export\runner      $runner   Export runner
	 * @param \phpbb\language\language         $language Language object
	 * @return void
	 */
	protected function run_batch(string $job_id, int $user_id, job_storage $storage, \phpbbgallery\export\runner $runner, \phpbb\language\language $language): void
	{
		$state = $storage->read_state($job_id);

		// The identifier alone proves nothing: the job has to belong to whoever is
		// holding it.
		if ($state === false || $state['owner_id'] !== $user_id)
		{
			trigger_error($language->lang('EXPORT_JOB_NOT_FOUND') . adm_back_link($this->u_action), E_USER_WARNING);
			return;
		}

		$result = $runner->step($state);
		if (isset($result['error']))
		{
			trigger_error($result['error'] . adm_back_link($this->u_action), E_USER_WARNING);
			return;
		}

		$state = $result['state'];

		if ($state['status'] === job_storage::STATUS_READY)
		{
			$message = $language->lang('EXPORT_FINISHED', $state['total']);
			if (!empty($state['errors']))
			{
				$message .= '<br /><br />' . implode('<br />', $state['errors']);
			}

			trigger_error($message . adm_back_link($this->u_action), empty($state['errors']) ? E_USER_NOTICE : E_USER_WARNING);
			return;
		}

		meta_refresh(1, $this->u_action . '&amp;job_id=' . $state['job_id']);
		trigger_error($language->lang('EXPORT_PROGRESS', $state['done'], $state['total']));
	}

	/**
	 * Validate the submitted selection and open a job for it.
	 *
	 * @param int                         $user_id  Administrator running the export
	 * @param \phpbbgallery\export\runner $runner   Export runner
	 * @param \phpbb\language\language    $language Language object
	 * @return void
	 */
	protected function start_job(int $user_id, \phpbbgallery\export\runner $runner, \phpbb\language\language $language): void
	{
		global $request, $phpbb_container;

		if (!check_form_key('acp_gallery'))
		{
			trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			return;
		}

		$export = $phpbb_container->get('phpbbgallery.export');

		$album_ids = $request->variable('album_ids', [0]);
		if ($request->variable('export_all', 0))
		{
			$album_ids = [];
		}

		$delivery = $request->variable('delivery', '') === job_storage::DELIVERY_SERVER
			? job_storage::DELIVERY_SERVER
			: job_storage::DELIVERY_DOWNLOAD;

		$selection = $export->resolve_admin_selection($album_ids);

		// A single album gives the archive a name an administrator can recognise in
		// a directory listing; anything wider stays generic.
		$label = count($album_ids) === 1 ? $export->get_album_name((int) reset($album_ids)) : '';

		$result = $runner->create($user_id, job_storage::SCOPE_ACP, $delivery, $album_ids, $selection, $label);
		if (isset($result['error']))
		{
			trigger_error($result['error'] . adm_back_link($this->u_action), E_USER_WARNING);
			return;
		}

		meta_refresh(2, $this->u_action . '&amp;job_id=' . $result['state']['job_id']);
		trigger_error($language->lang('EXPORT_STARTED', $result['state']['total']));
	}

	/**
	 * Remove a finished export and its archive.
	 *
	 * @param \phpbbgallery\export\job_storage $storage  Job storage
	 * @param \phpbb\language\language         $language Language object
	 * @return void
	 */
	protected function delete_job(job_storage $storage, \phpbb\language\language $language): void
	{
		global $request;

		if (!check_form_key('acp_gallery'))
		{
			trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			return;
		}

		$job_id = $request->variable('job_id_delete', '');
		$state = $storage->read_state($job_id);
		if ($state === false || !$storage->remove_job($state))
		{
			trigger_error($language->lang('EXPORT_JOB_NOT_FOUND') . adm_back_link($this->u_action), E_USER_WARNING);
			return;
		}

		trigger_error($language->lang('EXPORT_JOB_DELETED') . adm_back_link($this->u_action));
	}

	/**
	 * Render the selection form and the jobs that already exist.
	 *
	 * @param \phpbbgallery\export\job_storage $storage  Job storage
	 * @param \phpbbgallery\export\runner      $runner   Export runner
	 * @param \phpbb\language\language         $language Language object
	 * @return void
	 */
	protected function display_form(job_storage $storage, \phpbbgallery\export\runner $runner, \phpbb\language\language $language): void
	{
		global $config, $template, $user, $phpbb_container;

		$gallery_album = $phpbb_container->get('phpbbgallery.core.album');
		$controller_helper = $phpbb_container->get('controller.helper');

		foreach ($storage->all_jobs() as $state)
		{
			$is_ready = $state['status'] === job_storage::STATUS_READY;
			$is_server = $state['delivery'] === job_storage::DELIVERY_SERVER;

			$template->assign_block_vars('jobrow', [
				'JOB_ID'		=> $state['job_id'],
				'CREATED'		=> $user->format_date($state['created']),
				'DONE'			=> $state['done'],
				'TOTAL'			=> $state['total'],
				'SIZE'			=> get_formatted_filesize($state['bytes']),
				'ARCHIVE'		=> $state['archive'],
				'SERVER_PATH'	=> 'files/phpbbgallery/export/' . $state['archive'],
				'ERRORS'		=> count($state['errors']),
				'STATUS'		=> $is_ready ? $language->lang('EXPORT_STATUS_READY') : $language->lang('EXPORT_STATUS_RUNNING'),

				'S_READY'		=> $is_ready,
				'S_SERVER'		=> $is_server,
				'S_OWN'			=> $state['owner_id'] === (int) $user->data['user_id'],

				'U_DOWNLOAD'	=> ($is_ready && !$is_server) ? $controller_helper->route('phpbbgallery_export_download', ['job_id' => $state['job_id']]) : '',
				'U_CONTINUE'	=> !$is_ready ? $this->u_action . '&amp;job_id=' . $state['job_id'] : '',
			]);
		}

		$template->assign_vars([
			'U_ACTION'				=> $this->u_action,
			'S_ALBUM_OPTIONS'		=> $gallery_album->get_albumbox(false, false, false, 'a_list'),

			'EXPORT_MAX_IMAGES'		=> $runner->get_max_images(job_storage::SCOPE_ACP),
			'EXPORT_MAX_SIZE'		=> get_formatted_filesize((int) $config['phpbb_gallery_export_max_bytes']),
			'EXPORT_BATCH_SIZE'		=> $runner->get_batch_size(),
			'EXPORT_SERVER_PATH'	=> 'files/phpbbgallery/export/',
		]);
	}
}
