<?php
/**
*
* @package Topic description
* @copyright (c) 2018 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\topicdescription\migrations;

class v2 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\rmcgirr83\topicdescription\migrations\v1');
	}

	public function update_schema()
	{
		return array(
			'change_columns'    => array(
				$this->table_prefix . 'topics'        => array(
					'topic_desc'	=> array('TEXT_UNI', null),
				),
			),
		);
	}
}
