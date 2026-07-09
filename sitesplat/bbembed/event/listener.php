<?php

/**
* @package   BBembed
* @copyright Copyright (c) 2015 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
* @copyright (c) 2016 SiteSplat All rights reserved
*/
namespace sitesplat\bbembed\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use s9e\TextFormatter\Bundles\MediaPack;

class listener implements EventSubscriberInterface
{
	protected $hostRegexp = '(facebook|plus\\.google|medium|soundcloud|twit(?:ch|ter)|vimeo|youtu)Si';
	protected $inAcp      = false;
	protected $isDisabled = false;
	protected $tagExpr    = '(?:FACEBOOK|GOOGLEPLUS|MEDIUM|SOUNDCLOUD|TWIT(?:CH|TER)|VIMEO|YOUTUBE)';
	protected $tagNames   = array('FACEBOOK', 'GOOGLEPLUS', 'MEDIUM', 'SOUNDCLOUD', 'TWITCH', 'TWITTER', 'VIMEO', 'YOUTUBE');

	public static function getSubscribedEvents()
	{
		return array(
			'core.acp_manage_forums_request_data'     => 'onAcpManageForums',
			'core.acp_manage_forums_initialise_data'  => 'onAcpManageForums',
			'core.message_parser_check_message'       => 'onCheckMessage',
			'core.modify_format_display_text_after'   => 'onPreview',
//			'core.modify_format_display_text_before'  => 'onPreviewSetup',
			'core.modify_text_for_display_after'      => 'onDisplay',
			'core.modify_text_for_edit_before'        => 'onEdit',
			'core.posting_modify_submit_post_before'  => 'onSubmit',
			'core.submit_pm_before'                   => 'onPmStorage',
			'core.text_formatter_s9e_configure_after' => 'onConfigure',
			'core.text_formatter_s9e_parse_after'     => 'onParseCompleted',
			'core.text_formatter_s9e_parse_before'    => 'onParse',
			'core.text_formatter_s9e_render_before'   => 'onRender',
			'core.ucp_display_module_before'          => 'onUcpDisplay',
			'core.viewtopic_modify_post_data'         => 'onViewtopic'
		);
	}

	public function onAcpManageForums($event)
	{
		$this->inAcp = true;
	}

	public function onCheckMessage($event)
	{
		$this->isDisabled = ($this->inAcp || $event['mode'] !== 'post');
	}

	public function onConfigure($event)
	{
		$configurator = $event['configurator'];
		
		if (!isset($configurator->MediaEmbed->defaultSites['twitch']) || !defined('PHPBB_VERSION') || version_compare(PHPBB_VERSION, '3.3.3', '<'))
		{
			$configurator->MediaEmbed->defaultSites['twitch'] = ['attributes'=>[],'example'=>['https://www.twitch.tv/twitch','https://www.twitch.tv/twitch/v/29415830?t=17m17s','https://www.twitch.tv/videos/29415830?t=17m17s','https://clips.twitch.tv/twitch/HorribleWoodpeckerHassanChop','https://clips.twitch.tv/NeighborlyBetterJellyfishWTRuck'],'extract'=>['#twitch\\.tv/(?:videos|\\w+/v)/(?\'video_id\'\\d+)?#','#www\\.twitch\\.tv/(?!videos/)(?\'channel\'\\w+)(?:/clip/(?\'clip_id\'\\w+))?#','#t=(?\'t\'(?:(?:\\d+h)?\\d+m)?\\d+s)#','#clips\\.twitch\\.tv/(?:(?\'channel\'\\w+)/)?(?\'clip_id\'\\w+)#'],'homepage'=>'https://www.twitch.tv/','host'=>['twitch.tv'],'iframe'=>['onload'=>'contentWindow.postMessage(\'\',\'https://s9e.github.io\')','src'=>'https://s9e.github.io/iframe/2/twitch.min.html#channel={@channel};clip_id={@clip_id};t={@t};video_id={@video_id}'],'name'=>'Twitch','scrape'=>[],'source'=>'https://dev.twitch.tv/docs/embed/video-and-clips','tags'=>['gaming','livestreaming']];
		}
		
		foreach ($this->tagNames as $tagName)
		{
			$siteId = strtolower($tagName);
			unset($configurator->tags[$tagName]);
			$configurator->MediaEmbed->add($siteId);

			$tag = $configurator->tags[$tagName];
			$tag->template = str_replace(' scrolling="no"', '', $tag->template);
			$tag->template = $this->addTemplateEffects($tag->template);
		}
	}

	protected function addTemplateEffects($template)
	{
		if (substr($template, 0, 4) !== '<div' && preg_match('(max-width:(\\d+px))', $template, $m))
		{
			$template = '<div style="display:inline-block;position:relative;width:100%;max-width:' . $m[1] . '">' . $template . '</div>';
		}

		$template = str_replace('<iframe', '<span class="spinner"></span><iframe', $template);
		if (strpos($template, 'onload="') === false)
		{
			$template = str_replace('<iframe', '<iframe onload=""', $template);
		}
		$template = str_replace('onload="', 'onload="if(previousSibling)parentNode.removeChild(previousSibling);', $template);

		if (strpos($template, 'style.height') !== false)
		{
			$template = str_replace('border:0', 'transition:height .3s;border:0', $template);
		}

		return $template;
	}

	public function onDisplay($event)
	{
		$event['text'] = $this->render($event['text']);
	}

	public function onEdit($event)
	{
		$event['text'] = $this->unparse($event['text']);
	}

	public function onParse($event)
	{
		$parser     = $event['parser']->get_parser();
		$methodName = ($this->inAcp || $this->isDisabled) ? 'disableTag' : 'enableTag';
		foreach ($this->tagNames as $tagName)
		{
			$parser->$methodName($tagName);
		}
	}

	public function onParseCompleted($event)
	{
		if ($this->inAcp || $this->isDisabled)
		{
			$event['parser']->get_parser()->getLogger()->clear();
		}
	}

	public function onPmStorage($event)
	{
		$data = $event['data'];
		$data['message'] = $this->parse($data['message']);
		$event['data'] = $data;
	}

	public function onPreview($event)
	{
		if (!$event['update_this_message'])
		{
			$event['text'] = $this->render($this->parse($event['text']));
		}
	}

	public function onPreviewSetup($event)
	{
		if ($event['update_this_message'] && preg_match('(^<[rt][ />])', $event['text']))
		{
			$event['text'] = preg_replace(
				'(</?' . $this->tagExpr . '(?=[ />])[^>]*>)',
				'',
				$event['text']
			);
		}
	}

	public function onRender($event)
	{
		if ($event['xml'][1] !== 'r' || strpos($event['xml'], 'content="') === false)
		{
			return;
		}

		// Fix custom BBCodes
		$event['xml'] = preg_replace(
			'(<' . $this->tagExpr . ' content="([^"]*))',
			'$0" id="$1',
			$event['xml']
		);
	}

	public function onSubmit($event)
	{
		$data = $event['data'];
		$data['message'] = $this->parse($data['message']);
		$event['data'] = $data;
	}

	public function onUcpDisplay($event)
	{
		if ($event['id'] === 'ucp_profile' && $event['mode'] === 'signature')
		{
			$this->isDisabled = true;
		}
	}

	public function onViewtopic($event)
	{
		$rowset = $event['rowset'];
		foreach ($rowset as &$row)
		{
			if (strpos($row['post_text'], '<!-- sitesplat:bbembed:') === false)
			{
				$row['post_text'] = $this->parse($row['post_text']);
			}
			if ($this->hasAutolinks($row['post_text']))
			{
				$row['post_text'] = $this->convertLinks($row['post_text']);
			}
		}
		$event['rowset'] = $rowset;
	}

	protected function convertLinks($xml)
	{
		return preg_replace_callback(
			'(<URL[^>]*? url="([^"]+)"[^>]*>(?:\\w+://|<LINK_TEXT).*?</URL>(</\\w+)?)',
			array($this, 'convertLinksCallback'),
			$xml
		);
	}

	protected function convertLinksCallback($m)
	{
		$originalXml = $m[0];
		$url         = $m[1];
		$endTagXml   = isset($m[2]) ? $m[2] : '';
		$endTagName  = substr($endTagXml, 2);

		if (preg_match($this->hostRegexp, $url) && !in_array($endTagName, $this->tagNames, true))
		{
			$xml = MediaPack::parse($url);
			if ($xml[1] === 'r')
			{
				$regexp = '(^<r[^>]*>(<' . $this->tagExpr . ' [^>]+>.*?)</r>$)';
				if (preg_match($regexp, $xml, $m))
				{
					return $m[1] . $endTagXml;
				}
			}
		}

		return $originalXml;
	}

	protected function decodeAttributes($str)
	{
		return unserialize(base64_decode($str));
	}

	protected function encodeAttributes(array $attributes)
	{
		return base64_encode(serialize($attributes));
	}

	protected function encodeTag($siteId, array $attributes)
	{
		return '<!-- sitesplat:bbembed:' . $siteId . ':' . $this->encodeAttributes($attributes) . ' -->';
	}

	protected function extractAttributes($url, $regexp)
	{
		$attributes = array();
		if (preg_match($regexp, $url, $m))
		{
			foreach ($m as $k => $v)
			{
				if (!is_numeric($k) && $v !== '')
				{
					$attributes[$k] = $v;
				}
			}
		}

		return $attributes;
	}

	protected function hasAutolinks($xml)
	{
		if (strpos($xml, '<URL') === false)
		{
			return false;
		}

		return (bool) preg_match('(<URL [^>]++>(?:https?://|<LINK_TEXT))i', $xml);
	}

	protected function matchUrl($url)
	{
		$regexps = array(
			'facebook' => array(
				"@/(?!(?:apps|developers|graph)\\.)[-\\w.]*facebook\\.com/(?:[/\\w]+/permalink|(?!pages/|groups/).*?)(?:/|fbid=|\\?v=)(?<id>\\d+)(?![^/?&#])@",
				'#/(?<type>video)s?/#'
			),
			'googleplus' => array(
				'!//plus\\.google\\.com/(?:u/\\d+/)?(?:\\+(?<name>[^/]+)|(?<oid>\\d+))/posts/(?<pid>\\w+)!'
			),
			'medium' => array(
				"!medium\\.com/[^/]*/(?:[-\\w]+-)?(?'id'[\\da-f]+)!"
			),
			'soundcloud' => array(
				'@(?<id>https?://(?:api\\.)?soundcloud\\.com/(?!pages/)[-/\\w]+/[-/\\w]+|^[^/]+/[^/]+$)@',
				'@api\\.soundcloud\\.com/playlists/(?<playlist_id>\\d+)@',
				'@api\\.soundcloud\\.com/tracks/(?<track_id>\\d+)(?:\\?secret_token=(?<secret_token>[-\\w]+))?@',
				'@soundcloud\\.com/(?!playlists|tracks)[-\\w]+/[-\\w]+/(?=s-)(?<secret_token>[-\\w]+)@'
			),
			'twitch' => array(
				"#twitch\\.tv/(?<channel>(?!m/)\\w+)(?:/b/(?<archive_id>\\d+)|/c/(?<chapter_id>\\d+)|/v/(?<video_id>\\d+))?#"
			),
			'twitter' => array(
				"@twitter\\.com/(?:#!/)?\\w+/status(?:es)?/(?<id>\\d+)@",
			),
			'vimeo' => array(
				'!vimeo\\.com/(?:channels/[^/]+/|video/)?(?<id>\\d+)!',
			),
			'youtube' => array(
				"!youtube\\.com/(?:watch.*?v=|v/)(?<id>[-\\w]+)!",
				"!youtu\\.be/(?<id>[-\\w]+)!"
			)
		);

		foreach ($regexps as $siteId => $siteRegexps)
		{
			$attributes = array();
			foreach ($siteRegexps as $regexp)
			{
				$attributes += $this->extractAttributes($url, $regexp);
			}

			if (!empty($attributes))
			{
				return array('siteId' => $siteId, 'attributes' => $attributes);
			}
		}

		return false;
	}

	protected function parse($text)
	{
		if ($this->isDisabled || strpos($text, '<!-- m -->') === false)
		{
			return $text;
		}

		return preg_replace_callback(
			'(<!-- m -->.*?href="([^"]*).*?<!-- m -->)',
			array($this, 'parseCallback'),
			$text
		);
	}

	protected function parseCallback(array $m)
	{
		$match = $this->matchUrl($m[1]);
		if ($match === false)
		{
			return $m[0];
		}

		return $this->encodeTag($match['siteId'], $match['attributes']) . $m[0];
	}

	protected function render($text)
	{
		if (strpos($text, '<!-- m') === false)
		{
			return $text;
		}

		$text = $this->replaceTwitter($text);

		return preg_replace_callback(
			'(<!-- sitesplat:bbembed:(\\w+):(.*?) --><!-- m -->.*?<!-- m -->)',
			array($this, 'renderCallback'),
			$text
		);
	}

	protected function renderCallback(array $m)
	{
		$methodName = 'render' . ucfirst($m[1]);
		if (is_callable(array($this, $methodName)))
		{
			return $this->$methodName($this->decodeAttributes($m[2]));
		}

		return $m[0];
	}

	protected function renderFacebook(array $attributes)
	{
		$attributes += array('id' => null, 'type' => null);

		return $this->addTemplateEffects('<iframe data-sitesplat-mediaembed="facebook" allowfullscreen="" onload="var a=Math.random();window.addEventListener(\'message\',function(b){if(b.data.id==a)style.height=b.data.height+\'px\'});contentWindow.postMessage(\'s9e:\'+a,\'https://s9e.github.io\')" src="https://s9e.github.io/iframe/facebook.min.html#' . htmlspecialchars($attributes['type'] . $attributes['id'], 2) . '" style="border:0;height:360px;max-width:640px;width:100%"></iframe>');
	}
// todo remove this RIP g+
	protected function renderGoogleplus(array $attributes)
	{
		$attributes += array('name' => null, 'oid' => null, 'pid' => null);

		$html = '<iframe data-sitesplat-mediaembed="googleplus" allowfullscreen="" onload="var a=Math.random();window.addEventListener(\'message\',function(b){if(b.data.id==a)style.height=b.data.height+\'px\'});contentWindow.postMessage(\'s9e:\'+a,\'https://s9e.github.io\')" style="border:0;height:240px;max-width:450px;width:100%" src="https://s9e.github.io/iframe/googleplus.min.html#';
		if (isset($attributes['oid']))
		{
			$html .= htmlspecialchars($attributes['oid'], 2);
		}
		else
		{
			$html .= '+' . htmlspecialchars($attributes['name'], 2);
		}
		$html .= '/posts/' . htmlspecialchars($attributes['pid'], 2) . '"></iframe>';

		return $this->addTemplateEffects($html);
	}

	protected function renderMedium(array $attributes)
	{
		return '<div style="display:inline-block;position:relative;width:100%;max-width:400px"><span class="spinner"></span><iframe allowfullscreen="" onload="if(previousSibling)parentNode.removeChild(previousSibling);window.addEventListener(\'message\',function(a){a=a.data.split(\'::\');\'m\'===a[0]&amp;&amp;0&lt;src.indexOf(a[1])&amp;&amp;a[2]&amp;&amp;(style.height=a[2]+\'px\')})" src="https://api.medium.com/embed?type=story&amp;path=%2F%2F' . htmlspecialchars($attributes['id'],2).'&amp;id=' . htmlspecialchars(strtr($attributes['id'],'abcdef','111111'),2).'" style="border:1px solid;border-color:#eee #ddd #bbb;border-radius:5px;box-shadow:rgba(0,0,0,.15) 0 1px 3px;height:400px;max-width:400px;width:100%"></iframe></div>';
	}

	protected function renderSoundcloud($attributes)
	{
		$attributes += array('id' => null, 'playlist_id' => null, 'secret_token' => null, 'track_id' => null);

		$html = '<iframe data-sitesplat-mediaembed="soundcloud" allowfullscreen="" src="https://w.soundcloud.com/player/?url=';
		if (isset($attributes['playlist_id']))
		{
			$html .= 'https%3A//api.soundcloud.com/playlists/' . htmlspecialchars($attributes['playlist_id'], 2);
		}
		elseif (isset($attributes['track_id']))
		{
			$html .= 'https%3A//api.soundcloud.com/tracks/' . htmlspecialchars($attributes['track_id'], 2) . '&amp;secret_token=' . htmlspecialchars($attributes['secret_token'], 2);
		}
		else
		{
			if ((strpos($attributes['id'], '://') === false))
			{
				$html .=  'https%3A//soundcloud.com/';
			}
			$html .=  htmlspecialchars($attributes['id'], 2);
		}
		$html .=  '" style="border:0;height:';
		if (isset($attributes['playlist_id']) || (strpos($attributes['id'], '/sets/') !== false))
		{
			$html .=  '450';
		}
		else
		{
			$html .=  '166';
		}
		$html .=  'px;max-width:900px;width:100%"></iframe>';

		return $this->addTemplateEffects($html);
	}

	protected function renderTwitch(array $attributes)
	{
		$html = '<div data-sitesplat-mediaembed="twitch" style="display:inline-block;width:100%;max-width:640px"><div style="overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" style="border:0;height:100%;left:0;position:absolute;width:100%" src="//player.twitch.tv/?autoplay=false&amp;';
		if (isset($attributes['archive_id']))
		{
			$html .= 'video=a' . htmlspecialchars($attributes['archive_id'], 2);
		}
		elseif (isset($attributes['chapter_id']))
		{
			$html .= 'video=c' . htmlspecialchars($attributes['chapter_id'], 2);
		}
		elseif (isset($attributes['video_id']))
		{
			$html .= 'video=v' . htmlspecialchars($attributes['video_id'], 2);
		}
		else
		{
			$html .= 'channel=' . htmlspecialchars($attributes['channel'], 2);
		}
		if (isset($attributes['t']))
		{
			$html .= '&amp;time=' . htmlspecialchars($attributes['t'], 2);
		}
		$html .= '"></iframe></div></div>';

		return $this->addTemplateEffects($html);
	}

	protected function renderTwitter(array $attributes)
	{
		return '<div style="display:inline-block;width:100%;max-width:550px"><div style="position:relative"><span class="spinner"></span><iframe allowfullscreen="" onload="var a=Math.random();window.addEventListener(\'message\',function(b){if(b.data.id==a){style.height=b.data.height+\'px\';if(previousSibling)parentNode.removeChild(previousSibling)}});contentWindow.postMessage(\'s9e:\'+a,src.substr(0,src.indexOf(\'/\',8)));setTimeout(function(){if(previousSibling)parentNode.removeChild(previousSibling)},5e3)" src="//s9e.github.io/iframe/twitter.min.html#' . htmlspecialchars($attributes['id']) . '" style="border:0;height:186px;max-width:550px;transition:height .3s;width:100%"></iframe></div></div>';
	}

	protected function renderVimeo(array $attributes)
	{
		return '<div data-sitesplat-mediaembed="vimeo" style="display:inline-block;width:100%;max-width:640px"><div style="overflow:hidden;position:relative;padding-bottom:56.25%"><span class="spinner"></span><iframe allowfullscreen="" onload="parentNode.removeChild(previousSibling)" src="//player.vimeo.com/video/' . htmlspecialchars($attributes['id']) . '" style="border:0;height:100%;left:0;position:absolute;width:100%"></iframe></div></div>';
	}

	protected function renderYoutube(array $attributes)
	{
		return '<div style="background:url(//i.ytimg.com/vi/' . htmlspecialchars($attributes['id']) . '/hqdefault.jpg) no-repeat 50% 50% / cover;display:inline-block;width:100%;max-width:640px"><div style="position:relative;padding-bottom:56.25%"><span class="spinner"></span><iframe allowfullscreen="" onload="parentNode.removeChild(previousSibling)" style="border:0;height:100%;left:0;position:absolute;width:100%" src="//www.youtube.com/embed/' . htmlspecialchars($attributes['id']) . '"></iframe></div></div>';
	}

	protected function replaceTwitter($text)
	{
		if (strpos($text, '<!-- sitesplat:twitter') === false)
		{
			return $text;
		}

		return preg_replace_callback(
			'(<!-- sitesplat:twitter:(\\d+) -->)',
			array($this, 'replaceTwitterCallback'),
			$text
		);
	}

	protected function replaceTwitterCallback(array $m)
	{
		return $this->encodeTag('twitter', array('id' => $m[1]));
	}

	protected function unparse($text)
	{
		if (strpos($text, '<!-- sitesplat:') === false)
		{
			return $text;
		}

		return preg_replace('(<!-- sitesplat:(?:bbembed|twitter):([^ ]+) -->)', '', $text);
	}
}