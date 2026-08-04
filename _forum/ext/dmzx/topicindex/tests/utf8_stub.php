<?php

if (!function_exists('utf8_clean_string'))
{
	function utf8_clean_string($text)
	{
		return strtr(mb_strtolower($text), [
			'á' => 'a', 'à' => 'a', 'â' => 'a', 'ã' => 'a',
			'ç' => 'c',
			'é' => 'e', 'ê' => 'e',
			'í' => 'i',
			'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
			'ú' => 'u',
		]);
	}
}
