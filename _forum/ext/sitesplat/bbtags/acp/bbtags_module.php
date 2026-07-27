<?php
/**
 * BBTags ACP module.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\acp;

class bbtags_module
{
	const FORM_KEY = 'sitesplat/bbtags';

	protected $config;
	protected $config_text;
	protected $db;
	protected $user;
	protected $request;
	protected $template;
	protected $manager;
	protected $table_bbtags;
	protected $table_bbtags_topic;

	public $u_action;
	public $tpl_name;
	public $page_title;

	/**
	 * Display and process the BBTags administration page.
	 *
	 * @param int    $id   Module identifier
	 * @param string $mode Module mode
	 */
	public function main($id, $mode)
	{
		global $config, $db, $user, $request, $template, $phpbb_container, $phpbb_path_helper, $phpbb_extension_manager;

		$this->config = $config;
		$this->config_text = $phpbb_container->get('config_text');
		$this->db = $db;
		$this->user = $user;
		$this->request = $request;
		$this->template = $template;
		$this->manager = $phpbb_container->get('sitesplat.bbtags.manager');
		$this->table_bbtags = $phpbb_container->getParameter('sitesplat.bbtags.tables.bbtags');
		$this->table_bbtags_topic = $phpbb_container->getParameter('sitesplat.bbtags.tables.bbtags_topic');

		$this->tpl_name = 'acp_bbtags';
		$this->page_title = 'ACP_BBTAGS';
		$this->user->add_lang_ext('sitesplat/bbtags', 'info_acp_bbtags');

		$submit = $this->request->is_set_post('submit');
		$action = $this->request->variable('action', '');
		$delete_id = $this->request->variable('delete_id', 0);
		$start = max(0, $this->request->variable('start', 0));
		$per_page = 10;
		$sk = ($this->request->variable('sk', 'hits') === 'hits') ? 'hits' : 'tag';
		$sd = ($this->request->variable('sd', 'd') === 'd') ? 'd' : 'a';

		add_form_key(self::FORM_KEY);
		if ($delete_id > 0)
		{
			$action = 'delete';
		}

		if (in_array($action, array('delete', 'gaUpdate', 'save_config')) && !check_form_key(self::FORM_KEY))
		{
			trigger_error($this->user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
		}

		switch ($action)
		{
			case 'details':
				$phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/bbtags');
				$this->tpl_name = 'acp_ext_details';
			break;

			case 'delete':
				if (!$this->manager->delete_tag($delete_id))
				{
					trigger_error($this->user->lang('BBTAGS_TAG_NOT_FOUND') . adm_back_link($this->u_action), E_USER_WARNING);
				}
				trigger_error($this->user->lang('BBTAGS_TAG_DELETED') . adm_back_link($this->u_action));
			break;

			case 'gaUpdate':
				$this->db->sql_return_on_error(true);
				$updated = $this->manager->rename_tag(
					$this->request->variable('id', 0),
					utf8_normalize_nfc($this->request->variable('tag', '', true))
				);
				$this->db->sql_return_on_error(false);
				if (!$updated)
				{
					trigger_error($this->user->lang('BBTAGS_TAG_UPDATE_FAILED') . adm_back_link($this->u_action), E_USER_WARNING);
				}
				trigger_error($this->user->lang('BBTAGS_TAG_UPDATED') . adm_back_link($this->u_action));
			break;

			case 'save_config':
				if ($submit)
				{
					$this->save_config();
					trigger_error($this->user->lang('BBTAGS_SETTINGS_SAVED') . adm_back_link($this->u_action));
				}
			break;

			default:
				$this->display_tags($start, $per_page, $sk, $sd);
		}

		$predefined_tags = json_decode($this->config_text->get('bbtags_pre_tags'), true);
		$this->template->assign_vars(array(
			'U_ACTION' => $this->u_action,
			'EXT_PATH' => $phpbb_path_helper->update_web_root_path($phpbb_extension_manager->get_extension_path('sitesplat/bbtags', true)),
			'BBTAGS_MIN_LENGTH' => $this->config['bbtags_min_length'],
			'BBTAGS_MAX_TAGS' => $this->config['bbtags_max_tags'],
			'BBTAGS_CLOUD_LIMIT' => $this->config['bbtags_cloud_limit'],
			'BBTAGS_ON_INDEX' => $this->config['bbtags_on_index'],
			'PRE_BBTAGS' => htmlspecialchars(implode("\n", is_array($predefined_tags) ? $predefined_tags : array()), ENT_QUOTES, 'UTF-8'),
		));
	}

	/**
	 * Validate and save the current ACP configuration.
	 */
	protected function save_config()
	{
		$this->config->set('bbtags_min_length', max(3, min(30, $this->request->variable('bbtags_min_length', 3))));
		$this->config->set('bbtags_max_tags', max(1, min(10, $this->request->variable('bbtags_max_tags', 5))));
		$this->config->set('bbtags_cloud_limit', max(1, $this->request->variable('bbtags_cloud_limit', 10)));
		$this->config->set('bbtags_on_index', max(0, min(2, $this->request->variable('bbtags_on_index', 0))));

		$tags = array();
		foreach (explode("\n", $this->request->variable('bbtags_pre_tags', '', true)) as $tag)
		{
			$tag = $this->manager->clean_tag($tag);
			if ($tag !== '')
			{
				$tags[] = $tag;
			}
		}

		$tags = array_values(array_unique($tags));
		sort($tags, SORT_NATURAL | SORT_FLAG_CASE);
		$this->config_text->set('bbtags_pre_tags', json_encode($tags, JSON_UNESCAPED_UNICODE));
	}

	/**
	 * Build the portable tag list shown in the ACP.
	 *
	 * @param int    $start    Pagination offset
	 * @param int    $per_page Rows per page
	 * @param string $sk       Sort key
	 * @param string $sd       Sort direction
	 */
	protected function display_tags($start, $per_page, $sk, $sd)
	{
		$sql = 'SELECT COUNT(id) AS total FROM ' . $this->table_bbtags;
		$result = $this->db->sql_query($sql);
		$total_tags = (int) $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);

		$sql = 'SELECT t.tag, t.id, t.count
			FROM ' . $this->table_bbtags . ' t
			ORDER BY t.' . (($sk === 'hits') ? 'count' : 'tag') . ' ' . (($sd === 'd') ? 'DESC' : 'ASC');
		$result = $this->db->sql_query_limit($sql, $per_page, $start);
		$rows = $tag_ids = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
			$tag_ids[] = (int) $row['id'];
		}
		$this->db->sql_freeresult($result);

		$tag_forums = $this->get_tag_forums($tag_ids);
		$position = $start;
		$javascript = array("\ncbl = new Array();");
		foreach ($rows as $row)
		{
			$tag_id = (int) $row['id'];
			$javascript[] = 'cbl[cbl.length] = new cbItem(' . $tag_id . ', ' . json_encode($row['tag'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . ');';
			$this->template->assign_block_vars('records', array(
				'NUM' => ++$position,
				'ID' => $tag_id,
				'TAG' => htmlspecialchars($row['tag'], ENT_QUOTES, 'UTF-8'),
				'COUNT' => (int) $row['count'],
				'FORUMS' => isset($tag_forums[$tag_id]) ? implode(', ', $tag_forums[$tag_id]) : '',
			));
		}
		$javascript[] = "\ncb.data = cbl;\n";

		$this->template->assign_vars(array(
			'JS' => implode("\n", $javascript),
			'U_SORT' => $sd,
			'U_NAME' => $sk,
			'NEXTURL' => ($start + $per_page < $total_tags) ? $this->u_action . '&start=' . ($start + $per_page) . '&sd=' . $sd . '&sk=' . $sk : '',
			'PREVURL' => ($start >= $per_page) ? $this->u_action . '&start=' . ($start - $per_page) . '&sd=' . $sd . '&sk=' . $sk : '',
		));
	}

	/**
	 * Fetch forum names for the displayed tags without database-specific SQL.
	 *
	 * @param array $tag_ids Tag identifiers
	 *
	 * @return array Forum names indexed by tag identifier
	 */
	protected function get_tag_forums(array $tag_ids)
	{
		$tag_forums = array();
		if (empty($tag_ids))
		{
			return $tag_forums;
		}

		$sql = 'SELECT DISTINCT tt.tag_id, f.forum_name
			FROM ' . $this->table_bbtags_topic . ' tt
			JOIN ' . TOPICS_TABLE . ' t ON t.topic_id = tt.topic_id
			JOIN ' . FORUMS_TABLE . ' f ON f.forum_id = t.forum_id
			WHERE ' . $this->db->sql_in_set('tt.tag_id', $tag_ids) . '
			ORDER BY f.forum_name ASC';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$tag_forums[(int) $row['tag_id']][] = $row['forum_name'];
		}
		$this->db->sql_freeresult($result);

		return $tag_forums;
	}
}
