<?php
/**
 *
 * Advanced Polls Notification
 *
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
 */

namespace wolfsblvt\advancedpolls\notification;

/**
* Advanced Polls notifications class
* Notifies voters of a hidden poll once its results become visible
*
* @package notifications
*/
class pollended extends \phpbb\notification\type\base
{
	/** @var \phpbb\config\config */
	protected $config;

	/**
	* Set the config
	*
	* @param \phpbb\config\config $config
	* @return void
	*/
	public function set_config(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	/**
	* {@inheritdoc}
	*/
	public function get_type()
	{
		return 'wolfsblvt.advancedpolls.notification.type.pollended';
	}

	/**
	* {@inheritdoc}
	*/
	protected $language_key = 'NOTIFICATION_AP_POLL_ENDED';

	/**
	* {@inheritdoc}
	*/
	public static $notification_option = array(
		'lang'	=> 'NOTIFICATION_TYPE_AP_POLL_ENDED',
		'group'	=> 'NOTIFICATION_GROUP_POSTING',
	);

	/**
	* {@inheritdoc}
	*/
	public function is_available()
	{
		return (bool) $this->config['wolfsblvt.advancedpolls.activate_notifications'];
	}

	/**
	* {@inheritdoc}
	*/
	public static function get_item_id($data)
	{
		return (int) $data['topic_id'];
	}

	/**
	* {@inheritdoc}
	*/
	public static function get_item_parent_id($data)
	{
		return (int) $data['forum_id'];
	}

	/**
	* {@inheritdoc}
	*/
	public function find_users_for_notification($data, $options = array())
	{
		$options = array_merge(array(
			'ignore_users'	=> array(),
		), $options);

		// Grab all users that have voted in the poll
		$sql = 'SELECT DISTINCT vote_user_id
			FROM ' . POLL_VOTES_TABLE . '
			WHERE topic_id = ' . (int) $data['topic_id'] . '
				AND vote_user_id <> ' . ANONYMOUS;
		$result = $this->db->sql_query($sql);

		$users = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$users[] = (int) $row['vote_user_id'];
		}
		$this->db->sql_freeresult($result);

		if (empty($users))
		{
			return array();
		}
		$users = array_unique($users);

		return $this->check_user_notification_options($users, $options);
	}

	/**
	* {@inheritdoc}
	*/
	public function users_to_query()
	{
		return array();
	}

	/**
	* {@inheritdoc}
	*/
	public function get_title()
	{
		return $this->language->lang($this->language_key);
	}

	/**
	* {@inheritdoc}
	*/
	public function get_url()
	{
		return append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, "t={$this->item_id}");
	}

	/**
	* {@inheritdoc}
	*/
	public function get_email_template()
	{
		return false;
	}

	/**
	* {@inheritdoc}
	*/
	public function get_email_template_variables()
	{
		return array();
	}

	/**
	* {@inheritdoc}
	*/
	public function get_reference()
	{
		return $this->language->lang('NOTIFICATION_REFERENCE', censor_text($this->get_data('topic_title')));
	}

	/**
	* Function for preparing the data for insertion in an SQL query
	* (The service handles insertion)
	*
	* @param array $data The data for the poll
	* @param array $pre_create_data Data from pre_create_insert_array()
	*
	* @return array Array of data ready to be inserted into the database
	*/
	public function create_insert_array($data, $pre_create_data = array())
	{
		$this->set_data('forum_id', (int) $data['forum_id']);
		$this->set_data('topic_id', (int) $data['topic_id']);
		$this->set_data('topic_title', $data['topic_title']);
		$this->set_data('poll_title', $data['poll_title']);
		$this->set_data('poll_end', (int) $data['poll_end']);

		parent::create_insert_array($data, $pre_create_data);
	}
}
