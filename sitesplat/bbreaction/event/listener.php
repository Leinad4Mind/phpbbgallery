<?php
/**
*
* BBreaction
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'								=> 'add_page_header_link',
			'core.permissions'								=> 'add_permission',
			'core.viewtopic_modify_post_row'				=> 'viewtopic_handle_posts',
			'core.viewtopic_assign_template_vars_before'	=> 'view_topic_topic',
			'core.delete_posts_after'						=> 'delete_like_dislike',
			'core.memberlist_view_profile'					=> 'modify_profile',
			'core.delete_forum_content_before_query'		=> 'delete_like_dislike_forum',
			'core.delete_user_before'						=> 'delete_like_dislike_user',
		);
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

	protected $phpbb_dispatcher;

	/** @var string The database table the reactions are stored in */
	protected $reward_table;

	/** @var string The database table the reaction types are stored in */
	protected $reward_type_table;

	/** @var string The database table the posts are stored in */
	protected $posts_table;

	/** @var string The database table the topics are stored in */
	protected $topics_table;
	

	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\controller\helper $helper, \phpbb\extension\manager $ext_manager, \Symfony\Component\DependencyInjection\Container $phpbb_container, \phpbb\event\dispatcher_interface $phpbb_dispatcher, $reward_table, $reward_type_table, $posts_table, $topics_table)
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
		
		$this->template->assign_vars(array(
		//	'U_BBREACTION_PAGE'			=> $this->helper->route('sitesplat_bbreaction_main_controller', array('route' => 'toplist.html')),
            'U_BBREACTION_PAGE'         => ($this->auth->acl_get('u_bbreaction_module')) ? $this->helper->route('sitesplat_bbreaction_main_controller', array('route' => 'toplist.html')) : '',
			'BBREACTION_DISPLAY_TOP'	=> $this->config['rewards_display_top']
		));
	}
	
	public function viewtopic_handle_posts($event)
	{
		if (($this->config['rewards_allow_locked'] || $event['topic_data']['topic_status'] != ITEM_LOCKED) &&
			($this->config['rewards_allow_global'] || $event['topic_data']['topic_type'] != POST_GLOBAL))
		{
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
			while ($row = $this->db->sql_fetchrow($result))
			{
				$ary_tpl = array(
					'TYPE_ID'		=> $row['type_id'],
					'SYMBOL'		=> $row['symbol'],
					'TITLE'			=> $row['title'],
					'PERCENT'		=> ($this->config['rewards_percent']) ? (($row['percent']) ? round(($row['percent'] / $total) * 100, 1)  : 0) . ' %' : '# ' . $row['percent'],
					'S_POSITIVE'	=> ($row['positive']) ? true : false,
					'SEPERATOR'		=> ($row['seperator']) ? true : false,
					'U_LIKE'		=> append_sid($this->helper->route('sitesplat_bbreaction_main_controller', 
										array('route' => 'index.html', 'p=' . $post_row['POST_ID'], 'e=' . $row['type_id']))),
					
					'CLASSLIST'	=> 'fa ' . $row['symbol'],
					'CONTENTS'	=> '', 
				);

				/**
				* Event to modify reward template variables
				*
				* @event sitesplat.bbreaction.listener_viewtopic_handle_posts
				* @var	array	row		Reward data
				* @var	array	ary_tpl	Current reward template array
				* @since 1.3.0
				*/
				$vars = array(
					'row',
					'ary_tpl',
				);
				extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbreaction.listener_viewtopic_handle_posts', compact($vars)));

				$rewards[] = $ary_tpl;
				$positive = ($row['positive']) ? $positive + $row['percent']: $positive;
				$negative = (!$row['positive']) ? $negative + $row['percent'] : $negative;
			}
			$post_row['POSITIVE'] = ($this->config['rewards_progressbar'] && ($positive || $negative)) ? round(($positive / ($positive + $negative)) * 100, 1) : 0;
			$post_row['NEGATIVE'] = ($this->config['rewards_progressbar'] && ($positive || $negative)) ? round(($negative / ($positive + $negative)) * 100, 1) : 0;
			$post_row['rewards'] = $rewards;
			$event['post_row'] = $post_row;
		}
	}

	public function view_topic_topic($event)
	{
		$topic_id = $event['topic_id'];
		$postids = array();
		$sql = 'SELECT post_id FROM ' . POSTS_TABLE . ' WHERE topic_id = ' . $topic_id;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
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
		while ($row = $this->db->sql_fetchrow($result))
		{
			if ($row['percent'])
			{
				$ary_tpl = array(
					'SYMBOL'		=> $row['symbol'],
					'TITLE'			=> $row['title'],
					'PERCENT'		=> ($this->config['rewards_percent']) ? (($row['percent']) ? round(($row['percent'] / $total) * 100, 1)  : 0) . ' %' : '# ' . $row['percent'],
					'S_POSITIVE'	=> ($row['positive']) ? true : false,

					'CLASSLIST'	=> 'fa ' . $row['symbol'],
					'CONTENTS'	=> '', 
				);

				/**
				* Event to modify reward template variables
				*
				* @event sitesplat.bbreaction.listener_view_topic_topic
				* @var	array	row		Reward data
				* @var	array	ary_tpl	Current reward template array
				* @since 1.3.0
				*/
				$vars = array(
					'row',
					'ary_tpl',
				);
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
		if ($this->config['rewards_memberlist'])
		{
			$userid = $event['member']['user_id'];
			$sql = 'SELECT *, (SELECT COUNT(like_id) FROM ' . $this->reward_table . ' WHERE like_type = t.type_id AND user_id = ' . $userid . ') AS num, "given" AS type
					FROM ' . $this->reward_type_table . ' t WHERE active = 1 
	
					UNION
	
					SELECT *, (SELECT COUNT(r.like_id) FROM ' . $this->reward_table . ' r
					LEFT JOIN ' . POSTS_TABLE . ' p ON p.post_id = r.post_id WHERE r.like_type = t.type_id AND p.poster_id = ' . $userid . ') AS num, "recieved" AS type
					FROM ' . $this->reward_type_table . ' t WHERE active = 1 
					
					ORDER BY weight, type';
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result)) 
			{
				$ary_tpl = array(
					'TITLE'				=> $row['title'],
					'ICON'				=> $row['symbol'],
					'S_POSITIVE'		=> $row['positive'],
					'GIVEN_RECIEVED'	=> (($row['type'] == 'given') ? $this->user->lang['BBREACTION_GIVVEN'] : $this->user->lang['BBREACTION_RECIEVED']),
					'GIVE_RECIEVE'		=> $row['num'],

					'CLASSLIST'	=> 'icon fa ' . $row['symbol'],
					'CONTENTS'	=> '',
				);

				/**
				* Event to modify reward template variables
				*
				* @event sitesplat.bbreaction.listener_modify_profile
				* @var	array	row		Reward data
				* @var	array	ary_tpl	Current reward template array
				* @since 1.3.0
				*/
				$vars = array(
					'row',
					'ary_tpl',
				);
				extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbreaction.listener_modify_profile', compact($vars)));

				$this->template->assign_block_vars('rewards_memberlist', $ary_tpl);
			}
		}
	}

	protected function truncateByOccurence ($haystack, $needle, $limit)
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
		$permissions['u_bbreaction'] = array('lang' => 'ACL_U_BBREACTION', 'cat' => 'post');
		$permissions['u_bbreaction_module'] = array('lang' => 'ACL_U_BBREACTION_MODULE', 'cat' => 'post');
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
