<?php
/**
 * Gallery BBTags autocomplete controller.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge\controller;

use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\request\request_interface;
use phpbb\user;
use phpbbgallery\bbtagsbridge\album_scope_resolver;
use phpbbgallery\bbtagsbridge\image_tag_manager;
use sitesplat\bbtags\tags\manager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class tag_controller
{
	private auth $auth;
	private config $config;
	private helper $helper;
	private request_interface $request;
	private user $user;
	private \phpbbgallery\core\auth\auth $gallery_auth;
	private album_scope_resolver $scopes;
	private manager $tags;

	public function __construct(
		auth $auth,
		config $config,
		helper $helper,
		request_interface $request,
		user $user,
		\phpbbgallery\core\auth\auth $gallery_auth,
		album_scope_resolver $scopes,
		manager $tags
	)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->helper = $helper;
		$this->request = $request;
		$this->user = $user;
		$this->gallery_auth = $gallery_auth;
		$this->scopes = $scopes;
		$this->tags = $tags;
	}

	public function autocomplete(): Response
	{
		if (!$this->request->is_ajax()
			|| !$this->auth->acl_get('u_search')
			|| !$this->auth->acl_get('u_bbtags_read')
			|| empty($this->config['load_search']))
		{
			return $this->helper->error('NOT_AUTHORISED', 403);
		}

		$this->gallery_auth->load_user_permissions((int) $this->user->data['user_id']);
		$viewable = array_values(array_unique(array_filter(array_map(
			'intval',
			(array) $this->gallery_auth->acl_album_ids('i_view')
		))));
		$paths = array_intersect_key($this->scopes->get_all_paths(), array_flip($viewable));
		$matches = $this->tags->get_provider_tags(
			$this->request->variable('term', '', true),
			20,
			image_tag_manager::PROVIDER,
			$paths
		);

		return new JsonResponse($matches);
	}
}
