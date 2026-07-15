<?php
/**
* @package Splicker Giphy Embed
* @copyright (c) 2021 SplickerSnap.com
* @author Splicker
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace splicker\giphyembed\migrations;

class giphyembed_module extends \phpbb\db\migration\migration
{

	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'Giphy Embed')),
			array('module.add', array(
				'acp', 'Giphy Embed', array(
					'module_basename' => '\splicker\giphyembed\acp\giphyembed_module', 'modes'   => array('config'),
				),
			)),
		);
	}
}
