<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\integration;

/** Publish a caller-fetched local image through Gallery's normal upload pipeline. */
final class image_importer implements image_importer_interface
{
	public function __construct(
		private \phpbb\db\driver\driver_interface $db,
		private \phpbb\user $user,
		private \phpbb\event\dispatcher_interface $dispatcher,
		private \phpbbgallery\core\auth\auth $gallery_auth,
		private \phpbbgallery\core\album\album $album,
		private \phpbbgallery\core\policy\album_operation $album_operation,
		private \phpbbgallery\core\config $gallery_config,
		private \phpbbgallery\core\upload $upload,
		private \phpbbgallery\core\image\image $image,
		private string $images_table,
		private string $users_table
	)
	{
	}

	public function get_capabilities(): array
	{
		return [
			'contract_version' => self::CONTRACT_VERSION,
			'source_types' => ['local_file'],
			'remote_fetch' => false,
			'delegated_actor' => true,
			'source_ownership' => 'transferred',
			'events' => [
				'phpbbgallery.core.integration.import_image_validate',
				'phpbbgallery.core.integration.image_imported',
				'phpbbgallery.core.image.state_changed',
			],
		];
	}

	public function import(image_import_request $request): image_import_result
	{
		$current_user_id = (int) ($this->user->data['user_id'] ?? 0);
		$actor = $this->resolve_actor($request->get_actor_user_id() ?: $current_user_id);
		$actor_user_id = (int) $actor['user_id'];
		$context = $request->get_context();
		$validation_error = '';

		/**
		 * Allow add-ons to reject a programmatic import before Gallery takes
		 * ownership of the local temporary file.
		 *
		 * @event phpbbgallery.core.integration.import_image_validate
		 * @var image_import_request import_request  Immutable import request
		 * @var array                context         Caller-owned correlation data
		 * @var string               validation_error Empty string, or rejection reason
		 * @since 4.2.0
		 */
		$import_request = $request;
		$vars = ['import_request', 'context', 'validation_error'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.integration.import_image_validate',
			compact($vars)
		));
		if ($validation_error !== '')
		{
			throw new image_import_exception(image_import_exception::VALIDATION_FAILED, [(string) $validation_error]);
		}
		$this->validate_metadata($request);

		$image_id = 0;
		$finalized = false;
		$permissions_switched = $actor_user_id !== $current_user_id;
		$this->gallery_auth->load_user_permissions($actor_user_id);

		try
		{
			try
			{
				$album_data = $this->album->get_info($request->get_album_id(), false);
			}
			catch (\phpbb\exception\http_exception $exception)
			{
				throw new image_import_exception(image_import_exception::ALBUM_NOT_FOUND, [], $exception);
			}

			$this->assert_authorised($actor_user_id, $current_user_id, $album_data);
			$this->assert_quota_available($actor_user_id, $album_data);

			$this->upload->reset_operation();
			$this->upload->set_up($request->get_album_id(), 1, false);
			$this->upload->set_operation_context('integration', [
				'integration_name' => $request->get_integration_name(),
				'context' => $context,
			]);
			$this->upload->set_names([$request->get_image_name()]);
			$this->upload->set_descriptions([$request->get_description()]);
			$this->upload->set_subtitles([$request->get_subtitle()]);
			$this->upload->set_allow_comments(
				$request->allows_comments() && (bool) $this->gallery_config->get('allow_comments')
			);
			$this->upload->set_author(
				$actor_user_id,
				(string) $actor['username'],
				(string) $actor['user_colour']
			);

			$image_id = $this->upload->upload_local_file(
				$request->get_source_path(),
				$request->get_original_filename()
			);
			if (!$image_id)
			{
				throw new image_import_exception(image_import_exception::UPLOAD_FAILED, $this->upload->errors);
			}

			$needs_approval = !$this->gallery_auth->acl_check(
				'i_approve',
				$request->get_album_id(),
				(int) $album_data['album_user_id']
			);
			try
			{
				$image_updated = $this->upload->update_image($image_id, $needs_approval, $album_data);
			}
			catch (\Throwable $exception)
			{
				if ($this->is_finalized_image($image_id))
				{
					$finalized = true;
					$result = $this->build_result($request, $image_id, $actor_user_id, $context);
					throw new image_import_exception(
						image_import_exception::POST_PROCESSING_FAILED,
						[],
						$exception,
						$result
					);
				}

				throw new image_import_exception(
					image_import_exception::FINALIZATION_FAILED,
					$this->upload->errors,
					$exception
				);
			}
			if (!$image_updated)
			{
				throw new image_import_exception(image_import_exception::FINALIZATION_FAILED, $this->upload->errors);
			}
			$finalized = true;
			$result = $this->build_result($request, $image_id, $actor_user_id, $context);
			$image_data = $result->get_image_data();

			try
			{
				$this->image->handle_counter([$image_id], true);
				$this->album->update_info($request->get_album_id());

				/**
				 * Notify optional extensions after a programmatic image import has been
				 * finalized and Gallery counters have been synchronized.
				 *
				 * @event phpbbgallery.core.integration.image_imported
				 * @var image_import_request import_request Source request
				 * @var image_import_result  import_result  Stable Gallery reference
				 * @var int                  image_id       Finalized image identifier
				 * @var array                image_data     Final image database row
				 * @var array                album_data     Destination album row
				 * @var int                  actor_user_id  Effective author/permission owner
				 * @var array                context        Caller-owned correlation data
				 * @since 4.2.0
				 */
				$import_result = $result;
				$vars = [
					'import_request',
					'import_result',
					'image_id',
					'image_data',
					'album_data',
					'actor_user_id',
					'context',
				];
				extract($this->dispatcher->trigger_event(
					'phpbbgallery.core.integration.image_imported',
					compact($vars)
				));
			}
			catch (\Throwable $exception)
			{
				throw new image_import_exception(
					image_import_exception::POST_PROCESSING_FAILED,
					[],
					$exception,
					$result
				);
			}

			return $result;
		}
		finally
		{
			if ($image_id && !$finalized)
			{
				$this->upload->discard_uploaded_images();
			}
			if ($permissions_switched)
			{
				$this->gallery_auth->load_user_permissions($current_user_id);
			}
		}
	}

	private function build_result(
		image_import_request $request,
		int $image_id,
		int $actor_user_id,
		array $context
	): image_import_result
	{
		return new image_import_result(
			$image_id,
			$request->get_album_id(),
			$actor_user_id,
			$this->upload->image_data[$image_id],
			$context
		);
	}

	private function is_finalized_image(int $image_id): bool
	{
		return isset($this->upload->image_data[$image_id]['image_status'])
			&& (int) $this->upload->image_data[$image_id]['image_status'] !== \phpbbgallery\core\block::STATUS_ORPHAN;
	}

	private function validate_metadata(image_import_request $request): void
	{
		$errors = [];
		if (utf8_strlen($request->get_image_name()) > 255)
		{
			$errors[] = 'image_name_too_long';
		}
		if (utf8_strlen($request->get_description()) > (int) $this->gallery_config->get('description_length'))
		{
			$errors[] = 'description_too_long';
		}
		if (utf8_strlen($request->get_subtitle()) > \phpbbgallery\core\upload::IMAGE_SUBTITLE_MAX_LENGTH)
		{
			$errors[] = 'subtitle_too_long';
		}
		if ($errors)
		{
			throw new image_import_exception(image_import_exception::VALIDATION_FAILED, $errors);
		}
	}

	private function resolve_actor(int $actor_user_id): array
	{
		if ($actor_user_id <= 0)
		{
			throw new image_import_exception(image_import_exception::ACTOR_NOT_FOUND);
		}
		if ($actor_user_id === (int) ($this->user->data['user_id'] ?? 0))
		{
			return [
				'user_id' => $actor_user_id,
				'username' => (string) ($this->user->data['username'] ?? ''),
				'user_colour' => (string) ($this->user->data['user_colour'] ?? ''),
			];
		}

		$sql = 'SELECT user_id, username, user_colour
			FROM ' . $this->users_table . '
			WHERE user_id = ' . $actor_user_id;
		$result = $this->db->sql_query($sql);
		$actor = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if (!$actor)
		{
			throw new image_import_exception(image_import_exception::ACTOR_NOT_FOUND);
		}

		return $actor;
	}

	private function assert_authorised(int $actor_user_id, int $current_user_id, array $album_data): void
	{
		$album_id = (int) $album_data['album_id'];
		$album_owner_id = (int) $album_data['album_user_id'];
		$delegated_private_album = $actor_user_id !== $current_user_id
			&& $album_owner_id !== \phpbbgallery\core\block::PUBLIC_ALBUM;
		if ($delegated_private_album
			|| (int) $album_data['album_status'] === \phpbbgallery\core\block::ALBUM_LOCKED
			|| !$this->gallery_auth->acl_check('i_upload', $album_id, $album_owner_id)
			|| !$this->album_operation->allows('upload', $album_data))
		{
			throw new image_import_exception(image_import_exception::NOT_AUTHORISED);
		}
	}

	private function assert_quota_available(int $actor_user_id, array $album_data): void
	{
		$album_id = (int) $album_data['album_id'];
		$album_owner_id = (int) $album_data['album_user_id'];
		$batch_limit = max(0, (int) $this->gallery_config->get('num_uploads'));
		$album_limit = (int) $this->gallery_config->get('album_images');
		$user_unlimited = (bool) $this->gallery_auth->acl_check('i_unlimited', $album_id, $album_owner_id);
		$user_limit = max(0, (int) $this->gallery_auth->acl_check('i_count', $album_id, $album_owner_id));

		$album_count = $this->count_images('image_album_id = ' . $album_id . '
			AND image_status <> ' . \phpbbgallery\core\block::STATUS_ORPHAN . '
			AND image_status <> ' . \phpbbgallery\core\block::STATUS_DELETE_REQUESTED);
		$user_count = $user_unlimited ? 0 : $this->count_images('image_album_id = ' . $album_id . '
			AND image_user_id = ' . $actor_user_id . '
			AND image_status <> ' . \phpbbgallery\core\block::STATUS_ORPHAN);

		if ($batch_limit < 1
			|| ($album_limit >= 0 && $album_count >= $album_limit)
			|| (!$user_unlimited && $user_count >= $user_limit))
		{
			throw new image_import_exception(image_import_exception::QUOTA_REACHED);
		}
	}

	private function count_images(string $where): int
	{
		$sql = 'SELECT COUNT(image_id) AS image_count
			FROM ' . $this->images_table . '
			WHERE ' . $where;
		$result = $this->db->sql_query($sql);
		$count = (int) $this->db->sql_fetchfield('image_count');
		$this->db->sql_freeresult($result);

		return $count;
	}
}
