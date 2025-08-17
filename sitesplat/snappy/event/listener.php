<?php
/**
*
* Snappy Smart Reply
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\snappy\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	protected $auth;
	protected $config;
	protected $user;
	protected $template;
	protected $phpbb_root_path;
	protected $php_ext;
	protected $cache;
	protected $request;

	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user, \phpbb\template\template $template, $phpbb_root_path, $php_ext, \phpbb\plupload\plupload $plupload, \phpbb\cache\service $cache, \phpbb\request\request $request)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->user = $user;
		$this->template = $template;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->plupload = $plupload;
		$this->cache = $cache;
		$this->request = $request;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_modify_page_title' 	=> 'snappy',
			'core.viewtopic_modify_post_row'    => 'decoded_post_add',
		);
	}

	/**
	 * Inject BBcode in QR
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function snappy($event)
	{
		$forum_id = $event['forum_id'];
		$bbcode_status = ($this->config['allow_bbcode'] && $this->auth->acl_get('f_bbcode', $forum_id)) ? true : false;
		if($bbcode_status)
		{
			display_custom_bbcodes();
		}
		
		$smilies_status	= ($this->config['allow_smilies'] && $this->auth->acl_get('f_smilies', $forum_id)) ? true : false;
		if($smilies_status)
		{
			include $this->root_path . 'includes/functions_posting.' . $this->php_ext;
			generate_smilies('inline', $forum_id);
		}
		
		if($smilies_status || $bbcode_status)
		{
			$this->user->add_lang('posting');
		}
        
		$this->user->add_lang('plupload');

		$s_action = append_sid($this->root_path . 'posting.' . $this->php_ext, 'mode=reply&amp;f='. $forum_id);
		$s_action .= ($event['topic_data']['topic_id']) ? '&amp;t=' . $event['topic_data']['topic_id'] : '';
		$s_action .= (isset($event['topic_data']['post_id'])) ? '&amp;p=' . $event['topic_data']['post_id'] : '';
		$this->plupload->configure($this->cache, $this->template, $s_action, 0, 10);

		$max_filesize = @ini_get("upload_max_filesize");
		if (!empty($max_filesize))
		{
			$unit = strtolower(substr($max_filesize, -1, 1));
			$max_filesize = (int) $max_filesize;

			switch ($unit)
			{
				case 'g':
					$max_filesize *= 1024;
				case 'm':
					$max_filesize *= 1024;
				case 'k':
					$max_filesize *= 1024;
			}
		}
	//	print_r($event['topic_data']);
		
		// Are we watching this topic?
		$s_watching_topic = array(
			'link'			=> '',
			'link_toggle'	=> '',
			'title'			=> '',
			'title_toggle'	=> '',
			'is_watching'	=> false,
		);
	//	watch_topic_forum('topic', $s_watching_topic, $this->user->data['user_id'], $forum_id, $event['topic_data']['topic_id'], $event['topic_data']['notify_status'], $event['start'], $event['topic_data']['topic_title']);
		watch_topic_forum('topic', $s_watching_topic, $this->user->data['user_id'], $forum_id, $event['topic_data']['topic_id'], (isset($event['topic_data']['notify_status']) ? $event['topic_data']['notify_status'] : 0), $event['start'], $event['topic_data']['topic_title']);

		$this->template->assign_vars(array(
			'S_BBCODE_ALLOWED'		=> $bbcode_status,
			'S_BBCODE_CHECKED'		=> ($this->config['allow_bbcode'] && !$this->user->optionget('bbcode')) ? 'checked="checked"' : '',

			'S_SMILIES_ALLOWED'		=> $smilies_status,
			'S_SMILIES_CHECKED'		=> ($this->config['allow_smilies'] && !$this->user->optionget('smilies')) ? ' checked="checked"': '',
			
			'S_LINKS_ALLOWED'		=> ($this->config['allow_post_links']) ? true : false,

			'S_SIG_ALLOWED'			=> ($this->config['allow_sig'] && $this->config['allow_sig_pm'] && $this->auth->acl_get('u_sig')),
			'S_SIGNATURE_CHECKED'	=> $this->config['allow_sig'] && $this->user->optionget('attachsig') && $this->auth->acl_get('f_sigs', $forum_id) && $this->auth->acl_get('u_sig') ? ' checked="checked"' : '',
			
			'S_NOTIFY_ALLOWED'		=> $this->config['allow_topic_notify'],
			'S_NOTIFY_CHECKED'		=> $this->config['allow_topic_notify'] && ($this->user->data['user_notify'] || $s_watching_topic['is_watching']) ? ' checked="checked"': '',
			'S_LOCK_TOPIC_ALLOWED'	=> ($this->auth->acl_get('m_lock', $forum_id) || ($this->auth->acl_get('f_user_lock', $forum_id) && $this->user->data['is_registered'] && $this->user->data['user_id'] == $event['topic_data']['topic_poster'])) ? true : false,
			'S_LOCK_TOPIC_CHECKED'	=> ($event['topic_data']['topic_status'] != ITEM_UNLOCKED) ? ' checked="checked"' : '',
			
			'S_LOCK_POST_ALLOWED'	=> ($this->auth->acl_get('m_edit', $forum_id)) ? true : false,

			'MAX_POST_CHARS'		=> $this->config['max_post_chars'],
			'S_PLUPLOAD'			=> true,
			'FILESIZE'				=> $max_filesize,
			'S_ATTACH_DATA'			=> json_encode(array()),
			'S_FORM_ENCTYPE'		=> (@ini_get('file_uploads') == '0' || strtolower(@ini_get('file_uploads')) == 'off') ? '' : ' enctype="multipart/form-data"',
			'T_ASSETS_PATH'			=> $this->root_path . 'assets',
			'S_SNAPPY'				=> true,
			));
	}
	
	// Lets make a copy of the posts and be parsed to the original BBcodes so we can quote this son of a R2 D2 
	public function decoded_post_add($event)
    {
    $decoded_message = censor_text($event['row']['post_text']);
    decode_message($decoded_message, $event['row']['bbcode_uid']);
    $event['post_row'] += array('DECODED_MESSAGE' => bbcode_nl2br($decoded_message));
    }
}
