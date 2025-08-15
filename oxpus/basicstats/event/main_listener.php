<?php

/**
*
* @package phpBB Extension - Basic Stats
* @copyright (c) 2015 OXPUS - www.oxpus.net
* @copyright (c) 2016 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace oxpus\basicstats\event;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	/* @var string phpEx */
	protected $php_ext;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/** @var \phpbb\files\factory */
	protected $files_factory;

	/**
	* Constructor
	*
	* @param string									$php_ext
	* @param \phpbb\controller\helper				$helper
	* @param \phpbb\template\template				$template
	* @param \phpbb\user							$user
	* @param \phpbb\files\factory					$files_factory
	*/
	public function __construct(
		$php_ext,
		\phpbb\controller\helper $helper,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\files\factory $files_factory = null)
	{
		$this->php_ext 			= $php_ext;
		$this->helper 			= $helper;
		$this->template 		= $template;
		$this->user 			= $user;
		$this->files_factory 	= $files_factory;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'	=> 'add_link_to_stats',
		);
	}

	public function add_link_to_stats($event)
	{
		if ($this->user->data['user_type'] == USER_FOUNDER)
		{
			$ext_main_link = $this->helper->route('basicstats_controller');

			$this->user->add_lang_ext('oxpus/basicstats', 'common');

			$this->template->assign_vars(array(
				'U_BASIC_STATS' => $ext_main_link,
				'PHPBB_IS_32'	=> ($this->files_factory !== null) ? true : false,
			));
		}
	}
}
