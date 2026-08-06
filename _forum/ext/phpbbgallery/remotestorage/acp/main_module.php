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
use phpbbgallery\remotestorage\configured_provider_factory_interface;
use phpbbgallery\remotestorage\rotating_credentials_factory_interface;

class main_module
{
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
		$providers = $phpbb_container->get('phpbbgallery.remotestorage.migration.provider_resolver');
		$connection_tester = $phpbb_container->get('phpbbgallery.remotestorage.connection_tester');
		$migrator = $phpbb_container->get('phpbbgallery.remotestorage.migration.provider_migrator');
		$state = $migrator->state();

		if ($request->is_set_post('start_migration'))
		{
			$this->require_form_key($user);
			$active_provider = (string) ($config['phpbb_gallery_storage_provider'] ?? 'local');
			$target_provider = strtolower(trim($request->variable('target_provider', '', false, request_interface::POST)));
			$allowed_targets = array_merge(['local'], $providers->remote_provider_ids());
			if ($target_provider === '' || $target_provider === $active_provider
				|| !in_array($target_provider, $allowed_targets, true))
			{
				trigger_error($user->lang('REMOTE_STORAGE_MIGRATION_TARGET_INVALID')
					. adm_back_link($this->u_action), E_USER_WARNING);
			}
			if (!confirm_box(true))
			{
				confirm_box(
					false,
					'REMOTE_STORAGE_MIGRATION_START_CONFIRM',
					$this->confirmation_fields($request, 'start_migration', ['target_provider' => $target_provider]),
					'confirm_body.html',
					$this->u_action
				);
				return;
			}
			try
			{
				if ($target_provider !== 'local')
				{
					$connection_tester->test($providers->factory($target_provider)->create());
				}
				$migrator->start($target_provider);
				$state = $migrator->process();
			}
			catch (\Throwable $exception)
			{
				trigger_error($user->lang('REMOTE_STORAGE_MIGRATION_FAILED', $exception->getMessage())
					. adm_back_link($this->u_action), E_USER_WARNING);
			}
		}
		else if ($request->is_set_post('continue_migration'))
		{
			$this->require_form_key($user);
			try
			{
				$state = $migrator->process();
			}
			catch (\Throwable $exception)
			{
				trigger_error($user->lang('REMOTE_STORAGE_MIGRATION_FAILED', $exception->getMessage())
					. adm_back_link($this->u_action), E_USER_WARNING);
			}
		}
		else if ($request->is_set_post('abort_migration'))
		{
			$this->require_form_key($user);
			if (!confirm_box(true))
			{
				confirm_box(
					false,
					'REMOTE_STORAGE_MIGRATION_ABORT_CONFIRM',
					$this->confirmation_fields($request, 'abort_migration'),
					'confirm_body.html',
					$this->u_action
				);
				return;
			}
			$migrator->abort();
			trigger_error($user->lang('REMOTE_STORAGE_MIGRATION_ABORTED') . adm_back_link($this->u_action));
		}

		$save_provider = '';
		foreach ($providers->remote_provider_ids() as $provider_id)
		{
			if ($request->is_set_post('save_' . $provider_id))
			{
				$save_provider = $provider_id;
				break;
			}
		}
		if ($save_provider !== '')
		{
			$this->require_form_key($user);
			if ($state !== null && in_array((string) $state['status'], ['running', 'error', 'activating'], true))
			{
				trigger_error($user->lang('REMOTE_STORAGE_SETTINGS_LOCKED') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$settings = [];
			$factory = $providers->factory($save_provider);
			try
			{
				$settings = $this->submitted_settings($request, $config, $factory);
				$connection_tester->test($factory->create_from($settings));
				if ($factory instanceof rotating_credentials_factory_interface)
				{
					$settings = $factory->finalize_tested_settings($settings);
				}
			}
			catch (\Throwable $exception)
			{
				$rotated_credentials_preserved = false;
				if ($factory instanceof rotating_credentials_factory_interface)
				{
					try
					{
						$settings = $factory->finalize_tested_settings($settings);
						foreach ($settings as $field => $value)
						{
							$config->set($factory->config_key($field), $value);
						}
						$rotated_credentials_preserved = true;
					}
					catch (\Throwable)
					{
					}
				}
				trigger_error(
					$user->lang('REMOTE_STORAGE_CONNECTION_FAILED', $exception->getMessage())
					. ($rotated_credentials_preserved
						? '<br>' . $user->lang('REMOTE_STORAGE_ROTATED_CREDENTIALS_PRESERVED') : '')
					. adm_back_link($this->u_action),
					E_USER_WARNING
				);
			}

			foreach ($settings as $field => $value)
			{
				$config->set($factory->config_key($field), $value);
			}
			trigger_error($user->lang('REMOTE_STORAGE_SETTINGS_SAVED')
				. adm_back_link($this->u_action));
		}

		$active_provider = (string) ($config['phpbb_gallery_storage_provider'] ?? 'local');
		foreach (array_merge(['local'], $providers->remote_provider_ids()) as $target_provider)
		{
			if ($target_provider !== $active_provider)
			{
				$template->assign_block_vars('migration_targets', [
					'ID' => $target_provider,
					'NAME' => $target_provider === 'local'
						? $user->lang('REMOTE_STORAGE_LOCAL')
						: $user->lang($providers->factory($target_provider)->get_name_language_key()),
				]);
			}
		}
		foreach ($providers->remote_provider_ids() as $provider_id)
		{
			$factory = $providers->factory($provider_id);
			$template->assign_block_vars('providers', [
				'ID' => $provider_id,
				'NAME' => $user->lang($factory->get_name_language_key()),
			]);
			$overrides = $factory->environment_overrides();
			foreach ($overrides as $field)
			{
				$template->assign_block_vars('environment_overrides', [
					'NAME' => 'PHPBBGALLERY_' . strtoupper($provider_id . '_' . $field),
				]);
			}
			foreach ($factory->field_definitions() as $field => $definition)
			{
				$configured = (string) ($config[$factory->config_key($field)] ?? $definition['default']);
				$template->assign_block_vars('providers.fields', [
					'NAME' => $field,
					'TYPE' => $definition['type'],
					'MAXLENGTH' => $definition['maxlength'],
					'LABEL' => $user->lang($definition['label']),
					'EXPLAIN' => $definition['explain'] === '' ? '' : $user->lang($definition['explain']),
					'VALUE' => $definition['secret'] ? '' : $configured,
					'S_REQUIRED' => $definition['required'],
					'S_SECRET' => $definition['secret'],
					'S_OVERRIDDEN' => in_array($field, $overrides, true),
					'S_SECRET_CONFIGURED' => $definition['secret']
						&& ($configured !== '' || in_array($field, $overrides, true)),
				]);
			}
		}
		$template->assign_vars([
			'U_ACTION' => $this->u_action,
			'ACTIVE_PROVIDER' => $active_provider,
			'S_MIGRATION_ACTIVE' => $state !== null && in_array((string) $state['status'], ['running', 'error', 'activating'], true),
			'S_MIGRATION_CAN_ABORT' => $state !== null && in_array((string) $state['status'], ['running', 'error'], true),
			'S_MIGRATION_ERROR' => $state !== null && (string) $state['status'] === 'error',
			'S_MIGRATION_COMPLETE' => $state !== null && (string) $state['status'] === 'complete',
			'S_MIGRATION_CAN_START' => $state === null || !in_array((string) $state['status'], ['running', 'error', 'activating'], true),
			'MIGRATION_SOURCE' => (string) ($state['source_provider'] ?? ''),
			'MIGRATION_TARGET' => (string) ($state['target_provider'] ?? ''),
			'MIGRATION_VARIANT' => (string) ($state['variant'] ?? ''),
			'MIGRATION_COPIED' => (int) ($state['copied'] ?? 0),
			'MIGRATION_SKIPPED' => (int) ($state['skipped'] ?? 0),
			'MIGRATION_FAILED' => (int) ($state['failed'] ?? 0),
			'MIGRATION_LAST_ERROR' => (string) ($state['last_error'] ?? ''),
		]);
	}

	private function require_form_key(\phpbb\user $user): void
	{
		if (!check_form_key('acp_gallery_remote_storage'))
		{
			trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
		}
	}

	/** @param array<string, int|string> $extra */
	private function confirmation_fields(request_interface $request, string $action, array $extra = []): string
	{
		return build_hidden_fields($extra + [
			$action => 1,
			'creation_time' => $request->variable('creation_time', 0, false, request_interface::POST),
			'form_token' => $request->variable('form_token', '', false, request_interface::POST),
		]);
	}

	/** @return array<string, string> */
	private function submitted_settings(
		request_interface $request,
		\ArrayAccess $config,
		configured_provider_factory_interface $factory
	): array
	{
		$settings = [];
		$overrides = $factory->environment_overrides();
		foreach ($factory->field_definitions() as $field => $definition)
		{
			$value = trim($request->variable($field, '', true, request_interface::POST));
			if ($definition['secret'] && $value === '')
			{
				$value = (string) ($config[$factory->config_key($field)] ?? '');
			}
			if (($definition['required'] && $value === '' && !in_array($field, $overrides, true))
				|| strlen($value) > $definition['maxlength'])
			{
				throw new \RuntimeException('The submitted ' . $factory->get_id() . ' ' . $field . ' value is invalid.');
			}
			$settings[$field] = $value;
		}

		return $settings;
	}
}
