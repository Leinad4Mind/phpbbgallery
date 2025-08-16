<?php
/*
*
* @package My Topics
* @copyright (c) Pierre Duhem - LMDI - 2016-2017
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace lmdi\mytop\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{

	protected $user;
	protected $template;
	protected $root_path;
	protected $phpEx;
	protected $config;


	public function __construct(
		\phpbb\user $user,
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		$root_path,
		$phpEx)
	{
		$this->user = $user;
		$this->config = $config;
		$this->template = $template;
		$this->root_path = $root_path;
		$this->phpEx = $phpEx;
	}


	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'	=> 'load_language',
			'core.page_header'	=> 'build_url',
		);
	}


	public function load_language($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'lmdi/mytop',
			'lang_set' => 'mytop',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}


	public function build_url($event)
	{
		if (version_compare ($this->config['version'], '3.2.x', '<'))
		{
			$mytop_320 = 0;
		}
		else
		{
			$mytop_320 = 1;
		}
		$options = $this->config['lmdi_mytop'];
		switch ($options)
		{
			case 0 :
				$down = 0;
				$hidden = 0;
			break;
			case 1 :
				$down = 1;
				$hidden = 0;
			break;
			case 2 :
				$down = 0;
				$hidden = 1;
			break;
			case 3 :
				$down = 1;
				$hidden = 1;
			break;
		}
		$params  = "author=" . $this->user->data['username'] . "&amp;sf=firstpost&amp;sr=topics";
		$url = append_sid($this->root_path . "search." . $this->phpEx, $params);
		$this->template->assign_vars(array(
			'U_MYTOPICS'		=> $url,
			'S_MASK_MYPOSTS'	=> $hidden == 1 ? true : false,
			'S_MYTOP_AFTER'	=> $down == 1 ? true : false,
			'S_MYTOP_BEFORE'	=> $down == 0 ? true : false,
			'S_320'			=> $mytop_320,
		));
	}
}
