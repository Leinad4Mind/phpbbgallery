<?php
/**
*
* BB reaction.
*
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
		);
	}

	/* @var \phpbb\config\config*/
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\request */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\controller\helper */
	protected $helper;

	protected $bbemoji_parser;
	protected $bbemoji_enabled = false;

	/** @var string The database table the reactions are stored in */
	protected $reward_table;

	/** @var string The database table the reaction types are stored in */
	protected $reward_type_table;

	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\controller\helper $helper, \phpbb\extension\manager $ext_manager, \Symfony\Component\DependencyInjection\Container $phpbb_container, $reward_table, $reward_type_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->user = $user;
		$this->request = $request;
		$this->template = $template;
		$this->helper = $helper;
		$this->reward_table = $reward_table;
		$this->reward_type_table = $reward_type_table;

		if ($ext_manager->is_enabled('sitesplat/bbemoji'))
		{
			$this->bbemoji_enabled = true;
			$this->bbemoji_parser = new \sitesplat\bbreaction\bbemoji\parser($phpbb_container->getParameter('sitesplat.bbemoji.url.generators'), $phpbb_container->get('path_helper'));
			$this->template->assign_vars(array(
				'BBREACTION_EMOJI'	=> true,
			));
		}
	}

	public function add_page_header_link($event)
	{
		$this->user->add_lang_ext('sitesplat/bbreaction', 'bbreaction');
		
		$this->template->assign_vars(array(
			'U_BBREACTION_PAGE'			=> $this->helper->route('sitesplat_bbreaction_main_controller', array('route' => 'toplist.html')),
			'BBREACTION_DISPLAY_TOP'	=> $this->config['rewards_display_top']
		));
	}
	
	public function viewtopic_handle_posts($event)
	{
		if (($event['topic_data']['topic_status'] != ITEM_LOCKED) &&
			($event['topic_data']['topic_type'] != POST_GLOBAL))
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
				$rewards[] = array(
					'TYPE_ID'		=> $row['type_id'],
					'SYMBOL'		=> $row['symbol'],
					'EMOJI'			=> $this->bbemoji_enabled ? $this->bbemoji_parser->emoji_render($row['emoji']) : '',
					'TITLE'			=> $row['title'],
					'PERCENT'		=> ($this->config['rewards_percent']) ? (($row['percent']) ? round(($row['percent'] / $total) * 100, 1)  : 0) . ' %' : '# ' . $row['percent'],
					'S_POSITIVE'	=> ($row['positive']) ? true : false,
					'SEPERATOR'		=> ($row['seperator']) ? true : false,
					'U_LIKE'		=> append_sid($this->helper->route('sitesplat_bbreaction_main_controller', 
										array('route' => 'index.html', 'p=' . $post_row['POST_ID'], 'e=' . $row['type_id'])))
				);
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
			$this->template->assign_block_vars('reward', array(
				'SYMBOL'		=> $row['symbol'],
				'EMOJI'			=> $this->bbemoji_enabled ? $this->bbemoji_parser->emoji_render($row['emoji']) : '',
				'TITLE'			=> $row['title'],
				'PERCENT'		=> ($this->config['rewards_percent']) ? (($row['percent']) ? round(($row['percent'] / $total) * 100, 1)  : 0) . ' %' : '# ' . $row['percent'],
				'S_POSITIVE'	=> ($row['positive']) ? true : false,
			));
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
				$this->template->assign_block_vars('rewards_memberlist', array(
					'TITLE'				=> $row['title'],
					'ICON'				=> $row['symbol'],
					'EMOJI'				=> $this->bbemoji_enabled ? $this->bbemoji_parser->emoji_render($row['emoji']) : '',
					'S_POSITIVE'		=> $row['positive'],
					'GIVEN_RECIEVED'	=> (($row['type'] == 'given') ? $this->user->lang['BBREACTION_GIVVEN'] : $this->user->lang['BBREACTION_RECIEVED']),
					'GIVE_RECIEVE'		=> $row['num']
				));
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
		$event['permissions'] = $permissions;
	}
}
