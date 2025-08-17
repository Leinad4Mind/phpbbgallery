<?php
// leinad4mind.org

namespace leinad4mind\staff_notifier\event;
 
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use leinad4mind\staff_notifier\notification\type; 
 
class listener implements EventSubscriberInterface
{

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;
	
	protected $db;
	
	protected $helper;
	
	protected $notification;
	
	public function __construct( \phpbb\config\config $config, \phpbb\template\template $template,  \phpbb\user $user,\phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper, \phpbb\notification\manager $notification)
	{
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
		$this->db = $db;
		$this->helper	= $helper; //for route
		$this->notification = $notification;

	}
 

	static public function getSubscribedEvents()
	{
	return array(
				'core.report_post_auth'	=> 'warn',
				'core.acp_ban_after' => 'ban',
				'core.mcp_ban_after' => 'ban',
				'core.modify_posting_parameters' => 'delete',
		);
	}

 
public function warn($event)
{
	global $request, $user;
	if ($request->is_set_post('submit')){  
		
	 $admin_username = $user->data['username'];
	 $admin_color = $user->data['user_colour'];
	 $user_session_id = $user->data['user_id'];
	 
	 //get warn info
	 $forum_id = $event['report_data']['forum_id'];
	 $topic_id = $event['report_data']['topic_id'];
	 $topic_title = $event['report_data']['topic_title'];
	 //end get warn info
	 
	 //get last id
	 $sql1 = 'SHOW TABLE STATUS LIKE "' . NOTIFICATIONS_TABLE . '"';
	 $result1 = $this->db->sql_query($sql1);
	 $rowz = $this->db->sql_fetchrow($result1);
	 $this->db->sql_freeresult($result1);
     $max_id = $rowz['Auto_increment']; 
	 
	 //get all mods/admins
	 $sql4 = "SELECT user_id from " . USERS_TABLE . " WHERE group_id=4 OR group_id=5";
	 $result4 = $this->db->sql_query($sql4);
	 $new_array = array();
	 while($rowz2 = $this->db->sql_fetchrow($result4)) {
		  $new_array[] = $rowz2['user_id']; 
	 }
	 $this->db->sql_freeresult($result4);
 
    foreach($new_array as $user_id) {
		if($user_id != $user_session_id) {
		  $my_notification_data = array(
		          'id'=>0,
		          'item_id' => $max_id,
                  'message_subject'   => '<strong><span style="color:#'.$admin_color.'">'.$admin_username.'</span></strong> report the following topic/post:',
				  'user_id' => $user_id,
                  'topic_id'   => (int) $topic_id,
                  'forum_id'   => (int) $forum_id,
                  'time'   => time(),
                  'post_subject'   => '<span style="color:red">'.$topic_title.'</span>',
               );
		
		$this->notification->add_notifications('leinad4mind.staff_notifier.notification.type.notify', $my_notification_data);
		}//end userid check
	} //end foreach
	 
	} //end submit
	
} //end mcp warn post core event

public function ban($event)
{
	global $request, $user;
	
	if ($request->is_set_post('bansubmit')){  
	 
	 $banned_users = $event['ban'];
	 $ban_reason = $event['ban_reason'];
	 $minutes = " minutes";
	 $reason = ", reason: ";
	 $time=", time: ";
	 if(empty($event['ban_reason'])){ $reason="";} else { $ban_reason = $event['ban_reason']; }
	 if($event['ban_length'] == 0){ $ban_time = (string) "Permanent";$minutes = ""; } else { $ban_time = $event['ban_length']; }
	 
	 $user_session_id = $user->data['user_id'];
	 $admin_username = $user->data['username'];
	 $admin_color = $user->data['user_colour'];
	 
	 //get last id
	 $sql1 = 'SHOW TABLE STATUS LIKE "' . NOTIFICATIONS_TABLE . '"';
	 $result1 = $this->db->sql_query($sql1);
	 $rowz = $this->db->sql_fetchrow($result1);
	 $this->db->sql_freeresult($result1);
     $max_id = $rowz['Auto_increment']; 
	 
	 //get all mods/admins
	 $sql4 = "SELECT user_id from " . USERS_TABLE . " WHERE group_id=4 OR group_id=5";
	 $result4 = $this->db->sql_query($sql4);
	 $new_array = array();
	 while($rowz2 = $this->db->sql_fetchrow($result4)) {
		  $new_array[] = $rowz2['user_id']; 
	 }
	 $this->db->sql_freeresult($result4);
 
    foreach($new_array as $user_id) {
		if($user_id != $user_session_id) {
		  $my_notification_data = array(
		          'id'=>0,
		          'item_id' => $max_id,
                  'message_subject'   => '<span style="color:#'.$admin_color.'">'.$admin_username.'</span> banned the user:',
				  'user_id' => $user_id,
                  'topic_id'   => (int) 0,
                  'forum_id'   => (int) 0,
                  'time'   => time(),
                  'post_subject'   => '<span style="color:red">'.$banned_users.'</span>'.$reason.'<b>'.$ban_reason.'</b>'.$time.'<b>'.$ban_time.'</b>'.$minutes.'.',
               );
		
		$this->notification->add_notifications('leinad4mind.staff_notifier.notification.type.notify', $my_notification_data);
		}//end userid check
	} //end foreach
	
	} //end submit
	
}//end ban

public function delete($event) {
	global $request, $user;
	
	if($event['mode'] == 'soft_delete') {
	if ($request->is_set_post('confirm')){  
	
	//get topic info
	$post_id = $event['post_id'];
	$sql1 = 'SELECT topic_id, post_subject FROM ' . POSTS_TABLE . ' WHERE post_id=' . $post_id . '';
	$result1 = $this->db->sql_query($sql1);
	$rowz = $this->db->sql_fetchrow($result1);
	$this->db->sql_freeresult($result1);
    $topic_id = $rowz['topic_id']; 
	$forum_id = $event['forum_id'];
	$post_subject = $rowz['post_subject'];
	
	$user_session_id = $user->data['user_id'];
	$admin_username = $user->data['username'];
	$admin_color = $user->data['user_colour'];
	
	 //get last id
	 $sql1 = 'SHOW TABLE STATUS LIKE "' . NOTIFICATIONS_TABLE . '"';
	 $result1 = $this->db->sql_query($sql1);
	 $rowz = $this->db->sql_fetchrow($result1);
	 $this->db->sql_freeresult($result1);
     $max_id = $rowz['Auto_increment']; 
	 
	 //get all mods/admins
	 $sql4 = "SELECT user_id from " . USERS_TABLE . " WHERE group_id=4 OR group_id=5";
	 $result4 = $this->db->sql_query($sql4);
	 $new_array = array();
	 while($rowz2 = $this->db->sql_fetchrow($result4)) {
		  $new_array[] = $rowz2['user_id']; 
	 }
	 $this->db->sql_freeresult($result4);
 
    foreach($new_array as $user_id) {
		if($user_id != $user_session_id) {
		  $my_notification_data = array(
		          'id'=>0,
		          'item_id' => $max_id,
                  'message_subject'   => '<span style="color:#'.$admin_color.'">'.$admin_username.'</span> deleted a post or a whole topic in',
				  'user_id' => $user_id,
                  'topic_id'   => (int) $topic_id,
                  'forum_id'   => (int) $forum_id,
                  'time'   => time(),
                  'post_subject'   => '<span style="color:red">'.$post_subject.'</span>',
               );
		
		$this->notification->add_notifications('leinad4mind.staff_notifier.notification.type.notify', $my_notification_data);
		}//end userid check
	} //end foreach
	
	} //end submit
	} //end mode
	
	
}


}




