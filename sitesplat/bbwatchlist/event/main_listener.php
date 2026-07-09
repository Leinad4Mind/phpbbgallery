<?php
/**
 *
 * BBwatchlist. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbwatchlist\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'load_language_on_setup',
			'core.posting_modify_submit_post_after'	=> 'search_keywords',
		);
	}

	protected $bbwatchlist;
	public function __construct(\sitesplat\bbwatchlist\bbwatchlist\bbwatchlist $bbwatchlist)
	{
		$this->bbwatchlist = $bbwatchlist;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/bbwatchlist',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function search_keywords($event)
	{
		if ($event['mode'] == 'post' || $event['mode'] == 'reply' || $event['mode'] == 'quote')
		{
			$post_id = $topic_id = 0;

			$this->bbwatchlist->search_content($event['data']['message']);

			if ($event['mode'] == 'post')
			{
				$this->bbwatchlist->search_subject($event['post_data']['post_subject']);
				$topic_id = preg_replace('/.*t=([0-9]+)/', '$1', $event['redirect_url']);
			}
			else
			{
				$post_id = preg_replace('/.*#p([0-9]+)/', '$1', $event['redirect_url']);
			}

			$this->bbwatchlist->search($post_id, $topic_id);
		}
	}
}
