<?php
/**
 *
 * Search Results extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 John Peskens (http://ForumHulp.com)
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace forumhulp\searchresults\event;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\event\data;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	private const PRUNE_BATCH_SIZE = 500;

	private config $config;
	private driver_interface $db;
	private string $searchresults_table;

	public function __construct(config $config, driver_interface $db, string $searchresults_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->searchresults_table = $searchresults_table;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.search_results_modify_search_title' => 'list_keywords',
			'core.acp_board_config_edit_add' => 'load_config_on_setup',
		];
	}

	public function list_keywords(data $event): void
	{
		$this->prune_searchresults();

		$minimum_chars = max(1, (int) $this->config['fulltext_native_min_chars']);
		$maximum_chars = max($minimum_chars, (int) $this->config['fulltext_native_max_chars']);
		$keywords = $this->normalise_keywords((string) $event['keywords'], $minimum_chars, $maximum_chars);
		$now = time();

		foreach ($keywords as $keyword)
		{
			$sql = 'SELECT word_id
				FROM ' . SEARCH_WORDLIST_TABLE . "
				WHERE word_text = '" . $this->db->sql_escape($keyword) . "'";
			$result = $this->db->sql_query_limit($sql, 1);
			$in_post = (bool) $this->db->sql_fetchfield('word_id');
			$this->db->sql_freeresult($result);

			$this->record_keyword($keyword, $in_post, $now);
		}

		$this->prune_searchresults();
	}

	public function load_config_on_setup(data $event): void
	{
		if ($event['mode'] !== 'features')
		{
			return;
		}

		$display_vars = $event['display_vars'];
		$additional_config = [
			'prune_searchresults' => [
				'lang' => 'PRUNE_SEARCHRESULTS',
				'validate' => 'int',
				'type' => 'number:0:999999',
				'explain' => true,
			],
		];
		$display_vars['vars'] = phpbb_insert_config_array(
			$display_vars['vars'],
			$additional_config,
			['after' => 'allow_quick_reply']
		);
		$event['display_vars'] = [
			'title' => $display_vars['title'],
			'vars' => $display_vars['vars'],
		];
	}

	private function normalise_keywords(string $keywords, int $minimum_chars, int $maximum_chars): array
	{
		$keywords = utf8_strtolower(htmlspecialchars_decode($keywords, ENT_QUOTES));
		preg_match_all("~[\\p{L}\\p{N}]+(?:['’][\\p{L}\\p{N}]+)*~u", $keywords, $matches);

		$normalised = [];
		$boolean_operators = [
			'and' => true,
			'or' => true,
			'not' => true,
		];

		foreach ($matches[0] as $keyword)
		{
			$length = utf8_strlen($keyword);
			if ($length < $minimum_chars || $length > $maximum_chars || isset($boolean_operators[$keyword]))
			{
				continue;
			}

			$normalised[$keyword] = $keyword;
		}

		return array_values($normalised);
	}

	private function record_keyword(string $keyword, bool $in_post, int $now): void
	{
		$sql = 'SELECT search_key, hits, first_time, last_time, in_post
			FROM ' . $this->searchresults_table . "
			WHERE search_keywords = '" . $this->db->sql_escape($keyword) . "'
			ORDER BY search_key ASC";
		$result = $this->db->sql_query($sql);
		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		if (!$rows)
		{
			$sql = 'INSERT INTO ' . $this->searchresults_table . ' ' . $this->db->sql_build_array('INSERT', [
				'search_keywords' => $keyword,
				'in_post' => $in_post ? 1 : 0,
				'hits' => 1,
				'first_time' => $now,
				'last_time' => $now,
			]);
			$this->db->sql_query($sql);
			return;
		}

		$canonical = array_shift($rows);
		if (!$rows)
		{
			$sql_set = 'hits = hits + 1, last_time = ' . $now;
			if ($in_post && !(bool) $canonical['in_post'])
			{
				$sql_set .= ', in_post = 1';
			}

			$sql = 'UPDATE ' . $this->searchresults_table . '
				SET ' . $sql_set . '
				WHERE search_key = ' . (int) $canonical['search_key'];
			$this->db->sql_query($sql);
			return;
		}

		$hits = (int) $canonical['hits'] + 1;
		$first_time = (int) $canonical['first_time'];
		$stored_in_post = (bool) $canonical['in_post'];
		$duplicate_ids = [];

		foreach ($rows as $duplicate)
		{
			$hits += (int) $duplicate['hits'];
			$first_time = min($first_time, (int) $duplicate['first_time']);
			$stored_in_post = $stored_in_post || (bool) $duplicate['in_post'];
			$duplicate_ids[] = (int) $duplicate['search_key'];
		}

		$sql = 'UPDATE ' . $this->searchresults_table . '
			SET ' . $this->db->sql_build_array('UPDATE', [
				'hits' => $hits,
				'first_time' => $first_time,
				'last_time' => $now,
				'in_post' => ($in_post || $stored_in_post) ? 1 : 0,
			]) . '
			WHERE search_key = ' . (int) $canonical['search_key'];
		$this->db->sql_query($sql);

		if ($duplicate_ids)
		{
			$sql = 'DELETE FROM ' . $this->searchresults_table . '
				WHERE ' . $this->db->sql_in_set('search_key', $duplicate_ids);
			$this->db->sql_query($sql);
		}
	}

	private function prune_searchresults(): void
	{
		$maximum_records = (int) $this->config['prune_searchresults'];
		if ($maximum_records <= 0)
		{
			return;
		}

		do
		{
			$sql = 'SELECT search_key
				FROM ' . $this->searchresults_table . '
				ORDER BY hits DESC, last_time DESC, search_key ASC';
			$result = $this->db->sql_query_limit($sql, self::PRUNE_BATCH_SIZE, $maximum_records);
			$delete_ids = [];
			while (($search_key = $this->db->sql_fetchfield('search_key')) !== false)
			{
				$delete_ids[] = (int) $search_key;
			}
			$this->db->sql_freeresult($result);

			if ($delete_ids)
			{
				$sql = 'DELETE FROM ' . $this->searchresults_table . '
					WHERE ' . $this->db->sql_in_set('search_key', $delete_ids);
				$this->db->sql_query($sql);
			}
		}
		while (count($delete_ids) === self::PRUNE_BATCH_SIZE);
	}
}
