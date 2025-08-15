<?php
/**
 *
 * BBajaxnews. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\bbajaxnews\ajaxnews\type;

interface type_interface
{
	public function get_type();

	public function get_db_type();

	public function get_lang_array($data);

	public function get_content($data = []);

	public function get_receivers($data);

	public function is_special();
}
