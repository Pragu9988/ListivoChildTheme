<?php

use Tangibledesign\Listivo\Widgets\General\MenuV2Widget;
use Tangibledesign\Listivo\Widgets\General\PanelWidget;

/* @var MenuV2Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstMenu = $lstCurrentWidget->getMenu();
$lstUser = tdf_current_user();
$lstSimpleMenu = tdf_settings()->showMenuAccount();
?>
<div class="listivo-app">
    <div class="listivo-menu-sticky-holder"></div>

    <lst-mobile-menu prefix="listivo">
        <div slot-scope="props">
            <div
                    class="listivo-menu-mobile-v2"
                    :class="{'listivo-menu-mobile-v2--open': props.show}"
            >
                <div class="listivo-menu-mobile-v2__top">
                    <div class="listivo-menu-mobile-v2__button">
                        <?php if ($lstCurrentWidget->getCtaType() === 'button' && tdf_settings()->showMenuCtaButton()) : ?>
                            <a
                                <?php if ($lstCurrentWidget->getCtaButtonStyle() === 'primary_1') : ?>
                                    class="listivo-button listivo-button--primary-1"
                                <?php else : ?>
                                    class="listivo-button listivo-button--primary-2"
                                <?php endif; ?>
                                    href="<?php echo esc_url($lstCurrentWidget->getCtaButtonUrl()); ?>"
                            >
                                <span>
                                    <?php if (!empty(tdf_settings()->getCustomMenuCtaText())) : ?>
                                        <?php echo esc_html(tdf_settings()->getCustomMenuCtaText()); ?>
                                    <?php else : ?>
                                        <?php echo esc_html(tdf_string('add_listing')); ?>
                                    <?php endif; ?>

                                    <?php if ($lstCurrentWidget->hasCtaButtonIcon()) : ?>
                                        <i class="<?php echo esc_attr($lstCurrentWidget->getCtaButtonIcon()); ?>"></i>
                                    <?php else : ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                             viewBox="0 0 12 12" fill="none">
                                            <path d="M5.00488 11.525V7.075H0.854883V5.125H5.00488V0.65H7.00488V5.125H11.1549V7.075H7.00488V11.525H5.00488Z"
                                                  fill="#FDFDFE"/>
                                        </svg>
                                    <?php endif; ?>
                                </span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div
                            class="listivo-menu-mobile-v2__close"
                            @click.prevent="props.onShow"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                            <path d="M15.9999 15.9999L1 1" stroke="#2A3946" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M16 1L1 16" stroke="#2A3946" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>

                <?php if ($lstMenu) : ?>
                    <?php $lstMenu->display('listivo-menu-mobile-v2', $lstCurrentWidget->getMenuMobileArgs()); ?>
                <?php endif; ?>

                <div class="listivo-menu-mobile-v2__info">
                    <?php if (tdf_currencies()->count() > 1) : ?>
                        <lst-currency-switcher
                                :initial-currency-id="<?php echo esc_attr(tdf_current_currency()->getId()); ?>"
                                request-url="<?php echo esc_url(tdf_action_url('listivo/currency/switch')); ?>"
                        >
                            <div slot-scope="switcher" class="listivo-menu-mobile-v2__data">
                                <div class="listivo-menu-mobile-v2__data-label">
                                    <?php echo esc_html(tdf_string('currency')); ?>
                                </div>

                                <div class="listivo-menu-mobile-v2__data-value listivo-menu-mobile-v2__currencies">
                                    <?php foreach (tdf_currencies() as $lstCurrency) : ?>
                                        <div
                                                class="listivo-menu-mobile-v2__currency"
                                                :class="{'listivo-menu-mobile-v2__currency--current': switcher.currencyId === <?php echo esc_attr($lstCurrency->getId()); ?>}"
                                                @click.stop.prevent="switcher.setCurrency(<?php echo esc_attr($lstCurrency->getId()); ?>)"
                                        >
                                            <?php echo esc_html($lstCurrency->getName()); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </lst-currency-switcher>
                    <?php endif; ?>

                    <?php if (!empty(tdf_settings()->getPhone())) : ?>
                        <div class="listivo-menu-mobile-v2__data">
                            <div class="listivo-menu-mobile-v2__data-label">
                                <?php echo esc_html(tdf_string('call_support')); ?>
                            </div>

                            <div class="listivo-menu-mobile-v2__data-value">
                                <a href="tel:<?php echo esc_attr(tdf_settings()->getPhoneUrl()); ?>">
                                    <?php echo esc_html(tdf_settings()->getPhone()); ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty(tdf_settings()->getMail())) : ?>
                        <div class="listivo-menu-mobile-v2__data">
                            <div class="listivo-menu-mobile-v2__data-label">
                                <?php echo esc_html(tdf_string('email_address')); ?>
                            </div>

                            <div class="listivo-menu-mobile-v2__data-value">
                                <a href="mailto:<?php echo esc_attr(tdf_settings()->getMail()); ?>">
                                    <?php echo esc_html(tdf_settings()->getMail()); ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="listivo-menu-mobile-v2__socials">
                    <div class="listivo-social-icons">
                        <?php if (!empty(tdf_settings()->getFacebookProfile()))  : ?>
                            <a
                                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1"
                                    href="<?php echo esc_url(tdf_settings()->getFacebookProfile()); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty(tdf_settings()->getTwitterProfile()))  : ?>
                            <a
                                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1"
                                    href="<?php echo esc_url(tdf_settings()->getTwitterProfile()); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty(tdf_settings()->getLinkedInProfile()))  : ?>
                            <a
                                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1"
                                    href="<?php echo esc_url(tdf_settings()->getLinkedInProfile()); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M100.3 448H7.4V148.9h92.9zM53.8 108.1C24.1 108.1 0 83.5 0 53.8a53.8 53.8 0 0 1 107.6 0c0 29.7-24.1 54.3-53.8 54.3zM447.9 448h-92.7V302.4c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7V448h-92.8V148.9h89.1v40.8h1.3c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3V448z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty(tdf_settings()->getInstagramProfile()))  : ?>
                            <a
                                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1"
                                    href="<?php echo esc_url(tdf_settings()->getInstagramProfile()); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty(tdf_settings()->getYouTubeProfile()))  : ?>
                            <a
                                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1"
                                    href="<?php echo esc_url(tdf_settings()->getYouTubeProfile()); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty(tdf_settings()->getTiktokProfile()))  : ?>
                            <a
                                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1"
                                    href="<?php echo esc_url(tdf_settings()->getTiktokProfile()); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty(tdf_settings()->getTelegramProfile()))  : ?>
                            <a
                                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1"
                                    href="<?php echo esc_url(tdf_settings()->getTelegramProfile()); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M248 8C111 8 0 119 0 256S111 504 248 504 496 393 496 256 385 8 248 8zM363 176.7c-3.7 39.2-19.9 134.4-28.1 178.3-3.5 18.6-10.3 24.8-16.9 25.4-14.4 1.3-25.3-9.5-39.3-18.7-21.8-14.3-34.2-23.2-55.3-37.2-24.5-16.1-8.6-25 5.3-39.5 3.7-3.8 67.1-61.5 68.3-66.7 .2-.7 .3-3.1-1.2-4.4s-3.6-.8-5.1-.5q-3.3 .7-104.6 69.1-14.8 10.2-26.9 9.9c-8.9-.2-25.9-5-38.6-9.1-15.5-5-27.9-7.7-26.8-16.3q.8-6.7 18.5-13.7 108.4-47.2 144.6-62.3c68.9-28.6 83.2-33.6 92.5-33.8 2.1 0 6.6 .5 9.6 2.9a10.5 10.5 0 0 1 3.5 6.7A43.8 43.8 0 0 1 363 176.7z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty(tdf_settings()->getEbayProfile())): ?>
                            <a
                                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1"
                                    href="<?php echo esc_url(tdf_settings()->getEbayProfile()); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                    <!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M606 189.5l-54.8 109.9-54.9-109.9h-37.5l10.9 20.6c-11.5-19-35.9-26-63.3-26-31.8 0-67.9 8.7-71.5 43.1h33.7c1.4-13.8 15.7-21.8 35-21.8 26 0 41 9.6 41 33v3.4c-12.7 0-28 .1-41.7 .4-42.4 .9-69.6 10-76.7 34.4 1-5.2 1.5-10.6 1.5-16.2 0-52.1-39.7-76.2-75.4-76.2-21.3 0-43 5.5-58.7 24.2v-80.6h-32.1v169.5c0 10.3-.6 22.9-1.1 33.1h31.5c.7-6.3 1.1-12.9 1.1-19.5 13.6 16.6 35.4 24.9 58.7 24.9 36.9 0 64.9-21.9 73.3-54.2-.5 2.8-.7 5.8-.7 9 0 24.1 21.1 45 60.6 45 26.6 0 45.8-5.7 61.9-25.5 0 6.6 .3 13.3 1.1 20.2h29.8c-.7-8.2-1-17.5-1-26.8v-65.6c0-9.3-1.7-17.2-4.8-23.8l61.5 116.1-28.5 54.1h35.9L640 189.5zM243.7 313.8c-29.6 0-50.2-21.5-50.2-53.8 0-32.4 20.6-53.8 50.2-53.8 29.8 0 50.2 21.4 50.2 53.8 0 32.3-20.4 53.8-50.2 53.8zm200.9-47.3c0 30-17.9 48.4-51.6 48.4-25.1 0-35-13.4-35-25.8 0-19.1 18.1-24.4 47.2-25.3 13.1-.5 27.6-.6 39.4-.6zm-411.9 1.6h128.8v-8.5c0-51.7-33.1-75.4-78.4-75.4-56.8 0-83 30.8-83 77.6 0 42.5 25.3 74 82.5 74 31.4 0 68-11.7 74.4-46.1h-33.1c-12 35.8-87.7 36.7-91.2-21.6zm95-21.4H33.3c6.9-56.6 92.1-54.7 94.4 0z"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div
                    class="listivo-dark-mask"
                    :class="{'listivo-dark-mask--active': props.show}"
                    @click.prevent="props.onShow"
            ></div>
        </div>
    </lst-mobile-menu>

    <div class="listivo-menu-v2-wrapper">
        <header
            <?php if (!$lstSimpleMenu) : ?>
                class="listivo-menu-v2 listivo-menu-v2--simple listivo-menu-v2--<?php echo esc_attr($lstCurrentWidget->getMenuStyle()); ?>"
            <?php else : ?>
                class="listivo-menu-v2 listivo-menu-v2--<?php echo esc_attr($lstCurrentWidget->getMenuStyle()); ?>"
            <?php endif; ?>
        >
            <div class="listivo-menu-v2__container">
                <lst-open-mobile-menu class="listivo-menu-v2__mobile-button">
                    <div
                            slot-scope="props"
                            class="listivo-menu-v2__mobile-button"
                            @click.prevent="props.onOpen"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M2.5 4.16668C2.38958 4.16512 2.27994 4.18552 2.17747 4.2267C2.07499 4.26787 1.98173 4.32901 1.90308 4.40655C1.82444 4.48408 1.762 4.57648 1.71937 4.67836C1.67675 4.78024 1.6548 4.88957 1.6548 5.00001C1.6548 5.11045 1.67675 5.21979 1.71937 5.32167C1.762 5.42355 1.82444 5.51594 1.90308 5.59348C1.98173 5.67102 2.07499 5.73215 2.17747 5.77333C2.27994 5.81451 2.38958 5.83491 2.5 5.83335H17.5C17.6104 5.83491 17.7201 5.81451 17.8225 5.77333C17.925 5.73215 18.0183 5.67102 18.0969 5.59348C18.1756 5.51594 18.238 5.42355 18.2806 5.32167C18.3233 5.21979 18.3452 5.11045 18.3452 5.00001C18.3452 4.88957 18.3233 4.78024 18.2806 4.67836C18.238 4.57648 18.1756 4.48408 18.0969 4.40655C18.0183 4.32901 17.925 4.26787 17.8225 4.2267C17.7201 4.18552 17.6104 4.16512 17.5 4.16668H2.5ZM2.5 9.16668C2.38958 9.16512 2.27994 9.18552 2.17747 9.2267C2.07499 9.26787 1.98173 9.32901 1.90308 9.40655C1.82444 9.48408 1.762 9.57648 1.71937 9.67836C1.67675 9.78024 1.6548 9.88957 1.6548 10C1.6548 10.1104 1.67675 10.2198 1.71937 10.3217C1.762 10.4235 1.82444 10.5159 1.90308 10.5935C1.98173 10.671 2.07499 10.7322 2.17747 10.7733C2.27994 10.8145 2.38958 10.8349 2.5 10.8333H17.5C17.6104 10.8349 17.7201 10.8145 17.8225 10.7733C17.925 10.7322 18.0183 10.671 18.0969 10.5935C18.1756 10.5159 18.238 10.4235 18.2806 10.3217C18.3233 10.2198 18.3452 10.1104 18.3452 10C18.3452 9.88957 18.3233 9.78024 18.2806 9.67836C18.238 9.57648 18.1756 9.48408 18.0969 9.40655C18.0183 9.32901 17.925 9.26787 17.8225 9.2267C17.7201 9.18552 17.6104 9.16512 17.5 9.16668H2.5ZM2.5 14.1667C2.38958 14.1651 2.27994 14.1855 2.17747 14.2267C2.07499 14.2679 1.98173 14.329 1.90308 14.4065C1.82444 14.4841 1.762 14.5765 1.71937 14.6784C1.67675 14.7802 1.6548 14.8896 1.6548 15C1.6548 15.1104 1.67675 15.2198 1.71937 15.3217C1.762 15.4235 1.82444 15.5159 1.90308 15.5935C1.98173 15.671 2.07499 15.7321 2.17747 15.7733C2.27994 15.8145 2.38958 15.8349 2.5 15.8333H17.5C17.6104 15.8349 17.7201 15.8145 17.8225 15.7733C17.925 15.7321 18.0183 15.671 18.0969 15.5935C18.1756 15.5159 18.238 15.4235 18.2806 15.3217C18.3233 15.2198 18.3452 15.1104 18.3452 15C18.3452 14.8896 18.3233 14.7802 18.2806 14.6784C18.238 14.5765 18.1756 14.4841 18.0969 14.4065C18.0183 14.329 17.925 14.2679 17.8225 14.2267C17.7201 14.1855 17.6104 14.1651 17.5 14.1667H2.5Z"
                                  fill="#2A3946"/>
                        </svg>
                    </div>
                </lst-open-mobile-menu>

                <div class="listivo-menu-v2__left">
                    <?php if ($lstCurrentWidget->hasLogo()) :
                        $lstLogo = $lstCurrentWidget->getLogo();
                        ?>
                        <a
                                class="listivo-menu-v2__logo"
                                href="<?php echo esc_url(get_site_url()); ?>"
                                title="<?php echo esc_attr(get_bloginfo('name')); ?>"
                        >
                            <img
                                    src="<?php echo esc_url($lstCurrentWidget->getLogoUrl()); ?>"
                                    alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                                    style="aspect-ratio: <?php echo esc_attr($lstLogo->getWidth()); ?> / <?php echo esc_attr($lstLogo->getHeight()); ?>"
                            >
                        </a>

                        <a
                                class="listivo-menu-v2__logo listivo-menu-v2__logo--sticky"
                                href="<?php echo esc_url(get_site_url()); ?>"
                                title="<?php echo esc_attr(get_bloginfo('name')); ?>"
                        >
                            <img
                                    src="<?php echo esc_url($lstCurrentWidget->getStickyLogoUrl()); ?>"
                                    alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                            >
                        </a>
                    <?php endif; ?>

                    <?php
                    if ($lstMenu) :
                        $lstMenu->display('', $lstCurrentWidget->getMenuArgs());
                    endif;
                    ?>
                </div>

                <div class="listivo-menu-v2__right">
                    <?php if (tdf_currencies()->count() > 1) : ?>
                        <lst-currency-switcher
                                :initial-currency-id="<?php echo esc_attr(tdf_current_currency()->getId()); ?>"
                                request-url="<?php echo esc_url(tdf_action_url('listivo/currency/switch')); ?>"
                        >
                            <div slot-scope="switcher"
                                 class="listivo-menu-v2__currency-switcher listivo-currency-switcher">
                                <div class="listivo-currency-switcher__current">
                                    <?php echo esc_html(tdf_current_currency()->getName()); ?>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5"
                                         fill="none">
                                        <path opacity="0.4"
                                              d="M3.5 2.56793L5.87477 0.193161C6.13207 -0.0641413 6.54972 -0.0641413 6.80702 0.193161C7.06433 0.450464 7.06433 0.868114 6.80702 1.12542L3.9394 3.99304C3.6964 4.23604 3.30298 4.23604 3.0606 3.99304L0.192977 1.12542C-0.0643257 0.868114 -0.0643257 0.450464 0.192977 0.193161C0.45028 -0.0641413 0.86793 -0.0641413 1.12523 0.193161L3.5 2.56793Z"
                                              fill="#2A3946"/>
                                    </svg>
                                </div>

                                <div class="listivo-currency-switcher__dropdown">
                                    <?php foreach (tdf_currencies() as $lstCurrency) : ?>
                                        <div
                                                @click="switcher.setCurrency(<?php echo esc_attr($lstCurrency->getId()); ?>)"
                                                class="listivo-currency-switcher__option"
                                                :class="{'listivo-currency-switcher__option--selected': switcher.currencyId === <?php echo esc_attr($lstCurrency->getId()); ?>}"
                                        >
                                            <div
                                                    class="listivo-currency-switcher__checkbox"
                                                    :class="{'listivo-currency-switcher__checkbox--checked': switcher.currencyId === <?php echo esc_attr($lstCurrency->getId()); ?>}"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                                     viewBox="0 0 10 10" fill="none">
                                                    <path d="M9.76184 0.728889L8.8648 0.0970432C8.6166 -0.0771195 8.27655 -0.0102893 8.11043 0.244879L3.71321 6.96431L1.69244 4.87031C1.48138 4.65159 1.13741 4.65159 0.926348 4.87031L0.1583 5.66619C-0.0527667 5.88491 -0.0527667 6.24133 0.1583 6.46207L3.26567 9.68205C3.43961 9.86229 3.71321 10 3.95946 10C4.2057 10 4.4539 9.84001 4.61415 9.59902L9.90646 1.50857C10.0745 1.2534 10.01 0.903051 9.76184 0.728889Z"
                                                          fill="#FDFDFE"/>
                                                </svg>
                                            </div>

                                            <?php echo esc_html($lstCurrency->getName()); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </lst-currency-switcher>
                    <?php endif; ?>

                    <?php if (tdf_settings()->showMenuAccount()) : ?>
                        <div class="listivo-menu-v2__account">
                            <?php if ($lstUser) : ?>
                                <div class="listivo-menu-v2__user-menu">
                                    <div class="listivo-user-dropdown">
                                        <div class="listivo-user-dropdown__list">
                                            <?php if ($lstUser->canCreateModels() && !is_tdf_buyer()) : ?>
                                                <a
                                                        class="listivo-user-dropdown__item"
                                                        href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_CREATE)); ?>"
                                                >
                                                    <div class="listivo-user-dropdown__icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                             viewBox="0 0 14 14" fill="none">
                                                            <path
                                                                    class="listivo-user-dropdown__icon-stroke"
                                                                    d="M7 13C10.3137 13 13 10.3137 13 7C13 3.68629 10.3137 1 7 1C3.68629 1 1 3.68629 1 7C1 10.3137 3.68629 13 7 13Z"
                                                                    stroke="#2A3946" stroke-width="1.2"
                                                                    stroke-miterlimit="10"
                                                                    stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path
                                                                    class="listivo-user-dropdown__icon-stroke"
                                                                    d="M4.3335 7H9.66683" stroke="#2A3946"
                                                                    stroke-width="1.2"
                                                                    stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path
                                                                    class="listivo-user-dropdown__icon-stroke"
                                                                    d="M7 9.66683L7 4.3335" stroke="#2A3946"
                                                                    stroke-width="1.2"
                                                                    stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </div>

                                                    <div class="listivo-user-dropdown__label">
                                                        <?php echo esc_html(tdf_string('add_listing')); ?>
                                                    </div>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (tdf_current_user()->isModerator() && !is_tdf_buyer()) : ?>
                                                <a
                                                        class="listivo-user-dropdown__item"
                                                        href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_MODERATION)); ?>"
                                                >
                                                    <div class="listivo-user-dropdown__icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="14"
                                                             viewBox="0 0 11 14" fill="none">
                                                            <path
                                                                    class="listivo-user-dropdown__icon-fill"
                                                                    d="M8.09077 8.09077C8.32508 7.85645 8.32508 7.47655 8.09077 7.24224C7.85645 7.00793 7.47655 7.00793 7.24224 7.24224L8.09077 8.09077ZM4.99984 10.3332L4.57557 10.7574C4.80989 10.9917 5.18979 10.9917 5.4241 10.7574L4.99984 10.3332ZM4.09077 8.57557C3.85645 8.34126 3.47655 8.34126 3.24224 8.57557C3.00793 8.80989 3.00793 9.18979 3.24224 9.4241L4.09077 8.57557ZM7.24224 7.24224L4.57557 9.90891L5.4241 10.7574L8.09077 8.09077L7.24224 7.24224ZM5.4241 9.90891L4.09077 8.57557L3.24224 9.4241L4.57557 10.7574L5.4241 9.90891Z"
                                                                    fill="#2A3946"/>
                                                            <path
                                                                    class="listivo-user-dropdown__icon-stroke"
                                                                    d="M9.66667 13H1.66667C1.29848 13 1 12.7015 1 12.3333L1 1.66667C1 1.29848 1.29848 1 1.66667 1L6.70872 1C6.89443 1 7.07173 1.07746 7.1979 1.21373L10.1558 4.40831C10.2699 4.53154 10.3333 4.6933 10.3333 4.86125L10.3333 12.3333C10.3333 12.7015 10.0349 13 9.66667 13Z"
                                                                    stroke="#2A3946" stroke-width="1.2"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"/>
                                                            <path
                                                                    class="listivo-user-dropdown__icon-stroke"
                                                                    d="M10.3335 5L7.00016 5C6.63197 5 6.3335 4.70152 6.3335 4.33333L6.3335 1"
                                                                    stroke="#2A3946" stroke-width="1.2"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"/>
                                                        </svg>
                                                    </div>

                                                    <div class="listivo-user-dropdown__label">
                                                        <span>
                                                            <?php echo esc_html(tdf_string('moderation')); ?>
                                                        </span>

                                                        <div class="listivo-user-dropdown__count">
                                                            <?php echo esc_html(tdf_app('models_pending_count')); ?>
                                                        </div>
                                                    </div>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (class_exists(\WooCommerce::class) && tdf_settings()->paymentsEnabled() && tdf_current_user()->canSeeOrders() && !is_tdf_buyer()) : ?>
                                                <a
                                                        class="listivo-user-dropdown__item"
                                                        href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_ORDERS)); ?>"
                                                >
                                                    <div class="listivo-user-dropdown__icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11"
                                                             viewBox="0 0 12 11" fill="none">
                                                            <path
                                                                    class="listivo-user-dropdown__icon-fill"
                                                                    d="M1.2 0C0.5382 0 0 0.5382 0 1.2V9.6C0 10.2618 0.5382 10.8 1.2 10.8H10.8C11.4618 10.8 12 10.2618 12 9.6V1.2C12 0.5382 11.4618 0 10.8 0H1.2ZM1.2 1.2H10.8L10.8012 9.6H1.2V1.2ZM2.4 2.4V3.6H6.6V2.4H2.4ZM7.8 2.4V3.6H9.6V2.4H7.8ZM2.4 4.8V6H6.6V4.8H2.4ZM7.8 4.8V6H9.6V4.8H7.8ZM6.6 7.2V8.4H9.6V7.2H6.6Z"
                                                                    fill="#374B5C"/>
                                                        </svg>
                                                    </div>

                                                    <div class="listivo-user-dropdown__label">
                                                        <?php echo esc_html(tdf_string('orders')); ?>
                                                    </div>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($lstUser->canCreateModels() && !is_tdf_buyer()) : ?>
                                                <a
                                                        class="listivo-user-dropdown__item"
                                                        href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_LIST)); ?>"
                                                >
                                                    <div class="listivo-user-dropdown__icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="14"
                                                             viewBox="0 0 11 14" fill="none">
                                                            <path
                                                                    class="listivo-user-dropdown__icon-stroke"
                                                                    d="M9.66667 13H1.66667C1.29848 13 1 12.7015 1 12.3333L1 1.66667C1 1.29848 1.29848 1 1.66667 1L6.70872 1C6.89443 1 7.07173 1.07746 7.1979 1.21373L10.1558 4.40831C10.2699 4.53154 10.3333 4.6933 10.3333 4.86125L10.3333 12.3333C10.3333 12.7015 10.0349 13 9.66667 13Z"
                                                                    stroke="#2A3946" stroke-width="1.2"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"/>
                                                            <path
                                                                    class="listivo-user-dropdown__icon-stroke"
                                                                    d="M3.6665 10.3335H7.6665" stroke="#2A3946"
                                                                    stroke-width="1.2"
                                                                    stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path
                                                                    class="listivo-user-dropdown__icon-stroke"
                                                                    d="M3.6665 8.3335H7.6665" stroke="#2A3946"
                                                                    stroke-width="1.2"
                                                                    stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path
                                                                    class="listivo-user-dropdown__icon-stroke"
                                                                    d="M10.3335 5L7.00016 5C6.63197 5 6.3335 4.70152 6.3335 4.33333L6.3335 1"
                                                                    stroke="#2A3946" stroke-width="1.2"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"/>
                                                        </svg>
                                                    </div>

                                                    <div class="listivo-user-dropdown__label">
                                                        <span>
                                                            <?php echo esc_html(tdf_string('my_listings')); ?>
                                                        </span>

                                                        <?php if (!empty(tdf_current_user()->getCurrentUserPublishModelNumber())) : ?>
                                                            <div class="listivo-user-dropdown__count">
                                                                <?php echo esc_html(tdf_current_user()->getCurrentUserPublishModelNumber()); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (tdf_settings()->messageSystem()) : ?>
                                                <a
                                                        class="listivo-user-dropdown__item"
                                                        href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_MESSAGES)); ?>"
                                                >
                                                    <div class="listivo-user-dropdown__icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12"
                                                             viewBox="0 0 14 12" fill="none">
                                                            <path
                                                                    class="listivo-user-dropdown__icon-stroke"
                                                                    d="M12.3333 1H1.66667C1.29848 1 1 1.29848 1 1.66667V10.2796C1 10.8386 1.64662 11.1494 2.08313 10.8002L4.15072 9.14609C4.26893 9.05152 4.41581 9 4.56719 9H12.3333C12.7015 9 13 8.70152 13 8.33333V1.66667C13 1.29848 12.7015 1 12.3333 1Z"
                                                                    stroke="#2A3946" stroke-width="1.2"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"/>
                                                            <path
                                                                    class="listivo-user-dropdown__icon-stroke"
                                                                    d="M9.6665 5H9.6685V5.002H9.6665V5Z"
                                                                    stroke="#2A3946"
                                                                    stroke-width="1.2" stroke-linecap="round"
                                                                    stroke-linejoin="round"/>
                                                            <path
                                                                    class="listivo-user-dropdown__icon-stroke"
                                                                    d="M7 5H7.002V5.002H7V5Z" stroke="#2A3946"
                                                                    stroke-width="1.2"
                                                                    stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path
                                                                    class="listivo-user-dropdown__icon-stroke"
                                                                    d="M4.3335 5H4.3355V5.002H4.3335V5Z"
                                                                    stroke="#2A3946"
                                                                    stroke-width="1.2" stroke-linecap="round"
                                                                    stroke-linejoin="round"/>
                                                        </svg>
                                                    </div>

                                                    <lst-direct-message-count>
                                                        <div
                                                                class="listivo-user-dropdown__label"
                                                                slot-scope="props"
                                                        >
                                                            <span>
                                                                <?php echo esc_html(tdf_string('messages')); ?>
                                                            </span>

                                                            <div
                                                                    v-if="props.count > 0"
                                                                    class="listivo-user-dropdown__count"
                                                            >
                                                                {{ props.count }}
                                                            </div>
                                                        </div>
                                                    </lst-direct-message-count>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (tdf_settings()->isFavoriteEnabled()) : ?>
                                                <a
                                                        class="listivo-user-dropdown__item"
                                                        href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_FAVORITES)); ?>"
                                                >
                                                    <div class="listivo-user-dropdown__icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13"
                                                             viewBox="0 0 14 13" fill="none">
                                                            <path
                                                                    class="listivo-user-dropdown__icon-fill"
                                                                    d="M7 11.6405L6.55604 12.0441C6.66975 12.1692 6.83095 12.2405 7 12.2405C7.16905 12.2405 7.33025 12.1692 7.44396 12.0441L7 11.6405ZM12.2422 5.87404L12.6862 6.27765L12.2422 5.87404ZM7.81072 2.09364L8.27924 2.46845L8.27924 2.46845L7.81072 2.09364ZM7 3.10704L6.53148 3.48185C6.64534 3.62418 6.81773 3.70704 7 3.70704C7.18227 3.70704 7.35466 3.62418 7.46852 3.48185L7 3.10704ZM6.18928 2.09364L6.6578 1.71882V1.71882L6.18928 2.09364ZM1.75779 5.87404L1.31383 6.27764H1.31383L1.75779 5.87404ZM1.85347 1.8535L1.4292 1.42923L1.4292 1.42923L1.85347 1.8535ZM12.1465 1.8535L11.7223 2.27776V2.27776L12.1465 1.8535ZM7.44396 12.0441L12.6862 6.27765L11.7982 5.47044L6.55604 11.2369L7.44396 12.0441ZM7.3422 1.71882L6.53148 2.73222L7.46852 3.48185L8.27924 2.46845L7.3422 1.71882ZM7.46852 2.73222L6.6578 1.71882L5.72076 2.46846L6.53148 3.48185L7.46852 2.73222ZM1.31383 6.27764L6.55604 12.0441L7.44396 11.2369L2.20176 5.47044L1.31383 6.27764ZM1.4292 1.42923C0.102886 2.75555 0.0521005 4.88974 1.31383 6.27764L2.20176 5.47044C1.37091 4.5565 1.40435 3.15114 2.27773 2.27776L1.4292 1.42923ZM6.6578 1.71882C5.34949 0.0834286 2.91011 -0.0516763 1.4292 1.42923L2.27773 2.27776C3.25291 1.30258 4.85924 1.39155 5.72076 2.46846L6.6578 1.71882ZM12.5708 1.42923C11.0899 -0.0516764 8.65051 0.0834281 7.3422 1.71882L8.27924 2.46845C9.14077 1.39155 10.7471 1.30258 11.7223 2.27776L12.5708 1.42923ZM12.6862 6.27765C13.9479 4.88974 13.8971 2.75555 12.5708 1.42923L11.7223 2.27776C12.5956 3.15114 12.6291 4.55651 11.7982 5.47044L12.6862 6.27765Z"
                                                                    fill="#2A3946"/>
                                                        </svg>
                                                    </div>

                                                    <div class="listivo-user-dropdown__label">
                                                        <span>
                                                            <?php echo esc_html(tdf_string('favorites')); ?>
                                                        </span>

                                                        <div class="listivo-user-dropdown__count">
                                                            <?php echo esc_html(tdf_current_user()->getFavoriteNumber()); ?>
                                                        </div>
                                                    </div>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (class_exists(\WooCommerce::class) && tdf_settings()->paymentsEnabled() && $lstUser->canCreateModels() && !is_tdf_buyer()) : ?>
                                                <a
                                                        class="listivo-user-dropdown__item"
                                                        href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_MY_ORDERS)); ?>"
                                                >
                                                    <div class="listivo-user-dropdown__icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="13"
                                                             viewBox="0 0 11 13" fill="none">
                                                            <path
                                                                    class="listivo-user-dropdown__icon-fill"
                                                                    fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M1.62351 0.0294738C1.00828 0.123984 0.360164 0.693778 0.124588 1.34723C0.0561244 1.53719 0.0468697 1.65439 0.0241885 2.61874C-0.00806285 3.99129 -0.00806285 9.00397 0.0241885 10.3765C0.0468697 11.3409 0.0561244 11.4581 0.124588 11.648C0.303549 12.1444 0.729267 12.6143 1.18713 12.8206C1.41254 12.9222 1.5074 12.9452 1.80061 12.9693C1.99138 12.9849 3.77355 12.9982 5.76097 12.9988L9.37442 13L9.5992 12.9161C10.2632 12.6684 10.7137 12.1819 10.9256 11.4835L11 11.2386L10.9908 6.42971L10.9816 1.62085L10.8788 1.35042C10.7084 0.902369 10.3402 0.457053 9.96494 0.245372C9.61628 0.0486912 9.44783 0.0137007 8.84315 0.0124775C8.33902 0.0114796 8.26985 0.0180464 8.1596 0.0775334C7.88757 0.224255 7.79355 0.609118 7.9594 0.897058C8.08058 1.10748 8.20763 1.15348 8.72558 1.17447C8.96378 1.18413 9.209 1.20605 9.27048 1.22321C9.41695 1.26406 9.64074 1.47203 9.73378 1.65381L9.80789 1.79854L9.79878 6.54182L9.78966 11.2851L9.66697 11.452C9.59948 11.5437 9.47451 11.6616 9.38929 11.7139L9.23427 11.809H5.52263C2.17858 11.809 1.79987 11.8038 1.69877 11.7571C1.54025 11.6838 1.36539 11.525 1.27722 11.3744C1.20294 11.2475 1.20143 11.2121 1.17108 8.87969C1.15334 7.51496 1.15344 5.50569 1.17132 4.13167C1.20185 1.78544 1.20347 1.74768 1.27747 1.62085C1.45335 1.31939 1.69965 1.18654 2.08439 1.18564C2.4645 1.18474 2.79385 1.13597 2.89691 1.06528C3.03843 0.968294 3.12299 0.783459 3.12085 0.575834C3.11766 0.262755 2.96425 0.0811709 2.65793 0.0278322C2.44073 -0.00999105 1.87458 -0.00908977 1.62351 0.0294738ZM4.27695 0.025611C3.87427 0.0858063 3.6871 0.598367 3.9434 0.939066C4.12004 1.17389 4.09915 1.17087 5.505 1.16462C6.66293 1.15947 6.76781 1.15442 6.87203 1.0985C7.21383 0.915213 7.28054 0.4501 7.00405 0.177934C6.87852 0.0543566 6.85577 0.0453435 6.61248 0.0229714C6.29032 -0.00664333 4.47902 -0.00458315 4.27695 0.025611ZM2.49804 3.17981C2.22492 3.24049 2.0949 3.41847 2.0949 3.73167C2.0949 3.87582 2.1158 3.96389 2.17164 4.05515C2.32518 4.30601 2.17949 4.28994 4.53128 4.31515C5.68813 4.32751 7.06403 4.32905 7.58889 4.31856C8.66083 4.29712 8.69273 4.29043 8.82128 4.05901C8.9702 3.791 8.94604 3.54317 8.74612 3.28752L8.63846 3.14987L5.62082 3.15316C3.96114 3.15499 2.55589 3.16696 2.49804 3.17981ZM2.91693 5.56238C2.34632 5.58305 2.2705 5.61128 2.15797 5.84488C2.10405 5.95674 2.0907 6.03985 2.10153 6.19591C2.11664 6.41387 2.17609 6.51868 2.35379 6.64049C2.44984 6.70632 2.47491 6.70686 5.48912 6.70686C8.46452 6.70686 8.53014 6.70551 8.64691 6.64248C8.81704 6.55068 8.90888 6.36996 8.90888 6.12715C8.90888 5.90475 8.83814 5.76032 8.67415 5.64797C8.58086 5.58404 8.51843 5.57905 7.56989 5.55964C6.38304 5.53537 3.61829 5.53698 2.91693 5.56238ZM2.49804 7.91173C2.33083 7.94888 2.23832 8.01699 2.16403 8.15754C2.0066 8.45555 2.11958 8.86749 2.39288 8.99171C2.52924 9.05371 2.61296 9.05544 5.44274 9.05515C7.04304 9.05499 8.41106 9.04385 8.48281 9.03037C8.79439 8.97188 8.97391 8.66221 8.89602 8.31762C8.84803 8.10532 8.71993 7.96694 8.52562 7.9174C8.36836 7.87729 2.67715 7.87198 2.49804 7.91173Z"
                                                                    fill="#374B5C"/>
                                                        </svg>
                                                    </div>

                                                    <div class="listivo-user-dropdown__label">
                                                        <?php echo esc_html(tdf_string('my_orders')); ?>
                                                    </div>
                                                </a>
                                            <?php endif; ?>

                                            <a
                                                    class="listivo-user-dropdown__item"
                                                    href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_SETTINGS)); ?>"
                                            >
                                                <div class="listivo-user-dropdown__icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13"
                                                         viewBox="0 0 14 13" fill="none">
                                                        <path
                                                                class="listivo-user-dropdown__icon-stroke"
                                                                d="M8.3335 10.6665L13.0002 10.6665" stroke="#2A3946"
                                                                stroke-width="1.2" stroke-linecap="round"
                                                                stroke-linejoin="round"/>
                                                        <path
                                                                class="listivo-user-dropdown__icon-stroke"
                                                                d="M1 10.6665H2.33333" stroke="#2A3946"
                                                                stroke-width="1.2"
                                                                stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path
                                                                class="listivo-user-dropdown__icon-stroke"
                                                                d="M4.00016 12.3333C4.92064 12.3333 5.66683 11.5871 5.66683 10.6667C5.66683 9.74619 4.92064 9 4.00016 9C3.07969 9 2.3335 9.74619 2.3335 10.6667C2.3335 11.5871 3.07969 12.3333 4.00016 12.3333Z"
                                                                stroke="#2A3946" stroke-width="1.2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"/>
                                                        <path
                                                                class="listivo-user-dropdown__icon-stroke"
                                                                d="M12.3335 6.6665H13.0002" stroke="#2A3946"
                                                                stroke-width="1.2"
                                                                stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path
                                                                class="listivo-user-dropdown__icon-stroke"
                                                                d="M1 6.6665H5.66667" stroke="#2A3946"
                                                                stroke-width="1.2"
                                                                stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path
                                                                class="listivo-user-dropdown__icon-stroke"
                                                                d="M10.0002 8.33333C10.9206 8.33333 11.6668 7.58714 11.6668 6.66667C11.6668 5.74619 10.9206 5 10.0002 5C9.07969 5 8.3335 5.74619 8.3335 6.66667C8.3335 7.58714 9.07969 8.33333 10.0002 8.33333Z"
                                                                stroke="#2A3946" stroke-width="1.2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"/>
                                                        <path
                                                                class="listivo-user-dropdown__icon-stroke"
                                                                d="M7.6665 2.6665H12.9998" stroke="#2A3946"
                                                                stroke-width="1.2"
                                                                stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path
                                                                class="listivo-user-dropdown__icon-stroke"
                                                                d="M1 2.6665H1.66667" stroke="#2A3946"
                                                                stroke-width="1.2"
                                                                stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path
                                                                class="listivo-user-dropdown__icon-stroke"
                                                                d="M6.00016 4.33333C6.92064 4.33333 7.66683 3.58714 7.66683 2.66667C7.66683 1.74619 6.92064 1 6.00016 1C5.07969 1 4.3335 1.74619 4.3335 2.66667C4.3335 3.58714 5.07969 4.33333 6.00016 4.33333Z"
                                                                stroke="#2A3946" stroke-width="1.2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"/>
                                                    </svg>
                                                </div>

                                                <div class="listivo-user-dropdown__label">
                                                    <?php echo esc_html(tdf_string('settings')); ?>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="listivo-user-dropdown__separator"></div>

                                        <div class="listivo-user-dropdown__bottom">
                                            <a
                                                    class="listivo-user-dropdown__item"
                                                    href="<?php echo esc_url(tdf_logout_url()); ?>"
                                            >
                                                <div class="listivo-user-dropdown__icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                         viewBox="0 0 14 14" fill="none">
                                                        <path
                                                                class="listivo-user-dropdown__icon-fill"
                                                                d="M7.42426 8.82574C7.65858 9.06005 7.65858 9.43995 7.42426 9.67426C7.18995 9.90858 6.81005 9.90858 6.57574 9.67426L7.42426 8.82574ZM4.75 7L4.32574 7.42426C4.21321 7.31174 4.15 7.15913 4.15 7C4.15 6.84087 4.21321 6.68826 4.32574 6.57574L4.75 7ZM6.57574 4.32574C6.81005 4.09142 7.18995 4.09142 7.42426 4.32574C7.65858 4.56005 7.65858 4.93995 7.42426 5.17426L6.57574 4.32574ZM13 6.4C13.3314 6.4 13.6 6.66863 13.6 7C13.6 7.33137 13.3314 7.6 13 7.6L13 6.4ZM6.57574 9.67426L4.32574 7.42426L5.17426 6.57574L7.42426 8.82574L6.57574 9.67426ZM4.32574 6.57574L6.57574 4.32574L7.42426 5.17426L5.17426 7.42426L4.32574 6.57574ZM13 7.6L4.75 7.6V6.4L13 6.4L13 7.6Z"
                                                                fill="#2A3946"/>
                                                        <path
                                                                class="listivo-user-dropdown__icon-stroke"
                                                                d="M9.25 3.25V1.75C9.25 1.33579 8.91421 1 8.5 1H1.75C1.33579 1 1 1.33579 1 1.75V12.25C1 12.6642 1.33579 13 1.75 13H8.5C8.91421 13 9.25 12.6642 9.25 12.25V10.75"
                                                                stroke="#2A3946" stroke-width="1.2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"/>
                                                    </svg>
                                                </div>

                                                <div class="listivo-user-dropdown__label">
                                                    <?php echo esc_html(tdf_string('log_out')); ?>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <a
                                <?php if ($lstUser && $lstUser->hasImageUrl())  : ?>
                                    class="listivo-menu-v2__avatar listivo-menu-v2__avatar--no-border"
                                <?php else : ?>
                                    class="listivo-menu-v2__avatar"
                                <?php endif; ?>
                                <?php if ($lstUser) : ?>
                                    href="<?php echo esc_url(tdf_settings()->getPanelPageUrl()); ?>"
                                <?php else : ?>
                                    href="<?php echo esc_url(tdf_settings()->getLoginPageUrlWithoutTab()); ?>"
                                <?php endif; ?>
                            >
                                <?php if ($lstUser && $lstUser->hasImageUrl()) : ?>
                                    <img
                                            class="lazyload"
                                            data-src="<?php echo esc_url($lstUser->getImageUrl('listivo_100_100')); ?>"
                                            alt="<?php echo esc_attr($lstUser->getDisplayName()); ?>"
                                    >
                                <?php else : ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20"
                                         fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M9 0C5.53008 0 2.7 2.83008 2.7 6.3C2.7 8.46914 3.80742 10.3957 5.48438 11.5312C2.27461 12.9094 0 16.0945 0 19.8H1.8C1.8 17.1984 3.17461 14.9344 5.23125 13.6687C5.83594 15.1523 7.30898 16.2 9 16.2C10.691 16.2 12.1641 15.1523 12.7688 13.6687C14.8254 14.9344 16.2 17.1984 16.2 19.8H18C18 16.0945 15.7254 12.9094 12.5156 11.5312C14.1926 10.3957 15.3 8.46914 15.3 6.3C15.3 2.83008 12.4699 0 9 0ZM9 1.8C11.4961 1.8 13.5 3.80391 13.5 6.3C13.5 8.79609 11.4961 10.8 9 10.8C6.50391 10.8 4.5 8.79609 4.5 6.3C4.5 3.80391 6.50391 1.8 9 1.8ZM11.1094 12.9094C10.4414 12.7055 9.73828 12.6 9 12.6C8.26172 12.6 7.55859 12.7055 6.89062 12.9094C7.20352 13.7777 8.01914 14.4 9 14.4C9.98086 14.4 10.7965 13.7777 11.1094 12.9094Z"
                                              fill="#FDFDFE"
                                        />
                                    </svg>
                                <?php endif; ?>
                            </a>

                            <?php if ($lstUser) : ?>
                                <a
                                        class="listivo-menu-v2__account-link"
                                        href="<?php echo esc_url(tdf_settings()->getPanelPageUrl()); ?>"
                                >
                                    <?php echo esc_html($lstUser->getDisplayName()); ?>
                                </a>
                            <?php else : ?>
                                <a
                                        class="listivo-menu-v2__account-link"
                                        href="<?php echo esc_url(tdf_settings()->getLoginPageUrl()); ?>"
                                >
                                    <?php echo esc_html(tdf_string('log_in')); ?>
                                </a>

                                <?php if (tdf_settings()->userRegistrationOpen()): ?>
                                    <div class="listivo-menu-v2__separator"></div>

                                    <div class="listivo-menu-v2__register-wrapper" style="position: relative; height: 100%; display: flex; align-items: center;">
                                        <a
                                                class="listivo-menu-v2__account-link"
                                                href="javascript:void(0);"
                                                style="display: flex; align-items: center; cursor: pointer;"
                                        >
                                            <?php echo esc_html(tdf_string('register')); ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6" fill="none" style="margin-left: 6px;">
                                                <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>

                                        <div class="listivo-user-dropdown listivo-menu-v2__register-dropdown" style="display: none; position: absolute; top: 100%; right: 0; min-width: 220px; z-index: 1000;">
                                            <div class="listivo-user-dropdown__list" style="background: #fff; border-radius: 4px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); overflow: hidden;">
                                                <a class="listivo-user-dropdown__item" href="<?php echo esc_url(home_url('/buyer-register'))?>">
                                                    <div class="listivo-user-dropdown__icon">
                                                        <i class="far fa-user"></i>
                                                    </div>
                                                    <div class="listivo-user-dropdown__label">
                                                        <?php esc_html_e('As Buyer', 'listivo'); ?>
                                                    </div>
                                                </a>
                                                <a class="listivo-user-dropdown__item" href="<?php echo esc_url(tdf_settings()->getRegisterPageUrl()); ?>">
                                                    <div class="listivo-user-dropdown__icon">
                                                        <i class="far fa-building"></i>
                                                    </div>
                                                    <div class="listivo-user-dropdown__label">
                                                        <?php esc_html_e('As Business Broker', 'listivo'); ?>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (tdf_settings()->showMenuCtaButton()) : ?>
                        <?php if ($lstCurrentWidget->getCtaType() === 'button') : ?>
                            <div class="listivo-menu-v2__button">
                                <a
                                    <?php if ($lstCurrentWidget->getCtaButtonStyle() === 'primary_1') : ?>
                                        class="listivo-button listivo-button--primary-1"
                                    <?php else : ?>
                                        class="listivo-button listivo-button--primary-2"
                                    <?php endif; ?>
                                        href="<?php echo esc_url($lstCurrentWidget->getCtaButtonUrl()); ?>"
                                >
                                    <span>
                                        <?php if (!empty(tdf_settings()->getCustomMenuCtaText())) : ?>
                                            <?php echo esc_html(tdf_settings()->getCustomMenuCtaText()); ?>
                                        <?php else : ?>
                                            <?php echo esc_html(tdf_string('add_listing')); ?>
                                        <?php endif; ?>

                                        <?php if ($lstCurrentWidget->hasCtaButtonIcon()) : ?>
                                            <i class="<?php echo esc_attr($lstCurrentWidget->getCtaButtonIcon()); ?>"></i>
                                        <?php else : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                 viewBox="0 0 12 12" fill="none">
                                                <path d="M5.00488 11.525V7.075H0.854883V5.125H5.00488V0.65H7.00488V5.125H11.1549V7.075H7.00488V11.525H5.00488Z"
                                                      fill="#FDFDFE"/>
                                            </svg>
                                        <?php endif; ?>
                                    </span>
                                </a>
                            </div>
                        <?php elseif ($lstCurrentWidget->getCtaType() === 'phone') : ?>
                            <a
                                    class="listivo-menu-v2__phone"
                                    href="tel:<?php echo esc_attr(tdf_settings()->getPhoneUrl()); ?>"
                            >
                                <?php echo esc_html(tdf_settings()->getPhone()); ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="listivo-menu-v2__line"></div>
        </header>
    </div>
</div>