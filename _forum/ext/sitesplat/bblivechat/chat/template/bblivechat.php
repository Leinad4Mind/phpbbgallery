<?php
if (!defined('BBLIVECHAT')) {
	return;
}

global $bblivechat, $bblc_rooms, $bblc_settings, $user, $bblc_admin, $ugids, $user_avatar_full;
$u_acp = ($bblc_admin) ? append_sid('../adm/index.php', false, true, $user->session_id) : '';

$bblc_css = \sitesplat\apply_filters('bblivechat_css', '');
$bblc_js = \sitesplat\apply_filters('bblivechat_js', '');

$bblc_css_time = filemtime(BBLIVECHAT . '/css/bblivechat.css');
$bblc_js_time = filemtime(BBLIVECHAT . '/js/bblivechat.js');
$bblc_jso_time = filemtime(BBLIVECHAT . '/js/optiscroll.min.js');

if ($bblc_css) {
	$bblc_css = "<style>$bblc_css</style>";
}
if ($bblc_js) {
	$bblc_js = "<script>$bblc_js</script>";
}

if (empty($bblc_settings[1])) {
?><!DOCTYPE html>
<html lang="<?php echo $bblivechat->getLangCode(); ?>" dir="<?php echo BBLC_DIRECTION; ?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $bblivechat->getLang('bBlivechatfull'); ?></title>
<meta name="description" content="phpBB forum chat">
<link rel="apple-touch-icon" sizes="180x180" href="../ext/sitesplat/bblivechat/chat/media/fav/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../ext/sitesplat/bblivechat/chat/media/fav/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../ext/sitesplat/bblivechat/chat/media/fav/favicon-16x16.png">
<link rel="manifest" href="../ext/sitesplat/bblivechat/chat/media/fav/site.webmanifest">
<link rel="mask-icon" href="../ext/sitesplat/bblivechat/chat/media/fav/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<link rel="stylesheet" href="../ext/sitesplat/bblivechat/chat/css/bblivechat.css?v=<?php echo $bblc_css_time; ?>" />

<?php echo $bblc_css; ?>
</head>
<body>
<?php
}
else {
	echo $bblc_css;
}
?>

<div id="content" class="layout-app<?php echo \sitesplat\apply_filters('bblivechat_content_classes', ''); ?>">
<div class="root js-left-menu-root pinned" data-v-44ebcb1a="">
	<header class="header" data-v-44ebcb1a="">
		<section class="header-main-menu layout-main-menu" data-v-44ebcb1a="">
		    <div class="logo">
			  <svg class="text" viewBox="0 0 500 130">
				<text
					  fill="none"
					  stroke="#fff"
					  transform="translate(3 102)"
					  stroke-width="3"
					  font-size="56px"
					  font-family="Georgia"
					  font-weight="700"
					  letter-spacing="-4px"
					  class="is-active">
				  <tspan dx="4" dy="-1">GoldTugAnime</tspan>
				</text>
			  </svg>
			</div>
		</section>
	</header>
	<section class="body nli-body" data-v-44ebcb1a="">
		<?php $txt = <<<EOT
		<h2 class="nli-primary-heading" data-v-44ebcb1a="">Where communities thrive</h2>
		<br>
		<ul class="nli-info-block" data-v-44ebcb1a="">
			<li class="nli-info-block-item" data-v-44ebcb1a="">Join Over <strong>4k+ Happy Admins</strong></li>
			<li class="nli-info-block-item" data-v-44ebcb1a="">Over <strong>70 Premium</strong> Addons</li>
			<li class="nli-info-block-item" data-v-44ebcb1a="">Create Your <strong>own Community</strong></li>
			<li class="nli-info-block-item" data-v-44ebcb1a="">Exclusive <strong>Membership Perks</strong></li>
		</ul>
		<ul class="nli-info-block" data-v-44ebcb1a="">
			<li class="nli-info-block-item" data-v-44ebcb1a=""><a href="https://themeforest.net/user/ThemeSplat/portfolio?ref=ThemeSplat" data-v-44ebcb1a="">Explore more communities</a></li>
		</ul>
		<a><img src="../ext/sitesplat/bblivechat/chat/media/img/online-adverteren-met-ads.png" alt="" class="nli-info-block img-responsive" data-v-44ebcb1a=""></a>
		<a href="https://www.vultr.com/?ref=8543723-6G"><img class="nli-info-block img-responsive" src="https://www.vultr.com/media/banners/banner_628x628.png" alt="" data-v-44ebcb1a=""></a>
EOT;
		echo \sitesplat\apply_filters('bblivechat_sidebar_html', $txt);
		?>
	</section>

<section id="RoomTarget" class="body hidden" data-v-44ebcb1a="">
	<section class="body-main-menu layout-main-menu" data-v-44ebcb1a="">

	<h2 class="room-list-title" data-v-44ebcb1a="">Todos os canais</h2>
		<div id="chatrooms" data-v-7e347d98="" data-v-44ebcb1a="">
			<ul id="CloneNode" class="room-list" data-v-7e347d98="">
<?php
foreach ($bblc_rooms as $id => $room) {
	if ($bblc_admin || $id === 'user' || !$room['cover'] || count(array_intersect($room['groups'], $ugids))) {
		$image = '';
		if (!empty($room['image'])) {
			$image = '<img alt="" src="../images/bblivechat/image/' . $room['image'] . '" />';
		}
		else if ($id === 'user') {
			$image = '<img alt="" src="' . $user_avatar_full . '" />';
		}
?>
				<li data-room-id="<?php echo $id; ?>" class="list-item" data-v-9ef03dac="" data-v-7e347d98="">
					<a data-room="<?php echo $room['name']; ?>" data-classes="<?php echo $room['classes']; ?>" class="list-item-link" data-v-9ef03dac="" onclick="bblivechat.make_active(this, '')">
						<span class="list-item-room room-image" data-v-9ef03dac=""><?php echo $image; ?></span>
						<span class="list-item-name" data-v-9ef03dac=""><span class="name-piece" data-v-9ef03dac=""><?php echo $room['name']; ?></span></span>
						<span class="room-description"><?php echo $room['desc']; ?></span>
						<span class="room-announcement"><?php echo $room['announcement']; ?></span>
					</a>
				</li>
<?php
	}
}
?>
			</ul>
		</div>
	</section>

</section>
</div>

<div class="layout-app-body">

<header class="chat-header" id="header-wrapper">
	<div id="header" class="chat-header-inner">

		<div class="chat-header__main-grouping chat-header__left-menu-toggle-grouping">
			<button class="chat-header__left-menu-toggle js-header-view-left-menu-toggle">
				<svg class="chat-header__action-icon" viewBox="0 0 26 22">
					<path d="M0,2 l26,0"></path>
					<path d="M0,11 l26,0"></path>
					<path d="M0,20 l26,0"></path>
				</svg>
			</button>
		</div>

		<div id="current-room-image" class="chat-header__main-grouping chat-header__avatar-grouping"></div>

		<div class="chat-header__main-grouping chat-header__info-grouping">
			<div class="chat-header__heading-sub-group">
				<h1 id="current-room-name" class="js-chat-name chat-header__heading chat-header__title"></h1>
			</div>
			<div class="chat-header__topic-sub-group js-room-topic-edit-activator">
				<div class="chat-header__topic-wrapper js-room-topic-wrapper">
					<p id="current-room-desc" class="js-room-topic chat-header__topic"></p>
				</div>
			</div>
		</div>

	<div class="chat-header__main-grouping chat-header__action-grouping">
		<a style="display:none;" href="#" class="chat-header__org-page org-page-link js-chat-header-org-page-action" data-md-tooltip="<?php echo $bblivechat->getLang('logout'); ?>" onclick="bblivechat.sendMessageWrapper('/quit');">
			<i class="chat-header__action-icon icon-globe icon-moon-power"></i>
		</a>
		<a href="#" class="chat-header__org-page org-page-link js-chat-header-org-page-action" data-md-tooltip="<?php echo $bblivechat->getLang('toggleAutoScroll'); ?>" onclick="bblivechat.toggleSetting('autoScroll', 'autoScrollButton');">
			<i id="autoScrollButton" class="chat-header__action-icon icon-globe icon-moon-move-down"></i>
		</a>
		<a href="#open-modal-help" class="chat-header__favourite js-favourite-button favourite" data-md-tooltip="<?php echo $bblivechat->getLang('toggleHelp'); ?>">
			<i class="chat-header__action-icon icon-star-1 icon-moon-help-circled-alt" aria-hidden="true"></i>
		</a>
		<a style="display:none;" href="#open-modal-settings" class="chat-header__settings js-chat-settings" onclick="myFunctionDropRoom()">
		 <i class="chat-header__action-icon icon-star-1 icon-moon-help-circled-alt" aria-hidden="true"></i>
		</a>
		<a class="chat-header__favourite" data-md-tooltip="<?php echo $bblivechat->getLang('toggleAudio'); ?>" onclick="bblivechat.toggleSetting('audio', 'audioButton');">
			<i id="audioButton" class="chat-header__action-icon icon-moon-volume-up" aria-hidden="true"></i>
		</a>
		<a style="display:none;" href="#open-modal-settings" class="chat-header__settings js-chat-settings" data-md-tooltip="<?php echo $bblivechat->getLang('toggleSettings'); ?>">
			<i class="chat-header__action-icon icon-moon-params" aria-hidden="true"></i>
		</a>
		<div id="profile-menu" class="profile-menu">
		<img id="profile-menu-avatar" src="<?php echo $user_avatar_full; ?>" loading="lazy" width="34" height="34" class="profile-menu__avatar" alt="" onclick='bblivechat.toggleElement("#profile-menu-items", "hidden")'>
		<div class="dropdown-backdrop hidden" id="profile-menu-items-backdrop">
			<div style="position:fixed;width:100vw;height:100vh;background:transparent;" onclick='bblivechat.hiddenDropMenu("#profile-menu-items","#profile-menu-items-backdrop")'></div>
			<ul id="profile-menu-items" class="dropdown profile-menu__list hidden">
				<li class="dropdown__item--positive profile-menu__item"><a class="profile-menu__item__link" onclick="bblivechat.sendMessageWrapper('/quit');"><?php echo $user->lang('FORUM_INDEX'); ?></a></li>
				<?php if ($u_acp) { ?><li class="dropdown__item--positive profile-menu__item"><a class="profile-menu__item__link" href="<?php echo $u_acp; ?>"><?php echo $user->lang('ACP_SHORT'); ?></a></li><?php } ?>
				<?php echo \sitesplat\apply_filters('bblivechat_profile_menu', ''); ?>
			</ul>
        </div>
		</div>
	</div>

	</div>
</header>

	<div id="headlineContainer">
		<h1></h1>
	</div>

<div class="chat-and-toolbar-wrapper">

<div class="right-toolbar-region" id="right-toolbar-layout">
	<div id="collapseExample" class="right-toolbar right-toolbar--collapsible collapsed">
		<div id="toolbar-top-content" class="right-toolbar__body">
			<div id="people-list">
				<div class="trpToolbarHeader" id="top-header">
					<h5 class="trpToolbarHeaderItem selected" id="people-header"><?php echo $bblivechat->getLang('onlineUsers'); ?></h5>
				</div>
			</div>
		</div>
		<div class="trpToolbarList">
			<div class="trpToolbarListContent" id="people-roster">
				<span class="frame-people">
					<span id="roster-region">
						<div id="onlineList"></div>
					</span>
				</span>
			</div>
		</div>
		<div id="right-toolbar-footer-region" class="right-toolbar-region__footer" title="<?php echo $bblivechat->getLang('toggleOnlineList'); ?>">
			<svg class="menu-toggle-icon js-menu-toggle-icon" width="30px" height="34px" viewBox="0 0 30 34" onclick='bblivechat.toggleElement("#collapseExample", "collapsed")'>
				<path d="M0,6 l15,0 l15,0"></path>
				<path d="M0,17 l15,0 l15,0"></path>
				<path d="M0,28 l15,0 l15,0"></path>
			</svg>
		</div>
	</div>
</div>

<div id="chat-app">
	<div class="dropdown-backdrop hidden" id="backdrop-link-box">
		<div style="position:fixed;width:100vw;height:100vh;background:transparent;"></div>
		<form class="box-link hidden" onsubmit='bblivechat.getLinkFromBox("#address-url", event)'>
			<div class="content-box-container">
			  <div class="body-box">
				<span style="padding: 1.5rem; color: black;"><strong><?php echo $bblivechat->getLang('bBcodeurl'); ?></strong></span>
				<input
				  type="text"
				  id="address-url"
				  style="width: 80%; margin-top:1.5rem"
				  value="https://"
				/>
			  </div>
			</div>
			<div class="footer-box">
			  <button class="btnOK"><?php echo $bblivechat->getLang('btnOk'); ?></button>
			  <button type="button" class="btnCancel" onclick='bblivechat.toggleElement(".box-link", "hidden")'>
				<?php echo $bblivechat->getLang('btnCancel'); ?>
			  </button>
			</div>
		</form>
	</div>

	<div class="dropdown-backdrop hidden" id="backdrop-delete-box">
		<div style="position:fixed;width:100vw;height:100vh;background-color: rgba(0,0,0,.45);"></div>
		<form class="delete-box hidden" onsubmit="bblivechat.deleteMessageSelected(event)">
		<div class="content-box-container">
			<div class="body-box">
				<p style="text-align: center; color: black; font-size: 23px; margin: 0 0">
				   <strong><span style="color: red; font-weight: 2rem;">!!</span>&nbsp;<?php echo $bblivechat->getLang('btnWarning'); ?></strong>
				</p>
				<p style="color: black; font-size: 15px;"><?php echo $bblivechat->getLang('btnWarnmsg'); ?></p>
			</div>
			<div class="footer-box">
			  <button class="btnYes"><?php echo $bblivechat->getLang('btnYes'); ?></button>
			  <button type="button" class="btnNo" onclick='bblivechat.toggleDeleteBox()'><?php echo $bblivechat->getLang('btnNo'); ?></button>
			</div>
		</div>
		</form>
	</div>

<div id="content-wrapper" class="trpContentPanel optiscroll">
	<div id="chatList" class="trpChatPanel" onscroll="bblivechat.handleScroll()"></div>

	<div class="chat-connectivity-indicator-wrapper">
		<?php
$bblc_announce = $bblivechat->getConfig("announce");
if ($bblc_announce) {
	echo <<<EOT
		<div class="chat-connectivity-indicator indicator-general-alert">$bblc_announce</div>
EOT;
}
?>
	</div>
</div>

	<div id="bbCodetools" class="bbcodes-toolbar">
	    <div id="emoticonsContainer"></div>
	</div>

<footer id="chat-input-wrapper" class="chat-input chat-input-nli">
		<button type="button" class="item item-toggle md-tooltip--top" data-v-35d959fz="" onclick='bblivechat.toggleElement("#RoomTarget", "hidden")' data-md-tooltip="<?php echo $bblivechat->getLang('toggleRoomsTooltip'); ?>">
			<div class="unread-indicator" data-v-35d959fa=""></div>
			<span class="icon-wrapper" data-v-35d959fa="">
			   <svg viewBox="0 0 30 34" data-v-35d959fa="" data-v-04603212=""><path d="M0,6 l15,0 l15,0" data-v-35d959fa="" data-v-04603212=""></path> <path d="M0,17 l15,0 l15,0" data-v-35d959fa="" data-v-04603212=""></path> <path d="M0,28 l15,0 l15,0" data-v-35d959fa="" data-v-04603212=""></path></svg>
			</span>
		</button>
	<div class="chat-input__container js-chat-input-container" id="chat-input">
		<div id="bbCodeContainer" class="hidden">
			<button type="button" class="btn md-tooltip--top" value="<?php echo $bblivechat->getLang('bbCodeLabelBold'); ?>" data-md-tooltip="<?php echo $bblivechat->getLang('bbCodeTitleBold'); ?>" onclick="bblivechat.insertBBCode('b');"><i class="icon-moon-bold"></i></button>
			<button type="button" class="btn md-tooltip--top md-tooltip--medium" value="<?php echo $bblivechat->getLang('bbCodeLabelItalic'); ?>" data-md-tooltip="<?php echo $bblivechat->getLang('bbCodeTitleItalic'); ?>" onclick="bblivechat.insertBBCode('i');"><i class="icon-moon-italic"></i></button>
			<button type="button" class="btn md-tooltip--top md-tooltip--medium" value="<?php echo $bblivechat->getLang('bbCodeLabelUnderline'); ?>" data-md-tooltip="<?php echo $bblivechat->getLang('bbCodeTitleUnderline'); ?>" onclick="bblivechat.insertBBCode('u');"><i class="icon-moon-underline"></i></button>
			<button type="button" class="btn md-tooltip--top md-tooltip--long" value="<?php echo $bblivechat->getLang('bbCodeLabelURL'); ?>" data-md-tooltip="<?php echo $bblivechat->getLang('bbCodeTitleURL'); ?>" onclick='bblivechat.toggleElement(".box-link","hidden" );'><i class="icon-moon-link"></i></button>
			<button type="button" class="btn md-tooltip--top md-tooltip--long" value="<?php echo $bblivechat->getLang('bbCodeLabelImg'); ?>" data-md-tooltip="<?php echo $bblivechat->getLang('bbCodeTitleImg'); ?>" onclick="bblivechat.insertBBCode('img');"><i class="icon-moon-picture"></i></button>
			<button type="button" class="btn md-tooltip--top md-tooltip--long" value="<?php echo $bblivechat->getLang('bbCodeLabelCode'); ?>" data-md-tooltip="<?php echo $bblivechat->getLang('bbCodeTitleCode'); ?>" onclick="bblivechat.insertBBCode('code');"><i class="icon-moon-code"></i></button>
			<?php echo \sitesplat\apply_filters('bblivechat_bbcode_menu', ''); ?>
		</div>

	   <div class="chat-input__area">
		<div class="chat-user-is-typing__message"></div>
		  <div class="chat-input__avatar">
			 <div class="trpDisplayPicture avatar-s offline">
				<img src="<?php echo $user_avatar_full; ?>" loading="lazy" class="avatar__image" alt="" width="30" height="30">
			 </div>
		  </div>
		  <div id="chat-input-box-region" class="chat-input-box__region">
				<div id="inputFieldContainer" class="chat-input__box">
					<textarea id="inputField" class="inputbox chat-input__text-area js-reset-textarea-size"
							  placeholder="<?php echo $bblivechat->getLang('inputLineBreak'); ?>"
							  onkeypress="bblivechat.handleInputFieldKeyPress(event);"
							  onkeyup="bblivechat.handleInputFieldKeyUp(event);">
					</textarea>

					<span id="messageLengthCounter"></span>
					<span id="statusIconContainer" class="statusContainerOn" onclick="bblivechat.updateChat(null);"></span>
					<input style="display:none" type="button" id="submitButton" class="btn btn-send" value="<?php echo $bblivechat->getLang('messageSubmit'); ?>" onclick="bblivechat.sendMessage();"/>
				</div>
		  </div>

        			<div class="colorPicker hidden" id="ColorPicker">
			  <div class="arrow-top" style="display:none;"></div>
			  <div class="arrowWhite-top" style="display:none;"></div>
			  <div class="colorList">
				<a href="javascript:bblivechat.setFontColor('fuchsia');" title="fuchsia" class="colorContainer color-toggler" style="background:fuchsia;"></a>
				<a href="javascript:bblivechat.setFontColor('orange');" title="orange" class="colorContainer color-toggler" style="background:orange;"></a>
				<a href="javascript:bblivechat.setFontColor('teal');" title="teal" class="colorContainer color-toggler" style="background:teal;"></a>
				<a href="javascript:bblivechat.setFontColor('red');" title="red" class="colorContainer color-toggler" style="background:red;"></a>
				<a href="javascript:bblivechat.setFontColor('silver');" title="silver" class="colorContainer color-toggler" style="background:silver;"></a>
				<a href="javascript:bblivechat.setFontColor('aqua');" title="aqua" class="colorContainer color-toggler" style="background:aqua;"></a>
				<a href="javascript:bblivechat.setFontColor('gray');" title="gray" class="colorContainer color-toggler" style="background:gray;"></a>
				<a href="javascript:bblivechat.setFontColor('black');" title="black" class="colorContainer color-toggler" style="background:black;"></a>
				<a href="javascript:bblivechat.setFontColor('lime');" title="lime" class="colorContainer color-toggler" style="background:lime;"></a>
				<a href="javascript:bblivechat.setFontColor('maroon');" title="maroon" class="colorContainer color-toggler" style="background:maroon;"></a>
				<a href="javascript:bblivechat.setFontColor('salmon');" title="salmon" class="colorContainer color-toggler" style="background:salmon;"></a>
				<a href="javascript:bblivechat.setFontColor('greenyellow');" title="greenyellow" class="colorContainer color-toggler" style="background:greenyellow;"></a>
				<a href="javascript:bblivechat.setFontColor('rebeccapurple');" title="rebeccapurple" class="colorContainer color-toggler" style="background:rebeccapurple;"></a>
				<a href="javascript:bblivechat.setFontColor('blueviolet');" title="blueviolet" class="colorContainer color-toggler" style="background:blueviolet;"></a>

				<div style="display:none;" class="hexIcon">&#35;</div>
				<div style="display:none;" class="inputContainer">
				  <input value="" placeholder="ff691f" maxlength="6">
				</div>
				<div style="clear: both;"></div>
			  </div>
			  <div class="arrow-bottom"></div>
			  <div class="arrowWhite-bottom"></div>
			</div>

			<?php echo \sitesplat\apply_filters('bblivechat_picker_box', ''); ?>


		  <div id="chat-input-buttons-region" class="chat-input__buttons">
				<a style="display:none;" href="javascript:bblivechat.insertMessageWrapper('/roll ');" class="chat-input__button" aria-label="">
				  <i class="chat-input__button-icon chat-input__button-icon--chat icon-moon-dice" aria-hidden="true"></i>
				</a>
				<a class="chat-input__button" aria-label="">
				  <i class="chat-input__button-icon chat-input__button-icon--chat icon-moon-cog" aria-hidden="true" onclick='bblivechat.toggleElement("#bbCodeContainer", "hidden")'></i>
				</a>
				<a class="chat-input__button" aria-label="">
				  <i class="chat-input__button-icon chat-input__button-icon--chat icon-moon-pacman" aria-hidden="true" onclick='bblivechat.toggleElement("#bbCodetools", "active")'></i>
				</a>
				<a class="chat-input__button" aria-label="" onclick='bblivechat.toggleElement("#ColorPicker", "hidden")'>
				  <i class="chat-input__button-icon chat-input__button-icon--chat icon-moon-tint" aria-hidden="true"></i>
				</a>

				<?php echo \sitesplat\apply_filters('bblivechat_picker_btn', ''); ?>

				<svg class="menu-toggle-icon js-menu-toggle-icon js-menu-toggle-sm-device" width="30px" height="34px" viewBox="0 0 30 34" onclick='bblivechat.toggleElement("#collapseExample", "collapsed")'>
					<path d="M0,6 l15,0 l15,0"></path>
					<path d="M0,17 l15,0 l15,0"></path>
					<path d="M0,28 l15,0 l15,0"></path>
				</svg>
		  </div>
	   </div>
	</div>
	<div class="icon-scroll-down hidden" id="btn-scroll-down" onclick="bblivechat.setScrollFromBottom()"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="40" viewBox="0 0 171 171" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,171.9977v-171.9977h171.9977v171.9977z" fill="none"></path><g id="original-icon" fill="#3498db"><path d="M85.70039,7.42781c-43.37789,0 -78.66,35.28211 -78.66,78.66c0,43.37789 35.28211,78.66 78.66,78.66c43.36453,0 78.66,-35.28211 78.66,-78.66c0,-43.37789 -35.29547,-78.66 -78.66,-78.66zM115.27805,101.59805l-27.36,27.36c-0.30726,0.32062 -0.69469,0.5611 -1.10883,0.73477c-0.41414,0.17367 -0.86836,0.26719 -1.30922,0.26719c-0.44086,0 -0.89508,-0.09352 -1.30922,-0.26719c-0.41414,-0.17367 -0.7882,-0.41414 -1.10883,-0.73477l-27.36,-27.36c-1.33594,-1.33594 -1.33594,-3.50015 0,-4.83609c1.33594,-1.33594 3.50015,-1.33594 4.83609,0l21.52195,21.52195v-73.82391c0,-1.88367 1.53633,-3.42 3.42,-3.42c1.88367,0 3.42,1.53633 3.42,3.42v73.82391l21.52195,-21.52195c1.33594,-1.33594 3.50015,-1.33594 4.83609,0c1.33594,1.33594 1.33594,3.50015 0,4.83609z"></path></g></g></svg></div>
</footer>

</div>

</div>
</div>

<div id="open-modal-help" class="modal-window">
  <div style="position:fixed;width:100vw;height:100vh;background:transparent;z-index:998;" onclick="window.location.replace('#');"></div>
  <div style="z-index:999;">
	<a href="#" title="Close" class="modal-close"><?php echo $bblivechat->getLang('closeBtn'); ?></a>
	<h1><?php echo $bblivechat->getLang('help'); ?></h1>
	<div id="helpContainer">
		<div id="helpList">
			<table>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescJoin'); ?></td>
					<td class="code" id="L_helpItemCodeJoin">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeJoin" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeJoin'); ?>" readonly="readonly">
					</td>
				</tr>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescInvite'); ?></td>
					<td class="code" id="L_helpItemCodeInvite">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeInvite" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeInvite'); ?>" readonly="readonly">
					</td>
				</tr>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescUninvite'); ?></td>
					<td class="code" id="L_helpItemCodeUninvite">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeUninvite" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeUninvite'); ?>" readonly="readonly">
					</td>
				</tr>
				<tr>
					<td class="desc"><?php echo $user->lang('FORUM_INDEX'); ?>:</td>
					<td class="code" id="L_helpItemCodeLogout">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeLogout" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeLogout'); ?>" readonly="readonly">
					</td>
				</tr>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescPrivateMessage'); ?></td>
					<td class="code" id="L_helpItemCodePrivateMessage">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodePrivateMessage" type="text" value="<?php echo $bblivechat->getLang('helpItemCodePrivateMessage'); ?>" readonly="readonly">
					</td>
				</tr>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescQueryOpen'); ?></td>
					<td class="code" id="L_helpItemCodeQueryOpen">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeQueryOpen" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeQueryOpen'); ?>" readonly="readonly">
					</td>
				</tr>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescQueryClose'); ?></td>
					<td class="code" id="L_helpItemCodeQueryClose">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeQueryClose" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeQueryClose'); ?>" readonly="readonly">
					</td>
				</tr>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescAction'); ?></td>
					<td class="code" id="L_helpItemCodeAction">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeAction" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeAction'); ?>" readonly="readonly">
					</td>
				</tr>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescDescribe'); ?></td>
					<td class="code" id="L_helpItemCodeDescribe">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeDescribe" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeDescribe'); ?>" readonly="readonly">
					</td>
				</tr>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescIgnore'); ?></td>
					<td class="code" id="L_helpItemCodeIgnore">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeIgnore" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeIgnore'); ?>" readonly="readonly">
					</td>

				</tr>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescIgnoreList'); ?></td>
					<td class="code" id="L_helpItemCodeIgnoreList">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeIgnoreList" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeIgnoreList'); ?>" readonly="readonly">
					</td>
				</tr>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescWhereis'); ?></td>
					<td class="code" id="L_helpItemCodeWhereis">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeWhereis" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeWhereis'); ?>" readonly="readonly">
					</td>
				</tr>
			<?php if ($bblc_admin || $bblivechat->getUserRole() == AJAX_CHAT_MODERATOR) { ?>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescKick'); ?></td>
					<td class="code" id="L_helpItemCodeKick">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeKick" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeKick'); ?>" readonly="readonly">
					</td>
				</tr>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescUnban'); ?></td>
					<td class="code" id="L_helpItemCodeUnban">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeUnban" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeUnban'); ?>" readonly="readonly">
					</td>
				</tr>
				<tr>

					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescBans'); ?></td>
					<td class="code" id="L_helpItemCodeBans">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeBans" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeBans'); ?>" readonly="readonly">
					</td>
				</tr>
			<?php } ?>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescWho'); ?></td>
					<td class="code" id="L_helpItemCodeWho">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeWho" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeWho'); ?>" readonly="readonly">
					</td>
				</tr>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescList'); ?></td>
					<td class="code" id="L_helpItemCodeList">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeList" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeList'); ?>" readonly="readonly">
					</td>
				</tr>
				<tr>
					<td class="desc"><?php echo $bblivechat->getLang('helpItemDescRoll'); ?></td>
					<td class="code" id="L_helpItemCodeRoll">
						<input class="shareUrl-input js-shareUrl" id="L_helpItemCodeRoll" type="text" value="<?php echo $bblivechat->getLang('helpItemCodeRoll'); ?>" readonly="readonly">
					</td>

				</tr>
				<?php echo \sitesplat\apply_filters('bblivechat_help', ''); ?>
			</table>
		</div>
  	</div>
	<small><a href="https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat" target="_blank" class="modal-help"><?php echo $bblivechat->getLang('getBlivechat'); ?></a></small>
  </div>
</div>
</div>
<script src="../ext/sitesplat/bblivechat/chat/js/bblivechat.js?v=<?php echo $bblc_js_time; ?>"></script>
<script>
	/* removes the announcement after 10 seconds */
	const bblc_ann = document.querySelector('.chat-connectivity-indicator');
	if (bblc_ann) {
		setTimeout("bblc_ann.style.cssText = 'transition:top 3s linear;top:-500px'", 10000);
	}
	const bblivechat = new BBlivechat();
	const bblc_lang = <?php echo json_encode($bblivechat->jslang, 320); ?>;
	const bblc_config = <?php echo bblc_js_config(); ?>;
	bblivechat.setUserData(<?php echo bblc_userdata(); ?>);
	bblivechat.setLoginChannelName("<?php echo $bblivechat->getChannelName(); ?>");
	<?php echo $bblivechat->timeago['js']; ?>
</script>
<script src="../ext/sitesplat/bblivechat/chat/js/optiscroll.min.js?v=<?php echo $bblc_jso_time; ?>"></script>
<?php echo $bblc_js; ?>

<?php
if (empty($bblc_settings[1])) {
?>
</body>
</html><?php

}
