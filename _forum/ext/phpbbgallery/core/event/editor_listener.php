<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Expose the Gallery selector only to message editors that can use BBCodes.
 */
class editor_listener implements EventSubscriberInterface
{
	/** @var \phpbb\controller\helper Controller helper */
	protected \phpbb\controller\helper $helper;

	/** @var \phpbb\user phpBB user object */
	protected \phpbb\user $user;

	/** @var \phpbb\config\config phpBB configuration */
	protected \phpbb\config\config $config;

	/** @var \phpbb\auth\auth phpBB authorization object */
	protected \phpbb\auth\auth $auth;

	/** @var \phpbbgallery\core\image\selector Permission-filtered image selector */
	protected \phpbbgallery\core\image\selector $selector;

	public function __construct(\phpbb\controller\helper $helper, \phpbb\user $user,
		\phpbb\config\config $config, \phpbb\auth\auth $auth,
		\phpbbgallery\core\image\selector $selector)
	{
		$this->helper = $helper;
		$this->user = $user;
		$this->config = $config;
		$this->auth = $auth;
		$this->selector = $selector;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.posting_modify_template_vars'               => 'posting_editor',
			'core.ucp_pm_compose_template'                    => 'private_message_editor',
			'core.viewtopic_modify_quick_reply_template_vars' => 'quick_reply_editor',
		];
	}

	public function posting_editor(\phpbb\event\data $event): void
	{
		if (!in_array($event['mode'], ['post', 'reply', 'quote', 'edit'], true))
		{
			return;
		}

		$page_data = $event['page_data'];
		if (empty($page_data['S_BBCODE_ALLOWED']) || !$this->is_available())
		{
			return;
		}

		$page_data = array_merge($page_data, $this->template_variables());
		$event['page_data'] = $page_data;
	}

	public function private_message_editor(\phpbb\event\data $event): void
	{
		$template_ary = $event['template_ary'];
		if (empty($template_ary['S_BBCODE_ALLOWED']) || !$this->is_available())
		{
			return;
		}

		$template_ary = array_merge($template_ary, $this->template_variables());
		$event['template_ary'] = $template_ary;
	}

	public function quick_reply_editor(\phpbb\event\data $event): void
	{
		$topic_data = $event['topic_data'];
		$forum_id = (int) ($topic_data['forum_id'] ?? 0);
		if (empty($this->config['allow_bbcode'])
			|| !$this->user->optionget('bbcode')
			|| !$this->auth->acl_get('f_bbcode', $forum_id)
			|| !$this->is_available())
		{
			return;
		}

		$tpl_ary = array_merge($event['tpl_ary'], $this->template_variables());
		$event['tpl_ary'] = $tpl_ary;
	}

	private function is_available(): bool
	{
		if (empty($this->config['phpbb_gallery_bbcode_ready'])
			|| empty($this->user->data['is_registered'])
			|| !empty($this->user->data['is_bot']))
		{
			return false;
		}

		return $this->selector->has_images((int) $this->user->data['user_id']);
	}

	private function template_variables(): array
	{
		return [
			'S_GALLERY_SELECTOR'          => true,
			'U_GALLERY_SELECTOR'          => $this->helper->route('phpbbgallery_core_editor_images'),
			'U_GALLERY_SELECTOR_FALLBACK' => $this->helper->route('phpbbgallery_core_search_egosearch'),
		];
	}
}
