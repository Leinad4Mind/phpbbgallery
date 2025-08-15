<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\controller;

use sitesplat\badge\conditions\manager;
use phpbb\db\driver\driver_interface;
use phpbb\template\template;
use phpbb\user;
use phpbb\request\request;
use phpbb\controller\helper;
use Symfony\Component\DependencyInjection\Container;

class main
{
	/** @var \sitesplat\badge\conditions\manager */
	protected $manager;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;
	
	/** @var ContainerInterface */
	protected $phpbb_container;

	/** Template object 	@var \phpbb\template\template */
	protected $template;

	/** User object 	@var \phpbb\user */
	protected $user;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\controller\helper */
	protected $helper;

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

	public function __construct(manager $manager, driver_interface $db, Container $phpbb_container, template $template, user $user, request $request, helper $helper, $phpbb_root_path, \phpbb\path_helper $path_helper, $badge_rules_table, $badge_types_table, $badge_events_table, $badge_badges_table)
	{
		$this->manager = $manager;
		$this->db = $db;
		$this->phpbb_container = $phpbb_container;
		$this->template = $template;
		$this->user = $user;
		$this->request = $request;
		$this->helper = $helper;
		$this->root_path = generate_board_url() . '/';
		$this->path_helper = $path_helper;
		$this->badge_rules_table = $badge_rules_table;
		$this->badge_types_table = $badge_types_table;
		$this->badge_events_table = $badge_events_table;
		$this->badge_badges_table = $badge_badges_table;
	}

	/**
	* Extension front handler method. This is called automatically when your extension is accessed
	* through index.php?ext=example/foobar
	* @return null
	*/
	public function handle($route = 'index.html')
	{
		$sql = 'SELECT user_id FROM ' . USERS_TABLE . ' WHERE badge_route = "' . preg_replace('/\\.[^.\\s]{3,4}$/', '', $route) . '"';
		$result = $this->db->sql_query($sql);
		if (!($row = $this->db->sql_fetchrow($result)))
		{
			$userid = $this->request->variable('u', 0);
			$sql = 'SELECT user_id FROM ' . USERS_TABLE . ' WHERE user_id = ' . $userid;
			$result = $this->db->sql_query($sql);
			$userid = $this->db->sql_fetchfield('user_id');

		} else
		{
			$userid = $row['user_id'];
		}

		// Add the badge ACP lang file
		$this->user->add_lang_ext('sitesplat/badge', 'badge_acp');

		$breadcrumb = array($this->user->lang['BADGE_MANAGE'] => $this->helper->route('badge_award_controller', array('route' => 'index.html')),);
		($route == 'recent.html') ? $breadcrumb += array($this->user->lang['BADGE_RECENT'] => $this->helper->route('badge_award_controller', array('route' => 'recent.html')),) : null;

		$type_ids = $this->manager->get_rule_type_ids();
		array_walk($type_ids, function(&$value, $key, $return) {
			$value = $value[$return];
		}, 'id');

		$sql = 'SELECT r.rule_id, r.rule_type_id, r.rule_name, r.rule_description, rule_min_value, rule_max_value, e.user_id, u.username, u.badge_route, s.style_path,
					   u.user_avatar AS avatar, u.user_avatar_width AS avatar_width, u.user_avatar_height AS avatar_height, u.user_avatar_type AS avatar_type, u.user_colour, 
					   e.date, b.badge, t.rule_type_name
				FROM ' . $this->badge_rules_table . ' r
				LEFT OUTER JOIN ' . $this->badge_events_table . ' e ON e.rule_id = r.rule_id
				LEFT JOIN ' . $this->badge_types_table . ' t ON t.rule_type_id = r.rule_type_id
				LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = e.user_id
				LEFT JOIN ' . STYLES_TABLE . ' s ON s.style_id = u.user_style
				LEFT JOIN ' . $this->badge_badges_table . ' b ON b.badge_id = r.badge_id
				' . ((!$userid ) ? ' WHERE r.rule_type_id IN (' . implode(',', $type_ids) . ')' : ' WHERE e.user_id = ' . $userid) . ' AND r.rule_type_id IN (' . implode(',', $type_ids) . ')
				ORDER BY ' . (($route == 'recent.html') ? 't.rule_type_name, e.date DESC LIMIT 100' : 't.rule_type_name, r.rule_id, u.username_clean');
		$result = $this->db->sql_query($sql);
		$ruleid = $rulename = '0';
		
		if (!$userid )
		{
			while ($row = $this->db->sql_fetchrow($result))
			{
				if ($rulename != $row['rule_type_name'])
				{
					$this->template->assign_block_vars('rules', array(
						'CONDITION_NAME'	=> $this->manager->get_condition_lang($row['rule_type_name']),
						'URL'				=> $this->Slug($this->manager->get_condition_lang($row['rule_type_name']))
					));
				}
				
				if ($ruleid != $row['rule_id'])
				{
					$this->template->assign_block_vars('rules.badge', array(
						'BADGE'				=> $this->root_path . 'ext/sitesplat/badge/badges/' . $row['badge'],
						'GROUP_NAME'		=> $row['rule_name'],
						'DESCRIPTION'		=> (($row['rule_type_name'] != 'sitesplat.badge.type.custom') ? $this->manager->get_condition_lang($row['rule_type_name']) . $this->manager->get_condition_type_lang($row['rule_min_value'], $row['rule_max_value'], $row['rule_type_name']) : '') . (($row['rule_description']) ? '<br />' . $row['rule_description'] : '')
					));
				}
				if (!empty($row['username']))
				{
					$this->template->assign_block_vars('rules.badge.users', array(
						'USERNAME'	=> $row['username'],
						'USER_ID'	=> $row['user_id'],
						'U_URL'		=> $this->helper->route('badge_award_controller', array('route' => 
										(($row['badge_route'] != '') ? $row['badge_route'] . '.html' : 'index.html?u=' . $row['user_id']))),
						'U_COLOR'	=> $row['user_colour'],
						'AVATAR'	=> ($row['avatar']) ? phpbb_get_user_avatar($row) : '<img style="width:34px;height:34px;" src="' . generate_board_url() . '/styles/' . $row['style_path'] . '/theme/images/no_avatar.gif" alt="' . $this->user->lang['USER_AVATAR'] . '">',
						'DATE'		=> ($row['date']) ? $this->user->format_date($row['date'], 'j M Y') : '',
					));
				}
				$rulename = $row['rule_type_name'];
				$ruleid = $row['rule_id'];
			}
		} else
		{		
			while ($row = $this->db->sql_fetchrow($result))
			{
				if ($rulename != $row['username'])
				{
					$breadcrumb += array($this->user->lang['BADGE_USER'] => $this->helper->route('badge_award_controller', array('route' => $row['username'] . '.html')),);
					$this->template->assign_block_vars('rules', array(
						'CONDITION_NAME'	=> $row['username'],
					));
				}
				
				if ($ruleid != $row['rule_type_id'])
				{
					$avatar = phpbb_get_user_avatar($row);
					preg_match( '/src="([^"]*)"/i', $avatar, $match);
					$this->template->assign_block_vars('rules.badge', array(
						'BADGE'			=> ($rulename != $row['username']) ? 
											(($row['avatar'] && isset($match[1])) ? $match[1] : generate_board_url() . '/styles/' . $row['style_path'] . '/theme/images/no_avatar.gif') : '',
						'GROUP_NAME'	=> '',
						'DESCRIPTION'	=> $this->manager->get_condition_lang($row['rule_type_name'])
					));
				}
				if ($row['rule_id'])
				{
					$this->template->assign_block_vars('rules.badge.users', array(
						'USERNAME'	=> '',
						'USER_ID'	=> '',
						'U_URL'		=> '',
						'RULETITLE'	=> $row['rule_name'],
					//	'DESCR'		=> $row['rule_name'] . '<br />' . $row['rule_description'],
						'DESCR'		=> $row['rule_description'],
						'AVATAR'	=> '<img alt="' . $this->manager->get_condition_lang($row['rule_type_name']) . '" title="' . (($row['rule_type_name'] != 'sitesplat.badge.type.custom') ?$this->manager->get_condition_lang($row['rule_type_name']) . $this->manager->get_condition_type_lang($row['rule_min_value'], $row['rule_max_value'], $row['rule_type_name']) : $row['rule_name']) . "\n" . $row['rule_description'] . '" style="margin-top:4px;width:30px;height:30px;" src="' . $this->root_path . 'ext/sitesplat/badge/badges/' . $row['badge'] . '">',
						'DATE'		=> ($row['date']) ? $this->user->format_date($row['date'], 'j M Y') : '',
					));
				}
				$rulename = $row['username'];
				$ruleid = $row['rule_type_id'];
			}
		}

		$this->db->sql_freeresult($result);

		foreach ($breadcrumb as $i => $value)
		{
			$this->template->assign_block_vars('navlinks', array(
				'FORUM_NAME'	=> $i,
				'U_VIEW_FORUM'	=> $value
				)
			);
		}
		
		$this->template->assign_vars(array('S_RECENT' => ($route == 'recent.html') ? true : false, 'IN_BADGE' => true, 'IN_USER' => ($userid) ? true : false));
		// Send all data to the template file
		return $this->helper->render('badge.html', $this->user->lang['BADGE_MANAGE']);
	}

	protected function Slug($string)
	{
		return strtolower(str_replace(array('&','#',';',' '), array('','','','_'), mb_convert_encoding($string, 'HTML-ENTITIES', 'UTF8')));
//		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
	}
}
