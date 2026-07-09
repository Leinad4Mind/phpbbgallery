<?php
/**
*
* @package BBfront
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbfront\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'					=> 'load_language_on_setup',
			'core.page_header'					=> 'add_page_header_link',
			'core.viewtopic_cache_user_data'	=> 'viewtopic_cache_user_data',
			'core.viewtopic_modify_post_row'	=> 'viewtopic_handle_posts',
			'core.posting_modify_template_vars'	=> 'onEdit',
			'core.submit_post_modify_sql_data'	=> 'onSubmit',
		);
	}

	protected $request;
	protected $helper;
	protected $config;
	protected $user;
	protected $template;
	protected $phpbb_root_path;
	protected $php_ext;

	/**
	* Constructor
	*/
	public function __construct(\phpbb\request\request $request, \phpbb\controller\helper $helper, \phpbb\config\config $config, \phpbb\user $user, \phpbb\template\template $template, $phpbb_root_path, $php_ext)
	{
		$this->request = $request;
		$this->helper = $helper;
		$this->config = $config;
		$this->user = $user;
		$this->template = $template;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/bbfront',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_page_header_link($event)
	{
		$config_ary = json_decode($this->config['bbfront_settings'], true);
		$this->template->assign_vars(array(
			'U_BBFRONT_PAGE'	=> $this->helper->route('sitesplat_bbfront_controller', array('name' => $config_ary['name'])),
			'BBFRONT_PAGE'		=> $config_ary['name']
		));
	}

	public function viewtopic_cache_user_data($event)
	{
		$user_cache_data = $event['user_cache_data'];
		$user_cache_data['bbfront'] = $event['row']['bbfront'];
		$event['user_cache_data'] = $user_cache_data;
	}
	
	public function viewtopic_handle_posts($event)
	{
		$forum_ary = json_decode($this->config['bbfront_inc_forums'], true);
		$group_ary = json_decode($this->config['bbfront_inc_groups'], true);

		if ($event['topic_data']['topic_status'] != ITEM_LOCKED && $event['topic_data']['topic_type'] != POST_GLOBAL && 
			$event['topic_data']['topic_first_post_id'] == $event['row']['post_id'] && in_array($event['topic_data']['forum_id'], $forum_ary))
		{
			if (!function_exists('group_memberships'))
			{
			  include_once($this->phpbb_root_path . 'includes/functions_user.' . $this->php_ext);
			}
			
			if (group_memberships($group_ary, array($this->user->data['user_id']), true))
			{
				$post_row = $event['post_row'];
				$post_row['U_BBFRONT'] = $this->helper->route('sitesplat_bbfront_controller', array('name' => 'index.html', 'action' => 'change-status', 'id' => $post_row['POST_ID']));
				$post_row['S_BBFRONT'] = $event['user_poster_data']['bbfront'];
				$event['post_row'] = $post_row;
			}
		}
	}

	public function onEdit($event)
	{
		$forum_ary = json_decode($this->config['bbfront_inc_forums'], true);
		$group_ary = json_decode($this->config['bbfront_inc_groups'], true);
		
		if (!function_exists('group_memberships'))
		{
			include_once($this->phpbb_root_path . 'includes/functions_user.' . $this->php_ext);
		}
		
		$group_member = group_memberships($group_ary, array($this->user->data['user_id']), true);
		
		$this->template->assign_vars(array(
			'S_IN_BBFRONT_FORUM'	=> ($event['mode'] == 'post' || $event['post_id'] == $event['post_data']['topic_first_post_id']) && in_array($event['forum_id'], $forum_ary) && $group_member,
			'S_BBFRONT_CHECKED'		=> (isset($event['post_data']['bbfront']) && $event['post_data']['bbfront']) ? ' checked="checked"' : '',
		));
	}

	public function onSubmit($event)
	{
		$sql_data = $event['sql_data'];
		$sql_data[POSTS_TABLE]['sql']['bbfront'] = (isset($_POST['show_bbfront'])) ? 1 : 0;
		$event['sql_data'] = $sql_data;
	}
}
