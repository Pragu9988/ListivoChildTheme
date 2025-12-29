<?php


add_action('wp_enqueue_scripts', static function () {
    $deps = [];

    if (class_exists(\Elementor\Plugin::class)) {
        $deps[] = 'elementor-frontend';
    }

    if (is_rtl()) {
        wp_enqueue_style('listivo-rtl', get_template_directory_uri().'/style-rtl.css', $deps, LISTIVO_VERSION);
        wp_enqueue_style('listivo-child', get_stylesheet_directory_uri().'/style.css',
            ['listivo-rtl'], LISTIVO_VERSION);
    } else {
        wp_enqueue_style('listivo', get_template_directory_uri().'/style.css', $deps, LISTIVO_VERSION);
        wp_enqueue_style('listivo-child', get_stylesheet_directory_uri().'/style.css',
            ['listivo'], LISTIVO_VERSION);
    }
});

include_once get_stylesheet_directory() . '/templates/wp-buyer-register.php';

add_action('after_setup_theme', static function () {
    load_child_theme_textdomain('listivo', get_stylesheet_directory().'/languages');
});

add_shortcode('wp_users_listivo_design', function () {
    ob_start();
    include get_stylesheet_directory() . '/templates/wp-users-template.php';
    return ob_get_clean();
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script(
        'wp-users-js',
        get_stylesheet_directory_uri() . '/assets/js/wp-users.js',
        ['jquery'],
        false,
        true
    );

    wp_enqueue_script(
        'auto-populate-postcode',
        get_stylesheet_directory_uri() . '/assets/js/auto-populate-postcode.js',
        ['jquery'],
        false,
        true
    );

    wp_localize_script(
        'auto-populate-postcode',
        'ajaxurl',
        admin_url('admin-ajax.php')
    );

    $agents_count = count(
        get_users([
            'meta_key'     => 'account_type',
            'meta_value'   => 'regular',
            'meta_compare' => '!=',
        ])
    );

    $businesses_count = count(
        get_users([
            'meta_key'     => 'account_type',
            'meta_value'   => 'business',
        ])
    );

    $stats = [
        'listings'        => wp_count_posts('listivo_listing')->publish,
        'users'           => count_users()['total_users'],
        'dailySearches'   => get_option('daily_searches', 0),
        'verifiedUsers'   => count(get_users(['meta_key' => 'verified', 'meta_value' => 1])),
        'newListingsToday' => count(get_posts([
            'post_type' => 'listivo_listing',
            'date_query' => [['after' => 'today']]
        ])),
        'agents' => $businesses_count,
        'businesses' => $businesses_count,
        'categories' => wp_count_terms(['taxonomy' => 'listivo_14']),
    ];

    wp_localize_script('wp-users-js', 'siteData', $stats);
});

add_action('user_register', function ($user_id) {

    $user = get_userdata($user_id);
    if (!$user) {
        return;
    }

    // Check if role contains 'listivo_user'
    if (in_array('listivo_user', (array) $user->roles)) {

        // Set job_title
        update_user_meta($user_id, 'job_title', 'Agent');
    }

});




// Add to your child theme's functions.php
function add_buyer_user_role() {
    add_role(
        'buyer',
        'Buyer',
        array(
            'read' => true,
            'edit_posts' => false,
            // Add capabilities as needed
        )
    );
}
add_action('init', 'add_buyer_user_role');

// Add "Featured" column to users table
add_filter('manage_users_columns', 'add_featured_user_column');

function add_featured_user_column($columns) {
    $columns['is_featured'] = __('Featured', 'listivo');
    return $columns;
}

// Display featured status in the column
add_filter('manage_users_custom_column', 'show_featured_user_column_content', 10, 3);

function show_featured_user_column_content($value, $column_name, $user_id) {
    if ($column_name == 'is_featured') {
        $is_featured = get_user_meta($user_id, 'listivo_is_featured_user', true);
        
        if ($is_featured == '1') {
            return '<span style="color: #46b450; font-weight: bold;">★ Featured</span>';
        } else {
            return '<span style="color: #ddd;">—</span>';
        }
    }
    return $value;
}

// Make the column sortable
add_filter('manage_users_sortable_columns', 'make_featured_column_sortable');

function make_featured_column_sortable($columns) {
    $columns['is_featured'] = 'is_featured';
    return $columns;
}

// Handle the sorting
add_action('pre_get_users', 'sort_users_by_featured');

function sort_users_by_featured($query) {
    if (!is_admin()) {
        return;
    }
    
    $orderby = $query->get('orderby');
    
    if ($orderby == 'is_featured') {
        $query->set('meta_key', 'listivo_is_featured_user');
        $query->set('orderby', 'meta_value');
    }
}

// Add quick toggle for featured status
add_filter('user_row_actions', 'add_featured_quick_toggle', 10, 2);

function add_featured_quick_toggle($actions, $user) {
    // Only for listivo_user role
    if (!in_array('listivo_user', (array) $user->roles)) {
        return $actions;
    }
    
    $is_featured = get_user_meta($user->ID, 'listivo_is_featured_user', true);
    $nonce = wp_create_nonce('toggle_featured_user_' . $user->ID);
    
    if ($is_featured == '1') {
        $actions['toggle_featured'] = sprintf(
            '<a href="%s" style="color: #d63638;">%s</a>',
            add_query_arg([
                'action' => 'toggle_featured_user',
                'user_id' => $user->ID,
                'nonce' => $nonce
            ], admin_url('users.php')),
            __('Remove Featured', 'listivo')
        );
    } else {
        $actions['toggle_featured'] = sprintf(
            '<a href="%s" style="color: #46b450;">%s</a>',
            add_query_arg([
                'action' => 'toggle_featured_user',
                'user_id' => $user->ID,
                'nonce' => $nonce
            ], admin_url('users.php')),
            __('Make Featured', 'listivo')
        );
    }
    
    return $actions;
}

// Handle the toggle action
add_action('admin_init', 'handle_featured_user_toggle');

function handle_featured_user_toggle() {
    if (!isset($_GET['action']) || $_GET['action'] != 'toggle_featured_user') {
        return;
    }
    
    if (!isset($_GET['user_id']) || !isset($_GET['nonce'])) {
        return;
    }
    
    $user_id = intval($_GET['user_id']);
    
    // Verify nonce
    if (!wp_verify_nonce($_GET['nonce'], 'toggle_featured_user_' . $user_id)) {
        wp_die(__('Security check failed', 'listivo'));
    }
    
    // Check permissions
    if (!current_user_can('edit_user', $user_id)) {
        wp_die(__('You do not have permission to do this', 'listivo'));
    }
    
    // Toggle featured status
    $is_featured = get_user_meta($user_id, 'listivo_is_featured_user', true);
    
    if ($is_featured == '1') {
        delete_user_meta($user_id, 'listivo_is_featured_user');
        $message = 'User removed from featured';
    } else {
        update_user_meta($user_id, 'listivo_is_featured_user', '1');
        $message = 'User marked as featured';
    }
    
    // Redirect back
    wp_redirect(add_query_arg('featured_updated', '1', admin_url('users.php')));
    exit;
}

// Show admin notice after toggle
add_action('admin_notices', 'featured_user_toggle_notice');

function featured_user_toggle_notice() {
    if (isset($_GET['featured_updated'])) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Featured status updated successfully!', 'listivo'); ?></p>
        </div>
        <?php
    }
}

// Add "Account Type" column to users table
add_filter('manage_users_columns', 'add_account_type_column');

function add_account_type_column($columns) {
    // Insert after Username or Name if possible, or just append
    $new_columns = [];
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'name') {
            $new_columns['account_type'] = __('Account Type', 'listivo');
        }
    }
    // Fallback if 'name' key not found
    if (!isset($new_columns['account_type'])) {
        $new_columns['account_type'] = __('Account Type', 'listivo');
    }
    return $new_columns;
}

// Display Account Type content
add_filter('manage_users_custom_column', 'show_account_type_column_content', 10, 3);

function show_account_type_column_content($value, $column_name, $user_id) {
    if ($column_name !== 'account_type') {
        return $value;
    }

    $user = get_userdata($user_id);

    // Safety check
    if (!$user || !in_array('listivo_user', (array) $user->roles, true)) {
        return '<span style="color: #ddd;">—</span>';
    }

    $account_type = get_user_meta($user_id, 'account_type', true);

    if ($account_type === 'business') {
        return __('Business Broker', 'listivo');
    } elseif ($account_type === 'regular') {
        return __('Business Owner', 'listivo');
    }

    return '<span style="color: #ddd;">—</span>';
}


// ============================================
// CUSTOM REGISTRATION FIELDS
// ============================================

// 1. Save fields on registration
add_action('user_register', 'listivo_save_custom_registration_fields');

function listivo_save_custom_registration_fields($user_id) {
    if (isset($_POST['agency_name'])) {
        update_user_meta($user_id, 'agency_name', sanitize_text_field($_POST['agency_name']));
    }
    if (isset($_POST['director_name'])) {
        update_user_meta($user_id, 'director_name', sanitize_text_field($_POST['director_name']));
    }
    if (isset($_POST['business_trading_name'])) {
        update_user_meta($user_id, 'business_trading_name', sanitize_text_field($_POST['business_trading_name']));
    }
    if (isset($_POST['address'])) {
        update_user_meta($user_id, 'address', sanitize_text_field($_POST['address']));
    }
    if (isset($_POST['website_url'])) {
        update_user_meta($user_id, 'website_url', esc_url_raw($_POST['website_url']));
    }
}

// 2. Display fields in Admin User Profile
add_action('show_user_profile', 'listivo_add_custom_profile_fields');
add_action('edit_user_profile', 'listivo_add_custom_profile_fields');

function listivo_add_custom_profile_fields($user) {
    // Only show for 'listivo_user' role (Agents/Business)
    if (!in_array('listivo_user', (array) $user->roles) && !current_user_can('manage_options')) {
        return;
    }

    $agency_name = get_user_meta($user->ID, 'agency_name', true);
    $director_name = get_user_meta($user->ID, 'director_name', true);
    $business_trading_name = get_user_meta($user->ID, 'business_trading_name', true);
    $address = get_user_meta($user->ID, 'address', true);
    $website_url = get_user_meta($user->ID, 'website_url', true);

    ?>
    <h3><?php _e('Business Information', 'listivo'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="agency_name"><?php _e('Agency Name', 'listivo'); ?></label></th>
            <td>
                <input type="text" name="agency_name" id="agency_name" value="<?php echo esc_attr($agency_name); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="director_name"><?php _e('Director Name', 'listivo'); ?></label></th>
            <td>
                <input type="text" name="director_name" id="director_name" value="<?php echo esc_attr($director_name); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="business_trading_name"><?php _e('Business Trading Name', 'listivo'); ?></label></th>
            <td>
                <input type="text" name="business_trading_name" id="business_trading_name" value="<?php echo esc_attr($business_trading_name); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="address"><?php _e('Address', 'listivo'); ?></label></th>
            <td>
                <input type="text" name="address" id="address" value="<?php echo esc_attr($address); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="website_url"><?php _e('Website', 'listivo'); ?></label></th>
            <td>
                <input type="url" name="website_url" id="website_url" value="<?php echo esc_attr($website_url); ?>" class="regular-text" />
                <p class="description"><?php _e('Full URL with http:// or https://', 'listivo'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

// 3. Save fields in Admin User Profile
add_action('personal_options_update', 'listivo_save_custom_profile_fields');
add_action('edit_user_profile_update', 'listivo_save_custom_profile_fields');

function listivo_save_custom_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    if (isset($_POST['agency_name'])) {
        update_user_meta($user_id, 'agency_name', sanitize_text_field($_POST['agency_name']));
    }
    if (isset($_POST['director_name'])) {
        update_user_meta($user_id, 'director_name', sanitize_text_field($_POST['director_name']));
    }
    if (isset($_POST['business_trading_name'])) {
        update_user_meta($user_id, 'business_trading_name', sanitize_text_field($_POST['business_trading_name']));
    }
    if (isset($_POST['address'])) {
        update_user_meta($user_id, 'address', sanitize_text_field($_POST['address']));
    }
    if (isset($_POST['website_url'])) {
        update_user_meta($user_id, 'website_url', esc_url_raw($_POST['website_url']));
    }
}


/**
 * Safely check if the current user has a specific role in Listivo / TangibleDesign themes
 *
 * @param string $role   Role to check (e.g. 'buyer', 'seller', 'administrator')
 * @param object|null $user Optional: pass a TDF user object. If null, uses current user.
 * @return bool
 */
function tdf_user_has_role(string $role, $user = null): bool
{
    // If no user passed, get current
    if (!$user) {
        $user = function_exists('tdf_current_user') ? tdf_current_user() : null;
    }

    // Not logged in or invalid user object → false
    if (!$user || !is_object($user)) {
        return false;
    }

    // Try direct access first (fastest, works in 98% of cases)
    if (isset($user->user) && $user->user instanceof WP_User && is_array($user->user->roles)) {
        return in_array($role, $user->user->roles, true);
    }

    // Fallback: use closure to access protected $user property
    $wpUser = null;
    try {
        $getWpUser = \Closure::bind(fn() => $this->user ?? null, $user, $user);
        $wpUser = $getWpUser();
    } catch (\Throwable $e) {
        // Silence any error — we have more fallbacks
    }

    // Final fallback: use user ID if available
    if (!$wpUser && method_exists($user, 'getId') && $user->getId()) {
        $wpUser = get_user_by('id', $user->getId());
    }

    // Final check
    return $wpUser && is_array($wpUser->roles ?? null) && in_array($role, $wpUser->roles, true);
}

function is_tdf_buyer($user = null): bool    { 
    return tdf_user_has_role('buyer', $user); 
}

add_action('wp_ajax_get_postcode_by_suburb_name', 'get_postcode_by_suburb_name');
add_action('wp_ajax_nopriv_get_postcode_by_suburb_name', 'get_postcode_by_suburb_name');

function get_postcode_by_suburb_name() {
    $suburb_name = sanitize_text_field($_POST['suburb_name'] ?? 0);

    if (!$suburb_name) {
        wp_send_json_error('Invalid suburb');
    }

    $term = get_term_by('name', $suburb_name, 'listivo_11337');

    if (!$term) {
        wp_send_json_error();
    }

    wp_send_json_success([
        'postcode' => get_term_meta($term->term_id, 'postcode', true)
    ]);
}

// add_filter('wp_count_terms', '__return_false');

add_filter('register_taxonomy_args', function ($args, $taxonomy) {
    if ($taxonomy === 'listivo_11337') {
        $args['show_ui'] = false;
        $args['show_in_menu'] = false;
        $args['show_admin_column'] = false;
    }
    return $args;
}, 10, 2);

add_action('admin_menu', function () {
    remove_submenu_page(
        'edit.php?post_type=listivo_listing',
        'edit-tags.php?taxonomy=listivo_11337&post_type=listivo_listing'
    );
}, 999);

add_action('admin_init', function () {
    remove_meta_box(
        'tagsdiv-listivo_11337',
        'listivo_listing',
        'side'
    );
});