<?php

/**
 *
 * @package phpBB Extension - Group Rules
 * @copyright (c) 2017-2018 Leinad4Mind - https://leinad4mind.top/forum
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\grouprules\migrations;

use phpbb\config\db_text;
use phpbb\db\migration\container_aware_migration;

class m3_multiple_then_actions extends container_aware_migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\leinad4mind\grouprules\migrations\m2_acp_module'];
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['custom', [[$this, 'multiple_then_actions']]],
		];
	}

	/**
	 *
	 */
	public function multiple_then_actions()
	{
		/** @var db_text $config_text */
		$config_text = $this->container->get('config_text');

		$json = $config_text->get('grouprules_group_actions');

		$group_actions = @json_decode($json, true);

		if (is_array($group_actions))
		{
			foreach ($group_actions as &$group_action)
			{
				$then = $group_action['then'];

				$group_action['then'] = [
					[
						'action'	=> $then['action'],
						'group'		=> $then['group'],
					],
				];

				if ($then['default'])
				{
					$group_action['then'][] = [
						'action'	=> 'default',
						'group'		=> $then['group'],
						'stop'		=> 0,
					];
				}
			}
		}
		else
		{
			$group_actions = [];
		}

		$config_text->set('grouprules_group_actions', json_encode($group_actions));
	}
}
