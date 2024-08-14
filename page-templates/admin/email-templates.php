<?php
// Call the socks_get_email_template filter
// do_action('socks_send_email_template_action', 'signup-email', 1);

if (isset($_POST['email_template'])) {
    // Retrieve and sanitize data
    $templateId      = !empty($_POST['templateId']) ? sanitize_text_field($_POST['templateId']) : '';
    $subject         = !empty($_POST['subject']) ? sanitize_text_field($_POST['subject']) : '';
    $templateContent = !empty($_POST['email_template_editor']) ? wp_kses_post($_POST['email_template_editor']) : '';

    // Save data to options table
    $template_data = get_option('socks_email_templates', array());
    $template_data[$templateId] = ['subject' => $subject, 'body' => $templateContent];
    update_option('socks_email_templates', $template_data);
}

?>
<div class="bootstrap-iso">
    <div class="container pt-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-12">
                <form method="post" action="">
                    <div class="form-group">
                        <label class="d-block" for="email-templates">Select Template</label>
                        <select class="form-control select2" name="templateId" id="email-templates">
                            <option value="signup-email" selected>Signup Reseller Email</option>
                            <option value="welcome-reseller-email">Welcome Reseller Email</option>
                            <option value="sales-period-close">Sales Period Close</option>
                            <option value="halfway-sales-reminder">Halfway sales reminder</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="d-block" for="subject">Email Subject</label>
                        <input type="text" class="form-control" name="subject" id="email-subject" placeholder="Email subject">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Email Body</label>
                        <div class="email-body-data position-relative">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="font-weight-bold col-sm-2 col-form-label">Variables :</label>
                        <div class="col-sm-10 font-weight-bold">
                            {{username}}, {{first_name}}, {{last_name}}, {{full_name}}, {{email}}, {{admin_email}}, {{site_url}}
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="email_template" class="btn btn-success btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>