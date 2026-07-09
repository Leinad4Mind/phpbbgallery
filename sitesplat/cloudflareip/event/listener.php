<?php
/**
*
* Cloudflare IP
*
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\cloudflareip\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/**
	* Constructor
	*
	* @param \phpbb\request\request		$request	Request object
	* @param \phpbb\config\config		$config		Config object
	* @param \phpbb\template\template	$template	Template object
	* @access public
	*/
	public function __construct(\phpbb\request\request $request, \phpbb\config\config $config, \phpbb\template\template $template)
	{
		$this->request = $request;
		$this->config = $config;
		$this->template = $template;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	public static function getSubscribedEvents()
	{
		return array(
			'core.acp_main_notice'	=> 'add_cf_clear_cache_btn',
			'core.session_ip_after'	=> 'cloudflare_ip_support',
		);
	}

	/**
	 * Add "Clear CloudFlare’s cache" button to ACP main
	 *
	 * @return null
	 * @access public
	 */
	public function add_cf_clear_cache_btn()
	{
		if ($this->config['sitesplat_cf_email'] && $this->config['sitesplat_cf_api_key'] && $this->config['sitesplat_cf_domain'])
		{
			$this->template->assign_var('S_CF_CLEAR_CACHE', true);
		}
	}

	/**
	 * Use different IP when proxying through Cloudflare
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function cloudflare_ip_support($event)
	{
		if ($this->request->server('HTTP_CF_CONNECTING_IP') != '')
		{
			$event['ip'] = htmlspecialchars_decode($this->request->server('HTTP_CF_CONNECTING_IP'));
		}
	}
}
