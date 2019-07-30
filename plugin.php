<?php
/*
Plugin Name: xat Auto Staff
Plugin URI: https://github.com/xLaming/xatchathandler_wp
Description: List your staff automatically to WordPress.
Version: 1.0
Author: xLaming
Author URI: xat.me/PAULO
*/

/* global var */
define('DIRECTORY', __DIR__);

/* load files */
require_once DIRECTORY . '/src/ChatHandler.php';
require_once DIRECTORY . '/src/StaffHandler.php';
require_once DIRECTORY . '/settings.php';

/* register stuff */
add_shortcode('autostaff', 'initStaffList');
add_action('admin_menu', 'autoStaffSettingsMenu');
