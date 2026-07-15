<?php
/**
*
* @package Errorpages
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\errorpages\event;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $config;
	protected $user;
	protected $template;
	protected $log;

	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\template\template $template, \phpbb\log\log $log)
	{
		$this->config = $config;
		$this->user = $user;
		$this->template = $template;
		$this->log = $log;
	}

	public function onKernelException(GetResponseForExceptionEvent $event)
	{
		$this->user->add_lang_ext('forumhulp/errorpages', 'info_acp_errorpages');

		// Get the exception object from the received event
		$exception = $event->getException();
		$request = $event->getRequest();

		

		

		page_header($this->user->lang('INFORMATION'));
		$this->template->assign_vars(array(
			'MESSAGE_TITLE'		=> $this->user->lang('INFORMATION'),
			'MESSAGE_TEXT'		=> '</p><div class="text-center"><h1 class="text-uppercase">' . $this->user->lang[$msg] . '</h1>' . (($this->config['error_pages_explain']) ? $this->user->lang[$msg.'EXPA'] : '') . '<br /><br /><a href="' . generate_board_url() .'" class="btn btn-default">' . sprintf($this->user->lang['RETURN_INDEX'], '', '') . '</a></div><p>',
		));

		$this->template->set_filenames(array(
			'body'	=> 'message_body.html',
		));
		page_footer(true, false, false);

		$status_code = $exception instanceof HttpException ? $exception->getStatusCode() : 500;
		$response = new Response($this->template->assign_display('body'), $status_code);
		$event->setResponse($response);
	}

	public static function getSubscribedEvents()
	{
		return array (
			KernelEvents::EXCEPTION => array('onKernelException', 2000));
	}
}
