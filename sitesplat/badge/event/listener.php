<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var \sitesplat\badge\conditions\manager */
	protected $manager;

	/** @var \phpbb\controller\helper */
	protected $controller_helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\user */
	protected $user;

	protected $phpbb_root_path;

	protected $path_helper;

	/** @var string The database table the badge rules are stored in */
	protected $badge_rules_table;

	/** @var string The database table the badge types are stored in */
	protected $badge_types_table;

	/** @var string The database table the badge events are stored in */
	protected $badge_events_table;

	/** @var string The database table the badges are stored in */
	protected $badge_badges_table;

	public function __construct(\sitesplat\badge\conditions\manager $manager, \phpbb\controller\helper $controller_helper, \phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, $phpbb_root_path, \phpbb\path_helper $path_helper, $badge_rules_table, $badge_types_table, $badge_events_table, $badge_badges_table)
	{
		$this->manager = $manager;
		$this->controller_helper = $controller_helper;
		$this->template = $template;
		$this->db = $db;
		$this->user = $user;
		$this->root_path = $phpbb_root_path;
		$this->path_helper = $path_helper;
		$this->badge_rules_table = $badge_rules_table;
		$this->badge_types_table = $badge_types_table;
		$this->badge_events_table = $badge_events_table;
		$this->badge_badges_table = $badge_badges_table;
		$this->type_ids = array();
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'					=> 'add_page_header_link',
			'core.viewtopic_modify_post_row'	=> 'modify_post_row',
			'core.memberlist_view_profile'		=> 'modify_profile',

			'core.user_add_modify_data'			=> 'insert_user_data',
			'core.update_username'				=> 'modify_user_data',
			
			// Badge Award "Posts" listeners
			'core.submit_post_end'				=> 'submit_post_check',
			'core.delete_posts_after'			=> 'delete_post_check',

			// Badge Award "Warnings" listeners
			'core.mcp_warn_post_after'			=> 'add_warning_check',
			'core.mcp_warn_user_after'			=> 'add_warning_check',

			'core.submit_likedd_end'			=> 'submit_likedd_check',
			'core.submit_donation_end'			=> 'submit_donation_check',
		);
	}

	/**
	 * Add page header link during user setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function add_page_header_link($event)
	{
		$this->user->add_lang_ext('sitesplat/badge', 'badge_common');
		
		$this->template->assign_vars(array(
			'U_BADGE_PAGE'	=> $this->controller_helper->route('badge_award_controller', array('route' => 'index.html')),
			'U_RECENT'		=> $this->controller_helper->route('badge_award_controller', array('route' => 'recent.html')),
		));

		$this->type_ids = $this->manager->get_rule_type_ids();
		array_walk($this->type_ids, function(&$value, $key, $return) {
			$value = $value[$return];
		}, 'id');

		$sql = 'SELECT n.user_id, n.notification_id, n.notification_data, r.rule_name, r.rule_description, b.badge
				FROM ' . NOTIFICATIONS_TABLE . ' n
				INNER JOIN ' . NOTIFICATION_TYPES_TABLE . ' t ON t.notification_type_id = n.notification_type_id 
				LEFT JOIN ' . $this->badge_rules_table . ' r ON r.rule_id = n.item_id
				LEFT JOIN ' . $this->badge_badges_table . ' b ON b.badge_id = r.badge_id
				WHERE  t.notification_type_name = "sitesplat.badge.notification.type.award_added" AND
				r.rule_type_id IN (' . implode(',', $this->type_ids) . ')
				AND n.user_id = ' . $event['user_data']['user_id'] . ' AND n.notification_read = 0 LIMIT 1';

		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow();
			
		if (!defined('ADMIN_START') && $row['user_id'])
		{
			$notification_data = unserialize($row['notification_data']);
			
			$this->template->assign_vars(array(
				'NOTIFY_NEW_BADGE'	=> true,
				'NEW_BADGE'			=> $this->path_helper->update_web_root_path($this->root_path . 'ext/sitesplat/badge/badges/' . $row['badge']),
				'RULE_NAME'			=> addslashes($row['rule_name']),
				'RULE_DESCR'		=> addslashes($row['rule_description']),
				'BADGE_WHOHOO'		=> sprintf($this->user->lang['BADGE_WHOHOO'], $this->controller_helper->route('badge_award_controller', array('route' => 'index.html', 'u' => $row['user_id'])))
			));
			$sql = 'UPDATE ' . NOTIFICATIONS_TABLE . ' SET notification_read = 1 WHERE notification_id = ' . $row['notification_id'];
			$this->db->sql_query($sql);
		}
	}

	/**
	 * Load common language files during user setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/badge',
			'lang_set' => 'badge_common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function modify_post_row($event)
	{
		$badges = '';
		$sql = 'SELECT r.rule_id, r.rule_type_id, r.rule_name, rule_min_value, rule_max_value, 
					   e.date, b.badge, t.rule_type_name, u.badge_route
				FROM ' . $this->badge_rules_table . ' r
				LEFT OUTER JOIN ' . $this->badge_events_table . ' e ON e.rule_id = r.rule_id
				LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = e.user_id
				LEFT JOIN ' . $this->badge_types_table . ' t ON t.rule_type_id = r.rule_type_id
				LEFT JOIN ' . $this->badge_badges_table . ' b ON b.badge_id = r.badge_id
				WHERE e.user_id = ' . $event['row']['user_id'] . ' AND
				r.rule_type_id IN (' . implode(',', $this->type_ids) . ')
				ORDER BY r.rule_type_id, r.rule_id';
		$result = $this->db->sql_query($sql);
		$i = 0;
		$imax = 5;
		while ($row = $this->db->sql_fetchrow())
		{
			if ($i < $imax)
			{
				$badges .= '<a href="' . $this->root_path . 'badge/' . (($row['badge_route'] != '') ? $row['badge_route'] . '.html' : 'index.html?u=' . $event['row']['user_id']) . '"><img title="' . (($row['rule_type_name'] != 'sitesplat.badge.type.custom') ? $this->manager->get_condition_lang($row['rule_type_name']) . $this->manager->get_condition_type_lang($row['rule_min_value'], $row['rule_max_value'], $row['rule_type_name']) : $row['rule_name']) . '" style="vertical-align:middle;width:16px;height:16px;" src="' . $this->path_helper->update_web_root_path($this->root_path . 'ext/sitesplat/badge/badges/' . $row['badge']) . '"></a> ';
			}
			$i++;
		}

		if ($event['row']['user_id'] != ANONYMOUS)
		{
			$post_row = $event['post_row'];
			$post_row['BADGES'] = $badges . (($i > $imax) ? $this->user->lang('MORE_BADGES', $this->root_path . 'badge/index.html?u=' . $event['row']['user_id'], ($i - $imax)) : '');
			$event['post_row'] = $post_row;
		}
	}

	public function modify_profile($event)
	{
		$this->user->add_lang_ext('sitesplat/badge', 'badge_acp');

		$badges = '';
		$sql = 'SELECT r.rule_id, r.rule_type_id, r.rule_name, rule_min_value, rule_max_value, 
					   e.date, b.badge, t.rule_type_name
				FROM ' . $this->badge_rules_table . ' r
				LEFT OUTER JOIN ' . $this->badge_events_table . ' e ON e.rule_id = r.rule_id
				LEFT JOIN ' . $this->badge_types_table . ' t ON t.rule_type_id = r.rule_type_id
				LEFT JOIN ' . $this->badge_badges_table . ' b ON b.badge_id = r.badge_id
				WHERE e.user_id = ' . $event['member']['user_id'] . ' AND
				r.rule_type_id IN (' . implode(',', $this->type_ids) . ')
				ORDER BY r.rule_type_id, r.rule_id';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow())
		{
			$this->template->assign_block_vars('badges', array(
				'NAME'	=> $this->manager->get_condition_lang($row['rule_type_name']),
				'BADGE'	=> $this->path_helper->update_web_root_path($this->root_path . 'ext/sitesplat/badge/badges/' . $row['badge']),
				'TITLE'	=> ($row['rule_type_name'] != 'sitesplat.badge.type.custom') ? $this->manager->get_condition_lang($row['rule_type_name']) . $this->manager->get_condition_type_lang($row['rule_min_value'], $row['rule_max_value'], $row['rule_type_name']) : $row['rule_name'],
				'DATE'	=> $this->user->format_date($row['date'], 'j M Y')
			));
		}
	}

	public function insert_user_data($event)
	{
		$user_row = $event['user_row'];
		$sql_ary = $event['sql_ary'];
		$sql_ary['badge_route'] = $this->Slug($user_row['username']);
		$event['sql_ary'] = $sql_ary;
	}

	public function modify_user_data($event)
	{
		$new_name = $this->Slug($event['new_name']);
		$sql = 'UPDATE ' . USERS_TABLE . ' SET badge_route = "' . $new_name . '" WHERE username = "' . $event['new_name'] . '"';
		$this->db->sql_query($sql);
	}

	protected function var_display($i)
	{
		echo '<pre>';
		print_r($i);
		echo '</pre>';
		return true;
	}

	
	/**
	 * Check user's post count after submitting a post for badge award
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function submit_post_check($event)
	{
		$sql = 'SELECT rule_id FROM ' . $this->badge_rules_table . ' r 
		LEFT JOIN ' . $this->badge_types_table . ' t ON t.rule_type_id = r.rule_type_id
		where t.rule_type_name = "sitesplat.badge.type.posts"';
		$result = $this->db->sql_query($sql, 3600);
		$rows = $this->db->sql_fetchrowset($result);
		
		foreach($rows as $rule)
		{
			$this->manager->check_condition('sitesplat.badge.type.posts', $rule['rule_id'], array(
				'users'		=> $event['data']['poster_id'],
				'action'	=> 'nosync',
			));
		}
	}

	/**
	 * Check user's post count after deleting a post for badge award
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function delete_post_check($event)
	{
		$sql = 'SELECT rule_id FROM ' . $this->badge_rules_table . ' r 
		LEFT JOIN ' . $this->badge_types_table . ' t ON t.rule_type_id = r.rule_type_id
		where t.rule_type_name = "sitesplat.badge.type.posts"';
		$result = $this->db->sql_query($sql, 3600);
		$rows = $this->db->sql_fetchrowset($result);

		foreach($rows as $rule)
		{
			$this->manager->check_condition('sitesplat.badge.type.posts', $rule['rule_id'], array(
				'action'	=> 'delete',
				'users'		=> $event['poster_ids'],
			));
		}
	}

	/**
	 * Check user's warnings count after receiving a warning for badge award
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function add_warning_check($event)
	{
		$sql = 'SELECT rule_id FROM ' . $this->badge_rules_table . ' r 
		LEFT JOIN ' . $this->badge_types_table . ' t ON t.rule_type_id = r.rule_type_id
		where t.rule_type_name = "sitesplat.badge.type.warnings"';
		$result = $this->db->sql_query($sql, 3600);
		$rows = $this->db->sql_fetchrowset($result);

		foreach($rows as $rule)
		{
			$this->manager->check_condition('sitesplat.badge.type.warnings', $rule['rule_id'], array(
				'users'		=> $event['user_row']['user_id'],
				'action'	=> 'nosync',
			));
		}
	}

	/**
	 * Check user's likedd after submitting a likedd for badge award
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function submit_likedd_check($event)
	{
		$sql = 'SELECT rule_id, options FROM ' . $this->badge_rules_table . ' r 
		LEFT JOIN ' . $this->badge_types_table . ' t ON t.rule_type_id = r.rule_type_id
		where t.rule_type_name = "sitesplat.badge.type.likedd"
		AND (options = ' . bindec(sprintf( "%02d", (string) !$event['ld'] . '0')) . ' OR options = ' . bindec(sprintf( "%02d", (string) !$event['ld'] . '1')) . ')';
		$result = $this->db->sql_query($sql, 3600);
		$rows = $this->db->sql_fetchrowset($result);
		
		foreach($rows as $rule)
		{
			$this->manager->check_condition('sitesplat.badge.type.likedd', $rule['rule_id'], array(
				'users'		=> $event['user_id'],
				'action'	=> 'nosync',
				'option'	=> $rule['options']
			));
		}
	}

	public function submit_donation_check($event)
	{
		$sql = 'SELECT rule_id FROM ' . $this->badge_rules_table . ' r 
		LEFT JOIN ' . $this->badge_types_table . ' t ON t.rule_type_id = r.rule_type_id
		where t.rule_type_name = "sitesplat.badge.type.donations"';
		$result = $this->db->sql_query($sql, 3600);
		$rows = $this->db->sql_fetchrowset($result);

		foreach($rows as $rule)
		{
			$this->manager->check_condition('sitesplat.badge.type.donations', $rule['rule_id'], array(
				'users'		=> $event['user_id'],
				'action'	=> 'nosync',
			));
		}
	}

	protected function Slug($string)
	{
		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
	}
}
