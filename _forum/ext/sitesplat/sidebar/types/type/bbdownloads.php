<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\types\type;

/**
 * BB downloads class
 */
class bbdownloads extends \sitesplat\sidebar\types\type\base
{
	/**
	 * Get sidebar block enable
	 *
	 * @return sidebar block enabled
	 * @access public
	 */
	public function get_sidebar_enable()
	{
		$manager = $this->container->get('ext.manager');
		return $manager->is_enabled('sitesplat/bbdownloads');
	}

	/**
	 * Get sidebar type
	 *
	 * @return string sidebar type
	 * @access public
	 */
	public function get_sidebar_type()
	{
		return 'sitesplat.sidebar.type.bbdownloads';
	}

	/**
	 * Get sidebar type name
	 *
	 * @return string sidebar type name
	 * @access public
	 */
	public function get_sidebar_type_name()
	{
		return $this->user->lang('SIDEBAR_TYPE_BBDOWNLOADS');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_sidebar/bbdownloads.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function outputblock()
	{
		$howmany = $this->howmany();
		$sql_where = str_replace('user_id', 'u.user_id', $this->ignore_users());

		$sql_and = !empty($sql_where) ? ' AND user_inactive_reason = 0' : ' WHERE user_inactive_reason = 0';
		// downloads
		if (($downloads = $this->cache->get('_sidebar_bbdownloads')) === false)
		{
			$downloads['pop'] = $downloads['new'] = array();
			$bbdownloads_table = $this->container->getParameter('sitesplat.bbdownloads.tables.bbdownloads');
			$bbdownloads_version_table = $this->container->getParameter('sitesplat.bbdownloads.tables.bbdownloads_version');
			$bbdownloads_log_table = $this->container->getParameter('sitesplat.bbdownloads.tables.bbdownloads_log');

			// grab pop. downloads
			$sql = 'SELECT x.*, d.title, d.route, SUM(total) AS download 
					FROM (
							SELECT v.download_id, COUNT(l.id) AS total 
							FROM ' . $bbdownloads_log_table . ' l
							LEFT JOIN ' . $bbdownloads_version_table . ' v ON v.id = l.version_id
							GROUP BY l.version_id
							) x
					LEFT JOIN ' . $bbdownloads_table . ' d ON d.id = x.download_id
					GROUP BY x.download_id, x.total
					ORDER BY total DESC';
			$result = $this->db->sql_query_limit($sql, $howmany);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$downloads['pop'][] = array(
					'download_id'	=> $row['download_id'],
					'title'			=> $row['title'],
					'route'			=> $row['route'],
					'download'		=> $row['download']
				);
			}

			// grab new downloads
			$sql = 'SELECT x.*, d.title, d.route, x.timestamp
					FROM (
							SELECT v.download_id, MAX(v.timestamp) AS timestamp 
							FROM  ' . $bbdownloads_version_table . ' v 
							GROUP BY v.download_id
							) x
					LEFT JOIN ' . $bbdownloads_table . ' d ON d.id = x.download_id
					GROUP BY x.download_id
					ORDER BY timestamp DESC';
			$result = $this->db->sql_query_limit($sql, $howmany);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$downloads['new'][] = array(
					'download_id'	=> $row['download_id'],
					'title'			=> $row['title'],
					'route'			=> $row['route'],
					'timestamp'		=> $row['timestamp']
				);
			}
			$this->db->sql_freeresult($result);

			// cache this data for 5 minutes, this improves performance
			$this->cache->put('_sidebar_bbdownloads', $downloads, 300);
		}

		$this->helper = $this->container->get('controller.helper');
		$this->bbpoints_config = json_decode($this->config['bbpoints_settings'], true);

		foreach ($downloads['pop'] as $row)
		{
			$this->template->assign_block_vars('pop_downloads',array(
				'ID'				=> $row['download_id'],
				'TITLE'				=> $row['title'],
				'S_SEARCH_ACTION'	=> '/app.php/bbdownloads/index.html?action=search&keywords=' . $row['route'],
				'TOTAL'				=> $row['download']
			));
		}
		
		foreach ($downloads['new'] as $row)
		{
			$this->template->assign_block_vars('new_downloads',array(
				'ID'				=> $row['download_id'],
				'TITLE'				=> $row['title'],
				'S_SEARCH_ACTION'	=> '/app.php/bbdownloads/index.html?action=search&keywords=' . $row['route'],
				'TIMESTAMP'			=> $this->user->format_date($row['timestamp'], 'd-m \'y')
			));
		}
	}
}
