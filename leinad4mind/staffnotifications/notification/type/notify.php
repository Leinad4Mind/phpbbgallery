<?php

namespace leinad4mind\staff_notifier\notification\type;

class notify extends \phpbb\notification\type\base
{
 
	/**
	* Get notification type name
	*
	* @return string
	*/
 
	
	public function get_type()
	{
		return 'leinad4mind.staff_notifier.notification.type.notify';
	}
	/**
	* Is this type available to the current user (defines whether or not it will be shown in the UCP Edit notification options)
	*
	* @return bool True/False whether or not this is available to the user
	*/

	/** @var \phpbb\user_loader */
	protected $user_loader;

	/** @var \phpbb\config\config */
	protected $config;

	public function set_config(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	public function set_user_loader(\phpbb\user_loader $user_loader)
	{
		$this->user_loader = $user_loader;
	}
	
	public function is_available()
	{
		return false;
	}

	/**
	* Get the id of the notification
	*
	* @param array $data The data for the updated rules
	* @return int Id of the notification
	*/
   public static function get_item_id($my_notification_data)
   {
      return (int) $my_notification_data['item_id'];
   }

	/**
	* Get the id of the parent
	*
	* @param array $data The data for the updated rules
	* @return int Id of the parent
	*/
	public static function get_item_parent_id($my_notification_data)
   {
      return (int) $my_notification_data['id'];
   }

	/**
	* Find the users who will receive notifications
	*
	* @param array $data The type specific data for the updated rules
	* @param array $options Options for finding users for notification
	* @return array
	*/
	public function find_users_for_notification($my_notification_data, $options = array())
   {
      $options = array_merge(array(
         'ignore_users'      => array(),
      ), $options);

      $users = array((int) $my_notification_data['user_id']);

      return $this->check_user_notification_options($users, $options);
   }

	/**
	* Users needed to query before this notification can be displayed
	*
	* @return array Array of user_ids
	*/
	public function users_to_query()
	{
		return array();
	}

	/**
	* Get the HTML formatted title of this notification
	*
	* @return string
	*/
	public function get_title()
	{
		  return $this->get_data('message_subject');
	}

	/**
	* Get the url to this item
	*
	* @return string URL
	*/
   public function get_avatar()
   {
    //  return $this->user_loader->get_avatar($this->get_data('from'));
     return '<img src="'.generate_board_url().'/ext/leinad4mind/staff_notifier/img/admin.jpg"/>';
 
   }
   
 public function get_url()
   {
      return append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, "f=".$this->get_data('forum_id')."&t=".$this->get_data('topic_id'));
   }
	/**
	* Get email template
	*
	* @return string|bool
	*/
	public function get_email_template()
	{
		return false;
	}
	/**
	* Get email template variables
	*
	* @return array
	*/
	public function get_email_template_variables()
	{
		return array();
	}
	/**
	* Function for preparing the data for insertion in an SQL query
	* (The service handles insertion)
	*
	* @param array $data The data for the updated rules
	* @param array $pre_create_data Data from pre_create_insert_array()
	*
	* @return array Array of data ready to be inserted into the database
	*/
   public function create_insert_array($my_notification_data, $pre_create_data = array())
   {
	  $this->set_data('message_subject', $my_notification_data['message_subject']);
      $this->set_data('user_id', $my_notification_data['user_id']);
      $this->set_data('topic_id', $my_notification_data['topic_id']);
	  $this->set_data('forum_id', $my_notification_data['forum_id']);
      $this->set_data('post_subject', $my_notification_data['post_subject']);

      parent::create_insert_array($my_notification_data, $pre_create_data);
   }
   
    public function get_reference()
   {
      return $this->user->lang(
         'NOTIFICATION_REFERENCE',
         censor_text($this->get_data('post_subject'))
      );
   }
}
       