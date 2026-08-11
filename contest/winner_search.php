<?php
/**
 * phpBB Gallery Contest winner search.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest;

/**
 * Finds and renders completed contests whose stored winners remain valid.
 */
class winner_search
{
	private \phpbb\db\driver\driver_interface $db;
	private \phpbb\template\template $template;
	private \phpbb\user $user;
	private \phpbb\language\language $language;
	private \phpbb\controller\helper $helper;
	private \phpbbgallery\core\config $gallery_config;
	private \phpbbgallery\core\auth\auth $gallery_auth;
	private \phpbbgallery\core\image\image $image;
	private \phpbb\pagination $pagination;
	private string $images_table;
	private string $albums_table;
	private string $contests_table;

	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\language\language $language,
		\phpbb\controller\helper $helper,
		\phpbbgallery\core\config $gallery_config,
		\phpbbgallery\core\auth\auth $gallery_auth,
		\phpbbgallery\core\image\image $image,
		\phpbb\pagination $pagination,
		string $images_table,
		string $albums_table,
		string $contests_table
	)
	{
		$this->db = $db;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->helper = $helper;
		$this->gallery_config = $gallery_config;
		$this->gallery_auth = $gallery_auth;
		$this->image = $image;
		$this->pagination = $pagination;
		$this->images_table = $images_table;
		$this->albums_table = $albums_table;
		$this->contests_table = $contests_table;
	}

	public function has_visible_winners(): bool
	{
		$visible_album_ids = $this->get_visible_public_contest_album_ids();

		return $visible_album_ids !== [] && $this->count_visible_contests($visible_album_ids, time()) > 0;
	}

	public function display(int $limit, int $start = 0): void
	{
		$limit = max(1, $limit);
		$start = max(0, $start);
		$visible_album_ids = $this->get_visible_public_contest_album_ids();
		$now = time();
		$count = $visible_album_ids === [] ? 0 : $this->count_visible_contests($visible_album_ids, $now);

		if ($count === 0)
		{
			trigger_error('NO_SEARCH_RESULTS');
			return;
		}

		$sql_array = [
			'SELECT' => 'c.contest_id, c.contest_album_id, c.contest_start, c.contest_end,
				c.contest_first, c.contest_second, c.contest_third, a.album_name',
			'FROM' => [
				$this->contests_table => 'c',
				$this->albums_table => 'a',
			],
			'WHERE' => $this->get_visible_contest_where($visible_album_ids, $now),
			'ORDER_BY' => 'c.contest_start + c.contest_end DESC, c.contest_id DESC',
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query_limit($sql, $limit, $start);
		$contests = [];
		$winner_ids = [];

		while ($row = $this->db->sql_fetchrow($result))
		{
			$row['contest_album_id'] = (int) $row['contest_album_id'];
			$row['contest_scheduled_end'] = (int) $row['contest_start'] + (int) $row['contest_end'];
			foreach (['contest_first', 'contest_second', 'contest_third'] as $winner_column)
			{
				$row[$winner_column] = (int) $row[$winner_column];
				if ($row[$winner_column] > 0)
				{
					$winner_ids[] = $row[$winner_column];
				}
			}
			$contests[] = $row;
		}
		$this->db->sql_freeresult($result);

		if ($contests === [])
		{
			trigger_error('NO_SEARCH_RESULTS');
			return;
		}

		$winner_rows = $this->get_valid_winner_rows($winner_ids, $visible_album_ids);
		$show_options = (int) $this->gallery_config->get('search_display');
		$thumbnail_link = (string) $this->gallery_config->get('link_thumbnail');
		$imagename_link = (string) $this->gallery_config->get('link_image_name');
		$winner_columns = [
			1 => 'contest_first',
			2 => 'contest_second',
			3 => 'contest_third',
		];
		$image_template_vars = $this->image->enrich_block_template_vars(array_values($winner_rows));

		foreach ($contests as $contest)
		{
			$album_id = (int) $contest['contest_album_id'];
			$this->template->assign_block_vars('imageblock', [
				'BLOCK_NAME' => $this->language->lang('CONTEST_WINNERS_OF', $contest['album_name']),
				'U_BLOCK' => $this->helper->route('phpbbgallery_core_album', ['album_id' => $album_id]),
				'S_IMAGE_AWARD_BLOCK' => true,
			]);

			$used_winner_ids = [];
			foreach ($winner_columns as $rank => $winner_column)
			{
				$image_id = (int) $contest[$winner_column];
				$is_valid = $image_id > 0
					&& isset($winner_rows[$image_id])
					&& (int) $winner_rows[$image_id]['image_album_id'] === $album_id
					&& (int) $winner_rows[$image_id]['image_contest_end'] === (int) $contest['contest_scheduled_end']
					&& !isset($used_winner_ids[$image_id]);

				if (!$is_valid)
				{
					$this->template->assign_block_vars('imageblock.image', [
						'S_IMAGE_AWARD_PLACEHOLDER' => true,
						'S_IMAGE_AWARD_RANK' => $rank,
					]);
					continue;
				}

				$used_winner_ids[$image_id] = true;
				$winner_rows[$image_id]['image_contest_rank'] = $rank;
				$additional_vars = isset($image_template_vars[$image_id]) && is_array($image_template_vars[$image_id])
					? $image_template_vars[$image_id]
					: [];
				$this->image->assign_block(
					'imageblock.image',
					$winner_rows[$image_id],
					$show_options,
					$thumbnail_link,
					$imagename_link,
					$additional_vars
				);
			}
		}

		$this->template->assign_vars([
			'SEARCH_MATCHES' => $this->language->lang('FOUND_SEARCH_MATCHES', $count),
			'SEARCH_TITLE' => $this->language->lang('SEARCH_CONTEST'),
			'SEARCH_IN_RESULTS' => false,
			'S_SEARCH_ACTION' => $this->helper->route('phpbbgallery_contest_search'),
			'U_GALLERY_SEARCH' => $this->helper->route('phpbbgallery_core_search'),
		]);
		$this->pagination->generate_template_pagination([
			'routes' => [
				'phpbbgallery_contest_search',
				'phpbbgallery_contest_search_page',
			],
			'params' => [],
		], 'pagination', 'page', $count, $limit, $start);
	}

	private function get_visible_public_contest_album_ids(): array
	{
		$this->gallery_auth->load_user_permissions((int) $this->user->data['user_id']);
		$viewable_album_ids = $this->normalize_ids((array) $this->gallery_auth->acl_album_ids('i_view'));
		$excluded_album_ids = $this->normalize_ids((array) $this->gallery_auth->get_exclude_zebra());
		$viewable_album_ids = array_values(array_diff($viewable_album_ids, $excluded_album_ids));

		if ($viewable_album_ids === [])
		{
			return [];
		}

		$sql = 'SELECT album_id
			FROM ' . $this->albums_table . '
			WHERE ' . $this->db->sql_in_set('album_id', $viewable_album_ids) . '
				AND album_user_id = ' . (int) \phpbbgallery\core\auth\auth::PUBLIC_ALBUM . '
				AND album_type = ' . (int) manager::ALBUM_TYPE . '
			ORDER BY album_id ASC';
		$result = $this->db->sql_query($sql);
		$contest_album_ids = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$contest_album_ids[] = (int) $row['album_id'];
		}
		$this->db->sql_freeresult($result);

		return $this->normalize_ids($contest_album_ids);
	}

	private function count_visible_contests(array $visible_album_ids, int $now): int
	{
		$sql_array = [
			'SELECT' => 'COUNT(c.contest_id) AS count',
			'FROM' => [
				$this->contests_table => 'c',
				$this->albums_table => 'a',
			],
			'WHERE' => $this->get_visible_contest_where($visible_album_ids, $now),
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return is_array($row) ? (int) $row['count'] : 0;
	}

	private function get_visible_contest_where(array $visible_album_ids, int $now): string
	{
		$valid_statuses = [
			\phpbbgallery\core\block::STATUS_APPROVED,
			\phpbbgallery\core\block::STATUS_LOCKED,
		];

		return implode(' AND ', [
			'a.album_id = c.contest_album_id',
			'a.album_user_id = ' . (int) \phpbbgallery\core\auth\auth::PUBLIC_ALBUM,
			'a.album_type = ' . (int) manager::ALBUM_TYPE,
			$this->db->sql_in_set('c.contest_album_id', $visible_album_ids),
			'c.contest_marked = ' . (int) manager::STATE_INACTIVE,
			'c.contest_start + c.contest_end <= ' . $now,
			'EXISTS (SELECT 1
				FROM ' . $this->images_table . ' cw
				WHERE cw.image_album_id = c.contest_album_id
					AND cw.image_contest = ' . (int) manager::STATE_INACTIVE . '
					AND cw.image_contest_end = c.contest_start + c.contest_end
					AND ' . $this->db->sql_in_set('cw.image_status', $valid_statuses) . '
					AND (cw.image_id = c.contest_first
						OR cw.image_id = c.contest_second
						OR cw.image_id = c.contest_third))',
		]);
	}

	private function get_valid_winner_rows(array $winner_ids, array $visible_album_ids): array
	{
		$winner_ids = $this->normalize_ids($winner_ids);
		if ($winner_ids === [])
		{
			return [];
		}

		$sql_array = [
			'SELECT' => 'i.*, a.album_name, a.album_status, a.album_user_id, a.album_id',
			'FROM' => [
				$this->images_table => 'i',
				$this->albums_table => 'a',
			],
			'WHERE' => implode(' AND ', [
				'a.album_id = i.image_album_id',
				'a.album_user_id = ' . (int) \phpbbgallery\core\auth\auth::PUBLIC_ALBUM,
				'a.album_type = ' . (int) manager::ALBUM_TYPE,
				'i.image_contest = ' . (int) manager::STATE_INACTIVE,
				$this->db->sql_in_set('i.image_album_id', $visible_album_ids),
				$this->db->sql_in_set('i.image_id', $winner_ids),
				$this->db->sql_in_set('i.image_status', [
					\phpbbgallery\core\block::STATUS_APPROVED,
					\phpbbgallery\core\block::STATUS_LOCKED,
				]),
			]),
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$winner_rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$winner_rows[(int) $row['image_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		return $winner_rows;
	}

	private function normalize_ids(array $ids): array
	{
		$ids = array_map('intval', $ids);
		$ids = array_filter($ids, static fn (int $id): bool => $id > 0);

		return array_values(array_unique($ids));
	}
}
