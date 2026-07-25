<?php
/**
*
* @package phpBB Extension - Basic Stats
* @copyright (c) 2025 Stoker
* @copyright (c) 2015 OXPUS
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

declare(strict_types=1);

namespace stoker\basicstats\controller;

use phpbb\auth\auth;
use phpbb\cache\service as cache_interface;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\db\driver\driver_interface;
use phpbb\exception\http_exception;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Basic Stats front-end controller.
 *
 * Renders daily/monthly/yearly statistics with responsive, table-free markup.
 * Uses locale-aware number formatting based on language keys:
 * - DECIMAL_BS
 * - DECIMAL_SEPARATOR_BS
 * - THOUSANDS_SEPARATOR_BS
 *
 * Caching strategy:
 * - Cache by period bucket:
 * - Daily view  : one key per month (YYYY_MM)
 * - Monthly view: one key per year (YYYY) and one "all" key
 * - Yearly view : one "all years" key
 * - Only current periods use short TTL; past periods cache forever.
 * - Payloads are numbers-only (language-agnostic).
 *
 * Timezone note:
 * - phpBB stores all timestamps as UTC unix epochs. All internal period
 *   boundary/bucket math in this controller uses gmdate()/gmmktime() and the
 *   private gmgetdate() helper below (PHP has no native "gm" counterpart for
 *   getdate(), unlike date()/mktime()) so that "day 15", "month 8", "year
 *   2025" always mean the UTC calendar
 *   day/month/year - independent of the PHP server's default timezone and,
 *   for the MySQL fast path, independent of the MySQL session's time_zone
 *   setting too (see group_by_day/month/year - they bucket by
 *   FLOOR(unix_ts / 86400), a pure integer operation with no timezone
 *   conversion involved, and roll the buckets up to calendar labels in PHP).
 *   Only user-facing display labels go through $this->user->format_date(),
 *   which intentionally applies the viewing user's configured timezone.
 */
final class main
{
	private const CACHE_NS = 'bs_';
	private const TTL_D_CURRENT = 120;
	private const TTL_M_CURRENT = 300;
	private const TTL_M_ALL = 600;
	private const TTL_Y_ALL = 600;
	private const TTL_PERMANENT = 31536000; // 1 year

	protected driver_interface $db;
	protected helper $helper;
	protected language $language;
	protected request_interface $request;
	protected template $template;
	protected user $user;
	protected config $config;
	protected auth $auth;
	protected cache_interface $cache;
	protected string $u_action;

	/**
	 * @throws http_exception If user lacks permission u_basicstats_view
	 */
	public function __construct(driver_interface $db, helper $helper, language $language, request_interface $request, template $template, user $user, config $config, auth $auth, cache_interface $cache)
	{
		$this->db = $db;
		$this->helper = $helper;
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->auth = $auth;
		$this->cache = $cache;

		$this->u_action = $this->helper->route('stoker_basicstats');

		if (!$this->auth->acl_get('u_basicstats_view'))
		{
			throw new http_exception(403, 'NOT_AUTHORISED');
		}
	}

	/**
	 * Locale-aware number formatter.
	 *
	 * Uses DECIMAL_BS, DECIMAL_SEPARATOR_BS, THOUSANDS_SEPARATOR_BS.
	 * Clamps precision to 0..6 and suppresses decimals for whole numbers.
	 */
	protected function format_number(float $value): string
	{
		$decimals = (int) $this->language->lang('DECIMAL_BS');
		$decimal_separator = (string) $this->language->lang('DECIMAL_SEPARATOR_BS');
		$thousands_separator = (string) $this->language->lang('THOUSANDS_SEPARATOR_BS');

		if ($decimals < 0)
		{
			$decimals = 0;
		}
		if ($decimals > 6)
		{
			$decimals = 6;
		}

		if ($decimals === 0 || round($value, $decimals) === floor($value))
		{
			return number_format($value, 0, $decimal_separator, $thousands_separator);
		}

		return number_format($value, $decimals, $decimal_separator, $thousands_separator);
	}

	public function handle(string $view = ''): Response
	{
		$mode = $this->request->variable('mode', 'm');
		if (!in_array($mode, ['d', 'm', 'y'], true))
		{
			$mode = 'm';
		}

		$s_month = $this->request->variable('s_month', '');
		$ym = $this->request->variable('ym', '');
		if ($ym !== '')
		{
			$s_month = $ym;
		}
		$s_year = trim($this->request->variable('s_year', ''));
		$now = time();
		$now_info = $this->gmgetdate($now);

		switch ($mode)
		{
			case 'd':
				$current_time = $now_info;
				$board_starttime = $this->gmgetdate((int) $this->config['board_startdate']);

				if ($s_month === '')
				{
					$s_month = gmdate('n-Y', $current_time[0]);
				}

				[$sel_mon, $sel_year] = array_map('intval', explode('-', $s_month, 2));

				if ($sel_mon === (int) $current_time['mon'] && $sel_year === (int) $current_time['year'])
				{
					$start_ts = ($board_starttime['mon'] === $current_time['mon'] && $board_starttime['year'] === $current_time['year'])
						? $board_starttime[0]
						: gmmktime(0, 0, 0, $current_time['mon'], 1, $current_time['year']);
					$end_ts = $current_time[0];
				}
				else
				{
					$start_ts = ($sel_mon === (int) $board_starttime['mon'] && $sel_year === (int) $board_starttime['year']) ? $board_starttime[0] : gmmktime(0, 0, 0, $sel_mon, 1, $sel_year);
					$end_ts = gmmktime(0, 0, 0, $sel_mon + 1, 1, $sel_year);
				}

				$start_info = $this->gmgetdate($start_ts);
				$end_info = $this->gmgetdate($end_ts);
				$first_day = (int) $start_info['mday'];
				$last_day = (int) gmdate('j', $end_info[0] - 1);
				$counted_days = max(0, $last_day - $first_day + 1);

				$is_current_month = ($sel_year === (int) $current_time['year'] && $sel_mon === (int) $current_time['mon']);

				$ckey = $this->key_d($sel_year, $sel_mon);
				$pack = $this->cache_get($ckey);

				if ($pack === false)
				{
					$topics_by_day = $this->group_by_day(TOPICS_TABLE, 'topic_time', 'topic_visibility = ' . ITEM_APPROVED, $start_ts, $end_ts);
					$posts_by_day = $this->group_by_day(POSTS_TABLE, 'post_time', 'post_visibility = ' . ITEM_APPROVED, $start_ts, $end_ts);
					$regs_where = $this->db->sql_in_set('user_type', [USER_NORMAL, USER_FOUNDER]);
					$regs_by_day = $this->group_by_day(USERS_TABLE, 'user_regdate', $regs_where, $start_ts, $end_ts);

					$pack = [
						'topics'   => $topics_by_day,
						'posts'    => $posts_by_day,
						'user_reg' => $regs_by_day,
					];
					$this->cache_put($ckey, $pack, $is_current_month ? self::TTL_D_CURRENT : 0);
				}

				$daily_data = [];
				for ($d = $first_day; $d <= $last_day; $d++)
				{
					$daily_data[$d] = [
						'topics'   => (int) ($pack['topics'][$d] ?? 0),
						'posts'    => (int) ($pack['posts'][$d] ?? 0),
						'user_reg' => (int) ($pack['user_reg'][$d] ?? 0),
					];
				}

				$totals = ['topics' => 0, 'posts' => 0, 'user_reg' => 0];
				$max = ['topics' => 0, 'posts' => 0, 'user_reg' => 0];

				foreach ($daily_data as $data)
				{
					$totals['topics'] += $data['topics'];
					$totals['posts'] += $data['posts'];
					$totals['user_reg'] += $data['user_reg'];

					$max['topics'] = max($max['topics'], $data['topics']);
					$max['posts'] = max($max['posts'], $data['posts']);
					$max['user_reg'] = max($max['user_reg'], $data['user_reg']);
				}

				if ($totals['topics'])
				{
					$this->template->assign_var('S_DAILY_TOPICS', true);
					foreach ($daily_data as $day => $data)
					{
						$cnt = (float) $data['topics'];
						$pct = ($totals['topics'] > 0.0) ? ($cnt * 100.0 / $totals['topics']) : 0.0;
						$bar = ($max['topics'] > 0.0) ? ($cnt * 100.0 / $max['topics']) : 0.0;

						$this->template->assign_block_vars('periodic_topics_row', [
							'TIME_ELEMENT' => $this->user->format_date(gmmktime(0, 0, 0, $sel_mon, (int) $day, $sel_year), 'd F Y'),
							'COUNT'        => $this->format_number($cnt),
							'PCT'          => $this->format_number($pct),
							'BARWIDTH'     => sprintf('%.1f', $bar),
							'IS_MAX'       => ($data['topics'] == $max['topics']),
						]);
					}
				}

				if ($totals['posts'])
				{
					$this->template->assign_var('S_DAILY_POSTS', true);
					foreach ($daily_data as $day => $data)
					{
						$cnt = (float) $data['posts'];
						$pct = ($totals['posts'] > 0.0) ? ($cnt * 100.0 / $totals['posts']) : 0.0;
						$bar = ($max['posts'] > 0.0) ? ($cnt * 100.0 / $max['posts']) : 0.0;

						$this->template->assign_block_vars('periodic_posts_row', [
							'TIME_ELEMENT' => $this->user->format_date(gmmktime(0, 0, 0, $sel_mon, (int) $day, $sel_year), 'd F Y'),
							'COUNT'        => $this->format_number($cnt),
							'PCT'          => $this->format_number($pct),
							'BARWIDTH'     => sprintf('%.1f', $bar),
							'IS_MAX'       => ($data['posts'] == $max['posts']),
						]);
					}
				}

				if ($totals['user_reg'])
				{
					$this->template->assign_var('S_DAILY_USER_REGS', true);
					foreach ($daily_data as $day => $data)
					{
						$cnt = (float) $data['user_reg'];
						$pct = ($totals['user_reg'] > 0.0) ? ($cnt * 100.0 / $totals['user_reg']) : 0.0;
						$bar = ($max['user_reg'] > 0.0) ? ($cnt * 100.0 / $max['user_reg']) : 0.0;

						$this->template->assign_block_vars('periodic_user_regs_row', [
							'TIME_ELEMENT' => $this->user->format_date(gmmktime(0, 0, 0, $sel_mon, (int) $day, $sel_year), 'd F Y'),
							'COUNT'        => $this->format_number($cnt),
							'PCT'          => $this->format_number($pct),
							'BARWIDTH'     => sprintf('%.1f', $bar),
							'IS_MAX'       => ($data['user_reg'] == $max['user_reg']),
						]);
					}
				}

				$month_options = [];
				$temp_month = (int) $board_starttime['mon'];
				while (($temp_epoch = gmmktime(0, 0, 0, $temp_month, 1, (int) $board_starttime['year'])) <= $current_time[0])
				{
					$value = gmdate('n-Y', $temp_epoch);
					$label = $this->user->format_date($temp_epoch, 'F Y');
					$month_options[$value] = $label;
					$temp_month++;
				}

				$selected_month = $sel_mon . '-' . $sel_year;
				foreach ($month_options as $value => $label)
				{
					$this->template->assign_block_vars('bs_month_options', [
						'VALUE'    => $value,
						'LABEL'    => $label,
						'SELECTED' => ($value === $selected_month),
					]);
				}

				$u_bs_action = $this->u_action . '?mode=d';
				$board_min_ts = gmmktime(0, 0, 0, (int) $board_starttime['mon'], 1, (int) $board_starttime['year']);
				$current_month_ts = gmmktime(0, 0, 0, (int) $current_time['mon'], 1, (int) $current_time['year']);
				$sel_ts = gmmktime(0, 0, 0, $sel_mon, 1, $sel_year);
				$prev_ts = gmmktime(0, 0, 0, $sel_mon - 1, 1, $sel_year);
				$next_ts = gmmktime(0, 0, 0, $sel_mon + 1, 1, $sel_year);

				$prev_url = ($prev_ts >= $board_min_ts) ? $this->u_action . '?mode=d&s_month=' . gmdate('n-Y', $prev_ts) : '';
				$next_url = ($next_ts <= $current_month_ts) ? $this->u_action . '?mode=d&s_month=' . gmdate('n-Y', $next_ts) : '';

				$this->template->assign_vars([
					'AVG_TOPICS'          => $this->format_number($totals['topics'] / max(1, $counted_days)),
					'AVG_POSTS'           => $this->format_number($totals['posts'] / max(1, $counted_days)),
					'AVG_USER_REGS'       => $this->format_number($totals['user_reg'] / max(1, $counted_days)),
					'STATS_MONTH_EXPLAIN' => sprintf($this->language->lang('BS_STATS_MONTH_EXPLAIN'), $this->user->format_date($start_ts, 'F Y')),
					'U_BS_ACTION'         => $u_bs_action,
					'BS_PREV_URL'         => $prev_url,
					'BS_NEXT_URL'         => $next_url,
				]);
			break;

			case 'm':
				$show_all = false;
				$current_time = $now_info;
				$board_starttime = $this->gmgetdate((int) $this->config['board_startdate']);

				if ($s_year === '')
				{
					$s_year = (string) $current_time['year'];
				}
				elseif ($s_year === 'all')
				{
					$show_all = true;
				}
				$selected_year = $show_all ? 'all' : (string) $s_year;

				if ($show_all)
				{
					$start_ts = $board_starttime[0];
					$end_ts = $current_time[0];
				}
				else
				{
					$sy = (int) $s_year;
					$start_ts = ($sy === (int) $board_starttime['year']) ? $board_starttime[0] : gmmktime(0, 0, 0, 1, 1, $sy);
					$end_ts = ($sy === (int) $current_time['year']) ? $current_time[0] : gmmktime(0, 0, 0, 1, 1, $sy + 1);
				}

				$start_info = $this->gmgetdate($start_ts);
				$end_info = $this->gmgetdate($end_ts);

				$months = [];
				$counted_months = 0;
				$offset = $start_info[0];

				while ($offset < $end_info[0])
				{
					$key = gmdate('Y-m', $offset);
					$label = $this->user->format_date($offset, 'F Y');
					$months[$key] = ['label' => $label, 'topics' => 0, 'posts' => 0, 'user_reg' => 0];

					$counted_months++;
					$offset = gmmktime(0, 0, 0, $start_info['mon'] + $counted_months, 1, $start_info['year']);
				}

				$ckey = $show_all ? $this->key_m_all() : $this->key_m_year((int) $s_year);
				$pack = $this->cache_get($ckey);

				if ($pack === false)
				{
					$topics_by_month = $this->group_by_month(TOPICS_TABLE, 'topic_time', 'topic_visibility = ' . ITEM_APPROVED, $show_all ? null : $start_ts, $show_all ? null : $end_ts);
					$posts_by_month = $this->group_by_month(POSTS_TABLE, 'post_time', 'post_visibility = ' . ITEM_APPROVED, $show_all ? null : $start_ts, $show_all ? null : $end_ts);
					$regs_where = $this->db->sql_in_set('user_type', [USER_NORMAL, USER_FOUNDER]);
					$regs_by_month = $this->group_by_month(USERS_TABLE, 'user_regdate', $regs_where, $show_all ? null : $start_ts, $show_all ? null : $end_ts);

					$pack = [
						'topics'   => $topics_by_month,
						'posts'    => $posts_by_month,
						'user_reg' => $regs_by_month,
					];

					if ($show_all)
					{
						$this->cache_put($ckey, $pack, self::TTL_M_ALL);
					}
					else
					{
						$is_current_year = ((int) $s_year === (int) $current_time['year']);
						$this->cache_put($ckey, $pack, $is_current_year ? self::TTL_M_CURRENT : 0);
					}
				}

				foreach ($pack['topics'] as $ym => $cnt)
				{
					if (isset($months[$ym]))
					{
					$months[$ym]['topics'] = (int) $cnt;
					}
				}
				foreach ($pack['posts'] as $ym => $cnt)
				{
					if (isset($months[$ym]))
					{
					$months[$ym]['posts'] = (int) $cnt;
					}
				}
				foreach ($pack['user_reg'] as $ym => $cnt)
				{
					if (isset($months[$ym]))
					{
					$months[$ym]['user_reg'] = (int) $cnt;
					}
				}

				$totals = ['topics' => 0, 'posts' => 0, 'user_reg' => 0];
				$max = ['topics' => 0, 'posts' => 0, 'user_reg' => 0];

				foreach ($months as $mdata)
				{
					$totals['topics'] += $mdata['topics'];
					$totals['posts'] += $mdata['posts'];
					$totals['user_reg'] += $mdata['user_reg'];

					$max['topics'] = max($max['topics'], $mdata['topics']);
					$max['posts'] = max($max['posts'], $mdata['posts']);
					$max['user_reg'] = max($max['user_reg'], $mdata['user_reg']);
				}

				if ($totals['topics'])
				{
					$this->template->assign_var('S_MONTHLY_TOPICS', true);
					foreach ($months as $mdata)
					{
						$cnt = (float) $mdata['topics'];
						$pct = ($totals['topics'] > 0.0) ? ($cnt * 100.0 / $totals['topics']) : 0.0;
						$bar = ($max['topics'] > 0.0) ? ($cnt * 100.0 / $max['topics']) : 0.0;

						$this->template->assign_block_vars('periodic_topics_row', [
							'TIME_ELEMENT' => $mdata['label'],
							'COUNT'        => $this->format_number($cnt),
							'PCT'          => $this->format_number($pct),
							'BARWIDTH'     => sprintf('%.1f', $bar),
							'IS_MAX'       => ($mdata['topics'] == $max['topics']),
						]);
					}
				}

				if ($totals['posts'])
				{
					$this->template->assign_var('S_MONTHLY_POSTS', true);
					foreach ($months as $mdata)
					{
						$cnt = (float) $mdata['posts'];
						$pct = ($totals['posts'] > 0.0) ? ($cnt * 100.0 / $totals['posts']) : 0.0;
						$bar = ($max['posts'] > 0.0) ? ($cnt * 100.0 / $max['posts']) : 0.0;

						$this->template->assign_block_vars('periodic_posts_row', [
							'TIME_ELEMENT' => $mdata['label'],
							'COUNT'        => $this->format_number($cnt),
							'PCT'          => $this->format_number($pct),
							'BARWIDTH'     => sprintf('%.1f', $bar),
							'IS_MAX'       => ($mdata['posts'] == $max['posts']),
						]);
					}
				}

				if ($totals['user_reg'])
				{
					$this->template->assign_var('S_MONTHLY_USER_REGS', true);
					foreach ($months as $mdata)
					{
						$cnt = (float) $mdata['user_reg'];
						$pct = ($totals['user_reg'] > 0.0) ? ($cnt * 100.0 / $totals['user_reg']) : 0.0;
						$bar = ($max['user_reg'] > 0.0) ? ($cnt * 100.0 / $max['user_reg']) : 0.0;

						$this->template->assign_block_vars('periodic_user_regs_row', [
							'TIME_ELEMENT' => $mdata['label'],
							'COUNT'        => $this->format_number($cnt),
							'PCT'          => $this->format_number($pct),
							'BARWIDTH'     => sprintf('%.1f', $bar),
							'IS_MAX'       => ($mdata['user_reg'] == $max['user_reg']),
						]);
					}
				}

				$year_options = [];
				$temp_year = (int) $board_starttime['year'];
				while ($temp_year <= (int) $current_time['year'])
				{
					$year_options[(string) $temp_year] = (string) $temp_year;
					$temp_year++;
				}
				$year_options['all'] = $this->language->lang('BS_ALL_YEARS');

				foreach ($year_options as $value => $label)
				{
					$this->template->assign_block_vars('bs_year_options', [
						'VALUE'    => (string) $value,
						'LABEL'    => $label,
						'SELECTED' => ((string) $value === (string) $selected_year) ? 1 : 0,
					]);
				}

				$u_bs_action = $this->u_action . '?mode=m';

				$board_year = (int) $board_starttime['year'];
				$current_year = (int) $current_time['year'];

				if ($show_all)
				{
					$prev_url = '';
					$next_url = '';
				}
				else
				{
					$sy = (int) $s_year;
					$prev_url = ($sy - 1 >= $board_year) ? $this->u_action . '?mode=m&s_year=' . ($sy - 1) : '';
					$next_url = ($sy + 1 <= $current_year) ? $this->u_action . '?mode=m&s_year=' . ($sy + 1) : '';
				}

				$this->template->assign_vars([
					'AVG_TOPICS'         => $this->format_number($totals['topics'] / max(1, $counted_months)),
					'AVG_POSTS'          => $this->format_number($totals['posts'] / max(1, $counted_months)),
					'AVG_USER_REGS'      => $this->format_number($totals['user_reg'] / max(1, $counted_months)),
					'STATS_YEAR_EXPLAIN' => sprintf($this->language->lang('BS_STATS_YEAR_EXPLAIN'), ($start_info['year'] != $current_time['year']) ? ($show_all ? $start_info['year'] . ' - ' . $current_time['year'] : $start_info['year']) : $current_time['year']),
					'U_BS_ACTION'        => $u_bs_action,
					'BS_PREV_URL'        => $prev_url,
					'BS_NEXT_URL'        => $next_url,
				]);
			break;

			case 'y':
				$current_time = $now_info;
				$board_starttime = $this->gmgetdate((int) $this->config['board_startdate']);

				$start_info = $this->gmgetdate($board_starttime[0]);
				$end_info = $current_time;

				$years = [];
				$counted_years = 0;
				$offset = $start_info[0];

				while ($offset < $end_info[0])
				{
					$label = gmdate('Y', $offset);
					$years[$label] = ['topics' => 0, 'posts' => 0, 'user_reg' => 0];

					$counted_years++;
					$offset = gmmktime(0, 0, 0, 1, 1, (int) $start_info['year'] + $counted_years);
				}

				$ckey = $this->key_y_all();
				$pack = $this->cache_get($ckey);

				if ($pack === false)
				{
					$topics_by_year = $this->group_by_year(TOPICS_TABLE, 'topic_time', 'topic_visibility = ' . ITEM_APPROVED);
					$posts_by_year = $this->group_by_year(POSTS_TABLE, 'post_time', 'post_visibility = ' . ITEM_APPROVED);
					$regs_where = $this->db->sql_in_set('user_type', [USER_NORMAL, USER_FOUNDER]);
					$regs_by_year = $this->group_by_year(USERS_TABLE, 'user_regdate', $regs_where);

					$pack = [
						'topics'   => $topics_by_year,
						'posts'    => $posts_by_year,
						'user_reg' => $regs_by_year,
					];
					$this->cache_put($ckey, $pack, self::TTL_Y_ALL);
				}

				foreach ($pack['topics'] as $ykey => $cnt)
				{
					if (isset($years[$ykey]))
					{
					$years[$ykey]['topics'] = (int) $cnt;
					}
				}
				foreach ($pack['posts'] as $ykey => $cnt)
				{
					if (isset($years[$ykey]))
					{
					$years[$ykey]['posts'] = (int) $cnt;
					}
				}
				foreach ($pack['user_reg'] as $ykey => $cnt)
				{
					if (isset($years[$ykey]))
					{
					$years[$ykey]['user_reg'] = (int) $cnt;
					}
				}

				$totals = ['topics' => 0, 'posts' => 0, 'user_reg' => 0];
				$max = ['topics' => 0, 'posts' => 0, 'user_reg' => 0];

				foreach ($years as $data)
				{
					$totals['topics'] += $data['topics'];
					$totals['posts'] += $data['posts'];
					$totals['user_reg'] += $data['user_reg'];

					$max['topics'] = max($max['topics'], $data['topics']);
					$max['posts'] = max($max['posts'], $data['posts']);
					$max['user_reg'] = max($max['user_reg'], $data['user_reg']);
				}

				if ($totals['topics'])
				{
					$this->template->assign_var('S_YEARLY_TOPICS', true);
					foreach ($years as $year => $data)
					{
						$cnt = (float) $data['topics'];
						$pct = ($totals['topics'] > 0.0) ? ($cnt * 100.0 / $totals['topics']) : 0.0;
						$bar = ($max['topics'] > 0.0) ? ($cnt * 100.0 / $max['topics']) : 0.0;

						$this->template->assign_block_vars('periodic_topics_row', [
							'TIME_ELEMENT' => $year,
							'COUNT'        => $this->format_number($cnt),
							'PCT'          => $this->format_number($pct),
							'BARWIDTH'     => sprintf('%.1f', $bar),
							'IS_MAX'       => ($data['topics'] == $max['topics']),
						]);
					}
				}

				if ($totals['posts'])
				{
					$this->template->assign_var('S_YEARLY_POSTS', true);
					foreach ($years as $year => $data)
					{
						$cnt = (float) $data['posts'];
						$pct = ($totals['posts'] > 0.0) ? ($cnt * 100.0 / $totals['posts']) : 0.0;
						$bar = ($max['posts'] > 0.0) ? ($cnt * 100.0 / $max['posts']) : 0.0;

						$this->template->assign_block_vars('periodic_posts_row', [
							'TIME_ELEMENT' => $year,
							'COUNT'        => $this->format_number($cnt),
							'PCT'          => $this->format_number($pct),
							'BARWIDTH'     => sprintf('%.1f', $bar),
							'IS_MAX'       => ($data['posts'] == $max['posts']),
						]);
					}
				}

				if ($totals['user_reg'])
				{
					$this->template->assign_var('S_YEARLY_USER_REGS', true);
					foreach ($years as $year => $data)
					{
						$cnt = (float) $data['user_reg'];
						$pct = ($totals['user_reg'] > 0.0) ? ($cnt * 100.0 / $totals['user_reg']) : 0.0;
						$bar = ($max['user_reg'] > 0.0) ? ($cnt * 100.0 / $max['user_reg']) : 0.0;

						$this->template->assign_block_vars('periodic_user_regs_row', [
							'TIME_ELEMENT' => $year,
							'COUNT'        => $this->format_number($cnt),
							'PCT'          => $this->format_number($pct),
							'BARWIDTH'     => sprintf('%.1f', $bar),
							'IS_MAX'       => ($data['user_reg'] == $max['user_reg']),
						]);
					}
				}

				$this->template->assign_vars([
					'AVG_TOPICS'         => $this->format_number($totals['topics'] / max(1, $counted_years)),
					'AVG_POSTS'          => $this->format_number($totals['posts'] / max(1, $counted_years)),
					'AVG_USER_REGS'      => $this->format_number($totals['user_reg'] / max(1, $counted_years)),
					'STATS_YEAR_EXPLAIN' => sprintf($this->language->lang('BS_STATS_YEAR_EXPLAIN'), $start_info['year'] . ' - ' . $current_time['year']),
				]);
			break;
		}

		$page_title = $this->language->lang(strtoupper($mode . '_view_bs'));

		$this->template->assign_vars([
			'L_TITLE'           => $this->language->lang('BS_BASIC_STATS'),
			'S_IN_BASICSTATS'   => true,
			'TOTAL_TOPICSBS'    => $this->format_number((float) $totals['topics']),
			'TOTAL_POSTSBS'     => $this->format_number((float) $totals['posts']),
			'TOTAL_USER_REGSBS' => $this->format_number((float) $totals['user_reg']),
			'BASICSTATS_CREDIT' => '<a href="https://phpbb3bbcodes.com">' . $this->language->lang('BS_BASICSTATS_COPY') . '</a>',
			'BS_MODE'           => $mode,
			'U_D_MODE'          => $this->u_action . '?mode=d',
			'U_M_MODE'          => $this->u_action . '?mode=m',
			'U_Y_MODE'          => $this->u_action . '?mode=y',
			'S_FORM_ACTION'     => $this->u_action . '?mode=' . $mode,
			'AS_ON'             => sprintf($this->language->lang('BS_AS_ON'), $this->user->format_date(time())),
		]);

		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'   => $this->language->lang('BS_BASIC_STATS'),
			'U_VIEW_FORUM' => $this->helper->route('stoker_basicstats'),
		]);

		$tpl_map = [
			'd' => '@stoker_basicstats/basicstats_day.html',
			'm' => '@stoker_basicstats/basicstats_month.html',
			'y' => '@stoker_basicstats/basicstats_year.html',
		];

		return $this->helper->render($tpl_map[$mode], $page_title);
	}

	public function redirect(): Response
	{
		return new RedirectResponse($this->helper->route('stoker_basicstats'), 301);
	}

	/**
	 * Group counts by day-of-month (1..31) for a given UTC time window.
	 *
	 * MySQL path buckets by FLOOR(unix_ts / 86400) - a pure integer division,
	 * with no timezone conversion involved - then resolves each bucket back
	 * to a day-of-month using gmdate() in PHP. This intentionally avoids
	 * FROM_UNIXTIME()/DATE_FORMAT(), whose output depends on the MySQL
	 * session's time_zone and could otherwise disagree with the UTC-based
	 * $start/$end window boundaries computed above.
	 */
	private function group_by_day(string $table, string $timeCol, string $where, int $start, int $end): array
	{
		$this->validate_table($table);
		$out = [];

		if ($this->is_mysql())
		{
			$sql = "SELECT FLOOR($timeCol / 86400) AS bucket, COUNT(*) AS c
				FROM $table
				WHERE $where
					AND $timeCol >= " . (int) $start . "
					AND $timeCol < " . (int) $end . '
				GROUP BY bucket';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$d = (int) gmdate('j', ((int) $row['bucket']) * 86400);
				$out[$d] = ($out[$d] ?? 0) + (int) $row['c'];
			}
			$this->db->sql_freeresult($result);
			return $out;
		}

		$sql = "SELECT $timeCol AS t
			FROM $table
			WHERE $where
				AND $timeCol >= " . (int) $start . "
				AND $timeCol < " . (int) $end;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$d = (int) gmdate('j', (int) $row['t']);
			$out[$d] = ($out[$d] ?? 0) + 1;
		}
		$this->db->sql_freeresult($result);
		return $out;
	}

	/**
	 * Group counts by month (YYYY-mm) for an optional UTC time window.
	 *
	 * Same FLOOR(unix_ts / 86400) day-bucket trick as group_by_day(), rolled
	 * up to a Y-m label with gmdate() in PHP - see group_by_day() docblock
	 * for why this avoids FROM_UNIXTIME()/DATE_FORMAT().
	 */
	private function group_by_month(string $table, string $timeCol, string $where, ?int $start, ?int $end): array
	{
		$this->validate_table($table);
		$out = [];

		if ($this->is_mysql())
		{
			$sql = "SELECT FLOOR($timeCol / 86400) AS bucket, COUNT(*) AS c
				FROM $table
				WHERE $where";
			if ($start !== null)
			{
			$sql .= ' AND ' . $timeCol . ' >= ' . (int) $start;
			}
			if ($end !== null)
			{
			$sql .= ' AND ' . $timeCol . ' < ' . (int) $end;
			}
			$sql .= ' GROUP BY bucket';

			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$ym = gmdate('Y-m', ((int) $row['bucket']) * 86400);
				$out[$ym] = ($out[$ym] ?? 0) + (int) $row['c'];
			}
			$this->db->sql_freeresult($result);
			return $out;
		}

		$sql = "SELECT $timeCol AS t
			FROM $table
			WHERE $where";
		if ($start !== null)
		{
		$sql .= ' AND ' . $timeCol . ' >= ' . (int) $start;
		}
		if ($end !== null)
		{
		$sql .= ' AND ' . $timeCol . ' < ' . (int) $end;
		}

		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ym = gmdate('Y-m', (int) $row['t']);
			$out[$ym] = ($out[$ym] ?? 0) + 1;
		}
		$this->db->sql_freeresult($result);
		return $out;
	}

	/**
	 * Group counts by year (YYYY).
	 *
	 * Same FLOOR(unix_ts / 86400) day-bucket trick as group_by_day(), rolled
	 * up to a Y label with gmdate() in PHP - see group_by_day() docblock for
	 * why this avoids FROM_UNIXTIME()/DATE_FORMAT().
	 */
	private function group_by_year(string $table, string $timeCol, string $where): array
	{
		$this->validate_table($table);
		$out = [];

		if ($this->is_mysql())
		{
			$sql = "SELECT FLOOR($timeCol / 86400) AS bucket, COUNT(*) AS c
				FROM $table
				WHERE $where
				GROUP BY bucket";
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$y = gmdate('Y', ((int) $row['bucket']) * 86400);
				$out[$y] = ($out[$y] ?? 0) + (int) $row['c'];
			}
			$this->db->sql_freeresult($result);
			return $out;
		}

		$sql = "SELECT $timeCol AS t
			FROM $table
			WHERE $where";
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$y = gmdate('Y', (int) $row['t']);
			$out[$y] = ($out[$y] ?? 0) + 1;
		}
		$this->db->sql_freeresult($result);
		return $out;
	}

	private function is_mysql(): bool
	{
		$layer = method_exists($this->db, 'get_sql_layer') ? $this->db->get_sql_layer() : ($this->db->sql_layer ?? '');
		$layer = strtolower((string) $layer);
		return strpos($layer, 'mysql') !== false;
	}

	private function validate_table(string $table): void
	{
		if (!in_array($table, [TOPICS_TABLE, POSTS_TABLE, USERS_TABLE], true))
		{
			throw new \InvalidArgumentException('Invalid table: ' . $table);
		}
	}

	private function key_d(int $year, int $mon): string
	{
		return '_' . self::CACHE_NS . 'd_' . sprintf('%04d_%02d', $year, $mon);
	}

	private function key_m_year(int $year): string
	{
		return '_' . self::CACHE_NS . 'm_' . sprintf('%04d', $year);
	}

	private function key_m_all(): string
	{
		return '_' . self::CACHE_NS . 'm_all';
	}

	private function key_y_all(): string
	{
		return '_' . self::CACHE_NS . 'y_all';
	}

	private function cache_get(string $key)
	{
		return $this->cache->get($key);
	}

	/**
	 * Put payload to cache with TTL.
	 * TTL of 0 means permanent (stored as 1 year).
	 */
	private function cache_put(string $key, array $data, int $ttl = 0): void
	{
		$ttl = ($ttl === 0) ? self::TTL_PERMANENT : $ttl;
		$this->cache->put($key, $data, $ttl);
	}

	/**
	 * Get date/time information in UTC (GMT).
	 *
	 * @param int $timestamp
	 * @return array
	 */
	private function gmgetdate(int $timestamp): array
	{
		return [
			'seconds' => (int) gmdate('s', $timestamp),
			'minutes' => (int) gmdate('i', $timestamp),
			'hours'   => (int) gmdate('G', $timestamp),
			'mday'    => (int) gmdate('j', $timestamp),
			'wday'    => (int) gmdate('w', $timestamp),
			'mon'     => (int) gmdate('n', $timestamp),
			'year'    => (int) gmdate('Y', $timestamp),
			'yday'    => (int) gmdate('z', $timestamp),
			'weekday' => gmdate('l', $timestamp),
			'month'   => gmdate('F', $timestamp),
			0         => $timestamp,
		];
	}
}
