<?php

if (!defined('ABSPATH')) exit;

class KPCT_Frontend {

    public function __construct() {
        add_shortcode('kp_claim_tool', [$this, 'render_shortcode']);
    }

    /**
     * Shortcode renderer
     */
    public function render_shortcode($atts) {

        ob_start();
        ?>

        <div class="kpct-wrapper">

            <!-- Step Indicator -->
            <div class="kpct-steps">
                <div class="kpct-step kpct-step-active" data-step="1">
                    <div class="kpct-step-number">1</div>
                    <div class="kpct-step-label">Search</div>
                </div>

                <div class="kpct-step-line"></div>

                <div class="kpct-step" data-step="2">
                    <div class="kpct-step-number">2</div>
                    <div class="kpct-step-label">Select</div>
                </div>

                <div class="kpct-step-line"></div>

                <div class="kpct-step" data-step="3">
                    <div class="kpct-step-number">3</div>
                    <div class="kpct-step-label">Claim</div>
                </div>
            </div>

            <!-- Step 1: Search -->
            <div id="kpct-step-1" class="kpct-step-section kpct-step-section-active">
                <h2>Search for Your Entity</h2>
                <p>Enter your name, brand, or business as it appears on Google.</p>

                <div class="kpct-search-box">
                    <input type="text" id="kpct-search-input" placeholder="Type a name or brand…" />
                    <button id="kpct-search-button" class="kpct-btn kpct-btn-primary">
                        Search
                    </button>
                </div>

                <div class="kpct-tips">
                    <h3>Tips</h3>
                    <ul>
                        <li>Use the full name (e.g., “John Smith LLC”).</li>
                        <li>Try multiple variations if needed.</li>
                        <li>Businesses: include “Inc”, “LLC”, or city name.</li>
                    </ul>
                </div>
            </div>

            <!-- Step 2: Results -->
            <div id="kpct-step-2" class="kpct-step-section">
                <button id="kpct-back-button" class="kpct-btn kpct-btn-light">← Back</button>

                <h2>Select Your Entity</h2>
                <p>Choose the result that best matches your identity or brand.</p>

                <div id="kpct-results-list" class="kpct-results-grid">
                    <!-- JS inserts cards here -->
                </div>
            </div>

            <!-- Step 3: Claim -->
            <div id="kpct-step-3" class="kpct-step-section">
                <h2>Claim Your Knowledge Panel</h2>

                <div id="kpct-selected-entity" class="kpct-selected-entity">
                    <!-- JS inserts selected entity info -->
                </div>

                <div id="kpct-claim-instructions" class="kpct-claim-instructions">
                    <!-- JS inserts claim steps -->
                </div>

                <button id="kpct-start-over" class="kpct-btn kpct-btn-light">Search Again</button>
            </div>

        </div>

        <?php
        return ob_get_clean();
    }
}

