<?php
/**
 *
 * No DEA Emails. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, Picaron, https://github.com/picaronin/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace pikaron\nodeaemails\core;

use Symfony\Component\DependencyInjection\Container;

class functions_nodeaemails
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/**
	* The database table
	* @var string
	*/
	protected $nodeaemails_table;

	/**
	* Constructor
	*
	* @param \phpbb\config\config				$config
	* @param \phpbb\db\driver\driver_interface	$db
	* @param string								$nodeaemails_table
	*
	*/
	public function __construct
	(
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		$nodeaemails_table
	)
	{
		$this->config				= $config;
		$this->db					= $db;
		$this->nodeaemails_table	= $nodeaemails_table;
	}

	/**
	 * Returns whether this cron task should run now, because enough time
	 * has passed since it was last run.
	*/
	function canrun_cron()
	{
		return $this->config['nodeaemails_cron_last_gc'] < time() - $this->config['nodeaemails_cron_gc'];
	}

	/**
	* Update DEAS from https://github.com/wesbos/burner-email-providers.
	*/
	function update_deas()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, "https://raw.githubusercontent.com/wesbos/burner-email-providers/master/emails.txt");
		$result = curl_exec($ch);
		curl_close($ch);
		$pos = strpos($result, '404: Not Found');
		$data = ($pos === false) ? $result : ':::::CRON MESSAGE::::: An error occurred while loading the data from burner-email-providers.';

		if ($data != '')
		{
			$sql = "UPDATE " . $this->nodeaemails_table . "
					SET dea_emails = '" . $this->db->sql_escape($data) . "'
					WHERE source = '" . $this->db->sql_escape('external') . "'";
			$this->db->sql_query($sql);

			if (!$this->db->sql_affectedrows())
			{
				$sql = "INSERT INTO " . $this->nodeaemails_table . " (dea_emails, source)
						VALUES ('" . $this->db->sql_escape($data) . "', '" . $this->db->sql_escape('external') . "')";
				$this->db->sql_query($sql);
			}

			$this->config->set('nodeaemails_cron_last_gc', time(), true);
			$this->config->set('nodeaemails_counter', $this->config['nodeaemails_counter'] + 1);
		}
	}

	/**
	* Read out External DEAs values
	* Get all values
	*/
	function load_external_deas()
	{
		$sql = "SELECT * FROM " . $this->nodeaemails_table . " WHERE source = 'external'";
		$result = $this->db->sql_query($sql);
		$dea_values = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		$dea_array[] = preg_split('/\n|\r\n?/', $dea_values['dea_emails']);
		$MiArray = array_map('strtolower', $dea_array[0]);
		$ArrayCron = array_filter($MiArray);
		return $ArrayCron;
	}

	/**
	* Read local DEAs values
	* Get all values
	*/
	function load_local_deas()
	{
		$sql = "SELECT dea_emails
				FROM " . $this->nodeaemails_table ." WHERE source = 'local'";
		$result = $this->db->sql_query($sql);

		$dea_values = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$dea_values[] = $row['dea_emails'];
		}
		return $dea_values;
	}

	/**
	* Read out ALL DEAs values
	* Get all values
	*/
	function load_total_deas()
	{
		$ArrayExternal = $this->load_external_deas();
		$ArrayLocal = $this->load_local_deas();
		$result = array_merge($ArrayExternal, $ArrayLocal);
		return $result;
	}

	/**
	* Get number of all users
	*/
	function count_total_users()
	{
		$sql = 'SELECT COUNT(user_id) AS total_users
				FROM ' . USERS_TABLE;
		$result = $this->db->sql_query($sql);
		$total_users = (int) $this->db->sql_fetchfield('total_users');
		$this->db->sql_freeresult($result);
		return $total_users;
	}

	/**
	* Get users with DEA email
	*/
	function get_users_dea()
	{
		$sql = "SELECT user_id, user_email FROM " . USERS_TABLE ." WHERE user_email <> '' ORDER BY user_id ASC";
		$result = $this->db->sql_query($sql);
		$MiArray = $this->load_total_deas();
		$dea_users = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			// split on @ and return last value of array in $domain[1]
			$domain = explode('@', $row['user_email']);

			if (array_search($domain[1], $MiArray) !== false)
			{
				$dea_users[] = $row['user_id'];
			}
		}
		$this->db->sql_freeresult($result);
		return $dea_users;
	}

	/**
	 * Remove local domain
	 */
	function delete_deas($datas)
	{
		$sql = "DELETE FROM " . $this->nodeaemails_table . "
				WHERE source = '" . $this->db->sql_escape('local') . "'
				AND dea_emails = '" . $datas . "'";
		$this->db->sql_query($sql);
		return (int) $this->db->sql_affectedrows();
	}

	/**
	 * Save local domain
	 */
	function save_deas($datas)
	{
		$sql = "INSERT INTO " . $this->nodeaemails_table . " (dea_emails, source)
				VALUES ('" . $this->db->sql_escape($datas) . "', '" . $this->db->sql_escape('local') . "')";
		$this->db->sql_query($sql);
		return (int) $this->db->sql_nextid();
	}

}
