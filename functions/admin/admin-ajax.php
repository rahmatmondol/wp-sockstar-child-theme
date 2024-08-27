<?php
add_action('wp_ajax_socks_email_template', 'socks_email_template');
function socks_email_template()
{
    // Check nonce
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'socks-nonce')) {
        wp_send_json_error(array('message' => 'Invalid nonce.'));
    }

    // Retrieve templateId from POST data
    $templateId = $_POST['templateId'];
    $content    = get_option('socks_email_templates', array($templateId => ''))[$templateId];

    $subject    = $content['subject'];
    $body       = $content['body'];
    // Start output buffering
    ob_start();

    // Generate editor markup
    $editor_id = 'email_template_editor';
    $options = array(
        'media_buttons' => false
        // ),
    ); // Additional options
    wp_editor($body, $editor_id, $options);

    \_WP_Editors::enqueue_scripts();
    print_footer_scripts();
    \_WP_Editors::editor_js();

    // Get the buffered content and clean the buffer
    $editor_html = ob_get_clean();

    // Check if editor markup is generated
    if (!empty($editor_html)) {
        // Send the editor markup in the AJAX response
        wp_send_json_success(array('subject' => $subject, 'editor_html' => $editor_html));
    } else {
        wp_send_json_error(array('message' => 'Failed to generate editor markup.'));
    }
}
