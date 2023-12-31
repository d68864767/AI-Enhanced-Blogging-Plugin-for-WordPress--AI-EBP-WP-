<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the necessary WordPress libraries
require_once(ABSPATH . 'wp-includes/pluggable.php');
require_once(ABSPATH . 'wp-admin/includes/post.php');

// Function to schedule a blog post
function ai_ebp_wp_schedule_post($title, $content, $timestamp) {
    // Create a new post
    $post_id = wp_insert_post(array(
        'post_title' => $title,
        'post_content' => $content,
        'post_status' => 'future',
        'post_date' => date('Y-m-d H:i:s', $timestamp),
        'post_author' => get_current_user_id(),
        'post_type' => 'post'
    ));

    // Check for errors
    if (is_wp_error($post_id)) {
        // Log the error and return
        error_log($post_id->get_error_message());
        return;
    }

    // Schedule the post
    wp_schedule_single_event($timestamp, 'publish_future_post', array($post_id));
}

// Function to handle the AJAX request
function ai_ebp_wp_ajax_schedule_post() {
    // Check the nonce - security first!
    check_ajax_referer('ai_ebp_wp_ajax_nonce', 'nonce');

    // Get the parameters from the AJAX request
    $title = sanitize_text_field($_POST['title']);
    $content = wp_kses_post($_POST['content']);
    $timestamp = intval($_POST['timestamp']);

    // Schedule the post
    ai_ebp_wp_schedule_post($title, $content, $timestamp);

    // Send a JSON response
    wp_send_json_success();
}
add_action('wp_ajax_ai_ebp_wp_schedule_post', 'ai_ebp_wp_ajax_schedule_post');
