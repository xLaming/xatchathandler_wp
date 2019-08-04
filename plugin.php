<?php
/*
 * Plugin Name: xat Auto Staff
 * Plugin URI: https://github.com/xLaming/xatchathandler_wp
 * Description: List your staff automatically to WordPress.
 * Version: 1.2
 * Author: xLaming
 * Author URI: xat.me/PAULO
 * License: MIT
 */

if (!defined('ABSPATH'))
	exit;


/* global var */
define('XAS_DIR', __DIR__);
define('XAS_BASE_DIR', wp_get_upload_dir()['basedir']);
define('XAS_CACHE_DIR',  XAS_BASE_DIR . '/xas_usercache.json');


/* load files */
require_once XAS_DIR . '/src/ChatHandler.php';
require_once XAS_DIR . '/src/StaffHandler.php';
require_once XAS_DIR . '/settings.php';


/* register stuff */
add_shortcode('autostaff', 'XAS_StaffList');
add_action('admin_menu', 'XAS_SettingsMenu');
