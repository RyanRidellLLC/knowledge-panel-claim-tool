<?php

if (!defined('ABSPATH')) exit;

class KPCT_Admin {

    private $option_name = 'kpct_api_key';

    public function __construct() {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    /**
     * Add settings page under Settings menu
     */
    public function add_settings_page() {
        add_options_page(
            'Knowledge Panel Claim Tool',
            'Knowledge Panel Tool',
            'manage_options',
            'kpct-settings',
            [$this, 'render_settings_page']
        );
    }

    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting('kpct_settings_group', $this->option_name, [
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => ''
        ]);

        add_settings_section(
            'kpct_main_section',
            'API Configuration',
            null,
            'kpct-settings-page'
        );

        add_settings_field(
            'kpct_api_key_field',
            'Google API Key',
            [$this, 'api_key_field_html'],
            'kpct-settings-page',
            'kpct_main_section'
        );
    }

    /**
     * API Key input field
     */
    public function api_key_field_html() {
        $value = esc_attr(get_option($this->option_name));
        echo '<input type="text" name="' . $this->option_name . '" value="' . $value . '" class="regular-text" />';
        echo '<p class="description">Enter your Google Knowledge Graph Search API key.</p>';
    }

    /**
     * Render the settings page layout
     */
    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Knowledge Panel Claim Tool</h1>

            <form method="post" action="options.php">
                <?php
                    settings_fields('kpct_settings_group');
                    do_settings_sections('kpct-settings-page');
                    submit_button('Save API Key');
                ?>
            </form>
        </div>
        <?php
    }
}
