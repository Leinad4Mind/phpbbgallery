<?php
/**
 *
 * CF Change Post Time
 *
 * @copyright (c) 2024 chris1278
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
 */


namespace chris1278\cptfork\migrations;

class v1_0_3_acp_modul extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\chris1278\cptfork\migrations\v1_0_2_permissions'];
	}

	public function update_data()
	{
		return [
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'CF_CPT_TITLE'
			]],
			['module.add', [
				'acp',
				'CF_CPT_TITLE', [
					'module_basename'	=> '\chris1278\cptfork\acp\main_module',
					'modes'				=> ['settings'],
				],
			]],
			['config.add', ['cf_cpt_option', 'opt_1']],
		];
	}
}
