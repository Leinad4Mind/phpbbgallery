<?php
/**
 *
 * @package phpBB Extension - LMDI Delete Re:
 * @copyright (c) 2015-2022 LMDI - Pierre Duhem
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace lmdi\delre\event;

/**
 * @ignore
 */

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{

	/* @var \phpbb\template\template */
	protected $template;

	public function __construct(\phpbb\template\template $template)
	{
		$this->template = $template;
	}


	static public function getSubscribedEvents()
	{
	return array(
		'core.posting_modify_template_vars'	=> 'delete_re',
		'core.viewtopic_modify_page_title'	=> 'delete_re_2',
		'core.pm_modify_message_subject'	=> 'delete_re_pm',
	);
	}


	// Normal reply
	public function delete_re($event)
	{
		$page_data = $event['page_data'];
		$titre = $page_data['SUBJECT'];
		$titre = preg_replace('/^Re: /', '', $titre);
		$page_data['SUBJECT'] = $titre;
		$event['page_data'] = $page_data;
	}


	// Quick reply
	public function delete_re_2($event)
	{
		$topic_data = $event['topic_data'];
		$this->template->assign_var('SUBJECT', censor_text($topic_data['topic_title']));
	}


	// PM reply
	public function delete_re_pm($event)
	{
		$titre = $event['message_subject'];
		$titre = preg_replace('/^Re: /', '', $titre);
		$event['message_subject'] = $titre;
	}


}
