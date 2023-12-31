<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the necessary AI libraries
// You will need to replace 'path_to_ai_library' with the actual path to your AI library
require_once('path_to_ai_library');

// Function to generate a blog draft
function ai_ebp_wp_generate_draft($title, $keywords, $target_audience) {
    // Get the draft length setting
    $draft_length = get_option('ai_ebp_wp_draft_length');

    // Create a new instance of the AI
    $ai = new AI();

    // Set the AI's parameters
    $ai->setTitle($title);
    $ai->setKeywords($keywords);
    $ai->setTargetAudience($target_audience);
    $ai->setLength($draft_length);

    // Generate the draft
    $draft = $ai->generateDraft();

    // Return the draft
    return $draft;
}

// Function to handle the AJAX request
function ai_ebp_wp_ajax_generate_draft() {
    // Check the nonce - security first!
    check_ajax_referer('ai_ebp_wp_ajax_nonce', 'nonce');

    // Get the parameters from the AJAX request
    $title = sanitize_text_field($_POST['title']);
    $keywords = sanitize_text_field($_POST['keywords']);
    $target_audience = sanitize_text_field($_POST['target_audience']);

    // Generate the draft
    $draft = ai_ebp_wp_generate_draft($title, $keywords, $target_audience);

    // Return the draft
    wp_send_json_success($draft);
}
add_action('wp_ajax_ai_ebp_wp_generate_draft', 'ai_ebp_wp_ajax_generate_draft');

// Enqueue the necessary scripts
function ai_ebp_wp_enqueue_scripts() {
    // Enqueue the script
    wp_enqueue_script('ai-ebp-wp-script', AI_EBP_WP_PLUGIN_URL . 'script.js', array('jquery'), '1.0', true);

    // Localize the script with new data
    $script_data_array = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ai_ebp_wp_ajax_nonce'),
    );
    wp_localize_script('ai-ebp-wp-script', 'ai_ebp_wp', $script_data_array);
}
add_action('wp_enqueue_scripts', 'ai_ebp_wp_enqueue_scripts');
?>
