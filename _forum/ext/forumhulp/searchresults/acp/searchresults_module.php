<?php
/**
 *
 * Search Results extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 ForumHulp.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace forumhulp\searchresults\acp;

use phpbb\request\request_interface;

class searchresults_module
{
	private const FORM_KEY = 'acp_searchresults';

	public string $u_action = '';
	public string $page_title = '';
	public string $tpl_name = '';
	private string $searchresults_table = '';

	public function main(string $id, string $mode): void
	{
		global $user, $request, $phpbb_container;

		$user->add_lang_ext('forumhulp/searchresults', 'searchresults');

		$this->searchresults_table = $phpbb_container->getParameter('tables.searchresults');
		$this->page_title = $user->lang['ACP_SEARCHRESULTS'];
		$this->tpl_name = 'acp_searchresults';

		if ($request->variable('action', '') === 'details')
		{
			$user->add_lang_ext('forumhulp/searchresults', 'info_acp_searchresults');
			$phpbb_container->get('forumhulp.helper')->detail('forumhulp/searchresults');
			$this->tpl_name = 'acp_ext_details';
			return;
		}

		$this->page_title = 'ACP_SR_MANAGE';
		$this->manage($id, $mode);
	}

	private function manage(string $id, string $mode): void
	{
		global $config, $db, $user, $auth, $template, $request, $phpbb_container;

		$start = max(0, $request->variable('start', 0));
		$delete_marked = $request->variable('delmarked', false, false, request_interface::POST);
		$delete_all = $request->variable('delall', false, false, request_interface::POST);
		$marked_ids = $this->normalise_ids(
			$request->variable('mark', [0], false, request_interface::POST)
		);
		$sort_key = $request->variable('sk', 'v');
		$sort_direction = $request->variable('sd', 'd') === 'a' ? 'a' : 'd';

		add_form_key(self::FORM_KEY);

		if ($delete_marked || $delete_all)
		{
			if (!$auth->acl_get('a_clearlogs'))
			{
				trigger_error($user->lang['NO_AUTH_OPERATION'], E_USER_WARNING);
			}

			if (confirm_box(true))
			{
				$this->delete_results($delete_all, $marked_ids);
				redirect($this->u_action);
			}

			if (!check_form_key(self::FORM_KEY))
			{
				trigger_error($user->lang['FORM_INVALID'], E_USER_WARNING);
			}

			confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields([
				'i' => $id,
				'start' => $start,
				'delmarked' => $delete_marked,
				'delall' => $delete_all,
				'mark' => $marked_ids,
				'sk' => $sort_key,
				'sd' => $sort_direction,
				'mode' => $mode,
			]));
		}

		$sort_columns = [
			'h' => 'search_keywords',
			'v' => 'hits',
			'f' => 'first_time',
			'l' => 'last_time',
		];
		if (!isset($sort_columns[$sort_key]))
		{
			$sort_key = 'v';
		}

		$phpbb_root_path = $phpbb_container->getParameter('core.root_path');
		$php_ext = $phpbb_container->getParameter('core.php_ext');
		$sql_sort = $sort_columns[$sort_key] . ($sort_direction === 'd' ? ' DESC' : ' ASC');
		$sql = 'SELECT search_key, search_keywords, hits, first_time, last_time, in_post
			FROM ' . $this->searchresults_table . '
			ORDER BY in_post DESC, ' . $sql_sort;
		$result = $db->sql_query_limit($sql, (int) $config['topics_per_page'], $start);

		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars((($row['in_post']) ? '' : 'not_') . 'found', [
				'ID' => (int) $row['search_key'],
				'SEARCHWORD' => htmlspecialchars($row['search_keywords'], ENT_QUOTES, 'UTF-8'),
				'HITS' => (int) $row['hits'],
				'FIRST' => $user->format_date((int) $row['first_time']),
				'LAST' => $user->format_date((int) $row['last_time']),
				'U_SEARCH' => append_sid(
					"{$phpbb_root_path}search.$php_ext",
					'keywords=' . urlencode($row['search_keywords'])
				),
			]);
		}
		$db->sql_freeresult($result);

		$sql = 'SELECT COUNT(search_key) AS total_entries
			FROM ' . $this->searchresults_table;
		$result = $db->sql_query($sql);
		$total_entries = (int) $db->sql_fetchfield('total_entries');
		$db->sql_freeresult($result);

		$base_url = $this->u_action . '&amp;sk=' . $sort_key . '&amp;sd=' . $sort_direction;
		$phpbb_container->get('pagination')->generate_template_pagination(
			$base_url,
			'pagination',
			'start',
			$total_entries,
			(int) $config['topics_per_page'],
			$start
		);

		$template->assign_vars([
			'U_ACTION' => $this->u_action,
			'S_SORT_KEY' => $sort_key,
			'S_SORT_DIR' => $sort_direction,
			'S_REFDEL' => $auth->acl_get('a_clearlogs'),
			'TOTAL_ENTRIES' => $total_entries,
		]);
	}

	private function delete_results(bool $delete_all, array $marked_ids): void
	{
		global $db;

		if ($delete_all)
		{
			$db->sql_query('DELETE FROM ' . $this->searchresults_table);
			add_log('admin', 'LOG_SR_REMOVED_ALL');
			return;
		}

		if (!$marked_ids)
		{
			return;
		}

		$sql_where = ' WHERE ' . $db->sql_in_set('search_key', $marked_ids);
		$sql = 'SELECT search_keywords
			FROM ' . $this->searchresults_table . $sql_where;
		$result = $db->sql_query($sql);
		$keywords = [];
		while ($row = $db->sql_fetchrow($result))
		{
			$keywords[] = $row['search_keywords'];
		}
		$db->sql_freeresult($result);

		$db->sql_query('DELETE FROM ' . $this->searchresults_table . $sql_where);
		add_log(
			'admin',
			'LOG_SR_REMOVED',
			implode(', ', array_unique($keywords)),
			(int) $db->sql_affectedrows()
		);
	}

	private function normalise_ids(array $ids): array
	{
		$normalised = [];
		foreach ($ids as $id)
		{
			$id = (int) $id;
			if ($id > 0)
			{
				$normalised[$id] = $id;
			}
		}

		return array_values($normalised);
	}
}
