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
use phpbb\auth\auth;
use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\user;
use phpbb\config\config;
use phpbb\request\request;
use sitesplat\bbtags\tags\manager;
use sitesplat\bbtags\tags\moderation;

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
	protected $manager;
	protected $moderation;

	/**
	* Constructor
	* @access public
	*/
	public function __construct(auth $auth, helper $helper, template $template, user $user, config $config, request $request, manager $tag_manager, moderation $moderation)
	{
		$this->auth = $auth;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->request = $request;
		$this->manager = $tag_manager;
		$this->moderation = $moderation;
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
			'core.user_setup'						=> 'load_lang',
			'core.page_header_after'				=> 'load_tags',
			'core.posting_modify_template_vars'		=> 'modify_template_vars',
			'core.submit_post_end'					=> 'save_tags',
			'core.delete_topics_after_query'		=> 'delete_tags',
			'core.permissions'						=> 'add_permission',
		);
	}

	public function load_lang($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/bbtags',
			'lang_set' => 'bbtags',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function load_tags()
	{
		if (!$this->catalog_is_ready())
		{
			return;
		}

		if ($this->config['bbtags_on_index'] == 2
			|| ($this->config['bbtags_on_index'] == 1
				&& substr($this->user->data['session_page'], 0, 6) == 'index.')
		)
		{
			$tags = $this->manager->get_tags(0);
			if ($tags != '')
			{
				if ($this->auth->acl_get('u_bbtags_read'))
				{
					$this->assign_tags_to_template('bbtags', explode(',', $tags));
				}
				$this->template->assign_vars(array(
					'META_KEYWORDS' => '<meta name="keywords" content="' . htmlspecialchars($tags, ENT_QUOTES, 'UTF-8') . '">',
				));
			}
		}

		$topic_id = $this->request->variable('t', 0);
		if ($topic_id)
		{
			$tags = $this->manager->get_tags($topic_id);
			if ($tags != '' && $this->auth->acl_get('u_bbtags_read'))
			{
				$this->assign_tags_to_template('bbtagstopic', explode(',', $tags));
			}
		}
	}

	public function modify_template_vars($event)
	{
		if (!$this->catalog_is_ready())
		{
			return;
		}

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
			$pending_tags = [];
			if ($topic_id && !$this->request->is_set_post('bbtags'))
			{
				$assigned_tags = array_filter(array_map('trim', explode(',', $this->manager->get_tags($topic_id))));
				$pending_tags = $this->moderation->get_item_pending_tags(manager::FORUM_PROVIDER, (int) $topic_id);
				$tag_value = implode(', ', array_values(array_unique(array_merge($assigned_tags, $pending_tags))));
			}
			else
			{
				$tag_value = utf8_normalize_nfc($this->request->variable('bbtags', '', true));
			}
			$data['page_data']['BBTAGS_SHOW_FIELD'] = $this->auth->acl_get('u_bbtags');
			$data['page_data']['BBTAGS_TAGS'] = $tag_value;
			$data['page_data']['BBTAGS_HAS_PENDING'] = !empty($pending_tags);
			$data['page_data']['BBTAGS_MAXTAGS'] = $this->config['bbtags_max_tags'];
			$data['page_data']['BBTAGS_MAXLENGTH'] = isset($this->config['bbtags_max_length']) ? (int) $this->config['bbtags_max_length'] : manager::MAX_TAG_LENGTH;
			$data['page_data']['BBTAGS_FORUM_ID'] = (int) $forum_id;
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
			$tag = trim($tag);
			$this->template->assign_block_vars($block_name, array(
				'TAG'	=> htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'),
				'URL'	=> $this->helper->route('sitesplat_bbtags_controller', array('tags' => $this->manager->slug($tag, array('transliterate' => true)))),
			));
		}
	}

	public function save_tags($event)
	{
		if (!$this->catalog_is_ready())
		{
			return;
		}

		$data = $event['data'];
		if ($this->auth->acl_get('u_bbtags') && ($event['mode'] == 'post' || $this->is_edit_first_post($event['mode'], $data)))
		{
			$tag_str = utf8_normalize_nfc($this->request->variable('bbtags', '', true));
			$tag_str = explode(',', $tag_str);

			$tags = array();
			foreach ($tag_str as $tag)
			{
				$tag = $this->manager->clean_tag($tag);
				if (utf8_strlen($tag) >= (int) $this->config['bbtags_min_length'])
				{
					$tags[] = $tag;
				}
			}
			$tags = array_slice(array_values(array_unique($tags)), 0, (int) $this->config['bbtags_max_tags']);
			$topic_id = (int) $data['topic_id'];
			$forum_id = (int) $data['forum_id'];
			if ($this->auth->acl_get('m_bbtags_moderate'))
			{
				if ($this->manager->assign_tags_to_topic($topic_id, $tags, $forum_id))
				{
					$this->moderation->sync_item_suggestions([], manager::FORUM_PROVIDER, $forum_id, $topic_id, (int) $this->user->data['user_id']);
				}
				return;
			}

			$scope_path = $this->manager->get_forum_scope_path($forum_id);
			$classified_tags = $this->manager->classify_tags($tags, manager::FORUM_PROVIDER, $scope_path);
			$available_tags = $classified_tags['available'];
			if (!$this->manager->assign_tags_to_topic($topic_id, $available_tags, $forum_id, false))
			{
				return;
			}
			$this->moderation->sync_item_suggestions(
				$classified_tags['suggestible'],
				manager::FORUM_PROVIDER,
				$forum_id,
				$topic_id,
				(int) $this->user->data['user_id']
			);
		}
	}

	public function delete_tags($event)
	{
		if (!$this->catalog_is_ready())
		{
			return;
		}

		$topic_ids = $event['topic_ids'];
		$this->moderation->cancel_items(manager::FORUM_PROVIDER, $topic_ids);
		$this->manager->remove_tags_from_topics($topic_ids);
	}

	/**
	* Add permissions to page
	* @access public
	*/
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_bbtags'] = array('lang' => 'ACL_U_BBTAGS', 'cat' => 'misc');
		$permissions['u_bbtags_read'] = array('lang' => 'ACL_U_BBTAGS_READ', 'cat' => 'misc');
		$permissions['m_bbtags_moderate'] = array('lang' => 'ACL_M_BBTAGS_MODERATE', 'cat' => 'post_actions');
		$event['permissions'] = $permissions;
	}

	/**
	 * Check whether the provider-independent catalogue migrations are complete
	 *
	 * @return bool
	 */
	private function catalog_is_ready()
	{
		return isset($this->config['bbtags_catalog_version'])
			&& (int) $this->config['bbtags_catalog_version'] >= 1;
	}
}
