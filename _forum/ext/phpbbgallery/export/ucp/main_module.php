<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\export\ucp;

use phpbbgallery\export\job_storage;

class main_module
{
	/** @var string Template file to render */
	public string $tpl_name = '';

	/** @var string Page title */
	public string $page_title = '';

	/** @var string URL of this module */
	public string $u_action = '';

	/**
	 * Let a member take a copy of the images they uploaded.
	 *
	 * @param string $id   Module identifier
	 * @param string $mode Module mode
	 * @return void
	 */
	public function main(string $id, string $mode): void
	{
		global $request, $template, $user, $phpbb_container;

		$language = $phpbb_container->get('language');
		$language->add_lang(['gallery', 'gallery_zip'], 'phpbbgallery/core');
		$language->add_lang(['info_export', 'info_ucp_gallery_export'], 'phpbbgallery/export');

		$this->tpl_name = 'gallery/ucp_gallery_export';
		$this->page_title = $language->lang('UCP_GALLERY_EXPORT');
		add_form_key('ucp_gallery');

		$storage = $phpbb_container->get('phpbbgallery.export.storage');
		$runner = $phpbb_container->get('phpbbgallery.export.runner');
		$controller_helper = $phpbb_container->get('controller.helper');

		$user_id = (int) $user->data['user_id'];

		if (!$runner->is_ucp_enabled())
		{
			trigger_error($language->lang('EXPORT_UCP_DISABLED'));
			return;
		}

		$job_id = $request->variable('job_id', '');
		if ($job_id !== '')
		{
			$this->run_batch($job_id, $user_id, $storage, $runner, $language);
			return;
		}

		if ($request->is_set_post('start_export'))
		{
			$this->start_job($user_id, $runner, $language);
		}

		if ($request->is_set_post('delete_job'))
		{
			$this->delete_job($user_id, $storage, $language);
		}

		foreach ($storage->list_for_owner($user_id) as $state)
		{
			$is_ready = $state['status'] === job_storage::STATUS_READY;

			$template->assign_block_vars('jobrow', [
				'JOB_ID'		=> $state['job_id'],
				'CREATED'		=> $user->format_date($state['created']),
				'DONE'			=> $state['done'],
				'TOTAL'			=> $state['total'],
				'SIZE'			=> get_formatted_filesize($state['bytes']),
				'ERRORS'		=> count($state['errors']),
				'STATUS'		=> $is_ready ? $language->lang('EXPORT_STATUS_READY') : $language->lang('EXPORT_STATUS_RUNNING'),

				'S_READY'		=> $is_ready,

				'U_DOWNLOAD'	=> $is_ready ? $controller_helper->route('phpbbgallery_export_download', ['job_id' => $state['job_id']]) : '',
				'U_CONTINUE'	=> !$is_ready ? $this->u_action . '&amp;job_id=' . $state['job_id'] : '',
			]);
		}

		$template->assign_vars([
			'S_EXPORT_IMAGES'	=> true,
			'S_UCP_ACTION'		=> $this->u_action,

			'L_TITLE'			=> $language->lang('UCP_GALLERY_EXPORT'),
			'L_TITLE_EXPLAIN'	=> $language->lang('EXPORT_UCP_EXPLAIN', $runner->get_max_images(job_storage::SCOPE_UCP)),
		]);
	}

	/**
	 * Add the next batch of images to a running job.
	 *
	 * @param string                           $job_id   Job identifier
	 * @param int                              $user_id  Member running the export
	 * @param \phpbbgallery\export\job_storage $storage  Job storage
	 * @param \phpbbgallery\export\runner      $runner   Export runner
	 * @param \phpbb\language\language         $language Language object
	 * @return void
	 */
	protected function run_batch(string $job_id, int $user_id, job_storage $storage, \phpbbgallery\export\runner $runner, \phpbb\language\language $language): void
	{
		$state = $storage->read_state($job_id);

		// One member may never drive, or even see, another member's export.
		if ($state === false || $state['owner_id'] !== $user_id)
		{
			trigger_error($language->lang('EXPORT_JOB_NOT_FOUND') . '<br /><br />'
				. $language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>'), E_USER_WARNING);
			return;
		}

		$result = $runner->step($state);
		if (isset($result['error']))
		{
			trigger_error($result['error'] . '<br /><br />'
				. $language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>'), E_USER_WARNING);
			return;
		}

		$state = $result['state'];

		if ($state['status'] === job_storage::STATUS_READY)
		{
			meta_refresh(3, $this->u_action);
			trigger_error($language->lang('EXPORT_FINISHED', $state['total']) . '<br /><br />'
				. $language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>'));
			return;
		}

		meta_refresh(1, $this->u_action . '&amp;job_id=' . $state['job_id']);
		trigger_error($language->lang('EXPORT_PROGRESS', $state['done'], $state['total']));
	}

	/**
	 * Open a job covering the member's own uploads.
	 *
	 * @param int                         $user_id  Member running the export
	 * @param \phpbbgallery\export\runner $runner   Export runner
	 * @param \phpbb\language\language    $language Language object
	 * @return void
	 */
	protected function start_job(int $user_id, \phpbbgallery\export\runner $runner, \phpbb\language\language $language): void
	{
		global $phpbb_container;

		if (!check_form_key('ucp_gallery'))
		{
			trigger_error('FORM_INVALID');
			return;
		}

		$export = $phpbb_container->get('phpbbgallery.export');
		$selection = $export->resolve_own_images($user_id);

		$result = $runner->create($user_id, job_storage::SCOPE_UCP, job_storage::DELIVERY_DOWNLOAD, [], $selection);
		if (isset($result['error']))
		{
			trigger_error($result['error'] . '<br /><br />'
				. $language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>'), E_USER_WARNING);
			return;
		}

		meta_refresh(2, $this->u_action . '&amp;job_id=' . $result['state']['job_id']);
		trigger_error($language->lang('EXPORT_STARTED', $result['state']['total']));
	}

	/**
	 * Remove one of the member's own exports.
	 *
	 * @param int                              $user_id  Member running the export
	 * @param \phpbbgallery\export\job_storage $storage  Job storage
	 * @param \phpbb\language\language         $language Language object
	 * @return void
	 */
	protected function delete_job(int $user_id, job_storage $storage, \phpbb\language\language $language): void
	{
		global $request;

		if (!check_form_key('ucp_gallery'))
		{
			trigger_error('FORM_INVALID');
			return;
		}

		$state = $storage->read_state($request->variable('job_id_delete', ''));
		if ($state === false || $state['owner_id'] !== $user_id || !$storage->remove_job($state))
		{
			trigger_error($language->lang('EXPORT_JOB_NOT_FOUND') . '<br /><br />'
				. $language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>'), E_USER_WARNING);
			return;
		}

		meta_refresh(3, $this->u_action);
		trigger_error($language->lang('EXPORT_JOB_DELETED') . '<br /><br />'
			. $language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>'));
	}
}
