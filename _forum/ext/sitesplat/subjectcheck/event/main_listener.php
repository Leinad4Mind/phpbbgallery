<?php
/**
*
* @package subjectcheck
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\subjectcheck\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subject Check Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.posting_modify_submission_errors'	=> 'check_subject',
			'core.posting_modify_template_vars'		=> 'setup_ajax_bypass',
		);
	}

	protected $subject_check;
	protected $template;
	protected $user;
	protected $helper;
	protected $config;
	private $subject;
	private $bypass;
	private $checked;
	public function __construct(\sitesplat\subjectcheck\core\subject_check $subject_check, \phpbb\template\template $template, \phpbb\user $user, \phpbb\controller\helper $helper, \phpbb\config\config $config)
	{
		$this->subject_check = $subject_check;
		$this->template = $template;
		$this->user = $user;
		$this->helper = $helper;
		$this->config = $config;
	}

	public function check_subject($event)
	{
		$can_bypass = false;
		if((int) $this->config['subject_check_bypass'] === 1 && $this->config['subject_check_ajax']) return;
		if((int) $this->config['subject_check_bypass'] === 2 && $this->config['subject_check_ajax']) {
			$can_bypass = $this->subject_check->can_bypass($event);
		}
		if($can_bypass) return;
		list($this->subject, $this->bypass) = $this->subject_check->look_for_posts($event);
		if($this->bypass) $this->subject = '';
	}

	public function setup_ajax_bypass($event)
	{
		if ($this->config['subject_check_enable'])
		{
			if ($this->config['subject_check_ajax'] && $event['mode'] == 'post' && $event['post_data']['forum_subject_check'])
			{
				$this->user->add_lang_ext('sitesplat/subjectcheck', 'common');
				$this->template->assign_vars(array(
					'U_PRIME_SUBJECT_CHECK_AJAX'	=> $this->helper->route('sitesplat_subjectcheck_controller', array('forum_id' => $event['forum_id'], 'a' => '1')),
					'S_BYPASS_OPTION'		=> $this->config['subject_check_bypass'],
				));
			}

			$page_data = $event['page_data'];
			$page_data['S_HIDDEN_FIELDS'] .= '<input type="hidden" name="subject_checked" value="' . $this->subject . '" /><input type="hidden" name="subject_check_bypass" value="' . ($this->bypass ? 1 : 0) . '" />';
			$event['page_data'] = $page_data;
		}
	}
}
