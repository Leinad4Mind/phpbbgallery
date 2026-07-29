<?php
/**
 * phpBB Gallery - Feed tests
 *
 * @package   phpbbgallery/feed
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\feed\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\core\block;
use phpbbgallery\feed\feed;

/**
 * The feed must never publish an image the requester cannot already see.
 */
final class visibility_test extends TestCase
{
	/**
	 * Build a feed service whose collaborators answer with fixed data.
	 *
	 * @param array $viewable   Albums the user may view
	 * @param array $moderated  Albums the user moderates
	 * @param array $excluded   Albums hidden by the zebra rules
	 * @return feed
	 */
	private function make_feed(array $viewable, array $moderated, array $excluded = []): feed
	{
		$db = new class implements \phpbb\db\driver\driver_interface
		{
			public function sql_in_set($field, $array, $negate = false, $allow_empty_set = false)
			{
				return $field . ' IN (' . implode(',', (array) $array) . ')';
			}
		};

		$auth = new class($viewable, $moderated, $excluded) extends \phpbbgallery\core\auth\auth
		{
			public function __construct(private array $viewable, private array $moderated, private array $excluded)
			{
			}

			public function acl_album_ids(string $acl, string $return = 'array', bool $display_in_rrc = false, bool $display_pegas = true): array
			{
				return $acl === 'm_status' ? $this->moderated : $this->viewable;
			}

			public function get_exclude_zebra(): array
			{
				return $this->excluded;
			}
		};

		$config = new class extends \phpbbgallery\core\config
		{
			public function get(string $key): mixed
			{
				return $key === 'feed_limit' ? 10 : 1;
			}
		};

		return new feed($db, $auth, $config, new \phpbbgallery\core\album\album(), 'albums', 'images', 'contests');
	}

	public function test_feed_query_joins_only_the_active_contest_window(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/feed.php');

		$this->assertStringContainsString('c.contest_start, c.contest_end', $source);
		$this->assertStringContainsString('c.contest_marked <> ', $source);
	}

	public function test_feed_controller_hides_contest_author_and_description(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/main.php');

		$this->assertGreaterThanOrEqual(2, substr_count($source, 'hides_contest_private_data('));
		$this->assertStringContainsString('CONTEST_USERNAME', $source);
		$this->assertStringContainsString('CONTEST_IMAGE_DESC', $source);
	}

	/**
	 * Call the protected predicate builder.
	 *
	 * @param feed  $feed       Feed service
	 * @param array $candidates Albums flagged for publication
	 * @return string
	 */
	private function where(feed $feed, array $candidates): string
	{
		$method = new \ReflectionMethod($feed, 'build_visibility_where');

		return $method->invoke($feed, $candidates);
	}

	public function test_plain_viewers_never_receive_unapproved_images(): void
	{
		$where = $this->where($this->make_feed([5], []), [5]);

		$this->assertStringContainsString(
			'image_status <> ' . block::STATUS_UNAPPROVED,
			$where,
			'A viewable album must filter out images awaiting approval.'
		);
	}

	public function test_single_album_uses_the_same_filter_as_the_whole_gallery(): void
	{
		$feed = $this->make_feed([5, 6], []);

		// Restricting to one album must not drop the approval filter, which is
		// exactly the leak the original implementation had.
		$this->assertStringContainsString(
			'image_status <> ' . block::STATUS_UNAPPROVED,
			$this->where($feed, [5])
		);
	}

	public function test_moderators_see_everything_in_the_albums_they_moderate(): void
	{
		$where = $this->where($this->make_feed([], [7]), [7]);

		$this->assertStringContainsString('image_album_id IN (7)', $where);
		$this->assertStringNotContainsString(
			'image_status <> ' . block::STATUS_UNAPPROVED,
			$where,
			'Moderated albums are not subject to the approval filter.'
		);
	}

	public function test_moderated_albums_are_not_listed_twice(): void
	{
		// An album the user both views and moderates belongs to the moderator
		// branch only, otherwise the approval filter would contradict itself.
		$where = $this->where($this->make_feed([5, 7], [7]), [5, 7]);

		$this->assertStringContainsString('image_album_id IN (5)', $where);
		$this->assertStringContainsString('image_album_id IN (7)', $where);
		$this->assertStringNotContainsString('image_album_id IN (5,7)', $where);
	}

	public function test_orphaned_uploads_are_always_excluded(): void
	{
		foreach ([$this->make_feed([5], []), $this->make_feed([], [7])] as $feed)
		{
			$this->assertStringContainsString(
				'image_status <> ' . block::STATUS_ORPHAN,
				$this->where($feed, [5, 7])
			);
		}
	}

	public function test_albums_hidden_by_zebra_are_dropped(): void
	{
		$this->assertSame('', $this->where($this->make_feed([5], [], [5]), [5]));
	}

	public function test_nothing_visible_yields_no_query(): void
	{
		$this->assertSame('', $this->where($this->make_feed([], []), [5]));
		$this->assertSame('', $this->where($this->make_feed([5], []), []));
	}

	public function test_albums_outside_the_candidate_set_are_dropped(): void
	{
		// The user may view album 9, but only album 5 is flagged for the feed.
		$this->assertSame('', $this->where($this->make_feed([9], []), [5]));
	}
}
