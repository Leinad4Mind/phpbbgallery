<?php
/**
*
* BBlightbox
* @copyright (c) 2017 sitesplat.com All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bblightbox\migrations\v31x;

/**
* Migration stage 1: Initial config
*/
class m1_initial_config extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('bblightbox',  '{"plugin":"fancybox","bbcode_allow":"1","qimages":"1","resize":"200","captions":"1","protect":"1","slide":"1","animationeffect":"fade","enablezoom":"0","collums":"3"}')),
		);
	}
}
