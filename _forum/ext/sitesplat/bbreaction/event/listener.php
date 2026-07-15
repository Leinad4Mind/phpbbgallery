<?php

/**
 *
 * BBReaction
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbreaction\event;

/**
 * @ignore
 */

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\config\config;
use phpbb\db\driver\driver_interface as db;
use phpbb\user;
use phpbb\auth\auth;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\controller\helper;
use phpbb\event\dispatcher_interface as phpbb_dispatcher;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'										 => 'add_page_header_link',
			'core.permissions'									 => 'add_permission',
			'core.viewtopic_modify_post_row'					 => 'viewtopic_handle_posts',
			'core.viewtopic_assign_template_vars_before'	 => 'view_topic_topic',
			'core.delete_posts_after'							 => 'delete_like_dislike',
			'core.memberlist_view_profile'					 => 'modify_profile',
			'core.delete_forum_content_before_query'		 => 'delete_like_dislike_forum',
			'core.delete_user_before'							 => 'delete_like_dislike_user',
		];
	}

	/* @var \phpbb\config\config*/
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\request */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\event\dispatcher_interface */
	protected $phpbb_dispatcher;

	/** @var string The database table the reactions are stored in */
	protected $reward_table;

	/** @var string The database table the reaction types are stored in */
	protected $reward_type_table;

	/** @var string The database table the posts are stored in */
	protected $posts_table;

	/** @var string The database table the topics are stored in */
	protected $topics_table;


	public function __construct(config $config, db $db, user $user, auth $auth, request $request, template $template, helper $helper, phpbb_dispatcher $phpbb_dispatcher, $reward_table, $reward_type_table, $posts_table, $topics_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->user = $user;
		$this->auth = $auth;
		$this->request = $request;
		$this->template = $template;
		$this->helper = $helper;
		$this->phpbb_dispatcher = $phpbb_dispatcher;
		$this->reward_table = $reward_table;
		$this->reward_type_table = $reward_type_table;
		$this->posts_table = $posts_table;
		$this->topics_table = $topics_table;

		/**
		 * Event to run code at the end of listener constructor
		 *
		 * @event sitesplat.bbreaction.listener_construct
		 * @since 1.3.0
		 */
		extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbreaction.listener_construct'));
	}

	public function add_page_header_link($event)
	{
		$this->user->add_lang_ext('sitesplat/bbreaction', 'bbreaction');

		$this->template->assign_vars([
			//	'U_BBREACTION_PAGE'			 => $this->helper->route('sitesplat_bbreaction_main_controller', ['route' => 'toplist.html']),
			'U_BBREACTION_PAGE'			 => ($this->auth->acl_get('u_bbreaction_module')) ? $this->helper->route('sitesplat_bbreaction_main_controller', ['route' => 'toplist.html']) : '',
			'U_BBREACTION_VIEW'			=> $this->auth->acl_get('u_bbreaction'),
			'BBREACTION_DISPLAY_TOP'	 => $this->config['rewards_display_top'],
			'BBREACTION_DISPLAY_TOP_SHOW'	 => $this->config['rewards_display_top_show']
		]);
	}

	public function viewtopic_handle_posts($event)
	{
		if (($this->config['rewards_allow_locked'] || $event['topic_data']['topic_status'] != ITEM_LOCKED) &&
			($this->config['rewards_allow_global'] || $event['topic_data']['topic_type'] != POST_GLOBAL) &&
			($this->config['rewards_button_position'] == 0 ||
				($this->config['rewards_button_position'] == 1 && $event['post_row']['S_FIRST_POST']) ||
				($this->config['rewards_button_position'] == 2 && !$event['post_row']['S_FIRST_POST'])
			)
		) {
			$post_row['enable_rewards'] = true;
			$this->user->add_lang_ext('sitesplat/bbreaction', 'bbreaction');
			$positive = $negative = 0;
			$post_row = $event['post_row'];

			$sql = 'SELECT COUNT(r.like_id) AS total FROM ' . $this->reward_table . ' r
					INNER JOIN ' . $this->reward_type_table . ' t ON t.type_id = like_type and t.active = 1
					WHERE r.post_id = ' . $post_row['POST_ID'];
			$result = $this->db->sql_query($sql);
			$total = $this->db->sql_fetchfield('total');

			$sql = 'SELECT *, (SELECT COUNT(1) FROM ' . $this->reward_table . ' WHERE like_type = type_id AND post_id = ' . $post_row['POST_ID'] . ') AS percent 
					FROM ' . $this->reward_type_table . ' 
					WHERE active = 1 
					ORDER BY weight ASC';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result)) {

				$sql = 'SELECT t.* FROM ' . $this->reward_table . ' r
				INNER JOIN ' . $this->reward_type_table . ' t ON t.type_id = r.like_type AND t.active = 1
				WHERE r.post_id = ' . $post_row['POST_ID'] .
					' AND r.user_id = ' . $this->user->data['user_id'] .
					' AND t.symbol = "' . $row['symbol'] .
					'"';
				$noresult = $this->db->sql_query($sql);
				$isActive = $this->db->sql_fetchfield('symbol');

				$ary_tpl = [
					'TYPE_ID'		=> $row['type_id'],
					'SYMBOL'		=> $row['symbol'],
					'ACTIVE'		=> $isActive,
					'TITLE'			=> $row['title'],
					'PERCENT'		=> ($this->config['rewards_percent']) ? (($row['percent']) ? round(($row['percent'] / $total) * 100, 1)  : 0) . ' %' : '# ' . $row['percent'],
					'S_POSITIVE'	=> ($row['positive']) ? true : false,
					'SEPARATOR'		=> ($row['seperator']) ? true : false,
					'U_LIKE'		=> append_sid($this->helper->route(
						'sitesplat_bbreaction_main_controller',
						['route' => 'index.html', 'p=' . $post_row['POST_ID'], 'e=' . $row['type_id']]
					)),

					'CLASSLIST'	=> 'fa ' . $row['symbol'],
					'CONTENTS'	=> '',
				];

				/**
				 * Event to modify reward template variables
				 *
				 * @event sitesplat.bbreaction.listener_viewtopic_handle_posts
				 * @var	array	row		Reward data
				 * @var	array	ary_tpl	Current reward template array
				 * @since 1.3.0
				 */
				$vars = [
					'row',
					'ary_tpl',
				];
				extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbreaction.listener_viewtopic_handle_posts', compact($vars)));

				$rewards[] = $ary_tpl;
				$positive = ($row['positive']) ? $positive + $row['percent'] : $positive;
				$negative = (!$row['positive']) ? $negative + $row['percent'] : $negative;
			}
			$post_row['POSITIVE'] = ($this->config['rewards_progressbar'] && ($positive || $negative)) ? round(($positive / ($positive + $negative)) * 100, 1) : 0;
			$post_row['NEGATIVE'] = ($this->config['rewards_progressbar'] && ($positive || $negative)) ? round(($negative / ($positive + $negative)) * 100, 1) : 0;
			$post_row['rewards'] = $rewards;
			$post_row['enable_rewards'] = true;
			$sql = 'SELECT t.* FROM ' . $this->reward_table . ' r
				INNER JOIN ' . $this->reward_type_table . ' t ON t.type_id = r.like_type AND t.active = 1
				WHERE r.post_id = ' . $post_row['POST_ID'] . ' AND r.user_id = ' . $this->user->data['user_id'] .
				' ORDER BY r.like_id DESC';
			$result = $this->db->sql_query_limit($sql, 1);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			if (isset($row['type_id'])) {
				$post_row['CURRENT_USER_REWARD_CLASSLIST'] = 'fa ' . $row['symbol'];
				$post_row['CURRENT_USER_REWARD_CONTENTS'] = '';
				$post_row['CURRENT_USER_REWARD_S_POSITIVE'] = ($row['positive']) ? true : false;
			}
			/**
			 * Event to modify latest reward
			 *
			 * @event sitesplat.bbreaction.listener_viewtopic_handle_posts
			 * @var	array	row		Latest Reward data
			 * @var	array	ary_tpl	Current reward template array
			 * @since 1.3.0
			 */
			$vars = array(
				'post_row',
				'row'
			);
			extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbreaction.listener_viewtopic_handle_posts_latest_reaction', compact($vars)));

			$sql = 'SELECT t.*, u.username, u.user_colour, u.user_id, GROUP_CONCAT(t.positive ORDER BY t.symbol) as positives, GROUP_CONCAT(DISTINCT t.symbol ORDER BY t.symbol) as symbols, GROUP_CONCAT(DISTINCT t.emoji ORDER BY t.symbol) as emojis 
				FROM ' . $this->reward_table . ' r
				INNER JOIN ' . $this->reward_type_table . ' t ON t.type_id = r.like_type AND t.active = 1
				INNER JOIN ' . USERS_TABLE . ' u ON u.user_id = r.user_id
				WHERE r.post_id = ' . $post_row['POST_ID'] . '
				GROUP BY r.user_id 
				ORDER BY r.like_time DESC';

			$result = $this->db->sql_query_limit($sql, 4);
			$rewards = [];
			$i = 0;
			while ($row = $this->db->sql_fetchrow($result)) {
				if ($i < 3) {
					if (!empty($row['symbols'])) {
						$symbols = explode(",", $row['symbols']);
						$symbols_rendered = [];
						foreach ($symbols as $symbol) {
							$symbols_rendered[] = ['SYMBOL' => 'fa ' . $symbol];
						}
					}
					$positives_rendered = [];
					if (!empty($row['positives'])) {
						$positives = explode(",", $row['positives']);
						foreach ($positives as $positive) {
							$positives_rendered[] = ['POSITIVE' => (bool) $positive];
						}
					}

					$reward = array(
						'USERNAME' => $row['username'],
						'U_USERNAME' => generate_board_url() . '/memberlist.php?mode=viewprofile&amp;u=' . $row['user_id'],
						'USER_COLOUR' => $row['user_colour'],
						'CLASSLIST' => $symbols_rendered,
						'CONTENTS' => '',
						'S_POSITIVE' => $positives_rendered,
					);

					/**
					 * Event to modify latest rewards
					 *
					 * @event sitesplat.bbreaction.listener_viewtopic_handle_posts
					 * @var	array	row		Latest Reward data
					 * @var	array	ary_tpl	Current reward template array
					 * @since 1.3.0
					 */
					$vars = array(
						'reward',
						'row'
					);
					extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbreaction.listener_viewtopic_handle_posts_latest_reactions', compact($vars)));
					$rewards[] = $reward;
				}
				$i += 1;
			}

			$post_row['SHOW_OTHERS'] = $i > 3;
			$post_row['latest_rewards'] = $rewards;
			$this->db->sql_freeresult($result);
			$event['post_row'] = $post_row;
		}
	}

	public function view_topic_topic($event)
	{
		$topic_id = $event['topic_id'];
		$postids = [];
		$sql = 'SELECT post_id FROM ' . POSTS_TABLE . ' WHERE topic_id = ' . $topic_id;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result)) {
			$postids[] = $row['post_id'];
		}

		$sql = 'SELECT COUNT(r.like_id) AS total FROM ' . $this->reward_table . ' r
				INNER JOIN ' . $this->reward_type_table . ' t ON t.type_id = like_type and t.active = 1
				WHERE r.post_id IN (' . implode(',', $postids) . ')';
		$result = $this->db->sql_query($sql);
		$total = $this->db->sql_fetchfield('total');

		$sql = 'SELECT *, (SELECT COUNT(1) FROM ' . $this->reward_table . ' WHERE like_type = type_id AND post_id IN (' . implode(',', $postids) . ')) AS percent 
				FROM ' . $this->reward_type_table . ' 
				WHERE active = 1 
				ORDER BY weight ASC';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result)) {
			if ($row['percent']) {
				$ary_tpl = [
					'SYMBOL'		=> $row['symbol'],
					'TITLE'			=> $row['title'],
					'PERCENT'		=> ($this->config['rewards_percent']) ? (($row['percent']) ? round(($row['percent'] / $total) * 100, 1)  : 0) . ' %' : '# ' . $row['percent'],
					'S_POSITIVE'	=> ($row['positive']) ? true : false,

					'CLASSLIST'	=> 'fa ' . $row['symbol'],
					'CONTENTS'	=> '',
				];

				/**
				 * Event to modify reward template variables
				 *
				 * @event sitesplat.bbreaction.listener_view_topic_topic
				 * @var	array	row		Reward data
				 * @var	array	ary_tpl	Current reward template array
				 * @since 1.3.0
				 */
				$vars = [
					'row',
					'ary_tpl',
				];
				extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbreaction.listener_view_topic_topic', compact($vars)));

				$this->template->assign_block_vars('reward', $ary_tpl);
			}
		}
	}

	public function delete_like_dislike($event)
	{
		$post_ids = $event['post_ids'];
		$sql = 'DELETE FROM ' . $this->reward_table . ' WHERE post_id IN (' . implode(',', $post_ids) . ')';
		$this->db->sql_query($sql);
	}

	public function modify_profile($event)
	{
		if ($this->config['rewards_memberlist']) {
			$userid = $event['member']['user_id'];
			$sql = 'SELECT *, (SELECT COUNT(like_id) FROM ' . $this->reward_table . ' WHERE like_type = t.type_id AND user_id = ' . $userid . ') AS num, "given" AS type
					FROM ' . $this->reward_type_table . ' t WHERE active = 1 
	
					UNION
	
					SELECT *, (SELECT COUNT(r.like_id) FROM ' . $this->reward_table . ' r
					LEFT JOIN ' . POSTS_TABLE . ' p ON p.post_id = r.post_id WHERE r.like_type = t.type_id AND p.poster_id = ' . $userid . ') AS num, "received" AS type
					FROM ' . $this->reward_type_table . ' t WHERE active = 1 
					
					ORDER BY weight, type';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result)) {
				$ary_tpl = [
					'TITLE'				=> $row['title'],
					'ICON'				=> $row['symbol'],
					'S_POSITIVE'		=> $row['positive'],
					'GIVEN_RECEIVED'	=> (($row['type'] == 'given') ? $this->user->lang['BBREACTION_GIVEN'] : $this->user->lang['BBREACTION_RECEIVED']),
					'GIVE_RECEIVE'		=> $row['num'],

					'CLASSLIST'	=> 'icon fa ' . $row['symbol'],
					'CONTENTS'	=> '',
				];

				/**
				 * Event to modify reward template variables
				 *
				 * @event sitesplat.bbreaction.listener_modify_profile
				 * @var	array	row		Reward data
				 * @var	array	ary_tpl	Current reward template array
				 * @since 1.3.0
				 */
				$vars = [
					'row',
					'ary_tpl',
				];
				extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbreaction.listener_modify_profile', compact($vars)));

				$this->template->assign_block_vars('rewards_memberlist', $ary_tpl);
			}
		}
	}

	protected function truncateByOccurence($haystack, $needle, $limit)
	{
		$haystack = explode($needle, $haystack, $limit + 1);
		$haystack = array_slice($haystack, 0, $limit);
		return implode($needle, $haystack);
	}

	/**
	 * Add permissions to page
	 * @access public
	 */
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_bbreaction'] = ['lang' => 'ACL_U_BBREACTION', 'cat' => 'post'];
		$permissions['u_bbreaction_module'] = ['lang' => 'ACL_U_BBREACTION_MODULE', 'cat' => 'post'];
		$event['permissions'] = $permissions;
	}

	public function delete_like_dislike_forum($event)
	{
		$sql = "DELETE r.* FROM {$this->reward_table} r INNER JOIN {$this->posts_table} p
			WHERE p.forum_id = {$event['forum_id']}
			AND r.post_id = p.post_id";

		$this->db->sql_query($sql);
	}

	public function delete_like_dislike_user($event)
	{
		if (!empty($event['user_ids'])) {
			$user_id_in = is_array($event['user_ids']) ? 'IN (' . implode(',', $event['user_ids']) . ')' : "= {$event['user_ids']}";
			$this->db->sql_query("DELETE FROM {$this->reward_table} WHERE user_id $user_id_in");
			if ($event['mode'] == 'remove') {
				$sql = "DELETE r.* FROM {$this->reward_table} r INNER JOIN {$this->posts_table} p
					WHERE p.poster_id $user_id_in
					AND r.post_id = p.post_id";

				$this->db->sql_query($sql);
			}
		}
	}
}