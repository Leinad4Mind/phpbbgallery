<?php
/**
 *
 * Extension News. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\extnews\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return array(
			'core.acp_main_notice'	=> 'ext_news',
		);
	}

	protected $scraper;
	protected $template;
	protected $language;
	public function __construct(\senky\extnews\scraper $scraper, \phpbb\template\template $template, \phpbb\language\language $language)
	{
		$this->scraper = $scraper;
		$this->template = $template;
		$this->language = $language;
	}

	public function ext_news()
	{
		$this->language->add_lang('acp', 'senky/extnews');

		$exts = $this->scraper->get_most_updated_exts();
		foreach ($exts as $ext)
		{
			$this->template->assign_block_vars('extnews', [
				'URL'			=> $ext['url'],
				'NAME'			=> $ext['name'],
				'DESC'			=> $ext['desc'],
				'IMG'			=> $ext['img'],
				'AUTHOR'		=> $ext['author'],
				'AUTHOR_COLOUR'	=> $ext['author_colour'],
				'AUTHOR_URL'	=> $ext['author_url'],
			]);
		}
	}
}
