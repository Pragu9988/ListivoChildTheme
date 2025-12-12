<?php

use Tangibledesign\Framework\Widgets\General\PanelWidget;

if (!is_user_logged_in() || !tdf_settings()->paymentsEnabled()) {
    return;
}

if (!tdf_current_user()->canCreateModels()) {
    return;
}

if (is_tdf_buyer()) {
    return;
}
?>
<div class="listivo-packages-bar">
    <?php if (tdf_settings()->subscriptionsEnabled()) :
        $lstUserSubscription = tdf_current_user()->getUserSubscription();
        ?>
        <a
                class="listivo-packages-bar__subscription"
            <?php if ($lstUserSubscription && $lstUserSubscription->getStatus() !== 'expired') : ?>
                href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_SETTINGS)); ?>"
            <?php else : ?>
                href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_SELECT_SUBSCRIPTION)); ?>"
            <?php endif; ?>
        >
            <div class="listivo-subscription-button">
                <?php if ($lstUserSubscription && $lstUserSubscription->getStatus() !== 'expired') : ?>
                    <div class="listivo-subscription-button__label">
                        <?php echo esc_html(tdf_string('current_subscription')) ?>:
                    </div>

                    <div class="listivo-subscription-button__value listivo-button-primary-2-selector">
                        <?php echo esc_html(tdf_current_user()->getSubscriptionName()); ?>
                    </div>
                <?php else : ?>
                    <div class="listivo-subscription-button__label">
                        <?php echo esc_html(tdf_string('current_subscription')) ?>:
                    </div>

                    <div class="listivo-subscription-button__value listivo-button-primary-2-selector">
                        <?php echo esc_html(tdf_string('subscribe_now')); ?>
                    </div>
                <?php endif; ?>
            </div>
        </a>
    <?php endif; ?>

    <?php if (tdf_current_user()->hasPackages() || tdf_current_user()->getNotEmptyBumpUpPackage()) : ?>
        <a
                class="listivo-packages-bar__current listivo-button-primary-2-selector"
                href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_MY_PACKAGES)); ?>"
        >
            <?php echo esc_html(tdf_string('my_packages')); ?>
        </a>
    <?php endif; ?>

    <?php if (tdf_payment_packages_repository()->getRegularPaymentPackagesForUser(tdf_current_user())->isNotEmpty()) : ?>
        <a
                class="listivo-packages-bar__buy"
                href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_BUY_PACKAGE)); ?>"
        >
            <?php echo esc_html(tdf_string('buy_the_package')); ?>
        </a>
    <?php endif; ?>
</div>