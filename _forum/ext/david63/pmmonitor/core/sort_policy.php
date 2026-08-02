<?php
/**
 * @package PM Monitor
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\pmmonitor\core;

class sort_policy
{
	protected static $columns = array(
		'b' => 'p.bcc_address',
		'd' => 'p.message_time',
		'f' => 'author.username_clean',
		'i' => 'p.author_ip',
		'p' => 'recipient_copy.folder_id',
		't' => 'recipient.username_clean',
	);

	public static function key($key)
	{
		return isset(self::$columns[$key]) ? $key : 'd';
	}

	public static function direction($direction)
	{
		return $direction === 'a' ? 'a' : 'd';
	}

	public static function order_by($key, $direction)
	{
		$key = self::key($key);
		$sql_direction = self::direction($direction) === 'a' ? ' ASC' : ' DESC';
		return self::$columns[$key] . $sql_direction . ', p.msg_id DESC, recipient_copy.user_id ASC';
	}
}
