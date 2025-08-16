<?php
/**
*
* BBtags
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbtags\acp;

class bbtags_module
{
	protected $config;
	protected $config_text;
	protected $db;
	protected $user;
	protected $request;
	protected $template;
	protected $phpbb_container;

	public $u_action;
	
	function main($id, $mode)
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
		$this->user->add_lang_ext('sitesplat/bbtags', 'info_acp_bbtags');

		$submit		= $this->request->is_set_post('submit');
		$action		= $this->request->variable('action', '');
		$start		= $this->request->variable('start', 0);
		$per_page	= 10;
		$sk = ($this->request->variable('sk', 'hits') == 'hits') ? 'hits' : 'tag';
		$sd = ($this->request->variable('sd', 'd') == 'd') ? 'd' : 'a';

		switch ($action){
			case 'details':
				$phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/bbtags');
				$this->tpl_name = 'acp_ext_details';
			break;

			case 'delete':
				$sql = 'DELETE FROM  ' . $this->table_bbtags . ' WHERE id = ' . $this->request->variable('id', '');
				$this->db->sql_query($sql);
				$sql = 'DELETE FROM  ' . $this->table_bbtags_topic . ' WHERE tag_id = ' . $this->request->variable('id', '');
				$this->db->sql_query($sql);
				exit();
			break;
			
			case 'gaUpdate':
				$this->db->sql_return_on_error(true);
				$sql = 'UPDATE ' . $this->table_bbtags . ' SET tag = "' . $this->manager->clean_tag(utf8_normalize_nfc($this->request->variable('tag', '', true))) . '", 
						route = "' . $this->manager->Slug($this->manager->clean_tag(utf8_normalize_nfc($this->request->variable('tag', '', true)))) . '"
						WHERE id = ' . $this->request->variable('id', '');
				$this->db->sql_query($sql);

			case 'save_config':
				if ($this->request->is_set_post('submit'))
				{
					$this->config->set('bbtags_min_length', $this->request->variable('bbtags_min_length', 3));
					$this->config->set('bbtags_max_tags', $this->request->variable('bbtags_max_tags', 5));
					$this->config->set('bbtags_on_index', $this->request->variable('bbtags_on_index', 0));
					
					$list = explode("\n", $this->request->variable('bbtags_pre_tags', '', true));
					if (! empty($list))
					{
						$tags = array();
						for ($i = 0, $size = sizeof($list); $i < $size; $i ++)
						{
							$tags[] = $this->manager->clean_tag($list[$i]);
						}
					}
					asort($tags);
					$this->config_text->set('bbtags_pre_tags', json_encode($tags));
				}

			default:
			
				$sql = 'SELECT COUNT(id) AS total FROM ' . $this->table_bbtags;
				$result = $this->db->sql_query($sql);
				$total_tags = $this->db->sql_fetchfield('total');
				
				$sql = 'SELECT
					t.tag,
					t.id,
					t.count,
					 GROUP_CONCAT(DISTINCT f.forum_name ORDER BY f.forum_name ASC SEPARATOR ", ") as forums
				FROM
					' . $this->table_bbtags . ' t
				LEFT JOIN ' . $this->table_bbtags_topic . ' tt ON t.id = tt.tag_id
				LEFT JOIN ' . TOPICS_TABLE . ' ttt ON tt.topic_id = ttt.topic_id
				LEFT JOIN ' . FORUMS_TABLE . ' f ON ttt.forum_id = f.forum_id
				WHERE
					1 = 1
				GROUP BY
					t.tag
				ORDER BY t.' . (($sk == 'hits') ? 'count': 'tag') . ' ' . (($sd == 'd') ? 'DESC': 'ASC');
				$result = $this->db->sql_query_limit($sql, $per_page, $start);
				$i = $start;
				$js[] = "\ncbl = new Array();";
				while ($row = $this->db->sql_fetchrow($result))
				{
					$js[] = sprintf( "%s = new cbItem(%s, '%s');",
									"cbl[cbl.length]",
									$row['id'],
									$row['tag']);

					$this->template->assign_block_vars('records', array(
						'NUM'		=> ++$i,
						'ID'		=> $row['id'],
						'TAG'		=> $row['tag'],
						'COUNT'		=> $row['count'],
						'FORUMS'	=> $row['forums']
					));
				}
				$js[] = "\ncb.data = cbl;\n";
				$template->assign_vars(array(
					'JS' 			=> implode("\n", $js),
					'U_SORT'		=> $sd,
					'U_NAME'		=> $sk,
					'NEXTURL'	=> ($start > (floor($total_tags / $per_page) * $per_page) - $per_page) ? '' : $this->u_action . '&start=' . ($start + $per_page) . '&sd=' . $sd . '&sk=' . $sk,
					'PREVURL'	=> (($start - $per_page) < 0) ? '' : $this->u_action . '&start=' . ($start - $per_page) . '&sd=' . $sd . '&sk=' . $sk
				));

		}
		
		$this->template->assign_vars(array(
			'U_ACTION'		=> $this->u_action,
			'EXT_PATH'		=> $phpbb_path_helper->update_web_root_path($phpbb_extension_manager->get_extension_path('sitesplat/bbtags', true)),
			
			'BBTAGS_MIN_LENGTH'	=> $this->config['bbtags_min_length'],
			'BBTAGS_MAX_TAGS'	=> $this->config['bbtags_max_tags'],
			'BBTAGS_ON_INDEX'	=> $this->config['bbtags_on_index'],
			'PRE_BBTAGS'		=> implode("\n", json_decode($this->config_text->get('bbtags_pre_tags'), true))
			)
		);
	}
}
