<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\routing;

use canidev\blockgets\libraries\constants;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class page_loader extends Loader
{
	protected $blockgets;

	/**
	 * Constructor
	 *
	 * @param \canidev\blockgets\libraries\blockgets		$blockgets			Blockgets Object
	 * @access public
	 */
	public function __construct(\canidev\blockgets\libraries\blockgets $blockgets)
	{
		$this->blockgets = $blockgets;
	}

	/**
	 * {@inheritDoc}
	 */
	public function load($resource, $type = null)
	{
		$collection = new RouteCollection();

		$page_ary = $this->blockgets->get_pages();

		foreach($page_ary['pages'][constants::PAGE_CUSTOM] as $page_id => $row)
		{
			$page_alias = ($row['page_alias']) ? $row['page_alias'] : $row['page_id'];

			$route = new Route(
				'/{prefix}' . $page_alias,
				[
					'_controller' 	=> 'canidev.blockgets.controller:display',
					'page'			=> $page_alias,
					'prefix'		=> ($row['page_alias']) ? '' : 'page/',
				],
				[
					'prefix'	=> "(|page/)",
				]
			);
		
			$collection->add('canidev_blockgets_page_' . $row['page_id'], $route);
		}

		return $collection;
	}

	/**
	 * {@inheritdoc}
	 */
	public function supports($resource, $type = null)
	{
		return $type === 'canidev_blockgets_route';
	}
}
