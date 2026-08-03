<?php
/**
 * phpBB Gallery album-data extension boundary.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\album;

/**
 * Lets optional album-type providers append their data without coupling Core
 * to their storage or services.
 */
class data_enricher
{
	private \phpbb\event\dispatcher_interface $dispatcher;

	public function __construct(\phpbb\event\dispatcher_interface $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}

	public function enrich(array $album_data): array
	{
		/**
		 * Allow optional album-type providers to append data to an album row.
		 *
		 * @event phpbbgallery.core.album.enrich_data
		 * @var array album_data Base album data and data added by earlier listeners
		 * @since 4.1.0
		 */
		$vars = ['album_data'];
		extract($this->dispatcher->trigger_event('phpbbgallery.core.album.enrich_data', compact($vars)));

		return (array) $album_data;
	}

	public function enrich_many(array $album_rows): array
	{
		if (!$album_rows)
		{
			return [];
		}

		/**
		 * Allow optional album-type providers to append data to album rows in bulk.
		 *
		 * @event phpbbgallery.core.album.enrich_rows
		 * @var array album_rows Base album rows and data added by earlier listeners
		 * @since 4.1.0
		 */
		$vars = ['album_rows'];
		extract($this->dispatcher->trigger_event('phpbbgallery.core.album.enrich_rows', compact($vars)));

		return (array) $album_rows;
	}

	public function enrich_template_vars(string $context, array $album_data, array $template_vars): array
	{
		/**
		 * Allow optional album-type providers to append presentation data.
		 *
		 * @event phpbbgallery.core.album.enrich_template_vars
		 * @var string context       Template context being prepared
		 * @var array  album_data    Base and provider-enriched album data
		 * @var array  template_vars Values assigned by the Core
		 * @since 4.1.0
		 */
		$vars = ['context', 'album_data', 'template_vars'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.album.enrich_template_vars',
			compact($vars)
		));

		return (array) $template_vars;
	}
}
