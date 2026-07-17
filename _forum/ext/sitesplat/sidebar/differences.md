Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\sidebar/adm/style/acp_ext_details.html" "[FORUM_EXT]/sitesplat\\sidebar/adm/style/acp_ext_details.html"
--- "[ORIGINAL]/sitesplat\\sidebar/adm/style/acp_ext_details.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/adm/style/acp_ext_details.html"
@@ -1,143 +1,143 @@
-<h3>{L_ACP_SIDEBAR_TITLE}</h3>
+<h3>{{ lang('ACP_SIDEBAR_TITLE') }}</h3>
   <div class="clearfix description-ext">
-	<h1 class="ExtensionName"><!-- IF META_DISPLAY_NAME -->{META_DISPLAY_NAME} - <!-- ENDIF -->{L_EXT_DETAILS}</h1>
-	<!-- IF S_VERSIONCHECK -->
-	<!-- ELSE IF S_VERSIONCHECK_STATUS == 0 -->
+	<h1 class="ExtensionName">{% if META_DISPLAY_NAME %}{{ META_DISPLAY_NAME }} - {% endif %}{{ lang('EXT_DETAILS') }}</h1>
+	{% if S_VERSIONCHECK %}
+	{% elseif S_VERSIONCHECK_STATUS == 0 %}
 	<div class="errorbox notice">
-		<p>{L_VERSIONCHECK_FAIL}</p>
-		<p>{VERSIONCHECK_FAIL_REASON}</p>
-		<p><a href="{U_VERSIONCHECK_FORCE}">{L_VERSIONCHECK_FORCE_UPDATE}</a></p>
+		<p>{{ lang('VERSIONCHECK_FAIL') }}</p>
+		<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
+		<p><a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
 	</div>
-	<!-- ELSE IF S_VERSIONCHECK_STATUS == 1 -->
+	{% elseif S_VERSIONCHECK_STATUS == 1 %}
 	<div class="errorbox notice">
-		<p>{VERSIONCHECK_FAIL_REASON}</p>
+		<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
 	</div>
-	<!-- ENDIF -->
+	{% endif %}
 	
-	<!-- IF S_VERSIONCHECK && not S_UP_TO_DATE -->
+	{% if S_VERSIONCHECK && not S_UP_TO_DATE %}
 	<div class="alert alert-update">
 	  
       <div class="row">	
       <div class="col-md-12">
 	   	
 	  <div class="col-md-6">	
-		<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
-		    <span class="description_name">{L_CURRENT_VERSION}{L_COLON}</span>
+		<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
+		    <span class="description_name">{{ lang('CURRENT_VERSION') }}{{ lang('COLON') }}</span>
 			<div class="extension_latest_version_wrapper">
-			<strong class="extension_latest_version label label-warning">{META_VERSION}</strong>
+			<strong class="extension_latest_version label label-warning">{{ META_VERSION }}</strong>
 			</div>
 	    </div>
 	  </div>
 	  
 	  <div class="col-md-6">	
-		<!-- BEGIN updates_available -->
-			<span class="requirements_title">{L_LATEST_VERSION}{L_COLON}</span>
+		{% for updates_available in loops.updates_available %}
+			<span class="requirements_title">{{ lang('LATEST_VERSION') }}{{ lang('COLON') }}</span>
 			<div class="extension_latest_version_wrapper">
-				<strong class="extension_latest_version label label-success">{updates_available.current}</strong>
-				<!-- IF updates_available.download-->
-				<a href="{updates_available.download}" class="extension_author_link" title="{L_DOWNLOAD_LATEST}"><i class="fa fa-download"></i></a>
-				<!-- ENDIF -->
-				<!-- IF updates_available.announcement -->
-				<a href="{updates_available.announcement}" class="extension_author_link" title="{L_ANNOUNCEMENT_TOPIC}"><i class="fa fa-bullhorn"></i></a>
-				<!-- ENDIF -->
+				<strong class="extension_latest_version label label-success">{{ updates_available.current }}</strong>
+				{% if updates_available.download%}
+				<a href="{{ updates_available.download }}" class="extension_author_link" title="{{ lang('DOWNLOAD_LATEST') }}"><i class="fa fa-download"></i></a>
+				{% endif %}
+				{% if updates_available.announcement %}
+				<a href="{{ updates_available.announcement }}" class="extension_author_link" title="{{ lang('ANNOUNCEMENT_TOPIC') }}"><i class="fa fa-bullhorn"></i></a>
+				{% endif %}
 			</div>
-		<!-- END updates_available -->
+		{% endfor %}
 	   </div>	
 	  
 	  </div>
      </div>	  
 		
 	</div>
-	<!-- ENDIF -->
+	{% endif %}
 
 	<div class="description_div">
 		<div>
 			<div>
 				<p class="description_list">
-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_DESCRIPTION_PAGE}</span><br />
-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_1}</span><br />
-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_2}</span><br />
-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_3}</span><br />
-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_4}</span><br />
-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_5}</span><br />
-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_6}</span><br />
+					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_DESCRIPTION_PAGE') }}</span><br />
+					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_1') }}</span><br />
+					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_2') }}</span><br />
+					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_3') }}</span><br />
+					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_4') }}</span><br />
+					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_5') }}</span><br />
+					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_6') }}</span><br />
 				</p>
 			</div>
 		</div>
 	</div>
 	<div class="description_bubble big_bubble">
-		<span class="description_name">{L_CLEAN_NAME}{L_COLON}</span>
-		<strong class="description_value" id="meta_name">{META_NAME}</strong>
+		<span class="description_name">{{ lang('CLEAN_NAME') }}{{ lang('COLON') }}</span>
+		<strong class="description_value" id="meta_name">{{ META_NAME }}</strong>
 	</div>
-	<!-- IF S_VERSIONCHECK && S_UP_TO_DATE -->
-	<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
-		<span class="description_name">{L_VERSION}{L_COLON}</span>
-		<span class="description_value description_value_ok" id="meta_version">{META_VERSION}</span>
+	{% if S_VERSIONCHECK && S_UP_TO_DATE %}
+	<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
+		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
+		<span class="description_value description_value_ok" id="meta_version">{{ META_VERSION }}</span>
 	</div>
-	<!-- ELSE IF S_VERSIONCHECK && not S_UP_TO_DATE -->
-	<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
-		<span class="description_name">{L_VERSION}{L_COLON}</span>
-		<span class="description_value description_value_old" id="meta_version">{META_VERSION}</span>
+	{% elseif S_VERSIONCHECK && not S_UP_TO_DATE %}
+	<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
+		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
+		<span class="description_value description_value_old" id="meta_version">{{ META_VERSION }}</span>
 	</div>
-	<!-- ELSE -->
+	{% else %}
 	<div class="description_bubble small_bubble">
-		<span class="description_name">{L_VERSION}{L_COLON}</span>
-		<span class="description_value" id="meta_version">{META_VERSION}</span>
+		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
+		<span class="description_value" id="meta_version">{{ META_VERSION }}</span>
 	</div>
-	<!-- ENDIF -->
-	<!-- IF META_HOMEPAGE -->
+	{% endif %}
+	{% if META_HOMEPAGE %}
 	<div class="description_bubble big_bubble">
-		<span class="description_name">{L_HOMEPAGE}{L_COLON}</span>
-		<strong class="description_value" id="meta_homepage"><a href="{META_HOMEPAGE}"><i class="fa fa-globe"></i> {META_HOMEPAGE}</a></strong>
+		<span class="description_name">{{ lang('HOMEPAGE') }}{{ lang('COLON') }}</span>
+		<strong class="description_value" id="meta_homepage"><a href="{{ META_HOMEPAGE }}"><i class="fa fa-globe"></i> {{ META_HOMEPAGE }}</a></strong>
 	</div>
-	<!-- ENDIF -->
-	<!-- IF META_TIME -->
+	{% endif %}
+	{% if META_TIME %}
 	<div class="description_bubble small_bubble">
-		<span class="description_name">{L_TIME}{L_COLON}</span>
-		<span class="description_value" id="meta_time">{META_TIME}</span>
+		<span class="description_name">{{ lang('TIME') }}{{ lang('COLON') }}</span>
+		<span class="description_value" id="meta_time">{{ META_TIME }}</span>
 	</div>
-	<!-- ENDIF -->
+	{% endif %}
 	<div class="description_bubble small_bubble">
-		<span class="description_name">{L_LICENSE}{L_COLON}</span>
-		<span class="description_value" id="meta_license" style="padding:0 15px;">{L_LICENSE_INFO}</span>
+		<span class="description_name">{{ lang('LICENSE') }}{{ lang('COLON') }}</span>
+		<span class="description_value" id="meta_license" style="padding:0 15px;">{{ lang('LICENSE_INFO') }}</span>
 	</div>
 
-	<!-- IF META_REQUIRE_PHPBB || META_REQUIRE_PHP -->
+	{% if META_REQUIRE_PHPBB || META_REQUIRE_PHP %}
 	<div>
-		<span class="requirements_title">{L_REQUIREMENTS}{L_COLON}</span>
-		<!-- IF META_REQUIRE_PHPBB -->
+		<span class="requirements_title">{{ lang('REQUIREMENTS') }}{{ lang('COLON') }}</span>
+		{% if META_REQUIRE_PHPBB %}
 		<div class="requirements_bubble">
-			<span class="requirements_name">{L_PHPBB_VERSION}{L_COLON}</span>
-			<span class="requirements_value<!-- IF META_REQUIRE_PHPBB_FAIL --> requirements_value_not_met<!-- ENDIF -->" id="require_phpbb">{META_REQUIRE_PHPBB}</span>
+			<span class="requirements_name">{{ lang('PHPBB_VERSION') }}{{ lang('COLON') }}</span>
+			<span class="requirements_value{% if META_REQUIRE_PHPBB_FAIL %} requirements_value_not_met{% endif %}" id="require_phpbb">{{ META_REQUIRE_PHPBB }}</span>
 		</div>
-		<!-- ENDIF -->
-		<!-- IF META_REQUIRE_PHP -->
+		{% endif %}
+		{% if META_REQUIRE_PHP %}
 		<div class="requirements_bubble">
-			<span class="requirements_name">{L_PHP_VERSION}{L_COLON}</span>
-			<span class="requirements_value<!-- IF META_REQUIRE_PHP_FAIL --> requirements_value_not_met<!-- ENDIF -->" id="require_php">{META_REQUIRE_PHP}</span>
+			<span class="requirements_name">{{ lang('PHP_VERSION') }}{{ lang('COLON') }}</span>
+			<span class="requirements_value{% if META_REQUIRE_PHP_FAIL %} requirements_value_not_met{% endif %}" id="require_php">{{ META_REQUIRE_PHP }}</span>
 		</div>
-		<!-- ENDIF -->
+		{% endif %}
 	</div>
-	<!-- ENDIF -->
+	{% endif %}
 
 	<div>
-		<span class="requirements_title">{L_EXTENSION_DEVELOPER}{L_COLON}</span>
-		<!-- BEGIN meta_authors -->
+		<span class="requirements_title">{{ lang('EXTENSION_DEVELOPER') }}{{ lang('COLON') }}</span>
+		{% for meta_authors in loops.meta_authors %}
 		<div class="extension_author">
-			<strong class="extension_author_name">{meta_authors.AUTHOR_NAME}</strong>
-			<!-- IF meta_authors.AUTHOR_EMAIL -->
-			<a href="mailto:{meta_authors.AUTHOR_EMAIL}" title="{L_AUTHOR_EMAIL}" class="extension_author_link"><i class="fa fa-envelope"></i></a>
-			<!-- ENDIF -->
-			<!-- IF meta_authors.AUTHOR_HOMEPAGE -->
-			<a href="{meta_authors.AUTHOR_HOMEPAGE}" title="{L_AUTHOR_HOMEPAGE}" class="extension_author_link"><i class="fa fa-globe"></i></a>
-			<!-- ENDIF -->
+			<strong class="extension_author_name">{{ meta_authors.AUTHOR_NAME }}</strong>
+			{% if meta_authors.AUTHOR_EMAIL %}
+			<a href="mailto:{{ meta_authors.AUTHOR_EMAIL }}" title="{{ lang('AUTHOR_EMAIL') }}" class="extension_author_link"><i class="fa fa-envelope"></i></a>
+			{% endif %}
+			{% if meta_authors.AUTHOR_HOMEPAGE %}
+			<a href="{{ meta_authors.AUTHOR_HOMEPAGE }}" title="{{ lang('AUTHOR_HOMEPAGE') }}" class="extension_author_link"><i class="fa fa-globe"></i></a>
+			{% endif %}
 		</div>
-		<!-- END meta_authors -->
+		{% endfor %}
 	</div>
 	
 	<div class="clearfix">
 	<br/>
-	<button type="button" class="btn md-close btn-block" data-dismiss="modal">{L_ACP_SIDEBAR_NOTICE_CLOSE}</button>
+	<button type="button" class="btn md-close btn-block" data-dismiss="modal">{{ lang('ACP_SIDEBAR_NOTICE_CLOSE') }}</button>
 	</div>
 	
 </div>
diff --git "[ORIGINAL]/sitesplat\\sidebar/adm/style/acp_sidebar.html" "[FORUM_EXT]/sitesplat\\sidebar/adm/style/acp_sidebar.html"
--- "[ORIGINAL]/sitesplat\\sidebar/adm/style/acp_sidebar.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/adm/style/acp_sidebar.html"
@@ -1,24 +1,24 @@
-<!-- IF S_ALLOW_CDN -->
-<!-- INCLUDECSS //maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css -->
-<!-- ELSE -->
-<!-- INCLUDECSS {ROOT_PATH}ext/sitesplat/sidebar/vendor/font-awesome/css/font-awesome.min.css -->
-<!-- ENDIF -->
-<!-- INCLUDECSS {ROOT_PATH}ext/sitesplat/sidebar/vendor/bootstrap/css/bootstrap_modified.css -->
-<!-- INCLUDECSS css/sidebar.css -->
-<!-- INCLUDECSS css/component.css -->
+{% if S_ALLOW_CDN %}
+{% INCLUDECSS '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' %}
+{% else %}
+{% INCLUDECSS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/font-awesome/css/font-awesome.min.css' %}
+{% endif %}
+{% INCLUDECSS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/bootstrap/css/bootstrap_modified.css' %}
+{% INCLUDECSS 'css/sidebar.css' %}
+{% INCLUDECSS 'css/component.css' %}
 
-<!-- INCLUDE overall_header.html -->
+{% INCLUDE 'overall_header.html' %}
 
-<h1>{L_ACP_SIDEBAR_TITLE} <a href="javascript:void(0)" class="md-trigger" data-remote="{U_ACTION}&amp;action=details" data-toggle="modal" data-target="#myModal"><span class="label label-success">{L_ACP_SIDEBAR_VERSION} <i class="fa fa-info-circle"></i></span></a></h1>
+<h1>{{ lang('ACP_SIDEBAR_TITLE') }} <a href="javascript:void(0)" class="md-trigger" data-remote="{{ U_ACTION }}&amp;action=details" data-toggle="modal" data-target="#myModal"><span class="label label-success">{{ lang('ACP_SIDEBAR_VERSION') }} <i class="fa fa-info-circle"></i></span></a></h1>
 
 		<!-- Modal -->
 		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 		  <div class="modal-dialog" role="document">
 			<div class="modal-content md-content">
-			  <h3><i class="icon-bbreact-emo-beer" style="margin-right:20px;"></i> {L_ACP_SIDEBAR_TITLE}</h3>
+			  <h3><i class="icon-bbreact-emo-beer" style="margin-right:20px;"></i> {{ lang('ACP_SIDEBAR_TITLE') }}</h3>
 			  <div class="modal-body">
 			   <div class="panel-body">
-				<div class="loader">{L_ACP_LOADING}</div>
+				<div class="loader">{{ lang('ACP_LOADING') }}</div>
 			   </div>
 			  <div class="modal-footer">
 			  </div>
@@ -28,37 +28,37 @@
 		</div>
 
 
-<p>{L_AD_SIDEBAR_EXPLAIN}</p>
+<p>{{ lang('AD_SIDEBAR_EXPLAIN') }}</p>
 
-<!-- IF S_NOTICE_LIKEDD or S_NOTICE_BBREACTION or S_NOTICE_BBDONATION or S_NOTICE_BBMEMBERSHIP or S_NOTICE_BADGE or S_NOTICE_BBPOINTS or S_NOTICE_NEWSLETTER -->
+{% if S_NOTICE_LIKEDD or S_NOTICE_BBREACTION or S_NOTICE_BBDONATION or S_NOTICE_BBMEMBERSHIP or S_NOTICE_BADGE or S_NOTICE_BBPOINTS or S_NOTICE_NEWSLETTER %}
 <div id="sidbar_notice" class="errorbox notice">
-	<a href="{U_BADGE_NOTICE_CLOSE}" data-ajax="close_notice" data-overlay="false" class="close clearfix" title="{L_ACP_SIDEBAR_NOTICE_CLOSE}"></a>
+	<a href="{{ U_BADGE_NOTICE_CLOSE }}" data-ajax="close_notice" data-overlay="false" class="close clearfix" title="{{ lang('ACP_SIDEBAR_NOTICE_CLOSE') }}"></a>
 	<p>
-	 <!-- IF S_NOTICE_LIKEDD -->{S_NOTICE_LIKEDD}<br /><!-- ENDIF -->
-	 <!-- IF S_NOTICE_BBREACTION -->{S_NOTICE_BBREACTION}<br /><!-- ENDIF -->
-	 <!-- IF S_NOTICE_BBDONATION -->{S_NOTICE_BBDONATION}<br /><!-- ENDIF -->
-	 <!-- IF S_NOTICE_BBMEMBERSHIP -->{S_NOTICE_BBMEMBERSHIP}<br /><!-- ENDIF -->
-	 <!-- IF S_NOTICE_BADGE -->{S_NOTICE_BADGE}<br /><!-- ENDIF -->
-	 <!-- IF S_NOTICE_BBPOINTS -->{S_NOTICE_BBPOINTS}<br /><!-- ENDIF -->
-	 <!-- IF S_NOTICE_NEWSLETTER -->{S_NOTICE_NEWSLETTER}<br /><!-- ENDIF -->
-	  <!-- IF S_NOTICE_BBDOWNLOAD -->{S_NOTICE_BBDOWNLOAD}<!-- ENDIF -->
+	 {% if S_NOTICE_LIKEDD %}{{ S_NOTICE_LIKEDD }}<br />{% endif %}
+	 {% if S_NOTICE_BBREACTION %}{{ S_NOTICE_BBREACTION }}<br />{% endif %}
+	 {% if S_NOTICE_BBDONATION %}{{ S_NOTICE_BBDONATION }}<br />{% endif %}
+	 {% if S_NOTICE_BBMEMBERSHIP %}{{ S_NOTICE_BBMEMBERSHIP }}<br />{% endif %}
+	 {% if S_NOTICE_BADGE %}{{ S_NOTICE_BADGE }}<br />{% endif %}
+	 {% if S_NOTICE_BBPOINTS %}{{ S_NOTICE_BBPOINTS }}<br />{% endif %}
+	 {% if S_NOTICE_NEWSLETTER %}{{ S_NOTICE_NEWSLETTER }}<br />{% endif %}
+	  {% if S_NOTICE_BBDOWNLOAD %}{{ S_NOTICE_BBDOWNLOAD }}{% endif %}
 	</p>
 </div>
-<!-- ENDIF -->
+{% endif %}
 
 
-<form id="acp_sidebar" method="post" action="{U_ACTION}">
+<form id="acp_sidebar" method="post" action="{{ U_ACTION }}">
 	<fieldset>
-		<legend>{L_ACP_SIDEBAR_OPTIONS}</legend>
+		<legend>{{ lang('ACP_SIDEBAR_OPTIONS') }}</legend>
 		<div class="sidebar-wrapper">
 		<style>
 			#sidebar-nav {
-				width:<!-- IF SIDEBAR_WIDTH -->50<!-- ELSE -->30<!-- ENDIF -->px;
-				float:<!-- IF SIDEBAR_TYPE -->right<!-- ELSE -->left<!-- ENDIF -->;
+				width:{% if SIDEBAR_WIDTH %}50{% else %}30{% endif %}px;
+				float:{% if SIDEBAR_TYPE %}right{% else %}left{% endif %};
 			}
 			#sidebar-section {
-				width:<!-- IF SIDEBAR_WIDTH -->200<!-- ELSE -->220<!-- ENDIF -->px;
-				float:<!-- IF SIDEBAR_TYPE -->left<!-- ELSE -->right<!-- ENDIF -->;
+				width:{% if SIDEBAR_WIDTH %}200{% else %}220{% endif %}px;
+				float:{% if SIDEBAR_TYPE %}left{% else %}right{% endif %};
 			}
 			</style> 
 			<div class="browser-window">
@@ -70,7 +70,7 @@
 			  </div>
 			  <div class="dev-tools">
 			  <div class="bar">
-				<div class="dev-bar-content">{L_SITESPLAT_COM}</div>
+				<div class="dev-bar-content">{{ lang('SITESPLAT_COM') }}</div>
 				<div class="close-x">X</div>
 				<div class="clear"></div>
 			  </div>
@@ -79,19 +79,19 @@
 			<div class="content">
 			
 			<div class="inner-browser">
-			<div id="sidebar-header">{L_FLATBOOTS}</div>
+			<div id="sidebar-header">{{ lang('FLATBOOTS') }}</div>
 			
-			<div id="sidebar-nav">{L_ONE_S}<br />{L_ONE_I}<br />{L_ONE_D}<br />{L_ONE_E}<br />{L_ONE_B}<br />{L_ONE_A}<br />{L_ONE_R}</div>
+			<div id="sidebar-nav">{{ lang('ONE_S') }}<br />{{ lang('ONE_I') }}<br />{{ lang('ONE_D') }}<br />{{ lang('ONE_E') }}<br />{{ lang('ONE_B') }}<br />{{ lang('ONE_A') }}<br />{{ lang('ONE_R') }}</div>
 			
 			<div id="sidebar-section">
 			<p class="forum-wrapper">
-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
+			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
+			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
+			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
 			</p>
 			</div>
 			
-			<div id="sidebar-footer">{L_SITESPLAT_COPY}</div>
+			<div id="sidebar-footer">{{ lang('SITESPLAT_COPY') }}</div>
 			</div>
 			
 			</div>
@@ -102,11 +102,11 @@
 
 		<div style="float:left;width:80%;">
 		<dl>
-			<dt><label id="type" for="sidebartype">{L_ACP_SIDEBAR_TYPE}{L_COLON}</label><br /> {L_ACP_SIDEBAR_TYPE_EXPLAIN}</dt>
+			<dt><label id="type" for="sidebartype">{{ lang('ACP_SIDEBAR_TYPE') }}{{ lang('COLON') }}</label><br /> {{ lang('ACP_SIDEBAR_TYPE_EXPLAIN') }}</dt>
 			<dd>
 
 				    <div class="onoffswitch">
-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebartype" name="type"{SIDEBAR_TYPE}>
+						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebartype" name="type"{{ SIDEBAR_TYPE }}>
 						<label class="onoffswitch-label" for="sidebartype">
 							<span class="onoffswitch-inner onoffswitch-inner-position"></span>
 							<span class="onoffswitch-switch"></span>
@@ -116,11 +116,11 @@
 			</dd>
 		</dl>
 		<dl>
-			<dt><label for="width_s">{L_ACP_SIDEBAR_WIDTH}</label><br />{L_ACP_SIDEBAR_WIDTH_EXPLAIN}</dt>
+			<dt><label for="width_s">{{ lang('ACP_SIDEBAR_WIDTH') }}</label><br />{{ lang('ACP_SIDEBAR_WIDTH_EXPLAIN') }}</dt>
 			<dd>
 				
 				 <div class="onoffswitch">
-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="width_s" name="width"{SIDEBAR_WIDTH}>
+						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="width_s" name="width"{{ SIDEBAR_WIDTH }}>
 						<label class="onoffswitch-label" for="width_s">
 							<span class="onoffswitch-inner onoffswitch-inner-width"></span>
 							<span class="onoffswitch-switch"></span>
@@ -131,11 +131,11 @@
 		</dl>
 		
 		<dl>
-			<dt><label for="height">{L_ACP_SIDEBAR_HEIGHT}</label><br />{L_ACP_SIDEBAR_HEIGHT_EXPLAIN}</dt>
+			<dt><label for="height">{{ lang('ACP_SIDEBAR_HEIGHT') }}</label><br />{{ lang('ACP_SIDEBAR_HEIGHT_EXPLAIN') }}</dt>
 			<dd>
 					
 				<div class="onoffswitch">
-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="height" name="height"{SIDEBAR_HEIGHT}>
+						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="height" name="height"{{ SIDEBAR_HEIGHT }}>
 						<label class="onoffswitch-label" for="height">
 							<span class="onoffswitch-inner"></span>
 							<span class="onoffswitch-switch"></span>
@@ -147,11 +147,11 @@
 		
 		
 		<dl>
-			<dt><label for="all_pages">{L_ACP_SIDEBAR_ALL_PAGES}</label><br />{L_ACP_SIDEBAR_ALL_PAGES_EXPLAIN}</dt>
+			<dt><label for="all_pages">{{ lang('ACP_SIDEBAR_ALL_PAGES') }}</label><br />{{ lang('ACP_SIDEBAR_ALL_PAGES_EXPLAIN') }}</dt>
 			<dd>
 
 				<div class="onoffswitch">
-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="all_pages" name="all_pages"{SIDEBAR_ALL_PAGES}>
+						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="all_pages" name="all_pages"{{ SIDEBAR_ALL_PAGES }}>
 						<label class="onoffswitch-label" for="all_pages">
 							<span class="onoffswitch-inner"></span>
 							<span class="onoffswitch-switch"></span>
@@ -162,10 +162,10 @@
 		</dl>
 		
 		<dl>
-		<dt><label for="all_pages">{L_ACP_SIDEBAR_PANEL_PAGES}</label><br />{L_ACP_SIDEBAR_PANEL_PAGES_EXPLAIN}</dt>
+		<dt><label for="all_pages">{{ lang('ACP_SIDEBAR_PANEL_PAGES') }}</label><br />{{ lang('ACP_SIDEBAR_PANEL_PAGES_EXPLAIN') }}</dt>
 			<dd>
 				<div class="onoffswitch">
-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="panel_pages" name="panel_pages"{SIDEBAR_PANEL_PAGES}>
+						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="panel_pages" name="panel_pages"{{ SIDEBAR_PANEL_PAGES }}>
 						<label class="onoffswitch-label" for="panel_pages">
 							<span class="onoffswitch-inner"></span>
 							<span class="onoffswitch-switch"></span>
@@ -176,11 +176,11 @@
 			</dl>
 		
 		<dl>
-			<dt><label for="shuffle">{L_ACP_SIDEBAR_SHUFFLE}</label><br />{L_ACP_SIDEBAR_SHUFFLE_EXPLAIN}</dt>
+			<dt><label for="shuffle">{{ lang('ACP_SIDEBAR_SHUFFLE') }}</label><br />{{ lang('ACP_SIDEBAR_SHUFFLE_EXPLAIN') }}</dt>
 			<dd>
 
 				<div class="onoffswitch">
-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="shuffle" name="shuffle"{SIDEBAR_SHUFFLE}>
+						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="shuffle" name="shuffle"{{ SIDEBAR_SHUFFLE }}>
 						<label class="onoffswitch-label" for="shuffle">
 							<span class="onoffswitch-inner"></span>
 							<span class="onoffswitch-switch"></span>
@@ -190,16 +190,16 @@
 			</dd>
 		</dl>
 		<dl>
-			<dt><label for="slots">{L_ACP_SIDEBAR_SLOTS}</label><br />{L_ACP_SIDEBAR_SLOTS_EXPLAIN}</dt>
+			<dt><label for="slots">{{ lang('ACP_SIDEBAR_SLOTS') }}</label><br />{{ lang('ACP_SIDEBAR_SLOTS_EXPLAIN') }}</dt>
 			<dd>
-			 <input type="range" name="slots" id="slots" min="1" max="10" step="1" value="{SLOTS}" oninput="rangevalue1.value=value" />
+			 <input type="range" name="slots" id="slots" min="1" max="10" step="1" value="{{ SLOTS }}" oninput="rangevalue1.value=value" />
              <output id="rangevalue1"></output>
 			</dd>
 		</dl>
 		<dl>
-			<dt><label id="how_many" for="how_many">{L_HOWMANY}</label><br />{L_HOWMANY_EXPLAIN}</dt>
+			<dt><label id="how_many" for="how_many">{{ lang('HOWMANY') }}</label><br />{{ lang('HOWMANY_EXPLAIN') }}</dt>
 			<dd>
-			 <input type="range" name="how_many" id="how_many" min="1" max="10" step="1" value="{HOWMANY}" oninput="rangevalue.value=value" />
+			 <input type="range" name="how_many" id="how_many" min="1" max="10" step="1" value="{{ HOWMANY }}" oninput="rangevalue.value=value" />
              <output id="rangevalue"></output>
 			</dd>
 		</dl>
@@ -210,11 +210,11 @@
 		
 		<dl style="clear:both;">
 			<dt style="width:36%;">
-			<label id="ignore" for="ignore_inactive_users ignore_founder show_admins_mods">{L_IGNORE}</label><br />{L_IGNORE_EXPLAIN}</dt>
+			<label id="ignore" for="ignore_inactive_users ignore_founder show_admins_mods">{{ lang('IGNORE') }}</label><br />{{ lang('IGNORE_EXPLAIN') }}</dt>
 			<dd style="margin-left:36%;">
-			<div class="label-entry">{L_IGNORE_USERS}</div>
-			<div class="label-entry">{L_IGNORE_FOUNDER}</div>
-			<div class="label-entry">{L_IGNORE_ADMINS_MODS}</div>
+			<div class="label-entry">{{ lang('IGNORE_USERS') }}</div>
+			<div class="label-entry">{{ lang('IGNORE_FOUNDER') }}</div>
+			<div class="label-entry">{{ lang('IGNORE_ADMINS_MODS') }}</div>
 			</dd>
 			
 			<dd style="margin-left:36%;">
@@ -222,7 +222,7 @@
 				<div class="label-wrap">
 
 				 <div class="onoffswitch">
-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_inactive_users" name="ignore_inactive_users"{IGNORE_INACTIVE}>
+						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_inactive_users" name="ignore_inactive_users"{{ IGNORE_INACTIVE }}>
 						<label class="onoffswitch-label" for="ignore_inactive_users">
 							<span class="onoffswitch-inner"></span>
 							<span class="onoffswitch-switch"></span>
@@ -234,7 +234,7 @@
 				<div class="label-wrap">
 
 				    <div class="onoffswitch">
-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_founder" name="ignore_founder"{IGNORE_FOUNDER}>
+						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_founder" name="ignore_founder"{{ IGNORE_FOUNDER }}>
 						<label class="onoffswitch-label" for="ignore_founder">
 							<span class="onoffswitch-inner"></span>
 							<span class="onoffswitch-switch"></span>
@@ -247,7 +247,7 @@
 				
 				
 				    <div class="onoffswitch">
-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_admins_mods" name="ignore_admins_mods"{IGNORE_ADMINS_MODS}>
+						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_admins_mods" name="ignore_admins_mods"{{ IGNORE_ADMINS_MODS }}>
 						<label class="onoffswitch-label" for="ignore_admins_mods">
 							<span class="onoffswitch-inner"></span>
 							<span class="onoffswitch-switch"></span>
@@ -263,34 +263,34 @@
 
 	
 	<fieldset class="dtdd-fix">
-		<legend>{L_ACP_SIDEBAR_HEADSUP}{L_COLON}</legend>
-		<p>{L_ACP_SIDEBAR_HEADSIP_EXPLAIN}</p>
+		<legend>{{ lang('ACP_SIDEBAR_HEADSUP') }}{{ lang('COLON') }}</legend>
+		<p>{{ lang('ACP_SIDEBAR_HEADSIP_EXPLAIN') }}</p>
 	</fieldset>	
 	
 	<fieldset class="dtdd-fix">
-		<legend>{L_ACP_SIDEBAR_SETTINGS}{L_COLON}</legend>
+		<legend>{{ lang('ACP_SIDEBAR_SETTINGS') }}{{ lang('COLON') }}</legend>
 		<script>
-		var rule_type = [{OPTION_ARY}];
+		var rule_type = [{{ OPTION_ARY }}];
 		</script>
 		<dl>
 			<dt style="width:36%;"></dt>
 			<dd style="margin-left:36%;">
-				<span style="width:120px;display:inline-block;">{L_SHOW_TYPE}{L_COLON}</span>
-				<span style="width:150px;display:inline-block;">{L_SHOW_MOBILE}{L_COLON}</span>
-				<span style="width:150px;display:inline-block;">{L_SHOW_TABLET}{L_COLON}</span>
+				<span style="width:120px;display:inline-block;">{{ lang('SHOW_TYPE') }}{{ lang('COLON') }}</span>
+				<span style="width:150px;display:inline-block;">{{ lang('SHOW_MOBILE') }}{{ lang('COLON') }}</span>
+				<span style="width:150px;display:inline-block;">{{ lang('SHOW_TABLET') }}{{ lang('COLON') }}</span>
 			</dd>
 		</dl>
-		<!-- BEGIN slots -->
+		{% for slots in loops.slots %}
 		<dl>
-			<dt style="width:36%;"><label id="sidebar_slot{slots.ID}_active" for="sidebar_slot{slots.ID}_active">{L_ACP_SIDEBAR_SLOT} {slots.ID}</label></dt>
+			<dt style="width:36%;"><label id="sidebar_slot{{ slots.ID }}_active" for="sidebar_slot{{ slots.ID }}_active">{{ lang('ACP_SIDEBAR_SLOT') }} {{ slots.ID }}</label></dt>
 			<dd style="margin-left:36%;">
-				<select style="float:left;" name="sidebar[slot{slots.ID}][_active]]" id="sidebar_slot{slots.ID}_active">{slots.ACTIVE_SLOT}</select>
+				<select style="float:left;" name="sidebar[slot{{ slots.ID }}][_active]]" id="sidebar_slot{{ slots.ID }}_active">{{ slots.ACTIVE_SLOT }}</select>
 			
 			<div style="display:inline-block; margin-left:20px;">
-				<div id="show_mobile{slots.ID}" style="display:{slots.OPTION_SLOT};">
+				<div id="show_mobile{{ slots.ID }}" style="display:{{ slots.OPTION_SLOT }};">
 					<div class="onoffswitch">
-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{slots.ID}_show_mobile" name="options[slot{slots.ID}][_mobile]]"{slots.SHOW_MOBILE}>
-						<label class="onoffswitch-label" for="sidebar_slot{slots.ID}_show_mobile">
+						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{{ slots.ID }}_show_mobile" name="options[slot{{ slots.ID }}][_mobile]]"{{ slots.SHOW_MOBILE }}>
+						<label class="onoffswitch-label" for="sidebar_slot{{ slots.ID }}_show_mobile">
 							<span class="onoffswitch-inner onoffswitch-inner-yn"></span>
 							<span class="onoffswitch-switch"></span>
 						</label>
@@ -299,10 +299,10 @@
 			</div>
 			
 			<div style="display:inline-block; margin-left:20px;">
-				<div id="show_tablet{slots.ID}" style="display:{slots.OPTION_SLOT};">
+				<div id="show_tablet{{ slots.ID }}" style="display:{{ slots.OPTION_SLOT }};">
 				<div class="onoffswitch">
-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{slots.ID}_show_tablet" name="options[slot{slots.ID}][_tablet]]"{slots.SHOW_TABLET}>
-						<label class="onoffswitch-label" for="sidebar_slot{slots.ID}_show_tablet">
+						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{{ slots.ID }}_show_tablet" name="options[slot{{ slots.ID }}][_tablet]]"{{ slots.SHOW_TABLET }}>
+						<label class="onoffswitch-label" for="sidebar_slot{{ slots.ID }}_show_tablet">
 							<span class="onoffswitch-inner onoffswitch-inner-yn"></span>
 							<span class="onoffswitch-switch"></span>
 						</label>
@@ -312,29 +312,29 @@
 				
 			</dd>
 		</dl>
-		<div id="sidebar_slot{slots.ID}" style="display:{slots.VISIBILTY_SLOT};">
+		<div id="sidebar_slot{{ slots.ID }}" style="display:{{ slots.VISIBILTY_SLOT }};">
 		<dl>
-			<dt style="width:36%;"><label for="sidebar_slot{slots.ID}_title">{L_ACP_TITLE_SLOT} {slots.ID}</label><br />{L_ACP_TITLE_SLOT_EXPLAIN}</dt>
+			<dt style="width:36%;"><label for="sidebar_slot{{ slots.ID }}_title">{{ lang('ACP_TITLE_SLOT') }} {{ slots.ID }}</label><br />{{ lang('ACP_TITLE_SLOT_EXPLAIN') }}</dt>
 			<dd style="margin-left:36%;">
-				<input type="text" name="sidebar[slot{slots.ID}][_title]]" value="{slots.SIDEBAR_TITLE}" size="50" />
+				<input type="text" name="sidebar[slot{{ slots.ID }}][_title]]" value="{{ slots.SIDEBAR_TITLE }}" size="50" />
 			</dd>
 		</dl>
 		<dl>
-			<dt style="width:36%;"><label for="sidebar_slot{slots.ID}_text">{L_ACP_SIDEBAR_TEXT}{L_COLON}</label><br />{L_ACP_SIDEBAR_TEXT_EXPLAIN}</dt>
-			<dd style="margin-left:36%;"><textarea name="sidebar[slot{slots.ID}][_text]]" rows="3" cols="40">{slots.SIDEBAR_TEXT}</textarea></dd>
+			<dt style="width:36%;"><label for="sidebar_slot{{ slots.ID }}_text">{{ lang('ACP_SIDEBAR_TEXT') }}{{ lang('COLON') }}</label><br />{{ lang('ACP_SIDEBAR_TEXT_EXPLAIN') }}</dt>
+			<dd style="margin-left:36%;"><textarea name="sidebar[slot{{ slots.ID }}][_text]]" rows="3" cols="40">{{ slots.SIDEBAR_TEXT }}</textarea></dd>
 		</dl>
 		</div>
 		<hr />
-		<!-- END slots -->
+		{% endfor %}
 		<p class="submit-buttons">
-			<input class="button1" type="submit" name="update" value="{L_SUBMIT}" />&nbsp;
-			<input class="button2" type="reset" id="reset" name="reset" value="{L_RESET}" />
-			{S_FORM_TOKEN}
+			<input class="button1" type="submit" name="update" value="{{ lang('SUBMIT') }}" />&nbsp;
+			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+			{{ S_FORM_TOKEN }}
 		</p>
 	</fieldset>
 </form>
 
-<!-- INCLUDEJS js/sidebar.js -->
-<!-- INCLUDEJS {ROOT_PATH}ext/sitesplat/sidebar/vendor/bootstrap/js/bootstrap.min.js -->
+{% INCLUDEJS 'js/sidebar.js' %}
+{% INCLUDEJS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/bootstrap/js/bootstrap.min.js' %}
 <div class="md-overlay"></div><!-- the overlay element -->
-<!-- INCLUDE overall_footer.html -->
+{% INCLUDE 'overall_footer.html' %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/config/services.yml" "[FORUM_EXT]/sitesplat\\sidebar/config/services.yml"
--- "[ORIGINAL]/sitesplat\\sidebar/config/services.yml"
+++ "[FORUM_EXT]/sitesplat\\sidebar/config/services.yml"
@@ -60,5 +60,6 @@ services:
             - '@config'
             - '%core.root_path%'
             - '%core.php_ext%'
+            - '@ext.manager'
         tags:
             - { name: event.listener }
diff --git "[FORUM_EXT]/sitesplat\\sidebar/diff_full.tmp" "[FORUM_EXT]/sitesplat\\sidebar/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\sidebar/diff_full.tmp"
@@ -0,0 +1,3070 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
+index 81c13f5b4..3a96f4580 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
+@@ -1,143 +1,143 @@
+-<h3>{L_ACP_SIDEBAR_TITLE}</h3>
++<h3>{{ lang('ACP_SIDEBAR_TITLE') }}</h3>
+   <div class="clearfix description-ext">
+-	<h1 class="ExtensionName"><!-- IF META_DISPLAY_NAME -->{META_DISPLAY_NAME} - <!-- ENDIF -->{L_EXT_DETAILS}</h1>
+-	<!-- IF S_VERSIONCHECK -->
+-	<!-- ELSE IF S_VERSIONCHECK_STATUS == 0 -->
++	<h1 class="ExtensionName">{% if META_DISPLAY_NAME %}{{ META_DISPLAY_NAME }} - {% endif %}{{ lang('EXT_DETAILS') }}</h1>
++	{% if S_VERSIONCHECK %}
++	{% elseif S_VERSIONCHECK_STATUS == 0 %}
+ 	<div class="errorbox notice">
+-		<p>{L_VERSIONCHECK_FAIL}</p>
+-		<p>{VERSIONCHECK_FAIL_REASON}</p>
+-		<p><a href="{U_VERSIONCHECK_FORCE}">{L_VERSIONCHECK_FORCE_UPDATE}</a></p>
++		<p>{{ lang('VERSIONCHECK_FAIL') }}</p>
++		<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
++		<p><a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
+ 	</div>
+-	<!-- ELSE IF S_VERSIONCHECK_STATUS == 1 -->
++	{% elseif S_VERSIONCHECK_STATUS == 1 %}
+ 	<div class="errorbox notice">
+-		<p>{VERSIONCHECK_FAIL_REASON}</p>
++		<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
+ 	</div>
+-	<!-- ENDIF -->
++	{% endif %}
+ 	
+-	<!-- IF S_VERSIONCHECK && not S_UP_TO_DATE -->
++	{% if S_VERSIONCHECK && not S_UP_TO_DATE %}
+ 	<div class="alert alert-update">
+ 	  
+       <div class="row">	
+       <div class="col-md-12">
+ 	   	
+ 	  <div class="col-md-6">	
+-		<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
+-		    <span class="description_name">{L_CURRENT_VERSION}{L_COLON}</span>
++		<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
++		    <span class="description_name">{{ lang('CURRENT_VERSION') }}{{ lang('COLON') }}</span>
+ 			<div class="extension_latest_version_wrapper">
+-			<strong class="extension_latest_version label label-warning">{META_VERSION}</strong>
++			<strong class="extension_latest_version label label-warning">{{ META_VERSION }}</strong>
+ 			</div>
+ 	    </div>
+ 	  </div>
+ 	  
+ 	  <div class="col-md-6">	
+-		<!-- BEGIN updates_available -->
+-			<span class="requirements_title">{L_LATEST_VERSION}{L_COLON}</span>
++		{% for updates_available in loops.updates_available %}
++			<span class="requirements_title">{{ lang('LATEST_VERSION') }}{{ lang('COLON') }}</span>
+ 			<div class="extension_latest_version_wrapper">
+-				<strong class="extension_latest_version label label-success">{updates_available.current}</strong>
+-				<!-- IF updates_available.download-->
+-				<a href="{updates_available.download}" class="extension_author_link" title="{L_DOWNLOAD_LATEST}"><i class="fa fa-download"></i></a>
+-				<!-- ENDIF -->
+-				<!-- IF updates_available.announcement -->
+-				<a href="{updates_available.announcement}" class="extension_author_link" title="{L_ANNOUNCEMENT_TOPIC}"><i class="fa fa-bullhorn"></i></a>
+-				<!-- ENDIF -->
++				<strong class="extension_latest_version label label-success">{{ updates_available.current }}</strong>
++				{% if updates_available.download%}
++				<a href="{{ updates_available.download }}" class="extension_author_link" title="{{ lang('DOWNLOAD_LATEST') }}"><i class="fa fa-download"></i></a>
++				{% endif %}
++				{% if updates_available.announcement %}
++				<a href="{{ updates_available.announcement }}" class="extension_author_link" title="{{ lang('ANNOUNCEMENT_TOPIC') }}"><i class="fa fa-bullhorn"></i></a>
++				{% endif %}
+ 			</div>
+-		<!-- END updates_available -->
++		{% endfor %}
+ 	   </div>	
+ 	  
+ 	  </div>
+      </div>	  
+ 		
+ 	</div>
+-	<!-- ENDIF -->
++	{% endif %}
+ 
+ 	<div class="description_div">
+ 		<div>
+ 			<div>
+ 				<p class="description_list">
+-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_DESCRIPTION_PAGE}</span><br />
+-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_1}</span><br />
+-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_2}</span><br />
+-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_3}</span><br />
+-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_4}</span><br />
+-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_5}</span><br />
+-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_6}</span><br />
++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_DESCRIPTION_PAGE') }}</span><br />
++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_1') }}</span><br />
++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_2') }}</span><br />
++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_3') }}</span><br />
++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_4') }}</span><br />
++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_5') }}</span><br />
++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_6') }}</span><br />
+ 				</p>
+ 			</div>
+ 		</div>
+ 	</div>
+ 	<div class="description_bubble big_bubble">
+-		<span class="description_name">{L_CLEAN_NAME}{L_COLON}</span>
+-		<strong class="description_value" id="meta_name">{META_NAME}</strong>
++		<span class="description_name">{{ lang('CLEAN_NAME') }}{{ lang('COLON') }}</span>
++		<strong class="description_value" id="meta_name">{{ META_NAME }}</strong>
+ 	</div>
+-	<!-- IF S_VERSIONCHECK && S_UP_TO_DATE -->
+-	<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
+-		<span class="description_name">{L_VERSION}{L_COLON}</span>
+-		<span class="description_value description_value_ok" id="meta_version">{META_VERSION}</span>
++	{% if S_VERSIONCHECK && S_UP_TO_DATE %}
++	<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
++		<span class="description_value description_value_ok" id="meta_version">{{ META_VERSION }}</span>
+ 	</div>
+-	<!-- ELSE IF S_VERSIONCHECK && not S_UP_TO_DATE -->
+-	<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
+-		<span class="description_name">{L_VERSION}{L_COLON}</span>
+-		<span class="description_value description_value_old" id="meta_version">{META_VERSION}</span>
++	{% elseif S_VERSIONCHECK && not S_UP_TO_DATE %}
++	<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
++		<span class="description_value description_value_old" id="meta_version">{{ META_VERSION }}</span>
+ 	</div>
+-	<!-- ELSE -->
++	{% else %}
+ 	<div class="description_bubble small_bubble">
+-		<span class="description_name">{L_VERSION}{L_COLON}</span>
+-		<span class="description_value" id="meta_version">{META_VERSION}</span>
++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
++		<span class="description_value" id="meta_version">{{ META_VERSION }}</span>
+ 	</div>
+-	<!-- ENDIF -->
+-	<!-- IF META_HOMEPAGE -->
++	{% endif %}
++	{% if META_HOMEPAGE %}
+ 	<div class="description_bubble big_bubble">
+-		<span class="description_name">{L_HOMEPAGE}{L_COLON}</span>
+-		<strong class="description_value" id="meta_homepage"><a href="{META_HOMEPAGE}"><i class="fa fa-globe"></i> {META_HOMEPAGE}</a></strong>
++		<span class="description_name">{{ lang('HOMEPAGE') }}{{ lang('COLON') }}</span>
++		<strong class="description_value" id="meta_homepage"><a href="{{ META_HOMEPAGE }}"><i class="fa fa-globe"></i> {{ META_HOMEPAGE }}</a></strong>
+ 	</div>
+-	<!-- ENDIF -->
+-	<!-- IF META_TIME -->
++	{% endif %}
++	{% if META_TIME %}
+ 	<div class="description_bubble small_bubble">
+-		<span class="description_name">{L_TIME}{L_COLON}</span>
+-		<span class="description_value" id="meta_time">{META_TIME}</span>
++		<span class="description_name">{{ lang('TIME') }}{{ lang('COLON') }}</span>
++		<span class="description_value" id="meta_time">{{ META_TIME }}</span>
+ 	</div>
+-	<!-- ENDIF -->
++	{% endif %}
+ 	<div class="description_bubble small_bubble">
+-		<span class="description_name">{L_LICENSE}{L_COLON}</span>
+-		<span class="description_value" id="meta_license" style="padding:0 15px;">{L_LICENSE_INFO}</span>
++		<span class="description_name">{{ lang('LICENSE') }}{{ lang('COLON') }}</span>
++		<span class="description_value" id="meta_license" style="padding:0 15px;">{{ lang('LICENSE_INFO') }}</span>
+ 	</div>
+ 
+-	<!-- IF META_REQUIRE_PHPBB || META_REQUIRE_PHP -->
++	{% if META_REQUIRE_PHPBB || META_REQUIRE_PHP %}
+ 	<div>
+-		<span class="requirements_title">{L_REQUIREMENTS}{L_COLON}</span>
+-		<!-- IF META_REQUIRE_PHPBB -->
++		<span class="requirements_title">{{ lang('REQUIREMENTS') }}{{ lang('COLON') }}</span>
++		{% if META_REQUIRE_PHPBB %}
+ 		<div class="requirements_bubble">
+-			<span class="requirements_name">{L_PHPBB_VERSION}{L_COLON}</span>
+-			<span class="requirements_value<!-- IF META_REQUIRE_PHPBB_FAIL --> requirements_value_not_met<!-- ENDIF -->" id="require_phpbb">{META_REQUIRE_PHPBB}</span>
++			<span class="requirements_name">{{ lang('PHPBB_VERSION') }}{{ lang('COLON') }}</span>
++			<span class="requirements_value{% if META_REQUIRE_PHPBB_FAIL %} requirements_value_not_met{% endif %}" id="require_phpbb">{{ META_REQUIRE_PHPBB }}</span>
+ 		</div>
+-		<!-- ENDIF -->
+-		<!-- IF META_REQUIRE_PHP -->
++		{% endif %}
++		{% if META_REQUIRE_PHP %}
+ 		<div class="requirements_bubble">
+-			<span class="requirements_name">{L_PHP_VERSION}{L_COLON}</span>
+-			<span class="requirements_value<!-- IF META_REQUIRE_PHP_FAIL --> requirements_value_not_met<!-- ENDIF -->" id="require_php">{META_REQUIRE_PHP}</span>
++			<span class="requirements_name">{{ lang('PHP_VERSION') }}{{ lang('COLON') }}</span>
++			<span class="requirements_value{% if META_REQUIRE_PHP_FAIL %} requirements_value_not_met{% endif %}" id="require_php">{{ META_REQUIRE_PHP }}</span>
+ 		</div>
+-		<!-- ENDIF -->
++		{% endif %}
+ 	</div>
+-	<!-- ENDIF -->
++	{% endif %}
+ 
+ 	<div>
+-		<span class="requirements_title">{L_EXTENSION_DEVELOPER}{L_COLON}</span>
+-		<!-- BEGIN meta_authors -->
++		<span class="requirements_title">{{ lang('EXTENSION_DEVELOPER') }}{{ lang('COLON') }}</span>
++		{% for meta_authors in loops.meta_authors %}
+ 		<div class="extension_author">
+-			<strong class="extension_author_name">{meta_authors.AUTHOR_NAME}</strong>
+-			<!-- IF meta_authors.AUTHOR_EMAIL -->
+-			<a href="mailto:{meta_authors.AUTHOR_EMAIL}" title="{L_AUTHOR_EMAIL}" class="extension_author_link"><i class="fa fa-envelope"></i></a>
+-			<!-- ENDIF -->
+-			<!-- IF meta_authors.AUTHOR_HOMEPAGE -->
+-			<a href="{meta_authors.AUTHOR_HOMEPAGE}" title="{L_AUTHOR_HOMEPAGE}" class="extension_author_link"><i class="fa fa-globe"></i></a>
+-			<!-- ENDIF -->
++			<strong class="extension_author_name">{{ meta_authors.AUTHOR_NAME }}</strong>
++			{% if meta_authors.AUTHOR_EMAIL %}
++			<a href="mailto:{{ meta_authors.AUTHOR_EMAIL }}" title="{{ lang('AUTHOR_EMAIL') }}" class="extension_author_link"><i class="fa fa-envelope"></i></a>
++			{% endif %}
++			{% if meta_authors.AUTHOR_HOMEPAGE %}
++			<a href="{{ meta_authors.AUTHOR_HOMEPAGE }}" title="{{ lang('AUTHOR_HOMEPAGE') }}" class="extension_author_link"><i class="fa fa-globe"></i></a>
++			{% endif %}
+ 		</div>
+-		<!-- END meta_authors -->
++		{% endfor %}
+ 	</div>
+ 	
+ 	<div class="clearfix">
+ 	<br/>
+-	<button type="button" class="btn md-close btn-block" data-dismiss="modal">{L_ACP_SIDEBAR_NOTICE_CLOSE}</button>
++	<button type="button" class="btn md-close btn-block" data-dismiss="modal">{{ lang('ACP_SIDEBAR_NOTICE_CLOSE') }}</button>
+ 	</div>
+ 	
+ </div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
+index 1b366fc15..b68eb0fe7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
+@@ -1,24 +1,24 @@
+-<!-- IF S_ALLOW_CDN -->
+-<!-- INCLUDECSS //maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css -->
+-<!-- ELSE -->
+-<!-- INCLUDECSS {ROOT_PATH}ext/sitesplat/sidebar/vendor/font-awesome/css/font-awesome.min.css -->
+-<!-- ENDIF -->
+-<!-- INCLUDECSS {ROOT_PATH}ext/sitesplat/sidebar/vendor/bootstrap/css/bootstrap_modified.css -->
+-<!-- INCLUDECSS css/sidebar.css -->
+-<!-- INCLUDECSS css/component.css -->
++{% if S_ALLOW_CDN %}
++{% INCLUDECSS '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' %}
++{% else %}
++{% INCLUDECSS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/font-awesome/css/font-awesome.min.css' %}
++{% endif %}
++{% INCLUDECSS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/bootstrap/css/bootstrap_modified.css' %}
++{% INCLUDECSS 'css/sidebar.css' %}
++{% INCLUDECSS 'css/component.css' %}
+ 
+-<!-- INCLUDE overall_header.html -->
++{% INCLUDE 'overall_header.html' %}
+ 
+-<h1>{L_ACP_SIDEBAR_TITLE} <a href="javascript:void(0)" class="md-trigger" data-remote="{U_ACTION}&amp;action=details" data-toggle="modal" data-target="#myModal"><span class="label label-success">{L_ACP_SIDEBAR_VERSION} <i class="fa fa-info-circle"></i></span></a></h1>
++<h1>{{ lang('ACP_SIDEBAR_TITLE') }} <a href="javascript:void(0)" class="md-trigger" data-remote="{{ U_ACTION }}&amp;action=details" data-toggle="modal" data-target="#myModal"><span class="label label-success">{{ lang('ACP_SIDEBAR_VERSION') }} <i class="fa fa-info-circle"></i></span></a></h1>
+ 
+ 		<!-- Modal -->
+ 		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
+ 		  <div class="modal-dialog" role="document">
+ 			<div class="modal-content md-content">
+-			  <h3><i class="icon-bbreact-emo-beer" style="margin-right:20px;"></i> {L_ACP_SIDEBAR_TITLE}</h3>
++			  <h3><i class="icon-bbreact-emo-beer" style="margin-right:20px;"></i> {{ lang('ACP_SIDEBAR_TITLE') }}</h3>
+ 			  <div class="modal-body">
+ 			   <div class="panel-body">
+-				<div class="loader">{L_ACP_LOADING}</div>
++				<div class="loader">{{ lang('ACP_LOADING') }}</div>
+ 			   </div>
+ 			  <div class="modal-footer">
+ 			  </div>
+@@ -28,37 +28,37 @@
+ 		</div>
+ 
+ 
+-<p>{L_AD_SIDEBAR_EXPLAIN}</p>
++<p>{{ lang('AD_SIDEBAR_EXPLAIN') }}</p>
+ 
+-<!-- IF S_NOTICE_LIKEDD or S_NOTICE_BBREACTION or S_NOTICE_BBDONATION or S_NOTICE_BBMEMBERSHIP or S_NOTICE_BADGE or S_NOTICE_BBPOINTS or S_NOTICE_NEWSLETTER -->
++{% if S_NOTICE_LIKEDD or S_NOTICE_BBREACTION or S_NOTICE_BBDONATION or S_NOTICE_BBMEMBERSHIP or S_NOTICE_BADGE or S_NOTICE_BBPOINTS or S_NOTICE_NEWSLETTER %}
+ <div id="sidbar_notice" class="errorbox notice">
+-	<a href="{U_BADGE_NOTICE_CLOSE}" data-ajax="close_notice" data-overlay="false" class="close clearfix" title="{L_ACP_SIDEBAR_NOTICE_CLOSE}"></a>
++	<a href="{{ U_BADGE_NOTICE_CLOSE }}" data-ajax="close_notice" data-overlay="false" class="close clearfix" title="{{ lang('ACP_SIDEBAR_NOTICE_CLOSE') }}"></a>
+ 	<p>
+-	 <!-- IF S_NOTICE_LIKEDD -->{S_NOTICE_LIKEDD}<br /><!-- ENDIF -->
+-	 <!-- IF S_NOTICE_BBREACTION -->{S_NOTICE_BBREACTION}<br /><!-- ENDIF -->
+-	 <!-- IF S_NOTICE_BBDONATION -->{S_NOTICE_BBDONATION}<br /><!-- ENDIF -->
+-	 <!-- IF S_NOTICE_BBMEMBERSHIP -->{S_NOTICE_BBMEMBERSHIP}<br /><!-- ENDIF -->
+-	 <!-- IF S_NOTICE_BADGE -->{S_NOTICE_BADGE}<br /><!-- ENDIF -->
+-	 <!-- IF S_NOTICE_BBPOINTS -->{S_NOTICE_BBPOINTS}<br /><!-- ENDIF -->
+-	 <!-- IF S_NOTICE_NEWSLETTER -->{S_NOTICE_NEWSLETTER}<br /><!-- ENDIF -->
+-	  <!-- IF S_NOTICE_BBDOWNLOAD -->{S_NOTICE_BBDOWNLOAD}<!-- ENDIF -->
++	 {% if S_NOTICE_LIKEDD %}{{ S_NOTICE_LIKEDD }}<br />{% endif %}
++	 {% if S_NOTICE_BBREACTION %}{{ S_NOTICE_BBREACTION }}<br />{% endif %}
++	 {% if S_NOTICE_BBDONATION %}{{ S_NOTICE_BBDONATION }}<br />{% endif %}
++	 {% if S_NOTICE_BBMEMBERSHIP %}{{ S_NOTICE_BBMEMBERSHIP }}<br />{% endif %}
++	 {% if S_NOTICE_BADGE %}{{ S_NOTICE_BADGE }}<br />{% endif %}
++	 {% if S_NOTICE_BBPOINTS %}{{ S_NOTICE_BBPOINTS }}<br />{% endif %}
++	 {% if S_NOTICE_NEWSLETTER %}{{ S_NOTICE_NEWSLETTER }}<br />{% endif %}
++	  {% if S_NOTICE_BBDOWNLOAD %}{{ S_NOTICE_BBDOWNLOAD }}{% endif %}
+ 	</p>
+ </div>
+-<!-- ENDIF -->
++{% endif %}
+ 
+ 
+-<form id="acp_sidebar" method="post" action="{U_ACTION}">
++<form id="acp_sidebar" method="post" action="{{ U_ACTION }}">
+ 	<fieldset>
+-		<legend>{L_ACP_SIDEBAR_OPTIONS}</legend>
++		<legend>{{ lang('ACP_SIDEBAR_OPTIONS') }}</legend>
+ 		<div class="sidebar-wrapper">
+ 		<style>
+ 			#sidebar-nav {
+-				width:<!-- IF SIDEBAR_WIDTH -->50<!-- ELSE -->30<!-- ENDIF -->px;
+-				float:<!-- IF SIDEBAR_TYPE -->right<!-- ELSE -->left<!-- ENDIF -->;
++				width:{% if SIDEBAR_WIDTH %}50{% else %}30{% endif %}px;
++				float:{% if SIDEBAR_TYPE %}right{% else %}left{% endif %};
+ 			}
+ 			#sidebar-section {
+-				width:<!-- IF SIDEBAR_WIDTH -->200<!-- ELSE -->220<!-- ENDIF -->px;
+-				float:<!-- IF SIDEBAR_TYPE -->left<!-- ELSE -->right<!-- ENDIF -->;
++				width:{% if SIDEBAR_WIDTH %}200{% else %}220{% endif %}px;
++				float:{% if SIDEBAR_TYPE %}left{% else %}right{% endif %};
+ 			}
+ 			</style> 
+ 			<div class="browser-window">
+@@ -70,7 +70,7 @@
+ 			  </div>
+ 			  <div class="dev-tools">
+ 			  <div class="bar">
+-				<div class="dev-bar-content">{L_SITESPLAT_COM}</div>
++				<div class="dev-bar-content">{{ lang('SITESPLAT_COM') }}</div>
+ 				<div class="close-x">X</div>
+ 				<div class="clear"></div>
+ 			  </div>
+@@ -79,19 +79,19 @@
+ 			<div class="content">
+ 			
+ 			<div class="inner-browser">
+-			<div id="sidebar-header">{L_FLATBOOTS}</div>
++			<div id="sidebar-header">{{ lang('FLATBOOTS') }}</div>
+ 			
+-			<div id="sidebar-nav">{L_ONE_S}<br />{L_ONE_I}<br />{L_ONE_D}<br />{L_ONE_E}<br />{L_ONE_B}<br />{L_ONE_A}<br />{L_ONE_R}</div>
++			<div id="sidebar-nav">{{ lang('ONE_S') }}<br />{{ lang('ONE_I') }}<br />{{ lang('ONE_D') }}<br />{{ lang('ONE_E') }}<br />{{ lang('ONE_B') }}<br />{{ lang('ONE_A') }}<br />{{ lang('ONE_R') }}</div>
+ 			
+ 			<div id="sidebar-section">
+ 			<p class="forum-wrapper">
+-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
+-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
+-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
+ 			</p>
+ 			</div>
+ 			
+-			<div id="sidebar-footer">{L_SITESPLAT_COPY}</div>
++			<div id="sidebar-footer">{{ lang('SITESPLAT_COPY') }}</div>
+ 			</div>
+ 			
+ 			</div>
+@@ -102,11 +102,11 @@
+ 
+ 		<div style="float:left;width:80%;">
+ 		<dl>
+-			<dt><label id="type" for="sidebartype">{L_ACP_SIDEBAR_TYPE}{L_COLON}</label><br /> {L_ACP_SIDEBAR_TYPE_EXPLAIN}</dt>
++			<dt><label id="type" for="sidebartype">{{ lang('ACP_SIDEBAR_TYPE') }}{{ lang('COLON') }}</label><br /> {{ lang('ACP_SIDEBAR_TYPE_EXPLAIN') }}</dt>
+ 			<dd>
+ 
+ 				    <div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebartype" name="type"{SIDEBAR_TYPE}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebartype" name="type"{{ SIDEBAR_TYPE }}>
+ 						<label class="onoffswitch-label" for="sidebartype">
+ 							<span class="onoffswitch-inner onoffswitch-inner-position"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -116,11 +116,11 @@
+ 			</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="width_s">{L_ACP_SIDEBAR_WIDTH}</label><br />{L_ACP_SIDEBAR_WIDTH_EXPLAIN}</dt>
++			<dt><label for="width_s">{{ lang('ACP_SIDEBAR_WIDTH') }}</label><br />{{ lang('ACP_SIDEBAR_WIDTH_EXPLAIN') }}</dt>
+ 			<dd>
+ 				
+ 				 <div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="width_s" name="width"{SIDEBAR_WIDTH}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="width_s" name="width"{{ SIDEBAR_WIDTH }}>
+ 						<label class="onoffswitch-label" for="width_s">
+ 							<span class="onoffswitch-inner onoffswitch-inner-width"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -131,11 +131,11 @@
+ 		</dl>
+ 		
+ 		<dl>
+-			<dt><label for="height">{L_ACP_SIDEBAR_HEIGHT}</label><br />{L_ACP_SIDEBAR_HEIGHT_EXPLAIN}</dt>
++			<dt><label for="height">{{ lang('ACP_SIDEBAR_HEIGHT') }}</label><br />{{ lang('ACP_SIDEBAR_HEIGHT_EXPLAIN') }}</dt>
+ 			<dd>
+ 					
+ 				<div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="height" name="height"{SIDEBAR_HEIGHT}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="height" name="height"{{ SIDEBAR_HEIGHT }}>
+ 						<label class="onoffswitch-label" for="height">
+ 							<span class="onoffswitch-inner"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -147,11 +147,11 @@
+ 		
+ 		
+ 		<dl>
+-			<dt><label for="all_pages">{L_ACP_SIDEBAR_ALL_PAGES}</label><br />{L_ACP_SIDEBAR_ALL_PAGES_EXPLAIN}</dt>
++			<dt><label for="all_pages">{{ lang('ACP_SIDEBAR_ALL_PAGES') }}</label><br />{{ lang('ACP_SIDEBAR_ALL_PAGES_EXPLAIN') }}</dt>
+ 			<dd>
+ 
+ 				<div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="all_pages" name="all_pages"{SIDEBAR_ALL_PAGES}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="all_pages" name="all_pages"{{ SIDEBAR_ALL_PAGES }}>
+ 						<label class="onoffswitch-label" for="all_pages">
+ 							<span class="onoffswitch-inner"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -162,10 +162,10 @@
+ 		</dl>
+ 		
+ 		<dl>
+-		<dt><label for="all_pages">{L_ACP_SIDEBAR_PANEL_PAGES}</label><br />{L_ACP_SIDEBAR_PANEL_PAGES_EXPLAIN}</dt>
++		<dt><label for="all_pages">{{ lang('ACP_SIDEBAR_PANEL_PAGES') }}</label><br />{{ lang('ACP_SIDEBAR_PANEL_PAGES_EXPLAIN') }}</dt>
+ 			<dd>
+ 				<div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="panel_pages" name="panel_pages"{SIDEBAR_PANEL_PAGES}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="panel_pages" name="panel_pages"{{ SIDEBAR_PANEL_PAGES }}>
+ 						<label class="onoffswitch-label" for="panel_pages">
+ 							<span class="onoffswitch-inner"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -176,11 +176,11 @@
+ 			</dl>
+ 		
+ 		<dl>
+-			<dt><label for="shuffle">{L_ACP_SIDEBAR_SHUFFLE}</label><br />{L_ACP_SIDEBAR_SHUFFLE_EXPLAIN}</dt>
++			<dt><label for="shuffle">{{ lang('ACP_SIDEBAR_SHUFFLE') }}</label><br />{{ lang('ACP_SIDEBAR_SHUFFLE_EXPLAIN') }}</dt>
+ 			<dd>
+ 
+ 				<div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="shuffle" name="shuffle"{SIDEBAR_SHUFFLE}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="shuffle" name="shuffle"{{ SIDEBAR_SHUFFLE }}>
+ 						<label class="onoffswitch-label" for="shuffle">
+ 							<span class="onoffswitch-inner"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -190,16 +190,16 @@
+ 			</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="slots">{L_ACP_SIDEBAR_SLOTS}</label><br />{L_ACP_SIDEBAR_SLOTS_EXPLAIN}</dt>
++			<dt><label for="slots">{{ lang('ACP_SIDEBAR_SLOTS') }}</label><br />{{ lang('ACP_SIDEBAR_SLOTS_EXPLAIN') }}</dt>
+ 			<dd>
+-			 <input type="range" name="slots" id="slots" min="1" max="10" step="1" value="{SLOTS}" oninput="rangevalue1.value=value" />
++			 <input type="range" name="slots" id="slots" min="1" max="10" step="1" value="{{ SLOTS }}" oninput="rangevalue1.value=value" />
+              <output id="rangevalue1"></output>
+ 			</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label id="how_many" for="how_many">{L_HOWMANY}</label><br />{L_HOWMANY_EXPLAIN}</dt>
++			<dt><label id="how_many" for="how_many">{{ lang('HOWMANY') }}</label><br />{{ lang('HOWMANY_EXPLAIN') }}</dt>
+ 			<dd>
+-			 <input type="range" name="how_many" id="how_many" min="1" max="10" step="1" value="{HOWMANY}" oninput="rangevalue.value=value" />
++			 <input type="range" name="how_many" id="how_many" min="1" max="10" step="1" value="{{ HOWMANY }}" oninput="rangevalue.value=value" />
+              <output id="rangevalue"></output>
+ 			</dd>
+ 		</dl>
+@@ -210,11 +210,11 @@
+ 		
+ 		<dl style="clear:both;">
+ 			<dt style="width:36%;">
+-			<label id="ignore" for="ignore_inactive_users ignore_founder show_admins_mods">{L_IGNORE}</label><br />{L_IGNORE_EXPLAIN}</dt>
++			<label id="ignore" for="ignore_inactive_users ignore_founder show_admins_mods">{{ lang('IGNORE') }}</label><br />{{ lang('IGNORE_EXPLAIN') }}</dt>
+ 			<dd style="margin-left:36%;">
+-			<div class="label-entry">{L_IGNORE_USERS}</div>
+-			<div class="label-entry">{L_IGNORE_FOUNDER}</div>
+-			<div class="label-entry">{L_IGNORE_ADMINS_MODS}</div>
++			<div class="label-entry">{{ lang('IGNORE_USERS') }}</div>
++			<div class="label-entry">{{ lang('IGNORE_FOUNDER') }}</div>
++			<div class="label-entry">{{ lang('IGNORE_ADMINS_MODS') }}</div>
+ 			</dd>
+ 			
+ 			<dd style="margin-left:36%;">
+@@ -222,7 +222,7 @@
+ 				<div class="label-wrap">
+ 
+ 				 <div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_inactive_users" name="ignore_inactive_users"{IGNORE_INACTIVE}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_inactive_users" name="ignore_inactive_users"{{ IGNORE_INACTIVE }}>
+ 						<label class="onoffswitch-label" for="ignore_inactive_users">
+ 							<span class="onoffswitch-inner"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -234,7 +234,7 @@
+ 				<div class="label-wrap">
+ 
+ 				    <div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_founder" name="ignore_founder"{IGNORE_FOUNDER}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_founder" name="ignore_founder"{{ IGNORE_FOUNDER }}>
+ 						<label class="onoffswitch-label" for="ignore_founder">
+ 							<span class="onoffswitch-inner"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -247,7 +247,7 @@
+ 				
+ 				
+ 				    <div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_admins_mods" name="ignore_admins_mods"{IGNORE_ADMINS_MODS}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_admins_mods" name="ignore_admins_mods"{{ IGNORE_ADMINS_MODS }}>
+ 						<label class="onoffswitch-label" for="ignore_admins_mods">
+ 							<span class="onoffswitch-inner"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -263,34 +263,34 @@
+ 
+ 	
+ 	<fieldset class="dtdd-fix">
+-		<legend>{L_ACP_SIDEBAR_HEADSUP}{L_COLON}</legend>
+-		<p>{L_ACP_SIDEBAR_HEADSIP_EXPLAIN}</p>
++		<legend>{{ lang('ACP_SIDEBAR_HEADSUP') }}{{ lang('COLON') }}</legend>
++		<p>{{ lang('ACP_SIDEBAR_HEADSIP_EXPLAIN') }}</p>
+ 	</fieldset>	
+ 	
+ 	<fieldset class="dtdd-fix">
+-		<legend>{L_ACP_SIDEBAR_SETTINGS}{L_COLON}</legend>
++		<legend>{{ lang('ACP_SIDEBAR_SETTINGS') }}{{ lang('COLON') }}</legend>
+ 		<script>
+-		var rule_type = [{OPTION_ARY}];
++		var rule_type = [{{ OPTION_ARY }}];
+ 		</script>
+ 		<dl>
+ 			<dt style="width:36%;"></dt>
+ 			<dd style="margin-left:36%;">
+-				<span style="width:120px;display:inline-block;">{L_SHOW_TYPE}{L_COLON}</span>
+-				<span style="width:150px;display:inline-block;">{L_SHOW_MOBILE}{L_COLON}</span>
+-				<span style="width:150px;display:inline-block;">{L_SHOW_TABLET}{L_COLON}</span>
++				<span style="width:120px;display:inline-block;">{{ lang('SHOW_TYPE') }}{{ lang('COLON') }}</span>
++				<span style="width:150px;display:inline-block;">{{ lang('SHOW_MOBILE') }}{{ lang('COLON') }}</span>
++				<span style="width:150px;display:inline-block;">{{ lang('SHOW_TABLET') }}{{ lang('COLON') }}</span>
+ 			</dd>
+ 		</dl>
+-		<!-- BEGIN slots -->
++		{% for slots in loops.slots %}
+ 		<dl>
+-			<dt style="width:36%;"><label id="sidebar_slot{slots.ID}_active" for="sidebar_slot{slots.ID}_active">{L_ACP_SIDEBAR_SLOT} {slots.ID}</label></dt>
++			<dt style="width:36%;"><label id="sidebar_slot{{ slots.ID }}_active" for="sidebar_slot{{ slots.ID }}_active">{{ lang('ACP_SIDEBAR_SLOT') }} {{ slots.ID }}</label></dt>
+ 			<dd style="margin-left:36%;">
+-				<select style="float:left;" name="sidebar[slot{slots.ID}][_active]]" id="sidebar_slot{slots.ID}_active">{slots.ACTIVE_SLOT}</select>
++				<select style="float:left;" name="sidebar[slot{{ slots.ID }}][_active]]" id="sidebar_slot{{ slots.ID }}_active">{{ slots.ACTIVE_SLOT }}</select>
+ 			
+ 			<div style="display:inline-block; margin-left:20px;">
+-				<div id="show_mobile{slots.ID}" style="display:{slots.OPTION_SLOT};">
++				<div id="show_mobile{{ slots.ID }}" style="display:{{ slots.OPTION_SLOT }};">
+ 					<div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{slots.ID}_show_mobile" name="options[slot{slots.ID}][_mobile]]"{slots.SHOW_MOBILE}>
+-						<label class="onoffswitch-label" for="sidebar_slot{slots.ID}_show_mobile">
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{{ slots.ID }}_show_mobile" name="options[slot{{ slots.ID }}][_mobile]]"{{ slots.SHOW_MOBILE }}>
++						<label class="onoffswitch-label" for="sidebar_slot{{ slots.ID }}_show_mobile">
+ 							<span class="onoffswitch-inner onoffswitch-inner-yn"></span>
+ 							<span class="onoffswitch-switch"></span>
+ 						</label>
+@@ -299,10 +299,10 @@
+ 			</div>
+ 			
+ 			<div style="display:inline-block; margin-left:20px;">
+-				<div id="show_tablet{slots.ID}" style="display:{slots.OPTION_SLOT};">
++				<div id="show_tablet{{ slots.ID }}" style="display:{{ slots.OPTION_SLOT }};">
+ 				<div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{slots.ID}_show_tablet" name="options[slot{slots.ID}][_tablet]]"{slots.SHOW_TABLET}>
+-						<label class="onoffswitch-label" for="sidebar_slot{slots.ID}_show_tablet">
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{{ slots.ID }}_show_tablet" name="options[slot{{ slots.ID }}][_tablet]]"{{ slots.SHOW_TABLET }}>
++						<label class="onoffswitch-label" for="sidebar_slot{{ slots.ID }}_show_tablet">
+ 							<span class="onoffswitch-inner onoffswitch-inner-yn"></span>
+ 							<span class="onoffswitch-switch"></span>
+ 						</label>
+@@ -312,29 +312,29 @@
+ 				
+ 			</dd>
+ 		</dl>
+-		<div id="sidebar_slot{slots.ID}" style="display:{slots.VISIBILTY_SLOT};">
++		<div id="sidebar_slot{{ slots.ID }}" style="display:{{ slots.VISIBILTY_SLOT }};">
+ 		<dl>
+-			<dt style="width:36%;"><label for="sidebar_slot{slots.ID}_title">{L_ACP_TITLE_SLOT} {slots.ID}</label><br />{L_ACP_TITLE_SLOT_EXPLAIN}</dt>
++			<dt style="width:36%;"><label for="sidebar_slot{{ slots.ID }}_title">{{ lang('ACP_TITLE_SLOT') }} {{ slots.ID }}</label><br />{{ lang('ACP_TITLE_SLOT_EXPLAIN') }}</dt>
+ 			<dd style="margin-left:36%;">
+-				<input type="text" name="sidebar[slot{slots.ID}][_title]]" value="{slots.SIDEBAR_TITLE}" size="50" />
++				<input type="text" name="sidebar[slot{{ slots.ID }}][_title]]" value="{{ slots.SIDEBAR_TITLE }}" size="50" />
+ 			</dd>
+ 		</dl>
+ 		<dl>
+-			<dt style="width:36%;"><label for="sidebar_slot{slots.ID}_text">{L_ACP_SIDEBAR_TEXT}{L_COLON}</label><br />{L_ACP_SIDEBAR_TEXT_EXPLAIN}</dt>
+-			<dd style="margin-left:36%;"><textarea name="sidebar[slot{slots.ID}][_text]]" rows="3" cols="40">{slots.SIDEBAR_TEXT}</textarea></dd>
++			<dt style="width:36%;"><label for="sidebar_slot{{ slots.ID }}_text">{{ lang('ACP_SIDEBAR_TEXT') }}{{ lang('COLON') }}</label><br />{{ lang('ACP_SIDEBAR_TEXT_EXPLAIN') }}</dt>
++			<dd style="margin-left:36%;"><textarea name="sidebar[slot{{ slots.ID }}][_text]]" rows="3" cols="40">{{ slots.SIDEBAR_TEXT }}</textarea></dd>
+ 		</dl>
+ 		</div>
+ 		<hr />
+-		<!-- END slots -->
++		{% endfor %}
+ 		<p class="submit-buttons">
+-			<input class="button1" type="submit" name="update" value="{L_SUBMIT}" />&nbsp;
+-			<input class="button2" type="reset" id="reset" name="reset" value="{L_RESET}" />
+-			{S_FORM_TOKEN}
++			<input class="button1" type="submit" name="update" value="{{ lang('SUBMIT') }}" />&nbsp;
++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
++			{{ S_FORM_TOKEN }}
+ 		</p>
+ 	</fieldset>
+ </form>
+ 
+-<!-- INCLUDEJS js/sidebar.js -->
+-<!-- INCLUDEJS {ROOT_PATH}ext/sitesplat/sidebar/vendor/bootstrap/js/bootstrap.min.js -->
++{% INCLUDEJS 'js/sidebar.js' %}
++{% INCLUDEJS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/bootstrap/js/bootstrap.min.js' %}
+ <div class="md-overlay"></div><!-- the overlay element -->
+-<!-- INCLUDE overall_footer.html -->
++{% INCLUDE 'overall_footer.html' %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/config/services.yml"
+index 9d89dbafb..6b64f8585 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/config/services.yml"
+@@ -60,5 +60,6 @@ services:
+             - '@config'
+             - '%core.root_path%'
+             - '%core.php_ext%'
++            - '@ext.manager'
+         tags:
+             - { name: event.listener }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/diff_full.tmp"
+new file mode 100644
+index 000000000..1d6ea8569
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/diff_full.tmp"
+@@ -0,0 +1,607 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
++index 81c13f5b4..3a96f4580 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
++@@ -1,143 +1,143 @@
++-<h3>{L_ACP_SIDEBAR_TITLE}</h3>
+++<h3>{{ lang('ACP_SIDEBAR_TITLE') }}</h3>
++   <div class="clearfix description-ext">
++-	<h1 class="ExtensionName"><!-- IF META_DISPLAY_NAME -->{META_DISPLAY_NAME} - <!-- ENDIF -->{L_EXT_DETAILS}</h1>
++-	<!-- IF S_VERSIONCHECK -->
++-	<!-- ELSE IF S_VERSIONCHECK_STATUS == 0 -->
+++	<h1 class="ExtensionName">{% if META_DISPLAY_NAME %}{{ META_DISPLAY_NAME }} - {% endif %}{{ lang('EXT_DETAILS') }}</h1>
+++	{% if S_VERSIONCHECK %}
+++	{% elseif S_VERSIONCHECK_STATUS == 0 %}
++ 	<div class="errorbox notice">
++-		<p>{L_VERSIONCHECK_FAIL}</p>
++-		<p>{VERSIONCHECK_FAIL_REASON}</p>
++-		<p><a href="{U_VERSIONCHECK_FORCE}">{L_VERSIONCHECK_FORCE_UPDATE}</a></p>
+++		<p>{{ lang('VERSIONCHECK_FAIL') }}</p>
+++		<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
+++		<p><a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
++ 	</div>
++-	<!-- ELSE IF S_VERSIONCHECK_STATUS == 1 -->
+++	{% elseif S_VERSIONCHECK_STATUS == 1 %}
++ 	<div class="errorbox notice">
++-		<p>{VERSIONCHECK_FAIL_REASON}</p>
+++		<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
++ 	</div>
++-	<!-- ENDIF -->
+++	{% endif %}
++ 	
++-	<!-- IF S_VERSIONCHECK && not S_UP_TO_DATE -->
+++	{% if S_VERSIONCHECK && not S_UP_TO_DATE %}
++ 	<div class="alert alert-update">
++ 	  
++       <div class="row">	
++       <div class="col-md-12">
++ 	   	
++ 	  <div class="col-md-6">	
++-		<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
++-		    <span class="description_name">{L_CURRENT_VERSION}{L_COLON}</span>
+++		<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
+++		    <span class="description_name">{{ lang('CURRENT_VERSION') }}{{ lang('COLON') }}</span>
++ 			<div class="extension_latest_version_wrapper">
++-			<strong class="extension_latest_version label label-warning">{META_VERSION}</strong>
+++			<strong class="extension_latest_version label label-warning">{{ META_VERSION }}</strong>
++ 			</div>
++ 	    </div>
++ 	  </div>
++ 	  
++ 	  <div class="col-md-6">	
++-		<!-- BEGIN updates_available -->
++-			<span class="requirements_title">{L_LATEST_VERSION}{L_COLON}</span>
+++		{% for updates_available in loops.updates_available %}
+++			<span class="requirements_title">{{ lang('LATEST_VERSION') }}{{ lang('COLON') }}</span>
++ 			<div class="extension_latest_version_wrapper">
++-				<strong class="extension_latest_version label label-success">{updates_available.current}</strong>
++-				<!-- IF updates_available.download-->
++-				<a href="{updates_available.download}" class="extension_author_link" title="{L_DOWNLOAD_LATEST}"><i class="fa fa-download"></i></a>
++-				<!-- ENDIF -->
++-				<!-- IF updates_available.announcement -->
++-				<a href="{updates_available.announcement}" class="extension_author_link" title="{L_ANNOUNCEMENT_TOPIC}"><i class="fa fa-bullhorn"></i></a>
++-				<!-- ENDIF -->
+++				<strong class="extension_latest_version label label-success">{{ updates_available.current }}</strong>
+++				{% if updates_available.download%}
+++				<a href="{{ updates_available.download }}" class="extension_author_link" title="{{ lang('DOWNLOAD_LATEST') }}"><i class="fa fa-download"></i></a>
+++				{% endif %}
+++				{% if updates_available.announcement %}
+++				<a href="{{ updates_available.announcement }}" class="extension_author_link" title="{{ lang('ANNOUNCEMENT_TOPIC') }}"><i class="fa fa-bullhorn"></i></a>
+++				{% endif %}
++ 			</div>
++-		<!-- END updates_available -->
+++		{% endfor %}
++ 	   </div>	
++ 	  
++ 	  </div>
++      </div>	  
++ 		
++ 	</div>
++-	<!-- ENDIF -->
+++	{% endif %}
++ 
++ 	<div class="description_div">
++ 		<div>
++ 			<div>
++ 				<p class="description_list">
++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_DESCRIPTION_PAGE}</span><br />
++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_1}</span><br />
++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_2}</span><br />
++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_3}</span><br />
++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_4}</span><br />
++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_5}</span><br />
++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_6}</span><br />
+++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_DESCRIPTION_PAGE') }}</span><br />
+++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_1') }}</span><br />
+++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_2') }}</span><br />
+++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_3') }}</span><br />
+++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_4') }}</span><br />
+++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_5') }}</span><br />
+++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_6') }}</span><br />
++ 				</p>
++ 			</div>
++ 		</div>
++ 	</div>
++ 	<div class="description_bubble big_bubble">
++-		<span class="description_name">{L_CLEAN_NAME}{L_COLON}</span>
++-		<strong class="description_value" id="meta_name">{META_NAME}</strong>
+++		<span class="description_name">{{ lang('CLEAN_NAME') }}{{ lang('COLON') }}</span>
+++		<strong class="description_value" id="meta_name">{{ META_NAME }}</strong>
++ 	</div>
++-	<!-- IF S_VERSIONCHECK && S_UP_TO_DATE -->
++-	<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
++-		<span class="description_name">{L_VERSION}{L_COLON}</span>
++-		<span class="description_value description_value_ok" id="meta_version">{META_VERSION}</span>
+++	{% if S_VERSIONCHECK && S_UP_TO_DATE %}
+++	<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
+++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
+++		<span class="description_value description_value_ok" id="meta_version">{{ META_VERSION }}</span>
++ 	</div>
++-	<!-- ELSE IF S_VERSIONCHECK && not S_UP_TO_DATE -->
++-	<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
++-		<span class="description_name">{L_VERSION}{L_COLON}</span>
++-		<span class="description_value description_value_old" id="meta_version">{META_VERSION}</span>
+++	{% elseif S_VERSIONCHECK && not S_UP_TO_DATE %}
+++	<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
+++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
+++		<span class="description_value description_value_old" id="meta_version">{{ META_VERSION }}</span>
++ 	</div>
++-	<!-- ELSE -->
+++	{% else %}
++ 	<div class="description_bubble small_bubble">
++-		<span class="description_name">{L_VERSION}{L_COLON}</span>
++-		<span class="description_value" id="meta_version">{META_VERSION}</span>
+++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
+++		<span class="description_value" id="meta_version">{{ META_VERSION }}</span>
++ 	</div>
++-	<!-- ENDIF -->
++-	<!-- IF META_HOMEPAGE -->
+++	{% endif %}
+++	{% if META_HOMEPAGE %}
++ 	<div class="description_bubble big_bubble">
++-		<span class="description_name">{L_HOMEPAGE}{L_COLON}</span>
++-		<strong class="description_value" id="meta_homepage"><a href="{META_HOMEPAGE}"><i class="fa fa-globe"></i> {META_HOMEPAGE}</a></strong>
+++		<span class="description_name">{{ lang('HOMEPAGE') }}{{ lang('COLON') }}</span>
+++		<strong class="description_value" id="meta_homepage"><a href="{{ META_HOMEPAGE }}"><i class="fa fa-globe"></i> {{ META_HOMEPAGE }}</a></strong>
++ 	</div>
++-	<!-- ENDIF -->
++-	<!-- IF META_TIME -->
+++	{% endif %}
+++	{% if META_TIME %}
++ 	<div class="description_bubble small_bubble">
++-		<span class="description_name">{L_TIME}{L_COLON}</span>
++-		<span class="description_value" id="meta_time">{META_TIME}</span>
+++		<span class="description_name">{{ lang('TIME') }}{{ lang('COLON') }}</span>
+++		<span class="description_value" id="meta_time">{{ META_TIME }}</span>
++ 	</div>
++-	<!-- ENDIF -->
+++	{% endif %}
++ 	<div class="description_bubble small_bubble">
++-		<span class="description_name">{L_LICENSE}{L_COLON}</span>
++-		<span class="description_value" id="meta_license" style="padding:0 15px;">{L_LICENSE_INFO}</span>
+++		<span class="description_name">{{ lang('LICENSE') }}{{ lang('COLON') }}</span>
+++		<span class="description_value" id="meta_license" style="padding:0 15px;">{{ lang('LICENSE_INFO') }}</span>
++ 	</div>
++ 
++-	<!-- IF META_REQUIRE_PHPBB || META_REQUIRE_PHP -->
+++	{% if META_REQUIRE_PHPBB || META_REQUIRE_PHP %}
++ 	<div>
++-		<span class="requirements_title">{L_REQUIREMENTS}{L_COLON}</span>
++-		<!-- IF META_REQUIRE_PHPBB -->
+++		<span class="requirements_title">{{ lang('REQUIREMENTS') }}{{ lang('COLON') }}</span>
+++		{% if META_REQUIRE_PHPBB %}
++ 		<div class="requirements_bubble">
++-			<span class="requirements_name">{L_PHPBB_VERSION}{L_COLON}</span>
++-			<span class="requirements_value<!-- IF META_REQUIRE_PHPBB_FAIL --> requirements_value_not_met<!-- ENDIF -->" id="require_phpbb">{META_REQUIRE_PHPBB}</span>
+++			<span class="requirements_name">{{ lang('PHPBB_VERSION') }}{{ lang('COLON') }}</span>
+++			<span class="requirements_value{% if META_REQUIRE_PHPBB_FAIL %} requirements_value_not_met{% endif %}" id="require_phpbb">{{ META_REQUIRE_PHPBB }}</span>
++ 		</div>
++-		<!-- ENDIF -->
++-		<!-- IF META_REQUIRE_PHP -->
+++		{% endif %}
+++		{% if META_REQUIRE_PHP %}
++ 		<div class="requirements_bubble">
++-			<span class="requirements_name">{L_PHP_VERSION}{L_COLON}</span>
++-			<span class="requirements_value<!-- IF META_REQUIRE_PHP_FAIL --> requirements_value_not_met<!-- ENDIF -->" id="require_php">{META_REQUIRE_PHP}</span>
+++			<span class="requirements_name">{{ lang('PHP_VERSION') }}{{ lang('COLON') }}</span>
+++			<span class="requirements_value{% if META_REQUIRE_PHP_FAIL %} requirements_value_not_met{% endif %}" id="require_php">{{ META_REQUIRE_PHP }}</span>
++ 		</div>
++-		<!-- ENDIF -->
+++		{% endif %}
++ 	</div>
++-	<!-- ENDIF -->
+++	{% endif %}
++ 
++ 	<div>
++-		<span class="requirements_title">{L_EXTENSION_DEVELOPER}{L_COLON}</span>
++-		<!-- BEGIN meta_authors -->
+++		<span class="requirements_title">{{ lang('EXTENSION_DEVELOPER') }}{{ lang('COLON') }}</span>
+++		{% for meta_authors in loops.meta_authors %}
++ 		<div class="extension_author">
++-			<strong class="extension_author_name">{meta_authors.AUTHOR_NAME}</strong>
++-			<!-- IF meta_authors.AUTHOR_EMAIL -->
++-			<a href="mailto:{meta_authors.AUTHOR_EMAIL}" title="{L_AUTHOR_EMAIL}" class="extension_author_link"><i class="fa fa-envelope"></i></a>
++-			<!-- ENDIF -->
++-			<!-- IF meta_authors.AUTHOR_HOMEPAGE -->
++-			<a href="{meta_authors.AUTHOR_HOMEPAGE}" title="{L_AUTHOR_HOMEPAGE}" class="extension_author_link"><i class="fa fa-globe"></i></a>
++-			<!-- ENDIF -->
+++			<strong class="extension_author_name">{{ meta_authors.AUTHOR_NAME }}</strong>
+++			{% if meta_authors.AUTHOR_EMAIL %}
+++			<a href="mailto:{{ meta_authors.AUTHOR_EMAIL }}" title="{{ lang('AUTHOR_EMAIL') }}" class="extension_author_link"><i class="fa fa-envelope"></i></a>
+++			{% endif %}
+++			{% if meta_authors.AUTHOR_HOMEPAGE %}
+++			<a href="{{ meta_authors.AUTHOR_HOMEPAGE }}" title="{{ lang('AUTHOR_HOMEPAGE') }}" class="extension_author_link"><i class="fa fa-globe"></i></a>
+++			{% endif %}
++ 		</div>
++-		<!-- END meta_authors -->
+++		{% endfor %}
++ 	</div>
++ 	
++ 	<div class="clearfix">
++ 	<br/>
++-	<button type="button" class="btn md-close btn-block" data-dismiss="modal">{L_ACP_SIDEBAR_NOTICE_CLOSE}</button>
+++	<button type="button" class="btn md-close btn-block" data-dismiss="modal">{{ lang('ACP_SIDEBAR_NOTICE_CLOSE') }}</button>
++ 	</div>
++ 	
++ </div>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
++index 1b366fc15..b68eb0fe7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
++@@ -1,24 +1,24 @@
++-<!-- IF S_ALLOW_CDN -->
++-<!-- INCLUDECSS //maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css -->
++-<!-- ELSE -->
++-<!-- INCLUDECSS {ROOT_PATH}ext/sitesplat/sidebar/vendor/font-awesome/css/font-awesome.min.css -->
++-<!-- ENDIF -->
++-<!-- INCLUDECSS {ROOT_PATH}ext/sitesplat/sidebar/vendor/bootstrap/css/bootstrap_modified.css -->
++-<!-- INCLUDECSS css/sidebar.css -->
++-<!-- INCLUDECSS css/component.css -->
+++{% if S_ALLOW_CDN %}
+++{% INCLUDECSS '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' %}
+++{% else %}
+++{% INCLUDECSS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/font-awesome/css/font-awesome.min.css' %}
+++{% endif %}
+++{% INCLUDECSS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/bootstrap/css/bootstrap_modified.css' %}
+++{% INCLUDECSS 'css/sidebar.css' %}
+++{% INCLUDECSS 'css/component.css' %}
++ 
++-<!-- INCLUDE overall_header.html -->
+++{% INCLUDE 'overall_header.html' %}
++ 
++-<h1>{L_ACP_SIDEBAR_TITLE} <a href="javascript:void(0)" class="md-trigger" data-remote="{U_ACTION}&amp;action=details" data-toggle="modal" data-target="#myModal"><span class="label label-success">{L_ACP_SIDEBAR_VERSION} <i class="fa fa-info-circle"></i></span></a></h1>
+++<h1>{{ lang('ACP_SIDEBAR_TITLE') }} <a href="javascript:void(0)" class="md-trigger" data-remote="{{ U_ACTION }}&amp;action=details" data-toggle="modal" data-target="#myModal"><span class="label label-success">{{ lang('ACP_SIDEBAR_VERSION') }} <i class="fa fa-info-circle"></i></span></a></h1>
++ 
++ 		<!-- Modal -->
++ 		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
++ 		  <div class="modal-dialog" role="document">
++ 			<div class="modal-content md-content">
++-			  <h3><i class="icon-bbreact-emo-beer" style="margin-right:20px;"></i> {L_ACP_SIDEBAR_TITLE}</h3>
+++			  <h3><i class="icon-bbreact-emo-beer" style="margin-right:20px;"></i> {{ lang('ACP_SIDEBAR_TITLE') }}</h3>
++ 			  <div class="modal-body">
++ 			   <div class="panel-body">
++-				<div class="loader">{L_ACP_LOADING}</div>
+++				<div class="loader">{{ lang('ACP_LOADING') }}</div>
++ 			   </div>
++ 			  <div class="modal-footer">
++ 			  </div>
++@@ -28,37 +28,37 @@
++ 		</div>
++ 
++ 
++-<p>{L_AD_SIDEBAR_EXPLAIN}</p>
+++<p>{{ lang('AD_SIDEBAR_EXPLAIN') }}</p>
++ 
++-<!-- IF S_NOTICE_LIKEDD or S_NOTICE_BBREACTION or S_NOTICE_BBDONATION or S_NOTICE_BBMEMBERSHIP or S_NOTICE_BADGE or S_NOTICE_BBPOINTS or S_NOTICE_NEWSLETTER -->
+++{% if S_NOTICE_LIKEDD or S_NOTICE_BBREACTION or S_NOTICE_BBDONATION or S_NOTICE_BBMEMBERSHIP or S_NOTICE_BADGE or S_NOTICE_BBPOINTS or S_NOTICE_NEWSLETTER %}
++ <div id="sidbar_notice" class="errorbox notice">
++-	<a href="{U_BADGE_NOTICE_CLOSE}" data-ajax="close_notice" data-overlay="false" class="close clearfix" title="{L_ACP_SIDEBAR_NOTICE_CLOSE}"></a>
+++	<a href="{{ U_BADGE_NOTICE_CLOSE }}" data-ajax="close_notice" data-overlay="false" class="close clearfix" title="{{ lang('ACP_SIDEBAR_NOTICE_CLOSE') }}"></a>
++ 	<p>
++-	 <!-- IF S_NOTICE_LIKEDD -->{S_NOTICE_LIKEDD}<br /><!-- ENDIF -->
++-	 <!-- IF S_NOTICE_BBREACTION -->{S_NOTICE_BBREACTION}<br /><!-- ENDIF -->
++-	 <!-- IF S_NOTICE_BBDONATION -->{S_NOTICE_BBDONATION}<br /><!-- ENDIF -->
++-	 <!-- IF S_NOTICE_BBMEMBERSHIP -->{S_NOTICE_BBMEMBERSHIP}<br /><!-- ENDIF -->
++-	 <!-- IF S_NOTICE_BADGE -->{S_NOTICE_BADGE}<br /><!-- ENDIF -->
++-	 <!-- IF S_NOTICE_BBPOINTS -->{S_NOTICE_BBPOINTS}<br /><!-- ENDIF -->
++-	 <!-- IF S_NOTICE_NEWSLETTER -->{S_NOTICE_NEWSLETTER}<br /><!-- ENDIF -->
++-	  <!-- IF S_NOTICE_BBDOWNLOAD -->{S_NOTICE_BBDOWNLOAD}<!-- ENDIF -->
+++	 {% if S_NOTICE_LIKEDD %}{{ S_NOTICE_LIKEDD }}<br />{% endif %}
+++	 {% if S_NOTICE_BBREACTION %}{{ S_NOTICE_BBREACTION }}<br />{% endif %}
+++	 {% if S_NOTICE_BBDONATION %}{{ S_NOTICE_BBDONATION }}<br />{% endif %}
+++	 {% if S_NOTICE_BBMEMBERSHIP %}{{ S_NOTICE_BBMEMBERSHIP }}<br />{% endif %}
+++	 {% if S_NOTICE_BADGE %}{{ S_NOTICE_BADGE }}<br />{% endif %}
+++	 {% if S_NOTICE_BBPOINTS %}{{ S_NOTICE_BBPOINTS }}<br />{% endif %}
+++	 {% if S_NOTICE_NEWSLETTER %}{{ S_NOTICE_NEWSLETTER }}<br />{% endif %}
+++	  {% if S_NOTICE_BBDOWNLOAD %}{{ S_NOTICE_BBDOWNLOAD }}{% endif %}
++ 	</p>
++ </div>
++-<!-- ENDIF -->
+++{% endif %}
++ 
++ 
++-<form id="acp_sidebar" method="post" action="{U_ACTION}">
+++<form id="acp_sidebar" method="post" action="{{ U_ACTION }}">
++ 	<fieldset>
++-		<legend>{L_ACP_SIDEBAR_OPTIONS}</legend>
+++		<legend>{{ lang('ACP_SIDEBAR_OPTIONS') }}</legend>
++ 		<div class="sidebar-wrapper">
++ 		<style>
++ 			#sidebar-nav {
++-				width:<!-- IF SIDEBAR_WIDTH -->50<!-- ELSE -->30<!-- ENDIF -->px;
++-				float:<!-- IF SIDEBAR_TYPE -->right<!-- ELSE -->left<!-- ENDIF -->;
+++				width:{% if SIDEBAR_WIDTH %}50{% else %}30{% endif %}px;
+++				float:{% if SIDEBAR_TYPE %}right{% else %}left{% endif %};
++ 			}
++ 			#sidebar-section {
++-				width:<!-- IF SIDEBAR_WIDTH -->200<!-- ELSE -->220<!-- ENDIF -->px;
++-				float:<!-- IF SIDEBAR_TYPE -->left<!-- ELSE -->right<!-- ENDIF -->;
+++				width:{% if SIDEBAR_WIDTH %}200{% else %}220{% endif %}px;
+++				float:{% if SIDEBAR_TYPE %}left{% else %}right{% endif %};
++ 			}
++ 			</style> 
++ 			<div class="browser-window">
++@@ -70,7 +70,7 @@
++ 			  </div>
++ 			  <div class="dev-tools">
++ 			  <div class="bar">
++-				<div class="dev-bar-content">{L_SITESPLAT_COM}</div>
+++				<div class="dev-bar-content">{{ lang('SITESPLAT_COM') }}</div>
++ 				<div class="close-x">X</div>
++ 				<div class="clear"></div>
++ 			  </div>
++@@ -79,19 +79,19 @@
++ 			<div class="content">
++ 			
++ 			<div class="inner-browser">
++-			<div id="sidebar-header">{L_FLATBOOTS}</div>
+++			<div id="sidebar-header">{{ lang('FLATBOOTS') }}</div>
++ 			
++-			<div id="sidebar-nav">{L_ONE_S}<br />{L_ONE_I}<br />{L_ONE_D}<br />{L_ONE_E}<br />{L_ONE_B}<br />{L_ONE_A}<br />{L_ONE_R}</div>
+++			<div id="sidebar-nav">{{ lang('ONE_S') }}<br />{{ lang('ONE_I') }}<br />{{ lang('ONE_D') }}<br />{{ lang('ONE_E') }}<br />{{ lang('ONE_B') }}<br />{{ lang('ONE_A') }}<br />{{ lang('ONE_R') }}</div>
++ 			
++ 			<div id="sidebar-section">
++ 			<p class="forum-wrapper">
++-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
++-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
++-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
+++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
+++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
+++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
++ 			</p>
++ 			</div>
++ 			
++-			<div id="sidebar-footer">{L_SITESPLAT_COPY}</div>
+++			<div id="sidebar-footer">{{ lang('SITESPLAT_COPY') }}</div>
++ 			</div>
++ 			
++ 			</div>
++@@ -102,11 +102,11 @@
++ 
++ 		<div style="float:left;width:80%;">
++ 		<dl>
++-			<dt><label id="type" for="sidebartype">{L_ACP_SIDEBAR_TYPE}{L_COLON}</label><br /> {L_ACP_SIDEBAR_TYPE_EXPLAIN}</dt>
+++			<dt><label id="type" for="sidebartype">{{ lang('ACP_SIDEBAR_TYPE') }}{{ lang('COLON') }}</label><br /> {{ lang('ACP_SIDEBAR_TYPE_EXPLAIN') }}</dt>
++ 			<dd>
++ 
++ 				    <div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebartype" name="type"{SIDEBAR_TYPE}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebartype" name="type"{{ SIDEBAR_TYPE }}>
++ 						<label class="onoffswitch-label" for="sidebartype">
++ 							<span class="onoffswitch-inner onoffswitch-inner-position"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -116,11 +116,11 @@
++ 			</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="width_s">{L_ACP_SIDEBAR_WIDTH}</label><br />{L_ACP_SIDEBAR_WIDTH_EXPLAIN}</dt>
+++			<dt><label for="width_s">{{ lang('ACP_SIDEBAR_WIDTH') }}</label><br />{{ lang('ACP_SIDEBAR_WIDTH_EXPLAIN') }}</dt>
++ 			<dd>
++ 				
++ 				 <div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="width_s" name="width"{SIDEBAR_WIDTH}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="width_s" name="width"{{ SIDEBAR_WIDTH }}>
++ 						<label class="onoffswitch-label" for="width_s">
++ 							<span class="onoffswitch-inner onoffswitch-inner-width"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -131,11 +131,11 @@
++ 		</dl>
++ 		
++ 		<dl>
++-			<dt><label for="height">{L_ACP_SIDEBAR_HEIGHT}</label><br />{L_ACP_SIDEBAR_HEIGHT_EXPLAIN}</dt>
+++			<dt><label for="height">{{ lang('ACP_SIDEBAR_HEIGHT') }}</label><br />{{ lang('ACP_SIDEBAR_HEIGHT_EXPLAIN') }}</dt>
++ 			<dd>
++ 					
++ 				<div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="height" name="height"{SIDEBAR_HEIGHT}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="height" name="height"{{ SIDEBAR_HEIGHT }}>
++ 						<label class="onoffswitch-label" for="height">
++ 							<span class="onoffswitch-inner"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -147,11 +147,11 @@
++ 		
++ 		
++ 		<dl>
++-			<dt><label for="all_pages">{L_ACP_SIDEBAR_ALL_PAGES}</label><br />{L_ACP_SIDEBAR_ALL_PAGES_EXPLAIN}</dt>
+++			<dt><label for="all_pages">{{ lang('ACP_SIDEBAR_ALL_PAGES') }}</label><br />{{ lang('ACP_SIDEBAR_ALL_PAGES_EXPLAIN') }}</dt>
++ 			<dd>
++ 
++ 				<div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="all_pages" name="all_pages"{SIDEBAR_ALL_PAGES}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="all_pages" name="all_pages"{{ SIDEBAR_ALL_PAGES }}>
++ 						<label class="onoffswitch-label" for="all_pages">
++ 							<span class="onoffswitch-inner"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -162,10 +162,10 @@
++ 		</dl>
++ 		
++ 		<dl>
++-		<dt><label for="all_pages">{L_ACP_SIDEBAR_PANEL_PAGES}</label><br />{L_ACP_SIDEBAR_PANEL_PAGES_EXPLAIN}</dt>
+++		<dt><label for="all_pages">{{ lang('ACP_SIDEBAR_PANEL_PAGES') }}</label><br />{{ lang('ACP_SIDEBAR_PANEL_PAGES_EXPLAIN') }}</dt>
++ 			<dd>
++ 				<div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="panel_pages" name="panel_pages"{SIDEBAR_PANEL_PAGES}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="panel_pages" name="panel_pages"{{ SIDEBAR_PANEL_PAGES }}>
++ 						<label class="onoffswitch-label" for="panel_pages">
++ 							<span class="onoffswitch-inner"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -176,11 +176,11 @@
++ 			</dl>
++ 		
++ 		<dl>
++-			<dt><label for="shuffle">{L_ACP_SIDEBAR_SHUFFLE}</label><br />{L_ACP_SIDEBAR_SHUFFLE_EXPLAIN}</dt>
+++			<dt><label for="shuffle">{{ lang('ACP_SIDEBAR_SHUFFLE') }}</label><br />{{ lang('ACP_SIDEBAR_SHUFFLE_EXPLAIN') }}</dt>
++ 			<dd>
++ 
++ 				<div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="shuffle" name="shuffle"{SIDEBAR_SHUFFLE}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="shuffle" name="shuffle"{{ SIDEBAR_SHUFFLE }}>
++ 						<label class="onoffswitch-label" for="shuffle">
++ 							<span class="onoffswitch-inner"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -190,16 +190,16 @@
++ 			</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="slots">{L_ACP_SIDEBAR_SLOTS}</label><br />{L_ACP_SIDEBAR_SLOTS_EXPLAIN}</dt>
+++			<dt><label for="slots">{{ lang('ACP_SIDEBAR_SLOTS') }}</label><br />{{ lang('ACP_SIDEBAR_SLOTS_EXPLAIN') }}</dt>
++ 			<dd>
++-			 <input type="range" name="slots" id="slots" min="1" max="10" step="1" value="{SLOTS}" oninput="rangevalue1.value=value" />
+++			 <input type="range" name="slots" id="slots" min="1" max="10" step="1" value="{{ SLOTS }}" oninput="rangevalue1.value=value" />
++              <output id="rangevalue1"></output>
++ 			</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label id="how_many" for="how_many">{L_HOWMANY}</label><br />{L_HOWMANY_EXPLAIN}</dt>
+++			<dt><label id="how_many" for="how_many">{{ lang('HOWMANY') }}</label><br />{{ lang('HOWMANY_EXPLAIN') }}</dt>
++ 			<dd>
++-			 <input type="range" name="how_many" id="how_many" min="1" max="10" step="1" value="{HOWMANY}" oninput="rangevalue.value=value" />
+++			 <input type="range" name="how_many" id="how_many" min="1" max="10" step="1" value="{{ HOWMANY }}" oninput="rangevalue.value=value" />
++              <output id="rangevalue"></output>
++ 			</dd>
++ 		</dl>
++@@ -210,11 +210,11 @@
++ 		
++ 		<dl style="clear:both;">
++ 			<dt style="width:36%;">
++-			<label id="ignore" for="ignore_inactive_users ignore_founder show_admins_mods">{L_IGNORE}</label><br />{L_IGNORE_EXPLAIN}</dt>
+++			<label id="ignore" for="ignore_inactive_users ignore_founder show_admins_mods">{{ lang('IGNORE') }}</label><br />{{ lang('IGNORE_EXPLAIN') }}</dt>
++ 			<dd style="margin-left:36%;">
++-			<div class="label-entry">{L_IGNORE_USERS}</div>
++-			<div class="label-entry">{L_IGNORE_FOUNDER}</div>
++-			<div class="label-entry">{L_IGNORE_ADMINS_MODS}</div>
+++			<div class="label-entry">{{ lang('IGNORE_USERS') }}</div>
+++			<div class="label-entry">{{ lang('IGNORE_FOUNDER') }}</div>
+++			<div class="label-entry">{{ lang('IGNORE_ADMINS_MODS') }}</div>
++ 			</dd>
++ 			
++ 			<dd style="margin-left:36%;">
++@@ -222,7 +222,7 @@
++ 				<div class="label-wrap">
++ 
++ 				 <div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_inactive_users" name="ignore_inactive_users"{IGNORE_INACTIVE}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_inactive_users" name="ignore_inactive_users"{{ IGNORE_INACTIVE }}>
++ 						<label class="onoffswitch-label" for="ignore_inactive_users">
++ 							<span class="onoffswitch-inner"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -234,7 +234,7 @@
++ 				<div class="label-wrap">
++ 
++ 				    <div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_founder" name="ignore_founder"{IGNORE_FOUNDER}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_founder" name="ignore_founder"{{ IGNORE_FOUNDER }}>
++ 						<label class="onoffswitch-label" for="ignore_founder">
++ 							<span class="onoffswitch-inner"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -247,7 +247,7 @@
++ 				
++ 				
++ 				    <div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_admins_mods" name="ignore_admins_mods"{IGNORE_ADMINS_MODS}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_admins_mods" name="ignore_admins_mods"{{ IGNORE_ADMINS_MODS }}>
++ 						<label class="onoffswitch-label" for="ignore_admins_mods">
++ 							<span class="onoffswitch-inner"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -263,34 +263,34 @@
++ 
++ 	
++ 	<fieldset class="dtdd-fix">
++-		<legend>{L_ACP_SIDEBAR_HEADSUP}{L_COLON}</legend>
++-		<p>{L_ACP_SIDEBAR_HEADSIP_EXPLAIN}</p>
+++		<legend>{{ lang('ACP_SIDEBAR_HEADSUP') }}{{ lang('COLON') }}</legend>
+++		<p>{{ lang('ACP_SIDEBAR_HEADSIP_EXPLAIN') }}</p>
++ 	</fieldset>	
++ 	
++ 	<fieldset class="dtdd-fix">
++-		<legend>{L_ACP_SIDEBAR_SETTINGS}{L_COLON}</legend>
+++		<legend>{{ lang('ACP_SIDEBAR_SETTINGS') }}{{ lang('COLON') }}</legend>
++ 		<script>
++-		var rule_type = [{OPTION_ARY}];
+++		var rule_type = [{{ OPTION_ARY }}];
++ 		</script>
++ 		<dl>
++ 			<dt style="width:36%;"></dt>
++ 			<dd style="margin-left:36%;">
++-				<span style="width:120px;display:inline-block;">{L_SHOW_TYPE}{L_COLON}</span>
++-				<span style="width:150px;display:inline-block;">{L_SHOW_MOBILE}{L_COLON}</span>
++-				<span style="width:150px;display:inline-block;">{L_SHOW_TABLET}{L_COLON}</span>
+++				<span style="width:120px;display:inline-block;">{{ lang('SHOW_TYPE') }}{{ lang('COLON') }}</span>
+++				<span style="width:150px;display:inline-block;">{{ lang('SHOW_MOBILE') }}{{ lang('COLON') }}</span>
+++				<span style="width:150px;display:inline-block;">{{ lang('SHOW_TABLET') }}{{ lang('COLON') }}</span>
++ 			</dd>
++ 		</dl>
++-		<!-- BEGIN slots -->
+++		{% for slots in loops.slots %}
++ 		<dl>
++-			<dt style="width:36%;"><label id="sidebar_slot{slots.ID}_active" for="sidebar_slot{slots.ID}_active">{L_ACP_SIDEBAR_SLOT} {slots.ID}</label></dt>
+++			<dt style="width:36%;"><label id="sidebar_slot{{ slots.ID }}_active" for="sidebar_slot{{ slots.ID }}_active">{{ lang('ACP_SIDEBAR_SLOT') }} {{ slots.ID }}</label></dt>
++ 			<dd style="margin-left:36%;">
++-				<select style="float:left;" name="sidebar[slot{slots.ID}][_active]]" id="sidebar_slot{slots.ID}_active">{slots.ACTIVE_SLOT}</select>
+++				<select style="float:left;" name="sidebar[slot{{ slots.ID }}][_active]]" id="sidebar_slot{{ slots.ID }}_active">{{ slots.ACTIVE_SLOT }}</select>
++ 			
++ 			<div style="display:inline-block; margin-left:20px;">
++-				<div id="show_mobile{slots.ID}" style="display:{slots.OPTION_SLOT};">
+++				<div id="show_mobile{{ slots.ID }}" style="display:{{ slots.OPTION_SLOT }};">
++ 					<div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{slots.ID}_show_mobile" name="options[slot{slots.ID}][_mobile]]"{slots.SHOW_MOBILE}>
++-						<label class="onoffswitch-label" for="sidebar_slot{slots.ID}_show_mobile">
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{{ slots.ID }}_show_mobile" name="options[slot{{ slots.ID }}][_mobile]]"{{ slots.SHOW_MOBILE }}>
+++						<label class="onoffswitch-label" for="sidebar_slot{{ slots.ID }}_show_mobile">
++ 							<span class="onoffswitch-inner onoffswitch-inner-yn"></span>
++ 							<span class="onoffswitch-switch"></span>
++ 						</label>
++@@ -299,10 +299,10 @@
++ 			</div>
++ 			
++ 			<div style="display:inline-block; margin-left:20px;">
++-				<div id="show_tablet{slots.ID}" style="display:{slots.OPTION_SLOT};">
+++				<div id="show_tablet{{ slots.ID }}" style="display:{{ slots.OPTION_SLOT }};">
++ 				<div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{slots.ID}_show_tablet" name="options[slot{slots.ID}][_tablet]]"{slots.SHOW_TABLET}>
++-						<label class="onoffswitch-label" for="sidebar_slot{slots.ID}_show_tablet">
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{{ slots.ID }}_show_tablet" name="options[slot{{ slots.ID }}][_tablet]]"{{ slots.SHOW_TABLET }}>
+++						<label class="onoffswitch-label" for="sidebar_slot{{ slots.ID }}_show_tablet">
++ 							<span class="onoffswitch-inner onoffswitch-inner-yn"></span>
++ 							<span class="onoffswitch-switch"></span>
++ 						</label>
++@@ -312,29 +312,29 @@
++ 				
++ 			</dd>
++ 		</dl>
++-		<div id="sidebar_slot{slots.ID}" style="display:{slots.VISIBILTY_SLOT};">
+++		<div id="sidebar_slot{{ slots.ID }}" style="display:{{ slots.VISIBILTY_SLOT }};">
++ 		<dl>
++-			<dt style="width:36%;"><label for="sidebar_slot{slots.ID}_title">{L_ACP_TITLE_SLOT} {slots.ID}</label><br />{L_ACP_TITLE_SLOT_EXPLAIN}</dt>
+++			<dt style="width:36%;"><label for="sidebar_slot{{ slots.ID }}_title">{{ lang('ACP_TITLE_SLOT') }} {{ slots.ID }}</label><br />{{ lang('ACP_TITLE_SLOT_EXPLAIN') }}</dt>
++ 			<dd style="margin-left:36%;">
++-				<input type="text" name="sidebar[slot{slots.ID}][_title]]" value="{slots.SIDEBAR_TITLE}" size="50" />
+++				<input type="text" name="sidebar[slot{{ slots.ID }}][_title]]" value="{{ slots.SIDEBAR_TITLE }}" size="50" />
++ 			</dd>
++ 		</dl>
++ 		<dl>
++-			<dt style="width:36%;"><label for="sidebar_slot{slots.ID}_text">{L_ACP_SIDEBAR_TEXT}{L_COLON}</label><br />{L_ACP_SIDEBAR_TEXT_EXPLAIN}</dt>
++-			<dd style="margin-left:36%;"><textarea name="sidebar[slot{slots.ID}][_text]]" rows="3" cols="40">{slots.SIDEBAR_TEXT}</textarea></dd>
+++			<dt style="width:36%;"><label for="sidebar_slot{{ slots.ID }}_text">{{ lang('ACP_SIDEBAR_TEXT') }}{{ lang('COLON') }}</label><br />{{ lang('ACP_SIDEBAR_TEXT_EXPLAIN') }}</dt>
+++			<dd style="margin-left:36%;"><textarea name="sidebar[slot{{ slots.ID }}][_text]]" rows="3" cols="40">{{ slots.SIDEBAR_TEXT }}</textarea></dd>
++ 		</dl>
++ 		</div>
++ 		<hr />
++-		<!-- END slots -->
+++		{% endfor %}
++ 		<p class="submit-buttons">
++-			<input class="button1" type="submit" name="update" value="{L_SUBMIT}" />&nbsp;
++-			<input class="button2" type="reset" id="reset" name="reset" value="{L_RESET}" />
++-			{S_FORM_TOKEN}
+++			<input class="button1" type="submit" name="update" value="{{ lang('SUBMIT') }}" />&nbsp;
+++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+++			{{ S_FORM_TOKEN }}
++ 		</p>
++ 	</fieldset>
++ </form>
++ 
++-<!-- INCLUDEJS js/sidebar.js -->
++-<!-- INCLUDEJS {ROOT_PATH}ext/sitesplat/sidebar/vendor/bootstrap/js/bootstrap.min.js -->
+++{% INCLUDEJS 'js/sidebar.js' %}
+++{% INCLUDEJS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/bootstrap/js/bootstrap.min.js' %}
++ <div class="md-overlay"></div><!-- the overl
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/event/listener.php"
+index e4cc61427..ec79cb720 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/event/listener.php"
+@@ -29,8 +29,9 @@ class listener implements EventSubscriberInterface
+ 	protected $config;
+ 	protected $root_path;
+ 	protected $php_ext;
++	protected $ext_manager;
+ 
+-	public function __construct(\sitesplat\sidebar\types\manager $manager, \phpbb\user $user, \phpbb\request\request $request, \phpbb\config\db_text $config_text, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\config\config $config, $phpbb_root_path, $php_ext)
++	public function __construct(\sitesplat\sidebar\types\manager $manager, \phpbb\user $user, \phpbb\request\request $request, \phpbb\config\db_text $config_text, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\config\config $config, $phpbb_root_path, $php_ext, \phpbb\extension\manager $ext_manager)
+ 	{
+ 		$this->manager = $manager;
+ 		$this->user = $user;
+@@ -41,6 +42,7 @@ class listener implements EventSubscriberInterface
+ 		$this->config = $config;
+ 		$this->phpbb_root_path = $phpbb_root_path;
+ 		$this->php_ext = $php_ext;
++		$this->ext_manager = $ext_manager;
+ 	}
+ 
+ 	static public function getSubscribedEvents()
+@@ -99,7 +101,14 @@ class listener implements EventSubscriberInterface
+ 				($this->manager->is_enabled($type_name) && $this->manager->is_enabled($type_name) && $slot[$i-1]['id'] > 1) ? 
+ 					$this->manager->check_condition($type_name) : null;
+ 			}
+-			
++
++			if ($this->ext_manager->is_enabled('phpbb/collapsiblecategories'))
++			{
++				$this->template->assign_vars(array(
++					'PHPBB_COLLAPSIBLE_ENABLED'	=> true,
++				));
++			}
++
+ 			$this->template->assign_vars(array(
+ 				'S_SIDEBAR_TYPE'			=> !$sidebar_config['type'],
+ 				'S_SIDEBAR_ALL_PAGES'		=> !$sidebar_config['all_pages'],
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/extra/overall_footer_content_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/extra/overall_footer_content_after.html"
+index 6479064bc..12209ad81 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/extra/overall_footer_content_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/extra/overall_footer_content_after.html"
+@@ -1,5 +1,5 @@
+-<!-- IF S_SIDEBAR_ALL_PAGES or S_INDEX -->
++{% if S_SIDEBAR_ALL_PAGES or S_INDEX %}
+ 	</div>
+ </div>
+ </div>
+-<!-- ENDIF -->
+\ No newline at end of file
++{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/extra/overall_header_content_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/extra/overall_header_content_before.html"
+index ba0275eac..d4690c356 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/extra/overall_header_content_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/extra/overall_header_content_before.html"
+@@ -1,18 +1,18 @@
+-<!-- IF S_SIDEBAR_ALL_PAGES or S_INDEX -->
++{% if S_SIDEBAR_ALL_PAGES or S_INDEX %}
+ <div class="row">
+ 	<div class="col-md-3" id="page-sidebar">
+ 		<div id="sidebar-border">
+-		<!-- BEGIN slot -->
+-		<!-- IF slot.SIDEBAR_SLOT == 1 -->
+-			<!-- DEFINE $TITLE = '{slot.SIDEBAR_TITLE}' -->
+-			<!-- DEFINE $TEXT = '{slot.SIDEBAR_TEXT}' -->
+-			<!-- INCLUDE custom.html -->
+-		<!-- ELSE IF not slot.SIDEBAR_SLOT == 0 -->
+-			<!-- INCLUDE {slot.SIDEBAR_SLOT} -->
+-		<!-- ENDIF -->
+-		<!-- END slot -->
++		{% for slot in loops.slot %}
++		{% if slot.SIDEBAR_SLOT == 1 %}
++			{% DEFINE TITLE = ''~ slot.SIDEBAR_TITLE ~'' %}
++			{% DEFINE TEXT = ''~ slot.SIDEBAR_TEXT ~'' %}
++			{% INCLUDE 'custom.html' %}
++		{% elseif not slot.SIDEBAR_SLOT == 0 %}
++			{% INCLUDE ''~ slot.SIDEBAR_SLOT ~'' %}
++		{% endif %}
++		{% endfor %}
+ 		</div>
+ 	</div>
+ 	<div id="contentje">
+ 	 <div class="col-md-9">
+-<!-- ENDIF -->
+\ No newline at end of file
++{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/extra/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/extra/overall_header_stylesheets_after.html"
+index 142cfe577..e434bd4e5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/extra/overall_header_stylesheets_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/extra/overall_header_stylesheets_after.html"
+@@ -1,37 +1,37 @@
+-<!-- IF S_INDEX -->
+-	<!-- IF not S_SIDEBAR_TYPE -->
+-		<!-- IF S_SIDEBAR_WIDTH -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarright.css -->
+-		<!-- ELSE -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebar20right.css -->
+-		<!-- ENDIF -->
+-	<!-- ELSE -->
+-		<!-- IF S_SIDEBAR_WIDTH -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft.css -->
+-		<!-- ELSE -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft20.css -->
+-		<!-- ENDIF -->
+-	<!-- ENDIF -->
+-<!-- ENDIF -->
++{% if S_INDEX %}
++	{% if not S_SIDEBAR_TYPE %}
++		{% if S_SIDEBAR_WIDTH %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebarright.css' %}
++		{% else %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebar20right.css' %}
++		{% endif %}
++	{% else %}
++		{% if S_SIDEBAR_WIDTH %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft.css' %}
++		{% else %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft20.css' %}
++		{% endif %}
++	{% endif %}
++{% endif %}
+ 
+-<!-- IF S_SIDEBAR_ALL_PAGES and not S_INDEX -->
+-	<!-- IF not S_SIDEBAR_TYPE -->
+-		<!-- IF S_SIDEBAR_WIDTH -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarright.css -->
+-		<!-- ELSE -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebar20right.css -->
+-		<!-- ENDIF -->
+-	<!-- ELSE -->
+-		<!-- IF S_SIDEBAR_WIDTH -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft.css -->
+-		<!-- ELSE -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft20.css -->
+-		<!-- ENDIF -->
+-	<!-- ENDIF -->
+-<!-- ENDIF -->
++{% if S_SIDEBAR_ALL_PAGES and not S_INDEX %}
++	{% if not S_SIDEBAR_TYPE %}
++		{% if S_SIDEBAR_WIDTH %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebarright.css' %}
++		{% else %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebar20right.css' %}
++		{% endif %}
++	{% else %}
++		{% if S_SIDEBAR_WIDTH %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft.css' %}
++		{% else %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft20.css' %}
++		{% endif %}
++	{% endif %}
++{% endif %}
+ 
+-<!-- INCLUDECSS @sitesplat_sidebar/sidebar.css -->
++{% INCLUDECSS '@sitesplat_sidebar/sidebar.css' %}
+ 
+-<!-- IF S_SIDEBAR_DYNAMIC -->
+-	<!-- INCLUDECSS @sitesplat_sidebar/sidebar_dynamic.css -->
+-<!-- ENDIF -->
+\ No newline at end of file
++{% if S_SIDEBAR_DYNAMIC %}
++	{% INCLUDECSS '@sitesplat_sidebar/sidebar_dynamic.css' %}
++{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/language/en/sidebar.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/language/en/sidebar.php"
+index 16e4bd513..878914b28 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/language/en/sidebar.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/language/en/sidebar.php"
+@@ -38,10 +38,10 @@ $lang = array_merge($lang, array(
+ 	'CLOCK'				=> 'Time',
+ 	'LIKEDD'			=> 'Last likes',
+ 	
+-	'LAST_BADGES'		=> 'Last badges',	
++	'LAST_BADGES'		=> 'Last badges',
+ 	'SIDEBAR_BADGE'		=> 'Badge name',
+ 	'SIDEBAR_DATE'		=> 'Date',
+-	'LAST_BBREACTIONS'	=> 'Last BBreactions',
++	'LAST_BBREACTIONS'	=> 'Last reactions',
+ 	'SIDEBAR_REACTION'	=> 'Reaction type',
+ 	'BBPOINTS'			=> 'BBpoints',
+ 	'POLL'				=> 'Last poll',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/membership.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/membership.js"
+index 2f4089b9e..e3ca29948 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/membership.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/membership.js"
+@@ -18,8 +18,8 @@ head.ready(function () {
+ 			},
+ 			credits: {
+ 				enabled: false,
+-				text: 'sitesplat.com',
+-				href: 'https://sitesplat.com'
++				text: 'goldtuganime.com',
++				href: 'https://goldtuganime.com'
+ 			},
+ 			exporting: { enabled: false },
+ 			tooltip: {
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/poll.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/poll.js"
+index 6bfa67ab2..3291da547 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/poll.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/poll.js"
+@@ -18,8 +18,8 @@ head.ready(function () {
+ 			},
+ 			credits: {
+ 				enabled: false,
+-				text: 'sitesplat.com',
+-				href: 'https://sitesplat.com'
++				text: 'goldtuganime.com',
++				href: 'https://goldtuganime.com'
+ 			},
+ 			exporting: { enabled: false },
+ 			tooltip: {
+@@ -33,7 +33,7 @@ head.ready(function () {
+                     events: {
+                         click: function () {
+ 							$.ajax({ type: "POST", 
+-							url: sitesplat_board_url + "app.php/sidebar/poll.html", 
++							url: sitesplat_board_url + "app.php/sidebar/poll.html",
+ 							data: {"f" : this.f,
+ 									"t": this.t,
+ 									"v": this.v},
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbdownloads.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbdownloads.html"
+index ff5984edc..4c5d45f52 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbdownloads.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbdownloads.html"
+@@ -1,44 +1,62 @@
+-<!-- IF .pop_downloads -->
++{% if loops.pop_downloads|length %}
+ <div class="sidebar">
+-<div id="bbdownloads{slot.SIDEBAR_ID}" class="panel panel-info">
++<div id="bbdownloads{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
+     <div class="panel-heading">
+-     <h4 class="panel-title">{L_DOWNLOADS}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-bbdownloads{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('DOWNLOADS') }}</span>
+     </div>
+-	<div class="panel-body">
+-	 <div id="bbdownloadsinner{slot.SIDEBAR_ID}" class="inner">
++	 <div id="innerbbdownloads{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+ 		
+ 		  <ul class="nav nav-pills nav-top-poster nav-justified">
+-			<li class="active"><a data-toggle="pill" href="#popDown">{L_POP_DOWNLOADS}</a></li>
+-			<li><a data-toggle="pill" href="#newDown">{L_NEW_DOWNLOADS}</a></li>
++			<li class="active"><a data-toggle="pill" href="#popDown">{{ lang('POP_DOWNLOADS') }}</a></li>
++			<li><a data-toggle="pill" href="#newDown">{{ lang('NEW_DOWNLOADS') }}</a></li>
+ 		  </ul>
+ 		  
+ 		  <div class="tab-content media-list user-list">
+ 			<div id="popDown" class="tab-pane fade in active">
+-				<ul class="media">
+-				<!-- BEGIN pop_downloads -->
+-					<li><a href="{pop_downloads.S_SEARCH_ACTION}">{pop_downloads.TITLE}</a> <span class="pull-right">{pop_downloads.TOTAL}</span><!-- IF not pop_downloads.S_LAST_ROW --><hr /><!-- ENDIF --></li>
+-				<!-- BEGINELSE -->
+-					<li>{L_NO_MEMBERS}<hr /></li>
+-				<!-- END pop_downloads -->	
++				<ul class="media-list user-list">
++				{% for pop_downloads in loops.pop_downloads %}
++					<li class="sidebar-last-column">
++						<span class="last-wrapper text-overflow">
++							<a href="{{ pop_downloads.S_SEARCH_ACTION }}">{{ pop_downloads.TITLE }}</a><br />
++							<span class="pull-right"><i class="fa fa-download"></i>&nbsp;{{ pop_downloads.TOTAL }}</span>
++						</span>
++					</li>
++				{% else %}
++					<li class="sidebar-last-column">
++						<span class="last-wrapper text-overflow">
++							{{ lang('NO_MEMBERS') }}
++						</span>
++					</li>
++				{% endfor %}	
+ 				</ul>
+ 			</div>
+ 				
+ 			<div id="newDown" class="tab-pane fade">
+-				<ul class="media">
+-				<!-- BEGIN new_downloads -->
+-					<li><a href="{new_downloads.S_SEARCH_ACTION}">{new_downloads.TITLE}</a> <span class="pull-right">{new_downloads.TIMESTAMP}</span><!-- IF not new_downloads.S_LAST_ROW --><hr /><!-- ENDIF --></li>
+-				<!-- BEGINELSE -->
+-					<li>{L_NO_MEMBERS}<hr /></li>
+-				<!-- END new_downloads -->	
++				<ul class="media-list user-list">
++				{% for new_downloads in loops.new_downloads %}
++					<li class="sidebar-last-column">
++						<span class="last-wrapper text-overflow">
++							<a href="{{ new_downloads.S_SEARCH_ACTION }}">{{ new_downloads.TITLE }}</a><br />
++							<span class="pull-right forum-time"><i class="fa fa-clock-o"></i>&nbsp;{{ new_downloads.TIMESTAMP }}</span>
++						</span>
++					</li>
++				{% else %}
++					<li class="sidebar-last-column">
++						<span class="last-wrapper text-overflow">
++							{{ lang('NO_MEMBERS') }}
++						</span>
++					</li>
++				{% endfor %}	
+ 				</ul>
+ 			</div>
+ 		  </div>
+ 		</div>
+-	 </div>
+ 	</div>
+ </div>
+-<!-- ENDIF -->
+-
+-
+-
+-
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}!=""){$(".toggle-bbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }});$("#innerbbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }})}$(".toggle-bbdownloads{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-bbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerbbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-bbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerbbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbpoints.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbpoints.html"
+index 37fd45502..d7a1134a1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbpoints.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbpoints.html"
+@@ -1,22 +1,26 @@
+-<!-- IF .bbpoints -->
++{% if loops.bbpoints|length %}
+ <div class="sidebar">
+-<div id="bbpoints{slot.SIDEBAR_ID}" class="panel panel-inverse">
++<div id="bbpoints{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
+     <div class="panel-heading">
+-     <h4 class="panel-title">{L_BBPOINTS}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-bbpoints{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('BBPOINTS') }}</span>
+     </div>
+-	<div class="panel-body">
+-	 <div id="innerbbpoints{slot.SIDEBAR_ID}" class="inner">
++	<div id="innerbbpoints{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+ 		<ul class="media-list user-list">
+-		<!-- BEGIN bbpoints -->
++		{% for bbpoints in loops.bbpoints %}
+ 		<li class="media">
+-		 <div class="media-body">
+-		    {bbpoints.USERNAME_FULL}{L_COLON}&nbsp;<!-- IF SYMBOL_POS --><i class="fa {BBPOINTS_SYMBOL}"></i>&nbsp;<!-- ENDIF -->{bbpoints.BBPOINTS}<!-- IF not SYMBOL_POS --><i class="fa {BBPOINTS_SYMBOL}"></i><!-- ENDIF --><!-- IF S_REGISTERED_USER and bbpoints.TRANSFER_URL -->&nbsp;<a href="{bbpoints.TRANSFER_URL}" data-ajax="true" title="{L_TRANSFER_TO}"><i class="fa fa-random"></i></a><!-- ENDIF -->
+-		 </div>
++		 <span class="media-body">
++		    {{ bbpoints.USERNAME_FULL }}{{ lang('COLON') }}&nbsp;{% if SYMBOL_POS %}<i class="fa {{ BBPOINTS_SYMBOL }}"></i>&nbsp;{% endif %}{{ bbpoints.BBPOINTS }}{% if not SYMBOL_POS %}<i class="fa {{ BBPOINTS_SYMBOL }}"></i>{% endif %}{% if S_REGISTERED_USER and bbpoints.TRANSFER_URL %}&nbsp;<a href="{{ bbpoints.TRANSFER_URL }}" data-ajax="true" title="{{ lang('TRANSFER_TO') }}"><i class="fa fa-random"></i></a>{% endif %}
++		 </span>
+ 		</li>
+-		<!-- END bbpoints -->		
++		{% endfor %}
+ 		</ul>
+-	 </div>
+ 	</div>
+ </div>
+ </div>
+-<!-- ENDIF -->
+\ No newline at end of file
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}!=""){$(".toggle-bbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }});$("#innerbbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }})}$(".toggle-bbpoints{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-bbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerbbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-bbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerbbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/birthday.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/birthday.html"
+index 7366ac84d..9137c45a2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/birthday.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/birthday.html"
+@@ -1,18 +1,22 @@
+-<!-- IF .birthday -->
++{% if loops.birthday|length %}
+ <div class="sidebar">
+-<div id="birthday{slot.SIDEBAR_ID}" class="panel panel-info">
++<div id="birthday{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
+     <div class="panel-heading">
+-     <h4 class="panel-title">{L_BIRTHDAYS}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-birthday{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('BIRTHDAYS') }}</span>
+     </div>
+-	<div class="panel-body">
+-	 <div id="innerbirthday{slot.SIDEBAR_ID}" class="inner">
+-		<ul class="list-unstyled">	
+-		<!-- BEGIN birthday -->
+-			<li title="{birthday.BIRTHDAY}"><i class="fa fa-gift"></i>&nbsp;{birthday.USERNAME_FULL}&nbsp;&#45;&nbsp;{L_AGE}{L_COLON}&nbsp;{birthday.AGE}</li>
+-		<!-- END birthday -->	
++	<div id="innerbirthday{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++		<ul class="media-list user-list">
++		{% for birthday in loops.birthday %}
++			<li class="media" title="{{ birthday.BIRTHDAY }}"><i class="fa fa-gift"></i>&nbsp;{{ birthday.USERNAME_FULL }}&nbsp;&#45;&nbsp;{{ lang('AGE') }}{{ lang('COLON') }}&nbsp;{{ birthday.AGE }}</li>
++		{% endfor %}	
+ 		</ul>
+-	 </div>
+ 	</div>
+ </div>
+ </div>
+-<!-- ENDIF -->
+\ No newline at end of file
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}!=""){$(".toggle-birthday{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }});$("#innerbirthday{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }})}$(".toggle-birthday{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-birthday{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerbirthday{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-birthday{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerbirthday{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/custom.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/custom.html"
+index a088491d5..347417367 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/custom.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/custom.html"
+@@ -1,12 +1,16 @@
+ <div class="sidebar">
+-<div id="custom{slot.SIDEBAR_ID}" class="panel panel-inverse">
++<div id="custom{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
+     <div class="panel-heading">
+-     <h4 class="panel-title">{$TITLE}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-custom{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ definition.TITLE }}</span>
++    </div>
++    <div id="innercustom{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++		{{ definition.TEXT }}
+     </div>
+-	<div class="panel-body">
+-	 <div id="innercustom{slot.SIDEBAR_ID}" class="inner">
+-		{$TEXT}
+-	 </div>
+-	</div>
+ </div>
+ </div>
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}!=""){$(".toggle-custom{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }});$("#innercustom{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }})}$(".toggle-custom{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-custom{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innercustom{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-custom{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innercustom{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/donations.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/donations.html"
+index 62f111492..18eaff19c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/donations.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/donations.html"
+@@ -1,29 +1,33 @@
+-<!-- IF .donations -->
++{% if loops.donations|length %}
+ <div class="sidebar">
+-<div id="donators{slot.SIDEBAR_ID}" class="panel panel-info">
++<div id="donators{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
+     <div class="panel-heading">
+-     <h4 class="panel-title">{L_DONATIONS}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-donators{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('DONATIONS') }}</span>
+     </div>
+-	<div class="panel-body">
+-	 <div id="innerdonators{slot.SIDEBAR_ID}" class="inner">
++	<div id="innerdonators{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+ 		 <div class="media-list user-list">
+-			<!-- BEGIN donations -->
++			{% for donations in loops.donations %}
+ 			<div class="media">
+ 				<div class="media-left">
+-					  <img alt="" src="{donations.AVATAR}" class="media-object img-circle">
+-				 </div>
++					<img alt="" src="{{ donations.AVATAR }}" class="media-object img-circle">
++				</div>
+ 				<div class="media-body">
+-					<h4 class="media-heading">{donations.USERNAME_FULL}</h4>
+-					<span><a href="#" title="{donations.TIME}">{donations.CURRENCY_SYMBOL} {donations.AMOUNT}</a></span>
++					<div class="media-heading">{{ donations.USERNAME_FULL }}</div>
++					<span><a href="#" title="{{ donations.TIME }}">{{ donations.CURRENCY_SYMBOL }} {{ donations.AMOUNT }}</a></span>
+ 				</div>
+ 			</div>
+-			<!-- BEGINELSE -->
+-             <div>{L_NO_MEMBERS}</div>
+-			<!-- END donations -->
++			{% else %}
++             <div>{{ lang('NO_MEMBERS') }}</div>
++			{% endfor %}
+ 		 </div>	
+-        <!-- IF U_DONATE_PAGE --><br /><a href="{U_DONATE_PAGE}">{L_DONATE_ALSO}</a><!-- ENDIF -->
++        {% if U_DONATE_PAGE %}<br /><a href="{{ U_DONATE_PAGE }}">{{ lang('DONATE_ALSO') }}</a>{% endif %}
+ 		</div>
+-	 </div>
+ 	</div>
+ </div>
+-<!-- ENDIF -->
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}!=""){$(".toggle-donators{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }});$("#innerdonators{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }})}$(".toggle-donators{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-donators{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerdonators{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-donators{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerdonators{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_footer_content_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_footer_content_after.html"
+index ca2a2462e..1ede00fb0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_footer_content_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_footer_content_after.html"
+@@ -1,4 +1,4 @@
+-<!-- IF S_SIDEBAR_ALL_PAGES or S_INDEX -->
++{% if S_SIDEBAR_ALL_PAGES or S_INDEX %}
+ 	</div>
+ </div>
+-<!-- ENDIF -->
+\ No newline at end of file
++{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_content_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_content_before.html"
+index 376c25e7e..57ccd7109 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_content_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_content_before.html"
+@@ -1,17 +1,17 @@
+-<!-- IF S_SIDEBAR_ALL_PAGES or S_INDEX -->
++{% if S_SIDEBAR_ALL_PAGES or S_INDEX %}
+ <div class="wrapper">
+ 	<div id="page-sidebar">
+ 		<div id="sidebar-border">
+-		<!-- BEGIN slot -->
+-		<!-- IF slot.SIDEBAR_SLOT == 1 -->
+-			<!-- DEFINE $TITLE = '{slot.SIDEBAR_TITLE}' -->
+-			<!-- DEFINE $TEXT = '{slot.SIDEBAR_TEXT}' -->
+-			<!-- INCLUDE custom.html -->
+-		<!-- ELSE IF not slot.SIDEBAR_SLOT == 0 -->
+-			<!-- INCLUDE {slot.SIDEBAR_SLOT} -->
+-		<!-- ENDIF -->
+-		<!-- END slot -->
++		{% for slot in loops.slot %}
++		{% if slot.SIDEBAR_SLOT == 1 %}
++			{% DEFINE TITLE = ''~ slot.SIDEBAR_TITLE ~'' %}
++			{% DEFINE TEXT = ''~ slot.SIDEBAR_TEXT ~'' %}
++			{% INCLUDE 'custom.html' %}
++		{% elseif not slot.SIDEBAR_SLOT == 0 %}
++			{% INCLUDE ''~ slot.SIDEBAR_SLOT ~'' %}
++		{% endif %}
++		{% endfor %}
+ 		</div>
+ 	</div>
+ 	<div id="contentje">
+-<!-- ENDIF -->
+\ No newline at end of file
++{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+index c37cac5da..14acd0751 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+@@ -1,3 +1,3 @@
+-<!-- IF S_SIDEBAR_DYNAMIC -->
+-	<!-- INCLUDEJS @sitesplat_sidebar/js/dynamic.js -->
+-<!-- ENDIF -->
+\ No newline at end of file
++{% if S_SIDEBAR_DYNAMIC %}
++	{% INCLUDEJS '@sitesplat_sidebar/js/dynamic.js' %}
++{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+index 142cfe577..e434bd4e5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+@@ -1,37 +1,37 @@
+-<!-- IF S_INDEX -->
+-	<!-- IF not S_SIDEBAR_TYPE -->
+-		<!-- IF S_SIDEBAR_WIDTH -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarright.css -->
+-		<!-- ELSE -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebar20right.css -->
+-		<!-- ENDIF -->
+-	<!-- ELSE -->
+-		<!-- IF S_SIDEBAR_WIDTH -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft.css -->
+-		<!-- ELSE -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft20.css -->
+-		<!-- ENDIF -->
+-	<!-- ENDIF -->
+-<!-- ENDIF -->
++{% if S_INDEX %}
++	{% if not S_SIDEBAR_TYPE %}
++		{% if S_SIDEBAR_WIDTH %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebarright.css' %}
++		{% else %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebar20right.css' %}
++		{% endif %}
++	{% else %}
++		{% if S_SIDEBAR_WIDTH %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft.css' %}
++		{% else %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft20.css' %}
++		{% endif %}
++	{% endif %}
++{% endif %}
+ 
+-<!-- IF S_SIDEBAR_ALL_PAGES and not S_INDEX -->
+-	<!-- IF not S_SIDEBAR_TYPE -->
+-		<!-- IF S_SIDEBAR_WIDTH -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarright.css -->
+-		<!-- ELSE -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebar20right.css -->
+-		<!-- ENDIF -->
+-	<!-- ELSE -->
+-		<!-- IF S_SIDEBAR_WIDTH -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft.css -->
+-		<!-- ELSE -->
+-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft20.css -->
+-		<!-- ENDIF -->
+-	<!-- ENDIF -->
+-<!-- ENDIF -->
++{% if S_SIDEBAR_ALL_PAGES and not S_INDEX %}
++	{% if not S_SIDEBAR_TYPE %}
++		{% if S_SIDEBAR_WIDTH %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebarright.css' %}
++		{% else %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebar20right.css' %}
++		{% endif %}
++	{% else %}
++		{% if S_SIDEBAR_WIDTH %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft.css' %}
++		{% else %}
++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft20.css' %}
++		{% endif %}
++	{% endif %}
++{% endif %}
+ 
+-<!-- INCLUDECSS @sitesplat_sidebar/sidebar.css -->
++{% INCLUDECSS '@sitesplat_sidebar/sidebar.css' %}
+ 
+-<!-- IF S_SIDEBAR_DYNAMIC -->
+-	<!-- INCLUDECSS @sitesplat_sidebar/sidebar_dynamic.css -->
+-<!-- ENDIF -->
+\ No newline at end of file
++{% if S_SIDEBAR_DYNAMIC %}
++	{% INCLUDECSS '@sitesplat_sidebar/sidebar_dynamic.css' %}
++{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/hot_topics.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/hot_topics.html"
+index 5d52eb9ec..366fd567a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/hot_topics.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/hot_topics.html"
+@@ -1,27 +1,40 @@
+-<!-- IF .hot_topics -->
++{% if loops.hot_topics|length %}
+ <div class="sidebar">
+-<div id="hot_topic{slot.SIDEBAR_ID}" class="panel panel-danger list-announcement">
++<div id="hot_topics{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
+     <div class="panel-heading">
+-        <h4 class="panel-title">{L_HOT_TOPICS}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-hot-topics{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('HOT_TOPICS') }}</span>
+     </div>
+-    <div id="innerhot_topics{slot.SIDEBAR_ID}" class="panel-body inner">
+-        <ul class="list-unstyled mb20">
+-		<!-- BEGIN hot_topics -->
+-		<!-- IF hot_topics.NO_TOPIC_TITLE-->
+-				<li>   
+-				   {hot_topics.NO_TOPIC_TITLE}
++    <div id="innerhot_topics{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++        <ul class="media-list user-list">
++		{% for hot_topics in loops.hot_topics %}
++		{% if hot_topics.NO_TOPIC_TITLE%}
++				<li class="media">    
++				   {{ hot_topics.NO_TOPIC_TITLE }}
+ 				</li>
+-		<!-- ELSE -->
+-            <li>
+-               <!-- IF hot_topics.S_UNREAD --><span class="label label-warning">{L_UNREAD}</span>&nbsp;<!-- ENDIF --><a class="title-head" href="{hot_topics.U_TOPIC}" title="{{ hot_topics.TOPIC_TITLE_NO_HTML|e('html_attr') }}">{hot_topics.TOPIC_TITLE}</a>
+-               <div>{hot_topics.USERNAME_FULL}</div>
+-		  <!--// <div>{L_IN}{L_COLON}&nbsp;<a href="{hot_topics.U_FORUM}" title="{hot_topics.FORUM_NAME}">{hot_topics.FORUM_NAME}</a></div> -->
+-			   <small class="date"><i class="fa fa-clock-o"></i>&nbsp;{hot_topics.LAST_TOPIC_TIME}</small>
++		{% else %}
++            <li class="media">
++				<span class="media-left">
++					<img alt="" src="{{ hot_topics.AVATAR }}" class="media-object img-circle">
++					{% if hot_topics.S_UNREAD %}<span class="label label-warning">{{ lang('UNREAD') }}</span>&nbsp;{% endif %}
++				</span>
++				<span class="media-body">
++					<a class="title-head" href="{{ hot_topics.U_TOPIC }}">{{ hot_topics.TOPIC_TITLE }}</a>
++					<br />
++					{{ hot_topics.USERNAME_FULL }}<br />
++					<span class="forum-time"><i class="fa fa-clock-o"></i>&nbsp;{{ hot_topics.LAST_TOPIC_TIME }}</span>
++				</span>
++				<!--// <span>{{ lang('IN') }}{{ lang('COLON') }}&nbsp;<a href="{{ hot_topics.U_FORUM }}" title="{{ hot_topics.FORUM_NAME }}">{{ hot_topics.FORUM_NAME }}</a></span><br /> -->
+ 			</li>
+-		<!-- ENDIF -->	
+-		<!-- END hot_topics -->
++		{% endif %}	
++		{% endfor %}
+         </ul>
+     </div>
+ </div>
+ </div>
+-<!-- ENDIF -->
+\ No newline at end of file
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}!=""){$(".toggle-hot-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }});$("#innerhot_topics{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }})}$(".toggle-hot-topics{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-hot-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerhot_topics{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-hot-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerhot_topics{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/highcharts.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/highcharts.js"
+index cb79a7de0..61082c126 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/highcharts.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/highcharts.js"
+@@ -51,7 +51,7 @@ e,"stroke-width":h,transform:"translate"+k,fill:P});if(c)F(f,"height",t(F(f,"hei
+ alignSetter:function(a){this.element.setAttribute("text-anchor",{left:"start",center:"middle",right:"end"}[a])},opacitySetter:function(a,b,c){this[b]=a;c.setAttribute(b,a)},titleSetter:function(a){var b=this.element.getElementsByTagName("title")[0];b||(b=x.createElementNS(xa,"title"),this.element.appendChild(b));b.textContent=p(a,"").replace(/<[^>]*>/g,"")},textSetter:function(a){if(a!==this.textStr)delete this.bBox,this.textStr=a,this.added&&this.renderer.buildText(this)},fillSetter:function(a,b,
+ c){typeof a==="string"?c.setAttribute(b,a):a&&this.colorGradient(a,b,c)},zIndexSetter:function(a,b,c){c.setAttribute(b,a);this[b]=a},_defaultSetter:function(a,b,c){c.setAttribute(b,a)}};S.prototype.yGetter=S.prototype.xGetter;S.prototype.translateXSetter=S.prototype.translateYSetter=S.prototype.rotationSetter=S.prototype.verticalAlignSetter=S.prototype.scaleXSetter=S.prototype.scaleYSetter=function(a,b){this[b]=a;this.doTransform=!0};S.prototype["stroke-widthSetter"]=S.prototype.strokeSetter=function(a,
+ b,c){this[b]=a;if(this.stroke&&this["stroke-width"])this.strokeWidth=this["stroke-width"],S.prototype.fillSetter.call(this,this.stroke,"stroke",c),c.setAttribute("stroke-width",this["stroke-width"]),this.hasStroke=!0;else if(b==="stroke-width"&&a===0&&this.hasStroke)c.removeAttribute("stroke"),this.hasStroke=!1};var ta=function(){this.init.apply(this,arguments)};ta.prototype={Element:S,init:function(a,b,c,d,e){var f=location,g,d=this.createElement("svg").attr({version:"1.1"}).css(this.getStyle(d));
+-g=d.element;a.appendChild(g);a.innerHTML.indexOf("xmlns")===-1&&F(g,"xmlns",xa);this.isSVG=!0;this.box=g;this.boxWrapper=d;this.alignedObjects=[];this.url=(Ua||tb)&&x.getElementsByTagName("base").length?f.href.replace(/#.*?$/,"").replace(/([\('\)])/g,"\\$1").replace(/ /g,"%20"):"";this.createElement("desc").add().element.appendChild(x.createTextNode("Created with Highcharts 4.0.4 and sitesplat.com"));this.defs=this.createElement("defs").add();this.forExport=e;this.gradients={};this.cache={};this.setSize(b,c,!1);var h;
++g=d.element;a.appendChild(g);a.innerHTML.indexOf("xmlns")===-1&&F(g,"xmlns",xa);this.isSVG=!0;this.box=g;this.boxWrapper=d;this.alignedObjects=[];this.url=(Ua||tb)&&x.getElementsByTagName("base").length?f.href.replace(/#.*?$/,"").replace(/([\('\)])/g,"\\$1").replace(/ /g,"%20"):"";this.createElement("desc").add().element.appendChild(x.createTextNode("Created with Highcharts 4.0.4 and goldtuganime.com"));this.defs=this.createElement("defs").add();this.forExport=e;this.gradients={};this.cache={};this.setSize(b,c,!1);var h;
+ if(Ua&&a.getBoundingClientRect)this.subPixelFix=b=function(){B(a,{left:0,top:0});h=a.getBoundingClientRect();B(a,{left:La(h.left)-h.left+"px",top:La(h.top)-h.top+"px"})},b(),N(G,"resize",b)},getStyle:function(a){return this.style=r({fontFamily:'"Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif',fontSize:"12px"},a)},isHidden:function(){return!this.boxWrapper.getBBox().width},destroy:function(){var a=this.defs;this.box=null;this.boxWrapper=this.boxWrapper.destroy();Pa(this.gradients||
+ {});this.gradients=null;if(a)this.defs=a.destroy();this.subPixelFix&&X(G,"resize",this.subPixelFix);return this.alignedObjects=null},createElement:function(a){var b=new this.Element;b.init(this,a);return b},draw:function(){},buildText:function(a){for(var b=a.element,c=this,d=c.forExport,e=p(a.textStr,"").toString(),f=e.indexOf("<")!==-1,g=b.childNodes,h,i,j=F(b,"x"),k=a.styles,l=a.textWidth,n=k&&k.lineHeight,m=k&&k.HcTextStroke,o=g.length,Y=function(a){return n?y(n):c.fontMetrics(/(px|em)$/.test(a&&
+ a.style.fontSize)?a.style.fontSize:k&&k.fontSize||c.style.fontSize||12,a).h};o--;)b.removeChild(g[o]);!f&&!m&&e.indexOf(" ")===-1?b.appendChild(x.createTextNode(e)):(h=/<.*style="([^"]+)".*>/,i=/<.*href="(http[^"]+)".*>/,l&&!a.added&&this.box.appendChild(b),e=f?e.replace(/<(b|strong)>/g,'<span style="font-weight:bold">').replace(/<(i|em)>/g,'<span style="font-style:italic">').replace(/<a/g,"<span").replace(/<\/(b|strong|i|em|a)>/g,"</span>").split(/<br.*?>/g):[e],e[e.length-1]===""&&e.pop(),q(e,function(e,
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/membership.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/membership.js"
+index 2f4089b9e..e3ca29948 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/membership.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/membership.js"
+@@ -18,8 +18,8 @@ head.ready(function () {
+ 			},
+ 			credits: {
+ 				enabled: false,
+-				text: 'sitesplat.com',
+-				href: 'https://sitesplat.com'
++				text: 'goldtuganime.com',
++				href: 'https://goldtuganime.com'
+ 			},
+ 			exporting: { enabled: false },
+ 			tooltip: {
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/poll.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/poll.js"
+index 6bfa67ab2..3291da547 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/poll.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/poll.js"
+@@ -18,8 +18,8 @@ head.ready(function () {
+ 			},
+ 			credits: {
+ 				enabled: false,
+-				text: 'sitesplat.com',
+-				href: 'https://sitesplat.com'
++				text: 'goldtuganime.com',
++				href: 'https://goldtuganime.com'
+ 			},
+ 			exporting: { enabled: false },
+ 			tooltip: {
+@@ -33,7 +33,7 @@ head.ready(function () {
+                     events: {
+                         click: function () {
+ 							$.ajax({ type: "POST", 
+-							url: sitesplat_board_url + "app.php/sidebar/poll.html", 
++							url: sitesplat_board_url + "app.php/sidebar/poll.html",
+ 							data: {"f" : this.f,
+ 									"t": this.t,
+ 									"v": this.v},
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_badges.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_badges.html"
+index 564629e91..6a932fd71 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_badges.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_badges.html"
+@@ -1,29 +1,30 @@
+-<!-- IF .last_badges -->
++{% if loops.last_badges|length %}
+ <div class="sidebar">
+-<div id="lastbadges{slot.SIDEBAR_ID}" class="panel panel-success">
++<div id="lastbadges{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
+     <div class="panel-heading">
+-     <h4 class="panel-title">{L_LAST_BADGES}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-lastbadges{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('LAST_BADGES') }}</span>
+     </div>
+-	<div class="panel-body">
+-	 <div id="innerlastbadges{slot.SIDEBAR_ID}" class="inner">
+-		<ul class="media-list user-list">
+-		<!-- BEGIN last_badges -->
+-			<li class="media">
+-                    <div class="media-left">
+-                        <a href="#">
+-                          <img alt="" src="{last_badges.BADGE}" class="media-object img-circle">
+-                        </a>
+-                    </div>
+-                    <div class="media-body">
+-                        <h4 class="media-heading">{last_badges.USERNAME_FULL}</h4>
+-                        <span>{last_badges.NAME}</span>  
+-						<small class="date"><i class="fa fa-clock-o"></i>&nbsp;{last_badges.BADGE_DATE}</small>
+-                    </div>
+-            </li>
+-		<!-- END last_badges -->
+-		</ul>
+-	 </div>
++	 <div id="innerlastbadges{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++		<div class="media-list user-list">
++		{% for last_badges in loops.last_badges %}
++			<div class="media">
++				<div class="media-left">
++					<img alt="" src="{{ last_badges.BADGE }}" class="media-object img-circle">
++				</div>
++				<div class="media-body">
++					<div class="media-heading">{{ last_badges.USERNAME_FULL }}<br />{{ last_badges.NAME }}</div>
++					<span><a href="#"><i class="fa fa-clock-o"></i>&nbsp;{{ last_badges.BADGE_DATE }}</a></span>
++				</div>
++			</div>
++		{% endfor %}
++		</div>
+ 	</div>
+ </div>
+ </div>
+-<!-- ENDIF -->
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}!=""){$(".toggle-lastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }});$("#innerlastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }})}$(".toggle-lastbadges{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-lastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerlastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-lastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerlastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_bbreactions.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_bbreactions.html"
+index 6e409c3ee..d110dda76 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_bbreactions.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_bbreactions.html"
+@@ -1,31 +1,36 @@
+-<!-- IF .last_bbreactions -->
++{% if loops.last_bbreactions|length %}
+ <div class="sidebar">
+-<div id="lastbbreactions{slot.SIDEBAR_ID}" class="panel panel-inverse">
++<div id="lastbbreactions{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
+     <div class="panel-heading">
+-     <h4 class="panel-title">{L_LAST_BBREACTIONS}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-lastbbreactions{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('LAST_BBREACTIONS') }}</span>
+     </div>
+-	<div class="panel-body">
+-	 <div id="innerlastbbreactions{slot.SIDEBAR_ID}" class="inner">
++	 <div id="innerlastbbreactions{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+ 		<ul class="media-list user-list">	
+-		<!-- BEGIN last_bbreactions -->
+-		<li class="media">
+-                <div class="media-left bbreactions-emoji">
+-                    <!-- IF last_bbreactions.EMOJI -->
+-                    {last_bbreactions.EMOJI}
+-                    <!-- ELSE -->
+-                    <i class="fa {last_bbreactions.SYMBOL} fa-object" style="color:<!-- IF last_bbreactions.POSITIVE -->green<!-- ELSE -->red<!-- ENDIF -->;"></i>
+-                    <!-- ENDIF -->
+-                </div>
+-                <div class="media-body">
+-                    <h4 class="media-heading">{last_bbreactions.USERNAME_FULL}</h4>
+-                    <span><a href="{last_bbreactions.POST_URL}">{last_bbreactions.TYPE}</a></span>
+-                <small class="date"><i class="fa fa-clock-o"></i>&nbsp;{last_bbreactions.BADGE_DATE}</small>
+-				</div>
++            {% for last_bbreactions in loops.last_bbreactions %}
++			<li class="sidebar-last-column">
++				<span class="sidebar-poster-thumbs bbreactions-emoji">
++					{% if last_bbreactions.EMOJI %}
++					{{ last_bbreactions.EMOJI }}
++					{% else %}
++					<i class="fa {{ last_bbreactions.SYMBOL }} fa-object" style="color:{% if last_bbreactions.POSITIVE %}green{% else %}red{% endif %};"></i>
++					{% endif %}
++				</span>
++				<span class="last-wrapper text-overflow">
++					{{ last_bbreactions.USERNAME_FULL }}
++					<br />
++					<i class="fa fa-volume-control-phone"></i>&nbsp;<a href="{{ last_bbreactions.POST_URL }}">{{ last_bbreactions.TYPE }}</a>
++				</span>
++				<span class="space5"></span>
+          </li>
+-		<!-- END last_bbreactions -->		
++		{% endfor %}		
+ 		</ul>
+-	 </div>
+ 	</div>
+ </div>
+ </div>
+-<!-- ENDIF -->
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}=window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}||"";if(window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}!=""){$(".toggle-lastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }});$("#innerlastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }})}$(".toggle-lastbbreactions{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-lastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerlastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-lastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerlastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/likesdd.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/likesdd.html"
+index df6590a95..2eb377cde 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/likesdd.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/likesdd.html"
+@@ -1,27 +1,33 @@
+-<!-- IF .last_likes -->
++{% if loops.last_likes|length %}
+ <div class="sidebar">
+-<div id="lastlikes{slot.SIDEBAR_ID}" class="panel panel-warning">
++<div id="lastlikes{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
+     <div class="panel-heading">
+-     <h4 class="panel-title">{L_LIKEDD}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-lastlikes{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('LIKEDD') }}</span>
+     </div>
+-	<div class="panel-body">
+-	 <div id="innerlastlikes{slot.SIDEBAR_ID}" class="inner">
++	 <div id="innerlastlikes{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+ 		<ul class="media-list user-list">
+-            <!-- BEGIN last_likes -->
+-			<li class="media">
+-			    <div class="media-left">
+-                     <img alt="" src="{last_likes.AVATAR}" class="media-object img-circle">
+-                </div>
+-                <div class="media-body">
+-					<div><i class="fa fa-thumbs-up"></i>&nbsp;{L_BY}&nbsp;{last_likes.USERNAME_FULL}</div>
+-                    <a href="{last_likes.POST_URL}">{last_likes.SUBJECT}</a>
+-                    <small class="date"><i class="fa fa-clock-o"></i>&nbsp;{last_likes.LIKE_DATE}</small>
+-                </div>
+-            </li>
+-			<!-- END last_likes -->
++            {% for last_likes in loops.last_likes %}
++			<div class="media">
++				<div class="media-left">
++					<img alt="" src="{{ last_likes.AVATAR }}" class="media-object img-circle">
++				</div>
++				<div class="media-body">
++					<div class="media-heading">
++						<i class="fa fa-thumbs-up"></i>&nbsp;{{ last_likes.USERNAME_FULL }}
++					</div>
++					<a href="{{ last_likes.POST_URL }}">{{ last_likes.SUBJECT }}</a>
++				</div>
++				<div class="space10"></div>
++			</div>
++			{% endfor %}
+ 		</ul>
+ 	 </div>
+-	</div>
+ </div>
+ </div>
+-<!-- ENDIF -->
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}=window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}||"";if(window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}!=""){$(".toggle-lastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }});$("#innerlastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }})}$(".toggle-lastlikes{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-lastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerlastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-lastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerlastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/membership.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/membership.html"
+index 2512b8241..5f32461af 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/membership.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/membership.html"
+@@ -1,25 +1,29 @@
+-<!-- IF MEMBERSTATS -->
++{% if MEMBERSTATS %}
+ <div class="sidebar">
+-<div id="membership{slot.SIDEBAR_ID}" class="panel panel-inverse">
++<div id="membership{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
+     <div class="panel-heading">
+-     <h4 class="panel-title">{L_MEMBERSHIPS}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-membership{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('MEMBERSHIPS') }}</span>
+     </div>
+-	<div class="panel-body">
+-	 <div id="innermembership{slot.SIDEBAR_ID}" class="inner">
+-		<a href="{U_MEMBERSHIPS}">{L_MEMBERSHIPS_CTA}</a>
++    <div id="innermembership{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++		<a href="{{ U_MEMBERSHIPS }}">{{ lang('MEMBERSHIPS_CTA') }}</a>
+ 		<div id="membershipchart" style="width:100%;height:150px;margin:0 auto;background-color:transparant;"></div>
+ 	    <script>
+-			var memberstats = {MEMBERSTATS};
++			var memberstats = {{ MEMBERSTATS }};
+ 		</script>
+-	 </div>
+ 	</div>
+ </div>
+ </div>
+-<!-- ENDIF -->
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}!=""){$(".toggle-membership{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }});$("#innermembership{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }})}$(".toggle-membership{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-membership{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innermembership{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-membership{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innermembership{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+ <!-- // some trickery here to eliminate the conflict with the poll type block, likeBB and BBreaction extensions top stats pages  -->
+-<!-- IF not POLTITLE -->
+-    <!-- INCLUDEJS @sitesplat_sidebar/js/highcharts.js -->
+-<!-- ENDIF -->  
+-<!-- IF MEMBERSTATS -->
+-    <!-- INCLUDEJS @sitesplat_sidebar/js/membership.js -->
+-<!-- ENDIF --> 
+\ No newline at end of file
++{% if not POLTITLE %}
++    {% INCLUDEJS '@sitesplat_sidebar/js/highcharts.js' %}
++{% endif %}  
++{% if MEMBERSTATS %}
++    {% INCLUDEJS '@sitesplat_sidebar/js/membership.js' %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newsletter.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newsletter.html"
+index bdf7c3ad8..b525b6886 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newsletter.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newsletter.html"
+@@ -1,33 +1,34 @@
+-<!-- IF NEWSLETTER and SCRIPT_NAME eq 'index' -->
++{% if NEWSLETTER and SCRIPT_NAME eq 'index' %}
+ <div class="sidebar">
+-<div id="newsletter{slot.SIDEBAR_ID}" class="panel panel-info">
++<div id="newsletter{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
+     <div class="panel-heading">
+-     <h4 class="panel-title">{L_NEWSLETTER}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-newsletter{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('NEWSLETTER') }}</span>
+     </div>
+-	<div class="panel-body">
+-	 <div id="innernewsletter{slot.SIDEBAR_ID}" class="inner">
++	 <div id="innernewsletter{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+ 		<div class="subscribe-form" id="subscribe-sidebar">
+-			<!-- IF not S_SUBSCRIBE_MESSAGE -->
+-				<form method="post" action="{U_SUBSCRIBE_ACTION}" id="subscribe-form-sidebar">
++			{% if not S_SUBSCRIBE_MESSAGE %}
++				<form method="post" action="{{ U_SUBSCRIBE_ACTION }}" id="subscribe-form-sidebar">
+ 					<fieldset>
+ 					  <div class="form-group nomargin">
+-					   <label class="sr-only" for="email">{L_SUBSCRIBE_EMAIL}{L_COLON}</label>
++					   <label class="sr-only" for="email">{{ lang('SUBSCRIBE_EMAIL') }}{{ lang('COLON') }}</label>
+ 						<div class="input-group">
+ 						  <span class="input-group-addon"><i class="icon-moon-email"></i></span>
+-						  <input class="form-control" type="email" name="email" id="email" spellcheck="false" autocomplete="off" placeholder="{L_EMAIL}">
++						  <input class="form-control" type="email" name="email" id="email" spellcheck="false" autocomplete="off" placeholder="{{ lang('EMAIL') }}">
+ 						</div>
+ 					  </div>
+ 					<div class="form-group">
+-					  <button type="submit" class="btn btn-success btn-block" name="subscribe" value="{L_SUBSCRIBE_BUTTON}">{L_SUBSCRIBE_BTN}</button>
++					  <button type="submit" class="btn btn-success btn-block" name="subscribe" value="{{ lang('SUBSCRIBE_BUTTON') }}">{{ lang('SUBSCRIBE_BTN') }}</button>
+ 					</div>
+ 					</fieldset>
+ 				</form>
+-			<!-- ELSEIF S_SUBSCRIBE_MESSAGE -->
++			{% elseif S_SUBSCRIBE_MESSAGE %}
+ 				<div class="col-sm-12">
+-					<p>{S_SUBSCRIBE_MESSAGE}</p>
++					<p>{{ S_SUBSCRIBE_MESSAGE }}</p>
+ 				</div>
+-			<!-- ENDIF -->
+-	 </div>
++			{% endif %}
+ 	 </div>
+ 	</div>
+ </div>
+@@ -51,5 +52,8 @@ head.ready('jquery.min.js', function(){
+ 		});
+ 	});
+ });
+-</script>	
+-<!-- ENDIF -->
++</script>
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}!=""){$(".toggle-newsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }});$("#innernewsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }})}$(".toggle-newsletter{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-newsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innernewsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-newsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innernewsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newusers.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newusers.html"
+index e5b379f88..4ef546a54 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newusers.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newusers.html"
+@@ -1,25 +1,29 @@
+-<!-- IF .newest_users -->
++{% if loops.newest_users|length %}
+ <div class="sidebar">
+-<div id="users{slot.SIDEBAR_ID}" class="panel panel-info">
++<div id="users{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
+     <div class="panel-heading">
+-     <h4 class="panel-title">{L_NEWEST_USERS}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-users{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('NEWEST_USERS') }}</span>
+     </div>
+-	<div class="panel-body">
+-	 <div id="innerusers{slot.SIDEBAR_ID}" class="inner">
++	<div id="innerusers{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+ 		<ul class="media-list user-list">
+-		<!-- BEGIN newest_users -->
++		{% for newest_users in loops.newest_users %}
+ 		<li class="media">
+ 			<div class="media-left">
+-				<img alt="" src="{newest_users.AVATAR}" class="media-object img-circle">
++				<img alt="" src="{{ newest_users.AVATAR }}" class="media-object img-circle">
+ 			</div>
+             <div class="media-body">
+-                <div class="media-heading">{newest_users.USERNAME_FULL}&nbsp;&#45;&nbsp;<small>{newest_users.REG_DATE}</small></div>
++                <div class="media-heading">{{ newest_users.USERNAME_FULL }}&nbsp;&#45;&nbsp;<small>{{ newest_users.REG_DATE }}</small></div>
+             </div>
+         </li>
+-		<!-- END newest_users -->
++		{% endfor %}
+ 		</ul>
+-	 </div>
+ 	</div>
+ </div>
+ </div>
+-<!-- ENDIF -->
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}!=""){$(".toggle-users{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }});$("#innerusers{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }})}$(".toggle-users{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-users{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerusers{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-users{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerusers{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/poll.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/poll.html"
+index 658df82ad..cb9c9bb44 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/poll.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/poll.html"
+@@ -1,20 +1,24 @@
+-<!-- IF POLTITLE -->
++{% if POLTITLE %}
+ <div class="sidebar">
+-<div id="poll{slot.SIDEBAR_ID}" class="panel panel-inverse">
++<div id="poll{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
+     <div class="panel-heading">
+-     <h4 class="panel-title">{L_POLL}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-poll{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('POLL') }}</span>
+     </div>
+-	<div class="panel-body">
+-	 <div id="innerpoll{slot.SIDEBAR_ID}" class="inner">
+-		<a href="{URL}">{POLTITLE}</a>
++	<div id="innerpoll{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++		<a href="{{ URL }}">{{ POLTITLE }}</a>
+ 		<div id="pollchart" style="width:100%;height:150px;margin:0 auto;background-color:transparent;"></div>
+-	 </div>
+ 	</div>
+ </div>
+ </div>
+ <script>
+- var polstats = {POLSTATS};
++ var polstats = {{ POLSTATS }};
+ </script>
+-<!-- INCLUDEJS @sitesplat_sidebar/js/highcharts.js -->
+-<!-- INCLUDEJS @sitesplat_sidebar/js/poll.js -->
+-<!-- ENDIF -->
+\ No newline at end of file
++{% INCLUDEJS '@sitesplat_sidebar/js/highcharts.js' %}
++{% INCLUDEJS '@sitesplat_sidebar/js/poll.js' %}
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}!=""){$(".toggle-poll{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }});$("#innerpoll{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }})}$(".toggle-poll{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-poll{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerpoll{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-poll{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerpoll{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/staff.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/staff.html"
+index 8cc76175e..18b48b95f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/staff.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/staff.html"
+@@ -1,30 +1,37 @@
+-<!-- IF .staff -->
++{% if loops.staff|length %}
+ <div class="sidebar">
+-<div id="staff{slot.SIDEBAR_ID}" class="panel panel-info">
++<div id="staff{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
+     <div class="panel-heading">
+-     <h4 class="panel-title">{L_STAFF}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-staff{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('STAFF') }}</span>
+     </div>
+-	<div class="panel-body">
+-	 <div id="innerstaff{slot.SIDEBAR_ID}" class="inner">
+-		 <div class="media-list user-list">
+-			<!-- BEGIN staff -->
+-			<div class="media">
++	 <div id="innerstaff{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++		 <ul class="media-list user-list">
++			{% for staff in loops.staff %}
++            <div class="media">
+ 				<div class="media-left">
+-					<a href="#">
+-					  <img alt="" src="{staff.AVATAR}" class="media-object img-circle">
+-					</a>
+-				 </div>
++					<img alt="" src="{{ staff.AVATAR }}" class="media-object img-circle">
++				</div>
+ 				<div class="media-body">
+-					<h4 class="media-heading">{staff.USERNAME_FULL}</h4>
+-					<span><a href="{staff.S_SEARCH_ACTION}" title="">{staff.TIME}</a></span>
++					<div class="media-heading">{{ staff.USERNAME_FULL }}</div>
++					<span class="forum-time"><i class="fa fa-clock-o"></i>&nbsp;<a href="{{ staff.S_SEARCH_ACTION }}" title="">{{ staff.TIME }}</a></span>
+ 				</div>
++				<div class="space5"></div>
+ 			</div>
+-			<!-- BEGINELSE -->
+-             <div>{L_NO_MEMBERS}</div>
+-			<!-- END staff -->
+-		 </div>	
++			{% else %}
++			<li class="sidebar-last-column">
++				<span class="last-wrapper text-overflow">
++					{{ lang('NO_MEMBERS') }}
++				</span>
++			</li>
++			{% endfor %}
++		 </ul>	
+ 		</div>
+-	 </div>
+ 	</div>
+ </div>
+-<!-- ENDIF -->
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}!=""){$(".toggle-staff{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }});$("#innerstaff{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }})}$(".toggle-staff{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-staff{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerstaff{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-staff{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerstaff{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_posters.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_posters.html"
+index 786d07a82..0350dd762 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_posters.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_posters.html"
+@@ -1,65 +1,96 @@
+-<!-- IF .top_posters -->
++{% if loops.top_posters|length %}
+ <div class="sidebar">
+-<div id="posters{slot.SIDEBAR_ID}" class="panel panel-info">
++<div id="posters{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
+     <div class="panel-heading">
+-     <h4 class="panel-title">{L_TOP_POSTERS}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-posters{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('TOP_POSTERS') }}</span>
+     </div>
+-	<div class="panel-body">
+-	 <div id="innerposters{slot.SIDEBAR_ID}" class="inner">
+-		
++	 <div id="innerposters{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+ 		  <ul class="nav nav-pills nav-top-poster nav-justified">
+-			<li class="active"><a data-toggle="pill" href="#topAll">{L_SIDEBAR_ALL_TIME}</a></li>
+-			<li><a data-toggle="pill" href="#topDay">{L_SIDEBAR_DAILY}</a></li>
+-			<li><a data-toggle="pill" href="#topWeek">{L_SIDEBAR_WEEKLY}</a></li>
++			<li class="active"><a data-toggle="pill" href="#topAll">{{ lang('SIDEBAR_ALL_TIME') }}</a></li>
++			<li><a data-toggle="pill" href="#topDay">{{ lang('SIDEBAR_DAILY') }}</a></li>
++			<li><a data-toggle="pill" href="#topWeek">{{ lang('SIDEBAR_WEEKLY') }}</a></li>
+ 		  </ul>
+-		  
++
++		  <div class="space10"></div>
++
+ 		  <div class="tab-content media-list user-list">
+-			
+ 			<div id="topAll" class="tab-pane fade in active">
+-			<!-- BEGIN top_posters -->
+-			<div class="media">
++			<div class="media-list user-list">
++			{% for top_posters in loops.top_posters %}
++            <div class="media">
+ 				<div class="media-left">
+-					  <img alt="" src="{top_posters.AVATAR}" class="media-object img-circle">
+-				 </div>
++					<img alt="" src="{{ top_posters.AVATAR }}" class="media-object img-circle">
++				</div>
+ 				<div class="media-body">
+-					<h4 class="media-heading">{top_posters.USERNAME_FULL}</h4>
+-					<span>{L_POSTS}{L_COLON}&nbsp;<a href="{top_posters.S_SEARCH_ACTION}" title="">{top_posters.POSTS}</a></span>
++					<div class="media-heading">{{ top_posters.USERNAME_FULL }}</div>
++					<span>{{ lang('POSTS') }}{{ lang('COLON') }}&nbsp;<a href="{{ top_posters.S_SEARCH_ACTION }}" title="">{{ top_posters.POSTS }}</a></span>
+ 				</div>
++				<div class="space10"></div>
++			</div>
++			{% else %}
++			<div class="media">
++				<div class="media-body">
++					{{ lang('NO_MEMBERS') }}
++				</div>
++			</div>
++			{% endfor %}
+ 			</div>
+-			<!-- END top_posters -->
+ 			</div>
+ 			
+ 			<div id="topDay" class="tab-pane fade">
+-			<!-- BEGIN top_posters_day -->
+-			<div class="media">
++			<div class="media-list user-list">
++			{% for top_posters_day in loops.top_posters_day %}
++            <div class="media">
+ 				<div class="media-left">
+-					  <img alt="" src="{top_posters_day.AVATAR}" class="media-object img-circle">
+-				 </div>
++					<img alt="" src="{{ top_posters_day.AVATAR }}" class="media-object img-circle">
++				</div>
++				<div class="media-body">
++					<div class="media-heading">{{ top_posters_day.USERNAME_FULL }}</div>
++					<span>{{ lang('POSTS') }}{{ lang('COLON') }}&nbsp;<a href="{{ top_posters_day.S_SEARCH_ACTION }}" title="">{{ top_posters_day.POSTS }}</a></span>
++				</div>
++				<div class="space10"></div>
++			</div>
++			{% else %}
++			<div class="media">
+ 				<div class="media-body">
+-					<h4 class="media-heading">{top_posters_day.USERNAME_FULL}</h4>
+-					<span>{L_POSTS}{L_COLON}&nbsp;<a href="{top_posters_day.S_SEARCH_ACTION}" title="">{top_posters_day.POSTS}</a></span>
++					{{ lang('NO_MEMBERS') }}
+ 				</div>
+ 			</div>
+-			<!-- END top_posters_day -->
++			{% endfor %}
++			</div>
+ 			</div>
+ 			
+ 			<div id="topWeek" class="tab-pane fade">
+-			<!-- BEGIN top_posters_week -->
+-			<div class="media">
++			<div class="media-list user-list">
++			{% for top_posters_week in loops.top_posters_week %}
++            <div class="media">
+ 				<div class="media-left">
+-					  <img alt="" src="{top_posters_week.AVATAR}" class="media-object img-circle">
+-				 </div>
++					<img alt="" src="{{ top_posters_week.AVATAR }}" class="media-object img-circle">
++				</div>
+ 				<div class="media-body">
+-					<h4 class="media-heading">{top_posters_week.USERNAME_FULL}</h4>
+-					<span>{L_POSTS}{L_COLON}&nbsp;<a href="{top_posters_week.S_SEARCH_ACTION}" title="">{top_posters_week.POSTS}</a></span>
++					<div class="media-heading">{{ top_posters_week.USERNAME_FULL }}</div>
++					<span>{{ lang('POSTS') }}{{ lang('COLON') }}&nbsp;<a href="{{ top_posters_week.S_SEARCH_ACTION }}" title="">{{ top_posters_week.POSTS }}</a></span>
+ 				</div>
++				<div class="space10"></div>
++			</div>
++			{% else %}
++			<div class="media">
++				<div class="media-body">
++					{{ lang('NO_MEMBERS') }}
++				</div>
++			</div>
++			{% endfor %}
+ 			</div>
+-			<!-- END top_posters_week -->
+ 			</div>
+ 			
+ 		  </div>
+ 		</div>
+-	 </div>
+ 	</div>
+ </div>
+-<!-- ENDIF -->
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}=window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}||"";if(window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}!=""){$(".toggle-posters{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }});$("#innerposters{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }})}$(".toggle-posters{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-posters{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerposters{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-posters{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerposters{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_topics.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_topics.html"
+index eb070f94b..e7a9302cb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_topics.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_topics.html"
+@@ -1,27 +1,40 @@
+-<!-- IF .top_topics -->
++{% if loops.top_topics|length %}
+ <div class="sidebar">
+-<div id="topics{slot.SIDEBAR_ID}" class="panel panel-primary list-announcement">
++<div id="topics{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
+     <div class="panel-heading">
+-        <h4 class="panel-title">{L_NEWEST_TOPICS}</h4>
++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
++		<a class="toggle-topics{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
++		{% endif %}
++		<span>{{ lang('NEWEST_TOPICS') }}</span>
+     </div>
+-    <div id="innertopics{slot.SIDEBAR_ID}" class="panel-body inner">
+-        <ul class="list-unstyled mb20">
+-		<!-- BEGIN top_topics -->
+-		<!-- IF top_topics.NO_TOPIC_TITLE-->
+-				<li>   
+-				   {top_topics.NO_TOPIC_TITLE}
++    <div id="innertopics{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++        <ul class="media-list user-list">
++		{% for top_topics in loops.top_topics %}
++		{% if top_topics.NO_TOPIC_TITLE%}
++				<li class="media">   
++				   {{ top_topics.NO_TOPIC_TITLE }}
+ 				</li>
+-		<!-- ELSE -->
+-            <li>
+-               <!-- IF top_topics.S_UNREAD --><span class="label label-warning">{L_UNREAD}</span>&nbsp;<!-- ENDIF --><a class="title-head" href="{top_topics.U_TOPIC}" title="{{ top_topics.TOPIC_TITLE|striptags }}">{top_topics.TOPIC_TITLE}</a>
+-               <div>{top_topics.USERNAME_FULL}</div>
+-			   <div>{L_IN}{L_COLON}&nbsp;<a href="{top_topics.U_FORUM}" title="{top_topics.FORUM_NAME}">{top_topics.FORUM_NAME}</a></div>
+-			   <small class="date"><i class="fa fa-clock-o"></i>&nbsp;{top_topics.LAST_TOPIC_TIME}</small>
++		{% else %}
++            <li class="media">
++				<span class="media-left">
++					<img alt="" src="{{ top_topics.AVATAR }}" class="media-object img-circle">
++					{% if top_topics.S_UNREAD %}<span class="label label-warning">{{ lang('UNREAD') }}</span>&nbsp;{% endif %}
++				</span>
++				<span class="media-body">
++					<a class="title-head" href="{{ top_topics.U_TOPIC }}">{{ top_topics.TOPIC_TITLE }}</a>
++					<br />
++					{{ top_topics.USERNAME_FULL }}<br />
++					<span class="forum-time"><i class="fa fa-clock-o"></i>&nbsp;{{ top_topics.LAST_TOPIC_TIME }}</span>
++				</span>
++				<!-- <span>{{ lang('IN') }}{{ lang('COLON') }}&nbsp;<a href="{{ top_topics.U_FORUM }}" title="{{ top_topics.FORUM_NAME }}">{{ top_topics.FORUM_NAME }}</a></span><br /> -->
+ 			</li>
+-		<!-- ENDIF -->	
+-		<!-- END top_topics -->
++		{% endif %}	
++		{% endfor %}
+         </ul>
+     </div>
+ </div>
+ </div>
+-<!-- ENDIF -->
+\ No newline at end of file
++{% if PHPBB_COLLAPSIBLE_ENABLED %}
++<script>head.ready(function(){(function(){window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}=window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}||"";if(window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}!=""){$(".toggle-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }});$("#innertopics{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }})}$(".toggle-topics{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innertopics{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innertopics{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}=""}})})()});</script>
++{% endif %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/base.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/base.php"
+index c34809b37..7ecf97470 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/base.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/base.php"
+@@ -53,47 +53,49 @@ abstract class base implements type_interface
+  	/** 
+  	* {@inheritdoc} 
+  	*/ 
+-	protected function ignore_users()
++	protected function ignore_users($post_users_argument = '')
+ 	{
+-		// an array of user types we dont' bother with
++		// an array of user types we don't bother with
+ 		$ignore_users = $ignore_founders = array();
+ 		
+ 		$sql = 'SELECT group_id FROM ' . GROUPS_TABLE . ' WHERE group_name = "BOTS" AND group_type = ' . GROUP_SPECIAL;
+ 		$result = $this->db->sql_query($sql, 3600);
+ 		$bot_group = $this->db->sql_fetchfield('group_id');
+ 
+-		if (!$this->sidebar_settings['ignore_inactive_users'])
+-		{
++		if (!$this->sidebar_settings['ignore_inactive_users']) {
+ 			$ignore_users = array(USER_IGNORE, USER_INACTIVE);
+ 		}
+ 
+-		if (!$this->sidebar_settings['ignore_founder'])
+-		{
++		if (!$this->sidebar_settings['ignore_founder']) {
+ 			$ignore_founders = array(USER_FOUNDER);
+ 		}
+ 
+ 		$ignore_users = array_merge($ignore_users, $ignore_founders);
+ 
+ 		// Do we have anyone we want to ignore
+-		$sql_where = 'WHERE group_id <> ' . $bot_group . ' AND user_id <> ' . ANONYMOUS;
+-		if (sizeof($ignore_users))
+-		{
++		$sql_where = 'WHERE ';
++		
++		if ($post_users_argument !== '') {
++			$sql_where .= $post_users_argument . ' AND ';
++		}
++		
++		$sql_where .= 'group_id <> ' . $bot_group . ' AND user_id <> ' . ANONYMOUS;
++
++		if (sizeof($ignore_users)) {
+ 			$sql_where .= ' AND ' . $this->db->sql_in_set('user_type', $ignore_users, true);
+ 		}
+ 		
+-		if (!$this->sidebar_settings['ignore_admins_mods'])
+-		{
++		if (!$this->sidebar_settings['ignore_admins_mods']) {
+ 			// grab all admins
+ 			$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
+ 			$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : array();
+-	
+-			//grab all mods
+-			$mod_ary = $this->auth->acl_get_list(false,'m_', false);
++
++			// grab all mods
++			$mod_ary = $this->auth->acl_get_list(false, 'm_', false);
+ 			$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : array();
+ 			$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
+-			
+-			if (sizeof($admin_mod_array))
+-			{
++
++			if (sizeof($admin_mod_array)) {
+ 				$sql_where .= empty($sql_where) ? ' WHERE' : ' AND';
+ 				$sql_where .= ' ' . $this->db->sql_in_set('user_id', $admin_mod_array, true);
+ 			}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/bbpoints.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/bbpoints.php"
+index ed8e77de5..2fcd7a2d2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/bbpoints.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/bbpoints.php"
+@@ -74,11 +74,11 @@ class bbpoints extends \sitesplat\sidebar\types\type\base
+ 			// grab users
+ 			$sql = 'SELECT t1.user_id, SUM(points) as total, u.username, u.user_colour FROM ( 
+ 					SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $bbpoints_table . ' GROUP BY to_id
+-					UNION
++					UNION ALL
+ 					SELECT from_id AS user_id, SUM(-bbpoints) AS points FROM ' . $bbpoints_table . ' GROUP BY from_id
+-					UNION
++					UNION ALL
+ 					SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' GROUP BY topic_poster
+-					UNION 
++					UNION ALL
+ 					SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 GROUP BY poster_id) t1 
+ 					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = t1.user_id
+ 					' . $sql_where . '
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/donations.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/donations.php"
+index ccfe70b9d..a49978617 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/donations.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/donations.php"
+@@ -103,19 +103,20 @@ class donations extends \sitesplat\sidebar\types\type\base
+ 				FROM ' . $donations_table . ' d
+ 				LEFT JOIN ' . USERS_TABLE . " u ON u.user_id = d.user_id $sql_where $sql_and
+ 				AND d.payment_status = 'Completed'
++				AND d.payment_date >= UNIX_TIMESTAMP(DATE_SUB( CURDATE(), INTERVAL 1 MONTH)) 
+ 				ORDER BY d.payment_date DESC";
+ 			$result = $this->db->sql_query_limit($sql, $howmany);
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
+-			  $match = array();
+-			  $avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@',
++				$match = array();
++				$avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@',
+ 						  phpbb_get_user_avatar(
+ 							  array('avatar'			=> $row['user_avatar'], 
+ 									'avatar_type'		=> $row['user_avatar_type'], 
+ 									'avatar_width'	=> $row['user_avatar_width'], 
+ 									'avatar_height'	=> $row['user_avatar_height'])), $match) :
+ 									generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');
+-				
++									
+ 				if (count($match) > 1) {
+ 					$avatar = array_pop($match);
+ 					// fix an issue with BBrandom
+@@ -123,7 +124,7 @@ class donations extends \sitesplat\sidebar\types\type\base
+ 						$avatar = str_replace(['./../../', './../', './'], $board_url, $avatar);
+ 					}
+ 				}
+-
++				
+ 				$donations[$row['user_id']] = array(
+ 					'user_id'  	    => $row['user_id'],
+ 					'username'      => $row['username'],
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/hot_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/hot_topics.php"
+index d3536b258..3fe6da9dc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/hot_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/hot_topics.php"
+@@ -84,6 +84,7 @@ class hot_topics extends \sitesplat\sidebar\types\type\base
+ 				ORDER BY topic_last_post_time DESC';
+ 
+ 			$result = $this->db->sql_query_limit($sql, $howmany);
++
+ 			$forums = $ga_topic_ids = $topic_ids = array();
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
+@@ -109,7 +110,7 @@ class hot_topics extends \sitesplat\sidebar\types\type\base
+ 			{
+ 				// grab all posts that meet criteria and auths
+ 				$sql_array = array(
+-					'SELECT'	=> 'u.user_id, u.username, u.user_colour, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id,
++					'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id,
+ 									t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
+ 					'FROM'		=> array(TOPICS_TABLE => 't'),
+ 					'LEFT_JOIN'	=> array(
+@@ -140,19 +141,61 @@ class hot_topics extends \sitesplat\sidebar\types\type\base
+ 										$row['topic_last_post_id']);
+ 					$forum_name_url = append_sid("{$this->root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
+ 					$topic_title = censor_text($row['topic_title']);
+-					if (utf8_strlen($topic_title) >= 60)
+-					{
+-						$topic_title = (utf8_strlen($topic_title) > 60 + 3) ? utf8_substr($topic_title, 0, 60) . '...' : $topic_title;
+-					}
++					// can't truncate with bbemoji
++					// if (utf8_strlen($topic_title) >= 60)
++					// {
++						// $topic_title = (utf8_strlen($topic_title) > 60 + 3) ? utf8_substr($topic_title, 0, 60) . '...' : $topic_title;
++					// }
+ 					$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
+ 
++					/**
++					* Event to modify topic data before they are assigned
++					*
++					* @event sitesplat.bbsidebar.type.hot_topics_tpl_before
++					* @var	string	topic_id		Topic ID
++					* @var	string	forum_id		Forum ID
++					* @var	string	forum_name		Forum name
++					* @var	boolean	post_unread		Are there any posts unread?
++					* @var	string	view_topic_url	Topic URL
++					* @var	string	forum_name_url	Forum URL
++					* @var	string	topic_title		Topic title
++					* @var	boolean	is_guest		Is post author anonymous?
++					* @since 1.5.0
++					*/
++					$vars = array(
++						'topic_id',
++						'forum_id',
++						'forum_name',
++						'post_unread',
++						'view_topic_url',
++						'forum_name_url',
++						'topic_title',
++						'is_guest',
++					);
++					extract($phpbb_dispatcher->trigger_event('sitesplat.bbsidebar.type.hot_topics_tpl_before', compact($vars)));
++					
++					$board_url = generate_board_url() . '/';
++					$match = array();
++					$avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@',
++							  phpbb_get_user_avatar(
++								  array('avatar'			=> $row['user_avatar'], 
++								        'user_id'			=> $row['user_id'],
++										'avatar_type'		=> $row['user_avatar_type'], 
++										'avatar_width'		=> $row['user_avatar_width'], 
++										'avatar_height'		=> $row['user_avatar_height'])), $match) :
++										generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');
++
++					$username_string = ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . 
++												get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : 
++												$this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
++
+ 					$tpl_ary = array(
+ 						'U_TOPIC'			=> $view_topic_url,
+ 						'U_FORUM'			=> $forum_name_url,
+ 						'S_UNREAD'			=> ($post_unread) ? true : false,
+-						'USERNAME_FULL'		=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . 
+-												get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : 
+-												$this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
++						//'AVATAR'			=> ((sizeof($match) > 1) ? str_replace('./../../', './', array_pop($match)) : $avatar),
++						'AVATAR'			=> ((sizeof($match) > 1) ? strtr(array_pop($match), [ 'gallery/../random' => 'random', './../../' => $board_url,  './../' => $board_url, './' => $board_url ]) : $avatar),
++						'USERNAME_FULL'		=> $username_string,
+ 						'LAST_TOPIC_TIME'	=> $this->user->format_date($row['topic_last_post_time']),
+ 						'TOPIC_TITLE' 		=> $topic_title,
+ 						'TOPIC_TITLE_NO_HTML'	=> $topic_title,
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/last_badges.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/last_badges.php"
+index f9fc70bb3..ff73e1dd2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/last_badges.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/last_badges.php"
+@@ -64,7 +64,7 @@ class last_badges extends \sitesplat\sidebar\types\type\base
+ 		$howmany = $this->howmany();
+ 		$sql_where = str_replace('user_id', 'b.user_id', $this->ignore_users());
+ 
+-		$sql_and = !empty($sql_where) ? ' AND user_inactive_reason = 0' : ' WHERE user_inactive_reason = 0';
++		$sql_and = !empty($sql_where) ? ' AND user_posts > 1 AND user_inactive_reason = 0' : ' WHERE user_posts > 1 AND user_inactive_reason = 0';
+ 		// latest users
+ 		if (($newest_users = $this->cache->get('_sidebar_last_badges')) === false)
+ 		{
+@@ -77,8 +77,8 @@ class last_badges extends \sitesplat\sidebar\types\type\base
+ 			$sql = 'SELECT b.user_id, r.rule_name, u.username, u.user_colour, b.date, ba.badge 
+ 				FROM ' . $badge_event_table . ' b
+ 				LEFT JOIN ' . $badge_rules_table . ' r ON r.rule_id = b.rule_id
+-				LEFT JOIN ' . $badge_badges_table . ' ba ON ba.badge_id = r.badge_id 
+-				LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = b.user_id
++				INNER JOIN ' . $badge_badges_table . ' ba ON ba.badge_id = r.badge_id 
++				INNER JOIN ' . USERS_TABLE . ' u ON u.user_id = b.user_id
+ 				' . $sql_where . '
+ 				' . $sql_and . '
+ 				ORDER BY b.date DESC';
+@@ -97,8 +97,8 @@ class last_badges extends \sitesplat\sidebar\types\type\base
+ 			}
+ 			$this->db->sql_freeresult($result);
+ 
+-			// cache this data for 5 minutes, this improves performance
+-			$this->cache->put('_sidebar_last_badges', $newest_users, 300);
++			// cache this data for 30 minutes, this improves performance
++			$this->cache->put('_sidebar_last_badges', $newest_users, 1800);
+ 		}
+ 
+ 		foreach ($newest_users as $row)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/last_members.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/last_members.php"
+index 1f54d2a51..bc13e1f82 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/last_members.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/last_members.php"
+@@ -87,7 +87,7 @@ class last_members extends \sitesplat\sidebar\types\type\base
+ 						'avatar_width'     => $row['user_avatar_width'], 
+ 						'avatar_height'    => $row['user_avatar_height'])), $match) :
+ 						generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');
+-
++						
+ 				if (count($match) > 1) {
+ 					$avatar = array_pop($match);
+ 					// fix an issue with BBrandom
+@@ -98,7 +98,7 @@ class last_members extends \sitesplat\sidebar\types\type\base
+ 				}
+ 
+ 				$newest_users[$row['user_id']] = array(
+-				//	'avatar'     			=> ((sizeof($match) > 1) ? str_replace('./../../', './', array_pop($match)) : $avatar),
++					//	'avatar'     			=> ((sizeof($match) > 1) ? str_replace('./../../', './', array_pop($match)) : $avatar),
+ 					'avatar'				=> $avatar,
+ 					'user_id'				=> $row['user_id'],
+ 					'username'				=> $row['username'],
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/staff.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/staff.php"
+index ca90af0d2..bb928ae03 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/staff.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/staff.php"
+@@ -72,7 +72,8 @@ class staff extends \sitesplat\sidebar\types\type\base
+ 			$staff_ids = $staff_online = [];
+ 			$sql = 'SELECT u.user_id
+ 					FROM ' . GROUPS_TABLE . ' g, ' . USER_GROUP_TABLE . " u
+-					WHERE LOWER(g.group_name) LIKE '%staff%' AND u.group_id = g.group_id";
++					WHERE u.group_id = g.group_id AND u.group_id = 15";
++					// WHERE LOWER(g.group_name) LIKE '%staff%' AND u.group_id = g.group_id";
+ 			$result = $this->db->sql_query($sql);
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
+@@ -159,12 +160,14 @@ class staff extends \sitesplat\sidebar\types\type\base
+ 		{
+ 			foreach ($staff_online as $row)
+ 			{
++				$last_visit = $this->user->format_date($row['last_visit'], '|d M Y|, H:i');
++				$last_active = (!empty($row['last_active'])) ? $this->user->format_date($row['last_active'], '|d M Y|, H:i') : $this->user->lang['STAFF_UNKNOWN'];
+ 				$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) :
+ 									get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
+ 
+ 				$this->template->assign_block_vars('staff',array(
+ 					'S_SEARCH_ACTION'	=> append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
+-					'TIME'	 			=> ($row['last_visit']) ? $this->user->format_date($row['last_visit'], '|d M Y|, H:i') : $this->user->lang['STAFF_UNKNOWN'],
++					'TIME'	 			=> (!empty($row['last_visit'])) ? $last_visit : $last_active,
+ 					'USERNAME_FULL'		=> $username_string,
+ 					'AVATAR'			=> $row['avatar']
+ 				));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/top_posters.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/top_posters.php"
+index a8f3c774b..07b5856aa 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/top_posters.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/top_posters.php"
+@@ -61,10 +61,11 @@ class top_posters extends \sitesplat\sidebar\types\type\base
+ 	public function outputblock()
+ 	{
+ 		$howmany = $this->howmany();
+-		$sql_where = $this->ignore_users();
++		$sql_where = $this->ignore_users('user_posts > 1');
++		$sql_where_improve = $this->ignore_users('post_counts.user_posts > 1');
+ 
+ 		//set two variables for the sql
+-		$sql_and = $sql_other = '';
++		$sql_and = $sql_other = $sql_other_improve = '';
+ 
+ 		if (($user_posts = $this->cache->get('_sidebar_posters')) === false)
+ 		{
+@@ -89,17 +90,19 @@ class top_posters extends \sitesplat\sidebar\types\type\base
+ 				}
+ 			}
+ 			$sql_other = (empty($sql_and) && empty($sql_where)) ? ' WHERE' : ' AND';
+-			$sql_other .=  ' user_posts <> 0';
++			$sql_other .= empty($sql_where) ? ' user_posts <> 0' : ' 1=1';
++			$sql_other_improve = (empty($sql_and) && empty($sql_where)) ? ' WHERE' : ' AND';
++			$sql_other_improve .= empty($sql_where_improve) ? ' post_counts.user_posts <> 0' : ' 1=1';
+ 			$user_posts[0] = $user_posts[1] = $user_posts[2] = array();
+ 
+ 		//  damn phpbb url rewrite and broken driver
+ 		//	$board_url = generate_board_url();
+ 			$board_url = generate_board_url() . '/';
+ 			
+-			// do the main sql query		
++			// do the main sql query
+ 			$sql = 'SELECT user_id, username, user_colour, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height, user_posts
+ 				FROM ' . USERS_TABLE . '
+-				 ' . $sql_where . ' ' . $sql_and . '
++				' . $sql_where . ' ' . $sql_and . '
+ 				' . $sql_other . '
+ 				ORDER BY user_posts DESC';
+ 
+@@ -115,7 +118,7 @@ class top_posters extends \sitesplat\sidebar\types\type\base
+ 										'avatar_width'	=> $row['user_avatar_width'], 
+ 										'avatar_height'	=> $row['user_avatar_height'])), $match) :
+ 										generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');
+-				
++										
+ 				if (count($match) > 1) {
+ 					$avatar = array_pop($match);
+ 					// fix an issue with BBrandom
+@@ -123,7 +126,7 @@ class top_posters extends \sitesplat\sidebar\types\type\base
+ 						$avatar = str_replace(['./../../', './../', './'], $board_url, $avatar);
+ 					}
+ 				}
+-
++				
+ 				$user_posts[0][$row['user_id']] = array(
+ 					'user_id'      => $row['user_id'],
+ 					'username'      => $row['username'],
+@@ -137,14 +140,24 @@ class top_posters extends \sitesplat\sidebar\types\type\base
+ 
+ 
+ 			// do the main sql query
+-			$sql = 'SELECT user_id, username, user_colour, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height, COUNT(p.post_id) AS user_posts
+-					FROM ' . POSTS_TABLE . ' p
+-					LEFT JOIN ' . USERS_TABLE . ' ON user_id = p.poster_id
+-					' . $sql_where . ' ' . $sql_and . '
+-					' . $sql_other . '
+-					AND p.post_time > ' . (time() - 86400 ) . '
+-					GROUP BY p.poster_id
+-					ORDER BY user_posts DESC';
++			$timestamp = time() - 86400;
++			$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, post_counts.user_posts
++					FROM ' . USERS_TABLE . ' u
++					LEFT JOIN (
++						SELECT
++							poster_id,
++							COUNT(post_id) AS user_posts
++						FROM
++							' . POSTS_TABLE . '
++						WHERE
++							post_time > ' . $timestamp . '
++						GROUP BY
++							poster_id
++					) AS post_counts ON u.user_id = post_counts.poster_id 
++					' . $sql_where_improve . ' ' . $sql_and . '
++					' . $sql_other_improve . '
++					AND post_counts.user_posts IS NOT NULL
++					ORDER BY post_counts.user_posts DESC';
+ 			$result = $this->db->sql_query_limit($sql, $howmany);
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
+@@ -170,14 +183,24 @@ class top_posters extends \sitesplat\sidebar\types\type\base
+ 
+ 
+ 			// do the main sql query
+-			$sql = 'SELECT user_id, username, user_colour, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height, COUNT(p.post_id) AS user_posts
+-					FROM ' . POSTS_TABLE . ' p
+-					LEFT JOIN ' . USERS_TABLE . ' ON user_id = p.poster_id
+-					' . $sql_where . ' ' . $sql_and . '
+-					' . $sql_other . '
+-					AND p.post_time > ' . (time() - (86400 * 7)) . '
+-					GROUP BY p.poster_id
+-					ORDER BY user_posts DESC';
++			$timestamp = time() - (86400 * 7);
++			$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, post_counts.user_posts
++					FROM ' . USERS_TABLE . ' u
++					LEFT JOIN (
++						SELECT
++							poster_id,
++							COUNT(post_id) AS user_posts
++						FROM
++							' . POSTS_TABLE . '
++						WHERE
++							post_time > ' . $timestamp . '
++						GROUP BY
++							poster_id
++					) AS post_counts ON u.user_id = post_counts.poster_id
++					' . $sql_where_improve . ' ' . $sql_and . '
++					' . $sql_other_improve . '
++					AND IFNULL(post_counts.user_posts, 0) <> 0
++					ORDER BY post_counts.user_posts DESC';
+ 			$result = $this->db->sql_query_limit($sql, $howmany);
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
+@@ -195,14 +218,15 @@ class top_posters extends \sitesplat\sidebar\types\type\base
+ 					'user_id'      => $row['user_id'],
+ 					'username'      => $row['username'],
+ 					'user_colour'   => $row['user_colour'],
+-					'avatar'		=> (sizeof($match) > 1) ? array_pop($match) : $avatar,
++					//'avatar'		=> (sizeof($match) > 1) ? array_pop($match) : $avatar,
++					'avatar'		=> ((sizeof($match) > 1) ? strtr(array_pop($match), [ 'gallery/../random' => 'random', './../../' => $board_url,  './../' => $board_url, './' => $board_url ]) : $avatar),
+ 					'user_posts'    => $row['user_posts'],
+ 				);
+ 			}
+ 			$this->db->sql_freeresult($result);
+ 
+-			// cache this data for 5 minutes, this improves performance
+-			$this->cache->put('_sidebar_posters', $user_posts, 300);
++			// cache this data for 30 minutes, this improves performance
++			$this->cache->put('_sidebar_posters', $user_posts, 1800);
+ 		}
+ 
+ 		foreach ($user_posts[0] as $row)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/top_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/top_topics.php"
+index 52949ef4c..112cf66d9 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/top_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/top_topics.php"
+@@ -182,7 +182,7 @@ class top_topics extends \sitesplat\sidebar\types\type\base
+ 										'avatar_width'	=> $row['user_avatar_width'], 
+ 										'avatar_height'	=> $row['user_avatar_height'])), $match) :
+ 										generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');
+-				
++
+ 					$username_string = ($this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . 
+ 										get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : 
+ 										$this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']);
diff --git "[FORUM_EXT]/sitesplat\\sidebar/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\sidebar/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\sidebar/diff_nospace.tmp"
@@ -0,0 +1,3687 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
+index 81c13f5b4..3a96f4580 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
+@@ -1,143 +1,143 @@
+-<h3>{L_ACP_SIDEBAR_TITLE}</h3>
++<h3>{{ lang('ACP_SIDEBAR_TITLE') }}</h3>
+   <div class="clearfix description-ext">
+-	<h1 class="ExtensionName"><!-- IF META_DISPLAY_NAME -->{META_DISPLAY_NAME} - <!-- ENDIF -->{L_EXT_DETAILS}</h1>
+-	<!-- IF S_VERSIONCHECK -->
+-	<!-- ELSE IF S_VERSIONCHECK_STATUS == 0 -->
++	<h1 class="ExtensionName">{% if META_DISPLAY_NAME %}{{ META_DISPLAY_NAME }} - {% endif %}{{ lang('EXT_DETAILS') }}</h1>
++	{% if S_VERSIONCHECK %}
++	{% elseif S_VERSIONCHECK_STATUS == 0 %}
+ 	<div class="errorbox notice">
+-		<p>{L_VERSIONCHECK_FAIL}</p>
+-		<p>{VERSIONCHECK_FAIL_REASON}</p>
+-		<p><a href="{U_VERSIONCHECK_FORCE}">{L_VERSIONCHECK_FORCE_UPDATE}</a></p>
++		<p>{{ lang('VERSIONCHECK_FAIL') }}</p>
++		<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
++		<p><a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
+ 	</div>
+-	<!-- ELSE IF S_VERSIONCHECK_STATUS == 1 -->
++	{% elseif S_VERSIONCHECK_STATUS == 1 %}
+ 	<div class="errorbox notice">
+-		<p>{VERSIONCHECK_FAIL_REASON}</p>
++		<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
+ 	</div>
+-	<!-- ENDIF -->
++	{% endif %}
+ 	
+-	<!-- IF S_VERSIONCHECK && not S_UP_TO_DATE -->
++	{% if S_VERSIONCHECK && not S_UP_TO_DATE %}
+ 	<div class="alert alert-update">
+ 	  
+       <div class="row">	
+       <div class="col-md-12">
+ 	   	
+ 	  <div class="col-md-6">	
+-		<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
+-		    <span class="description_name">{L_CURRENT_VERSION}{L_COLON}</span>
++		<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
++		    <span class="description_name">{{ lang('CURRENT_VERSION') }}{{ lang('COLON') }}</span>
+ 			<div class="extension_latest_version_wrapper">
+-			<strong class="extension_latest_version label label-warning">{META_VERSION}</strong>
++			<strong class="extension_latest_version label label-warning">{{ META_VERSION }}</strong>
+ 			</div>
+ 	    </div>
+ 	  </div>
+ 	  
+ 	  <div class="col-md-6">	
+-		<!-- BEGIN updates_available -->
+-			<span class="requirements_title">{L_LATEST_VERSION}{L_COLON}</span>
++		{% for updates_available in loops.updates_available %}
++			<span class="requirements_title">{{ lang('LATEST_VERSION') }}{{ lang('COLON') }}</span>
+ 			<div class="extension_latest_version_wrapper">
+-				<strong class="extension_latest_version label label-success">{updates_available.current}</strong>
+-				<!-- IF updates_available.download-->
+-				<a href="{updates_available.download}" class="extension_author_link" title="{L_DOWNLOAD_LATEST}"><i class="fa fa-download"></i></a>
+-				<!-- ENDIF -->
+-				<!-- IF updates_available.announcement -->
+-				<a href="{updates_available.announcement}" class="extension_author_link" title="{L_ANNOUNCEMENT_TOPIC}"><i class="fa fa-bullhorn"></i></a>
+-				<!-- ENDIF -->
++				<strong class="extension_latest_version label label-success">{{ updates_available.current }}</strong>
++				{% if updates_available.download%}
++				<a href="{{ updates_available.download }}" class="extension_author_link" title="{{ lang('DOWNLOAD_LATEST') }}"><i class="fa fa-download"></i></a>
++				{% endif %}
++				{% if updates_available.announcement %}
++				<a href="{{ updates_available.announcement }}" class="extension_author_link" title="{{ lang('ANNOUNCEMENT_TOPIC') }}"><i class="fa fa-bullhorn"></i></a>
++				{% endif %}
+ 			</div>
+-		<!-- END updates_available -->
++		{% endfor %}
+ 	   </div>	
+ 	  
+ 	  </div>
+      </div>	  
+ 		
+ 	</div>
+-	<!-- ENDIF -->
++	{% endif %}
+ 
+ 	<div class="description_div">
+ 		<div>
+ 			<div>
+ 				<p class="description_list">
+-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_DESCRIPTION_PAGE}</span><br />
+-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_1}</span><br />
+-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_2}</span><br />
+-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_3}</span><br />
+-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_4}</span><br />
+-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_5}</span><br />
+-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_6}</span><br />
++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_DESCRIPTION_PAGE') }}</span><br />
++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_1') }}</span><br />
++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_2') }}</span><br />
++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_3') }}</span><br />
++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_4') }}</span><br />
++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_5') }}</span><br />
++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_6') }}</span><br />
+ 				</p>
+ 			</div>
+ 		</div>
+ 	</div>
+ 	<div class="description_bubble big_bubble">
+-		<span class="description_name">{L_CLEAN_NAME}{L_COLON}</span>
+-		<strong class="description_value" id="meta_name">{META_NAME}</strong>
++		<span class="description_name">{{ lang('CLEAN_NAME') }}{{ lang('COLON') }}</span>
++		<strong class="description_value" id="meta_name">{{ META_NAME }}</strong>
+ 	</div>
+-	<!-- IF S_VERSIONCHECK && S_UP_TO_DATE -->
+-	<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
+-		<span class="description_name">{L_VERSION}{L_COLON}</span>
+-		<span class="description_value description_value_ok" id="meta_version">{META_VERSION}</span>
++	{% if S_VERSIONCHECK && S_UP_TO_DATE %}
++	<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
++		<span class="description_value description_value_ok" id="meta_version">{{ META_VERSION }}</span>
+ 	</div>
+-	<!-- ELSE IF S_VERSIONCHECK && not S_UP_TO_DATE -->
+-	<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
+-		<span class="description_name">{L_VERSION}{L_COLON}</span>
+-		<span class="description_value description_value_old" id="meta_version">{META_VERSION}</span>
++	{% elseif S_VERSIONCHECK && not S_UP_TO_DATE %}
++	<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
++		<span class="description_value description_value_old" id="meta_version">{{ META_VERSION }}</span>
+ 	</div>
+-	<!-- ELSE -->
++	{% else %}
+ 	<div class="description_bubble small_bubble">
+-		<span class="description_name">{L_VERSION}{L_COLON}</span>
+-		<span class="description_value" id="meta_version">{META_VERSION}</span>
++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
++		<span class="description_value" id="meta_version">{{ META_VERSION }}</span>
+ 	</div>
+-	<!-- ENDIF -->
+-	<!-- IF META_HOMEPAGE -->
++	{% endif %}
++	{% if META_HOMEPAGE %}
+ 	<div class="description_bubble big_bubble">
+-		<span class="description_name">{L_HOMEPAGE}{L_COLON}</span>
+-		<strong class="description_value" id="meta_homepage"><a href="{META_HOMEPAGE}"><i class="fa fa-globe"></i> {META_HOMEPAGE}</a></strong>
++		<span class="description_name">{{ lang('HOMEPAGE') }}{{ lang('COLON') }}</span>
++		<strong class="description_value" id="meta_homepage"><a href="{{ META_HOMEPAGE }}"><i class="fa fa-globe"></i> {{ META_HOMEPAGE }}</a></strong>
+ 	</div>
+-	<!-- ENDIF -->
+-	<!-- IF META_TIME -->
++	{% endif %}
++	{% if META_TIME %}
+ 	<div class="description_bubble small_bubble">
+-		<span class="description_name">{L_TIME}{L_COLON}</span>
+-		<span class="description_value" id="meta_time">{META_TIME}</span>
++		<span class="description_name">{{ lang('TIME') }}{{ lang('COLON') }}</span>
++		<span class="description_value" id="meta_time">{{ META_TIME }}</span>
+ 	</div>
+-	<!-- ENDIF -->
++	{% endif %}
+ 	<div class="description_bubble small_bubble">
+-		<span class="description_name">{L_LICENSE}{L_COLON}</span>
+-		<span class="description_value" id="meta_license" style="padding:0 15px;">{L_LICENSE_INFO}</span>
++		<span class="description_name">{{ lang('LICENSE') }}{{ lang('COLON') }}</span>
++		<span class="description_value" id="meta_license" style="padding:0 15px;">{{ lang('LICENSE_INFO') }}</span>
+ 	</div>
+ 
+-	<!-- IF META_REQUIRE_PHPBB || META_REQUIRE_PHP -->
++	{% if META_REQUIRE_PHPBB || META_REQUIRE_PHP %}
+ 	<div>
+-		<span class="requirements_title">{L_REQUIREMENTS}{L_COLON}</span>
+-		<!-- IF META_REQUIRE_PHPBB -->
++		<span class="requirements_title">{{ lang('REQUIREMENTS') }}{{ lang('COLON') }}</span>
++		{% if META_REQUIRE_PHPBB %}
+ 		<div class="requirements_bubble">
+-			<span class="requirements_name">{L_PHPBB_VERSION}{L_COLON}</span>
+-			<span class="requirements_value<!-- IF META_REQUIRE_PHPBB_FAIL --> requirements_value_not_met<!-- ENDIF -->" id="require_phpbb">{META_REQUIRE_PHPBB}</span>
++			<span class="requirements_name">{{ lang('PHPBB_VERSION') }}{{ lang('COLON') }}</span>
++			<span class="requirements_value{% if META_REQUIRE_PHPBB_FAIL %} requirements_value_not_met{% endif %}" id="require_phpbb">{{ META_REQUIRE_PHPBB }}</span>
+ 		</div>
+-		<!-- ENDIF -->
+-		<!-- IF META_REQUIRE_PHP -->
++		{% endif %}
++		{% if META_REQUIRE_PHP %}
+ 		<div class="requirements_bubble">
+-			<span class="requirements_name">{L_PHP_VERSION}{L_COLON}</span>
+-			<span class="requirements_value<!-- IF META_REQUIRE_PHP_FAIL --> requirements_value_not_met<!-- ENDIF -->" id="require_php">{META_REQUIRE_PHP}</span>
++			<span class="requirements_name">{{ lang('PHP_VERSION') }}{{ lang('COLON') }}</span>
++			<span class="requirements_value{% if META_REQUIRE_PHP_FAIL %} requirements_value_not_met{% endif %}" id="require_php">{{ META_REQUIRE_PHP }}</span>
+ 		</div>
+-		<!-- ENDIF -->
++		{% endif %}
+ 	</div>
+-	<!-- ENDIF -->
++	{% endif %}
+ 
+ 	<div>
+-		<span class="requirements_title">{L_EXTENSION_DEVELOPER}{L_COLON}</span>
+-		<!-- BEGIN meta_authors -->
++		<span class="requirements_title">{{ lang('EXTENSION_DEVELOPER') }}{{ lang('COLON') }}</span>
++		{% for meta_authors in loops.meta_authors %}
+ 		<div class="extension_author">
+-			<strong class="extension_author_name">{meta_authors.AUTHOR_NAME}</strong>
+-			<!-- IF meta_authors.AUTHOR_EMAIL -->
+-			<a href="mailto:{meta_authors.AUTHOR_EMAIL}" title="{L_AUTHOR_EMAIL}" class="extension_author_link"><i class="fa fa-envelope"></i></a>
+-			<!-- ENDIF -->
+-			<!-- IF meta_authors.AUTHOR_HOMEPAGE -->
+-			<a href="{meta_authors.AUTHOR_HOMEPAGE}" title="{L_AUTHOR_HOMEPAGE}" class="extension_author_link"><i class="fa fa-globe"></i></a>
+-			<!-- ENDIF -->
++			<strong class="extension_author_name">{{ meta_authors.AUTHOR_NAME }}</strong>
++			{% if meta_authors.AUTHOR_EMAIL %}
++			<a href="mailto:{{ meta_authors.AUTHOR_EMAIL }}" title="{{ lang('AUTHOR_EMAIL') }}" class="extension_author_link"><i class="fa fa-envelope"></i></a>
++			{% endif %}
++			{% if meta_authors.AUTHOR_HOMEPAGE %}
++			<a href="{{ meta_authors.AUTHOR_HOMEPAGE }}" title="{{ lang('AUTHOR_HOMEPAGE') }}" class="extension_author_link"><i class="fa fa-globe"></i></a>
++			{% endif %}
+ 		</div>
+-		<!-- END meta_authors -->
++		{% endfor %}
+ 	</div>
+ 	
+ 	<div class="clearfix">
+ 	<br/>
+-	<button type="button" class="btn md-close btn-block" data-dismiss="modal">{L_ACP_SIDEBAR_NOTICE_CLOSE}</button>
++	<button type="button" class="btn md-close btn-block" data-dismiss="modal">{{ lang('ACP_SIDEBAR_NOTICE_CLOSE') }}</button>
+ 	</div>
+ 	
+ </div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
+index 1b366fc15..b68eb0fe7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
+@@ -1,24 +1,24 @@
+-<!-- IF S_ALLOW_CDN -->
+-<!-- INCLUDECSS //maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css -->
+-<!-- ELSE -->
+-<!-- INCLUDECSS {ROOT_PATH}ext/sitesplat/sidebar/vendor/font-awesome/css/font-awesome.min.css -->
+-<!-- ENDIF -->
+-<!-- INCLUDECSS {ROOT_PATH}ext/sitesplat/sidebar/vendor/bootstrap/css/bootstrap_modified.css -->
+-<!-- INCLUDECSS css/sidebar.css -->
+-<!-- INCLUDECSS css/component.css -->
++{% if S_ALLOW_CDN %}
++{% INCLUDECSS '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' %}
++{% else %}
++{% INCLUDECSS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/font-awesome/css/font-awesome.min.css' %}
++{% endif %}
++{% INCLUDECSS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/bootstrap/css/bootstrap_modified.css' %}
++{% INCLUDECSS 'css/sidebar.css' %}
++{% INCLUDECSS 'css/component.css' %}
+ 
+-<!-- INCLUDE overall_header.html -->
++{% INCLUDE 'overall_header.html' %}
+ 
+-<h1>{L_ACP_SIDEBAR_TITLE} <a href="javascript:void(0)" class="md-trigger" data-remote="{U_ACTION}&amp;action=details" data-toggle="modal" data-target="#myModal"><span class="label label-success">{L_ACP_SIDEBAR_VERSION} <i class="fa fa-info-circle"></i></span></a></h1>
++<h1>{{ lang('ACP_SIDEBAR_TITLE') }} <a href="javascript:void(0)" class="md-trigger" data-remote="{{ U_ACTION }}&amp;action=details" data-toggle="modal" data-target="#myModal"><span class="label label-success">{{ lang('ACP_SIDEBAR_VERSION') }} <i class="fa fa-info-circle"></i></span></a></h1>
+ 
+ 		<!-- Modal -->
+ 		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
+ 		  <div class="modal-dialog" role="document">
+ 			<div class="modal-content md-content">
+-			  <h3><i class="icon-bbreact-emo-beer" style="margin-right:20px;"></i> {L_ACP_SIDEBAR_TITLE}</h3>
++			  <h3><i class="icon-bbreact-emo-beer" style="margin-right:20px;"></i> {{ lang('ACP_SIDEBAR_TITLE') }}</h3>
+ 			  <div class="modal-body">
+ 			   <div class="panel-body">
+-				<div class="loader">{L_ACP_LOADING}</div>
++				<div class="loader">{{ lang('ACP_LOADING') }}</div>
+ 			   </div>
+ 			  <div class="modal-footer">
+ 			  </div>
+@@ -28,37 +28,37 @@
+ 		</div>
+ 
+ 
+-<p>{L_AD_SIDEBAR_EXPLAIN}</p>
++<p>{{ lang('AD_SIDEBAR_EXPLAIN') }}</p>
+ 
+-<!-- IF S_NOTICE_LIKEDD or S_NOTICE_BBREACTION or S_NOTICE_BBDONATION or S_NOTICE_BBMEMBERSHIP or S_NOTICE_BADGE or S_NOTICE_BBPOINTS or S_NOTICE_NEWSLETTER -->
++{% if S_NOTICE_LIKEDD or S_NOTICE_BBREACTION or S_NOTICE_BBDONATION or S_NOTICE_BBMEMBERSHIP or S_NOTICE_BADGE or S_NOTICE_BBPOINTS or S_NOTICE_NEWSLETTER %}
+ <div id="sidbar_notice" class="errorbox notice">
+-	<a href="{U_BADGE_NOTICE_CLOSE}" data-ajax="close_notice" data-overlay="false" class="close clearfix" title="{L_ACP_SIDEBAR_NOTICE_CLOSE}"></a>
++	<a href="{{ U_BADGE_NOTICE_CLOSE }}" data-ajax="close_notice" data-overlay="false" class="close clearfix" title="{{ lang('ACP_SIDEBAR_NOTICE_CLOSE') }}"></a>
+ 	<p>
+-	 <!-- IF S_NOTICE_LIKEDD -->{S_NOTICE_LIKEDD}<br /><!-- ENDIF -->
+-	 <!-- IF S_NOTICE_BBREACTION -->{S_NOTICE_BBREACTION}<br /><!-- ENDIF -->
+-	 <!-- IF S_NOTICE_BBDONATION -->{S_NOTICE_BBDONATION}<br /><!-- ENDIF -->
+-	 <!-- IF S_NOTICE_BBMEMBERSHIP -->{S_NOTICE_BBMEMBERSHIP}<br /><!-- ENDIF -->
+-	 <!-- IF S_NOTICE_BADGE -->{S_NOTICE_BADGE}<br /><!-- ENDIF -->
+-	 <!-- IF S_NOTICE_BBPOINTS -->{S_NOTICE_BBPOINTS}<br /><!-- ENDIF -->
+-	 <!-- IF S_NOTICE_NEWSLETTER -->{S_NOTICE_NEWSLETTER}<br /><!-- ENDIF -->
+-	  <!-- IF S_NOTICE_BBDOWNLOAD -->{S_NOTICE_BBDOWNLOAD}<!-- ENDIF -->
++	 {% if S_NOTICE_LIKEDD %}{{ S_NOTICE_LIKEDD }}<br />{% endif %}
++	 {% if S_NOTICE_BBREACTION %}{{ S_NOTICE_BBREACTION }}<br />{% endif %}
++	 {% if S_NOTICE_BBDONATION %}{{ S_NOTICE_BBDONATION }}<br />{% endif %}
++	 {% if S_NOTICE_BBMEMBERSHIP %}{{ S_NOTICE_BBMEMBERSHIP }}<br />{% endif %}
++	 {% if S_NOTICE_BADGE %}{{ S_NOTICE_BADGE }}<br />{% endif %}
++	 {% if S_NOTICE_BBPOINTS %}{{ S_NOTICE_BBPOINTS }}<br />{% endif %}
++	 {% if S_NOTICE_NEWSLETTER %}{{ S_NOTICE_NEWSLETTER }}<br />{% endif %}
++	  {% if S_NOTICE_BBDOWNLOAD %}{{ S_NOTICE_BBDOWNLOAD }}{% endif %}
+ 	</p>
+ </div>
+-<!-- ENDIF -->
++{% endif %}
+ 
+ 
+-<form id="acp_sidebar" method="post" action="{U_ACTION}">
++<form id="acp_sidebar" method="post" action="{{ U_ACTION }}">
+ 	<fieldset>
+-		<legend>{L_ACP_SIDEBAR_OPTIONS}</legend>
++		<legend>{{ lang('ACP_SIDEBAR_OPTIONS') }}</legend>
+ 		<div class="sidebar-wrapper">
+ 		<style>
+ 			#sidebar-nav {
+-				width:<!-- IF SIDEBAR_WIDTH -->50<!-- ELSE -->30<!-- ENDIF -->px;
+-				float:<!-- IF SIDEBAR_TYPE -->right<!-- ELSE -->left<!-- ENDIF -->;
++				width:{% if SIDEBAR_WIDTH %}50{% else %}30{% endif %}px;
++				float:{% if SIDEBAR_TYPE %}right{% else %}left{% endif %};
+ 			}
+ 			#sidebar-section {
+-				width:<!-- IF SIDEBAR_WIDTH -->200<!-- ELSE -->220<!-- ENDIF -->px;
+-				float:<!-- IF SIDEBAR_TYPE -->left<!-- ELSE -->right<!-- ENDIF -->;
++				width:{% if SIDEBAR_WIDTH %}200{% else %}220{% endif %}px;
++				float:{% if SIDEBAR_TYPE %}left{% else %}right{% endif %};
+ 			}
+ 			</style> 
+ 			<div class="browser-window">
+@@ -70,7 +70,7 @@
+ 			  </div>
+ 			  <div class="dev-tools">
+ 			  <div class="bar">
+-				<div class="dev-bar-content">{L_SITESPLAT_COM}</div>
++				<div class="dev-bar-content">{{ lang('SITESPLAT_COM') }}</div>
+ 				<div class="close-x">X</div>
+ 				<div class="clear"></div>
+ 			  </div>
+@@ -79,19 +79,19 @@
+ 			<div class="content">
+ 			
+ 			<div class="inner-browser">
+-			<div id="sidebar-header">{L_FLATBOOTS}</div>
++			<div id="sidebar-header">{{ lang('FLATBOOTS') }}</div>
+ 			
+-			<div id="sidebar-nav">{L_ONE_S}<br />{L_ONE_I}<br />{L_ONE_D}<br />{L_ONE_E}<br />{L_ONE_B}<br />{L_ONE_A}<br />{L_ONE_R}</div>
++			<div id="sidebar-nav">{{ lang('ONE_S') }}<br />{{ lang('ONE_I') }}<br />{{ lang('ONE_D') }}<br />{{ lang('ONE_E') }}<br />{{ lang('ONE_B') }}<br />{{ lang('ONE_A') }}<br />{{ lang('ONE_R') }}</div>
+ 			
+ 			<div id="sidebar-section">
+ 			<p class="forum-wrapper">
+-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
+-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
+-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
+ 			</p>
+ 			</div>
+ 			
+-			<div id="sidebar-footer">{L_SITESPLAT_COPY}</div>
++			<div id="sidebar-footer">{{ lang('SITESPLAT_COPY') }}</div>
+ 			</div>
+ 			
+ 			</div>
+@@ -102,11 +102,11 @@
+ 
+ 		<div style="float:left;width:80%;">
+ 		<dl>
+-			<dt><label id="type" for="sidebartype">{L_ACP_SIDEBAR_TYPE}{L_COLON}</label><br /> {L_ACP_SIDEBAR_TYPE_EXPLAIN}</dt>
++			<dt><label id="type" for="sidebartype">{{ lang('ACP_SIDEBAR_TYPE') }}{{ lang('COLON') }}</label><br /> {{ lang('ACP_SIDEBAR_TYPE_EXPLAIN') }}</dt>
+ 			<dd>
+ 
+ 				    <div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebartype" name="type"{SIDEBAR_TYPE}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebartype" name="type"{{ SIDEBAR_TYPE }}>
+ 						<label class="onoffswitch-label" for="sidebartype">
+ 							<span class="onoffswitch-inner onoffswitch-inner-position"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -116,11 +116,11 @@
+ 			</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="width_s">{L_ACP_SIDEBAR_WIDTH}</label><br />{L_ACP_SIDEBAR_WIDTH_EXPLAIN}</dt>
++			<dt><label for="width_s">{{ lang('ACP_SIDEBAR_WIDTH') }}</label><br />{{ lang('ACP_SIDEBAR_WIDTH_EXPLAIN') }}</dt>
+ 			<dd>
+ 				
+ 				 <div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="width_s" name="width"{SIDEBAR_WIDTH}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="width_s" name="width"{{ SIDEBAR_WIDTH }}>
+ 						<label class="onoffswitch-label" for="width_s">
+ 							<span class="onoffswitch-inner onoffswitch-inner-width"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -131,11 +131,11 @@
+ 		</dl>
+ 		
+ 		<dl>
+-			<dt><label for="height">{L_ACP_SIDEBAR_HEIGHT}</label><br />{L_ACP_SIDEBAR_HEIGHT_EXPLAIN}</dt>
++			<dt><label for="height">{{ lang('ACP_SIDEBAR_HEIGHT') }}</label><br />{{ lang('ACP_SIDEBAR_HEIGHT_EXPLAIN') }}</dt>
+ 			<dd>
+ 					
+ 				<div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="height" name="height"{SIDEBAR_HEIGHT}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="height" name="height"{{ SIDEBAR_HEIGHT }}>
+ 						<label class="onoffswitch-label" for="height">
+ 							<span class="onoffswitch-inner"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -147,11 +147,11 @@
+ 		
+ 		
+ 		<dl>
+-			<dt><label for="all_pages">{L_ACP_SIDEBAR_ALL_PAGES}</label><br />{L_ACP_SIDEBAR_ALL_PAGES_EXPLAIN}</dt>
++			<dt><label for="all_pages">{{ lang('ACP_SIDEBAR_ALL_PAGES') }}</label><br />{{ lang('ACP_SIDEBAR_ALL_PAGES_EXPLAIN') }}</dt>
+ 			<dd>
+ 
+ 				<div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="all_pages" name="all_pages"{SIDEBAR_ALL_PAGES}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="all_pages" name="all_pages"{{ SIDEBAR_ALL_PAGES }}>
+ 						<label class="onoffswitch-label" for="all_pages">
+ 							<span class="onoffswitch-inner"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -162,10 +162,10 @@
+ 		</dl>
+ 		
+ 		<dl>
+-		<dt><label for="all_pages">{L_ACP_SIDEBAR_PANEL_PAGES}</label><br />{L_ACP_SIDEBAR_PANEL_PAGES_EXPLAIN}</dt>
++		<dt><label for="all_pages">{{ lang('ACP_SIDEBAR_PANEL_PAGES') }}</label><br />{{ lang('ACP_SIDEBAR_PANEL_PAGES_EXPLAIN') }}</dt>
+ 			<dd>
+ 				<div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="panel_pages" name="panel_pages"{SIDEBAR_PANEL_PAGES}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="panel_pages" name="panel_pages"{{ SIDEBAR_PANEL_PAGES }}>
+ 						<label class="onoffswitch-label" for="panel_pages">
+ 							<span class="onoffswitch-inner"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -176,11 +176,11 @@
+ 			</dl>
+ 		
+ 		<dl>
+-			<dt><label for="shuffle">{L_ACP_SIDEBAR_SHUFFLE}</label><br />{L_ACP_SIDEBAR_SHUFFLE_EXPLAIN}</dt>
++			<dt><label for="shuffle">{{ lang('ACP_SIDEBAR_SHUFFLE') }}</label><br />{{ lang('ACP_SIDEBAR_SHUFFLE_EXPLAIN') }}</dt>
+ 			<dd>
+ 
+ 				<div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="shuffle" name="shuffle"{SIDEBAR_SHUFFLE}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="shuffle" name="shuffle"{{ SIDEBAR_SHUFFLE }}>
+ 						<label class="onoffswitch-label" for="shuffle">
+ 							<span class="onoffswitch-inner"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -190,16 +190,16 @@
+ 			</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="slots">{L_ACP_SIDEBAR_SLOTS}</label><br />{L_ACP_SIDEBAR_SLOTS_EXPLAIN}</dt>
++			<dt><label for="slots">{{ lang('ACP_SIDEBAR_SLOTS') }}</label><br />{{ lang('ACP_SIDEBAR_SLOTS_EXPLAIN') }}</dt>
+ 			<dd>
+-			 <input type="range" name="slots" id="slots" min="1" max="10" step="1" value="{SLOTS}" oninput="rangevalue1.value=value" />
++			 <input type="range" name="slots" id="slots" min="1" max="10" step="1" value="{{ SLOTS }}" oninput="rangevalue1.value=value" />
+              <output id="rangevalue1"></output>
+ 			</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label id="how_many" for="how_many">{L_HOWMANY}</label><br />{L_HOWMANY_EXPLAIN}</dt>
++			<dt><label id="how_many" for="how_many">{{ lang('HOWMANY') }}</label><br />{{ lang('HOWMANY_EXPLAIN') }}</dt>
+ 			<dd>
+-			 <input type="range" name="how_many" id="how_many" min="1" max="10" step="1" value="{HOWMANY}" oninput="rangevalue.value=value" />
++			 <input type="range" name="how_many" id="how_many" min="1" max="10" step="1" value="{{ HOWMANY }}" oninput="rangevalue.value=value" />
+              <output id="rangevalue"></output>
+ 			</dd>
+ 		</dl>
+@@ -210,11 +210,11 @@
+ 		
+ 		<dl style="clear:both;">
+ 			<dt style="width:36%;">
+-			<label id="ignore" for="ignore_inactive_users ignore_founder show_admins_mods">{L_IGNORE}</label><br />{L_IGNORE_EXPLAIN}</dt>
++			<label id="ignore" for="ignore_inactive_users ignore_founder show_admins_mods">{{ lang('IGNORE') }}</label><br />{{ lang('IGNORE_EXPLAIN') }}</dt>
+ 			<dd style="margin-left:36%;">
+-			<div class="label-entry">{L_IGNORE_USERS}</div>
+-			<div class="label-entry">{L_IGNORE_FOUNDER}</div>
+-			<div class="label-entry">{L_IGNORE_ADMINS_MODS}</div>
++			<div class="label-entry">{{ lang('IGNORE_USERS') }}</div>
++			<div class="label-entry">{{ lang('IGNORE_FOUNDER') }}</div>
++			<div class="label-entry">{{ lang('IGNORE_ADMINS_MODS') }}</div>
+ 			</dd>
+ 			
+ 			<dd style="margin-left:36%;">
+@@ -222,7 +222,7 @@
+ 				<div class="label-wrap">
+ 
+ 				 <div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_inactive_users" name="ignore_inactive_users"{IGNORE_INACTIVE}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_inactive_users" name="ignore_inactive_users"{{ IGNORE_INACTIVE }}>
+ 						<label class="onoffswitch-label" for="ignore_inactive_users">
+ 							<span class="onoffswitch-inner"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -234,7 +234,7 @@
+ 				<div class="label-wrap">
+ 
+ 				    <div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_founder" name="ignore_founder"{IGNORE_FOUNDER}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_founder" name="ignore_founder"{{ IGNORE_FOUNDER }}>
+ 						<label class="onoffswitch-label" for="ignore_founder">
+ 							<span class="onoffswitch-inner"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -247,7 +247,7 @@
+ 				
+ 				
+ 				    <div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_admins_mods" name="ignore_admins_mods"{IGNORE_ADMINS_MODS}>
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_admins_mods" name="ignore_admins_mods"{{ IGNORE_ADMINS_MODS }}>
+ 						<label class="onoffswitch-label" for="ignore_admins_mods">
+ 							<span class="onoffswitch-inner"></span>
+ 							<span class="onoffswitch-switch"></span>
+@@ -263,34 +263,34 @@
+ 
+ 	
+ 	<fieldset class="dtdd-fix">
+-		<legend>{L_ACP_SIDEBAR_HEADSUP}{L_COLON}</legend>
+-		<p>{L_ACP_SIDEBAR_HEADSIP_EXPLAIN}</p>
++		<legend>{{ lang('ACP_SIDEBAR_HEADSUP') }}{{ lang('COLON') }}</legend>
++		<p>{{ lang('ACP_SIDEBAR_HEADSIP_EXPLAIN') }}</p>
+ 	</fieldset>	
+ 	
+ 	<fieldset class="dtdd-fix">
+-		<legend>{L_ACP_SIDEBAR_SETTINGS}{L_COLON}</legend>
++		<legend>{{ lang('ACP_SIDEBAR_SETTINGS') }}{{ lang('COLON') }}</legend>
+ 		<script>
+-		var rule_type = [{OPTION_ARY}];
++		var rule_type = [{{ OPTION_ARY }}];
+ 		</script>
+ 		<dl>
+ 			<dt style="width:36%;"></dt>
+ 			<dd style="margin-left:36%;">
+-				<span style="width:120px;display:inline-block;">{L_SHOW_TYPE}{L_COLON}</span>
+-				<span style="width:150px;display:inline-block;">{L_SHOW_MOBILE}{L_COLON}</span>
+-				<span style="width:150px;display:inline-block;">{L_SHOW_TABLET}{L_COLON}</span>
++				<span style="width:120px;display:inline-block;">{{ lang('SHOW_TYPE') }}{{ lang('COLON') }}</span>
++				<span style="width:150px;display:inline-block;">{{ lang('SHOW_MOBILE') }}{{ lang('COLON') }}</span>
++				<span style="width:150px;display:inline-block;">{{ lang('SHOW_TABLET') }}{{ lang('COLON') }}</span>
+ 			</dd>
+ 		</dl>
+-		<!-- BEGIN slots -->
++		{% for slots in loops.slots %}
+ 		<dl>
+-			<dt style="width:36%;"><label id="sidebar_slot{slots.ID}_active" for="sidebar_slot{slots.ID}_active">{L_ACP_SIDEBAR_SLOT} {slots.ID}</label></dt>
++			<dt style="width:36%;"><label id="sidebar_slot{{ slots.ID }}_active" for="sidebar_slot{{ slots.ID }}_active">{{ lang('ACP_SIDEBAR_SLOT') }} {{ slots.ID }}</label></dt>
+ 			<dd style="margin-left:36%;">
+-				<select style="float:left;" name="sidebar[slot{slots.ID}][_active]]" id="sidebar_slot{slots.ID}_active">{slots.ACTIVE_SLOT}</select>
++				<select style="float:left;" name="sidebar[slot{{ slots.ID }}][_active]]" id="sidebar_slot{{ slots.ID }}_active">{{ slots.ACTIVE_SLOT }}</select>
+ 			
+ 			<div style="display:inline-block; margin-left:20px;">
+-				<div id="show_mobile{slots.ID}" style="display:{slots.OPTION_SLOT};">
++				<div id="show_mobile{{ slots.ID }}" style="display:{{ slots.OPTION_SLOT }};">
+ 					<div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{slots.ID}_show_mobile" name="options[slot{slots.ID}][_mobile]]"{slots.SHOW_MOBILE}>
+-						<label class="onoffswitch-label" for="sidebar_slot{slots.ID}_show_mobile">
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{{ slots.ID }}_show_mobile" name="options[slot{{ slots.ID }}][_mobile]]"{{ slots.SHOW_MOBILE }}>
++						<label class="onoffswitch-label" for="sidebar_slot{{ slots.ID }}_show_mobile">
+ 							<span class="onoffswitch-inner onoffswitch-inner-yn"></span>
+ 							<span class="onoffswitch-switch"></span>
+ 						</label>
+@@ -299,10 +299,10 @@
+ 			</div>
+ 			
+ 			<div style="display:inline-block; margin-left:20px;">
+-				<div id="show_tablet{slots.ID}" style="display:{slots.OPTION_SLOT};">
++				<div id="show_tablet{{ slots.ID }}" style="display:{{ slots.OPTION_SLOT }};">
+ 				<div class="onoffswitch">
+-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{slots.ID}_show_tablet" name="options[slot{slots.ID}][_tablet]]"{slots.SHOW_TABLET}>
+-						<label class="onoffswitch-label" for="sidebar_slot{slots.ID}_show_tablet">
++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{{ slots.ID }}_show_tablet" name="options[slot{{ slots.ID }}][_tablet]]"{{ slots.SHOW_TABLET }}>
++						<label class="onoffswitch-label" for="sidebar_slot{{ slots.ID }}_show_tablet">
+ 							<span class="onoffswitch-inner onoffswitch-inner-yn"></span>
+ 							<span class="onoffswitch-switch"></span>
+ 						</label>
+@@ -312,29 +312,29 @@
+ 				
+ 			</dd>
+ 		</dl>
+-		<div id="sidebar_slot{slots.ID}" style="display:{slots.VISIBILTY_SLOT};">
++		<div id="sidebar_slot{{ slots.ID }}" style="display:{{ slots.VISIBILTY_SLOT }};">
+ 		<dl>
+-			<dt style="width:36%;"><label for="sidebar_slot{slots.ID}_title">{L_ACP_TITLE_SLOT} {slots.ID}</label><br />{L_ACP_TITLE_SLOT_EXPLAIN}</dt>
++			<dt style="width:36%;"><label for="sidebar_slot{{ slots.ID }}_title">{{ lang('ACP_TITLE_SLOT') }} {{ slots.ID }}</label><br />{{ lang('ACP_TITLE_SLOT_EXPLAIN') }}</dt>
+ 			<dd style="margin-left:36%;">
+-				<input type="text" name="sidebar[slot{slots.ID}][_title]]" value="{slots.SIDEBAR_TITLE}" size="50" />
++				<input type="text" name="sidebar[slot{{ slots.ID }}][_title]]" value="{{ slots.SIDEBAR_TITLE }}" size="50" />
+ 			</dd>
+ 		</dl>
+ 		<dl>
+-			<dt style="width:36%;"><label for="sidebar_slot{slots.ID}_text">{L_ACP_SIDEBAR_TEXT}{L_COLON}</label><br />{L_ACP_SIDEBAR_TEXT_EXPLAIN}</dt>
+-			<dd style="margin-left:36%;"><textarea name="sidebar[slot{slots.ID}][_text]]" rows="3" cols="40">{slots.SIDEBAR_TEXT}</textarea></dd>
++			<dt style="width:36%;"><label for="sidebar_slot{{ slots.ID }}_text">{{ lang('ACP_SIDEBAR_TEXT') }}{{ lang('COLON') }}</label><br />{{ lang('ACP_SIDEBAR_TEXT_EXPLAIN') }}</dt>
++			<dd style="margin-left:36%;"><textarea name="sidebar[slot{{ slots.ID }}][_text]]" rows="3" cols="40">{{ slots.SIDEBAR_TEXT }}</textarea></dd>
+ 		</dl>
+ 		</div>
+ 		<hr />
+-		<!-- END slots -->
++		{% endfor %}
+ 		<p class="submit-buttons">
+-			<input class="button1" type="submit" name="update" value="{L_SUBMIT}" />&nbsp;
+-			<input class="button2" type="reset" id="reset" name="reset" value="{L_RESET}" />
+-			{S_FORM_TOKEN}
++			<input class="button1" type="submit" name="update" value="{{ lang('SUBMIT') }}" />&nbsp;
++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
++			{{ S_FORM_TOKEN }}
+ 		</p>
+ 	</fieldset>
+ </form>
+ 
+-<!-- INCLUDEJS js/sidebar.js -->
+-<!-- INCLUDEJS {ROOT_PATH}ext/sitesplat/sidebar/vendor/bootstrap/js/bootstrap.min.js -->
++{% INCLUDEJS 'js/sidebar.js' %}
++{% INCLUDEJS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/bootstrap/js/bootstrap.min.js' %}
+ <div class="md-overlay"></div><!-- the overlay element -->
+-<!-- INCLUDE overall_footer.html -->
++{% INCLUDE 'overall_footer.html' %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/config/services.yml"
+index 9d89dbafb..6b64f8585 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/config/services.yml"
+@@ -60,5 +60,6 @@ services:
+             - '@config'
+             - '%core.root_path%'
+             - '%core.php_ext%'
++            - '@ext.manager'
+         tags:
+             - { name: event.listener }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/diff_full.tmp"
+new file mode 100644
+index 000000000..2560e6662
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/diff_full.tmp"
+@@ -0,0 +1,3070 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
++index 81c13f5b4..3a96f4580 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
++@@ -1,143 +1,143 @@
++-<h3>{L_ACP_SIDEBAR_TITLE}</h3>
+++<h3>{{ lang('ACP_SIDEBAR_TITLE') }}</h3>
++   <div class="clearfix description-ext">
++-	<h1 class="ExtensionName"><!-- IF META_DISPLAY_NAME -->{META_DISPLAY_NAME} - <!-- ENDIF -->{L_EXT_DETAILS}</h1>
++-	<!-- IF S_VERSIONCHECK -->
++-	<!-- ELSE IF S_VERSIONCHECK_STATUS == 0 -->
+++	<h1 class="ExtensionName">{% if META_DISPLAY_NAME %}{{ META_DISPLAY_NAME }} - {% endif %}{{ lang('EXT_DETAILS') }}</h1>
+++	{% if S_VERSIONCHECK %}
+++	{% elseif S_VERSIONCHECK_STATUS == 0 %}
++ 	<div class="errorbox notice">
++-		<p>{L_VERSIONCHECK_FAIL}</p>
++-		<p>{VERSIONCHECK_FAIL_REASON}</p>
++-		<p><a href="{U_VERSIONCHECK_FORCE}">{L_VERSIONCHECK_FORCE_UPDATE}</a></p>
+++		<p>{{ lang('VERSIONCHECK_FAIL') }}</p>
+++		<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
+++		<p><a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
++ 	</div>
++-	<!-- ELSE IF S_VERSIONCHECK_STATUS == 1 -->
+++	{% elseif S_VERSIONCHECK_STATUS == 1 %}
++ 	<div class="errorbox notice">
++-		<p>{VERSIONCHECK_FAIL_REASON}</p>
+++		<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
++ 	</div>
++-	<!-- ENDIF -->
+++	{% endif %}
++ 	
++-	<!-- IF S_VERSIONCHECK && not S_UP_TO_DATE -->
+++	{% if S_VERSIONCHECK && not S_UP_TO_DATE %}
++ 	<div class="alert alert-update">
++ 	  
++       <div class="row">	
++       <div class="col-md-12">
++ 	   	
++ 	  <div class="col-md-6">	
++-		<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
++-		    <span class="description_name">{L_CURRENT_VERSION}{L_COLON}</span>
+++		<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
+++		    <span class="description_name">{{ lang('CURRENT_VERSION') }}{{ lang('COLON') }}</span>
++ 			<div class="extension_latest_version_wrapper">
++-			<strong class="extension_latest_version label label-warning">{META_VERSION}</strong>
+++			<strong class="extension_latest_version label label-warning">{{ META_VERSION }}</strong>
++ 			</div>
++ 	    </div>
++ 	  </div>
++ 	  
++ 	  <div class="col-md-6">	
++-		<!-- BEGIN updates_available -->
++-			<span class="requirements_title">{L_LATEST_VERSION}{L_COLON}</span>
+++		{% for updates_available in loops.updates_available %}
+++			<span class="requirements_title">{{ lang('LATEST_VERSION') }}{{ lang('COLON') }}</span>
++ 			<div class="extension_latest_version_wrapper">
++-				<strong class="extension_latest_version label label-success">{updates_available.current}</strong>
++-				<!-- IF updates_available.download-->
++-				<a href="{updates_available.download}" class="extension_author_link" title="{L_DOWNLOAD_LATEST}"><i class="fa fa-download"></i></a>
++-				<!-- ENDIF -->
++-				<!-- IF updates_available.announcement -->
++-				<a href="{updates_available.announcement}" class="extension_author_link" title="{L_ANNOUNCEMENT_TOPIC}"><i class="fa fa-bullhorn"></i></a>
++-				<!-- ENDIF -->
+++				<strong class="extension_latest_version label label-success">{{ updates_available.current }}</strong>
+++				{% if updates_available.download%}
+++				<a href="{{ updates_available.download }}" class="extension_author_link" title="{{ lang('DOWNLOAD_LATEST') }}"><i class="fa fa-download"></i></a>
+++				{% endif %}
+++				{% if updates_available.announcement %}
+++				<a href="{{ updates_available.announcement }}" class="extension_author_link" title="{{ lang('ANNOUNCEMENT_TOPIC') }}"><i class="fa fa-bullhorn"></i></a>
+++				{% endif %}
++ 			</div>
++-		<!-- END updates_available -->
+++		{% endfor %}
++ 	   </div>	
++ 	  
++ 	  </div>
++      </div>	  
++ 		
++ 	</div>
++-	<!-- ENDIF -->
+++	{% endif %}
++ 
++ 	<div class="description_div">
++ 		<div>
++ 			<div>
++ 				<p class="description_list">
++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_DESCRIPTION_PAGE}</span><br />
++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_1}</span><br />
++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_2}</span><br />
++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_3}</span><br />
++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_4}</span><br />
++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_5}</span><br />
++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_6}</span><br />
+++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_DESCRIPTION_PAGE') }}</span><br />
+++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_1') }}</span><br />
+++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_2') }}</span><br />
+++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_3') }}</span><br />
+++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_4') }}</span><br />
+++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_5') }}</span><br />
+++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_6') }}</span><br />
++ 				</p>
++ 			</div>
++ 		</div>
++ 	</div>
++ 	<div class="description_bubble big_bubble">
++-		<span class="description_name">{L_CLEAN_NAME}{L_COLON}</span>
++-		<strong class="description_value" id="meta_name">{META_NAME}</strong>
+++		<span class="description_name">{{ lang('CLEAN_NAME') }}{{ lang('COLON') }}</span>
+++		<strong class="description_value" id="meta_name">{{ META_NAME }}</strong>
++ 	</div>
++-	<!-- IF S_VERSIONCHECK && S_UP_TO_DATE -->
++-	<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
++-		<span class="description_name">{L_VERSION}{L_COLON}</span>
++-		<span class="description_value description_value_ok" id="meta_version">{META_VERSION}</span>
+++	{% if S_VERSIONCHECK && S_UP_TO_DATE %}
+++	<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
+++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
+++		<span class="description_value description_value_ok" id="meta_version">{{ META_VERSION }}</span>
++ 	</div>
++-	<!-- ELSE IF S_VERSIONCHECK && not S_UP_TO_DATE -->
++-	<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
++-		<span class="description_name">{L_VERSION}{L_COLON}</span>
++-		<span class="description_value description_value_old" id="meta_version">{META_VERSION}</span>
+++	{% elseif S_VERSIONCHECK && not S_UP_TO_DATE %}
+++	<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
+++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
+++		<span class="description_value description_value_old" id="meta_version">{{ META_VERSION }}</span>
++ 	</div>
++-	<!-- ELSE -->
+++	{% else %}
++ 	<div class="description_bubble small_bubble">
++-		<span class="description_name">{L_VERSION}{L_COLON}</span>
++-		<span class="description_value" id="meta_version">{META_VERSION}</span>
+++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
+++		<span class="description_value" id="meta_version">{{ META_VERSION }}</span>
++ 	</div>
++-	<!-- ENDIF -->
++-	<!-- IF META_HOMEPAGE -->
+++	{% endif %}
+++	{% if META_HOMEPAGE %}
++ 	<div class="description_bubble big_bubble">
++-		<span class="description_name">{L_HOMEPAGE}{L_COLON}</span>
++-		<strong class="description_value" id="meta_homepage"><a href="{META_HOMEPAGE}"><i class="fa fa-globe"></i> {META_HOMEPAGE}</a></strong>
+++		<span class="description_name">{{ lang('HOMEPAGE') }}{{ lang('COLON') }}</span>
+++		<strong class="description_value" id="meta_homepage"><a href="{{ META_HOMEPAGE }}"><i class="fa fa-globe"></i> {{ META_HOMEPAGE }}</a></strong>
++ 	</div>
++-	<!-- ENDIF -->
++-	<!-- IF META_TIME -->
+++	{% endif %}
+++	{% if META_TIME %}
++ 	<div class="description_bubble small_bubble">
++-		<span class="description_name">{L_TIME}{L_COLON}</span>
++-		<span class="description_value" id="meta_time">{META_TIME}</span>
+++		<span class="description_name">{{ lang('TIME') }}{{ lang('COLON') }}</span>
+++		<span class="description_value" id="meta_time">{{ META_TIME }}</span>
++ 	</div>
++-	<!-- ENDIF -->
+++	{% endif %}
++ 	<div class="description_bubble small_bubble">
++-		<span class="description_name">{L_LICENSE}{L_COLON}</span>
++-		<span class="description_value" id="meta_license" style="padding:0 15px;">{L_LICENSE_INFO}</span>
+++		<span class="description_name">{{ lang('LICENSE') }}{{ lang('COLON') }}</span>
+++		<span class="description_value" id="meta_license" style="padding:0 15px;">{{ lang('LICENSE_INFO') }}</span>
++ 	</div>
++ 
++-	<!-- IF META_REQUIRE_PHPBB || META_REQUIRE_PHP -->
+++	{% if META_REQUIRE_PHPBB || META_REQUIRE_PHP %}
++ 	<div>
++-		<span class="requirements_title">{L_REQUIREMENTS}{L_COLON}</span>
++-		<!-- IF META_REQUIRE_PHPBB -->
+++		<span class="requirements_title">{{ lang('REQUIREMENTS') }}{{ lang('COLON') }}</span>
+++		{% if META_REQUIRE_PHPBB %}
++ 		<div class="requirements_bubble">
++-			<span class="requirements_name">{L_PHPBB_VERSION}{L_COLON}</span>
++-			<span class="requirements_value<!-- IF META_REQUIRE_PHPBB_FAIL --> requirements_value_not_met<!-- ENDIF -->" id="require_phpbb">{META_REQUIRE_PHPBB}</span>
+++			<span class="requirements_name">{{ lang('PHPBB_VERSION') }}{{ lang('COLON') }}</span>
+++			<span class="requirements_value{% if META_REQUIRE_PHPBB_FAIL %} requirements_value_not_met{% endif %}" id="require_phpbb">{{ META_REQUIRE_PHPBB }}</span>
++ 		</div>
++-		<!-- ENDIF -->
++-		<!-- IF META_REQUIRE_PHP -->
+++		{% endif %}
+++		{% if META_REQUIRE_PHP %}
++ 		<div class="requirements_bubble">
++-			<span class="requirements_name">{L_PHP_VERSION}{L_COLON}</span>
++-			<span class="requirements_value<!-- IF META_REQUIRE_PHP_FAIL --> requirements_value_not_met<!-- ENDIF -->" id="require_php">{META_REQUIRE_PHP}</span>
+++			<span class="requirements_name">{{ lang('PHP_VERSION') }}{{ lang('COLON') }}</span>
+++			<span class="requirements_value{% if META_REQUIRE_PHP_FAIL %} requirements_value_not_met{% endif %}" id="require_php">{{ META_REQUIRE_PHP }}</span>
++ 		</div>
++-		<!-- ENDIF -->
+++		{% endif %}
++ 	</div>
++-	<!-- ENDIF -->
+++	{% endif %}
++ 
++ 	<div>
++-		<span class="requirements_title">{L_EXTENSION_DEVELOPER}{L_COLON}</span>
++-		<!-- BEGIN meta_authors -->
+++		<span class="requirements_title">{{ lang('EXTENSION_DEVELOPER') }}{{ lang('COLON') }}</span>
+++		{% for meta_authors in loops.meta_authors %}
++ 		<div class="extension_author">
++-			<strong class="extension_author_name">{meta_authors.AUTHOR_NAME}</strong>
++-			<!-- IF meta_authors.AUTHOR_EMAIL -->
++-			<a href="mailto:{meta_authors.AUTHOR_EMAIL}" title="{L_AUTHOR_EMAIL}" class="extension_author_link"><i class="fa fa-envelope"></i></a>
++-			<!-- ENDIF -->
++-			<!-- IF meta_authors.AUTHOR_HOMEPAGE -->
++-			<a href="{meta_authors.AUTHOR_HOMEPAGE}" title="{L_AUTHOR_HOMEPAGE}" class="extension_author_link"><i class="fa fa-globe"></i></a>
++-			<!-- ENDIF -->
+++			<strong class="extension_author_name">{{ meta_authors.AUTHOR_NAME }}</strong>
+++			{% if meta_authors.AUTHOR_EMAIL %}
+++			<a href="mailto:{{ meta_authors.AUTHOR_EMAIL }}" title="{{ lang('AUTHOR_EMAIL') }}" class="extension_author_link"><i class="fa fa-envelope"></i></a>
+++			{% endif %}
+++			{% if meta_authors.AUTHOR_HOMEPAGE %}
+++			<a href="{{ meta_authors.AUTHOR_HOMEPAGE }}" title="{{ lang('AUTHOR_HOMEPAGE') }}" class="extension_author_link"><i class="fa fa-globe"></i></a>
+++			{% endif %}
++ 		</div>
++-		<!-- END meta_authors -->
+++		{% endfor %}
++ 	</div>
++ 	
++ 	<div class="clearfix">
++ 	<br/>
++-	<button type="button" class="btn md-close btn-block" data-dismiss="modal">{L_ACP_SIDEBAR_NOTICE_CLOSE}</button>
+++	<button type="button" class="btn md-close btn-block" data-dismiss="modal">{{ lang('ACP_SIDEBAR_NOTICE_CLOSE') }}</button>
++ 	</div>
++ 	
++ </div>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
++index 1b366fc15..b68eb0fe7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
++@@ -1,24 +1,24 @@
++-<!-- IF S_ALLOW_CDN -->
++-<!-- INCLUDECSS //maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css -->
++-<!-- ELSE -->
++-<!-- INCLUDECSS {ROOT_PATH}ext/sitesplat/sidebar/vendor/font-awesome/css/font-awesome.min.css -->
++-<!-- ENDIF -->
++-<!-- INCLUDECSS {ROOT_PATH}ext/sitesplat/sidebar/vendor/bootstrap/css/bootstrap_modified.css -->
++-<!-- INCLUDECSS css/sidebar.css -->
++-<!-- INCLUDECSS css/component.css -->
+++{% if S_ALLOW_CDN %}
+++{% INCLUDECSS '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' %}
+++{% else %}
+++{% INCLUDECSS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/font-awesome/css/font-awesome.min.css' %}
+++{% endif %}
+++{% INCLUDECSS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/bootstrap/css/bootstrap_modified.css' %}
+++{% INCLUDECSS 'css/sidebar.css' %}
+++{% INCLUDECSS 'css/component.css' %}
++ 
++-<!-- INCLUDE overall_header.html -->
+++{% INCLUDE 'overall_header.html' %}
++ 
++-<h1>{L_ACP_SIDEBAR_TITLE} <a href="javascript:void(0)" class="md-trigger" data-remote="{U_ACTION}&amp;action=details" data-toggle="modal" data-target="#myModal"><span class="label label-success">{L_ACP_SIDEBAR_VERSION} <i class="fa fa-info-circle"></i></span></a></h1>
+++<h1>{{ lang('ACP_SIDEBAR_TITLE') }} <a href="javascript:void(0)" class="md-trigger" data-remote="{{ U_ACTION }}&amp;action=details" data-toggle="modal" data-target="#myModal"><span class="label label-success">{{ lang('ACP_SIDEBAR_VERSION') }} <i class="fa fa-info-circle"></i></span></a></h1>
++ 
++ 		<!-- Modal -->
++ 		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
++ 		  <div class="modal-dialog" role="document">
++ 			<div class="modal-content md-content">
++-			  <h3><i class="icon-bbreact-emo-beer" style="margin-right:20px;"></i> {L_ACP_SIDEBAR_TITLE}</h3>
+++			  <h3><i class="icon-bbreact-emo-beer" style="margin-right:20px;"></i> {{ lang('ACP_SIDEBAR_TITLE') }}</h3>
++ 			  <div class="modal-body">
++ 			   <div class="panel-body">
++-				<div class="loader">{L_ACP_LOADING}</div>
+++				<div class="loader">{{ lang('ACP_LOADING') }}</div>
++ 			   </div>
++ 			  <div class="modal-footer">
++ 			  </div>
++@@ -28,37 +28,37 @@
++ 		</div>
++ 
++ 
++-<p>{L_AD_SIDEBAR_EXPLAIN}</p>
+++<p>{{ lang('AD_SIDEBAR_EXPLAIN') }}</p>
++ 
++-<!-- IF S_NOTICE_LIKEDD or S_NOTICE_BBREACTION or S_NOTICE_BBDONATION or S_NOTICE_BBMEMBERSHIP or S_NOTICE_BADGE or S_NOTICE_BBPOINTS or S_NOTICE_NEWSLETTER -->
+++{% if S_NOTICE_LIKEDD or S_NOTICE_BBREACTION or S_NOTICE_BBDONATION or S_NOTICE_BBMEMBERSHIP or S_NOTICE_BADGE or S_NOTICE_BBPOINTS or S_NOTICE_NEWSLETTER %}
++ <div id="sidbar_notice" class="errorbox notice">
++-	<a href="{U_BADGE_NOTICE_CLOSE}" data-ajax="close_notice" data-overlay="false" class="close clearfix" title="{L_ACP_SIDEBAR_NOTICE_CLOSE}"></a>
+++	<a href="{{ U_BADGE_NOTICE_CLOSE }}" data-ajax="close_notice" data-overlay="false" class="close clearfix" title="{{ lang('ACP_SIDEBAR_NOTICE_CLOSE') }}"></a>
++ 	<p>
++-	 <!-- IF S_NOTICE_LIKEDD -->{S_NOTICE_LIKEDD}<br /><!-- ENDIF -->
++-	 <!-- IF S_NOTICE_BBREACTION -->{S_NOTICE_BBREACTION}<br /><!-- ENDIF -->
++-	 <!-- IF S_NOTICE_BBDONATION -->{S_NOTICE_BBDONATION}<br /><!-- ENDIF -->
++-	 <!-- IF S_NOTICE_BBMEMBERSHIP -->{S_NOTICE_BBMEMBERSHIP}<br /><!-- ENDIF -->
++-	 <!-- IF S_NOTICE_BADGE -->{S_NOTICE_BADGE}<br /><!-- ENDIF -->
++-	 <!-- IF S_NOTICE_BBPOINTS -->{S_NOTICE_BBPOINTS}<br /><!-- ENDIF -->
++-	 <!-- IF S_NOTICE_NEWSLETTER -->{S_NOTICE_NEWSLETTER}<br /><!-- ENDIF -->
++-	  <!-- IF S_NOTICE_BBDOWNLOAD -->{S_NOTICE_BBDOWNLOAD}<!-- ENDIF -->
+++	 {% if S_NOTICE_LIKEDD %}{{ S_NOTICE_LIKEDD }}<br />{% endif %}
+++	 {% if S_NOTICE_BBREACTION %}{{ S_NOTICE_BBREACTION }}<br />{% endif %}
+++	 {% if S_NOTICE_BBDONATION %}{{ S_NOTICE_BBDONATION }}<br />{% endif %}
+++	 {% if S_NOTICE_BBMEMBERSHIP %}{{ S_NOTICE_BBMEMBERSHIP }}<br />{% endif %}
+++	 {% if S_NOTICE_BADGE %}{{ S_NOTICE_BADGE }}<br />{% endif %}
+++	 {% if S_NOTICE_BBPOINTS %}{{ S_NOTICE_BBPOINTS }}<br />{% endif %}
+++	 {% if S_NOTICE_NEWSLETTER %}{{ S_NOTICE_NEWSLETTER }}<br />{% endif %}
+++	  {% if S_NOTICE_BBDOWNLOAD %}{{ S_NOTICE_BBDOWNLOAD }}{% endif %}
++ 	</p>
++ </div>
++-<!-- ENDIF -->
+++{% endif %}
++ 
++ 
++-<form id="acp_sidebar" method="post" action="{U_ACTION}">
+++<form id="acp_sidebar" method="post" action="{{ U_ACTION }}">
++ 	<fieldset>
++-		<legend>{L_ACP_SIDEBAR_OPTIONS}</legend>
+++		<legend>{{ lang('ACP_SIDEBAR_OPTIONS') }}</legend>
++ 		<div class="sidebar-wrapper">
++ 		<style>
++ 			#sidebar-nav {
++-				width:<!-- IF SIDEBAR_WIDTH -->50<!-- ELSE -->30<!-- ENDIF -->px;
++-				float:<!-- IF SIDEBAR_TYPE -->right<!-- ELSE -->left<!-- ENDIF -->;
+++				width:{% if SIDEBAR_WIDTH %}50{% else %}30{% endif %}px;
+++				float:{% if SIDEBAR_TYPE %}right{% else %}left{% endif %};
++ 			}
++ 			#sidebar-section {
++-				width:<!-- IF SIDEBAR_WIDTH -->200<!-- ELSE -->220<!-- ENDIF -->px;
++-				float:<!-- IF SIDEBAR_TYPE -->left<!-- ELSE -->right<!-- ENDIF -->;
+++				width:{% if SIDEBAR_WIDTH %}200{% else %}220{% endif %}px;
+++				float:{% if SIDEBAR_TYPE %}left{% else %}right{% endif %};
++ 			}
++ 			</style> 
++ 			<div class="browser-window">
++@@ -70,7 +70,7 @@
++ 			  </div>
++ 			  <div class="dev-tools">
++ 			  <div class="bar">
++-				<div class="dev-bar-content">{L_SITESPLAT_COM}</div>
+++				<div class="dev-bar-content">{{ lang('SITESPLAT_COM') }}</div>
++ 				<div class="close-x">X</div>
++ 				<div class="clear"></div>
++ 			  </div>
++@@ -79,19 +79,19 @@
++ 			<div class="content">
++ 			
++ 			<div class="inner-browser">
++-			<div id="sidebar-header">{L_FLATBOOTS}</div>
+++			<div id="sidebar-header">{{ lang('FLATBOOTS') }}</div>
++ 			
++-			<div id="sidebar-nav">{L_ONE_S}<br />{L_ONE_I}<br />{L_ONE_D}<br />{L_ONE_E}<br />{L_ONE_B}<br />{L_ONE_A}<br />{L_ONE_R}</div>
+++			<div id="sidebar-nav">{{ lang('ONE_S') }}<br />{{ lang('ONE_I') }}<br />{{ lang('ONE_D') }}<br />{{ lang('ONE_E') }}<br />{{ lang('ONE_B') }}<br />{{ lang('ONE_A') }}<br />{{ lang('ONE_R') }}</div>
++ 			
++ 			<div id="sidebar-section">
++ 			<p class="forum-wrapper">
++-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
++-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
++-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
+++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
+++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
+++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
++ 			</p>
++ 			</div>
++ 			
++-			<div id="sidebar-footer">{L_SITESPLAT_COPY}</div>
+++			<div id="sidebar-footer">{{ lang('SITESPLAT_COPY') }}</div>
++ 			</div>
++ 			
++ 			</div>
++@@ -102,11 +102,11 @@
++ 
++ 		<div style="float:left;width:80%;">
++ 		<dl>
++-			<dt><label id="type" for="sidebartype">{L_ACP_SIDEBAR_TYPE}{L_COLON}</label><br /> {L_ACP_SIDEBAR_TYPE_EXPLAIN}</dt>
+++			<dt><label id="type" for="sidebartype">{{ lang('ACP_SIDEBAR_TYPE') }}{{ lang('COLON') }}</label><br /> {{ lang('ACP_SIDEBAR_TYPE_EXPLAIN') }}</dt>
++ 			<dd>
++ 
++ 				    <div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebartype" name="type"{SIDEBAR_TYPE}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebartype" name="type"{{ SIDEBAR_TYPE }}>
++ 						<label class="onoffswitch-label" for="sidebartype">
++ 							<span class="onoffswitch-inner onoffswitch-inner-position"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -116,11 +116,11 @@
++ 			</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="width_s">{L_ACP_SIDEBAR_WIDTH}</label><br />{L_ACP_SIDEBAR_WIDTH_EXPLAIN}</dt>
+++			<dt><label for="width_s">{{ lang('ACP_SIDEBAR_WIDTH') }}</label><br />{{ lang('ACP_SIDEBAR_WIDTH_EXPLAIN') }}</dt>
++ 			<dd>
++ 				
++ 				 <div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="width_s" name="width"{SIDEBAR_WIDTH}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="width_s" name="width"{{ SIDEBAR_WIDTH }}>
++ 						<label class="onoffswitch-label" for="width_s">
++ 							<span class="onoffswitch-inner onoffswitch-inner-width"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -131,11 +131,11 @@
++ 		</dl>
++ 		
++ 		<dl>
++-			<dt><label for="height">{L_ACP_SIDEBAR_HEIGHT}</label><br />{L_ACP_SIDEBAR_HEIGHT_EXPLAIN}</dt>
+++			<dt><label for="height">{{ lang('ACP_SIDEBAR_HEIGHT') }}</label><br />{{ lang('ACP_SIDEBAR_HEIGHT_EXPLAIN') }}</dt>
++ 			<dd>
++ 					
++ 				<div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="height" name="height"{SIDEBAR_HEIGHT}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="height" name="height"{{ SIDEBAR_HEIGHT }}>
++ 						<label class="onoffswitch-label" for="height">
++ 							<span class="onoffswitch-inner"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -147,11 +147,11 @@
++ 		
++ 		
++ 		<dl>
++-			<dt><label for="all_pages">{L_ACP_SIDEBAR_ALL_PAGES}</label><br />{L_ACP_SIDEBAR_ALL_PAGES_EXPLAIN}</dt>
+++			<dt><label for="all_pages">{{ lang('ACP_SIDEBAR_ALL_PAGES') }}</label><br />{{ lang('ACP_SIDEBAR_ALL_PAGES_EXPLAIN') }}</dt>
++ 			<dd>
++ 
++ 				<div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="all_pages" name="all_pages"{SIDEBAR_ALL_PAGES}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="all_pages" name="all_pages"{{ SIDEBAR_ALL_PAGES }}>
++ 						<label class="onoffswitch-label" for="all_pages">
++ 							<span class="onoffswitch-inner"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -162,10 +162,10 @@
++ 		</dl>
++ 		
++ 		<dl>
++-		<dt><label for="all_pages">{L_ACP_SIDEBAR_PANEL_PAGES}</label><br />{L_ACP_SIDEBAR_PANEL_PAGES_EXPLAIN}</dt>
+++		<dt><label for="all_pages">{{ lang('ACP_SIDEBAR_PANEL_PAGES') }}</label><br />{{ lang('ACP_SIDEBAR_PANEL_PAGES_EXPLAIN') }}</dt>
++ 			<dd>
++ 				<div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="panel_pages" name="panel_pages"{SIDEBAR_PANEL_PAGES}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="panel_pages" name="panel_pages"{{ SIDEBAR_PANEL_PAGES }}>
++ 						<label class="onoffswitch-label" for="panel_pages">
++ 							<span class="onoffswitch-inner"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -176,11 +176,11 @@
++ 			</dl>
++ 		
++ 		<dl>
++-			<dt><label for="shuffle">{L_ACP_SIDEBAR_SHUFFLE}</label><br />{L_ACP_SIDEBAR_SHUFFLE_EXPLAIN}</dt>
+++			<dt><label for="shuffle">{{ lang('ACP_SIDEBAR_SHUFFLE') }}</label><br />{{ lang('ACP_SIDEBAR_SHUFFLE_EXPLAIN') }}</dt>
++ 			<dd>
++ 
++ 				<div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="shuffle" name="shuffle"{SIDEBAR_SHUFFLE}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="shuffle" name="shuffle"{{ SIDEBAR_SHUFFLE }}>
++ 						<label class="onoffswitch-label" for="shuffle">
++ 							<span class="onoffswitch-inner"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -190,16 +190,16 @@
++ 			</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="slots">{L_ACP_SIDEBAR_SLOTS}</label><br />{L_ACP_SIDEBAR_SLOTS_EXPLAIN}</dt>
+++			<dt><label for="slots">{{ lang('ACP_SIDEBAR_SLOTS') }}</label><br />{{ lang('ACP_SIDEBAR_SLOTS_EXPLAIN') }}</dt>
++ 			<dd>
++-			 <input type="range" name="slots" id="slots" min="1" max="10" step="1" value="{SLOTS}" oninput="rangevalue1.value=value" />
+++			 <input type="range" name="slots" id="slots" min="1" max="10" step="1" value="{{ SLOTS }}" oninput="rangevalue1.value=value" />
++              <output id="rangevalue1"></output>
++ 			</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label id="how_many" for="how_many">{L_HOWMANY}</label><br />{L_HOWMANY_EXPLAIN}</dt>
+++			<dt><label id="how_many" for="how_many">{{ lang('HOWMANY') }}</label><br />{{ lang('HOWMANY_EXPLAIN') }}</dt>
++ 			<dd>
++-			 <input type="range" name="how_many" id="how_many" min="1" max="10" step="1" value="{HOWMANY}" oninput="rangevalue.value=value" />
+++			 <input type="range" name="how_many" id="how_many" min="1" max="10" step="1" value="{{ HOWMANY }}" oninput="rangevalue.value=value" />
++              <output id="rangevalue"></output>
++ 			</dd>
++ 		</dl>
++@@ -210,11 +210,11 @@
++ 		
++ 		<dl style="clear:both;">
++ 			<dt style="width:36%;">
++-			<label id="ignore" for="ignore_inactive_users ignore_founder show_admins_mods">{L_IGNORE}</label><br />{L_IGNORE_EXPLAIN}</dt>
+++			<label id="ignore" for="ignore_inactive_users ignore_founder show_admins_mods">{{ lang('IGNORE') }}</label><br />{{ lang('IGNORE_EXPLAIN') }}</dt>
++ 			<dd style="margin-left:36%;">
++-			<div class="label-entry">{L_IGNORE_USERS}</div>
++-			<div class="label-entry">{L_IGNORE_FOUNDER}</div>
++-			<div class="label-entry">{L_IGNORE_ADMINS_MODS}</div>
+++			<div class="label-entry">{{ lang('IGNORE_USERS') }}</div>
+++			<div class="label-entry">{{ lang('IGNORE_FOUNDER') }}</div>
+++			<div class="label-entry">{{ lang('IGNORE_ADMINS_MODS') }}</div>
++ 			</dd>
++ 			
++ 			<dd style="margin-left:36%;">
++@@ -222,7 +222,7 @@
++ 				<div class="label-wrap">
++ 
++ 				 <div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_inactive_users" name="ignore_inactive_users"{IGNORE_INACTIVE}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_inactive_users" name="ignore_inactive_users"{{ IGNORE_INACTIVE }}>
++ 						<label class="onoffswitch-label" for="ignore_inactive_users">
++ 							<span class="onoffswitch-inner"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -234,7 +234,7 @@
++ 				<div class="label-wrap">
++ 
++ 				    <div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_founder" name="ignore_founder"{IGNORE_FOUNDER}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_founder" name="ignore_founder"{{ IGNORE_FOUNDER }}>
++ 						<label class="onoffswitch-label" for="ignore_founder">
++ 							<span class="onoffswitch-inner"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -247,7 +247,7 @@
++ 				
++ 				
++ 				    <div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_admins_mods" name="ignore_admins_mods"{IGNORE_ADMINS_MODS}>
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_admins_mods" name="ignore_admins_mods"{{ IGNORE_ADMINS_MODS }}>
++ 						<label class="onoffswitch-label" for="ignore_admins_mods">
++ 							<span class="onoffswitch-inner"></span>
++ 							<span class="onoffswitch-switch"></span>
++@@ -263,34 +263,34 @@
++ 
++ 	
++ 	<fieldset class="dtdd-fix">
++-		<legend>{L_ACP_SIDEBAR_HEADSUP}{L_COLON}</legend>
++-		<p>{L_ACP_SIDEBAR_HEADSIP_EXPLAIN}</p>
+++		<legend>{{ lang('ACP_SIDEBAR_HEADSUP') }}{{ lang('COLON') }}</legend>
+++		<p>{{ lang('ACP_SIDEBAR_HEADSIP_EXPLAIN') }}</p>
++ 	</fieldset>	
++ 	
++ 	<fieldset class="dtdd-fix">
++-		<legend>{L_ACP_SIDEBAR_SETTINGS}{L_COLON}</legend>
+++		<legend>{{ lang('ACP_SIDEBAR_SETTINGS') }}{{ lang('COLON') }}</legend>
++ 		<script>
++-		var rule_type = [{OPTION_ARY}];
+++		var rule_type = [{{ OPTION_ARY }}];
++ 		</script>
++ 		<dl>
++ 			<dt style="width:36%;"></dt>
++ 			<dd style="margin-left:36%;">
++-				<span style="width:120px;display:inline-block;">{L_SHOW_TYPE}{L_COLON}</span>
++-				<span style="width:150px;display:inline-block;">{L_SHOW_MOBILE}{L_COLON}</span>
++-				<span style="width:150px;display:inline-block;">{L_SHOW_TABLET}{L_COLON}</span>
+++				<span style="width:120px;display:inline-block;">{{ lang('SHOW_TYPE') }}{{ lang('COLON') }}</span>
+++				<span style="width:150px;display:inline-block;">{{ lang('SHOW_MOBILE') }}{{ lang('COLON') }}</span>
+++				<span style="width:150px;display:inline-block;">{{ lang('SHOW_TABLET') }}{{ lang('COLON') }}</span>
++ 			</dd>
++ 		</dl>
++-		<!-- BEGIN slots -->
+++		{% for slots in loops.slots %}
++ 		<dl>
++-			<dt style="width:36%;"><label id="sidebar_slot{slots.ID}_active" for="sidebar_slot{slots.ID}_active">{L_ACP_SIDEBAR_SLOT} {slots.ID}</label></dt>
+++			<dt style="width:36%;"><label id="sidebar_slot{{ slots.ID }}_active" for="sidebar_slot{{ slots.ID }}_active">{{ lang('ACP_SIDEBAR_SLOT') }} {{ slots.ID }}</label></dt>
++ 			<dd style="margin-left:36%;">
++-				<select style="float:left;" name="sidebar[slot{slots.ID}][_active]]" id="sidebar_slot{slots.ID}_active">{slots.ACTIVE_SLOT}</select>
+++				<select style="float:left;" name="sidebar[slot{{ slots.ID }}][_active]]" id="sidebar_slot{{ slots.ID }}_active">{{ slots.ACTIVE_SLOT }}</select>
++ 			
++ 			<div style="display:inline-block; margin-left:20px;">
++-				<div id="show_mobile{slots.ID}" style="display:{slots.OPTION_SLOT};">
+++				<div id="show_mobile{{ slots.ID }}" style="display:{{ slots.OPTION_SLOT }};">
++ 					<div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{slots.ID}_show_mobile" name="options[slot{slots.ID}][_mobile]]"{slots.SHOW_MOBILE}>
++-						<label class="onoffswitch-label" for="sidebar_slot{slots.ID}_show_mobile">
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{{ slots.ID }}_show_mobile" name="options[slot{{ slots.ID }}][_mobile]]"{{ slots.SHOW_MOBILE }}>
+++						<label class="onoffswitch-label" for="sidebar_slot{{ slots.ID }}_show_mobile">
++ 							<span class="onoffswitch-inner onoffswitch-inner-yn"></span>
++ 							<span class="onoffswitch-switch"></span>
++ 						</label>
++@@ -299,10 +299,10 @@
++ 			</div>
++ 			
++ 			<div style="display:inline-block; margin-left:20px;">
++-				<div id="show_tablet{slots.ID}" style="display:{slots.OPTION_SLOT};">
+++				<div id="show_tablet{{ slots.ID }}" style="display:{{ slots.OPTION_SLOT }};">
++ 				<div class="onoffswitch">
++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{slots.ID}_show_tablet" name="options[slot{slots.ID}][_tablet]]"{slots.SHOW_TABLET}>
++-						<label class="onoffswitch-label" for="sidebar_slot{slots.ID}_show_tablet">
+++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{{ slots.ID }}_show_tablet" name="options[slot{{ slots.ID }}][_tablet]]"{{ slots.SHOW_TABLET }}>
+++						<label class="onoffswitch-label" for="sidebar_slot{{ slots.ID }}_show_tablet">
++ 							<span class="onoffswitch-inner onoffswitch-inner-yn"></span>
++ 							<span class="onoffswitch-switch"></span>
++ 						</label>
++@@ -312,29 +312,29 @@
++ 				
++ 			</dd>
++ 		</dl>
++-		<div id="sidebar_slot{slots.ID}" style="display:{slots.VISIBILTY_SLOT};">
+++		<div id="sidebar_slot{{ slots.ID }}" style="display:{{ slots.VISIBILTY_SLOT }};">
++ 		<dl>
++-			<dt style="width:36%;"><label for="sidebar_slot{slots.ID}_title">{L_ACP_TITLE_SLOT} {slots.ID}</label><br />{L_ACP_TITLE_SLOT_EXPLAIN}</dt>
+++			<dt style="width:36%;"><label for="sidebar_slot{{ slots.ID }}_title">{{ lang('ACP_TITLE_SLOT') }} {{ slots.ID }}</label><br />{{ lang('ACP_TITLE_SLOT_EXPLAIN') }}</dt>
++ 			<dd style="margin-left:36%;">
++-				<input type="text" name="sidebar[slot{slots.ID}][_title]]" value="{slots.SIDEBAR_TITLE}" size="50" />
+++				<input type="text" name="sidebar[slot{{ slots.ID }}][_title]]" value="{{ slots.SIDEBAR_TITLE }}" size="50" />
++ 			</dd>
++ 		</dl>
++ 		<dl>
++-			<dt style="width:36%;"><label for="sidebar_slot{slots.ID}_text">{L_ACP_SIDEBAR_TEXT}{L_COLON}</label><br />{L_ACP_SIDEBAR_TEXT_EXPLAIN}</dt>
++-			<dd style="margin-left:36%;"><textarea name="sidebar[slot{slots.ID}][_text]]" rows="3" cols="40">{slots.SIDEBAR_TEXT}</textarea></dd>
+++			<dt style="width:36%;"><label for="sidebar_slot{{ slots.ID }}_text">{{ lang('ACP_SIDEBAR_TEXT') }}{{ lang('COLON') }}</label><br />{{ lang('ACP_SIDEBAR_TEXT_EXPLAIN') }}</dt>
+++			<dd style="margin-left:36%;"><textarea name="sidebar[slot{{ slots.ID }}][_text]]" rows="3" cols="40">{{ slots.SIDEBAR_TEXT }}</textarea></dd>
++ 		</dl>
++ 		</div>
++ 		<hr />
++-		<!-- END slots -->
+++		{% endfor %}
++ 		<p class="submit-buttons">
++-			<input class="button1" type="submit" name="update" value="{L_SUBMIT}" />&nbsp;
++-			<input class="button2" type="reset" id="reset" name="reset" value="{L_RESET}" />
++-			{S_FORM_TOKEN}
+++			<input class="button1" type="submit" name="update" value="{{ lang('SUBMIT') }}" />&nbsp;
+++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+++			{{ S_FORM_TOKEN }}
++ 		</p>
++ 	</fieldset>
++ </form>
++ 
++-<!-- INCLUDEJS js/sidebar.js -->
++-<!-- INCLUDEJS {ROOT_PATH}ext/sitesplat/sidebar/vendor/bootstrap/js/bootstrap.min.js -->
+++{% INCLUDEJS 'js/sidebar.js' %}
+++{% INCLUDEJS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/bootstrap/js/bootstrap.min.js' %}
++ <div class="md-overlay"></div><!-- the overlay element -->
++-<!-- INCLUDE overall_footer.html -->
+++{% INCLUDE 'overall_footer.html' %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/config/services.yml"
++index 9d89dbafb..6b64f8585 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/config/services.yml"
++@@ -60,5 +60,6 @@ services:
++             - '@config'
++             - '%core.root_path%'
++             - '%core.php_ext%'
+++            - '@ext.manager'
++         tags:
++             - { name: event.listener }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/diff_full.tmp"
++new file mode 100644
++index 000000000..1d6ea8569
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/diff_full.tmp"
++@@ -0,0 +1,607 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
+++index 81c13f5b4..3a96f4580 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_ext_details.html"
+++@@ -1,143 +1,143 @@
+++-<h3>{L_ACP_SIDEBAR_TITLE}</h3>
++++<h3>{{ lang('ACP_SIDEBAR_TITLE') }}</h3>
+++   <div class="clearfix description-ext">
+++-	<h1 class="ExtensionName"><!-- IF META_DISPLAY_NAME -->{META_DISPLAY_NAME} - <!-- ENDIF -->{L_EXT_DETAILS}</h1>
+++-	<!-- IF S_VERSIONCHECK -->
+++-	<!-- ELSE IF S_VERSIONCHECK_STATUS == 0 -->
++++	<h1 class="ExtensionName">{% if META_DISPLAY_NAME %}{{ META_DISPLAY_NAME }} - {% endif %}{{ lang('EXT_DETAILS') }}</h1>
++++	{% if S_VERSIONCHECK %}
++++	{% elseif S_VERSIONCHECK_STATUS == 0 %}
+++ 	<div class="errorbox notice">
+++-		<p>{L_VERSIONCHECK_FAIL}</p>
+++-		<p>{VERSIONCHECK_FAIL_REASON}</p>
+++-		<p><a href="{U_VERSIONCHECK_FORCE}">{L_VERSIONCHECK_FORCE_UPDATE}</a></p>
++++		<p>{{ lang('VERSIONCHECK_FAIL') }}</p>
++++		<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
++++		<p><a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
+++ 	</div>
+++-	<!-- ELSE IF S_VERSIONCHECK_STATUS == 1 -->
++++	{% elseif S_VERSIONCHECK_STATUS == 1 %}
+++ 	<div class="errorbox notice">
+++-		<p>{VERSIONCHECK_FAIL_REASON}</p>
++++		<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
+++ 	</div>
+++-	<!-- ENDIF -->
++++	{% endif %}
+++ 	
+++-	<!-- IF S_VERSIONCHECK && not S_UP_TO_DATE -->
++++	{% if S_VERSIONCHECK && not S_UP_TO_DATE %}
+++ 	<div class="alert alert-update">
+++ 	  
+++       <div class="row">	
+++       <div class="col-md-12">
+++ 	   	
+++ 	  <div class="col-md-6">	
+++-		<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
+++-		    <span class="description_name">{L_CURRENT_VERSION}{L_COLON}</span>
++++		<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
++++		    <span class="description_name">{{ lang('CURRENT_VERSION') }}{{ lang('COLON') }}</span>
+++ 			<div class="extension_latest_version_wrapper">
+++-			<strong class="extension_latest_version label label-warning">{META_VERSION}</strong>
++++			<strong class="extension_latest_version label label-warning">{{ META_VERSION }}</strong>
+++ 			</div>
+++ 	    </div>
+++ 	  </div>
+++ 	  
+++ 	  <div class="col-md-6">	
+++-		<!-- BEGIN updates_available -->
+++-			<span class="requirements_title">{L_LATEST_VERSION}{L_COLON}</span>
++++		{% for updates_available in loops.updates_available %}
++++			<span class="requirements_title">{{ lang('LATEST_VERSION') }}{{ lang('COLON') }}</span>
+++ 			<div class="extension_latest_version_wrapper">
+++-				<strong class="extension_latest_version label label-success">{updates_available.current}</strong>
+++-				<!-- IF updates_available.download-->
+++-				<a href="{updates_available.download}" class="extension_author_link" title="{L_DOWNLOAD_LATEST}"><i class="fa fa-download"></i></a>
+++-				<!-- ENDIF -->
+++-				<!-- IF updates_available.announcement -->
+++-				<a href="{updates_available.announcement}" class="extension_author_link" title="{L_ANNOUNCEMENT_TOPIC}"><i class="fa fa-bullhorn"></i></a>
+++-				<!-- ENDIF -->
++++				<strong class="extension_latest_version label label-success">{{ updates_available.current }}</strong>
++++				{% if updates_available.download%}
++++				<a href="{{ updates_available.download }}" class="extension_author_link" title="{{ lang('DOWNLOAD_LATEST') }}"><i class="fa fa-download"></i></a>
++++				{% endif %}
++++				{% if updates_available.announcement %}
++++				<a href="{{ updates_available.announcement }}" class="extension_author_link" title="{{ lang('ANNOUNCEMENT_TOPIC') }}"><i class="fa fa-bullhorn"></i></a>
++++				{% endif %}
+++ 			</div>
+++-		<!-- END updates_available -->
++++		{% endfor %}
+++ 	   </div>	
+++ 	  
+++ 	  </div>
+++      </div>	  
+++ 		
+++ 	</div>
+++-	<!-- ENDIF -->
++++	{% endif %}
+++ 
+++ 	<div class="description_div">
+++ 		<div>
+++ 			<div>
+++ 				<p class="description_list">
+++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_DESCRIPTION_PAGE}</span><br />
+++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_1}</span><br />
+++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_2}</span><br />
+++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_3}</span><br />
+++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_4}</span><br />
+++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_5}</span><br />
+++-					<span><i class="fa fa-fw fa-check"></i> {L_SIDEBAR_TASKS_6}</span><br />
++++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_DESCRIPTION_PAGE') }}</span><br />
++++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_1') }}</span><br />
++++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_2') }}</span><br />
++++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_3') }}</span><br />
++++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_4') }}</span><br />
++++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_5') }}</span><br />
++++					<span><i class="fa fa-fw fa-check"></i> {{ lang('SIDEBAR_TASKS_6') }}</span><br />
+++ 				</p>
+++ 			</div>
+++ 		</div>
+++ 	</div>
+++ 	<div class="description_bubble big_bubble">
+++-		<span class="description_name">{L_CLEAN_NAME}{L_COLON}</span>
+++-		<strong class="description_value" id="meta_name">{META_NAME}</strong>
++++		<span class="description_name">{{ lang('CLEAN_NAME') }}{{ lang('COLON') }}</span>
++++		<strong class="description_value" id="meta_name">{{ META_NAME }}</strong>
+++ 	</div>
+++-	<!-- IF S_VERSIONCHECK && S_UP_TO_DATE -->
+++-	<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
+++-		<span class="description_name">{L_VERSION}{L_COLON}</span>
+++-		<span class="description_value description_value_ok" id="meta_version">{META_VERSION}</span>
++++	{% if S_VERSIONCHECK && S_UP_TO_DATE %}
++++	<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
++++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
++++		<span class="description_value description_value_ok" id="meta_version">{{ META_VERSION }}</span>
+++ 	</div>
+++-	<!-- ELSE IF S_VERSIONCHECK && not S_UP_TO_DATE -->
+++-	<div class="description_bubble small_bubble" title="{UP_TO_DATE_MSG}">
+++-		<span class="description_name">{L_VERSION}{L_COLON}</span>
+++-		<span class="description_value description_value_old" id="meta_version">{META_VERSION}</span>
++++	{% elseif S_VERSIONCHECK && not S_UP_TO_DATE %}
++++	<div class="description_bubble small_bubble" title="{{ UP_TO_DATE_MSG }}">
++++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
++++		<span class="description_value description_value_old" id="meta_version">{{ META_VERSION }}</span>
+++ 	</div>
+++-	<!-- ELSE -->
++++	{% else %}
+++ 	<div class="description_bubble small_bubble">
+++-		<span class="description_name">{L_VERSION}{L_COLON}</span>
+++-		<span class="description_value" id="meta_version">{META_VERSION}</span>
++++		<span class="description_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span>
++++		<span class="description_value" id="meta_version">{{ META_VERSION }}</span>
+++ 	</div>
+++-	<!-- ENDIF -->
+++-	<!-- IF META_HOMEPAGE -->
++++	{% endif %}
++++	{% if META_HOMEPAGE %}
+++ 	<div class="description_bubble big_bubble">
+++-		<span class="description_name">{L_HOMEPAGE}{L_COLON}</span>
+++-		<strong class="description_value" id="meta_homepage"><a href="{META_HOMEPAGE}"><i class="fa fa-globe"></i> {META_HOMEPAGE}</a></strong>
++++		<span class="description_name">{{ lang('HOMEPAGE') }}{{ lang('COLON') }}</span>
++++		<strong class="description_value" id="meta_homepage"><a href="{{ META_HOMEPAGE }}"><i class="fa fa-globe"></i> {{ META_HOMEPAGE }}</a></strong>
+++ 	</div>
+++-	<!-- ENDIF -->
+++-	<!-- IF META_TIME -->
++++	{% endif %}
++++	{% if META_TIME %}
+++ 	<div class="description_bubble small_bubble">
+++-		<span class="description_name">{L_TIME}{L_COLON}</span>
+++-		<span class="description_value" id="meta_time">{META_TIME}</span>
++++		<span class="description_name">{{ lang('TIME') }}{{ lang('COLON') }}</span>
++++		<span class="description_value" id="meta_time">{{ META_TIME }}</span>
+++ 	</div>
+++-	<!-- ENDIF -->
++++	{% endif %}
+++ 	<div class="description_bubble small_bubble">
+++-		<span class="description_name">{L_LICENSE}{L_COLON}</span>
+++-		<span class="description_value" id="meta_license" style="padding:0 15px;">{L_LICENSE_INFO}</span>
++++		<span class="description_name">{{ lang('LICENSE') }}{{ lang('COLON') }}</span>
++++		<span class="description_value" id="meta_license" style="padding:0 15px;">{{ lang('LICENSE_INFO') }}</span>
+++ 	</div>
+++ 
+++-	<!-- IF META_REQUIRE_PHPBB || META_REQUIRE_PHP -->
++++	{% if META_REQUIRE_PHPBB || META_REQUIRE_PHP %}
+++ 	<div>
+++-		<span class="requirements_title">{L_REQUIREMENTS}{L_COLON}</span>
+++-		<!-- IF META_REQUIRE_PHPBB -->
++++		<span class="requirements_title">{{ lang('REQUIREMENTS') }}{{ lang('COLON') }}</span>
++++		{% if META_REQUIRE_PHPBB %}
+++ 		<div class="requirements_bubble">
+++-			<span class="requirements_name">{L_PHPBB_VERSION}{L_COLON}</span>
+++-			<span class="requirements_value<!-- IF META_REQUIRE_PHPBB_FAIL --> requirements_value_not_met<!-- ENDIF -->" id="require_phpbb">{META_REQUIRE_PHPBB}</span>
++++			<span class="requirements_name">{{ lang('PHPBB_VERSION') }}{{ lang('COLON') }}</span>
++++			<span class="requirements_value{% if META_REQUIRE_PHPBB_FAIL %} requirements_value_not_met{% endif %}" id="require_phpbb">{{ META_REQUIRE_PHPBB }}</span>
+++ 		</div>
+++-		<!-- ENDIF -->
+++-		<!-- IF META_REQUIRE_PHP -->
++++		{% endif %}
++++		{% if META_REQUIRE_PHP %}
+++ 		<div class="requirements_bubble">
+++-			<span class="requirements_name">{L_PHP_VERSION}{L_COLON}</span>
+++-			<span class="requirements_value<!-- IF META_REQUIRE_PHP_FAIL --> requirements_value_not_met<!-- ENDIF -->" id="require_php">{META_REQUIRE_PHP}</span>
++++			<span class="requirements_name">{{ lang('PHP_VERSION') }}{{ lang('COLON') }}</span>
++++			<span class="requirements_value{% if META_REQUIRE_PHP_FAIL %} requirements_value_not_met{% endif %}" id="require_php">{{ META_REQUIRE_PHP }}</span>
+++ 		</div>
+++-		<!-- ENDIF -->
++++		{% endif %}
+++ 	</div>
+++-	<!-- ENDIF -->
++++	{% endif %}
+++ 
+++ 	<div>
+++-		<span class="requirements_title">{L_EXTENSION_DEVELOPER}{L_COLON}</span>
+++-		<!-- BEGIN meta_authors -->
++++		<span class="requirements_title">{{ lang('EXTENSION_DEVELOPER') }}{{ lang('COLON') }}</span>
++++		{% for meta_authors in loops.meta_authors %}
+++ 		<div class="extension_author">
+++-			<strong class="extension_author_name">{meta_authors.AUTHOR_NAME}</strong>
+++-			<!-- IF meta_authors.AUTHOR_EMAIL -->
+++-			<a href="mailto:{meta_authors.AUTHOR_EMAIL}" title="{L_AUTHOR_EMAIL}" class="extension_author_link"><i class="fa fa-envelope"></i></a>
+++-			<!-- ENDIF -->
+++-			<!-- IF meta_authors.AUTHOR_HOMEPAGE -->
+++-			<a href="{meta_authors.AUTHOR_HOMEPAGE}" title="{L_AUTHOR_HOMEPAGE}" class="extension_author_link"><i class="fa fa-globe"></i></a>
+++-			<!-- ENDIF -->
++++			<strong class="extension_author_name">{{ meta_authors.AUTHOR_NAME }}</strong>
++++			{% if meta_authors.AUTHOR_EMAIL %}
++++			<a href="mailto:{{ meta_authors.AUTHOR_EMAIL }}" title="{{ lang('AUTHOR_EMAIL') }}" class="extension_author_link"><i class="fa fa-envelope"></i></a>
++++			{% endif %}
++++			{% if meta_authors.AUTHOR_HOMEPAGE %}
++++			<a href="{{ meta_authors.AUTHOR_HOMEPAGE }}" title="{{ lang('AUTHOR_HOMEPAGE') }}" class="extension_author_link"><i class="fa fa-globe"></i></a>
++++			{% endif %}
+++ 		</div>
+++-		<!-- END meta_authors -->
++++		{% endfor %}
+++ 	</div>
+++ 	
+++ 	<div class="clearfix">
+++ 	<br/>
+++-	<button type="button" class="btn md-close btn-block" data-dismiss="modal">{L_ACP_SIDEBAR_NOTICE_CLOSE}</button>
++++	<button type="button" class="btn md-close btn-block" data-dismiss="modal">{{ lang('ACP_SIDEBAR_NOTICE_CLOSE') }}</button>
+++ 	</div>
+++ 	
+++ </div>
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
+++index 1b366fc15..b68eb0fe7 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/adm/style/acp_sidebar.html"
+++@@ -1,24 +1,24 @@
+++-<!-- IF S_ALLOW_CDN -->
+++-<!-- INCLUDECSS //maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css -->
+++-<!-- ELSE -->
+++-<!-- INCLUDECSS {ROOT_PATH}ext/sitesplat/sidebar/vendor/font-awesome/css/font-awesome.min.css -->
+++-<!-- ENDIF -->
+++-<!-- INCLUDECSS {ROOT_PATH}ext/sitesplat/sidebar/vendor/bootstrap/css/bootstrap_modified.css -->
+++-<!-- INCLUDECSS css/sidebar.css -->
+++-<!-- INCLUDECSS css/component.css -->
++++{% if S_ALLOW_CDN %}
++++{% INCLUDECSS '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' %}
++++{% else %}
++++{% INCLUDECSS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/font-awesome/css/font-awesome.min.css' %}
++++{% endif %}
++++{% INCLUDECSS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/bootstrap/css/bootstrap_modified.css' %}
++++{% INCLUDECSS 'css/sidebar.css' %}
++++{% INCLUDECSS 'css/component.css' %}
+++ 
+++-<!-- INCLUDE overall_header.html -->
++++{% INCLUDE 'overall_header.html' %}
+++ 
+++-<h1>{L_ACP_SIDEBAR_TITLE} <a href="javascript:void(0)" class="md-trigger" data-remote="{U_ACTION}&amp;action=details" data-toggle="modal" data-target="#myModal"><span class="label label-success">{L_ACP_SIDEBAR_VERSION} <i class="fa fa-info-circle"></i></span></a></h1>
++++<h1>{{ lang('ACP_SIDEBAR_TITLE') }} <a href="javascript:void(0)" class="md-trigger" data-remote="{{ U_ACTION }}&amp;action=details" data-toggle="modal" data-target="#myModal"><span class="label label-success">{{ lang('ACP_SIDEBAR_VERSION') }} <i class="fa fa-info-circle"></i></span></a></h1>
+++ 
+++ 		<!-- Modal -->
+++ 		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
+++ 		  <div class="modal-dialog" role="document">
+++ 			<div class="modal-content md-content">
+++-			  <h3><i class="icon-bbreact-emo-beer" style="margin-right:20px;"></i> {L_ACP_SIDEBAR_TITLE}</h3>
++++			  <h3><i class="icon-bbreact-emo-beer" style="margin-right:20px;"></i> {{ lang('ACP_SIDEBAR_TITLE') }}</h3>
+++ 			  <div class="modal-body">
+++ 			   <div class="panel-body">
+++-				<div class="loader">{L_ACP_LOADING}</div>
++++				<div class="loader">{{ lang('ACP_LOADING') }}</div>
+++ 			   </div>
+++ 			  <div class="modal-footer">
+++ 			  </div>
+++@@ -28,37 +28,37 @@
+++ 		</div>
+++ 
+++ 
+++-<p>{L_AD_SIDEBAR_EXPLAIN}</p>
++++<p>{{ lang('AD_SIDEBAR_EXPLAIN') }}</p>
+++ 
+++-<!-- IF S_NOTICE_LIKEDD or S_NOTICE_BBREACTION or S_NOTICE_BBDONATION or S_NOTICE_BBMEMBERSHIP or S_NOTICE_BADGE or S_NOTICE_BBPOINTS or S_NOTICE_NEWSLETTER -->
++++{% if S_NOTICE_LIKEDD or S_NOTICE_BBREACTION or S_NOTICE_BBDONATION or S_NOTICE_BBMEMBERSHIP or S_NOTICE_BADGE or S_NOTICE_BBPOINTS or S_NOTICE_NEWSLETTER %}
+++ <div id="sidbar_notice" class="errorbox notice">
+++-	<a href="{U_BADGE_NOTICE_CLOSE}" data-ajax="close_notice" data-overlay="false" class="close clearfix" title="{L_ACP_SIDEBAR_NOTICE_CLOSE}"></a>
++++	<a href="{{ U_BADGE_NOTICE_CLOSE }}" data-ajax="close_notice" data-overlay="false" class="close clearfix" title="{{ lang('ACP_SIDEBAR_NOTICE_CLOSE') }}"></a>
+++ 	<p>
+++-	 <!-- IF S_NOTICE_LIKEDD -->{S_NOTICE_LIKEDD}<br /><!-- ENDIF -->
+++-	 <!-- IF S_NOTICE_BBREACTION -->{S_NOTICE_BBREACTION}<br /><!-- ENDIF -->
+++-	 <!-- IF S_NOTICE_BBDONATION -->{S_NOTICE_BBDONATION}<br /><!-- ENDIF -->
+++-	 <!-- IF S_NOTICE_BBMEMBERSHIP -->{S_NOTICE_BBMEMBERSHIP}<br /><!-- ENDIF -->
+++-	 <!-- IF S_NOTICE_BADGE -->{S_NOTICE_BADGE}<br /><!-- ENDIF -->
+++-	 <!-- IF S_NOTICE_BBPOINTS -->{S_NOTICE_BBPOINTS}<br /><!-- ENDIF -->
+++-	 <!-- IF S_NOTICE_NEWSLETTER -->{S_NOTICE_NEWSLETTER}<br /><!-- ENDIF -->
+++-	  <!-- IF S_NOTICE_BBDOWNLOAD -->{S_NOTICE_BBDOWNLOAD}<!-- ENDIF -->
++++	 {% if S_NOTICE_LIKEDD %}{{ S_NOTICE_LIKEDD }}<br />{% endif %}
++++	 {% if S_NOTICE_BBREACTION %}{{ S_NOTICE_BBREACTION }}<br />{% endif %}
++++	 {% if S_NOTICE_BBDONATION %}{{ S_NOTICE_BBDONATION }}<br />{% endif %}
++++	 {% if S_NOTICE_BBMEMBERSHIP %}{{ S_NOTICE_BBMEMBERSHIP }}<br />{% endif %}
++++	 {% if S_NOTICE_BADGE %}{{ S_NOTICE_BADGE }}<br />{% endif %}
++++	 {% if S_NOTICE_BBPOINTS %}{{ S_NOTICE_BBPOINTS }}<br />{% endif %}
++++	 {% if S_NOTICE_NEWSLETTER %}{{ S_NOTICE_NEWSLETTER }}<br />{% endif %}
++++	  {% if S_NOTICE_BBDOWNLOAD %}{{ S_NOTICE_BBDOWNLOAD }}{% endif %}
+++ 	</p>
+++ </div>
+++-<!-- ENDIF -->
++++{% endif %}
+++ 
+++ 
+++-<form id="acp_sidebar" method="post" action="{U_ACTION}">
++++<form id="acp_sidebar" method="post" action="{{ U_ACTION }}">
+++ 	<fieldset>
+++-		<legend>{L_ACP_SIDEBAR_OPTIONS}</legend>
++++		<legend>{{ lang('ACP_SIDEBAR_OPTIONS') }}</legend>
+++ 		<div class="sidebar-wrapper">
+++ 		<style>
+++ 			#sidebar-nav {
+++-				width:<!-- IF SIDEBAR_WIDTH -->50<!-- ELSE -->30<!-- ENDIF -->px;
+++-				float:<!-- IF SIDEBAR_TYPE -->right<!-- ELSE -->left<!-- ENDIF -->;
++++				width:{% if SIDEBAR_WIDTH %}50{% else %}30{% endif %}px;
++++				float:{% if SIDEBAR_TYPE %}right{% else %}left{% endif %};
+++ 			}
+++ 			#sidebar-section {
+++-				width:<!-- IF SIDEBAR_WIDTH -->200<!-- ELSE -->220<!-- ENDIF -->px;
+++-				float:<!-- IF SIDEBAR_TYPE -->left<!-- ELSE -->right<!-- ENDIF -->;
++++				width:{% if SIDEBAR_WIDTH %}200{% else %}220{% endif %}px;
++++				float:{% if SIDEBAR_TYPE %}left{% else %}right{% endif %};
+++ 			}
+++ 			</style> 
+++ 			<div class="browser-window">
+++@@ -70,7 +70,7 @@
+++ 			  </div>
+++ 			  <div class="dev-tools">
+++ 			  <div class="bar">
+++-				<div class="dev-bar-content">{L_SITESPLAT_COM}</div>
++++				<div class="dev-bar-content">{{ lang('SITESPLAT_COM') }}</div>
+++ 				<div class="close-x">X</div>
+++ 				<div class="clear"></div>
+++ 			  </div>
+++@@ -79,19 +79,19 @@
+++ 			<div class="content">
+++ 			
+++ 			<div class="inner-browser">
+++-			<div id="sidebar-header">{L_FLATBOOTS}</div>
++++			<div id="sidebar-header">{{ lang('FLATBOOTS') }}</div>
+++ 			
+++-			<div id="sidebar-nav">{L_ONE_S}<br />{L_ONE_I}<br />{L_ONE_D}<br />{L_ONE_E}<br />{L_ONE_B}<br />{L_ONE_A}<br />{L_ONE_R}</div>
++++			<div id="sidebar-nav">{{ lang('ONE_S') }}<br />{{ lang('ONE_I') }}<br />{{ lang('ONE_D') }}<br />{{ lang('ONE_E') }}<br />{{ lang('ONE_B') }}<br />{{ lang('ONE_A') }}<br />{{ lang('ONE_R') }}</div>
+++ 			
+++ 			<div id="sidebar-section">
+++ 			<p class="forum-wrapper">
+++-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
+++-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
+++-			 <span class="forum-content">{L_FORUM_CONTENT}</span>
++++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
++++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
++++			 <span class="forum-content">{{ lang('FORUM_CONTENT') }}</span>
+++ 			</p>
+++ 			</div>
+++ 			
+++-			<div id="sidebar-footer">{L_SITESPLAT_COPY}</div>
++++			<div id="sidebar-footer">{{ lang('SITESPLAT_COPY') }}</div>
+++ 			</div>
+++ 			
+++ 			</div>
+++@@ -102,11 +102,11 @@
+++ 
+++ 		<div style="float:left;width:80%;">
+++ 		<dl>
+++-			<dt><label id="type" for="sidebartype">{L_ACP_SIDEBAR_TYPE}{L_COLON}</label><br /> {L_ACP_SIDEBAR_TYPE_EXPLAIN}</dt>
++++			<dt><label id="type" for="sidebartype">{{ lang('ACP_SIDEBAR_TYPE') }}{{ lang('COLON') }}</label><br /> {{ lang('ACP_SIDEBAR_TYPE_EXPLAIN') }}</dt>
+++ 			<dd>
+++ 
+++ 				    <div class="onoffswitch">
+++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebartype" name="type"{SIDEBAR_TYPE}>
++++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebartype" name="type"{{ SIDEBAR_TYPE }}>
+++ 						<label class="onoffswitch-label" for="sidebartype">
+++ 							<span class="onoffswitch-inner onoffswitch-inner-position"></span>
+++ 							<span class="onoffswitch-switch"></span>
+++@@ -116,11 +116,11 @@
+++ 			</dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label for="width_s">{L_ACP_SIDEBAR_WIDTH}</label><br />{L_ACP_SIDEBAR_WIDTH_EXPLAIN}</dt>
++++			<dt><label for="width_s">{{ lang('ACP_SIDEBAR_WIDTH') }}</label><br />{{ lang('ACP_SIDEBAR_WIDTH_EXPLAIN') }}</dt>
+++ 			<dd>
+++ 				
+++ 				 <div class="onoffswitch">
+++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="width_s" name="width"{SIDEBAR_WIDTH}>
++++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="width_s" name="width"{{ SIDEBAR_WIDTH }}>
+++ 						<label class="onoffswitch-label" for="width_s">
+++ 							<span class="onoffswitch-inner onoffswitch-inner-width"></span>
+++ 							<span class="onoffswitch-switch"></span>
+++@@ -131,11 +131,11 @@
+++ 		</dl>
+++ 		
+++ 		<dl>
+++-			<dt><label for="height">{L_ACP_SIDEBAR_HEIGHT}</label><br />{L_ACP_SIDEBAR_HEIGHT_EXPLAIN}</dt>
++++			<dt><label for="height">{{ lang('ACP_SIDEBAR_HEIGHT') }}</label><br />{{ lang('ACP_SIDEBAR_HEIGHT_EXPLAIN') }}</dt>
+++ 			<dd>
+++ 					
+++ 				<div class="onoffswitch">
+++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="height" name="height"{SIDEBAR_HEIGHT}>
++++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="height" name="height"{{ SIDEBAR_HEIGHT }}>
+++ 						<label class="onoffswitch-label" for="height">
+++ 							<span class="onoffswitch-inner"></span>
+++ 							<span class="onoffswitch-switch"></span>
+++@@ -147,11 +147,11 @@
+++ 		
+++ 		
+++ 		<dl>
+++-			<dt><label for="all_pages">{L_ACP_SIDEBAR_ALL_PAGES}</label><br />{L_ACP_SIDEBAR_ALL_PAGES_EXPLAIN}</dt>
++++			<dt><label for="all_pages">{{ lang('ACP_SIDEBAR_ALL_PAGES') }}</label><br />{{ lang('ACP_SIDEBAR_ALL_PAGES_EXPLAIN') }}</dt>
+++ 			<dd>
+++ 
+++ 				<div class="onoffswitch">
+++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="all_pages" name="all_pages"{SIDEBAR_ALL_PAGES}>
++++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="all_pages" name="all_pages"{{ SIDEBAR_ALL_PAGES }}>
+++ 						<label class="onoffswitch-label" for="all_pages">
+++ 							<span class="onoffswitch-inner"></span>
+++ 							<span class="onoffswitch-switch"></span>
+++@@ -162,10 +162,10 @@
+++ 		</dl>
+++ 		
+++ 		<dl>
+++-		<dt><label for="all_pages">{L_ACP_SIDEBAR_PANEL_PAGES}</label><br />{L_ACP_SIDEBAR_PANEL_PAGES_EXPLAIN}</dt>
++++		<dt><label for="all_pages">{{ lang('ACP_SIDEBAR_PANEL_PAGES') }}</label><br />{{ lang('ACP_SIDEBAR_PANEL_PAGES_EXPLAIN') }}</dt>
+++ 			<dd>
+++ 				<div class="onoffswitch">
+++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="panel_pages" name="panel_pages"{SIDEBAR_PANEL_PAGES}>
++++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="panel_pages" name="panel_pages"{{ SIDEBAR_PANEL_PAGES }}>
+++ 						<label class="onoffswitch-label" for="panel_pages">
+++ 							<span class="onoffswitch-inner"></span>
+++ 							<span class="onoffswitch-switch"></span>
+++@@ -176,11 +176,11 @@
+++ 			</dl>
+++ 		
+++ 		<dl>
+++-			<dt><label for="shuffle">{L_ACP_SIDEBAR_SHUFFLE}</label><br />{L_ACP_SIDEBAR_SHUFFLE_EXPLAIN}</dt>
++++			<dt><label for="shuffle">{{ lang('ACP_SIDEBAR_SHUFFLE') }}</label><br />{{ lang('ACP_SIDEBAR_SHUFFLE_EXPLAIN') }}</dt>
+++ 			<dd>
+++ 
+++ 				<div class="onoffswitch">
+++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="shuffle" name="shuffle"{SIDEBAR_SHUFFLE}>
++++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="shuffle" name="shuffle"{{ SIDEBAR_SHUFFLE }}>
+++ 						<label class="onoffswitch-label" for="shuffle">
+++ 							<span class="onoffswitch-inner"></span>
+++ 							<span class="onoffswitch-switch"></span>
+++@@ -190,16 +190,16 @@
+++ 			</dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label for="slots">{L_ACP_SIDEBAR_SLOTS}</label><br />{L_ACP_SIDEBAR_SLOTS_EXPLAIN}</dt>
++++			<dt><label for="slots">{{ lang('ACP_SIDEBAR_SLOTS') }}</label><br />{{ lang('ACP_SIDEBAR_SLOTS_EXPLAIN') }}</dt>
+++ 			<dd>
+++-			 <input type="range" name="slots" id="slots" min="1" max="10" step="1" value="{SLOTS}" oninput="rangevalue1.value=value" />
++++			 <input type="range" name="slots" id="slots" min="1" max="10" step="1" value="{{ SLOTS }}" oninput="rangevalue1.value=value" />
+++              <output id="rangevalue1"></output>
+++ 			</dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label id="how_many" for="how_many">{L_HOWMANY}</label><br />{L_HOWMANY_EXPLAIN}</dt>
++++			<dt><label id="how_many" for="how_many">{{ lang('HOWMANY') }}</label><br />{{ lang('HOWMANY_EXPLAIN') }}</dt>
+++ 			<dd>
+++-			 <input type="range" name="how_many" id="how_many" min="1" max="10" step="1" value="{HOWMANY}" oninput="rangevalue.value=value" />
++++			 <input type="range" name="how_many" id="how_many" min="1" max="10" step="1" value="{{ HOWMANY }}" oninput="rangevalue.value=value" />
+++              <output id="rangevalue"></output>
+++ 			</dd>
+++ 		</dl>
+++@@ -210,11 +210,11 @@
+++ 		
+++ 		<dl style="clear:both;">
+++ 			<dt style="width:36%;">
+++-			<label id="ignore" for="ignore_inactive_users ignore_founder show_admins_mods">{L_IGNORE}</label><br />{L_IGNORE_EXPLAIN}</dt>
++++			<label id="ignore" for="ignore_inactive_users ignore_founder show_admins_mods">{{ lang('IGNORE') }}</label><br />{{ lang('IGNORE_EXPLAIN') }}</dt>
+++ 			<dd style="margin-left:36%;">
+++-			<div class="label-entry">{L_IGNORE_USERS}</div>
+++-			<div class="label-entry">{L_IGNORE_FOUNDER}</div>
+++-			<div class="label-entry">{L_IGNORE_ADMINS_MODS}</div>
++++			<div class="label-entry">{{ lang('IGNORE_USERS') }}</div>
++++			<div class="label-entry">{{ lang('IGNORE_FOUNDER') }}</div>
++++			<div class="label-entry">{{ lang('IGNORE_ADMINS_MODS') }}</div>
+++ 			</dd>
+++ 			
+++ 			<dd style="margin-left:36%;">
+++@@ -222,7 +222,7 @@
+++ 				<div class="label-wrap">
+++ 
+++ 				 <div class="onoffswitch">
+++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_inactive_users" name="ignore_inactive_users"{IGNORE_INACTIVE}>
++++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_inactive_users" name="ignore_inactive_users"{{ IGNORE_INACTIVE }}>
+++ 						<label class="onoffswitch-label" for="ignore_inactive_users">
+++ 							<span class="onoffswitch-inner"></span>
+++ 							<span class="onoffswitch-switch"></span>
+++@@ -234,7 +234,7 @@
+++ 				<div class="label-wrap">
+++ 
+++ 				    <div class="onoffswitch">
+++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_founder" name="ignore_founder"{IGNORE_FOUNDER}>
++++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_founder" name="ignore_founder"{{ IGNORE_FOUNDER }}>
+++ 						<label class="onoffswitch-label" for="ignore_founder">
+++ 							<span class="onoffswitch-inner"></span>
+++ 							<span class="onoffswitch-switch"></span>
+++@@ -247,7 +247,7 @@
+++ 				
+++ 				
+++ 				    <div class="onoffswitch">
+++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_admins_mods" name="ignore_admins_mods"{IGNORE_ADMINS_MODS}>
++++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="ignore_admins_mods" name="ignore_admins_mods"{{ IGNORE_ADMINS_MODS }}>
+++ 						<label class="onoffswitch-label" for="ignore_admins_mods">
+++ 							<span class="onoffswitch-inner"></span>
+++ 							<span class="onoffswitch-switch"></span>
+++@@ -263,34 +263,34 @@
+++ 
+++ 	
+++ 	<fieldset class="dtdd-fix">
+++-		<legend>{L_ACP_SIDEBAR_HEADSUP}{L_COLON}</legend>
+++-		<p>{L_ACP_SIDEBAR_HEADSIP_EXPLAIN}</p>
++++		<legend>{{ lang('ACP_SIDEBAR_HEADSUP') }}{{ lang('COLON') }}</legend>
++++		<p>{{ lang('ACP_SIDEBAR_HEADSIP_EXPLAIN') }}</p>
+++ 	</fieldset>	
+++ 	
+++ 	<fieldset class="dtdd-fix">
+++-		<legend>{L_ACP_SIDEBAR_SETTINGS}{L_COLON}</legend>
++++		<legend>{{ lang('ACP_SIDEBAR_SETTINGS') }}{{ lang('COLON') }}</legend>
+++ 		<script>
+++-		var rule_type = [{OPTION_ARY}];
++++		var rule_type = [{{ OPTION_ARY }}];
+++ 		</script>
+++ 		<dl>
+++ 			<dt style="width:36%;"></dt>
+++ 			<dd style="margin-left:36%;">
+++-				<span style="width:120px;display:inline-block;">{L_SHOW_TYPE}{L_COLON}</span>
+++-				<span style="width:150px;display:inline-block;">{L_SHOW_MOBILE}{L_COLON}</span>
+++-				<span style="width:150px;display:inline-block;">{L_SHOW_TABLET}{L_COLON}</span>
++++				<span style="width:120px;display:inline-block;">{{ lang('SHOW_TYPE') }}{{ lang('COLON') }}</span>
++++				<span style="width:150px;display:inline-block;">{{ lang('SHOW_MOBILE') }}{{ lang('COLON') }}</span>
++++				<span style="width:150px;display:inline-block;">{{ lang('SHOW_TABLET') }}{{ lang('COLON') }}</span>
+++ 			</dd>
+++ 		</dl>
+++-		<!-- BEGIN slots -->
++++		{% for slots in loops.slots %}
+++ 		<dl>
+++-			<dt style="width:36%;"><label id="sidebar_slot{slots.ID}_active" for="sidebar_slot{slots.ID}_active">{L_ACP_SIDEBAR_SLOT} {slots.ID}</label></dt>
++++			<dt style="width:36%;"><label id="sidebar_slot{{ slots.ID }}_active" for="sidebar_slot{{ slots.ID }}_active">{{ lang('ACP_SIDEBAR_SLOT') }} {{ slots.ID }}</label></dt>
+++ 			<dd style="margin-left:36%;">
+++-				<select style="float:left;" name="sidebar[slot{slots.ID}][_active]]" id="sidebar_slot{slots.ID}_active">{slots.ACTIVE_SLOT}</select>
++++				<select style="float:left;" name="sidebar[slot{{ slots.ID }}][_active]]" id="sidebar_slot{{ slots.ID }}_active">{{ slots.ACTIVE_SLOT }}</select>
+++ 			
+++ 			<div style="display:inline-block; margin-left:20px;">
+++-				<div id="show_mobile{slots.ID}" style="display:{slots.OPTION_SLOT};">
++++				<div id="show_mobile{{ slots.ID }}" style="display:{{ slots.OPTION_SLOT }};">
+++ 					<div class="onoffswitch">
+++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{slots.ID}_show_mobile" name="options[slot{slots.ID}][_mobile]]"{slots.SHOW_MOBILE}>
+++-						<label class="onoffswitch-label" for="sidebar_slot{slots.ID}_show_mobile">
++++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{{ slots.ID }}_show_mobile" name="options[slot{{ slots.ID }}][_mobile]]"{{ slots.SHOW_MOBILE }}>
++++						<label class="onoffswitch-label" for="sidebar_slot{{ slots.ID }}_show_mobile">
+++ 							<span class="onoffswitch-inner onoffswitch-inner-yn"></span>
+++ 							<span class="onoffswitch-switch"></span>
+++ 						</label>
+++@@ -299,10 +299,10 @@
+++ 			</div>
+++ 			
+++ 			<div style="display:inline-block; margin-left:20px;">
+++-				<div id="show_tablet{slots.ID}" style="display:{slots.OPTION_SLOT};">
++++				<div id="show_tablet{{ slots.ID }}" style="display:{{ slots.OPTION_SLOT }};">
+++ 				<div class="onoffswitch">
+++-						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{slots.ID}_show_tablet" name="options[slot{slots.ID}][_tablet]]"{slots.SHOW_TABLET}>
+++-						<label class="onoffswitch-label" for="sidebar_slot{slots.ID}_show_tablet">
++++						<input type="checkbox" class="onoffswitch-checkbox" value="1" id="sidebar_slot{{ slots.ID }}_show_tablet" name="options[slot{{ slots.ID }}][_tablet]]"{{ slots.SHOW_TABLET }}>
++++						<label class="onoffswitch-label" for="sidebar_slot{{ slots.ID }}_show_tablet">
+++ 							<span class="onoffswitch-inner onoffswitch-inner-yn"></span>
+++ 							<span class="onoffswitch-switch"></span>
+++ 						</label>
+++@@ -312,29 +312,29 @@
+++ 				
+++ 			</dd>
+++ 		</dl>
+++-		<div id="sidebar_slot{slots.ID}" style="display:{slots.VISIBILTY_SLOT};">
++++		<div id="sidebar_slot{{ slots.ID }}" style="display:{{ slots.VISIBILTY_SLOT }};">
+++ 		<dl>
+++-			<dt style="width:36%;"><label for="sidebar_slot{slots.ID}_title">{L_ACP_TITLE_SLOT} {slots.ID}</label><br />{L_ACP_TITLE_SLOT_EXPLAIN}</dt>
++++			<dt style="width:36%;"><label for="sidebar_slot{{ slots.ID }}_title">{{ lang('ACP_TITLE_SLOT') }} {{ slots.ID }}</label><br />{{ lang('ACP_TITLE_SLOT_EXPLAIN') }}</dt>
+++ 			<dd style="margin-left:36%;">
+++-				<input type="text" name="sidebar[slot{slots.ID}][_title]]" value="{slots.SIDEBAR_TITLE}" size="50" />
++++				<input type="text" name="sidebar[slot{{ slots.ID }}][_title]]" value="{{ slots.SIDEBAR_TITLE }}" size="50" />
+++ 			</dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt style="width:36%;"><label for="sidebar_slot{slots.ID}_text">{L_ACP_SIDEBAR_TEXT}{L_COLON}</label><br />{L_ACP_SIDEBAR_TEXT_EXPLAIN}</dt>
+++-			<dd style="margin-left:36%;"><textarea name="sidebar[slot{slots.ID}][_text]]" rows="3" cols="40">{slots.SIDEBAR_TEXT}</textarea></dd>
++++			<dt style="width:36%;"><label for="sidebar_slot{{ slots.ID }}_text">{{ lang('ACP_SIDEBAR_TEXT') }}{{ lang('COLON') }}</label><br />{{ lang('ACP_SIDEBAR_TEXT_EXPLAIN') }}</dt>
++++			<dd style="margin-left:36%;"><textarea name="sidebar[slot{{ slots.ID }}][_text]]" rows="3" cols="40">{{ slots.SIDEBAR_TEXT }}</textarea></dd>
+++ 		</dl>
+++ 		</div>
+++ 		<hr />
+++-		<!-- END slots -->
++++		{% endfor %}
+++ 		<p class="submit-buttons">
+++-			<input class="button1" type="submit" name="update" value="{L_SUBMIT}" />&nbsp;
+++-			<input class="button2" type="reset" id="reset" name="reset" value="{L_RESET}" />
+++-			{S_FORM_TOKEN}
++++			<input class="button1" type="submit" name="update" value="{{ lang('SUBMIT') }}" />&nbsp;
++++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
++++			{{ S_FORM_TOKEN }}
+++ 		</p>
+++ 	</fieldset>
+++ </form>
+++ 
+++-<!-- INCLUDEJS js/sidebar.js -->
+++-<!-- INCLUDEJS {ROOT_PATH}ext/sitesplat/sidebar/vendor/bootstrap/js/bootstrap.min.js -->
++++{% INCLUDEJS 'js/sidebar.js' %}
++++{% INCLUDEJS ''~ ROOT_PATH ~'ext/sitesplat/sidebar/vendor/bootstrap/js/bootstrap.min.js' %}
+++ <div class="md-overlay"></div><!-- the overl
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/event/listener.php"
++index e4cc61427..ec79cb720 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/event/listener.php"
++@@ -29,8 +29,9 @@ class listener implements EventSubscriberInterface
++ 	protected $config;
++ 	protected $root_path;
++ 	protected $php_ext;
+++	protected $ext_manager;
++ 
++-	public function __construct(\sitesplat\sidebar\types\manager $manager, \phpbb\user $user, \phpbb\request\request $request, \phpbb\config\db_text $config_text, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\config\config $config, $phpbb_root_path, $php_ext)
+++	public function __construct(\sitesplat\sidebar\types\manager $manager, \phpbb\user $user, \phpbb\request\request $request, \phpbb\config\db_text $config_text, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\config\config $config, $phpbb_root_path, $php_ext, \phpbb\extension\manager $ext_manager)
++ 	{
++ 		$this->manager = $manager;
++ 		$this->user = $user;
++@@ -41,6 +42,7 @@ class listener implements EventSubscriberInterface
++ 		$this->config = $config;
++ 		$this->phpbb_root_path = $phpbb_root_path;
++ 		$this->php_ext = $php_ext;
+++		$this->ext_manager = $ext_manager;
++ 	}
++ 
++ 	static public function getSubscribedEvents()
++@@ -99,7 +101,14 @@ class listener implements EventSubscriberInterface
++ 				($this->manager->is_enabled($type_name) && $this->manager->is_enabled($type_name) && $slot[$i-1]['id'] > 1) ? 
++ 					$this->manager->check_condition($type_name) : null;
++ 			}
++-			
+++
+++			if ($this->ext_manager->is_enabled('phpbb/collapsiblecategories'))
+++			{
+++				$this->template->assign_vars(array(
+++					'PHPBB_COLLAPSIBLE_ENABLED'	=> true,
+++				));
+++			}
+++
++ 			$this->template->assign_vars(array(
++ 				'S_SIDEBAR_TYPE'			=> !$sidebar_config['type'],
++ 				'S_SIDEBAR_ALL_PAGES'		=> !$sidebar_config['all_pages'],
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/extra/overall_footer_content_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/extra/overall_footer_content_after.html"
++index 6479064bc..12209ad81 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/extra/overall_footer_content_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/extra/overall_footer_content_after.html"
++@@ -1,5 +1,5 @@
++-<!-- IF S_SIDEBAR_ALL_PAGES or S_INDEX -->
+++{% if S_SIDEBAR_ALL_PAGES or S_INDEX %}
++ 	</div>
++ </div>
++ </div>
++-<!-- ENDIF -->
++\ No newline at end of file
+++{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/extra/overall_header_content_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/extra/overall_header_content_before.html"
++index ba0275eac..d4690c356 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/extra/overall_header_content_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/extra/overall_header_content_before.html"
++@@ -1,18 +1,18 @@
++-<!-- IF S_SIDEBAR_ALL_PAGES or S_INDEX -->
+++{% if S_SIDEBAR_ALL_PAGES or S_INDEX %}
++ <div class="row">
++ 	<div class="col-md-3" id="page-sidebar">
++ 		<div id="sidebar-border">
++-		<!-- BEGIN slot -->
++-		<!-- IF slot.SIDEBAR_SLOT == 1 -->
++-			<!-- DEFINE $TITLE = '{slot.SIDEBAR_TITLE}' -->
++-			<!-- DEFINE $TEXT = '{slot.SIDEBAR_TEXT}' -->
++-			<!-- INCLUDE custom.html -->
++-		<!-- ELSE IF not slot.SIDEBAR_SLOT == 0 -->
++-			<!-- INCLUDE {slot.SIDEBAR_SLOT} -->
++-		<!-- ENDIF -->
++-		<!-- END slot -->
+++		{% for slot in loops.slot %}
+++		{% if slot.SIDEBAR_SLOT == 1 %}
+++			{% DEFINE TITLE = ''~ slot.SIDEBAR_TITLE ~'' %}
+++			{% DEFINE TEXT = ''~ slot.SIDEBAR_TEXT ~'' %}
+++			{% INCLUDE 'custom.html' %}
+++		{% elseif not slot.SIDEBAR_SLOT == 0 %}
+++			{% INCLUDE ''~ slot.SIDEBAR_SLOT ~'' %}
+++		{% endif %}
+++		{% endfor %}
++ 		</div>
++ 	</div>
++ 	<div id="contentje">
++ 	 <div class="col-md-9">
++-<!-- ENDIF -->
++\ No newline at end of file
+++{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/extra/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/extra/overall_header_stylesheets_after.html"
++index 142cfe577..e434bd4e5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/extra/overall_header_stylesheets_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/extra/overall_header_stylesheets_after.html"
++@@ -1,37 +1,37 @@
++-<!-- IF S_INDEX -->
++-	<!-- IF not S_SIDEBAR_TYPE -->
++-		<!-- IF S_SIDEBAR_WIDTH -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarright.css -->
++-		<!-- ELSE -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebar20right.css -->
++-		<!-- ENDIF -->
++-	<!-- ELSE -->
++-		<!-- IF S_SIDEBAR_WIDTH -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft.css -->
++-		<!-- ELSE -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft20.css -->
++-		<!-- ENDIF -->
++-	<!-- ENDIF -->
++-<!-- ENDIF -->
+++{% if S_INDEX %}
+++	{% if not S_SIDEBAR_TYPE %}
+++		{% if S_SIDEBAR_WIDTH %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebarright.css' %}
+++		{% else %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebar20right.css' %}
+++		{% endif %}
+++	{% else %}
+++		{% if S_SIDEBAR_WIDTH %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft.css' %}
+++		{% else %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft20.css' %}
+++		{% endif %}
+++	{% endif %}
+++{% endif %}
++ 
++-<!-- IF S_SIDEBAR_ALL_PAGES and not S_INDEX -->
++-	<!-- IF not S_SIDEBAR_TYPE -->
++-		<!-- IF S_SIDEBAR_WIDTH -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarright.css -->
++-		<!-- ELSE -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebar20right.css -->
++-		<!-- ENDIF -->
++-	<!-- ELSE -->
++-		<!-- IF S_SIDEBAR_WIDTH -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft.css -->
++-		<!-- ELSE -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft20.css -->
++-		<!-- ENDIF -->
++-	<!-- ENDIF -->
++-<!-- ENDIF -->
+++{% if S_SIDEBAR_ALL_PAGES and not S_INDEX %}
+++	{% if not S_SIDEBAR_TYPE %}
+++		{% if S_SIDEBAR_WIDTH %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebarright.css' %}
+++		{% else %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebar20right.css' %}
+++		{% endif %}
+++	{% else %}
+++		{% if S_SIDEBAR_WIDTH %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft.css' %}
+++		{% else %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft20.css' %}
+++		{% endif %}
+++	{% endif %}
+++{% endif %}
++ 
++-<!-- INCLUDECSS @sitesplat_sidebar/sidebar.css -->
+++{% INCLUDECSS '@sitesplat_sidebar/sidebar.css' %}
++ 
++-<!-- IF S_SIDEBAR_DYNAMIC -->
++-	<!-- INCLUDECSS @sitesplat_sidebar/sidebar_dynamic.css -->
++-<!-- ENDIF -->
++\ No newline at end of file
+++{% if S_SIDEBAR_DYNAMIC %}
+++	{% INCLUDECSS '@sitesplat_sidebar/sidebar_dynamic.css' %}
+++{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/language/en/sidebar.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/language/en/sidebar.php"
++index 16e4bd513..878914b28 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/language/en/sidebar.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/language/en/sidebar.php"
++@@ -38,10 +38,10 @@ $lang = array_merge($lang, array(
++ 	'CLOCK'				=> 'Time',
++ 	'LIKEDD'			=> 'Last likes',
++ 	
++-	'LAST_BADGES'		=> 'Last badges',	
+++	'LAST_BADGES'		=> 'Last badges',
++ 	'SIDEBAR_BADGE'		=> 'Badge name',
++ 	'SIDEBAR_DATE'		=> 'Date',
++-	'LAST_BBREACTIONS'	=> 'Last BBreactions',
+++	'LAST_BBREACTIONS'	=> 'Last reactions',
++ 	'SIDEBAR_REACTION'	=> 'Reaction type',
++ 	'BBPOINTS'			=> 'BBpoints',
++ 	'POLL'				=> 'Last poll',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/membership.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/membership.js"
++index 2f4089b9e..e3ca29948 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/membership.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/membership.js"
++@@ -18,8 +18,8 @@ head.ready(function () {
++ 			},
++ 			credits: {
++ 				enabled: false,
++-				text: 'sitesplat.com',
++-				href: 'https://sitesplat.com'
+++				text: 'goldtuganime.com',
+++				href: 'https://goldtuganime.com'
++ 			},
++ 			exporting: { enabled: false },
++ 			tooltip: {
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/poll.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/poll.js"
++index 6bfa67ab2..3291da547 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/poll.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/BBOOTS/template/js/poll.js"
++@@ -18,8 +18,8 @@ head.ready(function () {
++ 			},
++ 			credits: {
++ 				enabled: false,
++-				text: 'sitesplat.com',
++-				href: 'https://sitesplat.com'
+++				text: 'goldtuganime.com',
+++				href: 'https://goldtuganime.com'
++ 			},
++ 			exporting: { enabled: false },
++ 			tooltip: {
++@@ -33,7 +33,7 @@ head.ready(function () {
++                     events: {
++                         click: function () {
++ 							$.ajax({ type: "POST", 
++-							url: sitesplat_board_url + "app.php/sidebar/poll.html", 
+++							url: sitesplat_board_url + "app.php/sidebar/poll.html",
++ 							data: {"f" : this.f,
++ 									"t": this.t,
++ 									"v": this.v},
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbdownloads.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbdownloads.html"
++index ff5984edc..4c5d45f52 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbdownloads.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbdownloads.html"
++@@ -1,44 +1,62 @@
++-<!-- IF .pop_downloads -->
+++{% if loops.pop_downloads|length %}
++ <div class="sidebar">
++-<div id="bbdownloads{slot.SIDEBAR_ID}" class="panel panel-info">
+++<div id="bbdownloads{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
++     <div class="panel-heading">
++-     <h4 class="panel-title">{L_DOWNLOADS}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-bbdownloads{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('DOWNLOADS') }}</span>
++     </div>
++-	<div class="panel-body">
++-	 <div id="bbdownloadsinner{slot.SIDEBAR_ID}" class="inner">
+++	 <div id="innerbbdownloads{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++ 		
++ 		  <ul class="nav nav-pills nav-top-poster nav-justified">
++-			<li class="active"><a data-toggle="pill" href="#popDown">{L_POP_DOWNLOADS}</a></li>
++-			<li><a data-toggle="pill" href="#newDown">{L_NEW_DOWNLOADS}</a></li>
+++			<li class="active"><a data-toggle="pill" href="#popDown">{{ lang('POP_DOWNLOADS') }}</a></li>
+++			<li><a data-toggle="pill" href="#newDown">{{ lang('NEW_DOWNLOADS') }}</a></li>
++ 		  </ul>
++ 		  
++ 		  <div class="tab-content media-list user-list">
++ 			<div id="popDown" class="tab-pane fade in active">
++-				<ul class="media">
++-				<!-- BEGIN pop_downloads -->
++-					<li><a href="{pop_downloads.S_SEARCH_ACTION}">{pop_downloads.TITLE}</a> <span class="pull-right">{pop_downloads.TOTAL}</span><!-- IF not pop_downloads.S_LAST_ROW --><hr /><!-- ENDIF --></li>
++-				<!-- BEGINELSE -->
++-					<li>{L_NO_MEMBERS}<hr /></li>
++-				<!-- END pop_downloads -->	
+++				<ul class="media-list user-list">
+++				{% for pop_downloads in loops.pop_downloads %}
+++					<li class="sidebar-last-column">
+++						<span class="last-wrapper text-overflow">
+++							<a href="{{ pop_downloads.S_SEARCH_ACTION }}">{{ pop_downloads.TITLE }}</a><br />
+++							<span class="pull-right"><i class="fa fa-download"></i>&nbsp;{{ pop_downloads.TOTAL }}</span>
+++						</span>
+++					</li>
+++				{% else %}
+++					<li class="sidebar-last-column">
+++						<span class="last-wrapper text-overflow">
+++							{{ lang('NO_MEMBERS') }}
+++						</span>
+++					</li>
+++				{% endfor %}	
++ 				</ul>
++ 			</div>
++ 				
++ 			<div id="newDown" class="tab-pane fade">
++-				<ul class="media">
++-				<!-- BEGIN new_downloads -->
++-					<li><a href="{new_downloads.S_SEARCH_ACTION}">{new_downloads.TITLE}</a> <span class="pull-right">{new_downloads.TIMESTAMP}</span><!-- IF not new_downloads.S_LAST_ROW --><hr /><!-- ENDIF --></li>
++-				<!-- BEGINELSE -->
++-					<li>{L_NO_MEMBERS}<hr /></li>
++-				<!-- END new_downloads -->	
+++				<ul class="media-list user-list">
+++				{% for new_downloads in loops.new_downloads %}
+++					<li class="sidebar-last-column">
+++						<span class="last-wrapper text-overflow">
+++							<a href="{{ new_downloads.S_SEARCH_ACTION }}">{{ new_downloads.TITLE }}</a><br />
+++							<span class="pull-right forum-time"><i class="fa fa-clock-o"></i>&nbsp;{{ new_downloads.TIMESTAMP }}</span>
+++						</span>
+++					</li>
+++				{% else %}
+++					<li class="sidebar-last-column">
+++						<span class="last-wrapper text-overflow">
+++							{{ lang('NO_MEMBERS') }}
+++						</span>
+++					</li>
+++				{% endfor %}	
++ 				</ul>
++ 			</div>
++ 		  </div>
++ 		</div>
++-	 </div>
++ 	</div>
++ </div>
++-<!-- ENDIF -->
++-
++-
++-
++-
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}!=""){$(".toggle-bbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }});$("#innerbbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }})}$(".toggle-bbdownloads{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-bbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerbbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-bbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerbbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbpoints.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbpoints.html"
++index 37fd45502..d7a1134a1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbpoints.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/bbpoints.html"
++@@ -1,22 +1,26 @@
++-<!-- IF .bbpoints -->
+++{% if loops.bbpoints|length %}
++ <div class="sidebar">
++-<div id="bbpoints{slot.SIDEBAR_ID}" class="panel panel-inverse">
+++<div id="bbpoints{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
++     <div class="panel-heading">
++-     <h4 class="panel-title">{L_BBPOINTS}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-bbpoints{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('BBPOINTS') }}</span>
++     </div>
++-	<div class="panel-body">
++-	 <div id="innerbbpoints{slot.SIDEBAR_ID}" class="inner">
+++	<div id="innerbbpoints{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++ 		<ul class="media-list user-list">
++-		<!-- BEGIN bbpoints -->
+++		{% for bbpoints in loops.bbpoints %}
++ 		<li class="media">
++-		 <div class="media-body">
++-		    {bbpoints.USERNAME_FULL}{L_COLON}&nbsp;<!-- IF SYMBOL_POS --><i class="fa {BBPOINTS_SYMBOL}"></i>&nbsp;<!-- ENDIF -->{bbpoints.BBPOINTS}<!-- IF not SYMBOL_POS --><i class="fa {BBPOINTS_SYMBOL}"></i><!-- ENDIF --><!-- IF S_REGISTERED_USER and bbpoints.TRANSFER_URL -->&nbsp;<a href="{bbpoints.TRANSFER_URL}" data-ajax="true" title="{L_TRANSFER_TO}"><i class="fa fa-random"></i></a><!-- ENDIF -->
++-		 </div>
+++		 <span class="media-body">
+++		    {{ bbpoints.USERNAME_FULL }}{{ lang('COLON') }}&nbsp;{% if SYMBOL_POS %}<i class="fa {{ BBPOINTS_SYMBOL }}"></i>&nbsp;{% endif %}{{ bbpoints.BBPOINTS }}{% if not SYMBOL_POS %}<i class="fa {{ BBPOINTS_SYMBOL }}"></i>{% endif %}{% if S_REGISTERED_USER and bbpoints.TRANSFER_URL %}&nbsp;<a href="{{ bbpoints.TRANSFER_URL }}" data-ajax="true" title="{{ lang('TRANSFER_TO') }}"><i class="fa fa-random"></i></a>{% endif %}
+++		 </span>
++ 		</li>
++-		<!-- END bbpoints -->		
+++		{% endfor %}
++ 		</ul>
++-	 </div>
++ 	</div>
++ </div>
++ </div>
++-<!-- ENDIF -->
++\ No newline at end of file
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}!=""){$(".toggle-bbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }});$("#innerbbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }})}$(".toggle-bbpoints{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-bbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerbbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-bbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerbbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/birthday.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/birthday.html"
++index 7366ac84d..9137c45a2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/birthday.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/birthday.html"
++@@ -1,18 +1,22 @@
++-<!-- IF .birthday -->
+++{% if loops.birthday|length %}
++ <div class="sidebar">
++-<div id="birthday{slot.SIDEBAR_ID}" class="panel panel-info">
+++<div id="birthday{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
++     <div class="panel-heading">
++-     <h4 class="panel-title">{L_BIRTHDAYS}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-birthday{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('BIRTHDAYS') }}</span>
++     </div>
++-	<div class="panel-body">
++-	 <div id="innerbirthday{slot.SIDEBAR_ID}" class="inner">
++-		<ul class="list-unstyled">	
++-		<!-- BEGIN birthday -->
++-			<li title="{birthday.BIRTHDAY}"><i class="fa fa-gift"></i>&nbsp;{birthday.USERNAME_FULL}&nbsp;&#45;&nbsp;{L_AGE}{L_COLON}&nbsp;{birthday.AGE}</li>
++-		<!-- END birthday -->	
+++	<div id="innerbirthday{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+++		<ul class="media-list user-list">
+++		{% for birthday in loops.birthday %}
+++			<li class="media" title="{{ birthday.BIRTHDAY }}"><i class="fa fa-gift"></i>&nbsp;{{ birthday.USERNAME_FULL }}&nbsp;&#45;&nbsp;{{ lang('AGE') }}{{ lang('COLON') }}&nbsp;{{ birthday.AGE }}</li>
+++		{% endfor %}	
++ 		</ul>
++-	 </div>
++ 	</div>
++ </div>
++ </div>
++-<!-- ENDIF -->
++\ No newline at end of file
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}!=""){$(".toggle-birthday{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }});$("#innerbirthday{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }})}$(".toggle-birthday{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-birthday{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerbirthday{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-birthday{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerbirthday{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/custom.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/custom.html"
++index a088491d5..347417367 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/custom.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/custom.html"
++@@ -1,12 +1,16 @@
++ <div class="sidebar">
++-<div id="custom{slot.SIDEBAR_ID}" class="panel panel-inverse">
+++<div id="custom{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
++     <div class="panel-heading">
++-     <h4 class="panel-title">{$TITLE}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-custom{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ definition.TITLE }}</span>
+++    </div>
+++    <div id="innercustom{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+++		{{ definition.TEXT }}
++     </div>
++-	<div class="panel-body">
++-	 <div id="innercustom{slot.SIDEBAR_ID}" class="inner">
++-		{$TEXT}
++-	 </div>
++-	</div>
++ </div>
++ </div>
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}!=""){$(".toggle-custom{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }});$("#innercustom{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }})}$(".toggle-custom{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-custom{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innercustom{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-custom{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innercustom{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/donations.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/donations.html"
++index 62f111492..18eaff19c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/donations.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/donations.html"
++@@ -1,29 +1,33 @@
++-<!-- IF .donations -->
+++{% if loops.donations|length %}
++ <div class="sidebar">
++-<div id="donators{slot.SIDEBAR_ID}" class="panel panel-info">
+++<div id="donators{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
++     <div class="panel-heading">
++-     <h4 class="panel-title">{L_DONATIONS}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-donators{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('DONATIONS') }}</span>
++     </div>
++-	<div class="panel-body">
++-	 <div id="innerdonators{slot.SIDEBAR_ID}" class="inner">
+++	<div id="innerdonators{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++ 		 <div class="media-list user-list">
++-			<!-- BEGIN donations -->
+++			{% for donations in loops.donations %}
++ 			<div class="media">
++ 				<div class="media-left">
++-					  <img alt="" src="{donations.AVATAR}" class="media-object img-circle">
++-				 </div>
+++					<img alt="" src="{{ donations.AVATAR }}" class="media-object img-circle">
+++				</div>
++ 				<div class="media-body">
++-					<h4 class="media-heading">{donations.USERNAME_FULL}</h4>
++-					<span><a href="#" title="{donations.TIME}">{donations.CURRENCY_SYMBOL} {donations.AMOUNT}</a></span>
+++					<div class="media-heading">{{ donations.USERNAME_FULL }}</div>
+++					<span><a href="#" title="{{ donations.TIME }}">{{ donations.CURRENCY_SYMBOL }} {{ donations.AMOUNT }}</a></span>
++ 				</div>
++ 			</div>
++-			<!-- BEGINELSE -->
++-             <div>{L_NO_MEMBERS}</div>
++-			<!-- END donations -->
+++			{% else %}
+++             <div>{{ lang('NO_MEMBERS') }}</div>
+++			{% endfor %}
++ 		 </div>	
++-        <!-- IF U_DONATE_PAGE --><br /><a href="{U_DONATE_PAGE}">{L_DONATE_ALSO}</a><!-- ENDIF -->
+++        {% if U_DONATE_PAGE %}<br /><a href="{{ U_DONATE_PAGE }}">{{ lang('DONATE_ALSO') }}</a>{% endif %}
++ 		</div>
++-	 </div>
++ 	</div>
++ </div>
++-<!-- ENDIF -->
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}!=""){$(".toggle-donators{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }});$("#innerdonators{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }})}$(".toggle-donators{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-donators{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerdonators{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-donators{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerdonators{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_footer_content_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_footer_content_after.html"
++index ca2a2462e..1ede00fb0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_footer_content_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_footer_content_after.html"
++@@ -1,4 +1,4 @@
++-<!-- IF S_SIDEBAR_ALL_PAGES or S_INDEX -->
+++{% if S_SIDEBAR_ALL_PAGES or S_INDEX %}
++ 	</div>
++ </div>
++-<!-- ENDIF -->
++\ No newline at end of file
+++{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_content_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_content_before.html"
++index 376c25e7e..57ccd7109 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_content_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_content_before.html"
++@@ -1,17 +1,17 @@
++-<!-- IF S_SIDEBAR_ALL_PAGES or S_INDEX -->
+++{% if S_SIDEBAR_ALL_PAGES or S_INDEX %}
++ <div class="wrapper">
++ 	<div id="page-sidebar">
++ 		<div id="sidebar-border">
++-		<!-- BEGIN slot -->
++-		<!-- IF slot.SIDEBAR_SLOT == 1 -->
++-			<!-- DEFINE $TITLE = '{slot.SIDEBAR_TITLE}' -->
++-			<!-- DEFINE $TEXT = '{slot.SIDEBAR_TEXT}' -->
++-			<!-- INCLUDE custom.html -->
++-		<!-- ELSE IF not slot.SIDEBAR_SLOT == 0 -->
++-			<!-- INCLUDE {slot.SIDEBAR_SLOT} -->
++-		<!-- ENDIF -->
++-		<!-- END slot -->
+++		{% for slot in loops.slot %}
+++		{% if slot.SIDEBAR_SLOT == 1 %}
+++			{% DEFINE TITLE = ''~ slot.SIDEBAR_TITLE ~'' %}
+++			{% DEFINE TEXT = ''~ slot.SIDEBAR_TEXT ~'' %}
+++			{% INCLUDE 'custom.html' %}
+++		{% elseif not slot.SIDEBAR_SLOT == 0 %}
+++			{% INCLUDE ''~ slot.SIDEBAR_SLOT ~'' %}
+++		{% endif %}
+++		{% endfor %}
++ 		</div>
++ 	</div>
++ 	<div id="contentje">
++-<!-- ENDIF -->
++\ No newline at end of file
+++{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++index c37cac5da..14acd0751 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++@@ -1,3 +1,3 @@
++-<!-- IF S_SIDEBAR_DYNAMIC -->
++-	<!-- INCLUDEJS @sitesplat_sidebar/js/dynamic.js -->
++-<!-- ENDIF -->
++\ No newline at end of file
+++{% if S_SIDEBAR_DYNAMIC %}
+++	{% INCLUDEJS '@sitesplat_sidebar/js/dynamic.js' %}
+++{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++index 142cfe577..e434bd4e5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++@@ -1,37 +1,37 @@
++-<!-- IF S_INDEX -->
++-	<!-- IF not S_SIDEBAR_TYPE -->
++-		<!-- IF S_SIDEBAR_WIDTH -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarright.css -->
++-		<!-- ELSE -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebar20right.css -->
++-		<!-- ENDIF -->
++-	<!-- ELSE -->
++-		<!-- IF S_SIDEBAR_WIDTH -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft.css -->
++-		<!-- ELSE -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft20.css -->
++-		<!-- ENDIF -->
++-	<!-- ENDIF -->
++-<!-- ENDIF -->
+++{% if S_INDEX %}
+++	{% if not S_SIDEBAR_TYPE %}
+++		{% if S_SIDEBAR_WIDTH %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebarright.css' %}
+++		{% else %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebar20right.css' %}
+++		{% endif %}
+++	{% else %}
+++		{% if S_SIDEBAR_WIDTH %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft.css' %}
+++		{% else %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft20.css' %}
+++		{% endif %}
+++	{% endif %}
+++{% endif %}
++ 
++-<!-- IF S_SIDEBAR_ALL_PAGES and not S_INDEX -->
++-	<!-- IF not S_SIDEBAR_TYPE -->
++-		<!-- IF S_SIDEBAR_WIDTH -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarright.css -->
++-		<!-- ELSE -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebar20right.css -->
++-		<!-- ENDIF -->
++-	<!-- ELSE -->
++-		<!-- IF S_SIDEBAR_WIDTH -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft.css -->
++-		<!-- ELSE -->
++-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft20.css -->
++-		<!-- ENDIF -->
++-	<!-- ENDIF -->
++-<!-- ENDIF -->
+++{% if S_SIDEBAR_ALL_PAGES and not S_INDEX %}
+++	{% if not S_SIDEBAR_TYPE %}
+++		{% if S_SIDEBAR_WIDTH %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebarright.css' %}
+++		{% else %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebar20right.css' %}
+++		{% endif %}
+++	{% else %}
+++		{% if S_SIDEBAR_WIDTH %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft.css' %}
+++		{% else %}
+++			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft20.css' %}
+++		{% endif %}
+++	{% endif %}
+++{% endif %}
++ 
++-<!-- INCLUDECSS @sitesplat_sidebar/sidebar.css -->
+++{% INCLUDECSS '@sitesplat_sidebar/sidebar.css' %}
++ 
++-<!-- IF S_SIDEBAR_DYNAMIC -->
++-	<!-- INCLUDECSS @sitesplat_sidebar/sidebar_dynamic.css -->
++-<!-- ENDIF -->
++\ No newline at end of file
+++{% if S_SIDEBAR_DYNAMIC %}
+++	{% INCLUDECSS '@sitesplat_sidebar/sidebar_dynamic.css' %}
+++{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/hot_topics.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/hot_topics.html"
++index 5d52eb9ec..366fd567a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/hot_topics.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/hot_topics.html"
++@@ -1,27 +1,40 @@
++-<!-- IF .hot_topics -->
+++{% if loops.hot_topics|length %}
++ <div class="sidebar">
++-<div id="hot_topic{slot.SIDEBAR_ID}" class="panel panel-danger list-announcement">
+++<div id="hot_topics{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
++     <div class="panel-heading">
++-        <h4 class="panel-title">{L_HOT_TOPICS}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-hot-topics{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('HOT_TOPICS') }}</span>
++     </div>
++-    <div id="innerhot_topics{slot.SIDEBAR_ID}" class="panel-body inner">
++-        <ul class="list-unstyled mb20">
++-		<!-- BEGIN hot_topics -->
++-		<!-- IF hot_topics.NO_TOPIC_TITLE-->
++-				<li>   
++-				   {hot_topics.NO_TOPIC_TITLE}
+++    <div id="innerhot_topics{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+++        <ul class="media-list user-list">
+++		{% for hot_topics in loops.hot_topics %}
+++		{% if hot_topics.NO_TOPIC_TITLE%}
+++				<li class="media">    
+++				   {{ hot_topics.NO_TOPIC_TITLE }}
++ 				</li>
++-		<!-- ELSE -->
++-            <li>
++-               <!-- IF hot_topics.S_UNREAD --><span class="label label-warning">{L_UNREAD}</span>&nbsp;<!-- ENDIF --><a class="title-head" href="{hot_topics.U_TOPIC}" title="{{ hot_topics.TOPIC_TITLE_NO_HTML|e('html_attr') }}">{hot_topics.TOPIC_TITLE}</a>
++-               <div>{hot_topics.USERNAME_FULL}</div>
++-		  <!--// <div>{L_IN}{L_COLON}&nbsp;<a href="{hot_topics.U_FORUM}" title="{hot_topics.FORUM_NAME}">{hot_topics.FORUM_NAME}</a></div> -->
++-			   <small class="date"><i class="fa fa-clock-o"></i>&nbsp;{hot_topics.LAST_TOPIC_TIME}</small>
+++		{% else %}
+++            <li class="media">
+++				<span class="media-left">
+++					<img alt="" src="{{ hot_topics.AVATAR }}" class="media-object img-circle">
+++					{% if hot_topics.S_UNREAD %}<span class="label label-warning">{{ lang('UNREAD') }}</span>&nbsp;{% endif %}
+++				</span>
+++				<span class="media-body">
+++					<a class="title-head" href="{{ hot_topics.U_TOPIC }}">{{ hot_topics.TOPIC_TITLE }}</a>
+++					<br />
+++					{{ hot_topics.USERNAME_FULL }}<br />
+++					<span class="forum-time"><i class="fa fa-clock-o"></i>&nbsp;{{ hot_topics.LAST_TOPIC_TIME }}</span>
+++				</span>
+++				<!--// <span>{{ lang('IN') }}{{ lang('COLON') }}&nbsp;<a href="{{ hot_topics.U_FORUM }}" title="{{ hot_topics.FORUM_NAME }}">{{ hot_topics.FORUM_NAME }}</a></span><br /> -->
++ 			</li>
++-		<!-- ENDIF -->	
++-		<!-- END hot_topics -->
+++		{% endif %}	
+++		{% endfor %}
++         </ul>
++     </div>
++ </div>
++ </div>
++-<!-- ENDIF -->
++\ No newline at end of file
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}!=""){$(".toggle-hot-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }});$("#innerhot_topics{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }})}$(".toggle-hot-topics{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-hot-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerhot_topics{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-hot-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerhot_topics{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/highcharts.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/highcharts.js"
++index cb79a7de0..61082c126 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/highcharts.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/highcharts.js"
++@@ -51,7 +51,7 @@ e,"stroke-width":h,transform:"translate"+k,fill:P});if(c)F(f,"height",t(F(f,"hei
++ alignSetter:function(a){this.element.setAttribute("text-anchor",{left:"start",center:"middle",right:"end"}[a])},opacitySetter:function(a,b,c){this[b]=a;c.setAttribute(b,a)},titleSetter:function(a){var b=this.element.getElementsByTagName("title")[0];b||(b=x.createElementNS(xa,"title"),this.element.appendChild(b));b.textContent=p(a,"").replace(/<[^>]*>/g,"")},textSetter:function(a){if(a!==this.textStr)delete this.bBox,this.textStr=a,this.added&&this.renderer.buildText(this)},fillSetter:function(a,b,
++ c){typeof a==="string"?c.setAttribute(b,a):a&&this.colorGradient(a,b,c)},zIndexSetter:function(a,b,c){c.setAttribute(b,a);this[b]=a},_defaultSetter:function(a,b,c){c.setAttribute(b,a)}};S.prototype.yGetter=S.prototype.xGetter;S.prototype.translateXSetter=S.prototype.translateYSetter=S.prototype.rotationSetter=S.prototype.verticalAlignSetter=S.prototype.scaleXSetter=S.prototype.scaleYSetter=function(a,b){this[b]=a;this.doTransform=!0};S.prototype["stroke-widthSetter"]=S.prototype.strokeSetter=function(a,
++ b,c){this[b]=a;if(this.stroke&&this["stroke-width"])this.strokeWidth=this["stroke-width"],S.prototype.fillSetter.call(this,this.stroke,"stroke",c),c.setAttribute("stroke-width",this["stroke-width"]),this.hasStroke=!0;else if(b==="stroke-width"&&a===0&&this.hasStroke)c.removeAttribute("stroke"),this.hasStroke=!1};var ta=function(){this.init.apply(this,arguments)};ta.prototype={Element:S,init:function(a,b,c,d,e){var f=location,g,d=this.createElement("svg").attr({version:"1.1"}).css(this.getStyle(d));
++-g=d.element;a.appendChild(g);a.innerHTML.indexOf("xmlns")===-1&&F(g,"xmlns",xa);this.isSVG=!0;this.box=g;this.boxWrapper=d;this.alignedObjects=[];this.url=(Ua||tb)&&x.getElementsByTagName("base").length?f.href.replace(/#.*?$/,"").replace(/([\('\)])/g,"\\$1").replace(/ /g,"%20"):"";this.createElement("desc").add().element.appendChild(x.createTextNode("Created with Highcharts 4.0.4 and sitesplat.com"));this.defs=this.createElement("defs").add();this.forExport=e;this.gradients={};this.cache={};this.setSize(b,c,!1);var h;
+++g=d.element;a.appendChild(g);a.innerHTML.indexOf("xmlns")===-1&&F(g,"xmlns",xa);this.isSVG=!0;this.box=g;this.boxWrapper=d;this.alignedObjects=[];this.url=(Ua||tb)&&x.getElementsByTagName("base").length?f.href.replace(/#.*?$/,"").replace(/([\('\)])/g,"\\$1").replace(/ /g,"%20"):"";this.createElement("desc").add().element.appendChild(x.createTextNode("Created with Highcharts 4.0.4 and goldtuganime.com"));this.defs=this.createElement("defs").add();this.forExport=e;this.gradients={};this.cache={};this.setSize(b,c,!1);var h;
++ if(Ua&&a.getBoundingClientRect)this.subPixelFix=b=function(){B(a,{left:0,top:0});h=a.getBoundingClientRect();B(a,{left:La(h.left)-h.left+"px",top:La(h.top)-h.top+"px"})},b(),N(G,"resize",b)},getStyle:function(a){return this.style=r({fontFamily:'"Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif',fontSize:"12px"},a)},isHidden:function(){return!this.boxWrapper.getBBox().width},destroy:function(){var a=this.defs;this.box=null;this.boxWrapper=this.boxWrapper.destroy();Pa(this.gradients||
++ {});this.gradients=null;if(a)this.defs=a.destroy();this.subPixelFix&&X(G,"resize",this.subPixelFix);return this.alignedObjects=null},createElement:function(a){var b=new this.Element;b.init(this,a);return b},draw:function(){},buildText:function(a){for(var b=a.element,c=this,d=c.forExport,e=p(a.textStr,"").toString(),f=e.indexOf("<")!==-1,g=b.childNodes,h,i,j=F(b,"x"),k=a.styles,l=a.textWidth,n=k&&k.lineHeight,m=k&&k.HcTextStroke,o=g.length,Y=function(a){return n?y(n):c.fontMetrics(/(px|em)$/.test(a&&
++ a.style.fontSize)?a.style.fontSize:k&&k.fontSize||c.style.fontSize||12,a).h};o--;)b.removeChild(g[o]);!f&&!m&&e.indexOf(" ")===-1?b.appendChild(x.createTextNode(e)):(h=/<.*style="([^"]+)".*>/,i=/<.*href="(http[^"]+)".*>/,l&&!a.added&&this.box.appendChild(b),e=f?e.replace(/<(b|strong)>/g,'<span style="font-weight:bold">').replace(/<(i|em)>/g,'<span style="font-style:italic">').replace(/<a/g,"<span").replace(/<\/(b|strong|i|em|a)>/g,"</span>").split(/<br.*?>/g):[e],e[e.length-1]===""&&e.pop(),q(e,function(e,
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/membership.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/membership.js"
++index 2f4089b9e..e3ca29948 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/membership.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/membership.js"
++@@ -18,8 +18,8 @@ head.ready(function () {
++ 			},
++ 			credits: {
++ 				enabled: false,
++-				text: 'sitesplat.com',
++-				href: 'https://sitesplat.com'
+++				text: 'goldtuganime.com',
+++				href: 'https://goldtuganime.com'
++ 			},
++ 			exporting: { enabled: false },
++ 			tooltip: {
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/poll.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/poll.js"
++index 6bfa67ab2..3291da547 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/poll.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/js/poll.js"
++@@ -18,8 +18,8 @@ head.ready(function () {
++ 			},
++ 			credits: {
++ 				enabled: false,
++-				text: 'sitesplat.com',
++-				href: 'https://sitesplat.com'
+++				text: 'goldtuganime.com',
+++				href: 'https://goldtuganime.com'
++ 			},
++ 			exporting: { enabled: false },
++ 			tooltip: {
++@@ -33,7 +33,7 @@ head.ready(function () {
++                     events: {
++                         click: function () {
++ 							$.ajax({ type: "POST", 
++-							url: sitesplat_board_url + "app.php/sidebar/poll.html", 
+++							url: sitesplat_board_url + "app.php/sidebar/poll.html",
++ 							data: {"f" : this.f,
++ 									"t": this.t,
++ 									"v": this.v},
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_badges.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_badges.html"
++index 564629e91..6a932fd71 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_badges.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_badges.html"
++@@ -1,29 +1,30 @@
++-<!-- IF .last_badges -->
+++{% if loops.last_badges|length %}
++ <div class="sidebar">
++-<div id="lastbadges{slot.SIDEBAR_ID}" class="panel panel-success">
+++<div id="lastbadges{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
++     <div class="panel-heading">
++-     <h4 class="panel-title">{L_LAST_BADGES}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-lastbadges{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('LAST_BADGES') }}</span>
++     </div>
++-	<div class="panel-body">
++-	 <div id="innerlastbadges{slot.SIDEBAR_ID}" class="inner">
++-		<ul class="media-list user-list">
++-		<!-- BEGIN last_badges -->
++-			<li class="media">
++-                    <div class="media-left">
++-                        <a href="#">
++-                          <img alt="" src="{last_badges.BADGE}" class="media-object img-circle">
++-                        </a>
++-                    </div>
++-                    <div class="media-body">
++-                        <h4 class="media-heading">{last_badges.USERNAME_FULL}</h4>
++-                        <span>{last_badges.NAME}</span>  
++-						<small class="date"><i class="fa fa-clock-o"></i>&nbsp;{last_badges.BADGE_DATE}</small>
++-                    </div>
++-            </li>
++-		<!-- END last_badges -->
++-		</ul>
++-	 </div>
+++	 <div id="innerlastbadges{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+++		<div class="media-list user-list">
+++		{% for last_badges in loops.last_badges %}
+++			<div class="media">
+++				<div class="media-left">
+++					<img alt="" src="{{ last_badges.BADGE }}" class="media-object img-circle">
+++				</div>
+++				<div class="media-body">
+++					<div class="media-heading">{{ last_badges.USERNAME_FULL }}<br />{{ last_badges.NAME }}</div>
+++					<span><a href="#"><i class="fa fa-clock-o"></i>&nbsp;{{ last_badges.BADGE_DATE }}</a></span>
+++				</div>
+++			</div>
+++		{% endfor %}
+++		</div>
++ 	</div>
++ </div>
++ </div>
++-<!-- ENDIF -->
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}!=""){$(".toggle-lastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }});$("#innerlastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }})}$(".toggle-lastbadges{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-lastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerlastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-lastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerlastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_bbreactions.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_bbreactions.html"
++index 6e409c3ee..d110dda76 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_bbreactions.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/last_bbreactions.html"
++@@ -1,31 +1,36 @@
++-<!-- IF .last_bbreactions -->
+++{% if loops.last_bbreactions|length %}
++ <div class="sidebar">
++-<div id="lastbbreactions{slot.SIDEBAR_ID}" class="panel panel-inverse">
+++<div id="lastbbreactions{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
++     <div class="panel-heading">
++-     <h4 class="panel-title">{L_LAST_BBREACTIONS}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-lastbbreactions{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('LAST_BBREACTIONS') }}</span>
++     </div>
++-	<div class="panel-body">
++-	 <div id="innerlastbbreactions{slot.SIDEBAR_ID}" class="inner">
+++	 <div id="innerlastbbreactions{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++ 		<ul class="media-list user-list">	
++-		<!-- BEGIN last_bbreactions -->
++-		<li class="media">
++-                <div class="media-left bbreactions-emoji">
++-                    <!-- IF last_bbreactions.EMOJI -->
++-                    {last_bbreactions.EMOJI}
++-                    <!-- ELSE -->
++-                    <i class="fa {last_bbreactions.SYMBOL} fa-object" style="color:<!-- IF last_bbreactions.POSITIVE -->green<!-- ELSE -->red<!-- ENDIF -->;"></i>
++-                    <!-- ENDIF -->
++-                </div>
++-                <div class="media-body">
++-                    <h4 class="media-heading">{last_bbreactions.USERNAME_FULL}</h4>
++-                    <span><a href="{last_bbreactions.POST_URL}">{last_bbreactions.TYPE}</a></span>
++-                <small class="date"><i class="fa fa-clock-o"></i>&nbsp;{last_bbreactions.BADGE_DATE}</small>
++-				</div>
+++            {% for last_bbreactions in loops.last_bbreactions %}
+++			<li class="sidebar-last-column">
+++				<span class="sidebar-poster-thumbs bbreactions-emoji">
+++					{% if last_bbreactions.EMOJI %}
+++					{{ last_bbreactions.EMOJI }}
+++					{% else %}
+++					<i class="fa {{ last_bbreactions.SYMBOL }} fa-object" style="color:{% if last_bbreactions.POSITIVE %}green{% else %}red{% endif %};"></i>
+++					{% endif %}
+++				</span>
+++				<span class="last-wrapper text-overflow">
+++					{{ last_bbreactions.USERNAME_FULL }}
+++					<br />
+++					<i class="fa fa-volume-control-phone"></i>&nbsp;<a href="{{ last_bbreactions.POST_URL }}">{{ last_bbreactions.TYPE }}</a>
+++				</span>
+++				<span class="space5"></span>
++          </li>
++-		<!-- END last_bbreactions -->		
+++		{% endfor %}		
++ 		</ul>
++-	 </div>
++ 	</div>
++ </div>
++ </div>
++-<!-- ENDIF -->
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}=window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}||"";if(window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}!=""){$(".toggle-lastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }});$("#innerlastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }})}$(".toggle-lastbbreactions{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-lastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerlastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-lastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerlastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/likesdd.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/likesdd.html"
++index df6590a95..2eb377cde 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/likesdd.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/likesdd.html"
++@@ -1,27 +1,33 @@
++-<!-- IF .last_likes -->
+++{% if loops.last_likes|length %}
++ <div class="sidebar">
++-<div id="lastlikes{slot.SIDEBAR_ID}" class="panel panel-warning">
+++<div id="lastlikes{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
++     <div class="panel-heading">
++-     <h4 class="panel-title">{L_LIKEDD}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-lastlikes{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('LIKEDD') }}</span>
++     </div>
++-	<div class="panel-body">
++-	 <div id="innerlastlikes{slot.SIDEBAR_ID}" class="inner">
+++	 <div id="innerlastlikes{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++ 		<ul class="media-list user-list">
++-            <!-- BEGIN last_likes -->
++-			<li class="media">
++-			    <div class="media-left">
++-                     <img alt="" src="{last_likes.AVATAR}" class="media-object img-circle">
++-                </div>
++-                <div class="media-body">
++-					<div><i class="fa fa-thumbs-up"></i>&nbsp;{L_BY}&nbsp;{last_likes.USERNAME_FULL}</div>
++-                    <a href="{last_likes.POST_URL}">{last_likes.SUBJECT}</a>
++-                    <small class="date"><i class="fa fa-clock-o"></i>&nbsp;{last_likes.LIKE_DATE}</small>
++-                </div>
++-            </li>
++-			<!-- END last_likes -->
+++            {% for last_likes in loops.last_likes %}
+++			<div class="media">
+++				<div class="media-left">
+++					<img alt="" src="{{ last_likes.AVATAR }}" class="media-object img-circle">
+++				</div>
+++				<div class="media-body">
+++					<div class="media-heading">
+++						<i class="fa fa-thumbs-up"></i>&nbsp;{{ last_likes.USERNAME_FULL }}
+++					</div>
+++					<a href="{{ last_likes.POST_URL }}">{{ last_likes.SUBJECT }}</a>
+++				</div>
+++				<div class="space10"></div>
+++			</div>
+++			{% endfor %}
++ 		</ul>
++ 	 </div>
++-	</div>
++ </div>
++ </div>
++-<!-- ENDIF -->
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}=window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}||"";if(window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}!=""){$(".toggle-lastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }});$("#innerlastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }})}$(".toggle-lastlikes{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-lastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerlastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-lastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerlastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/membership.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/membership.html"
++index 2512b8241..5f32461af 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/membership.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/membership.html"
++@@ -1,25 +1,29 @@
++-<!-- IF MEMBERSTATS -->
+++{% if MEMBERSTATS %}
++ <div class="sidebar">
++-<div id="membership{slot.SIDEBAR_ID}" class="panel panel-inverse">
+++<div id="membership{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
++     <div class="panel-heading">
++-     <h4 class="panel-title">{L_MEMBERSHIPS}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-membership{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('MEMBERSHIPS') }}</span>
++     </div>
++-	<div class="panel-body">
++-	 <div id="innermembership{slot.SIDEBAR_ID}" class="inner">
++-		<a href="{U_MEMBERSHIPS}">{L_MEMBERSHIPS_CTA}</a>
+++    <div id="innermembership{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+++		<a href="{{ U_MEMBERSHIPS }}">{{ lang('MEMBERSHIPS_CTA') }}</a>
++ 		<div id="membershipchart" style="width:100%;height:150px;margin:0 auto;background-color:transparant;"></div>
++ 	    <script>
++-			var memberstats = {MEMBERSTATS};
+++			var memberstats = {{ MEMBERSTATS }};
++ 		</script>
++-	 </div>
++ 	</div>
++ </div>
++ </div>
++-<!-- ENDIF -->
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}!=""){$(".toggle-membership{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }});$("#innermembership{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }})}$(".toggle-membership{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-membership{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innermembership{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-membership{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innermembership{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++ <!-- // some trickery here to eliminate the conflict with the poll type block, likeBB and BBreaction extensions top stats pages  -->
++-<!-- IF not POLTITLE -->
++-    <!-- INCLUDEJS @sitesplat_sidebar/js/highcharts.js -->
++-<!-- ENDIF -->  
++-<!-- IF MEMBERSTATS -->
++-    <!-- INCLUDEJS @sitesplat_sidebar/js/membership.js -->
++-<!-- ENDIF --> 
++\ No newline at end of file
+++{% if not POLTITLE %}
+++    {% INCLUDEJS '@sitesplat_sidebar/js/highcharts.js' %}
+++{% endif %}  
+++{% if MEMBERSTATS %}
+++    {% INCLUDEJS '@sitesplat_sidebar/js/membership.js' %}
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newsletter.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newsletter.html"
++index bdf7c3ad8..b525b6886 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newsletter.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newsletter.html"
++@@ -1,33 +1,34 @@
++-<!-- IF NEWSLETTER and SCRIPT_NAME eq 'index' -->
+++{% if NEWSLETTER and SCRIPT_NAME eq 'index' %}
++ <div class="sidebar">
++-<div id="newsletter{slot.SIDEBAR_ID}" class="panel panel-info">
+++<div id="newsletter{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
++     <div class="panel-heading">
++-     <h4 class="panel-title">{L_NEWSLETTER}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-newsletter{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('NEWSLETTER') }}</span>
++     </div>
++-	<div class="panel-body">
++-	 <div id="innernewsletter{slot.SIDEBAR_ID}" class="inner">
+++	 <div id="innernewsletter{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++ 		<div class="subscribe-form" id="subscribe-sidebar">
++-			<!-- IF not S_SUBSCRIBE_MESSAGE -->
++-				<form method="post" action="{U_SUBSCRIBE_ACTION}" id="subscribe-form-sidebar">
+++			{% if not S_SUBSCRIBE_MESSAGE %}
+++				<form method="post" action="{{ U_SUBSCRIBE_ACTION }}" id="subscribe-form-sidebar">
++ 					<fieldset>
++ 					  <div class="form-group nomargin">
++-					   <label class="sr-only" for="email">{L_SUBSCRIBE_EMAIL}{L_COLON}</label>
+++					   <label class="sr-only" for="email">{{ lang('SUBSCRIBE_EMAIL') }}{{ lang('COLON') }}</label>
++ 						<div class="input-group">
++ 						  <span class="input-group-addon"><i class="icon-moon-email"></i></span>
++-						  <input class="form-control" type="email" name="email" id="email" spellcheck="false" autocomplete="off" placeholder="{L_EMAIL}">
+++						  <input class="form-control" type="email" name="email" id="email" spellcheck="false" autocomplete="off" placeholder="{{ lang('EMAIL') }}">
++ 						</div>
++ 					  </div>
++ 					<div class="form-group">
++-					  <button type="submit" class="btn btn-success btn-block" name="subscribe" value="{L_SUBSCRIBE_BUTTON}">{L_SUBSCRIBE_BTN}</button>
+++					  <button type="submit" class="btn btn-success btn-block" name="subscribe" value="{{ lang('SUBSCRIBE_BUTTON') }}">{{ lang('SUBSCRIBE_BTN') }}</button>
++ 					</div>
++ 					</fieldset>
++ 				</form>
++-			<!-- ELSEIF S_SUBSCRIBE_MESSAGE -->
+++			{% elseif S_SUBSCRIBE_MESSAGE %}
++ 				<div class="col-sm-12">
++-					<p>{S_SUBSCRIBE_MESSAGE}</p>
+++					<p>{{ S_SUBSCRIBE_MESSAGE }}</p>
++ 				</div>
++-			<!-- ENDIF -->
++-	 </div>
+++			{% endif %}
++ 	 </div>
++ 	</div>
++ </div>
++@@ -51,5 +52,8 @@ head.ready('jquery.min.js', function(){
++ 		});
++ 	});
++ });
++-</script>	
++-<!-- ENDIF -->
+++</script>
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}!=""){$(".toggle-newsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }});$("#innernewsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }})}$(".toggle-newsletter{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-newsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innernewsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-newsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innernewsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newusers.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newusers.html"
++index e5b379f88..4ef546a54 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newusers.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/newusers.html"
++@@ -1,25 +1,29 @@
++-<!-- IF .newest_users -->
+++{% if loops.newest_users|length %}
++ <div class="sidebar">
++-<div id="users{slot.SIDEBAR_ID}" class="panel panel-info">
+++<div id="users{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
++     <div class="panel-heading">
++-     <h4 class="panel-title">{L_NEWEST_USERS}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-users{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('NEWEST_USERS') }}</span>
++     </div>
++-	<div class="panel-body">
++-	 <div id="innerusers{slot.SIDEBAR_ID}" class="inner">
+++	<div id="innerusers{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++ 		<ul class="media-list user-list">
++-		<!-- BEGIN newest_users -->
+++		{% for newest_users in loops.newest_users %}
++ 		<li class="media">
++ 			<div class="media-left">
++-				<img alt="" src="{newest_users.AVATAR}" class="media-object img-circle">
+++				<img alt="" src="{{ newest_users.AVATAR }}" class="media-object img-circle">
++ 			</div>
++             <div class="media-body">
++-                <div class="media-heading">{newest_users.USERNAME_FULL}&nbsp;&#45;&nbsp;<small>{newest_users.REG_DATE}</small></div>
+++                <div class="media-heading">{{ newest_users.USERNAME_FULL }}&nbsp;&#45;&nbsp;<small>{{ newest_users.REG_DATE }}</small></div>
++             </div>
++         </li>
++-		<!-- END newest_users -->
+++		{% endfor %}
++ 		</ul>
++-	 </div>
++ 	</div>
++ </div>
++ </div>
++-<!-- ENDIF -->
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}!=""){$(".toggle-users{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }});$("#innerusers{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }})}$(".toggle-users{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-users{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerusers{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-users{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerusers{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/poll.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/poll.html"
++index 658df82ad..cb9c9bb44 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/poll.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/poll.html"
++@@ -1,20 +1,24 @@
++-<!-- IF POLTITLE -->
+++{% if POLTITLE %}
++ <div class="sidebar">
++-<div id="poll{slot.SIDEBAR_ID}" class="panel panel-inverse">
+++<div id="poll{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
++     <div class="panel-heading">
++-     <h4 class="panel-title">{L_POLL}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-poll{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('POLL') }}</span>
++     </div>
++-	<div class="panel-body">
++-	 <div id="innerpoll{slot.SIDEBAR_ID}" class="inner">
++-		<a href="{URL}">{POLTITLE}</a>
+++	<div id="innerpoll{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+++		<a href="{{ URL }}">{{ POLTITLE }}</a>
++ 		<div id="pollchart" style="width:100%;height:150px;margin:0 auto;background-color:transparent;"></div>
++-	 </div>
++ 	</div>
++ </div>
++ </div>
++ <script>
++- var polstats = {POLSTATS};
+++ var polstats = {{ POLSTATS }};
++ </script>
++-<!-- INCLUDEJS @sitesplat_sidebar/js/highcharts.js -->
++-<!-- INCLUDEJS @sitesplat_sidebar/js/poll.js -->
++-<!-- ENDIF -->
++\ No newline at end of file
+++{% INCLUDEJS '@sitesplat_sidebar/js/highcharts.js' %}
+++{% INCLUDEJS '@sitesplat_sidebar/js/poll.js' %}
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}!=""){$(".toggle-poll{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }});$("#innerpoll{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }})}$(".toggle-poll{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-poll{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerpoll{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-poll{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerpoll{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/staff.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/staff.html"
++index 8cc76175e..18b48b95f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/staff.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/staff.html"
++@@ -1,30 +1,37 @@
++-<!-- IF .staff -->
+++{% if loops.staff|length %}
++ <div class="sidebar">
++-<div id="staff{slot.SIDEBAR_ID}" class="panel panel-info">
+++<div id="staff{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
++     <div class="panel-heading">
++-     <h4 class="panel-title">{L_STAFF}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-staff{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('STAFF') }}</span>
++     </div>
++-	<div class="panel-body">
++-	 <div id="innerstaff{slot.SIDEBAR_ID}" class="inner">
++-		 <div class="media-list user-list">
++-			<!-- BEGIN staff -->
++-			<div class="media">
+++	 <div id="innerstaff{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+++		 <ul class="media-list user-list">
+++			{% for staff in loops.staff %}
+++            <div class="media">
++ 				<div class="media-left">
++-					<a href="#">
++-					  <img alt="" src="{staff.AVATAR}" class="media-object img-circle">
++-					</a>
++-				 </div>
+++					<img alt="" src="{{ staff.AVATAR }}" class="media-object img-circle">
+++				</div>
++ 				<div class="media-body">
++-					<h4 class="media-heading">{staff.USERNAME_FULL}</h4>
++-					<span><a href="{staff.S_SEARCH_ACTION}" title="">{staff.TIME}</a></span>
+++					<div class="media-heading">{{ staff.USERNAME_FULL }}</div>
+++					<span class="forum-time"><i class="fa fa-clock-o"></i>&nbsp;<a href="{{ staff.S_SEARCH_ACTION }}" title="">{{ staff.TIME }}</a></span>
++ 				</div>
+++				<div class="space5"></div>
++ 			</div>
++-			<!-- BEGINELSE -->
++-             <div>{L_NO_MEMBERS}</div>
++-			<!-- END staff -->
++-		 </div>	
+++			{% else %}
+++			<li class="sidebar-last-column">
+++				<span class="last-wrapper text-overflow">
+++					{{ lang('NO_MEMBERS') }}
+++				</span>
+++			</li>
+++			{% endfor %}
+++		 </ul>	
++ 		</div>
++-	 </div>
++ 	</div>
++ </div>
++-<!-- ENDIF -->
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}!=""){$(".toggle-staff{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }});$("#innerstaff{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }})}$(".toggle-staff{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-staff{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerstaff{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-staff{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerstaff{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_posters.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_posters.html"
++index 786d07a82..0350dd762 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_posters.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_posters.html"
++@@ -1,65 +1,96 @@
++-<!-- IF .top_posters -->
+++{% if loops.top_posters|length %}
++ <div class="sidebar">
++-<div id="posters{slot.SIDEBAR_ID}" class="panel panel-info">
+++<div id="posters{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
++     <div class="panel-heading">
++-     <h4 class="panel-title">{L_TOP_POSTERS}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-posters{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('TOP_POSTERS') }}</span>
++     </div>
++-	<div class="panel-body">
++-	 <div id="innerposters{slot.SIDEBAR_ID}" class="inner">
++-		
+++	 <div id="innerposters{{ slot.SIDEBAR_ID }}" class="panel-body inner">
++ 		  <ul class="nav nav-pills nav-top-poster nav-justified">
++-			<li class="active"><a data-toggle="pill" href="#topAll">{L_SIDEBAR_ALL_TIME}</a></li>
++-			<li><a data-toggle="pill" href="#topDay">{L_SIDEBAR_DAILY}</a></li>
++-			<li><a data-toggle="pill" href="#topWeek">{L_SIDEBAR_WEEKLY}</a></li>
+++			<li class="active"><a data-toggle="pill" href="#topAll">{{ lang('SIDEBAR_ALL_TIME') }}</a></li>
+++			<li><a data-toggle="pill" href="#topDay">{{ lang('SIDEBAR_DAILY') }}</a></li>
+++			<li><a data-toggle="pill" href="#topWeek">{{ lang('SIDEBAR_WEEKLY') }}</a></li>
++ 		  </ul>
++-		  
+++
+++		  <div class="space10"></div>
+++
++ 		  <div class="tab-content media-list user-list">
++-			
++ 			<div id="topAll" class="tab-pane fade in active">
++-			<!-- BEGIN top_posters -->
++-			<div class="media">
+++			<div class="media-list user-list">
+++			{% for top_posters in loops.top_posters %}
+++            <div class="media">
++ 				<div class="media-left">
++-					  <img alt="" src="{top_posters.AVATAR}" class="media-object img-circle">
++-				 </div>
+++					<img alt="" src="{{ top_posters.AVATAR }}" class="media-object img-circle">
+++				</div>
++ 				<div class="media-body">
++-					<h4 class="media-heading">{top_posters.USERNAME_FULL}</h4>
++-					<span>{L_POSTS}{L_COLON}&nbsp;<a href="{top_posters.S_SEARCH_ACTION}" title="">{top_posters.POSTS}</a></span>
+++					<div class="media-heading">{{ top_posters.USERNAME_FULL }}</div>
+++					<span>{{ lang('POSTS') }}{{ lang('COLON') }}&nbsp;<a href="{{ top_posters.S_SEARCH_ACTION }}" title="">{{ top_posters.POSTS }}</a></span>
++ 				</div>
+++				<div class="space10"></div>
+++			</div>
+++			{% else %}
+++			<div class="media">
+++				<div class="media-body">
+++					{{ lang('NO_MEMBERS') }}
+++				</div>
+++			</div>
+++			{% endfor %}
++ 			</div>
++-			<!-- END top_posters -->
++ 			</div>
++ 			
++ 			<div id="topDay" class="tab-pane fade">
++-			<!-- BEGIN top_posters_day -->
++-			<div class="media">
+++			<div class="media-list user-list">
+++			{% for top_posters_day in loops.top_posters_day %}
+++            <div class="media">
++ 				<div class="media-left">
++-					  <img alt="" src="{top_posters_day.AVATAR}" class="media-object img-circle">
++-				 </div>
+++					<img alt="" src="{{ top_posters_day.AVATAR }}" class="media-object img-circle">
+++				</div>
+++				<div class="media-body">
+++					<div class="media-heading">{{ top_posters_day.USERNAME_FULL }}</div>
+++					<span>{{ lang('POSTS') }}{{ lang('COLON') }}&nbsp;<a href="{{ top_posters_day.S_SEARCH_ACTION }}" title="">{{ top_posters_day.POSTS }}</a></span>
+++				</div>
+++				<div class="space10"></div>
+++			</div>
+++			{% else %}
+++			<div class="media">
++ 				<div class="media-body">
++-					<h4 class="media-heading">{top_posters_day.USERNAME_FULL}</h4>
++-					<span>{L_POSTS}{L_COLON}&nbsp;<a href="{top_posters_day.S_SEARCH_ACTION}" title="">{top_posters_day.POSTS}</a></span>
+++					{{ lang('NO_MEMBERS') }}
++ 				</div>
++ 			</div>
++-			<!-- END top_posters_day -->
+++			{% endfor %}
+++			</div>
++ 			</div>
++ 			
++ 			<div id="topWeek" class="tab-pane fade">
++-			<!-- BEGIN top_posters_week -->
++-			<div class="media">
+++			<div class="media-list user-list">
+++			{% for top_posters_week in loops.top_posters_week %}
+++            <div class="media">
++ 				<div class="media-left">
++-					  <img alt="" src="{top_posters_week.AVATAR}" class="media-object img-circle">
++-				 </div>
+++					<img alt="" src="{{ top_posters_week.AVATAR }}" class="media-object img-circle">
+++				</div>
++ 				<div class="media-body">
++-					<h4 class="media-heading">{top_posters_week.USERNAME_FULL}</h4>
++-					<span>{L_POSTS}{L_COLON}&nbsp;<a href="{top_posters_week.S_SEARCH_ACTION}" title="">{top_posters_week.POSTS}</a></span>
+++					<div class="media-heading">{{ top_posters_week.USERNAME_FULL }}</div>
+++					<span>{{ lang('POSTS') }}{{ lang('COLON') }}&nbsp;<a href="{{ top_posters_week.S_SEARCH_ACTION }}" title="">{{ top_posters_week.POSTS }}</a></span>
++ 				</div>
+++				<div class="space10"></div>
+++			</div>
+++			{% else %}
+++			<div class="media">
+++				<div class="media-body">
+++					{{ lang('NO_MEMBERS') }}
+++				</div>
+++			</div>
+++			{% endfor %}
++ 			</div>
++-			<!-- END top_posters_week -->
++ 			</div>
++ 			
++ 		  </div>
++ 		</div>
++-	 </div>
++ 	</div>
++ </div>
++-<!-- ENDIF -->
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}=window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}||"";if(window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}!=""){$(".toggle-posters{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }});$("#innerposters{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }})}$(".toggle-posters{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-posters{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerposters{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-posters{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerposters{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_topics.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_topics.html"
++index eb070f94b..e7a9302cb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_topics.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/styles/FLATBOOTS/template/top_topics.html"
++@@ -1,27 +1,40 @@
++-<!-- IF .top_topics -->
+++{% if loops.top_topics|length %}
++ <div class="sidebar">
++-<div id="topics{slot.SIDEBAR_ID}" class="panel panel-primary list-announcement">
+++<div id="topics{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
++     <div class="panel-heading">
++-        <h4 class="panel-title">{L_NEWEST_TOPICS}</h4>
+++		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++		<a class="toggle-topics{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+++		{% endif %}
+++		<span>{{ lang('NEWEST_TOPICS') }}</span>
++     </div>
++-    <div id="innertopics{slot.SIDEBAR_ID}" class="panel-body inner">
++-        <ul class="list-unstyled mb20">
++-		<!-- BEGIN top_topics -->
++-		<!-- IF top_topics.NO_TOPIC_TITLE-->
++-				<li>   
++-				   {top_topics.NO_TOPIC_TITLE}
+++    <div id="innertopics{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+++        <ul class="media-list user-list">
+++		{% for top_topics in loops.top_topics %}
+++		{% if top_topics.NO_TOPIC_TITLE%}
+++				<li class="media">   
+++				   {{ top_topics.NO_TOPIC_TITLE }}
++ 				</li>
++-		<!-- ELSE -->
++-            <li>
++-               <!-- IF top_topics.S_UNREAD --><span class="label label-warning">{L_UNREAD}</span>&nbsp;<!-- ENDIF --><a class="title-head" href="{top_topics.U_TOPIC}" title="{{ top_topics.TOPIC_TITLE|striptags }}">{top_topics.TOPIC_TITLE}</a>
++-               <div>{top_topics.USERNAME_FULL}</div>
++-			   <div>{L_IN}{L_COLON}&nbsp;<a href="{top_topics.U_FORUM}" title="{top_topics.FORUM_NAME}">{top_topics.FORUM_NAME}</a></div>
++-			   <small class="date"><i class="fa fa-clock-o"></i>&nbsp;{top_topics.LAST_TOPIC_TIME}</small>
+++		{% else %}
+++            <li class="media">
+++				<span class="media-left">
+++					<img alt="" src="{{ top_topics.AVATAR }}" class="media-object img-circle">
+++					{% if top_topics.S_UNREAD %}<span class="label label-warning">{{ lang('UNREAD') }}</span>&nbsp;{% endif %}
+++				</span>
+++				<span class="media-body">
+++					<a class="title-head" href="{{ top_topics.U_TOPIC }}">{{ top_topics.TOPIC_TITLE }}</a>
+++					<br />
+++					{{ top_topics.USERNAME_FULL }}<br />
+++					<span class="forum-time"><i class="fa fa-clock-o"></i>&nbsp;{{ top_topics.LAST_TOPIC_TIME }}</span>
+++				</span>
+++				<!-- <span>{{ lang('IN') }}{{ lang('COLON') }}&nbsp;<a href="{{ top_topics.U_FORUM }}" title="{{ top_topics.FORUM_NAME }}">{{ top_topics.FORUM_NAME }}</a></span><br /> -->
++ 			</li>
++-		<!-- ENDIF -->	
++-		<!-- END top_topics -->
+++		{% endif %}	
+++		{% endfor %}
++         </ul>
++     </div>
++ </div>
++ </div>
++-<!-- ENDIF -->
++\ No newline at end of file
+++{% if PHPBB_COLLAPSIBLE_ENABLED %}
+++<script>head.ready(function(){(function(){window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}=window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}||"";if(window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}!=""){$(".toggle-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }});$("#innertopics{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }})}$(".toggle-topics{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innertopics{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innertopics{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+++{% endif %}
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/base.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/base.php"
++index c34809b37..7ecf97470 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/base.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/base.php"
++@@ -53,47 +53,49 @@ abstract class base implements type_interface
++  	/** 
++  	* {@inheritdoc} 
++  	*/ 
++-	protected function ignore_users()
+++	protected function ignore_users($post_users_argument = '')
++ 	{
++-		// an array of user types we dont' bother with
+++		// an array of user types we don't bother with
++ 		$ignore_users = $ignore_founders = array();
++ 		
++ 		$sql = 'SELECT group_id FROM ' . GROUPS_TABLE . ' WHERE group_name = "BOTS" AND group_type = ' . GROUP_SPECIAL;
++ 		$result = $this->db->sql_query($sql, 3600);
++ 		$bot_group = $this->db->sql_fetchfield('group_id');
++ 
++-		if (!$this->sidebar_settings['ignore_inactive_users'])
++-		{
+++		if (!$this->sidebar_settings['ignore_inactive_users']) {
++ 			$ignore_users = array(USER_IGNORE, USER_INACTIVE);
++ 		}
++ 
++-		if (!$this->sidebar_settings['ignore_founder'])
++-		{
+++		if (!$this->sidebar_settings['ignore_founder']) {
++ 			$ignore_founders = array(USER_FOUNDER);
++ 		}
++ 
++ 		$ignore_users = array_merge($ignore_users, $ignore_founders);
++ 
++ 		// Do we have anyone we want to ignore
++-		$sql_where = 'WHERE group_id <> ' . $bot_group . ' AND user_id <> ' . ANONYMOUS;
++-		if (sizeof($ignore_users))
++-		{
+++		$sql_where = 'WHERE ';
+++		
+++		if ($post_users_argument !== '') {
+++			$sql_where .= $post_users_argument . ' AND ';
+++		}
+++		
+++		$sql_where .= 'group_id <> ' . $bot_group . ' AND user_id <> ' . ANONYMOUS;
+++
+++		if (sizeof($ignore_users)) {
++ 			$sql_where .= ' AND ' . $this->db->sql_in_set('user_type', $ignore_users, true);
++ 		}
++ 		
++-		if (!$this->sidebar_settings['ignore_admins_mods'])
++-		{
+++		if (!$this->sidebar_settings['ignore_admins_mods']) {
++ 			// grab all admins
++ 			$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
++ 			$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : array();
++-	
++-			//grab all mods
++-			$mod_ary = $this->auth->acl_get_list(false,'m_', false);
+++
+++			// grab all mods
+++			$mod_ary = $this->auth->acl_get_list(false, 'm_', false);
++ 			$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : array();
++ 			$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
++-			
++-			if (sizeof($admin_mod_array))
++-			{
+++
+++			if (sizeof($admin_mod_array)) {
++ 				$sql_where .= empty($sql_where) ? ' WHERE' : ' AND';
++ 				$sql_where .= ' ' . $this->db->sql_in_set('user_id', $admin_mod_array, true);
++ 			}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/bbpoints.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/bbpoints.php"
++index ed8e77de5..2fcd7a2d2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/bbpoints.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/bbpoints.php"
++@@ -74,11 +74,11 @@ class bbpoints extends \sitesplat\sidebar\types\type\base
++ 			// grab users
++ 			$sql = 'SELECT t1.user_id, SUM(points) as total, u.username, u.user_colour FROM ( 
++ 					SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $bbpoints_table . ' GROUP BY to_id
++-					UNION
+++					UNION ALL
++ 					SELECT from_id AS user_id, SUM(-bbpoints) AS points FROM ' . $bbpoints_table . ' GROUP BY from_id
++-					UNION
+++					UNION ALL
++ 					SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' GROUP BY topic_poster
++-					UNION 
+++					UNION ALL
++ 					SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 GROUP BY poster_id) t1 
++ 					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = t1.user_id
++ 					' . $sql_where . '
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/donations.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/donations.php"
++index ccfe70b9d..a49978617 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/donations.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/donations.php"
++@@ -103,19 +103,20 @@ class donations extends \sitesplat\sidebar\types\type\base
++ 				FROM ' . $donations_table . ' d
++ 				LEFT JOIN ' . USERS_TABLE . " u ON u.user_id = d.user_id $sql_where $sql_and
++ 				AND d.payment_status = 'Completed'
+++				AND d.payment_date >= UNIX_TIMESTAMP(DATE_SUB( CURDATE(), INTERVAL 1 MONTH)) 
++ 				ORDER BY d.payment_date DESC";
++ 			$result = $this->db->sql_query_limit($sql, $howmany);
++ 			while ($row = $this->db->sql_fetchrow($result))
++ 			{
++-			  $match = array();
++-			  $avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@',
+++				$match = array();
+++				$avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@',
++ 						  phpbb_get_user_avatar(
++ 							  array('avatar'			=> $row['user_avatar'], 
++ 									'avatar_type'		=> $row['user_avatar_type'], 
++ 									'avatar_width'	=> $row['user_avatar_width'], 
++ 									'avatar_height'	=> $row['user_avatar_height'])), $match) :
++ 									generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');
++-				
+++									
++ 				if (count($match) > 1) {
++ 					$avatar = array_pop($match);
++ 					// fix an issue with BBrandom
++@@ -123,7 +124,7 @@ class donations extends \sitesplat\sidebar\types\type\base
++ 						$avatar = str_replace(['./../../', './../', './'], $board_url, $avatar);
++ 					}
++ 				}
++-
+++				
++ 				$donations[$row['user_id']] = array(
++ 					'user_id'  	    => $row['user_id'],
++ 					'username'      => $row['username'],
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/hot_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/hot_topics.php"
++index d3536b258..3fe6da9dc 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/hot_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/hot_topics.php"
++@@ -84,6 +84,7 @@ class hot_topics extends \sitesplat\sidebar\types\type\base
++ 				ORDER BY topic_last_post_time DESC';
++ 
++ 			$result = $this->db->sql_query_limit($sql, $howmany);
+++
++ 			$forums = $ga_topic_ids = $topic_ids = array();
++ 			while ($row = $this->db->sql_fetchrow($result))
++ 			{
++@@ -109,7 +110,7 @@ class hot_topics extends \sitesplat\sidebar\types\type\base
++ 			{
++ 				// grab all posts that meet criteria and auths
++ 				$sql_array = array(
++-					'SELECT'	=> 'u.user_id, u.username, u.user_colour, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id,
+++					'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id,
++ 									t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
++ 					'FROM'		=> array(TOPICS_TABLE => 't'),
++ 					'LEFT_JOIN'	=> array(
++@@ -140,19 +141,61 @@ class hot_topics extends \sitesplat\sidebar\types\type\base
++ 										$row['topic_last_post_id']);
++ 					$forum_name_url = append_sid("{$this->root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
++ 					$topic_title = censor_text($row['topic_title']);
++-					if (utf8_strlen($topic_title) >= 60)
++-					{
++-						$topic_title = (utf8_strlen($topic_title) > 60 + 3) ? utf8_substr($topic_title, 0, 60) . '...' : $topic_title;
++-					}
+++					// can't truncate with bbemoji
+++					// if (utf8_strlen($topic_title) >= 60)
+++					// {
+++						// $topic_title = (utf8_strlen($topic_title) > 60 + 3) ? utf8_substr($topic_title, 0, 60) . '...' : $topic_title;
+++					// }
++ 					$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
++ 
+++					/**
+++					* Event to modify topic data before they are assigned
+++					*
+++					* @event sitesplat.bbsidebar.type.hot_topics_tpl_before
+++					* @var	string	topic_id		Topic ID
+++					* @var	string	forum_id		Forum ID
+++					* @var	string	forum_name		Forum name
+++					* @var	boolean	post_unread		Are there any posts unread?
+++					* @var	string	view_topic_url	Topic URL
+++					* @var	string	forum_name_url	Forum URL
+++					* @var	string	topic_title		Topic title
+++					* @var	boolean	is_guest		Is post author anonymous?
+++					* @since 1.5.0
+++					*/
+++					$vars = array(
+++						'topic_id',
+++						'forum_id',
+++						'forum_name',
+++						'post_unread',
+++						'view_topic_url',
+++						'forum_name_url',
+++						'topic_title',
+++						'is_guest',
+++					);
+++					extract($phpbb_dispatcher->trigger_event('sitesplat.bbsidebar.type.hot_topics_tpl_before', compact($vars)));
+++					
+++					$board_url = generate_board_url() . '/';
+++					$match = array();
+++					$avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@',
+++							  phpbb_get_user_avatar(
+++								  array('avatar'			=> $row['user_avatar'], 
+++								        'user_id'			=> $row['user_id'],
+++										'avatar_type'		=> $row['user_avatar_type'], 
+++										'avatar_width'		=> $row['user_avatar_width'], 
+++										'avatar_height'		=> $row['user_avatar_height'])), $match) :
+++										generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');
+++
+++					$username_string = ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . 
+++												get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : 
+++												$this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
+++
++ 					$tpl_ary = array(
++ 						'U_TOPIC'			=> $view_topic_url,
++ 						'U_FORUM'			=> $forum_name_url,
++ 						'S_UNREAD'			=> ($post_unread) ? true : false,
++-						'USERNAME_FULL'		=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . 
++-												get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : 
++-												$this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
+++						//'AVATAR'			=> ((sizeof($match) > 1) ? str_replace('./../../', './', array_pop($match)) : $avatar),
+++						'AVATAR'			=> ((sizeof($match) > 1) ? strtr(array_pop($match), [ 'gallery/../random' => 'random', './../../' => $board_url,  './../' => $board_url, './' => $board_url ]) : $avatar),
+++						'USERNAME_FULL'		=> $username_string,
++ 						'LAST_TOPIC_TIME'	=> $this->user->format_date($row['topic_last_post_time']),
++ 						'TOPIC_TITLE' 		=> $topic_title,
++ 						'TOPIC_TITLE_NO_HTML'	=> $topic_title,
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/last_badges.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/last_badges.php"
++index f9fc70bb3..ff73e1dd2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/last_badges.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/last_badges.php"
++@@ -64,7 +64,7 @@ class last_badges extends \sitesplat\sidebar\types\type\base
++ 		$howmany = $this->howmany();
++ 		$sql_where = str_replace('user_id', 'b.user_id', $this->ignore_users());
++ 
++-		$sql_and = !empty($sql_where) ? ' AND user_inactive_reason = 0' : ' WHERE user_inactive_reason = 0';
+++		$sql_and = !empty($sql_where) ? ' AND user_posts > 1 AND user_inactive_reason = 0' : ' WHERE user_posts > 1 AND user_inactive_reason = 0';
++ 		// latest users
++ 		if (($newest_users = $this->cache->get('_sidebar_last_badges')) === false)
++ 		{
++@@ -77,8 +77,8 @@ class last_badges extends \sitesplat\sidebar\types\type\base
++ 			$sql = 'SELECT b.user_id, r.rule_name, u.username, u.user_colour, b.date, ba.badge 
++ 				FROM ' . $badge_event_table . ' b
++ 				LEFT JOIN ' . $badge_rules_table . ' r ON r.rule_id = b.rule_id
++-				LEFT JOIN ' . $badge_badges_table . ' ba ON ba.badge_id = r.badge_id 
++-				LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = b.user_id
+++				INNER JOIN ' . $badge_badges_table . ' ba ON ba.badge_id = r.badge_id 
+++				INNER JOIN ' . USERS_TABLE . ' u ON u.user_id = b.user_id
++ 				' . $sql_where . '
++ 				' . $sql_and . '
++ 				ORDER BY b.date DESC';
++@@ -97,8 +97,8 @@ class last_badges extends \sitesplat\sidebar\types\type\base
++ 			}
++ 			$this->db->sql_freeresult($result);
++ 
++-			// cache this data for 5 minutes, this improves performance
++-			$this->cache->put('_sidebar_last_badges', $newest_users, 300);
+++			// cache this data for 30 minutes, this improves performance
+++			$this->cache->put('_sidebar_last_badges', $newest_users, 1800);
++ 		}
++ 
++ 		foreach ($newest_users as $row)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/last_members.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/last_members.php"
++index 1f54d2a51..bc13e1f82 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/last_members.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/last_members.php"
++@@ -87,7 +87,7 @@ class last_members extends \sitesplat\sidebar\types\type\base
++ 						'avatar_width'     => $row['user_avatar_width'], 
++ 						'avatar_height'    => $row['user_avatar_height'])), $match) :
++ 						generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');
++-
+++						
++ 				if (count($match) > 1) {
++ 					$avatar = array_pop($match);
++ 					// fix an issue with BBrandom
++@@ -98,7 +98,7 @@ class last_members extends \sitesplat\sidebar\types\type\base
++ 				}
++ 
++ 				$newest_users[$row['user_id']] = array(
++-				//	'avatar'     			=> ((sizeof($match) > 1) ? str_replace('./../../', './', array_pop($match)) : $avatar),
+++					//	'avatar'     			=> ((sizeof($match) > 1) ? str_replace('./../../', './', array_pop($match)) : $avatar),
++ 					'avatar'				=> $avatar,
++ 					'user_id'				=> $row['user_id'],
++ 					'username'				=> $row['username'],
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/staff.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/staff.php"
++index ca90af0d2..bb928ae03 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/staff.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/staff.php"
++@@ -72,7 +72,8 @@ class staff extends \sitesplat\sidebar\types\type\base
++ 			$staff_ids = $staff_online = [];
++ 			$sql = 'SELECT u.user_id
++ 					FROM ' . GROUPS_TABLE . ' g, ' . USER_GROUP_TABLE . " u
++-					WHERE LOWER(g.group_name) LIKE '%staff%' AND u.group_id = g.group_id";
+++					WHERE u.group_id = g.group_id AND u.group_id = 15";
+++					// WHERE LOWER(g.group_name) LIKE '%staff%' AND u.group_id = g.group_id";
++ 			$result = $this->db->sql_query($sql);
++ 			while ($row = $this->db->sql_fetchrow($result))
++ 			{
++@@ -159,12 +160,14 @@ class staff extends \sitesplat\sidebar\types\type\base
++ 		{
++ 			foreach ($staff_online as $row)
++ 			{
+++				$last_visit = $this->user->format_date($row['last_visit'], '|d M Y|, H:i');
+++				$last_active = (!empty($row['last_active'])) ? $this->user->format_date($row['last_active'], '|d M Y|, H:i') : $this->user->lang['STAFF_UNKNOWN'];
++ 				$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) :
++ 									get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
++ 
++ 				$this->template->assign_block_vars('staff',array(
++ 					'S_SEARCH_ACTION'	=> append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
++-					'TIME'	 			=> ($row['last_visit']) ? $this->user->format_date($row['last_visit'], '|d M Y|, H:i') : $this->user->lang['STAFF_UNKNOWN'],
+++					'TIME'	 			=> (!empty($row['last_visit'])) ? $last_visit : $last_active,
++ 					'USERNAME_FULL'		=> $username_string,
++ 					'AVATAR'			=> $row['avatar']
++ 				));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/top_posters.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/top_posters.php"
++index a8f3c774b..07b5856aa 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/top_posters.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/top_posters.php"
++@@ -61,10 +61,11 @@ class top_posters extends \sitesplat\sidebar\types\type\base
++ 	public function outputblock()
++ 	{
++ 		$howmany = $this->howmany();
++-		$sql_where = $this->ignore_users();
+++		$sql_where = $this->ignore_users('user_posts > 1');
+++		$sql_where_improve = $this->ignore_users('post_counts.user_posts > 1');
++ 
++ 		//set two variables for the sql
++-		$sql_and = $sql_other = '';
+++		$sql_and = $sql_other = $sql_other_improve = '';
++ 
++ 		if (($user_posts = $this->cache->get('_sidebar_posters')) === false)
++ 		{
++@@ -89,17 +90,19 @@ class top_posters extends \sitesplat\sidebar\types\type\base
++ 				}
++ 			}
++ 			$sql_other = (empty($sql_and) && empty($sql_where)) ? ' WHERE' : ' AND';
++-			$sql_other .=  ' user_posts <> 0';
+++			$sql_other .= empty($sql_where) ? ' user_posts <> 0' : ' 1=1';
+++			$sql_other_improve = (empty($sql_and) && empty($sql_where)) ? ' WHERE' : ' AND';
+++			$sql_other_improve .= empty($sql_where_improve) ? ' post_counts.user_posts <> 0' : ' 1=1';
++ 			$user_posts[0] = $user_posts[1] = $user_posts[2] = array();
++ 
++ 		//  damn phpbb url rewrite and broken driver
++ 		//	$board_url = generate_board_url();
++ 			$board_url = generate_board_url() . '/';
++ 			
++-			// do the main sql query		
+++			// do the main sql query
++ 			$sql = 'SELECT user_id, username, user_colour, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height, user_posts
++ 				FROM ' . USERS_TABLE . '
++-				 ' . $sql_where . ' ' . $sql_and . '
+++				' . $sql_where . ' ' . $sql_and . '
++ 				' . $sql_other . '
++ 				ORDER BY user_posts DESC';
++ 
++@@ -115,7 +118,7 @@ class top_posters extends \sitesplat\sidebar\types\type\base
++ 										'avatar_width'	=> $row['user_avatar_width'], 
++ 										'avatar_height'	=> $row['user_avatar_height'])), $match) :
++ 										generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');
++-				
+++										
++ 				if (count($match) > 1) {
++ 					$avatar = array_pop($match);
++ 					// fix an issue with BBrandom
++@@ -123,7 +126,7 @@ class top_posters extends \sitesplat\sidebar\types\type\base
++ 						$avatar = str_replace(['./../../', './../', './'], $board_url, $avatar);
++ 					}
++ 				}
++-
+++				
++ 				$user_posts[0][$row['user_id']] = array(
++ 					'user_id'      => $row['user_id'],
++ 					'username'      => $row['username'],
++@@ -137,14 +140,24 @@ class top_posters extends \sitesplat\sidebar\types\type\base
++ 
++ 
++ 			// do the main sql query
++-			$sql = 'SELECT user_id, username, user_colour, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height, COUNT(p.post_id) AS user_posts
++-					FROM ' . POSTS_TABLE . ' p
++-					LEFT JOIN ' . USERS_TABLE . ' ON user_id = p.poster_id
++-					' . $sql_where . ' ' . $sql_and . '
++-					' . $sql_other . '
++-					AND p.post_time > ' . (time() - 86400 ) . '
++-					GROUP BY p.poster_id
++-					ORDER BY user_posts DESC';
+++			$timestamp = time() - 86400;
+++			$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, post_counts.user_posts
+++					FROM ' . USERS_TABLE . ' u
+++					LEFT JOIN (
+++						SELECT
+++							poster_id,
+++							COUNT(post_id) AS user_posts
+++						FROM
+++							' . POSTS_TABLE . '
+++						WHERE
+++							post_time > ' . $timestamp . '
+++						GROUP BY
+++							poster_id
+++					) AS post_counts ON u.user_id = post_counts.poster_id 
+++					' . $sql_where_improve . ' ' . $sql_and . '
+++					' . $sql_other_improve . '
+++					AND post_counts.user_posts IS NOT NULL
+++					ORDER BY post_counts.user_posts DESC';
++ 			$result = $this->db->sql_query_limit($sql, $howmany);
++ 			while ($row = $this->db->sql_fetchrow($result))
++ 			{
++@@ -170,14 +183,24 @@ class top_posters extends \sitesplat\sidebar\types\type\base
++ 
++ 
++ 			// do the main sql query
++-			$sql = 'SELECT user_id, username, user_colour, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height, COUNT(p.post_id) AS user_posts
++-					FROM ' . POSTS_TABLE . ' p
++-					LEFT JOIN ' . USERS_TABLE . ' ON user_id = p.poster_id
++-					' . $sql_where . ' ' . $sql_and . '
++-					' . $sql_other . '
++-					AND p.post_time > ' . (time() - (86400 * 7)) . '
++-					GROUP BY p.poster_id
++-					ORDER BY user_posts DESC';
+++			$timestamp = time() - (86400 * 7);
+++			$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, post_counts.user_posts
+++					FROM ' . USERS_TABLE . ' u
+++					LEFT JOIN (
+++						SELECT
+++							poster_id,
+++							COUNT(post_id) AS user_posts
+++						FROM
+++							' . POSTS_TABLE . '
+++						WHERE
+++							post_time > ' . $timestamp . '
+++						GROUP BY
+++							poster_id
+++					) AS post_counts ON u.user_id = post_counts.poster_id
+++					' . $sql_where_improve . ' ' . $sql_and . '
+++					' . $sql_other_improve . '
+++					AND IFNULL(post_counts.user_posts, 0) <> 0
+++					ORDER BY post_counts.user_posts DESC';
++ 			$result = $this->db->sql_query_limit($sql, $howmany);
++ 			while ($row = $this->db->sql_fetchrow($result))
++ 			{
++@@ -195,14 +218,15 @@ class top_posters extends \sitesplat\sidebar\types\type\base
++ 					'user_id'      => $row['user_id'],
++ 					'username'      => $row['username'],
++ 					'user_colour'   => $row['user_colour'],
++-					'avatar'		=> (sizeof($match) > 1) ? array_pop($match) : $avatar,
+++					//'avatar'		=> (sizeof($match) > 1) ? array_pop($match) : $avatar,
+++					'avatar'		=> ((sizeof($match) > 1) ? strtr(array_pop($match), [ 'gallery/../random' => 'random', './../../' => $board_url,  './../' => $board_url, './' => $board_url ]) : $avatar),
++ 					'user_posts'    => $row['user_posts'],
++ 				);
++ 			}
++ 			$this->db->sql_freeresult($result);
++ 
++-			// cache this data for 5 minutes, this improves performance
++-			$this->cache->put('_sidebar_posters', $user_posts, 300);
+++			// cache this data for 30 minutes, this improves performance
+++			$this->cache->put('_sidebar_posters', $user_posts, 1800);
++ 		}
++ 
++ 		foreach ($user_posts[0] as $row)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/top_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\sidebar/types/type/top_topics.php"
++index 52949ef4c..112cf66d9 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\sidebar/types/type/top_topics.php"
+++++ "b/C:
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\sidebar/event/listener.php" "[FORUM_EXT]/sitesplat\\sidebar/event/listener.php"
--- "[ORIGINAL]/sitesplat\\sidebar/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\sidebar/event/listener.php"
@@ -29,8 +29,9 @@ class listener implements EventSubscriberInterface
 	protected $config;
 	protected $root_path;
 	protected $php_ext;
+	protected $ext_manager;
 
-	public function __construct(\sitesplat\sidebar\types\manager $manager, \phpbb\user $user, \phpbb\request\request $request, \phpbb\config\db_text $config_text, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\config\config $config, $phpbb_root_path, $php_ext)
+	public function __construct(\sitesplat\sidebar\types\manager $manager, \phpbb\user $user, \phpbb\request\request $request, \phpbb\config\db_text $config_text, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\config\config $config, $phpbb_root_path, $php_ext, \phpbb\extension\manager $ext_manager)
 	{
 		$this->manager = $manager;
 		$this->user = $user;
@@ -41,6 +42,7 @@ class listener implements EventSubscriberInterface
 		$this->config = $config;
 		$this->phpbb_root_path = $phpbb_root_path;
 		$this->php_ext = $php_ext;
+		$this->ext_manager = $ext_manager;
 	}
 
 	static public function getSubscribedEvents()
@@ -100,6 +102,13 @@ class listener implements EventSubscriberInterface
 					$this->manager->check_condition($type_name) : null;
 			}
 
+			if ($this->ext_manager->is_enabled('phpbb/collapsiblecategories'))
+			{
+				$this->template->assign_vars(array(
+					'PHPBB_COLLAPSIBLE_ENABLED'	=> true,
+				));
+			}
+
 			$this->template->assign_vars(array(
 				'S_SIDEBAR_TYPE'			=> !$sidebar_config['type'],
 				'S_SIDEBAR_ALL_PAGES'		=> !$sidebar_config['all_pages'],
diff --git "[ORIGINAL]/sitesplat\\sidebar/extra/overall_footer_content_after.html" "[FORUM_EXT]/sitesplat\\sidebar/extra/overall_footer_content_after.html"
--- "[ORIGINAL]/sitesplat\\sidebar/extra/overall_footer_content_after.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/extra/overall_footer_content_after.html"
@@ -1,5 +1,5 @@
-<!-- IF S_SIDEBAR_ALL_PAGES or S_INDEX -->
+{% if S_SIDEBAR_ALL_PAGES or S_INDEX %}
 	</div>
 </div>
 </div>
-<!-- ENDIF -->
\ No newline at end of file
+{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\sidebar/extra/overall_header_content_before.html" "[FORUM_EXT]/sitesplat\\sidebar/extra/overall_header_content_before.html"
--- "[ORIGINAL]/sitesplat\\sidebar/extra/overall_header_content_before.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/extra/overall_header_content_before.html"
@@ -1,18 +1,18 @@
-<!-- IF S_SIDEBAR_ALL_PAGES or S_INDEX -->
+{% if S_SIDEBAR_ALL_PAGES or S_INDEX %}
 <div class="row">
 	<div class="col-md-3" id="page-sidebar">
 		<div id="sidebar-border">
-		<!-- BEGIN slot -->
-		<!-- IF slot.SIDEBAR_SLOT == 1 -->
-			<!-- DEFINE $TITLE = '{slot.SIDEBAR_TITLE}' -->
-			<!-- DEFINE $TEXT = '{slot.SIDEBAR_TEXT}' -->
-			<!-- INCLUDE custom.html -->
-		<!-- ELSE IF not slot.SIDEBAR_SLOT == 0 -->
-			<!-- INCLUDE {slot.SIDEBAR_SLOT} -->
-		<!-- ENDIF -->
-		<!-- END slot -->
+		{% for slot in loops.slot %}
+		{% if slot.SIDEBAR_SLOT == 1 %}
+			{% DEFINE TITLE = ''~ slot.SIDEBAR_TITLE ~'' %}
+			{% DEFINE TEXT = ''~ slot.SIDEBAR_TEXT ~'' %}
+			{% INCLUDE 'custom.html' %}
+		{% elseif not slot.SIDEBAR_SLOT == 0 %}
+			{% INCLUDE ''~ slot.SIDEBAR_SLOT ~'' %}
+		{% endif %}
+		{% endfor %}
 		</div>
 	</div>
 	<div id="contentje">
 	 <div class="col-md-9">
-<!-- ENDIF -->
\ No newline at end of file
+{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\sidebar/extra/overall_header_stylesheets_after.html" "[FORUM_EXT]/sitesplat\\sidebar/extra/overall_header_stylesheets_after.html"
--- "[ORIGINAL]/sitesplat\\sidebar/extra/overall_header_stylesheets_after.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/extra/overall_header_stylesheets_after.html"
@@ -1,37 +1,37 @@
-<!-- IF S_INDEX -->
-	<!-- IF not S_SIDEBAR_TYPE -->
-		<!-- IF S_SIDEBAR_WIDTH -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarright.css -->
-		<!-- ELSE -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebar20right.css -->
-		<!-- ENDIF -->
-	<!-- ELSE -->
-		<!-- IF S_SIDEBAR_WIDTH -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft.css -->
-		<!-- ELSE -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft20.css -->
-		<!-- ENDIF -->
-	<!-- ENDIF -->
-<!-- ENDIF -->
+{% if S_INDEX %}
+	{% if not S_SIDEBAR_TYPE %}
+		{% if S_SIDEBAR_WIDTH %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebarright.css' %}
+		{% else %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebar20right.css' %}
+		{% endif %}
+	{% else %}
+		{% if S_SIDEBAR_WIDTH %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft.css' %}
+		{% else %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft20.css' %}
+		{% endif %}
+	{% endif %}
+{% endif %}
 
-<!-- IF S_SIDEBAR_ALL_PAGES and not S_INDEX -->
-	<!-- IF not S_SIDEBAR_TYPE -->
-		<!-- IF S_SIDEBAR_WIDTH -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarright.css -->
-		<!-- ELSE -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebar20right.css -->
-		<!-- ENDIF -->
-	<!-- ELSE -->
-		<!-- IF S_SIDEBAR_WIDTH -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft.css -->
-		<!-- ELSE -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft20.css -->
-		<!-- ENDIF -->
-	<!-- ENDIF -->
-<!-- ENDIF -->
+{% if S_SIDEBAR_ALL_PAGES and not S_INDEX %}
+	{% if not S_SIDEBAR_TYPE %}
+		{% if S_SIDEBAR_WIDTH %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebarright.css' %}
+		{% else %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebar20right.css' %}
+		{% endif %}
+	{% else %}
+		{% if S_SIDEBAR_WIDTH %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft.css' %}
+		{% else %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft20.css' %}
+		{% endif %}
+	{% endif %}
+{% endif %}
 
-<!-- INCLUDECSS @sitesplat_sidebar/sidebar.css -->
+{% INCLUDECSS '@sitesplat_sidebar/sidebar.css' %}
 
-<!-- IF S_SIDEBAR_DYNAMIC -->
-	<!-- INCLUDECSS @sitesplat_sidebar/sidebar_dynamic.css -->
-<!-- ENDIF -->
\ No newline at end of file
+{% if S_SIDEBAR_DYNAMIC %}
+	{% INCLUDECSS '@sitesplat_sidebar/sidebar_dynamic.css' %}
+{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\sidebar/language/en/sidebar.php" "[FORUM_EXT]/sitesplat\\sidebar/language/en/sidebar.php"
--- "[ORIGINAL]/sitesplat\\sidebar/language/en/sidebar.php"
+++ "[FORUM_EXT]/sitesplat\\sidebar/language/en/sidebar.php"
@@ -41,7 +41,7 @@ $lang = array_merge($lang, array(
 	'LAST_BADGES'		=> 'Last badges',
 	'SIDEBAR_BADGE'		=> 'Badge name',
 	'SIDEBAR_DATE'		=> 'Date',
-	'LAST_BBREACTIONS'	=> 'Last BBreactions',
+	'LAST_BBREACTIONS'	=> 'Last reactions',
 	'SIDEBAR_REACTION'	=> 'Reaction type',
 	'BBPOINTS'			=> 'BBpoints',
 	'POLL'				=> 'Last poll',
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/BBOOTS/template/js/membership.js" "[FORUM_EXT]/sitesplat\\sidebar/styles/BBOOTS/template/js/membership.js"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/BBOOTS/template/js/membership.js"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/BBOOTS/template/js/membership.js"
@@ -18,8 +18,8 @@ head.ready(function () {
 			},
 			credits: {
 				enabled: false,
-				text: 'sitesplat.com',
-				href: 'https://sitesplat.com'
+				text: 'goldtuganime.com',
+				href: 'https://goldtuganime.com'
 			},
 			exporting: { enabled: false },
 			tooltip: {
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/BBOOTS/template/js/poll.js" "[FORUM_EXT]/sitesplat\\sidebar/styles/BBOOTS/template/js/poll.js"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/BBOOTS/template/js/poll.js"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/BBOOTS/template/js/poll.js"
@@ -18,8 +18,8 @@ head.ready(function () {
 			},
 			credits: {
 				enabled: false,
-				text: 'sitesplat.com',
-				href: 'https://sitesplat.com'
+				text: 'goldtuganime.com',
+				href: 'https://goldtuganime.com'
 			},
 			exporting: { enabled: false },
 			tooltip: {
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/bbdownloads.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/bbdownloads.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/bbdownloads.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/bbdownloads.html"
@@ -1,44 +1,62 @@
-<!-- IF .pop_downloads -->
+{% if loops.pop_downloads|length %}
 <div class="sidebar">
-<div id="bbdownloads{slot.SIDEBAR_ID}" class="panel panel-info">
+<div id="bbdownloads{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
     <div class="panel-heading">
-     <h4 class="panel-title">{L_DOWNLOADS}</h4>
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-bbdownloads{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('DOWNLOADS') }}</span>
     </div>
-	<div class="panel-body">
-	 <div id="bbdownloadsinner{slot.SIDEBAR_ID}" class="inner">
+	 <div id="innerbbdownloads{{ slot.SIDEBAR_ID }}" class="panel-body inner">
 		
 		  <ul class="nav nav-pills nav-top-poster nav-justified">
-			<li class="active"><a data-toggle="pill" href="#popDown">{L_POP_DOWNLOADS}</a></li>
-			<li><a data-toggle="pill" href="#newDown">{L_NEW_DOWNLOADS}</a></li>
+			<li class="active"><a data-toggle="pill" href="#popDown">{{ lang('POP_DOWNLOADS') }}</a></li>
+			<li><a data-toggle="pill" href="#newDown">{{ lang('NEW_DOWNLOADS') }}</a></li>
 		  </ul>
 		  
 		  <div class="tab-content media-list user-list">
 			<div id="popDown" class="tab-pane fade in active">
-				<ul class="media">
-				<!-- BEGIN pop_downloads -->
-					<li><a href="{pop_downloads.S_SEARCH_ACTION}">{pop_downloads.TITLE}</a> <span class="pull-right">{pop_downloads.TOTAL}</span><!-- IF not pop_downloads.S_LAST_ROW --><hr /><!-- ENDIF --></li>
-				<!-- BEGINELSE -->
-					<li>{L_NO_MEMBERS}<hr /></li>
-				<!-- END pop_downloads -->	
+				<ul class="media-list user-list">
+				{% for pop_downloads in loops.pop_downloads %}
+					<li class="sidebar-last-column">
+						<span class="last-wrapper text-overflow">
+							<a href="{{ pop_downloads.S_SEARCH_ACTION }}">{{ pop_downloads.TITLE }}</a><br />
+							<span class="pull-right"><i class="fa fa-download"></i>&nbsp;{{ pop_downloads.TOTAL }}</span>
+						</span>
+					</li>
+				{% else %}
+					<li class="sidebar-last-column">
+						<span class="last-wrapper text-overflow">
+							{{ lang('NO_MEMBERS') }}
+						</span>
+					</li>
+				{% endfor %}	
 				</ul>
 			</div>
 				
 			<div id="newDown" class="tab-pane fade">
-				<ul class="media">
-				<!-- BEGIN new_downloads -->
-					<li><a href="{new_downloads.S_SEARCH_ACTION}">{new_downloads.TITLE}</a> <span class="pull-right">{new_downloads.TIMESTAMP}</span><!-- IF not new_downloads.S_LAST_ROW --><hr /><!-- ENDIF --></li>
-				<!-- BEGINELSE -->
-					<li>{L_NO_MEMBERS}<hr /></li>
-				<!-- END new_downloads -->	
+				<ul class="media-list user-list">
+				{% for new_downloads in loops.new_downloads %}
+					<li class="sidebar-last-column">
+						<span class="last-wrapper text-overflow">
+							<a href="{{ new_downloads.S_SEARCH_ACTION }}">{{ new_downloads.TITLE }}</a><br />
+							<span class="pull-right forum-time"><i class="fa fa-clock-o"></i>&nbsp;{{ new_downloads.TIMESTAMP }}</span>
+						</span>
+					</li>
+				{% else %}
+					<li class="sidebar-last-column">
+						<span class="last-wrapper text-overflow">
+							{{ lang('NO_MEMBERS') }}
+						</span>
+					</li>
+				{% endfor %}	
 				</ul>
 			</div>
 		  </div>
 		</div>
 	</div>
 </div>
-</div>
-<!-- ENDIF -->
-
-
-
-
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}!=""){$(".toggle-bbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }});$("#innerbbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }})}$(".toggle-bbdownloads{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-bbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerbbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-bbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerbbdownloads{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_bbdownloads{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/bbpoints.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/bbpoints.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/bbpoints.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/bbpoints.html"
@@ -1,22 +1,26 @@
-<!-- IF .bbpoints -->
+{% if loops.bbpoints|length %}
 <div class="sidebar">
-<div id="bbpoints{slot.SIDEBAR_ID}" class="panel panel-inverse">
+<div id="bbpoints{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
     <div class="panel-heading">
-     <h4 class="panel-title">{L_BBPOINTS}</h4>
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-bbpoints{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('BBPOINTS') }}</span>
     </div>
-	<div class="panel-body">
-	 <div id="innerbbpoints{slot.SIDEBAR_ID}" class="inner">
+	<div id="innerbbpoints{{ slot.SIDEBAR_ID }}" class="panel-body inner">
 		<ul class="media-list user-list">
-		<!-- BEGIN bbpoints -->
+		{% for bbpoints in loops.bbpoints %}
 		<li class="media">
-		 <div class="media-body">
-		    {bbpoints.USERNAME_FULL}{L_COLON}&nbsp;<!-- IF SYMBOL_POS --><i class="fa {BBPOINTS_SYMBOL}"></i>&nbsp;<!-- ENDIF -->{bbpoints.BBPOINTS}<!-- IF not SYMBOL_POS --><i class="fa {BBPOINTS_SYMBOL}"></i><!-- ENDIF --><!-- IF S_REGISTERED_USER and bbpoints.TRANSFER_URL -->&nbsp;<a href="{bbpoints.TRANSFER_URL}" data-ajax="true" title="{L_TRANSFER_TO}"><i class="fa fa-random"></i></a><!-- ENDIF -->
-		 </div>
+		 <span class="media-body">
+		    {{ bbpoints.USERNAME_FULL }}{{ lang('COLON') }}&nbsp;{% if SYMBOL_POS %}<i class="fa {{ BBPOINTS_SYMBOL }}"></i>&nbsp;{% endif %}{{ bbpoints.BBPOINTS }}{% if not SYMBOL_POS %}<i class="fa {{ BBPOINTS_SYMBOL }}"></i>{% endif %}{% if S_REGISTERED_USER and bbpoints.TRANSFER_URL %}&nbsp;<a href="{{ bbpoints.TRANSFER_URL }}" data-ajax="true" title="{{ lang('TRANSFER_TO') }}"><i class="fa fa-random"></i></a>{% endif %}
+		 </span>
 		</li>
-		<!-- END bbpoints -->		
+		{% endfor %}
 		</ul>
 	</div>
 </div>
 </div>
-</div>
-<!-- ENDIF -->
\ No newline at end of file
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}!=""){$(".toggle-bbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }});$("#innerbbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }})}$(".toggle-bbpoints{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-bbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerbbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-bbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerbbpoints{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_bbpoints{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/birthday.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/birthday.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/birthday.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/birthday.html"
@@ -1,18 +1,22 @@
-<!-- IF .birthday -->
+{% if loops.birthday|length %}
 <div class="sidebar">
-<div id="birthday{slot.SIDEBAR_ID}" class="panel panel-info">
+<div id="birthday{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
     <div class="panel-heading">
-     <h4 class="panel-title">{L_BIRTHDAYS}</h4>
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-birthday{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('BIRTHDAYS') }}</span>
     </div>
-	<div class="panel-body">
-	 <div id="innerbirthday{slot.SIDEBAR_ID}" class="inner">
-		<ul class="list-unstyled">	
-		<!-- BEGIN birthday -->
-			<li title="{birthday.BIRTHDAY}"><i class="fa fa-gift"></i>&nbsp;{birthday.USERNAME_FULL}&nbsp;&#45;&nbsp;{L_AGE}{L_COLON}&nbsp;{birthday.AGE}</li>
-		<!-- END birthday -->	
+	<div id="innerbirthday{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+		<ul class="media-list user-list">
+		{% for birthday in loops.birthday %}
+			<li class="media" title="{{ birthday.BIRTHDAY }}"><i class="fa fa-gift"></i>&nbsp;{{ birthday.USERNAME_FULL }}&nbsp;&#45;&nbsp;{{ lang('AGE') }}{{ lang('COLON') }}&nbsp;{{ birthday.AGE }}</li>
+		{% endfor %}	
 		</ul>
 	</div>
 </div>
 </div>
-</div>
-<!-- ENDIF -->
\ No newline at end of file
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}!=""){$(".toggle-birthday{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }});$("#innerbirthday{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }})}$(".toggle-birthday{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-birthday{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerbirthday{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-birthday{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerbirthday{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_birthday{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/custom.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/custom.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/custom.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/custom.html"
@@ -1,12 +1,16 @@
 <div class="sidebar">
-<div id="custom{slot.SIDEBAR_ID}" class="panel panel-inverse">
+<div id="custom{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
     <div class="panel-heading">
-     <h4 class="panel-title">{$TITLE}</h4>
-    </div>
-	<div class="panel-body">
-	 <div id="innercustom{slot.SIDEBAR_ID}" class="inner">
-		{$TEXT}
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-custom{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ definition.TITLE }}</span>
     </div>
+    <div id="innercustom{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+		{{ definition.TEXT }}
     </div>
 </div>
 </div>
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}!=""){$(".toggle-custom{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }});$("#innercustom{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }})}$(".toggle-custom{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-custom{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innercustom{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-custom{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innercustom{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_custom{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/donations.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/donations.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/donations.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/donations.html"
@@ -1,29 +1,33 @@
-<!-- IF .donations -->
+{% if loops.donations|length %}
 <div class="sidebar">
-<div id="donators{slot.SIDEBAR_ID}" class="panel panel-info">
+<div id="donators{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
     <div class="panel-heading">
-     <h4 class="panel-title">{L_DONATIONS}</h4>
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-donators{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('DONATIONS') }}</span>
     </div>
-	<div class="panel-body">
-	 <div id="innerdonators{slot.SIDEBAR_ID}" class="inner">
+	<div id="innerdonators{{ slot.SIDEBAR_ID }}" class="panel-body inner">
 		 <div class="media-list user-list">
-			<!-- BEGIN donations -->
+			{% for donations in loops.donations %}
 			<div class="media">
 				<div class="media-left">
-					  <img alt="" src="{donations.AVATAR}" class="media-object img-circle">
+					<img alt="" src="{{ donations.AVATAR }}" class="media-object img-circle">
 				</div>
 				<div class="media-body">
-					<h4 class="media-heading">{donations.USERNAME_FULL}</h4>
-					<span><a href="#" title="{donations.TIME}">{donations.CURRENCY_SYMBOL} {donations.AMOUNT}</a></span>
+					<div class="media-heading">{{ donations.USERNAME_FULL }}</div>
+					<span><a href="#" title="{{ donations.TIME }}">{{ donations.CURRENCY_SYMBOL }} {{ donations.AMOUNT }}</a></span>
 				</div>
 			</div>
-			<!-- BEGINELSE -->
-             <div>{L_NO_MEMBERS}</div>
-			<!-- END donations -->
+			{% else %}
+             <div>{{ lang('NO_MEMBERS') }}</div>
+			{% endfor %}
 		 </div>	
-        <!-- IF U_DONATE_PAGE --><br /><a href="{U_DONATE_PAGE}">{L_DONATE_ALSO}</a><!-- ENDIF -->
+        {% if U_DONATE_PAGE %}<br /><a href="{{ U_DONATE_PAGE }}">{{ lang('DONATE_ALSO') }}</a>{% endif %}
 		</div>
 	</div>
 </div>
-</div>
-<!-- ENDIF -->
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}!=""){$(".toggle-donators{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }});$("#innerdonators{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }})}$(".toggle-donators{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-donators{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerdonators{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-donators{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerdonators{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_donators{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_footer_content_after.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_footer_content_after.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_footer_content_after.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_footer_content_after.html"
@@ -1,4 +1,4 @@
-<!-- IF S_SIDEBAR_ALL_PAGES or S_INDEX -->
+{% if S_SIDEBAR_ALL_PAGES or S_INDEX %}
 	</div>
 </div>
-<!-- ENDIF -->
\ No newline at end of file
+{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_content_before.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_content_before.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_content_before.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_content_before.html"
@@ -1,17 +1,17 @@
-<!-- IF S_SIDEBAR_ALL_PAGES or S_INDEX -->
+{% if S_SIDEBAR_ALL_PAGES or S_INDEX %}
 <div class="wrapper">
 	<div id="page-sidebar">
 		<div id="sidebar-border">
-		<!-- BEGIN slot -->
-		<!-- IF slot.SIDEBAR_SLOT == 1 -->
-			<!-- DEFINE $TITLE = '{slot.SIDEBAR_TITLE}' -->
-			<!-- DEFINE $TEXT = '{slot.SIDEBAR_TEXT}' -->
-			<!-- INCLUDE custom.html -->
-		<!-- ELSE IF not slot.SIDEBAR_SLOT == 0 -->
-			<!-- INCLUDE {slot.SIDEBAR_SLOT} -->
-		<!-- ENDIF -->
-		<!-- END slot -->
+		{% for slot in loops.slot %}
+		{% if slot.SIDEBAR_SLOT == 1 %}
+			{% DEFINE TITLE = ''~ slot.SIDEBAR_TITLE ~'' %}
+			{% DEFINE TEXT = ''~ slot.SIDEBAR_TEXT ~'' %}
+			{% INCLUDE 'custom.html' %}
+		{% elseif not slot.SIDEBAR_SLOT == 0 %}
+			{% INCLUDE ''~ slot.SIDEBAR_SLOT ~'' %}
+		{% endif %}
+		{% endfor %}
 		</div>
 	</div>
 	<div id="contentje">
-<!-- ENDIF -->
\ No newline at end of file
+{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_head_append.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_head_append.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_head_append.html"
@@ -1,3 +1,3 @@
-<!-- IF S_SIDEBAR_DYNAMIC -->
-	<!-- INCLUDEJS @sitesplat_sidebar/js/dynamic.js -->
-<!-- ENDIF -->
\ No newline at end of file
+{% if S_SIDEBAR_DYNAMIC %}
+	{% INCLUDEJS '@sitesplat_sidebar/js/dynamic.js' %}
+{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
@@ -1,37 +1,37 @@
-<!-- IF S_INDEX -->
-	<!-- IF not S_SIDEBAR_TYPE -->
-		<!-- IF S_SIDEBAR_WIDTH -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarright.css -->
-		<!-- ELSE -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebar20right.css -->
-		<!-- ENDIF -->
-	<!-- ELSE -->
-		<!-- IF S_SIDEBAR_WIDTH -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft.css -->
-		<!-- ELSE -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft20.css -->
-		<!-- ENDIF -->
-	<!-- ENDIF -->
-<!-- ENDIF -->
+{% if S_INDEX %}
+	{% if not S_SIDEBAR_TYPE %}
+		{% if S_SIDEBAR_WIDTH %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebarright.css' %}
+		{% else %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebar20right.css' %}
+		{% endif %}
+	{% else %}
+		{% if S_SIDEBAR_WIDTH %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft.css' %}
+		{% else %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft20.css' %}
+		{% endif %}
+	{% endif %}
+{% endif %}
 
-<!-- IF S_SIDEBAR_ALL_PAGES and not S_INDEX -->
-	<!-- IF not S_SIDEBAR_TYPE -->
-		<!-- IF S_SIDEBAR_WIDTH -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarright.css -->
-		<!-- ELSE -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebar20right.css -->
-		<!-- ENDIF -->
-	<!-- ELSE -->
-		<!-- IF S_SIDEBAR_WIDTH -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft.css -->
-		<!-- ELSE -->
-			<!-- INCLUDECSS @sitesplat_sidebar/sidebarleft20.css -->
-		<!-- ENDIF -->
-	<!-- ENDIF -->
-<!-- ENDIF -->
+{% if S_SIDEBAR_ALL_PAGES and not S_INDEX %}
+	{% if not S_SIDEBAR_TYPE %}
+		{% if S_SIDEBAR_WIDTH %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebarright.css' %}
+		{% else %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebar20right.css' %}
+		{% endif %}
+	{% else %}
+		{% if S_SIDEBAR_WIDTH %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft.css' %}
+		{% else %}
+			{% INCLUDECSS '@sitesplat_sidebar/sidebarleft20.css' %}
+		{% endif %}
+	{% endif %}
+{% endif %}
 
-<!-- INCLUDECSS @sitesplat_sidebar/sidebar.css -->
+{% INCLUDECSS '@sitesplat_sidebar/sidebar.css' %}
 
-<!-- IF S_SIDEBAR_DYNAMIC -->
-	<!-- INCLUDECSS @sitesplat_sidebar/sidebar_dynamic.css -->
-<!-- ENDIF -->
\ No newline at end of file
+{% if S_SIDEBAR_DYNAMIC %}
+	{% INCLUDECSS '@sitesplat_sidebar/sidebar_dynamic.css' %}
+{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/hot_topics.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/hot_topics.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/hot_topics.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/hot_topics.html"
@@ -1,27 +1,40 @@
-<!-- IF .hot_topics -->
+{% if loops.hot_topics|length %}
 <div class="sidebar">
-<div id="hot_topic{slot.SIDEBAR_ID}" class="panel panel-danger list-announcement">
+<div id="hot_topics{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
     <div class="panel-heading">
-        <h4 class="panel-title">{L_HOT_TOPICS}</h4>
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-hot-topics{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('HOT_TOPICS') }}</span>
     </div>
-    <div id="innerhot_topics{slot.SIDEBAR_ID}" class="panel-body inner">
-        <ul class="list-unstyled mb20">
-		<!-- BEGIN hot_topics -->
-		<!-- IF hot_topics.NO_TOPIC_TITLE-->
-				<li>   
-				   {hot_topics.NO_TOPIC_TITLE}
+    <div id="innerhot_topics{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+        <ul class="media-list user-list">
+		{% for hot_topics in loops.hot_topics %}
+		{% if hot_topics.NO_TOPIC_TITLE%}
+				<li class="media">    
+				   {{ hot_topics.NO_TOPIC_TITLE }}
 				</li>
-		<!-- ELSE -->
-            <li>
-               <!-- IF hot_topics.S_UNREAD --><span class="label label-warning">{L_UNREAD}</span>&nbsp;<!-- ENDIF --><a class="title-head" href="{hot_topics.U_TOPIC}" title="{{ hot_topics.TOPIC_TITLE_NO_HTML|e('html_attr') }}">{hot_topics.TOPIC_TITLE}</a>
-               <div>{hot_topics.USERNAME_FULL}</div>
-		  <!--// <div>{L_IN}{L_COLON}&nbsp;<a href="{hot_topics.U_FORUM}" title="{hot_topics.FORUM_NAME}">{hot_topics.FORUM_NAME}</a></div> -->
-			   <small class="date"><i class="fa fa-clock-o"></i>&nbsp;{hot_topics.LAST_TOPIC_TIME}</small>
+		{% else %}
+            <li class="media">
+				<span class="media-left">
+					<img alt="" src="{{ hot_topics.AVATAR }}" class="media-object img-circle">
+					{% if hot_topics.S_UNREAD %}<span class="label label-warning">{{ lang('UNREAD') }}</span>&nbsp;{% endif %}
+				</span>
+				<span class="media-body">
+					<a class="title-head" href="{{ hot_topics.U_TOPIC }}">{{ hot_topics.TOPIC_TITLE }}</a>
+					<br />
+					{{ hot_topics.USERNAME_FULL }}<br />
+					<span class="forum-time"><i class="fa fa-clock-o"></i>&nbsp;{{ hot_topics.LAST_TOPIC_TIME }}</span>
+				</span>
+				<!--// <span>{{ lang('IN') }}{{ lang('COLON') }}&nbsp;<a href="{{ hot_topics.U_FORUM }}" title="{{ hot_topics.FORUM_NAME }}">{{ hot_topics.FORUM_NAME }}</a></span><br /> -->
 			</li>
-		<!-- ENDIF -->	
-		<!-- END hot_topics -->
+		{% endif %}	
+		{% endfor %}
         </ul>
     </div>
 </div>
 </div>
-<!-- ENDIF -->
\ No newline at end of file
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}!=""){$(".toggle-hot-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }});$("#innerhot_topics{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }})}$(".toggle-hot-topics{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-hot-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerhot_topics{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-hot-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerhot_topics{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_hot_topics{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/js/highcharts.js" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/js/highcharts.js"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/js/highcharts.js"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/js/highcharts.js"
@@ -51,7 +51,7 @@ e,"stroke-width":h,transform:"translate"+k,fill:P});if(c)F(f,"height",t(F(f,"hei
 alignSetter:function(a){this.element.setAttribute("text-anchor",{left:"start",center:"middle",right:"end"}[a])},opacitySetter:function(a,b,c){this[b]=a;c.setAttribute(b,a)},titleSetter:function(a){var b=this.element.getElementsByTagName("title")[0];b||(b=x.createElementNS(xa,"title"),this.element.appendChild(b));b.textContent=p(a,"").replace(/<[^>]*>/g,"")},textSetter:function(a){if(a!==this.textStr)delete this.bBox,this.textStr=a,this.added&&this.renderer.buildText(this)},fillSetter:function(a,b,
 c){typeof a==="string"?c.setAttribute(b,a):a&&this.colorGradient(a,b,c)},zIndexSetter:function(a,b,c){c.setAttribute(b,a);this[b]=a},_defaultSetter:function(a,b,c){c.setAttribute(b,a)}};S.prototype.yGetter=S.prototype.xGetter;S.prototype.translateXSetter=S.prototype.translateYSetter=S.prototype.rotationSetter=S.prototype.verticalAlignSetter=S.prototype.scaleXSetter=S.prototype.scaleYSetter=function(a,b){this[b]=a;this.doTransform=!0};S.prototype["stroke-widthSetter"]=S.prototype.strokeSetter=function(a,
 b,c){this[b]=a;if(this.stroke&&this["stroke-width"])this.strokeWidth=this["stroke-width"],S.prototype.fillSetter.call(this,this.stroke,"stroke",c),c.setAttribute("stroke-width",this["stroke-width"]),this.hasStroke=!0;else if(b==="stroke-width"&&a===0&&this.hasStroke)c.removeAttribute("stroke"),this.hasStroke=!1};var ta=function(){this.init.apply(this,arguments)};ta.prototype={Element:S,init:function(a,b,c,d,e){var f=location,g,d=this.createElement("svg").attr({version:"1.1"}).css(this.getStyle(d));
-g=d.element;a.appendChild(g);a.innerHTML.indexOf("xmlns")===-1&&F(g,"xmlns",xa);this.isSVG=!0;this.box=g;this.boxWrapper=d;this.alignedObjects=[];this.url=(Ua||tb)&&x.getElementsByTagName("base").length?f.href.replace(/#.*?$/,"").replace(/([\('\)])/g,"\\$1").replace(/ /g,"%20"):"";this.createElement("desc").add().element.appendChild(x.createTextNode("Created with Highcharts 4.0.4 and sitesplat.com"));this.defs=this.createElement("defs").add();this.forExport=e;this.gradients={};this.cache={};this.setSize(b,c,!1);var h;
+g=d.element;a.appendChild(g);a.innerHTML.indexOf("xmlns")===-1&&F(g,"xmlns",xa);this.isSVG=!0;this.box=g;this.boxWrapper=d;this.alignedObjects=[];this.url=(Ua||tb)&&x.getElementsByTagName("base").length?f.href.replace(/#.*?$/,"").replace(/([\('\)])/g,"\\$1").replace(/ /g,"%20"):"";this.createElement("desc").add().element.appendChild(x.createTextNode("Created with Highcharts 4.0.4 and goldtuganime.com"));this.defs=this.createElement("defs").add();this.forExport=e;this.gradients={};this.cache={};this.setSize(b,c,!1);var h;
 if(Ua&&a.getBoundingClientRect)this.subPixelFix=b=function(){B(a,{left:0,top:0});h=a.getBoundingClientRect();B(a,{left:La(h.left)-h.left+"px",top:La(h.top)-h.top+"px"})},b(),N(G,"resize",b)},getStyle:function(a){return this.style=r({fontFamily:'"Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif',fontSize:"12px"},a)},isHidden:function(){return!this.boxWrapper.getBBox().width},destroy:function(){var a=this.defs;this.box=null;this.boxWrapper=this.boxWrapper.destroy();Pa(this.gradients||
 {});this.gradients=null;if(a)this.defs=a.destroy();this.subPixelFix&&X(G,"resize",this.subPixelFix);return this.alignedObjects=null},createElement:function(a){var b=new this.Element;b.init(this,a);return b},draw:function(){},buildText:function(a){for(var b=a.element,c=this,d=c.forExport,e=p(a.textStr,"").toString(),f=e.indexOf("<")!==-1,g=b.childNodes,h,i,j=F(b,"x"),k=a.styles,l=a.textWidth,n=k&&k.lineHeight,m=k&&k.HcTextStroke,o=g.length,Y=function(a){return n?y(n):c.fontMetrics(/(px|em)$/.test(a&&
 a.style.fontSize)?a.style.fontSize:k&&k.fontSize||c.style.fontSize||12,a).h};o--;)b.removeChild(g[o]);!f&&!m&&e.indexOf(" ")===-1?b.appendChild(x.createTextNode(e)):(h=/<.*style="([^"]+)".*>/,i=/<.*href="(http[^"]+)".*>/,l&&!a.added&&this.box.appendChild(b),e=f?e.replace(/<(b|strong)>/g,'<span style="font-weight:bold">').replace(/<(i|em)>/g,'<span style="font-style:italic">').replace(/<a/g,"<span").replace(/<\/(b|strong|i|em|a)>/g,"</span>").split(/<br.*?>/g):[e],e[e.length-1]===""&&e.pop(),q(e,function(e,
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/js/membership.js" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/js/membership.js"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/js/membership.js"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/js/membership.js"
@@ -18,8 +18,8 @@ head.ready(function () {
 			},
 			credits: {
 				enabled: false,
-				text: 'sitesplat.com',
-				href: 'https://sitesplat.com'
+				text: 'goldtuganime.com',
+				href: 'https://goldtuganime.com'
 			},
 			exporting: { enabled: false },
 			tooltip: {
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/js/poll.js" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/js/poll.js"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/js/poll.js"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/js/poll.js"
@@ -18,8 +18,8 @@ head.ready(function () {
 			},
 			credits: {
 				enabled: false,
-				text: 'sitesplat.com',
-				href: 'https://sitesplat.com'
+				text: 'goldtuganime.com',
+				href: 'https://goldtuganime.com'
 			},
 			exporting: { enabled: false },
 			tooltip: {
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/last_badges.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/last_badges.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/last_badges.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/last_badges.html"
@@ -1,29 +1,30 @@
-<!-- IF .last_badges -->
+{% if loops.last_badges|length %}
 <div class="sidebar">
-<div id="lastbadges{slot.SIDEBAR_ID}" class="panel panel-success">
+<div id="lastbadges{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
     <div class="panel-heading">
-     <h4 class="panel-title">{L_LAST_BADGES}</h4>
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-lastbadges{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('LAST_BADGES') }}</span>
     </div>
-	<div class="panel-body">
-	 <div id="innerlastbadges{slot.SIDEBAR_ID}" class="inner">
-		<ul class="media-list user-list">
-		<!-- BEGIN last_badges -->
-			<li class="media">
+	 <div id="innerlastbadges{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+		<div class="media-list user-list">
+		{% for last_badges in loops.last_badges %}
+			<div class="media">
 				<div class="media-left">
-                        <a href="#">
-                          <img alt="" src="{last_badges.BADGE}" class="media-object img-circle">
-                        </a>
+					<img alt="" src="{{ last_badges.BADGE }}" class="media-object img-circle">
 				</div>
 				<div class="media-body">
-                        <h4 class="media-heading">{last_badges.USERNAME_FULL}</h4>
-                        <span>{last_badges.NAME}</span>  
-						<small class="date"><i class="fa fa-clock-o"></i>&nbsp;{last_badges.BADGE_DATE}</small>
+					<div class="media-heading">{{ last_badges.USERNAME_FULL }}<br />{{ last_badges.NAME }}</div>
+					<span><a href="#"><i class="fa fa-clock-o"></i>&nbsp;{{ last_badges.BADGE_DATE }}</a></span>
 				</div>
-            </li>
-		<!-- END last_badges -->
-		</ul>
 			</div>
+		{% endfor %}
 		</div>
 	</div>
 </div>
-<!-- ENDIF -->
+</div>
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}!=""){$(".toggle-lastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }});$("#innerlastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }})}$(".toggle-lastbadges{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-lastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerlastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-lastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerlastbadges{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_lastbadges{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/last_bbreactions.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/last_bbreactions.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/last_bbreactions.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/last_bbreactions.html"
@@ -1,31 +1,36 @@
-<!-- IF .last_bbreactions -->
+{% if loops.last_bbreactions|length %}
 <div class="sidebar">
-<div id="lastbbreactions{slot.SIDEBAR_ID}" class="panel panel-inverse">
+<div id="lastbbreactions{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
     <div class="panel-heading">
-     <h4 class="panel-title">{L_LAST_BBREACTIONS}</h4>
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-lastbbreactions{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('LAST_BBREACTIONS') }}</span>
     </div>
-	<div class="panel-body">
-	 <div id="innerlastbbreactions{slot.SIDEBAR_ID}" class="inner">
+	 <div id="innerlastbbreactions{{ slot.SIDEBAR_ID }}" class="panel-body inner">
 		<ul class="media-list user-list">	
-		<!-- BEGIN last_bbreactions -->
-		<li class="media">
-                <div class="media-left bbreactions-emoji">
-                    <!-- IF last_bbreactions.EMOJI -->
-                    {last_bbreactions.EMOJI}
-                    <!-- ELSE -->
-                    <i class="fa {last_bbreactions.SYMBOL} fa-object" style="color:<!-- IF last_bbreactions.POSITIVE -->green<!-- ELSE -->red<!-- ENDIF -->;"></i>
-                    <!-- ENDIF -->
-                </div>
-                <div class="media-body">
-                    <h4 class="media-heading">{last_bbreactions.USERNAME_FULL}</h4>
-                    <span><a href="{last_bbreactions.POST_URL}">{last_bbreactions.TYPE}</a></span>
-                <small class="date"><i class="fa fa-clock-o"></i>&nbsp;{last_bbreactions.BADGE_DATE}</small>
-				</div>
+            {% for last_bbreactions in loops.last_bbreactions %}
+			<li class="sidebar-last-column">
+				<span class="sidebar-poster-thumbs bbreactions-emoji">
+					{% if last_bbreactions.EMOJI %}
+					{{ last_bbreactions.EMOJI }}
+					{% else %}
+					<i class="fa {{ last_bbreactions.SYMBOL }} fa-object" style="color:{% if last_bbreactions.POSITIVE %}green{% else %}red{% endif %};"></i>
+					{% endif %}
+				</span>
+				<span class="last-wrapper text-overflow">
+					{{ last_bbreactions.USERNAME_FULL }}
+					<br />
+					<i class="fa fa-volume-control-phone"></i>&nbsp;<a href="{{ last_bbreactions.POST_URL }}">{{ last_bbreactions.TYPE }}</a>
+				</span>
+				<span class="space5"></span>
          </li>
-		<!-- END last_bbreactions -->		
+		{% endfor %}		
 		</ul>
 	</div>
 </div>
 </div>
-</div>
-<!-- ENDIF -->
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}=window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}||"";if(window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}!=""){$(".toggle-lastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }});$("#innerlastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }})}$(".toggle-lastbbreactions{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-lastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerlastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-lastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerlastbbreactions{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.localStorage.toggle_lastbbreactions{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/likesdd.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/likesdd.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/likesdd.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/likesdd.html"
@@ -1,27 +1,33 @@
-<!-- IF .last_likes -->
+{% if loops.last_likes|length %}
 <div class="sidebar">
-<div id="lastlikes{slot.SIDEBAR_ID}" class="panel panel-warning">
+<div id="lastlikes{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
     <div class="panel-heading">
-     <h4 class="panel-title">{L_LIKEDD}</h4>
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-lastlikes{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('LIKEDD') }}</span>
     </div>
-	<div class="panel-body">
-	 <div id="innerlastlikes{slot.SIDEBAR_ID}" class="inner">
+	 <div id="innerlastlikes{{ slot.SIDEBAR_ID }}" class="panel-body inner">
 		<ul class="media-list user-list">
-            <!-- BEGIN last_likes -->
-			<li class="media">
+            {% for last_likes in loops.last_likes %}
+			<div class="media">
 				<div class="media-left">
-                     <img alt="" src="{last_likes.AVATAR}" class="media-object img-circle">
+					<img alt="" src="{{ last_likes.AVATAR }}" class="media-object img-circle">
 				</div>
 				<div class="media-body">
-					<div><i class="fa fa-thumbs-up"></i>&nbsp;{L_BY}&nbsp;{last_likes.USERNAME_FULL}</div>
-                    <a href="{last_likes.POST_URL}">{last_likes.SUBJECT}</a>
-                    <small class="date"><i class="fa fa-clock-o"></i>&nbsp;{last_likes.LIKE_DATE}</small>
+					<div class="media-heading">
+						<i class="fa fa-thumbs-up"></i>&nbsp;{{ last_likes.USERNAME_FULL }}
 					</div>
-            </li>
-			<!-- END last_likes -->
-		</ul>
+					<a href="{{ last_likes.POST_URL }}">{{ last_likes.SUBJECT }}</a>
+				</div>
+				<div class="space10"></div>
 			</div>
+			{% endfor %}
+		</ul>
 	 </div>
 </div>
 </div>
-<!-- ENDIF -->
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}=window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}||"";if(window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}!=""){$(".toggle-lastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }});$("#innerlastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }})}$(".toggle-lastlikes{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-lastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerlastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-lastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerlastlikes{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.localStorage.toggle_lastlikes{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/membership.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/membership.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/membership.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/membership.html"
@@ -1,25 +1,29 @@
-<!-- IF MEMBERSTATS -->
+{% if MEMBERSTATS %}
 <div class="sidebar">
-<div id="membership{slot.SIDEBAR_ID}" class="panel panel-inverse">
+<div id="membership{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
     <div class="panel-heading">
-     <h4 class="panel-title">{L_MEMBERSHIPS}</h4>
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-membership{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('MEMBERSHIPS') }}</span>
     </div>
-	<div class="panel-body">
-	 <div id="innermembership{slot.SIDEBAR_ID}" class="inner">
-		<a href="{U_MEMBERSHIPS}">{L_MEMBERSHIPS_CTA}</a>
+    <div id="innermembership{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+		<a href="{{ U_MEMBERSHIPS }}">{{ lang('MEMBERSHIPS_CTA') }}</a>
 		<div id="membershipchart" style="width:100%;height:150px;margin:0 auto;background-color:transparant;"></div>
 	    <script>
-			var memberstats = {MEMBERSTATS};
+			var memberstats = {{ MEMBERSTATS }};
 		</script>
 	</div>
 </div>
 </div>
-</div>
-<!-- ENDIF -->
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}!=""){$(".toggle-membership{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }});$("#innermembership{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }})}$(".toggle-membership{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-membership{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innermembership{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-membership{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innermembership{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_membership{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
 <!-- // some trickery here to eliminate the conflict with the poll type block, likeBB and BBreaction extensions top stats pages  -->
-<!-- IF not POLTITLE -->
-    <!-- INCLUDEJS @sitesplat_sidebar/js/highcharts.js -->
-<!-- ENDIF -->  
-<!-- IF MEMBERSTATS -->
-    <!-- INCLUDEJS @sitesplat_sidebar/js/membership.js -->
-<!-- ENDIF --> 
\ No newline at end of file
+{% if not POLTITLE %}
+    {% INCLUDEJS '@sitesplat_sidebar/js/highcharts.js' %}
+{% endif %}  
+{% if MEMBERSTATS %}
+    {% INCLUDEJS '@sitesplat_sidebar/js/membership.js' %}
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/newsletter.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/newsletter.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/newsletter.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/newsletter.html"
@@ -1,33 +1,34 @@
-<!-- IF NEWSLETTER and SCRIPT_NAME eq 'index' -->
+{% if NEWSLETTER and SCRIPT_NAME eq 'index' %}
 <div class="sidebar">
-<div id="newsletter{slot.SIDEBAR_ID}" class="panel panel-info">
+<div id="newsletter{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
     <div class="panel-heading">
-     <h4 class="panel-title">{L_NEWSLETTER}</h4>
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-newsletter{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('NEWSLETTER') }}</span>
     </div>
-	<div class="panel-body">
-	 <div id="innernewsletter{slot.SIDEBAR_ID}" class="inner">
+	 <div id="innernewsletter{{ slot.SIDEBAR_ID }}" class="panel-body inner">
 		<div class="subscribe-form" id="subscribe-sidebar">
-			<!-- IF not S_SUBSCRIBE_MESSAGE -->
-				<form method="post" action="{U_SUBSCRIBE_ACTION}" id="subscribe-form-sidebar">
+			{% if not S_SUBSCRIBE_MESSAGE %}
+				<form method="post" action="{{ U_SUBSCRIBE_ACTION }}" id="subscribe-form-sidebar">
 					<fieldset>
 					  <div class="form-group nomargin">
-					   <label class="sr-only" for="email">{L_SUBSCRIBE_EMAIL}{L_COLON}</label>
+					   <label class="sr-only" for="email">{{ lang('SUBSCRIBE_EMAIL') }}{{ lang('COLON') }}</label>
 						<div class="input-group">
 						  <span class="input-group-addon"><i class="icon-moon-email"></i></span>
-						  <input class="form-control" type="email" name="email" id="email" spellcheck="false" autocomplete="off" placeholder="{L_EMAIL}">
+						  <input class="form-control" type="email" name="email" id="email" spellcheck="false" autocomplete="off" placeholder="{{ lang('EMAIL') }}">
 						</div>
 					  </div>
 					<div class="form-group">
-					  <button type="submit" class="btn btn-success btn-block" name="subscribe" value="{L_SUBSCRIBE_BUTTON}">{L_SUBSCRIBE_BTN}</button>
+					  <button type="submit" class="btn btn-success btn-block" name="subscribe" value="{{ lang('SUBSCRIBE_BUTTON') }}">{{ lang('SUBSCRIBE_BTN') }}</button>
 					</div>
 					</fieldset>
 				</form>
-			<!-- ELSEIF S_SUBSCRIBE_MESSAGE -->
+			{% elseif S_SUBSCRIBE_MESSAGE %}
 				<div class="col-sm-12">
-					<p>{S_SUBSCRIBE_MESSAGE}</p>
-				</div>
-			<!-- ENDIF -->
+					<p>{{ S_SUBSCRIBE_MESSAGE }}</p>
 				</div>
+			{% endif %}
 	 </div>
 	</div>
 </div>
@@ -52,4 +53,7 @@ head.ready('jquery.min.js', function(){
 	});
 });
 </script>
-<!-- ENDIF -->
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}!=""){$(".toggle-newsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }});$("#innernewsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }})}$(".toggle-newsletter{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-newsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innernewsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-newsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innernewsletter{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_newsletter{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/newusers.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/newusers.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/newusers.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/newusers.html"
@@ -1,25 +1,29 @@
-<!-- IF .newest_users -->
+{% if loops.newest_users|length %}
 <div class="sidebar">
-<div id="users{slot.SIDEBAR_ID}" class="panel panel-info">
+<div id="users{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
     <div class="panel-heading">
-     <h4 class="panel-title">{L_NEWEST_USERS}</h4>
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-users{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('NEWEST_USERS') }}</span>
     </div>
-	<div class="panel-body">
-	 <div id="innerusers{slot.SIDEBAR_ID}" class="inner">
+	<div id="innerusers{{ slot.SIDEBAR_ID }}" class="panel-body inner">
 		<ul class="media-list user-list">
-		<!-- BEGIN newest_users -->
+		{% for newest_users in loops.newest_users %}
 		<li class="media">
 			<div class="media-left">
-				<img alt="" src="{newest_users.AVATAR}" class="media-object img-circle">
+				<img alt="" src="{{ newest_users.AVATAR }}" class="media-object img-circle">
 			</div>
             <div class="media-body">
-                <div class="media-heading">{newest_users.USERNAME_FULL}&nbsp;&#45;&nbsp;<small>{newest_users.REG_DATE}</small></div>
+                <div class="media-heading">{{ newest_users.USERNAME_FULL }}&nbsp;&#45;&nbsp;<small>{{ newest_users.REG_DATE }}</small></div>
             </div>
         </li>
-		<!-- END newest_users -->
+		{% endfor %}
 		</ul>
 	</div>
 </div>
 </div>
-</div>
-<!-- ENDIF -->
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}!=""){$(".toggle-users{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }});$("#innerusers{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }})}$(".toggle-users{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-users{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerusers{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-users{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerusers{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_users{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/poll.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/poll.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/poll.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/poll.html"
@@ -1,20 +1,24 @@
-<!-- IF POLTITLE -->
+{% if POLTITLE %}
 <div class="sidebar">
-<div id="poll{slot.SIDEBAR_ID}" class="panel panel-inverse">
+<div id="poll{{ slot.SIDEBAR_ID }}" class="panel panel-forum">
     <div class="panel-heading">
-     <h4 class="panel-title">{L_POLL}</h4>
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-poll{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('POLL') }}</span>
     </div>
-	<div class="panel-body">
-	 <div id="innerpoll{slot.SIDEBAR_ID}" class="inner">
-		<a href="{URL}">{POLTITLE}</a>
+	<div id="innerpoll{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+		<a href="{{ URL }}">{{ POLTITLE }}</a>
 		<div id="pollchart" style="width:100%;height:150px;margin:0 auto;background-color:transparent;"></div>
 	</div>
 </div>
 </div>
-</div>
 <script>
- var polstats = {POLSTATS};
+ var polstats = {{ POLSTATS }};
 </script>
-<!-- INCLUDEJS @sitesplat_sidebar/js/highcharts.js -->
-<!-- INCLUDEJS @sitesplat_sidebar/js/poll.js -->
-<!-- ENDIF -->
\ No newline at end of file
+{% INCLUDEJS '@sitesplat_sidebar/js/highcharts.js' %}
+{% INCLUDEJS '@sitesplat_sidebar/js/poll.js' %}
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}!=""){$(".toggle-poll{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }});$("#innerpoll{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }})}$(".toggle-poll{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-poll{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerpoll{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-poll{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerpoll{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_poll{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/staff.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/staff.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/staff.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/staff.html"
@@ -1,30 +1,37 @@
-<!-- IF .staff -->
+{% if loops.staff|length %}
 <div class="sidebar">
-<div id="staff{slot.SIDEBAR_ID}" class="panel panel-info">
+<div id="staff{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
     <div class="panel-heading">
-     <h4 class="panel-title">{L_STAFF}</h4>
-    </div>
-	<div class="panel-body">
-	 <div id="innerstaff{slot.SIDEBAR_ID}" class="inner">
-		 <div class="media-list user-list">
-			<!-- BEGIN staff -->
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-staff{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('STAFF') }}</span>
+    </div>
+	 <div id="innerstaff{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+		 <ul class="media-list user-list">
+			{% for staff in loops.staff %}
             <div class="media">
 				<div class="media-left">
-					<a href="#">
-					  <img alt="" src="{staff.AVATAR}" class="media-object img-circle">
-					</a>
+					<img alt="" src="{{ staff.AVATAR }}" class="media-object img-circle">
 				</div>
 				<div class="media-body">
-					<h4 class="media-heading">{staff.USERNAME_FULL}</h4>
-					<span><a href="{staff.S_SEARCH_ACTION}" title="">{staff.TIME}</a></span>
-				</div>
-			</div>
-			<!-- BEGINELSE -->
-             <div>{L_NO_MEMBERS}</div>
-			<!-- END staff -->
+					<div class="media-heading">{{ staff.USERNAME_FULL }}</div>
+					<span class="forum-time"><i class="fa fa-clock-o"></i>&nbsp;<a href="{{ staff.S_SEARCH_ACTION }}" title="">{{ staff.TIME }}</a></span>
 				</div>
+				<div class="space5"></div>
 			</div>
+			{% else %}
+			<li class="sidebar-last-column">
+				<span class="last-wrapper text-overflow">
+					{{ lang('NO_MEMBERS') }}
+				</span>
+			</li>
+			{% endfor %}
+		 </ul>	
 		</div>
 	</div>
 </div>
-<!-- ENDIF -->
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}=window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}||"";if(window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}!=""){$(".toggle-staff{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }});$("#innerstaff{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }})}$(".toggle-staff{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-staff{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerstaff{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-staff{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerstaff{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.window.localStorage.toggle_staff{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/top_posters.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/top_posters.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/top_posters.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/top_posters.html"
@@ -1,65 +1,96 @@
-<!-- IF .top_posters -->
+{% if loops.top_posters|length %}
 <div class="sidebar">
-<div id="posters{slot.SIDEBAR_ID}" class="panel panel-info">
+<div id="posters{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
     <div class="panel-heading">
-     <h4 class="panel-title">{L_TOP_POSTERS}</h4>
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-posters{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('TOP_POSTERS') }}</span>
     </div>
-	<div class="panel-body">
-	 <div id="innerposters{slot.SIDEBAR_ID}" class="inner">
-		
+	 <div id="innerposters{{ slot.SIDEBAR_ID }}" class="panel-body inner">
 		  <ul class="nav nav-pills nav-top-poster nav-justified">
-			<li class="active"><a data-toggle="pill" href="#topAll">{L_SIDEBAR_ALL_TIME}</a></li>
-			<li><a data-toggle="pill" href="#topDay">{L_SIDEBAR_DAILY}</a></li>
-			<li><a data-toggle="pill" href="#topWeek">{L_SIDEBAR_WEEKLY}</a></li>
+			<li class="active"><a data-toggle="pill" href="#topAll">{{ lang('SIDEBAR_ALL_TIME') }}</a></li>
+			<li><a data-toggle="pill" href="#topDay">{{ lang('SIDEBAR_DAILY') }}</a></li>
+			<li><a data-toggle="pill" href="#topWeek">{{ lang('SIDEBAR_WEEKLY') }}</a></li>
 		  </ul>
 
-		  <div class="tab-content media-list user-list">
+		  <div class="space10"></div>
 
+		  <div class="tab-content media-list user-list">
 			<div id="topAll" class="tab-pane fade in active">
-			<!-- BEGIN top_posters -->
+			<div class="media-list user-list">
+			{% for top_posters in loops.top_posters %}
             <div class="media">
 				<div class="media-left">
-					  <img alt="" src="{top_posters.AVATAR}" class="media-object img-circle">
+					<img alt="" src="{{ top_posters.AVATAR }}" class="media-object img-circle">
+				</div>
+				<div class="media-body">
+					<div class="media-heading">{{ top_posters.USERNAME_FULL }}</div>
+					<span>{{ lang('POSTS') }}{{ lang('COLON') }}&nbsp;<a href="{{ top_posters.S_SEARCH_ACTION }}" title="">{{ top_posters.POSTS }}</a></span>
 				</div>
+				<div class="space10"></div>
+			</div>
+			{% else %}
+			<div class="media">
 				<div class="media-body">
-					<h4 class="media-heading">{top_posters.USERNAME_FULL}</h4>
-					<span>{L_POSTS}{L_COLON}&nbsp;<a href="{top_posters.S_SEARCH_ACTION}" title="">{top_posters.POSTS}</a></span>
+					{{ lang('NO_MEMBERS') }}
+				</div>
 			</div>
+			{% endfor %}
 			</div>
-			<!-- END top_posters -->
 			</div>
 			
 			<div id="topDay" class="tab-pane fade">
-			<!-- BEGIN top_posters_day -->
+			<div class="media-list user-list">
+			{% for top_posters_day in loops.top_posters_day %}
             <div class="media">
 				<div class="media-left">
-					  <img alt="" src="{top_posters_day.AVATAR}" class="media-object img-circle">
+					<img alt="" src="{{ top_posters_day.AVATAR }}" class="media-object img-circle">
 				</div>
 				<div class="media-body">
-					<h4 class="media-heading">{top_posters_day.USERNAME_FULL}</h4>
-					<span>{L_POSTS}{L_COLON}&nbsp;<a href="{top_posters_day.S_SEARCH_ACTION}" title="">{top_posters_day.POSTS}</a></span>
+					<div class="media-heading">{{ top_posters_day.USERNAME_FULL }}</div>
+					<span>{{ lang('POSTS') }}{{ lang('COLON') }}&nbsp;<a href="{{ top_posters_day.S_SEARCH_ACTION }}" title="">{{ top_posters_day.POSTS }}</a></span>
 				</div>
+				<div class="space10"></div>
+			</div>
+			{% else %}
+			<div class="media">
+				<div class="media-body">
+					{{ lang('NO_MEMBERS') }}
+				</div>
+			</div>
+			{% endfor %}
 			</div>
-			<!-- END top_posters_day -->
 			</div>
 			
 			<div id="topWeek" class="tab-pane fade">
-			<!-- BEGIN top_posters_week -->
+			<div class="media-list user-list">
+			{% for top_posters_week in loops.top_posters_week %}
             <div class="media">
 				<div class="media-left">
-					  <img alt="" src="{top_posters_week.AVATAR}" class="media-object img-circle">
+					<img alt="" src="{{ top_posters_week.AVATAR }}" class="media-object img-circle">
 				</div>
 				<div class="media-body">
-					<h4 class="media-heading">{top_posters_week.USERNAME_FULL}</h4>
-					<span>{L_POSTS}{L_COLON}&nbsp;<a href="{top_posters_week.S_SEARCH_ACTION}" title="">{top_posters_week.POSTS}</a></span>
+					<div class="media-heading">{{ top_posters_week.USERNAME_FULL }}</div>
+					<span>{{ lang('POSTS') }}{{ lang('COLON') }}&nbsp;<a href="{{ top_posters_week.S_SEARCH_ACTION }}" title="">{{ top_posters_week.POSTS }}</a></span>
 				</div>
+				<div class="space10"></div>
 			</div>
-			<!-- END top_posters_week -->
+			{% else %}
+			<div class="media">
+				<div class="media-body">
+					{{ lang('NO_MEMBERS') }}
 				</div>
-			
 			</div>
+			{% endfor %}
+			</div>
+			</div>
+			
 		  </div>
 		</div>
 	</div>
 </div>
-<!-- ENDIF -->
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}=window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}||"";if(window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}!=""){$(".toggle-posters{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }});$("#innerposters{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }})}$(".toggle-posters{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-posters{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innerposters{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-posters{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innerposters{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.localStorage.toggle_posters{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/top_topics.html" "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/top_topics.html"
--- "[ORIGINAL]/sitesplat\\sidebar/styles/FLATBOOTS/template/top_topics.html"
+++ "[FORUM_EXT]/sitesplat\\sidebar/styles/FLATBOOTS/template/top_topics.html"
@@ -1,27 +1,40 @@
-<!-- IF .top_topics -->
+{% if loops.top_topics|length %}
 <div class="sidebar">
-<div id="topics{slot.SIDEBAR_ID}" class="panel panel-primary list-announcement">
+<div id="topics{{ slot.SIDEBAR_ID }}" class="panel panel-forum list-announcement">
     <div class="panel-heading">
-        <h4 class="panel-title">{L_NEWEST_TOPICS}</h4>
+		{% if PHPBB_COLLAPSIBLE_ENABLED %}
+		<a class="toggle-topics{{ slot.SIDEBAR_ID }}" href="javascript:void(0)"></a>
+		{% endif %}
+		<span>{{ lang('NEWEST_TOPICS') }}</span>
     </div>
-    <div id="innertopics{slot.SIDEBAR_ID}" class="panel-body inner">
-        <ul class="list-unstyled mb20">
-		<!-- BEGIN top_topics -->
-		<!-- IF top_topics.NO_TOPIC_TITLE-->
-				<li>   
-				   {top_topics.NO_TOPIC_TITLE}
+    <div id="innertopics{{ slot.SIDEBAR_ID }}" class="panel-body inner">
+        <ul class="media-list user-list">
+		{% for top_topics in loops.top_topics %}
+		{% if top_topics.NO_TOPIC_TITLE%}
+				<li class="media">   
+				   {{ top_topics.NO_TOPIC_TITLE }}
 				</li>
-		<!-- ELSE -->
-            <li>
-               <!-- IF top_topics.S_UNREAD --><span class="label label-warning">{L_UNREAD}</span>&nbsp;<!-- ENDIF --><a class="title-head" href="{top_topics.U_TOPIC}" title="{{ top_topics.TOPIC_TITLE|striptags }}">{top_topics.TOPIC_TITLE}</a>
-               <div>{top_topics.USERNAME_FULL}</div>
-			   <div>{L_IN}{L_COLON}&nbsp;<a href="{top_topics.U_FORUM}" title="{top_topics.FORUM_NAME}">{top_topics.FORUM_NAME}</a></div>
-			   <small class="date"><i class="fa fa-clock-o"></i>&nbsp;{top_topics.LAST_TOPIC_TIME}</small>
+		{% else %}
+            <li class="media">
+				<span class="media-left">
+					<img alt="" src="{{ top_topics.AVATAR }}" class="media-object img-circle">
+					{% if top_topics.S_UNREAD %}<span class="label label-warning">{{ lang('UNREAD') }}</span>&nbsp;{% endif %}
+				</span>
+				<span class="media-body">
+					<a class="title-head" href="{{ top_topics.U_TOPIC }}">{{ top_topics.TOPIC_TITLE }}</a>
+					<br />
+					{{ top_topics.USERNAME_FULL }}<br />
+					<span class="forum-time"><i class="fa fa-clock-o"></i>&nbsp;{{ top_topics.LAST_TOPIC_TIME }}</span>
+				</span>
+				<!-- <span>{{ lang('IN') }}{{ lang('COLON') }}&nbsp;<a href="{{ top_topics.U_FORUM }}" title="{{ top_topics.FORUM_NAME }}">{{ top_topics.FORUM_NAME }}</a></span><br /> -->
 			</li>
-		<!-- ENDIF -->	
-		<!-- END top_topics -->
+		{% endif %}	
+		{% endfor %}
         </ul>
     </div>
 </div>
 </div>
-<!-- ENDIF -->
\ No newline at end of file
+{% if PHPBB_COLLAPSIBLE_ENABLED %}
+<script>head.ready(function(){(function(){window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}=window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}||"";if(window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}!=""){$(".toggle-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed"+window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }});$("#innertopics{{ slot.SIDEBAR_ID }}").toggleClass("collapse"+window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }})}$(".toggle-topics{{ slot.SIDEBAR_ID }}").on("click",function(){if(window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}!=" toggle"){$(".toggle-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",true);$("#innertopics{{ slot.SIDEBAR_ID }}").toggleClass("collapse",true);window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}=" toggle"}else{$(".toggle-topics{{ slot.SIDEBAR_ID }}").toggleClass("collapsed",false);$("#innertopics{{ slot.SIDEBAR_ID }}").toggleClass("collapse",false);window.localStorage.toggle_topics{{ slot.SIDEBAR_ID }}=""}})})()});</script>
+{% endif %}
+{% endif %}
diff --git "[ORIGINAL]/sitesplat\\sidebar/types/type/base.php" "[FORUM_EXT]/sitesplat\\sidebar/types/type/base.php"
--- "[ORIGINAL]/sitesplat\\sidebar/types/type/base.php"
+++ "[FORUM_EXT]/sitesplat\\sidebar/types/type/base.php"
@@ -53,36 +53,39 @@ abstract class base implements type_interface
  	/** 
  	* {@inheritdoc} 
  	*/ 
-	protected function ignore_users()
+	protected function ignore_users($post_users_argument = '')
 	{
-		// an array of user types we dont' bother with
+		// an array of user types we don't bother with
 		$ignore_users = $ignore_founders = array();
 		
 		$sql = 'SELECT group_id FROM ' . GROUPS_TABLE . ' WHERE group_name = "BOTS" AND group_type = ' . GROUP_SPECIAL;
 		$result = $this->db->sql_query($sql, 3600);
 		$bot_group = $this->db->sql_fetchfield('group_id');
 
-		if (!$this->sidebar_settings['ignore_inactive_users'])
-		{
+		if (!$this->sidebar_settings['ignore_inactive_users']) {
 			$ignore_users = array(USER_IGNORE, USER_INACTIVE);
 		}
 
-		if (!$this->sidebar_settings['ignore_founder'])
-		{
+		if (!$this->sidebar_settings['ignore_founder']) {
 			$ignore_founders = array(USER_FOUNDER);
 		}
 
 		$ignore_users = array_merge($ignore_users, $ignore_founders);
 
 		// Do we have anyone we want to ignore
-		$sql_where = 'WHERE group_id <> ' . $bot_group . ' AND user_id <> ' . ANONYMOUS;
-		if (sizeof($ignore_users))
-		{
+		$sql_where = 'WHERE ';
+		
+		if ($post_users_argument !== '') {
+			$sql_where .= $post_users_argument . ' AND ';
+		}
+		
+		$sql_where .= 'group_id <> ' . $bot_group . ' AND user_id <> ' . ANONYMOUS;
+
+		if (sizeof($ignore_users)) {
 			$sql_where .= ' AND ' . $this->db->sql_in_set('user_type', $ignore_users, true);
 		}
 		
-		if (!$this->sidebar_settings['ignore_admins_mods'])
-		{
+		if (!$this->sidebar_settings['ignore_admins_mods']) {
 			// grab all admins
 			$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
 			$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : array();
@@ -92,8 +95,7 @@ abstract class base implements type_interface
 			$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : array();
 			$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
 
-			if (sizeof($admin_mod_array))
-			{
+			if (sizeof($admin_mod_array)) {
 				$sql_where .= empty($sql_where) ? ' WHERE' : ' AND';
 				$sql_where .= ' ' . $this->db->sql_in_set('user_id', $admin_mod_array, true);
 			}
diff --git "[ORIGINAL]/sitesplat\\sidebar/types/type/bbpoints.php" "[FORUM_EXT]/sitesplat\\sidebar/types/type/bbpoints.php"
--- "[ORIGINAL]/sitesplat\\sidebar/types/type/bbpoints.php"
+++ "[FORUM_EXT]/sitesplat\\sidebar/types/type/bbpoints.php"
@@ -74,11 +74,11 @@ class bbpoints extends \sitesplat\sidebar\types\type\base
 			// grab users
 			$sql = 'SELECT t1.user_id, SUM(points) as total, u.username, u.user_colour FROM ( 
 					SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $bbpoints_table . ' GROUP BY to_id
-					UNION
+					UNION ALL
 					SELECT from_id AS user_id, SUM(-bbpoints) AS points FROM ' . $bbpoints_table . ' GROUP BY from_id
-					UNION
+					UNION ALL
 					SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' GROUP BY topic_poster
-					UNION 
+					UNION ALL
 					SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 GROUP BY poster_id) t1 
 					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = t1.user_id
 					' . $sql_where . '
diff --git "[ORIGINAL]/sitesplat\\sidebar/types/type/donations.php" "[FORUM_EXT]/sitesplat\\sidebar/types/type/donations.php"
--- "[ORIGINAL]/sitesplat\\sidebar/types/type/donations.php"
+++ "[FORUM_EXT]/sitesplat\\sidebar/types/type/donations.php"
@@ -103,6 +103,7 @@ class donations extends \sitesplat\sidebar\types\type\base
 				FROM ' . $donations_table . ' d
 				LEFT JOIN ' . USERS_TABLE . " u ON u.user_id = d.user_id $sql_where $sql_and
 				AND d.payment_status = 'Completed'
+				AND d.payment_date >= UNIX_TIMESTAMP(DATE_SUB( CURDATE(), INTERVAL 1 MONTH)) 
 				ORDER BY d.payment_date DESC";
 			$result = $this->db->sql_query_limit($sql, $howmany);
 			while ($row = $this->db->sql_fetchrow($result))
diff --git "[ORIGINAL]/sitesplat\\sidebar/types/type/hot_topics.php" "[FORUM_EXT]/sitesplat\\sidebar/types/type/hot_topics.php"
--- "[ORIGINAL]/sitesplat\\sidebar/types/type/hot_topics.php"
+++ "[FORUM_EXT]/sitesplat\\sidebar/types/type/hot_topics.php"
@@ -84,6 +84,7 @@ class hot_topics extends \sitesplat\sidebar\types\type\base
 				ORDER BY topic_last_post_time DESC';
 
 			$result = $this->db->sql_query_limit($sql, $howmany);
+
 			$forums = $ga_topic_ids = $topic_ids = array();
 			while ($row = $this->db->sql_fetchrow($result))
 			{
@@ -109,7 +110,7 @@ class hot_topics extends \sitesplat\sidebar\types\type\base
 			{
 				// grab all posts that meet criteria and auths
 				$sql_array = array(
-					'SELECT'	=> 'u.user_id, u.username, u.user_colour, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id,
+					'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id,
 									t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
 					'FROM'		=> array(TOPICS_TABLE => 't'),
 					'LEFT_JOIN'	=> array(
@@ -140,19 +141,61 @@ class hot_topics extends \sitesplat\sidebar\types\type\base
 										$row['topic_last_post_id']);
 					$forum_name_url = append_sid("{$this->root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
 					$topic_title = censor_text($row['topic_title']);
-					if (utf8_strlen($topic_title) >= 60)
-					{
-						$topic_title = (utf8_strlen($topic_title) > 60 + 3) ? utf8_substr($topic_title, 0, 60) . '...' : $topic_title;
-					}
+					// can't truncate with bbemoji
+					// if (utf8_strlen($topic_title) >= 60)
+					// {
+						// $topic_title = (utf8_strlen($topic_title) > 60 + 3) ? utf8_substr($topic_title, 0, 60) . '...' : $topic_title;
+					// }
 					$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
 
+					/**
+					* Event to modify topic data before they are assigned
+					*
+					* @event sitesplat.bbsidebar.type.hot_topics_tpl_before
+					* @var	string	topic_id		Topic ID
+					* @var	string	forum_id		Forum ID
+					* @var	string	forum_name		Forum name
+					* @var	boolean	post_unread		Are there any posts unread?
+					* @var	string	view_topic_url	Topic URL
+					* @var	string	forum_name_url	Forum URL
+					* @var	string	topic_title		Topic title
+					* @var	boolean	is_guest		Is post author anonymous?
+					* @since 1.5.0
+					*/
+					$vars = array(
+						'topic_id',
+						'forum_id',
+						'forum_name',
+						'post_unread',
+						'view_topic_url',
+						'forum_name_url',
+						'topic_title',
+						'is_guest',
+					);
+					extract($phpbb_dispatcher->trigger_event('sitesplat.bbsidebar.type.hot_topics_tpl_before', compact($vars)));
+					
+					$board_url = generate_board_url() . '/';
+					$match = array();
+					$avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@',
+							  phpbb_get_user_avatar(
+								  array('avatar'			=> $row['user_avatar'], 
+								        'user_id'			=> $row['user_id'],
+										'avatar_type'		=> $row['user_avatar_type'], 
+										'avatar_width'		=> $row['user_avatar_width'], 
+										'avatar_height'		=> $row['user_avatar_height'])), $match) :
+										generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');
+
+					$username_string = ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . 
+												get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : 
+												$this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
+
 					$tpl_ary = array(
 						'U_TOPIC'			=> $view_topic_url,
 						'U_FORUM'			=> $forum_name_url,
 						'S_UNREAD'			=> ($post_unread) ? true : false,
-						'USERNAME_FULL'		=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . 
-												get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : 
-												$this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
+						//'AVATAR'			=> ((sizeof($match) > 1) ? str_replace('./../../', './', array_pop($match)) : $avatar),
+						'AVATAR'			=> ((sizeof($match) > 1) ? strtr(array_pop($match), [ 'gallery/../random' => 'random', './../../' => $board_url,  './../' => $board_url, './' => $board_url ]) : $avatar),
+						'USERNAME_FULL'		=> $username_string,
 						'LAST_TOPIC_TIME'	=> $this->user->format_date($row['topic_last_post_time']),
 						'TOPIC_TITLE' 		=> $topic_title,
 						'TOPIC_TITLE_NO_HTML'	=> $topic_title,
diff --git "[ORIGINAL]/sitesplat\\sidebar/types/type/last_badges.php" "[FORUM_EXT]/sitesplat\\sidebar/types/type/last_badges.php"
--- "[ORIGINAL]/sitesplat\\sidebar/types/type/last_badges.php"
+++ "[FORUM_EXT]/sitesplat\\sidebar/types/type/last_badges.php"
@@ -64,7 +64,7 @@ class last_badges extends \sitesplat\sidebar\types\type\base
 		$howmany = $this->howmany();
 		$sql_where = str_replace('user_id', 'b.user_id', $this->ignore_users());
 
-		$sql_and = !empty($sql_where) ? ' AND user_inactive_reason = 0' : ' WHERE user_inactive_reason = 0';
+		$sql_and = !empty($sql_where) ? ' AND user_posts > 1 AND user_inactive_reason = 0' : ' WHERE user_posts > 1 AND user_inactive_reason = 0';
 		// latest users
 		if (($newest_users = $this->cache->get('_sidebar_last_badges')) === false)
 		{
@@ -77,8 +77,8 @@ class last_badges extends \sitesplat\sidebar\types\type\base
 			$sql = 'SELECT b.user_id, r.rule_name, u.username, u.user_colour, b.date, ba.badge 
 				FROM ' . $badge_event_table . ' b
 				LEFT JOIN ' . $badge_rules_table . ' r ON r.rule_id = b.rule_id
-				LEFT JOIN ' . $badge_badges_table . ' ba ON ba.badge_id = r.badge_id 
-				LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = b.user_id
+				INNER JOIN ' . $badge_badges_table . ' ba ON ba.badge_id = r.badge_id 
+				INNER JOIN ' . USERS_TABLE . ' u ON u.user_id = b.user_id
 				' . $sql_where . '
 				' . $sql_and . '
 				ORDER BY b.date DESC';
@@ -97,8 +97,8 @@ class last_badges extends \sitesplat\sidebar\types\type\base
 			}
 			$this->db->sql_freeresult($result);
 
-			// cache this data for 5 minutes, this improves performance
-			$this->cache->put('_sidebar_last_badges', $newest_users, 300);
+			// cache this data for 30 minutes, this improves performance
+			$this->cache->put('_sidebar_last_badges', $newest_users, 1800);
 		}
 
 		foreach ($newest_users as $row)
diff --git "[ORIGINAL]/sitesplat\\sidebar/types/type/staff.php" "[FORUM_EXT]/sitesplat\\sidebar/types/type/staff.php"
--- "[ORIGINAL]/sitesplat\\sidebar/types/type/staff.php"
+++ "[FORUM_EXT]/sitesplat\\sidebar/types/type/staff.php"
@@ -72,7 +72,8 @@ class staff extends \sitesplat\sidebar\types\type\base
 			$staff_ids = $staff_online = [];
 			$sql = 'SELECT u.user_id
 					FROM ' . GROUPS_TABLE . ' g, ' . USER_GROUP_TABLE . " u
-					WHERE LOWER(g.group_name) LIKE '%staff%' AND u.group_id = g.group_id";
+					WHERE u.group_id = g.group_id AND u.group_id = 15";
+					// WHERE LOWER(g.group_name) LIKE '%staff%' AND u.group_id = g.group_id";
 			$result = $this->db->sql_query($sql);
 			while ($row = $this->db->sql_fetchrow($result))
 			{
@@ -159,12 +160,14 @@ class staff extends \sitesplat\sidebar\types\type\base
 		{
 			foreach ($staff_online as $row)
 			{
+				$last_visit = $this->user->format_date($row['last_visit'], '|d M Y|, H:i');
+				$last_active = (!empty($row['last_active'])) ? $this->user->format_date($row['last_active'], '|d M Y|, H:i') : $this->user->lang['STAFF_UNKNOWN'];
 				$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) :
 									get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
 
 				$this->template->assign_block_vars('staff',array(
 					'S_SEARCH_ACTION'	=> append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
-					'TIME'	 			=> ($row['last_visit']) ? $this->user->format_date($row['last_visit'], '|d M Y|, H:i') : $this->user->lang['STAFF_UNKNOWN'],
+					'TIME'	 			=> (!empty($row['last_visit'])) ? $last_visit : $last_active,
 					'USERNAME_FULL'		=> $username_string,
 					'AVATAR'			=> $row['avatar']
 				));
diff --git "[ORIGINAL]/sitesplat\\sidebar/types/type/top_posters.php" "[FORUM_EXT]/sitesplat\\sidebar/types/type/top_posters.php"
--- "[ORIGINAL]/sitesplat\\sidebar/types/type/top_posters.php"
+++ "[FORUM_EXT]/sitesplat\\sidebar/types/type/top_posters.php"
@@ -61,10 +61,11 @@ class top_posters extends \sitesplat\sidebar\types\type\base
 	public function outputblock()
 	{
 		$howmany = $this->howmany();
-		$sql_where = $this->ignore_users();
+		$sql_where = $this->ignore_users('user_posts > 1');
+		$sql_where_improve = $this->ignore_users('post_counts.user_posts > 1');
 
 		//set two variables for the sql
-		$sql_and = $sql_other = '';
+		$sql_and = $sql_other = $sql_other_improve = '';
 
 		if (($user_posts = $this->cache->get('_sidebar_posters')) === false)
 		{
@@ -89,7 +90,9 @@ class top_posters extends \sitesplat\sidebar\types\type\base
 				}
 			}
 			$sql_other = (empty($sql_and) && empty($sql_where)) ? ' WHERE' : ' AND';
-			$sql_other .=  ' user_posts <> 0';
+			$sql_other .= empty($sql_where) ? ' user_posts <> 0' : ' 1=1';
+			$sql_other_improve = (empty($sql_and) && empty($sql_where)) ? ' WHERE' : ' AND';
+			$sql_other_improve .= empty($sql_where_improve) ? ' post_counts.user_posts <> 0' : ' 1=1';
 			$user_posts[0] = $user_posts[1] = $user_posts[2] = array();
 
 		//  damn phpbb url rewrite and broken driver
@@ -137,14 +140,24 @@ class top_posters extends \sitesplat\sidebar\types\type\base
 
 
 			// do the main sql query
-			$sql = 'SELECT user_id, username, user_colour, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height, COUNT(p.post_id) AS user_posts
-					FROM ' . POSTS_TABLE . ' p
-					LEFT JOIN ' . USERS_TABLE . ' ON user_id = p.poster_id
-					' . $sql_where . ' ' . $sql_and . '
-					' . $sql_other . '
-					AND p.post_time > ' . (time() - 86400 ) . '
-					GROUP BY p.poster_id
-					ORDER BY user_posts DESC';
+			$timestamp = time() - 86400;
+			$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, post_counts.user_posts
+					FROM ' . USERS_TABLE . ' u
+					LEFT JOIN (
+						SELECT
+							poster_id,
+							COUNT(post_id) AS user_posts
+						FROM
+							' . POSTS_TABLE . '
+						WHERE
+							post_time > ' . $timestamp . '
+						GROUP BY
+							poster_id
+					) AS post_counts ON u.user_id = post_counts.poster_id 
+					' . $sql_where_improve . ' ' . $sql_and . '
+					' . $sql_other_improve . '
+					AND post_counts.user_posts IS NOT NULL
+					ORDER BY post_counts.user_posts DESC';
 			$result = $this->db->sql_query_limit($sql, $howmany);
 			while ($row = $this->db->sql_fetchrow($result))
 			{
@@ -170,14 +183,24 @@ class top_posters extends \sitesplat\sidebar\types\type\base
 
 
 			// do the main sql query
-			$sql = 'SELECT user_id, username, user_colour, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height, COUNT(p.post_id) AS user_posts
-					FROM ' . POSTS_TABLE . ' p
-					LEFT JOIN ' . USERS_TABLE . ' ON user_id = p.poster_id
-					' . $sql_where . ' ' . $sql_and . '
-					' . $sql_other . '
-					AND p.post_time > ' . (time() - (86400 * 7)) . '
-					GROUP BY p.poster_id
-					ORDER BY user_posts DESC';
+			$timestamp = time() - (86400 * 7);
+			$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, post_counts.user_posts
+					FROM ' . USERS_TABLE . ' u
+					LEFT JOIN (
+						SELECT
+							poster_id,
+							COUNT(post_id) AS user_posts
+						FROM
+							' . POSTS_TABLE . '
+						WHERE
+							post_time > ' . $timestamp . '
+						GROUP BY
+							poster_id
+					) AS post_counts ON u.user_id = post_counts.poster_id
+					' . $sql_where_improve . ' ' . $sql_and . '
+					' . $sql_other_improve . '
+					AND IFNULL(post_counts.user_posts, 0) <> 0
+					ORDER BY post_counts.user_posts DESC';
 			$result = $this->db->sql_query_limit($sql, $howmany);
 			while ($row = $this->db->sql_fetchrow($result))
 			{
@@ -195,14 +218,15 @@ class top_posters extends \sitesplat\sidebar\types\type\base
 					'user_id'      => $row['user_id'],
 					'username'      => $row['username'],
 					'user_colour'   => $row['user_colour'],
-					'avatar'		=> (sizeof($match) > 1) ? array_pop($match) : $avatar,
+					//'avatar'		=> (sizeof($match) > 1) ? array_pop($match) : $avatar,
+					'avatar'		=> ((sizeof($match) > 1) ? strtr(array_pop($match), [ 'gallery/../random' => 'random', './../../' => $board_url,  './../' => $board_url, './' => $board_url ]) : $avatar),
 					'user_posts'    => $row['user_posts'],
 				);
 			}
 			$this->db->sql_freeresult($result);
 
-			// cache this data for 5 minutes, this improves performance
-			$this->cache->put('_sidebar_posters', $user_posts, 300);
+			// cache this data for 30 minutes, this improves performance
+			$this->cache->put('_sidebar_posters', $user_posts, 1800);
 		}
 
 		foreach ($user_posts[0] as $row)
```
