<?php
/**
*
* @package Faulty logins
* @copyright (c) 2014 John Peskens (http://ForumHulp.com)
* @license Proprietary
*
*/

namespace forumhulp\faultylogins\event;

use phpbb\user;
use phpbb\log\log;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $user;
	protected $log;

	/**
	* Constructor
	*/
	public function __construct(user $user, log $log)
	{
		$this->user = $user;
		$this->log = $log;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.login_box_failed' => 'log_login'
		);
	}

	public function log_login($event)
	{
		$eventvars = $event['result'];
		if (in_array($eventvars['status'], range(10, 15)))
		{
			$this->log->add('admin', $eventvars['user_row']['user_id'], $this->user->ip, 'LOG_FAULTY_LOGINS', time(),
				array(($eventvars['user_row']['user_id'] == 1) ? $this->user->lang['GUEST'] : $eventvars['user_row']['username'], $event['password'], $this->user->lang[$eventvars['error_msg']]));
		}
	}
}
