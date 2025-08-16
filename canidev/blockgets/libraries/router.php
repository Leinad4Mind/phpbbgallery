<?php

namespace canidev\blockgets\libraries;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;

class router extends UrlGenerator
{
	/**
	* Constructor
	*
	* @param ContainerInterface 	$container		Service container interface
	*
	* @access public
	*/
	public function __construct($container)
	{
		$provider 	= $container->get('controller.provider');
		$manager	= $container->get('ext.manager');

		$provider->find_routing_files($manager->get_finder());
		$route_collection = $provider->find($container->getParameter('core.root_path'))->get_routes();
		
		parent::__construct($route_collection, new RequestContext());
		
		unset($route_collection, $provider, $manager);
	}
	
	public function getRouteCollection()
	{
		return $this->routes;
	}
}
