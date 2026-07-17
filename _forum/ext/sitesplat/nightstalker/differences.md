Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/sitesplat\\nightstalker/diff_full.tmp" "[FORUM_EXT]/sitesplat\\nightstalker/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\nightstalker/diff_full.tmp"
@@ -0,0 +1,2870 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.bak" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.bak"
+new file mode 100644
+index 000000000..88b97dac6
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.bak"
+@@ -0,0 +1,1610 @@
++/*****************************************************************
++* Custom CSS Stylesheet. You can add any custom CSS selectors here after the comment line. 
++* They will be given the highest priority on any elements on the forum
++* **************************************************************
++*
++* FLATBOOTS @SiteSplat.com - Custom CSS STYLESHEET - DARK Theme
++* 
++***************************************************************
++*****************************************************************/
++/* ===[ CSS HOOK TOP ]=== */
++body {
++    background: #333 url(./images/bg.png) repeat repeat 100% 0;
++    // color: #fff
++	// background-color: #333;
++}
++
++a:link {
++    color: #fff
++}
++
++a:visited {
++    color: #fafafa
++}
++
++a:hover {
++    color: #fafafa
++}
++
++#contentje h1,
++#contentje h2,
++#contentje h3,
++#contentje h4,
++#contentje h5,
++#contentje h6,
++#contentje h1 a,
++#contentje h2 a,
++#contentje h3 a,
++#contentje h4 a,
++#contentje h5 a,
++#contentje h6 a {
++    color: #fff!important
++}
++
++.codebox {
++    background-color: #444
++}
++
++code {
++    background-color: #555
++}
++
++.codebox code {
++    color: #fafafa
++}
++
++.content blockquote {
++    background: #555
++}
++
++.btn-default.disabled,
++.btn-default[disabled],
++fieldset[disabled] .btn-default,
++.btn-default.disabled:hover,
++.btn-default[disabled]:hover,
++fieldset[disabled] .btn-default:hover,
++.btn-default.disabled:focus,
++.btn-default[disabled]:focus,
++fieldset[disabled] .btn-default:focus,
++.btn-default.disabled:active,
++.btn-default[disabled]:active,
++fieldset[disabled] .btn-default:active,
++.btn-default.disabled.active,
++.btn-default.active[disabled],
++fieldset[disabled] .btn-default.active {
++    background-color: #999
++}
++
++#qr_postform .col-md-snappy {
++    background: rgba(12, 12, 12, 0.82) none repeat scroll 0 0
++}
++
++.prefix-popover {
++    background-color: #555;
++    border: 2px solid #444
++}
++
++.prefix-popover:after {
++    border-top: 10px solid #444
++}
++
++.breadcrumb-buttons {
++    background: #555;
++    border-radius: 0
++}
++
++.popup-box {
++    background: #555
++}
++
++.profile-data h3 {
++    border-bottom: none!important
++}
++
++.navbar-inverse {
++	// background: #333 url("./images/bg-maintitle.png") repeat-x scroll 0 0;
++    border-color: #222
++}
++
++.navbar-nav-fancy > li > a:hover i {
++    color: #fff;
++}
++
++.flat-nav .navbar-nav > .open > a,
++.flat-nav .navbar-nav > .open > a:hover,
++.flat-nav .navbar-nav > .open > a:focus,
++.flat-nav .navbar-nav > .active > a,
++.flat-nav .navbar-nav > .active > a:hover,
++.flat-nav .navbar-nav > .active > a:focus {
++	background-color: #888;
++}
++
++.navbar-nav-fancy > li:before {
++    background: #888;
++}
++
++.blog-meta {
++    background: #ffa800
++}
++
++.top-flat {
++    background-color: #ffa800
++}
++
++.top-flat:hover {
++-webkit-transition : all .1s linear 0s;
++transition: all .1s linear 0s;
++    color: #2d2d2d!important;
++    border-bottom: none;
++    background-color: #fff;
++}
++.top-flat:hover:after {
++	color: #2d2d2d;
++}
++
++.section-pre-footer .thumb i {
++    color: #ffa800;
++}
++
++.side-segment > h3 {
++    color: #fff;
++}
++
++.side-segment h3:after,
++.side-segment h2:after {
++    background-color: #ffa800
++}
++
++a.forumtitle,
++a.topictitle,
++a.topictitleattribute {
++    color: #ffa800
++}
++
++.mobile-post {
++    background: #222;
++    color: #cacaca
++}
++
++.btn-notification {
++    background-color: #555
++}
++
++.notification-block img,
++.dropdown-avatar img,
++.profile-avatar img {
++    border-color: #555
++}
++
++.list-group-item-info,
++a.list-group-item-info,
++.bg-info {
++    background-color: #555
++}
++
++.square-icon {
++    border: 3px solid #444
++}
++
++.list-group-item-warning,
++a.list-group-item-warning,
++.bg-warning {
++    background-color: #555
++}
++
++.bg-success,
++a.list-group-item-success,
++.list-group-item-success {
++    background-color: #555
++}
++
++.bg-primary,
++.list-group-item-primary {
++    background-color: #555
++}
++
++/* ===[ SMART COLLAPSE ]=== */
++ /* ========================================================================
++   Component: placeholder.less
++ ========================================================================== */
++.box-placeholder {
++  border: 2px dashed #999;
++  background: #555;
++}
++/* ===[ SMART COLLAPSE ]=== */
++
++.panel-default > .panel-heading {
++    border-color: transparent;
++    color: #fff
++}
++
++.postbody .content {
++    color: #ccc
++}
++
++.well {
++    background-color: #262626;
++    border: 3px solid #999
++}
++
++li .no_notifications {
++    border-bottom: none!important
++}
++
++.form-actions {
++    background: #444;
++    border: 2px solid #999
++}
++
++.nav-tabs {
++    background: #333
++}
++
++.nav-tabs > li.active > a,
++.nav-tabs > li.active > a:focus,
++.nav-tabs > li.active > a:hover {
++    background-color: #222;
++    color: #ccc
++}
++
++.control-label {
++    color: #ccc
++}
++
++.masthead:before {
++    background-color: #222
++}
++
++.mastbottom {
++    background-color: #222
++}
++
++.dropdown-menu {
++    border: 4px solid #999;
++    background-color: #262626
++}
++
++.dropdown-menu > li > a:hover {
++    background: #999;
++    color: #fff
++}
++
++.dropdown-menu > li > a:hover i {
++    color: #fff
++}
++
++.user-login .navbar-footer {
++    background-color: #555
++}
++
++.user-login-drop > li:first-child {
++    background-color: #555
++}
++
++.arrow-up:before {
++    border-color: rgba(12, 12, 12, 0) rgba(12, 12, 12, 0) #999
++}
++
++.modal-header {
++    border-bottom: 1px solid #555
++}
++
++.modal-content {
++    background-color: #444
++}
++
++.modal-footer {
++    border-top: 1px solid #555
++}
++
++.profile-data.modal-body h3 {
++    border-bottom: none!important
++}
++
++.mini-profile-contact li a.default-contact {
++    background-color: #555
++}
++
++.avatar-over>.status:before {
++    border: 4px solid #555
++}
++
++.panel-login {
++    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0
++}
++
++.panel-login .signin-text span {
++    background: #252525
++}
++
++.panel-heading {
++    border-color: #555
++}
++
++.panel-forum {
++    background: rgba(12, 12, 12, 0.9)
++}
++
++.panel-forum > .panel-heading {
++    background: rgba(12, 12, 12, 0) url("./images/bg-maintitle.png") repeat-x scroll 0 50%
++}
++
++.panel-default {
++    border-color: #999
++}
++
++.panel {
++    background: rgba(24, 24, 24, 0.9)
++}
++
++.panel > .panel-heading {
++    background: rgba(12, 12, 12, 0) url("./images/bg-maintitle.png") repeat-x scroll 0 50%;
++    background-size: cover
++}
++
++.panel-body {
++    background-color: rgba(0, 0, 0, 0.1);
++    background-image: -webkit-gradient(linear, left top, left bottom, from(#252525), to(#181818));
++    background-image: -moz-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
++}
++
++.panel-footer {
++    background-color: rgba(0, 0, 0, 0.1);
++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
++    background-image: -moz-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent);
++    border-top: 1px solid #555
++}
++
++.form-control {
++    background: #262626;
++    color: #999
++}
++
++.tag-editor .placeholder, .tag-editor input {
++	color: #999;
++}
++
++.tag-editor input:focus {
++    box-shadow: none;
++}
++
++.control-bbtags .tag-editor {
++	border: 2px solid #444;
++	background: #181818;
++    color: #999;
++}
++
++.tag-editor .tag-editor-tag {
++    color: #8d9aa5;
++    background: #444;
++}
++
++.tag-editor .tag-editor-delete {
++    background: #444;
++}
++
++.tag-editor .tag-editor-delete i:before{
++    color: #8d9aa5;
++}
++
++.attachbox {
++    background-color: #262626
++}
++
++.separator i {
++    background: rgba(12, 12, 12, 0.1) -moz-linear-gradient(center top, rgba(255, 255, 255, 0.09) 0%, transparent 100%) repeat scroll 0 0
++}
++
++.pagination > li > a,
++.pagination > li > span {
++    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0
++}
++
++.pagination > li > a,
++.pagination > li > span:hover {
++    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0
++}
++
++.pagination > li > a,
++.pagination > li > span {
++    border: 2px solid #999
++}
++
++.pagination > .active > a,
++.pagination > .active > span,
++.pagination > .active > a:hover,
++.pagination > .active > span:hover,
++.pagination > .active > a:focus,
++.pagination > .active > span:focus {
++    background-color: #555;
++    border-color: #999;
++    color: #999
++}
++
++.pagination > li > a:focus,
++.pagination > li > a:hover,
++.pagination > li > span:focus,
++.pagination > li > span:hover {
++    background-color: #555;
++    color: #999
++}
++
++.pager li > a,
++.pager li > span {
++    background-color: #444;
++    border: 1px solid #333
++}
++
++.pager li > a:focus,
++.pager li > a:hover {
++    background-color: #555;
++    border: 1px solid #444;
++    color: #999
++}
++
++.separator:before {
++    background: #999
++}
++
++.separator i {
++    background: transparent
++}
++
++.btn-default {
++    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0
++}
++
++.btn-default:hover,
++.btn-default:focus,
++.btn-default:active,
++.btn-default.active,
++.open .dropdown-toggle.btn-default {
++    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
++    border-color: #999
++}
++
++.dropdown-menu > li > a:focus,
++.dropdown-menu > li > a:hover {
++    background-color: #777
++}
++
++.btn-default.active.focus,
++.btn-default.active:focus,
++.btn-default.active:hover,
++.btn-default.focus:active,
++.btn-default:active:focus,
++.btn-default:active:hover,
++.open > .dropdown-toggle.btn-default.focus,
++.open > .dropdown-toggle.btn-default:focus,
++.open > .dropdown-toggle.btn-default:hover {
++    background-color: #777
++}
++
++.btn-default {
++    color: #e0e0e0!important
++}
++
++.btn-default:hover {
++    color: #fff!important
++}
++
++.ui-timeline .tl-item .tl-body .tl-content {
++    background-color: #444
++}
++
++.ui-timeline .tl-item .tl-body .tl-content:after {
++    border-color: rgba(12, 12, 12, 0) #444 rgba(12, 12, 12, 0) rgba(12, 12, 12, 0)
++}
++
++.ui-timeline .tl-item.alt .tl-body .tl-content:after {
++    border-color: rgba(12, 12, 12, 0) rgba(12, 12, 12, 0) rgba(12, 12, 12, 0) #444
++}
++
++.ui-timeline .tl-item .tl-body .tl-time {
++    color: #fff
++}
++
++.square-icon {
++    box-shadow: none
++}
++
++.notification-content li {
++    border-bottom: 4px solid #999
++}
++
++.counter {
++    text-shadow: none
++}
++
++.login-full .signin-text span {
++    background: #262626
++}
++
++.login-full {
++    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
++    padding: 20px
++}
++
++.breadcrumb-line {
++    background: #262626
++}
++
++.breadcrumb {
++    background: #262626
++}
++
++.breadcrumb li:first-child a {
++    background: #262626
++}
++
++.panel-post .panel-bottom {
++    background-color: #262626
++}
++
++.section-page {
++    background: rgba(255, 255, 255, 0.07);
++    background-color: rgba(255, 255, 255, 0.07)
++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
++    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
++    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
++}
++
++.icon-wrapper {
++    background: rgba(255, 255, 255, 0.1);
++    background-color: rgba(255, 255, 255, 0.1);
++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
++}
++
++.table-primary tbody tr:nth-child(2n+1) td,
++.table-primary tbody tr:nth-child(2n+1) th {
++    background-color: rgba(0, 0, 0, 0.1);
++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
++}
++
++.table {
++    background: inherit
++}
++
++table .stats-col {
++    background-color: rgba(0, 0, 0, 0.1)!important;
++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent))!important;
++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%)!important;
++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)!important
++}
++
++.table-primary tbody td {
++    background: url("./images/highlight_reallyfaint.png");
++    background-color: rgba(0, 0, 0, 0.1);
++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
++}
++
++.table-primary tbody tr:nth-child(2n+1) td,
++.table-primary tbody tr:nth-child(2n+1) th {
++    background: url("./images/highlight_reallyfaint.png");
++    background-color: rgba(0, 0, 0, 0.1);
++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
++}
++
++.table tr.active td,
++.table tr.active {
++    background-color: rgba(0, 0, 0, 0.1);
++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
++}
++
++.table > thead > tr > th {
++    background-color: rgba(0, 0, 0, 0.1);
++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
++}
++
++.table-hover > tbody > tr:hover > td,
++.table-hover > tbody > tr:hover > th {
++    background-color: rgba(0, 0, 0, 0.1);
++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent);
++    color: #888
++}
++
++.table-striped > tbody > tr:nth-of-type(2n+1) {
++    background-color: inherit
++}
++
++.table-hover > tbody > tr:hover > td,
++.table-hover > tbody > tr:hover > th {
++    background-color: rgba(0, 0, 0, 0.1);
++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent);
++    color: #888
++}
++
++.table-striped > tbody > tr:hover {
++    background-color: rgba(0, 0, 0, 0.1);
++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
++}
++
++.table > thead > tr > th,
++.table > tbody > tr > th,
++.table > tfoot > tr > th,
++.table > thead > tr > td,
++.table > tbody > tr > td,
++.table > tfoot > tr > td {
++    border-top: 4px solid rgba(255, 255, 255, 0.09)
++}
++
++.form-control {
++    border: 2px solid #444
++}
++
++.form-control[disabled],
++.form-control[readonly],
++fieldset[disabled] .form-control {
++    background-color: #363636
++}
++
++.panel-post h6,
++.panel-post h6 > a {
++    color: #666!important
++}
++
++.alert-default {
++    background-color: #222;
++    border-color: #999;
++    color: #555
++}
++
++.comment_starter {
++    background: #555;
++    color: #ccc
++}
++
++.comment-body {
++    color: #ccc
++}
++
++.comment_reply {
++    background: #444;
++    border-top: 1px solid #777
++}
++
++.comment footer {
++    background-color: #555
++}
++
++.list-group-item {
++    background: #444
++}
++
++a.list-group-item:focus,
++a.list-group-item:hover {
++    background-color: #555;
++    color: #999
++}
++
++.input-group-addon {
++    background-color: #444;
++    border: 2px solid #444;
++    color: #999
++}
++
++.nav-tabs > li > a:hover,
++.nav-tabs > li > a:focus {
++    background-color: #555
++}
++
++.progress {
++    background-color: #444
++}
++
++.thumbnail {
++    background-color: #444;
++    border: 1px solid #999
++}
++
++.alert-default {
++    background-color: #222;
++    border: 2px solid #999;
++    color: #555
++}
++
++#darken {
++    opacity: .7
++    -ms-filter : "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
++}
++
++.close {
++    color: #fff!important;
++    text-shadow: 0 1px 0 transparent
++}
++
++.phpbb_alert p {
++    color: #fff
++}
++
++.bbtag, .bbtags-topic .bbtag {
++    color: #888 !important;
++}
++
++.bbtag:before, .bbtag:after {
++    background: #222;
++}
++
++.bbtag:hover, .bbtags-topic .bbtag:hover  {
++    background-color: #ffa800;
++}
++
++.bbtag:hover:after, .bbtags-topic .bbtag:hover:after {
++    border-left-color: #ffa800;
++}
++
++.bbtags-topic .bbtag:before, .bbtags-topic .bbtag:after {
++    background: #333;
++}
++
++.section-pre-footer {
++    background: transparent
++}
++
++.section-pre-footer .section-bg {
++    background: #292929
++}
++
++@media (max-width:767px) {
++	.container>.navbar-header {
++		padding-bottom: 5px;
++	}
++	.section-pre-footer .section-bg {
++		background: none repeat scroll 0 center transparent;
++	}
++}
++
++@media (max-width:468px) {
++	.section-pre-footer .section-bg {
++		background: none repeat scroll 0 center transparent;
++	}
++}
++
++.section-pre-footer p, .twitter h3 a small, .copyrights, .debug-output {
++	color: #888;
++}
++
++.twitter h3 a small:hover {
++	color: #ffa800;
++}
++
++.section-pre-footer a:hover,
++.footer-nav a:hover,
++.debug-output a:hover {
++	color: #ffa800;
++}
++
++.burned-asphalt {
++    background-color: transparent
++}
++
++.avatar-over img {
++    border: 4px solid #555
++}
++
++h3 {
++    border-bottom: 4px solid #777!important
++}
++
++.popover {
++    background-color: #333
++}
++
++.popover.right > .arrow::after {
++    border-right-color: #444
++}
++
++.popover-title {
++    background-color: #555
++}
++
++.badge_award h3 {
++    border-bottom: none
++}
++
++.footable.breakpoint > tbody > tr > td > span.footable-toggle {
++    background: #222;
++    color: #cacaca
++}
++
++.footable.breakpoint > tbody > tr.footable-row-detail {
++    background: #222
++}
++
++.search-input-fullscreen {
++    background-color: #333
++}
++
++.search-input-fullscreen input:focus {
++box-shadow: none;
++}
++
++.label-huskygray {
++    background-color: #333;
++    float: left!important
++}
++
++.sidebar .panel {
++    border-radius: 6px 6px 2px 2px;
++    background-color: none
++}
++
++#page-sidebar .panel-inverse > .panel-heading {
++    background-color: #505b72
++}
++
++#page-sidebar .panel-info > .panel-heading {
++    background-color: #5bc0de
++}
++
++#page-sidebar .panel-primary > .panel-heading {
++    background-color: #337ab7
++}
++
++#page-sidebar .panel-success > .panel-heading {
++    background-color: #2dcb73
++}
++
++#page-sidebar .panel-body {
++    background-color: #222
++}
++
++.list-announcement .panel-body ul > li a {
++    color: #fafafa
++}
++
++.list-announcement .panel-body ul > li small {
++    color: #ccc
++}
++
++.user-list .media-body small.date,
++.list-announcement .media-body small.date {
++    color: #ccc
++}
++
++.card .com-contain {
++    background: rgba(12, 12, 12, 0.7)
++}
++
++.com-stuff {
++    background: rgba(12, 12, 12, 0) -webkit-radial-gradient(center center ellipse, rgba(12, 12, 12, 1) 0%, rgba(12, 12, 12, 0) 100%)
++    background: rgba(12, 12, 12, 0) radial-gradient(ellipse at center center , rgba(12, 12, 12, 1) 0%, rgba(12, 12, 12, 0 100%);
++}
++
++.avn-price-table.avn-style12 {
++    background: #666
++}
++
++.avn-price-table.avn-style12 .avn-tagline {
++    color: #fafafa
++}
++
++.share-button {
++    background-color: #333;
++    border: 1px solid #444
++}
++
++.share-button > a:hover,
++.share-button > a:hover:after {
++    color: #ddd;
++    background-color: #3c3c3c;
++    border-color: #888
++}
++
++.icons-wrapper {
++    background-color: #3c3c3c
++}
++
++.share-button .icons-wrapper ul li:last-child a {
++    background-color: #444
++}
++
++.share-button .icons-wrapper ul li a:hover i {
++    color: #555
++}
++
++.share-button a:hover,
++.share-button button:hover,
++.share-button a:focus,
++.share-button button:focus {
++    color: #ddd
++}
++
++.sidebar .panel {
++    background-color: #292c2e!important
++}
++
++.sidebar .panel-info > .panel-heading {
++    background-color: #444;
++    border-color: transparent
++}
++
++.sidebar .panel-body {
++    border-bottom-left-radius: 4px;
++    border-bottom-right-radius: 4px;
++    border-color: #444;
++    border-image: none;
++    border-style: none solid solid;
++    border-width: medium 1px 1px
++}
++
++.panel-primary > .panel-heading,
++.panel-info > .panel-heading,
++.panel-custom > .panel-heading,
++.panel-success > .panel-heading,
++.panel-warning > .panel-heading {
++    background-color: #444;
++    border-color: transparent
++}
++
++.user-list .media-object {
++    border: 2px solid #444
++}
++
++.list-announcement .panel-body ul > li small {
++    color: #fff
++}
++
++.list-announcement .panel-body ul > li a {
++    color: #ffd700
++}
++
++.sidebar .nav > li > a:focus,
++.sidebar .nav > li > a:hover {
++    background-color: #444
++}
++
++.list-group-item {
++    background-color: #444;
++    border: 1px solid #555
++}
++
++.list-group-item.active,
++.list-group-item.active:focus,
++.list-group-item.active:hover {
++    background-color: #555;
++    border-color: #555
++}
++
++a.list-group-item:focus,
++a.list-group-item:hover,
++button.list-group-item:focus,
++button.list-group-item:hover {
++    background-color: #626262;
++    color: #fafafa
++}
++
++.panel-poll {
++    border-color: transparent;
++    border-style: solid;
++    border-width: 2px
++}
++
++.mini-timeline::before {
++    background: #555
++}
++
++.mini-timeline > li:last-child::before {
++    background: #555
++}
++
++.mini-timeline > li .timeline-body {
++    background-color: transparent
++}
++
++.cc-revoke, .cc-window {
++	background: #181818;
++}
++.cc-link, .cc-link:focus {
++	color: #ffa800 !important;
++}
++.com-stuff p {
++    color: #8c8c8c;
++    font-size: 16px;
++}
++.btn.focus, .btn:focus, .btn:hover {
++    color: #e4e4e4;
++}
++.btn-default {
++    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
++}
++.btn-default:hover,
++.btn-default:focus,
++.btn-default:active,
++.btn-default.active,
++.open .dropdown-toggle.btn-default {
++    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
++}
++
++.donation-actions {
++    background-color: #262626;
++    border: 3px solid #999
++}
++
++.donation-actions p {
++    color: #8d9aa5
++}
++
++.donation-premium > strong,
++#donationicons .amt-donation {
++    color: #ffa800
++}
++#donationmessage, #submission {
++    background-color: #444;
++}
++#donationmessage h3 {
++	color: #ffa800;
++    border-bottom: none !important;
++}
++.donation-actions h2,
++#donationicons > span + p span {
++    color: #fafafa
++}
++.donation-actions p a,
++#submission output {
++    color: #ffa800
++}
++#donationicons > span.selected:before {
++    color: #7F7F7F;
++    text-shadow: 1px 1px 2px rgba(12, 12, 12, 0.5)
++}
++#donationicons > span:before {
++    color: rgba(21, 23, 25, 0.8);
++    /* this creates the "inset" text shadow */
++    text-shadow: 1px 2px 2px #222, 0 0 0 #000, 1px 2px 2px #222, 0 1px 1px rgba(255, 255, 255, 0.5)
++}
++#donationicons > span:after {
++    border-bottom: 7px solid #444
++}
++
++input:focus {
++    outline: none!important;
++    border-color: #CDCDCD
++    box-shadow: 0 0 10px #CDCDCD;
++}
++
++input[type=range] {
++    background-color: #999
++}
++
++input[type=range]::-webkit-slider-runnable-track {
++    background-color: #444
++}
++
++input[type=range]::-moz-range-track {
++    background-color: #444
++}
++
++input[type="range"]::-ms-track {
++    background-color: #444
++}
++
++input[type=range]::-webkit-slider-thumb {
++    background: -webkit-linear-gradient(left, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), -webkit-linear-gradient(left, #959595, #BBB 40%, #BBB 60%, #959595);
++    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBB 40%, #BBB 60%, #959595);
++    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBB inset, 0 5px 10px rgba(12, 12, 12, 0.5)
++}
++
++input[type=range]::-webkit-slider-thumb:hover,
++input[type=range]::-webkit-slider-thumb:active {
++    background: -webkit-linear-gradient(left, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), -webkit-linear-gradient(left, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
++    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4)
++}
++
++input[type=range]::-moz-range-thumb {
++    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBB 40%, #BBB 60%, #959595);
++    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBB inset, 0 5px 10px rgba(12, 12, 12, 0.5)
++}
++
++input[type=range]::-moz-range-thumb:hover,
++input[type=range]::-moz-range-thumb:active {
++    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4)
++}
++
++input[type=range]::-ms-thumb {
++    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBB 40%, #BBB 60%, #959595);
++    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBB inset, 0 5px 10px rgba(12, 12, 12, 0.5)
++}
++
++input[type=range]::-ms-thumb:hover,
++input[type=range]::-ms-thumb:active {
++    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4)
++}
++
++#submission .btn-bbdonation {
++    background-color: #363636;
++    border: 0 none #444
++}
++
++#submission .btn-bbdonation:hover,
++#submission .btn-bbdonation:focus,
++#submission .btn-bbdonation:active {
++    background-color: #7f7f7f;
++    border: 0 none #d6d9e0
++}
++
++.member-info {
++    color: #8d9aa5
++}
++
++.member-info a {
++    color: #fafafa
++}
++
++.alert-info {
++    background-color: #8a6d3b
++}
++
++.side-segment > h3 {
++    color: #fff
++}
++
++.chat-row {
++    background-color: #222
++}
++
++.chat-row:nth-child(even) {
++    background-color: #323232
++}
++
++.chat-row:hover {
++    background-color: #121212
++}
++
++#chat-message textarea,
++#chat-dialog textarea {
++    background-color: #323232
++}
++
++#chat-right-panel,
++#chat-conversation-container,
++#chat-tabs li.active,
++#chat-toolbar a.active,
++.ic-box {
++    background: #323232
++}
++
++#chat-body {
++    color: #FFF
++}
++
++.blg-table {
++    color: #fff
++}
++
++.blg-table .blg-column-topic-title {
++    text-align: left
++}
++
++.blg-widget-content {
++    background: #252525;
++    border: 0
++}
++
++.blg-widget-header {
++    background: #353535;
++    border: 1px solid #171717;
++    color: #d6a400;
++    padding: 2px 2px 4px
++}
++
++input,
++textarea#mchat-input {
++    color: #181818
++}
++
++#chat-body blockquote {
++    background-color: #696969
++}
++
++.blg-state-hover a,
++.blg-state-hover a:hover {
++    color: #353535
++}
++
++.blg-state-default a,
++.blg-state-default a:link,
++.blg-state-default a:visited {
++    color: #171717
++}
++
++.blg-accordion > .blg-state-default a,
++.blg-accordion > .blg-state-default a:link,
++.blg-accordion > .blg-state-default a:visited {
++    color: #fff
++}
++
++.blg-accordion-icons .blg-accordion-header {
++    background-color: transparent;
++    color: #FFF
++}
++
++.blg-calendar-info {
++    background: #252525
++}
++
++.blg-calendar-event {
++    background: #d6a400
++}
++
++.blg-dialog .blg-dialog-content,
++.blg-dialog .dialog-text {
++    color: #ddd
++}
++
++.blg-state-default {
++    background: #f5f5f5;
++    border: 1px solid #282828;
++    color: #333
++}
++
++.blg-state-highlight {
++    background: #fbec88!important;
++    color: #363636!important
++}
++
++.blg-state-hover,
++.blg-state-focus {
++    background: #f2f2f2;
++    border: 1px solid #282828;
++    color: #222
++}
++
++.calendar tbody a {
++    color: #000
++}
++
++.calendar .month-title,
++.calendar .cal-header {
++    color: #fff
++}
++
++.calendar.autofit tbody a {
++    color: #d6a403;
++    background-color: transparent;
++    border-color: #181818
++}
++
++.calendar a.today {
++    color: #fff!important
++}
++
++.blg-inputbox {
++    color: #757575
++}
++
++.ads img {
++    opacity: 1;
++    filter: alpha(opacity=1)
++}
++
++.nightpanel {
++    padding-right: 0
++}
++
++.breadcrumb .icon {
++    color: #d6a400
++}
++
++.blg-icon {
++    color: #d6a400
++}
++
++a.blg-button {
++    color: #181818!important
++}
++
++.blg-align-center {
++    color: #fff
++}
++
++.panel-bottom-messages {
++    margin-top: 15px;
++    padding: 15px
++}
++
++.blg-calendar td {
++    background-color: #222
++}
++
++.blg-calendar-event.blg-event-birthday {
++    background: #ccc
++}
++
++#qm_main select,
++.qm-dialog select,
++.qm_inputbox,
++.qm-menu,
++.qm-button,
++.row_mark input {
++    color: #181818
++}
++
++.quick_mod_buttons {
++    background-color: transparent
++}
++
++a [class*="qm-icon"] {
++    color: #b8bdcb
++}
++
++@media (max-width: 768px) {
++    #donationicons > span:after {
++        border-bottom: medium none
++    }
++}
++
++.flatpickr-input {
++    background: transparent
++}
++
++.flatpickr-calendar {
++    background: #2b2a2a
++}
++
++.flatpickr-current-month {
++    color: #fff
++}
++
++span.flatpickr-weekday {
++    color: rgba(255, 255, 255, 0.54)
++}
++
++.flatpickr-day.flatpickr-disabled,
++.flatpickr-day.flatpickr-disabled:hover {
++    color: #d94444
++}
++
++.flatpickr-day {
++    color: #fff
++}
++
++.flatpickr-day.inRange,
++.flatpickr-day.prevMonthDay.inRange,
++.flatpickr-day.nextMonthDay.inRange,
++.flatpickr-day.today.inRange,
++.flatpickr-day.prevMonthDay.today.inRange,
++.flatpickr-day.nextMonthDay.today.inRange,
++.flatpickr-day:hover,
++.flatpickr-day.prevMonthDay:hover,
++.flatpickr-day.nextMonthDay:hover,
++.flatpickr-day:focus,
++.flatpickr-day.prevMonthDay:focus,
++.flatpickr-day.nextMonthDay:focus {
++    background: #714b4b
++}
++
++flatpickr-day.flatpickr-disabled,
++.flatpickr-day.flatpickr-disabled:hover,
++.flatpickr-day.prevMonthDay,
++.flatpickr-day.nextMonthDay,
++.flatpickr-day.notAllowed,
++.flatpickr-day.notAllowed.prevMonthDay,
++.flatpickr-day.notAllowed.nextMonthDay {
++    color: rgba(155, 88, 88, 0.3)
++}
++
++.flatpickr-time input {
++    color: #fffbfb
++}
++
++.flatpickr-time .flatpickr-time-separator,
++.flatpickr-time .flatpickr-am-pm {
++    color: #fff
++}
++
++.flatpickr-time input:hover,
++.flatpickr-time .flatpickr-am-pm:hover,
++.flatpickr-time input:focus,
++.flatpickr-time .flatpickr-am-pm:focus {
++    background: #45a1ce
++}
++
++/* ===[ BBDOWNLOADS START ]=== */
++.widget,
++.post {
++    box-shadow: none
++}
++
++.post .details {
++    background: rgba(0, 0, 0, 0.9);
++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
++    color: #ccc
++}
++
++.widget .header.header-item {
++    background: rgba(40, 40, 40, 0.9) url("../../../../bbdownloads/styles/FLATBOOTS/theme/images/item-header-pattern.png") repeat scroll 0 0
++}
++
++.container.with_sidebar .et_pb_column_sidebar {
++    background: rgba(38, 38, 38, 0.9)
++}
++
++.btn.btn-primary.changelog {
++    background: #a1d36e
++}
++
++.btn.btn-primary.changelog:hover {
++    background: #94cd5a!important
++}
++
++.btn.btn-secondary {
++    background: #6ad1dd!important
++}
++
++.container-downloads .btn {
++    background: #777
++}
++/* ===[ BBDOWNLOADS END ]=== */
++
++/* ===[ BBMEMBERSHIP START ]=== */
++
++.npt-format-1 .npt-item {
++    background: rgba(0, 0, 0, 0.9)
++}
++
++.npt-plan-name {
++    border-bottom: 0 none!important
++}
++
++.npt-plan-bottom .avn-btn {
++    background: #181818 none repeat scroll 0 0
++}
++
++.npt-plan-bottom .avn-btn:hover {
++    background: #3a3a3a none repeat scroll 0 0
++}
++
++.thumbnail,
++.bg-group-info,
++.btn-primary {
++    background-color: #262626
++}
++
++.btn-primary:hover {
++    background-color: #3a3a3a!important
++}
++
++.text-muted {
++    color: #fff
++}
++/* ===[ BBMEMBERSHIP END ]=== */
++
++/* ===[ BBCHAT START ]=== */
++
++.rooms li {
++    border-bottom: .6em dotted #777
++}
++
++.person:before,
++.person:hover span {
++    background: #333
++}
++
++.bbchat .left .people a:link,
++.bbchat .left .people a:hover,
++.bbchat .left .people a:visited {
++    color: #8c8c8c
++}
++
++.bbchat,
++.bbchat .left,
++.bbchat .right {
++    background-color: #262626;
++    border-color: #999
++}
++
++.delete-message:before,
++.layout-list .delete-message:before {
++    border: 3px dashed #181818
++}
++
++.bbchat .right .top span .name,
++.me .bubble {
++    color: #fff
++}
++
++.bbchat .right .top:after {
++    background: -webkit-linear-gradient(bottom, rgba(38, 38, 38, 0) 10%, #262626 100%);
++    background: linear-gradient(to top, rgba(38, 38, 38, 0) 10%, #262626 100%)
++}
++
++.bbchat .right .top,
++.me .bubble:before,
++.me .bubble,
++.write input,
++.ps:hover.ps--in-scrolling.ps--y>.ps__scrollbar-y-rail,
++.ps:hover>.ps__scrollbar-y-rail:hover {
++    background-color: #333!important
++}
++
++.bbchat .right .write:before {
++    background: -webkit-linear-gradient(top, rgba(38, 38, 38, 0) 20%, #262626 100%);
++    background: linear-gradient(to bottom, rgba(38, 38, 38, 0) 20%, #262626 100%)
++}
++
++.write {
++    background-color: #333;
++    border-color: #999
++}
++
++.giphy>input {
++    border: 1px solid #999!important
++}
++
++#chatbox-input,
++.write input {
++    color: #8c8c8c
++}
++
++.giphy,
++.emoji-picker {
++    background-color: #181818
++}
++
++.bbchat-attachments-input {
++    background: #333;
++    box-shadow: 0 1px 15px 1px rgba(51, 51, 51, .12)
++}
++
++.bbchat-attachments-input>.button-upld {
++    background: #222 url(images/highlight_reallyfaint.png) repeat-x scroll 0 0
++}
++
++.bbchat-attachments-input:hover>.button-upld {
++    background: #777
++}
++/* ===[ BBCHAT END ]=== */
++.blog-summary {
++    color: #412525;
++}
++.blog-summary .btn {
++    margin-top: 10px;
++    background: #222222;
++    border: 1px solid #262626!important;
++}
++.blog-details {
++     background-color: #333;
++}
++.blog-title a {
++    color: #FFF!important;
++}
++
++.blog-item {
++    background: #333333;
++    border-radius: 5px;
++}
++.blog-quote .quote a {
++    border-radius: 0 0 10px 10px;
++}
++.blog-quote .blog-metas {
++    color: #ddd;
++}
++
++.textcomplete-item.active,
++.dropdown-menu>.active>a,
++.dropdown-menu>.active>a:focus,
++.dropdown-menu>.active>a:hover {
++    background-color:#161616;
++}
++/* ===[ CSS HOOK BOTTOM ]=== */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.css"
+index b85f8ae3d..73d0a07b1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.css"
+@@ -1,1240 +1 @@
+-/*****************************************************************
+-* Custom CSS Stylesheet. You can add any custom CSS selectors here after the comment line. 
+-* They will be given the highest priority on any elements on the forum
+-* **************************************************************
+-*
+-* FLATBOOTS @SiteSplat.com - Custom CSS STYLESHEET - DARK Theme
+-* 
+-***************************************************************
+-*****************************************************************/
+-/* ===[ CSS HOOK TOP ]=== */
+-body {
+-   // background: #000 url("./images/fallout4-background.jpg") repeat fixed 50% 0;
+-   // color: #fff;
+-   background-color: #333;
+-}
+-
+-a:link {
+-    color: #fff;
+-}
+-a:visited {
+-    color: #fafafa;
+-}
+-a:hover {
+-    color: #fafafa;
+-}
+-
+-
+-#contentje h1, #contentje h2, #contentje h3, #contentje h4, #contentje h5, #contentje h6,
+-#contentje h1 a, #contentje h2 a, #contentje h3 a, #contentje h4 a, #contentje h5 a, #contentje h6 a {
+-    color: #fff !important;
+-}
+-
+-.codebox {
+-    background-color: #444;
+-}
+-
+-code {
+-    background-color: #555;
+-}
+-
+-.codebox code {
+-   color: #fafafa;
+-}
+-
+-.content blockquote {
+-    background: #555;
+-}
+-
+-.btn-default.disabled, .btn-default[disabled], fieldset[disabled] .btn-default, .btn-default.disabled:hover, .btn-default[disabled]:hover, fieldset[disabled] .btn-default:hover, .btn-default.disabled:focus, .btn-default[disabled]:focus, fieldset[disabled] .btn-default:focus, .btn-default.disabled:active, .btn-default[disabled]:active, fieldset[disabled] .btn-default:active, .btn-default.disabled.active, .btn-default.active[disabled], fieldset[disabled] .btn-default.active {
+-    background-color: #999;
+-}
+-
+-#qr_postform .col-md-snappy {
+-    background: rgba(0, 0, 0, 0.82) none repeat scroll 0 0;
+-}
+-
+-.prefix-popover {
+-    background-color: #555;
+-    border: 2px solid #444;
+-}
+-
+-.prefix-popover:after {
+-    border-top: 10px solid #444;
+-}
+-
+-.breadcrumb-buttons {
+-    background: #555;
+-    border-radius: 0;
+-}
+-
+-.popup-box {
+-    background: #555;
+-}
+-
+-.profile-data h3 {
+-    border-bottom: none !important;
+-}
+-
+-.navbar-inverse {
+-    background: #000 url("./images/bg-maintitle.png") repeat-x scroll 0 0;
+-    border-color: #222;
+-}
+-
+-.navbar-nav-fancy > li > a:hover i {
+-    color: #fff;
+-}
+-
+-.flat-nav .navbar-nav > .open > a,
+-.flat-nav .navbar-nav > .open > a:hover,
+-.flat-nav .navbar-nav > .open > a:focus,
+-.flat-nav .navbar-nav > .active > a,
+-.flat-nav .navbar-nav > .active > a:hover,
+-.flat-nav .navbar-nav > .active > a:focus {
+-	background-color: #888;
+-}
+-
+-.navbar-nav-fancy > li:before {
+-    background: #888;
+-}
+-
+-.blog-meta {
+-    background: #ffa800;
+-}
+-
+-.top-flat {
+-    background-color: #ffa800;
+-}
+-
+-.top-flat:hover {
+--webkit-transition : all .1s linear 0s;
+-transition: all .1s linear 0s;
+-    color: #2d2d2d!important;
+-    border-bottom: none;
+-    background-color: #fff;
+-}
+-.top-flat:hover:after {
+-	color: #2d2d2d;
+-}
+-
+-.section-pre-footer .thumb i {
+-    color: #ffa800;
+-}
+-
+-.side-segment > h3 {
+-    color: #fff;
+-}
+-
+-.side-segment h3:after, .side-segment h2:after {
+-    background-color: #ffa800;
+-}
+-
+-a.forumtitle, a.topictitle {
+-    color: #ffa800;
+-}
+-
+-.mobile-post {
+-    background: #222;
+-    color: #cacaca;
+-}
+-
+-.btn-notification {
+-    background-color: #555;
+-}
+-
+-.notification-block img,
+-.dropdown-avatar img,
+-.profile-avatar img {
+-    border-color: #555;
+-}
+-
+-.list-group-item-info, a.list-group-item-info, .bg-info {
+-    background-color: #555;
+-}
+-
+-
+-.square-icon {
+-    border: 3px solid #444;
+-}
+-
+-.list-group-item-warning, a.list-group-item-warning, .bg-warning {
+-    background-color: #555;
+-}
+-
+-.bg-success, a.list-group-item-success, .list-group-item-success {
+-    background-color: #555;
+-}
+-
+-.bg-primary, .list-group-item-primary {
+-    background-color: #555;
+-}
+-
+-/* ===[ SMART COLLAPSE ]=== */
+- /* ========================================================================
+-   Component: placeholder.less
+- ========================================================================== */
+-.box-placeholder {
+-  border: 2px dashed #999;
+-  background: #555;
+-}
+-/* ===[ SMART COLLAPSE ]=== */
+-
+-.panel-default > .panel-heading {
+-    border-color: transparent;
+-    color: #fff;
+-}
+-
+-.postbody .content {
+-    color: #ccc;
+-} 
+- 
+-.well {
+-    background-color: #181818;
+-    border: 3px solid #999;
+-} 
+- 
+-li .no_notifications {
+-    border-bottom: none !important;
+-}
+- 
+-.form-actions {
+-    background: #444;
+-    border: 2px solid #999;
+-} 
+- 
+-.nav-tabs {
+-    background: #444;
+-}
+- 
+-.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
+-    background-color: #222;
+-    color: #ccc;
+-} 
+- 
+-.control-label {
+-    color: #ccc;
+-} 
+- 
+-.masthead:before {
+-    background-color: #222;
+-} 
+-
+-.mastbottom {
+-    background-color: #222;
+-} 
+- 
+-.dropdown-menu {
+-    border: 4px solid #999;
+-	background-color: #181818;
+-}
+-
+-.dropdown-menu > li > a:hover {
+-    background: #999;
+-    color: #fff;
+-}
+-
+-.dropdown-menu > li > a:hover i {
+-    color: #fff;
+-}
+-
+-.user-login .navbar-footer {
+-    background-color: #555;
+-}
+-
+-.user-login-drop > li:first-child {
+-    background-color: #555;
+-}
+- 
+-
+-.arrow-up:before {
+-    border-color: transparent transparent #999;
+-}
+-
+-.modal-header {
+-    border-bottom: 1px solid #555;
+-} 
+- 
+-.modal-content {
+-    background-color: #444;
+-} 
+- 
+-.modal-footer {
+-    border-top: 1px solid #555;
+-} 
+- 
+-.profile-data.modal-body h3 {
+-    border-bottom: none !important;
+-} 
+- 
+-.mini-profile-contact li a.default-contact {
+-    background-color: #555;
+-} 
+- 
+-
+-.avatar-over>.status:before {
+-    border: 4px solid #555;
+-} 
+- 
+-.panel-login {
+-    background: #181818 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+-} 
+- 
+-.panel-login .signin-text span {
+-    background: #181818;
+-} 
+-
+-.panel-heading {
+-    border-color: #555;
+-}
+- 
+- 
+-.panel-forum {
+-    background: rgba(0, 0, 0, 0.9);
+-}
+-
+-.panel-forum > .panel-heading {
+-    background: transparent url("./images/bg-maintitle.png") repeat-x scroll 0 50%;
+-} 
+- 
+- 
+-.panel-default {
+-    border-color: #999;
+-}
+- 
+-.panel{
+-    background: rgba(0, 0, 0, 0.9);
+-}
+-
+-.panel > .panel-heading {
+-    background: transparent url("./images/bg-maintitle.png") repeat-x scroll 0 50%;
+-	background-size:cover;
+-} 
+- 
+-.panel-body {
+-    background-color: rgba(0,0,0,0.1);
+-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-} 
+-
+-.panel-footer {
+-    background-color: rgba(0,0,0,0.1);
+-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-    border-top: 1px solid #555;
+-}
+-
+-.form-control {
+-    background: #181818;
+-	color: #999;
+-}
+-
+-.tag-editor .placeholder, .tag-editor input {
+-	color: #999;
+-}
+-
+-.tag-editor input:focus {
+-    box-shadow: none;
+-}
+-
+-.control-bbtags .tag-editor {
+-	border: 2px solid #444;
+-	background: #181818;
+-    color: #999;
+-}
+-
+-.tag-editor .tag-editor-tag {
+-    color: #8d9aa5;
+-    background: #444;
+-}
+-
+-.tag-editor .tag-editor-delete {
+-    background: #444;
+-}
+-
+-.tag-editor .tag-editor-delete i:before{
+-    color: #8d9aa5;
+-}
+- 
+-.attachbox {
+-    background-color: #181818;
+-}
+-
+-.separator i {
+-    background: rgba(0, 0, 0, 0.1) -moz-linear-gradient(center top , rgba(255, 255, 255, 0.09) 0%, transparent 100%) repeat scroll 0 0;
+-}
+- 
+-.pagination > li > a, .pagination > li > span {
+-    background: #222222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+-} 
+-
+-.pagination > li > a, .pagination > li > span:hover {
+-    background: #222222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+-} 
+- 
+-.pagination > li > a, .pagination > li > span {
+-    border: 2px solid #999;
+-} 
+-
+-.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
+-    background-color: #555;
+-    border-color: #999;
+-    color: #999;
+-}
+-
+-.pagination > li > a:focus,
+-.pagination > li > a:hover,
+-.pagination > li > span:focus,
+-.pagination > li > span:hover {
+-    background-color: #555;
+-	color: #999;
+-}
+-
+-
+-.pager li > a, .pager li > span {
+-    background-color: #444;
+-    border: 1px solid #333;
+-}
+-
+-.pager li > a:focus, 
+-.pager li > a:hover {
+-    background-color: #555;
+-    border: 1px solid #444;
+-	color: #999;
+-}
+-
+-.separator:before {
+-    background: #999;
+-}
+-
+-.separator i {
+-    background: transparent;
+-} 
+- 
+-.btn-default {
+-    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+-}
+-
+-.btn-default:hover,
+-.btn-default:focus,
+-.btn-default:active,
+-.btn-default.active,
+-.open .dropdown-toggle.btn-default {
+-    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+-}
+-
+-.btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .open .dropdown-toggle.btn-default {
+-    border-color: #999;
+-}
+-
+-
+-.dropdown-menu > li > a:focus, .dropdown-menu > li > a:hover {
+-    background-color: #777;
+-}
+-
+-.btn-default.active.focus, .btn-default.active:focus, .btn-default.active:hover, .btn-default.focus:active, .btn-default:active:focus, .btn-default:active:hover, .open > .dropdown-toggle.btn-default.focus, .open > .dropdown-toggle.btn-default:focus, .open > .dropdown-toggle.btn-default:hover {
+-    background-color: #777;
+-}
+-
+-.btn-default {
+-    color: #e0e0e0 !important;
+-}
+-
+-.btn-default:hover {
+-    color: #fff !important;
+-}
+-
+-
+-.ui-timeline .tl-item .tl-body .tl-content {
+-    background-color: #444;
+-}
+-
+-.ui-timeline .tl-item .tl-body .tl-content:after {
+-    border-color: transparent #444 transparent transparent;
+-}
+-
+-.ui-timeline .tl-item.alt .tl-body .tl-content:after {
+-    border-color: transparent transparent transparent #444;
+-}
+-
+-
+-.ui-timeline .tl-item .tl-body .tl-time {
+-    color: #fff;
+-}
+-
+-.square-icon {
+-    box-shadow: none;
+-}
+-
+-
+-.notification-content li {
+-    border-bottom: 4px solid #999;
+-}
+-
+-.counter {
+-    text-shadow: none;
+-}
+-
+-
+-.login-full .signin-text span {
+-    background: #181818;
+-}
+-
+-.login-full {
+-    background: #181818 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+-    padding: 20px;
+-}
+-
+-.breadcrumb-line {
+-    background: #181818;
+-}
+-
+-.breadcrumb li:first-child a {
+-    background: #222;
+-}
+-
+-.panel-post .panel-bottom {
+-    background-color: #181818;
+-}
+- 
+-.section-page {
+-    background: rgba(255, 255, 255, 0.1);
+-	background-color: rgba(255, 255, 255, 0.1);
+-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-}
+-
+-.icon-wrapper {
+-    background: rgba(255, 255, 255, 0.1);
+-    background-color: rgba(255, 255, 255, 0.1);
+-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-	}
+-
+-.table-primary tbody tr:nth-child(2n+1) td, .table-primary tbody tr:nth-child(2n+1) th {
+-    background-color: rgba(0,0,0,0.1);
+-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-}
+-
+-.table {
+-    background: inherit;
+-}
+-
+-
+-table .stats-col {
+-    background-color: rgba(0,0,0,0.1)!important;
+-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent))!important;
+-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent)!important;
+-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent)!important;
+-}
+-
+-
+-
+-.table-primary tbody td {
+-    background: url("./images/highlight_reallyfaint.png");
+-    background-color: rgba(0,0,0,0.1);
+-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-}
+-
+-.table-primary tbody tr:nth-child(2n+1) td,
+-.table-primary tbody tr:nth-child(2n+1) th {
+-    background: url("./images/highlight_reallyfaint.png");
+-    background-color: rgba(0,0,0,0.1);
+-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-}
+-
+-.table tr.active td,
+-.table tr.active {
+-    background-color: rgba(0,0,0,0.1);
+-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-}
+-
+-
+-.table > thead > tr > th {
+-    background-color: rgba(0,0,0,0.1);
+-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-}
+-
+-.table-hover > tbody > tr:hover > td,
+-.table-hover > tbody > tr:hover > th {
+-    background-color: rgba(0,0,0,0.1);
+-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-	color: #888;
+-}
+-
+-.table-striped > tbody > tr:nth-of-type(2n+1) {
+-    background-color: inherit;
+-}
+-
+-
+-.table-hover > tbody > tr:hover > td, .table-hover > tbody > tr:hover > th {
+-    background-color: rgba(0,0,0,0.1);
+-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-    color: #888;
+-}
+-
+-
+-.table-striped > tbody > tr:hover {
+-    background-color: rgba(0,0,0,0.1);
+-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
+-}
+-
+-
+-.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
+-    border-top: 4px solid #2d2d2d;
+-}
+-
+-
+-.form-control {
+-    border: 2px solid #444;
+-}
+-
+-.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
+-    background-color: #363636;
+-}
+-
+-.panel-post h6, .panel-post h6 > a {
+-    color: #666 !important;
+-}
+-
+-
+-.alert-default {
+-    background-color: #222;
+-    border-color: #999;
+-    color: #555;
+-}
+-
+-
+-
+-.comment_starter {
+-    background: #555;
+-    color: #ccc;
+-}
+-
+-.comment-body {
+-    color: #ccc;
+-}
+-
+-.comment_reply {
+-    background: #444;
+-	border-top: 1px solid #777;
+-}
+-
+-.comment footer {
+-    background-color: #555;
+-}
+-
+-.list-group-item {
+-    background: #444;
+-}
+-
+-a.list-group-item:focus,
+-a.list-group-item:hover {
+-    background-color: #555;
+-	color: #999;
+-}
+-
+-.input-group-addon {
+-    background-color: #444;
+-    border: 2px solid #444;
+-	color: #999;
+-}
+-
+-.nav-tabs > li > a:hover,
+-.nav-tabs > li > a:focus {
+-    background-color: #626262;
+-}
+-
+-.progress {
+-    background-color: #444;
+-}
+-
+-.thumbnail {
+-    background-color: #444;
+-    border: 1px solid #999;
+-}
+-
+-
+-.alert-default {
+-    background-color: #222;
+-    border: 2px solid #999;
+-    color: #555;
+-}
+-
+-#darken {
+-    opacity: 0.7;
+-    -ms-filter : "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
+-}
+-
+-.close {
+-    color: #fff!important;
+-    text-shadow:0 1px 0 transparent;
+-}
+-
+-.phpbb_alert p {
+-    color: #fff;
+-}
+-
+-.bbtag, .bbtags-topic .bbtag {
+-    color: #888 !important;
+-}
+-
+-.bbtag:before, .bbtag:after {
+-    background: #222;
+-}
+-
+-.bbtag:hover, .bbtags-topic .bbtag:hover  {
+-    background-color: #ffa800;
+-}
+-
+-.bbtag:hover:after, .bbtags-topic .bbtag:hover:after {
+-    border-left-color: #ffa800;
+-}
+-
+-.bbtags-topic .bbtag:before, .bbtags-topic .bbtag:after {
+-    background: #333;
+-}
+-
+-.section-pre-footer {
+-    background: #222;
+-}
+-
+-.section-pre-footer .section-bg {
+-    background: #292929;
+-}
+-
+-@media (max-width:767px) {
+-	.container>.navbar-header {
+-		padding-bottom: 5px;
+-	}
+-	.section-pre-footer .section-bg {
+-		background: none repeat scroll 0 center transparent;
+-	}
+-}
+-
+-@media (max-width:468px) {
+-	.section-pre-footer .section-bg {
+-		background: none repeat scroll 0 center transparent;
+-	}
+-}
+-
+-.section-pre-footer p, .twitter h3 a small, .copyrights, .debug-output {
+-	color: #888;
+-}
+-
+-.twitter h3 a small:hover {
+-	color: #ffa800;
+-}
+-
+-.section-pre-footer a:hover,
+-.footer-nav a:hover,
+-.debug-output a:hover {
+-	color: #ffa800;
+-}
+-
+-.burned-asphalt {
+-    background-color: #181818;
+-}
+-
+-.avatar-over img {
+-    border: 4px solid #555;
+-}
+-
+-h3 {
+-    border-bottom: 4px solid #777 !important;
+-}
+-
+-.popover {
+-    background-color: #333;
+-}
+-
+-.popover.right > .arrow:after {
+-    border-right-color: #444;
+-}
+-
+-.popover-title {
+-    background-color: #555;
+-}
+-
+-.badge_award h3 {
+-    border-bottom: none;
+-}
+-
+-
+-.footable.breakpoint > tbody > tr > td > span.footable-toggle {
+-    background: #222;
+-    color: #cacaca;
+-}
+-
+-.footable.breakpoint > tbody > tr.footable-row-detail {
+-    background: #222;
+-}
+-
+-.search-input-fullscreen {
+-    background-color: #333;
+-}
+-
+-.search-input-fullscreen input:focus {
+-box-shadow: none;
+-}
+-
+-.label-huskygray {
+-    background-color: #333;
+-}
+-
+-.sidebar .panel {
+-    border-radius: 4px;
+-}
+-
+-.list-announcement .panel-body ul > li a {
+-    color: #fafafa;
+-}
+-
+-.list-announcement .panel-body ul > li small {
+-    color: #ccc;
+-}
+-
+-.user-list .media-body small.date, .list-announcement .media-body small.date {
+-    color: #ccc;
+-}
+-
+-.card .com-contain {
+-    background: rgba(0, 0, 0, 0.7);
+-}
+-
+-.com-stuff {
+-    background: transparent -webkit-radial-gradient(center center ellipse , rgba(0, 0, 0, 1) 0%, transparent 100%);
+-    background: transparent radial-gradient(ellipse at center center , rgba(0, 0, 0, 1) 0%, transparent 100%);
+-}
+-
+-.avn-price-table.avn-style12 {
+-    background: #666;
+-}
+-
+-.avn-price-table.avn-style12 .avn-tagline {
+-    color: #fafafa;
+-}
+-
+-.share-button {
+-    background-color: #333;
+-    border: 1px solid #444;
+-}
+-
+-.share-button > a:hover,
+-.share-button > a:hover:after {
+-	color: #ddd;
+-	background-color: rgb(60,60,60);
+-    border-color:888;
+-}
+-
+-.icons-wrapper {
+-    background-color: rgb(60, 60, 60);
+-}
+-
+-.share-button .icons-wrapper ul li:last-child a {
+-    background-color: #444;
+-}
+-
+-.share-button .icons-wrapper ul li a:hover i {
+-   color:#555;
+-}
+-
+-.share-button a:hover,
+-.share-button button:hover,
+-.share-button a:focus,
+-.share-button button:focus {
+-    color: #ddd;
+-}
+-
+-.sidebar .panel-info > .panel-heading {
+-    background-color: #444;
+-    border-color: transparent;
+-}
+-
+-.panel-primary > .panel-heading,
+-.panel-info > .panel-heading,
+-.panel-custom > .panel-heading,
+-.panel-success > .panel-heading,
+-.panel-warning > .panel-heading {
+-    background-color: #444;
+-    border-color: transparent;
+-}
+-
+-.user-list .media-object {
+-    border: 2px solid #444;
+-}
+-
+-
+-.list-announcement .panel-body ul > li small {
+-    color: #fff;
+-}
+-
+-.list-announcement .panel-body ul > li a {
+-    color: #ffd700;
+-}
+-
+-.sidebar .nav > li > a:focus,
+-.sidebar .nav > li > a:hover {
+-    background-color: #444;
+-}
+-
+-
+-.list-group-item {
+-    background-color: #444;
+-    border: 1px solid #555;
+-}
+-
+-.list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
+-    background-color: #555;
+-    border-color: #555;
+-}
+-
+-a.list-group-item:focus, a.list-group-item:hover, button.list-group-item:focus, button.list-group-item:hover {
+-    background-color: #626262;
+-    color: #fafafa;
+-}
+-
+-.panel-poll {
+-    border-color: transparent;
+-    border-style: solid;
+-    border-width: 2px;
+-}
+-
+-.mini-timeline:before {
+-    background: #555;
+-}
+-
+-.mini-timeline > li:last-child:before {
+-    background: #555;
+-}
+-
+-.mini-timeline > li .timeline-body {
+-    background-color: transparent;
+-}
+-
+-.cc-revoke, .cc-window {
+-	background: #181818;
+-}
+-.cc-link, .cc-link:focus {
+-	color: #ffa800 !important;
+-}
+-.com-stuff p {
+-    color: #8c8c8c;
+-    font-size: 16px;
+-}
+-.btn.focus, .btn:focus, .btn:hover {
+-    color: #e4e4e4;
+-}
+-.btn-default {
+-    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+-}
+-.btn-default:hover,
+-.btn-default:focus,
+-.btn-default:active,
+-.btn-default.active,
+-.open .dropdown-toggle.btn-default {
+-    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+-}
+-.donation-actions {
+-    background-color: #181818;
+-    border: 3px solid #999;
+-}
+-.donation-actions p {
+-    color: #8d9aa5;
+-}
+-.donation-premium > strong,
+-#donationicons .amt-donation {
+-    color: #ffa800;
+-}
+-#donationmessage, #submission {
+-    background-color: #444;
+-}
+-#donationmessage h3 {
+-	color: #ffa800;
+-    border-bottom: none !important;
+-}
+-.donation-actions h2,
+-#donationicons > span + p span {
+-    color: #fafafa;
+-}
+-.donation-actions p a,
+-#submission output {
+-    color: #ffa800;
+-}
+-#donationicons > span.selected:before {
+-    color: #7F7F7F;
+-    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
+-}
+-#donationicons > span:before {
+-  color: rgba(42,42,42, 0.8);
+-  /* this creates the "inset" text shadow */
+-  text-shadow: 1px 2px 2px #000, 0 0 0 #444, 1px 2px 2px #000, 0 1px 1px rgba(255, 255, 255, 0.5);
+-}
+-#donationicons > span:after {
+-    border-bottom: 7px solid #444;
+-}
+-input:focus {
+-    outline: none !important;
+-    border-color: #CDCDCD;
+-    box-shadow: 0 0 10px #CDCDCD;
+-}
+-input[type=range] {
+-    background-color: #999;
+-}
+-
+-input[type=range]::-webkit-slider-runnable-track {
+-    background-color: #444;
+-}
+-input[type=range]::-moz-range-track {
+-    background-color: #444;
+-}
+-input[type="range"]::-ms-track {
+-    background-color: #444;
+-}
+-input[type=range]::-webkit-slider-thumb {
+-    background: -webkit-linear-gradient(left, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), -webkit-linear-gradient(left, #959595, #BBBBBB 40%, #BBBBBB 60%, #959595);
+-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBBBBB 40%, #BBBBBB 60%, #959595);
+-    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBBBBB inset, 0 5px 10px rgba(0, 0, 0, 0.5);
+-}
+-input[type=range]::-webkit-slider-thumb:hover, input[type=range]::-webkit-slider-thumb:active {
+-    background: -webkit-linear-gradient(left, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), -webkit-linear-gradient(left, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
+-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
+-}
+-input[type=range]::-moz-range-thumb {
+-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBBBBB 40%, #BBBBBB 60%, #959595);
+-    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBBBBB inset, 0 5px 10px rgba(0, 0, 0, 0.5);
+-}
+-input[type=range]::-moz-range-thumb:hover, input[type=range]::-moz-range-thumb:active {
+-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
+-}
+-input[type=range]::-ms-thumb {
+-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBBBBB 40%, #BBBBBB 60%, #959595);
+-    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBBBBB inset, 0 5px 10px rgba(0, 0, 0, 0.5);
+-}
+-input[type=range]::-ms-thumb:hover, input[type=range]::-ms-thumb:active {
+-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
+-}
+-#submission .btn-bbdonation {
+-    background-color: #363636;
+-    border: 0 none #444;
+-}
+-#submission .btn-bbdonation:hover,
+-#submission .btn-bbdonation:focus,
+-#submission .btn-bbdonation:active {
+-    background-color: #7f7f7f;
+-    border: 0 none #d6d9e0;
+-}
+-.member-info {
+-  color: rgb(141, 154, 165);
+-}
+-.member-info a {
+-    color: rgb(250, 250, 250);
+-}
+-
+-@media (max-width: 768px) {
+-    #donationicons > span:after {
+-        border-bottom: medium none;
+-    }
+-}
+-
+-.flatpickr-input {
+-    background:transparent;
+-}
+-
+-.flatpickr-calendar {
+-    background: #2b2a2a;
+-}
+-
+-.flatpickr-current-month {
+-    color: #fff;
+-}
+-
+-
+-span.flatpickr-weekday {
+-    color:rgba(255, 255, 255, 0.54);
+-}
+-
+-.flatpickr-day.flatpickr-disabled, .flatpickr-day.flatpickr-disabled:hover {
+-    color: #d94444;
+-}
+-
+-.flatpickr-day {
+-    color:#fff;
+-}
+-
+-.flatpickr-day.inRange, .flatpickr-day.prevMonthDay.inRange, .flatpickr-day.nextMonthDay.inRange, .flatpickr-day.today.inRange, .flatpickr-day.prevMonthDay.today.inRange, .flatpickr-day.nextMonthDay.today.inRange, .flatpickr-day:hover, .flatpickr-day.prevMonthDay:hover, .flatpickr-day.nextMonthDay:hover, .flatpickr-day:focus, .flatpickr-day.prevMonthDay:focus, .flatpickr-day.nextMonthDay:focus {
+-    background: #714b4b;
+-}
+-
+-flatpickr-day.flatpickr-disabled, .flatpickr-day.flatpickr-disabled:hover, .flatpickr-day.prevMonthDay, .flatpickr-day.nextMonthDay, .flatpickr-day.notAllowed, .flatpickr-day.notAllowed.prevMonthDay, .flatpickr-day.notAllowed.nextMonthDay {
+-    color: rgba(155, 88, 88, 0.3);
+-}
+-
+-.flatpickr-time input {
+-   color:#fffbfb;
+-}
+-
+-.flatpickr-time .flatpickr-time-separator, .flatpickr-time .flatpickr-am-pm {
+-    color: #fff;
+-}
+-.flatpickr-time input:hover, .flatpickr-time .flatpickr-am-pm:hover, .flatpickr-time input:focus, .flatpickr-time .flatpickr-am-pm:focus {
+-    background: #45a1ce;
+-}
+-
+-/* ===[ BBDOWNLOADS START ]=== */
+-.widget, .post {
+-    box-shadow: none;
+-}
+-.post .details {
+-    background: rgba(0, 0, 0, 0.9);
+-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+-    color: #ccc;
+-}
+-.widget .header.header-item {
+-    background: rgba(40, 40, 40, 0.9) url(../../../../bbdownloads/styles/FLATBOOTS/theme/images/item-header-pattern.png) repeat scroll 0 0;
+-}
+-.container.with_sidebar .et_pb_column_sidebar {
+-    background: rgba(38, 38, 38, 0.9);
+-}
+-.btn.btn-primary.changelog {
+-    background: #a1d36e;
+-}
+-.btn.btn-primary.changelog:hover {
+-    background: #94cd5a !important;
+-}
+-.btn.btn-secondary {
+-    background: #6ad1dd !important;
+-}
+-.container-downloads .btn {
+-    background: #777;
+-}
+-/* ===[ BBDOWNLOADS END ]=== */
+-
+-/* ===[ BBMEMBERSHIP START ]=== */
+-.npt-format-1 .npt-item {
+-    background: rgba(0, 0, 0, 0.9);
+-}
+-.npt-plan-name {
+-    border-bottom: 0 none !important;
+-}
+-.npt-plan-bottom .avn-btn {
+-    background: #181818 none repeat scroll 0 0;
+-}
+-.npt-plan-bottom .avn-btn:hover {
+-    background: #3a3a3a none repeat scroll 0 0;
+-}
+-.thumbnail, .bg-group-info, .btn-primary {
+-    background-color: #262626;
+-}
+-.btn-primary:hover {
+-    background-color: #3a3a3a !important;
+-}
+-.text-muted {
+-    color: #fff;
+-}
+-/* ===[ BBMEMBERSHIP END ]=== */
+-
+-/* ===[ BBCHAT START ]=== */
+-.rooms li {
+-    border-bottom: .6em dotted #777;
+-}
+-
+-.person:before,
+-.person:hover span {
+-    background: #333;
+-}
+-
+-.bbchat .left .people a:link,
+-.bbchat .left .people a:hover,
+-.bbchat .left .people a:visited {
+-    color: #8c8c8c;
+-}
+-
+-.bbchat,
+-.bbchat .left,
+-.bbchat .right {
+-    background-color: #262626;
+-    border-color: #999;
+-}
+-
+-.delete-message:before, .layout-list .delete-message:before {
+-    border: 3px dashed #181818;
+-}
+-
+-.bbchat .right .top span .name,
+-.me .bubble {
+-    color: #fff;
+-}
+-
+-.bbchat .right .top:after {
+-    background: -webkit-linear-gradient(bottom,rgba(38,38,38,0) 10%,#262626 100%);
+-    background: linear-gradient(to top,rgba(38,38,38,0) 10%,#262626 100%);
+-}
+-
+-.bbchat .right .top,
+-.me .bubble:before,
+-.me .bubble,
+-.write input,
+-.ps:hover.ps--in-scrolling.ps--y>.ps__scrollbar-y-rail,
+-.ps:hover>.ps__scrollbar-y-rail:hover {
+-    background-color: #333 !important;
+-}
+-
+-.bbchat .right .write:before {
+-    background: -webkit-linear-gradient(top,rgba(38,38,38,0) 20%,#262626 100%);
+-    background: linear-gradient(to bottom,rgba(38,38,38,0) 20%,#262626 100%);
+-}
+-
+-.write {
+-    background-color: #333;
+-    border-color: #999;
+-}
+-
+-.giphy>input {
+-    border: 1px solid #999 !important;
+-}
+-
+-#chatbox-input,
+-.write input {
+-    color: #8c8c8c;
+-}
+-
+-.giphy,
+-.emoji-picker {
+-    background-color: #181818;
+-}
+-
+-.bbchat-attachments-input {
+-    background: #333;
+-    box-shadow: 0 1px 15px 1px rgba(51,51,51,.12);
+-}
+-
+-.bbchat-attachments-input>.button-upld {
+-    background: #222 url(images/highlight_reallyfaint.png) repeat-x scroll 0 0;
+-}
+-
+-.bbchat-attachments-input:hover>.button-upld {
+-    background: #777;
+-}
+-/* ===[ BBCHAT END ]=== */
+-
+-/* ===[ CSS HOOK BOTTOM ]=== */
++body{background:#333 url(./images/bg.png) repeat repeat 100% 0}a:link{color:#fff}a:visited{color:#fafafa}a:hover{color:#fafafa}a.postlink-local:link{color:#FFBF00}a.postlink-local:visited{color:#bf8d20}a.postlink-local:hover{color:#daa520}#contentje h1,#contentje h2,#contentje h3,#contentje h4,#contentje h5,#contentje h6,#contentje h1 a,#contentje h2 a,#contentje h3 a,#contentje h4 a,#contentje h5 a,#contentje h6 a{color:#fff!important}.codebox{background-color:#444}code{background-color:#555}.codebox code{color:#fafafa}.content blockquote{background:#555}.btn-default.disabled,.btn-default[disabled],fieldset[disabled] .btn-default,.btn-default.disabled:hover,.btn-default[disabled]:hover,fieldset[disabled] .btn-default:hover,.btn-default.disabled:focus,.btn-default[disabled]:focus,fieldset[disabled] .btn-default:focus,.btn-default.disabled:active,.btn-default[disabled]:active,fieldset[disabled] .btn-default:active,.btn-default.disabled.active,.btn-default.active[disabled],fieldset[disabled] .btn-default.active{background-color:#999}#qr_postform .col-md-snappy{background:rgba(12,12,12,0.82) none repeat scroll 0 0}.prefix-popover{background-color:#555;border:2px solid #444}.prefix-popover:after{border-top:10px solid #444}.breadcrumb-buttons{background:#555;border-radius:0}.popup-box{background:#555}.profile-data h3{border-bottom:none!important}.navbar-inverse{border-color:#222}.navbar-nav-fancy > li > a:hover i{color:#fff}.flat-nav .navbar-nav > .open > a,.flat-nav .navbar-nav > .open > a:hover,.flat-nav .navbar-nav > .open > a:focus,.flat-nav .navbar-nav > .active > a,.flat-nav .navbar-nav > .active > a:hover,.flat-nav .navbar-nav > .active > a:focus{background-color:#888}.navbar-nav-fancy > li:before{background:#888}.blog-meta{background:#ffa800}.top-flat{background-color:#ffa800}.top-flat:hover{-webkit-transition:all .1s linear 0;transition:all .1s linear 0;color:#2d2d2d!important;border-bottom:none;background-color:#fff}.top-flat:hover:after{color:#2d2d2d}.section-pre-footer .thumb i{color:#ffa800}.side-segment > h3{color:#fff}.side-segment h3:after,.side-segment h2:after{background-color:#ffa800}a.forumtitle,a.topictitle,a.topictitleattribute{color:#ffa800}.mobile-post{background:#222;color:#cacaca}.btn-notification{background-color:#555}.notification-block img,.dropdown-avatar img,.profile-avatar img{border-color:#555}.list-group-item-info,a.list-group-item-info,.bg-info{background-color:#555}.square-icon{border:3px solid #444}.list-group-item-warning,a.list-group-item-warning,.bg-warning{background-color:#555}.bg-success,a.list-group-item-success,.list-group-item-success{background-color:#555}.bg-primary,.list-group-item-primary{background-color:#555}.box-placeholder{border:2px dashed #999;background:#555}.panel-default > .panel-heading{border-color:transparent;color:#fff}.postbody .content{color:#ccc}.well{background-color:#262626;border:3px solid #999}li .no_notifications{border-bottom:none!important}.form-actions{background:#444;border:2px solid #999}.nav-tabs{background:#333}.nav-tabs > li.active > a,.nav-tabs > li.active > a:focus,.nav-tabs > li.active > a:hover{background-color:#222;color:#ccc}.control-label{color:#ccc}.masthead:before{background-color:#222}.mastbottom{background-color:#222}.dropdown-menu{border:4px solid #999;background-color:#262626}.dropdown-menu > li > a:hover{background:#999;color:#fff}.dropdown-menu > li > a:hover i{color:#fff}.user-login .navbar-footer{background-color:#555}.user-login-drop > li:first-child{background-color:#555}.arrow-up:before{border-color:rgba(12,12,12,0) rgba(12,12,12,0) #999}.modal-header{border-bottom:1px solid #555}.modal-content{background-color:#444}.modal-footer{border-top:1px solid #555}.profile-data.modal-body h3{border-bottom:none!important}.mini-profile-contact li a.default-contact{background-color:#555}.avatar-over>.status:before{border:4px solid #555}.panel-login{background:#252525 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0}.panel-login .signin-text span{background:#252525}.panel-heading{border-color:#555}.panel-forum{background:rgba(12,12,12,0.9)}.panel-forum > .panel-heading{background:rgba(12,12,12,0) url(./images/bg-maintitle.png) repeat-x scroll 0 50%}.panel-default{border-color:#999}.panel{background:rgba(24,24,24,0.9)}.panel > .panel-heading{background:rgba(12,12,12,0) url(./images/bg-maintitle.png) repeat-x scroll 0 50%;background-size:cover}.panel-footer{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-moz-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent);border-top:1px solid #555}.form-control{background:#262626;color:#999}.tag-editor .placeholder,.tag-editor input{color:#999}.tag-editor input:focus{box-shadow:none}.control-bbtags .tag-editor{border:2px solid #444;background:#181818;color:#999}.tag-editor .tag-editor-tag{color:#8d9aa5;background:#444}.tag-editor .tag-editor-delete{background:#444}.tag-editor .tag-editor-delete i:before{color:#8d9aa5}.attachbox{background-color:#262626}.separator i{background:rgba(12,12,12,0.1) -moz-linear-gradient(center top,rgba(255,255,255,0.09) 0%,transparent 100%) repeat scroll 0 0}.pagination > li > a,.pagination > li > span{background:#222 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0}.pagination > li > a,.pagination > li > span:hover{background:#222 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0}.pagination > li > a,.pagination > li > span{border:2px solid #999}.pagination > .active > a,.pagination > .active > span,.pagination > .active > a:hover,.pagination > .active > span:hover,.pagination > .active > a:focus,.pagination > .active > span:focus{background-color:#555;border-color:#999;color:#999}.pagination > li > a:focus,.pagination > li > a:hover,.pagination > li > span:focus,.pagination > li > span:hover{background-color:#555;color:#999}.pager li > a,.pager li > span{background-color:#444;border:1px solid #333}.pager li > a:focus,.pager li > a:hover{background-color:#555;border:1px solid #444;color:#999}.separator:before{background:#999}.separator i{background:transparent}.btn-default{background:#252525 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0}.btn-default:hover,.btn-default:focus,.btn-default:active,.btn-default.active,.open .dropdown-toggle.btn-default{background:#252525 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0;border-color:#999}.dropdown-menu > li > a:focus,.dropdown-menu > li > a:hover{background-color:#777}.btn-default.active.focus,.btn-default.active:focus,.btn-default.active:hover,.btn-default.focus:active,.btn-default:active:focus,.btn-default:active:hover,.open > .dropdown-toggle.btn-default.focus,.open > .dropdown-toggle.btn-default:focus,.open > .dropdown-toggle.btn-default:hover{background-color:#777}.btn-default{color:#e0e0e0!important}.btn-default:hover{color:#fff!important}.ui-timeline .tl-item .tl-body .tl-content{background-color:#444}.ui-timeline .tl-item .tl-body .tl-content:after{border-color:rgba(12,12,12,0) #444 rgba(12,12,12,0) rgba(12,12,12,0)}.ui-timeline .tl-item.alt .tl-body .tl-content:after{border-color:rgba(12,12,12,0) rgba(12,12,12,0) rgba(12,12,12,0) #444}.ui-timeline .tl-item .tl-body .tl-time{color:#fff}.square-icon{box-shadow:none}.notification-content li{border-bottom:4px solid #999}.counter{text-shadow:none}.login-full .signin-text span{background:#262626}.login-full{background:#252525 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0;padding:20px}.breadcrumb-line{background:#262626}.breadcrumb{background:#262626}.breadcrumb li:first-child a{background:#262626}.panel-post .panel-bottom{background-color:#262626}.section-page{background:rgba(255,255,255,0.07);background-color:rgba(255,255,255,0.07);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09),transparent);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.icon-wrapper{background:rgba(255,255,255,0.1);background-color:rgba(255,255,255,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table-primary tbody tr:nth-child(2n+1) td,.table-primary tbody tr:nth-child(2n+1) th{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table{background:inherit}table .stats-col{background-color:rgba(0,0,0,0.1)!important;background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent))!important;background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%)!important;background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)!important}.table-primary tbody td{background:url(./images/highlight_reallyfaint.png);background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table-primary tbody tr:nth-child(2n+1) td,.table-primary tbody tr:nth-child(2n+1) th{background:url(./images/highlight_reallyfaint.png);background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table tr.active td,.table tr.active{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table > thead > tr > th{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table-hover > tbody > tr:hover > td,.table-hover > tbody > tr:hover > th{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent);color:#888}.table-striped > tbody > tr:nth-of-type(2n+1){background-color:inherit}.table-hover > tbody > tr:hover > td,.table-hover > tbody > tr:hover > th{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent);color:#888}.table-striped > tbody > tr:hover{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table > thead > tr > th,.table > tbody > tr > th,.table > tfoot > tr > th,.table > thead > tr > td,.table > tbody > tr > td,.table > tfoot > tr > td{border-top:4px solid rgba(255,255,255,0.09)}.form-control{border:2px solid #444}.form-control[disabled],.form-control[readonly],fieldset[disabled] .form-control{background-color:#363636}.panel-post h6,.panel-post h6 > a{color:#666!important}.alert-default{background-color:#222;border-color:#999;color:#555}.comment_starter{background:#555;color:#ccc}.comment-body{color:#ccc}.comment_reply{background:#444;border-top:1px solid #777}.comment footer{background-color:#555}.list-group-item{background:#444}a.list-group-item:focus,a.list-group-item:hover{background-color:#555;color:#999}.input-group-addon{background-color:#444;border:2px solid #444;color:#999}.nav-tabs > li > a:hover,.nav-tabs > li > a:focus{background-color:#555}.progress{background-color:#444}.thumbnail{background-color:#444;border:1px solid #999}.alert-default{background-color:#222;border:2px solid #999;color:#555}#darken{opacity:.7 -ms-filter : progid:DXImageTransform.Microsoft.Alpha(Opacity=70)}.close{color:#fff!important;text-shadow:0 1px 0 transparent}.phpbb_alert p{color:#fff}.bbtag,.bbtags-topic .bbtag{color:#888!important}.bbtag:before,.bbtag:after{background:#222}.bbtag:hover,.bbtags-topic .bbtag:hover{background-color:#ffa800}.bbtag:hover:after,.bbtags-topic .bbtag:hover:after{border-left-color:#ffa800}.bbtags-topic .bbtag:before,.bbtags-topic .bbtag:after{background:#333}.section-pre-footer{background:transparent}.section-pre-footer .section-bg{background:#292929}@media (max-width:767px){.container>.navbar-header{padding-bottom:5px}.section-pre-footer .section-bg{background:none repeat scroll 0 center transparent}}@media (max-width:468px){.section-pre-footer .section-bg{background:none repeat scroll 0 center transparent}}.section-pre-footer p,.twitter h3 a small,.copyrights,.debug-output{color:#888}.twitter h3 a small:hover{color:#ffa800}.section-pre-footer a:hover,.footer-nav a:hover,.debug-output a:hover{color:#ffa800}.burned-asphalt{background-color:transparent}.avatar-over img{border:4px solid #555}h3{border-bottom:4px solid #777!important}.popover{background-color:#333}.popover.right > .arrow::after{border-right-color:#444}.popover-title{background-color:#555}.badge_award h3{border-bottom:none}.footable.breakpoint > tbody > tr > td > span.footable-toggle{background:#222;color:#cacaca}.footable.breakpoint > tbody > tr.footable-row-detail{background:#222}.search-input-fullscreen{background-color:#333}.search-input-fullscreen input:focus{box-shadow:none}.label-huskygray{background-color:#333;float:left!important}.sidebar .panel{border-radius:6px 6px 2px 2px;background-color:none}#page-sidebar .panel-inverse > .panel-heading{background-color:#505b72}#page-sidebar .panel-info > .panel-heading{background-color:#5bc0de}#page-sidebar .panel-primary > .panel-heading{background-color:#337ab7}#page-sidebar .panel-success > .panel-heading{background-color:#2dcb73}#page-sidebar .panel-body{background-color:#222}.list-announcement .panel-body ul > li a{color:#fafafa}.list-announcement .panel-body ul > li small{color:#ccc}.user-list .media-body small.date,.list-announcement .media-body small.date{color:#ccc}.card .com-contain{background:rgba(12,12,12,0.7)}.com-stuff{background:rgba(12,12,12,0) -webkit-radial-gradient(center center ellipse,rgba(12,12,12,1) 0%,rgba(12,12,12,0) 100%)}.panel-bottom-messages{padding:15px}.spoiler .spoiler-header{background-color:#171717;color:#ccc;}.spoiler{background-color:#333;border-color:#333}.spoiler .spoiler-body{border-color:#333}.blg-widget-content{border: 1px solid #363636;background: #282828}.calendar.autofit tbody a{background-color:#181818}.calendar .month-title, .calendar .cal-header{color:#f5f5f5}.blg-accordion-icons .blg-accordion-header{background-color:#282828}pre{background-color: #555555;color:#f0f0f0}.spoiler-content .offtopic{margin:0!important;background:#333!important}.spoiler-content .offtopic_title{background:#333333!important;color:#8c8c8c!important}.spoiler-content .offtopic_text{color:#f0f0f0!important}.blog-summary{color:#FFF}.blog-summary .btn{margin-top:10px;background:#222222;border:1px solid #262626!important}.blog-details{background-color:#333}.blog-title a{color:#FFF!important}.blog-item{background:#333;border-radius:5px}.blog-quote .quote a{border-radius:0 0 10px 10px}.blog-quote .blog-metas{color:#ddd}.framed-ucp.topic-list{background:#181818}.textcomplete-item.active,.dropdown-menu>.active>a,.dropdown-menu>.active>a:focus,.dropdown-menu>.active>a:hover{background-color:#161616}.form-buttons{border:2px solid #999999;background:#1a1a1a}.panel-login .signin-text:before{background:#333}.blg-block .panel-login .signin-text span{background:#333;}.blg-linear-list.news-block li.double-space{border:1px solid #313131}.blg-linear-list.news-block li:first-child{border-top:4px solid #313131}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:0}.contributors-box .tag-editor{background:#262626;color:#999;border:2px solid #444}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/images/bg.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/images/bg.png"
+new file mode 100644
+index 000000000..3b21f7f45
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/images/bg.png" differ
diff --git "[FORUM_EXT]/sitesplat\\nightstalker/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\nightstalker/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\nightstalker/diff_nospace.tmp"
@@ -0,0 +1,2871 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/diff_full.tmp"
+new file mode 100644
+index 000000000..b2f58173c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/diff_full.tmp"
+@@ -0,0 +1,2870 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.bak" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.bak"
++new file mode 100644
++index 000000000..88b97dac6
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.bak"
++@@ -0,0 +1,1610 @@
+++/*****************************************************************
+++* Custom CSS Stylesheet. You can add any custom CSS selectors here after the comment line. 
+++* They will be given the highest priority on any elements on the forum
+++* **************************************************************
+++*
+++* FLATBOOTS @SiteSplat.com - Custom CSS STYLESHEET - DARK Theme
+++* 
+++***************************************************************
+++*****************************************************************/
+++/* ===[ CSS HOOK TOP ]=== */
+++body {
+++    background: #333 url(./images/bg.png) repeat repeat 100% 0;
+++    // color: #fff
+++	// background-color: #333;
+++}
+++
+++a:link {
+++    color: #fff
+++}
+++
+++a:visited {
+++    color: #fafafa
+++}
+++
+++a:hover {
+++    color: #fafafa
+++}
+++
+++#contentje h1,
+++#contentje h2,
+++#contentje h3,
+++#contentje h4,
+++#contentje h5,
+++#contentje h6,
+++#contentje h1 a,
+++#contentje h2 a,
+++#contentje h3 a,
+++#contentje h4 a,
+++#contentje h5 a,
+++#contentje h6 a {
+++    color: #fff!important
+++}
+++
+++.codebox {
+++    background-color: #444
+++}
+++
+++code {
+++    background-color: #555
+++}
+++
+++.codebox code {
+++    color: #fafafa
+++}
+++
+++.content blockquote {
+++    background: #555
+++}
+++
+++.btn-default.disabled,
+++.btn-default[disabled],
+++fieldset[disabled] .btn-default,
+++.btn-default.disabled:hover,
+++.btn-default[disabled]:hover,
+++fieldset[disabled] .btn-default:hover,
+++.btn-default.disabled:focus,
+++.btn-default[disabled]:focus,
+++fieldset[disabled] .btn-default:focus,
+++.btn-default.disabled:active,
+++.btn-default[disabled]:active,
+++fieldset[disabled] .btn-default:active,
+++.btn-default.disabled.active,
+++.btn-default.active[disabled],
+++fieldset[disabled] .btn-default.active {
+++    background-color: #999
+++}
+++
+++#qr_postform .col-md-snappy {
+++    background: rgba(12, 12, 12, 0.82) none repeat scroll 0 0
+++}
+++
+++.prefix-popover {
+++    background-color: #555;
+++    border: 2px solid #444
+++}
+++
+++.prefix-popover:after {
+++    border-top: 10px solid #444
+++}
+++
+++.breadcrumb-buttons {
+++    background: #555;
+++    border-radius: 0
+++}
+++
+++.popup-box {
+++    background: #555
+++}
+++
+++.profile-data h3 {
+++    border-bottom: none!important
+++}
+++
+++.navbar-inverse {
+++	// background: #333 url("./images/bg-maintitle.png") repeat-x scroll 0 0;
+++    border-color: #222
+++}
+++
+++.navbar-nav-fancy > li > a:hover i {
+++    color: #fff;
+++}
+++
+++.flat-nav .navbar-nav > .open > a,
+++.flat-nav .navbar-nav > .open > a:hover,
+++.flat-nav .navbar-nav > .open > a:focus,
+++.flat-nav .navbar-nav > .active > a,
+++.flat-nav .navbar-nav > .active > a:hover,
+++.flat-nav .navbar-nav > .active > a:focus {
+++	background-color: #888;
+++}
+++
+++.navbar-nav-fancy > li:before {
+++    background: #888;
+++}
+++
+++.blog-meta {
+++    background: #ffa800
+++}
+++
+++.top-flat {
+++    background-color: #ffa800
+++}
+++
+++.top-flat:hover {
+++-webkit-transition : all .1s linear 0s;
+++transition: all .1s linear 0s;
+++    color: #2d2d2d!important;
+++    border-bottom: none;
+++    background-color: #fff;
+++}
+++.top-flat:hover:after {
+++	color: #2d2d2d;
+++}
+++
+++.section-pre-footer .thumb i {
+++    color: #ffa800;
+++}
+++
+++.side-segment > h3 {
+++    color: #fff;
+++}
+++
+++.side-segment h3:after,
+++.side-segment h2:after {
+++    background-color: #ffa800
+++}
+++
+++a.forumtitle,
+++a.topictitle,
+++a.topictitleattribute {
+++    color: #ffa800
+++}
+++
+++.mobile-post {
+++    background: #222;
+++    color: #cacaca
+++}
+++
+++.btn-notification {
+++    background-color: #555
+++}
+++
+++.notification-block img,
+++.dropdown-avatar img,
+++.profile-avatar img {
+++    border-color: #555
+++}
+++
+++.list-group-item-info,
+++a.list-group-item-info,
+++.bg-info {
+++    background-color: #555
+++}
+++
+++.square-icon {
+++    border: 3px solid #444
+++}
+++
+++.list-group-item-warning,
+++a.list-group-item-warning,
+++.bg-warning {
+++    background-color: #555
+++}
+++
+++.bg-success,
+++a.list-group-item-success,
+++.list-group-item-success {
+++    background-color: #555
+++}
+++
+++.bg-primary,
+++.list-group-item-primary {
+++    background-color: #555
+++}
+++
+++/* ===[ SMART COLLAPSE ]=== */
+++ /* ========================================================================
+++   Component: placeholder.less
+++ ========================================================================== */
+++.box-placeholder {
+++  border: 2px dashed #999;
+++  background: #555;
+++}
+++/* ===[ SMART COLLAPSE ]=== */
+++
+++.panel-default > .panel-heading {
+++    border-color: transparent;
+++    color: #fff
+++}
+++
+++.postbody .content {
+++    color: #ccc
+++}
+++
+++.well {
+++    background-color: #262626;
+++    border: 3px solid #999
+++}
+++
+++li .no_notifications {
+++    border-bottom: none!important
+++}
+++
+++.form-actions {
+++    background: #444;
+++    border: 2px solid #999
+++}
+++
+++.nav-tabs {
+++    background: #333
+++}
+++
+++.nav-tabs > li.active > a,
+++.nav-tabs > li.active > a:focus,
+++.nav-tabs > li.active > a:hover {
+++    background-color: #222;
+++    color: #ccc
+++}
+++
+++.control-label {
+++    color: #ccc
+++}
+++
+++.masthead:before {
+++    background-color: #222
+++}
+++
+++.mastbottom {
+++    background-color: #222
+++}
+++
+++.dropdown-menu {
+++    border: 4px solid #999;
+++    background-color: #262626
+++}
+++
+++.dropdown-menu > li > a:hover {
+++    background: #999;
+++    color: #fff
+++}
+++
+++.dropdown-menu > li > a:hover i {
+++    color: #fff
+++}
+++
+++.user-login .navbar-footer {
+++    background-color: #555
+++}
+++
+++.user-login-drop > li:first-child {
+++    background-color: #555
+++}
+++
+++.arrow-up:before {
+++    border-color: rgba(12, 12, 12, 0) rgba(12, 12, 12, 0) #999
+++}
+++
+++.modal-header {
+++    border-bottom: 1px solid #555
+++}
+++
+++.modal-content {
+++    background-color: #444
+++}
+++
+++.modal-footer {
+++    border-top: 1px solid #555
+++}
+++
+++.profile-data.modal-body h3 {
+++    border-bottom: none!important
+++}
+++
+++.mini-profile-contact li a.default-contact {
+++    background-color: #555
+++}
+++
+++.avatar-over>.status:before {
+++    border: 4px solid #555
+++}
+++
+++.panel-login {
+++    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0
+++}
+++
+++.panel-login .signin-text span {
+++    background: #252525
+++}
+++
+++.panel-heading {
+++    border-color: #555
+++}
+++
+++.panel-forum {
+++    background: rgba(12, 12, 12, 0.9)
+++}
+++
+++.panel-forum > .panel-heading {
+++    background: rgba(12, 12, 12, 0) url("./images/bg-maintitle.png") repeat-x scroll 0 50%
+++}
+++
+++.panel-default {
+++    border-color: #999
+++}
+++
+++.panel {
+++    background: rgba(24, 24, 24, 0.9)
+++}
+++
+++.panel > .panel-heading {
+++    background: rgba(12, 12, 12, 0) url("./images/bg-maintitle.png") repeat-x scroll 0 50%;
+++    background-size: cover
+++}
+++
+++.panel-body {
+++    background-color: rgba(0, 0, 0, 0.1);
+++    background-image: -webkit-gradient(linear, left top, left bottom, from(#252525), to(#181818));
+++    background-image: -moz-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+++}
+++
+++.panel-footer {
+++    background-color: rgba(0, 0, 0, 0.1);
+++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+++    background-image: -moz-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent);
+++    border-top: 1px solid #555
+++}
+++
+++.form-control {
+++    background: #262626;
+++    color: #999
+++}
+++
+++.tag-editor .placeholder, .tag-editor input {
+++	color: #999;
+++}
+++
+++.tag-editor input:focus {
+++    box-shadow: none;
+++}
+++
+++.control-bbtags .tag-editor {
+++	border: 2px solid #444;
+++	background: #181818;
+++    color: #999;
+++}
+++
+++.tag-editor .tag-editor-tag {
+++    color: #8d9aa5;
+++    background: #444;
+++}
+++
+++.tag-editor .tag-editor-delete {
+++    background: #444;
+++}
+++
+++.tag-editor .tag-editor-delete i:before{
+++    color: #8d9aa5;
+++}
+++
+++.attachbox {
+++    background-color: #262626
+++}
+++
+++.separator i {
+++    background: rgba(12, 12, 12, 0.1) -moz-linear-gradient(center top, rgba(255, 255, 255, 0.09) 0%, transparent 100%) repeat scroll 0 0
+++}
+++
+++.pagination > li > a,
+++.pagination > li > span {
+++    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0
+++}
+++
+++.pagination > li > a,
+++.pagination > li > span:hover {
+++    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0
+++}
+++
+++.pagination > li > a,
+++.pagination > li > span {
+++    border: 2px solid #999
+++}
+++
+++.pagination > .active > a,
+++.pagination > .active > span,
+++.pagination > .active > a:hover,
+++.pagination > .active > span:hover,
+++.pagination > .active > a:focus,
+++.pagination > .active > span:focus {
+++    background-color: #555;
+++    border-color: #999;
+++    color: #999
+++}
+++
+++.pagination > li > a:focus,
+++.pagination > li > a:hover,
+++.pagination > li > span:focus,
+++.pagination > li > span:hover {
+++    background-color: #555;
+++    color: #999
+++}
+++
+++.pager li > a,
+++.pager li > span {
+++    background-color: #444;
+++    border: 1px solid #333
+++}
+++
+++.pager li > a:focus,
+++.pager li > a:hover {
+++    background-color: #555;
+++    border: 1px solid #444;
+++    color: #999
+++}
+++
+++.separator:before {
+++    background: #999
+++}
+++
+++.separator i {
+++    background: transparent
+++}
+++
+++.btn-default {
+++    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0
+++}
+++
+++.btn-default:hover,
+++.btn-default:focus,
+++.btn-default:active,
+++.btn-default.active,
+++.open .dropdown-toggle.btn-default {
+++    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+++    border-color: #999
+++}
+++
+++.dropdown-menu > li > a:focus,
+++.dropdown-menu > li > a:hover {
+++    background-color: #777
+++}
+++
+++.btn-default.active.focus,
+++.btn-default.active:focus,
+++.btn-default.active:hover,
+++.btn-default.focus:active,
+++.btn-default:active:focus,
+++.btn-default:active:hover,
+++.open > .dropdown-toggle.btn-default.focus,
+++.open > .dropdown-toggle.btn-default:focus,
+++.open > .dropdown-toggle.btn-default:hover {
+++    background-color: #777
+++}
+++
+++.btn-default {
+++    color: #e0e0e0!important
+++}
+++
+++.btn-default:hover {
+++    color: #fff!important
+++}
+++
+++.ui-timeline .tl-item .tl-body .tl-content {
+++    background-color: #444
+++}
+++
+++.ui-timeline .tl-item .tl-body .tl-content:after {
+++    border-color: rgba(12, 12, 12, 0) #444 rgba(12, 12, 12, 0) rgba(12, 12, 12, 0)
+++}
+++
+++.ui-timeline .tl-item.alt .tl-body .tl-content:after {
+++    border-color: rgba(12, 12, 12, 0) rgba(12, 12, 12, 0) rgba(12, 12, 12, 0) #444
+++}
+++
+++.ui-timeline .tl-item .tl-body .tl-time {
+++    color: #fff
+++}
+++
+++.square-icon {
+++    box-shadow: none
+++}
+++
+++.notification-content li {
+++    border-bottom: 4px solid #999
+++}
+++
+++.counter {
+++    text-shadow: none
+++}
+++
+++.login-full .signin-text span {
+++    background: #262626
+++}
+++
+++.login-full {
+++    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+++    padding: 20px
+++}
+++
+++.breadcrumb-line {
+++    background: #262626
+++}
+++
+++.breadcrumb {
+++    background: #262626
+++}
+++
+++.breadcrumb li:first-child a {
+++    background: #262626
+++}
+++
+++.panel-post .panel-bottom {
+++    background-color: #262626
+++}
+++
+++.section-page {
+++    background: rgba(255, 255, 255, 0.07);
+++    background-color: rgba(255, 255, 255, 0.07)
+++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+++    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
+++    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
+++}
+++
+++.icon-wrapper {
+++    background: rgba(255, 255, 255, 0.1);
+++    background-color: rgba(255, 255, 255, 0.1);
+++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+++}
+++
+++.table-primary tbody tr:nth-child(2n+1) td,
+++.table-primary tbody tr:nth-child(2n+1) th {
+++    background-color: rgba(0, 0, 0, 0.1);
+++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+++}
+++
+++.table {
+++    background: inherit
+++}
+++
+++table .stats-col {
+++    background-color: rgba(0, 0, 0, 0.1)!important;
+++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent))!important;
+++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%)!important;
+++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)!important
+++}
+++
+++.table-primary tbody td {
+++    background: url("./images/highlight_reallyfaint.png");
+++    background-color: rgba(0, 0, 0, 0.1);
+++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+++}
+++
+++.table-primary tbody tr:nth-child(2n+1) td,
+++.table-primary tbody tr:nth-child(2n+1) th {
+++    background: url("./images/highlight_reallyfaint.png");
+++    background-color: rgba(0, 0, 0, 0.1);
+++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+++}
+++
+++.table tr.active td,
+++.table tr.active {
+++    background-color: rgba(0, 0, 0, 0.1);
+++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+++}
+++
+++.table > thead > tr > th {
+++    background-color: rgba(0, 0, 0, 0.1);
+++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+++}
+++
+++.table-hover > tbody > tr:hover > td,
+++.table-hover > tbody > tr:hover > th {
+++    background-color: rgba(0, 0, 0, 0.1);
+++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent);
+++    color: #888
+++}
+++
+++.table-striped > tbody > tr:nth-of-type(2n+1) {
+++    background-color: inherit
+++}
+++
+++.table-hover > tbody > tr:hover > td,
+++.table-hover > tbody > tr:hover > th {
+++    background-color: rgba(0, 0, 0, 0.1);
+++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent);
+++    color: #888
+++}
+++
+++.table-striped > tbody > tr:hover {
+++    background-color: rgba(0, 0, 0, 0.1);
+++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+++    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+++    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+++}
+++
+++.table > thead > tr > th,
+++.table > tbody > tr > th,
+++.table > tfoot > tr > th,
+++.table > thead > tr > td,
+++.table > tbody > tr > td,
+++.table > tfoot > tr > td {
+++    border-top: 4px solid rgba(255, 255, 255, 0.09)
+++}
+++
+++.form-control {
+++    border: 2px solid #444
+++}
+++
+++.form-control[disabled],
+++.form-control[readonly],
+++fieldset[disabled] .form-control {
+++    background-color: #363636
+++}
+++
+++.panel-post h6,
+++.panel-post h6 > a {
+++    color: #666!important
+++}
+++
+++.alert-default {
+++    background-color: #222;
+++    border-color: #999;
+++    color: #555
+++}
+++
+++.comment_starter {
+++    background: #555;
+++    color: #ccc
+++}
+++
+++.comment-body {
+++    color: #ccc
+++}
+++
+++.comment_reply {
+++    background: #444;
+++    border-top: 1px solid #777
+++}
+++
+++.comment footer {
+++    background-color: #555
+++}
+++
+++.list-group-item {
+++    background: #444
+++}
+++
+++a.list-group-item:focus,
+++a.list-group-item:hover {
+++    background-color: #555;
+++    color: #999
+++}
+++
+++.input-group-addon {
+++    background-color: #444;
+++    border: 2px solid #444;
+++    color: #999
+++}
+++
+++.nav-tabs > li > a:hover,
+++.nav-tabs > li > a:focus {
+++    background-color: #555
+++}
+++
+++.progress {
+++    background-color: #444
+++}
+++
+++.thumbnail {
+++    background-color: #444;
+++    border: 1px solid #999
+++}
+++
+++.alert-default {
+++    background-color: #222;
+++    border: 2px solid #999;
+++    color: #555
+++}
+++
+++#darken {
+++    opacity: .7
+++    -ms-filter : "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
+++}
+++
+++.close {
+++    color: #fff!important;
+++    text-shadow: 0 1px 0 transparent
+++}
+++
+++.phpbb_alert p {
+++    color: #fff
+++}
+++
+++.bbtag, .bbtags-topic .bbtag {
+++    color: #888 !important;
+++}
+++
+++.bbtag:before, .bbtag:after {
+++    background: #222;
+++}
+++
+++.bbtag:hover, .bbtags-topic .bbtag:hover  {
+++    background-color: #ffa800;
+++}
+++
+++.bbtag:hover:after, .bbtags-topic .bbtag:hover:after {
+++    border-left-color: #ffa800;
+++}
+++
+++.bbtags-topic .bbtag:before, .bbtags-topic .bbtag:after {
+++    background: #333;
+++}
+++
+++.section-pre-footer {
+++    background: transparent
+++}
+++
+++.section-pre-footer .section-bg {
+++    background: #292929
+++}
+++
+++@media (max-width:767px) {
+++	.container>.navbar-header {
+++		padding-bottom: 5px;
+++	}
+++	.section-pre-footer .section-bg {
+++		background: none repeat scroll 0 center transparent;
+++	}
+++}
+++
+++@media (max-width:468px) {
+++	.section-pre-footer .section-bg {
+++		background: none repeat scroll 0 center transparent;
+++	}
+++}
+++
+++.section-pre-footer p, .twitter h3 a small, .copyrights, .debug-output {
+++	color: #888;
+++}
+++
+++.twitter h3 a small:hover {
+++	color: #ffa800;
+++}
+++
+++.section-pre-footer a:hover,
+++.footer-nav a:hover,
+++.debug-output a:hover {
+++	color: #ffa800;
+++}
+++
+++.burned-asphalt {
+++    background-color: transparent
+++}
+++
+++.avatar-over img {
+++    border: 4px solid #555
+++}
+++
+++h3 {
+++    border-bottom: 4px solid #777!important
+++}
+++
+++.popover {
+++    background-color: #333
+++}
+++
+++.popover.right > .arrow::after {
+++    border-right-color: #444
+++}
+++
+++.popover-title {
+++    background-color: #555
+++}
+++
+++.badge_award h3 {
+++    border-bottom: none
+++}
+++
+++.footable.breakpoint > tbody > tr > td > span.footable-toggle {
+++    background: #222;
+++    color: #cacaca
+++}
+++
+++.footable.breakpoint > tbody > tr.footable-row-detail {
+++    background: #222
+++}
+++
+++.search-input-fullscreen {
+++    background-color: #333
+++}
+++
+++.search-input-fullscreen input:focus {
+++box-shadow: none;
+++}
+++
+++.label-huskygray {
+++    background-color: #333;
+++    float: left!important
+++}
+++
+++.sidebar .panel {
+++    border-radius: 6px 6px 2px 2px;
+++    background-color: none
+++}
+++
+++#page-sidebar .panel-inverse > .panel-heading {
+++    background-color: #505b72
+++}
+++
+++#page-sidebar .panel-info > .panel-heading {
+++    background-color: #5bc0de
+++}
+++
+++#page-sidebar .panel-primary > .panel-heading {
+++    background-color: #337ab7
+++}
+++
+++#page-sidebar .panel-success > .panel-heading {
+++    background-color: #2dcb73
+++}
+++
+++#page-sidebar .panel-body {
+++    background-color: #222
+++}
+++
+++.list-announcement .panel-body ul > li a {
+++    color: #fafafa
+++}
+++
+++.list-announcement .panel-body ul > li small {
+++    color: #ccc
+++}
+++
+++.user-list .media-body small.date,
+++.list-announcement .media-body small.date {
+++    color: #ccc
+++}
+++
+++.card .com-contain {
+++    background: rgba(12, 12, 12, 0.7)
+++}
+++
+++.com-stuff {
+++    background: rgba(12, 12, 12, 0) -webkit-radial-gradient(center center ellipse, rgba(12, 12, 12, 1) 0%, rgba(12, 12, 12, 0) 100%)
+++    background: rgba(12, 12, 12, 0) radial-gradient(ellipse at center center , rgba(12, 12, 12, 1) 0%, rgba(12, 12, 12, 0 100%);
+++}
+++
+++.avn-price-table.avn-style12 {
+++    background: #666
+++}
+++
+++.avn-price-table.avn-style12 .avn-tagline {
+++    color: #fafafa
+++}
+++
+++.share-button {
+++    background-color: #333;
+++    border: 1px solid #444
+++}
+++
+++.share-button > a:hover,
+++.share-button > a:hover:after {
+++    color: #ddd;
+++    background-color: #3c3c3c;
+++    border-color: #888
+++}
+++
+++.icons-wrapper {
+++    background-color: #3c3c3c
+++}
+++
+++.share-button .icons-wrapper ul li:last-child a {
+++    background-color: #444
+++}
+++
+++.share-button .icons-wrapper ul li a:hover i {
+++    color: #555
+++}
+++
+++.share-button a:hover,
+++.share-button button:hover,
+++.share-button a:focus,
+++.share-button button:focus {
+++    color: #ddd
+++}
+++
+++.sidebar .panel {
+++    background-color: #292c2e!important
+++}
+++
+++.sidebar .panel-info > .panel-heading {
+++    background-color: #444;
+++    border-color: transparent
+++}
+++
+++.sidebar .panel-body {
+++    border-bottom-left-radius: 4px;
+++    border-bottom-right-radius: 4px;
+++    border-color: #444;
+++    border-image: none;
+++    border-style: none solid solid;
+++    border-width: medium 1px 1px
+++}
+++
+++.panel-primary > .panel-heading,
+++.panel-info > .panel-heading,
+++.panel-custom > .panel-heading,
+++.panel-success > .panel-heading,
+++.panel-warning > .panel-heading {
+++    background-color: #444;
+++    border-color: transparent
+++}
+++
+++.user-list .media-object {
+++    border: 2px solid #444
+++}
+++
+++.list-announcement .panel-body ul > li small {
+++    color: #fff
+++}
+++
+++.list-announcement .panel-body ul > li a {
+++    color: #ffd700
+++}
+++
+++.sidebar .nav > li > a:focus,
+++.sidebar .nav > li > a:hover {
+++    background-color: #444
+++}
+++
+++.list-group-item {
+++    background-color: #444;
+++    border: 1px solid #555
+++}
+++
+++.list-group-item.active,
+++.list-group-item.active:focus,
+++.list-group-item.active:hover {
+++    background-color: #555;
+++    border-color: #555
+++}
+++
+++a.list-group-item:focus,
+++a.list-group-item:hover,
+++button.list-group-item:focus,
+++button.list-group-item:hover {
+++    background-color: #626262;
+++    color: #fafafa
+++}
+++
+++.panel-poll {
+++    border-color: transparent;
+++    border-style: solid;
+++    border-width: 2px
+++}
+++
+++.mini-timeline::before {
+++    background: #555
+++}
+++
+++.mini-timeline > li:last-child::before {
+++    background: #555
+++}
+++
+++.mini-timeline > li .timeline-body {
+++    background-color: transparent
+++}
+++
+++.cc-revoke, .cc-window {
+++	background: #181818;
+++}
+++.cc-link, .cc-link:focus {
+++	color: #ffa800 !important;
+++}
+++.com-stuff p {
+++    color: #8c8c8c;
+++    font-size: 16px;
+++}
+++.btn.focus, .btn:focus, .btn:hover {
+++    color: #e4e4e4;
+++}
+++.btn-default {
+++    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+++}
+++.btn-default:hover,
+++.btn-default:focus,
+++.btn-default:active,
+++.btn-default.active,
+++.open .dropdown-toggle.btn-default {
+++    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+++}
+++
+++.donation-actions {
+++    background-color: #262626;
+++    border: 3px solid #999
+++}
+++
+++.donation-actions p {
+++    color: #8d9aa5
+++}
+++
+++.donation-premium > strong,
+++#donationicons .amt-donation {
+++    color: #ffa800
+++}
+++#donationmessage, #submission {
+++    background-color: #444;
+++}
+++#donationmessage h3 {
+++	color: #ffa800;
+++    border-bottom: none !important;
+++}
+++.donation-actions h2,
+++#donationicons > span + p span {
+++    color: #fafafa
+++}
+++.donation-actions p a,
+++#submission output {
+++    color: #ffa800
+++}
+++#donationicons > span.selected:before {
+++    color: #7F7F7F;
+++    text-shadow: 1px 1px 2px rgba(12, 12, 12, 0.5)
+++}
+++#donationicons > span:before {
+++    color: rgba(21, 23, 25, 0.8);
+++    /* this creates the "inset" text shadow */
+++    text-shadow: 1px 2px 2px #222, 0 0 0 #000, 1px 2px 2px #222, 0 1px 1px rgba(255, 255, 255, 0.5)
+++}
+++#donationicons > span:after {
+++    border-bottom: 7px solid #444
+++}
+++
+++input:focus {
+++    outline: none!important;
+++    border-color: #CDCDCD
+++    box-shadow: 0 0 10px #CDCDCD;
+++}
+++
+++input[type=range] {
+++    background-color: #999
+++}
+++
+++input[type=range]::-webkit-slider-runnable-track {
+++    background-color: #444
+++}
+++
+++input[type=range]::-moz-range-track {
+++    background-color: #444
+++}
+++
+++input[type="range"]::-ms-track {
+++    background-color: #444
+++}
+++
+++input[type=range]::-webkit-slider-thumb {
+++    background: -webkit-linear-gradient(left, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), -webkit-linear-gradient(left, #959595, #BBB 40%, #BBB 60%, #959595);
+++    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBB 40%, #BBB 60%, #959595);
+++    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBB inset, 0 5px 10px rgba(12, 12, 12, 0.5)
+++}
+++
+++input[type=range]::-webkit-slider-thumb:hover,
+++input[type=range]::-webkit-slider-thumb:active {
+++    background: -webkit-linear-gradient(left, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), -webkit-linear-gradient(left, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
+++    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4)
+++}
+++
+++input[type=range]::-moz-range-thumb {
+++    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBB 40%, #BBB 60%, #959595);
+++    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBB inset, 0 5px 10px rgba(12, 12, 12, 0.5)
+++}
+++
+++input[type=range]::-moz-range-thumb:hover,
+++input[type=range]::-moz-range-thumb:active {
+++    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4)
+++}
+++
+++input[type=range]::-ms-thumb {
+++    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBB 40%, #BBB 60%, #959595);
+++    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBB inset, 0 5px 10px rgba(12, 12, 12, 0.5)
+++}
+++
+++input[type=range]::-ms-thumb:hover,
+++input[type=range]::-ms-thumb:active {
+++    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4)
+++}
+++
+++#submission .btn-bbdonation {
+++    background-color: #363636;
+++    border: 0 none #444
+++}
+++
+++#submission .btn-bbdonation:hover,
+++#submission .btn-bbdonation:focus,
+++#submission .btn-bbdonation:active {
+++    background-color: #7f7f7f;
+++    border: 0 none #d6d9e0
+++}
+++
+++.member-info {
+++    color: #8d9aa5
+++}
+++
+++.member-info a {
+++    color: #fafafa
+++}
+++
+++.alert-info {
+++    background-color: #8a6d3b
+++}
+++
+++.side-segment > h3 {
+++    color: #fff
+++}
+++
+++.chat-row {
+++    background-color: #222
+++}
+++
+++.chat-row:nth-child(even) {
+++    background-color: #323232
+++}
+++
+++.chat-row:hover {
+++    background-color: #121212
+++}
+++
+++#chat-message textarea,
+++#chat-dialog textarea {
+++    background-color: #323232
+++}
+++
+++#chat-right-panel,
+++#chat-conversation-container,
+++#chat-tabs li.active,
+++#chat-toolbar a.active,
+++.ic-box {
+++    background: #323232
+++}
+++
+++#chat-body {
+++    color: #FFF
+++}
+++
+++.blg-table {
+++    color: #fff
+++}
+++
+++.blg-table .blg-column-topic-title {
+++    text-align: left
+++}
+++
+++.blg-widget-content {
+++    background: #252525;
+++    border: 0
+++}
+++
+++.blg-widget-header {
+++    background: #353535;
+++    border: 1px solid #171717;
+++    color: #d6a400;
+++    padding: 2px 2px 4px
+++}
+++
+++input,
+++textarea#mchat-input {
+++    color: #181818
+++}
+++
+++#chat-body blockquote {
+++    background-color: #696969
+++}
+++
+++.blg-state-hover a,
+++.blg-state-hover a:hover {
+++    color: #353535
+++}
+++
+++.blg-state-default a,
+++.blg-state-default a:link,
+++.blg-state-default a:visited {
+++    color: #171717
+++}
+++
+++.blg-accordion > .blg-state-default a,
+++.blg-accordion > .blg-state-default a:link,
+++.blg-accordion > .blg-state-default a:visited {
+++    color: #fff
+++}
+++
+++.blg-accordion-icons .blg-accordion-header {
+++    background-color: transparent;
+++    color: #FFF
+++}
+++
+++.blg-calendar-info {
+++    background: #252525
+++}
+++
+++.blg-calendar-event {
+++    background: #d6a400
+++}
+++
+++.blg-dialog .blg-dialog-content,
+++.blg-dialog .dialog-text {
+++    color: #ddd
+++}
+++
+++.blg-state-default {
+++    background: #f5f5f5;
+++    border: 1px solid #282828;
+++    color: #333
+++}
+++
+++.blg-state-highlight {
+++    background: #fbec88!important;
+++    color: #363636!important
+++}
+++
+++.blg-state-hover,
+++.blg-state-focus {
+++    background: #f2f2f2;
+++    border: 1px solid #282828;
+++    color: #222
+++}
+++
+++.calendar tbody a {
+++    color: #000
+++}
+++
+++.calendar .month-title,
+++.calendar .cal-header {
+++    color: #fff
+++}
+++
+++.calendar.autofit tbody a {
+++    color: #d6a403;
+++    background-color: transparent;
+++    border-color: #181818
+++}
+++
+++.calendar a.today {
+++    color: #fff!important
+++}
+++
+++.blg-inputbox {
+++    color: #757575
+++}
+++
+++.ads img {
+++    opacity: 1;
+++    filter: alpha(opacity=1)
+++}
+++
+++.nightpanel {
+++    padding-right: 0
+++}
+++
+++.breadcrumb .icon {
+++    color: #d6a400
+++}
+++
+++.blg-icon {
+++    color: #d6a400
+++}
+++
+++a.blg-button {
+++    color: #181818!important
+++}
+++
+++.blg-align-center {
+++    color: #fff
+++}
+++
+++.panel-bottom-messages {
+++    margin-top: 15px;
+++    padding: 15px
+++}
+++
+++.blg-calendar td {
+++    background-color: #222
+++}
+++
+++.blg-calendar-event.blg-event-birthday {
+++    background: #ccc
+++}
+++
+++#qm_main select,
+++.qm-dialog select,
+++.qm_inputbox,
+++.qm-menu,
+++.qm-button,
+++.row_mark input {
+++    color: #181818
+++}
+++
+++.quick_mod_buttons {
+++    background-color: transparent
+++}
+++
+++a [class*="qm-icon"] {
+++    color: #b8bdcb
+++}
+++
+++@media (max-width: 768px) {
+++    #donationicons > span:after {
+++        border-bottom: medium none
+++    }
+++}
+++
+++.flatpickr-input {
+++    background: transparent
+++}
+++
+++.flatpickr-calendar {
+++    background: #2b2a2a
+++}
+++
+++.flatpickr-current-month {
+++    color: #fff
+++}
+++
+++span.flatpickr-weekday {
+++    color: rgba(255, 255, 255, 0.54)
+++}
+++
+++.flatpickr-day.flatpickr-disabled,
+++.flatpickr-day.flatpickr-disabled:hover {
+++    color: #d94444
+++}
+++
+++.flatpickr-day {
+++    color: #fff
+++}
+++
+++.flatpickr-day.inRange,
+++.flatpickr-day.prevMonthDay.inRange,
+++.flatpickr-day.nextMonthDay.inRange,
+++.flatpickr-day.today.inRange,
+++.flatpickr-day.prevMonthDay.today.inRange,
+++.flatpickr-day.nextMonthDay.today.inRange,
+++.flatpickr-day:hover,
+++.flatpickr-day.prevMonthDay:hover,
+++.flatpickr-day.nextMonthDay:hover,
+++.flatpickr-day:focus,
+++.flatpickr-day.prevMonthDay:focus,
+++.flatpickr-day.nextMonthDay:focus {
+++    background: #714b4b
+++}
+++
+++flatpickr-day.flatpickr-disabled,
+++.flatpickr-day.flatpickr-disabled:hover,
+++.flatpickr-day.prevMonthDay,
+++.flatpickr-day.nextMonthDay,
+++.flatpickr-day.notAllowed,
+++.flatpickr-day.notAllowed.prevMonthDay,
+++.flatpickr-day.notAllowed.nextMonthDay {
+++    color: rgba(155, 88, 88, 0.3)
+++}
+++
+++.flatpickr-time input {
+++    color: #fffbfb
+++}
+++
+++.flatpickr-time .flatpickr-time-separator,
+++.flatpickr-time .flatpickr-am-pm {
+++    color: #fff
+++}
+++
+++.flatpickr-time input:hover,
+++.flatpickr-time .flatpickr-am-pm:hover,
+++.flatpickr-time input:focus,
+++.flatpickr-time .flatpickr-am-pm:focus {
+++    background: #45a1ce
+++}
+++
+++/* ===[ BBDOWNLOADS START ]=== */
+++.widget,
+++.post {
+++    box-shadow: none
+++}
+++
+++.post .details {
+++    background: rgba(0, 0, 0, 0.9);
+++    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+++    color: #ccc
+++}
+++
+++.widget .header.header-item {
+++    background: rgba(40, 40, 40, 0.9) url("../../../../bbdownloads/styles/FLATBOOTS/theme/images/item-header-pattern.png") repeat scroll 0 0
+++}
+++
+++.container.with_sidebar .et_pb_column_sidebar {
+++    background: rgba(38, 38, 38, 0.9)
+++}
+++
+++.btn.btn-primary.changelog {
+++    background: #a1d36e
+++}
+++
+++.btn.btn-primary.changelog:hover {
+++    background: #94cd5a!important
+++}
+++
+++.btn.btn-secondary {
+++    background: #6ad1dd!important
+++}
+++
+++.container-downloads .btn {
+++    background: #777
+++}
+++/* ===[ BBDOWNLOADS END ]=== */
+++
+++/* ===[ BBMEMBERSHIP START ]=== */
+++
+++.npt-format-1 .npt-item {
+++    background: rgba(0, 0, 0, 0.9)
+++}
+++
+++.npt-plan-name {
+++    border-bottom: 0 none!important
+++}
+++
+++.npt-plan-bottom .avn-btn {
+++    background: #181818 none repeat scroll 0 0
+++}
+++
+++.npt-plan-bottom .avn-btn:hover {
+++    background: #3a3a3a none repeat scroll 0 0
+++}
+++
+++.thumbnail,
+++.bg-group-info,
+++.btn-primary {
+++    background-color: #262626
+++}
+++
+++.btn-primary:hover {
+++    background-color: #3a3a3a!important
+++}
+++
+++.text-muted {
+++    color: #fff
+++}
+++/* ===[ BBMEMBERSHIP END ]=== */
+++
+++/* ===[ BBCHAT START ]=== */
+++
+++.rooms li {
+++    border-bottom: .6em dotted #777
+++}
+++
+++.person:before,
+++.person:hover span {
+++    background: #333
+++}
+++
+++.bbchat .left .people a:link,
+++.bbchat .left .people a:hover,
+++.bbchat .left .people a:visited {
+++    color: #8c8c8c
+++}
+++
+++.bbchat,
+++.bbchat .left,
+++.bbchat .right {
+++    background-color: #262626;
+++    border-color: #999
+++}
+++
+++.delete-message:before,
+++.layout-list .delete-message:before {
+++    border: 3px dashed #181818
+++}
+++
+++.bbchat .right .top span .name,
+++.me .bubble {
+++    color: #fff
+++}
+++
+++.bbchat .right .top:after {
+++    background: -webkit-linear-gradient(bottom, rgba(38, 38, 38, 0) 10%, #262626 100%);
+++    background: linear-gradient(to top, rgba(38, 38, 38, 0) 10%, #262626 100%)
+++}
+++
+++.bbchat .right .top,
+++.me .bubble:before,
+++.me .bubble,
+++.write input,
+++.ps:hover.ps--in-scrolling.ps--y>.ps__scrollbar-y-rail,
+++.ps:hover>.ps__scrollbar-y-rail:hover {
+++    background-color: #333!important
+++}
+++
+++.bbchat .right .write:before {
+++    background: -webkit-linear-gradient(top, rgba(38, 38, 38, 0) 20%, #262626 100%);
+++    background: linear-gradient(to bottom, rgba(38, 38, 38, 0) 20%, #262626 100%)
+++}
+++
+++.write {
+++    background-color: #333;
+++    border-color: #999
+++}
+++
+++.giphy>input {
+++    border: 1px solid #999!important
+++}
+++
+++#chatbox-input,
+++.write input {
+++    color: #8c8c8c
+++}
+++
+++.giphy,
+++.emoji-picker {
+++    background-color: #181818
+++}
+++
+++.bbchat-attachments-input {
+++    background: #333;
+++    box-shadow: 0 1px 15px 1px rgba(51, 51, 51, .12)
+++}
+++
+++.bbchat-attachments-input>.button-upld {
+++    background: #222 url(images/highlight_reallyfaint.png) repeat-x scroll 0 0
+++}
+++
+++.bbchat-attachments-input:hover>.button-upld {
+++    background: #777
+++}
+++/* ===[ BBCHAT END ]=== */
+++.blog-summary {
+++    color: #412525;
+++}
+++.blog-summary .btn {
+++    margin-top: 10px;
+++    background: #222222;
+++    border: 1px solid #262626!important;
+++}
+++.blog-details {
+++     background-color: #333;
+++}
+++.blog-title a {
+++    color: #FFF!important;
+++}
+++
+++.blog-item {
+++    background: #333333;
+++    border-radius: 5px;
+++}
+++.blog-quote .quote a {
+++    border-radius: 0 0 10px 10px;
+++}
+++.blog-quote .blog-metas {
+++    color: #ddd;
+++}
+++
+++.textcomplete-item.active,
+++.dropdown-menu>.active>a,
+++.dropdown-menu>.active>a:focus,
+++.dropdown-menu>.active>a:hover {
+++    background-color:#161616;
+++}
+++/* ===[ CSS HOOK BOTTOM ]=== */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.css"
++index b85f8ae3d..73d0a07b1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.css"
++@@ -1,1240 +1 @@
++-/*****************************************************************
++-* Custom CSS Stylesheet. You can add any custom CSS selectors here after the comment line. 
++-* They will be given the highest priority on any elements on the forum
++-* **************************************************************
++-*
++-* FLATBOOTS @SiteSplat.com - Custom CSS STYLESHEET - DARK Theme
++-* 
++-***************************************************************
++-*****************************************************************/
++-/* ===[ CSS HOOK TOP ]=== */
++-body {
++-   // background: #000 url("./images/fallout4-background.jpg") repeat fixed 50% 0;
++-   // color: #fff;
++-   background-color: #333;
++-}
++-
++-a:link {
++-    color: #fff;
++-}
++-a:visited {
++-    color: #fafafa;
++-}
++-a:hover {
++-    color: #fafafa;
++-}
++-
++-
++-#contentje h1, #contentje h2, #contentje h3, #contentje h4, #contentje h5, #contentje h6,
++-#contentje h1 a, #contentje h2 a, #contentje h3 a, #contentje h4 a, #contentje h5 a, #contentje h6 a {
++-    color: #fff !important;
++-}
++-
++-.codebox {
++-    background-color: #444;
++-}
++-
++-code {
++-    background-color: #555;
++-}
++-
++-.codebox code {
++-   color: #fafafa;
++-}
++-
++-.content blockquote {
++-    background: #555;
++-}
++-
++-.btn-default.disabled, .btn-default[disabled], fieldset[disabled] .btn-default, .btn-default.disabled:hover, .btn-default[disabled]:hover, fieldset[disabled] .btn-default:hover, .btn-default.disabled:focus, .btn-default[disabled]:focus, fieldset[disabled] .btn-default:focus, .btn-default.disabled:active, .btn-default[disabled]:active, fieldset[disabled] .btn-default:active, .btn-default.disabled.active, .btn-default.active[disabled], fieldset[disabled] .btn-default.active {
++-    background-color: #999;
++-}
++-
++-#qr_postform .col-md-snappy {
++-    background: rgba(0, 0, 0, 0.82) none repeat scroll 0 0;
++-}
++-
++-.prefix-popover {
++-    background-color: #555;
++-    border: 2px solid #444;
++-}
++-
++-.prefix-popover:after {
++-    border-top: 10px solid #444;
++-}
++-
++-.breadcrumb-buttons {
++-    background: #555;
++-    border-radius: 0;
++-}
++-
++-.popup-box {
++-    background: #555;
++-}
++-
++-.profile-data h3 {
++-    border-bottom: none !important;
++-}
++-
++-.navbar-inverse {
++-    background: #000 url("./images/bg-maintitle.png") repeat-x scroll 0 0;
++-    border-color: #222;
++-}
++-
++-.navbar-nav-fancy > li > a:hover i {
++-    color: #fff;
++-}
++-
++-.flat-nav .navbar-nav > .open > a,
++-.flat-nav .navbar-nav > .open > a:hover,
++-.flat-nav .navbar-nav > .open > a:focus,
++-.flat-nav .navbar-nav > .active > a,
++-.flat-nav .navbar-nav > .active > a:hover,
++-.flat-nav .navbar-nav > .active > a:focus {
++-	background-color: #888;
++-}
++-
++-.navbar-nav-fancy > li:before {
++-    background: #888;
++-}
++-
++-.blog-meta {
++-    background: #ffa800;
++-}
++-
++-.top-flat {
++-    background-color: #ffa800;
++-}
++-
++-.top-flat:hover {
++--webkit-transition : all .1s linear 0s;
++-transition: all .1s linear 0s;
++-    color: #2d2d2d!important;
++-    border-bottom: none;
++-    background-color: #fff;
++-}
++-.top-flat:hover:after {
++-	color: #2d2d2d;
++-}
++-
++-.section-pre-footer .thumb i {
++-    color: #ffa800;
++-}
++-
++-.side-segment > h3 {
++-    color: #fff;
++-}
++-
++-.side-segment h3:after, .side-segment h2:after {
++-    background-color: #ffa800;
++-}
++-
++-a.forumtitle, a.topictitle {
++-    color: #ffa800;
++-}
++-
++-.mobile-post {
++-    background: #222;
++-    color: #cacaca;
++-}
++-
++-.btn-notification {
++-    background-color: #555;
++-}
++-
++-.notification-block img,
++-.dropdown-avatar img,
++-.profile-avatar img {
++-    border-color: #555;
++-}
++-
++-.list-group-item-info, a.list-group-item-info, .bg-info {
++-    background-color: #555;
++-}
++-
++-
++-.square-icon {
++-    border: 3px solid #444;
++-}
++-
++-.list-group-item-warning, a.list-group-item-warning, .bg-warning {
++-    background-color: #555;
++-}
++-
++-.bg-success, a.list-group-item-success, .list-group-item-success {
++-    background-color: #555;
++-}
++-
++-.bg-primary, .list-group-item-primary {
++-    background-color: #555;
++-}
++-
++-/* ===[ SMART COLLAPSE ]=== */
++- /* ========================================================================
++-   Component: placeholder.less
++- ========================================================================== */
++-.box-placeholder {
++-  border: 2px dashed #999;
++-  background: #555;
++-}
++-/* ===[ SMART COLLAPSE ]=== */
++-
++-.panel-default > .panel-heading {
++-    border-color: transparent;
++-    color: #fff;
++-}
++-
++-.postbody .content {
++-    color: #ccc;
++-} 
++- 
++-.well {
++-    background-color: #181818;
++-    border: 3px solid #999;
++-} 
++- 
++-li .no_notifications {
++-    border-bottom: none !important;
++-}
++- 
++-.form-actions {
++-    background: #444;
++-    border: 2px solid #999;
++-} 
++- 
++-.nav-tabs {
++-    background: #444;
++-}
++- 
++-.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
++-    background-color: #222;
++-    color: #ccc;
++-} 
++- 
++-.control-label {
++-    color: #ccc;
++-} 
++- 
++-.masthead:before {
++-    background-color: #222;
++-} 
++-
++-.mastbottom {
++-    background-color: #222;
++-} 
++- 
++-.dropdown-menu {
++-    border: 4px solid #999;
++-	background-color: #181818;
++-}
++-
++-.dropdown-menu > li > a:hover {
++-    background: #999;
++-    color: #fff;
++-}
++-
++-.dropdown-menu > li > a:hover i {
++-    color: #fff;
++-}
++-
++-.user-login .navbar-footer {
++-    background-color: #555;
++-}
++-
++-.user-login-drop > li:first-child {
++-    background-color: #555;
++-}
++- 
++-
++-.arrow-up:before {
++-    border-color: transparent transparent #999;
++-}
++-
++-.modal-header {
++-    border-bottom: 1px solid #555;
++-} 
++- 
++-.modal-content {
++-    background-color: #444;
++-} 
++- 
++-.modal-footer {
++-    border-top: 1px solid #555;
++-} 
++- 
++-.profile-data.modal-body h3 {
++-    border-bottom: none !important;
++-} 
++- 
++-.mini-profile-contact li a.default-contact {
++-    background-color: #555;
++-} 
++- 
++-
++-.avatar-over>.status:before {
++-    border: 4px solid #555;
++-} 
++- 
++-.panel-login {
++-    background: #181818 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
++-} 
++- 
++-.panel-login .signin-text span {
++-    background: #181818;
++-} 
++-
++-.panel-heading {
++-    border-color: #555;
++-}
++- 
++- 
++-.panel-forum {
++-    background: rgba(0, 0, 0, 0.9);
++-}
++-
++-.panel-forum > .panel-heading {
++-    background: transparent url("./images/bg-maintitle.png") repeat-x scroll 0 50%;
++-} 
++- 
++- 
++-.panel-default {
++-    border-color: #999;
++-}
++- 
++-.panel{
++-    background: rgba(0, 0, 0, 0.9);
++-}
++-
++-.panel > .panel-heading {
++-    background: transparent url("./images/bg-maintitle.png") repeat-x scroll 0 50%;
++-	background-size:cover;
++-} 
++- 
++-.panel-body {
++-    background-color: rgba(0,0,0,0.1);
++-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
++-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-} 
++-
++-.panel-footer {
++-    background-color: rgba(0,0,0,0.1);
++-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
++-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-    border-top: 1px solid #555;
++-}
++-
++-.form-control {
++-    background: #181818;
++-	color: #999;
++-}
++-
++-.tag-editor .placeholder, .tag-editor input {
++-	color: #999;
++-}
++-
++-.tag-editor input:focus {
++-    box-shadow: none;
++-}
++-
++-.control-bbtags .tag-editor {
++-	border: 2px solid #444;
++-	background: #181818;
++-    color: #999;
++-}
++-
++-.tag-editor .tag-editor-tag {
++-    color: #8d9aa5;
++-    background: #444;
++-}
++-
++-.tag-editor .tag-editor-delete {
++-    background: #444;
++-}
++-
++-.tag-editor .tag-editor-delete i:before{
++-    color: #8d9aa5;
++-}
++- 
++-.attachbox {
++-    background-color: #181818;
++-}
++-
++-.separator i {
++-    background: rgba(0, 0, 0, 0.1) -moz-linear-gradient(center top , rgba(255, 255, 255, 0.09) 0%, transparent 100%) repeat scroll 0 0;
++-}
++- 
++-.pagination > li > a, .pagination > li > span {
++-    background: #222222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
++-} 
++-
++-.pagination > li > a, .pagination > li > span:hover {
++-    background: #222222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
++-} 
++- 
++-.pagination > li > a, .pagination > li > span {
++-    border: 2px solid #999;
++-} 
++-
++-.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
++-    background-color: #555;
++-    border-color: #999;
++-    color: #999;
++-}
++-
++-.pagination > li > a:focus,
++-.pagination > li > a:hover,
++-.pagination > li > span:focus,
++-.pagination > li > span:hover {
++-    background-color: #555;
++-	color: #999;
++-}
++-
++-
++-.pager li > a, .pager li > span {
++-    background-color: #444;
++-    border: 1px solid #333;
++-}
++-
++-.pager li > a:focus, 
++-.pager li > a:hover {
++-    background-color: #555;
++-    border: 1px solid #444;
++-	color: #999;
++-}
++-
++-.separator:before {
++-    background: #999;
++-}
++-
++-.separator i {
++-    background: transparent;
++-} 
++- 
++-.btn-default {
++-    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
++-}
++-
++-.btn-default:hover,
++-.btn-default:focus,
++-.btn-default:active,
++-.btn-default.active,
++-.open .dropdown-toggle.btn-default {
++-    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
++-}
++-
++-.btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .open .dropdown-toggle.btn-default {
++-    border-color: #999;
++-}
++-
++-
++-.dropdown-menu > li > a:focus, .dropdown-menu > li > a:hover {
++-    background-color: #777;
++-}
++-
++-.btn-default.active.focus, .btn-default.active:focus, .btn-default.active:hover, .btn-default.focus:active, .btn-default:active:focus, .btn-default:active:hover, .open > .dropdown-toggle.btn-default.focus, .open > .dropdown-toggle.btn-default:focus, .open > .dropdown-toggle.btn-default:hover {
++-    background-color: #777;
++-}
++-
++-.btn-default {
++-    color: #e0e0e0 !important;
++-}
++-
++-.btn-default:hover {
++-    color: #fff !important;
++-}
++-
++-
++-.ui-timeline .tl-item .tl-body .tl-content {
++-    background-color: #444;
++-}
++-
++-.ui-timeline .tl-item .tl-body .tl-content:after {
++-    border-color: transparent #444 transparent transparent;
++-}
++-
++-.ui-timeline .tl-item.alt .tl-body .tl-content:after {
++-    border-color: transparent transparent transparent #444;
++-}
++-
++-
++-.ui-timeline .tl-item .tl-body .tl-time {
++-    color: #fff;
++-}
++-
++-.square-icon {
++-    box-shadow: none;
++-}
++-
++-
++-.notification-content li {
++-    border-bottom: 4px solid #999;
++-}
++-
++-.counter {
++-    text-shadow: none;
++-}
++-
++-
++-.login-full .signin-text span {
++-    background: #181818;
++-}
++-
++-.login-full {
++-    background: #181818 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
++-    padding: 20px;
++-}
++-
++-.breadcrumb-line {
++-    background: #181818;
++-}
++-
++-.breadcrumb li:first-child a {
++-    background: #222;
++-}
++-
++-.panel-post .panel-bottom {
++-    background-color: #181818;
++-}
++- 
++-.section-page {
++-    background: rgba(255, 255, 255, 0.1);
++-	background-color: rgba(255, 255, 255, 0.1);
++-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
++-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-}
++-
++-.icon-wrapper {
++-    background: rgba(255, 255, 255, 0.1);
++-    background-color: rgba(255, 255, 255, 0.1);
++-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
++-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-	}
++-
++-.table-primary tbody tr:nth-child(2n+1) td, .table-primary tbody tr:nth-child(2n+1) th {
++-    background-color: rgba(0,0,0,0.1);
++-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
++-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-}
++-
++-.table {
++-    background: inherit;
++-}
++-
++-
++-table .stats-col {
++-    background-color: rgba(0,0,0,0.1)!important;
++-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent))!important;
++-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent)!important;
++-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent)!important;
++-}
++-
++-
++-
++-.table-primary tbody td {
++-    background: url("./images/highlight_reallyfaint.png");
++-    background-color: rgba(0,0,0,0.1);
++-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
++-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-}
++-
++-.table-primary tbody tr:nth-child(2n+1) td,
++-.table-primary tbody tr:nth-child(2n+1) th {
++-    background: url("./images/highlight_reallyfaint.png");
++-    background-color: rgba(0,0,0,0.1);
++-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
++-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-}
++-
++-.table tr.active td,
++-.table tr.active {
++-    background-color: rgba(0,0,0,0.1);
++-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
++-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-}
++-
++-
++-.table > thead > tr > th {
++-    background-color: rgba(0,0,0,0.1);
++-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
++-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-}
++-
++-.table-hover > tbody > tr:hover > td,
++-.table-hover > tbody > tr:hover > th {
++-    background-color: rgba(0,0,0,0.1);
++-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
++-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-	color: #888;
++-}
++-
++-.table-striped > tbody > tr:nth-of-type(2n+1) {
++-    background-color: inherit;
++-}
++-
++-
++-.table-hover > tbody > tr:hover > td, .table-hover > tbody > tr:hover > th {
++-    background-color: rgba(0,0,0,0.1);
++-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
++-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-    color: #888;
++-}
++-
++-
++-.table-striped > tbody > tr:hover {
++-    background-color: rgba(0,0,0,0.1);
++-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
++-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
++-}
++-
++-
++-.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
++-    border-top: 4px solid #2d2d2d;
++-}
++-
++-
++-.form-control {
++-    border: 2px solid #444;
++-}
++-
++-.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
++-    background-color: #363636;
++-}
++-
++-.panel-post h6, .panel-post h6 > a {
++-    color: #666 !important;
++-}
++-
++-
++-.alert-default {
++-    background-color: #222;
++-    border-color: #999;
++-    color: #555;
++-}
++-
++-
++-
++-.comment_starter {
++-    background: #555;
++-    color: #ccc;
++-}
++-
++-.comment-body {
++-    color: #ccc;
++-}
++-
++-.comment_reply {
++-    background: #444;
++-	border-top: 1px solid #777;
++-}
++-
++-.comment footer {
++-    background-color: #555;
++-}
++-
++-.list-group-item {
++-    background: #444;
++-}
++-
++-a.list-group-item:focus,
++-a.list-group-item:hover {
++-    background-color: #555;
++-	color: #999;
++-}
++-
++-.input-group-addon {
++-    background-color: #444;
++-    border: 2px solid #444;
++-	color: #999;
++-}
++-
++-.nav-tabs > li > a:hover,
++-.nav-tabs > li > a:focus {
++-    background-color: #626262;
++-}
++-
++-.progress {
++-    background-color: #444;
++-}
++-
++-.thumbnail {
++-    background-color: #444;
++-    border: 1px solid #999;
++-}
++-
++-
++-.alert-default {
++-    background-color: #222;
++-    border: 2px solid #999;
++-    color: #555;
++-}
++-
++-#darken {
++-    opacity: 0.7;
++-    -ms-filter : "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
++-}
++-
++-.close {
++-    color: #fff!important;
++-    text-shadow:0 1px 0 transparent;
++-}
++-
++-.phpbb_alert p {
++-    color: #fff;
++-}
++-
++-.bbtag, .bbtags-topic .bbtag {
++-    color: #888 !important;
++-}
++-
++-.bbtag:before, .bbtag:after {
++-    background: #222;
++-}
++-
++-.bbtag:hover, .bbtags-topic .bbtag:hover  {
++-    background-color: #ffa800;
++-}
++-
++-.bbtag:hover:after, .bbtags-topic .bbtag:hover:after {
++-    border-left-color: #ffa800;
++-}
++-
++-.bbtags-topic .bbtag:before, .bbtags-topic .bbtag:after {
++-    background: #333;
++-}
++-
++-.section-pre-footer {
++-    background: #222;
++-}
++-
++-.section-pre-footer .section-bg {
++-    background: #292929;
++-}
++-
++-@media (max-width:767px) {
++-	.container>.navbar-header {
++-		padding-bottom: 5px;
++-	}
++-	.section-pre-footer .section-bg {
++-		background: none repeat scroll 0 center transparent;
++-	}
++-}
++-
++-@media (max-width:468px) {
++-	.section-pre-footer .section-bg {
++-		background: none repeat scroll 0 center transparent;
++-	}
++-}
++-
++-.section-pre-footer p, .twitter h3 a small, .copyrights, .debug-output {
++-	color: #888;
++-}
++-
++-.twitter h3 a small:hover {
++-	color: #ffa800;
++-}
++-
++-.section-pre-footer a:hover,
++-.footer-nav a:hover,
++-.debug-output a:hover {
++-	color: #ffa800;
++-}
++-
++-.burned-asphalt {
++-    background-color: #181818;
++-}
++-
++-.avatar-over img {
++-    border: 4px solid #555;
++-}
++-
++-h3 {
++-    border-bottom: 4px solid #777 !important;
++-}
++-
++-.popover {
++-    background-color: #333;
++-}
++-
++-.popover.right > .arrow:after {
++-    border-right-color: #444;
++-}
++-
++-.popover-title {
++-    background-color: #555;
++-}
++-
++-.badge_award h3 {
++-    border-bottom: none;
++-}
++-
++-
++-.footable.breakpoint > tbody > tr > td > span.footable-toggle {
++-    background: #222;
++-    color: #cacaca;
++-}
++-
++-.footable.breakpoint > tbody > tr.footable-row-detail {
++-    background: #222;
++-}
++-
++-.search-input-fullscreen {
++-    background-color: #333;
++-}
++-
++-.search-input-fullscreen input:focus {
++-box-shadow: none;
++-}
++-
++-.label-huskygray {
++-    background-color: #333;
++-}
++-
++-.sidebar .panel {
++-    border-radius: 4px;
++-}
++-
++-.list-announcement .panel-body ul > li a {
++-    color: #fafafa;
++-}
++-
++-.list-announcement .panel-body ul > li small {
++-    color: #ccc;
++-}
++-
++-.user-list .media-body small.date, .list-announcement .media-body small.date {
++-    color: #ccc;
++-}
++-
++-.card .com-contain {
++-    background: rgba(0, 0, 0, 0.7);
++-}
++-
++-.com-stuff {
++-    background: transparent -webkit-radial-gradient(center center ellipse , rgba(0, 0, 0, 1) 0%, transparent 100%);
++-    background: transparent radial-gradient(ellipse at center center , rgba(0, 0, 0, 1) 0%, transparent 100%);
++-}
++-
++-.avn-price-table.avn-style12 {
++-    background: #666;
++-}
++-
++-.avn-price-table.avn-style12 .avn-tagline {
++-    color: #fafafa;
++-}
++-
++-.share-button {
++-    background-color: #333;
++-    border: 1px solid #444;
++-}
++-
++-.share-button > a:hover,
++-.share-button > a:hover:after {
++-	color: #ddd;
++-	background-color: rgb(60,60,60);
++-    border-color:888;
++-}
++-
++-.icons-wrapper {
++-    background-color: rgb(60, 60, 60);
++-}
++-
++-.share-button .icons-wrapper ul li:last-child a {
++-    background-color: #444;
++-}
++-
++-.share-button .icons-wrapper ul li a:hover i {
++-   color:#555;
++-}
++-
++-.share-button a:hover,
++-.share-button button:hover,
++-.share-button a:focus,
++-.share-button button:focus {
++-    color: #ddd;
++-}
++-
++-.sidebar .panel-info > .panel-heading {
++-    background-color: #444;
++-    border-color: transparent;
++-}
++-
++-.panel-primary > .panel-heading,
++-.panel-info > .panel-heading,
++-.panel-custom > .panel-heading,
++-.panel-success > .panel-heading,
++-.panel-warning > .panel-heading {
++-    background-color: #444;
++-    border-color: transparent;
++-}
++-
++-.user-list .media-object {
++-    border: 2px solid #444;
++-}
++-
++-
++-.list-announcement .panel-body ul > li small {
++-    color: #fff;
++-}
++-
++-.list-announcement .panel-body ul > li a {
++-    color: #ffd700;
++-}
++-
++-.sidebar .nav > li > a:focus,
++-.sidebar .nav > li > a:hover {
++-    background-color: #444;
++-}
++-
++-
++-.list-group-item {
++-    background-color: #444;
++-    border: 1px solid #555;
++-}
++-
++-.list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
++-    background-color: #555;
++-    border-color: #555;
++-}
++-
++-a.list-group-item:focus, a.list-group-item:hover, button.list-group-item:focus, button.list-group-item:hover {
++-    background-color: #626262;
++-    color: #fafafa;
++-}
++-
++-.panel-poll {
++-    border-color: transparent;
++-    border-style: solid;
++-    border-width: 2px;
++-}
++-
++-.mini-timeline:before {
++-    background: #555;
++-}
++-
++-.mini-timeline > li:last-child:before {
++-    background: #555;
++-}
++-
++-.mini-timeline > li .timeline-body {
++-    background-color: transparent;
++-}
++-
++-.cc-revoke, .cc-window {
++-	background: #181818;
++-}
++-.cc-link, .cc-link:focus {
++-	color: #ffa800 !important;
++-}
++-.com-stuff p {
++-    color: #8c8c8c;
++-    font-size: 16px;
++-}
++-.btn.focus, .btn:focus, .btn:hover {
++-    color: #e4e4e4;
++-}
++-.btn-default {
++-    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
++-}
++-.btn-default:hover,
++-.btn-default:focus,
++-.btn-default:active,
++-.btn-default.active,
++-.open .dropdown-toggle.btn-default {
++-    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
++-}
++-.donation-actions {
++-    background-color: #181818;
++-    border: 3px solid #999;
++-}
++-.donation-actions p {
++-    color: #8d9aa5;
++-}
++-.donation-premium > strong,
++-#donationicons .amt-donation {
++-    color: #ffa800;
++-}
++-#donationmessage, #submission {
++-    background-color: #444;
++-}
++-#donationmessage h3 {
++-	color: #ffa800;
++-    border-bottom: none !important;
++-}
++-.donation-actions h2,
++-#donationicons > span + p span {
++-    color: #fafafa;
++-}
++-.donation-actions p a,
++-#submission output {
++-    color: #ffa800;
++-}
++-#donationicons > span.selected:before {
++-    color: #7F7F7F;
++-    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
++-}
++-#donationicons > span:before {
++-  color: rgba(42,42,42, 0.8);
++-  /* this creates the "inset" text shadow */
++-  text-shadow: 1px 2px 2px #000, 0 0 0 #444, 1px 2px 2px #000, 0 1px 1px rgba(255, 255, 255, 0.5);
++-}
++-#donationicons > span:after {
++-    border-bottom: 7px solid #444;
++-}
++-input:focus {
++-    outline: none !important;
++-    border-color: #CDCDCD;
++-    box-shadow: 0 0 10px #CDCDCD;
++-}
++-input[type=range] {
++-    background-color: #999;
++-}
++-
++-input[type=range]::-webkit-slider-runnable-track {
++-    background-color: #444;
++-}
++-input[type=range]::-moz-range-track {
++-    background-color: #444;
++-}
++-input[type="range"]::-ms-track {
++-    background-color: #444;
++-}
++-input[type=range]::-webkit-slider-thumb {
++-    background: -webkit-linear-gradient(left, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), -webkit-linear-gradient(left, #959595, #BBBBBB 40%, #BBBBBB 60%, #959595);
++-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBBBBB 40%, #BBBBBB 60%, #959595);
++-    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBBBBB inset, 0 5px 10px rgba(0, 0, 0, 0.5);
++-}
++-input[type=range]::-webkit-slider-thumb:hover, input[type=range]::-webkit-slider-thumb:active {
++-    background: -webkit-linear-gradient(left, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), -webkit-linear-gradient(left, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
++-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
++-}
++-input[type=range]::-moz-range-thumb {
++-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBBBBB 40%, #BBBBBB 60%, #959595);
++-    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBBBBB inset, 0 5px 10px rgba(0, 0, 0, 0.5);
++-}
++-input[type=range]::-moz-range-thumb:hover, input[type=range]::-moz-range-thumb:active {
++-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
++-}
++-input[type=range]::-ms-thumb {
++-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBBBBB 40%, #BBBBBB 60%, #959595);
++-    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBBBBB inset, 0 5px 10px rgba(0, 0, 0, 0.5);
++-}
++-input[type=range]::-ms-thumb:hover, input[type=range]::-ms-thumb:active {
++-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
++-}
++-#submission .btn-bbdonation {
++-    background-color: #363636;
++-    border: 0 none #444;
++-}
++-#submission .btn-bbdonation:hover,
++-#submission .btn-bbdonation:focus,
++-#submission .btn-bbdonation:active {
++-    background-color: #7f7f7f;
++-    border: 0 none #d6d9e0;
++-}
++-.member-info {
++-  color: rgb(141, 154, 165);
++-}
++-.member-info a {
++-    color: rgb(250, 250, 250);
++-}
++-
++-@media (max-width: 768px) {
++-    #donationicons > span:after {
++-        border-bottom: medium none;
++-    }
++-}
++-
++-.flatpickr-input {
++-    background:transparent;
++-}
++-
++-.flatpickr-calendar {
++-    background: #2b2a2a;
++-}
++-
++-.flatpickr-current-month {
++-    color: #fff;
++-}
++-
++-
++-span.flatpickr-weekday {
++-    color:rgba(255, 255, 255, 0.54);
++-}
++-
++-.flatpickr-day.flatpickr-disabled, .flatpickr-day.flatpickr-disabled:hover {
++-    color: #d94444;
++-}
++-
++-.flatpickr-day {
++-    color:#fff;
++-}
++-
++-.flatpickr-day.inRange, .flatpickr-day.prevMonthDay.inRange, .flatpickr-day.nextMonthDay.inRange, .flatpickr-day.today.inRange, .flatpickr-day.prevMonthDay.today.inRange, .flatpickr-day.nextMonthDay.today.inRange, .flatpickr-day:hover, .flatpickr-day.prevMonthDay:hover, .flatpickr-day.nextMonthDay:hover, .flatpickr-day:focus, .flatpickr-day.prevMonthDay:focus, .flatpickr-day.nextMonthDay:focus {
++-    background: #714b4b;
++-}
++-
++-flatpickr-day.flatpickr-disabled, .flatpickr-day.flatpickr-disabled:hover, .flatpickr-day.prevMonthDay, .flatpickr-day.nextMonthDay, .flatpickr-day.notAllowed, .flatpickr-day.notAllowed.prevMonthDay, .flatpickr-day.notAllowed.nextMonthDay {
++-    color: rgba(155, 88, 88, 0.3);
++-}
++-
++-.flatpickr-time input {
++-   color:#fffbfb;
++-}
++-
++-.flatpickr-time .flatpickr-time-separator, .flatpickr-time .flatpickr-am-pm {
++-    color: #fff;
++-}
++-.flatpickr-time input:hover, .flatpickr-time .flatpickr-am-pm:hover, .flatpickr-time input:focus, .flatpickr-time .flatpickr-am-pm:focus {
++-    background: #45a1ce;
++-}
++-
++-/* ===[ BBDOWNLOADS START ]=== */
++-.widget, .post {
++-    box-shadow: none;
++-}
++-.post .details {
++-    background: rgba(0, 0, 0, 0.9);
++-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
++-    color: #ccc;
++-}
++-.widget .header.header-item {
++-    background: rgba(40, 40, 40, 0.9) url(../../../../bbdownloads/styles/FLATBOOTS/theme/images/item-header-pattern.png) repeat scroll 0 0;
++-}
++-.container.with_sidebar .et_pb_column_sidebar {
++-    background: rgba(38, 38, 38, 0.9);
++-}
++-.btn.btn-primary.changelog {
++-    background: #a1d36e;
++-}
++-.btn.btn-primary.changelog:hover {
++-    background: #94cd5a !important;
++-}
++-.btn.btn-secondary {
++-    background: #6ad1dd !important;
++-}
++-.container-downloads .btn {
++-    background: #777;
++-}
++-/* ===[ BBDOWNLOADS END ]=== */
++-
++-/* ===[ BBMEMBERSHIP START ]=== */
++-.npt-format-1 .npt-item {
++-    background: rgba(0, 0, 0, 0.9);
++-}
++-.npt-plan-name {
++-    border-bottom: 0 none !important;
++-}
++-.npt-plan-bottom .avn-btn {
++-    background: #181818 none repeat scroll 0 0;
++-}
++-.npt-plan-bottom .avn-btn:hover {
++-    background: #3a3a3a none repeat scroll 0 0;
++-}
++-.thumbnail, .bg-group-info, .btn-primary {
++-    background-color: #262626;
++-}
++-.btn-primary:hover {
++-    background-color: #3a3a3a !important;
++-}
++-.text-muted {
++-    color: #fff;
++-}
++-/* ===[ BBMEMBERSHIP END ]=== */
++-
++-/* ===[ BBCHAT START ]=== */
++-.rooms li {
++-    border-bottom: .6em dotted #777;
++-}
++-
++-.person:before,
++-.person:hover span {
++-    background: #333;
++-}
++-
++-.bbchat .left .people a:link,
++-.bbchat .left .people a:hover,
++-.bbchat .left .people a:visited {
++-    color: #8c8c8c;
++-}
++-
++-.bbchat,
++-.bbchat .left,
++-.bbchat .right {
++-    background-color: #262626;
++-    border-color: #999;
++-}
++-
++-.delete-message:before, .layout-list .delete-message:before {
++-    border: 3px dashed #181818;
++-}
++-
++-.bbchat .right .top span .name,
++-.me .bubble {
++-    color: #fff;
++-}
++-
++-.bbchat .right .top:after {
++-    background: -webkit-linear-gradient(bottom,rgba(38,38,38,0) 10%,#262626 100%);
++-    background: linear-gradient(to top,rgba(38,38,38,0) 10%,#262626 100%);
++-}
++-
++-.bbchat .right .top,
++-.me .bubble:before,
++-.me .bubble,
++-.write input,
++-.ps:hover.ps--in-scrolling.ps--y>.ps__scrollbar-y-rail,
++-.ps:hover>.ps__scrollbar-y-rail:hover {
++-    background-color: #333 !important;
++-}
++-
++-.bbchat .right .write:before {
++-    background: -webkit-linear-gradient(top,rgba(38,38,38,0) 20%,#262626 100%);
++-    background: linear-gradient(to bottom,rgba(38,38,38,0) 20%,#262626 100%);
++-}
++-
++-.write {
++-    background-color: #333;
++-    border-color: #999;
++-}
++-
++-.giphy>input {
++-    border: 1px solid #999 !important;
++-}
++-
++-#chatbox-input,
++-.write input {
++-    color: #8c8c8c;
++-}
++-
++-.giphy,
++-.emoji-picker {
++-    background-color: #181818;
++-}
++-
++-.bbchat-attachments-input {
++-    background: #333;
++-    box-shadow: 0 1px 15px 1px rgba(51,51,51,.12);
++-}
++-
++-.bbchat-attachments-input>.button-upld {
++-    background: #222 url(images/highlight_reallyfaint.png) repeat-x scroll 0 0;
++-}
++-
++-.bbchat-attachments-input:hover>.button-upld {
++-    background: #777;
++-}
++-/* ===[ BBCHAT END ]=== */
++-
++-/* ===[ CSS HOOK BOTTOM ]=== */
+++body{background:#333 url(./images/bg.png) repeat repeat 100% 0}a:link{color:#fff}a:visited{color:#fafafa}a:hover{color:#fafafa}a.postlink-local:link{color:#FFBF00}a.postlink-local:visited{color:#bf8d20}a.postlink-local:hover{color:#daa520}#contentje h1,#contentje h2,#contentje h3,#contentje h4,#contentje h5,#contentje h6,#contentje h1 a,#contentje h2 a,#contentje h3 a,#contentje h4 a,#contentje h5 a,#contentje h6 a{color:#fff!important}.codebox{background-color:#444}code{background-color:#555}.codebox code{color:#fafafa}.content blockquote{background:#555}.btn-default.disabled,.btn-default[disabled],fieldset[disabled] .btn-default,.btn-default.disabled:hover,.btn-default[disabled]:hover,fieldset[disabled] .btn-default:hover,.btn-default.disabled:focus,.btn-default[disabled]:focus,fieldset[disabled] .btn-default:focus,.btn-default.disabled:active,.btn-default[disabled]:active,fieldset[disabled] .btn-default:active,.btn-default.disabled.active,.btn-default.active[disabled],fieldset[disabled] .btn-default.active{background-color:#999}#qr_postform .col-md-snappy{background:rgba(12,12,12,0.82) none repeat scroll 0 0}.prefix-popover{background-color:#555;border:2px solid #444}.prefix-popover:after{border-top:10px solid #444}.breadcrumb-buttons{background:#555;border-radius:0}.popup-box{background:#555}.profile-data h3{border-bottom:none!important}.navbar-inverse{border-color:#222}.navbar-nav-fancy > li > a:hover i{color:#fff}.flat-nav .navbar-nav > .open > a,.flat-nav .navbar-nav > .open > a:hover,.flat-nav .navbar-nav > .open > a:focus,.flat-nav .navbar-nav > .active > a,.flat-nav .navbar-nav > .active > a:hover,.flat-nav .navbar-nav > .active > a:focus{background-color:#888}.navbar-nav-fancy > li:before{background:#888}.blog-meta{background:#ffa800}.top-flat{background-color:#ffa800}.top-flat:hover{-webkit-transition:all .1s linear 0;transition:all .1s linear 0;color:#2d2d2d!important;border-bottom:none;background-color:#fff}.top-flat:hover:after{color:#2d2d2d}.section-pre-footer .thumb i{color:#ffa800}.side-segment > h3{color:#fff}.side-segment h3:after,.side-segment h2:after{background-color:#ffa800}a.forumtitle,a.topictitle,a.topictitleattribute{color:#ffa800}.mobile-post{background:#222;color:#cacaca}.btn-notification{background-color:#555}.notification-block img,.dropdown-avatar img,.profile-avatar img{border-color:#555}.list-group-item-info,a.list-group-item-info,.bg-info{background-color:#555}.square-icon{border:3px solid #444}.list-group-item-warning,a.list-group-item-warning,.bg-warning{background-color:#555}.bg-success,a.list-group-item-success,.list-group-item-success{background-color:#555}.bg-primary,.list-group-item-primary{background-color:#555}.box-placeholder{border:2px dashed #999;background:#555}.panel-default > .panel-heading{border-color:transparent;color:#fff}.postbody .content{color:#ccc}.well{background-color:#262626;border:3px solid #999}li .no_notifications{border-bottom:none!important}.form-actions{background:#444;border:2px solid #999}.nav-tabs{background:#333}.nav-tabs > li.active > a,.nav-tabs > li.active > a:focus,.nav-tabs > li.active > a:hover{background-color:#222;color:#ccc}.control-label{color:#ccc}.masthead:before{background-color:#222}.mastbottom{background-color:#222}.dropdown-menu{border:4px solid #999;background-color:#262626}.dropdown-menu > li > a:hover{background:#999;color:#fff}.dropdown-menu > li > a:hover i{color:#fff}.user-login .navbar-footer{background-color:#555}.user-login-drop > li:first-child{background-color:#555}.arrow-up:before{border-color:rgba(12,12,12,0) rgba(12,12,12,0) #999}.modal-header{border-bottom:1px solid #555}.modal-content{background-color:#444}.modal-footer{border-top:1px solid #555}.profile-data.modal-body h3{border-bottom:none!important}.mini-profile-contact li a.default-contact{background-color:#555}.avatar-over>.status:before{border:4px solid #555}.panel-login{background:#252525 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0}.panel-login .signin-text span{background:#252525}.panel-heading{border-color:#555}.panel-forum{background:rgba(12,12,12,0.9)}.panel-forum > .panel-heading{background:rgba(12,12,12,0) url(./images/bg-maintitle.png) repeat-x scroll 0 50%}.panel-default{border-color:#999}.panel{background:rgba(24,24,24,0.9)}.panel > .panel-heading{background:rgba(12,12,12,0) url(./images/bg-maintitle.png) repeat-x scroll 0 50%;background-size:cover}.panel-footer{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-moz-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent);border-top:1px solid #555}.form-control{background:#262626;color:#999}.tag-editor .placeholder,.tag-editor input{color:#999}.tag-editor input:focus{box-shadow:none}.control-bbtags .tag-editor{border:2px solid #444;background:#181818;color:#999}.tag-editor .tag-editor-tag{color:#8d9aa5;background:#444}.tag-editor .tag-editor-delete{background:#444}.tag-editor .tag-editor-delete i:before{color:#8d9aa5}.attachbox{background-color:#262626}.separator i{background:rgba(12,12,12,0.1) -moz-linear-gradient(center top,rgba(255,255,255,0.09) 0%,transparent 100%) repeat scroll 0 0}.pagination > li > a,.pagination > li > span{background:#222 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0}.pagination > li > a,.pagination > li > span:hover{background:#222 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0}.pagination > li > a,.pagination > li > span{border:2px solid #999}.pagination > .active > a,.pagination > .active > span,.pagination > .active > a:hover,.pagination > .active > span:hover,.pagination > .active > a:focus,.pagination > .active > span:focus{background-color:#555;border-color:#999;color:#999}.pagination > li > a:focus,.pagination > li > a:hover,.pagination > li > span:focus,.pagination > li > span:hover{background-color:#555;color:#999}.pager li > a,.pager li > span{background-color:#444;border:1px solid #333}.pager li > a:focus,.pager li > a:hover{background-color:#555;border:1px solid #444;color:#999}.separator:before{background:#999}.separator i{background:transparent}.btn-default{background:#252525 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0}.btn-default:hover,.btn-default:focus,.btn-default:active,.btn-default.active,.open .dropdown-toggle.btn-default{background:#252525 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0;border-color:#999}.dropdown-menu > li > a:focus,.dropdown-menu > li > a:hover{background-color:#777}.btn-default.active.focus,.btn-default.active:focus,.btn-default.active:hover,.btn-default.focus:active,.btn-default:active:focus,.btn-default:active:hover,.open > .dropdown-toggle.btn-default.focus,.open > .dropdown-toggle.btn-default:focus,.open > .dropdown-toggle.btn-default:hover{background-color:#777}.btn-default{color:#e0e0e0!important}.btn-default:hover{color:#fff!important}.ui-timeline .tl-item .tl-body .tl-content{background-color:#444}.ui-timeline .tl-item .tl-body .tl-content:after{border-color:rgba(12,12,12,0) #444 rgba(12,12,12,0) rgba(12,12,12,0)}.ui-timeline .tl-item.alt .tl-body .tl-content:after{border-color:rgba(12,12,12,0) rgba(12,12,12,0) rgba(12,12,12,0) #444}.ui-timeline .tl-item .tl-body .tl-time{color:#fff}.square-icon{box-shadow:none}.notification-content li{border-bottom:4px solid #999}.counter{text-shadow:none}.login-full .signin-text span{background:#262626}.login-full{background:#252525 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0;padding:20px}.breadcrumb-line{background:#262626}.breadcrumb{background:#262626}.breadcrumb li:first-child a{background:#262626}.panel-post .panel-bottom{background-color:#262626}.section-page{background:rgba(255,255,255,0.07);background-color:rgba(255,255,255,0.07);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09),transparent);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.icon-wrapper{background:rgba(255,255,255,0.1);background-color:rgba(255,255,255,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table-primary tbody tr:nth-child(2n+1) td,.table-primary tbody tr:nth-child(2n+1) th{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table{background:inherit}table .stats-col{background-color:rgba(0,0,0,0.1)!important;background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent))!important;background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%)!important;background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)!important}.table-primary tbody td{background:url(./images/highlight_reallyfaint.png);background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table-primary tbody tr:nth-child(2n+1) td,.table-primary tbody tr:nth-child(2n+1) th{background:url(./images/highlight_reallyfaint.png);background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table tr.active td,.table tr.active{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table > thead > tr > th{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table-hover > tbody > tr:hover > td,.table-hover > tbody > tr:hover > th{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent);color:#888}.table-striped > tbody > tr:nth-of-type(2n+1){background-color:inherit}.table-hover > tbody > tr:hover > td,.table-hover > tbody > tr:hover > th{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent);color:#888}.table-striped > tbody > tr:hover{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table > thead > tr > th,.table > tbody > tr > th,.table > tfoot > tr > th,.table > thead > tr > td,.table > tbody > tr > td,.table > tfoot > tr > td{border-top:4px solid rgba(255,255,255,0.09)}.form-control{border:2px solid #444}.form-control[disabled],.form-control[readonly],fieldset[disabled] .form-control{background-color:#363636}.panel-post h6,.panel-post h6 > a{color:#666!important}.alert-default{background-color:#222;border-color:#999;color:#555}.comment_starter{background:#555;color:#ccc}.comment-body{color:#ccc}.comment_reply{background:#444;border-top:1px solid #777}.comment footer{background-color:#555}.list-group-item{background:#444}a.list-group-item:focus,a.list-group-item:hover{background-color:#555;color:#999}.input-group-addon{background-color:#444;border:2px solid #444;color:#999}.nav-tabs > li > a:hover,.nav-tabs > li > a:focus{background-color:#555}.progress{background-color:#444}.thumbnail{background-color:#444;border:1px solid #999}.alert-default{background-color:#222;border:2px solid #999;color:#555}#darken{opacity:.7 -ms-filter : progid:DXImageTransform.Microsoft.Alpha(Opacity=70)}.close{color:#fff!important;text-shadow:0 1px 0 transparent}.phpbb_alert p{color:#fff}.bbtag,.bbtags-topic .bbtag{color:#888!important}.bbtag:before,.bbtag:after{background:#222}.bbtag:hover,.bbtags-topic .bbtag:hover{background-color:#ffa800}.bbtag:hover:after,.bbtags-topic .bbtag:hover:after{border-left-color:#ffa800}.bbtags-topic .bbtag:before,.bbtags-topic .bbtag:after{background:#333}.section-pre-footer{background:transparent}.section-pre-footer .section-bg{background:#292929}@media (max-width:767px){.container>.navbar-header{padding-bottom:5px}.section-pre-footer .section-bg{background:none repeat scroll 0 center transparent}}@media (max-width:468px){.section-pre-footer .section-bg{background:none repeat scroll 0 center transparent}}.section-pre-footer p,.twitter h3 a small,.copyrights,.debug-output{color:#888}.twitter h3 a small:hover{color:#ffa800}.section-pre-footer a:hover,.footer-nav a:hover,.debug-output a:hover{color:#ffa800}.burned-asphalt{background-color:transparent}.avatar-over img{border:4px solid #555}h3{border-bottom:4px solid #777!important}.popover{background-color:#333}.popover.right > .arrow::after{border-right-color:#444}.popover-title{background-color:#555}.badge_award h3{border-bottom:none}.footable.breakpoint > tbody > tr > td > span.footable-toggle{background:#222;color:#cacaca}.footable.breakpoint > tbody > tr.footable-row-detail{background:#222}.search
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.bak" "[FORUM_EXT]/sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.bak"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.bak"
@@ -0,0 +1,1610 @@
+/*****************************************************************
+* Custom CSS Stylesheet. You can add any custom CSS selectors here after the comment line. 
+* They will be given the highest priority on any elements on the forum
+* **************************************************************
+*
+* FLATBOOTS @SiteSplat.com - Custom CSS STYLESHEET - DARK Theme
+* 
+***************************************************************
+*****************************************************************/
+/* ===[ CSS HOOK TOP ]=== */
+body {
+    background: #333 url(./images/bg.png) repeat repeat 100% 0;
+    // color: #fff
+	// background-color: #333;
+}
+
+a:link {
+    color: #fff
+}
+
+a:visited {
+    color: #fafafa
+}
+
+a:hover {
+    color: #fafafa
+}
+
+#contentje h1,
+#contentje h2,
+#contentje h3,
+#contentje h4,
+#contentje h5,
+#contentje h6,
+#contentje h1 a,
+#contentje h2 a,
+#contentje h3 a,
+#contentje h4 a,
+#contentje h5 a,
+#contentje h6 a {
+    color: #fff!important
+}
+
+.codebox {
+    background-color: #444
+}
+
+code {
+    background-color: #555
+}
+
+.codebox code {
+    color: #fafafa
+}
+
+.content blockquote {
+    background: #555
+}
+
+.btn-default.disabled,
+.btn-default[disabled],
+fieldset[disabled] .btn-default,
+.btn-default.disabled:hover,
+.btn-default[disabled]:hover,
+fieldset[disabled] .btn-default:hover,
+.btn-default.disabled:focus,
+.btn-default[disabled]:focus,
+fieldset[disabled] .btn-default:focus,
+.btn-default.disabled:active,
+.btn-default[disabled]:active,
+fieldset[disabled] .btn-default:active,
+.btn-default.disabled.active,
+.btn-default.active[disabled],
+fieldset[disabled] .btn-default.active {
+    background-color: #999
+}
+
+#qr_postform .col-md-snappy {
+    background: rgba(12, 12, 12, 0.82) none repeat scroll 0 0
+}
+
+.prefix-popover {
+    background-color: #555;
+    border: 2px solid #444
+}
+
+.prefix-popover:after {
+    border-top: 10px solid #444
+}
+
+.breadcrumb-buttons {
+    background: #555;
+    border-radius: 0
+}
+
+.popup-box {
+    background: #555
+}
+
+.profile-data h3 {
+    border-bottom: none!important
+}
+
+.navbar-inverse {
+	// background: #333 url("./images/bg-maintitle.png") repeat-x scroll 0 0;
+    border-color: #222
+}
+
+.navbar-nav-fancy > li > a:hover i {
+    color: #fff;
+}
+
+.flat-nav .navbar-nav > .open > a,
+.flat-nav .navbar-nav > .open > a:hover,
+.flat-nav .navbar-nav > .open > a:focus,
+.flat-nav .navbar-nav > .active > a,
+.flat-nav .navbar-nav > .active > a:hover,
+.flat-nav .navbar-nav > .active > a:focus {
+	background-color: #888;
+}
+
+.navbar-nav-fancy > li:before {
+    background: #888;
+}
+
+.blog-meta {
+    background: #ffa800
+}
+
+.top-flat {
+    background-color: #ffa800
+}
+
+.top-flat:hover {
+-webkit-transition : all .1s linear 0s;
+transition: all .1s linear 0s;
+    color: #2d2d2d!important;
+    border-bottom: none;
+    background-color: #fff;
+}
+.top-flat:hover:after {
+	color: #2d2d2d;
+}
+
+.section-pre-footer .thumb i {
+    color: #ffa800;
+}
+
+.side-segment > h3 {
+    color: #fff;
+}
+
+.side-segment h3:after,
+.side-segment h2:after {
+    background-color: #ffa800
+}
+
+a.forumtitle,
+a.topictitle,
+a.topictitleattribute {
+    color: #ffa800
+}
+
+.mobile-post {
+    background: #222;
+    color: #cacaca
+}
+
+.btn-notification {
+    background-color: #555
+}
+
+.notification-block img,
+.dropdown-avatar img,
+.profile-avatar img {
+    border-color: #555
+}
+
+.list-group-item-info,
+a.list-group-item-info,
+.bg-info {
+    background-color: #555
+}
+
+.square-icon {
+    border: 3px solid #444
+}
+
+.list-group-item-warning,
+a.list-group-item-warning,
+.bg-warning {
+    background-color: #555
+}
+
+.bg-success,
+a.list-group-item-success,
+.list-group-item-success {
+    background-color: #555
+}
+
+.bg-primary,
+.list-group-item-primary {
+    background-color: #555
+}
+
+/* ===[ SMART COLLAPSE ]=== */
+ /* ========================================================================
+   Component: placeholder.less
+ ========================================================================== */
+.box-placeholder {
+  border: 2px dashed #999;
+  background: #555;
+}
+/* ===[ SMART COLLAPSE ]=== */
+
+.panel-default > .panel-heading {
+    border-color: transparent;
+    color: #fff
+}
+
+.postbody .content {
+    color: #ccc
+}
+
+.well {
+    background-color: #262626;
+    border: 3px solid #999
+}
+
+li .no_notifications {
+    border-bottom: none!important
+}
+
+.form-actions {
+    background: #444;
+    border: 2px solid #999
+}
+
+.nav-tabs {
+    background: #333
+}
+
+.nav-tabs > li.active > a,
+.nav-tabs > li.active > a:focus,
+.nav-tabs > li.active > a:hover {
+    background-color: #222;
+    color: #ccc
+}
+
+.control-label {
+    color: #ccc
+}
+
+.masthead:before {
+    background-color: #222
+}
+
+.mastbottom {
+    background-color: #222
+}
+
+.dropdown-menu {
+    border: 4px solid #999;
+    background-color: #262626
+}
+
+.dropdown-menu > li > a:hover {
+    background: #999;
+    color: #fff
+}
+
+.dropdown-menu > li > a:hover i {
+    color: #fff
+}
+
+.user-login .navbar-footer {
+    background-color: #555
+}
+
+.user-login-drop > li:first-child {
+    background-color: #555
+}
+
+.arrow-up:before {
+    border-color: rgba(12, 12, 12, 0) rgba(12, 12, 12, 0) #999
+}
+
+.modal-header {
+    border-bottom: 1px solid #555
+}
+
+.modal-content {
+    background-color: #444
+}
+
+.modal-footer {
+    border-top: 1px solid #555
+}
+
+.profile-data.modal-body h3 {
+    border-bottom: none!important
+}
+
+.mini-profile-contact li a.default-contact {
+    background-color: #555
+}
+
+.avatar-over>.status:before {
+    border: 4px solid #555
+}
+
+.panel-login {
+    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0
+}
+
+.panel-login .signin-text span {
+    background: #252525
+}
+
+.panel-heading {
+    border-color: #555
+}
+
+.panel-forum {
+    background: rgba(12, 12, 12, 0.9)
+}
+
+.panel-forum > .panel-heading {
+    background: rgba(12, 12, 12, 0) url("./images/bg-maintitle.png") repeat-x scroll 0 50%
+}
+
+.panel-default {
+    border-color: #999
+}
+
+.panel {
+    background: rgba(24, 24, 24, 0.9)
+}
+
+.panel > .panel-heading {
+    background: rgba(12, 12, 12, 0) url("./images/bg-maintitle.png") repeat-x scroll 0 50%;
+    background-size: cover
+}
+
+.panel-body {
+    background-color: rgba(0, 0, 0, 0.1);
+    background-image: -webkit-gradient(linear, left top, left bottom, from(#252525), to(#181818));
+    background-image: -moz-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+}
+
+.panel-footer {
+    background-color: rgba(0, 0, 0, 0.1);
+    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+    background-image: -moz-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent);
+    border-top: 1px solid #555
+}
+
+.form-control {
+    background: #262626;
+    color: #999
+}
+
+.tag-editor .placeholder, .tag-editor input {
+	color: #999;
+}
+
+.tag-editor input:focus {
+    box-shadow: none;
+}
+
+.control-bbtags .tag-editor {
+	border: 2px solid #444;
+	background: #181818;
+    color: #999;
+}
+
+.tag-editor .tag-editor-tag {
+    color: #8d9aa5;
+    background: #444;
+}
+
+.tag-editor .tag-editor-delete {
+    background: #444;
+}
+
+.tag-editor .tag-editor-delete i:before{
+    color: #8d9aa5;
+}
+
+.attachbox {
+    background-color: #262626
+}
+
+.separator i {
+    background: rgba(12, 12, 12, 0.1) -moz-linear-gradient(center top, rgba(255, 255, 255, 0.09) 0%, transparent 100%) repeat scroll 0 0
+}
+
+.pagination > li > a,
+.pagination > li > span {
+    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0
+}
+
+.pagination > li > a,
+.pagination > li > span:hover {
+    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0
+}
+
+.pagination > li > a,
+.pagination > li > span {
+    border: 2px solid #999
+}
+
+.pagination > .active > a,
+.pagination > .active > span,
+.pagination > .active > a:hover,
+.pagination > .active > span:hover,
+.pagination > .active > a:focus,
+.pagination > .active > span:focus {
+    background-color: #555;
+    border-color: #999;
+    color: #999
+}
+
+.pagination > li > a:focus,
+.pagination > li > a:hover,
+.pagination > li > span:focus,
+.pagination > li > span:hover {
+    background-color: #555;
+    color: #999
+}
+
+.pager li > a,
+.pager li > span {
+    background-color: #444;
+    border: 1px solid #333
+}
+
+.pager li > a:focus,
+.pager li > a:hover {
+    background-color: #555;
+    border: 1px solid #444;
+    color: #999
+}
+
+.separator:before {
+    background: #999
+}
+
+.separator i {
+    background: transparent
+}
+
+.btn-default {
+    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0
+}
+
+.btn-default:hover,
+.btn-default:focus,
+.btn-default:active,
+.btn-default.active,
+.open .dropdown-toggle.btn-default {
+    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+    border-color: #999
+}
+
+.dropdown-menu > li > a:focus,
+.dropdown-menu > li > a:hover {
+    background-color: #777
+}
+
+.btn-default.active.focus,
+.btn-default.active:focus,
+.btn-default.active:hover,
+.btn-default.focus:active,
+.btn-default:active:focus,
+.btn-default:active:hover,
+.open > .dropdown-toggle.btn-default.focus,
+.open > .dropdown-toggle.btn-default:focus,
+.open > .dropdown-toggle.btn-default:hover {
+    background-color: #777
+}
+
+.btn-default {
+    color: #e0e0e0!important
+}
+
+.btn-default:hover {
+    color: #fff!important
+}
+
+.ui-timeline .tl-item .tl-body .tl-content {
+    background-color: #444
+}
+
+.ui-timeline .tl-item .tl-body .tl-content:after {
+    border-color: rgba(12, 12, 12, 0) #444 rgba(12, 12, 12, 0) rgba(12, 12, 12, 0)
+}
+
+.ui-timeline .tl-item.alt .tl-body .tl-content:after {
+    border-color: rgba(12, 12, 12, 0) rgba(12, 12, 12, 0) rgba(12, 12, 12, 0) #444
+}
+
+.ui-timeline .tl-item .tl-body .tl-time {
+    color: #fff
+}
+
+.square-icon {
+    box-shadow: none
+}
+
+.notification-content li {
+    border-bottom: 4px solid #999
+}
+
+.counter {
+    text-shadow: none
+}
+
+.login-full .signin-text span {
+    background: #262626
+}
+
+.login-full {
+    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+    padding: 20px
+}
+
+.breadcrumb-line {
+    background: #262626
+}
+
+.breadcrumb {
+    background: #262626
+}
+
+.breadcrumb li:first-child a {
+    background: #262626
+}
+
+.panel-post .panel-bottom {
+    background-color: #262626
+}
+
+.section-page {
+    background: rgba(255, 255, 255, 0.07);
+    background-color: rgba(255, 255, 255, 0.07)
+    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
+    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
+    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
+}
+
+.icon-wrapper {
+    background: rgba(255, 255, 255, 0.1);
+    background-color: rgba(255, 255, 255, 0.1);
+    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+}
+
+.table-primary tbody tr:nth-child(2n+1) td,
+.table-primary tbody tr:nth-child(2n+1) th {
+    background-color: rgba(0, 0, 0, 0.1);
+    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+}
+
+.table {
+    background: inherit
+}
+
+table .stats-col {
+    background-color: rgba(0, 0, 0, 0.1)!important;
+    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent))!important;
+    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%)!important;
+    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)!important
+}
+
+.table-primary tbody td {
+    background: url("./images/highlight_reallyfaint.png");
+    background-color: rgba(0, 0, 0, 0.1);
+    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+}
+
+.table-primary tbody tr:nth-child(2n+1) td,
+.table-primary tbody tr:nth-child(2n+1) th {
+    background: url("./images/highlight_reallyfaint.png");
+    background-color: rgba(0, 0, 0, 0.1);
+    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+}
+
+.table tr.active td,
+.table tr.active {
+    background-color: rgba(0, 0, 0, 0.1);
+    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+}
+
+.table > thead > tr > th {
+    background-color: rgba(0, 0, 0, 0.1);
+    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+}
+
+.table-hover > tbody > tr:hover > td,
+.table-hover > tbody > tr:hover > th {
+    background-color: rgba(0, 0, 0, 0.1);
+    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent);
+    color: #888
+}
+
+.table-striped > tbody > tr:nth-of-type(2n+1) {
+    background-color: inherit
+}
+
+.table-hover > tbody > tr:hover > td,
+.table-hover > tbody > tr:hover > th {
+    background-color: rgba(0, 0, 0, 0.1);
+    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent);
+    color: #888
+}
+
+.table-striped > tbody > tr:hover {
+    background-color: rgba(0, 0, 0, 0.1);
+    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+    background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.09) 0%, transparent 100%);
+    background-image: linear-gradient(top, rgba(255, 255, 255, 0.09), transparent)
+}
+
+.table > thead > tr > th,
+.table > tbody > tr > th,
+.table > tfoot > tr > th,
+.table > thead > tr > td,
+.table > tbody > tr > td,
+.table > tfoot > tr > td {
+    border-top: 4px solid rgba(255, 255, 255, 0.09)
+}
+
+.form-control {
+    border: 2px solid #444
+}
+
+.form-control[disabled],
+.form-control[readonly],
+fieldset[disabled] .form-control {
+    background-color: #363636
+}
+
+.panel-post h6,
+.panel-post h6 > a {
+    color: #666!important
+}
+
+.alert-default {
+    background-color: #222;
+    border-color: #999;
+    color: #555
+}
+
+.comment_starter {
+    background: #555;
+    color: #ccc
+}
+
+.comment-body {
+    color: #ccc
+}
+
+.comment_reply {
+    background: #444;
+    border-top: 1px solid #777
+}
+
+.comment footer {
+    background-color: #555
+}
+
+.list-group-item {
+    background: #444
+}
+
+a.list-group-item:focus,
+a.list-group-item:hover {
+    background-color: #555;
+    color: #999
+}
+
+.input-group-addon {
+    background-color: #444;
+    border: 2px solid #444;
+    color: #999
+}
+
+.nav-tabs > li > a:hover,
+.nav-tabs > li > a:focus {
+    background-color: #555
+}
+
+.progress {
+    background-color: #444
+}
+
+.thumbnail {
+    background-color: #444;
+    border: 1px solid #999
+}
+
+.alert-default {
+    background-color: #222;
+    border: 2px solid #999;
+    color: #555
+}
+
+#darken {
+    opacity: .7
+    -ms-filter : "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
+}
+
+.close {
+    color: #fff!important;
+    text-shadow: 0 1px 0 transparent
+}
+
+.phpbb_alert p {
+    color: #fff
+}
+
+.bbtag, .bbtags-topic .bbtag {
+    color: #888 !important;
+}
+
+.bbtag:before, .bbtag:after {
+    background: #222;
+}
+
+.bbtag:hover, .bbtags-topic .bbtag:hover  {
+    background-color: #ffa800;
+}
+
+.bbtag:hover:after, .bbtags-topic .bbtag:hover:after {
+    border-left-color: #ffa800;
+}
+
+.bbtags-topic .bbtag:before, .bbtags-topic .bbtag:after {
+    background: #333;
+}
+
+.section-pre-footer {
+    background: transparent
+}
+
+.section-pre-footer .section-bg {
+    background: #292929
+}
+
+@media (max-width:767px) {
+	.container>.navbar-header {
+		padding-bottom: 5px;
+	}
+	.section-pre-footer .section-bg {
+		background: none repeat scroll 0 center transparent;
+	}
+}
+
+@media (max-width:468px) {
+	.section-pre-footer .section-bg {
+		background: none repeat scroll 0 center transparent;
+	}
+}
+
+.section-pre-footer p, .twitter h3 a small, .copyrights, .debug-output {
+	color: #888;
+}
+
+.twitter h3 a small:hover {
+	color: #ffa800;
+}
+
+.section-pre-footer a:hover,
+.footer-nav a:hover,
+.debug-output a:hover {
+	color: #ffa800;
+}
+
+.burned-asphalt {
+    background-color: transparent
+}
+
+.avatar-over img {
+    border: 4px solid #555
+}
+
+h3 {
+    border-bottom: 4px solid #777!important
+}
+
+.popover {
+    background-color: #333
+}
+
+.popover.right > .arrow::after {
+    border-right-color: #444
+}
+
+.popover-title {
+    background-color: #555
+}
+
+.badge_award h3 {
+    border-bottom: none
+}
+
+.footable.breakpoint > tbody > tr > td > span.footable-toggle {
+    background: #222;
+    color: #cacaca
+}
+
+.footable.breakpoint > tbody > tr.footable-row-detail {
+    background: #222
+}
+
+.search-input-fullscreen {
+    background-color: #333
+}
+
+.search-input-fullscreen input:focus {
+box-shadow: none;
+}
+
+.label-huskygray {
+    background-color: #333;
+    float: left!important
+}
+
+.sidebar .panel {
+    border-radius: 6px 6px 2px 2px;
+    background-color: none
+}
+
+#page-sidebar .panel-inverse > .panel-heading {
+    background-color: #505b72
+}
+
+#page-sidebar .panel-info > .panel-heading {
+    background-color: #5bc0de
+}
+
+#page-sidebar .panel-primary > .panel-heading {
+    background-color: #337ab7
+}
+
+#page-sidebar .panel-success > .panel-heading {
+    background-color: #2dcb73
+}
+
+#page-sidebar .panel-body {
+    background-color: #222
+}
+
+.list-announcement .panel-body ul > li a {
+    color: #fafafa
+}
+
+.list-announcement .panel-body ul > li small {
+    color: #ccc
+}
+
+.user-list .media-body small.date,
+.list-announcement .media-body small.date {
+    color: #ccc
+}
+
+.card .com-contain {
+    background: rgba(12, 12, 12, 0.7)
+}
+
+.com-stuff {
+    background: rgba(12, 12, 12, 0) -webkit-radial-gradient(center center ellipse, rgba(12, 12, 12, 1) 0%, rgba(12, 12, 12, 0) 100%)
+    background: rgba(12, 12, 12, 0) radial-gradient(ellipse at center center , rgba(12, 12, 12, 1) 0%, rgba(12, 12, 12, 0 100%);
+}
+
+.avn-price-table.avn-style12 {
+    background: #666
+}
+
+.avn-price-table.avn-style12 .avn-tagline {
+    color: #fafafa
+}
+
+.share-button {
+    background-color: #333;
+    border: 1px solid #444
+}
+
+.share-button > a:hover,
+.share-button > a:hover:after {
+    color: #ddd;
+    background-color: #3c3c3c;
+    border-color: #888
+}
+
+.icons-wrapper {
+    background-color: #3c3c3c
+}
+
+.share-button .icons-wrapper ul li:last-child a {
+    background-color: #444
+}
+
+.share-button .icons-wrapper ul li a:hover i {
+    color: #555
+}
+
+.share-button a:hover,
+.share-button button:hover,
+.share-button a:focus,
+.share-button button:focus {
+    color: #ddd
+}
+
+.sidebar .panel {
+    background-color: #292c2e!important
+}
+
+.sidebar .panel-info > .panel-heading {
+    background-color: #444;
+    border-color: transparent
+}
+
+.sidebar .panel-body {
+    border-bottom-left-radius: 4px;
+    border-bottom-right-radius: 4px;
+    border-color: #444;
+    border-image: none;
+    border-style: none solid solid;
+    border-width: medium 1px 1px
+}
+
+.panel-primary > .panel-heading,
+.panel-info > .panel-heading,
+.panel-custom > .panel-heading,
+.panel-success > .panel-heading,
+.panel-warning > .panel-heading {
+    background-color: #444;
+    border-color: transparent
+}
+
+.user-list .media-object {
+    border: 2px solid #444
+}
+
+.list-announcement .panel-body ul > li small {
+    color: #fff
+}
+
+.list-announcement .panel-body ul > li a {
+    color: #ffd700
+}
+
+.sidebar .nav > li > a:focus,
+.sidebar .nav > li > a:hover {
+    background-color: #444
+}
+
+.list-group-item {
+    background-color: #444;
+    border: 1px solid #555
+}
+
+.list-group-item.active,
+.list-group-item.active:focus,
+.list-group-item.active:hover {
+    background-color: #555;
+    border-color: #555
+}
+
+a.list-group-item:focus,
+a.list-group-item:hover,
+button.list-group-item:focus,
+button.list-group-item:hover {
+    background-color: #626262;
+    color: #fafafa
+}
+
+.panel-poll {
+    border-color: transparent;
+    border-style: solid;
+    border-width: 2px
+}
+
+.mini-timeline::before {
+    background: #555
+}
+
+.mini-timeline > li:last-child::before {
+    background: #555
+}
+
+.mini-timeline > li .timeline-body {
+    background-color: transparent
+}
+
+.cc-revoke, .cc-window {
+	background: #181818;
+}
+.cc-link, .cc-link:focus {
+	color: #ffa800 !important;
+}
+.com-stuff p {
+    color: #8c8c8c;
+    font-size: 16px;
+}
+.btn.focus, .btn:focus, .btn:hover {
+    color: #e4e4e4;
+}
+.btn-default {
+    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+}
+.btn-default:hover,
+.btn-default:focus,
+.btn-default:active,
+.btn-default.active,
+.open .dropdown-toggle.btn-default {
+    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
+}
+
+.donation-actions {
+    background-color: #262626;
+    border: 3px solid #999
+}
+
+.donation-actions p {
+    color: #8d9aa5
+}
+
+.donation-premium > strong,
+#donationicons .amt-donation {
+    color: #ffa800
+}
+#donationmessage, #submission {
+    background-color: #444;
+}
+#donationmessage h3 {
+	color: #ffa800;
+    border-bottom: none !important;
+}
+.donation-actions h2,
+#donationicons > span + p span {
+    color: #fafafa
+}
+.donation-actions p a,
+#submission output {
+    color: #ffa800
+}
+#donationicons > span.selected:before {
+    color: #7F7F7F;
+    text-shadow: 1px 1px 2px rgba(12, 12, 12, 0.5)
+}
+#donationicons > span:before {
+    color: rgba(21, 23, 25, 0.8);
+    /* this creates the "inset" text shadow */
+    text-shadow: 1px 2px 2px #222, 0 0 0 #000, 1px 2px 2px #222, 0 1px 1px rgba(255, 255, 255, 0.5)
+}
+#donationicons > span:after {
+    border-bottom: 7px solid #444
+}
+
+input:focus {
+    outline: none!important;
+    border-color: #CDCDCD
+    box-shadow: 0 0 10px #CDCDCD;
+}
+
+input[type=range] {
+    background-color: #999
+}
+
+input[type=range]::-webkit-slider-runnable-track {
+    background-color: #444
+}
+
+input[type=range]::-moz-range-track {
+    background-color: #444
+}
+
+input[type="range"]::-ms-track {
+    background-color: #444
+}
+
+input[type=range]::-webkit-slider-thumb {
+    background: -webkit-linear-gradient(left, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), -webkit-linear-gradient(left, #959595, #BBB 40%, #BBB 60%, #959595);
+    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBB 40%, #BBB 60%, #959595);
+    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBB inset, 0 5px 10px rgba(12, 12, 12, 0.5)
+}
+
+input[type=range]::-webkit-slider-thumb:hover,
+input[type=range]::-webkit-slider-thumb:active {
+    background: -webkit-linear-gradient(left, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), -webkit-linear-gradient(left, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
+    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4)
+}
+
+input[type=range]::-moz-range-thumb {
+    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBB 40%, #BBB 60%, #959595);
+    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBB inset, 0 5px 10px rgba(12, 12, 12, 0.5)
+}
+
+input[type=range]::-moz-range-thumb:hover,
+input[type=range]::-moz-range-thumb:active {
+    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4)
+}
+
+input[type=range]::-ms-thumb {
+    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBB 40%, #BBB 60%, #959595);
+    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBB inset, 0 5px 10px rgba(12, 12, 12, 0.5)
+}
+
+input[type=range]::-ms-thumb:hover,
+input[type=range]::-ms-thumb:active {
+    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4)
+}
+
+#submission .btn-bbdonation {
+    background-color: #363636;
+    border: 0 none #444
+}
+
+#submission .btn-bbdonation:hover,
+#submission .btn-bbdonation:focus,
+#submission .btn-bbdonation:active {
+    background-color: #7f7f7f;
+    border: 0 none #d6d9e0
+}
+
+.member-info {
+    color: #8d9aa5
+}
+
+.member-info a {
+    color: #fafafa
+}
+
+.alert-info {
+    background-color: #8a6d3b
+}
+
+.side-segment > h3 {
+    color: #fff
+}
+
+.chat-row {
+    background-color: #222
+}
+
+.chat-row:nth-child(even) {
+    background-color: #323232
+}
+
+.chat-row:hover {
+    background-color: #121212
+}
+
+#chat-message textarea,
+#chat-dialog textarea {
+    background-color: #323232
+}
+
+#chat-right-panel,
+#chat-conversation-container,
+#chat-tabs li.active,
+#chat-toolbar a.active,
+.ic-box {
+    background: #323232
+}
+
+#chat-body {
+    color: #FFF
+}
+
+.blg-table {
+    color: #fff
+}
+
+.blg-table .blg-column-topic-title {
+    text-align: left
+}
+
+.blg-widget-content {
+    background: #252525;
+    border: 0
+}
+
+.blg-widget-header {
+    background: #353535;
+    border: 1px solid #171717;
+    color: #d6a400;
+    padding: 2px 2px 4px
+}
+
+input,
+textarea#mchat-input {
+    color: #181818
+}
+
+#chat-body blockquote {
+    background-color: #696969
+}
+
+.blg-state-hover a,
+.blg-state-hover a:hover {
+    color: #353535
+}
+
+.blg-state-default a,
+.blg-state-default a:link,
+.blg-state-default a:visited {
+    color: #171717
+}
+
+.blg-accordion > .blg-state-default a,
+.blg-accordion > .blg-state-default a:link,
+.blg-accordion > .blg-state-default a:visited {
+    color: #fff
+}
+
+.blg-accordion-icons .blg-accordion-header {
+    background-color: transparent;
+    color: #FFF
+}
+
+.blg-calendar-info {
+    background: #252525
+}
+
+.blg-calendar-event {
+    background: #d6a400
+}
+
+.blg-dialog .blg-dialog-content,
+.blg-dialog .dialog-text {
+    color: #ddd
+}
+
+.blg-state-default {
+    background: #f5f5f5;
+    border: 1px solid #282828;
+    color: #333
+}
+
+.blg-state-highlight {
+    background: #fbec88!important;
+    color: #363636!important
+}
+
+.blg-state-hover,
+.blg-state-focus {
+    background: #f2f2f2;
+    border: 1px solid #282828;
+    color: #222
+}
+
+.calendar tbody a {
+    color: #000
+}
+
+.calendar .month-title,
+.calendar .cal-header {
+    color: #fff
+}
+
+.calendar.autofit tbody a {
+    color: #d6a403;
+    background-color: transparent;
+    border-color: #181818
+}
+
+.calendar a.today {
+    color: #fff!important
+}
+
+.blg-inputbox {
+    color: #757575
+}
+
+.ads img {
+    opacity: 1;
+    filter: alpha(opacity=1)
+}
+
+.nightpanel {
+    padding-right: 0
+}
+
+.breadcrumb .icon {
+    color: #d6a400
+}
+
+.blg-icon {
+    color: #d6a400
+}
+
+a.blg-button {
+    color: #181818!important
+}
+
+.blg-align-center {
+    color: #fff
+}
+
+.panel-bottom-messages {
+    margin-top: 15px;
+    padding: 15px
+}
+
+.blg-calendar td {
+    background-color: #222
+}
+
+.blg-calendar-event.blg-event-birthday {
+    background: #ccc
+}
+
+#qm_main select,
+.qm-dialog select,
+.qm_inputbox,
+.qm-menu,
+.qm-button,
+.row_mark input {
+    color: #181818
+}
+
+.quick_mod_buttons {
+    background-color: transparent
+}
+
+a [class*="qm-icon"] {
+    color: #b8bdcb
+}
+
+@media (max-width: 768px) {
+    #donationicons > span:after {
+        border-bottom: medium none
+    }
+}
+
+.flatpickr-input {
+    background: transparent
+}
+
+.flatpickr-calendar {
+    background: #2b2a2a
+}
+
+.flatpickr-current-month {
+    color: #fff
+}
+
+span.flatpickr-weekday {
+    color: rgba(255, 255, 255, 0.54)
+}
+
+.flatpickr-day.flatpickr-disabled,
+.flatpickr-day.flatpickr-disabled:hover {
+    color: #d94444
+}
+
+.flatpickr-day {
+    color: #fff
+}
+
+.flatpickr-day.inRange,
+.flatpickr-day.prevMonthDay.inRange,
+.flatpickr-day.nextMonthDay.inRange,
+.flatpickr-day.today.inRange,
+.flatpickr-day.prevMonthDay.today.inRange,
+.flatpickr-day.nextMonthDay.today.inRange,
+.flatpickr-day:hover,
+.flatpickr-day.prevMonthDay:hover,
+.flatpickr-day.nextMonthDay:hover,
+.flatpickr-day:focus,
+.flatpickr-day.prevMonthDay:focus,
+.flatpickr-day.nextMonthDay:focus {
+    background: #714b4b
+}
+
+flatpickr-day.flatpickr-disabled,
+.flatpickr-day.flatpickr-disabled:hover,
+.flatpickr-day.prevMonthDay,
+.flatpickr-day.nextMonthDay,
+.flatpickr-day.notAllowed,
+.flatpickr-day.notAllowed.prevMonthDay,
+.flatpickr-day.notAllowed.nextMonthDay {
+    color: rgba(155, 88, 88, 0.3)
+}
+
+.flatpickr-time input {
+    color: #fffbfb
+}
+
+.flatpickr-time .flatpickr-time-separator,
+.flatpickr-time .flatpickr-am-pm {
+    color: #fff
+}
+
+.flatpickr-time input:hover,
+.flatpickr-time .flatpickr-am-pm:hover,
+.flatpickr-time input:focus,
+.flatpickr-time .flatpickr-am-pm:focus {
+    background: #45a1ce
+}
+
+/* ===[ BBDOWNLOADS START ]=== */
+.widget,
+.post {
+    box-shadow: none
+}
+
+.post .details {
+    background: rgba(0, 0, 0, 0.9);
+    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.09)), to(transparent));
+    color: #ccc
+}
+
+.widget .header.header-item {
+    background: rgba(40, 40, 40, 0.9) url("../../../../bbdownloads/styles/FLATBOOTS/theme/images/item-header-pattern.png") repeat scroll 0 0
+}
+
+.container.with_sidebar .et_pb_column_sidebar {
+    background: rgba(38, 38, 38, 0.9)
+}
+
+.btn.btn-primary.changelog {
+    background: #a1d36e
+}
+
+.btn.btn-primary.changelog:hover {
+    background: #94cd5a!important
+}
+
+.btn.btn-secondary {
+    background: #6ad1dd!important
+}
+
+.container-downloads .btn {
+    background: #777
+}
+/* ===[ BBDOWNLOADS END ]=== */
+
+/* ===[ BBMEMBERSHIP START ]=== */
+
+.npt-format-1 .npt-item {
+    background: rgba(0, 0, 0, 0.9)
+}
+
+.npt-plan-name {
+    border-bottom: 0 none!important
+}
+
+.npt-plan-bottom .avn-btn {
+    background: #181818 none repeat scroll 0 0
+}
+
+.npt-plan-bottom .avn-btn:hover {
+    background: #3a3a3a none repeat scroll 0 0
+}
+
+.thumbnail,
+.bg-group-info,
+.btn-primary {
+    background-color: #262626
+}
+
+.btn-primary:hover {
+    background-color: #3a3a3a!important
+}
+
+.text-muted {
+    color: #fff
+}
+/* ===[ BBMEMBERSHIP END ]=== */
+
+/* ===[ BBCHAT START ]=== */
+
+.rooms li {
+    border-bottom: .6em dotted #777
+}
+
+.person:before,
+.person:hover span {
+    background: #333
+}
+
+.bbchat .left .people a:link,
+.bbchat .left .people a:hover,
+.bbchat .left .people a:visited {
+    color: #8c8c8c
+}
+
+.bbchat,
+.bbchat .left,
+.bbchat .right {
+    background-color: #262626;
+    border-color: #999
+}
+
+.delete-message:before,
+.layout-list .delete-message:before {
+    border: 3px dashed #181818
+}
+
+.bbchat .right .top span .name,
+.me .bubble {
+    color: #fff
+}
+
+.bbchat .right .top:after {
+    background: -webkit-linear-gradient(bottom, rgba(38, 38, 38, 0) 10%, #262626 100%);
+    background: linear-gradient(to top, rgba(38, 38, 38, 0) 10%, #262626 100%)
+}
+
+.bbchat .right .top,
+.me .bubble:before,
+.me .bubble,
+.write input,
+.ps:hover.ps--in-scrolling.ps--y>.ps__scrollbar-y-rail,
+.ps:hover>.ps__scrollbar-y-rail:hover {
+    background-color: #333!important
+}
+
+.bbchat .right .write:before {
+    background: -webkit-linear-gradient(top, rgba(38, 38, 38, 0) 20%, #262626 100%);
+    background: linear-gradient(to bottom, rgba(38, 38, 38, 0) 20%, #262626 100%)
+}
+
+.write {
+    background-color: #333;
+    border-color: #999
+}
+
+.giphy>input {
+    border: 1px solid #999!important
+}
+
+#chatbox-input,
+.write input {
+    color: #8c8c8c
+}
+
+.giphy,
+.emoji-picker {
+    background-color: #181818
+}
+
+.bbchat-attachments-input {
+    background: #333;
+    box-shadow: 0 1px 15px 1px rgba(51, 51, 51, .12)
+}
+
+.bbchat-attachments-input>.button-upld {
+    background: #222 url(images/highlight_reallyfaint.png) repeat-x scroll 0 0
+}
+
+.bbchat-attachments-input:hover>.button-upld {
+    background: #777
+}
+/* ===[ BBCHAT END ]=== */
+.blog-summary {
+    color: #412525;
+}
+.blog-summary .btn {
+    margin-top: 10px;
+    background: #222222;
+    border: 1px solid #262626!important;
+}
+.blog-details {
+     background-color: #333;
+}
+.blog-title a {
+    color: #FFF!important;
+}
+
+.blog-item {
+    background: #333333;
+    border-radius: 5px;
+}
+.blog-quote .quote a {
+    border-radius: 0 0 10px 10px;
+}
+.blog-quote .blog-metas {
+    color: #ddd;
+}
+
+.textcomplete-item.active,
+.dropdown-menu>.active>a,
+.dropdown-menu>.active>a:focus,
+.dropdown-menu>.active>a:hover {
+    background-color:#161616;
+}
+/* ===[ CSS HOOK BOTTOM ]=== */
diff --git "[ORIGINAL]/sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.css" "[FORUM_EXT]/sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.css"
--- "[ORIGINAL]/sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.css"
+++ "[FORUM_EXT]/sitesplat\\nightstalker/styles/FLATBOOTS/theme/flatboots.css"
@@ -1,1240 +1 @@
-/*****************************************************************
-* Custom CSS Stylesheet. You can add any custom CSS selectors here after the comment line. 
-* They will be given the highest priority on any elements on the forum
-* **************************************************************
-*
-* FLATBOOTS @SiteSplat.com - Custom CSS STYLESHEET - DARK Theme
-* 
-***************************************************************
-*****************************************************************/
-/* ===[ CSS HOOK TOP ]=== */
-body {
-   // background: #000 url("./images/fallout4-background.jpg") repeat fixed 50% 0;
-   // color: #fff;
-   background-color: #333;
-}
-
-a:link {
-    color: #fff;
-}
-a:visited {
-    color: #fafafa;
-}
-a:hover {
-    color: #fafafa;
-}
-
-
-#contentje h1, #contentje h2, #contentje h3, #contentje h4, #contentje h5, #contentje h6,
-#contentje h1 a, #contentje h2 a, #contentje h3 a, #contentje h4 a, #contentje h5 a, #contentje h6 a {
-    color: #fff !important;
-}
-
-.codebox {
-    background-color: #444;
-}
-
-code {
-    background-color: #555;
-}
-
-.codebox code {
-   color: #fafafa;
-}
-
-.content blockquote {
-    background: #555;
-}
-
-.btn-default.disabled, .btn-default[disabled], fieldset[disabled] .btn-default, .btn-default.disabled:hover, .btn-default[disabled]:hover, fieldset[disabled] .btn-default:hover, .btn-default.disabled:focus, .btn-default[disabled]:focus, fieldset[disabled] .btn-default:focus, .btn-default.disabled:active, .btn-default[disabled]:active, fieldset[disabled] .btn-default:active, .btn-default.disabled.active, .btn-default.active[disabled], fieldset[disabled] .btn-default.active {
-    background-color: #999;
-}
-
-#qr_postform .col-md-snappy {
-    background: rgba(0, 0, 0, 0.82) none repeat scroll 0 0;
-}
-
-.prefix-popover {
-    background-color: #555;
-    border: 2px solid #444;
-}
-
-.prefix-popover:after {
-    border-top: 10px solid #444;
-}
-
-.breadcrumb-buttons {
-    background: #555;
-    border-radius: 0;
-}
-
-.popup-box {
-    background: #555;
-}
-
-.profile-data h3 {
-    border-bottom: none !important;
-}
-
-.navbar-inverse {
-    background: #000 url("./images/bg-maintitle.png") repeat-x scroll 0 0;
-    border-color: #222;
-}
-
-.navbar-nav-fancy > li > a:hover i {
-    color: #fff;
-}
-
-.flat-nav .navbar-nav > .open > a,
-.flat-nav .navbar-nav > .open > a:hover,
-.flat-nav .navbar-nav > .open > a:focus,
-.flat-nav .navbar-nav > .active > a,
-.flat-nav .navbar-nav > .active > a:hover,
-.flat-nav .navbar-nav > .active > a:focus {
-	background-color: #888;
-}
-
-.navbar-nav-fancy > li:before {
-    background: #888;
-}
-
-.blog-meta {
-    background: #ffa800;
-}
-
-.top-flat {
-    background-color: #ffa800;
-}
-
-.top-flat:hover {
--webkit-transition : all .1s linear 0s;
-transition: all .1s linear 0s;
-    color: #2d2d2d!important;
-    border-bottom: none;
-    background-color: #fff;
-}
-.top-flat:hover:after {
-	color: #2d2d2d;
-}
-
-.section-pre-footer .thumb i {
-    color: #ffa800;
-}
-
-.side-segment > h3 {
-    color: #fff;
-}
-
-.side-segment h3:after, .side-segment h2:after {
-    background-color: #ffa800;
-}
-
-a.forumtitle, a.topictitle {
-    color: #ffa800;
-}
-
-.mobile-post {
-    background: #222;
-    color: #cacaca;
-}
-
-.btn-notification {
-    background-color: #555;
-}
-
-.notification-block img,
-.dropdown-avatar img,
-.profile-avatar img {
-    border-color: #555;
-}
-
-.list-group-item-info, a.list-group-item-info, .bg-info {
-    background-color: #555;
-}
-
-
-.square-icon {
-    border: 3px solid #444;
-}
-
-.list-group-item-warning, a.list-group-item-warning, .bg-warning {
-    background-color: #555;
-}
-
-.bg-success, a.list-group-item-success, .list-group-item-success {
-    background-color: #555;
-}
-
-.bg-primary, .list-group-item-primary {
-    background-color: #555;
-}
-
-/* ===[ SMART COLLAPSE ]=== */
- /* ========================================================================
-   Component: placeholder.less
- ========================================================================== */
-.box-placeholder {
-  border: 2px dashed #999;
-  background: #555;
-}
-/* ===[ SMART COLLAPSE ]=== */
-
-.panel-default > .panel-heading {
-    border-color: transparent;
-    color: #fff;
-}
-
-.postbody .content {
-    color: #ccc;
-} 
- 
-.well {
-    background-color: #181818;
-    border: 3px solid #999;
-} 
- 
-li .no_notifications {
-    border-bottom: none !important;
-}
- 
-.form-actions {
-    background: #444;
-    border: 2px solid #999;
-} 
- 
-.nav-tabs {
-    background: #444;
-}
- 
-.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
-    background-color: #222;
-    color: #ccc;
-} 
- 
-.control-label {
-    color: #ccc;
-} 
- 
-.masthead:before {
-    background-color: #222;
-} 
-
-.mastbottom {
-    background-color: #222;
-} 
- 
-.dropdown-menu {
-    border: 4px solid #999;
-	background-color: #181818;
-}
-
-.dropdown-menu > li > a:hover {
-    background: #999;
-    color: #fff;
-}
-
-.dropdown-menu > li > a:hover i {
-    color: #fff;
-}
-
-.user-login .navbar-footer {
-    background-color: #555;
-}
-
-.user-login-drop > li:first-child {
-    background-color: #555;
-}
- 
-
-.arrow-up:before {
-    border-color: transparent transparent #999;
-}
-
-.modal-header {
-    border-bottom: 1px solid #555;
-} 
- 
-.modal-content {
-    background-color: #444;
-} 
- 
-.modal-footer {
-    border-top: 1px solid #555;
-} 
- 
-.profile-data.modal-body h3 {
-    border-bottom: none !important;
-} 
- 
-.mini-profile-contact li a.default-contact {
-    background-color: #555;
-} 
- 
-
-.avatar-over>.status:before {
-    border: 4px solid #555;
-} 
- 
-.panel-login {
-    background: #181818 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
-} 
- 
-.panel-login .signin-text span {
-    background: #181818;
-} 
-
-.panel-heading {
-    border-color: #555;
-}
- 
- 
-.panel-forum {
-    background: rgba(0, 0, 0, 0.9);
-}
-
-.panel-forum > .panel-heading {
-    background: transparent url("./images/bg-maintitle.png") repeat-x scroll 0 50%;
-} 
- 
- 
-.panel-default {
-    border-color: #999;
-}
- 
-.panel{
-    background: rgba(0, 0, 0, 0.9);
-}
-
-.panel > .panel-heading {
-    background: transparent url("./images/bg-maintitle.png") repeat-x scroll 0 50%;
-	background-size:cover;
-} 
- 
-.panel-body {
-    background-color: rgba(0,0,0,0.1);
-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
-} 
-
-.panel-footer {
-    background-color: rgba(0,0,0,0.1);
-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
-    border-top: 1px solid #555;
-}
-
-.form-control {
-    background: #181818;
-	color: #999;
-}
-
-.tag-editor .placeholder, .tag-editor input {
-	color: #999;
-}
-
-.tag-editor input:focus {
-    box-shadow: none;
-}
-
-.control-bbtags .tag-editor {
-	border: 2px solid #444;
-	background: #181818;
-    color: #999;
-}
-
-.tag-editor .tag-editor-tag {
-    color: #8d9aa5;
-    background: #444;
-}
-
-.tag-editor .tag-editor-delete {
-    background: #444;
-}
-
-.tag-editor .tag-editor-delete i:before{
-    color: #8d9aa5;
-}
- 
-.attachbox {
-    background-color: #181818;
-}
-
-.separator i {
-    background: rgba(0, 0, 0, 0.1) -moz-linear-gradient(center top , rgba(255, 255, 255, 0.09) 0%, transparent 100%) repeat scroll 0 0;
-}
- 
-.pagination > li > a, .pagination > li > span {
-    background: #222222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
-} 
-
-.pagination > li > a, .pagination > li > span:hover {
-    background: #222222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
-} 
- 
-.pagination > li > a, .pagination > li > span {
-    border: 2px solid #999;
-} 
-
-.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
-    background-color: #555;
-    border-color: #999;
-    color: #999;
-}
-
-.pagination > li > a:focus,
-.pagination > li > a:hover,
-.pagination > li > span:focus,
-.pagination > li > span:hover {
-    background-color: #555;
-	color: #999;
-}
-
-
-.pager li > a, .pager li > span {
-    background-color: #444;
-    border: 1px solid #333;
-}
-
-.pager li > a:focus, 
-.pager li > a:hover {
-    background-color: #555;
-    border: 1px solid #444;
-	color: #999;
-}
-
-.separator:before {
-    background: #999;
-}
-
-.separator i {
-    background: transparent;
-} 
- 
-.btn-default {
-    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
-}
-
-.btn-default:hover,
-.btn-default:focus,
-.btn-default:active,
-.btn-default.active,
-.open .dropdown-toggle.btn-default {
-    background: #252525 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
-}
-
-.btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .open .dropdown-toggle.btn-default {
-    border-color: #999;
-}
-
-
-.dropdown-menu > li > a:focus, .dropdown-menu > li > a:hover {
-    background-color: #777;
-}
-
-.btn-default.active.focus, .btn-default.active:focus, .btn-default.active:hover, .btn-default.focus:active, .btn-default:active:focus, .btn-default:active:hover, .open > .dropdown-toggle.btn-default.focus, .open > .dropdown-toggle.btn-default:focus, .open > .dropdown-toggle.btn-default:hover {
-    background-color: #777;
-}
-
-.btn-default {
-    color: #e0e0e0 !important;
-}
-
-.btn-default:hover {
-    color: #fff !important;
-}
-
-
-.ui-timeline .tl-item .tl-body .tl-content {
-    background-color: #444;
-}
-
-.ui-timeline .tl-item .tl-body .tl-content:after {
-    border-color: transparent #444 transparent transparent;
-}
-
-.ui-timeline .tl-item.alt .tl-body .tl-content:after {
-    border-color: transparent transparent transparent #444;
-}
-
-
-.ui-timeline .tl-item .tl-body .tl-time {
-    color: #fff;
-}
-
-.square-icon {
-    box-shadow: none;
-}
-
-
-.notification-content li {
-    border-bottom: 4px solid #999;
-}
-
-.counter {
-    text-shadow: none;
-}
-
-
-.login-full .signin-text span {
-    background: #181818;
-}
-
-.login-full {
-    background: #181818 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
-    padding: 20px;
-}
-
-.breadcrumb-line {
-    background: #181818;
-}
-
-.breadcrumb li:first-child a {
-    background: #222;
-}
-
-.panel-post .panel-bottom {
-    background-color: #181818;
-}
- 
-.section-page {
-    background: rgba(255, 255, 255, 0.1);
-	background-color: rgba(255, 255, 255, 0.1);
-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
-}
-
-.icon-wrapper {
-    background: rgba(255, 255, 255, 0.1);
-    background-color: rgba(255, 255, 255, 0.1);
-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
-	}
-
-.table-primary tbody tr:nth-child(2n+1) td, .table-primary tbody tr:nth-child(2n+1) th {
-    background-color: rgba(0,0,0,0.1);
-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
-}
-
-.table {
-    background: inherit;
-}
-
-
-table .stats-col {
-    background-color: rgba(0,0,0,0.1)!important;
-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent))!important;
-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent)!important;
-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent)!important;
-}
-
-
-
-.table-primary tbody td {
-    background: url("./images/highlight_reallyfaint.png");
-    background-color: rgba(0,0,0,0.1);
-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
-}
-
-.table-primary tbody tr:nth-child(2n+1) td,
-.table-primary tbody tr:nth-child(2n+1) th {
-    background: url("./images/highlight_reallyfaint.png");
-    background-color: rgba(0,0,0,0.1);
-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
-}
-
-.table tr.active td,
-.table tr.active {
-    background-color: rgba(0,0,0,0.1);
-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
-}
-
-
-.table > thead > tr > th {
-    background-color: rgba(0,0,0,0.1);
-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
-}
-
-.table-hover > tbody > tr:hover > td,
-.table-hover > tbody > tr:hover > th {
-    background-color: rgba(0,0,0,0.1);
-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
-	color: #888;
-}
-
-.table-striped > tbody > tr:nth-of-type(2n+1) {
-    background-color: inherit;
-}
-
-
-.table-hover > tbody > tr:hover > td, .table-hover > tbody > tr:hover > th {
-    background-color: rgba(0,0,0,0.1);
-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
-    color: #888;
-}
-
-
-.table-striped > tbody > tr:hover {
-    background-color: rgba(0,0,0,0.1);
-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
-    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.09), transparent);
-    background-image: linear-gradient(top, rgba(255,255,255,0.09), transparent);
-}
-
-
-.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
-    border-top: 4px solid #2d2d2d;
-}
-
-
-.form-control {
-    border: 2px solid #444;
-}
-
-.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
-    background-color: #363636;
-}
-
-.panel-post h6, .panel-post h6 > a {
-    color: #666 !important;
-}
-
-
-.alert-default {
-    background-color: #222;
-    border-color: #999;
-    color: #555;
-}
-
-
-
-.comment_starter {
-    background: #555;
-    color: #ccc;
-}
-
-.comment-body {
-    color: #ccc;
-}
-
-.comment_reply {
-    background: #444;
-	border-top: 1px solid #777;
-}
-
-.comment footer {
-    background-color: #555;
-}
-
-.list-group-item {
-    background: #444;
-}
-
-a.list-group-item:focus,
-a.list-group-item:hover {
-    background-color: #555;
-	color: #999;
-}
-
-.input-group-addon {
-    background-color: #444;
-    border: 2px solid #444;
-	color: #999;
-}
-
-.nav-tabs > li > a:hover,
-.nav-tabs > li > a:focus {
-    background-color: #626262;
-}
-
-.progress {
-    background-color: #444;
-}
-
-.thumbnail {
-    background-color: #444;
-    border: 1px solid #999;
-}
-
-
-.alert-default {
-    background-color: #222;
-    border: 2px solid #999;
-    color: #555;
-}
-
-#darken {
-    opacity: 0.7;
-    -ms-filter : "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
-}
-
-.close {
-    color: #fff!important;
-    text-shadow:0 1px 0 transparent;
-}
-
-.phpbb_alert p {
-    color: #fff;
-}
-
-.bbtag, .bbtags-topic .bbtag {
-    color: #888 !important;
-}
-
-.bbtag:before, .bbtag:after {
-    background: #222;
-}
-
-.bbtag:hover, .bbtags-topic .bbtag:hover  {
-    background-color: #ffa800;
-}
-
-.bbtag:hover:after, .bbtags-topic .bbtag:hover:after {
-    border-left-color: #ffa800;
-}
-
-.bbtags-topic .bbtag:before, .bbtags-topic .bbtag:after {
-    background: #333;
-}
-
-.section-pre-footer {
-    background: #222;
-}
-
-.section-pre-footer .section-bg {
-    background: #292929;
-}
-
-@media (max-width:767px) {
-	.container>.navbar-header {
-		padding-bottom: 5px;
-	}
-	.section-pre-footer .section-bg {
-		background: none repeat scroll 0 center transparent;
-	}
-}
-
-@media (max-width:468px) {
-	.section-pre-footer .section-bg {
-		background: none repeat scroll 0 center transparent;
-	}
-}
-
-.section-pre-footer p, .twitter h3 a small, .copyrights, .debug-output {
-	color: #888;
-}
-
-.twitter h3 a small:hover {
-	color: #ffa800;
-}
-
-.section-pre-footer a:hover,
-.footer-nav a:hover,
-.debug-output a:hover {
-	color: #ffa800;
-}
-
-.burned-asphalt {
-    background-color: #181818;
-}
-
-.avatar-over img {
-    border: 4px solid #555;
-}
-
-h3 {
-    border-bottom: 4px solid #777 !important;
-}
-
-.popover {
-    background-color: #333;
-}
-
-.popover.right > .arrow:after {
-    border-right-color: #444;
-}
-
-.popover-title {
-    background-color: #555;
-}
-
-.badge_award h3 {
-    border-bottom: none;
-}
-
-
-.footable.breakpoint > tbody > tr > td > span.footable-toggle {
-    background: #222;
-    color: #cacaca;
-}
-
-.footable.breakpoint > tbody > tr.footable-row-detail {
-    background: #222;
-}
-
-.search-input-fullscreen {
-    background-color: #333;
-}
-
-.search-input-fullscreen input:focus {
-box-shadow: none;
-}
-
-.label-huskygray {
-    background-color: #333;
-}
-
-.sidebar .panel {
-    border-radius: 4px;
-}
-
-.list-announcement .panel-body ul > li a {
-    color: #fafafa;
-}
-
-.list-announcement .panel-body ul > li small {
-    color: #ccc;
-}
-
-.user-list .media-body small.date, .list-announcement .media-body small.date {
-    color: #ccc;
-}
-
-.card .com-contain {
-    background: rgba(0, 0, 0, 0.7);
-}
-
-.com-stuff {
-    background: transparent -webkit-radial-gradient(center center ellipse , rgba(0, 0, 0, 1) 0%, transparent 100%);
-    background: transparent radial-gradient(ellipse at center center , rgba(0, 0, 0, 1) 0%, transparent 100%);
-}
-
-.avn-price-table.avn-style12 {
-    background: #666;
-}
-
-.avn-price-table.avn-style12 .avn-tagline {
-    color: #fafafa;
-}
-
-.share-button {
-    background-color: #333;
-    border: 1px solid #444;
-}
-
-.share-button > a:hover,
-.share-button > a:hover:after {
-	color: #ddd;
-	background-color: rgb(60,60,60);
-    border-color:888;
-}
-
-.icons-wrapper {
-    background-color: rgb(60, 60, 60);
-}
-
-.share-button .icons-wrapper ul li:last-child a {
-    background-color: #444;
-}
-
-.share-button .icons-wrapper ul li a:hover i {
-   color:#555;
-}
-
-.share-button a:hover,
-.share-button button:hover,
-.share-button a:focus,
-.share-button button:focus {
-    color: #ddd;
-}
-
-.sidebar .panel-info > .panel-heading {
-    background-color: #444;
-    border-color: transparent;
-}
-
-.panel-primary > .panel-heading,
-.panel-info > .panel-heading,
-.panel-custom > .panel-heading,
-.panel-success > .panel-heading,
-.panel-warning > .panel-heading {
-    background-color: #444;
-    border-color: transparent;
-}
-
-.user-list .media-object {
-    border: 2px solid #444;
-}
-
-
-.list-announcement .panel-body ul > li small {
-    color: #fff;
-}
-
-.list-announcement .panel-body ul > li a {
-    color: #ffd700;
-}
-
-.sidebar .nav > li > a:focus,
-.sidebar .nav > li > a:hover {
-    background-color: #444;
-}
-
-
-.list-group-item {
-    background-color: #444;
-    border: 1px solid #555;
-}
-
-.list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
-    background-color: #555;
-    border-color: #555;
-}
-
-a.list-group-item:focus, a.list-group-item:hover, button.list-group-item:focus, button.list-group-item:hover {
-    background-color: #626262;
-    color: #fafafa;
-}
-
-.panel-poll {
-    border-color: transparent;
-    border-style: solid;
-    border-width: 2px;
-}
-
-.mini-timeline:before {
-    background: #555;
-}
-
-.mini-timeline > li:last-child:before {
-    background: #555;
-}
-
-.mini-timeline > li .timeline-body {
-    background-color: transparent;
-}
-
-.cc-revoke, .cc-window {
-	background: #181818;
-}
-.cc-link, .cc-link:focus {
-	color: #ffa800 !important;
-}
-.com-stuff p {
-    color: #8c8c8c;
-    font-size: 16px;
-}
-.btn.focus, .btn:focus, .btn:hover {
-    color: #e4e4e4;
-}
-.btn-default {
-    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
-}
-.btn-default:hover,
-.btn-default:focus,
-.btn-default:active,
-.btn-default.active,
-.open .dropdown-toggle.btn-default {
-    background: #222 url("./images/highlight_reallyfaint.png") repeat-x scroll 0 0;
-}
-.donation-actions {
-    background-color: #181818;
-    border: 3px solid #999;
-}
-.donation-actions p {
-    color: #8d9aa5;
-}
-.donation-premium > strong,
-#donationicons .amt-donation {
-    color: #ffa800;
-}
-#donationmessage, #submission {
-    background-color: #444;
-}
-#donationmessage h3 {
-	color: #ffa800;
-    border-bottom: none !important;
-}
-.donation-actions h2,
-#donationicons > span + p span {
-    color: #fafafa;
-}
-.donation-actions p a,
-#submission output {
-    color: #ffa800;
-}
-#donationicons > span.selected:before {
-    color: #7F7F7F;
-    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
-}
-#donationicons > span:before {
-  color: rgba(42,42,42, 0.8);
-  /* this creates the "inset" text shadow */
-  text-shadow: 1px 2px 2px #000, 0 0 0 #444, 1px 2px 2px #000, 0 1px 1px rgba(255, 255, 255, 0.5);
-}
-#donationicons > span:after {
-    border-bottom: 7px solid #444;
-}
-input:focus {
-    outline: none !important;
-    border-color: #CDCDCD;
-    box-shadow: 0 0 10px #CDCDCD;
-}
-input[type=range] {
-    background-color: #999;
-}
-
-input[type=range]::-webkit-slider-runnable-track {
-    background-color: #444;
-}
-input[type=range]::-moz-range-track {
-    background-color: #444;
-}
-input[type="range"]::-ms-track {
-    background-color: #444;
-}
-input[type=range]::-webkit-slider-thumb {
-    background: -webkit-linear-gradient(left, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), -webkit-linear-gradient(left, #959595, #BBBBBB 40%, #BBBBBB 60%, #959595);
-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBBBBB 40%, #BBBBBB 60%, #959595);
-    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBBBBB inset, 0 5px 10px rgba(0, 0, 0, 0.5);
-}
-input[type=range]::-webkit-slider-thumb:hover, input[type=range]::-webkit-slider-thumb:active {
-    background: -webkit-linear-gradient(left, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), -webkit-linear-gradient(left, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
-}
-input[type=range]::-moz-range-thumb {
-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBBBBB 40%, #BBBBBB 60%, #959595);
-    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBBBBB inset, 0 5px 10px rgba(0, 0, 0, 0.5);
-}
-input[type=range]::-moz-range-thumb:hover, input[type=range]::-moz-range-thumb:active {
-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
-}
-input[type=range]::-ms-thumb {
-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #959595, #BBBBBB 40%, #BBBBBB 60%, #959595);
-    box-shadow: 0 -2px 0 #868686 inset, 0 2px 0 #BBBBBB inset, 0 5px 10px rgba(0, 0, 0, 0.5);
-}
-input[type=range]::-ms-thumb:hover, input[type=range]::-ms-thumb:active {
-    background: linear-gradient(to right, transparent, transparent 4px, #7C7C7C 4px, #7C7C7C 5px, transparent 5px, transparent 7px, #7C7C7C 7px, #7C7C7C 8px, transparent 8px, transparent 10px, #7C7C7C 10px, #7C7C7C 11px, transparent 11px, transparent 64px, #7C7C7C 64px, #7C7C7C 65px, transparent 65px, transparent 67px, #7C7C7C 67px, #7C7C7C 68px, transparent 68px, transparent 70px, #7C7C7C 70px, #7C7C7C 71px, transparent 71px), linear-gradient(to right, #B4B4B4, #C8C8C8 35%, #C8C8C8 65%, #B4B4B4);
-}
-#submission .btn-bbdonation {
-    background-color: #363636;
-    border: 0 none #444;
-}
-#submission .btn-bbdonation:hover,
-#submission .btn-bbdonation:focus,
-#submission .btn-bbdonation:active {
-    background-color: #7f7f7f;
-    border: 0 none #d6d9e0;
-}
-.member-info {
-  color: rgb(141, 154, 165);
-}
-.member-info a {
-    color: rgb(250, 250, 250);
-}
-
-@media (max-width: 768px) {
-    #donationicons > span:after {
-        border-bottom: medium none;
-    }
-}
-
-.flatpickr-input {
-    background:transparent;
-}
-
-.flatpickr-calendar {
-    background: #2b2a2a;
-}
-
-.flatpickr-current-month {
-    color: #fff;
-}
-
-
-span.flatpickr-weekday {
-    color:rgba(255, 255, 255, 0.54);
-}
-
-.flatpickr-day.flatpickr-disabled, .flatpickr-day.flatpickr-disabled:hover {
-    color: #d94444;
-}
-
-.flatpickr-day {
-    color:#fff;
-}
-
-.flatpickr-day.inRange, .flatpickr-day.prevMonthDay.inRange, .flatpickr-day.nextMonthDay.inRange, .flatpickr-day.today.inRange, .flatpickr-day.prevMonthDay.today.inRange, .flatpickr-day.nextMonthDay.today.inRange, .flatpickr-day:hover, .flatpickr-day.prevMonthDay:hover, .flatpickr-day.nextMonthDay:hover, .flatpickr-day:focus, .flatpickr-day.prevMonthDay:focus, .flatpickr-day.nextMonthDay:focus {
-    background: #714b4b;
-}
-
-flatpickr-day.flatpickr-disabled, .flatpickr-day.flatpickr-disabled:hover, .flatpickr-day.prevMonthDay, .flatpickr-day.nextMonthDay, .flatpickr-day.notAllowed, .flatpickr-day.notAllowed.prevMonthDay, .flatpickr-day.notAllowed.nextMonthDay {
-    color: rgba(155, 88, 88, 0.3);
-}
-
-.flatpickr-time input {
-   color:#fffbfb;
-}
-
-.flatpickr-time .flatpickr-time-separator, .flatpickr-time .flatpickr-am-pm {
-    color: #fff;
-}
-.flatpickr-time input:hover, .flatpickr-time .flatpickr-am-pm:hover, .flatpickr-time input:focus, .flatpickr-time .flatpickr-am-pm:focus {
-    background: #45a1ce;
-}
-
-/* ===[ BBDOWNLOADS START ]=== */
-.widget, .post {
-    box-shadow: none;
-}
-.post .details {
-    background: rgba(0, 0, 0, 0.9);
-    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.09)), to(transparent));
-    color: #ccc;
-}
-.widget .header.header-item {
-    background: rgba(40, 40, 40, 0.9) url(../../../../bbdownloads/styles/FLATBOOTS/theme/images/item-header-pattern.png) repeat scroll 0 0;
-}
-.container.with_sidebar .et_pb_column_sidebar {
-    background: rgba(38, 38, 38, 0.9);
-}
-.btn.btn-primary.changelog {
-    background: #a1d36e;
-}
-.btn.btn-primary.changelog:hover {
-    background: #94cd5a !important;
-}
-.btn.btn-secondary {
-    background: #6ad1dd !important;
-}
-.container-downloads .btn {
-    background: #777;
-}
-/* ===[ BBDOWNLOADS END ]=== */
-
-/* ===[ BBMEMBERSHIP START ]=== */
-.npt-format-1 .npt-item {
-    background: rgba(0, 0, 0, 0.9);
-}
-.npt-plan-name {
-    border-bottom: 0 none !important;
-}
-.npt-plan-bottom .avn-btn {
-    background: #181818 none repeat scroll 0 0;
-}
-.npt-plan-bottom .avn-btn:hover {
-    background: #3a3a3a none repeat scroll 0 0;
-}
-.thumbnail, .bg-group-info, .btn-primary {
-    background-color: #262626;
-}
-.btn-primary:hover {
-    background-color: #3a3a3a !important;
-}
-.text-muted {
-    color: #fff;
-}
-/* ===[ BBMEMBERSHIP END ]=== */
-
-/* ===[ BBCHAT START ]=== */
-.rooms li {
-    border-bottom: .6em dotted #777;
-}
-
-.person:before,
-.person:hover span {
-    background: #333;
-}
-
-.bbchat .left .people a:link,
-.bbchat .left .people a:hover,
-.bbchat .left .people a:visited {
-    color: #8c8c8c;
-}
-
-.bbchat,
-.bbchat .left,
-.bbchat .right {
-    background-color: #262626;
-    border-color: #999;
-}
-
-.delete-message:before, .layout-list .delete-message:before {
-    border: 3px dashed #181818;
-}
-
-.bbchat .right .top span .name,
-.me .bubble {
-    color: #fff;
-}
-
-.bbchat .right .top:after {
-    background: -webkit-linear-gradient(bottom,rgba(38,38,38,0) 10%,#262626 100%);
-    background: linear-gradient(to top,rgba(38,38,38,0) 10%,#262626 100%);
-}
-
-.bbchat .right .top,
-.me .bubble:before,
-.me .bubble,
-.write input,
-.ps:hover.ps--in-scrolling.ps--y>.ps__scrollbar-y-rail,
-.ps:hover>.ps__scrollbar-y-rail:hover {
-    background-color: #333 !important;
-}
-
-.bbchat .right .write:before {
-    background: -webkit-linear-gradient(top,rgba(38,38,38,0) 20%,#262626 100%);
-    background: linear-gradient(to bottom,rgba(38,38,38,0) 20%,#262626 100%);
-}
-
-.write {
-    background-color: #333;
-    border-color: #999;
-}
-
-.giphy>input {
-    border: 1px solid #999 !important;
-}
-
-#chatbox-input,
-.write input {
-    color: #8c8c8c;
-}
-
-.giphy,
-.emoji-picker {
-    background-color: #181818;
-}
-
-.bbchat-attachments-input {
-    background: #333;
-    box-shadow: 0 1px 15px 1px rgba(51,51,51,.12);
-}
-
-.bbchat-attachments-input>.button-upld {
-    background: #222 url(images/highlight_reallyfaint.png) repeat-x scroll 0 0;
-}
-
-.bbchat-attachments-input:hover>.button-upld {
-    background: #777;
-}
-/* ===[ BBCHAT END ]=== */
-
-/* ===[ CSS HOOK BOTTOM ]=== */
+body{background:#333 url(./images/bg.png) repeat repeat 100% 0}a:link{color:#fff}a:visited{color:#fafafa}a:hover{color:#fafafa}a.postlink-local:link{color:#FFBF00}a.postlink-local:visited{color:#bf8d20}a.postlink-local:hover{color:#daa520}#contentje h1,#contentje h2,#contentje h3,#contentje h4,#contentje h5,#contentje h6,#contentje h1 a,#contentje h2 a,#contentje h3 a,#contentje h4 a,#contentje h5 a,#contentje h6 a{color:#fff!important}.codebox{background-color:#444}code{background-color:#555}.codebox code{color:#fafafa}.content blockquote{background:#555}.btn-default.disabled,.btn-default[disabled],fieldset[disabled] .btn-default,.btn-default.disabled:hover,.btn-default[disabled]:hover,fieldset[disabled] .btn-default:hover,.btn-default.disabled:focus,.btn-default[disabled]:focus,fieldset[disabled] .btn-default:focus,.btn-default.disabled:active,.btn-default[disabled]:active,fieldset[disabled] .btn-default:active,.btn-default.disabled.active,.btn-default.active[disabled],fieldset[disabled] .btn-default.active{background-color:#999}#qr_postform .col-md-snappy{background:rgba(12,12,12,0.82) none repeat scroll 0 0}.prefix-popover{background-color:#555;border:2px solid #444}.prefix-popover:after{border-top:10px solid #444}.breadcrumb-buttons{background:#555;border-radius:0}.popup-box{background:#555}.profile-data h3{border-bottom:none!important}.navbar-inverse{border-color:#222}.navbar-nav-fancy > li > a:hover i{color:#fff}.flat-nav .navbar-nav > .open > a,.flat-nav .navbar-nav > .open > a:hover,.flat-nav .navbar-nav > .open > a:focus,.flat-nav .navbar-nav > .active > a,.flat-nav .navbar-nav > .active > a:hover,.flat-nav .navbar-nav > .active > a:focus{background-color:#888}.navbar-nav-fancy > li:before{background:#888}.blog-meta{background:#ffa800}.top-flat{background-color:#ffa800}.top-flat:hover{-webkit-transition:all .1s linear 0;transition:all .1s linear 0;color:#2d2d2d!important;border-bottom:none;background-color:#fff}.top-flat:hover:after{color:#2d2d2d}.section-pre-footer .thumb i{color:#ffa800}.side-segment > h3{color:#fff}.side-segment h3:after,.side-segment h2:after{background-color:#ffa800}a.forumtitle,a.topictitle,a.topictitleattribute{color:#ffa800}.mobile-post{background:#222;color:#cacaca}.btn-notification{background-color:#555}.notification-block img,.dropdown-avatar img,.profile-avatar img{border-color:#555}.list-group-item-info,a.list-group-item-info,.bg-info{background-color:#555}.square-icon{border:3px solid #444}.list-group-item-warning,a.list-group-item-warning,.bg-warning{background-color:#555}.bg-success,a.list-group-item-success,.list-group-item-success{background-color:#555}.bg-primary,.list-group-item-primary{background-color:#555}.box-placeholder{border:2px dashed #999;background:#555}.panel-default > .panel-heading{border-color:transparent;color:#fff}.postbody .content{color:#ccc}.well{background-color:#262626;border:3px solid #999}li .no_notifications{border-bottom:none!important}.form-actions{background:#444;border:2px solid #999}.nav-tabs{background:#333}.nav-tabs > li.active > a,.nav-tabs > li.active > a:focus,.nav-tabs > li.active > a:hover{background-color:#222;color:#ccc}.control-label{color:#ccc}.masthead:before{background-color:#222}.mastbottom{background-color:#222}.dropdown-menu{border:4px solid #999;background-color:#262626}.dropdown-menu > li > a:hover{background:#999;color:#fff}.dropdown-menu > li > a:hover i{color:#fff}.user-login .navbar-footer{background-color:#555}.user-login-drop > li:first-child{background-color:#555}.arrow-up:before{border-color:rgba(12,12,12,0) rgba(12,12,12,0) #999}.modal-header{border-bottom:1px solid #555}.modal-content{background-color:#444}.modal-footer{border-top:1px solid #555}.profile-data.modal-body h3{border-bottom:none!important}.mini-profile-contact li a.default-contact{background-color:#555}.avatar-over>.status:before{border:4px solid #555}.panel-login{background:#252525 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0}.panel-login .signin-text span{background:#252525}.panel-heading{border-color:#555}.panel-forum{background:rgba(12,12,12,0.9)}.panel-forum > .panel-heading{background:rgba(12,12,12,0) url(./images/bg-maintitle.png) repeat-x scroll 0 50%}.panel-default{border-color:#999}.panel{background:rgba(24,24,24,0.9)}.panel > .panel-heading{background:rgba(12,12,12,0) url(./images/bg-maintitle.png) repeat-x scroll 0 50%;background-size:cover}.panel-footer{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-moz-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent);border-top:1px solid #555}.form-control{background:#262626;color:#999}.tag-editor .placeholder,.tag-editor input{color:#999}.tag-editor input:focus{box-shadow:none}.control-bbtags .tag-editor{border:2px solid #444;background:#181818;color:#999}.tag-editor .tag-editor-tag{color:#8d9aa5;background:#444}.tag-editor .tag-editor-delete{background:#444}.tag-editor .tag-editor-delete i:before{color:#8d9aa5}.attachbox{background-color:#262626}.separator i{background:rgba(12,12,12,0.1) -moz-linear-gradient(center top,rgba(255,255,255,0.09) 0%,transparent 100%) repeat scroll 0 0}.pagination > li > a,.pagination > li > span{background:#222 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0}.pagination > li > a,.pagination > li > span:hover{background:#222 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0}.pagination > li > a,.pagination > li > span{border:2px solid #999}.pagination > .active > a,.pagination > .active > span,.pagination > .active > a:hover,.pagination > .active > span:hover,.pagination > .active > a:focus,.pagination > .active > span:focus{background-color:#555;border-color:#999;color:#999}.pagination > li > a:focus,.pagination > li > a:hover,.pagination > li > span:focus,.pagination > li > span:hover{background-color:#555;color:#999}.pager li > a,.pager li > span{background-color:#444;border:1px solid #333}.pager li > a:focus,.pager li > a:hover{background-color:#555;border:1px solid #444;color:#999}.separator:before{background:#999}.separator i{background:transparent}.btn-default{background:#252525 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0}.btn-default:hover,.btn-default:focus,.btn-default:active,.btn-default.active,.open .dropdown-toggle.btn-default{background:#252525 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0;border-color:#999}.dropdown-menu > li > a:focus,.dropdown-menu > li > a:hover{background-color:#777}.btn-default.active.focus,.btn-default.active:focus,.btn-default.active:hover,.btn-default.focus:active,.btn-default:active:focus,.btn-default:active:hover,.open > .dropdown-toggle.btn-default.focus,.open > .dropdown-toggle.btn-default:focus,.open > .dropdown-toggle.btn-default:hover{background-color:#777}.btn-default{color:#e0e0e0!important}.btn-default:hover{color:#fff!important}.ui-timeline .tl-item .tl-body .tl-content{background-color:#444}.ui-timeline .tl-item .tl-body .tl-content:after{border-color:rgba(12,12,12,0) #444 rgba(12,12,12,0) rgba(12,12,12,0)}.ui-timeline .tl-item.alt .tl-body .tl-content:after{border-color:rgba(12,12,12,0) rgba(12,12,12,0) rgba(12,12,12,0) #444}.ui-timeline .tl-item .tl-body .tl-time{color:#fff}.square-icon{box-shadow:none}.notification-content li{border-bottom:4px solid #999}.counter{text-shadow:none}.login-full .signin-text span{background:#262626}.login-full{background:#252525 url(./images/highlight_reallyfaint.png) repeat-x scroll 0 0;padding:20px}.breadcrumb-line{background:#262626}.breadcrumb{background:#262626}.breadcrumb li:first-child a{background:#262626}.panel-post .panel-bottom{background-color:#262626}.section-page{background:rgba(255,255,255,0.07);background-color:rgba(255,255,255,0.07);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09),transparent);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.icon-wrapper{background:rgba(255,255,255,0.1);background-color:rgba(255,255,255,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table-primary tbody tr:nth-child(2n+1) td,.table-primary tbody tr:nth-child(2n+1) th{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table{background:inherit}table .stats-col{background-color:rgba(0,0,0,0.1)!important;background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent))!important;background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%)!important;background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)!important}.table-primary tbody td{background:url(./images/highlight_reallyfaint.png);background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table-primary tbody tr:nth-child(2n+1) td,.table-primary tbody tr:nth-child(2n+1) th{background:url(./images/highlight_reallyfaint.png);background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table tr.active td,.table tr.active{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table > thead > tr > th{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table-hover > tbody > tr:hover > td,.table-hover > tbody > tr:hover > th{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent);color:#888}.table-striped > tbody > tr:nth-of-type(2n+1){background-color:inherit}.table-hover > tbody > tr:hover > td,.table-hover > tbody > tr:hover > th{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent);color:#888}.table-striped > tbody > tr:hover{background-color:rgba(0,0,0,0.1);background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(255,255,255,0.09)),to(transparent));background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.09) 0%,transparent 100%);background-image:linear-gradient(top,rgba(255,255,255,0.09),transparent)}.table > thead > tr > th,.table > tbody > tr > th,.table > tfoot > tr > th,.table > thead > tr > td,.table > tbody > tr > td,.table > tfoot > tr > td{border-top:4px solid rgba(255,255,255,0.09)}.form-control{border:2px solid #444}.form-control[disabled],.form-control[readonly],fieldset[disabled] .form-control{background-color:#363636}.panel-post h6,.panel-post h6 > a{color:#666!important}.alert-default{background-color:#222;border-color:#999;color:#555}.comment_starter{background:#555;color:#ccc}.comment-body{color:#ccc}.comment_reply{background:#444;border-top:1px solid #777}.comment footer{background-color:#555}.list-group-item{background:#444}a.list-group-item:focus,a.list-group-item:hover{background-color:#555;color:#999}.input-group-addon{background-color:#444;border:2px solid #444;color:#999}.nav-tabs > li > a:hover,.nav-tabs > li > a:focus{background-color:#555}.progress{background-color:#444}.thumbnail{background-color:#444;border:1px solid #999}.alert-default{background-color:#222;border:2px solid #999;color:#555}#darken{opacity:.7 -ms-filter : progid:DXImageTransform.Microsoft.Alpha(Opacity=70)}.close{color:#fff!important;text-shadow:0 1px 0 transparent}.phpbb_alert p{color:#fff}.bbtag,.bbtags-topic .bbtag{color:#888!important}.bbtag:before,.bbtag:after{background:#222}.bbtag:hover,.bbtags-topic .bbtag:hover{background-color:#ffa800}.bbtag:hover:after,.bbtags-topic .bbtag:hover:after{border-left-color:#ffa800}.bbtags-topic .bbtag:before,.bbtags-topic .bbtag:after{background:#333}.section-pre-footer{background:transparent}.section-pre-footer .section-bg{background:#292929}@media (max-width:767px){.container>.navbar-header{padding-bottom:5px}.section-pre-footer .section-bg{background:none repeat scroll 0 center transparent}}@media (max-width:468px){.section-pre-footer .section-bg{background:none repeat scroll 0 center transparent}}.section-pre-footer p,.twitter h3 a small,.copyrights,.debug-output{color:#888}.twitter h3 a small:hover{color:#ffa800}.section-pre-footer a:hover,.footer-nav a:hover,.debug-output a:hover{color:#ffa800}.burned-asphalt{background-color:transparent}.avatar-over img{border:4px solid #555}h3{border-bottom:4px solid #777!important}.popover{background-color:#333}.popover.right > .arrow::after{border-right-color:#444}.popover-title{background-color:#555}.badge_award h3{border-bottom:none}.footable.breakpoint > tbody > tr > td > span.footable-toggle{background:#222;color:#cacaca}.footable.breakpoint > tbody > tr.footable-row-detail{background:#222}.search-input-fullscreen{background-color:#333}.search-input-fullscreen input:focus{box-shadow:none}.label-huskygray{background-color:#333;float:left!important}.sidebar .panel{border-radius:6px 6px 2px 2px;background-color:none}#page-sidebar .panel-inverse > .panel-heading{background-color:#505b72}#page-sidebar .panel-info > .panel-heading{background-color:#5bc0de}#page-sidebar .panel-primary > .panel-heading{background-color:#337ab7}#page-sidebar .panel-success > .panel-heading{background-color:#2dcb73}#page-sidebar .panel-body{background-color:#222}.list-announcement .panel-body ul > li a{color:#fafafa}.list-announcement .panel-body ul > li small{color:#ccc}.user-list .media-body small.date,.list-announcement .media-body small.date{color:#ccc}.card .com-contain{background:rgba(12,12,12,0.7)}.com-stuff{background:rgba(12,12,12,0) -webkit-radial-gradient(center center ellipse,rgba(12,12,12,1) 0%,rgba(12,12,12,0) 100%)}.panel-bottom-messages{padding:15px}.spoiler .spoiler-header{background-color:#171717;color:#ccc;}.spoiler{background-color:#333;border-color:#333}.spoiler .spoiler-body{border-color:#333}.blg-widget-content{border: 1px solid #363636;background: #282828}.calendar.autofit tbody a{background-color:#181818}.calendar .month-title, .calendar .cal-header{color:#f5f5f5}.blg-accordion-icons .blg-accordion-header{background-color:#282828}pre{background-color: #555555;color:#f0f0f0}.spoiler-content .offtopic{margin:0!important;background:#333!important}.spoiler-content .offtopic_title{background:#333333!important;color:#8c8c8c!important}.spoiler-content .offtopic_text{color:#f0f0f0!important}.blog-summary{color:#FFF}.blog-summary .btn{margin-top:10px;background:#222222;border:1px solid #262626!important}.blog-details{background-color:#333}.blog-title a{color:#FFF!important}.blog-item{background:#333;border-radius:5px}.blog-quote .quote a{border-radius:0 0 10px 10px}.blog-quote .blog-metas{color:#ddd}.framed-ucp.topic-list{background:#181818}.textcomplete-item.active,.dropdown-menu>.active>a,.dropdown-menu>.active>a:focus,.dropdown-menu>.active>a:hover{background-color:#161616}.form-buttons{border:2px solid #999999;background:#1a1a1a}.panel-login .signin-text:before{background:#333}.blg-block .panel-login .signin-text span{background:#333;}.blg-linear-list.news-block li.double-space{border:1px solid #313131}.blg-linear-list.news-block li:first-child{border-top:4px solid #313131}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:0}.contributors-box .tag-editor{background:#262626;color:#999;border:2px solid #444}
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\nightstalker/styles/FLATBOOTS/theme/images/bg.png" "[FORUM_EXT]/sitesplat\\nightstalker/styles/FLATBOOTS/theme/images/bg.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\nightstalker/styles/FLATBOOTS/theme/images/bg.png" differ
```
