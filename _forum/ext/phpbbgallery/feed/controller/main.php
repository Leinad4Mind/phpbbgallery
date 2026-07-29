<?php
/**
 * phpBB Gallery - Feed Extension
 *
 * @package   phpbbgallery/feed
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\feed\controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Publishes the gallery as an ATOM 1.0 feed.
 */
class main
{
	/* @var \phpbb\config\config */
	protected \phpbb\config\config $config;

	/* @var \phpbb\controller\helper */
	protected \phpbb\controller\helper $helper;

	/* @var \phpbb\language\language */
	protected \phpbb\language\language $language;

	/* @var \phpbb\template\twig\environment */
	protected \phpbb\template\twig\environment $twig;

	/* @var \phpbb\user */
	protected \phpbb\user $user;

	/* @var \phpbbgallery\core\auth\auth */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/* @var \phpbbgallery\feed\feed */
	protected \phpbbgallery\feed\feed $feed;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config              $config       Config object
	 * @param \phpbb\controller\helper          $helper       Controller helper object
	 * @param \phpbb\language\language          $language     Language object
	 * @param \phpbb\template\twig\environment   $twig         Twig environment
	 * @param \phpbb\user                       $user         User object
	 * @param \phpbbgallery\core\auth\auth      $gallery_auth Gallery auth object
	 * @param \phpbbgallery\feed\feed           $feed         Gallery feed object
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\language\language $language,
		\phpbb\template\twig\environment $twig, \phpbb\user $user, \phpbbgallery\core\auth\auth $gallery_auth, \phpbbgallery\feed\feed $feed)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->language = $language;
		$this->twig = $twig;
		$this->user = $user;
		$this->gallery_auth = $gallery_auth;
		$this->feed = $feed;
	}

	/**
	 * Feed of the newest images across the whole gallery.
	 *
	 * @return Response
	 */
	public function base(): Response
	{
		$this->setup();

		return $this->render(
			$this->feed->get_images(),
			$this->language->lang('GALLERY'),
			$this->absolute_route('phpbbgallery_feed')
		);
	}

	/**
	 * Feed of the newest images of a single album.
	 *
	 * @param int $album_id Album to publish
	 * @return Response
	 */
	public function album(int $album_id): Response
	{
		$this->setup();

		$album_data = $this->feed->get_publishable_album($album_id);

		if ($album_data === false)
		{
			throw new \phpbb\exception\http_exception(Response::HTTP_FORBIDDEN, 'NO_FEED');
		}

		return $this->render(
			$this->feed->get_images($album_id),
			$album_data['album_name'],
			$this->absolute_route('phpbbgallery_feed_album', ['album_id' => $album_id])
		);
	}

	/**
	 * Load the gallery permissions and language needed by every feed.
	 *
	 * @return void
	 */
	protected function setup(): void
	{
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$this->language->add_lang(['info_feed'], 'phpbbgallery/feed');

		if (!$this->feed->is_enabled())
		{
			throw new \phpbb\exception\http_exception(Response::HTTP_FORBIDDEN, 'NO_FEED_ENABLED');
		}

		$this->gallery_auth->load_user_permissions((int) $this->user->data['user_id']);
	}

	/**
	 * Build an absolute URL for a route.
	 *
	 * @param string $route  Route name
	 * @param array  $params Route parameters
	 * @return string
	 */
	protected function absolute_route(string $route, array $params = []): string
	{
		return $this->helper->route($route, $params, true, '', UrlGeneratorInterface::ABSOLUTE_URL);
	}

	/**
	 * Render the image rows as an ATOM document.
	 *
	 * @param array  $rowset    Image rows, newest first
	 * @param string $title     Feed title
	 * @param string $self_link Absolute URL of the feed itself
	 * @return Response
	 */
	protected function render(array $rowset, string $title, string $self_link): Response
	{
		$entries = [];
		$updated_time = 0;

		foreach ($rowset as $row)
		{
			$image_id = (int) $row['image_id'];
			$album_id = (int) $row['image_album_id'];
			$image_time = (int) $row['image_time'];
			$updated_time = max($updated_time, $image_time);

			$entries[] = [
				'title'			=> censor_text($row['image_name']),
				'album_name'	=> censor_text((string) $row['album_name']),
				'author'		=> $this->get_author($row),
				'updated'		=> gmdate(DATE_ATOM, $image_time),
				'description'	=> $this->get_description($row),
				'link'			=> $this->absolute_route('phpbbgallery_core_image', ['image_id' => $image_id]),
				'album_link'	=> $this->absolute_route('phpbbgallery_core_album', ['album_id' => $album_id]),
				'thumbnail'		=> $this->absolute_route('phpbbgallery_core_image_file_mini', ['image_id' => $image_id]),
				'medium'		=> $this->absolute_route('phpbbgallery_core_image_file_medium', ['image_id' => $image_id]),
			];
		}

		// Sending the current time beats sending no time at all.
		if (!$updated_time)
		{
			$updated_time = time();
		}

		$content = $this->twig->render('@phpbbgallery_feed/feed_body.html', [
			'FEED_TITLE'	=> censor_text($title),
			'FEED_SUBTITLE'	=> $this->config['site_desc'],
			'FEED_AUTHOR'	=> $this->config['sitename'],
			'FEED_LANG'		=> $this->user->lang['USER_LANG'],
			'FEED_UPDATED'	=> gmdate(DATE_ATOM, $updated_time),
			'FEED_LINK'		=> generate_board_url(),
			'SELF_LINK'		=> $self_link,
			'FEED_ROWS'		=> $entries,
		]);

		$response = new Response($content);
		$response->headers->set('Content-Type', 'application/atom+xml; charset=UTF-8');
		$response->setLastModified(new \DateTime('@' . $updated_time));

		return $response;
	}

	/**
	 * Whether the feed viewer must be denied private contest data.
	 *
	 * @param array $row Image and album row
	 * @return bool
	 */
	protected function hides_contest_private_data(array $row): bool
	{
		$can_moderate = $this->gallery_auth->acl_check(
			'm_status',
			(int) $row['image_album_id'],
			(int) $row['album_user_id']
		);

		return \phpbbgallery\core\contest::hides_private_data(
			$row,
			(int) $this->user->data['user_id'],
			$can_moderate
		);
	}

	/**
	 * Author line for an entry, keeping contest entries anonymous.
	 *
	 * @param array $row Image row
	 * @return string
	 */
	protected function get_author(array $row): string
	{
		if ($this->hides_contest_private_data($row))
		{
			return $this->language->lang('CONTEST_USERNAME');
		}

		return (string) $row['image_username'];
	}

	/**
	 * Plain-text description of an entry.
	 *
	 * @param array $row Image row
	 * @return string
	 */
	protected function get_description(array $row): string
	{
		if ($this->hides_contest_private_data($row))
		{
			$contest_end_time = (int) ($row['contest_start'] ?? 0) + (int) ($row['contest_end'] ?? 0);

			return $this->language->lang(
				'CONTEST_IMAGE_DESC',
				$this->user->format_date($contest_end_time, false, true)
			);
		}

		$description = (string) $row['image_desc'];

		if (!empty($row['image_desc_uid']))
		{
			// Keep list items readable once the BBCode markers are gone.
			$description = str_replace('[*:' . $row['image_desc_uid'] . ']', '* ', $description);
			strip_bbcode($description, $row['image_desc_uid']);
		}

		return censor_text($description);
	}
}
