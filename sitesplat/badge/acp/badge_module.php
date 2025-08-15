<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\acp;

class badge_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container, $request, $config, $phpbb_extension_manager, $template, $user, $phpbb_root_path;

		// Add the badge ACP lang file
		$user->add_lang_ext('sitesplat/badge', 'badge_acp');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('sitesplat.badge.admin_controller');

		// Requests
		$action = $request->variable('action', '');
		$rule_id = $request->variable('rule_id', 0);

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		// Load a template from adm/style
		$this->tpl_name = 'manage_badge';

		// Set the page title
		$this->page_title = $user->lang('ACP_BADGE_MANAGE');

		// Quick-submit settings from the general options form
		if ($request->is_set_post('generalsubmit'))
		{
			$admin_controller->submit_badge_options();
		}

		$admin_controller->check_ext();


		// Perform any actions submitted by the user
		switch ($action)
		{
			case 'details':
				$user->add_lang(array('install', 'acp/extensions', 'migrator'));
				$ext_name = 'sitesplat/badge';
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
			break;
			
			case 'add':
			case 'edit':
				// Set the page title
				$this->page_title = $user->lang(strtoupper("ACP_BADGE_$action"));

				// Load the save badge rule handle in the admin controller
				$admin_controller->save_badge_rule($rule_id);

				// Return to stop execution of this script
				return;
			break;

			case 'sync':
				// Resync badge rule check against all users
				$admin_controller->resync_badge_rule($rule_id);
			break;

			case 'delete':
				// Use a confirm box routine when deleting an badge rule
				if (confirm_box(true))
				{
					// Delete badge rule on confirmation from the user
					$admin_controller->delete_badge_rule($rule_id);
				}
				else
				{
					// Request confirmation from the user to delete badge rule
					confirm_box(false, $user->lang('ACP_BADGE_DELETE_CONFIRM'), build_hidden_fields(array(
						'rule_id'		=> $rule_id,
						'mode'			=> $mode,
						'action'		=> $action,
					)));
				}
			break;
		}

		// Display badge rules
		$admin_controller->display_badge_rules();
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

		if (version_compare($config['version'], '1.0.1', '>'))
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
