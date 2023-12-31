// jQuery is used as it is already included in WordPress
jQuery(document).ready(function($) {

    // Handle the form submission for generating a blog draft
    $('#ai-ebp-wp-generate-draft-form').on('submit', function(e) {
        e.preventDefault();

        // Get the form data
        var title = $('#ai-ebp-wp-title').val();
        var keywords = $('#ai-ebp-wp-keywords').val();
        var target_audience = $('#ai-ebp-wp-target-audience').val();

        // Send an AJAX request
        $.ajax({
            url: ai_ebp_wp_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'ai_ebp_wp_ajax_generate_draft',
                title: title,
                keywords: keywords,
                target_audience: target_audience,
                nonce: ai_ebp_wp_ajax_object.nonce
            },
            success: function(response) {
                // Update the draft textarea with the generated draft
                $('#ai-ebp-wp-draft').val(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    // Handle the form submission for optimizing content
    $('#ai-ebp-wp-optimize-content-form').on('submit', function(e) {
        e.preventDefault();

        // Get the form data
        var content = $('#ai-ebp-wp-content').val();

        // Send an AJAX request
        $.ajax({
            url: ai_ebp_wp_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'ai_ebp_wp_ajax_optimize_content',
                content: content,
                nonce: ai_ebp_wp_ajax_object.nonce
            },
            success: function(response) {
                // Update the content textarea with the optimized content
                $('#ai-ebp-wp-content').val(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    // Handle the form submission for recommending media
    $('#ai-ebp-wp-recommend-media-form').on('submit', function(e) {
        e.preventDefault();

        // Get the form data
        var content = $('#ai-ebp-wp-content').val();

        // Send an AJAX request
        $.ajax({
            url: ai_ebp_wp_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'ai_ebp_wp_ajax_recommend_media',
                content: content,
                nonce: ai_ebp_wp_ajax_object.nonce
            },
            success: function(response) {
                // Update the media recommendations div with the recommended media
                $('#ai-ebp-wp-media-recommendations').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    // Handle the form submission for scheduling a blog post
    $('#ai-ebp-wp-schedule-post-form').on('submit', function(e) {
        e.preventDefault();

        // Get the form data
        var title = $('#ai-ebp-wp-title').val();
        var content = $('#ai-ebp-wp-content').val();
        var date = $('#ai-ebp-wp-date').val();

        // Send an AJAX request
        $.ajax({
            url: ai_ebp_wp_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'ai_ebp_wp_ajax_schedule_post',
                title: title,
                content: content,
                date: date,
                nonce: ai_ebp_wp_ajax_object.nonce
            },
            success: function(response) {
                // Show a success message
                alert('Blog post scheduled successfully!');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

});
