<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core;

/**
 * Adds route-aware page-jump metadata to phpBB pagination.
 */
class pagination extends \phpbb\pagination
{
	private const JUMP_TOKEN = 'PHPBBGALLERYPAGE';
	private const SENTINEL_PAGE = 987654321;

	/**
	 * {@inheritdoc}
	 */
	public function generate_template_pagination($base_url, $block_var_name, $start_name, $num_items, $per_page, $start = 1, $reverse_count = false, $ignore_on_page = false)
	{
		parent::generate_template_pagination($base_url, $block_var_name, $start_name, $num_items, $per_page, $start, $reverse_count, $ignore_on_page);
		if (empty($base_url))
		{
			return;
		}

		$per_page = max(1, (int) $per_page);
		$total_pages = (int) ceil((int) $num_items / $per_page);
		$route_uses_pages = !is_string($base_url);
		$generated_value = $route_uses_pages ? self::SENTINEL_PAGE : (self::SENTINEL_PAGE - 1) * $per_page;
		$jump_url = '';

		if ($total_pages > 6)
		{
			$generated_url = $this->generate_page_link($base_url, self::SENTINEL_PAGE, $start_name, $per_page);
			$position = strpos($generated_url, (string) $generated_value);
			if ($position !== false)
			{
				$jump_url = substr_replace($generated_url, self::JUMP_TOKEN, $position, strlen((string) $generated_value));
			}
		}

		$this->assign_jump_vars($block_var_name, [
			'GALLERY_JUMP_URL' => $jump_url,
			'GALLERY_JUMP_TOKEN' => self::JUMP_TOKEN,
			'GALLERY_JUMP_MODE' => $route_uses_pages ? 'page' : 'offset',
			'GALLERY_JUMP_PER_PAGE' => $per_page,
		]);
	}

	private function assign_jump_vars(string $block_var_name, array $jump_vars): void
	{
		$block_name = '';
		$separator = strrpos($block_var_name, '.');
		if ($separator !== false)
		{
			$block_name = substr($block_var_name, 0, $separator);
			$prefix = strtoupper(substr($block_var_name, $separator + 1));
		}
		else
		{
			$prefix = strtoupper($block_var_name);
		}

		$prefix = $prefix === 'PAGINATION' ? '' : $prefix . '_';
		$template_vars = [];
		foreach ($jump_vars as $name => $value)
		{
			$template_vars[$prefix . $name] = $value;
		}

		if ($block_name !== '')
		{
			$this->template->alter_block_array($block_name, $template_vars, true, 'change');
			return;
		}

		$this->template->assign_vars($template_vars);
	}
}
