<?php
/**
*
* @package phpBB Extension - Form Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace leinad4mind\formcreator;

/**
* Extension class for custom enable/disable/purge actions
*/
class ext extends \phpbb\extension\base
{
	/**
	* Enable extension if phpBB version requirement is met
	*
	* @return bool
	* @access public
	*/
	public function is_enableable()
	{
		$config = $this->container->get('config');
		return version_compare($config['version'], '3.2.0-a1', '>=');
	}

	public static function explode($string)
	{
		$separators = ["\n\n", "\n"];

		foreach ($separators as $separator)
		{
			if (strpos($string, $separator) !== false)
			{
				return explode($separator, $string);
			}
		}

		return explode(',', $string);
	}


	public static function trim_once($str)
	{
		if (utf8_strlen($str) < 2)
		{
			return $str;
		}

		if ($str === '  ')
		{
			return ' ';
		}

		return trim(utf8_substr($str, 0, 1)) . utf8_substr($str, 1, -1) . trim(utf8_substr($str, -1, 1));
	}

	public static function split($value, $token = '=>')
	{
		$token = htmlspecialchars($token, ENT_COMPAT);

		$pos = utf8_strpos($value, $token);

		if ($pos === false)
		{
			return [$value, $value];
		}

		$token_length = utf8_strlen($token);

		return [
			utf8_substr($value, 0, $pos),
			utf8_substr($value, $pos + $token_length),
		];
	}
}
