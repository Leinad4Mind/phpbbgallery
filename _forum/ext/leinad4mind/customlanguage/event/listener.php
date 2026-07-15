<?php
/**
*
* @package Custom Language
* @version $Id$
* @copyright (c) 2015-2021 https://leinad4mind.top/forum
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace leinad4mind\customlanguage\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup' => 'language'
		);
	}

	public function language($event)
	{
		$event['lang_set_ext'] = array_merge($event['lang_set_ext'], array(
			array(
				'ext_name' => 'leinad4mind/customlanguage',
				'lang_set' => 'common'
			)
		));
	}
}
