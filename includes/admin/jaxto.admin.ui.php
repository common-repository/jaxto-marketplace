<?php
/*!
* WordPress JAXTO
*/

/**
* The LOC in charge of displaying JAXTO Admin GUInterfaces
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// --------------------------------------------------------------------

/**
* Generate jaxto admin pages
*
* wp-admin/admin.php?page=wordpress-jaxto-store&..
*/
function jaxto_admin_main()
{
	// HOOKABLE:
	do_action( "jaxto_admin_main_start" );

	if ( ! current_user_can('manage_options') )
	{
		wp_die( 'You do not have sufficient permissions to access this page.' );
	}

	if( ! jaxto_check_requirements() )
	{
		jaxto_admin_ui_fail();

		exit;
	}

	GLOBAL $JAXTO_ADMIN_TABS;
	GLOBAL $JAXTO_COMPONENTS;
	GLOBAL $JAXTO_PROVIDERS_CONFIG;
	GLOBAL $JAXTO_VERSION;

	if( isset( $_REQUEST["enable"] ) && isset( $JAXTO_COMPONENTS[ $_REQUEST["enable"] ] ) )
	{
		$component = $_REQUEST["enable"];

		$JAXTO_COMPONENTS[ $component ][ "enabled" ] = true;

		update_option( "jaxto_components_" . $component . "_enabled", 1 );

		jaxto_register_components();
	}

	if( isset( $_REQUEST["disable"] ) && isset( $JAXTO_COMPONENTS[ $_REQUEST["disable"] ] ) )
	{
		$component = $_REQUEST["disable"];

		$JAXTO_COMPONENTS[ $component ][ "enabled" ] = false;

		update_option( "jaxto_components_" . $component . "_enabled", 2 );

		jaxto_register_components();
	}

	$jaxtop            = "jaxto-plugin-settings";
	$jaxtodwp          = 0;
	$assets_base_url = JAXTO_PLUGIN_URL . 'assets/img/16x16/';

	if( isset( $_REQUEST["jaxtop"] ) )
	{
		$jaxtop = trim( strtolower( strip_tags( $_REQUEST["jaxtop"] ) ) );
	}

	jaxto_admin_ui_header( $jaxtop );

	if( isset( $JAXTO_ADMIN_TABS[$jaxtop] ) && $JAXTO_ADMIN_TABS[$jaxtop]["enabled"] )
	{
		if( isset( $JAXTO_ADMIN_TABS[$jaxtop]["action"] ) && $JAXTO_ADMIN_TABS[$jaxtop]["action"] )
		{
			do_action( $JAXTO_ADMIN_TABS[$jaxtop]["action"] );
		}
		else
		{
			include "components/$jaxtop/index.php";
		}
	}
	else
	{
		jaxto_admin_ui_error();
	}

	jaxto_admin_ui_footer();

	// HOOKABLE:
	do_action( "jaxto_admin_main_end" );
}

function jaxto_plugin_supported()
{
	// HOOKABLE:
	do_action( "jaxto_admin_main_start" );

	if ( ! current_user_can('manage_options') )
	{
		wp_die( 'You do not have sufficient permissions to access this page.' );
	}

	if( ! jaxto_check_requirements() )
	{
		jaxto_admin_ui_fail();

		exit;
	}

	GLOBAL $JAXTO_ADMIN_TABS;
	GLOBAL $JAXTO_COMPONENTS;
	GLOBAL $JAXTO_PROVIDERS_CONFIG;
	GLOBAL $JAXTO_VERSION;

	if( isset( $_REQUEST["enable"] ) && isset( $JAXTO_COMPONENTS[ $_REQUEST["enable"] ] ) )
	{
		$component = $_REQUEST["enable"];

		$JAXTO_COMPONENTS[ $component ][ "enabled" ] = true;

		update_option( "jaxto_components_" . $component . "_enabled", 1 );

		jaxto_register_components();
	}

	if( isset( $_REQUEST["disable"] ) && isset( $JAXTO_COMPONENTS[ $_REQUEST["disable"] ] ) )
	{
		$component = $_REQUEST["disable"];

		$JAXTO_COMPONENTS[ $component ][ "enabled" ] = false;

		update_option( "jaxto_components_" . $component . "_enabled", 2 );

		jaxto_register_components();
	}

	$jaxtop            = "jaxto-plugin-settings";
	$jaxtodwp          = 0;
	$assets_base_url = JAXTO_PLUGIN_URL . 'assets/img/16x16/';

	if( isset( $_REQUEST["jaxtop"] ) )
	{
		$jaxtop = trim( strtolower( strip_tags( $_REQUEST["jaxtop"] ) ) );
	}

	jaxto_admin_ui_header( $jaxtop );

	if( isset( $JAXTO_ADMIN_TABS[$jaxtop] ) && $JAXTO_ADMIN_TABS[$jaxtop]["enabled"] )
	{
		if( isset( $JAXTO_ADMIN_TABS[$jaxtop]["action"] ) && $JAXTO_ADMIN_TABS[$jaxtop]["action"] )
		{
			do_action( $JAXTO_ADMIN_TABS[$jaxtop]["action"] );
		}
		else
		{
			include "components/$jaxtop/plugin-supported.php";
		}
	}
	else
	{
		jaxto_admin_ui_error();
	}

	jaxto_admin_ui_footer();

	// HOOKABLE:
	do_action( "jaxto_admin_main_end" );
}

function jaxto_app_link()
{
	// HOOKABLE:
	do_action( "jaxto_admin_main_start" );

	if ( ! current_user_can('manage_options') )
	{
		wp_die( 'You do not have sufficient permissions to access this page.' );
	}

	if( ! jaxto_check_requirements() )
	{
		jaxto_admin_ui_fail();

		exit;
	}

	GLOBAL $JAXTO_ADMIN_TABS;
	GLOBAL $JAXTO_COMPONENTS;
	GLOBAL $JAXTO_PROVIDERS_CONFIG;
	GLOBAL $JAXTO_VERSION;

	if( isset( $_REQUEST["enable"] ) && isset( $JAXTO_COMPONENTS[ $_REQUEST["enable"] ] ) )
	{
		$component = $_REQUEST["enable"];

		$JAXTO_COMPONENTS[ $component ][ "enabled" ] = true;

		update_option( "jaxto_components_" . $component . "_enabled", 1 );

		jaxto_register_components();
	}

	if( isset( $_REQUEST["disable"] ) && isset( $JAXTO_COMPONENTS[ $_REQUEST["disable"] ] ) )
	{
		$component = $_REQUEST["disable"];

		$JAXTO_COMPONENTS[ $component ][ "enabled" ] = false;

		update_option( "jaxto_components_" . $component . "_enabled", 2 );

		jaxto_register_components();
	}

	$jaxtop            = "jaxto-plugin-settings";
	$jaxtodwp          = 0;
	$assets_base_url = JAXTO_PLUGIN_URL . 'assets/img/16x16/';

	if( isset( $_REQUEST["jaxtop"] ) )
	{
		$jaxtop = trim( strtolower( strip_tags( $_REQUEST["jaxtop"] ) ) );
	}

	jaxto_admin_ui_header( $jaxtop );

	if( isset( $JAXTO_ADMIN_TABS[$jaxtop] ) && $JAXTO_ADMIN_TABS[$jaxtop]["enabled"] )
	{
		if( isset( $JAXTO_ADMIN_TABS[$jaxtop]["action"] ) && $JAXTO_ADMIN_TABS[$jaxtop]["action"] )
		{
			do_action( $JAXTO_ADMIN_TABS[$jaxtop]["action"] );
		}
		else
		{
			include "components/$jaxtop/app-link.php";
		}
	}
	else
	{
		jaxto_admin_ui_error();
	}

	jaxto_admin_ui_footer();

	// HOOKABLE:
	do_action( "jaxto_admin_main_end" );
}

function jaxto_admin_main_about()
{
	// HOOKABLE:
	do_action( "jaxto_admin_main_start" );

	if ( ! current_user_can('manage_options') )
	{
		wp_die( 'You do not have sufficient permissions to access this page.' );
	}

	if( ! jaxto_check_requirements() )
	{
		jaxto_admin_ui_fail();

		exit;
	}

	GLOBAL $JAXTO_ADMIN_TABS;
	GLOBAL $JAXTO_COMPONENTS;
	GLOBAL $JAXTO_PROVIDERS_CONFIG;
	GLOBAL $JAXTO_VERSION;

	if( isset( $_REQUEST["enable"] ) && isset( $JAXTO_COMPONENTS[ $_REQUEST["enable"] ] ) )
	{
		$component = $_REQUEST["enable"];

		$JAXTO_COMPONENTS[ $component ][ "enabled" ] = true;

		update_option( "jaxto_components_" . $component . "_enabled", 1 );

		jaxto_register_components();
	}

	if( isset( $_REQUEST["disable"] ) && isset( $JAXTO_COMPONENTS[ $_REQUEST["disable"] ] ) )
	{
		$component = $_REQUEST["disable"];

		$JAXTO_COMPONENTS[ $component ][ "enabled" ] = false;

		update_option( "jaxto_components_" . $component . "_enabled", 2 );

		jaxto_register_components();
	}

	$jaxtop            = "jaxto-plugin-settings";
	$jaxtodwp          = 0;
	$assets_base_url = JAXTO_PLUGIN_URL . 'assets/img/16x16/';

	if( isset( $_REQUEST["jaxtop"] ) )
	{
		$jaxtop = trim( strtolower( strip_tags( $_REQUEST["jaxtop"] ) ) );
	}

	jaxto_admin_ui_header( $jaxtop );

	if( isset( $JAXTO_ADMIN_TABS[$jaxtop] ) && $JAXTO_ADMIN_TABS[$jaxtop]["enabled"] )
	{
		if( isset( $JAXTO_ADMIN_TABS[$jaxtop]["action"] ) && $JAXTO_ADMIN_TABS[$jaxtop]["action"] )
		{
			do_action( $JAXTO_ADMIN_TABS[$jaxtop]["action"] );
		}
		else
		{
			include "components/$jaxtop/about.php";
		}
	}
	else
	{
		jaxto_admin_ui_error();
	}

	jaxto_admin_ui_footer();

	// HOOKABLE:
	do_action( "jaxto_admin_main_end" );
}

function jaxto_api_id()
{
	// HOOKABLE:
	do_action( "jaxto_admin_main_start" );

	if ( ! current_user_can('manage_options') )
	{
		wp_die( 'You do not have sufficient permissions to access this page.' );
	}

	if( ! jaxto_check_requirements() )
	{
		jaxto_admin_ui_fail();

		exit;
	}

	GLOBAL $JAXTO_ADMIN_TABS;
	GLOBAL $JAXTO_COMPONENTS;
	GLOBAL $JAXTO_PROVIDERS_CONFIG;
	GLOBAL $JAXTO_VERSION;

	if( isset( $_REQUEST["enable"] ) && isset( $JAXTO_COMPONENTS[ $_REQUEST["enable"] ] ) )
	{
		$component = $_REQUEST["enable"];

		$JAXTO_COMPONENTS[ $component ][ "enabled" ] = true;

		update_option( "jaxto_components_" . $component . "_enabled", 1 );

		jaxto_register_components();
	}

	if( isset( $_REQUEST["disable"] ) && isset( $JAXTO_COMPONENTS[ $_REQUEST["disable"] ] ) )
	{
		$component = $_REQUEST["disable"];

		$JAXTO_COMPONENTS[ $component ][ "enabled" ] = false;

		update_option( "jaxto_components_" . $component . "_enabled", 2 );

		jaxto_register_components();
	}

	$jaxtop            = "jaxto-plugin-settings";
	$jaxtodwp          = 0;
	$assets_base_url = JAXTO_PLUGIN_URL . 'assets/img/16x16/';

	if( isset( $_REQUEST["jaxtop"] ) )
	{
		$jaxtop = trim( strtolower( strip_tags( $_REQUEST["jaxtop"] ) ) );
	}

	jaxto_admin_ui_header( $jaxtop );

	if( isset( $JAXTO_ADMIN_TABS[$jaxtop] ) && $JAXTO_ADMIN_TABS[$jaxtop]["enabled"] )
	{
		if( isset( $JAXTO_ADMIN_TABS[$jaxtop]["action"] ) && $JAXTO_ADMIN_TABS[$jaxtop]["action"] )
		{
			do_action( $JAXTO_ADMIN_TABS[$jaxtop]["action"] );
		}
		else
		{
			include "components/$jaxtop/api-id.php";
		}
	}
	else
	{
		jaxto_admin_ui_error();
	}

	jaxto_admin_ui_footer();

	// HOOKABLE:
	do_action( "jaxto_admin_main_end" );
}

// --------------------------------------------------------------------

/**
* Render jaxto admin pages header (label and tabs)
*/
function jaxto_admin_ui_header( $jaxtop = null )
{
	// HOOKABLE:
	do_action( "jaxto_admin_ui_header_start" );

	GLOBAL $JAXTO_VERSION;
	GLOBAL $JAXTO_ADMIN_TABS;

?>
<!--<a name="jaxtotop"></a>-->
<div class="jaxto-container">

	<?php
		// nag

		if( in_array( $jaxtop, array( 'networks', 'login-widget' ) ) and ( isset( $_REQUEST['settings-updated'] ) or isset( $_REQUEST['enable'] ) ) )
		{
			$active_plugins = implode('', (array) get_option('active_plugins') );
			$cache_enabled  =
				strpos( $active_plugins, "w3-total-cache"   ) !== false |
				strpos( $active_plugins, "wp-super-cache"   ) !== false |
				strpos( $active_plugins, "quick-cache"      ) !== false |
				strpos( $active_plugins, "wp-fastest-cache" ) !== false |
				strpos( $active_plugins, "wp-widget-cache"  ) !== false |
				strpos( $active_plugins, "hyper-cache"      ) !== false;

			if( $cache_enabled )
			{
				?>
					<div class="fade updated" style="margin: 4px 0 20px;">
						<p>
							<?php _e("<b>Note:</b> JAXTO has detected that you are using a caching plugin. If the saved changes didn't take effect immediately then you might need to empty the cache", 'wordpress-jaxto-store') ?>.
						</p>
					</div>
				<?php
			}
		}

		if( get_option( 'jaxto_settings_development_mode_enabled' ) )
		{
	?>
				<div class="fade error jaxto-error-dev-mode-on" style="margin: 4px 0 20px;">
					<p>
						<?php _e('<b>Warning:</b> You are now running JAXTO with DEVELOPMENT MODE enabled. This mode is not intend for live websites as it might raise serious security risks', 'wordpress-jaxto-store') ?>.
					</p>
					<p>
						<a class="button-secondary" href="admin.php?page=wordpress-jaxto-store&jaxtop=tools#dev-mode"><?php _e('Change this mode', 'wordpress-jaxto-store') ?></a>
						<a class="button-secondary" href="troubleshooting-advanced.html" target="_blank"><?php _e('Read about the development mode', 'wordpress-jaxto-store') ?></a>
					</p>
				</div>
			<?php
		}

		if( get_option( 'jaxto_settings_debug_mode_enabled' ) )
		{
			?>
				<div class="fade updated jaxto-error-debug-mode-on" style="margin: 4px 0 20px;">
					<p>
						<?php _e('<b>Note:</b> You are now running JAXTO with DEBUG MODE enabled. This mode is not intend for live websites as it might add to loading time and store unnecessary data on your server', 'wordpress-jaxto-store') ?>.
					</p>
					<p>
						<a class="button-secondary" href="admin.php?page=wordpress-jaxto-store&jaxtop=tools#debug-mode"><?php _e('Change this mode', 'wordpress-jaxto-store') ?></a>
						<a class="button-secondary" href="admin.php?page=wordpress-jaxto-store&jaxtop=watchdog"><?php _e('View JAXTO logs', 'wordpress-jaxto-store') ?></a>
						<a class="button-secondary" href="troubleshooting-advanced.html" target="_blank"><?php _e('Read about the debug mode', 'wordpress-jaxto-store') ?></a>
					</p>
				</div>
			<?php
		}
	?>
	<div id="jaxto_admin_tab_content">
<?php
	// HOOKABLE:
	do_action( "jaxto_admin_ui_header_end" );
}

// --------------------------------------------------------------------

/**
* Renders jaxto admin pages footer
*/
function jaxto_admin_ui_footer()
{
	// HOOKABLE:
	do_action( "jaxto_admin_ui_footer_start" );

	GLOBAL $JAXTO_VERSION;
?>
	</div> <!-- ./jaxto_admin_tab_content -->

<div class="clear"></div>

<?php
	jaxto_admin_help_us_localize_note();

	// HOOKABLE:
	do_action( "jaxto_admin_ui_footer_end" );

	if( get_option( 'jaxto_settings_development_mode_enabled' ) )
	{
		jaxto_display_dev_mode_debugging_area();
 	}
}

// --------------------------------------------------------------------

/**
* Renders jaxto admin error page
*/
function jaxto_admin_ui_error()
{
	// HOOKABLE:
	do_action( "jaxto_admin_ui_error_start" );
?>
<div id="jaxto_div_warn">
	<h3 style="margin:0px;"><?php _e('Oops! We ran into an issue.', 'wordpress-jaxto-store') ?></h3>

	<hr />

	<p>
		<?php _e('Unknown or Disabled <b>Component</b>! Check the list of enabled components or the typed URL', 'wordpress-jaxto-store') ?> .
	</p>

	<p>
		<?php _e("If you believe you've found a problem with <b>WordPress JAXTO</b>, be sure to let us know so we can fix it", 'wordpress-jaxto-store') ?>.
	</p>

	<hr />

	<div>
		<a class="button-secondary" href="support.html" target="_blank"><?php _e( "Report as bug", 'wordpress-jaxto-store' ) ?></a>
		<a class="button-primary" href="admin.php?page=wordpress-jaxto-store&jaxtop=components" style="float:<?php if( is_rtl() ) echo 'left'; else echo 'right'; ?>"><?php _e( "Check enabled components", 'wordpress-jaxto-store' ) ?></a>
	</div>
</div>
<?php
	// HOOKABLE:
	do_action( "jaxto_admin_ui_error_end" );
}

// --------------------------------------------------------------------

/**
* Renders JAXTO #FAIL page
*/
function jaxto_admin_ui_fail()
{
	// HOOKABLE:
	do_action( "jaxto_admin_ui_fail_start" );
?>
<div class="jaxto-container">
		<div style="background: none repeat scroll 0 0 #fff;border: 1px solid #e5e5e5;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);padding:20px;">
			<h1><?php _e("JAXTO - FAIL!", 'wordpress-jaxto-store') ?></h1>

			<hr />

			<p>
				<?php _e('Despite the efforts, put into <b>WordPress JAXTO</b> in terms of reliability, portability, and maintenance by the plugin <a href="http://profiles.wordpress.org/" target="_blank">author</a> and <a href="https://github.com/hybridauth/WordPress-Social-Login/graphs/contributors" target="_blank">contributors</a>', 'wordpress-jaxto-store') ?>.
				<b style="color:red;"><?php _e('Your server failed the requirements check for this plugin', 'wordpress-jaxto-store') ?>:</b>
			</p>

			<p>
				<?php _e('These requirements are usually met by default by most "modern" web hosting providers, however some complications may occur with <b>shared hosting</b> and, or <b>custom wordpress installations</b>', 'wordpress-jaxto-store') ?>.
			</p>

			<p>
				<?php _e("The minimum server requirements are", 'wordpress-jaxto-store') ?>:
			</p>

			<ul style="margin-left:60px;">
				<li><?php _e("PHP >= 5.2.0 installed", 'wordpress-jaxto-store') ?></li>
				<li><?php _e("JAXTO Endpoint URLs reachable", 'wordpress-jaxto-store') ?></li>
				<li><?php _e("PHP's default SESSION handling", 'wordpress-jaxto-store') ?></li>
				<li><?php _e("PHP/CURL/SSL Extension enabled", 'wordpress-jaxto-store') ?></li>
				<li><?php _e("PHP/JSON Extension enabled", 'wordpress-jaxto-store') ?></li>
				<li><?php _e("PHP/REGISTER_GLOBALS Off", 'wordpress-jaxto-store') ?></li>
				<li><?php _e("jQuery installed on WordPress backoffice", 'wordpress-jaxto-store') ?></li>
			</ul>
		</div>

<?php
	include_once( JAXTO_ABS_PATH . 'includes/admin/components/tools/jaxto.components.tools.actions.job.php' );

	jaxto_component_tools_do_diagnostics();
?>
</div>
<style>.jaxto-container .button-secondary { display:none; }</style>
<?php
	// HOOKABLE:
	do_action( "jaxto_admin_ui_fail_end" );
}

// --------------------------------------------------------------------

/**
* Renders jaxto admin welcome panel
*/
function jaxto_admin_welcome_panel()
{
	if( isset( $_REQUEST["jaxtodwp"] ) && (int) $_REQUEST["jaxtodwp"] )
	{
		$jaxtodwp = (int) $_REQUEST["jaxtodwp"];

		update_option( "jaxto_settings_welcome_panel_enabled", jaxto_get_version() );

		return;
	}

	// if new user or jaxto updated, then we display jaxto welcome panel
	if( get_option( 'jaxto_settings_welcome_panel_enabled' ) == jaxto_get_version() )
	{
		return;
	}

	$jaxtop = "networks";

	if( isset( $_REQUEST["jaxtop"] ) )
	{
		$jaxtop = $_REQUEST["jaxtop"];
	}
?>
<?php
}

// --------------------------------------------------------------------

/**
* Renders jaxto localization note
*/
function jaxto_admin_help_us_localize_note()
{
	return; // nothing, until I decide otherwise..

	$assets_url = JAXTO_PLUGIN_URL . 'assets/img/';

	?>
		<div id="l10n-footer">
			<br /><br />
			<img src="<?php echo $assets_url ?>flags.png">
			<a href="https://www.transifex.com/projects/p/wordpress-jaxto-store/" target="_blank"><?php _e( "Help us translate JAXTO into your language", 'wordpress-jaxto-store' ) ?></a>
		</div>
	<?php
}

// --------------------------------------------------------------------

/**
* Renders an editor in a page in the typical fashion used in Posts and Pages.
* wp_editor was implemented in wp 3.3. if not found we fallback to a regular textarea
*
* Utility.
*/
function jaxto_render_wp_editor( $name, $content )
{
	if( ! function_exists( 'wp_editor' ) )
	{
		?>
			<textarea style="width:100%;height:100px;margin-top:6px;" name="<?php echo $name ?>"><?php echo htmlentities( $content ); ?></textarea>
		<?php
		return;
	}
?>
<div class="postbox">
	<div class="wp-editor-textarea" style="background-color: #FFFFFF;">
		<?php
			wp_editor(
				$content, $name,
				array( 'textarea_name' => $name, 'media_buttons' => true, 'tinymce' => array( 'theme_advanced_buttons1' => 'formatselect,forecolor,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink' ) )
			);
		?>
	</div>
</div>
<?php
}

// --------------------------------------------------------------------

/**
* Display JAXTO on settings as submenu
*/
function jaxto_admin_menu()
{	
	$assets_url = JAXTO_PLUGIN_URL . 'assets/img/';
	add_menu_page( 'JAXTO', 'JAXTO', 'manage_options', 'wordpress-jaxto-store', 'jaxto_admin_main', $assets_url. 'menu-icon.png', 57.8 );
	add_submenu_page( null,'JAXTO','JAXTO','manage_options','wordpress-jaxto-app-link','jaxto_app_link',$assets_url. 'menu-icon.png',57.8);
	add_submenu_page( null,'JAXTO','JAXTO','manage_options','wordpress-about-jaxto-store','jaxto_admin_main_about',$assets_url. 'menu-icon.png',57.8);
	add_submenu_page( null,'JAXTO','JAXTO','manage_options','wordpress-api-id','jaxto_api_id',$assets_url. 'menu-icon.png',57.8);
	add_submenu_page( null,'JAXTO','JAXTO','manage_options','wordpress-jaxto-plugin-supported','jaxto_plugin_supported',$assets_url. 'menu-icon.png',57.8);
	add_action( 'admin_init', 'jaxto_register_setting' );
}

add_action('admin_menu', 'jaxto_admin_menu' );

// --------------------------------------------------------------------

/**
* Enqueue JAXTO admin CSS file
*/
function jaxto_add_admin_stylesheets($hooks)
{
	if( ! wp_style_is( 'jaxto-admin', 'registered' ) )
	{
		wp_register_style( "jaxto-admin", JAXTO_PLUGIN_URL . "assets/css/admin.css" );
		
	}
	
	wp_enqueue_style( "jaxto-admin" );
	
	if($_GET['page']=='wordpress-jaxto-store')
	{
		if (is_admin())
			wp_enqueue_media ();
	
		if( ! wp_style_is( 'jaxto-admin-css1', 'registered' ) )
			wp_register_style( "jaxto-admin-css1", JAXTO_PLUGIN_URL . "assets/form/css/template-blue.css" );
		wp_enqueue_style( "jaxto-admin-css1" );
		
		if( ! wp_style_is( 'jaxto-admin-css2', 'registered' ) )
			wp_register_style( "jaxto-admin-css2", JAXTO_PLUGIN_URL . "assets/form/css/landing.css" );
		wp_enqueue_style( "jaxto-admin-css2" );
		
		if( ! wp_style_is( 'jaxto-admin-css3', 'registered' ) )
			wp_register_style( "jaxto-admin-css3", JAXTO_PLUGIN_URL . "assets/form/css/style.css" );
		wp_enqueue_style( "jaxto-admin-css3" );
		
		wp_enqueue_style( 'select2.css', JAXTO_PLUGIN_URL . 'assets/form/select2/select2.min.css' );
		
		wp_enqueue_style( 'minicolors.css', JAXTO_PLUGIN_URL . 'assets/form/colorjs/jquery.minicolors.css' );
		
		wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );
		
		wp_enqueue_style( 'jquery.tagit', JAXTO_PLUGIN_URL . 'assets/tags/css/jquery.tagit.css' );
		wp_enqueue_style( 'tagit.ui-zendesk', JAXTO_PLUGIN_URL . 'assets/tags/css/tagit.ui-zendesk.css' );
		
	}
	if($_GET['page']=='wordpress-jaxto-app-link' || $_GET['page']=='wordpress-about-jaxto-store' || $_GET['page']=='wordpress-jaxto-plugin-supported' || $_GET['page']=='wordpress-api-id' )
	{
		if( ! wp_style_is( 'jaxto-admin-css1', 'registered' ) )
			wp_register_style( "jaxto-admin-css1", JAXTO_PLUGIN_URL . "assets/form/css/template-blue.css" );
		wp_enqueue_style( "jaxto-admin-css1" );
		
		if( ! wp_style_is( 'jaxto-admin-css2', 'registered' ) )
			wp_register_style( "jaxto-admin-css2", JAXTO_PLUGIN_URL . "assets/form/css/landing.css" );
		wp_enqueue_style( "jaxto-admin-css2" );
		
		if( ! wp_style_is( 'jaxto-admin-css3', 'registered' ) )
			wp_register_style( "jaxto-admin-css3", JAXTO_PLUGIN_URL . "assets/form/css/style.css" );
		wp_enqueue_style( "jaxto-admin-css3" );
		
	}
}
add_action( 'admin_enqueue_scripts', 'jaxto_add_admin_stylesheets' );

function jaxto_add_admin_footer_script() {
	
	if($_GET['page']=='wordpress-jaxto-store')
	{
		wp_enqueue_script( 'jquery-ui','https://code.jquery.com/ui/1.12.1/jquery-ui.min.js' );
		wp_enqueue_script( 'tags.js', JAXTO_PLUGIN_URL . 'assets/tags/js/tag-it.min.js' );
		wp_enqueue_script( 'custom-tag.js', JAXTO_PLUGIN_URL . 'assets/js/jaxto-script.js' );
		
		wp_enqueue_script( 'select2.js', JAXTO_PLUGIN_URL . 'assets/form/select2/select2.min.js' );
		
		wp_enqueue_script( 'minicolors.js', JAXTO_PLUGIN_URL . 'assets/form/colorjs/jquery.minicolors.js' );
		wp_enqueue_script( 'color.js', JAXTO_PLUGIN_URL . 'assets/form/colorjs/color.js' );
	}
	
	if($_GET['page']=='wordpress-jaxto-app-link' || $_GET['page']=='wordpress-api-id')
	{
		wp_enqueue_script( 'custom-tag.js', JAXTO_PLUGIN_URL . 'assets/js/script.js' );
	}
}
add_action('admin_footer', 'jaxto_add_admin_footer_script');
// --------------------------------------------------------------------