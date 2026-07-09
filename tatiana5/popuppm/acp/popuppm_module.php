<?php
/**
 *
 * @package       Popup PM
 * @copyright (c) 2016 Татьяна5
 * @license       http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

namespace tatiana5\popuppm\acp;

use tatiana5\popuppm\functions\acp_module_helper;

class popuppm_module extends acp_module_helper
{
	public function main($id, $mode)
	{
		$this->tpl_name = 'acp_popuppm';
		$this->form_key = 'config_popuppm';
		add_form_key($this->form_key);

		parent::main($id, $mode);
	}

	/**
	 * Generates the array of display_vars
	 *
	 * @return array
	 */
	protected function generate_display_vars()
	{
		$this->display_vars = [
			'title' => 'ACP_POPUPPM_TITLE',
			'vars'  => [
				'legend1'                    => '',
				'popuppm_enable_popup'       => ['lang' => 'ACP_POPUPPM_ENABLE_POPUP', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
				'popuppm_enable_blink'       => ['lang' => 'ACP_POPUPPM_ENABLE_BLINK', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
				//
				'legend2'                    => 'ACP_SUBMIT_CHANGES',
			],
		];
	}
}
