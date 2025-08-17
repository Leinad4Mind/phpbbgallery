<?php

/**
* @package   BBembed
* @copyright Copyright (c) 2015 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
* @copyright (c) 2016 SiteSplat All rights reserved
*/
namespace sitesplat\bbembed\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $inAcp      = false;
	protected $isDisabled = false;
	protected $parser;
	protected $siteIds    = array('facebook', 'medium', 'googleplus', 'soundcloud', 'twitch', 'twitter', 'vimeo', 'youtube');
	protected $tagNames   = array('FACEBOOK', 'MEDIUM', 'GOOGLEPLUS', 'SOUNDCLOUD', 'TWITCH', 'TWITTER', 'VIMEO', 'YOUTUBE');

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
		foreach ($this->siteIds as $siteId)
		{
			unset($configurator->tags[$siteId]);
			$configurator->MediaEmbed->add($siteId);

			$tag = $configurator->tags[$siteId];
			$tag->template = $this->addTemplateEffects($tag->template);
		}
	}

	protected function addTemplateEffects($template)
	{
		if (substr($template, 0, 4) !== '<div' && preg_match('(max-width:(\\d+px))', $template, $m))
		{
			$template = '<div style="display:inline-block;position:relative;width:100%;max-width:' . $m[1] . '">' . $template . '</div>';
		}

		$template = str_replace('<iframe', '<div class="spinner"></div><iframe', $template);
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
				'(</?(?:' . implode('|', $this->tagNames) . ')(?=[ />])[^>]*>)',
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
			'(<(?:' . implode('|', $this->tagNames) . ') content="([^"]*))',
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
			'(<URL[^>]*? url="([^"]+)"[^>]*>(?:https?://|<LINK_TEXT).*?</URL>)i',
			array($this, 'convertLinksCallback'),
			$xml
		);
	}

	protected function convertLinksCallback($m)
	{
		$originalXml = $m[0];
		$url         = $m[1];

		$xml = $this->getParser()->parse($url);
		if ($xml[1] === 'r')
		{
			$regexp = '(^<r[^>]*>(<(?:' . implode('|', $this->tagNames) . ') [^>]+>[^<]+</\\w+>)</r>$)';
			if (preg_match($regexp, $xml, $m))
			{
				return $m[1];
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

	protected function getParser()
	{
		if (!isset($this->parser))
		{
			$this->parser = unserialize('O:24:"s9e\\TextFormatter\\Parser":4:{s:16:"' . "\0" . '*' . "\0" . 'pluginsConfig";a:2:{s:7:"BBCodes";a:4:{s:7:"bbcodes";a:1:{s:5:"MEDIA";a:2:{s:17:"contentAttributes";a:1:{i:0;s:3:"url";}s:16:"defaultAttribute";s:4:"site";}}s:10:"quickMatch";s:1:"[";s:6:"regexp";s:30:"#\\[/?(\\*|[-\\w]+)(?=[\\]\\s=:/])#";s:11:"regexpLimit";i:10000;}s:10:"MediaEmbed";a:4:{s:10:"quickMatch";s:3:"://";s:6:"regexp";s:26:"/\\bhttps?:\\/\\/[^["\'\\s]+/Si";s:7:"tagName";s:5:"MEDIA";s:11:"regexpLimit";i:10000;}}s:14:"registeredVars";a:2:{s:9:"urlConfig";a:1:{s:14:"allowedSchemes";s:12:"/^https?$/Di";}s:10:"mediasites";a:9:{s:12:"facebook.com";s:8:"facebook";s:10:"medium.com";s:6:"medium";s:15:"plus.google.com";s:10:"googleplus";s:14:"soundcloud.com";s:10:"soundcloud";s:9:"twitch.tv";s:6:"twitch";s:11:"twitter.com";s:7:"twitter";s:9:"vimeo.com";s:5:"vimeo";s:11:"youtube.com";s:7:"youtube";s:8:"youtu.be";s:7:"youtube";}}s:14:"' . "\0" . '*' . "\0" . 'rootContext";a:2:{s:7:"allowed";a:1:{i:0;i:32639;}s:5:"flags";i:0;}s:13:"' . "\0" . '*' . "\0" . 'tagsConfig";a:9:{s:8:"FACEBOOK";a:8:{s:10:"attributes";a:3:{s:2:"id";a:2:{s:11:"filterChain";a:1:{i:0;a:2:{s:8:"callback";s:53:"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp";s:6:"params";a:2:{s:9:"attrValue";N;i:0;s:8:"@^\\d+$@D";}}}s:8:"required";b:1;}s:4:"type";a:2:{s:11:"filterChain";a:1:{i:0;a:2:{s:8:"callback";s:53:"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp";s:6:"params";a:2:{s:9:"attrValue";N;i:0;s:10:"#^video$#D";}}}s:8:"required";b:0;}s:3:"url";a:2:{s:11:"filterChain";a:1:{i:0;a:2:{s:8:"callback";s:50:"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterUrl";s:6:"params";a:3:{s:9:"attrValue";N;s:9:"urlConfig";N;s:6:"logger";N;}}}s:8:"required";b:0;}}s:22:"attributePreprocessors";a:3:{i:0;a:3:{i:0;s:3:"url";i:1;s:135:"@/(?!(?:apps|developers|graph)\\.)[-\\w.]*facebook\\.com/(?:[/\\w]+/permalink|(?!pages/|groups/).*?)(?:/|fbid=|\\?v=)(?\'id\'\\d+)(?=$|[/?&#])@";i:2;a:2:{i:0;s:0:"";i:1;s:2:"id";}}i:1;a:3:{i:0;s:3:"url";i:1;s:20:"#/(?\'type\'video)s?/#";i:2;a:2:{i:0;s:0:"";i:1;s:4:"type";}}i:2;a:3:{i:0;s:3:"url";i:1;s:15:"@^(?\'id\'\\d+)$@D";i:2;R:66;}}s:11:"filterChain";a:2:{i:0;a:2:{s:8:"callback";s:55:"s9e\\TextFormatter\\Parser::executeAttributePreprocessors";s:6:"params";a:2:{s:3:"tag";N;s:9:"tagConfig";N;}}i:1;a:2:{s:8:"callback";s:42:"s9e\\TextFormatter\\Parser::filterAttributes";s:6:"params";a:4:{s:3:"tag";N;s:9:"tagConfig";N;s:14:"registeredVars";N;s:6:"logger";N;}}}s:12:"nestingLimit";i:10;s:5:"rules";a:1:{s:5:"flags";i:3089;}s:8:"tagLimit";i:1000;s:9:"bitNumber";i:1;s:7:"allowed";a:1:{i:0;i:32604;}}s:10:"GOOGLEPLUS";a:8:{s:10:"attributes";a:4:{s:4:"name";a:2:{s:11:"filterChain";a:2:{i:0;a:2:{s:8:"callback";s:53:"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp";s:6:"params";a:2:{s:9:"attrValue";N;i:0;s:10:"!^[^/]+$!D";}}i:1;a:2:{s:8:"callback";s:9:"urldecode";s:6:"params";a:1:{s:9:"attrValue";N;}}}s:8:"required";b:0;}s:3:"oid";a:2:{s:11:"filterChain";a:1:{i:0;a:2:{s:8:"callback";s:53:"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp";s:6:"params";a:2:{s:9:"attrValue";N;i:0;s:8:"!^\\d+$!D";}}}s:8:"required";b:0;}s:3:"pid";a:2:{s:11:"filterChain";a:1:{i:0;a:2:{s:8:"callback";s:53:"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp";s:6:"params";a:2:{s:9:"attrValue";N;i:0;s:8:"!^\\w+$!D";}}}s:8:"required";b:0;}s:3:"url";R:53;}s:22:"attributePreprocessors";a:1:{i:0;a:3:{i:0;s:3:"url";i:1;s:83:"!//plus\\.google\\.com/(?:u/\\d+/)?(?:\\+(?\'name\'[^/]+)|(?\'oid\'\\d+))/posts/(?\'pid\'\\w+)!";i:2;a:4:{i:0;s:0:"";i:1;s:4:"name";i:2;s:3:"oid";i:3;s:3:"pid";}}}s:11:"filterChain";a:3:{i:0;R:79;i:1;R:84;i:2;a:2:{s:8:"callback";s:67:"s9e\\TextFormatter\\Plugins\\MediaEmbed\\Parser::hasNonDefaultAttribute";s:6:"params";a:1:{s:3:"tag";N;}}}s:12:"nestingLimit";i:10;s:5:"rules";R:92;s:8:"tagLimit";i:1000;s:9:"bitNumber";i:3;s:7:"allowed";a:1:{i:0;i:32598;}}s:5:"MEDIA";a:6:{s:11:"filterChain";a:1:{i:0;a:2:{s:8:"callback";s:54:"s9e\\TextFormatter\\Plugins\\MediaEmbed\\Parser::filterTag";s:6:"params";a:3:{s:3:"tag";N;s:6:"parser";N;s:10:"mediasites";N;}}}s:12:"nestingLimit";i:10;s:5:"rules";a:1:{s:5:"flags";i:513;}s:8:"tagLimit";i:1000;s:9:"bitNumber";i:0;s:7:"allowed";a:1:{i:0;i:32638;}}s:6:"MEDIUM";a:8:{s:10:"attributes";a:2:{s:2:"id";a:2:{s:11:"filterChain";a:1:{i:0;a:2:{s:8:"callback";s:53:"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp";s:6:"params";a:2:{s:9:"attrValue";N;i:0;s:13:"!^[\\da-f]+$!D";}}}s:8:"required";b:1;}s:3:"url";R:53;}s:22:"attributePreprocessors";a:2:{i:0;a:3:{i:0;s:3:"url";i:1;s:47:"!medium\\.com/[^/]*/(?:[-\\w]+-)?(?\'id\'[\\da-f]+)!";i:2;R:66;}i:1;a:3:{i:0;s:3:"url";i:1;s:20:"!^(?\'id\'[\\da-f]+)$!D";i:2;R:66;}}s:11:"filterChain";R:78;s:12:"nestingLimit";i:10;s:5:"rules";R:92;s:8:"tagLimit";i:1000;s:9:"bitNumber";i:2;s:7:"allowed";a:1:{i:0;i:32602;}}s:10:"SOUNDCLOUD";a:8:{s:10:"attributes";a:5:{s:2:"id";a:2:{s:11:"filterChain";a:1:{i:0;a:2:{s:8:"callback";s:53:"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp";s:6:"params";a:2:{s:9:"attrValue";N;i:0;s:83:"@^(?:https?://(?:api\\.)?soundcloud\\.com/(?!pages/)[-/\\w]+/[-/\\w]+|^[^/]+/[^/]+$)$@D";}}}s:8:"required";b:1;}s:11:"playlist_id";a:2:{s:11:"filterChain";R:38;s:8:"required";b:0;}s:12:"secret_token";a:2:{s:11:"filterChain";a:1:{i:0;a:2:{s:8:"callback";s:53:"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp";s:6:"params";a:2:{s:9:"attrValue";N;i:0;s:11:"@^[-\\w]+$@D";}}}s:8:"required";b:0;}s:8:"track_id";R:194;s:3:"url";R:53;}s:22:"attributePreprocessors";a:5:{i:0;a:3:{i:0;s:3:"url";i:1;s:83:"@(?\'id\'https?://(?:api\\.)?soundcloud\\.com/(?!pages/)[-/\\w]+/[-/\\w]+|^[^/]+/[^/]+$)@";i:2;R:66;}i:1;a:3:{i:0;s:3:"url";i:1;s:52:"@api\\.soundcloud\\.com/playlists/(?\'playlist_id\'\\d+)@";i:2;a:2:{i:0;s:0:"";i:1;s:11:"playlist_id";}}i:2;a:3:{i:0;s:3:"url";i:1;s:89:"@api\\.soundcloud\\.com/tracks/(?\'track_id\'\\d+)(?:\\?secret_token=(?\'secret_token\'[-\\w]+))?@";i:2;a:3:{i:0;s:0:"";i:1;s:8:"track_id";i:2;s:12:"secret_token";}}i:3;a:3:{i:0;s:3:"url";i:1;s:81:"@soundcloud\\.com/(?!playlists|tracks)[-\\w]+/[-\\w]+/(?=s-)(?\'secret_token\'[-\\w]+)@";i:2;a:2:{i:0;s:0:"";i:1;s:12:"secret_token";}}i:4;a:3:{i:0;s:3:"url";i:1;s:90:"@^(?\'id\'(?:https?://(?:api\\.)?soundcloud\\.com/(?!pages/)[-/\\w]+/[-/\\w]+|^[^/]+/[^/]+$))$@D";i:2;R:66;}}s:11:"filterChain";a:3:{i:0;R:79;i:1;a:2:{s:8:"callback";s:51:"s9e\\TextFormatter\\Plugins\\MediaEmbed\\Parser::scrape";s:6:"params";a:3:{s:3:"tag";N;i:0;a:2:{i:0;a:3:{i:0;s:54:"@soundcloud\\.com/(?!playlists|tracks)[-\\w]+/[-\\w]+/s-@";i:1;s:36:"@soundcloud:tracks:(?\'track_id\'\\d+)@";i:2;a:1:{i:0;s:8:"track_id";}}i:1;a:3:{i:0;s:27:"@soundcloud\\.com/\\w+/sets/@";i:1;s:44:"@soundcloud://playlists:(?\'playlist_id\'\\d+)@";i:2;a:1:{i:0;s:11:"playlist_id";}}}s:8:"cacheDir";N;}}i:2;R:84;}s:12:"nestingLimit";i:10;s:5:"rules";R:92;s:8:"tagLimit";i:1000;s:9:"bitNumber";i:4;s:7:"allowed";a:1:{i:0;i:32590;}}s:6:"TWITCH";a:8:{s:10:"attributes";a:6:{s:10:"archive_id";a:2:{s:11:"filterChain";a:1:{i:0;a:2:{s:8:"callback";s:53:"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp";s:6:"params";a:2:{s:9:"attrValue";N;i:0;s:8:"#^\\d+$#D";}}}s:8:"required";b:0;}s:7:"channel";a:2:{s:11:"filterChain";a:1:{i:0;a:2:{s:8:"callback";s:53:"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp";s:6:"params";a:2:{s:9:"attrValue";N;i:0;s:8:"#^\\w+$#D";}}}s:8:"required";b:0;}s:10:"chapter_id";R:254;s:1:"t";a:2:{s:11:"filterChain";a:1:{i:0;a:2:{s:8:"callback";s:53:"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp";s:6:"params";a:2:{s:9:"attrValue";N;i:0;s:27:"#^(?:(?:\\d+h)?\\d+m)?\\d+s$#D";}}}s:8:"required";b:0;}s:3:"url";R:53;s:8:"video_id";R:254;}s:22:"attributePreprocessors";a:2:{i:0;a:3:{i:0;s:3:"url";i:1;s:96:"#twitch\\.tv/(?\'channel\'\\w+)(?:/b/(?\'archive_id\'\\d+)|/c/(?\'chapter_id\'\\d+)|/v/(?\'video_id\'\\d+))?#";i:2;a:5:{i:0;s:0:"";i:1;s:7:"channel";i:2;s:10:"archive_id";i:3;s:10:"chapter_id";i:4;s:8:"video_id";}}i:1;a:3:{i:0;s:3:"url";i:1;s:32:"#t=(?\'t\'(?:(?:\\d+h)?\\d+m)?\\d+s)#";i:2;a:2:{i:0;s:0:"";i:1;s:1:"t";}}}s:11:"filterChain";R:137;s:12:"nestingLimit";i:10;s:5:"rules";R:92;s:8:"tagLimit";i:1000;s:9:"bitNumber";i:5;s:7:"allowed";a:1:{i:0;i:32606;}}s:7:"TWITTER";a:8:{s:10:"attributes";a:2:{s:2:"id";R:37;s:3:"url";R:53;}s:22:"attributePreprocessors";a:2:{i:0;a:3:{i:0;s:3:"url";i:1;s:51:"@twitter\\.com/(?:#!/)?\\w+/status(?:es)?/(?\'id\'\\d+)@";i:2;R:66;}i:1;R:75;}s:11:"filterChain";R:78;s:12:"nestingLimit";i:10;s:5:"rules";R:92;s:8:"tagLimit";i:1000;s:9:"bitNumber";i:6;s:7:"allowed";a:1:{i:0;i:32542;}}s:5:"VIMEO";a:8:{s:10:"attributes";a:2:{s:2:"id";a:2:{s:11:"filterChain";R:113;s:8:"required";b:1;}s:3:"url";R:53;}s:22:"attributePreprocessors";a:2:{i:0;a:3:{i:0;s:3:"url";i:1;s:50:"!vimeo\\.com/(?:channels/[^/]+/|video/)?(?\'id\'\\d+)!";i:2;R:66;}i:1;a:3:{i:0;s:3:"url";i:1;s:15:"!^(?\'id\'\\d+)$!D";i:2;R:66;}}s:11:"filterChain";R:78;s:12:"nestingLimit";i:10;s:5:"rules";R:92;s:8:"tagLimit";i:1000;s:9:"bitNumber";i:5;s:7:"allowed";R:297;}s:7:"YOUTUBE";a:8:{s:10:"attributes";a:7:{s:1:"h";R:112;s:2:"id";a:2:{s:11:"filterChain";a:1:{i:0;a:2:{s:8:"callback";s:53:"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp";s:6:"params";a:2:{s:9:"attrValue";N;i:0;s:11:"!^[-\\w]+$!D";}}}s:8:"required";b:1;}s:4:"list";a:2:{s:11:"filterChain";R:327;s:8:"required";b:0;}s:1:"m";R:112;s:1:"s";R:112;s:1:"t";R:112;s:3:"url";R:53;}s:22:"attributePreprocessors";a:5:{i:0;a:3:{i:0;s:3:"url";i:1;s:45:"!youtube\\.com/(?:watch.*?v=|v/)(?\'id\'[-\\w]+)!";i:2;R:66;}i:1;a:3:{i:0;s:3:"url";i:1;s:25:"!youtu\\.be/(?\'id\'[-\\w]+)!";i:2;R:66;}i:2;a:3:{i:0;s:3:"url";i:1;s:57:"![#&?]t=(?:(?:(?\'h\'\\d+)h)?(?\'m\'\\d+)m(?\'s\'\\d+)|(?\'t\'\\d+))!";i:2;a:5:{i:0;s:0:"";i:1;s:1:"h";i:2;s:1:"m";i:3;s:1:"s";i:4;s:1:"t";}}i:3;a:3:{i:0;s:3:"url";i:1;s:23:"!&list=(?\'list\'[-\\w]+)!";i:2;a:2:{i:0;s:0:"";i:1;s:4:"list";}}i:4;a:3:{i:0;s:3:"url";i:1;s:18:"!^(?\'id\'[-\\w]+)$!D";i:2;R:66;}}s:11:"filterChain";R:78;s:12:"nestingLimit";i:10;s:5:"rules";R:92;s:8:"tagLimit";i:1000;s:9:"bitNumber";i:5;s:7:"allowed";R:297;}}}');
		}

		return $this->parser;
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

		return $this->addTemplateEffects('<iframe data-sitesplat-mediaembed="facebook" allowfullscreen="" onload="var a=Math.random();window.addEventListener(\'message\',function(b){if(b.data.id==a)style.height=b.data.height+\'px\'});contentWindow.postMessage(\'s9e:\'+a,\'https://s9e.github.io\')" scrolling="no" src="https://s9e.github.io/iframe/facebook.min.html#' . htmlspecialchars($attributes['type'] . $attributes['id'], 2) . '" style="border:0;height:360px;max-width:640px;width:100%"></iframe>');
	}

	protected function renderGoogleplus(array $attributes)
	{
		$attributes += array('name' => null, 'oid' => null, 'pid' => null);

		$html = '<iframe data-sitesplat-mediaembed="googleplus" allowfullscreen="" onload="var a=Math.random();window.addEventListener(\'message\',function(b){if(b.data.id==a)style.height=b.data.height+\'px\'});contentWindow.postMessage(\'s9e:\'+a,\'https://s9e.github.io\')" scrolling="no" style="border:0;height:240px;max-width:450px;width:100%" src="https://s9e.github.io/iframe/googleplus.min.html#';
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
		return '<div style="display:inline-block;position:relative;width:100%;max-width:400px"><div class="spinner"></div><iframe allowfullscreen="" onload="if(previousSibling)parentNode.removeChild(previousSibling);window.addEventListener(\'message\',function(a){a=a.data.split(\'::\');\'m\'===a[0]&amp;&amp;0&lt;src.indexOf(a[1])&amp;&amp;a[2]&amp;&amp;(style.height=a[2]+\'px\')})" scrolling="no" src="https://api.medium.com/embed?type=story&amp;path=%2F%2F' . htmlspecialchars($attributes['id'],2).'&amp;id=' . htmlspecialchars(strtr($attributes['id'],'abcdef','111111'),2).'" style="border:1px solid;border-color:#eee #ddd #bbb;border-radius:5px;box-shadow:rgba(0,0,0,.15) 0 1px 3px;height:400px;max-width:400px;width:100%"></iframe></div>';
	}

	protected function renderSoundcloud($attributes)
	{
		$attributes += array('id' => null, 'playlist_id' => null, 'secret_token' => null, 'track_id' => null);

		$html = '<iframe data-sitesplat-mediaembed="soundcloud" allowfullscreen="" scrolling="no" src="https://w.soundcloud.com/player/?url=';
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
		$html = '<div data-sitesplat-mediaembed="twitch" style="display:inline-block;width:100%;max-width:640px"><div style="overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" scrolling="no" style="border:0;height:100%;left:0;position:absolute;width:100%" src="//player.twitch.tv/?autoplay=false&amp;';
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
		return '<div style="display:inline-block;width:100%;max-width:500px"><div style="position:relative"><div class="spinner"></div><iframe allowfullscreen="" onload="var a=Math.random();window.addEventListener(\'message\',function(b){if(b.data.id==a){style.height=b.data.height+\'px\';if(previousSibling)parentNode.removeChild(previousSibling)}});contentWindow.postMessage(\'s9e:\'+a,src.substr(0,src.indexOf(\'/\',8)));setTimeout(function(){if(previousSibling)parentNode.removeChild(previousSibling)},5e3)" scrolling="no" src="//s9e.github.io/iframe/twitter.min.html#' . htmlspecialchars($attributes['id']) . '" style="border:0;height:186px;max-width:500px;transition:height .3s;width:100%"></iframe></div></div>';
	}

	protected function renderVimeo(array $attributes)
	{
		return '<div data-sitesplat-mediaembed="vimeo" style="display:inline-block;width:100%;max-width:640px"><div style="overflow:hidden;position:relative;padding-bottom:56.25%"><div class="spinner"></div><iframe allowfullscreen="" onload="parentNode.removeChild(previousSibling)" scrolling="no" src="//player.vimeo.com/video/' . htmlspecialchars($attributes['id']) . '" style="border:0;height:100%;left:0;position:absolute;width:100%"></iframe></div></div>';
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