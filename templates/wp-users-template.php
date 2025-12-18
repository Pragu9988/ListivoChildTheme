<?php

/** SETTINGS */
$per_page = 12;
$page = isset($_GET['lp']) ? absint($_GET['lp']) : 1;
$search = isset($_GET['keyword']) ? sanitize_text_field($_GET['keyword']) : '';
$location = isset($_GET['location']) ? sanitize_text_field($_GET['location']) : '';
$user_type = isset($_GET['user_type']) ? sanitize_text_field($_GET['user_type']) : '';
$orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'relevant';

$args = [
    'number'  => $per_page,
    'offset'  => ($page - 1) * $per_page,
    'role__in' => ['listivo_user'], // customize
    'meta_query' => [
        'relation' => 'OR',
        [
            'key'     => 'account_type',
            'value'   => 'business',
            'compare' => '='
        ],
        // [
        //     'key'     => 'account_type',
        //     'value'   => 'regular',
        //     'compare' => '='
        // ],
    ],
];

// Search Logic
if ($search) {
    $args['search'] = '*' . esc_attr($search) . '*';
    $args['search_columns'] = ['user_login', 'user_nicename', 'display_name'];
}

// Location Filter
if ($location) {
    $args['meta_query'][] = [
        'key'     => 'location', // Assuming meta key is 'location'
        'value'   => $location,
        'compare' => 'LIKE'
    ];
}

// User Type Filter
// if ($user_type) {
//     $args['meta_query'][] = [
//         'key'     => 'account_type', // Assuming meta key is 'user_type'
//         'value'   => $user_type,
//         'compare' => '='
//     ];
// }

// Order By Logic
switch ($orderby) {
    case 'newest':
        $args['orderby'] = 'registered';
        $args['order'] = 'DESC';
        break;
    case 'oldest':
        $args['orderby'] = 'registered';
        $args['order'] = 'ASC';
        break;
    case 'name_asc':
        $args['orderby'] = 'display_name';
        $args['order'] = 'ASC';
        break;
    case 'name_desc':
        $args['orderby'] = 'display_name';
        $args['order'] = 'DESC';
        break;
    case 'relevant':
        $args['listivo_sort_relevant'] = true;
        break;
    default:
        $args['orderby'] = 'registered';
        $args['order'] = 'DESC';
        break;
}

// Hook for custom sorting: Featured First, then Listing Count
if (isset($args['listivo_sort_relevant']) && $args['listivo_sort_relevant']) {
    $custom_sort_action = function ($query) {
        if (isset($query->query_vars['listivo_sort_relevant']) && $query->query_vars['listivo_sort_relevant']) {
            global $wpdb;
            // Order by featured meta (assuming '1' is true) DESC, then by standard post count logic
            // Note: Counting posts in subquery can be expensive on large DBs, but standard for this requirement without caching.
            $query->query_orderby = "ORDER BY 
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = {$wpdb->users}.ID AND meta_key = 'listivo_is_featured_user' LIMIT 1) DESC,
            (SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_author = {$wpdb->users}.ID AND post_type = 'listivo_listing' AND post_status = 'publish') DESC";
        }
    };
    add_action('pre_user_query', $custom_sort_action);
}

$wp_users = get_users($args);

// Remove hook immediately
if (isset($custom_sort_action)) {
    remove_action('pre_user_query', $custom_sort_action);
}
$total_users = count_users()['total_users']; // Note: This counts ALL users, might need adjustment if filtering logic is complex but for now it's standard WP behavior to count all or use a separate query for filtered count.
// For accurate pagination with filters, we actually need to count the filtered results.
// get_users doesn't return total count easily without SQL_CALC_FOUND_ROWS or a separate count query.
// For this task, I'll stick to the existing pattern but be aware pagination might be off if not counting filtered.
// Let's do a quick count query for better pagination if filters are active.
if ($search || $location || $user_type) {
    $count_args = $args;
    unset($count_args['number']);
    unset($count_args['offset']);
    $count_query = new WP_User_Query($count_args);
    $total_users = $count_query->get_total();
} else {
    // If we are just filtering by role 'listivo_user', we should count only those.
    $count_args = [
        'role__in' => ['listivo_user'],
    ];
    $count_query = new WP_User_Query($count_args);
    $total_users = $count_query->get_total();
}

?>

<style>
    .listivo-users-filter-bar {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .listivo-users-filter-item {
        flex: 1;
        min-width: 150px;
    }

    .listivo-users-filter-item label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        font-size: 14px;
        color: #333;
    }

    .listivo-users-filter-item input,
    .listivo-users-filter-item select {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        font-size: 14px;
        color: #555;
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }

    .listivo-users-filter-item input:focus,
    .listivo-users-filter-item select:focus {
        border-color: var(--e-global-color-lprimary1);
        /* Listivo primary color approx */
        background-color: #fff;
        outline: none;
    }

    /* View Toggle */
    .listivo-view-toggle {
        display: flex;
        gap: 5px;
        align-items: flex-end;
        height: 100%;
        padding-top: 24px;
        /* Align with inputs */
    }

    .listivo-view-btn {
        background: #f9f9f9;
        border: 1px solid #e0e0e0;
        padding: 10px;
        border-radius: 4px;
        cursor: pointer;
        color: #777;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
    }

    .listivo-view-btn.active,
    .listivo-view-btn:hover {
        background: var(--e-global-color-lprimary1);
        color: #fff;
        border-color: var(--e-global-color-lprimary1);
    }

    .listivo-view-btn svg {
        fill: currentColor;
        width: 18px;
        height: 18px;
    }

    /* User Card Styles */
    .listivo-user-card-meta {
        margin-top: 10px;
        font-size: 13px;
        color: #777;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .listivo-user-card-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .listivo-user-card-meta-icon {
        width: 14px;
        text-align: center;
        color: var(--e-global-color-lprimary1);
    }

    .listivo-user-bio {
        margin-top: 10px;
        font-size: 13px;
        color: #555;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Phone Reveal Styles */
    .listivo-user-phone-reveal {
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        color: #333;
        font-weight: 600;
    }

    .listivo-user-phone-reveal:hover {
        color: var(--e-global-color-lprimary1);
    }

    .listivo-phone-eye-icon {
        width: 16px;
        height: 16px;
        fill: currentColor;
        cursor: pointer;
    }

    /* Grid View Image Consistency */
    .listivo-user-profiles:not(.list-view) .listivo-single-user-profile__image img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    /* List View Styles */
    .listivo-user-profiles.list-view {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .listivo-user-profiles.list-view .listivo-single-user-profile {
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: stretch;
        /* Align top */
        padding: 0;
        overflow: hidden;
        text-align: left;
    }

    .listivo-user-profiles.list-view .listivo-single-user-profile__image {
        width: 250px;
        min-width: 250px;
        height: auto;
        margin: 0;
        border-radius: 0;
    }

    .listivo-user-profiles.list-view .listivo-single-user-profile__image img {
        height: 100%;
        object-fit: cover;
        min-height: 200px;
        /* Ensure height in list view */
    }

    .listivo-user-profiles.list-view .listivo-single-user-profile__content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        border: none !important;
    }

    .listivo-user-profiles.list-view .listivo-single-user-profile__label {
        margin-top: 0;
        font-size: 20px;
    }

    .listivo-user-profiles.list-view .listivo-single-user-profile__socials {
        margin-top: 15px;
        justify-content: flex-start;
    }

    .listivo-user-profiles.list-view .listivo-user-bio {
        -webkit-line-clamp: 3;
        /* Show more lines in list view */
    }

    /* Remove Social Animation in List View */
    .listivo-user-profiles.list-view .listivo-social-icon {
        transform: none !important;
        transition: none !important;
    }

    .listivo-user-profiles.list-view .listivo-social-icon:hover {
        transform: none !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .listivo-user-profiles.list-view .listivo-single-user-profile {
            flex-direction: column;
        }

        .listivo-user-profiles.list-view .listivo-single-user-profile__image {
            width: 100%;
            min-width: 100%;
            height: auto;
        }

        .listivo-user-profiles.list-view .listivo-single-user-profile__image img {
            height: auto;
            aspect-ratio: 16/9;
        }

        /* Filter Bar Responsive */
        .listivo-users-filter-bar {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }

        .listivo-users-filter-item {
            min-width: 100%;
        }

        .listivo-view-toggle {
            padding-top: 0;
            justify-content: flex-end;
            width: 100%;
        }
    }

    .listivo-single-user-profile--icons-smaller:hover .listivo-single-user-profile__socials {
        animation: none;
    }

    .listivo-single-user-profile__socials {
        height: auto;
        opacity: 1;
    }

    .listivo-single-user-profile--icons-smaller:hover .listivo-single-user-profile__content {
        margin-top: 0;
    }

    .listivo-single-user-profile__socials {
        margin-top: 20px;
    }

    .list-view .listivo-single-user-profile__content {
        border-top: 1px solid var(--e-global-color-lcolor4);
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .listivo-single-user-profile__content {
        border-top: 1px solid var(--e-global-color-lcolor4);
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        padding: var(--e-global-size-6);
        background-color: transparent;
    }

    /* Featured User Highlight */
    .listivo-single-user-profile {
        position: relative; /* Ensure badge positioning */
        transition: all 0.3s ease;
    }

    .listivo-single-user-profile.listivo-featured-user {
        border: 2px solid var(--e-global-color-lprimary2); /* Yellow highlight */
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.15);
        border-radius: 8px;
        background: #FFFCF4;
    }

    .listivo-top-broker-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: var(--e-global-color-lprimary2);
        color: white;
        font-size: 14px;
        padding: 4px 8px;
        border-radius: 4px;
        z-index: 20;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* List View Adjustments */
    .listivo-user-profiles.list-view .listivo-single-user-profile.listivo-featured-user {
         border: 2px solid var(--e-global-color-lprimary2);
    }

    .listivo-user-profiles .listivo-single-user-profile {
        border: 1px solid var(--e-global-color-lcolor3);
        border-radius: 8px;
    }

    /* Meta Social Icons */
    .listivo-user-card-meta-socials {
        margin: 0;
        gap: 10px;
        display: flex;
        flex-wrap: wrap;
    }

    .listivo-user-card-meta-social-link {
        width: 36px;
        height: 36px;
        font-size: 14px;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.3s;
        color: #777; /* Default icon color to match meta text */
    }

    .listivo-user-card-meta-social-link:hover {
        color: var(--e-global-color-lprimary1);
    }

    .listivo-user-card-meta-social-link svg {
        width: 18px; 
        height: 18px;
        fill: currentColor;
    }
</style>

<div class="listivo-search-v2">
    <div class="listivo-main-search-form">
        <div class="listivo-main-search-form__primary-wrapper">
            <div class="listivo-container">

                <form id="wp-user-search-form">
                    <div class="listivo-users-filter-bar">
                        <!-- Keyword Search -->
                        <div class="listivo-users-filter-item">
                            <label>Search</label>
                            <input type="text" name="keyword" placeholder="Name, Username..." value="<?php echo esc_attr($search); ?>">
                        </div>

                        <!-- Location Filter -->
                        <div class="listivo-users-filter-item">
                            <label>Location</label>
                            <input type="text" name="location" placeholder="City, Country..." value="<?php echo esc_attr($location); ?>">
                        </div>

                        <!-- User Type Filter -->
                        <!-- <div class="listivo-users-filter-item">
                            <label>User Type</label>
                            <select name="user_type">
                                <option value="">All Types</option>
                                <option value="business" <?php selected($user_type, 'business'); ?>>Business Brokers</option>
                                <option value="regular" <?php selected($user_type, 'regular'); ?>>Private Sellers</option>
                            </select>
                        </div> -->

                        <!-- Order By -->
                        <div class="listivo-users-filter-item">
                            <label>Sort By</label>
                            <select name="orderby">
                                <option value="relevant" <?php selected($orderby, 'relevant'); ?>>Most Relevant</option>
                                <option value="newest" <?php selected($orderby, 'newest'); ?>>Newest First</option>
                                <option value="oldest" <?php selected($orderby, 'oldest'); ?>>Oldest First</option>
                                <option value="name_asc" <?php selected($orderby, 'name_asc'); ?>>Name (A-Z)</option>
                                <option value="name_desc" <?php selected($orderby, 'name_desc'); ?>>Name (Z-A)</option>
                            </select>
                        </div>

                        <!-- View Toggle -->
                        <div class="listivo-view-toggle">
                            <button type="button" class="listivo-view-btn active" data-view="grid" title="Grid View">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M2.60078 0.800049C1.61378 0.800049 0.800781 1.61305 0.800781 2.60005V5.80005C0.800781 6.78705 1.61378 7.60005 2.60078 7.60005H5.80078C6.78778 7.60005 7.60078 6.78705 7.60078 5.80005V2.60005C7.60078 1.61305 6.78778 0.800049 5.80078 0.800049H2.60078ZM10.2008 0.800049C9.21378 0.800049 8.40078 1.61305 8.40078 2.60005V5.80005C8.40078 6.78705 9.21378 7.60005 10.2008 7.60005H13.4008C14.3878 7.60005 15.2008 6.78705 15.2008 5.80005V2.60005C15.2008 1.61305 14.3878 0.800049 13.4008 0.800049H10.2008ZM2.60078 2.00005H5.80078C6.13938 2.00005 6.40078 2.26145 6.40078 2.60005V5.80005C6.40078 6.13865 6.13938 6.40005 5.80078 6.40005H2.60078C2.26218 6.40005 2.00078 6.13865 2.00078 5.80005V2.60005C2.00078 2.26145 2.26218 2.00005 2.60078 2.00005ZM10.2008 2.00005H13.4008C13.7394 2.00005 14.0008 2.26145 14.0008 2.60005V5.80005C14.0008 6.13865 13.7394 6.40005 13.4008 6.40005H10.2008C9.86218 6.40005 9.60078 6.13865 9.60078 5.80005V2.60005C9.60078 2.26145 9.86218 2.00005 10.2008 2.00005ZM2.60078 8.40005C1.61378 8.40005 0.800781 9.21305 0.800781 10.2V13.4C0.800781 14.387 1.61378 15.2 2.60078 15.2H5.80078C6.78778 15.2 7.60078 14.387 7.60078 13.4V10.2C7.60078 9.21305 6.78778 8.40005 5.80078 8.40005H2.60078ZM10.2008 8.40005C9.21378 8.40005 8.40078 9.21305 8.40078 10.2V13.4C8.40078 14.387 9.21378 15.2 10.2008 15.2H13.4008C14.3878 15.2 15.2008 14.387 15.2008 13.4V10.2C15.2008 9.21305 14.3878 8.40005 13.4008 8.40005H10.2008ZM2.60078 9.60005H5.80078C6.13938 9.60005 6.40078 9.86145 6.40078 10.2V13.4C6.40078 13.7386 6.13938 14 5.80078 14H2.60078C2.26218 14 2.00078 13.7386 2.00078 13.4V10.2C2.00078 9.86145 2.26218 9.60005 2.60078 9.60005ZM10.2008 9.60005H13.4008C13.7394 9.60005 14.0008 9.86145 14.0008 10.2V13.4C14.0008 13.7386 13.7394 14 13.4008 14H10.2008C9.86218 14 9.60078 13.7386 9.60078 13.4V10.2C9.60078 9.86145 9.86218 9.60005 10.2008 9.60005Z" fill="currentColor"></path>
                                </svg>
                            </button>
                            <button type="button" class="listivo-view-btn" data-view="list" title="List View">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.5988 2.00005H2.39883C2.17791 2.00005 1.99883 2.17913 1.99883 2.40005V2.80005C1.99883 3.02096 2.17791 3.20005 2.39883 3.20005H13.5988C13.8197 3.20005 13.9988 3.02096 13.9988 2.80005V2.40005C13.9988 2.17913 13.8197 2.00005 13.5988 2.00005ZM2.39883 0.800049C1.51517 0.800049 0.798828 1.51639 0.798828 2.40005V2.80005C0.798828 3.6837 1.51517 4.40005 2.39883 4.40005H13.5988C14.4825 4.40005 15.1988 3.6837 15.1988 2.80005V2.40005C15.1988 1.51639 14.4825 0.800049 13.5988 0.800049H2.39883Z" fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.5988 12.8001H2.39883C2.17791 12.8001 1.99883 12.9792 1.99883 13.2001V13.6001C1.99883 13.821 2.17791 14.0001 2.39883 14.0001H13.5988C13.8197 14.0001 13.9988 13.821 13.9988 13.6001V13.2001C13.9988 12.9792 13.8197 12.8001 13.5988 12.8001ZM2.39883 11.6001C1.51517 11.6001 0.798828 12.3164 0.798828 13.2001V13.6001C0.798828 14.4838 1.51517 15.2001 2.39883 15.2001H13.5988C14.4825 15.2001 15.1988 14.4838 15.1988 13.6001V13.2001C15.1988 12.3164 14.4825 11.6001 13.5988 11.6001H2.39883Z" fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.5988 7.2H2.39883C2.17791 7.2 1.99883 7.37909 1.99883 7.6V8C1.99883 8.22091 2.17791 8.4 2.39883 8.4H13.5988C13.8197 8.4 13.9988 8.22091 13.9988 8V7.6C13.9988 7.37909 13.8197 7.2 13.5988 7.2ZM2.39883 6C1.51517 6 0.798828 6.71634 0.798828 7.6V8C0.798828 8.88366 1.51517 9.6 2.39883 9.6H13.5988C14.4825 9.6 15.1988 8.88366 15.1988 8V7.6C15.1988 6.71634 14.4825 6 13.5988 6H2.39883Z" fill="currentColor"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- SEARCH BAR -->


<div class="listivo-search-v2__content listivo-user-profiles" id="wp-users-result">
    <?php if (!empty($wp_users)) : ?>
        <?php foreach ($wp_users as $user): ?>

            <?php
            $user_id = $user->ID;

            // Custom META
            $job_title = get_user_meta($user_id, 'job_title', true);
            $account_type = get_user_meta($user_id, 'account_type', true);
            $user_location = get_user_meta($user_id, 'location', true);
            $user_description = get_user_meta($user_id, 'company_information', true); // Bio
            $user_phone = get_user_meta($user_id, 'phone', true); // Phone
            $registered_date = date_i18n(get_option('date_format'), strtotime($user->user_registered));
            $user_url = get_author_posts_url($user_id);

            // Listing Count
            $listing_count = count_user_posts($user_id, 'listivo_listing');

            // Phone Masking Logic
            $masked_phone = '';
            if ($user_phone) {
                $visible_digits = 3;
                $masked_phone = substr($user_phone, 0, $visible_digits) . str_repeat('*', strlen($user_phone) - $visible_digits);
            }

            // Socials
            $facebook  = get_user_meta($user_id, 'facebook_profile', true);
            $twitter   = get_user_meta($user_id, 'twitter_profile', true);
            $linkedin  = get_user_meta($user_id, 'linkedin_profile', true);

            // Featured User Logic
            $is_featured = get_user_meta($user_id, 'listivo_is_featured_user', true);
            $featured_class = $is_featured ? 'listivo-featured-user' : '';
            ?>

            <div class="listivo-single-user-profile listivo-single-user-profile--icons-smaller <?php echo esc_attr($featured_class); ?>">
                <?php if ($is_featured): ?>
                    <div class="listivo-top-broker-badge">Top Broker</div>
                <?php endif; ?>
                <a href="<?php echo esc_url($user_url); ?>" class="listivo-single-user-profile__link"></a>

                <!-- USER IMAGE -->
                <div class="listivo-single-user-profile__image">
                    <?php
                    $image_id = get_user_meta($user_id, 'image', true);

                    if ($image_id) {
                        // Full Listivo-compatible HTML <img>
                        echo wp_get_attachment_image($image_id, 'full', false, [
                            'class' => 'lazyautosizes ls-is-cached lazyloaded',
                            'alt' => esc_attr($user->display_name)
                        ]);
                    } else {
                        // fallback avatar
                    echo '<img src="' . esc_url( get_stylesheet_directory_uri() . '/assets/user.png' ) . '" 
                        alt="Default Avatar" 
                        style="display:block; padding: 2rem;">';
                    }   
                    ?>
                </div>

                <div class="listivo-single-user-profile__content">

                    <!-- NAME -->
                    <h3 class="listivo-single-user-profile__label">
                        <a href="<?php echo esc_url($user_url); ?>">
                            <?php echo esc_html($user->display_name); ?>
                        </a>
                    </h3>

                    <!-- JOB TITLE -->
                    <?php if (!empty($account_type)): ?>
                        <div class="listivo-single-user-profile__job-title">
                            <?php echo esc_html($account_type === 'business' ? 'Business Broker' : 'Private Seller'); ?>
                        </div>
                    <?php endif; ?>

                    <!-- NEW: EXTRA INFO -->
                    <div class="listivo-user-card-meta">
                        <?php if (!empty($user_location)): ?>
                            <div class="listivo-user-card-meta-item">
                                <span class="listivo-user-card-meta-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5 0C2.24609 0 0 2.27981 0 5.07505C0 5.8601 0.316406 6.72048 0.753906 7.62843C1.19141 8.54036 1.76172 9.49193 2.33594 10.3602C3.47656 12.1008 4.61328 13.5163 4.61328 13.5163L5 14L5.38672 13.5163C5.38672 13.5163 6.52344 12.1008 7.66797 10.3602C8.23828 9.49193 8.80859 8.54036 9.24609 7.62843C9.68359 6.72048 10 5.8601 10 5.07505C10 2.27981 7.75391 0 5 0ZM5 1.01514C7.21484 1.01514 9 2.82709 9 5.07518C9 5.55096 8.75391 6.33997 8.34766 7.18449C7.94141 8.03298 7.38672 8.95283 6.83594 9.80132C5.99563 11.0789 5.40082 11.8315 5.08146 12.2356L5 12.3388L4.91854 12.2356C4.59919 11.8315 4.00437 11.0789 3.16406 9.80132C2.61328 8.95283 2.05859 8.03298 1.65234 7.18449C1.24609 6.33997 1 5.55096 1 5.07518C1 2.82709 2.78516 1.01514 5 1.01514ZM4.00002 5.06006C4.00002 4.50928 4.44924 4.06006 5.00002 4.06006C5.5508 4.06006 6.00002 4.50928 6.00002 5.06006C6.00002 5.61084 5.5508 6.06006 5.00002 6.06006C4.44924 6.06006 4.00002 5.61084 4.00002 5.06006Z" fill="#374B5C"></path>
                                    </svg>
                                </span>
                                <?php echo esc_html($user_location); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($user_phone)): ?>
                            <div class="listivo-user-card-meta-item">
                                <span class="listivo-user-card-meta-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-icon lucide-phone">
                                        <path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                                    </svg></span>
                                <div class="listivo-user-phone-reveal" data-full-phone="<?php echo esc_attr($user_phone); ?>">
                                    <span class="listivo-user-phone-text"><?php echo esc_html($masked_phone); ?></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="11" viewBox="0 0 15 11" fill="none">
                                        <path d="M7.5 0.25C2.40909 0.25 0.5 5.34091 0.5 5.34091C0.5 5.34091 2.40909 10.4318 7.5 10.4318C12.5909 10.4318 14.5 5.34091 14.5 5.34091C14.5 5.34091 12.5909 0.25 7.5 0.25ZM7.5 1.52273C10.8575 1.52273 12.5557 4.23815 13.1055 5.33842C12.555 6.43106 10.8441 9.15909 7.5 9.15909C4.14255 9.15909 2.44435 6.44367 1.89453 5.34339C2.44562 4.25076 4.15591 1.52273 7.5 1.52273ZM7.5 2.79545C6.09427 2.79545 4.95455 3.93518 4.95455 5.34091C4.95455 6.74664 6.09427 7.88636 7.5 7.88636C8.90573 7.88636 10.0455 6.74664 10.0455 5.34091C10.0455 3.93518 8.90573 2.79545 7.5 2.79545ZM7.5 4.06818C8.20318 4.06818 8.77273 4.63773 8.77273 5.34091C8.77273 6.04409 8.20318 6.61364 7.5 6.61364C6.79682 6.61364 6.22727 6.04409 6.22727 5.34091C6.22727 4.63773 6.79682 4.06818 7.5 4.06818Z" fill="#374B5C"></path>
                                    </svg>
                                </div>
                            </div>
                        <?php endif; ?>

                         <div class="listivo-user-card-meta-item">
                            <span class="listivo-user-card-meta-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-land-plot-icon lucide-land-plot">
                                    <path d="m12 8 6-3-6-3v10" />
                                    <path d="m8 11.99-5.5 3.14a1 1 0 0 0 0 1.74l8.5 4.86a2 2 0 0 0 2 0l8.5-4.86a1 1 0 0 0 0-1.74L16 12" />
                                    <path d="m6.49 12.85 11.02 6.3" />
                                    <path d="M17.51 12.85 6.5 19.15" />
                                </svg></span>
                            <?php echo esc_html($listing_count); ?> Listings
                        </div>

                        <!-- SOCIAL ICONS (Moved) -->
                        <?php if ($facebook || $twitter || $linkedin): ?>
                            <div class="listivo-user-card-meta-item">
                                <div class="listivo-user-card-meta-socials">
                                    <?php if ($facebook): ?>
                                        <a class="listivo-user-card-meta-social-link" href="<?php echo esc_url($facebook); ?>" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                <path d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"></path>
                                            </svg>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($twitter): ?>
                                        <a class="listivo-user-card-meta-social-link" href="<?php echo esc_url($twitter); ?>" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path>
                                            </svg>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($linkedin): ?>
                                        <a class="listivo-user-card-meta-social-link" href="<?php echo esc_url($linkedin); ?>" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"></path>
                                            </svg>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($user_description)): ?>
                        <div class="listivo-user-bio">
                            <?php echo wp_trim_words(esc_html($user_description), 15, '...'); ?>
                        </div>
                    <?php endif; ?>



                </div>
            </div>

        <?php endforeach; ?>
    <?php else: ?>
        <div class="listivo-no-results">
            <h3>No users found.</h3>
        </div>
    <?php endif; ?>
</div>

<!-- PAGINATION -->
<?php
$total_pages = ceil($total_users / $per_page);

if ($total_pages > 1): ?>
    <div class="listivo-pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a class="listivo-pagination__item <?php echo ($i == $page) ? 'listivo-pagination__item--active' : ''; ?>"
                href="?lp=<?php echo $i; ?>&<?php echo http_build_query(array_merge($_GET, ['lp' => $i])); // Preserve other params 
                                            ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>
