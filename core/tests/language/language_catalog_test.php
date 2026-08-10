<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests\language;

use PHPUnit\Framework\TestCase;

class language_catalog_test extends TestCase
{
	/** @var string */
	private $extension_root;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->extension_root = dirname(__DIR__, 3);
	}

	public function test_every_translation_has_the_english_files_and_keys(): void
	{
		$failures = [];

		foreach ($this->components() as $component)
		{
			$language_root = $this->extension_root . '/' . $component . '/language';
			$english_files = $this->php_files($language_root . '/en');

			foreach ($this->language_directories($language_root) as $directory)
			{
				if (basename($directory) === 'en')
				{
					continue;
				}

				$translated_files = $this->php_files($directory);
				if ($english_files !== $translated_files)
				{
					$failures[] = $component . '/' . basename($directory) . ': PHP file set differs from English';
					continue;
				}

				foreach ($english_files as $file)
				{
					$english = $this->load_language($language_root . '/en/' . $file);
					$translated = $this->load_language($directory . '/' . $file);
					$english_keys = array_keys($english);
					$translated_keys = array_keys($translated);
					sort($english_keys);
					sort($translated_keys);

					if ($english_keys !== $translated_keys)
					{
						$failures[] = $component . '/' . basename($directory) . '/' . $file . ': key set differs from English';
					}
				}
			}
		}

		$this->assertSame([], $failures, implode("\n", $failures));
	}

	public function test_every_translation_preserves_printf_placeholders(): void
	{
		$failures = [];

		foreach ($this->catalogs() as $catalog)
		{
			foreach ($catalog['english'] as $key => $english)
			{
				if ($this->placeholder_shape($english) !== $this->placeholder_shape($catalog['translated'][$key]))
				{
					$failures[] = $catalog['name'] . ':' . $key;
				}
			}
		}

		$this->assertSame([], $failures, 'Placeholder mismatch: ' . implode(', ', $failures));
	}

	public function test_every_translation_is_valid_utf8_and_not_unexpectedly_empty(): void
	{
		$failures = [];

		foreach ($this->catalogs() as $catalog)
		{
			foreach ($catalog['english'] as $key => $english)
			{
				$english_values = $this->string_values($english);
				$translated_values = $this->string_values($catalog['translated'][$key]);

				foreach ($translated_values as $index => $value)
				{
					if (preg_match('//u', $value) !== 1)
					{
						$failures[] = $catalog['name'] . ':' . $key . ': invalid UTF-8';
					}
					if ($value === '' && isset($english_values[$index]) && $english_values[$index] !== '')
					{
						$failures[] = $catalog['name'] . ':' . $key . ': empty translation';
					}
				}
			}
		}

		$this->assertSame([], $failures, implode("\n", $failures));
	}

	public function test_every_language_uses_the_current_project_credit(): void
	{
		$expected = 'Powered by <a href="https://github.com/satanasov/phpbbgallery">phpBB Gallery</a> &copy; 2014–2026';
		$language_root = $this->extension_root . '/core/language';

		foreach ($this->language_directories($language_root) as $directory)
		{
			$language = $this->load_language($directory . '/info_acp_gallery.php');
			$this->assertSame($expected, $language['GALLERY_COPYRIGHT'], basename($directory));
		}
	}

	public function test_portuguese_catalogs_use_the_declared_orthography_and_tu_register(): void
	{
		$forbidden_patterns = [
			'pt' => [
				'/(?<!\p{L})Você(?!\p{L})/u',
				'/\b(?:respectiv|acç(?:ão|ões)|activ|actual|direct|efect|excepto|seleccion|correct)/iu',
			],
			'pt_preao' => [
				'/(?<!\p{L})Você(?!\p{L})/u',
				'/(?<!\p{L})(?:ação|ações)(?!\p{L})/iu',
				'/\b(?:respetiv|(?:des)?ativ(?:ada|adas|ado|ados|ar|as)|(?:des)?atual|diretório|efetue|efetuados|exceto|selecion|(?:in)?corret|relactiv|tentactiv)/iu',
			],
		];
		$failures = [];
		$language_root = $this->extension_root . '/core/language';

		foreach ($forbidden_patterns as $locale => $patterns)
		{
			foreach ($this->php_files($language_root . '/' . $locale) as $file)
			{
				$source = file_get_contents($language_root . '/' . $locale . '/' . $file);
				foreach ($patterns as $pattern)
				{
					if (preg_match($pattern, $source, $match) === 1)
					{
						$failures[] = $locale . '/' . $file . ': ' . $match[0];
					}
				}
			}
		}

		$this->assertSame([], $failures, implode(chr(10), $failures));
	}

	public function test_portuguese_acp_settings_describe_the_values_they_control(): void
	{
		$expected = [
			'COMMENT_MAX_LENGTH' => 'Comprimento máximo dos comentários',
			'IMAGE_DESC_MAX_LENGTH' => 'Comprimento máximo das descrições das imagens',
			'ITEMS_PER_PAGE' => 'Itens por página',
			'RATE_SCALE' => 'Escala de classificação',
		];
		$language_root = $this->extension_root . '/core/language';

		foreach (['pt', 'pt_preao'] as $locale)
		{
			$language = $this->load_language($language_root . '/' . $locale . '/gallery_acp.php');
			foreach ($expected as $key => $value)
			{
				$this->assertSame($value, $language[$key], $locale . ':' . $key);
			}
		}
	}

	public function test_image_permissions_distinguish_previews_from_original_sources(): void
	{
		$language_root = $this->extension_root . '/core/language';
		foreach (glob($language_root . '/*/gallery_acp.php') as $catalog)
		{
			$locale = basename(dirname($catalog));
			$language = $this->load_language($catalog);
			$this->assertStringContainsString('(', $language['PERMISSION_I_VIEW'], $locale . ':PERMISSION_I_VIEW');
			$this->assertStringContainsString('source', $language['PERMISSION_I_DOWNLOAD'], $locale . ':PERMISSION_I_DOWNLOAD');
			$this->assertStringContainsString('source', $language['PERMISSION_I_DOWNLOAD_FREE'], $locale . ':PERMISSION_I_DOWNLOAD_FREE');
			foreach (['PERMISSION_I_VIEW_EXPLAIN', 'PERMISSION_I_DOWNLOAD_EXPLAIN', 'PERMISSION_I_DOWNLOAD_FREE_EXPLAIN'] as $key)
			{
				$this->assertArrayHasKey($key, $language, $locale . ':' . $key);
				$this->assertNotSame('', trim($language[$key]), $locale . ':' . $key);
			}
		}

		$english = $this->load_language($language_root . '/en/gallery_acp.php');
		$this->assertStringContainsString('album image listings', $english['PERMISSION_I_VIEW_EXPLAIN']);
		$this->assertStringContainsString('individual image pages', $english['PERMISSION_I_VIEW_EXPLAIN']);
		$this->assertStringContainsString('does not grant access to the original source file', $english['PERMISSION_I_VIEW_EXPLAIN']);
		$this->assertStringContainsString('permission is also required', $english['PERMISSION_I_DOWNLOAD_EXPLAIN']);
	}

	public function test_download_source_tooltip_is_translated_in_every_language(): void
	{
		$language_root = $this->extension_root . '/core/language';
		foreach ($this->language_directories($language_root) as $directory)
		{
			$language = $this->load_language($directory . '/gallery.php');
			$this->assertArrayHasKey('DOWNLOAD_SOURCE', $language, basename($directory));
			$this->assertNotSame('DOWNLOAD_SOURCE', $language['DOWNLOAD_SOURCE'], basename($directory));
			$this->assertNotSame('', trim($language['DOWNLOAD_SOURCE']), basename($directory));
		}
	}

	public function test_upload_comment_option_distinguishes_one_image_from_a_batch(): void
	{
		$language_root = $this->extension_root . '/core/language';
		foreach ($this->language_directories($language_root) as $directory)
		{
			$language = $this->load_language($directory . '/gallery.php');
			$this->assertArrayHasKey('ALLOW_COMMENTS', $language, basename($directory));
			$this->assertArrayHasKey('ALLOW_COMMENTS_ALL', $language, basename($directory));
			$this->assertNotSame($language['ALLOW_COMMENTS'], $language['ALLOW_COMMENTS_ALL'], basename($directory));
		}

		$styles_root = $this->extension_root . '/core/styles';
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents($styles_root . '/' . $style . '/template/gallery/posting_body.html');
			$this->assertStringContainsString('NUM_IMAGES > 1', $template, $style);
			$this->assertStringContainsString("lang('ALLOW_COMMENTS_ALL')", $template, $style);
		}
	}

	public function test_php_upload_limit_error_is_explained_in_every_language(): void
	{
		$language_root = $this->extension_root . '/core/language';
		foreach ($this->language_directories($language_root) as $directory)
		{
			$catalog = $directory . '/gallery.php';
			$language = $this->load_language($catalog);
			$this->assertArrayHasKey('PHP_SIZE_OVERRUN', $language, basename($directory));
			$this->assertSame(1, substr_count(file_get_contents($catalog), 'PHP_SIZE_OVERRUN'), basename($directory));
			$this->assertStringContainsString('upload_max_filesize', $language['PHP_SIZE_OVERRUN'], basename($directory));
			$this->assertStringContainsString('post_max_size', $language['PHP_SIZE_OVERRUN'], basename($directory));
			$this->assertSame(['d', 's'], $this->placeholder_shape($language['PHP_SIZE_OVERRUN']), basename($directory));

			$this->assertArrayHasKey('RESIZE_SOURCE_FILESIZE_EXPLAIN', $language, basename($directory));
			$this->assertSame(1, substr_count(file_get_contents($catalog), 'RESIZE_SOURCE_FILESIZE_EXPLAIN'), basename($directory));
			$this->assertStringContainsString('upload_max_filesize', $language['RESIZE_SOURCE_FILESIZE_EXPLAIN'], basename($directory));
			$this->assertStringContainsString('post_max_size', $language['RESIZE_SOURCE_FILESIZE_EXPLAIN'], basename($directory));
			$this->assertSame(['s', 's'], $this->placeholder_shape($language['RESIZE_SOURCE_FILESIZE_EXPLAIN']), basename($directory));

			$this->assertArrayHasKey('UPLOAD_EFFECTIVE_LIMIT', $language, basename($directory));
			$this->assertSame(1, substr_count(file_get_contents($catalog), 'UPLOAD_EFFECTIVE_LIMIT'), basename($directory));
			$this->assertSame(['d'], $this->placeholder_shape($language['UPLOAD_EFFECTIVE_LIMIT']), basename($directory));
		}
	}

	public function test_brazilian_portuguese_catalog_uses_brazilian_vocabulary_and_register(): void
	{
		$patterns = [
			'/(?<!\p{L})(?:aceder|contacte|contactado|directoria|descarregar|equipa|ficheiro|gerir|pixeis|secção|utilizador)(?!\p{L})/iu',
			'/(?<!\p{L})(?:acções|activar|apagar|eliminar|hiperligação|registado|registados|subscrito|subscritos)(?!\p{L})/iu',
			'/(?<!\p{L})(?:até ao|base de dados|já não|palavra-passe|por baixo|tem a certeza)(?!\p{L})/iu',
			'/(?<!\p{L})(?:a aguardar|a carregar|a observar|está a|estão a)(?!\p{L})/iu',
			'/(?<!\p{L})Pode usar as suas(?!\p{L})/iu',
		];
		$failures = [];
		$language_root = $this->extension_root . '/core/language/pt_br';

		foreach ($this->php_files($language_root) as $file)
		{
			foreach ($this->load_language($language_root . '/' . $file) as $key => $value)
			{
				foreach ($this->string_values($value) as $text)
				{
					foreach ($patterns as $pattern)
					{
						if (preg_match($pattern, $text, $match) === 1)
						{
							$failures[] = 'pt_br/' . $file . ':' . $key . ': ' . $match[0];
						}
					}
				}
			}
		}

		$this->assertSame([], $failures, implode(chr(10), $failures));
	}

	public function test_catalogs_do_not_use_the_obsolete_gallery_mod_name(): void
	{
		$failures = [];

		foreach ($this->components() as $component)
		{
			$language_root = $this->extension_root . '/' . $component . '/language';
			foreach ($this->language_directories($language_root) as $directory)
			{
				foreach ($this->php_files($directory) as $file)
				{
					foreach ($this->load_language($directory . '/' . $file) as $key => $value)
					{
						foreach ($this->string_values($value) as $text)
						{
							if (stripos($text, 'Gallery-MOD') !== false)
							{
								$failures[] = $component . '/' . basename($directory) . '/' . $file . ':' . $key;
							}
						}
					}
				}
			}
		}

		$this->assertSame([], $failures, implode(chr(10), $failures));
	}

	public function test_foreign_core_catalogs_do_not_keep_known_english_fallbacks(): void
	{
		$forbidden = [
			'No comments or own pictures yet',
			'You are not subscribed to an album.',
			'Show gallery link',
			'Show link to the gallery in user menu.',
			'Report closed by',
			'Not approved images',
			'Resync personal albums to profile fields',
		];
		$failures = [];
		$language_root = $this->extension_root . '/core/language';

		foreach ($this->language_directories($language_root) as $directory)
		{
			if (basename($directory) === 'en')
			{
				continue;
			}

			foreach ($this->php_files($directory) as $file)
			{
				foreach ($this->load_language($directory . '/' . $file) as $key => $value)
				{
					foreach ($this->string_values($value) as $text)
					{
						if (in_array($text, $forbidden, true))
						{
							$failures[] = basename($directory) . '/' . $file . ':' . $key;
						}
					}
				}
			}
		}

		$this->assertSame([], $failures, implode(chr(10), $failures));
	}

	public function test_install_catalog_contains_runtime_lifecycle_messages(): void
	{
		$language_root = $this->extension_root . '/core/language';

		foreach ($this->language_directories($language_root) as $directory)
		{
			$language = $this->load_language($directory . '/install_gallery.php');
			$this->assertSame([
				'GALLERY_BBCODE_CONFLICT',
				'GALLERY_BBCODE_LIMIT_REACHED',
				'GALLERY_CORE_ENABLE_SUCCESS',
				'GALLERY_CORE_ENABLE_BBCODE_FALLBACK',
				'GALLERY_REQUIREMENTS_MISSING',
				'GALLERY_SUB_EXT_UNINSTALL',
			], array_keys($language), basename($directory));
			$this->assertSame(['s'], $this->placeholder_shape($language['GALLERY_BBCODE_CONFLICT']), basename($directory));
			$this->assertSame(['s'], $this->placeholder_shape($language['GALLERY_BBCODE_LIMIT_REACHED']), basename($directory));
		}
	}

	private function components(): array
	{
		return ['core', 'acpcleanup', 'acpimport', 'exif', 'imagefields', 'imagerevisions', 'tiff'];
	}

	private function php_files(string $directory): array
	{
		$files = array_map('basename', glob($directory . '/*.php') ?: []);
		sort($files);

		return $files;
	}

	private function language_directories(string $language_root): array
	{
		$directories = glob($language_root . '/*', GLOB_ONLYDIR) ?: [];
		sort($directories);

		return $directories;
	}

	private function load_language(string $file): array
	{
		$lang = [];
		// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredVariables.NotAllowed -- Legacy language strings interpolate this phpBB variable.
		$phpEx = 'php';
		include $file;

		return $lang;
	}

	private function catalogs(): array
	{
		$catalogs = [];

		foreach ($this->components() as $component)
		{
			$language_root = $this->extension_root . '/' . $component . '/language';
			foreach ($this->language_directories($language_root) as $directory)
			{
				$locale = basename($directory);
				if ($locale === 'en')
				{
					continue;
				}

				foreach ($this->php_files($language_root . '/en') as $file)
				{
					$catalogs[] = [
						'name' => $component . '/' . $locale . '/' . $file,
						'english' => $this->load_language($language_root . '/en/' . $file),
						'translated' => $this->load_language($directory . '/' . $file),
					];
				}
			}
		}

		return $catalogs;
	}

	private function placeholder_shape($value): array
	{
		if (is_array($value))
		{
			$shape = [];
			foreach ($value as $key => $item)
			{
				$shape[$key] = $this->placeholder_shape($item);
			}

			return $shape;
		}

		preg_match_all('/(?<!%)%(?!%)(?:\d+\$)?([bcdeEfFgGosuxXdi])/', (string) $value, $matches);
		sort($matches[1]);

		return $matches[1];
	}

	private function string_values($value): array
	{
		if (!is_array($value))
		{
			return [(string) $value];
		}

		$values = [];
		array_walk_recursive($value, function ($item) use (&$values): void
		{
			$values[] = (string) $item;
		});

		return $values;
	}
}
