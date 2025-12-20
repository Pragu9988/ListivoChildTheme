<?php

use Tangibledesign\Listivo\Widgets\Listing\ListingSocialsWidget;

/* @var ListingSocialsWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}
?>
<div class="listivo-listing-socials listivo-app">
    <div class="listivo-social-icons">
        <?php if (tdf_settings()->isFavoriteEnabled()) : ?>
            <lst-favorite :model-id="<?php echo esc_attr($lstModel->getId()); ?>">
                <div
                        class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                        slot-scope="favorite"
                        @click.prevent="favorite.onClick"
                        :class="{'listivo-social-icon--active': favorite.isActive}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M0 5.65768C0 2.54234 2.47122 0.000488281 5.5 0.000488281C7.23822 0.000488281 8.75159 0.960404 10 2.59102C11.2484 0.960404 12.7618 0.000488281 14.5 0.000488281C17.5288 0.000488281 20 2.54234 20 5.65768C20 7.76429 18.4562 9.74777 16.5742 11.7819C15.4942 12.9494 14.271 14.1254 13.0759 15.2744C12.1885 16.1275 11.3167 16.9658 10.5303 17.7746C10.2374 18.0758 9.76262 18.0758 9.46973 17.7746C8.68334 16.9658 7.81146 16.1275 6.92412 15.2744C5.729 14.1254 4.50584 12.9494 3.42578 11.7819C1.54382 9.74777 0 7.76429 0 5.65768ZM9.36621 4.2696C8.18315 2.34493 6.96429 1.54346 5.5 1.54346C3.28178 1.54346 1.5 3.37616 1.5 5.65778C1.5 6.89405 2.70618 8.76774 4.51172 10.7193C5.54128 11.8321 6.72729 12.9761 7.91045 14.1173C8.61942 14.8011 9.32736 15.484 10 16.1585C10.6726 15.484 11.3806 14.8011 12.0895 14.1173C13.2727 12.9761 14.4587 11.8321 15.4883 10.7193C17.2938 8.76774 18.5 6.89405 18.5 5.65778C18.5 3.37616 16.7182 1.54346 14.5 1.54346C13.0357 1.54346 11.8168 2.34493 10.6338 4.2696C10.4963 4.49305 10.2571 4.62849 10 4.62849C9.7429 4.62849 9.50371 4.49305 9.36621 4.2696Z"
                              fill="#2A3946"/>
                    </svg>

                    <div class="listivo-social-icon__notice">
                        <?php echo esc_html(tdf_string('add_to_favorites')); ?>
                    </div>
                </div>
            </lst-favorite>
        <?php endif; ?>

        <?php if (tdf_settings()->isCompareModelsEnabled()) : ?>
            <lst-compare :model-id="<?php echo esc_attr($lstModel->getId()); ?>">
                <div
                        slot-scope="compare"
                        class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                        @click.prevent="compare.onClick"
                        :class="{'listivo-social-icon--active': compare.isActive}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="18" viewBox="0 0 21 18" fill="none">
                        <path d="M0.214532 8.75689L3.76943 12.2853L7.29782 8.73039L4.4645 8.74099L4.45125 5.19935C4.44682 4.01642 5.38535 3.07084 6.56828 3.06641L14.4927 3.03676C14.7911 3.85594 15.5738 4.44939 16.4902 4.44596C17.6554 4.4416 18.6116 3.47823 18.6072 2.31303C18.6029 1.14782 17.6395 0.191631 16.4743 0.195991C15.5579 0.19942 14.7797 0.798713 14.4874 1.6201L6.56298 1.64975C4.6151 1.65704 3.0273 3.25677 3.03459 5.20465L3.04785 8.74629L0.214532 8.75689ZM1.65504 15.1265C1.6594 16.2918 2.62277 17.2479 3.78798 17.2436C4.70433 17.2402 5.48257 16.6409 5.77485 15.8195L13.6993 15.7898C15.6472 15.7825 17.235 14.1828 17.2277 12.2349L17.2144 8.69328L20.0477 8.68268L16.4928 5.15429L12.9644 8.70919L15.7978 8.69858L15.811 12.2402C15.8154 13.4232 14.8769 14.3687 13.694 14.3732L5.76955 14.4028C5.47113 13.5836 4.68843 12.9902 3.77208 12.9936C2.60687 12.998 1.65068 13.9613 1.65504 15.1265ZM3.0717 15.1212C3.0702 14.7217 3.37779 14.4118 3.77738 14.4103C4.17697 14.4088 4.48686 14.7164 4.48836 15.1159C4.48985 15.5155 4.18227 15.8254 3.78268 15.8269C3.38309 15.8284 3.0732 15.5208 3.0717 15.1212ZM15.7739 2.32363C15.7724 1.92404 16.08 1.61414 16.4796 1.61265C16.8792 1.61115 17.1891 1.91874 17.1906 2.31833C17.1921 2.71792 16.8845 3.02781 16.4849 3.02931C16.0853 3.0308 15.7754 2.72322 15.7739 2.32363Z"
                              fill="#2A3946"/>
                    </svg>

                    <div class="listivo-social-icon__notice">
                        <?php echo esc_html(tdf_string('add_to_compare')); ?>
                    </div>
                </div>
            </lst-compare>
        <?php endif; ?>

        <?php if ($lstCurrentWidget->showFacebook()) : ?>
            <a
                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                    href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(tdf_app('current_url')); ?>"
                    target="_blank"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"/>
                </svg>

                <div class="listivo-social-icon__notice">
                    <?php echo esc_html(tdf_string('share_on_facebook')); ?>
                </div>
            </a>
        <?php endif; ?>

        <?php if ($lstCurrentWidget->showTwitter()) : ?>
            <a
                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                    href="https://twitter.com/share?url=<?php echo esc_url(tdf_app('current_url')); ?>"
                    target="_blank"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                </svg>

                <div class="listivo-social-icon__notice">
                    <?php echo esc_html(tdf_string('share_on_twitter')); ?>
                </div>
            </a>
        <?php endif; ?>

        <?php if ($lstCurrentWidget->showWhatsApp()) : ?>
            <a
                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--mobile listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                    href="whatsapp://send?text=<?php echo urlencode(tdf_app('current_url')); ?>"
                    target="_blank"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                </svg>

                <div class="listivo-social-icon__notice">
                    <?php echo esc_html(tdf_string('share_on_whats_app')); ?>
                </div>
            </a>
        <?php endif; ?>

        <?php if ($lstCurrentWidget->showMessenger()) : ?>
            <a
                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--mobile listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                    href="fb-messenger://share?link=<?php echo urlencode(tdf_app('current_url')); ?>"
                    target="_blank"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M256.6 8C116.5 8 8 110.3 8 248.6c0 72.3 29.7 134.8 78.1 177.9 8.4 7.5 6.6 11.9 8.1 58.2A19.9 19.9 0 0 0 122 502.3c52.9-23.3 53.6-25.1 62.6-22.7C337.9 521.8 504 423.7 504 248.6 504 110.3 396.6 8 256.6 8zm149.2 185.1l-73 115.6a37.4 37.4 0 0 1 -53.9 9.9l-58.1-43.5a15 15 0 0 0 -18 0l-78.4 59.4c-10.5 7.9-24.2-4.6-17.1-15.7l73-115.6a37.4 37.4 0 0 1 53.9-9.9l58.1 43.5a15 15 0 0 0 18 0l78.4-59.4c10.4-8 24.1 4.5 17.1 15.6z"/>
                </svg>

                <div class="listivo-social-icon__notice">
                    <?php echo esc_html(tdf_string('share_on_messenger')); ?>
                </div>
            </a>
        <?php endif; ?>

        <?php if ($lstCurrentWidget->showPrint()) : ?>
            <lst-print-button url="<?php echo esc_url($lstModel->getUrl() . '?print=1'); ?>">
                <button
                        slot-scope="print"
                        class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                        @click.prevent="print.onClick"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M5 2.5V6.25H3.125C2.09473 6.25 1.25 7.09473 1.25 8.125V13.125C1.25 14.1553 2.09473 15 3.125 15H5V17.5H15V15H16.875C17.9053 15 18.75 14.1553 18.75 13.125V8.125C18.75 7.09473 17.9053 6.25 16.875 6.25H15V2.5H5ZM6.25 3.75H13.75V6.25H6.25V3.75ZM3.125 7.5H16.875C17.2266 7.5 17.5 7.77344 17.5 8.125V13.125C17.5 13.4766 17.2266 13.75 16.875 13.75H15V11.25H5V13.75H3.125C2.77344 13.75 2.5 13.4766 2.5 13.125V8.125C2.5 7.77344 2.77344 7.5 3.125 7.5ZM4.375 8.75C4.02832 8.75 3.75 9.02832 3.75 9.375C3.75 9.72168 4.02832 10 4.375 10C4.72168 10 5 9.72168 5 9.375C5 9.02832 4.72168 8.75 4.375 8.75ZM6.25 12.5H13.75V16.25H6.25V12.5Z"
                              fill="#2A3946"/>
                    </svg>

                    <div class="listivo-social-icon__notice">
                        <?php echo esc_html(tdf_string('print')); ?>
                    </div>
                </button>
            </lst-print-button>
        <?php endif; ?>
    </div>
</div>
