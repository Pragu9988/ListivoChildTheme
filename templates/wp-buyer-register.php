<?php
// 1. Add this to your theme's functions.php or a custom plugin

function custom_buyer_registration_form() {
    
    // If user is already logged in, don't show the form
    if (is_user_logged_in()) {
        return '<p>' . esc_html__('You are already registered and logged in.', 'listivo') . '</p>';
    }

    $output = '<div class="listivo-login-widget">
    <div class="listivo-login-widget__form">
    <div class="listivo-login-form">
    <div class="listivo-login-form__inner">
    <div class="listivo-login-form__form listivo-login-form__form">';
    
    // Show success or error messages
    if (isset($_GET['registration'])) {
        if ($_GET['registration'] === 'success') {
            $output .= '<div class="listivo-notification listivo-notification--success" style="margin-bottom: 20px; padding: 15px; background: #dffff0; border-radius: 4px;">' . esc_html__('Thank you! Your account has been created.', 'listivo') . ' <a href="' . esc_url(wp_login_url()) . '">' . esc_html__('Click here to log in', 'listivo') . '</a>.</div>';
        } elseif ($_GET['registration'] === 'error') {
            $output .= '<div class="listivo-notification listivo-notification--error" style="margin-bottom: 20px; padding: 15px; background: #ffe6e6; border-radius: 4px; color: red;">' . esc_html__('Registration failed. Please try again or contact support.', 'listivo') . '</div>';
        }
    }

    $phone_country_codes = function_exists('tdf_app') ? tdf_app('phone_country_codes_with_flags') : [];
    if (empty($phone_country_codes)) {
        // Fallback if tdf_app is not available or empty
        $phone_country_codes = ['Australia (+61)' => '+61', 'Default' => ''];
    }

    $output .= '
    <form method="post" class="buyer-register-form">
        
        <!-- Username Field -->
        <div class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon">
            <div class="listivo-input-v2__icon listivo-icon-v2">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16" fill="none">
                    <path d="M7.27273 0C4.46875 0 2.18182 2.28693 2.18182 5.09091C2.18182 6.84375 3.0767 8.40057 4.43182 9.31818C1.83807 10.4318 0 13.0057 0 16H1.45455C1.45455 13.8977 2.56534 12.0682 4.22727 11.0455C4.71591 12.2443 5.90625 13.0909 7.27273 13.0909C8.6392 13.0909 9.82955 12.2443 10.3182 11.0455C11.9801 12.0682 13.0909 13.8977 13.0909 16H14.5455C14.5455 13.0057 12.7074 10.4318 10.1136 9.31818C11.4688 8.40057 12.3636 6.84375 12.3636 5.09091C12.3636 2.28693 10.0767 0 7.27273 0ZM7.27273 1.45455C9.28977 1.45455 10.9091 3.07386 10.9091 5.09091C10.9091 7.10796 9.28977 8.72727 7.27273 8.72727C5.25568 8.72727 3.63636 7.10796 3.63636 5.09091C3.63636 3.07386 5.25568 1.45455 7.27273 1.45455ZM7.27273 10.1818C7.86932 10.1818 8.4375 10.267 8.97727 10.4318C8.72443 11.1335 8.06534 11.6364 7.27273 11.6364C6.48011 11.6364 5.82102 11.1335 5.56818 10.4318C6.10796 10.267 6.67614 10.1818 7.27273 10.1818Z" fill="#FDFDFE"/>
                </svg>
            </div>
            <input type="text" name="buyer_username" id="buyer_username" required placeholder="' . esc_attr__('Username', 'listivo') . '*" value="' . (isset($_POST['buyer_username']) ? esc_attr($_POST['buyer_username']) : '') . '" />
        </div>

        <!-- First Name Field (Optional) -->
        <div class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon">
            <div class="listivo-input-v2__icon listivo-icon-v2">
                <i class="far fa-id-card"></i>
            </div>
            <input type="text" name="buyer_first_name" id="buyer_first_name" placeholder="' . esc_attr__('First Name', 'listivo') . '" value="' . (isset($_POST['buyer_first_name']) ? esc_attr($_POST['buyer_first_name']) : '') . '" />
        </div>

        <!-- Last Name Field (Optional) -->
        <div class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon">
            <div class="listivo-input-v2__icon listivo-icon-v2">
                <i class="far fa-id-card"></i>
            </div>
            <input type="text" name="buyer_last_name" id="buyer_last_name" placeholder="' . esc_attr__('Last Name', 'listivo') . '" value="' . (isset($_POST['buyer_last_name']) ? esc_attr($_POST['buyer_last_name']) : '') . '" />
        </div>

        <!-- Email Field -->
        <div class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon">
            <div class="listivo-input-v2__icon listivo-icon-v2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 3.58883 3.58883 0 8 0C12.4112 0 16 3.58883 16 8C16 12.4112 12.4112 16 8 16C3.58883 16 0 12.4112 0 8ZM14.7992 8C14.7992 4.23736 11.7619 1.2 7.99922 1.2C4.23657 1.2 1.19922 4.23736 1.19922 8C1.19922 11.7626 4.23657 14.8 7.99922 14.8C11.7619 14.8 14.7992 11.7626 14.7992 8ZM8.00039 2.4C4.91457 2.4 2.40039 4.91418 2.40039 8C2.40039 11.0858 4.91457 13.6 8.00039 13.6C8.69124 13.6 9.3557 13.4746 9.96836 13.2445C10.1715 13.1709 10.3194 12.9938 10.3556 12.7808C10.3918 12.5678 10.3106 12.3518 10.1432 12.2153C9.97576 12.0788 9.74784 12.0428 9.54648 12.1211C9.06635 12.3014 8.54634 12.4 8.00039 12.4C5.56301 12.4 3.60039 10.4374 3.60039 8C3.60039 5.56262 5.56301 3.6 8.00039 3.6C10.4378 3.6 12.4004 5.56262 12.4004 8V8.6C12.4004 9.15929 11.9597 9.6 11.4004 9.6C10.8411 9.6 10.4004 9.15929 10.4004 8.6V5.8C10.4028 5.49492 10.1759 5.23659 9.87308 5.19961C9.57025 5.16263 9.28786 5.35877 9.2168 5.65547C8.81185 5.36971 8.32747 5.2 7.80039 5.2C6.33967 5.2 5.20039 6.49099 5.20039 8C5.20039 9.50901 6.33967 10.8 7.80039 10.8C8.54069 10.8 9.1973 10.4673 9.66602 9.94375C10.0698 10.4624 10.6977 10.8 11.4004 10.8C12.6083 10.8 13.6004 9.80791 13.6004 8.6V8C13.6004 4.91418 11.0862 2.4 8.00039 2.4ZM9.20039 8C9.20039 7.08261 8.54527 6.4 7.80039 6.4C7.05552 6.4 6.40039 7.08261 6.40039 8C6.40039 8.91739 7.05552 9.6 7.80039 9.6C8.54527 9.6 9.20039 8.91739 9.20039 8Z" fill="#FDFDFE"/>
                </svg>
            </div>
            <input type="email" name="buyer_email" id="buyer_email" required placeholder="' . esc_attr__('Email Address', 'listivo') . '*" value="' . (isset($_POST['buyer_email']) ? esc_attr($_POST['buyer_email']) : '') . '" />
        </div>

        <!-- Phone Number Field (Required) -->
        <div class="listivo-login-form__field listivo-login-form__field--advanced-phone">
            <label for="listivo-phone-with-country-code">
                <div class="listivo-phone-with-country-code">
                    <div class="listivo-phone-with-country-code__icon listivo-icon-v2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                            <path d="M1.8 0C0.813 0 0 0.813 0 1.8V14.2C0 15.187 0.813 16 1.8 16H7.8C8.787 16 9.6 15.187 9.6 14.2V1.8C9.6 0.813 8.787 0 7.8 0H1.8ZM1.8 1.2H7.8C8.1386 1.2 8.4 1.4614 8.4 1.8V14.2C8.4 14.5386 8.1386 14.8 7.8 14.8H1.8C1.4614 14.8 1.2 14.5386 1.2 14.2V1.8C1.2 1.4614 1.4614 1.2 1.8 1.2ZM4.8 2.4C4.64087 2.4 4.48826 2.46321 4.37574 2.57574C4.26321 2.68826 4.2 2.84087 4.2 3C4.2 3.15913 4.26321 3.31174 4.37574 3.42426C4.48826 3.53679 4.64087 3.6 4.8 3.6C4.95913 3.6 5.11174 3.53679 5.22426 3.42426C5.33679 3.31174 5.4 3.15913 5.4 3C5.4 2.84087 5.33679 2.68826 5.22426 2.57574C5.11174 2.46321 4.95913 2.4 4.8 2.4ZM3.8 12.4C3.72049 12.3989 3.64156 12.4136 3.56777 12.4432C3.49399 12.4729 3.42684 12.5169 3.37022 12.5727C3.3136 12.6285 3.26864 12.6951 3.23795 12.7684C3.20726 12.8418 3.19145 12.9205 3.19145 13C3.19145 13.0795 3.20726 13.1582 3.23795 13.2316C3.26864 13.3049 3.3136 13.3715 3.37022 13.4273C3.42684 13.4831 3.49399 13.5271 3.56777 13.5568C3.64156 13.5864 3.72049 13.6011 3.8 13.6H5.8C5.87951 13.6011 5.95845 13.5864 6.03223 13.5568C6.10601 13.5271 6.17316 13.4831 6.22978 13.4273C6.2864 13.3715 6.33137 13.3049 6.36205 13.2316C6.39274 13.1582 6.40855 13.0795 6.40855 13C6.40855 12.9205 6.39274 12.8418 6.36205 12.7684C6.33137 12.6951 6.2864 12.6285 6.22978 12.5727C6.17316 12.5169 6.10601 12.4729 6.03223 12.4432C5.95845 12.4136 5.87951 12.3989 5.8 12.4H3.8Z" fill="#FDFDFE"/>
                        </svg>
                    </div>

                    <select name="buyer_phone_code" style="max-width: 80px;">';
                        foreach ($phone_country_codes as $text => $code) {
                            $selected = '';
                            if (isset($_POST['buyer_phone_code'])) {
                                if ($_POST['buyer_phone_code'] === $text) {
                                    $selected = 'selected';
                                }
                            } else {
                                // Default to Australia if no post data
                                // Using relaxed check for "Australia"
                                if (stripos($text, '&#x1F1E6&#x1F1FA') !== false) {
                                    $selected = 'selected';
                                }
                            }
                            $output .= '<option value="' . esc_attr($text) . '" ' . $selected . '>' . $text . '</option>';
                        }
    $output .= '    </select>

                    <input 
                        type="tel" 
                        name="buyer_phone" 
                        id="buyer_phone" 
                        required 
                        placeholder="' . esc_attr__('Phone', 'listivo') . '*" 
                        value="' . (isset($_POST['buyer_phone']) ? esc_attr($_POST['buyer_phone']) : '') . '" 
                        maxlength="10" 
                        pattern="[0-9]*" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, \'\').substring(0, 10);"
                    />
                </div>
            </label>
        </div>

        <!-- Password Field -->
        <div class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon">
            <div class="listivo-input-v2__icon listivo-icon-v2">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="16" viewBox="0 0 13 16" fill="none">
                    <path d="M6.09524 0C3.56281 0 1.52381 2.039 1.52381 4.57143V5.33333C0.691 5.33333 0 6.02433 0 6.85714V14.4762C0 15.309 0.691 16 1.52381 16H10.6667C11.4995 16 12.1905 15.309 12.1905 14.4762V6.85714C12.1905 6.02433 11.4995 5.33333 10.6667 5.33333V4.57143C10.6667 2.039 8.62766 0 6.09524 0ZM6.09524 1.52381C7.82948 1.52381 9.14286 2.83719 9.14286 4.57143V5.33333H3.04762V4.57143C3.04762 2.83719 4.361 1.52381 6.09524 1.52381ZM1.52381 6.85714H10.6667V14.4762H1.52381V6.85714ZM6.09524 9.14286C5.25714 9.14286 4.57143 9.82857 4.57143 10.6667C4.57143 11.5048 5.25714 12.1905 6.09524 12.1905C6.93333 12.1905 7.61905 11.5048 7.61905 10.6667C7.61905 9.82857 6.93333 9.14286 6.09524 9.14286Z" fill="#FDFDFE"/>
                </svg>
            </div>
            <input type="password" name="buyer_password" id="buyer_password" required placeholder="' . esc_attr__('Password', 'listivo') . '*" />
        </div>

        <!-- Confirm Password Field -->
        <div class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon">
            <div class="listivo-input-v2__icon listivo-icon-v2">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="16" viewBox="0 0 13 16" fill="none">
                    <path d="M6.09524 0C3.56281 0 1.52381 2.039 1.52381 4.57143V5.33333C0.691 5.33333 0 6.02433 0 6.85714V14.4762C0 15.309 0.691 16 1.52381 16H10.6667C11.4995 16 12.1905 15.309 12.1905 14.4762V6.85714C12.1905 6.02433 11.4995 5.33333 10.6667 5.33333V4.57143C10.6667 2.039 8.62766 0 6.09524 0ZM6.09524 1.52381C7.82948 1.52381 9.14286 2.83719 9.14286 4.57143V5.33333H3.04762V4.57143C3.04762 2.83719 4.361 1.52381 6.09524 1.52381ZM1.52381 6.85714H10.6667V14.4762H1.52381V6.85714ZM6.09524 9.14286C5.25714 9.14286 4.57143 9.82857 4.57143 10.6667C4.57143 11.5048 5.25714 12.1905 6.09524 12.1905C6.93333 12.1905 7.61905 11.5048 7.61905 10.6667C7.61905 9.82857 6.93333 9.14286 6.09524 9.14286Z" fill="#FDFDFE"/>
                </svg>
            </div>
            <input type="password" name="buyer_password_confirm" id="buyer_password_confirm" required placeholder="' . esc_attr__('Confirm Password', 'listivo') . '*" />
        </div>

        <div class="listivo-login-form__actions" style="margin-top: 20px;">
            <input type="hidden" name="buyer_register_nonce" value="' . wp_create_nonce("buyer_register_action") . '" />
        </div>
        <div class="listivo-login-form__button">
            <button type="submit" name="buyer_register_submit" class="listivo-simple-button listivo-simple-button--background-primary-1 listivo-button-primary-1-selector listivo-simple-button--full-width listivo-simple-button--height-60">
                <span>' . esc_html__('Register as Buyer', 'listivo') . '</span>
            </button>
        </div>
        
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>';

    return $output;
}

// Handle form submission
function handle_buyer_registration() {
    if (
        isset($_POST["buyer_register_submit"]) &&
        isset($_POST["buyer_register_nonce"]) &&
        wp_verify_nonce($_POST["buyer_register_nonce"], "buyer_register_action")
    ) {

        $username = sanitize_user($_POST["buyer_username"]);
        $email    = sanitize_email($_POST["buyer_email"]);
        $first_name = sanitize_text_field($_POST["buyer_first_name"]);
        $last_name  = sanitize_text_field($_POST["buyer_last_name"]);
        $phone_code = sanitize_text_field($_POST["buyer_phone_code"]);
        $phone      = sanitize_text_field($_POST["buyer_phone"]);
        $password = $_POST["buyer_password"];
        $password_confirm = $_POST["buyer_password_confirm"];

        // Basic validation
        $errors = [];

        if (empty($username)) $errors[] = "Username is required.";
        if (username_exists($username)) $errors[] = "Username already exists.";
        if (!validate_username($username)) $errors[] = "Invalid username.";
        if (empty($email) || !is_email($email)) $errors[] = "Valid email is required.";
        if (email_exists($email)) $errors[] = "Email is already registered.";
        if (empty($phone)) {
            $errors[] = "Phone number is required.";
        } else {
            // Remove non-numeric characters for check to be safe
            $numeric_phone = preg_replace('/[^0-9]/', '', $phone);
            if (!is_numeric($numeric_phone) || strlen($numeric_phone) > 10) {
                $errors[] = "Phone number must be digits only and maximum 10 digits.";
            }
        }
        if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
        if ($password !== $password_confirm) $errors[] = "Passwords do not match.";

        if (!empty($errors)) {
            wp_redirect(add_query_arg("registration", "error", $_SERVER["REQUEST_URI"]));
            exit;
        }

        // Create the user
        $user_id = wp_create_user($username, $password, $email);

        if (is_wp_error($user_id)) {
            wp_redirect(add_query_arg("registration", "error", $_SERVER["REQUEST_URI"]));
            exit;
        }

        // Update User Meta
        if (!empty($first_name)) {
            update_user_meta($user_id, 'first_name', $first_name);
        }
        if (!empty($last_name)) {
            update_user_meta($user_id, 'last_name', $last_name);
        }
        if (!empty($phone)) {
            // Save phone.
            update_user_meta($user_id, 'phone', $phone);
        }

        // Assign "buyer" role
        $user = new WP_User($user_id);
        $user->remove_role("subscriber"); // remove default role
        $user->add_role("buyer");         // add your custom buyer role

        // Optional: Auto login after registration
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        wp_redirect(home_url()); // or wp_redirect(wp_login_url());
        exit;

        // Success redirect
        wp_redirect(add_query_arg("registration", "success", $_SERVER["REQUEST_URI"]));
        exit;
    }
}
add_action("init", "handle_buyer_registration");

// Register shortcode so you can use [buyer_register_form] on any page
add_shortcode("buyer_register_form", "custom_buyer_registration_form");