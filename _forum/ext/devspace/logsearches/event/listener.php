<?php
/**
 *
 * @package Log Searches Extension
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\logsearches\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use phpbb\config\config;
use phpbb\user;
use phpbb\auth\auth;
use phpbb\db\driver\driver_interface;
use phpbb\language\language;
use devspace\logsearches\core\functions;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var config */
	protected $config;

	/** @var user */
	protected $user;

	/** @var auth */
	protected $auth;

	/** @var driver_interface */
	protected $db;

	/** @var language */
	protected $language;

	/** @var functions */
	protected $functions;

	/** @var array phpBB tables */
	protected $tables;

	/**
	 * Constructor for listener
	 *
	 * @param config                 $config             Config object
	 * @param user                   $user               User object
	 * @param auth                   $auth               Auth object
	 * @param driver_interface       $db                 Database object
	 * @param language               $language           Language object
	 * @param functions              $functions          Functions for the extension
	 * @param array                  $tables             phpBB db tables
	 *
	 * @return \devspace\logsearches\event\listener
	 * @access public
	 */
	public function __construct(config $config, user $user, auth $auth, driver_interface $db, language $language, functions $functions, $tables)
	{
		$this->config    = $config;
		$this->user      = $user;
		$this->auth      = $auth;
		$this->db        = $db;
		$this->language  = $language;
		$this->functions = $functions;
		$this->tables    = $tables;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.search_modify_param_before' 			=> 'get_search_data',
			'core.search_results_modify_search_title'	=> 'log_search',
		];
	}

	public function get_search_data($event)
	{
		$this->author_id_ary = $event['author_id_ary'];
		$this->ex_fid_ary    = $event['ex_fid_ary'];
		$this->show_results  = $event['show_results'];
	}

	public function log_search($event)
	{
		$total_match_count = $event['total_match_count'];

		// Add the language file
		$this->language->add_lang('logsearches', $this->functions->get_ext_namespace());

		$search_data = [];
		if ($event['keywords'])
		{
			$search_data['k'] = $event['keywords'];
		}

		if ($this->author_id_ary)
		{
			$search_data['a'] = $this->get_search_authors($this->author_id_ary);
		}

		$search_data['f'] = $this->get_search_fora($this->ex_fid_ary, $event['l_search_title']);
		$search_data['t'] = $this->show_results;

		if ($this->config['search_log_all'] || (!$this->config['search_log_all'] && !$total_match_count))
		{
			// Sets the values required for the log
			$sql_ary = [
				'log_data' 			=> json_encode($search_data),
				'log_ip' 			=> $this->user->ip,
				'log_search_type'	=> ($total_match_count > 0) ? true : false,
				'log_time' 			=> time(),
				'log_title' 		=> ($event['l_search_title']) ? $event['l_search_title'] : $this->language->lang('POSTS_SEARCH'),
				'user_id' 			=> (int) $this->user->data['user_id'],
			];

			// Insert the search data into the database
			$sql = 'INSERT INTO ' . $this->tables['search_log'] . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
			$this->db->sql_query($sql);
		}
	}

	public function get_search_fora($excluded_ids, $title)
	{
		if (empty($excluded_ids) || !empty($title))
		{
			return $this->language->lang('ALL_FORA');
		}

		// Build a list of fora that the user has permission for
		$sql = 'SELECT forum_id, forum_name, parent_id
            FROM ' . $this->tables['forums'];

		$result = $this->db->sql_query($sql);

		$forum_ary = [];
		$forum_id_ary = [];

		while ($row = $this->db->sql_fetchrow($result))
		{
			$forum_ary[] = $row;

			if ($this->auth->acl_get('f_list', $row['forum_id']))
			{
				$forum_id_ary[] = $row['forum_id'];
			}
		}

		$this->db->sql_freeresult($result);

		if (sizeof($forum_id_ary) == sizeof($excluded_ids) || sizeof($forum_id_ary) == (sizeof($forum_ary) - sizeof($excluded_ids)))
		{
			return $this->language->lang('ALL_FORA');
		}

		$used_ids = array_diff($forum_id_ary, $excluded_ids);

		$forum_data = '';
		foreach ($used_ids as $key => $forum)
		{
			if ($forum_ary[$key]['parent_id'] == 0)
			{
				continue;
			}
			else
			{
				$forum_data .= $forum_ary[$key]['forum_name'] . ', ';
			}
		}

		return substr($forum_data, 0, -2);
	}

	public function get_search_authors($authors)
	{
		$search_user = '';
		foreach ($authors as $key => $author)
		{
			$sql = 'SELECT username
                FROM ' . $this->tables['users'] . '
                WHERE user_id = ' . (int) $author;

			$result = $this->db->sql_query($sql);
			$search_user .= $this->db->sql_fetchfield('username') . ', ';

			$this->db->sql_freeresult($result);
		}

		return substr($search_user, 0, -2);
	}
}
