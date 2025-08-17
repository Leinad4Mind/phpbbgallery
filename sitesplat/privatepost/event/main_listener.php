<?php
/**
*
* Private Post
*
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\privatepost\event;

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
			// misc
			'core.permissions'	=> 'add_permissions',
			'core.user_setup'	=> 'load_language_on_setup',

			// posting
			'core.modify_posting_auth'			=> 'no_auth_private_post',
			'core.posting_modify_message_text'	=> 'retain_private_post_on_preview',
			'core.posting_modify_template_vars'	=> 'prepare_private_post_checkbox',
			'core.submit_post_modify_sql_data'	=> 'save_private_post_on_post_submit',
			'core.topic_review_modify_row'		=> 'add_private_post_review_template',

			// viewtopic
			'core.viewtopic_post_rowset_data'	=> 'add_private_post_to_rowset',
			'core.viewtopic_modify_post_row'	=> 'add_private_post_template',

			// mcp
			'core.mcp_global_f_read_auth_after'	=> 'mcp_auth_private_post',

			// report
			'core.report_post_auth'	=> 'no_report_private_post',

			// search
			'core.search_modify_tpl_ary'	=> 'remove_private_posts_from_search',

			// Fancy Lazy Topic Loader extension
			'sitesplat.fltl.controller_sql'			=> 'fltl_fetch_private_post_data',
			'sitesplat.fltl.controller_sql_after'	=> 'fltl_mark_private_post_data',

			// BBpreview
			'sitesplat.bbtpreview.controller_sql'				=> 'bbtpreview_fetch_private_post_data',
			'sitesplat.bbtpreview.controller_response_before'	=> 'bbtpreview_mark_private_post_data',
		);
	}

	/* @var \phpbb\request\request */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\auth\auth */
	protected $auth;

	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\user */
	protected $user;

	/* @var string */
	protected $posts_table;

	/**
	* Constructor
	*
	* @param \phpbb\controller\request	$request		Request object
	* @param \phpbb\template\template	$template		Template object
	* @param \phpbb\auth\auth			$auth			Auth object
	* @param \phpbb\user				$user			User object
	* @param string						$posts_table	Posts table
	*/
	public function __construct(\phpbb\request\request $request, \phpbb\template\template $template, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, $posts_table)
	{
		$this->request = $request;
		$this->template = $template;
		$this->auth = $auth;
		$this->db = $db;
		$this->user = $user;
		$this->posts_table = $posts_table;
	}

	public function add_permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['f_seeprivateposts'] = array('lang' => 'ACL_U_SEEPRIVATEPOSTS', 'cat' => 'content');
		$event['permissions'] = $permissions;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/privatepost',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function no_auth_private_post($event)
	{
		if (in_array($event['mode'], array('quote', 'edit', 'soft_delete', 'delete')))
		{
			$sql = 'SELECT poster_id, post_private
					FROM ' . $this->posts_table . '
					WHERE post_id = ' . (int) $event['post_id'];
			$this->db->sql_query($sql);

			if ($this->db->sql_fetchfield('post_private') == '1')
			{
				if ($event['mode'] == 'quote')
				{
					trigger_error('NO_QUOTE_PRIVATE_POST');
				}

				if (!$this->auth->acl_get('f_seeprivateposts', $event['forum_id']) && $this->db->sql_fetchfield('post_private') != $this->user->data['user_id'])
				{
					trigger_error('NO_MANIPULATION_PRIVATE_POST');
				}
			}
		}
	}

	public function retain_private_post_on_preview($event)
	{
		$post_data = $event['post_data'];
		$post_data['post_private'] = $this->request->is_set_post('private_post');
		$event['post_data'] = $post_data;
	}

	public function prepare_private_post_checkbox($event)
	{
		$this->template->assign_vars(array(
			'S_PRIVATE_CHECKED'	=> (isset($event['post_data']['post_private']) && $event['post_data']['post_private']) ? ' checked="checked"' : '',
		));
	}

	public function save_private_post_on_post_submit($event)
	{
		$sql_data = $event['sql_data'];
		$sql_data[POSTS_TABLE]['sql']['post_private'] = $this->request->is_set_post('private_post');
		$event['sql_data'] = $sql_data;
	}

	public function add_private_post_review_template($event)
	{
		$post_row = $event['post_row'];
		$post_row['S_POST_PRIVATE'] = ($this->auth->acl_get('f_seeprivateposts', $event['row']['forum_id']) || $event['row']['poster_id'] == $this->user->data['user_id']) ? false : (bool) $event['row']['post_private'];
		$event['post_row'] = $post_row;
	}

	public function add_private_post_to_rowset($event)
	{
		$rowset_data = $event['rowset_data'];
		$rowset_data['post_private'] = $event['row']['post_private'];
		$event['rowset_data'] = $rowset_data;
	}

	public function add_private_post_template($event)
	{
		$post_row = $event['post_row'];

		$post_private = (bool) $event['row']['post_private'];

		$post_row['S_POST_PRIVATE'] = ($this->auth->acl_get('f_seeprivateposts', $event['row']['forum_id']) || $event['poster_id'] == $this->user->data['user_id']) ? false : $post_private;
		if ($post_private)
		{
			$post_row['POST_SUBJECT'] = $this->user->lang('PRIVATE_TAG') . $post_row['POST_SUBJECT'];
			$post_row['U_QUOTE'] = '';
		}

		$event['post_row'] = $post_row;
	}

	public function mcp_auth_private_post($event)
	{
		if (!$this->auth->acl_get('f_seeprivateposts', $event['forum_id']))
		{
			if ($event['quickmod'])
			{
				$sql = 'SELECT post_id
						FROM ' . $this->posts_table . '
						WHERE post_private = 1
							AND topic_id = ' . (int) $event['topic_id'];
				$this->db->sql_query($sql);
				if ($this->db->sql_affectedrows())
				{
					trigger_error('NO_QUICKMOD_WITH_PRIVATE_POST');
				}
			}
			else if ($event['mode'] == 'topic_view')
			{
				$sql = 'SELECT post_id
						FROM ' . $this->posts_table . '
						WHERE post_private = 1
							AND topic_id = ' . (int) $event['topic_id'];
				$this->db->sql_query($sql);
				if ($this->db->sql_affectedrows())
				{
					trigger_error('NO_MCP_TOPIC_WITH_PRIVATE_POST');
				}
			}
			else if ($event['mode'] == 'warn_post')
			{
				$sql = 'SELECT post_id
						FROM ' . $this->posts_table . '
						WHERE post_private = 1
							AND post_id = ' . (int) $this->request->variable('p', 0);
				$this->db->sql_query($sql);
				if ($this->db->sql_affectedrows())
				{
					trigger_error('NO_MCP_WARN_PRIVATE_POST');
				}
			}
			else if ($event['mode'] == 'post_details')
			{
				$sql = 'SELECT poster_id, post_private
						FROM ' . $this->posts_table . '
						WHERE post_id = ' . (int) $this->request->variable('p', 0);
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
				if ($row['post_private'] == '1' && $row['poster_id'] != $this->user->data['user_id'])
				{
					trigger_error('NO_MCP_POST_DETAILS_PRIVATE_POST');
				}
			}
			else if ($event['mode'] == 'report_details')
			{
				$sql = 'SELECT p.poster_id, p.post_private
						FROM ' . $this->posts_table . ' as p, . ' . REPORTS_TABLE . ' as r
						WHERE p.post_id = r.post_id
							AND r.report_id = ' . (int) $this->request->variable('r', 0);
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
				if ($row['post_private'] == '1' && $row['poster_id'] != $this->user->data['user_id'])
				{
					trigger_error('NO_MCP_REPORT_PRIVATE_POST');
				}
			}
		}
	}

	public function no_report_private_post($event)
	{
		if (!$this->auth->acl_get('f_seeprivateposts', $event['forum_data']['forum_id']) && $event['report_data']['poster_id'] != $this->user->data['user_id'])
		{
			trigger_error('NO_REPORT_PRIVATE_POST');
		}
	}

	public function remove_private_posts_from_search($event)
	{
		if ($event['show_results'] == 'posts')
		{
			$post_private = (bool) $event['row']['post_private'];

			$tpl_ary = $event['tpl_ary'];
			$tpl_ary['S_POST_PRIVATE'] = ($this->auth->acl_get('f_seeprivateposts', $event['row']['forum_id']) || $event['row']['poster_id'] == $this->user->data['user_id']) ? false : $post_private;
			if ($post_private)
			{
				$tpl_ary['POST_SUBJECT'] = $this->user->lang('PRIVATE_TAG') . $tpl_ary['POST_SUBJECT'];
			}
			$event['tpl_ary'] = $tpl_ary;
		}
	}

	public function fltl_fetch_private_post_data($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['SELECT'] .= ', p.poster_id, p.post_private';
		$event['sql_ary'] = $sql_ary;
	}

	public function fltl_mark_private_post_data($event)
	{
		$rows = $event['rows'];
		foreach ($rows as &$row)
		{
			if ($row['post_private'] == '1' && $row['poster_id'] != $this->user->data['user_id'] && !$this->auth->acl_get('f_seeprivateposts', $row['forum_id']))
			{
				$row['post_text'] = $this->user->lang('FLTL_PRIVATE');
			}
		}
		$event['rows'] = $rows;
	}

	public function bbtpreview_fetch_private_post_data($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['SELECT'] .= ', p.post_private';
		$event['sql_ary'] = $sql_ary;
	}

	public function bbtpreview_mark_private_post_data($event)
	{
		$row = $event['row'];
		if ($row['post_private'] == '1' && $row['topic_poster'] != $this->user->data['user_id'] && !$this->auth->acl_get('f_seeprivateposts', $row['forum_id']))
		{
			$row['post_text'] = $this->user->lang('BBPREVIEW_PRIVATE');
		}
		$event['row'] = $row;
	}
}
