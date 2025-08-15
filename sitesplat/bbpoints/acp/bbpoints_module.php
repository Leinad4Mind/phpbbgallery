<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbpoints\acp;

class bbpoints_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container, $request, $user, $config, $phpbb_extension_manager, $template, $phpbb_root_path;

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('sitesplat.bbpoints.admin_controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		// Load a template from adm/style for our ACP auto groups
		$this->tpl_name = 'manage_bbpoints';

		// Set the page title for our ACP bbpoints
		$this->page_title = $user->lang('ACP_POINTS_INDEX_TITLE');

		if ($request->is_set_post('reset_points'))
		{
			if (confirm_box(true))
			{
				$admin_controller->reset_points();
			} else
			{
				// Request confirmation from the user to reset point
				confirm_box(false, $user->lang('RESET_POINTS_CONFIRM'), build_hidden_fields(array(
					'i'				=> $id,
					'mode'			=> $mode,
					'reset_points'	=> true,
				)));
			}
		}

		if ($request->is_set_post('sync_points') || $request->variable('action', '') == 'progressbar')
		{
			if ($request->variable('skiprows', 0) == 0)
			{
				$config->set('search_indexing_state', 0, true);
				$admin_controller->sync_points();
				$admin_controller->sync_post();
			} else
			{
				$admin_controller->sync_post();
			}
		}

		// Quick-submit settings from the general options form
		if ($request->is_set_post('set_config'))
		{
			if (($request->variable('group_id', 0) > 0 || $request->variable('transfer_to', 0) > 0 )&& $request->variable('transfer_amount', 0) != 0)
			{
				$admin_controller->transfer_amount();
			}
		
			$admin_controller->submit_config_options();
		}

		if ($request->variable('action', '') == 'details')
		{
			$user->add_lang(array('install', 'acp/extensions', 'migrator'));
			$ext_name = 'sitesplat/bbpoints';
			$md_manager = new \phpbb\extension\metadata_manager($ext_name, $config, $phpbb_extension_manager, $template, $user, $phpbb_root_path);
			try
			{
				$this->metadata = $md_manager->get_metadata('all');
			}
			catch(\phpbb\extension\exception $e)
			{
				trigger_error($e, E_USER_WARNING);
			}

			$md_manager->output_template_data();

			try
			{
				$updates_available = $this->version_check($md_manager, $request->variable('versioncheck_force', false));

				$template->assign_vars(array(
					'S_UP_TO_DATE'		=> empty($updates_available),
					'S_VERSIONCHECK'	=> true,
					'UP_TO_DATE_MSG'	=> $user->lang(empty($updates_available) ? 'UP_TO_DATE' : 'NOT_UP_TO_DATE', $md_manager->get_metadata('display-name')),
				));

				foreach ($updates_available as $branch => $version_data)
				{
					$template->assign_block_vars('updates_available', $version_data);
				}
			}
			catch (\RuntimeException $e)
			{
				$template->assign_vars(array(
					'S_VERSIONCHECK_STATUS'			=> $e->getCode(),
					'VERSIONCHECK_FAIL_REASON'		=> ($e->getMessage() !== $user->lang('VERSIONCHECK_FAIL')) ? $e->getMessage() : '',
				));
			}

			if ($request->is_ajax())
			{
				$template->assign_vars(array(
					'IS_AJAX'				=> true,
				));
			}
			else
			{
				$template->assign_vars(array(
					'U_BACK'				=> $this->u_action,
				));
			}

			$this->tpl_name = 'acp_ext_details';
		}

		// Display setup
		$admin_controller->display();
	}

	/**
	* Check the version and return the available updates.
	*
	* @param \phpbb\extension\metadata_manager $md_manager The metadata manager for the version to check.
	* @param bool $force_update Ignores cached data. Defaults to false.
	* @param bool $force_cache Force the use of the cache. Override $force_update.
	* @return string
	* @throws RuntimeException
	*/
	protected function version_check(\phpbb\extension\metadata_manager $md_manager, $force_update = false, $force_cache = false)
	{
		global $cache, $config, $user;
		$meta = $md_manager->get_metadata('all');

		if (!isset($meta['extra']['version-check']))
		{
			throw new \RuntimeException($this->user->lang('NO_VERSIONCHECK'), 1);
		}

		$version_check = $meta['extra']['version-check'];

		if (version_compare($config['version'], '1.0.0', '>'))
		{
			$version_helper = new \phpbb\version_helper($cache, $config, new \phpbb\file_downloader(), $user);
		}
		else
		{
			$version_helper = new \phpbb\version_helper($cache, $config, $user);
		}
		$version_helper->set_current_version($meta['version']);
		$version_helper->set_file_location($version_check['host'], $version_check['directory'], $version_check['filename']);
		$version_helper->force_stability($config['extension_force_unstable'] ? 'unstable' : null);

		return $updates = $version_helper->get_suggested_updates($force_update, $force_cache);
	}
}
