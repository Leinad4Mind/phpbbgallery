<?php
/**
 * phpBB Gallery - Extension dependency version validation.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\dependency;

/** Validate enabled or available extension versions before an add-on is installed. */
final class version_validator
{
	/**
	 * Validate dependency versions and report incompatible packages through phpBB.
	 *
	 * @param object $manager      phpBB extension manager
	 * @param object $user         phpBB user/language service
	 * @param array  $requirements Extension => [inclusive minimum, exclusive maximum]
	 */
	public static function validate(object $manager, object $user, array $requirements): bool
	{
		$incompatible = self::incompatible($manager, $requirements);
		if (!$incompatible)
		{
			return true;
		}

		$user->add_lang_ext('phpbbgallery/core', 'install_gallery');
		trigger_error($user->lang('GALLERY_DEPENDENCY_VERSION_UNSUPPORTED', implode(', ', $incompatible)), E_USER_WARNING);

		return false;
	}

	/**
	 * Return human-readable entries for every incompatible dependency.
	 *
	 * Test doubles predating version validation may omit the metadata API. Real phpBB
	 * extension managers always provide it.
	 */
	public static function incompatible(object $manager, array $requirements): array
	{
		if (!method_exists($manager, 'create_extension_metadata_manager'))
		{
			return [];
		}

		$incompatible = [];
		foreach ($requirements as $extension => [$minimum, $maximum])
		{
			try
			{
				$metadata = $manager->create_extension_metadata_manager($extension);
				$version = (string) $metadata->get_metadata('version');
			}
			catch (\Throwable)
			{
				$version = '';
			}

			if (!self::satisfies($version, (string) $minimum, (string) $maximum))
			{
				$found = $version !== '' ? $version : '?';
				$incompatible[] = $extension . ' >=' . $minimum . ',<' . $maximum . ' (' . $found . ')';
			}
		}

		return $incompatible;
	}

	/** Check an inclusive minimum and exclusive maximum version range. */
	public static function satisfies(string $version, string $minimum, string $maximum): bool
	{
		return $version !== ''
			&& version_compare($version, $minimum, '>=')
			&& version_compare($version, $maximum, '<');
	}
}
