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

	/**
	* Constructor
	*
	* @param \phpbb\request\request		$request			Request object
	* @access public
	*/
	public function __construct(\phpbb\request\request $request)
	{
		$this->request = $request;
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
			'core.session_ip_after'	=> 'cloudflare_ip_support',
		);
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
