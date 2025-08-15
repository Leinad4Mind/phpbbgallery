<?php
/**
*
* @package BBrandom
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbrandom\controller;

use Symfony\Component\DependencyInjection\Container;

/**
* Main controller
*/
class controller
{
	protected $phpbb_container;
	protected $user;
	protected $helper;

	public function __construct(Container $phpbb_container, \phpbb\user $user, \phpbb\controller\helper $helper)
	{
		$this->user = $user;
		$this->phpbb_container = $phpbb_container;
		$this->helper = $helper;
	}

	/**
	* Display the page
	*
	* @param string $route The route name for a page
	* @return Redirect
	* @access public
	*/
	public function display($route)
	{
		$route = preg_replace('/\\.[^.\\s]{3,4}$/', '', $route);
		
		$this->user->add_lang_ext('sitesplat/bbrandom', 'info_acp_bbrandom');
		$this->user->add_lang('acp/common');
		$this->phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/bbrandom');
		$this->tpl_name = 'acp_ext_details';
		return $this->helper->render('acp_ext_details.html', 'detail');
	}
}
