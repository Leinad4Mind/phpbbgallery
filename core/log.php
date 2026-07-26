<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core;

class log
{
	/** @var \phpbb\db\driver\driver_interface  */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var \phpbb\user  */
	protected \phpbb\user $user;

	/** @var \phpbb\language\language  */
	protected \phpbb\language\language $language;

	/** @var \phpbb\user_loader  */
	protected \phpbb\user_loader $user_loader;

	/** @var \phpbb\template\template  */
	protected \phpbb\template\template $template;

	/** @var \phpbb\controller\helper  */
	protected \phpbb\controller\helper $helper;

	/** @var \phpbb\pagination  */
	protected \phpbb\pagination $pagination;

	/** @var \phpbbgallery\core\auth\auth  */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/** @var \phpbbgallery\core\config  */
	protected \phpbbgallery\core\config $gallery_config;

	/** @var string */
	protected string $log_table;

	/** @var string */
	protected string $images_table;

	/**
	 * log constructor.
	 *
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbb\user                       $user
	 * @param \phpbb\user_loader                $user_loader
	 * @param \phpbb\template\template          $template
	 * @param \phpbb\controller\helper          $helper
	 * @param \phpbb\pagination                 $pagination
	 * @param auth\auth                         $gallery_auth
	 * @param config                            $gallery_config
	 * @param                                   $log_table
	 * @param                                   $images_table
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\language\language $language,
		\phpbb\user_loader $user_loader, \phpbb\template\template $template, \phpbb\controller\helper $helper, \phpbb\pagination $pagination,
		\phpbbgallery\core\auth\auth $gallery_auth, \phpbbgallery\core\config $gallery_config,
		string $log_table, string $images_table)
	{
		$this->db = $db;
		$this->user = $user;
		$this->language = $language;
		$this->user_loader = $user_loader;
		$this->template = $template;
		$this->helper = $helper;
		$this->pagination = $pagination;
		$this->gallery_auth = $gallery_auth;
		$this->gallery_config = $gallery_config;
		$this->log_table = $log_table;
		$this->images_table = $images_table;
	}

	/**
	 * Add item to log
	 *
	 * @param   string			$log_type    type of action (user/mod/admin/system) max 16 chars
	 * @param   string			$log_action  action we are logging (add/remove/approve/unapprove/delete) max 32 chars
	 * @param 	int				$album
	 * @param   int				$image       Image we are logging for (can be 0)
	 * @param	array|string 	$description Description string
	 */
	public function add_log(string $log_type, string $log_action, int $album = 0, int $image = 0, array|string $description = []): void
	{
		$user = (int) $this->user->data['user_id'];
		$time = (int) time();

		$sql_array = [
			'log_time'		=> (int) $time,
			'log_type'		=> $log_type,
			'log_action'	=> $log_action,
			'log_user'		=> (int) $user,
			'log_ip'		=> $this->user->ip,
			'album'			=> (int) $album,
			'image'			=> (int) $image,
			'description'	=> json_encode($description, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
		];
		$sql = 'INSERT INTO ' . $this->log_table . ' ' . $this->db->sql_build_array('INSERT', $sql_array);
		$this->db->sql_query($sql);
	}

	/**
	* Delete logs
	* @param	array	$mark	Logs selected for deletion
	**/
	public function delete_logs(array $mark): void
	{
		$sql = 'DELETE FROM ' . $this->log_table . ' WHERE ' . $this->db->sql_in_set('log_id', $mark);
		$this->db->sql_query($sql);
		$this->add_log('admin', 'log', 0, 0, ['LOG_CLEAR_GALLERY']);
	}

	/**
	 * Build log list
	 *
	 * @param   	string		$type  Type of queue to build user/mod/admin/system
	 * @param		int			$limit How many items to show
	 * @param		int			$page
	 * @param		int			$album
	 * @param		int			$image
	 * @param		array		$additional
	 * @internal	param int	$start start count used to build paging
	 */
	public function build_list(string $type, int $limit = 0, int $page = 1, int $album = 0, int $image = 0, array $additional = []): void
	{
		if ($limit == 0)
		{
			$limit = max(1, (int) $this->gallery_config->get('items_per_page'));
			// If its called from ACP album is -1, if from MCP then is not
			if ($album == -1)
			{
				$page = (int) ($page / $limit) + 1;
			}
		}
		$page = max(1, $page);
		$this->language->add_lang(['info_acp_gallery_logs'], 'phpbbgallery/core');

		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$sql_array = [
			'FROM'	=> [
				$this->log_table	=> 'l'
			],
			'LEFT_JOIN' => [
				[
					'FROM'	=> [$this->images_table => 'i'],
					'ON'	=> 'l.image = i.image_id'
				]
			]
		];
		$sql_where = [];
		if ($type != 'all')
		{
			$sql_where[] = "l.log_type = '" . $this->db->sql_escape($type) . "'";
		}
		// If album is -1 we are calling it from ACP so ... priority!
		// If album is 0 we are calling it from moderator log, so we need album we can access
		$mod_array = (array) $this->gallery_auth->acl_album_ids('m_status');
		// Patch for missing album
		$mod_array[] = 0;
		if ($album === 0)
		{
			// If no albums we can approve - quit building queue
			if (empty($mod_array))
			{
				return;
			}
			$sql_where[] = $this->db->sql_in_set('l.album', $mod_array);
			$sql_where[] = $this->db->sql_in_set('i.image_album_id', $mod_array);
		}
		if ($album > 0)
		{
			if (!$this->gallery_auth->acl_check('i_view', $album))
			{
				return;
			}
			$sql_where[] = 'l.album = ' . (int) $album;
		}
		if ($image > 0)
		{
			$sql_where[] = 'l.image = ' . (int) $image;
			$sql_where[] = $this->db->sql_in_set('i.image_album_id', $mod_array);
		}
		if (isset($additional['sort_days']))
		{
			$sql_where[] = 'l.log_time > ' . (time() - ($additional['sort_days'] * 86400));
		}
		// And additional check for "active" logs (DB admin can review logs in DB)
		$sql_where[] = 'l.deleted = 0';
		$sql_array['WHERE'] = implode(' and ', $sql_where);
		$sort_direction = (($additional['sort_dir'] ?? 'd') === 'a') ? 'ASC' : 'DESC';
		if (isset($additional['sort_key']))
		{
			switch ($additional['sort_key'])
			{
				case 'u':
					$sql_array['ORDER_BY'] = 'l.log_user ' . $sort_direction;
					$sql_array['GROUP_BY'] = 'l.log_user, l.log_id, i.image_id, i.image_album_id';
				break;
				case 'i':
					$sql_array['ORDER_BY'] = 'l.log_ip ' . $sort_direction;
					$sql_array['GROUP_BY'] = 'l.log_ip, l.log_id, i.image_id, i.image_album_id';
				break;
				case 'o':
					$sql_array['ORDER_BY'] = 'l.description ' . $sort_direction;
					$sql_array['GROUP_BY'] = 'l.description, l.log_id, i.image_id, i.image_album_id';
				break;
			}
		}
		else
		{
			$sql_array['ORDER_BY'] = 'l.log_time ' . $sort_direction;
			$sql_array['GROUP_BY'] = 'l.log_time, l.log_id, i.image_id, i.image_album_id';
		}
		// So we need count - so define SELECT
		$count_sql_array = $sql_array;

		// Remove SELECT for correct count
		$count_sql_array['SELECT'] = 'COUNT(DISTINCT l.log_id) as count';
		unset($count_sql_array['GROUP_BY']);
		unset($count_sql_array['ORDER_BY']);
		$filtering_on_image_album = false;
		foreach ($sql_where as $where_clause)
		{
			if (strpos($where_clause, 'i.image_album_id') !== false)
			{
				$filtering_on_image_album = true;
				break;
			}
		}
		if (!$filtering_on_image_album)
		{
			unset($count_sql_array['LEFT_JOIN']);
		}

		$sql = $this->db->sql_build_query('SELECT', $count_sql_array);
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$count = $row ? $row['count'] : 0;

		$sql_array['SELECT'] = '*';
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query_limit($sql, $limit, ($page - 1) * $limit);

		$logoutput = $users_array = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$logoutput[] = [
				'id'	=> $row['log_id'],
				'type'	=> $row['log_type'],
				'action'	=> $row['log_action'],
				'time'	=> $row['log_time'],
				'user'	=> $row['log_user'],
				'ip'	=> $row['log_ip'],
				'album'	=> $row['album'],
				'image'	=> $row['image'],
				'description'	=> $this->decode_log_description($row['description'])
			];
			$users_array[$row['log_user']] = [''];
		}
		$this->db->sql_freeresult($result);

		$this->user_loader->load_users(array_keys($users_array));

		// Let's build template vars
		if (!empty($logoutput))
		{
			foreach ($logoutput as $var)
			{
				$this->template->assign_block_vars('log', [
					'U_LOG_ID'		=> $var['id'],
					'U_LOG_USER'	=> $this->user_loader->get_username($var['user'], 'full'),
					'U_TYPE'		=> $var['type'],
					'U_LOG_IP'		=> $var['ip'],
					'U_ALBUM_LINK'	=> $var['album'] != 0 ? $this->helper->route('phpbbgallery_core_album', ['album_id'	=> $var['album']]) : false,
					'U_IMAGE_LINK'	=> $var['image'] != 0 ? $this->helper->route('phpbbgallery_core_image', ['image_id'	=> $var['image']]) : false,
					'U_LOG_ACTION' => isset($var['description']) && is_array($var['description']) ? $this->language->lang($var['description'][0], $var['description'][1] ?? false, $var['description'][2] ?? false, $var['description'][3] ?? false) : '',
					'U_TIME'		=> $this->user->format_date($var['time']),
				]);
			}
		}
		$this->template->assign_vars([
			'S_HAS_LOGS' => $count > 0 ? true : false,
			'TOTAL_PAGES'	=> $this->language->lang('PAGE_TITLE_NUMBER', $page),
		]);
		// Here we do some routes magic
		if ($album == 0)
		{
			$this->pagination->generate_template_pagination([
				'routes' => [
					'phpbbgallery_core_moderate_action_log',
					'phpbbgallery_core_moderate_action_log_page',
				],
				'params' => [
				],
			], 'pagination', 'page', $count, $limit, ($page-1) * $limit);
		}
		else if ($album == -1)
		{
			$url_array = [
				'i' => '-phpbbgallery-core-acp-gallery_logs_module',
				'mode' => 'main',
				'lf' => $type
			];
			if (isset($additional['sort_days']))
			{
				$url_array['st'] = $additional['sort_days'];
			}
			if (isset($additional['sort_key']))
			{
				$url_array['sk'] = $additional['sort_key'];
			}
			if (isset($additional['sort_dir']))
			{
				$url_array['sd'] = $additional['sort_dir'];
			}
			$url = http_build_query($url_array,'','&');

			$this->pagination->generate_template_pagination(append_sid('index.php?' . $url), 'pagination', 'page', $count, $limit, ($page-1) * $limit);
		}
		else
		{
			$this->pagination->generate_template_pagination([
				'routes' => [
					'phpbbgallery_core_moderate_action_log_album',
					'phpbbgallery_core_moderate_action_log_album_page',
				],
				'params' => [
					'album_id'	=> $album,
				],
			], 'pagination', 'page', $count, $limit, ($page-1) * $limit);
		}
	}

	/**
	 * Decode current JSON logs while retaining compatibility with legacy
	 * descriptions that were escaped before being handed to the DBAL.
	 *
	 * @param string $description Stored log description
	 * @return array|string|null Decoded log description
	 */
	protected function decode_log_description(string $description): array|string|null
	{
		try
		{
			$decoded = json_decode($description, true, 512, JSON_THROW_ON_ERROR);
		}
		catch (\JsonException)
		{
			try
			{
				$decoded = json_decode(stripslashes($description), true, 512, JSON_THROW_ON_ERROR);
			}
			catch (\JsonException)
			{
				return null;
			}
		}

		return is_array($decoded) || is_string($decoded) ? $decoded : null;
	}
}
