<?php
/**
 * Plugin Name: Knowledge Panel Claim Tool
 * Description: Frontend tool to search Google Knowledge Graph and guide users in claiming their Knowledge Panel.
 * Version: 1.0.0
 * Author: Ryan Ridell
 * Text Domain: kpct
 */

if (!defined('ABSPATH')) exit;

// Plugin path constants
define('KPCT_PATH', plugin_dir_path(__FILE__));
define('KPCT_URL', plugin_dir_url(__FILE__));

// Auto-load required classes
require_once KPCT_PATH . 'includes/class-kp-admin.php';
require_once KPCT_PATH . 'includes/class-kp-assets.php';
require_once KPCT_PATH . 'includes/class-kp-api.php';
require_once KPCT_PATH . 'includes/class-kp-frontend.php';

// Initialize plugin classes
new KPCT_Admin();      // Admin settings + API key field
new KPCT_Assets();     // Load CSS/JS only on pages with shortcode
new KPCT_API();        // AJAX search handler
new KPCT_Frontend();   // Shortcode + frontend UI
