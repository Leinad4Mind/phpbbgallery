<?php
/**
*
* BBtpreview
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbtpreview\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\Container;


/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	protected $db;
	protected $user;
	protected $request;
	protected $auth;
	protected $template;
	protected $phpbb_container;

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\request\request $request, \phpbb\auth\auth $auth, \phpbb\template\template $template,  Container $phpbb_container)
	{
		$this->db = $db;
		$this->user = $user;
		$this->request = $request;
		$this->auth = $auth;
		$this->template = $template;
		$this->container = $phpbb_container;
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
			'core.viewforum_modify_topicrow'		=> 'add_lang',
			'sitesplat.bbtags.btpreview'			=> 'add_lang',
			'core.modify_text_for_display_after'	=> 'modify_path'
		);
	}

	public function add_lang($event)
	{
		$this->user->add_lang_ext('sitesplat/bbtpreview', 'bbtpreview');

		$bbtpreview = true;
		/* Desactiva o BBPreview nos tópicos pagos
		$bbtpreview = false;
		if (isset($event['row']['bbpoints_payed']) && $event['row']['bbpoints_payed'])
		{
			$manager = $this->container->get('ext.manager');
			if ($manager->is_enabled('sitesplat/bbpoints'))
			{
				$this->bbpoints_table = $this->container->getParameter('sitesplat.bbpoints.table');
				$sql = 'SELECT * FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $this->user->data['user_id'] . ' AND topic_id = ' . $event['row']['topic_id'] . ' 
						ORDER BY timestamp DESC';
				$result = $this->db->sql_query_limit($sql, 1);
				$row = $this->db->sql_fetchrow($result);
				
				$bbtpreview = ($row['bbpoints'] == $event['row']['bbpoints_payed'] || 
								$event['row']['topic_poster'] == $this->user->data['user_id'] || 
								$this->auth->acl_gets('m_', $event['row']['forum_id'])
							   );
			} else
			{
				$bbtpreview = true;	
			}		
		} else
		{
			$bbtpreview = true;	
		}
		*/
		
		$template_data = $event['topic_row'];
		$template_data['BBTPREVIEW'] = $bbtpreview;
		$event['topic_row'] = $template_data;
	}

	public function modify_path($event)
	{
		$in_bbtags = $this->request->variable('b', 0);
		$text = $event['text'];
		$text = ($in_bbtags) ? $text: str_replace('./../../', './', $text);
		$event['text'] = $text;
		
	}
}
