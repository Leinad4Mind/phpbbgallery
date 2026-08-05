<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\acp;

use phpbb\request\request_interface;

class main_module
{
	private const FIELD_LIMITS = [
		'endpoint' => 255,
		'bucket' => 63,
		'access_key' => 255,
		'secret_key' => 255,
		'region' => 64,
		'prefix' => 255,
	];

	public string $u_action = '';
	public string $tpl_name = '';
	public string $page_title = '';

	public function main(string $id, string $mode): void
	{
		global $config, $request, $template, $user, $phpbb_container;

		$user->add_lang_ext('phpbbgallery/remotestorage', 'info_acp_remotestorage');
		$this->tpl_name = 'remotestorage_settings';
		$this->page_title = 'ACP_GALLERY_REMOTE_STORAGE';
		add_form_key('acp_gallery_remote_storage');
		$factory = $phpbb_container->get('phpbbgallery.remotestorage.s3.builder');
		$connection_tester = $phpbb_container->get('phpbbgallery.remotestorage.connection_tester');

		if ($request->is_set_post('save'))
		{
			if (!check_form_key('acp_gallery_remote_storage'))
			{
				trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$settings = [];
			try
			{
				$settings = $this->submitted_settings($request, $config);
				$connection_tester->test($factory->create_from($settings));
			}
			catch (\Throwable $exception)
			{
				trigger_error(
					$user->lang('REMOTE_STORAGE_CONNECTION_FAILED', $exception->getMessage())
					. adm_back_link($this->u_action),
					E_USER_WARNING
				);
			}

			foreach ($settings as $field => $value)
			{
				$config->set('phpbb_gallery_s3_' . $field, $value);
			}
			trigger_error($user->lang('REMOTE_STORAGE_SETTINGS_SAVED') . adm_back_link($this->u_action));
		}

		foreach ($factory->environment_overrides() as $field)
		{
			$template->assign_block_vars('environment_overrides', [
				'NAME' => 'PHPBBGALLERY_S3_' . strtoupper($field),
			]);
		}
		$template->assign_vars([
			'U_ACTION' => $this->u_action,
			'ACTIVE_PROVIDER' => (string) ($config['phpbb_gallery_storage_provider'] ?? 'local'),
			'S3_ENDPOINT' => (string) ($config['phpbb_gallery_s3_endpoint'] ?? ''),
			'S3_BUCKET' => (string) ($config['phpbb_gallery_s3_bucket'] ?? ''),
			'S3_ACCESS_KEY' => (string) ($config['phpbb_gallery_s3_access_key'] ?? ''),
			'S3_REGION' => (string) ($config['phpbb_gallery_s3_region'] ?? 'us-east-1'),
			'S3_PREFIX' => (string) ($config['phpbb_gallery_s3_prefix'] ?? 'phpbbgallery'),
			'S_SECRET_CONFIGURED' => (string) ($config['phpbb_gallery_s3_secret_key'] ?? '') !== ''
				|| in_array('secret_key', $factory->environment_overrides(), true),
		]);
	}

	/** @return array<string, string> */
	private function submitted_settings(request_interface $request, \ArrayAccess $config): array
	{
		$settings = [];
		foreach (self::FIELD_LIMITS as $field => $limit)
		{
			$value = trim($request->variable($field, '', true, request_interface::POST));
			if ($field === 'secret_key' && $value === '')
			{
				$value = (string) ($config['phpbb_gallery_s3_secret_key'] ?? '');
			}
			if (strlen($value) > $limit)
			{
				throw new \RuntimeException('The submitted S3 ' . $field . ' value is too long.');
			}
			$settings[$field] = $value;
		}

		return $settings;
	}
}
