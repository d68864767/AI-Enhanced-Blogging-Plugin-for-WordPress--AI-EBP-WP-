<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Add settings, sections, and fields
function ai_ebp_wp_add_settings() {
    // Add a new section to the AI-EBP-WP settings page
    add_settings_section(
        'ai_ebp_wp_settings_section', // ID
        'AI-EBP-WP Settings', // Title
        'ai_ebp_wp_settings_section_callback', // Callback
        'ai-ebp-wp' // Page
    );

    // Add the 'Blog Draft Length' field
    add_settings_field(
        'ai_ebp_wp_draft_length', // ID
        'Blog Draft Length', // Title
        'ai_ebp_wp_draft_length_callback', // Callback
        'ai-ebp-wp', // Page
        'ai_ebp_wp_settings_section' // Section
    );

    // Register the 'Blog Draft Length' setting
    register_setting(
        'ai-ebp-wp-settings-group', // Option group
        'ai_ebp_wp_draft_length' // Option name
    );
}
add_action('admin_init', 'ai_ebp_wp_add_settings');

// Callback for the settings section
function ai_ebp_wp_settings_section_callback() {
    echo 'Configure the settings for the AI-Enhanced Blogging Plugin for WordPress.';
}

// Callback for the 'Blog Draft Length' field
function ai_ebp_wp_draft_length_callback() {
    // Get the value of the setting we've registered with register_setting()
    $setting = esc_attr(get_option('ai_ebp_wp_draft_length'));

    // Create a dropdown
    echo "<select id='ai_ebp_wp_draft_length' name='ai_ebp_wp_draft_length'>";
    echo "<option value='short' " . selected($setting, 'short', false) . ">Short</option>";
    echo "<option value='medium' " . selected($setting, 'medium', false) . ">Medium</option>";
    echo "<option value='long' " . selected($setting, 'long', false) . ">Long</option>";
    echo "</select>";
}

// Output the settings page
function ai_ebp_wp_settings_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    ?>
    <div class="wrap">
        <h1>AI-Enhanced Blogging Plugin for WordPress Settings</h1>
        <form method="post" action="options.php">
            <?php
            // Output security fields for the registered setting "ai-ebp-wp"
            settings_fields('ai-ebp-wp-settings-group');
            // Output setting sections and their fields
            do_settings_sections('ai-ebp-wp');
            // Output save settings button
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
?>
</h1>