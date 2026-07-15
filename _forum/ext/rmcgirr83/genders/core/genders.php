<?php
/**
*
* @package Genders
* @copyright (c) 2020 Rich McGirr(RMcGirr83)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace rmcgirr83\genders\core;

use Symfony\Component\HttpFoundation\JsonResponse;

class genders
{
	/** @var array */
	protected $gender_constants;

	/**
	 * Constructor
	 *
	 * @param array		$gender_constants	Constants used by the extension
	 */
	public function __construct(array $gender_constants)
	{
		$this->gender_constants = $gender_constants;
	}

	/**
	 * Display gender on change in ucp
	 * Ajax function
	 * @param $gender
	 *
	 * @return JsonResponse
	 */
	public function get_gender($gender_id)
	{
		$genders = array_flip($this->gender_constants);

		//default gender is the very first in the array
		$gender = reset($this->gender_constants);

		if (array_key_exists($gender_id, $genders))
		{
			$gender = $genders[$gender_id];
		}

		$json = new JsonResponse([
			'gender'     => $gender,
		]);

		return $json;
	}
}
