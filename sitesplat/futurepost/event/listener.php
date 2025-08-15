<?php
/**
*
* Future Posts
*
* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\futurepost\event;

use phpbb\auth\auth;
use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\user;
use phpbb\config\config;
use phpbb\request\request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $auth;
	protected $helper;
	protected $template;
	protected $user;
	protected $config;
	protected $request;
	protected $phpbb_root_path;
	protected $php_ext;

	/**
	* Constructor
	* @access public
	*/
	public function __construct(auth $auth, helper $helper, template $template, \phpbb\user $user, config $config, request $request, $phpbb_root_path, $php_ext)
	{
		$this->auth = $auth;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->request = $request;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;

		$this->user->add_lang_ext('forumhulp/futurepost', 'futurepost');
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
			'core.posting_modify_template_vars'				=> 'temp_future_time',
			'core.modify_submit_post_data'					=> 'save_future_time',
			'core.submit_post_modify_sql_data'				=> 'sql_future_time',
			'core.permissions'								=> 'add_permission',

			'core.mcp_front_queue_unapproved_total_before'	=> 'mcp_list',
			'core.mcp_front_queue_unapproved_posts_before'	=> 'mcp_posts',
		);
	}

	/**
	* Template_future_time
	* @access public
	*/
	public function mcp_list($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['WHERE'] .= ' AND p.post_time <= ' . time();	
		$event['sql_ary'] = $sql_ary;
	}

	/**
	* Template_future_time
	* @access public
	*/
	public function mcp_posts($event)
	{
		$sql = $event['sql'];
		$sql = str_replace('ORDER BY', ' AND post_time <=' . time() . ' ORDER BY', $sql);
		$event['sql'] = $sql;
	}

	/**
	* Template_future_time
	* @access public
	*/
	public function temp_future_time($event)
	{
		$template = $event['page_data'];
		if ($this->auth->acl_get('u_futureposts') && $event['topic_data']['topic_status'] != ITEM_LOCKED && $event['topic_data']['topic_type'] != POST_GLOBAL && 
			$event['topic_data']['topic_first_post_id'] == $event['row']['post_id'] && ($event['mode'] == 'post' || $event['mode'] == 'edit'))
		{
			if ($event['post_data']['post_time'] > time() || $event['mode'] == 'post' || ($event['mode'] == 'edit' && $event['post_data']['post_visibility'] == ITEM_UNAPPROVED))
			{
				$template['S_FUTURE_DATE'] = ($event['post_data']['post_time'] > time()) ? ' checked="checked"' : '';
				$template['T_FUTURE_DATE'] = ($event['post_data']['post_time'] > time()) ? date('m/d/Y', $event['post_data']['post_time']) : '';
				$template['D_FUTURE_DATE'] = date('m/d/Y', ($event['post_data']['post_time']) ? $event['post_data']['post_time'] : time() + 86400);
				$template['S_FUTURE_DATE_HIDDEN'] = true;
			} else
			{
				$template['S_FUTURE_DATE_HIDDEN'] = false;
			}
		} else
		{
			$template['S_FUTURE_DATE_HIDDEN'] = false;
		}
		$event['page_data'] = $template;
	}

	/**
	* Save_future_time
	* @access public
	*/
	public function sql_future_time($event)
	{
		$data = $event['sql_data'];
		if ($this->request->is_set_post('future_chk'))
		{
			$data[POSTS_TABLE]['sql']['post_time'] = strtotime($this->request->variable('future_date', ''));
			$data[POSTS_TABLE]['sql']['post_visibility'] = ITEM_UNAPPROVED;			
		} else
		{
			$data[POSTS_TABLE]['sql']['post_time'] = time();
		}
		$event['sql_data'] = $data;
	}

	/**
	* Save_future_time
	* @access public
	*/
	public function save_future_time($event)
	{
		$data = $event['data'];
		if ($this->request->is_set_post('future_chk'))
		{
			$data['post_time'] = strtotime($this->request->variable('future_date', ''));
			$data['post_visibility'] = ITEM_UNAPPROVED;			
		} else
		{
			$data['post_time'] = time();
		}
		$event['data'] = $data;
	}

	/**
	* Add permissions to page
	* @access public
	*/
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_futureposts'] = array('lang' => 'ACL_U_FUTUREPOSTS', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}
}
