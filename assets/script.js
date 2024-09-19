(function ($) {
    jQuery(document).ready(function ($) {
        $('.socks-login').on('submit', function (e) {
            e.preventDefault();
            // Get form data
            var formData = $(this).serialize();
            // Your AJAX request with nonce
            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: 'action=custom_login&nonce=' + ajax_object.nonce + '&' + formData,
                success: function (response) {
                    if (response.success) {
                        // Redirect to the desired URL after successful login
                        window.location.replace(response.data.redirect);
                    } else {
                        $('#error-message').text(response.data.message).show();
                    }
                },
                error: function (error) {
                    // Handle error response
                    console.log(error);
                }
            });
        });


        $('.showHidePassword').on('click', function () {
            const passwordInputGroup = $(this).closest('.input-group');
            const passwordInput = passwordInputGroup.find('input');
            const icon = $(this).find('i');

            // Toggle password visibility
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);

            // Toggle eye icon
            icon.toggleClass('fa-eye-slash fa-eye');
        });

        // member registration
        $('#memberRegistrationForm').on('submit', function (e) {
            e.preventDefault();
            // Reset previous error messages
            $('.error-message').remove();

            var data = {
                'action': 'shocks_user_registration',
                'userType': $('#userType').val(),
                'fullName': $('#fullName').val(),
                'email': $('#emailAddress').val(),
                'password': $('#password').val(),
                'reseller_id': $('#reseller_id').val(),
                'register_type': $('#register_type').val(),
                'security': ajax_object.nonce,
            };

            // Validate fields
            var isValid = true;

            $.each(data, function (key, value) {
                if (value === '' || value === null) {
                    isValid = false;
                    $('#' + key).after('<div class="error-message">This field is required</div>');
                }
            });

            // Proceed with Ajax request if all validations pass
            if (isValid) {
                $.ajax({
                    type: 'POST',
                    url: ajax_object.ajax_url,
                    data: data,
                    beforeSend: function () {
                        // Show loading spinner or disable the submit button
                    },
                    success: function (response) {
                        console.log(response);
                        // Scroll to the top of the form
                        const formTop = $('#memberRegistrationForm').offset().top;
                        $('html, body').animate({
                            scrollTop: formTop - 20
                        }, 500);

                        if (response.success) {
                            $('#success-message').text(response.data.message).show();
                            if (response.data.data.register_type == 'team') {
                                // window.location.href = response.data.data.redirect_url;
                            }
                            // You can clear the form or perform any other actions here
                            $('#error-message').text(response.data.message).hide(); // Show error message above the form
                        } else {
                            $('#success-message').text(response.data.message).hide();
                            $('#error-message').text(response.data.message).show(); // Show error message above the form
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // Handle Ajax errors
                        console.log(jqXHR.responseText); // Log the detailed error message
                        $('#error-message').text('An error occurred. Please try again.').show(); // Show a generic error message
                    },
                    complete: function () {
                        // Hide loading spinner or enable the submit button
                    }
                });
            }
        });

        //reseler registration
        $('#resellerRegistrationForm').on('submit', function (e) {
            e.preventDefault();
            // Reset previous error messages
            $('.error-message').remove();

            var data = {
                'action': 'shocks_reseller_registration',
                'userType': $('#userType').val(),
                'fullName': $('#fullName').val(),
                'TeamName': $('#TeamName').val(),
                'Address': $('#Address').val(),
                'zipCode': $('#zipCode').val(),
                'PostalAddress': $('#PostalAddress').val(),
                'EmailAddress': $('#EmailAddress').val(),
                'EmailAddressRepeat': $('#EmailAddressRepeat').val(),
                'password': $('#password').val(),
                'confirmPassword': $('#confirmPassword').val(),
                'reseller_id': $('#reseller_id').val(),
                'register_type': $('#register_type').val(),
                'bank_name': $('#bank_name').val(),
                'account_number': $('#account_number').val(),
                // 'PhoneNumber': $('#PhoneNumber').val(),
                'security': ajax_object.nonce,
            };

            // Validate fields
            var isValid = true;

            $.each(data, function (key, value) {
                if (value === '' || value === null) {
                    isValid = false;
                    $('#' + key).after('<div class="error-message">This field is required</div>');
                }
            });

            // Additional validation (e.g., email matching)
            if (data.Email !== data.EmailRepeat) {
                isValid = false;
                $('#EmailAddressRepeat').after('<div class="error-message">Emails do not match</div>');
            }

            // Proceed with Ajax request if all validations pass
            if (isValid) {
                $.ajax({
                    type: 'POST',
                    url: ajax_object.ajax_url,
                    data: data,
                    beforeSend: function () {
                        // Show loading spinner or disable the submit button
                    },
                    success: function (response) {
                        console.log(response);
                        // Scroll to the top of the form
                        const formTop = $('#resellerRegistrationForm').offset().top;
                        $('html, body').animate({
                            scrollTop: formTop - 20
                        }, 500);

                        if (response.success) {
                            $('#success-message').text(response.data.message).show();
                            if (response.data.data.register_type == 'team') {
                                // window.location.href = response.data.data.redirect_url;
                            }
                            // You can clear the form or perform any other actions here
                            $('#error-message').text(response.data.message).hide(); // Show error message above the form
                        } else {
                            $('#success-message').text(response.data.message).hide();
                            $('#error-message').text(response.data.message).show(); // Show error message above the form
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // Handle Ajax errors
                        console.log(jqXHR.responseText); // Log the detailed error message
                        $('#error-message').text('An error occurred. Please try again.').show(); // Show a generic error message
                    },
                    complete: function () {
                        // Hide loading spinner or enable the submit button
                    }
                });
            }
        });

        // profit calculator js starts
        const productRange = $('#productRange');
        const orderRange = $('#orderRange');
        const profitResult = $('.profit-calculator-result p');

        const htmlInputRange = {
            init: function () {
                const inputRanges = $('.socks-calculator-range-container input[type="range"]');
                inputRanges.each(function () {
                    let $this = $(this);
                    let container = $this.parent();
                    container.addClass('socks-calculator-range-custom');
                    container.append('<div class="hir-tracker-bg"></div><div class="hir-tracker-thumb"></div>');
                    $this.attr({
                        min: 0,
                        max: 100,
                        value: $this.val(),
                        step: 1
                    });
                    const tooltipPosition = ($this.val() / $this.attr('max')) * 55 - 3.5;

                    const tooltipText = $this.data('tooltip-text') || ''; // Default to empty string
                    container.append(`<div class="socks-tooltip" style="left: ${tooltipPosition}%;"><h4 class="text-center">${$this.val()}</h4><p class="text-center">${tooltipText}</p></div>`);
                });
                // Call inputChange when the page loads
                inputRanges.each(function () {
                    htmlInputRange.inputChange($(this));
                });
            },
            inputChange: function ($input) {
                let $this = $input;
                let container = $this.parent();
                let inputMax = 100 / $this.attr('max');
                let trackerTooltipMove = ($this.val() * inputMax);
                container.find('.socks-tooltip').css('left', trackerTooltipMove + '%');
                container.find('.hir-tracker-thumb').css('width', trackerTooltipMove + '%');
                container.find('.socks-tooltip h4').text($this.val());
            }
        };

        function updateProfit() {
            const productCount = parseInt(productRange.val());
            const orderCount = parseInt(orderRange.val());
            const productPrice = 249;
            const commissionRate = .5;

            const totalRevenue = productCount * productPrice * orderCount;
            const commission = totalRevenue * commissionRate;
            const profit = totalRevenue - commission;
            profitResult.text(`${profit.toFixed()}` + ' ' + profitResult.data('currency'));
        }

        productRange.on('input change', function () {
            htmlInputRange.inputChange($(this));
            updateProfit();
        });

        orderRange.on('input change', function () {
            htmlInputRange.inputChange($(this));
            updateProfit();
        });

        htmlInputRange.init();
        updateProfit(); // Call updateProfit to initialize the profit display with default values
        // profit calculator js end
    });

    //cover photo and profile photos ajax
    $('.sock-shop-profile-cover-upload').on('click', function (e) {
        e.preventDefault();
        var thisData = $(this);
        var type = thisData.data('type');
        // Remove the img tag within thisData
        $('.' + type + '-upload').find('img').remove();
        $('.' + type + '-choose').hide();
        $('.' + type + '-upload').show();
        $('.' + type + '-img-select').prop('type', 'file');
        if (type == 'profile-photos') {
            $('.socks-hide-profile').trigger('click');
        } else {
            $('.socks-hide-cover').trigger('click');
        }

    })
    $('.sock-shop-profile-cover-choose').on('click', function () {
        var thisData = $(this);
        var type = thisData.data('type');
        var attachID = thisData.data('attachd');
        getCategoryImages('', type, attachID)
    })

    //get category based images
    // On category button click
    $(document).on('click', '.category-button', function (e) {
        e.preventDefault();
        // Get selected category slug
        var categoryID = $(this).data('category-id');
        var type = $(this).data('type');

        // Make AJAX request to get category-wise photos
        getCategoryImages(categoryID, type);
    });

    // Function to get category-wise photos
    function getCategoryImages(categoryID, type, attachID) {
        $('.' + type + '-upload').hide();
        $('.' + type + '-choose').show();
        var Container = $('.' + type + '-choose');
        Container.html('<div class="socks-loader" id="socks-loader-circle"></div>')
        // AJAX request
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'socks_cover_profile_images',
                category: categoryID,
                type: type,
                attach_id: attachID
            },
            success: function (response) {
                var categoriesData = '';
                var activeButton = '';

                response.categories.forEach(function (category) {
                    // Check if the category is active based on post category_id
                    var activeCategory = response.posts[0].category_id;
                    console.log(categoryID)
                    if (categoryID !== "") {
                        activeCategory = categoryID;
                    }
                    var isActive = (response.posts.length > 0 && activeCategory === category.id) ? 'active' : '';

                    var categoryButton = '<button type="button" class="category-button btn btn-sm btn-light px-2 me-2 ' + isActive + '" data-type="' + type + '" data-category-id="' + category.id + '">' + category.name + '</button>';

                    // If the category is active, store it in activeButton
                    if (isActive === 'active') {
                        activeButton = categoryButton;
                    } else {
                        categoriesData += categoryButton;
                    }
                });

                var postData = '';
                response.posts.forEach(function (post) {
                    postImages = '<div class="col-md-3 col-6 socks-shop-img-select" data-type="' + type + '" data-attach-id="' + post.id + '" data-attach-url="' + post.url + '" data-categoryid="' + post.category_id + '"><img src="' + post.url + '" alt="Image"></div>';
                    postData += postImages;
                });
                if (postData == '' || postData == null) {
                    postData = '<div class="col-6"><p class="text-center">No Data found!</p></div>'
                }
                // Append the active button at the beginning
                Container.html('<div class="pb-3">' + activeButton + categoriesData + '</div><div class="row align-items-center">' + postData + '</div>');

            }
        });
    }
    $(document).on('click', '.socks-shop-img-select', function (e) {
        e.preventDefault();
        var thisData = $(this);
        var type = thisData.data('type');
        var imgUrl = thisData.data('attach-url');
        $('.socks-shop-img-select').removeClass('active-selection');
        thisData.addClass('active-selection');
        $('.' + type + '-img-select').prop('type', 'hidden');
        $('.' + type + '-img-select').val(thisData.data('attach-id'));
        $('.' + type + '-upload .picture__image img').attr("src", imgUrl);
        $('.demo-profile-' + type + ' img').attr("src", imgUrl);
        // $('.' + type + '-choose').hide()
        // $('.' + type + '-upload').show()
    })

    // // Function to set a cookie
    // function setCookie(name, value, days) {
    //     var expires = "";
    //     if (days) {
    //         var date = new Date();
    //         date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    //         expires = "; expires=" + date.toUTCString();
    //     }
    //     document.cookie = name + "=" + (value || "") + expires + "; path=/";
    // }

    // // Function to get a cookie value by name
    // function getCookie(name) {
    //     var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    //     if (match) return match[2];
    // }

    // // Get the current language code
    // var currentLanguage = document.documentElement.lang;
    // console.log(currentLanguage);

    // // Set the cookie for wmc_current_currency based on the current language
    // var currency = (currentLanguage === 'sv-SE') ? 'SEK' : 'EUR';
    // setCookie('wmc_current_currency', currency, 365);

    // // Update the URL parameter
    // var currentUrl = window.location.href;
    // var updatedUrl = currentUrl.replace(/(\?|&)wmc-currency=[A-Z]+/, '');
    // updatedUrl += (updatedUrl.includes('?') ? '&' : '?') + 'wmc-currency=' + currency;
    // window.history.replaceState({ path: updatedUrl }, '', updatedUrl);

    // Update the cookie for current language
    // setCookie('wmc_current_language', currentLanguage, 365);

    // Function to get the reseller ID from the browser's localStorage
    function getResellerId() {
        return localStorage.getItem('resellerId');
    }

    // Function to set the reseller ID in the browser's localStorage
    function setResellerId(resellerId) {
        localStorage.setItem('resellerId', resellerId);
    }

    // Function to check if the current page is a WooCommerce product single page
    function isWooCommerceProductSinglePage() {
        // Adjust the condition based on your actual WooCommerce product single page structure
        return jQuery('body').hasClass('single-product');
    }

    // Add a click event to the link with the reseller ID
    jQuery('.sock-product-link-reseller').on('click', function (e) {
        // Prevent the default behavior of the link

        // Get the reseller ID from the link's data attribute
        var resellerId = jQuery(this).data('reseller-id');

        // Set the reseller ID in localStorage
        setResellerId(resellerId);

    });
    // Check if the current page is a WooCommerce product single page
    if (isWooCommerceProductSinglePage()) {
        // Get the reseller ID from localStorage
        var resellerId = getResellerId();

        // Check if the resellerId exists
        if (resellerId) {
            // Update the URL without a page refresh
            var newUrl = updateQueryStringParameter(window.location.href, 'resellerid', resellerId);
            window.history.replaceState({ path: newUrl }, '', newUrl);
        }
    }

    // Function to update or add a query parameter to a URL
    function updateQueryStringParameter(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";

        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            return uri + separator + key + "=" + value;
        }
    }


})(jQuery);

//dashboard 
document.addEventListener('DOMContentLoaded', () => {
    const openSidebarButton = document.getElementById('open-sidebar');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    openSidebarButton.addEventListener('click', () => {
        // add class active on #sidebar
        sidebar.classList.add('active');
        // show sidebar overlay
        sidebarOverlay.classList.remove('d-none');
    });

    sidebarOverlay.addEventListener('click', () => {
        // add class active on #sidebar
        sidebar.classList.remove('active');
        // show sidebar overlay
        sidebarOverlay.classList.add('d-none');
    });
});