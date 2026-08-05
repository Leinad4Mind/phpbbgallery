<?php
/**
*
* @package Statistics
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\statistics\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\config\config;
use phpbb\request\request;
use phpbb\user;
use phpbb\db\driver\driver_interface;
use phpbb\template\template;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $config;
	protected $request;
	protected $user;
	protected $db;
	protected $template;
	protected $cache;
	protected $container;
	protected $online_table;
	protected $config_table;
	protected $se_table;
	protected $php_ext;
	protected $modules;
	protected $ip_cache;

	/**
	* Constructor
	*
	*/
	public function __construct(config $config, request $request, user $user, driver_interface $db, template $template, \phpbb\cache\driver\driver_interface $cache, ContainerInterface $container, $online_table, $config_table, $se_table, $php_ext)
	{
		$this->config		= $config;
		$this->request		= $request;
		$this->user			= $user;
		$this->db			= $db;
		$this->template		= $template;
		$this->cache		= $cache;
		$this->container	= $container;
		$this->online_table = $online_table;
		$this->config_table = $config_table;
		$this->se_table		= $se_table;
		$this->php_ext		= $php_ext;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_footer'	=> 'get_ref',
		);
	}

	function get_ref($event)
	{
		if ($this->user->page['script_path'] != '/adm/')
		{
			$modules = $this->get_modules();

			$ref_url = strtolower($this->user->referer);
			$searchwords = '';

			if (!empty($ref_url) && (strpos($ref_url, $this->config['server_name']) === false))
			{
				if (strpos($ref_url, 'sid=') !== false)
				{
					$ref_url = preg_replace('/(\?)?(&amp;|&)?sid=[a-z0-9]+/', '', $ref_url);
					$ref_url = preg_replace("/$this->php_ext(&amp;|&)+?/", "$this->php_ext?", $ref_url);
				}

				$data['referer'] = @parse_url(htmlspecialchars(strip_tags($ref_url)));

				if (!empty($data['referer']['host']) && strrpos($data['referer']['host'], '.') !== false)
				{
					$se_name = substr($data['referer']['host'], 0, strrpos($data['referer']['host'], '.'));
					$sql = 'SELECT DISTINCT query FROM ' . $this->se_table . ' WHERE ' . $this->db->sql_like_expression($this->db->get_any_char() . $se_name);
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);

					if ($row && !empty($data['referer']['query']) && strpos($data['referer']['query'], $row['query'] . '=') !== false)
					{
						parse_str($data['referer']['query'], $query);
						$searchwords = trim($query[$row['query']]);
						$searchwords = str_replace(array('%3d','%27'), array('',''), $searchwords);
						$searchwords = str_replace(array('=','\''), array('',''), $searchwords);
						$searchwords = urldecode($searchwords);
						$searchwords = str_replace(',', ' ', $searchwords);
						$searchwords = str_replace('+', ' ', $searchwords);
						// The urldecode() above can turn already-escaped sequences (%3c, %26, ...)
						// back into raw markup, so the invariant "everything reaching the database
						// is already escaped" has to be restored here before it's stored.
						$searchwords = htmlspecialchars($searchwords, ENT_COMPAT, 'UTF-8');
					}
				}
			} else
			{
				$ref_url = '';
			}

			if ($this->request->is_set('i'))
			{
				if (is_numeric($this->request->variable('i', '')))
				{
					$data['module'] = $this->request->variable('i', 0);
				} else
				{
					$data['module'] = ltrim(strtoupper($this->request->variable('i', '')), '-');

					if ($this->request->is_set('mode'))
					{
						$data['module'] = (isset($modules[substr($data['module'], 0, 3) . '_' . strtoupper($this->request->variable('mode', ''))]) ?
											substr($data['module'], 0, 3) . '_' . strtoupper($this->request->variable('mode', '')) :
											(isset($modules[$data['module']]) ? $modules[$data['module']] :
											$data['module'] . '_' . strtoupper($this->request->variable('mode', ''))));
					}
				}
			} else if (strpos($this->user->page['page_name'], 'app.php') !== false)
			{
				$path_parts = pathinfo($this->user->page['page_name']);
				$path_parts['dirname'] = strtok(strtolower(str_replace('app.php/', '', $path_parts['dirname'])), '/');
				$data['module'] = (isset($modules[$path_parts['dirname']])) ? $modules[$path_parts['dirname']] : null;
				if ($this->container->get('ext.manager')->is_enabled('forumhulp/portal'))
				{
					$data['module'] = (isset($modules[$path_parts['filename']])) ? $modules[$path_parts['filename']] : null;
				}
			} else if (!$this->user->page['forum'])
			{
				$data['module'] = isset($modules[$this->user->page['page_name']]) ? $modules[$this->user->page['page_name']] : null;
			} else
			{
				$data['module'] = $this->user->page['forum'];
			}

			if (isset($data['module']) && $data['module'] !== '')
			{
				$this->resolve_ip_info($this->user->data['session_ip']);

				$data['host'] = $this->ip_cache[$this->user->data['session_ip']]['reverse'];
				$data['domain'] = strtolower($this->ip_cache[$this->user->data['session_ip']]['countryCode']);

				$data['domain'] = (!file_exists($this->container->getParameter('core.root_path') . 'ext/forumhulp/statistics/adm/style/images/flags/' . $data['domain'] . '.png')) ? 'un' : $data['domain'];

				$screen_res = '1920x1080x24';
				if (!$this->request->is_set($this->config['cookie_name'] . '_statistics_res', \phpbb\request\request_interface::COOKIE))
				{
					$this->template->assign_vars(array('ACOOKIE' => true, 'COOKIENAME' => $this->config['cookie_name']));
				} else
				{
					$candidate = $this->request->variable($this->config['cookie_name'] . '_statistics_res', $screen_res, false, \phpbb\request\request_interface::COOKIE);
					// The cookie is entirely visitor-controlled; only accept the WxHxDepth shape it's
					// meant to hold instead of trusting it as free text.
					if (preg_match('/^\d{1,5}x\d{1,5}(x\d{1,2})?$/', $candidate))
					{
						$screen_res = $candidate;
					}
				}
				$data['screen_res'] = $screen_res;

				$fields = array(
					'time'			=> time(),
					'uname'			=> $this->user->data['username'],
					'ugroup'		=> (int) $this->user->data['group_id'],
					'agent'			=> $this->user->browser,
					'ip_addr'		=> $this->user->data['session_ip'],
					'host'			=> $data['host'],
					'domain'		=> $data['domain'],
					'module'		=> $data['module'],
					'scr_res'		=> $data['screen_res'],
					'referer'		=> $ref_url,
					'page'			=> $this->user->page['page'],
					'se_terms'		=> $searchwords,
				);
				$sql = 'INSERT INTO ' . $this->online_table . ' ' . $this->db->sql_build_array('INSERT', $fields);
				$this->db->sql_query($sql);
			}
		}
	}

	/**
	 * Resolve reverse DNS host and country code for an IP, filling $this->ip_cache.
	 *
	 * Uses the ip-api.com third-party service only when the admin has opted in
	 * (statistics_config.geoip_lookup); otherwise resolves locally via gethostbyaddr(), which
	 * never leaves the server.
	 *
	 * @param string $ip
	 * @return void
	 * @access protected
	 */
	protected function resolve_ip_info($ip)
	{
		if ($this->ip_cache === null)
		{
			$this->ip_cache = $this->cache->get('_ip_cache');
			if ($this->ip_cache === false)
			{
				$this->ip_cache = array();
			}
		}

		if (isset($this->ip_cache[$ip]))
		{
			return;
		}

		if ($ip != '127.0.0.1' && $this->is_geoip_lookup_enabled())
		{
			$context = stream_context_create(array('http' => array('timeout' => 3)));
			$ip_query = @file_get_contents('https://ip-api.com/json/' . rawurlencode($ip) . '?fields=status,countryCode,reverse', false, $context);
			$ip_aray = ($ip_query !== false) ? json_decode($ip_query, true) : null;

			if (is_array($ip_aray) && isset($ip_aray['status']) && $ip_aray['status'] == 'success')
			{
				$this->ip_cache[$ip]['countryCode'] = strtolower($ip_aray['countryCode']);
				$this->ip_cache[$ip]['reverse'] = strtolower($ip_aray['reverse']);
				$this->ip_cache = array_slice($this->ip_cache, -50, 50, true);
				$this->cache->put('_ip_cache', $this->ip_cache);

				return;
			}
		}

		$this->ip_cache[$ip]['reverse'] = ($ip == '127.0.0.1') ? '' : (string) @gethostbyaddr($ip);
		$aray = explode('.', $this->ip_cache[$ip]['reverse']);
		$this->ip_cache[$ip]['countryCode'] = ($ip == '127.0.0.1') ? 'lo' : strtolower(end($aray));
	}

	/**
	 * Whether the admin has opted into sending visitor IPs to ip-api.com. Off by default.
	 *
	 * @return boolean
	 * @access protected
	 */
	protected function is_geoip_lookup_enabled()
	{
		$sql = 'SELECT geoip_lookup FROM ' . $this->config_table;
		$result = $this->db->sql_query($sql);
		$enabled = (bool) $this->db->sql_fetchfield('geoip_lookup');
		$this->db->sql_freeresult($result);

		return $enabled;
	}

	/**
	 * @return array
	 * @access protected
	 */
	protected function get_modules()
	{
		if ($this->modules !== null)
		{
			return $this->modules;
		}

		if (($this->modules = $this->cache->get('_modules_stats')) === false)
		{
			$this->modules = ['index.php' => 'FORUM_INDEX', 'help' => 'VIEWING_FAQ', 'mcp.php' => 'VIEWING_MCP', 'search.php' => 'SEARCHING_FORUMS',
							  'viewonline.php' => 'VIEWING_ONLINE', 'memberlist.php' => 'VIEWING_MEMBERS', 'ucp.php' => 'VIEWING_UCP'];

			if (defined('FORUMS_TABLE'))
			{
				$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE;
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$this->modules[$row['forum_id']] = $row['forum_name'];
				}
				$this->db->sql_freeresult($result);
			}

			if ($this->container->get('ext.manager')->is_enabled('forumhulp/portal'))
			{
				$sql = 'SELECT a.route, c.title FROM ' . $this->container->getParameter('forumhulp.tables.articles') . ' a
						LEFT JOIN ' . $this->container->getParameter('forumhulp.tables.categories') . ' c ON c.cid = a.cid';
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$this->modules[$row['route']] = $row['title'];
				}
				$this->db->sql_freeresult($result);
			}

			$sql = 'SELECT module_id, module_basename, module_langname FROM ' . MODULES_TABLE . " WHERE module_class IN ('ucp', 'mcp')";
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				if (strpos($row['module_basename'], '\\') !== false)
				{
					$this->modules[strtoupper(ltrim(str_replace('\\', '-', $row['module_basename']), '-'))] = $row['module_langname'];
				}
				$this->modules[$row['module_langname']] = $row['module_langname'];
				$this->modules[$row['module_id']] = $row['module_langname'];
			}
			$this->db->sql_freeresult($result);

			$sql = 'SELECT custom_pages FROM ' . $this->config_table;
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchfield('custom_pages');
			$this->db->sql_freeresult($result);
			$row = (!empty($row)) ? @unserialize($row, ['allowed_classes' => false]) : false;

			if (is_array($row) && sizeof($row) > 0)
			{
				foreach ($row as $key => $value)
				{
					$this->modules[$key] = $value;
				}
			}
			$this->cache->put('_modules_stats', $this->modules, 3600);
		}
		return $this->modules;
	}
}
