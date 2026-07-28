<?php
/**
 * Minimal Symfony event subscriber contract for isolated BBTags tests.
 */

namespace Symfony\Component\EventDispatcher;

interface EventSubscriberInterface
{
	public static function getSubscribedEvents();
}
