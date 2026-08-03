<?php
/**
 * BBTags cumulative-filter URL builder.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\tags;

class filter_url
{
	private $helper;
	private $config;

	public function __construct($helper, $config)
	{
		$this->helper = $helper;
		$this->config = $config;
	}

	public function parse_routes(string $routes): array
	{
		return $this->normalize_routes(preg_split('/,+/u', $routes, -1, PREG_SPLIT_NO_EMPTY) ?: []);
	}

	public function normalize_routes(array $routes): array
	{
		$normalized = [];
		$limit = isset($this->config['bbtags_max_tags'])
			? max(1, min(10, (int) $this->config['bbtags_max_tags']))
			: 5;
		foreach ($routes as $route)
		{
			$route = trim((string) $route);
			if ($route === ''
				|| utf8_strlen($route) > manager::MAX_TAG_LENGTH
				|| !preg_match('/^[\p{L}\p{N}][\p{L}\p{N}-]*$/uD', $route))
			{
				continue;
			}
			$normalized[$route] = true;
			if (count($normalized) >= $limit)
			{
				break;
			}
		}

		return array_keys($normalized);
	}

	public function build(array $routes, string $operator = 'and'): string
	{
		$routes = $this->normalize_routes($routes);
		$params = [];
		if (!empty($routes))
		{
			$params['routes'] = implode(',', $routes);
			$params['operator'] = $operator === 'or' ? 'or' : 'and';
		}

		return $this->helper->route('sitesplat_bbtags_search_controller', $params);
	}

	public function toggle(array $active_routes, string $route, string $operator = 'and'): string
	{
		$active_routes = $this->normalize_routes($active_routes);
		if (in_array($route, $active_routes, true))
		{
			$routes = array_values(array_diff($active_routes, [$route]));
		}
		else
		{
			$routes = array_merge($active_routes, [$route]);
		}

		return $this->build($routes, $operator);
	}
}
