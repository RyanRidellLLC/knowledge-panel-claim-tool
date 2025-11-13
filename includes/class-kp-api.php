<?php

if (!defined('ABSPATH')) exit;

class KPCT_Assets {

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'maybe_enqueue_assets']);
    }

    /**
     * Only load assets when shortcode is found on the page
     */
    public function maybe_enqueue_assets() {

        // If not singular page/post, skip
        if (!is_singular()) return;

        global $post;

        if (!isset($post->post_content)) return;

        // Check if shortcode exists in the content
        if (has_shortcode($post->post_content, 'kp_claim_tool')) {

            // CSS
            wp_enqueue_style(
                'kpct-frontend',
                KPCT_URL . 'assets/css/kp-frontend.css',
                [],
                '1.0.0'
            );

            // JS
            wp_enqueue_script(
                'kpct-frontend',
                KPCT_URL . 'assets/js/kp-frontend.js',
                ['jquery'],
                '1.0.0',
                true
            );

            // Localize AJAX + settings
            wp_localize_script('kpct-frontend', 'kpctData', [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('kpct_nonce'),
            ]);
        }
    }
}
