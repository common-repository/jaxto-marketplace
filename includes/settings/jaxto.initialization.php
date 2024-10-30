<?php
/*!
* WordPress JAXTO
*

*/

/**
* Check JAXTO requirements and register JAXTO settings 
*/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// --------------------------------------------------------------------

/**
* Check JAXTO minimum requirements. Display fail page if they are not met.
*
* This function will only test the strict minimal
*/
function jaxto_check_requirements()
{
	if (! version_compare( PHP_VERSION, '5.2.0', '>=' ))
	{
		return false;
	}
	return true;
}

// --------------------------------------------------------------------

/** list of JAXTO components */
$JAXTO_COMPONENTS = ARRAY(
	"jaxto-plugin-settings"=> array( "type" => "core","label" => __("JAXTO Plugin Settings",'wordpress-jaxto-store'),"description" => __("JAXTO Plugin Settings.",'wordpress-jaxto-store') )
);

/** list of JAXTO admin tabs */
$JAXTO_ADMIN_TABS = ARRAY(  
	"jaxto-plugin-settings" => 
		array( 
		"label" => __("JAXTO Plugin Settings",'wordpress-jaxto-store'), 
		"visible" => true  , 
		"component" => "jaxto-plugin-settings", 
		"default" => true 
		)
);

// --------------------------------------------------------------------

/**
* Register a new JAXTO component 
*/
function jaxto_register_component( $component, $label, $description, $version, $author, $author_url, $component_url )
{
	GLOBAL $JAXTO_COMPONENTS;

	$config = array();

	$config["type"]          = "addon"; // < force to addon
	$config["label"]         = $label;
	$config["description"]   = $description;
	$config["version"]       = $version;
	$config["author"]        = $author;
	$config["author_url"]    = $author_url;
	$config["component_url"] = $component_url;

	$JAXTO_COMPONENTS[ $component ] = $config;
}

// --------------------------------------------------------------------

/**
* Register new JAXTO admin tab
*/
function jaxto_register_admin_tab( $component, $tab, $label, $action, $visible = false, $pull_right = false ) 
{ 
	GLOBAL $JAXTO_ADMIN_TABS;

	$config = array();

	$config["component"]  = $component;
	$config["label"]      = $label;
	$config["visible"]    = $visible;
	$config["action"]     = $action;
	$config["pull_right"] = $pull_right;

	$JAXTO_ADMIN_TABS[ $tab ] = $config;
}

// --------------------------------------------------------------------

/**
* Check if a component is enabled
*/
function jaxto_is_component_enabled( $component )
{ 
	if( get_option( "jaxto_components_" . $component . "_enabled" ) == 1 )
	{
		return true;
	}

	return false;
}

// --------------------------------------------------------------------

/**
* Register JAXTO components (Bulk action)
*/
function jaxto_register_components()
{
	GLOBAL $JAXTO_COMPONENTS;
	GLOBAL $JAXTO_ADMIN_TABS;

	// HOOKABLE:
	do_action( 'jaxto_register_components' );

	foreach( $JAXTO_ADMIN_TABS as $tab => $config )
	{
		$JAXTO_ADMIN_TABS[ $tab ][ "enabled" ] = false; 
	}

	foreach( $JAXTO_COMPONENTS as $component => $config )
	{
		$JAXTO_COMPONENTS[ $component ][ "enabled" ] = false;

		$is_component_enabled = get_option( "jaxto_components_" . $component . "_enabled" );
		
		if( $is_component_enabled == 1 )
		{
			$JAXTO_COMPONENTS[ $component ][ "enabled" ] = true;
		}

		if( $JAXTO_COMPONENTS[ $component ][ "type" ] == "core" )
		{
			$JAXTO_COMPONENTS[ $component ][ "enabled" ] = true;

			if( $is_component_enabled != 1 )
			{
				update_option( "jaxto_components_" . $component . "_enabled", 1 );
			}
		}
	}

	foreach( $JAXTO_ADMIN_TABS as $tab => $config )
	{
		$component = $config[ "component" ] ;

		if( $JAXTO_COMPONENTS[ $component ][ "enabled" ] )
		{
			$JAXTO_ADMIN_TABS[ $tab ][ "enabled" ] = true;
		}
	}
}

// --------------------------------------------------------------------

/**
* Register JAXTO core settings ( options; components )
*/
function jaxto_register_setting()
{
	GLOBAL $JAXTO_PROVIDERS_CONFIG;
	GLOBAL $JAXTO_COMPONENTS;
	GLOBAL $JAXTO_ADMIN_TABS;

	// HOOKABLE:
	do_action( 'jaxto_register_setting' );

	jaxto_register_components();

	// idps credentials
	foreach( $JAXTO_PROVIDERS_CONFIG AS $item )
	{
		$provider_id          = isset( $item["provider_id"]       ) ? $item["provider_id"]       : null;
		$require_client_id    = isset( $item["require_client_id"] ) ? $item["require_client_id"] : null;
		$require_registration = isset( $item["new_app_link"]      ) ? $item["new_app_link"]      : null;
		$default_api_scope    = isset( $item["default_api_scope"] ) ? $item["default_api_scope"] : null;

		/**
		* @fixme
		*
		* Here we should only register enabled providers settings. postponed. patches are welcome.
		***
			$default_network = isset( $item["default_network"] ) ? $item["default_network"] : null;

			if( ! $default_network || get_option( 'jaxto_settings_' . $provider_id . '_enabled' ) != 1 .. )
			{
				..
			}
		*/

		register_setting( 'jaxto-settings-group', 'jaxto_settings_' . $provider_id . '_enabled' );

		// require application?
		if( $require_registration )
		{
			// api key or id ?
			if( $require_client_id )
			{
				register_setting( 'jaxto-settings-group', 'jaxto_settings_' . $provider_id . '_app_id' ); 
			}
			else
			{
				register_setting( 'jaxto-settings-group', 'jaxto_settings_' . $provider_id . '_app_key' ); 
			}

			// api secret
			register_setting( 'jaxto-settings-group', 'jaxto_settings_' . $provider_id . '_app_secret' ); 

			// api scope?
			if( $default_api_scope )
			{
				if( ! get_option( 'jaxto_settings_' . $provider_id . '_app_scope' ) )
				{
					update_option( 'jaxto_settings_' . $provider_id . '_app_scope', $default_api_scope );
				}

				register_setting( 'jaxto-settings-group', 'jaxto_settings_' . $provider_id . '_app_scope' );
			}
		}
	}

	register_setting( 'jaxto-settings-group-customize'        , 'jaxto_settings_connect_with_label'                               ); 
	register_setting( 'jaxto-settings-group-customize'        , 'jaxto_settings_social_icon_set'                                  ); 
	register_setting( 'jaxto-settings-group-customize'        , 'jaxto_settings_users_avatars'                                    ); 
	register_setting( 'jaxto-settings-group-customize'        , 'jaxto_settings_use_popup'                                        ); 
	register_setting( 'jaxto-settings-group-customize'        , 'jaxto_settings_widget_display'                                   ); 
	register_setting( 'jaxto-settings-group-customize'        , 'jaxto_settings_redirect_url'                                     ); 
	register_setting( 'jaxto-settings-group-customize'        , 'jaxto_settings_force_redirect_url'                               ); 
	register_setting( 'jaxto-settings-group-customize'        , 'jaxto_settings_users_notification'                               ); 
	register_setting( 'jaxto-settings-group-customize'        , 'jaxto_settings_authentication_widget_css'                        ); 

	register_setting( 'jaxto-settings-group-contacts-import'  , 'jaxto_settings_contacts_import_facebook'                         ); 
	register_setting( 'jaxto-settings-group-contacts-import'  , 'jaxto_settings_contacts_import_google'                           ); 
	register_setting( 'jaxto-settings-group-contacts-import'  , 'jaxto_settings_contacts_import_twitter'                          ); 
	register_setting( 'jaxto-settings-group-contacts-import'  , 'jaxto_settings_contacts_import_linkedin'                         ); 
	register_setting( 'jaxto-settings-group-contacts-import'  , 'jaxto_settings_contacts_import_live'                             ); 
	register_setting( 'jaxto-settings-group-contacts-import'  , 'jaxto_settings_contacts_import_vkontakte'                        ); 

	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_registration_enabled'                     ); 
	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_authentication_enabled'                   ); 

	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_accounts_linking_enabled'                 );

	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_profile_completion_require_email'         );
	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_profile_completion_change_username'       );
	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_profile_completion_hook_extra_fields'     );

	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_new_users_moderation_level'               );
	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_new_users_membership_default_role'        );

	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_new_users_restrict_domain_enabled'        );
	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_new_users_restrict_domain_list'           );
	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_new_users_restrict_domain_text_bounce'    );
	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_new_users_restrict_email_enabled'         );
	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_new_users_restrict_email_list'            );
	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_new_users_restrict_email_text_bounce'     );
	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_new_users_restrict_profile_enabled'       );
	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_new_users_restrict_profile_list'          );
	register_setting( 'jaxto-settings-group-bouncer'          , 'jaxto_settings_bouncer_new_users_restrict_profile_text_bounce'   );

	register_setting( 'jaxto-settings-group-buddypress'       , 'jaxto_settings_buddypress_enable_mapping' ); 
	register_setting( 'jaxto-settings-group-buddypress'       , 'jaxto_settings_buddypress_xprofile_map' ); 

	register_setting( 'jaxto-settings-group-debug'            , 'jaxto_settings_debug_mode_enabled' ); 
	register_setting( 'jaxto-settings-group-development'      , 'jaxto_settings_development_mode_enabled' ); 
}

// --------------------------------------------------------------------
