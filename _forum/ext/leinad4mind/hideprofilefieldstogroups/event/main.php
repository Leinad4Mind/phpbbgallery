<?php

/**
 *
 * Hide Profile Fields To Groups. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2020, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\hideprofilefieldstogroups\event;

use leinad4mind\hideprofilefieldstogroups\profilefields_manager;
use phpbb\event\data;
use phpbb\request\request_interface;
use phpbb\template\template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main implements EventSubscriberInterface
{
	/** @var request_interface */
	protected $request;

	/** @var template */
	protected $template;

	/** @var profilefields_manager */
	protected $profilefields_helper;

	/**
	 * @param request_interface		$request
	 * @param template				$template
	 * @param profilefields_manager $profilefields_helper
	 */
	public function __construct(
		request_interface $request,
		template $template,
		profilefields_manager $profilefields_helper
	)
	{
		$this->request				= $request;
		$this->template				= $template;
		$this->profilefields_helper	= $profilefields_helper;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.acp_profile_create_edit_init'			=> 'acp_profile_create_edit_init',
			'core.acp_profile_create_edit_save_before'	=> 'acp_profile_create_edit_save_before',
		];
	}

	/**
	 * @param data $event
	 */
	public function acp_profile_create_edit_init(data $event)
	{
		if ($event['action'] == 'edit')
		{
			$field_id = $event['field_row']['field_id'];
			$groups = $this->profilefields_helper->get_profilefieldgroups($field_id);
			$this->template->assign_block_vars_array('hidetogroups', $groups);
		}
	}

	/**
	 * @param data $event
	 */
	public function acp_profile_create_edit_save_before(data $event)
	{
		$field_id = $this->request->variable('field_id', 0);
		if ($field_id)
		{
			$hidetogroups = $this->request->variable('hidetogroups', [0]);
			$this->profilefields_helper->set_profilefieldgroups($field_id, $hidetogroups);
		}
	}
}
