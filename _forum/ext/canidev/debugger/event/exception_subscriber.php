<?php
/*
* @package cBB Debugger
* @version v1.0.0 21/06/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\debugger\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class exception_subscriber implements EventSubscriberInterface
{
	/**
	* Construct method
	*/
	public function __construct()
	{
	}

	public function on_kernel_exception(GetResponseForExceptionEvent $event)
	{
		$config = \canidev\debugger\libraries\config::instance();

		if($config->get('debug_enable'))
		{
			$exception = $event->getException();

			if ($exception instanceof \phpbb\exception\exception_interface ||
				$exception instanceof NotFoundHttpException ||
				$exception instanceof HttpExceptionInterface)
			{
				return;
			}

			$event->stopPropagation();
		}
	}

	static public function getSubscribedEvents()
	{
		return array(
			KernelEvents::EXCEPTION		=> array('on_kernel_exception', 10),
		);
	}
}
