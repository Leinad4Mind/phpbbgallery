<?php
/**
 *
 * Extension News. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\extnews;

class scraper
{
	protected $cache;
	protected $root_path;
	protected $php_ext;
	public function __construct(\phpbb\cache\driver\driver_interface $cache, $root_path, $php_ext)
	{
		$this->cache = $cache;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public function get_most_updated_exts()
	{
		$exts = $this->cache->get('_senky_extnews');
		if ($exts)
		{
			return $exts;
		}

		$html = \duzun\hQuery::fromUrl('https://www.phpbb.com/customise/db/extensions-36/3.2?sk=t&sd=d');
		if (!$html)
		{
			return [];
		}

		$extensions = $html->find('.contrib-list .contrib-quickview');
		$extensions = array_slice($extensions->toArray(), 0, 10);

		$exts = [];
		foreach ($extensions as $extension)
		{
			$main_anchor = $extension->find('a')[0];

			$coloured_author = $extension->find('a.username-coloured');
			$author_anchor = $coloured_author ? $coloured_author[0] : $extension->find('span.username')[0]->parent();

			$exts[] = [
				'url'			=> $this->remove_sid($main_anchor->attr('href')),
				'name'			=> $main_anchor->text,
				'desc'			=> $extension->find('.quickview-desc')[0]->text,
				'img'			=> $this->remove_sid($extension->find('.screenshot')[0]->attr('src')),
				'author'		=> $author_anchor->text,
				'author_colour'	=> str_replace('color: #', '', $author_anchor->attr('style')),
				'author_url'	=> $this->remove_sid($author_anchor->attr('href')),
			];
		}
		
		$this->cache->put('_senky_extnews', $exts, 86400);

		return $exts;
	}

	protected function remove_sid($url)
	{
		return preg_replace('/(&amp;|\?)sid=[a-z0-9]+/', '', $url);
	}
}
