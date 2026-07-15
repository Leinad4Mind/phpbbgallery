<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015-2022 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbpoints\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use phpbb\json_response;

/**
* Main controller
*/
class main_controller
{
	protected $db;
	protected $request;
	protected $template;
	protected $user;
	protected $config;
	protected $container;
	protected $root_path;
	protected $php_ext;
	protected $bbpoints_table;
	protected $bbpoints_helper;
	protected $phpbb_dispatcher;
	
	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\config\config $config,
	\phpbb\event\dispatcher $phpbb_dispatcher, ContainerInterface $container, $root_path, $php_ext, $bbpoints_table, $bbpoints_helper)
	{
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->phpbb_dispatcher = $phpbb_dispatcher;
		$this->container = $container;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->bbpoints_table = $bbpoints_table;
		$this->bbpoints_helper = $bbpoints_helper;
		$this->bbpoints_config = json_decode($this->config['bbpoints_settings'], true);
		$this->bbpoints_config['currency'] = $this->bbpoints_helper->currency(0, $this->bbpoints_config['currency']);
	}

	/**
	* Display the page
	*
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	* @access public
	*/
	public function display()
	{
		/**
		* Before main display
		*
		* @event sitesplat.bbpoints.before_main_controller_display
		*/
		$vars = [];
		extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbpoints.before_main_controller_display', compact($vars)));

		$this->user->add_lang_ext('sitesplat/bbpoints', 'bbpoints');
		if (!confirm_box(true))
		{
			$sql = 'SELECT user_id, username FROM ' . USERS_TABLE . ' WHERE user_id = ' . $this->request->variable('u', 0) . ' AND user_type <> ' . USER_IGNORE;
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result)) 
			{
				$this->template->assign_vars([
					'USER_ID'	=> $row['user_id'],
					'USER_NAME'	=> $row['username'],
				]);
			}
			$this->template->assign_vars(['COMMENT_ENABLED' => $this->bbpoints_config['comments_enable']]);
			confirm_box(false, $this->user->lang['TRANSFER_TO'], build_hidden_fields([
				'userid'	=> $this->user->data['user_id'],
				'action'	=> 'transfer',
			]), 'confirm_transfer.html', generate_board_url() . '/app.php/bbpoints/');
		} else
		{
			if ($this->request->variable('transfer_to', 0) && $this->request->variable('amount', 0) > 4 && $this->request->variable('transfer_to', 0) != $this->user->data['user_id'])
			{
				$user_id = $this->user->data['user_id'];
				$sql = 'SELECT ' . $user_id . ' AS user_id,
				COALESCE((
					SELECT SUM(bbpoints)
					FROM bbgta_posts
					WHERE post_visibility = 1 AND poster_id = ' . $user_id . '
				), 0)
				 + COALESCE((
					SELECT SUM(bbpoints)
					FROM bbgta_topics
					WHERE topic_poster = ' . $user_id . '
				), 0)
				 + COALESCE((
					SELECT SUM(bbpoints)
					FROM bbgta_bbpoints
					WHERE to_id = ' . $user_id . '
				), 0)
				 - COALESCE((
					SELECT SUM(bbpoints)
					FROM bbgta_bbpoints
					WHERE from_id = ' . $user_id . '
				), 0) AS total;';
				$result = $this->db->sql_query($sql);
				$user_points  = $this->db->sql_fetchfield('total');
			
				if ($this->request->variable('amount', 0) <= $user_points)
				{
					$sql = 'INSERT INTO ' . $this->bbpoints_table . ' (from_id, to_id, bbpoints, reason, timestamp) 
						VALUES(' . $user_id . ', ' . $this->request->variable('transfer_to', 0) . ', ' . $this->request->variable('amount', 0) . ', "' . $this->request->variable('comment', '') . '", ' . time() . ')';

					$this->db->sql_query($sql);
					$item_id = $this->db->sql_nextid();

					if ($this->bbpoints_config['transfer_notify'])
					{
						$amount = ($this->bbpoints_config['symbol_pos']) ? '<i class="fa ' . $this->bbpoints_config['currency'][0] . '"></i> ' . number_format($this->request->variable('amount', 0), 0) :
								   number_format($this->request->variable('amount', 0), 0) . ' <i class="fa ' . $this->bbpoints_config['currency'][0] . '"></i>';
						$noti_ary = [
							'user_ids'		=> $this->request->variable('transfer_to', 0),
							'parent_id'		=> 0,
							'post_id'		=> $item_id,
							'poster_id'		=> $user_id,
							'amount'		=> $this->request->variable('amount', 0),
							'like_txt'		=> sprintf($this->user->lang('TRANSFER_NOTI'), $amount, $this->user->data['username'], $this->request->variable('comment', '')),
							'currency'		=> $this->bbpoints_config['currency']
						];
						$this->bbpoints_helper->add_noti($noti_ary);
					}
					$this->container->get('cache')->destroy('sql', [$this->bbpoints_table]);
					trigger_error($this->user->lang['TRANSFER_SUCCESS']);	
				} else
				{
					trigger_error($this->user->lang['TRANSFER_NOT_ENOUGH_POINTS']);	
				}
			} else
			{
				trigger_error($this->user->lang[(!$this->request->variable('transfer_to', 0) ? 'NO_USER_SELECTED' : 'NO_AMOUNT_SELECTED')]);	
			}
		}
		/**
		* After main display
		*
		* @event sitesplat.bbpoints.after_main_controller_display
		*/
		$vars = [];
		extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbpoints.after_main_controller_display', compact($vars)));
	}

	public function search_user()
	{
		$term = strtolower($this->request->variable('term', '', true));

		/**
		* Before main search user
		*
		* @event sitesplat.bbpoints.before_main_controller_search_user
		*/
		$vars = [];
		extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbpoints.before_main_controller_search_user', compact($vars)));

		$sql = 'SELECT user_id, username 
				FROM ' . USERS_TABLE . ' 
				WHERE user_id <> ' . 0 . ' AND username_clean like "' . $term . '%"';
		$result = $this->db->sql_query($sql);
		$user_ary = [];
		while($row = $this->db->sql_fetchrow($result)) 
		{
			$user_ary[] = ['value' => $row['user_id'], 'label' => $row['username']];
		}
		/**
		* After main search user
		*
		* @event sitesplat.bbpoints.after_main_controller_search_user
		*/
		$vars = [];
		extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbpoints.after_main_controller_search_user', compact($vars)));
		$json_response = new json_response();
		$json_response->send($user_ary);
	}
}
