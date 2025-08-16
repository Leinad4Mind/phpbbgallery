<?php
/*
* @package cBB QuickMod
* @version v1.1.1 04/07/2019
*
* @copyright (c) 2019 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\core\compatibility\quickmod;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class bbemoji extends \canidev\core\compatibility\base
{
	public $name = 'sitesplat/bbemoji';

	protected $db;

	public function __construct($container)
	{
		$this->container 	= $container;
		$this->db			= $container->get('dbal.conn');
	}
	
	public function is_runnable()
	{
		return $this->container->get('ext.manager')->is_enabled($this->name);
	}
	
	public function core_events()
	{
		return array(
			'quickmod.after_ajax_action'		=> 'after_ajax_action',
		);
	}
	
	public function after_ajax_action($event)
	{
		if($event['message'] == 'TOPIC_RENAMED_SUCCESS')
		{
			// Get some data before changed
			$sql = 'SELECT t.topic_title, f.enable_subject_emoji
				FROM ' . TOPICS_TABLE . ' t
				LEFT JOIN ' . FORUMS_TABLE . ' f ON(f.forum_id = t.forum_id)
			WHERE t.topic_id = ' . $event['topic_ids'][0];
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			
			if($row['enable_subject_emoji'])
			{
				$listener = $this->container->get('sitesplat.bbemoji.listener');
				
				$new_title = $listener->render($listener->parse($row['topic_title']));
				
				$event['message'] = array('TOPIC_RENAMED_SUCCESS', false, $new_title);
			}
		}
	}

	public function frontend_js_events()
	{
		return array(
			'quickmod.onRename'	=> "function(e) {
				if(e.state == 'show')
				{
					e.service.renameTitleObj = e.service.currentRow.find('.topictitle');
					
					var tempDom = e.service.renameTitleObj.clone();
					
					tempDom.children('img.emoji').each(function() {
						$(this).replaceWith(this.alt);
					});
					
					e.service.renameDom.children('#topic_title').val(tempDom.text());
				}
				else
				{
					var title = e.service.renameTitleObj.html();
					
					title = title.replace('&lt;', '<').replace('&gt;', '>');
					
					e.service.renameTitleObj.html(title);
					
					delete(e.service.renameTitleObj);
				}
			}"
		);
	}
}