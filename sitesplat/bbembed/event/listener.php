<?php

/**
* @package   BBembed
* @copyright Copyright (c) 2015 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
* @copyright (c) 2015 SiteSplat All rights reserved
*/
namespace sitesplat\bbembed\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return array(
			'core.modify_format_display_text_after' => 'onPreview',
			'core.modify_submit_post_data'          => 'onSubmit',
			'core.modify_text_for_display_after'    => 'onDisplay',
			'core.modify_text_for_edit_before'      => 'onEdit',
			'core.modify_text_for_storage_after'    => 'onStorage',
			'core.submit_pm_before'                 => 'onPmStorage'
		);
	}

	public function onDisplay($event)
	{
		$event['text'] = $this->render($event['text']);
	}

	public function onEdit($event)
	{
		$event['text'] = $this->unparse($event['text']);
	}

	public function onPmStorage($event)
	{
		$data = $event['data'];
		$data['message'] = $this->parse($data['message']);
		$event['data'] = $data;
	}

	public function onPreview($event)
	{
		$event['text'] = $this->render($this->parse($event['text']));
	}

	public function onStorage($event)
	{
		$event['text'] = $this->parse($event['text']);
	}

	public function onSubmit($event)
	{
		$data = $event['data'];
		$data['message'] = $this->parse($data['message']);
		$event['data'] = $data;
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

	protected function matchUrl($url)
	{
		$regexps = array(
			'facebook' => array(
				"@(?:m|www)\\.facebook\\.com/(?:[/\\w]+/permalink|(?!pages/|groups/).*?)(?:/|fbid=|\\?v=)(?'id'\\d+)(?![^/?&#])@"
			),
			'twitch' => array(
				"#twitch\\.tv/(?'channel'(?!m/)\\w+)(?:/b/(?'archive_id'\\d+)|/c/(?'chapter_id'\\d+)|/v/(?'video_id'\\d+))?#"
			),
			'twitter' => array(
				"@twitter\\.com/(?:#!/)?\\w+/status(?:es)?/(?'id'\\d+)@",
			),
			'youtube' => array(
				"!youtube\.com/(?:watch.*?v=|v/)(?'id'[-\\w]+)!",
				"!youtu\\.be/(?'id'[-\\w]+)!"
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
		if (strpos($text, '<!-- m -->') === false)
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

		if (strpos($text, '<!-- sitesplat:') === false)
		{
			$text = $this->parse($text);

			if (strpos($text, '<!-- sitesplat:') === false)
			{
				return $text;
			}
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
		return '<div style="display:inline-block;width:100%;max-width:640px"><div style="position:relative"><div class="spinner"></div><iframe allowfullscreen="" onload="var a=Math.random();window.addEventListener(\'message\',function(b){if(b.data.id==a){style.height=b.data.height+\'px\';if(previousSibling)parentNode.removeChild(previousSibling)}});contentWindow.postMessage(\'s9e:\'+a,src.substr(0,src.indexOf(\'/\',8)));setTimeout(function(){if(previousSibling)parentNode.removeChild(previousSibling)},1e4)" scrolling="no" src="//s9e.github.io/iframe/facebook.min.html#' . htmlspecialchars($attributes['id']) . '" style="border:0;height:360px;max-width:640px;transition:height .3s;width:100%"></iframe></div></div>';
	}

	protected function renderTwitch(array $attributes)
	{
		$html = '<div style="display:inline-block;width:100%;max-width:640px"><div style="position:relative;padding-bottom:61.09375%;padding-bottom:calc(56.25% + 30px)"><div class="spinner"></div><iframe allowfullscreen="" onload="setTimeout(function(){parentNode.removeChild(previousSibling)},2e3)" scrolling="no" style="border:0;height:100%;left:0;position:absolute;width:100%" src="//s9e.github.io/iframe/twitch.min.html#channel=' . htmlspecialchars($attributes['channel']);

		if (isset($attributes['archive_id']))
		{
			$html .= '&amp;videoId=a' . htmlspecialchars($attributes['archive_id']);
		}
		elseif (isset($attributes['chapter_id']))
		{
			$html .= '&amp;videoId=c' . htmlspecialchars($attributes['chapter_id']);
		}
		elseif (isset($attributes['video_id']))
		{
			$html .= '&amp;videoId=v' . htmlspecialchars($attributes['video_id']);
		}

		$html .= '"></iframe></div></div>';

		return $html;
	}

	protected function renderTwitter(array $attributes)
	{
		return '<div style="display:inline-block;width:100%;max-width:500px"><div style="position:relative"><div class="spinner"></div><iframe allowfullscreen="" onload="var a=Math.random();window.addEventListener(\'message\',function(b){if(b.data.id==a){style.height=b.data.height+\'px\';if(previousSibling)parentNode.removeChild(previousSibling)}});contentWindow.postMessage(\'s9e:\'+a,src.substr(0,src.indexOf(\'/\',8)));setTimeout(function(){if(previousSibling)parentNode.removeChild(previousSibling)},5e3)" scrolling="no" src="//s9e.github.io/iframe/twitter.min.html#' . htmlspecialchars($attributes['id']) . '" style="border:0;height:186px;max-width:500px;transition:height .3s;width:100%"></iframe></div></div>';
	}

	protected function renderYoutube(array $attributes)
	{
		return '<div style="background:url(//i.ytimg.com/vi/' . htmlspecialchars($attributes['id']) . '/hqdefault.jpg) no-repeat 50% 50% / cover;display:inline-block;width:100%;max-width:640px"><div style="position:relative;padding-bottom:56.25%"><div class="spinner"></div><iframe allowfullscreen="" onload="parentNode.removeChild(previousSibling)" scrolling="no" style="border:0;height:100%;left:0;position:absolute;width:100%" src="//www.youtube.com/embed/' . htmlspecialchars($attributes['id']) . '"></iframe></div></div>';
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