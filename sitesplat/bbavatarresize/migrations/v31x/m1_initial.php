<?php
/**
*
* @package Avatar Resize
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbavatarresize\migrations\v31x;

class m1_initial extends \phpbb\db\migration\migration
{
	/**
	 * Assign migration file dependencies for this migration
	 *
	 * @return array Array of migration files
	 * @static
	 * @access public
	 */
	static public function depends_on()
	{
		//return array('\sitesplat\helper\migrations\v31x\m1_initial_module');
		return array('\sitesplat\BBCore\migrations\v32x\m1_initial_module');
	}
}
