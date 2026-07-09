<?php
/**
*
* @package - Quick Reply On Last Page Only
* @copyright (c) 2015 RMcGirr83
* @author RMcGirr83 (Rich McGirr)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace rmcgirr83\qronlastpage\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/**
	 * Target post count
	 */
	private $post_count = 0;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\user $user)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
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
			'core.viewtopic_assign_template_vars_before'			=> 'viewtopic_assign_template_vars_before',
			'core.viewtopic_modify_page_title'		=> 'viewtopic_modify_page_title',
		);
	}

	/**
	* We simply want the post_count of the topic
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_assign_template_vars_before($event)
	{
		$this->post_count = (int) $event['total_posts'];
	}

	/**
	* Only display quick reply on the last page
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_modify_page_title($event)
	{
		$qr = $on_last_page = false;
		//we check first to ensure quick reply is even activated for the forum
		if ($this->user->data['is_registered'] && $this->config['allow_quick_reply'] && ($event['topic_data']['forum_flags'] & FORUM_FLAG_QUICK_REPLY) && $this->auth->acl_get('f_reply', $event['topic_data']['forum_id']))
		{
			$qr = (($event['topic_data']['forum_status'] == ITEM_UNLOCKED && $event['topic_data']['topic_status'] == ITEM_UNLOCKED) || $this->auth->acl_get('m_edit', $event['topic_data']['forum_id'])) ? true : false;
		}

		if ($qr)
		{
			$on_last_page = ((floor($event['start'] / $this->config['posts_per_page']) + 1) == max(ceil($this->post_count / $this->config['posts_per_page']), 1)) ? true : false;
		}

		if (!$on_last_page)
		{
			$this->template->assign_vars(array(
				'S_QUICK_REPLY'	=> false,
			));
		}
	}
}
