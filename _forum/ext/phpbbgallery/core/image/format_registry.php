<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\image;

use Symfony\Component\DependencyInjection\ContainerInterface;

/** Discover and validate image formats supplied by trusted Gallery add-ons. */
final class format_registry
{
	private \phpbb\event\dispatcher_interface $dispatcher;
	private ContainerInterface $container;
	/** @var array<string, array{service: string, mime: string, label: string}>|null */
	private ?array $formats = null;

	public function __construct(\phpbb\event\dispatcher_interface $dispatcher, ContainerInterface $container)
	{
		$this->dispatcher = $dispatcher;
		$this->container = $container;
	}

	/** @return list<string> */
	public function extensions(): array
	{
		return array_keys($this->formats());
	}

	/** @return list<string> */
	public function labels(\phpbb\language\language $language): array
	{
		$labels = [];
		foreach ($this->formats() as $format)
		{
			$label = $language->lang($format['label']);
			if (!in_array($label, $labels, true))
			{
				$labels[] = $label;
			}
		}

		return $labels;
	}

	public function processor_for_filename(string $filename): ?external_processor_interface
	{
		$extension = strtolower((string) pathinfo($filename, PATHINFO_EXTENSION));
		$formats = $this->formats();
		if (!isset($formats[$extension]))
		{
			return null;
		}

		$processor = $this->container->get($formats[$extension]['service']);

		return $processor instanceof external_processor_interface ? $processor : null;
	}

	public function accepts_metadata(string $filename, array $metadata): bool
	{
		$extension = strtolower((string) pathinfo($filename, PATHINFO_EXTENSION));
		$formats = $this->formats();

		return isset($formats[$extension])
			&& strtolower((string) ($metadata['extension'] ?? '')) === $extension
			&& strtolower((string) ($metadata['mime'] ?? '')) === $formats[$extension]['mime']
			&& (int) ($metadata['width'] ?? 0) > 0
			&& (int) ($metadata['height'] ?? 0) > 0
			&& ((int) $metadata['width'] * (int) $metadata['height']) <= \phpbbgallery\core\file\file::MAX_DECODE_PIXELS
			&& (int) ($metadata['filesize'] ?? 0) > 0;
	}

	/** @return array<string, array{service: string, mime: string, label: string}> */
	private function formats(): array
	{
		if ($this->formats !== null)
		{
			return $this->formats;
		}

		$formats = [];
		/**
		 * Register trusted external image processors.
		 *
		 * Each extension must map to service, MIME and language-label strings. The
		 * service must implement external_processor_interface. Duplicate extensions
		 * are rejected rather than allowing listener order to select a processor.
		 *
		 * @event phpbbgallery.core.image_format.collect
		 * @var array formats External image format definitions
		 * @since 3.4.0
		 */
		$vars = ['formats'];
		extract($this->dispatcher->trigger_event('phpbbgallery.core.image_format.collect', compact($vars)));

		$normalized = [];
		foreach ($formats as $extension => $format)
		{
			$extension = strtolower((string) $extension);
			if (preg_match('/^[a-z0-9]{2,10}$/D', $extension) !== 1
				|| !is_array($format)
				|| !isset($format['service'], $format['mime'], $format['label'])
				|| !is_string($format['service']) || !is_string($format['mime']) || !is_string($format['label'])
				|| preg_match('/^[a-z0-9_.-]{3,128}$/D', $format['service']) !== 1
				|| preg_match('#^image/[a-z0-9.+-]{2,64}$#D', strtolower($format['mime'])) !== 1
				|| preg_match('/^[A-Z0-9_]{3,128}$/D', $format['label']) !== 1
				|| isset($normalized[$extension])
				|| !$this->container->has($format['service']))
			{
				continue;
			}
			$processor = $this->container->get($format['service']);
			if (!$processor instanceof external_processor_interface)
			{
				continue;
			}
			$normalized[$extension] = [
				'service' => $format['service'],
				'mime' => strtolower($format['mime']),
				'label' => $format['label'],
			];
		}

		return $this->formats = $normalized;
	}
}
