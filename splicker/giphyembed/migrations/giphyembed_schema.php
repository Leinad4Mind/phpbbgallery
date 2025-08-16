<?php
/**
* @package Splicker Giphy Embed
* @copyright (c) 2021 SplickerSnap.com
* @author Splicker
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace splicker\giphyembed\migrations;

class giphyembed_schema extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\dev');
	}
	
	public function update_data()
	{
		return array(
			array('config.add', array('splicker_giphyembed', '1.0.0')),
			array('config.add', array('giphyembed_enable', 1)),			
			array('config.add', array('giphyembed_apikey', 'ABCDEFG123456789')),
			array('config.add', array('giphyembed_rating', 'pg')),
			array('config.add', array('giphyembed_scroll', 1)),
		);
	}
}
