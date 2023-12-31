<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the necessary AI libraries
// You will need to replace 'path_to_ai_library' with the actual path to your AI library
require_once('path_to_ai_library');

// Function to analyze text
function ai_ebp_wp_analyze_text($text) {
    // Create a new instance of the AI
    $ai = new AI();

    // Set the AI's parameters
    $ai->setText($text);

    // Analyze the text
    $analysis = $ai->analyzeText();

    // Return the analysis
    return $analysis;
}

// Function to handle the AJAX request
function ai_ebp_wp_ajax_analyze_text() {
    // Check the nonce - security first!
    check_ajax_referer('ai_ebp_wp_ajax_nonce', 'nonce');

    // Get the parameters from the AJAX request
    $text = sanitize_text_field($_POST['text']);

    // Analyze the text
    $analysis = ai_ebp_wp_analyze_text($text);

    // Return the analysis
    wp_send_json_success($analysis);
}
add_action('wp_ajax_ai_ebp_wp_analyze_text', 'ai_ebp_wp_ajax_analyze_text');

// Enqueue the necessary scripts
function ai_ebp_wp_enqueue_analyzer_scripts() {
    // Enqueue the script
    wp_enqueue_script('ai-ebp-wp-analyzer', AI_EBP_WP_PLUGIN_URL . 'script.js', array('jquery'), '1.0', true);

    // Localize the script with new data
    $analyzer_data = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ai_ebp_wp_ajax_nonce'),
    );
    wp_localize_script('ai-ebp-wp-analyzer', 'ai_ebp_wp', $analyzer_data);
}
add_action('wp_enqueue_scripts', 'ai_ebp_wp_enqueue_analyzer_scripts');
