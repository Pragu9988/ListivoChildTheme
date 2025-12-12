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

    $agents_count = count(
        get_users([
            'meta_key'     => 'account_type',
            'meta_value'   => 'private',
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

// Add buyer option to user profile
add_action('show_user_profile', 'add_buyer_field');
add_action('edit_user_profile', 'add_buyer_field');

function add_buyer_field($user) {
    $is_buyer = get_user_meta($user->ID, 'is_buyer', true);
    ?>
    <h3>Account Type</h3>
    <table class="form-table">
        <tr>
            <th><label for="is_buyer">Is Buyer</label></th>
            <td>
                <input type="checkbox" name="is_buyer" id="is_buyer" value="1" <?php checked($is_buyer, '1'); ?> />
            </td>
        </tr>
    </table>
    <?php
}

// Save the buyer field
add_action('personal_options_update', 'save_buyer_field');
add_action('edit_user_profile_update', 'save_buyer_field');

function save_buyer_field($user_id) {
    if (current_user_can('edit_user', $user_id)) {
        update_user_meta($user_id, 'is_buyer', isset($_POST['is_buyer']) ? '1' : '0');
    }
}

// ============================================
// FEATURED USER FUNCTIONALITY FOR LISTIVO
// ============================================

// 1. Add checkbox to user profile
add_action('show_user_profile', 'listivo_add_featured_user_field');
add_action('edit_user_profile', 'listivo_add_featured_user_field');

function listivo_add_featured_user_field($user) {
    if (!in_array('listivo_user', (array) $user->roles)) {
        return;
    }
    
    $is_featured = get_user_meta($user->ID, 'listivo_is_featured_user', true);
    ?>
    <h3><?php _e('Featured User Settings', 'listivo'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="listivo_is_featured_user"><?php _e('Is Featured User', 'listivo'); ?></label></th>
            <td>
                <input type="checkbox" 
                       name="listivo_is_featured_user" 
                       id="listivo_is_featured_user" 
                       value="1" 
                       <?php checked($is_featured, '1'); ?> />
                <p class="description">
                    <?php _e('Mark this user as featured. Featured users will appear prominently on the site.', 'listivo'); ?>
                </p>
            </td>
        </tr>
    </table>
    <?php
}

// 2. Save the checkbox
add_action('personal_options_update', 'listivo_save_featured_user_field');
add_action('edit_user_profile_update', 'listivo_save_featured_user_field');

function listivo_save_featured_user_field($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    
    if (isset($_POST['listivo_is_featured_user'])) {
        update_user_meta($user_id, 'listivo_is_featured_user', '1');
    } else {
        delete_user_meta($user_id, 'listivo_is_featured_user');
    }
}


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

