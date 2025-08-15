<?php

/**
*
* @package phpBB Extension - Basic Stats
* @copyright (c) 2015 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace oxpus\basicstats\event;

/**
* @ignore
*/
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'load_language_on_setup',
			'core.page_header'						=> 'add_link_to_stats',
		);
	}

	/* @var string phpEx */
	protected $php_ext;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;
	
	/* @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param string									$php_ext
	* @param \phpbb\controller\helper				$helper
	* @param \phpbb\template\template				$template
	* @param \phpbb\user							$user
	*/
	public function __construct($php_ext, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->php_ext 		= $php_ext;
		$this->helper 		= $helper;
		$this->template 	= $template;
		$this->user 		= $user;
	}

	public function load_language_on_setup($event)
	{	
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'oxpus/basicstats',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;

	}

	public function add_link_to_stats($event)
	{
		if ($this->user->data['user_type'] == USER_FOUNDER)
		{
			$ext_main_link = $this->helper->route('basicstats_controller');

			$this->template->assign_vars(array(
				'U_BASIC_STATS' => $ext_main_link,
			));
		}
	}
}
