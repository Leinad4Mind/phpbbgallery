<?php
/*
* @package cBB Blockgets
* @version v2.0.2 26/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\blockgets\migrations;

class v202 extends \canidev\blockgets\libraries\migration_base
{
	protected $version = '2.0.2';

	static public function depends_on()
	{
		return array(
			'\canidev\blockgets\migrations\v201',
		);
	}

	public function _update_data()
	{
		return [
			['custom', [[$this, 'update_block_config']]],
		];
	}

	public function update_block_config()
	{
		$block_manager = new \canidev\blockgets\libraries\block_manager($this->db, $this->table_prefix);

		$block_manager->add_config(array(
			'leaders_block'	=> array(
				'only_online'		=> 0
			),
			'recent_topics_block' => array(
				'show_parent'		=> 0,
				'sections'			=> \canidev\blockgets\blocks\recent_topics_block::$default_sections,
				'title_limit'		=> null,
			),
			'top_topics_block' => array(
				'show_parent'		=> 0
			),
			'topic_index_block' => array(
				'show_parent'		=> 0
			)
		));
	}
}
