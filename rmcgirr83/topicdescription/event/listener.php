<?php
/**
*
* @package Topic description
* @copyright (c) 2016 RMcGirr83
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*
*/

namespace rmcgirr83\topicdescription\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	private $topic_desc = '';

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth					$auth				Auth object
	* @param \phpbb\request\request				$request			Request object
	* @param \phpbb\template\template           $template       	Template object
	* @param \phpbb\user                        $user           	User object
	* @access public
	*/
	public function __construct(
			\phpbb\auth\auth $auth,
			\phpbb\request\request $request,
			\phpbb\template\template $template,
			\phpbb\user $user)
	{
		$this->auth = $auth;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
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
			'core.permissions'						=> 'add_permission',
			'core.posting_modify_template_vars'		=> 'topic_data_topic_desc',
			'core.posting_modify_submission_errors'		=> 'topic_desc_add_to_post_data',
			'core.posting_modify_submit_post_before'		=> 'topic_desc_add',
			'core.posting_modify_message_text'		=> 'modify_message_text',
			'core.submit_post_modify_sql_data'		=> 'submit_post_modify_sql_data',
			'core.viewtopic_modify_page_title'		=> 'topic_desc_add_viewtopic',
			'core.viewforum_modify_topicrow'		=> 'modify_topicrow',
			'core.search_modify_tpl_ary'			=> 'search_modify_tpl_ary',
			'core.mcp_view_forum_modify_topicrow'	=> 'modify_topicrow',
		);
	}

	/**
	* Add administrative permissions to manage forums
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['f_topic_desc'] = array('lang' => 'ACL_F_TOPIC_DESC', 'cat' => 'post');
		$event['permissions'] = $permissions;
	}

	public function topic_data_topic_desc($event)
	{
		$mode = $event['mode'];
		$post_data = $event['post_data'];
		$page_data = $event['page_data'];
		$post_data['topic_desc'] = (!empty($post_data['topic_desc'])) ? $post_data['topic_desc'] : '';
		if ($this->auth->acl_get('f_topic_desc', $event['forum_id']) && ($mode == 'post' || ($mode == 'edit' && $post_data['topic_first_post_id'] == $post_data['post_id'])))
		{
			$this->user->add_lang_ext('rmcgirr83/topicdescription', 'common');
			$page_data['TOPIC_DESC'] = $this->request->variable('topic_desc', $post_data['topic_desc'], true);
			$page_data['S_DESC_TOPIC'] = true;
		}

		$event['page_data']	= $page_data;
	}

	public function topic_desc_add_to_post_data($event)
	{
		if ($this->auth->acl_get('f_topic_desc', $event['forum_id']))
		{
			$event['post_data'] = array_merge($event['post_data'], array(
				'topic_desc'	=> $this->request->variable('topic_desc', '', true),
			));
		}
	}

	public function topic_desc_add($event)
	{
		$event['data'] = array_merge($event['data'], array(
			'topic_desc'	=> $event['post_data']['topic_desc'],
		));
	}

	public function modify_message_text($event)
	{
		$event['post_data'] = array_merge($event['post_data'], array(
			'topic_desc'	=> $this->request->variable('topic_desc', $event['post_data']['topic_desc'], true),
		));
	}

	public function submit_post_modify_sql_data($event)
	{
		$mode = $event['post_mode'];
		$topic_desc = $event['data']['topic_desc'];
		$data_sql = $event['sql_data'];
		if (in_array($mode, array('post', 'edit_topic', 'edit_first_post')))
		{
			$data_sql[TOPICS_TABLE]['sql']['topic_desc'] = $topic_desc;
		}
		$event['sql_data'] = $data_sql;
	}

	public function topic_desc_add_viewtopic($event)
	{
		$topic_data = $event['topic_data'];
		$this->template->assign_var('TOPIC_DESC',censor_text($topic_data['topic_desc']));
	}

	public function modify_topicrow($event)
	{
		$row = $event['row'];
		if (!empty($row['topic_desc']))
		{
			$topic_row = $event['topic_row'];
			$topic_row['TOPIC_DESC'] = censor_text($row['topic_desc']);
			$event['topic_row'] = $topic_row;
		}
	}

	public function search_modify_tpl_ary($event)
	{
		$row = $event['row'];
		if ($event['show_results'] == 'topics' && !empty($row['topic_desc']))
		{
			$tpl_array = $event['tpl_ary'];
			$tpl_array['TOPIC_DESC'] = censor_text($row['topic_desc']);
			$event['tpl_ary'] = $tpl_array;
		}
	}
}
