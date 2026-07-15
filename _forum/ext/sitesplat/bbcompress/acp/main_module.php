<?php
/**
*
* BBcompress
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbcompress\acp;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache, $request;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$user->add_lang('acp/common');
		$this->tpl_name = 'bbcompress';
		$this->page_title = $user->lang('ACP_BBCOMPRESS_TITLE');
		add_form_key('sitesplat/bbcompress');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('sitesplat/bbcompress'))
			{
				trigger_error('FORM_INVALID');
			}

			$driver = $request->variable('bbcompress_driver', '');

			$config->set('bbcompress_allowed_posts', $request->variable('bbcompress_allowed_posts', 0));
			$config->set('bbcompress_allowed_avatars', $request->variable('bbcompress_allowed_avatars', 0));
			$config->set('bbcompress_driver', $driver);

			switch($driver)
			{
				case 'Kraken':

					$config->set('kraken_api_key', $request->variable('kraken_api_key', ''));
					$config->set('kraken_api_secret', $request->variable('kraken_api_secret', ''));

					$kraken = new \Kraken($config['kraken_api_key'], $config['kraken_api_secret']);
					$data = $kraken->status();

					if ($data['success'])
					{
						if (!$data['active'])
						{
							trigger_error($user->lang('ACP_KRAKEN_INACTIVE') . adm_back_link($this->u_action), E_USER_WARNING);
						}
					}
					else
					{
						trigger_error($user->lang('ACP_KRAKEN_API_KEY_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}

				break;

				case 'PHP':
				break;

				case 'TinyPNG':

					$config->set('tinify_api_key', $request->variable('tinify_api_key', ''));
					$config->set('tinify_resize', $request->variable('tinify_resize', ''));
					$config->set('tinify_width', $request->variable('tinify_width', 0));
					$config->set('tinify_height', $request->variable('tinify_height', 0));

					try
					{
						\Tinify\setKey($request->variable('tinify_api_key', ''));
						\Tinify\validate();
					}
					catch(\Tinify\Exception $e)
					{
						trigger_error($user->lang('ACP_TINIFY_API_KEY_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}

				break;

				case 'ImageOptim':

					$config->set('imageoptim_username', $request->variable('imageoptim_username', ''));

				break;
			}

			trigger_error($user->lang('ACP_BBCOMPRESS_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		// load optimizer drivers
		$drivers = array();
		foreach(array_diff(scandir($phpbb_root_path . 'ext/sitesplat/bbcompress/optimizers/driver'), array('..', '.', 'driver_interface.php')) as $class_name)
		{
			$class_name = substr($class_name, 0, -4);
			if (in_array('sitesplat\bbcompress\optimizers\driver\driver_interface', class_implements('\sitesplat\bbcompress\optimizers\driver\\' . $class_name)))
			{
				$template->assign_block_vars('optimizer_drivers', array(
					'NAME'	=> $class_name,
				));
			}
		}

		$template->assign_vars(array(
			'U_ACTION'						=> $this->u_action,
			'BBCOMPRESS_INSTRUCTIONS'		=> $user->lang('ACP_BBCOMPRESS_SETTINGS_EXPLAIN', get_formatted_filesize($config['bbcompress_saved_storage'])),
			'BBCOMPRESS_ALLOWED_POSTS'		=> $config['bbcompress_allowed_posts'],
			'BBCOMPRESS_ALLOWED_AVATARS'	=> $config['bbcompress_allowed_avatars'],
			'BBCOMPRESS_DRIVER'				=> $config['bbcompress_driver'],
			'TINIFY_API_KEY'				=> $config['tinify_api_key'],
			'TINIFY_RESIZE'					=> $config['tinify_resize'],
			'TINIFY_WIDTH'					=> $config['tinify_width'],
			'TINIFY_HEIGHT'					=> $config['tinify_height'],
			'KRAKEN_API_KEY'				=> $config['kraken_api_key'],
			'KRAKEN_API_SECRET'				=> $config['kraken_api_secret'],
			'IMAGEOPTIM_USERNAME'			=> $config['imageoptim_username'],
		));
	}
}
