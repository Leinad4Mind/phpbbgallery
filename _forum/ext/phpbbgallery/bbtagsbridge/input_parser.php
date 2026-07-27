<?php
/**
 * Parses Gallery input using the shared BBTags normalization rules.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge;

use phpbb\config\config;
use sitesplat\bbtags\tags\manager;

final class input_parser
{
	private config $config;
	private manager $tags;

	public function __construct(config $config, manager $tags)
	{
		$this->config = $config;
		$this->tags = $tags;
	}

	/**
	 * @return string[]
	 */
	public function parse(string $input): array
	{
		$input = utf8_normalize_nfc(trim($input));
		if ($input === '')
		{
			return [];
		}

		$min_length = max(1, (int) $this->config['bbtags_min_length']);
		$max_length = max($min_length, (int) ($this->config['bbtags_max_length'] ?? manager::MAX_TAG_LENGTH));
		$max_tags = max(1, (int) $this->config['bbtags_max_tags']);
		$tags = [];
		foreach (explode(',', $input) as $value)
		{
			$value = preg_replace('/^#+/u', '', trim($value));
			if (!is_string($value) || $value === '')
			{
				continue;
			}
			if (utf8_strlen($value) > $max_length)
			{
				throw new \InvalidArgumentException('BBTAGSBRIDGE_TAG_TOO_LONG');
			}
			$tag = $this->tags->clean_tag($value);
			if ($tag === '' || utf8_strlen($tag) < $min_length)
			{
				throw new \InvalidArgumentException('BBTAGSBRIDGE_TAG_TOO_SHORT');
			}
			$tags[$this->tags->canonical_tag($tag)] = $tag;
			if (count($tags) > $max_tags)
			{
				throw new \InvalidArgumentException('BBTAGSBRIDGE_TAG_LIMIT');
			}
		}

		return array_values($tags);
	}

	public function format(array $tags): string
	{
		$values = array_map(static function ($tag): string
		{
			return is_array($tag) ? (string) ($tag['tag'] ?? '') : (string) $tag;
		}, $tags);

		return implode(', ', array_values(array_filter($values, static function (string $tag): bool
		{
			return $tag !== '';
		})));
	}

	public function get_min_length(): int
	{
		return max(1, (int) $this->config['bbtags_min_length']);
	}

	public function get_max_length(): int
	{
		return max($this->get_min_length(), (int) ($this->config['bbtags_max_length'] ?? manager::MAX_TAG_LENGTH));
	}

	public function get_max_tags(): int
	{
		return max(1, (int) $this->config['bbtags_max_tags']);
	}
}
