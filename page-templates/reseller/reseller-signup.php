<div class="signup-page">
    <form method="post" action="" id="resellerRegistrationForm">
        <div class="row justify-content-center">
            <div class="col-md-10 col-12 customer-form" style="padding: 20px; border-radius: 10px; border: 1px solid #ccc;">
                <div id="success-message" class="bg-success text-white p-3 my-2"><span class=" text-white"></span></div>
                <div id="error-message" class="bg-danger text-white p-3 my-2"><span class=" text-white"></span></div>
                <input type="hidden" id="register_type" name="register_type" value="reseller">

                <label class="header-label"><?php echo __('Group tasks', 'hello-elementor'); ?></label>

                <div class="row" style="margin-bottom: 10px;">
                    <div class="form-group col-md-6">
                        <label><?php echo __('We are one', 'hello-elementor'); ?></label>
                        <select class="form-control" style="border-radius: 5px;" name="userType" id="userType">
                            <option value="School Class"><?php echo __('School class', 'hello-elementor'); ?></option>
                            <option value="Association"><?php echo __('Association', 'hello-elementor'); ?></option>
                            <option value="Sports team"><?php echo __('Sports team', 'hello-elementor'); ?></option>
                            <option value="Other"><?php echo __('Other', 'hello-elementor'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3" style="margin-bottom: 20px;">
                    <div class="form-group col-md-12">
                        <label><?php echo __('Name of association & team or school & class', 'hello-elementor'); ?></label>
                        <small class="text-muted d-block"><?php echo __('Enter both name of school and class name, alt. name of association and team name', 'hello-elementor'); ?></small>
                        <input required name="TeamName" id="TeamName" class="form-control" type="text" placeholder="<?php echo __('Enter both name of school and class name, alt. name of association and team name', 'hello-elementor'); ?>" style="border-radius: 5px;">
                        <span class="error-msg" style="color: red;"></span>
                    </div>
                </div>

                <label class="header-label"><?php echo __('Contact details', 'hello-elementor'); ?></label>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label><?php echo __('First and last name', 'hello-elementor'); ?></label>
                    <input required name="fullName" id="fullName" class="form-control" type="text" placeholder="<?php echo __('Enter full name', 'hello-elementor'); ?>" style="border-radius: 5px;">
                    <span class="error-msg" style="color: red;"></span>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label><?php echo __('Address', 'hello-elementor'); ?></label>
                    <input required name="Address" id="Address" class="form-control" autocomplete="shipping street-address" type="text" placeholder="<?php echo __('Enter address', 'hello-elementor'); ?>" style="border-radius: 5px;">
                    <span class="error-msg" style="color: red;"></span>
                </div>

                <div class="row" style="margin-bottom: 20px;">
                    <div class="form-group col-md-6">
                        <label><?php echo __('ZIP code', 'hello-elementor'); ?></label>
                        <input required name="zipCode" id="zipCode" class="form-control" numbers-only minlength="5" maxlength="5" autocomplete="shipping postal-code" type="tel" placeholder="<?php echo __('Enter zip code', 'hello-elementor'); ?>" style="border-radius: 5px;">
                        <span class="error-msg" style="color: red;"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label><?php echo __('Postal address', 'hello-elementor'); ?></label>
                        <input required name="PostalAddress" id="PostalAddress" class="form-control" autocomplete="shipping address-level2" type="text" placeholder="<?php echo __('Enter postal address', 'hello-elementor'); ?>" style="border-radius: 5px;">
                        <span class="error-msg" style="color: red;"></span>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 20px;">
                    <div class="form-group col-md-6 order-1 order-md-0">
                        <label for="email1"><?php echo __('Email address', 'hello-elementor'); ?></label>
                        <input required name="EmailAddress" id="EmailAddress" class="form-control" id="email1" prevent-copy type="email" placeholder="<?php echo __('Enter your e-mail', 'hello-elementor'); ?>" style="border-radius: 5px;">
                        <span class="error-msg" style="color: red;"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email2"><?php echo __('Enter your email address again', 'hello-elementor'); ?></label>
                        <input required name="EmailAddressRepeat" id="EmailAddressRepeat" class="form-control" id="email2" prevent-copy aria-describedby="EmailRepeatBlock" type="email" placeholder="<?php echo __('Please repeat', 'hello-elementor'); ?>" style="border-radius: 5px;">
                        <span class="error-msg" style="color: red;"></span>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 20px;">
                    <div class="form-group col-md-6 order-1 order-md-0">

                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo __('Password', 'hello-elementor'); ?>" aria-label="<?php echo __('Password', 'hello-elementor'); ?>" aria-describedby="password">
                            <span class="input-group-text showHidePassword"><i class="fa-solid fa-eye-slash"></i></span>
                        </div>
                    </div>
                    <div class="form-group col-md-6 order-1 order-md-0">
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="<?php echo __('Confirm Password', 'hello-elementor'); ?>" aria-label="<?php echo __('Confirm Password', 'hello-elementor'); ?>" aria-describedby="confirmPassword">
                            <span class="input-group-text showHidePassword"><i class="fa-solid fa-eye-slash"></i></span>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 20px;">
                    <div class="form-group col-md-6 order-1 order-md-0">
                        <label for="bank_name"><?php echo __('Bank Name', 'hello-elementor'); ?></label>
                        <input required name="bank_name" id="bank_name" class="form-control" id="bank_name" prevent-copy type="text" placeholder="<?php echo __('Enter your bank name', 'hello-elementor'); ?>" style="border-radius: 5px;">
                        <span class="error-msg" style="color: red;"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="account_number"><?php echo __('Account Number', 'hello-elementor'); ?></label>
                        <input required name="account_number" id="account_number" class="form-control" id="email2" prevent-copy aria-describedby="account_number" type="text" placeholder="<?php echo __('Enter bank account number', 'hello-elementor'); ?>" style="border-radius: 5px;">
                        <span class="error-msg" style="color: red;"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn theme-bg-primary btn-block"><?php echo __('Complete registration', 'hello-elementor'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>