<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package Ignis Pro
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'http://athemes.com', // Site where EDD is hosted
		'item_name'      => 'Ignis Pro', // Name of theme
		'theme_slug'     => 'ignis-pro', // Theme slug
		'version'        => '1.1.0', // The current version of this theme
		'author'         => 'aThemes', // The author of this theme
		'download_id'    => '', // Optional, used for generating a license renewal link
		'renew_url'      => '', // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Theme License', 'ignis' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'ignis' ),
		'license-key'               => __( 'License Key', 'ignis' ),
		'license-action'            => __( 'License Action', 'ignis' ),
		'deactivate-license'        => __( 'Deactivate License', 'ignis' ),
		'activate-license'          => __( 'Activate License', 'ignis' ),
		'status-unknown'            => __( 'License status is unknown.', 'ignis' ),
		'renew'                     => __( 'Renew?', 'ignis' ),
		'unlimited'                 => __( 'unlimited', 'ignis' ),
		'license-key-is-active'     => __( 'License key is active.', 'ignis' ),
		'expires%s'                 => __( 'Expires %s.', 'ignis' ),
		'expires-never'             => __( 'Lifetime License.', 'ignis' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'ignis' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'ignis' ),
		'license-key-expired'       => __( 'License key has expired.', 'ignis' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'ignis' ),
		'license-is-inactive'       => __( 'License is inactive.', 'ignis' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'ignis' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'ignis' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'ignis' ),
		'update-notice'             => __( "Updating this theme will lose any code customizations you have made. 'Cancel' to stop, 'OK' to update.", 'ignis' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'ignis' ),
	)

);
