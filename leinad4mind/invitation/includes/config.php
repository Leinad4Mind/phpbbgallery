<?php

/**
 *
 * Invitation. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2021, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation\includes;

use phpbb\db\driver\driver_interface as db_interface;
use phpbb\language\language;

class config implements \ArrayAccess
{
	/** @var language */
	protected $language;

	/** @var db_interface */
	protected $db;

	/** @var string */
	protected $table_invite_config;

	/** @var array */
	protected $config = array();

	/**
	 * config constructor.
	 *
	 * @param \phpbb\language\language          $language
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param string                            $table_invite_config
	 */
	public function __construct(language $language, db_interface $db, $table_invite_config)
	{
		$this->language = $language;
		$this->db = $db;
		$this->table_invite_config = $table_invite_config;

		$this->init();

		// Load language files
		$this->language->add_lang(array('info_ucp_meghivo', 'meghivo'), 'leinad4mind/invitation');
	}

	/**
	 *
	 */
	protected function init()
	{
		$sql = 'SELECT * FROM ' . $this->table_invite_config;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->config[$row['config_name']] = $row['config_value'];
		}
		$this->db->sql_freeresult($result);
	}

	/**
	 * @param string $config_name
	 * @param mixed $config_value
	 */
	public function set($config_name, $config_value)
	{
		// Config entries not already in the database aren't allowed!
		// They should be added through a migration.

		if (!isset($this->config[$config_name]))
		{
			return;
		}

		$sql = 'UPDATE ' . $this->table_invite_config . "
				SET config_value = '" . $this->db->sql_escape($config_value). "'
				WHERE config_name = '" . $this->db->sql_escape($config_name) . "'";
		$this->db->sql_query($sql);

		//if (!$this->db->sql_affectedrows() && !isset($this->meghivo_config[$config_name]))
		//{
		//	$this->db->sql_query('INSERT INTO ' . $this->table_invite_config . ' ' . $this->db->sql_build_array('INSERT', array(
		//		'config_name'  => $config_name,
		//		'config_value' => $config_value)
		//	));
		//}

		$this->config[$config_name] = $config_value;
	}

	public function offsetExists($offset)
	{
		return isset($this->config[$offset]);
	}

	public function offsetGet($offset)
	{
		return $this->config[$offset];
	}

	public function offsetSet($offset, $value)
	{
		$this->config[$offset] = $value;
	}

	public function offsetUnset($offset)
	{
		unset($this->config[$offset]);
	}
}
