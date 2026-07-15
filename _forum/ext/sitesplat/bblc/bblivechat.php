<?php
/**
 * BBlivechat Giphy Addon
 * @copyright (c) 2021 SiteSplat. All rights reserved.
 * @license Proprietary
 */

namespace sitesplat\bblc_giphy;

class bblivechat
{
	public function __construct()
	{
		global $config;

		\sitesplat\add_filter('bblc_handle_acp_settings', [$this, 'giphy_handle'], 1);
		\sitesplat\add_filter('bblc_display_acp_settings', [$this, 'giphy_form'], 5);

		if ($config['bblc_giphy']) {
			\sitesplat\add_filter('bblivechat_js', [$this, 'add_giphy_js'], 1);
			\sitesplat\add_filter('bblivechat_picker_box', [$this, 'add_giphy_box'], 1);
			\sitesplat\add_filter('bblivechat_picker_btn', [$this, 'add_giphy_btn'], 1);
		}
	}

	public function giphy_handle($error)
	{
		global $config, $request;

		$config->set('bblc_giphy', $request->variable('bblc_giphy', ''));
		return $error;
	}

	public function giphy_form($html)
	{
		global $config, $language;

		$giphylabel = $language->lang('GIPHY_LABEL') . $language->lang('COLON');
		$giphyexplain = $language->lang('GIPHY_EXPLAIN');
		$giphy = $config['bblc_giphy'];

		return $html . <<<EOT
		<dl>
			<dt><label>$giphylabel</label><span>$giphyexplain</span></dt>
			<dd>
				<input type="text" size="32" maxlength="128" name="bblc_giphy" value="$giphy" />
			</dd>
		</dl>
		<hr />
EOT;
	}

	public function add_giphy_js($js)
	{
		global $config;

		$giphy = $config['bblc_giphy'];
		return $js . <<<EOT
var mirrorText = document.querySelector('.mirror-text');
var form = document.querySelector('.search-form');
var field = document.querySelector('.search-field');
var giphyResult = document.querySelector('.giphyResult');
var clearSearch = document.querySelector('.search__clear');
var url = 'https://api.giphy.com/v1/gifs/search?';
var giphy_api = '$giphy';

function getQueryString() {
	var query = url + 'q=' + encodeURI(field.value) + '&api_key=' + giphy_api + '&limit=40';
	return query;
}

var result = {};
form.addEventListener('submit', function (event) {
	fetch(getQueryString()).then(function (response) {
		return response.json();
	}).then(function (response) {
		renderImages(response.data);
	});
	event.preventDefault();
	form.reset();
});

const insertGif = (bbCode, src) => {
	let element = document.querySelector('#inputField');
	if (element) {
		element.value += `[\${bbCode}]\${src}[/\${bbCode}]`;
	}
};

function renderImages(data) {
	var oldImage = document.querySelectorAll('.search__result');
	if (oldImage.length > 0) {
		oldImage.forEach(function (image) {
			image.remove();
		});
	}

	data.forEach(function (value, key) {
		var anchor = getElement('div', {class: 'result__link'});
		setElement(anchor, '.giphyResult');
		var image = getElement('img', {
			src: value.images.fixed_width.url,
			alt: value.title,
			class: 'search__result',
			onclick: `insertGif("img","\${value.images.fixed_width.url}")`
		});
		setElement(image, '.result__link');
	});
}
function getElement(type, attributes) {
	var element = document.createElement(type);
	for (attribute in attributes) {
		element.setAttribute(attribute, attributes[attribute]);
	}
	return element;
}
function setElement(element, target) {
	document.querySelector(target).appendChild(element);
}
EOT;
	}

	public function add_giphy_box($html)
	{
		global $bblivechat;

		$gifsearch = $bblivechat->getLang('gifSearch');
		return $html . <<<EOT
<div class="colorPicker hidden" id="GifPicker">
	<div class="arrow-top" style="display:none;"></div>
	<div class="arrowWhite-top" style="display:none;"></div>
	<div class="colorList">
		<div class="header">
			<div class="banner">
				<form class="search-form">
					<div class="search-form-items">
					<input class="search-field" type="search" placeholder="$gifsearch" />
					</div>
				</form>
			</div>
			<div class="giphyResult"></div>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="arrow-bottom"></div>
	<div class="arrowWhite-bottom"></div>
</div>
EOT;
	}

	public function add_giphy_btn($html)
	{
		return $html . <<<EOT
<a class="chat-input__button" aria-label="" onclick='bblivechat.toggleElement("#GifPicker", "hidden")'>
  <i class="chat-input__button-icon chat-input__button-icon--chat icon-moon-gif" aria-hidden="true"></i>
</a>
EOT;
	}
}
