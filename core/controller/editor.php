<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * JSON controller used by the Gallery selector in phpBB message editors.
 */
class editor
{
	/** @var \phpbb\request\request_interface Request object */
	protected \phpbb\request\request_interface $request;

	/** @var \phpbb\user phpBB user object */
	protected \phpbb\user $user;

	/** @var \phpbb\language\language Language service */
	protected \phpbb\language\language $language;

	/** @var \phpbb\controller\helper Controller helper */
	protected \phpbb\controller\helper $helper;

	/** @var \phpbbgallery\core\image\selector Gallery editor selector */
	protected \phpbbgallery\core\image\selector $selector;

	public function __construct(\phpbb\request\request_interface $request, \phpbb\user $user,
		\phpbb\language\language $language, \phpbb\controller\helper $helper,
		\phpbbgallery\core\image\selector $selector)
	{
		$this->request = $request;
		$this->user = $user;
		$this->language = $language;
		$this->helper = $helper;
		$this->selector = $selector;
	}

	public function images(): JsonResponse
	{
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');

		if (empty($this->user->data['is_registered']) || !empty($this->user->data['is_bot']))
		{
			return $this->response([
				'error' => $this->language->lang('NOT_AUTHORISED'),
			], 403);
		}

		$album_id = max(0, $this->request->variable('album_id', 0));
		$page = max(1, $this->request->variable('page', 1));
		$data = $this->selector->get_page((int) $this->user->data['user_id'], $album_id, $page);
		if (!$data['authorized'])
		{
			return $this->response([
				'error' => $this->language->lang('NOT_AUTHORISED'),
			], 403);
		}

		foreach ($data['images'] as &$image)
		{
			$image['thumbnail_url'] = $this->helper->route('phpbbgallery_core_image_file_mini', [
				'image_id' => $image['image_id'],
			], false);
			$image['view_url'] = $this->helper->route('phpbbgallery_core_image', [
				'image_id' => $image['image_id'],
			], false);
		}
		unset($image);

		return $this->response($data);
	}

	private function response(array $data, int $status = 200): JsonResponse
	{
		$response = new JsonResponse($data, $status);
		$response->headers->set('Cache-Control', 'private, no-store');
		$response->headers->set('X-Content-Type-Options', 'nosniff');

		return $response;
	}
}
