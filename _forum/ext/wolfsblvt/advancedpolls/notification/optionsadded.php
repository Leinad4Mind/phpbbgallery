<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\notification;

/**
 * Notifies existing voters after options are appended to a live poll.
 */
class optionsadded extends \phpbb\notification\type\base
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var string */
	protected $ballots_table;

	protected $language_key = 'NOTIFICATION_AP_POLL_OPTIONS_ADDED';

	public static $notification_option = array(
		'lang' => 'NOTIFICATION_TYPE_AP_POLL_OPTIONS_ADDED',
		'group' => 'NOTIFICATION_GROUP_POSTING',
	);

	public function set_config(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	public function set_table_prefix($table_prefix)
	{
		$this->ballots_table = $table_prefix . 'advancedpolls_ballots';
	}

	public function get_type()
	{
		return 'wolfsblvt.advancedpolls.notification.type.optionsadded';
	}

	public function is_available()
	{
		return isset($this->config['wolfsblvt.advancedpolls.activate_notifications'])
			&& (bool) $this->config['wolfsblvt.advancedpolls.activate_notifications'];
	}

	public static function get_item_id($data)
	{
		return (int) $data['revision_id'];
	}

	public static function get_item_parent_id($data)
	{
		return (int) $data['topic_id'];
	}

	public function find_users_for_notification($data, $options = array())
	{
		$options = array_merge(array('ignore_users' => array()), $options);
		$users = array();
		$sql = 'SELECT DISTINCT vote_user_id
			FROM ' . POLL_VOTES_TABLE . '
			WHERE topic_id = ' . (int) $data['topic_id'] . '
				AND vote_user_id <> ' . ANONYMOUS;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$users[] = (int) $row['vote_user_id'];
		}
		$this->db->sql_freeresult($result);

		$sql = 'SELECT DISTINCT vote_user_id
			FROM ' . $this->ballots_table . '
			WHERE topic_id = ' . (int) $data['topic_id'] . '
				AND vote_user_id <> ' . ANONYMOUS;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$users[] = (int) $row['vote_user_id'];
		}
		$this->db->sql_freeresult($result);

		$users = array_values(array_diff(array_unique($users), array((int) $data['actor_user_id'])));
		return $this->get_authorised_recipients($users, (int) $data['forum_id'], $options, true);
	}

	public function users_to_query()
	{
		return array();
	}

	public function get_title()
	{
		return $this->language->lang($this->language_key);
	}

	public function get_url()
	{
		return append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext,
			'f=' . (int) $this->get_data('forum_id') . '&amp;t=' . (int) $this->get_data('topic_id'));
	}

	public function get_email_template()
	{
		return false;
	}

	public function get_email_template_variables()
	{
		return array();
	}

	public function get_reference()
	{
		return $this->language->lang('NOTIFICATION_REFERENCE', censor_text($this->get_data('topic_title')));
	}

	public function create_insert_array($data, $pre_create_data = array())
	{
		$this->set_data('topic_id', (int) $data['topic_id']);
		$this->set_data('forum_id', (int) $data['forum_id']);
		$this->set_data('topic_title', $data['topic_title']);
		$this->set_data('poll_title', $data['poll_title']);
		$this->set_data('option_count', (int) $data['option_count']);
		parent::create_insert_array($data, $pre_create_data);
	}
}
