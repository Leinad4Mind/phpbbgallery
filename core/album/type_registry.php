<?php
/**
 * phpBB Gallery album-type registry.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\album;

/**
 * Provides the Core album types and lets optional add-ons register more.
 */
class type_registry
{
	private \phpbb\event\dispatcher_interface $dispatcher;

	public function __construct(\phpbb\event\dispatcher_interface $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}

	/**
	 * Return every album type available for the current operation.
	 *
	 * Definitions contain a language suffix, whether images are accepted and
	 * whether new albums of the type may currently be created and whether an
	 * existing album may leave that type.
	 *
	 * @param array $context Operation-specific context
	 * @return array<int, array{lang: string, accepts_images: bool, can_create: bool, immutable: bool}>
	 */
	public function get_types(array $context = []): array
	{
		$types = [
			(int) \phpbbgallery\core\block::TYPE_CAT => [
				'lang' => 'CAT',
				'accepts_images' => false,
				'can_create' => true,
				'immutable' => false,
			],
			(int) \phpbbgallery\core\block::TYPE_UPLOAD => [
				'lang' => 'UPLOAD',
				'accepts_images' => true,
				'can_create' => true,
				'immutable' => false,
			],
		];

		/**
		 * Allow add-ons to register independently owned album types.
		 *
		 * @event phpbbgallery.core.album.types
		 * @var array types   Album type definitions keyed by their numeric ID
		 * @var array context Operation-specific context
		 * @since 4.1.0
		 */
		$vars = ['types', 'context'];
		extract($this->dispatcher->trigger_event('phpbbgallery.core.album.types', compact($vars)));

		$normalized = [];
		foreach ((array) $types as $type_id => $definition)
		{
			if ((!is_int($type_id) && !ctype_digit((string) $type_id)) || !is_array($definition))
			{
				continue;
			}

			$type_id = (int) $type_id;
			$lang = (string) ($definition['lang'] ?? '');
			if ($type_id < 0 || $lang === '')
			{
				continue;
			}

			$normalized[$type_id] = [
				'lang' => $lang,
				'accepts_images' => (bool) ($definition['accepts_images'] ?? false),
				'can_create' => (bool) ($definition['can_create'] ?? true),
				'immutable' => (bool) ($definition['immutable'] ?? false),
			];
		}

		ksort($normalized);
		return $normalized;
	}

	public function is_available(int $type_id, array $context = []): bool
	{
		return isset($this->get_types($context)[$type_id]);
	}

	public function accepts_images(int $type_id, array $context = []): bool
	{
		$types = $this->get_types($context);
		return isset($types[$type_id]) && $types[$type_id]['accepts_images'];
	}
}
