jQuery(document).ready(function ($) {
    $('.select2').select2();
    // Get the initially selected template ID
    var initialTemplateId = $('#email-templates').val();
    var nonce = ajax_object.nonce
    // Fetch template content for the initially selected option
    socks_email_template_ajax(initialTemplateId,nonce);

    // Handle 'change' event of the select element
    $('#email-templates').on('change', function (e) {
        var templateId = $(this).val();
        e.preventDefault();
        // Your AJAX request with nonce
        socks_email_template_ajax(templateId, nonce);

    });

    function socks_email_template_ajax(templateId, nonce) {
        $('.email-body-data').append('<div class="data-spinner"><div class="spinner-grow text-secondary style="width: 3rem; height: 3rem;"" role="status"><span class="sr-only">Loading...</span></div></div>')

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'socks_email_template',
                nonce: nonce,
                templateId: templateId // Pass templateId as a parameter
            },
            success: function (response) {
                console.log(response.data)
                console.log(ajax_object.nonce)
                $('#email-subject').val(response.data.subject);
                $('.email-body-data').html(response.data.editor_html);
            },
            error: function (error) {
                // Handle error response
                console.log(error);
            }
        });
    }
});
