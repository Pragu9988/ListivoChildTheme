<?php
// 1. Add this to your theme's functions.php or a custom plugin

function custom_buyer_registration_form() {
    
    // If user is already logged in, don't show the form
    if (is_user_logged_in()) {
        return '<p>You are already registered and logged in.</p>';
    }

    $output = '<div class="buyer-registration-form">';
    
    // Show success or error messages
    if (isset($_GET['registration']) && $_GET['registration'] === 'success') {
        $output .= '<p class="success">Thank you! Your account has been created. <a href="' . wp_login_url() . '">Click here to log in</a>.</p>';
    }

    if (isset($_GET['registration']) && $_GET['registration'] === 'error') {
        $output .= '<p class="error">Registration failed. Please try again or contact support.</p>';
    }

    $output .= '
    <form method="post" class="buyer-register-form">
        <p>
            <label for="buyer_username">Username <span class="required">*</span></label>
            <input type="text" name="buyer_username" id="buyer_username" required 
                   value="' . (isset($_POST['buyer_username']) ? esc_attr($_POST['buyer_username']) : '') . '" />
        </p>

        <p>
            <label for="buyer_email">Email Address <span class="required">*</span></label>
            <input type="email" name="buyer_email" id="buyer_email" required 
                   value="' . (isset($_POST['buyer_email']) ? esc_attr($_POST['buyer_email']) : '') . '" />
        </p>

        <p>
            <label for="buyer_password">Password <span class="required">*</span></label>
            <input type="password" name="buyer_password" id="buyer_password" required />
        </p>

        <p>
            <label for="buyer_password_confirm">Confirm Password <span class="required">*</span></label>
            <input type="password" name="buyer_password_confirm" id="buyer_password_confirm" required />
        </p>

        <p>
            <input type="hidden" name="buyer_register_nonce" value="' . wp_create_nonce('buyer_register_action') . '" />
            <button type="submit" name="buyer_register_submit">Register as Buyer</button>
        </p>
    </form>
    </div>';

    // Add some basic styling
    $output .= '
    <style>
        .buyer-registration-form { max-width: 400px; margin: 40px auto; padding: 20px; font-family: Arial, sans-serif; }
        .buyer-registration-form label { display: block; margin: 15px 0 5px; font-weight: bold; }
        .buyer-registration-form input[type="text"],
        .buyer-registration-form input[type="email"],
        .buyer-registration-form input[type="password"] {
            width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;
        }
        .buyer-registration-form button {
            background: #2271b1; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin-top: 10px;
        }
        .buyer-registration-form button:hover { background: #135e96; }
        .buyer-registration-form .success { color: green; background: #dffff0; padding: 15px; border-radius: 4px; }
        .buyer-registration-form .error { color: red; background: #ffe6e6; padding: 15px; border-radius: 4px; }
        .required { color: red; }
    </style>';

    return $output;
}

// Handle form submission
function handle_buyer_registration() {
    if (
        isset($_POST['buyer_register_submit']) &&
        isset($_POST['buyer_register_nonce']) &&
        wp_verify_nonce($_POST['buyer_register_nonce'], 'buyer_register_action')
    ) {

        $username = sanitize_user($_POST['buyer_username']);
        $email    = sanitize_email($_POST['buyer_email']);
        $password = $_POST['buyer_password'];
        $password_confirm = $_POST['buyer_password_confirm'];

        // Basic validation
        $errors = [];

        if (empty($username)) $errors[] = 'Username is required.';
        if (username_exists($username)) $errors[] = 'Username already exists.';
        if (!validate_username($username)) $errors[] = 'Invalid username.';
        if (empty($email) || !is_email($email)) $errors[] = 'Valid email is required.';
        if (email_exists($email)) $errors[] = 'Email is already registered.';
        if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
        if ($password !== $password_confirm) $errors[] = 'Passwords do not match.';

        if (!empty($errors)) {
            wp_redirect(add_query_arg('registration', 'error', $_SERVER['REQUEST_URI']));
            exit;
        }

        // Create the user
        $user_id = wp_create_user($username, $password, $email);

        if (is_wp_error($user_id)) {
            wp_redirect(add_query_arg('registration', 'error', $_SERVER['REQUEST_URI']));
            exit;
        }

        // Assign "buyer" role
        $user = new WP_User($user_id);
        $user->remove_role('subscriber'); // remove default role
        $user->add_role('buyer');         // add your custom buyer role

        // Optional: Auto login after registration
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        wp_redirect(home_url()); // or wp_redirect(wp_login_url());
        exit;

        // Success redirect
        wp_redirect(add_query_arg('registration', 'success', $_SERVER['REQUEST_URI']));
        exit;
    }
}
add_action('init', 'handle_buyer_registration');

// Register shortcode so you can use [buyer_register_form] on any page
add_shortcode('buyer_register_form', 'custom_buyer_registration_form');