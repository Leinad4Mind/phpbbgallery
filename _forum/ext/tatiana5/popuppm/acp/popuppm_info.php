<?php
/**
 *
 * @package       Popup PM
 * @copyright (c) 2016 Татьяна5
 * @license       http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

namespace tatiana5\popuppm\acp;

class popuppm_info
{
	public function module()
	{
		return [
			'filename'	=> '\tatiana5\popuppm\acp\popuppm_module',
			'title'		=> 'ACP_POPUPPM',
			'version'	=> '0.0.1',
			'modes'		=> [
				'config_popuppm'		=> ['title' => 'ACP_POPUPPM_EXPLAIN', 'auth' => 'ext_tatiana5/popuppm  && acl_a_board', 'cat' => ['ACP_POPUPPM_EXPLAIN']],
			],
		];
	}
}
