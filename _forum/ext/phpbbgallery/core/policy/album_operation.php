<?php
/**
 * phpBB Gallery album-operation policy boundary.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\policy;

use phpbbgallery\core\album\type_registry;

/**
 * Combines the Core album-type capabilities with optional add-on policies.
 */
class album_operation
{
	private \phpbb\event\dispatcher_interface $dispatcher;
	private type_registry $type_registry;

	public function __construct(
		\phpbb\event\dispatcher_interface $dispatcher,
		type_registry $type_registry
	)
	{
		$this->dispatcher = $dispatcher;
		$this->type_registry = $type_registry;
	}

	public function allows(string $operation, array $album_data): bool
	{
		$operation = trim($operation);
		if ($operation === '')
		{
			throw new \InvalidArgumentException('Album operation must not be empty.');
		}

		$album_type = (int) ($album_data['album_type'] ?? -1);
		$context = [
			'operation' => $operation,
			'album_data' => $album_data,
		];

		if (!$this->type_registry->is_available($album_type, $context))
		{
			return false;
		}

		$requires_image_capability = in_array($operation, ['upload', 'move_in'], true);
		$allowed = !$requires_image_capability
			|| $this->type_registry->accepts_images($album_type, $context);

		/**
		 * Allow add-ons to restrict operations on album types they own.
		 *
		 * @event phpbbgallery.core.album_operation
		 * @var string operation  Operation being checked
		 * @var array  album_data Album row and any extended type data
		 * @var bool   allowed    Whether the operation is currently allowed
		 * @since 4.1.0
		 */
		$vars = ['operation', 'album_data', 'allowed'];
		extract($this->dispatcher->trigger_event('phpbbgallery.core.album_operation', compact($vars)));

		return (bool) $allowed;
	}
}
