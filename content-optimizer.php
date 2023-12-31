<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the necessary AI libraries
// You will need to replace 'path_to_ai_library' with the actual path to your AI library
require_once('path_to_ai_library');

// Function to optimize content
function ai_ebp_wp_optimize_content($content) {
    // Create a new instance of the AI
    $ai = new AI();

    // Set the AI's parameters
    $ai->setContent($content);

    // Optimize the content
    $optimized_content = $ai->optimizeContent();

    // Return the optimized content
    return $optimized_content;
}

// Function to handle the AJAX request
function ai_ebp_wp_ajax_optimize_content() {
    // Check the nonce - security first!
    check_ajax_referer('ai_ebp_wp_ajax_nonce', 'nonce');

    // Get the parameters from the AJAX request
    $content = sanitize_text_field($_POST['content']);

    // Optimize the content
    $optimized_content = ai_ebp_wp_optimize_content($content);

    // Return the optimized content
    wp_send_json_success($optimized_content);
}
add_action('wp_ajax_ai_ebp_wp_optimize_content', 'ai_ebp_wp_ajax_optimize_content');

// Enqueue the necessary scripts
function ai_ebp_wp_enqueue_optimizer_scripts() {
    // Enqueue the script
    wp_enqueue_script('ai-ebp-wp-optimizer', AI_EBP_WP_PLUGIN_URL . 'script.js', array('jquery'), '1.0', true);

    // Localize the script with new data
    $optimizer_data = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ai_ebp_wp_ajax_nonce'),
    );
    wp_localize_script('ai-ebp-wp-optimizer', 'optimizerData', $optimizer_data);
}
add_action('wp_enqueue_scripts', 'ai_ebp_wp_enqueue_optimizer_scripts');
