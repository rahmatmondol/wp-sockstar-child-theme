<?php
get_header();
// Check if the user is not logged in
if (!is_user_logged_in()) {
    // Display a message indicating that the user doesn't have access
?>
    <div class="container-fluid py-3">
        <?php include get_stylesheet_directory() . '/page-templates/forbiden.php'; ?>
    </div>
<?php
} else {

    function handle_image_upload($file_name, $file_temp)
    {
        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($file_temp);
        $filename = basename($file_name);
        $filetype = wp_check_filetype($file_name);
        $filename = time() . '.' . $filetype['ext'];

        if (wp_mkdir_p($upload_dir['path'])) {
            $file = $upload_dir['path'] . '/' . $filename;
        } else {
            $file = $upload_dir['basedir'] . '/' . $filename;
        }

        file_put_contents($file, $image_data);
        $wp_filetype = wp_check_filetype($filename, null);
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment($attachment, $file);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        wp_update_attachment_metadata($attach_id, $attach_data);
        return $attach_id;
    }
    $user_id = get_current_user_id();
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']) && wp_verify_nonce($_POST['_wpnonce'], 'socks-nonce')) {
        // Sanitize and save shop name and description to user meta
        $shop_name = sanitize_text_field($_POST['shop_name']);
        $shop_description = sanitize_text_field($_POST['shop_description']);
        $bgColorProfile = $_POST['bgColorProfile'];
        update_user_meta($user_id, 'shop_name', $shop_name);
        update_user_meta($user_id, 'shop_description', $shop_description);
        update_user_meta($user_id, 'bgColorProfile', $bgColorProfile);

        // Handle profile image upload
        if (isset($_FILES['shopprofileimg']['name']) && !empty($_FILES['shopprofileimg']['name'])) {
            $profile_image_id = handle_image_upload($_FILES['shopprofileimg']['name'], $_FILES['shopprofileimg']['tmp_name']);
            var_dump($profile_image_id);
            update_user_meta($user_id, 'shop_profile_image_id', $profile_image_id);
        } else {
            update_user_meta($user_id, 'shop_profile_image_id', $_POST['shopprofileimg']);
        }

        // Handle cover photo upload
        if (isset($_FILES['shopcoverphoto']['name']) && !empty($_FILES['shopcoverphoto']['name'])) {
            $cover_photo_id = handle_image_upload($_FILES['shopcoverphoto']['name'], $_FILES['shopcoverphoto']['tmp_name']);
            var_dump($cover_photo_id);
            update_user_meta($user_id, 'shop_cover_photo_id', $cover_photo_id);
        } else {
            update_user_meta($user_id, 'shop_cover_photo_id', $_POST['shopcoverphoto']);
        }
    }
    $user_meta_data = get_user_meta($user_id);
    $shop_name = $user_meta_data['shop_name'][0];
    $shop_description = $user_meta_data['shop_description'][0];
    $bgColorProfile = $user_meta_data['bgColorProfile'][0];
    $shop_profile_image_id = $user_meta_data['shop_profile_image_id'][0];
    $shop_profile_img_src = wp_get_attachment_image_url($shop_profile_image_id, 'full');
    $shop_cover_photo_id = $user_meta_data['shop_cover_photo_id'][0];
    $shop_cover_img_src = wp_get_attachment_image_url($shop_cover_photo_id, 'full');
?>

    <style>
        .profile-main {
            background-image: url('<?php echo !empty($shop_cover_img_src) ? $shop_cover_img_src : "https://imagizer.imageshack.com/img921/9628/VIaL8H.jpg"; ?>');
            background-color: <?php echo $bgColorProfile; ?>;
            height: 300px;
            width: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }


        .picture__input {
            display: none;
        }

        .picture {
            width: 320px;
            aspect-ratio: 16/9;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            border: 2px dashed currentcolor;
            cursor: pointer;
            font-family: sans-serif;
            transition: color 300ms ease-in-out, background 300ms ease-in-out;
            outline: none;
            overflow: hidden;
        }

        .picture:hover {
            color: #777;
            background: #ccc;
        }

        .picture:active {
            border-color: turquoise;
            color: turquoise;
            background: #eee;
        }

        .picture:focus {
            color: #777;
            background: #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .picture__img {
            max-width: 100%;
        }

        #u-name {
            left: 37% !important;
        }

        .user-dashboard #profile-pic {
            width: 250px;
            height: 250px;
        }
    </style>
    <div class="container-fluid user-dashboard">
        <div class="row">
            <?php include_once get_stylesheet_directory() . '/page-templates/dashboard-sidebar.php'; ?>
            <div class="col-md-9 col-lg-10 ml-md-auto">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-8 py-5">
                        <form method="post" action="" enctype="multipart/form-data">
                            <?php wp_nonce_field('socks-nonce', '_wpnonce'); ?>
                            <h3 class="text-center pb-5"><?php echo __('Our Shop', 'hello-elementor'); ?></h3>
                            <div class="mb-3">
                                <label for="shop_name" class="col-form-label text-center"><?php echo __('Shop Name', 'hello-elementor'); ?></label>
                                <input type="text" name="shop_name" class="form-control" value="<?php echo $shop_name; ?>" id="shop_name">
                                <p class="pt-2">Ex: <span class="fw-bold">Fotbollslaget IK</span></p>
                            </div>
                            <div class="mb-3 row">
                                <label for="text_color" class="col-sm-3 col-form-label fw-bold"><?php echo __('Choose a text color', 'hello-elementor'); ?></label>
                                <div class="col-sm-5">
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#000000')) ? 'color-active-selection' : ''; ?>" style="background-color: #000000" data-color="#000000"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#545454')) ? 'color-active-selection' : ''; ?>" style="background-color: #545454" data-color="#545454"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#A6A6A6')) ? 'color-active-selection' : ''; ?>" style="background-color: #A6A6A6" data-color="#A6A6A6"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#A6A6A6')) ? 'color-active-selection' : ''; ?>" style="background-color: #A6A6A6" data-color="#A6A6A6"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#D9D9D9')) ? 'color-active-selection' : ''; ?>" style="background-color: #D9D9D9" data-color="#D9D9D9"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#FFFFFF')) ? 'color-active-selection' : ''; ?>" style="background-color: #FFFFFF" data-color="#FFFFFF"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#FE3032')) ? 'color-active-selection' : ''; ?>" style="background-color: #FE3032" data-color="#FE3032"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#FF5757')) ? 'color-active-selection' : ''; ?>" style="background-color: #FF5757" data-color="#FF5757"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#FF65C3')) ? 'color-active-selection' : ''; ?>" style="background-color: #FF65C3" data-color="#FF65C3"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#CB6BE6')) ? 'color-active-selection' : ''; ?>" style="background-color: #CB6BE6" data-color="#CB6BE6"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#8B52FE')) ? 'color-active-selection' : ''; ?>" style="background-color: #8B52FE" data-color="#8B52FE"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#5E18EC')) ? 'color-active-selection' : ''; ?>" style="background-color: #5E18EC" data-color="#5E18EC"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#0197B2')) ? 'color-active-selection' : ''; ?>" style="background-color: #0197B2" data-color="#0197B2"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#08C1DF')) ? 'color-active-selection' : ''; ?>" style="background-color: #08C1DF" data-color="#08C1DF"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#5BE1E6')) ? 'color-active-selection' : ''; ?>" style="background-color: #5BE1E6" data-color="#5BE1E6"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#37B7FE')) ? 'color-active-selection' : ''; ?>" style="background-color: #37B7FE" data-color="#37B7FE"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#5271FF')) ? 'color-active-selection' : ''; ?>" style="background-color: #5271FF" data-color="#5271FF"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#004AAD')) ? 'color-active-selection' : ''; ?>" style="background-color: #004AAD" data-color="#004AAD"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#00BF63')) ? 'color-active-selection' : ''; ?>" style="background-color: #00BF63" data-color="#00BF63"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#7ED956')) ? 'color-active-selection' : ''; ?>" style="background-color: #7ED956" data-color="#7ED956"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#C1FF72')) ? 'color-active-selection' : ''; ?>" style="background-color: #C1FF72" data-color="#C1FF72"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#FFDE59')) ? 'color-active-selection' : ''; ?>" style="background-color: #FFDE59" data-color="#FFDE59"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#FEBC5B')) ? 'color-active-selection' : ''; ?>" style="background-color: #FEBC5B" data-color="#FEBC5B"></div>
                                    <div class="m-1 p-0 form-control form-control-color socks-profile-bg-color d-inline-block mb-2 <?php echo (isset($bgColorProfile) && !empty($bgColorProfile) && ($bgColorProfile == '#FF914C')) ? 'color-active-selection' : ''; ?>" style="background-color: #FF914C" data-color="#FF914C"></div>
                                </div>
                                <input type="hidden" name="bgColorProfile" id="bgColorProfile" value="<?php echo $bgColorProfile; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="shop_description" class="col-form-label fw-bold"><?php echo __('Describe your store and why you collect money for', 'hello-elementor'); ?></label>
                                <textarea type="text" name="shop_description" class="form-control" id="shop_description"><?php echo $shop_description; ?></textarea>
                                <p class="pt-2"><span class="fw-bold">Exempel på text:</span> Stöd vår resa till Gothia Cup och Liseberg genom att köpa våra strumpor! Varje bidrag är viktigt för att uppfylla vår dröm och ge vårt lag ett minne för livet. Tack för ert stöd och ert förtroende. Tillsammans erövrar vi Gothia Cup och utforskar Göteborg. Med vänliga hälsningar, Fotbollslaget IK.</p>
                            </div>
                            <h3 class="py-4 text-center fw-bold"><?php echo __('Använd ditt eget material', 'hello-elementor'); ?></h3>

                            <p class="text-center" style="margin-top:-1rem; margin-bottom: 2rem;"><?php echo __('För optimal bildkvalitet följ dessa riktlinjer:', 'hello-elementor'); ?></br>
                                <b><?php echo __('Profilbild:', 'hello-elementor'); ?></b> 500px X 500px
                                <b><?php echo __('Omslagsbild:', 'hello-elementor'); ?></b> 1000px X 300px
                            </p>

                            </p>
                            <div class="mb-3 row">
                                <div class="col-md-6 col-12 text-center">
                                    <label class="d-block pb-3"><?php echo __('Upload a Profile', 'hello-elementor'); ?></label>
                                    <label for="profile-photos-field" class="btn sock-primary-bg-color sock-primary-text-color px-5 py-2">
                                        <span class="text-white"><?php echo __('Upload', 'hello-elementor'); ?></span>
                                    </label>
                                    <input type="file" id="profile-photos-field" name="shopprofileimg" data-type="profile-photos" data-preview-id="profile-photos-preview" class="d-none sc-photo-preview">
                                    <div id="profile-photos-preview" class="pt-3"><img src="<?php echo  $shop_profile_img_src; ?>" alt=""></div>

                                </div>
                                <div class="col-md-6 col-12 text-center">
                                    <label class="d-block pb-3"><?php echo __('Upload Cover Photo', 'hello-elementor'); ?></label>
                                    <label for="cover-photos-field" class="btn sock-primary-bg-color sock-primary-text-color px-5 py-2">
                                        <span class="text-white"><?php echo __('Upload', 'hello-elementor'); ?></span>
                                    </label>
                                    <input type="file" id="cover-photos-field" name="shopcoverphoto" data-type="cover-photos" data-preview-id="cover-photos-preview" class="d-none sc-photo-preview">
                                    <div id="cover-photos-preview" class="pt-3"><img src="<?php echo $shop_cover_img_src; ?>" alt=""></div>
                                </div>
                            </div>
                            <h3 class="py-4 text-center fw-bold"><?php echo __('Använd vårt material', 'hello-elementor'); ?></h3>

                            <div class="mb-3 row">
                                <div class="col-md-6 col-12 text-center">
                                    <label class="d-block pb-3"><?php echo __('Upload a profile picture from our library', 'hello-elementor'); ?></label>
                                    <button type="button" data-type="profile-photos" class="sock-shop-profile-cover-choose btn sock-primary-bg-color sock-primary-text-color px-5 py-2 text-white"><?php echo __('Choose', 'hello-elementor'); ?></button>
                                    <div class="profile-photos-choose pt-5">

                                    </div>
                                </div>
                                <div class="col-md-6 col-12 text-center">
                                    <label class="d-block pb-3"><?php echo __('Upload a banner image from our library', 'hello-elementor'); ?></label>
                                    <button type="button" data-type="cover-photos" class="sock-shop-profile-cover-choose btn sock-primary-bg-color sock-primary-text-color px-5 py-2 text-white"><?php echo __('Choose', 'hello-elementor'); ?></button>
                                    <div class="cover-photos-choose pt-5">

                                    </div>

                                </div>

                            </div>
                            <hr>
                            <input type="hidden" name="shopprofileimg" id="shopprofileimg" class="picture__input profile-photos-img-select" onchange="handleFileChange(this, 'profileImage')" value="<?php echo $shop_profile_image_id; ?>">
                            <input type="hidden" name="shopcoverphoto" id="shopcoverphoto" class="picture__input cover-photos-img-select" onchange="handleFileChange(this, 'coverPhotoImage')" value="<?php echo $shop_cover_photo_id; ?>">

                            <div class="profile-main">
                                <div class="position-relative">
                                    <div id="profile-banner-image" class="position-relative overflow-hidden demo-profile-cover-photos">
                                        <img src="<?php echo !empty($shop_cover_img_src) ? $shop_cover_img_src : 'https://imagizer.imageshack.com/img921/9628/VIaL8H.jpg'; ?>" class="img-fluid">
                                    </div>
                                    <div id="profile-d" class="text-light">
                                        <div id="profile-pic" class="mb-3 demo-profile-profile-photos" style="width: 160px;height: 160px;position: absolute;bottom: 52px;">
                                            <img src="<?php echo !empty($shop_profile_img_src) ? $shop_profile_img_src : 'https://imagizer.imageshack.com/img921/3072/rqkhIb.jpg" class="img-fluid rounded-circle'; ?>" class="img-fluid">

                                        </div>
                                        <div id="u-name" style="color: <?php echo $bgColorProfile; ?>;" style="top: -5em;"><?php echo esc_html($shop_name); ?></div>
                                    </div>
                                </div>
                            </div>


                            <div class="text-center pt-5">
                                <h3><?php echo __('', 'hello-elementor'); ?></h3>
                                <p class="bw-profile-description"><?php echo $shop_description; ?></p>
                                <div class=" mt-3">
                                    <button type="submit" class="btn text-white sock-primary-bg-color px-4 py-2" name="submit"><?php echo __('Slutför', 'hello-elementor'); ?></button>
                                </div>

                            </div>
                            <div class="pt-5 text-center">
                                <h3 class="py-4"><?php echo __('Lycka till med försäljningen!', 'hello-elementor'); ?></h3>
                                <h3><?php echo __('Med vänlig hälsning', 'hello-elementor'); ?></h3>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sockstar-banner-logo.png" alt="">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
get_footer();
?>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // profile photo image preview
        document.querySelectorAll('.sc-photo-preview').forEach(function(input) {
            input.addEventListener('change', function(event) {
                const fileInput = event.target;
                const previewId = fileInput.getAttribute('data-preview-id');
                const previewContainer = document.getElementById(previewId);

                // Clear any previous previews
                previewContainer.innerHTML = '';

                // Get the file from the input
                const file = fileInput.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // Create an image element
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '100%'; // Optional: set max-width to fit container
                        img.style.height = 'auto'; // Optional: set height to auto

                        // Append the image to the preview container
                        previewContainer.appendChild(img);
                    };

                    // Read the file as a data URL (base64)
                    reader.readAsDataURL(file);
                }
            });
        });


        // profile photo image preview


        var elements = document.querySelectorAll('.socks-profile-bg-color');
        elements.forEach(function(element) {
            element.addEventListener('click', function() {
                // Remove 'color-active-selection' class from all elements
                elements.forEach(function(el) {
                    el.classList.remove('color-active-selection');
                });
                // Add 'color-active-selection' class to the clicked element
                this.classList.add('color-active-selection');

                // Get the value of the clicked input element
                var bgColor = element.getAttribute('data-color');
                // Assign the background color value to the hidden field
                var hiddenField = document.getElementById('bgColorProfile');
                hiddenField.value = bgColor;
                // Assign the background color value to the demo profile section
                var profileMainbg = document.querySelector('.profile-main');
                profileMainbg.style.backgroundColor = bgColor; // Set the background color to black
                var profileName = document.getElementById('u-name');
                profileName.style.color = bgColor; // Set the background color to black
            });
        });

        // Get the textarea element
        var textarea = document.getElementById('shop_description');

        // Get the textarea and the div where the content will be displayed
        var textarea = document.querySelector('textarea');
        var descriptionDiv = document.querySelector('.bw-profile-description');

        // Define the function to update the content
        function updateDescription() {
            descriptionDiv.textContent = textarea.value;
        }

        // Add event listeners for both the input and blur events
        textarea.addEventListener('input', updateDescription);
        textarea.addEventListener('blur', updateDescription);



        document.querySelectorAll('input[type=file]').forEach(function(input) {
            input.addEventListener('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-fluid');

                        var dataType = input.dataset.type;
                        var container = document.querySelector('.demo-profile-' + dataType);
                        container.innerHTML = ''; // Clear previous content
                        container.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        const handleFileChange = (inputFile, pictureImage) => {
            inputFile.addEventListener("change", function(e) {
                const inputTarget = e.target;
                const file = inputTarget.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.addEventListener("load", function(e) {
                        const readerTarget = e.target;

                        const img = document.createElement("img");
                        img.src = readerTarget.result;
                        img.classList.add("picture__img");

                        pictureImage.innerHTML = "";
                        pictureImage.appendChild(img);
                    });

                    reader.readAsDataURL(file);
                }
            });
        };

        const inputFile1 = document.querySelector("#shopprofileimg");
        const inputFile2 = document.querySelector("#shopcoverphoto");

        const pictureImage1 = document.querySelector("#profileImage");
        const pictureImage2 = document.querySelector("#coverPhotoImage");

        handleFileChange(inputFile1, pictureImage1);
        handleFileChange(inputFile2, pictureImage2);
    });
</script>