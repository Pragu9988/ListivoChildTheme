<?php
use Tangibledesign\Listivo\Widgets\General\LoginAndRegisterWidget;
/* @var LoginAndRegisterWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<?php if (tdf_settings()->showFacebookAuth() || tdf_settings()->showGoogleAuth()) : ?>
    <div class="listivo-login-form__socials">
        <?php if (tdf_settings()->showFacebookAuth()) : ?>
            <a
                    class="listivo-login-form__social-button listivo-social-auth-button"
                    href="<?php echo esc_url(tdf_action_url('listivo/socialAuth/facebook')); ?>"
            >
                <span class="listivo-social-auth-button__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="30" viewBox="0 0 31 30" fill="none">
                        <path d="M15.0039 0C6.71941 0 0.00390625 6.71549 0.00390625 15C0.00390625 23.2845 6.71941 30 15.0039 30C23.2884 30 30.0039 23.2845 30.0039 15C30.0039 6.71549 23.2884 0 15.0039 0Z"
                              fill="url(#paint0_linear_960_24904)"/>
                        <path d="M17.0341 18.9757H20.9161L21.5258 15.0322H17.0341V12.8767C17.0341 11.2387 17.5696 9.78599 19.1018 9.78599H21.5641V6.345C21.1313 6.2865 20.2163 6.159 18.4876 6.159C14.8771 6.159 12.7606 8.06549 12.7606 12.4095V15.033H9.04883V18.9765H12.7598V29.8155C13.4948 29.925 14.2396 30 15.0038 30C15.6946 30 16.3688 29.937 17.0341 29.847V18.9757Z"
                              fill="white"/>
                        <defs>
                            <linearGradient id="paint0_linear_960_24904" x1="4.49866" y1="4.49475" x2="27.4651"
                                            y2="27.4612" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#2AA4F4"/>
                                <stop offset="1" stop-color="#007AD9"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </span>

                <?php echo esc_html(tdf_string('continue_with_facebook')); ?>
            </a>
        <?php endif; ?>

        <?php if (tdf_settings()->showGoogleAuth()) : ?>
            <a
                    class="listivo-login-form__social-button listivo-social-auth-button"
                    href="<?php echo esc_url(tdf_action_url('listivo/socialAuth/google')); ?>"
            >
                <span class="listivo-social-auth-button__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="30" viewBox="0 0 31 30" fill="none">
                        <path d="M29.7122 12.0623H28.5039V12H15.0039V18H23.4812C22.2444 21.4928 18.9212 24 15.0039 24C10.0337 24 6.00391 19.9702 6.00391 15C6.00391 10.0297 10.0337 6 15.0039 6C17.2982 6 19.3854 6.8655 20.9747 8.27925L25.2174 4.0365C22.5384 1.53975 18.9549 0 15.0039 0C6.72016 0 0.00390625 6.71625 0.00390625 15C0.00390625 23.2838 6.72016 30 15.0039 30C23.2877 30 30.0039 23.2838 30.0039 15C30.0039 13.9943 29.9004 13.0125 29.7122 12.0623Z"
                              fill="#FFC107"/>
                        <path d="M1.73438 8.01825L6.66263 11.6325C7.99613 8.331 11.2256 6 15.0049 6C17.2991 6 19.3864 6.8655 20.9756 8.27925L25.2184 4.0365C22.5394 1.53975 18.9559 0 15.0049 0C9.24338 0 4.24688 3.25275 1.73438 8.01825Z"
                              fill="#FF3D00"/>
                        <path d="M15.0041 30C18.8786 30 22.3991 28.5172 25.0609 26.106L20.4184 22.1775C18.9124 23.3182 17.0404 24 15.0041 24C11.1026 24 7.78989 21.5122 6.54189 18.0405L1.65039 21.8092C4.13289 26.667 9.17439 30 15.0041 30Z"
                              fill="#4CAF50"/>
                        <path d="M29.7122 12.0623H28.5039V12H15.0039V18H23.4812C22.8872 19.6778 21.8079 21.1245 20.4159 22.1782C20.4167 22.1775 20.4174 22.1775 20.4182 22.1768L25.0607 26.1052C24.7322 26.4037 30.0039 22.5 30.0039 15C30.0039 13.9943 29.9004 13.0125 29.7122 12.0623Z"
                              fill="#1976D2"/>
                    </svg>
                </span>

                <?php echo esc_html(tdf_string('continue_with_google')); ?>
            </a>
        <?php endif; ?>

    </div>

    <div class="listivo-login-form__separator">
        <span>
            <?php echo esc_html(tdf_string('or')); ?>
        </span>
    </div>
<?php endif; ?>

<lst-login
        class="listivo-login-form__form"
        request-url="<?php echo esc_url(tdf_action_url('listivo/user/login')); ?>"
        send-confirmation-request-url="<?php echo esc_url(tdf_action_url('listivo/user/sendConfirmationMail')); ?>"
        redirect-url="<?php echo esc_url(tdf_app('after_login_redirect_url')); ?>"
        :is-admin="<?php echo esc_attr(is_user_logged_in() && current_user_can('manage_options') ? 'true' : 'false'); ?>"
        td-nonce="<?php echo esc_attr(wp_create_nonce('listivo_login')); ?>"
        send-again-text="<?php echo esc_attr(tdf_string('send_again')); ?>"
        close-text="<?php echo esc_attr(tdf_string('close')); ?>"
        confirmation-email-sent-title="<?php echo esc_attr(tdf_string('success')); ?>"
        confirmation-email-sent-text="<?php echo esc_attr(tdf_string('confirmation_email_sent')); ?>"
        send-confirmation-email-title="<?php echo esc_attr(tdf_string('send_confirmation_email_title')); ?>"
        send-confirmation-email-text="<?php echo esc_attr(tdf_string('send_confirmation_email_text')); ?>"
        invalid-email-text="<?php echo esc_attr(tdf_string('invalid_email')); ?>"
        :login-min-length="<?php echo esc_attr(tdf_settings()->getLoginMinLength()); ?>"
    <?php if (tdf_settings()->reCaptchaEnabled()) : ?>
        :re-captcha="true"
        re-captcha-key="<?php echo esc_attr(tdf_settings()->getReCaptchaSiteKey()); ?>"
    <?php endif; ?>
>
    <div
            class="listivo-login-form__form"
            slot-scope="loginForm"
    >
        <form @submit.prevent="loginForm.onLogin">
            <div
                    class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon"
                    :class="{
                        'listivo-input-v2--error': loginForm.showErrors && (!loginForm.errors.login.required || !loginForm.errors.login.minLength),
                    }"
            >
                <div class="listivo-input-v2__icon listivo-icon-v2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M0 8C0 3.58883 3.58883 0 8 0C12.4112 0 16 3.58883 16 8C16 12.4112 12.4112 16 8 16C3.58883 16 0 12.4112 0 8ZM14.7992 8C14.7992 4.23736 11.7619 1.2 7.99922 1.2C4.23657 1.2 1.19922 4.23736 1.19922 8C1.19922 11.7626 4.23657 14.8 7.99922 14.8C11.7619 14.8 14.7992 11.7626 14.7992 8ZM8.00039 2.4C4.91457 2.4 2.40039 4.91418 2.40039 8C2.40039 11.0858 4.91457 13.6 8.00039 13.6C8.69124 13.6 9.3557 13.4746 9.96836 13.2445C10.1715 13.1709 10.3194 12.9938 10.3556 12.7808C10.3918 12.5678 10.3106 12.3518 10.1432 12.2153C9.97576 12.0788 9.74784 12.0428 9.54648 12.1211C9.06635 12.3014 8.54634 12.4 8.00039 12.4C5.56301 12.4 3.60039 10.4374 3.60039 8C3.60039 5.56262 5.56301 3.6 8.00039 3.6C10.4378 3.6 12.4004 5.56262 12.4004 8V8.6C12.4004 9.15929 11.9597 9.6 11.4004 9.6C10.8411 9.6 10.4004 9.15929 10.4004 8.6V5.8C10.4028 5.49492 10.1759 5.23659 9.87308 5.19961C9.57025 5.16263 9.28786 5.35877 9.2168 5.65547C8.81185 5.36971 8.32747 5.2 7.80039 5.2C6.33967 5.2 5.20039 6.49099 5.20039 8C5.20039 9.50901 6.33967 10.8 7.80039 10.8C8.54069 10.8 9.1973 10.4673 9.66602 9.94375C10.0698 10.4624 10.6977 10.8 11.4004 10.8C12.6083 10.8 13.6004 9.80791 13.6004 8.6V8C13.6004 4.91418 11.0862 2.4 8.00039 2.4ZM9.20039 8C9.20039 7.08261 8.54527 6.4 7.80039 6.4C7.05552 6.4 6.40039 7.08261 6.40039 8C6.40039 8.91739 7.05552 9.6 7.80039 9.6C8.54527 9.6 9.20039 8.91739 9.20039 8Z"
                              fill="#FDFDFE"/>
                    </svg>
                </div>

                <input
                        id="listivo-login"
                        type="text"
                        placeholder="<?php echo esc_attr(tdf_string('email_or_username')); ?>"
                        :value="loginForm.login"
                        @input="loginForm.setLogin($event.target.value)"
                >

                <template>
                    <div
                            class="listivo-input-v2__error listivo-field-error"
                            v-if="loginForm.showErrors && (!loginForm.errors.login.required || !loginForm.errors.login.minLength)"
                    >
                        <div class="listivo-field-error__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9"
                                 fill="none">
                                <path d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                      fill="#FDFDFE"/>
                                <path d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                      fill="#F09965"/>
                            </svg>
                        </div>

                        <template v-if="!loginForm.errors.login.required">
                            <?php echo esc_html(tdf_string('field_is_required')); ?>
                        </template>

                        <template v-if="!loginForm.errors.login.minLength">
                            <?php if (strpos(tdf_string('login_min_letters'), '%d') === false): ?>
                                <?php echo esc_html(tdf_string('login_min_letters')); ?>
                            <?php else: ?>
                                <?php echo sprintf(esc_html(tdf_string('login_min_letters')),
                                    tdf_settings()->getLoginMinLength()); ?>
                            <?php endif; ?>
                        </template>
                    </div>
                </template>
            </div>

            <div
                    class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon"
                    :class="{
                        'listivo-input-v2--error': loginForm.showErrors && (!loginForm.errors.password.required || !loginForm.errors.password.minLength)
                    }"
            >
                <div class="listivo-input-v2__icon listivo-icon-v2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="16" viewBox="0 0 13 16" fill="none">
                        <path d="M6.09524 0C3.56281 0 1.52381 2.039 1.52381 4.57143V5.33333C0.691 5.33333 0 6.02433 0 6.85714V14.4762C0 15.309 0.691 16 1.52381 16H10.6667C11.4995 16 12.1905 15.309 12.1905 14.4762V6.85714C12.1905 6.02433 11.4995 5.33333 10.6667 5.33333V4.57143C10.6667 2.039 8.62766 0 6.09524 0ZM6.09524 1.52381C7.82948 1.52381 9.14286 2.83719 9.14286 4.57143V5.33333H3.04762V4.57143C3.04762 2.83719 4.361 1.52381 6.09524 1.52381ZM1.52381 6.85714H10.6667V14.4762H1.52381V6.85714ZM6.09524 9.14286C5.25714 9.14286 4.57143 9.82857 4.57143 10.6667C4.57143 11.5048 5.25714 12.1905 6.09524 12.1905C6.93333 12.1905 7.61905 11.5048 7.61905 10.6667C7.61905 9.82857 6.93333 9.14286 6.09524 9.14286Z"
                              fill="#FDFDFE"/>
                    </svg>
                </div>

                <input
                        id="listivo-password"
                        :type="loginForm.passwordVisible ? 'text' : 'password'"
                        placeholder="<?php echo esc_attr(tdf_string('password')); ?>"
                        :value="loginForm.password"
                        @input="loginForm.setPassword($event.target.value)"
                >

                <?php if ($lstCurrentWidget instanceof LoginAndRegisterWidget && $lstCurrentWidget->showPasswordToggle()) : ?>
                    <button
                            type="button"
                            class="listivo-input-v2__clear listivo-input-v2__password-toggle"
                            :aria-label="loginForm.passwordVisible ? '<?php echo esc_js(tdf_string('hide_password')); ?>' : '<?php echo esc_js(tdf_string('show_password')); ?>'"
                            @click="loginForm.togglePasswordVisibility"
                    >
                        <i class="far" :class="loginForm.passwordVisible ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                <?php endif; ?>

                <template>
                    <div
                            v-if="loginForm.showErrors && (!loginForm.errors.password.required || !loginForm.errors.password.minLength)"
                            class="listivo-input-v2__error listivo-field-error"
                    >
                        <div class="listivo-field-error__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9"
                                 fill="none">
                                <path d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                      fill="#FDFDFE"/>
                                <path d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                      fill="#F09965"/>
                            </svg>
                        </div>

                        <template v-if="!loginForm.errors.password.required">
                            <?php echo esc_html(tdf_string('field_is_required')); ?>
                        </template>

                        <template v-if="!loginForm.errors.password.minLength">
                            <?php echo esc_html(tdf_string('password_min_letters')); ?>
                        </template>
                    </div>
                </template>
            </div>

            <div class="listivo-login-form__bottom">
                <div
                        class="listivo-login-form__remember"
                        @click.prevent="loginForm.setRemember"
                >
                    <div
                            class="listivo-login-form__checkbox listivo-checkbox"
                            :class="{'listivo-checkbox--checked': loginForm.remember}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11" fill="none">
                            <path d="M11.7142 0.779513L10.6378 0.103783C10.3399 -0.0824758 9.93186 -0.011004 9.73252 0.261887L4.45585 7.44801L2.03093 5.20858C1.77765 4.97467 1.3649 4.97467 1.11162 5.20858L0.18996 6.05974C-0.06332 6.29364 -0.06332 6.67482 0.18996 6.9109L3.91881 10.3545C4.12753 10.5473 4.45585 10.6945 4.75135 10.6945C5.04684 10.6945 5.34468 10.5235 5.53698 10.2657L11.8877 1.61335C12.0894 1.34046 12.012 0.965772 11.7142 0.779513Z"
                                  fill="#FDFDFE"/>
                        </svg>
                    </div>

                    <?php echo esc_html(tdf_string('remember')); ?>
                </div>

                <lst-reset-password
                        class="listivo-login-form__lost-password"
                        td-nonce="<?php echo esc_attr(wp_create_nonce('listivo_reset_password')); ?>"
                        request-url="<?php echo esc_url(tdf_action_url('listivo/user/resetPassword')); ?>"
                        title-text="<?php echo esc_attr(tdf_string('reset_password')); ?>"
                        message-text="<?php echo esc_attr(tdf_string('reset_password_message')); ?>"
                        confirmation-button-text="<?php echo esc_attr(tdf_string('send')); ?>"
                        cancel-button-text="<?php echo esc_attr(tdf_string('cancel')); ?>"
                        invalid-email-text="<?php echo esc_attr(tdf_string('invalid_email')); ?>"
                        close-text="<?php echo esc_attr(tdf_string('close')); ?>"
                    <?php if (tdf_settings()->reCaptchaEnabled()) : ?>
                        :re-captcha="true"
                        re-captcha-key="<?php echo esc_attr(tdf_settings()->getReCaptchaSiteKey()); ?>"
                    <?php endif; ?>
                >
                    <div
                            slot-scope="resetPassword"
                            class="listivo-login-form__lost-password"
                            @click.prevent="resetPassword.onClick"
                    >
                        <?php echo esc_html(tdf_string('forgot_password_question')); ?>
                    </div>
                </lst-reset-password>
            </div>

            <div class="listivo-login-form__button">
                <button
                    <?php if (tdf_current_kit()->get_settings_for_display('login_button_type') === 'primary_1') : ?>
                        class="listivo-simple-button listivo-simple-button--background-primary-1 listivo-button-primary-1-selector listivo-simple-button--full-width listivo-simple-button--height-60"
                    <?php else : ?>
                        class="listivo-simple-button listivo-simple-button--background-primary-2 listivo-button-primary-2-selector listivo-simple-button--full-width listivo-simple-button--height-60"
                    <?php endif; ?>
                        :class="{'listivo-simple-button--loading': loginForm.inProgress}"
                        :disabled="loginForm.inProgress"
                >
                    <span v-if="!loginForm.inProgress">
                        <?php echo esc_html(tdf_string('login')); ?>
                    </span>

                    <template>
                        <svg
                                v-if="loginForm.inProgress"
                                width='40'
                                height='10'
                                viewBox='0 0 120 30'
                                xmlns='http://www.w3.org/2000/svg'
                                fill='#fff'
                                class="listivo-simple-button__loading"
                        >
                            <circle cx='15' cy='15' r='15'>
                                <animate attributeName='r' from='15' to='15' begin='0s' dur='0.8s' values='15;9;15'
                                         calcMode='linear' repeatCount='indefinite'/>
                                <animate attributeName='fill-opacity' from='1' to='1' begin='0s' dur='0.8s'
                                         values='1;.5;1'
                                         calcMode='linear' repeatCount='indefinite'/>
                            </circle>

                            <circle cx='60' cy='15' r='9' fill-opacity='0.3'>
                                <animate attributeName='r' from='9' to='9' begin='0s' dur='0.8s' values='9;15;9'
                                         calcMode='linear' repeatCount='indefinite'/>
                                <animate attributeName='fill-opacity' from='0.5' to='0.5' begin='0s' dur='0.8s'
                                         values='.5;1;.5' calcMode='linear' repeatCount='indefinite'/>
                            </circle>

                            <circle cx='105' cy='15' r='15'>
                                <animate attributeName='r' from='15' to='15' begin='0s' dur='0.8s' values='15;9;15'
                                         calcMode='linear' repeatCount='indefinite'/>
                                <animate attributeName='fill-opacity' from='1' to='1' begin='0s' dur='0.8s'
                                         values='1;.5;1'
                                         calcMode='linear' repeatCount='indefinite'/>
                            </circle>
                        </svg>
                    </template>
                </button>
            </div>

            <div class="listivo-login-form__footer" style="text-align: center; margin-top: 15px;">
                <?php echo esc_html__("Don't have an account? Register as ", 'listivo'); ?>
                <a href="<?php echo esc_url(tdf_settings()->getRegisterPageUrl()); ?>" class="listivo-login-form__register-link" style="font-weight: 600;">
                    <?php echo esc_html__('Seller', 'listivo'); ?>
                </a>
                <?php echo esc_html__('or', 'listivo'); ?>
                <a href="<?php echo esc_url(home_url('/buyer-register/')); ?>" class="listivo-login-form__register-link" style="font-weight: 600;">
                    <?php echo esc_html__('Buyer', 'listivo'); ?>
                </a>
            </div>

            <lst-reset-password
                    class="listivo-login-form__lost-password-mobile"
                    td-nonce="<?php echo esc_attr(wp_create_nonce('listivo_reset_password')); ?>"
                    request-url="<?php echo esc_url(tdf_action_url('listivo/user/resetPassword')); ?>"
                    title-text="<?php echo esc_attr(tdf_string('reset_password')); ?>"
                    message-text="<?php echo esc_attr(tdf_string('reset_password_message')); ?>"
                    confirmation-button-text="<?php echo esc_attr(tdf_string('send')); ?>"
                    cancel-button-text="<?php echo esc_attr(tdf_string('cancel')); ?>"
                    invalid-email-text="<?php echo esc_attr(tdf_string('invalid_email')); ?>"
                    close-text="<?php echo esc_attr(tdf_string('close')); ?>"
                <?php if (tdf_settings()->reCaptchaEnabled()) : ?>
                    :re-captcha="true"
                    re-captcha-key="<?php echo esc_attr(tdf_settings()->getReCaptchaSiteKey()); ?>"
                <?php endif; ?>
            >
                <div
                        slot-scope="resetPassword"
                        class="listivo-login-form__lost-password"
                        @click.prevent="resetPassword.onClick"
                >
                    <?php echo esc_html(tdf_string('forgot_password_question')); ?>
                </div>
            </lst-reset-password>
        </form>
    </div>
</lst-login>
