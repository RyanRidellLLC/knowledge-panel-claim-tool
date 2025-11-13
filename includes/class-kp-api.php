<?php

if (!defined('ABSPATH')) exit;

class KPCT_API {

    private $option_name = 'kpct_api_key';

    public function __construct() {
        add_action('wp_ajax_kpct_search', [$this, 'handle_search']);
        add_action('wp_ajax_nopriv_kpct_search', [$this, 'handle_search']);
    }

    /**
     * AJAX handler for KG search
     */
    public function handle_search() {

        check_ajax_referer('kpct_nonce', 'nonce');

        $query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';
        if (empty($query)) {
            wp_send_json_error(['message' => 'Missing search query']);
        }

        $api_key = get_option($this->option_name);
        if (empty($api_key)) {
            wp_send_json_error(['message' => 'API key is not configured']);
        }

        // Build Google KG API URL
        $url = 'https://kgsearch.googleapis.com/v1/entities:search?' . http_build_query([
            'query' => $query,
            'key'   => $api_key,
            'limit' => 20,
        ]);

        $response = wp_remote_get($url);

        if (is_wp_error($response)) {
            wp_send_json_error(['message' => 'API request failed']);
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        $results = [];

        if (!empty($data['itemListElement'])) {
            foreach ($data['itemListElement'] as $item) {

                $result = $item['result'];

                $results[] = [
                    'id'          => $result['@id'] ?? uniqid(),
                    'name'        => $result['name'] ?? $query,
                    'type'        => $result['@type'][0] ?? '',
                    'description' => $result['description']
                                    ?? ($result['detailedDescription']['articleBody'] ?? ''),
                    'image'       => $result['image']['contentUrl']
                                    ?? ($result['image']['url'] ?? ''),
                    'url'         => $result['detailedDescription']['url']
                                    ?? 'https://www.google.com/search?q=' . urlencode($query),
                ];
            }
        }

        wp_send_json_success($results);
    }
}
