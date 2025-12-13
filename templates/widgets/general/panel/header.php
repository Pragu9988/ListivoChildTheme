<?php

use Tangibledesign\Framework\Widgets\General\PanelWidget;

/* @var PanelWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-panel-menu">
    <div class="listivo-panel-menu__list">
        <?php if (tdf_current_user()->canCreateModels() || !is_tdf_buyer()) : ?>
            <a
                <?php if ($lstCurrentWidget->isActionActive(PanelWidget::ACTION_CREATE)) : ?>
                    class="listivo-panel-menu__item listivo-panel-menu__item--active"
                <?php else : ?>
                    class="listivo-panel-menu__item"
                <?php endif; ?>
                    href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_CREATE)); ?>"
            >
                <?php echo esc_html(tdf_string('add_new')); ?>
            </a>
        <?php endif; ?>

        <!-- <?php if (tdf_current_user()->isModerator() || !is_tdf_buyer()) : ?>
            <a
                <?php if ($lstCurrentWidget->isActionActive(PanelWidget::ACTION_MODERATION)) : ?>
                    class="listivo-panel-menu__item listivo-panel-menu__item--active"
                <?php else : ?>
                    class="listivo-panel-menu__item"
                <?php endif; ?>
                    href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_MODERATION)); ?>"
            >
                <?php echo esc_html(tdf_string('moderation')); ?>
            </a>
        <?php endif; ?> -->

        <!-- <?php if (class_exists(\WooCommerce::class) && tdf_current_user()->canSeeOrders() && tdf_settings()->paymentsEnabled() || !is_tdf_buyer()) : ?>
            <a
                <?php if ($lstCurrentWidget->isActionActive(PanelWidget::ACTION_ORDERS)) : ?>
                    class="listivo-panel-menu__item listivo-panel-menu__item--active"
                <?php else : ?>
                    class="listivo-panel-menu__item"
                <?php endif; ?>
                    href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_ORDERS)); ?>"
            >
                <?php echo esc_html(tdf_string('orders')); ?>
            </a>
        <?php endif; ?> -->

        <?php if (tdf_current_user()->canCreateModels() || !is_tdf_buyer()) : ?>
            <a
                <?php if ($lstCurrentWidget->isActionActive(PanelWidget::ACTION_LIST)) : ?>
                    class="listivo-panel-menu__item listivo-panel-menu__item--active"
                <?php else : ?>
                    class="listivo-panel-menu__item"
                <?php endif; ?>
                    href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_LIST)); ?>"
            >
                <?php echo esc_html(tdf_string('my_listings')); ?>
            </a>
        <?php endif; ?>

        <?php if (tdf_settings()->isFavoriteEnabled()) : ?>
            <a
                <?php if ($lstCurrentWidget->isActionActive(PanelWidget::ACTION_FAVORITES)) : ?>
                    class="listivo-panel-menu__item listivo-panel-menu__item--active"
                <?php else : ?>
                    class="listivo-panel-menu__item"
                <?php endif; ?>
                    href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_FAVORITES)); ?>"
            >
                <?php echo esc_html(tdf_string('favorites')); ?>
            </a>
        <?php endif; ?>

        <?php if (tdf_settings()->messageSystem()) : ?>
            <lst-direct-message-count>
                <a
                    <?php if ($lstCurrentWidget->isActionActive(PanelWidget::ACTION_MESSAGES)) : ?>
                        class="listivo-panel-menu__item listivo-panel-menu__item--active"
                    <?php else : ?>
                        class="listivo-panel-menu__item"
                    <?php endif; ?>
                        href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_MESSAGES)); ?>"
                        slot-scope="props"
                >
                    <?php echo esc_html(tdf_string('messages')); ?>

                    <template>
                        <span
                                v-if="props.count > 0"
                                class="listivo-panel-menu__count"
                        >
                            {{ props.count }}
                        </span>
                    </template>
                </a>
            </lst-direct-message-count>
        <?php endif; ?>

        <!-- <?php if (class_exists(\WooCommerce::class) && tdf_settings()->paymentsEnabled() && tdf_current_user()->canCreateModels() || !is_tdf_buyer()) : ?>
            <a
                <?php if ($lstCurrentWidget->isActionActive(PanelWidget::ACTION_MY_ORDERS)) : ?>
                    class="listivo-panel-menu__item listivo-panel-menu__item--active"
                <?php else : ?>
                    class="listivo-panel-menu__item"
                <?php endif; ?>
                    href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_MY_ORDERS)); ?>"
            >
                <?php echo esc_html(tdf_string('my_orders')); ?>
            </a>
        <?php endif; ?> -->

        <a
            <?php if ($lstCurrentWidget->isActionActive(PanelWidget::ACTION_SETTINGS)) : ?>
                class="listivo-panel-menu__item listivo-panel-menu__item--active"
            <?php else : ?>
                class="listivo-panel-menu__item"
            <?php endif; ?>
                href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_SETTINGS)); ?>"
        >
            <?php echo esc_html(tdf_string('settings')); ?>
        </a>

        <?php if (tdf_settings()->paymentsEnabled() && tdf_current_user()->canCreateModels() || !is_tdf_buyer()) : ?>
            <?php if (tdf_current_user()->hasPackages() || tdf_current_user()->getNotEmptyBumpUpPackage()) : ?>
                <a
                    <?php if ($lstCurrentWidget->isActionActive(PanelWidget::ACTION_MY_PACKAGES)) : ?>
                        class="listivo-panel-menu__item listivo-panel-menu__item--mobile-only listivo-panel-menu__item--active"
                    <?php else : ?>
                        class="listivo-panel-menu__item listivo-panel-menu__item--mobile-only"
                    <?php endif; ?>
                        href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_MY_PACKAGES)); ?>"
                >
                    <?php echo esc_html(tdf_string('my_packages')); ?>
                </a>
            <?php endif; ?>

            <?php if (tdf_payment_packages_repository()->getRegularPaymentPackagesForUser(tdf_current_user())->isNotEmpty()) : ?>
                <a
                    <?php if ($lstCurrentWidget->isActionActive(PanelWidget::ACTION_BUY_PACKAGE)) : ?>
                        class="listivo-panel-menu__item listivo-panel-menu__item--mobile-only listivo-panel-menu__item--active"
                    <?php else : ?>
                        class="listivo-panel-menu__item listivo-panel-menu__item--mobile-only"
                    <?php endif; ?>
                        href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_BUY_PACKAGE)); ?>"
                >
                    <?php echo esc_html(tdf_string('purchase_new_package')); ?>
                </a>
            <?php endif; ?>
        <?php endif; ?>

        <a
                class="listivo-panel-menu__item listivo-panel-menu__item--tablet-only"
                href="<?php echo esc_url(tdf_logout_url()); ?>"
        >
            <?php echo esc_html(tdf_string('log_out')); ?>
        </a>
    </div>
</div>