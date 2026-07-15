<?php

namespace canidev\blockgets\routing;

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
	 *
	 * @access public
	 */
	public function __construct(\canidev\blockgets\libraries\blockgets $blockgets)
	{
		$this->blockgets = $blockgets;
	}

	/**
	 * Loads routes defined in Page's database.
	 *
	 * @param string      $resource Resource (not used, but required by parent interface)
	 * @param string|null $type     The resource type
	 *
	 * @return RouteCollection A RouteCollection instance
	 *
	 * @api
	 */
	public function load($resource, $type = null)
	{
		$collection = new RouteCollection();

		$page_ary = $this->blockgets->get_pages();

		foreach($page_ary['pages'][PAGE_CUSTOM] as $page_id => $row)
		{
			$page_alias = ($row['page_alias']) ? $row['page_alias'] : $row['page_id'];

			$route = new Route(
				'/{prefix}' . $page_alias,
				array(
					'_controller' 	=> 'canidev.blockgets.controller:display',
					'page'			=> $page_alias,
					'prefix'		=> '',
				),
				array(
					'prefix'	=> "(|page/)",
				)
			);
		
			$collection->add('canidev_blockgets_page_' . $row['page_id'], $route);
		}

		return $collection;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @api
	 */
	public function supports($resource, $type = null)
	{
		return $type === 'canidev_blockgets_route';
	}
}
