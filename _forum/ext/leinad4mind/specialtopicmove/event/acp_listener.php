<?php

/**
 *
 * Special Topic Move. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\specialtopicmove\event;

use leinad4mind\specialtopicmove\ext;
use phpbb\config\config;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\request\request_interface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class acp_listener implements EventSubscriberInterface
{
	/** @var config */
	protected $config;

	/** @var request_interface */
	protected $request;

	/* @var language */
	protected $language;

	/**
	 * @param config			$config
	 * @param request_interface	$request
	 * @param language			$language
	 */
	public function __construct(
		config $config,
		request_interface $request,
		language $language
	)
	{
		$this->config	= $config;
		$this->request	= $request;
		$this->language	= $language;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.acp_board_config_edit_add' => 'acp_board_config_edit_add',
		];
	}

	/**
	 * @param data $event
	 */
	public function acp_board_config_edit_add(data $event)
	{
		if ($event['mode'] == 'features')
		{
			if ($event['submit'])
			{
				$checkboxes = $this->request->variable('topic_moved_display', ['' => '']);

				$merged = 0;

				foreach ($checkboxes as $k => $v)
				{
					$merged |= $k;
				}

				$this->config->set('topic_moved_display', $merged);
			}

			$this->language->add_lang('acp', 'leinad4mind/specialtopicmove');

			$config = [
				'topic_moved_display' => [
					'lang'		=> 'SPECIAL_TOPIC_MOVED_DISPLAY',
					'validate'	=> 'string',
					'type'		=> 'custom',
					'function'	=> [$this, 'special_topic_move_acp_option'],
					'params'	=> ['{KEY}'],
					'explain'	=> true,
				],
			];

			$display_vars = $event['display_vars'];
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $config, ['after' => 'allow_birthdays']);
			$event['display_vars'] = $display_vars;
		}
	}

	/**
	 * @param string $key
	 * @return string
	 */
	public function special_topic_move_acp_option($key = '')
	{
		$options_array = [
			ext::SPECIAL_TOPIC_MOVED_BIT_FIRST	=> 'SPECIAL_TOPIC_MOVED_DISPLAY_FIRST',
			ext::SPECIAL_TOPIC_MOVED_BIT_LAST	=> 'SPECIAL_TOPIC_MOVED_DISPLAY_LAST',
			ext::SPECIAL_TOPIC_MOVED_BIT_MOVED	=> 'SPECIAL_TOPIC_MOVED_DISPLAY_MOVED',
			ext::SPECIAL_TOPIC_MOVED_BIT_SHADOW	=> 'SPECIAL_TOPIC_MOVED_DISPLAY_SHADOW',
		];

		$select = '';

		foreach ($options_array as $idx => $title)
		{
			$selected = ($this->config['topic_moved_display'] & $idx) ? ' checked' : '';
			$id = $key . ($idx == 1 ? '' : $idx);
			$input = '<input type="checkbox" id="' . $id . '" name="topic_moved_display[' . $idx . ']"' . $selected . ' style="cursor:auto">';
			$select .= '<label for="' . $id . '">' . $input . '&nbsp;' . $this->language->lang($title) . '</label><br>';
		}

		return $select;
	}
}
