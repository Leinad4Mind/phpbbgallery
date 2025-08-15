<?php

/**
* @package   BB@mention
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*/
namespace sitesplat\bbmention;

use phpbb\extension\base;

class ext extends base
{
	
	
	public function is_enableable()
	{
		if (!class_exists('sitesplat\BBCore\helper'))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/bbmention', 'info_acp_bbmention');
			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTY'], E_USER_WARNING);	
		}
		
		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore'))
		{
			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
		}

		return class_exists('sitesplat\BBCore\helper');
	}
	
	
	protected $notificationType = 'sitesplat.bbmention.notification';

	public function disable_step($oldState)
	{
		if (!$oldState)
		{
			$this->container->get('notification_manager')->disable_notifications($this->notificationType);
		}

		return parent::disable_step($oldState);
	}
	
	/**
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				if (empty($old_state))
				{
					$this->container->get('user')->add_lang_ext('sitesplat/bbmention', 'info_acp_bbmention');
					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] . 
						(isset($this->container->get('user')->lang['BBMENTION_NOTICE']) ?
							sprintf($this->container->get('user')->lang['BBMENTION_NOTICE'],
									$this->container->get('user')->lang['ACP_CAT_POSTING'],
									$this->container->get('user')->lang['ACP_MESSAGES'],
									$this->container->get('user')->lang['ACP_BBMENTION']) : ''));
				}

				// Enable other stuff
				$this->installBBCodes();
			    $this->container->get('notification_manager')->enable_notifications($this->notificationType);
				return 'notifications';
			
			break;
			
			default:
			
				// Run parent enable step method
				return parent::enable_step($old_state);
				
			break;
		}
	}

	public function purge_step($oldState)
	{
		if (!$oldState)
		{
			$this->container->get('notification_manager')->purge_notifications($this->notificationType);
		}

		return parent::purge_step($oldState);
	}

	protected function getBBCodeId($bbcodeTag)
	{
		$db = $this->container->get('dbal.conn');

		$sql    = 'SELECT bbcode_id FROM ' . BBCODES_TABLE . " WHERE bbcode_tag = '" . $bbcodeTag . "'";
		$result = $db->sql_query($sql);
		$id     = $db->sql_fetchfield('bbcode_id');
		$db->sql_freeresult($result);

		if ($id)
		{
			$db->sql_query('DELETE FROM ' . BBCODES_TABLE . ' WHERE bbcode_id = ' . $id);
		}
		else
		{
			$sql    = 'SELECT MAX(bbcode_id) AS bbcode_id FROM ' . BBCODES_TABLE;
			$result = $db->sql_query($sql);
			$id     = $db->sql_fetchfield('bbcode_id');
			$db->sql_freeresult($result);

			if ($id)
			{
				++$id;
			}
			else
			{
				$id = 13;
			}
		}

		return $id;
	}

	protected function installBBCodes()
	{
		$bbcodes = array(
			array(
				'bbcode_tag'          => 'groupmention=',
				'display_on_posting'  => 0,
				'bbcode_match'        => '[groupmention={NUMBER}]{TEXT}[/groupmention]',
				'bbcode_tpl'          => '{TEXT}',
				'first_pass_match'    => '(\\[groupmention=([0-9]+)\\](.*?)\\[/groupmention\\])i',
				'first_pass_replace'  => '[groupmention=$1:$uid]$2[/groupmention:$uid]',
				'second_pass_match'   => '(\\[groupmention=[0-9]+:$uid\\](.*?)\\[/groupmention:$uid\\])',
				'second_pass_replace' => '$1'
			),
			array(
				'bbcode_tag'          => 'usermention=',
				'display_on_posting'  => 0,
				'bbcode_match'        => '[usermention={NUMBER}]{TEXT}[/usermention]',
				'bbcode_tpl'          => '{TEXT}',
				'first_pass_match'    => '(\\[usermention=([0-9]+)\\](.*?)\\[/usermention\\])i',
				'first_pass_replace'  => '[usermention=$1:$uid]$2[/usermention:$uid]',
				'second_pass_match'   => '(\\[usermention=[0-9]+:$uid\\](.*?)\\[/usermention:$uid\\])',
				'second_pass_replace' => '$1'
			)
		);

		$db = $this->container->get('dbal.conn');
		foreach ($bbcodes as $row)
		{
			$row['bbcode_id'] = $this->getBBCodeId($row['bbcode_tag']);

			$db->sql_multi_insert(BBCODES_TABLE, array($row));
		}
	}
}