<?php
/**
 *
 * Topic Index Bridge. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kasimi\topicindexbridge\core;

use phpbb\cache\service as cache;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\event\data;
use phpbb\extension\manager;
use phpbb\path_helper;
use Symfony\Component\DependencyInjection\ContainerInterface;

class bridge_manager
{
	protected $config;
	protected $extension_manager;
	protected $cache;
	protected $path_helper;
	protected $helper;
	protected $container;
	protected $qte;
	protected $bbprefix;
	protected $bbemoji;
	protected $topic_image_preview;

	protected $modules = [
		'foruminfo' => ['dependency' => '', 'legacy' => 'kasimi/topicindexforuminfo'],
		'qte' => ['dependency' => 'ernadoo/qte', 'legacy' => ''],
		'bbprefix' => ['dependency' => 'sitesplat/bbprefix', 'legacy' => 'kasimi/topicindexattributes'],
		'bbemoji' => ['dependency' => 'sitesplat/bbemoji', 'legacy' => 'kasimi/topicindexattributes'],
		'topicimagepreview' => ['dependency' => 'vse/topicimagepreview', 'legacy' => 'kasimi/topicindextopicimagepreview'],
		'usertopics' => ['dependency' => '', 'legacy' => 'kasimi/topicindexusertopics'],
	];

	public function __construct(
		config $config,
		manager $extension_manager,
		cache $cache,
		path_helper $path_helper,
		helper $helper,
		ContainerInterface $container
	)
	{
		$this->config = $config;
		$this->extension_manager = $extension_manager;
		$this->cache = $cache;
		$this->path_helper = $path_helper;
		$this->helper = $helper;
		$this->container = $container;
	}

	public function get_modules()
	{
		$result = [];
		foreach ($this->modules as $name => $definition)
		{
			$result[$name] = [
				'name' => $name,
				'config' => 'topicindex_bridge_' . $name,
				'available' => $this->is_available($name),
				'legacy' => $this->is_legacy_enabled($name),
				'enabled' => !empty($this->config['topicindex_bridge_' . $name]),
				'effective' => $this->is_effective($name),
			];
		}

		return $result;
	}

	public function is_effective($name)
	{
		return isset($this->modules[$name])
			&& !empty($this->config['topicindex_bridge_' . $name])
			&& $this->is_available($name)
			&& !$this->is_legacy_enabled($name);
	}

	public function add_qte_fields(array $sql_array)
	{
		if ($this->is_effective('foruminfo'))
		{
			$sql_array['SELECT'] .= ', f.forum_name, f.forum_image';
			$sql_array['LEFT_JOIN'][] = [
				'FROM' => [FORUMS_TABLE => 'f'],
				'ON' => 'f.forum_id = t.forum_id',
			];
		}
		if ($this->is_effective('qte'))
		{
			$sql_array['SELECT'] .= ', t.topic_attr_id, t.topic_attr_user, t.topic_attr_time';
		}

		return $sql_array;
	}

	public function enrich(array $topics)
	{
		$forum_info_enabled = $this->is_effective('foruminfo');
		$qte_enabled = $this->is_effective('qte');
		$prefix_enabled = $this->is_effective('bbprefix');
		$emoji_enabled = $this->is_effective('bbemoji');
		$image_preview_enabled = $this->is_effective('topicimagepreview');

		if ($qte_enabled && !empty($topics))
		{
			$this->qte = $this->get_optional_service('qte');
			$this->qte->get_users_by_topic_id(array_column($topics, 'id'));
		}
		if ($image_preview_enabled && !empty($topics))
		{
			$this->topic_image_preview = $this->get_optional_service('topicimagepreview');
			$topics = $this->enrich_images($topics);
		}
		if ($prefix_enabled)
		{
			$this->bbprefix = $this->get_optional_service('bbprefix');
		}
		if ($emoji_enabled)
		{
			$this->bbemoji = $this->get_optional_service('bbemoji');
		}

		$icons = $forum_info_enabled ? $this->cache->obtain_icons() : [];
		foreach ($topics as &$topic)
		{
			if ($forum_info_enabled)
			{
				$icon = !empty($icons[$topic['icon_id']]) ? $icons[$topic['icon_id']] : [];
				$topic['bridge_forum_name'] = $topic['forum_name'];
				$topic['bridge_forum_url'] = append_sid($this->path_helper->get_phpbb_root_path() . 'viewforum.' . $this->path_helper->get_php_ext(), ['f' => $topic['forum_id']]);
				$topic['bridge_forum_image'] = $this->normalise_image_url($topic['forum_image']);
				$topic['bridge_icon'] = is_array($icon) ? $icon : [];
			}
			if ($qte_enabled && !empty($topic['topic_attr_id']))
			{
				$topic['bridge_qte'] = $this->qte->attr_display($topic['topic_attr_id'], $topic['topic_attr_user'], $topic['topic_attr_time']);
			}
			if ($prefix_enabled)
			{
				$topic['bridge_prefix'] = $this->bbprefix->load_prefixes_topic($topic['id'], '', true, $topic['forum_id']);
			}
			if ($emoji_enabled)
			{
				$topic['title'] = $this->bbemoji->render($this->bbemoji->parse($topic['title']));
			}
		}
		unset($topic);

		return $topics;
	}

	public function template_vars(array $topic, array $template_vars)
	{
		if (isset($topic['bridge_forum_name']))
		{
			$icon = $topic['bridge_icon'];
			$template_vars += [
				'BRIDGE_FORUM_NAME' => $topic['bridge_forum_name'],
				'BRIDGE_FORUM_URL' => $topic['bridge_forum_url'],
				'BRIDGE_FORUM_IMAGE' => $topic['bridge_forum_image'],
				'BRIDGE_TOPIC_ICON_IMG' => isset($icon['img']) ? $icon['img'] : '',
				'BRIDGE_TOPIC_ICON_ALT' => isset($icon['alt']) ? $icon['alt'] : '',
				'BRIDGE_TOPIC_ICON_WIDTH' => isset($icon['width']) ? (int) $icon['width'] : 0,
				'BRIDGE_TOPIC_ICON_HEIGHT' => isset($icon['height']) ? (int) $icon['height'] : 0,
			];
		}
		$template_vars['BRIDGE_QTE'] = isset($topic['bridge_qte']) ? $topic['bridge_qte'] : '';
		$template_vars['BRIDGE_PREFIX'] = isset($topic['bridge_prefix']) ? $topic['bridge_prefix'] : '';
		$template_vars['BRIDGE_IMAGES'] = isset($topic['bridge_images']) ? $topic['bridge_images'] : [];

		return $template_vars;
	}

	protected function enrich_images(array $topics)
	{
		$rowset = [];
		foreach ($topics as $topic)
		{
			$rowset[$topic['id']] = [
				'topic_first_post_id' => $topic['topic_first_post_id'],
				'forum_id' => $topic['forum_id'],
			];
		}
		$enriched_rowset = [];
		foreach (array_chunk(array_keys($rowset), 100) as $topic_ids)
		{
			$chunk = array_intersect_key($rowset, array_flip($topic_ids));
			$preview_event = new data(['topic_list' => $topic_ids, 'rowset' => $chunk]);
			$this->topic_image_preview->viewforum_row($preview_event);
			$enriched_rowset += $preview_event['rowset'];
		}
		$rowset = $enriched_rowset;
		foreach ($topics as &$topic)
		{
			if (empty($rowset[$topic['id']]['post_text']))
			{
				continue;
			}
			$topic_event = new data([
				'row' => $rowset[$topic['id']],
				'topic_row' => [],
			]);
			$this->topic_image_preview->viewforum_tpl($topic_event);
			$images = isset($topic_event['topic_row']['TOPIC_IMAGES']) ? $topic_event['topic_row']['TOPIC_IMAGES'] : [];
			foreach ((array) $images as $image_id)
			{
				$image_id = (int) $image_id;
				if ($image_id)
				{
					$topic['bridge_images'][] = [
						'MINI' => $this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => $image_id]),
						'SOURCE' => $this->helper->route('phpbbgallery_core_image_file_source', ['image_id' => $image_id]),
						'MIN_SIZE' => (int) $topic_event['topic_row']['TOPIC_IMAGES_SIZE_MIN'],
						'MAX_SIZE' => (int) $topic_event['topic_row']['TOPIC_IMAGES_SIZE_MAX'],
					];
				}
			}
		}
		unset($topic);

		return $topics;
	}

	protected function is_available($name)
	{
		if (!$this->extension_manager->is_enabled('dmzx/topicindex'))
		{
			return false;
		}
		$dependency = $this->modules[$name]['dependency'];
		if ($dependency && !$this->extension_manager->is_enabled($dependency))
		{
			return false;
		}
		switch ($name)
		{
			case 'qte':
				return $this->container->has('ernadoo.qte');
			case 'bbprefix':
				return $this->container->has('bbprefix.manager');
			case 'bbemoji':
				return $this->container->has('sitesplat.bbemoji.listener');
			case 'topicimagepreview':
				return $this->container->has('vse.topicimagepreview.preview') && $this->extension_manager->is_enabled('phpbbgallery/core');
			default:
				return true;
		}
	}

	protected function get_optional_service($name)
	{
		$service_ids = [
			'qte' => 'ernadoo.qte',
			'bbprefix' => 'bbprefix.manager',
			'bbemoji' => 'sitesplat.bbemoji.listener',
			'topicimagepreview' => 'vse.topicimagepreview.preview',
		];

		return $this->container->get($service_ids[$name]);
	}

	protected function is_legacy_enabled($name)
	{
		return $this->modules[$name]['legacy'] !== '' && $this->extension_manager->is_enabled($this->modules[$name]['legacy']);
	}

	protected function normalise_image_url($url)
	{
		$url = trim((string) $url);
		if ($url === '' || preg_match('#^(?:https?:)?//#i', $url))
		{
			return $url;
		}

		return $this->path_helper->update_web_root_path($this->path_helper->get_phpbb_root_path() . ltrim($url, '/'));
	}
}
