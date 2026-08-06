<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\migrations;

class v1_4_0_data extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\wolfsblvt\advancedpolls\migrations\v1_4_0_schema');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('wolfsblvt.advancedpolls.activate_poll_collapsible', 0)),
			array('custom', array(array($this, 'initialise_collapsible_default'))),
		);
	}

	public function revert_data()
	{
		return array(
			array('config.remove', array('wolfsblvt.advancedpolls.activate_poll_collapsible')),
		);
	}

	/**
	 * Enable collapsible polls initially when Collapsible Forum Categories is installed.
	 * A configured extension remains installed even while it is temporarily disabled.
	 *
	 * @return void
	 */
	public function initialise_collapsible_default()
	{
		$sql = "SELECT ext_name
			FROM {$this->table_prefix}ext
			WHERE ext_name = 'phpbb/collapsiblecategories'";
		$result = $this->db->sql_query_limit($sql, 1);
		$installed = (bool) $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$this->config->set('wolfsblvt.advancedpolls.activate_poll_collapsible', $installed ? 1 : 0);
	}
}
