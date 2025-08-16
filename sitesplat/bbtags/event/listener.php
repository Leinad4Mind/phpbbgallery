<?php
/**
*
* BBtags
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbtags\event;

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
	protected $tag_manager;
	protected $phpbb_root_path;
	protected $php_ext;

	/**
	* Constructor
	* @access public
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user, \phpbb\config\config $config, \phpbb\request\request $request, \sitesplat\bbtags\tags\manager $tag_manager, $phpbb_root_path, $php_ext)
	{
		$this->auth = $auth;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->request = $request;
		$this->manager = $tag_manager;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
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
			'core.user_setup'								=> 'load_language_on_setup',
			'core.index_modify_page_title'					=> 'viewtopic_assign_template_vars_before',
			'core.viewforum_modify_topics_data'				=> 'viewtopic_assign_template_vars_before',
			
			'core.posting_modify_template_vars'				=> 'modify_template_vars',
			'core.viewtopic_assign_template_vars_before'	=> 'viewtopic_assign_template_vars_before',
			'core.submit_post_end'							=> 'save_tags',
			'core.permissions'								=> 'add_permission',
		);
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/bbtags',
			'lang_set' => 'bbtags',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function viewtopic_assign_template_vars_before($event)
	{
		$data = $event->get_data();

		if (!isset($data['page_title']) || ($this->config['bbtags_on_index'] && isset($data['page_title'])))    		        
		{
			$tags = $this->manager->get_tags((int) (isset($data['topic_id']) ? $data['topic_id'] : 0));
			if (!empty($tags))
			{
				$this->assign_tags_to_template('bbtags', explode(',', $tags));
				$this->template->assign_vars(array(
					'BBTAGS_SHOW'	=> $this->auth->acl_get('u_bbtags'),
					'META'			=> '<meta name="keywords" content="' . $tags . '">',
				));
			}
		}
	}

	public function modify_template_vars($event)
	{
		$data = $event->get_data();
		$forum_id = $data['forum_id'];

		$topic_id = false;

		if (empty($data['mode']) || $data['mode'] == 'reply')
		{
			return;
		}

		if (!empty($data['post_data']['topic_id']))
		{
			$topic_id = $data['post_data']['topic_id'];
		}

		$is_edit_first_post = $topic_id && $this->is_edit_first_post($data['mode'], $data['post_data']);
		if ($data['mode'] == 'post' || $is_edit_first_post)
		{
			$data['page_data']['BBTAGS_SHOW_FIELD'] = $this->auth->acl_get('u_bbtags');
			$data['page_data']['BBTAGS_TAGS'] = ($this->request->is_set_post('bbtags') || !$topic_id) ? 
					utf8_normalize_nfc($this->request->variable('bbtags', '', true)) : $this->manager->get_tags($topic_id);
			$data['page_data']['BBTAGS_MAXTAGS'] = $this->config['bbtags_max_tags'];
			$data['page_data']['BBTAGS_MAXLENGTH'] = $this->config['bbtags_min_length'];
			$event->set_data($data);
		}
	}

	private function is_edit_first_post($mode, array $post_data)
	{
		$post_id = $topic_first_post_id = false;
		if (!empty($post_data['topic_first_post_id']))
		{
			$topic_first_post_id = $post_data['topic_first_post_id'];
		}
		if (!empty($post_data['post_id']))
		{
			$post_id = $post_data['post_id'];
		}
		return $mode == 'edit' && $post_id && $post_id == $topic_first_post_id;
	}



	private function assign_tags_to_template($block_name, array $tags)
	{
		foreach ($tags as $tag)
		{
			$this->template->assign_block_vars($block_name, array (
				'TAG'	=> $tag,
				'URL'	=> $this->helper->route('sitesplat_bbtags_controller', array('tags' => $this->manager->Slug($tag)))
			));
		}
	}

	public function save_tags($event)
	{
		$data = $event['data'];
		if ($this->auth->acl_get('u_bbtags') && ($event['mode'] == 'post' || $this->is_edit_first_post($event['mode'], $data)))
		{
			$tag_str = utf8_normalize_nfc($this->request->variable('bbtags', '', true));
			$tag_str = explode(',', $tag_str);

			$tags = array();
			foreach($tag_str as $tag)
			{
				(strlen($tag) >= $this->config['bbtags_min_length']) ? $tags[] = $this->manager->clean_tag($tag) : null;
				
			}
			$this->manager->assign_tags_to_topic($data['topic_id'], $tags);
		}
	}

	/**
	* Add permissions to page
	* @access public
	*/
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_bbtags'] = array('lang' => 'ACL_U_BBTAGS', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}
}
