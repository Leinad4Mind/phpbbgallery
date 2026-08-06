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

use wolfsblvt\advancedpolls\core\poll_options;

class v1_3_0_data extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\wolfsblvt\advancedpolls\migrations\v1_3_0_schema');
	}

	public function update_data()
	{
		$default_visibility = !empty($this->config['wolfsblvt.advancedpolls.default_poll_votes_hide'])
			? poll_options::VISIBILITY_PRIVATE
			: poll_options::VISIBILITY_DEFAULT;
		$default_vote_mode = !empty($this->config['wolfsblvt.advancedpolls.default_poll_votes_change'])
			? poll_options::VOTE_MODE_CHANGE
			: (!empty($this->config['wolfsblvt.advancedpolls.activate_incremental_votes'])
				? poll_options::VOTE_MODE_INCREMENTAL
				: poll_options::VOTE_MODE_NO_CHANGE);

		return array(
			array('config.add', array('wolfsblvt.advancedpolls.activate_notifications', 1)),
			array('config.add', array('wolfsblvt.advancedpolls.default_poll_visibility', $default_visibility)),
			array('config.add', array('wolfsblvt.advancedpolls.default_poll_vote_mode', $default_vote_mode)),
			array('config.add', array('wolfsblvt.advancedpolls.activate_vote_delete', 0)),
			array('config.add', array('wolfsblvt.advancedpolls.activate_show_abstainers', 1)),
			array('custom', array(array($this, 'migrate_poll_options'))),
			array('custom', array(array($this, 'initialise_notification_cron'))),
		);
	}

	public function revert_data()
	{
		return array(
			array('config.remove', array('wolfsblvt.advancedpolls.activate_notifications')),
			array('config.remove', array('wolfsblvt.advancedpolls.default_poll_visibility')),
			array('config.remove', array('wolfsblvt.advancedpolls.default_poll_vote_mode')),
			array('config.remove', array('wolfsblvt.advancedpolls.activate_vote_delete')),
			array('config.remove', array('wolfsblvt.advancedpolls.activate_show_abstainers')),
		);
	}

	public function migrate_poll_options()
	{
		$sql = 'UPDATE ' . $this->table_prefix . 'topics
			SET wolfsblvt_poll_visibility = ' . poll_options::VISIBILITY_PRIVATE . '
			WHERE wolfsblvt_poll_votes_hide = 1';
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . $this->table_prefix . 'topics
			SET wolfsblvt_poll_vote_mode = ' . poll_options::VOTE_MODE_CHANGE . '
			WHERE poll_vote_change = 1';
		$this->db->sql_query($sql);

		if (!empty($this->config['wolfsblvt.advancedpolls.activate_incremental_votes']))
		{
			$sql = 'UPDATE ' . $this->table_prefix . 'topics
				SET wolfsblvt_poll_vote_mode = ' . poll_options::VOTE_MODE_INCREMENTAL . '
				WHERE poll_start > 0
					AND poll_vote_change = 0';
			$this->db->sql_query($sql);
		}

		$sql = 'UPDATE ' . $this->table_prefix . 'topics
			SET wolfsblvt_poll_type = ' . poll_options::TYPE_SCORING . '
			WHERE wolfsblvt_poll_max_value > 1';
		$this->db->sql_query($sql);
	}

	public function initialise_notification_cron()
	{
		$now = time();
		$sql = 'UPDATE ' . $this->table_prefix . 'topics
			SET wolfsblvt_poll_notified = 1
			WHERE poll_start > 0
				AND poll_length > 0
				AND poll_start + poll_length <= ' . $now;
		$this->db->sql_query($sql);

		$this->config->set('wolfsblvt.advancedpolls.pollend_last_gc', $now, false);
		$this->config->set('wolfsblvt.advancedpolls.pollend_gc', 60, false);
	}
}
