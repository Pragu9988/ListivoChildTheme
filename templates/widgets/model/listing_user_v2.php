<?php

use Tangibledesign\Framework\Core\Image\RenderUserImage;
use Tangibledesign\Listivo\Widgets\Listing\ListingUserV2Widget;

/* @var ListingUserV2Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}

$lstUser = $lstModel->getUser();
if (!$lstUser) {
    return;
}

add_filter('tdf/portals', static function ($portals) use ($lstCurrentWidget) {
    $portals[] = 'contact_form-' . $lstCurrentWidget->get_id();

    return $portals;
});
?>
<div class="listivo-listing-user-v2 listivo-app">
    <div class="listivo-listing-user-v2__content">
        <div class="listivo-listing-user-v2__avatar-wrapper">
            <?php if ($lstUser->isFacebookImage()) : ?>
                <div class="listivo-listing-user-v2__facebook-icon">
                    <i class="fab fa-facebook"></i>
                </div>
            <?php endif; ?>

            <a
                <?php if (!$lstUser->hasImageUrl('listivo_100_100') && !$lstUser->hasSocialImage()) : ?>
                    class="listivo-listing-user-v2__avatar listivo-listing-user-v2__avatar--no-image"
                <?php else : ?>
                    class="listivo-listing-user-v2__avatar"
                <?php endif; ?>
                    href="<?php echo esc_url($lstUser->getUrl()); ?>"
            >
                <?php RenderUserImage::render($lstUser, 'listivo_100_100', RenderUserImage::PLACEHOLDER_CIRCLE); ?>
            </a>
        </div>

        <div class="listivo-listing-user-v2__info">
            <a
                    class="listivo-listing-user-v2__name"
                    href="<?php echo esc_url($lstUser->getUrl()); ?>"
            >
                <?php echo esc_html($lstUser->getDisplayName()); ?>
            </a>

            <?php if ($lstCurrentWidget->showUserRating()) :
                $lstRating = $lstUser->getRating();
                ?>
                <div class="listivo-listing-user-v2__rating-wrapper">
                    <div class="listivo-listing-user-v2__rating">
                        <?php echo esc_html($lstRating); ?>
                    </div>

                    <div class="listivo-listing-user-v2__stars">
                        <div class="listivo-listing-user-v2__active-rating">
                            <div class="listivo-listing-user-v2__stars">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <div
                                            class="listivo-listing-user-v2__star listivo-listing-user-v2__star--active"
                                        <?php if ($i > $lstRating && $lstRating - $i > -1) : ?>
                                            style="width: <?php echo esc_attr(($lstRating - $i + 1) * 26); ?>px;"
                                        <?php elseif ($i > $lstRating) : ?>
                                            style="width: 0;"
                                        <?php endif; ?>
                                    >
                                        <div class="listivo-listing-user-v2__star-wrapper">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="25"
                                                 viewBox="0 0 26 25">
                                                <path d="M12.9987 20.6139L19.21 24.3626C20.19 24.9539 21.3987 24.0751 21.1387 22.9614L19.49 15.8951L24.9787 11.1401C25.8437 10.3914 25.3812 8.97014 24.2412 8.87389L17.0162 8.26139L14.19 1.59264C13.7437 0.541387 12.2537 0.541387 11.8075 1.59264L8.98124 8.26139L1.75624 8.87389C0.616237 8.97014 0.153736 10.3914 1.01874 11.1401L6.50749 15.8951L4.85874 22.9614C4.59874 24.0751 5.80749 24.9539 6.78749 24.3626L12.9987 20.6139Z"
                                                />
                                            </svg>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <?php for ($i = 0; $i < 5; $i++) : ?>
                            <div class="listivo-listing-user-v2__star">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="25" viewBox="0 0 26 25"
                                     fill="none">
                                    <path d="M12.9987 20.6139L19.21 24.3626C20.19 24.9539 21.3987 24.0751 21.1387 22.9614L19.49 15.8951L24.9787 11.1401C25.8437 10.3914 25.3812 8.97014 24.2412 8.87389L17.0162 8.26139L14.19 1.59264C13.7437 0.541387 12.2537 0.541387 11.8075 1.59264L8.98124 8.26139L1.75624 8.87389C0.616237 8.97014 0.153736 10.3914 1.01874 11.1401L6.50749 15.8951L4.85874 22.9614C4.59874 24.0751 5.80749 24.9539 6.78749 24.3626L12.9987 20.6139Z"
                                    />
                                </svg>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <?php if ($lstCurrentWidget->showUserRatingsNumber()) :
                        $lstReviewNumber = $lstUser->getReviewNumber();
                        ?>
                        <a
                                class="listivo-listing-user-v2__rating-count"
                                href="<?php echo esc_url($lstUser->getUrl()); ?>#listivo-reviews-<?php echo esc_attr($lstUser->getId()); ?>"
                                target="_blank"
                        >
                            <?php
                            $lstReviewText = $lstReviewNumber === 1 ? tdf_string('review') : tdf_string('reviews');

                            echo sprintf('%d %s', $lstReviewNumber, $lstReviewText);
                            ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($lstCurrentWidget->showMemberSince()) : ?>
                <div class="listivo-listing-user-v2__member-since">
                    <?php echo esc_html(tdf_string('member_since') . ': ' . $lstUser->getRegistrationDateDiff()); ?>
                </div>
            <?php endif; ?>

            <?php if ($lstCurrentWidget->showAccountType()) : ?>
                <div class="listivo-listing-user-v2__account-type">
                    <?php echo esc_html(tdf_string('account_type') . ': ' . $lstUser->getDisplayAccountType()); ?>
                </div>
            <?php endif; ?>

            <?php if ($lstCurrentWidget->showUserState()) : ?>
                <div
                    <?php if ($lstCurrentWidget->isUserOnline()) : ?>
                        class="listivo-listing-user-v2__state listivo-listing-user-v2__state--online"
                    <?php else : ?>
                        class="listivo-listing-user-v2__state listivo-listing-user-v2__state--offline"
                    <?php endif; ?>
                >
                    <?php if ($lstCurrentWidget->isUserOnline()) : ?>
                        <?php echo esc_html(tdf_string('user_is_online_now')); ?>
                    <?php else : ?>
                        <?php echo esc_html(tdf_string('user_is_offline')); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($lstCurrentWidget->showAddress() && !empty($lstUser->getAddress())) : ?>
                <div class="listivo-listing-user-v2__address">
                    <div class="listivo-listing-user-v2__address-icon-wrapper">
                        <div class="listivo-listing-user-v2__address-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14"
                                 fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M5 0C2.24609 0 0 2.27981 0 5.07505C0 5.8601 0.316406 6.72048 0.753906 7.62843C1.19141 8.54036 1.76172 9.49193 2.33594 10.3602C3.47656 12.1008 4.61328 13.5163 4.61328 13.5163L5 14L5.38672 13.5163C5.38672 13.5163 6.52344 12.1008 7.66797 10.3602C8.23828 9.49193 8.80859 8.54036 9.24609 7.62843C9.68359 6.72048 10 5.8601 10 5.07505C10 2.27981 7.75391 0 5 0ZM5 1.01514C7.21484 1.01514 9 2.82709 9 5.07518C9 5.55096 8.75391 6.33997 8.34766 7.18449C7.94141 8.03298 7.38672 8.95283 6.83594 9.80132C5.99563 11.0789 5.40082 11.8315 5.08146 12.2356L5 12.3388L4.91854 12.2356C4.59919 11.8315 4.00437 11.0789 3.16406 9.80132C2.61328 8.95283 2.05859 8.03298 1.65234 7.18449C1.24609 6.33997 1 5.55096 1 5.07518C1 2.82709 2.78516 1.01514 5 1.01514ZM4.00002 5.06006C4.00002 4.50928 4.44924 4.06006 5.00002 4.06006C5.5508 4.06006 6.00002 4.50928 6.00002 5.06006C6.00002 5.61084 5.5508 6.06006 5.00002 6.06006C4.44924 6.06006 4.00002 5.61084 4.00002 5.06006Z"
                                      fill="#374B5C"/>
                            </svg>
                        </div>
                    </div>

                    <div class="listivo-listing-user-v2__address-text">
                        <?php echo esc_html($lstUser->getAddress()); ?>
                    </div>
                </div>
            <?php endif; ?>

            <a
                    class="listivo-listing-user-v2__see-all"
                    href="<?php echo esc_url($lstUser->getUrl()); ?>"
            >
                <?php echo esc_html(tdf_string('see_all_ads')); ?>
            </a>
        </div>
    </div>

    <?php if ($lstCurrentWidget->showPhone() && $lstUser->hasPhone()) : ?>
        <div class="listivo-listing-user-v2__phone">
            <?php if (!$lstCurrentWidget->hidePhoneNumber()) : ?>
                <a
                        href="tel:<?php echo esc_attr($lstUser->getPhoneUrl()); ?>"
                        class="listivo-contact-button listivo-contact-button--listing-user-v2"
                >
                    <div class="listivo-contact-button__inner">
                        <div class="listivo-contact-button__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="24" viewBox="0 0 14 24"
                                 fill="none">
                                <path
                                        d="M2.625 0C1.18562 0 0 1.18562 0 2.625V20.7083C0 22.1477 1.18562 23.3333 2.625 23.3333H11.375C12.8144 23.3333 14 22.1477 14 20.7083V2.625C14 1.18562 12.8144 0 11.375 0H2.625ZM2.625 1.75H11.375C11.8688 1.75 12.25 2.13121 12.25 2.625V20.7083C12.25 21.2021 11.8688 21.5833 11.375 21.5833H2.625C2.13121 21.5833 1.75 21.2021 1.75 20.7083V2.625C1.75 2.13121 2.13121 1.75 2.625 1.75ZM7 3.5C6.76794 3.5 6.54538 3.59219 6.38128 3.75628C6.21719 3.92038 6.125 4.14294 6.125 4.375C6.125 4.60706 6.21719 4.82962 6.38128 4.99372C6.54538 5.15781 6.76794 5.25 7 5.25C7.23206 5.25 7.45462 5.15781 7.61872 4.99372C7.78281 4.82962 7.875 4.60706 7.875 4.375C7.875 4.14294 7.78281 3.92038 7.61872 3.75628C7.45462 3.59219 7.23206 3.5 7 3.5ZM5.54167 18.0833C5.42572 18.0817 5.3106 18.1031 5.203 18.1464C5.09541 18.1896 4.99748 18.2538 4.9149 18.3352C4.83233 18.4166 4.76676 18.5136 4.722 18.6206C4.67725 18.7276 4.6542 18.8424 4.6542 18.9583C4.6542 19.0743 4.67725 19.1891 4.722 19.2961C4.76676 19.403 4.83233 19.5001 4.9149 19.5815C4.99748 19.6629 5.09541 19.7271 5.203 19.7703C5.3106 19.8136 5.42572 19.835 5.54167 19.8333H8.45833C8.57428 19.835 8.6894 19.8136 8.797 19.7703C8.90459 19.7271 9.00252 19.6629 9.0851 19.5815C9.16767 19.5001 9.23324 19.403 9.278 19.2961C9.32275 19.1891 9.3458 19.0743 9.3458 18.9583C9.3458 18.8424 9.32275 18.7276 9.278 18.6206C9.23324 18.5136 9.16767 18.4166 9.0851 18.3352C9.00252 18.2538 8.90459 18.1896 8.797 18.1464C8.6894 18.1031 8.57428 18.0817 8.45833 18.0833H5.54167Z"
                                        fill="#2A3946"/>
                            </svg>
                        </div>

                        <?php echo wp_kses_post($lstUser->getDisplayPhone()); ?>
                    </div>
                </a>
            <?php else : ?>
                <lst-show>
                    <div slot-scope="showProps">
                        <lst-phone
                                :user-id="<?php echo esc_attr($lstUser->getId()); ?>"
                                request-url="<?php echo esc_url(tdf_action_url('listivo/phone')); ?>"
                                phone-nonce="<?php echo esc_attr(wp_create_nonce('phone_' . $lstUser->getId())) ?>"
                                :model-id="<?php echo esc_attr($lstModel->getId()); ?>"
                        >
                            <div slot-scope="props">
                                <div
                                        v-if="!props.phone"
                                        @click.prevent="<?php echo !is_user_logged_in() ? 'showProps.onClick' : 'props.onShow'; ?>"
                                        class="listivo-contact-button listivo-contact-button--listing-user-v2"
                                >
                                    <div class="listivo-contact-button__inner">
                                        <div class="listivo-contact-button__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="24"
                                                 viewBox="0 0 14 24"
                                                 fill="none">
                                                <path
                                                        d="M2.625 0C1.18562 0 0 1.18562 0 2.625V20.7083C0 22.1477 1.18562 23.3333 2.625 23.3333H11.375C12.8144 23.3333 14 22.1477 14 20.7083V2.625C14 1.18562 12.8144 0 11.375 0H2.625ZM2.625 1.75H11.375C11.8688 1.75 12.25 2.13121 12.25 2.625V20.7083C12.25 21.2021 11.8688 21.5833 11.375 21.5833H2.625C2.13121 21.5833 1.75 21.2021 1.75 20.7083V2.625C1.75 2.13121 2.13121 1.75 2.625 1.75ZM7 3.5C6.76794 3.5 6.54538 3.59219 6.38128 3.75628C6.21719 3.92038 6.125 4.14294 6.125 4.375C6.125 4.60706 6.21719 4.82962 6.38128 4.99372C6.54538 5.15781 6.76794 5.25 7 5.25C7.23206 5.25 7.45462 5.15781 7.61872 4.99372C7.78281 4.82962 7.875 4.60706 7.875 4.375C7.875 4.14294 7.78281 3.92038 7.61872 3.75628C7.45462 3.59219 7.23206 3.5 7 3.5ZM5.54167 18.0833C5.42572 18.0817 5.3106 18.1031 5.203 18.1464C5.09541 18.1896 4.99748 18.2538 4.9149 18.3352C4.83233 18.4166 4.76676 18.5136 4.722 18.6206C4.67725 18.7276 4.6542 18.8424 4.6542 18.9583C4.6542 19.0743 4.67725 19.1891 4.722 19.2961C4.76676 19.403 4.83233 19.5001 4.9149 19.5815C4.99748 19.6629 5.09541 19.7271 5.203 19.7703C5.3106 19.8136 5.42572 19.835 5.54167 19.8333H8.45833C8.57428 19.835 8.6894 19.8136 8.797 19.7703C8.90459 19.7271 9.00252 19.6629 9.0851 19.5815C9.16767 19.5001 9.23324 19.403 9.278 19.2961C9.32275 19.1891 9.3458 19.0743 9.3458 18.9583C9.3458 18.8424 9.32275 18.7276 9.278 18.6206C9.23324 18.5136 9.16767 18.4166 9.0851 18.3352C9.00252 18.2538 8.90459 18.1896 8.797 18.1464C8.6894 18.1031 8.57428 18.0817 8.45833 18.0833H5.54167Z"
                                                        fill="#2A3946"/>
                                            </svg>
                                        </div>

                                        <?php echo wp_kses_post($lstUser->getPhonePlaceholder()); ?>
                                    </div>

                                    <div class="listivo-contact-button__icon listivo-contact-button__icon--additional">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="14" viewBox="0 0 20 14"
                                             fill="none">
                                            <path
                                                    d="M10 0.333252C3.33334 0.333252 0.833344 6.99992 0.833344 6.99992C0.833344 6.99992 3.33334 13.6666 10 13.6666C16.6667 13.6666 19.1667 6.99992 19.1667 6.99992C19.1667 6.99992 16.6667 0.333252 10 0.333252ZM10 1.99992C14.3967 1.99992 16.6205 5.55583 17.3405 6.99666C16.6197 8.4275 14.3792 11.9999 10 11.9999C5.60334 11.9999 3.37952 8.44401 2.65952 7.00317C3.38118 5.57234 5.62084 1.99992 10 1.99992ZM10 3.66658C8.15918 3.66658 6.66668 5.15908 6.66668 6.99992C6.66668 8.84075 8.15918 10.3333 10 10.3333C11.8408 10.3333 13.3333 8.84075 13.3333 6.99992C13.3333 5.15908 11.8408 3.66658 10 3.66658ZM10 5.33325C10.9208 5.33325 11.6667 6.07908 11.6667 6.99992C11.6667 7.92075 10.9208 8.66658 10 8.66658C9.07918 8.66658 8.33334 7.92075 8.33334 6.99992C8.33334 6.07908 9.07918 5.33325 10 5.33325Z"
                                                    fill="#FDFDFE"/>
                                        </svg>
                                    </div>
                                </div>

                                <template>
                                    <a
                                            v-if="props.phone"
                                            :href="'tel:' + props.phone.url"
                                            class="listivo-contact-button listivo-contact-button--listing-user-v2"
                                    >
                                        <div class="listivo-contact-button__inner">
                                            <div class="listivo-contact-button__icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="24"
                                                     viewBox="0 0 14 24"
                                                     fill="none">
                                                    <path
                                                            d="M2.625 0C1.18562 0 0 1.18562 0 2.625V20.7083C0 22.1477 1.18562 23.3333 2.625 23.3333H11.375C12.8144 23.3333 14 22.1477 14 20.7083V2.625C14 1.18562 12.8144 0 11.375 0H2.625ZM2.625 1.75H11.375C11.8688 1.75 12.25 2.13121 12.25 2.625V20.7083C12.25 21.2021 11.8688 21.5833 11.375 21.5833H2.625C2.13121 21.5833 1.75 21.2021 1.75 20.7083V2.625C1.75 2.13121 2.13121 1.75 2.625 1.75ZM7 3.5C6.76794 3.5 6.54538 3.59219 6.38128 3.75628C6.21719 3.92038 6.125 4.14294 6.125 4.375C6.125 4.60706 6.21719 4.82962 6.38128 4.99372C6.54538 5.15781 6.76794 5.25 7 5.25C7.23206 5.25 7.45462 5.15781 7.61872 4.99372C7.78281 4.82962 7.875 4.60706 7.875 4.375C7.875 4.14294 7.78281 3.92038 7.61872 3.75628C7.45462 3.59219 7.23206 3.5 7 3.5ZM5.54167 18.0833C5.42572 18.0817 5.3106 18.1031 5.203 18.1464C5.09541 18.1896 4.99748 18.2538 4.9149 18.3352C4.83233 18.4166 4.76676 18.5136 4.722 18.6206C4.67725 18.7276 4.6542 18.8424 4.6542 18.9583C4.6542 19.0743 4.67725 19.1891 4.722 19.2961C4.76676 19.403 4.83233 19.5001 4.9149 19.5815C4.99748 19.6629 5.09541 19.7271 5.203 19.7703C5.3106 19.8136 5.42572 19.835 5.54167 19.8333H8.45833C8.57428 19.835 8.6894 19.8136 8.797 19.7703C8.90459 19.7271 9.00252 19.6629 9.0851 19.5815C9.16767 19.5001 9.23324 19.403 9.278 19.2961C9.32275 19.1891 9.3458 19.0743 9.3458 18.9583C9.3458 18.8424 9.32275 18.7276 9.278 18.6206C9.23324 18.5136 9.16767 18.4166 9.0851 18.3352C9.00252 18.2538 8.90459 18.1896 8.797 18.1464C8.6894 18.1031 8.57428 18.0817 8.45833 18.0833H5.54167Z"
                                                            fill="#2A3946"/>
                                                </svg>
                                            </div>

                                            {{ props.phone.label }}
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </lst-phone>

                        <template>
                            <portal v-if="showProps.show" to="footer">
                                <div class="listivo-dark-mask listivo-dark-mask--active"></div>
                                <div class="listivo-user-popup">
                                    <div class="listivo-user-popup__form">
                                        <div class="listivo-user-popup__inner-form">
                                            <div
                                                    @click.prevent="showProps.onClick"
                                                    class="listivo-user-popup__close"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                                    fill="none">
                                                    <path d="M1.33403 0.000578098C1.06975 0.000905507 0.811563 0.0800467 0.592456 0.227892C0.373349 0.375737 0.203268 0.585574 0.10394 0.830597C0.00461216 1.07562 -0.0194532 1.3447 0.0348181 1.60348C0.0890895 1.86225 0.219234 2.09896 0.408626 2.28338L4.12063 5.99715L0.408626 9.71092C0.281072 9.83344 0.179237 9.9802 0.109083 10.1426C0.0389292 10.305 0.00186758 10.4797 6.87814e-05 10.6566C-0.00173002 10.8335 0.0317702 11.009 0.0986071 11.1728C0.165444 11.3366 0.264274 11.4854 0.38931 11.6105C0.514346 11.7356 0.663073 11.8345 0.826782 11.9013C0.990491 11.9682 1.16589 12.0017 1.34271 11.9999C1.51953 11.9981 1.69421 11.961 1.85652 11.8909C2.01884 11.8207 2.16552 11.7188 2.28799 11.5912L6 7.8774L9.712 11.5912C9.83447 11.7188 9.98115 11.8207 10.1435 11.8909C10.3058 11.9611 10.4805 11.9981 10.6573 11.9999C10.8341 12.0017 11.0095 11.9682 11.1732 11.9013C11.3369 11.8345 11.4857 11.7356 11.6107 11.6105C11.7357 11.4854 11.8346 11.3366 11.9014 11.1728C11.9682 11.009 12.0017 10.8336 11.9999 10.6566C11.9981 10.4797 11.9611 10.305 11.8909 10.1426C11.8208 9.9802 11.7189 9.83344 11.5914 9.71092L7.87936 5.99715L11.5914 2.28338C11.7834 2.09661 11.9146 1.85615 11.9677 1.59351C12.0208 1.33087 11.9934 1.0583 11.889 0.811532C11.7846 0.564762 11.6081 0.355297 11.3827 0.210589C11.1573 0.0658805 10.8934 -0.00732073 10.6257 0.000578098C10.2804 0.0108714 9.95272 0.155247 9.712 0.403119L6 4.11689L2.28799 0.403119C2.16398 0.275586 2.01566 0.174247 1.8518 0.105102C1.68793 0.0359579 1.51187 0.000414782 1.33403 0.000578098Z"
                                                        fill="#FDFDFE"/>
                                                </svg>
                                            </div>

                                            <?php get_template_part('templates/partials/login_and_register'); ?>
                                        </div>
                                    </div>
                                </div>
                            </portal>
                        </template>
                    </div>
                </lst-show>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($lstCurrentWidget->showContactForm() || tdf_settings()->messageSystem()) : ?>
        <div class="listivo-listing-user-v2__bottom">
            <?php if (tdf_settings()->messageSystem()) :

                $lstInitialMessage = tdf_settings()->getMessageSystemInitialMessage($lstModel);
                ?>
                <lst-show class="listivo-listing-user-v2__button">
                    <div slot-scope="showProps" class="listivo-listing-user-v2__button">
                        <button
                                class="listivo-simple-button listivo-simple-button--background-primary-1 listivo-simple-button--height-60"
                                @click="showProps.onClick"
                        >
                            <div class="listivo-simple-button__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                     fill="none">
                                    <path
                                            d="M12.25 3.82163V3.3332C12.25 2.02462 11.204 0.95 9.925 0.95H3.275C1.99602 0.95 0.95 2.02462 0.95 3.3332V9.07646V11.2428C0.95 11.9764 1.81796 12.4397 2.40539 12.0191L2.40636 12.0191L2.41964 12.0092L3.87559 10.9231C4.1898 11.8577 5.0588 12.5365 6.075 12.5365H10.4375L13.5804 14.8808L13.5936 14.8907L13.5946 14.8907C14.182 15.3113 15.05 14.848 15.05 14.1144V11.9481V6.20483C15.05 4.89625 14.004 3.82163 12.725 3.82163H12.25ZM3.275 2.12686H9.925C10.5787 2.12686 11.1 2.65963 11.1 3.3332V7.28169C11.1 7.95526 10.5787 8.48803 9.925 8.48803H5.375C5.2531 8.48801 5.13445 8.52763 5.03612 8.60101C5.03612 8.60101 5.03612 8.60101 5.03611 8.60101L2.1 10.7912V9.07646V3.3332C2.1 2.65963 2.62128 2.12686 3.275 2.12686ZM12.25 4.99849H12.725C13.3787 4.99849 13.9 5.53126 13.9 6.20483V11.9481V13.6628L10.9639 11.4726C10.9639 11.4726 10.9639 11.4726 10.9639 11.4726C10.8655 11.3993 10.7469 11.3596 10.625 11.3597H6.075C5.42304 11.3597 4.90281 10.8298 4.90001 10.1588L5.56248 9.66489H9.925C11.204 9.66489 12.25 8.59027 12.25 7.28169V4.99849Z"
                                            fill="#FDFDFE" stroke="#FDFDFE" stroke-width="0.1"/>
                                </svg>
                            </div>

                            <?php echo esc_html($lstCurrentWidget->getChatButtonLabel()); ?>
                        </button>

                        <template>
                            <portal v-if="showProps.show" to="footer">
                                <div class="listivo-dark-mask listivo-dark-mask--active"></div>
                                <?php if(!is_user_logged_in()): ?>
                                <div class="listivo-user-popup">
                                    <div class="listivo-user-popup__form">
                                        <div class="listivo-user-popup__inner-form">
                                            <div
                                                    @click.prevent="showProps.onClick"
                                                    class="listivo-user-popup__close"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                                    fill="none">
                                                    <path d="M1.33403 0.000578098C1.06975 0.000905507 0.811563 0.0800467 0.592456 0.227892C0.373349 0.375737 0.203268 0.585574 0.10394 0.830597C0.00461216 1.07562 -0.0194532 1.3447 0.0348181 1.60348C0.0890895 1.86225 0.219234 2.09896 0.408626 2.28338L4.12063 5.99715L0.408626 9.71092C0.281072 9.83344 0.179237 9.9802 0.109083 10.1426C0.0389292 10.305 0.00186758 10.4797 6.87814e-05 10.6566C-0.00173002 10.8335 0.0317702 11.009 0.0986071 11.1728C0.165444 11.3366 0.264274 11.4854 0.38931 11.6105C0.514346 11.7356 0.663073 11.8345 0.826782 11.9013C0.990491 11.9682 1.16589 12.0017 1.34271 11.9999C1.51953 11.9981 1.69421 11.961 1.85652 11.8909C2.01884 11.8207 2.16552 11.7188 2.28799 11.5912L6 7.8774L9.712 11.5912C9.83447 11.7188 9.98115 11.8207 10.1435 11.8909C10.3058 11.9611 10.4805 11.9981 10.6573 11.9999C10.8341 12.0017 11.0095 11.9682 11.1732 11.9013C11.3369 11.8345 11.4857 11.7356 11.6107 11.6105C11.7357 11.4854 11.8346 11.3366 11.9014 11.1728C11.9682 11.009 12.0017 10.8336 11.9999 10.6566C11.9981 10.4797 11.9611 10.305 11.8909 10.1426C11.8208 9.9802 11.7189 9.83344 11.5914 9.71092L7.87936 5.99715L11.5914 2.28338C11.7834 2.09661 11.9146 1.85615 11.9677 1.59351C12.0208 1.33087 11.9934 1.0583 11.889 0.811532C11.7846 0.564762 11.6081 0.355297 11.3827 0.210589C11.1573 0.0658805 10.8934 -0.00732073 10.6257 0.000578098C10.2804 0.0108714 9.95272 0.155247 9.712 0.403119L6 4.11689L2.28799 0.403119C2.16398 0.275586 2.01566 0.174247 1.8518 0.105102C1.68793 0.0359579 1.51187 0.000414782 1.33403 0.000578098Z"
                                                        fill="#FDFDFE"/>
                                                </svg>
                                            </div>

                                            <?php get_template_part('templates/partials/login_and_register'); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div
                                        class="listivo-popup-wrapper"
                                        @click="showProps.onClick"
                                >
                                    <div class="listivo-popup-wrapper__container">
                                        <div
                                                class="listivo-popup-wrapper__modal"
                                                @click.stop.prevent
                                        >
                                            <div
                                                    class="listivo-popup-wrapper__close"
                                                    @click="showProps.onClick"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"
                                                     viewBox="0 0 8 8" fill="none">
                                                    <path
                                                            d="M0.889354 0.000385399C0.713166 0.000603672 0.541042 0.0533645 0.394971 0.151928C0.248899 0.250491 0.135512 0.390383 0.0692934 0.553731C0.00307477 0.71708 -0.0129688 0.89647 0.0232121 1.06899C0.059393 1.2415 0.146156 1.39931 0.272417 1.52225L2.74709 3.9981L0.272417 6.47394C0.187381 6.55563 0.119491 6.65346 0.0727219 6.76173C0.0259528 6.86999 0.00124506 6.9865 4.58543e-05 7.10443C-0.00115335 7.22237 0.0211801 7.33935 0.0657381 7.44855C0.110296 7.55774 0.176183 7.65694 0.25954 7.74033C0.342897 7.82373 0.442049 7.88965 0.551188 7.93423C0.660327 7.97881 0.77726 8.00115 0.895139 7.99995C1.01302 7.99875 1.12947 7.97403 1.23768 7.92724C1.34589 7.88045 1.44368 7.81252 1.52533 7.72745L4 5.2516L6.47467 7.72745C6.55631 7.81253 6.6541 7.88045 6.76231 7.92724C6.87052 7.97403 6.98698 7.99875 7.10486 7.99995C7.22274 8.00115 7.33967 7.97881 7.44881 7.93423C7.55795 7.88965 7.6571 7.82373 7.74046 7.74034C7.82382 7.65694 7.88971 7.55774 7.93426 7.44855C7.97882 7.33936 8.00115 7.22237 7.99995 7.10443C7.99875 6.9865 7.97405 6.86999 7.92728 6.76173C7.88051 6.65346 7.81261 6.55563 7.72758 6.47394L5.25291 3.9981L7.72758 1.52225C7.85561 1.39774 7.94306 1.23743 7.97847 1.06234C8.01387 0.887245 7.99558 0.705535 7.92599 0.541021C7.8564 0.376508 7.73876 0.236865 7.58848 0.140392C7.4382 0.0439203 7.26229 -0.00488048 7.08382 0.000385399C6.85363 0.00724757 6.63515 0.103498 6.47467 0.268746L4 2.74459L1.52533 0.268746C1.44266 0.183724 1.34377 0.116165 1.23453 0.0700682C1.12529 0.023972 1.00791 0.000276521 0.889354 0.000385399Z"
                                                            fill="#FDFDFE"/>
                                                </svg>
                                            </div>

                                            <lst-create-direct-message
                                                    request-url="<?php echo esc_url(tdf_action_url('listivo/directMessages/create')); ?>"
                                                    :user-id="<?php echo esc_attr($lstUser->getId()); ?>"
                                                    redirect-url="<?php echo esc_url($lstCurrentWidget->getChatRedirectUrl($lstUser->getId())); ?>"
                                                    :is-logged="<?php echo esc_attr(is_user_logged_in() ? 'true' : 'false'); ?>"
                                                    :same-user="<?php echo esc_attr($lstUser->getId() === get_current_user_id() ? 'true' : 'false'); ?>"
                                                    same-user-text="<?php echo esc_attr(tdf_string('same_user_message')); ?>"
                                                    initial-message="<?php echo esc_attr($lstInitialMessage); ?>"
                                                    td-nonce="<?php echo esc_attr(wp_create_nonce('listivo_create_message')); ?>"
                                                    create-message-nonce="<?php echo esc_attr(wp_create_nonce('listivo_create_message')); ?>"
                                            >
                                                <form slot-scope="props">
                                                    <div
                                                            class="listivo-create-message-form listivo-create-message-form--v2">
                                                        <div class="listivo-create-message-form__label">
                                                            <?php echo esc_html(tdf_string('send_message')); ?>
                                                        </div>

                                                        <div class="listivo-create-message-form__form">
                                                            <textarea
                                                                    @focusin="props.checkSameUser"
                                                                    @input="props.setMessage($event.target.value)"
                                                                    :value="props.message"
                                                            ></textarea>
                                                        </div>

                                                        <div class="listivo-create-message-form__button">
                                                            <button
                                                                    class="listivo-button listivo-button--primary-1"
                                                                    :disabled="props.inProgress"
                                                                    @click.prevent="props.onCreate"
                                                            >
                                                                <span>
                                                                    <?php echo esc_html(tdf_string('send')); ?>

                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                         height="11"
                                                                         viewBox="0 0 12 11"
                                                                         fill="none">
                                                                        <path
                                                                                d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                                                                fill="#FDFDFE"/>
                                                                    </svg>
                                                                </span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </lst-create-direct-message>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </portal>
                        </template>
                    </div>
                </lst-show>
            <?php endif; ?>

            <?php if ($lstCurrentWidget->showContactForm()) : ?>
                <lst-show class="listivo-listing-user-v2__button">
                    <div slot-scope="showProps" class="listivo-listing-user-v2__button">
                        <button
                                class="listivo-simple-button listivo-simple-button--background-primary-1 listivo-simple-button--height-60"
                                @click="showProps.onClick"
                        >
                            <div class="listivo-simple-button__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="11" viewBox="0 0 14 11"
                                     fill="none">
                                    <path
                                            d="M1.4 0C0.6279 0 0 0.616687 0 1.375V9.625C0 10.3833 0.6279 11 1.4 11H12.6C13.3721 11 14 10.3833 14 9.625V1.375C14 0.616687 13.3721 0 12.6 0H1.4ZM1.4 1.375H12.6V1.37903L7 4.8125L1.4 1.37769V1.375ZM1.4 2.75269L7 6.1875L12.6 2.75403L12.6014 9.625H1.4V2.75269Z"
                                            fill="#FDFDFE"/>
                                </svg>
                            </div>

                            <?php echo esc_html($lstCurrentWidget->getEmailButtonLabel()); ?>
                        </button>

                        <template>
                            <portal to="contact_form-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>">
                                <div
                                        v-show="showProps.show"
                                        class="listivo-popup-wrapper"
                                        @click="showProps.onClick"
                                >
                                    <div class="listivo-popup-wrapper__container">
                                        <div
                                                class="listivo-popup-wrapper__modal"
                                                @click.stop
                                        >
                                            <div
                                                    class="listivo-popup-wrapper__close"
                                                    @click="showProps.onClick"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"
                                                     viewBox="0 0 8 8" fill="none">
                                                    <path
                                                            d="M0.889354 0.000385399C0.713166 0.000603672 0.541042 0.0533645 0.394971 0.151928C0.248899 0.250491 0.135512 0.390383 0.0692934 0.553731C0.00307477 0.71708 -0.0129688 0.89647 0.0232121 1.06899C0.059393 1.2415 0.146156 1.39931 0.272417 1.52225L2.74709 3.9981L0.272417 6.47394C0.187381 6.55563 0.119491 6.65346 0.0727219 6.76173C0.0259528 6.86999 0.00124506 6.9865 4.58543e-05 7.10443C-0.00115335 7.22237 0.0211801 7.33935 0.0657381 7.44855C0.110296 7.55774 0.176183 7.65694 0.25954 7.74033C0.342897 7.82373 0.442049 7.88965 0.551188 7.93423C0.660327 7.97881 0.77726 8.00115 0.895139 7.99995C1.01302 7.99875 1.12947 7.97403 1.23768 7.92724C1.34589 7.88045 1.44368 7.81252 1.52533 7.72745L4 5.2516L6.47467 7.72745C6.55631 7.81253 6.6541 7.88045 6.76231 7.92724C6.87052 7.97403 6.98698 7.99875 7.10486 7.99995C7.22274 8.00115 7.33967 7.97881 7.44881 7.93423C7.55795 7.88965 7.6571 7.82373 7.74046 7.74034C7.82382 7.65694 7.88971 7.55774 7.93426 7.44855C7.97882 7.33936 8.00115 7.22237 7.99995 7.10443C7.99875 6.9865 7.97405 6.86999 7.92728 6.76173C7.88051 6.65346 7.81261 6.55563 7.72758 6.47394L5.25291 3.9981L7.72758 1.52225C7.85561 1.39774 7.94306 1.23743 7.97847 1.06234C8.01387 0.887245 7.99558 0.705535 7.92599 0.541021C7.8564 0.376508 7.73876 0.236865 7.58848 0.140392C7.4382 0.0439203 7.26229 -0.00488048 7.08382 0.000385399C6.85363 0.00724757 6.63515 0.103498 6.47467 0.268746L4 2.74459L1.52533 0.268746C1.44266 0.183724 1.34377 0.116165 1.23453 0.0700682C1.12529 0.023972 1.00791 0.000276521 0.889354 0.000385399Z"
                                                            fill="#FDFDFE"/>
                                                </svg>
                                            </div>

                                            <?php $lstCurrentWidget->displayForm(); ?>
                                        </div>
                                    </div>
                                </div>
                            </portal>
                        </template>
                    </div>
                </lst-show>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>