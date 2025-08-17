<?php
/**
*
* @package phpBB Extension - Topic Index
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\topicindex\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use dmzx\topicindex\core\functions_topicindex;
use phpbb\user;
use phpbb\auth\auth;
use phpbb\template\template;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\request\request_interface;
use phpbb\files\factory;

class listener implements EventSubscriberInterface
{
	/** @var functions_topicindex */
	protected $functions_topicindex;

	/** @var user */
	protected $user;

	/** @var auth */
	protected $auth;

	/** @var template */
	protected $template;

	/** @var db_interface */
	protected $db;

	/** @var config */
	protected $config;

	/** @var helper */
	protected $helper;

	/** @var request_interface */
	protected $request;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/** @var factory */
	protected $files_factory;

	/**
	* Constructor
	*
	* @param functions_topicindex	$functions_topicindex
	* @param user					$user
	* @param auth					$auth
	* @param template				$template
	* @param db_interface			$db
	* @param config					$config
	* @param helper					$helper
	* @param request_interface		$request
	* @param string					$root_path
	* @param string					$php_ext
	* @param factory				$files_factory
	*/
	public function __construct(
		functions_topicindex $functions_topicindex,
		user $user,
		auth $auth,
		template $template,
		db_interface $db,
		config $config,
		helper $helper,
		request_interface $request,
		$root_path,
		$php_ext,
		factory $files_factory = null
	)
	{
		$this->functions_topicindex		= $functions_topicindex;
		$this->user						= $user;
		$this->auth 					= $auth;
		$this->template					= $template;
		$this->db						= $db;
		$this->config					= $config;
		$this->helper 					= $helper;
		$this->request 					= $request;
		$this->root_path 				= $root_path;
		$this->php_ext 					= $php_ext;
		$this->files_factory 			= $files_factory;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.viewonline_overwrite_location'			=> 'add_page_viewonline',
			'core.permissions'								=> 'permissions',
			'core.user_setup'								=> 'load_language_on_setup',
			'core.page_header'								=> 'page_header',
			'core.acp_manage_forums_request_data'			=> 'acp_manage_forums_request_data',
			'core.acp_manage_forums_initialise_data'		=> 'acp_manage_forums_initialise_data',
			'core.acp_manage_forums_display_form'			=> 'acp_manage_forums_display_form',
			'core.viewtopic_modify_post_row'				=> 'viewtopic_modify_post_row',
		);
	}

	public function add_page_viewonline($event)
	{
		if (strrpos($event['row']['session_page'], 'app.' . $this->php_ext . '/topicindex') === 0)
		{
			$event['location'] = $this->user->lang('OIINDEX_HEADER');
			$event['location_url'] = $this->helper->route('dmzx_topicindex_controller', array('name' => 'index'));
		}
	}

	public function permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_topicindex_view'] = array('lang' => 'ACL_U_TOPICINDEX', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'dmzx/topicindex',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function page_header($event)
	{
		$this->template->assign_vars(array(
			'U_OTINDEX'				=> $this->helper->route('dmzx_topicindex_controller'),
			'PHPBB_IS_32'			=> ($this->files_factory !== null) ? true : false,
			'TOPICINDEXLIST_VIEW'	=> $this->auth->acl_get('u_topicindex_view'),
		));
	}

	// Submit form (add/update)
	public function acp_manage_forums_request_data($event)
	{
		$forum_data = $event['forum_data'];

		$forum_data = array_merge($forum_data, array(
			'post_index'			=> $this->request->variable('post_index', 0),
			'default_inindex'		=> $this->request->variable('default_inindex', 0),
			'tag_filter'			=> $this->request->variable('index_filter', 0),
		));

		$event['forum_data'] = $forum_data;
	}

	// Default settings for new forums
	public function acp_manage_forums_initialise_data($event)
	{
		$this->user->add_lang_ext('dmzx/topicindex', 'acp_topicindex');

		$forum_data = $event['forum_data'];
		if ($event['action'] == 'add')
		{
			$forum_data['post_index'] = 0;
			$forum_data['default_inindex'] = 0;
			$forum_data['tag_filter'] =	0;
		}
		$event['forum_data'] = $forum_data;
	}

	// ACP forums template output
	public function acp_manage_forums_display_form($event)
	{
		$template_data = $event['template_data'];
		$forum_data = $event['forum_data'];
		$forum_id = $event['forum_id'];
		$action = $event['action'];

		if ($forum_id)
		{
			$sql = "SELECT topic_id, forum_id, topic_posts_approved, topic_title, topic_type
				FROM " . TOPICS_TABLE . "
				WHERE forum_id = " . (int) $forum_id . "
				AND topic_posts_approved >= 1
				AND (topic_type = " . POST_STICKY . "
					OR topic_type = " . POST_ANNOUNCE . ")
						ORDER BY topic_title ASC";
			$result	= $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$this->template->assign_block_vars('block_topic_index', array(
					'ITOPIC_ID'		=> $row['topic_id'],
					'ITOPIC_SEL'	=> ($row['topic_id'] == $forum_data['post_index']) ? 'selected="selected"' : '',
					'ITOPIC_NAME'	=> $row['topic_title']
				));
			}
			$this->db->sql_freeresult();
		}
		$template_data = array_merge($template_data, array(
			'LEGATOPIC1'	=> ($forum_data['post_index'] == 0) ? 'selected="selected"' : '',
			'ITOPICDEF1'	=> ($forum_data['default_inindex'] == 1) ? 'selected="selected"' : '',
			'ITOPICDEF0'	=> ($forum_data['default_inindex'] == 0) ? 'selected="selected"' : '',
			'ITOPICTAG'		=> ($forum_data['tag_filter'] == 1) ? 'checked="checked"' : '',
			'SHOW_OINDEX'	=> ($action == 'edit') ? true : false,
		));

		$event['template_data'] = $template_data;
	}

	public function viewtopic_modify_post_row($event)
	{
		$row 		= $event['row'];
		$post_row 	= $event['post_row'];
		$topic_data	= $event['topic_data'];
		$topic_id	= $row['topic_id'];
		$forum_id	= $row['forum_id'];
		$iremove	= $this->request->variable('iremove', 0);
		$iaddlist	= $this->request->variable('iaddlist', 0);
		$ilimiter	= $this->request->variable('ilimit', '');
		$official_topic_index = $post_row['MESSAGE'];

		if (!empty($topic_data['post_index']) && $topic_data['post_index'] > 0 && $row['post_id'] == $topic_data['topic_first_post_id'] && $topic_data['post_index'] != $topic_id)
		{
			$icheker		= $this->functions_topicindex->checkif_inlist($topic_data['default_inindex'], $topic_data['inindex_topic'], $topic_data['outindex_topic']);
			$iindex_url		= (!empty($icheker)) ? append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$topic_id}&amp;iremove={$topic_id}") : append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$topic_id}&amp;iaddlist={$topic_id}");
			$iindex_img		= (!empty($icheker)) ? 'fa fa-minus fa-fw' : 'fa fa-plus fa-fw';
			$iindex_lan		= (!empty($icheker)) ? $this->user->lang['REMOVE_INILIST'] : $this->user->lang['ADD_INILIST'];
			$iindex_bb_img	= (!empty($icheker)) ? $this->user->img('icon_post_iremove', 'REMOVE_INILIST') : $this->user->img('icon_post_iinlist', 'ADD_INILIST');
		}
		else
		{
			$iindex_url		= '';
			$iindex_img		= '';
			$iindex_lan		= '';
			$iindex_bb_img	= '';
		}

		if (!empty($topic_data['post_index']))
		{
			if ($topic_data['post_index'] > 0 && $topic_data['topic_first_post_id'] == $row['post_id'])
			{

				if (!empty($iremove))
				{
					$this->functions_topicindex->remove_from_ilist($forum_id, $iremove);
					$zurl	= append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$topic_id}");
					redirect($zurl, false, true);
				}

				if (!empty($iaddlist))
				{
					$this->functions_topicindex->add_to_ilist($forum_id, $iaddlist);
					$zurl	= append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$topic_id}");
					redirect($zurl, false, true);
				}

				if ($topic_data['post_index'] == $topic_id)
				{
					$filtrini	= range('a', 'z');
					$indexlist	= $this->functions_topicindex->get_topic_index($forum_id, $topic_id, $topic_data['default_inindex'], $topic_data['tag_filter']);
					$fixa		= array();
					$fixa 		= $this->functions_topicindex->create_key_list($indexlist);
					$fixedlist	= $this->functions_topicindex->filter_topiclist($indexlist, $ilimiter);
					$bulo		= (!$ilimiter) ? $fixa : array($ilimiter);

					// Create data for template
					foreach ($filtrini as $filtrino)
					{
						// Build menu
						$this->template->assign_block_vars('block_filtrino', array(
							'U_FILTER'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$topic_id}&amp;ilimit={$filtrino}"),
							'FILTRINO'	=> $filtrino,
							'S_ISWITH'	=> (in_array($filtrino, $fixa)) ? true : false
						));
					}

					// Build template data
					foreach ($fixa as $realfilter)
					{
						$this->template->assign_block_vars('block_list', array(
							'FILTRINO'	=> ($realfilter == '_') ? $this->user->lang['SYMB'] : strtoupper($realfilter),
							'S_ISWITH2'	=> (in_array($realfilter, $bulo)) ? true : false
						));

						$nums = 0;
						foreach ($fixedlist as $indexdata)
						{
							if ($realfilter == $indexdata['key'] && $indexdata['id'] != $topic_data['post_index'])
							{
								$this->template->assign_block_vars('block_list.block_topic_index', array(
									'ITOPIC_URL'		=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$indexdata['id']}"),
									'ITOPIC_TITLE'		=> $indexdata['title'],
									'ITOPIC_POSTER'		=> get_username_string('full', $indexdata['posterid'], $indexdata['poster'], $indexdata['postercol']),
									'ITOPIC_TOTREP'		=> $indexdata['posts'],
									'U_REMOVE_FROM'		=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$topic_id}&amp;iremove=" . $indexdata['id']),
									'ITOPIC_CLASS'		=> ($nums % 2) ? 'row bg1' : 'row bg3'
								));
								$nums++;
							}
						}
					}

					$this->template->assign_block_vars('block_nofiltrino', array(
						'U_TUTTI'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$topic_id}"),
						'U_09'		=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$topic_id}&amp;ilimit=09"),
						'U_SYMB'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$topic_id}&amp;ilimit=_"),
						'S_09'		=> (in_array('09', $fixa)) ? true : false,
						'S_SYMB'	=> (in_array('_', $fixa)) ? true : false
					));

					$this->functions_topicindex->assign_authors();

					$official_topic_index = $this->template
						->assign_vars(array(
							'S_ISTYLE'					=> (!empty($this->config['oindex_overflow'])) ? 'content_index_flow' : 'content_index',
							'TOPICINDEX_FOOTER_VIEW'	=> true,
						))
						->set_filenames(array(
							'topic_index'	=> '@dmzx_topicindex/official_topic_index.html',
						))
						->assign_display('topic_index');

					$activeindex = true;
				}
				else
				{
					$activeindex = false;
				}
			}
			else
			{
				$activeindex = false;
			}
		}
		else
		{
			$activeindex = false;
		}

		$post_row = array_merge($post_row, array(
			'S_ACTIVEINDEX'	=> $activeindex,
			'U_ININDEXLIST'	=> $iindex_url,
			'IINDEX_ICON'	=> $iindex_img,
			'IINEDX_LANG'	=> $iindex_lan,
			'ILIST_IMG'		=> $iindex_bb_img,
			'MESSAGE'		=> $official_topic_index,
		));
		$event['post_row'] = $post_row;
	}
}
