<?php
/**
 *
 * Mass Notification. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\massnotification\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\request\request */
	protected $request;

	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents()
	{
		return array(
			'core.index_mark_notification_after'	=> 'redirect_external_url',
		);
	}

	/**
	 * Constructor
	 *
	 * @param \phpbb\request\request	$request	Request object
	 */
	public function __construct(\phpbb\request\request $request)
	{
		$this->request = $request;
	}

	/**
	 * Allows redirecting mass notification to external URL.
	 *
	 * @param	\phpbb\event\data	$event	The event object
	 * @return	void
	 */
	public function redirect_external_url($event)
	{
		if ($event['notification']->get_type() === 'senky.massnotification.notification.type.manual' && !$this->request->is_ajax())
		{
			redirect($event['notification']->get_redirect_url(), false, true);
		}
	}
}
