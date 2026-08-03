<?php
/**
 * phpBB Gallery - Feed Extension
 *
 * @package   phpbbgallery/feed
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\feed;

/**
 * Builds the image sets published through the gallery feed.
 *
 * Both the gallery-wide and the single-album feed run through the very same
 * visibility predicate, so an album feed can never expose images that the
 * gallery-wide feed would hide.
 */
class feed
{
	/* @var \phpbb\db\driver\driver_interface */
	protected \phpbb\db\driver\driver_interface $db;

	/* @var \phpbbgallery\core\auth\auth */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/* @var \phpbbgallery\core\config */
	protected \phpbbgallery\core\config $gallery_config;

	/* @var \phpbbgallery\core\album\album */
	protected \phpbbgallery\core\album\album $album;

	/* @var \phpbbgallery\core\album\data_enricher */
	protected \phpbbgallery\core\album\data_enricher $data_enricher;

	/* @var string */
	protected string $albums_table;

	/* @var string */
	protected string $images_table;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface $db             Database object
	 * @param \phpbbgallery\core\auth\auth      $gallery_auth   Gallery auth object
	 * @param \phpbbgallery\core\config         $gallery_config Gallery config object
	 * @param \phpbbgallery\core\album\album    $album          Gallery album object
	 * @param \phpbbgallery\core\album\data_enricher $data_enricher Album extension-data boundary
	 * @param string                            $albums_table   Gallery albums table
	 * @param string                            $images_table   Gallery images table
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbbgallery\core\auth\auth $gallery_auth,
		\phpbbgallery\core\config $gallery_config, \phpbbgallery\core\album\album $album,
		\phpbbgallery\core\album\data_enricher $data_enricher, string $albums_table, string $images_table)
	{
		$this->db = $db;
		$this->gallery_auth = $gallery_auth;
		$this->gallery_config = $gallery_config;
		$this->album = $album;
		$this->data_enricher = $data_enricher;
		$this->albums_table = $albums_table;
		$this->images_table = $images_table;
	}

	/**
	 * Is the feed enabled board-wide?
	 *
	 * @return bool
	 */
	public function is_enabled(): bool
	{
		return (bool) $this->gallery_config->get('feed_enable');
	}

	/**
	 * How many items does a feed carry at most?
	 *
	 * @return int
	 */
	public function get_limit(): int
	{
		return max(1, (int) $this->gallery_config->get('feed_limit'));
	}

	/**
	 * Album ids that are flagged for feed publication.
	 *
	 * Unlike the original implementation this is not tied to "display in
	 * recent/random blocks": an album is published when album_feed says so,
	 * nothing else.
	 *
	 * @return array
	 */
	public function get_feed_album_ids(): array
	{
		$album_ids = [];

		$sql = 'SELECT album_id
			FROM ' . $this->albums_table . '
			WHERE album_feed = 1';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$album_ids[] = (int) $row['album_id'];
		}
		$this->db->sql_freeresult($result);

		return $album_ids;
	}

	/**
	 * Read a single album and tell whether it may be published at all.
	 *
	 * @param int $album_id Album to publish
	 * @return array|false Album data, or false when it must not be published
	 */
	public function get_publishable_album(int $album_id): array|false
	{
		$album_data = $this->album->get_info($album_id);

		if (empty($album_data) || empty($album_data['album_feed']))
		{
			return false;
		}

		// Personal galleries are published only when the board allows it.
		if ((int) $album_data['album_user_id'] !== (int) \phpbbgallery\core\block::PUBLIC_ALBUM
			&& !$this->gallery_config->get('feed_enable_pegas'))
		{
			return false;
		}

		return $album_data;
	}

	/**
	 * Fetch the newest images the current user is allowed to see.
	 *
	 * @param int|false $album_id Restrict to a single album, or false for the whole gallery
	 * @return array Image rows, newest first; empty when nothing is visible
	 */
	public function get_images(int|false $album_id = false): array
	{
		$candidates = $this->get_feed_album_ids();

		if ($album_id !== false)
		{
			$candidates = array_intersect($candidates, [(int) $album_id]);
		}

		$where = $this->build_visibility_where($candidates);

		if ($where === '')
		{
			return [];
		}

		$sql_array = [
			'SELECT'	=> 'i.*, a.album_name, a.album_user_id, a.album_id, a.album_type',
			'FROM'		=> [$this->images_table => 'i'],
			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [$this->albums_table => 'a'],
					'ON'	=> 'i.image_album_id = a.album_id',
				],
			],
			'WHERE'		=> $where,
			'ORDER_BY'	=> 'i.image_time DESC',
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query_limit($sql, $this->get_limit());

		$rowset = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rowset[] = $row;
		}
		$this->db->sql_freeresult($result);

		return $this->data_enricher->enrich_many($rowset);
	}

	/**
	 * Build the visibility predicate shared by every feed mode.
	 *
	 * Plain viewers never see images awaiting approval; moderators of an album
	 * see everything in it. Orphaned uploads are always excluded.
	 *
	 * @param array $candidate_albums Albums eligible for publication
	 * @return string SQL condition, or an empty string when nothing is visible
	 */
	protected function build_visibility_where(array $candidate_albums): string
	{
		if (empty($candidate_albums))
		{
			return '';
		}

		$display_pegas = (bool) $this->gallery_config->get('feed_enable_pegas');
		$excluded = $this->gallery_auth->get_exclude_zebra();

		$viewable = array_intersect(
			array_diff($this->gallery_auth->acl_album_ids('i_view', 'array', false, $display_pegas), $excluded),
			$candidate_albums
		);
		$moderated = array_intersect(
			array_diff($this->gallery_auth->acl_album_ids('m_status', 'array', false, $display_pegas), $excluded),
			$candidate_albums
		);

		// Moderated albums are handled by their own branch, without the status filter.
		$viewable = array_diff($viewable, $moderated);

		if (empty($viewable) && empty($moderated))
		{
			return '';
		}

		$conditions = [];

		if (!empty($viewable))
		{
			$conditions[] = '(' . $this->db->sql_in_set('i.image_album_id', $viewable, false, true) . '
				AND i.image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . ')';
		}

		if (!empty($moderated))
		{
			$conditions[] = $this->db->sql_in_set('i.image_album_id', $moderated, false, true);
		}

		return '(' . implode(' OR ', $conditions) . ')
			AND i.image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN;
	}
}
