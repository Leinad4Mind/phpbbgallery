<?php
/**
*
* Nightstalker
*
* @copyright (c) 2015 sitesplat.com <https://sitesplat.com>
* @license Proprietary
*
*/

namespace sitesplat\nightstalker\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $config;
	protected $helper;
	protected $user;
	protected $request;
	protected $template;

	/**
	* Constructor
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\user $user, \phpbb\request\request $request, \phpbb\template\template $template)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->user = $user;
		$this->request = $request;
		$this->template = $template;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'	=> array('check_ext', 100),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function check_ext()
	{
		$this->user->add_lang_ext('sitesplat/nightstalker', 'nightstalker');
		$style_name = (in_array($this->user->style['style_name'], array('FLATBOOTS', 'BBOOTS'))) ? strtolower($this->user->style['style_name']) : 'normal';
		$cookie = $this->request->variable($this->config['cookie_name'] . '_nightstalker', 0, false, \phpbb\request\request_interface::COOKIE);
		$this->template->assign_vars(array(
			'S_F_NIGHTSTALKER'	=> ($cookie) ? '<link href="'. generate_board_url() .'/ext/sitesplat/nightstalker/styles/FLATBOOTS/theme/' . $style_name . '.css" rel="stylesheet">': false,
			'S_B_NIGHTSTALKER'	=> ($cookie) ? '<link href="'. generate_board_url() .'/ext/sitesplat/nightstalker/styles/BBOOTS/theme/' . $style_name . '.css" rel="stylesheet">': false,
			'L_NIGHTSTALKER'	=> (!$cookie) ? $this->user->lang['NIGHTSTALKER'] : $this->user->lang['NORMAL_VIEW'],
			'U_NIGHTSTALKER'	=> $this->helper->route('sitesplat_nightstalker_controller', array('nightstalker' =>  (!$cookie) ? 'on' : 'off')),
		));
	}
}
