<?php
/**
 * @package cBB Debugger
 * @version 1.0.1 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
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
	 * Handle Kernel exception
	 * @param GetResponseForExceptionEvent 	$event
	 */
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

	/**
	 * {@inheritDoc}
	 */
	static public function getSubscribedEvents()
	{
		return [
			KernelEvents::EXCEPTION		=> ['on_kernel_exception', 10],
		];
	}
}
