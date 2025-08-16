<?php
/**
*
* @package htmlemail
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\htmlemail\event;

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
	protected $phpbb_dispatcher;

	/**
	* Constructor
	*
	* @param \phpbb\event\dispatcher           $phpbb_dispatcher Event dispatcher object
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\event\dispatcher $phpbb_dispatcher)
	{
		$this->config = $config;
		$this->phpbb_dispatcher = $phpbb_dispatcher;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.modify_email_headers'	=> 'set_html_headers',
		);
	}

	public function set_html_headers($event)
	{
		$headers = $event['headers'];
		$headers = $this->array_find('Content-Type', $headers);

		$event['headers'] = $headers;
	}

	// array_search with partial matches
	public function array_find($needle, $haystack)
	{
		if (!is_array($haystack))
		{
			return false;
		}
		foreach ($haystack as $key => $item)
		{
			if (strpos($item, $needle) !== false)
			{
				$haystack[$key] = 'Content-Type: text/html; charset=UTF-8'; // format=flowed';
			}
		}
		return $haystack;
	}
}
