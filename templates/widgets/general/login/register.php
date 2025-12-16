<?php

use Tangibledesign\Listivo\Widgets\General\LoginAndRegisterWidget;

/* @var LoginAndRegisterWidget $lstCurrentWidget */
global $lstCurrentWidget;

if (tdf_settings()->showFacebookAuth() || tdf_settings()->showGoogleAuth()) : ?>
    <div class="listivo-login-form__socials">
        <?php if (tdf_settings()->showFacebookAuth()) : ?>
            <a
                    class="listivo-login-form__social-button listivo-social-auth-button"
                    href="<?php echo esc_url(tdf_action_url('listivo/socialAuth/facebook')); ?>"
            >
                <span class="listivo-social-auth-button__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="30" viewBox="0 0 31 30" fill="none">
                        <path
                                d="M15.0039 0C6.71941 0 0.00390625 6.71549 0.00390625 15C0.00390625 23.2845 6.71941 30 15.0039 30C23.2884 30 30.0039 23.2845 30.0039 15C30.0039 6.71549 23.2884 0 15.0039 0Z"
                                fill="url(#paint0_linear_960_24904)"/>
                        <path
                                d="M17.0341 18.9757H20.9161L21.5258 15.0322H17.0341V12.8767C17.0341 11.2387 17.5696 9.78599 19.1018 9.78599H21.5641V6.345C21.1313 6.2865 20.2163 6.159 18.4876 6.159C14.8771 6.159 12.7606 8.06549 12.7606 12.4095V15.033H9.04883V18.9765H12.7598V29.8155C13.4948 29.925 14.2396 30 15.0038 30C15.6946 30 16.3688 29.937 17.0341 29.847V18.9757Z"
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
                        <path
                                d="M29.7122 12.0623H28.5039V12H15.0039V18H23.4812C22.2444 21.4928 18.9212 24 15.0039 24C10.0337 24 6.00391 19.9702 6.00391 15C6.00391 10.0297 10.0337 6 15.0039 6C17.2982 6 19.3854 6.8655 20.9747 8.27925L25.2174 4.0365C22.5384 1.53975 18.9549 0 15.0039 0C6.72016 0 0.00390625 6.71625 0.00390625 15C0.00390625 23.2838 6.72016 30 15.0039 30C23.2877 30 30.0039 23.2838 30.0039 15C30.0039 13.9943 29.9004 13.0125 29.7122 12.0623Z"
                                fill="#FFC107"/>
                        <path
                                d="M1.73438 8.01825L6.66263 11.6325C7.99613 8.331 11.2256 6 15.0049 6C17.2991 6 19.3864 6.8655 20.9756 8.27925L25.2184 4.0365C22.5394 1.53975 18.9559 0 15.0049 0C9.24338 0 4.24688 3.25275 1.73438 8.01825Z"
                                fill="#FF3D00"/>
                        <path
                                d="M15.0041 30C18.8786 30 22.3991 28.5172 25.0609 26.106L20.4184 22.1775C18.9124 23.3182 17.0404 24 15.0041 24C11.1026 24 7.78989 21.5122 6.54189 18.0405L1.65039 21.8092C4.13289 26.667 9.17439 30 15.0041 30Z"
                                fill="#4CAF50"/>
                        <path
                                d="M29.7122 12.0623H28.5039V12H15.0039V18H23.4812C22.8872 19.6778 21.8079 21.1245 20.4159 22.1782C20.4167 22.1775 20.4174 22.1775 20.4182 22.1768L25.0607 26.1052C24.7322 26.4037 30.0039 22.5 30.0039 15C30.0039 13.9943 29.9004 13.0125 29.7122 12.0623Z"
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

<lst-register
        class="listivo-login-form__form"
        td-nonce="<?php echo esc_attr(wp_create_nonce('listivo_register')); ?>"
        request-url="<?php echo esc_url(tdf_action_url('listivo/user/register')); ?>"
        redirect-url="<?php echo esc_url(tdf_app('after_register_redirect_url')); ?>"
        :accept-policy="<?php echo esc_attr(!empty(tdf_settings()->getPolicyLabel()) ? 'true' : 'false'); ?>"
    <?php if (tdf_settings()->isMarketingConsentsEnabled()) : ?>
        :is-marketing-consent-required="<?php echo esc_attr(tdf_settings()->isMarketingConsentsRequired() ? 'true' : 'false'); ?>"
        :initial-marketing-consent="<?php echo esc_attr(tdf_settings()->isMarketingConsentsCheckedByDefault() ? 'true' : 'false'); ?>"
    <?php endif; ?>
        :is-admin="<?php echo esc_attr(is_user_logged_in() && current_user_can('manage_options') ? 'true' : 'false'); ?>"
        :phone-required="<?php echo esc_attr(tdf_settings()->isPhoneRequired() ? 'true' : 'false'); ?>"
        close-text="<?php echo esc_attr(tdf_string('close')); ?>"
        :login-min-length="<?php echo esc_attr(tdf_settings()->getLoginMinLength()); ?>"
    <?php if (tdf_settings()->isPhoneCountryCodeSelectEnabled()) : ?>
        initial-phone-country-code="<?php echo esc_attr(tdf_app('phone_initial_country_code')); ?>"
    <?php endif; ?>
    <?php if (tdf_settings()->isFullNameEnabledForPrivateAccount()) : ?>
        :private-full-name-required="<?php echo esc_attr(tdf_settings()->isFullNameRequiredForPrivateAccount() ? 'true' : 'false'); ?>"
    <?php endif; ?>
    <?php if (tdf_settings()->isFullNameEnabledForBusinessAccount()) : ?>
        :business-full-name-required="<?php echo esc_attr(tdf_settings()->isFullNameRequiredForBusinessAccount() ? 'true' : 'false'); ?>"
    <?php endif; ?>
    <?php if (tdf_settings()->isCompanyInformationEnabled()) : ?>
        :company-information-required="<?php echo esc_attr(tdf_settings()->requireCompanyInformation() ? 'true' : 'false'); ?>"
    <?php endif; ?>
    <?php if (tdf_settings()->reCaptchaEnabled()) : ?>
        :re-captcha="true"
        re-captcha-key="<?php echo esc_attr(tdf_settings()->getReCaptchaSiteKey()); ?>"
    <?php endif; ?>
    <?php if ($lstCurrentWidget instanceof LoginAndRegisterWidget) : ?>
        initial-account-type="<?php echo esc_attr($lstCurrentWidget->getInitialUserType()); ?>"
    <?php endif; ?>
>
    <div
            class="listivo-login-form__form"
            slot-scope="registerForm"
    >
        <form @submit.prevent="registerForm.onRegister">
            <div
                    class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon"
                    :class="{
                        'listivo-input-v2--error': registerForm.showErrors && (!registerForm.errors.name.required || !registerForm.errors.name.minLength)
                    }"
            >
                <div class="listivo-input-v2__icon listivo-icon-v2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16" fill="none">
                        <path
                                d="M7.27273 0C4.46875 0 2.18182 2.28693 2.18182 5.09091C2.18182 6.84375 3.0767 8.40057 4.43182 9.31818C1.83807 10.4318 0 13.0057 0 16H1.45455C1.45455 13.8977 2.56534 12.0682 4.22727 11.0455C4.71591 12.2443 5.90625 13.0909 7.27273 13.0909C8.6392 13.0909 9.82955 12.2443 10.3182 11.0455C11.9801 12.0682 13.0909 13.8977 13.0909 16H14.5455C14.5455 13.0057 12.7074 10.4318 10.1136 9.31818C11.4688 8.40057 12.3636 6.84375 12.3636 5.09091C12.3636 2.28693 10.0767 0 7.27273 0ZM7.27273 1.45455C9.28977 1.45455 10.9091 3.07386 10.9091 5.09091C10.9091 7.10796 9.28977 8.72727 7.27273 8.72727C5.25568 8.72727 3.63636 7.10796 3.63636 5.09091C3.63636 3.07386 5.25568 1.45455 7.27273 1.45455ZM7.27273 10.1818C7.86932 10.1818 8.4375 10.267 8.97727 10.4318C8.72443 11.1335 8.06534 11.6364 7.27273 11.6364C6.48011 11.6364 5.82102 11.1335 5.56818 10.4318C6.10796 10.267 6.67614 10.1818 7.27273 10.1818Z"
                                fill="#FDFDFE"/>
                    </svg>
                </div>

                <input
                        name="name"
                        @keydown="registerForm.nameKeydown"
                        @input="registerForm.setName($event.target.value)"
                        :value="registerForm.name"
                        type="text"
                        placeholder="<?php echo esc_attr(tdf_string('username')); ?>*"
                >

                <template>
                    <div
                            v-if="registerForm.showErrors && (!registerForm.errors.name.required || !registerForm.errors.name.minLength)"
                            class="listivo-input-v2__error listivo-field-error"
                    >
                        <div class="listivo-field-error__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9"
                                 fill="none">
                                <path
                                        d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                        fill="#FDFDFE"/>
                                <path
                                        d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                        fill="#F09965"/>
                            </svg>
                        </div>

                        <template v-if="!registerForm.errors.name.required">
                            <?php echo esc_html(tdf_string('field_is_required')); ?>
                        </template>

                        <template v-if="!registerForm.errors.name.minLength">
                            <?php echo sprintf(esc_html(tdf_string('login_min_letters')),
                                tdf_settings()->getLoginMinLength()); ?>
                        </template>
                    </div>
                </template>
            </div>

            <div
                    class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon"
                    :class="{
                        'listivo-input-v2--error': registerForm.showErrors && (!registerForm.errors.email.required || !registerForm.errors.email.email)
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
                        name="email"
                        @input="registerForm.setMail($event.target.value)"
                        :value="registerForm.email"
                        type="text"
                        placeholder="<?php echo esc_attr(tdf_string('email')); ?>*"
                >

                <template>
                    <div
                            v-if="registerForm.showErrors && (!registerForm.errors.email.required || !registerForm.errors.email.email)"
                            class="listivo-input-v2__error listivo-field-error"
                    >
                        <div class="listivo-field-error__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9"
                                 fill="none">
                                <path
                                        d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                        fill="#FDFDFE"/>
                                <path
                                        d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                        fill="#F09965"/>
                            </svg>
                        </div>

                        <template v-if="!registerForm.errors.email.required">
                            <?php echo esc_html(tdf_string('field_is_required')); ?>
                        </template>

                        <template v-if="!registerForm.errors.email.email">
                            <?php echo esc_html(tdf_string('email_invalid_format')); ?>
                        </template>
                    </div>
                </template>
            </div>

            <?php if (tdf_settings()->showPhoneOnRegister()) : ?>
                <?php if (tdf_settings()->isPhoneCountryCodeSelectEnabled()) : ?>
                    <div class="listivo-login-form__field listivo-login-form__field--advanced-phone">
                        <label for="listivo-phone-with-country-code">
                            <div
                                    class="listivo-phone-with-country-code"
                                    :class="{
                                        'listivo-phone-with-country-code--error': registerForm.showErrors && (!registerForm.errors.phone.isPhone || !registerForm.errors.phone.required)
                                    }"
                            >
                                <div class="listivo-phone-with-country-code__icon listivo-icon-v2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16"
                                         fill="none">
                                        <path
                                                d="M1.8 0C0.813 0 0 0.813 0 1.8V14.2C0 15.187 0.813 16 1.8 16H7.8C8.787 16 9.6 15.187 9.6 14.2V1.8C9.6 0.813 8.787 0 7.8 0H1.8ZM1.8 1.2H7.8C8.1386 1.2 8.4 1.4614 8.4 1.8V14.2C8.4 14.5386 8.1386 14.8 7.8 14.8H1.8C1.4614 14.8 1.2 14.5386 1.2 14.2V1.8C1.2 1.4614 1.4614 1.2 1.8 1.2ZM4.8 2.4C4.64087 2.4 4.48826 2.46321 4.37574 2.57574C4.26321 2.68826 4.2 2.84087 4.2 3C4.2 3.15913 4.26321 3.31174 4.37574 3.42426C4.48826 3.53679 4.64087 3.6 4.8 3.6C4.95913 3.6 5.11174 3.53679 5.22426 3.42426C5.33679 3.31174 5.4 3.15913 5.4 3C5.4 2.84087 5.33679 2.68826 5.22426 2.57574C5.11174 2.46321 4.95913 2.4 4.8 2.4ZM3.8 12.4C3.72049 12.3989 3.64156 12.4136 3.56777 12.4432C3.49399 12.4729 3.42684 12.5169 3.37022 12.5727C3.3136 12.6285 3.26864 12.6951 3.23795 12.7684C3.20726 12.8418 3.19145 12.9205 3.19145 13C3.19145 13.0795 3.20726 13.1582 3.23795 13.2316C3.26864 13.3049 3.3136 13.3715 3.37022 13.4273C3.42684 13.4831 3.49399 13.5271 3.56777 13.5568C3.64156 13.5864 3.72049 13.6011 3.8 13.6H5.8C5.87951 13.6011 5.95845 13.5864 6.03223 13.5568C6.10601 13.5271 6.17316 13.4831 6.22978 13.4273C6.2864 13.3715 6.33137 13.3049 6.36205 13.2316C6.39274 13.1582 6.40855 13.0795 6.40855 13C6.40855 12.9205 6.39274 12.8418 6.36205 12.7684C6.33137 12.6951 6.2864 12.6285 6.22978 12.5727C6.17316 12.5169 6.10601 12.4729 6.03223 12.4432C5.95845 12.4136 5.87951 12.3989 5.8 12.4H3.8Z"
                                                fill="#FDFDFE"/>
                                    </svg>
                                </div>

                                <select
                                        @change="registerForm.setPhoneCountryCode($event.target.value)"
                                        :value="registerForm.phoneCountryCode"
                                >
                                    <?php foreach (tdf_app('phone_country_codes_with_flags') as $text => $code) : ?>
                                        <option value="<?php echo esc_attr($text); ?>">
                                            <?php echo tdf_filter($text); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <input
                                    id="listivo-phone-with-country-code"
                                    name="phone"
                                    @input="registerForm.setPhone($event.target.value.replace(/\D/g, '').substring(0, 10))"
                                    :value="registerForm.phone"
                                    type="tel"
                                    pattern="[0-9]{10}"
                                    maxlength="10"
                                    inputmode="numeric"
                                    <?php if (tdf_settings()->isPhoneRequired()) : ?>
                                        placeholder="<?php echo esc_attr(tdf_string('phone')); ?>* (10 digits)"
                                    <?php else : ?>
                                        placeholder="<?php echo esc_attr(tdf_string('phone')); ?> (10 digits)"
                                    <?php endif; ?>
                                    :required="registerForm.phoneRequired"
                                >

                                <template>
                                    <div
                                        <?php if (tdf_settings()->isPhoneRequired()) : ?>
                                            v-if="registerForm.showErrors && (!registerForm.errors.phone.isPhone || !registerForm.errors.phone.required)"
                                        <?php else : ?>
                                            v-if="registerForm.showErrors && (!registerForm.errors.phone.isPhone)"
                                        <?php endif; ?>
                                            class="listivo-phone-with-country-code__error listivo-field-error"
                                    >
                                        <div class="listivo-field-error__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9"
                                                 viewBox="0 0 10 9"
                                                 fill="none">
                                                <path
                                                        d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                                        fill="#FDFDFE"/>
                                                <path
                                                        d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                                        fill="#F09965"/>
                                            </svg>
                                        </div>

                                        <template v-if="!registerForm.errors.phone.isPhone">
                                            <?php echo esc_attr(tdf_string('only_numbers')); ?>
                                        </template>

                                        <?php if (tdf_settings()->isPhoneRequired()) : ?>
                                            <template v-if="!registerForm.errors.phone.required">
                                                <?php echo esc_html(tdf_string('field_is_required')); ?>
                                            </template>
                                        <?php endif; ?>
                                    </div>
                                </template>
                            </div>
                        </label>
                    </div>
                <?php else : ?>
                    <div
                            class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon"
                            :class="{
                                'listivo-input-v2--error': registerForm.showErrors && (!registerForm.errors.phone.isPhone || !registerForm.errors.phone.required)
                            }"
                    >
                        <div class="listivo-input-v2__icon listivo-icon-v2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16"
                                 fill="none">
                                <path
                                        d="M1.8 0C0.813 0 0 0.813 0 1.8V14.2C0 15.187 0.813 16 1.8 16H7.8C8.787 16 9.6 15.187 9.6 14.2V1.8C9.6 0.813 8.787 0 7.8 0H1.8ZM1.8 1.2H7.8C8.1386 1.2 8.4 1.4614 8.4 1.8V14.2C8.4 14.5386 8.1386 14.8 7.8 14.8H1.8C1.4614 14.8 1.2 14.5386 1.2 14.2V1.8C1.2 1.4614 1.4614 1.2 1.8 1.2ZM4.8 2.4C4.64087 2.4 4.48826 2.46321 4.37574 2.57574C4.26321 2.68826 4.2 2.84087 4.2 3C4.2 3.15913 4.26321 3.31174 4.37574 3.42426C4.48826 3.53679 4.64087 3.6 4.8 3.6C4.95913 3.6 5.11174 3.53679 5.22426 3.42426C5.33679 3.31174 5.4 3.15913 5.4 3C5.4 2.84087 5.33679 2.68826 5.22426 2.57574C5.11174 2.46321 4.95913 2.4 4.8 2.4ZM3.8 12.4C3.72049 12.3989 3.64156 12.4136 3.56777 12.4432C3.49399 12.4729 3.42684 12.5169 3.37022 12.5727C3.3136 12.6285 3.26864 12.6951 3.23795 12.7684C3.20726 12.8418 3.19145 12.9205 3.19145 13C3.19145 13.0795 3.20726 13.1582 3.23795 13.2316C3.26864 13.3049 3.3136 13.3715 3.37022 13.4273C3.42684 13.4831 3.49399 13.5271 3.56777 13.5568C3.64156 13.5864 3.72049 13.6011 3.8 13.6H5.8C5.87951 13.6011 5.95845 13.5864 6.03223 13.5568C6.10601 13.5271 6.17316 13.4831 6.22978 13.4273C6.2864 13.3715 6.33137 13.3049 6.36205 13.2316C6.39274 13.1582 6.40855 13.0795 6.40855 13C6.40855 12.9205 6.39274 12.8418 6.36205 12.7684C6.33137 12.6951 6.2864 12.6285 6.22978 12.5727C6.17316 12.5169 6.10601 12.4729 6.03223 12.4432C5.95845 12.4136 5.87951 12.3989 5.8 12.4H3.8Z"
                                        fill="#FDFDFE"/>
                            </svg>
                        </div>

                        <input
                                name="phone"
                                @input="registerForm.setPhone($event.target.value)"
                                :value="registerForm.phone"
                                type="tel"
                            <?php if (tdf_settings()->isPhoneRequired()) : ?>
                                placeholder="<?php echo esc_attr(tdf_string('phone')); ?>*"
                            <?php else : ?>
                                placeholder="<?php echo esc_attr(tdf_string('phone')); ?>"
                            <?php endif; ?>
                                :required="registerForm.phoneRequired"
                        >

                        <template>
                            <div
                                <?php if (tdf_settings()->isPhoneRequired()) : ?>
                                    v-if="registerForm.showErrors && (!registerForm.errors.phone.isPhone || !registerForm.errors.phone.required)"
                                <?php else : ?>
                                    v-if="registerForm.showErrors && (!registerForm.errors.phone.isPhone)"
                                <?php endif; ?>
                                    class="listivo-input-v2__error listivo-field-error"
                            >
                                <div class="listivo-field-error__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9"
                                         fill="none">
                                        <path
                                                d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                                fill="#FDFDFE"/>
                                        <path
                                                d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                                fill="#F09965"/>
                                    </svg>
                                </div>

                                <template v-if="!registerForm.errors.phone.isPhone">
                                    <?php echo esc_attr(tdf_string('only_numbers')); ?>
                                </template>

                                <template v-if="!registerForm.errors.phone.length">
                                    Phone number must be exactly 10 digits
                                </template>

                                <?php if (tdf_settings()->isPhoneRequired()) : ?>
                                    <template v-if="!registerForm.errors.phone.required">
                                        <?php echo esc_html(tdf_string('field_is_required')); ?>
                                    </template>
                                <?php endif; ?>
                            </div>
                        </template>
                    </div>
                <?php endif; ?>

                <?php if (tdf_settings()->isChatAppsOnRegistrationActivated()) : ?>
                    <?php if (!tdf_settings()->disableWhatsApp()) : ?>
                        <div class="listivo-login-form__field">
                            <div
                                    class="listivo-login-form__chat-app"
                                    @click.stop.prevent="registerForm.setWhatsAppEnabled"
                            >
                                <div
                                        class="listivo-login-form__checkbox listivo-checkbox"
                                        :class="{'listivo-checkbox--checked': registerForm.whatsAppEnabled}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                         fill="none">
                                        <path
                                                d="M11.7142 0.779513L10.6378 0.103783C10.3399 -0.0824758 9.93186 -0.011004 9.73252 0.261887L4.45585 7.44801L2.03093 5.20858C1.77765 4.97467 1.3649 4.97467 1.11162 5.20858L0.18996 6.05974C-0.06332 6.29364 -0.06332 6.67482 0.18996 6.9109L3.91881 10.3545C4.12753 10.5473 4.45585 10.6945 4.75135 10.6945C5.04684 10.6945 5.34468 10.5235 5.53698 10.2657L11.8877 1.61335C12.0894 1.34046 12.012 0.965772 11.7142 0.779513Z"
                                                fill="#FDFDFE"/>
                                    </svg>
                                </div>

                                <span><?php echo esc_html(tdf_string('enable_whats_app_communication')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!tdf_settings()->disableViber()) : ?>
                        <div class="listivo-login-form__field">
                            <div
                                    class="listivo-login-form__chat-app"
                                    @click.stop.prevent="registerForm.setViberEnabled"
                            >
                                <div
                                        class="listivo-login-form__checkbox listivo-checkbox"
                                        :class="{'listivo-checkbox--checked': registerForm.viberEnabled}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                         fill="none">
                                        <path
                                                d="M11.7142 0.779513L10.6378 0.103783C10.3399 -0.0824758 9.93186 -0.011004 9.73252 0.261887L4.45585 7.44801L2.03093 5.20858C1.77765 4.97467 1.3649 4.97467 1.11162 5.20858L0.18996 6.05974C-0.06332 6.29364 -0.06332 6.67482 0.18996 6.9109L3.91881 10.3545C4.12753 10.5473 4.45585 10.6945 4.75135 10.6945C5.04684 10.6945 5.34468 10.5235 5.53698 10.2657L11.8877 1.61335C12.0894 1.34046 12.012 0.965772 11.7142 0.779513Z"
                                                fill="#FDFDFE"/>
                                    </svg>
                                </div>

                                <span><?php echo esc_html(tdf_string('enable_viber_communication')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>

            <div
                    class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon"
                    :class="{
                        'listivo-input-v2--error': registerForm.showErrors && (!registerForm.errors.password.required || !registerForm.errors.password.minLength)
                    }"
            >
                <div class="listivo-input-v2__icon listivo-icon-v2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="16" viewBox="0 0 13 16" fill="none">
                        <path
                                d="M6.09524 0C3.56281 0 1.52381 2.039 1.52381 4.57143V5.33333C0.691 5.33333 0 6.02433 0 6.85714V14.4762C0 15.309 0.691 16 1.52381 16H10.6667C11.4995 16 12.1905 15.309 12.1905 14.4762V6.85714C12.1905 6.02433 11.4995 5.33333 10.6667 5.33333V4.57143C10.6667 2.039 8.62766 0 6.09524 0ZM6.09524 1.52381C7.82948 1.52381 9.14286 2.83719 9.14286 4.57143V5.33333H3.04762V4.57143C3.04762 2.83719 4.361 1.52381 6.09524 1.52381ZM1.52381 6.85714H10.6667V14.4762H1.52381V6.85714ZM6.09524 9.14286C5.25714 9.14286 4.57143 9.82857 4.57143 10.6667C4.57143 11.5048 5.25714 12.1905 6.09524 12.1905C6.93333 12.1905 7.61905 11.5048 7.61905 10.6667C7.61905 9.82857 6.93333 9.14286 6.09524 9.14286Z"
                                fill="#FDFDFE"/>
                    </svg>
                </div>

                <input
                        name="password"
                        @input="registerForm.setPassword($event.target.value)"
                        :value="registerForm.password"
                        :type="registerForm.passwordVisible ? 'text' : 'password'"
                        placeholder="<?php echo esc_attr(tdf_string('password')); ?>*"
                >

                <?php if ($lstCurrentWidget instanceof \Tangibledesign\Listivo\Widgets\General\LoginAndRegisterWidget && $lstCurrentWidget->showPasswordToggle()) : ?>
                    <button
                            type="button"
                            class="listivo-input-v2__clear listivo-input-v2__password-toggle"
                            :aria-label="registerForm.passwordVisible ? '<?php echo esc_js(tdf_string('hide_password')); ?>' : '<?php echo esc_js(tdf_string('show_password')); ?>'"
                            @click="registerForm.togglePasswordVisibility"
                    >
                        <i class="far" :class="registerForm.passwordVisible ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                <?php endif; ?>

                <template>
                    <div
                            v-if="registerForm.showErrors && (!registerForm.errors.password.required || !registerForm.errors.password.minLength)"
                            class="listivo-input-v2__error listivo-field-error"
                    >
                        <div class="listivo-field-error__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9"
                                 fill="none">
                                <path
                                        d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                        fill="#FDFDFE"/>
                                <path
                                        d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                        fill="#F09965"/>
                            </svg>
                        </div>

                        <template v-if="!registerForm.errors.password.required">
                            <?php echo esc_html(tdf_string('field_is_required')); ?>
                        </template>

                        <template v-if="!registerForm.errors.password.minLength">
                            <?php echo esc_html(tdf_string('password_min_letters')); ?>
                        </template>
                    </div>
                </template>
            </div>

            <?php if (tdf_settings()->isAccountTypeEnabled()) : ?>
                <?php if (
                    !($lstCurrentWidget instanceof LoginAndRegisterWidget)
                    || $lstCurrentWidget->showAccountTypeSelect()
                ) : ?>
                    <lst-select
                            :options="<?php echo htmlspecialchars(json_encode([
                                [
                                    'name' => tdf_string('private_account_type'),
                                    'value' => 'regular',
                                ],
                                [
                                    'name' => tdf_string('business'),
                                    'value' => 'business',
                                ]
                            ])); ?>"
                            @input="registerForm.setAccountType"
                            active-text-class="listivo-select-v2__option--highlight-text"
                            highlight-option-class="listivo-select-v2__option--highlight"
                            :is-selected="registerForm.isAccountType"
                            order-type="custom"
                    >
                        <div
                                slot-scope="select"
                                @click="select.onOpen"
                                @focusin="select.focusIn"
                                @focusout="select.focusOut"
                                @keyup.esc="select.onClose"
                                @keyup.up="select.decreaseOptionIndex"
                                @keyup.down="select.increaseOptionIndex"
                                @keyup.enter="select.setOptionByIndex"
                                tabindex="0"
                                class="listivo-login-form__field listivo-select-v2 listivo-select-v2--with-icon"
                                :class="{
                                'listivo-select-v2--open':  select.open,
                            }"
                        >
                            <div class="listivo-select-v2__icon listivo-icon-v2">
                                <i class="far fa-address-card"></i>
                            </div>

                            <div class="listivo-select-v2__arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5"
                                     viewBox="0 0 7 5" fill="none">
                                    <path
                                            d="M3.5 2.56768L5.87477 0.192917C6.13207 -0.0643854 6.54972 -0.0643854 6.80702 0.192917C7.06433 0.45022 7.06433 0.86787 6.80702 1.12517L3.9394 3.99279C3.6964 4.2358 3.30298 4.2358 3.0606 3.99279L0.192977 1.12517C-0.0643257 0.86787 -0.0643257 0.45022 0.192977 0.192917C0.45028 -0.0643854 0.86793 -0.0643854 1.12523 0.192917L3.5 2.56768Z"
                                            fill="#2A3946"/>
                                </svg>
                            </div>

                            <template>
                                <div class="listivo-select-v2__placeholder">
                                    <div v-if="registerForm.accountType === 'regular'">
                                        <?php echo esc_html(tdf_string('private_account_type')); ?>
                                    </div>

                                    <div v-if="registerForm.accountType === 'business'">
                                        <?php echo esc_html(tdf_string('business')); ?>
                                    </div>
                                </div>

                                <div v-if="select.open" class="listivo-select-v2__dropdown">
                                    <div
                                            v-for="(option, index) in select.options"
                                            :key="option.id"
                                            @click="select.setOption(option)"
                                            class="listivo-select-v2__option"
                                            :class="{
                                            'listivo-select-v2__option--highlight': index === select.optionIndex,
                                            'listivo-select-v2__option--disabled': option.disabled && !option.selected,
                                        }"
                                    >
                                        <div class="listivo-select-v2__value" v-html="option.label"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </lst-select>
                <?php endif; ?>

                <?php if (tdf_settings()->isFullNameEnabledForBusinessAccount() && (tdf_settings()->isFullNameRequiredForBusinessAccount() || tdf_settings()->showFullNameFieldOnRegisterFormForBusinessAccount())) : ?>
                    <template>
                        <div
                                v-if="registerForm.accountType === 'business'"
                                class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon"
                                :class="{
                                    'listivo-input-v2--error': registerForm.showErrors && (registerForm.errors.firstName && !registerForm.errors.firstName.required)
                                }"
                        >
                            <div class="listivo-input-v2__icon listivo-icon-v2">
                                <i class="far fa-id-card"></i>
                            </div>

                            <input
                                    @input="registerForm.setFirstName($event.target.value)"
                                    :value="registerForm.firstName"
                                    type="text"
                                <?php if (tdf_settings()->isFullNameRequiredForBusinessAccount()) : ?>
                                    placeholder="<?php echo esc_attr(tdf_string('first_name')); ?>*"
                                <?php else : ?>
                                    placeholder="<?php echo esc_attr(tdf_string('first_name')); ?>"
                                <?php endif; ?>
                            >

                            <div
                                    v-if="registerForm.showErrors && (registerForm.errors.firstName && !registerForm.errors.firstName.required)"
                                    class="listivo-input-v2__error listivo-field-error"
                            >
                                <div class="listivo-field-error__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9"
                                         fill="none">
                                        <path
                                                d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                                fill="#FDFDFE"/>
                                        <path
                                                d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                                fill="#F09965"/>
                                    </svg>
                                </div>

                                <template
                                        v-if="registerForm.errors.firstName && !registerForm.errors.firstName.required">
                                    <?php echo esc_html(tdf_string('field_is_required')); ?>
                                </template>
                            </div>
                        </div>

                        <div
                                v-if="registerForm.accountType === 'business'"
                                class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon"
                                :class="{
                                    'listivo-input-v2--error': registerForm.showErrors && (registerForm.errors.lastName && !registerForm.errors.lastName.required)
                                }"
                        >
                            <div class="listivo-input-v2__icon listivo-icon-v2">
                                <i class="far fa-id-card"></i>
                            </div>

                            <input
                                    name="email"
                                    @input="registerForm.setLastName($event.target.value)"
                                    :value="registerForm.lastName"
                                    type="text"
                                <?php if (tdf_settings()->isFullNameRequiredForBusinessAccount()) : ?>
                                    placeholder="<?php echo esc_attr(tdf_string('last_name')); ?>*"
                                <?php else : ?>
                                    placeholder="<?php echo esc_attr(tdf_string('last_name')); ?>"
                                <?php endif; ?>
                            >

                            <div
                                    v-if="registerForm.showErrors && (registerForm.errors.lastName && !registerForm.errors.lastName.required)"
                                    class="listivo-input-v2__error listivo-field-error"
                            >
                                <div class="listivo-field-error__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9"
                                         fill="none">
                                        <path
                                                d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                                fill="#FDFDFE"/>
                                        <path
                                                d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                                fill="#F09965"/>
                                    </svg>
                                </div>

                                <template v-if="registerForm.errors.lastName && !registerForm.errors.lastName.required">
                                    <?php echo esc_html(tdf_string('field_is_required')); ?>
                                </template>
                            </div>
                        </div>
                    </template>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Custom Fields for Business Account -->
            <template>
                <div v-if="registerForm.accountType === 'business'">
                    
                    <!-- Company Name -->
                    <div class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon">
                        <div class="listivo-input-v2__icon listivo-icon-v2">
                            <i class="far fa-building"></i>
                        </div>
                        <input type="text" name="agency_name" class="listivo-extra-field" placeholder="Company Name *" required>
                    </div>

                    <!-- Business Trading Name -->
                    <div class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon">
                        <div class="listivo-input-v2__icon listivo-icon-v2">
                            <i class="far fa-id-badge"></i>
                        </div>
                        <input type="text" name="business_trading_name" class="listivo-extra-field" placeholder="Business Trading Name *" required>
                    </div>

                    <!-- Director Name -->
                    <div class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon">
                        <div class="listivo-input-v2__icon listivo-icon-v2">
                            <i class="far fa-user"></i>
                        </div>
                        <input type="text" name="director_name" class="listivo-extra-field" placeholder="Director Name *" required>
                    </div>

                    <!-- Address -->
                    <div class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon">
                        <div class="listivo-input-v2__icon listivo-icon-v2">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <input type="text" name="address" class="listivo-extra-field" placeholder="Address *" required>
                    </div>

                    <!-- Website -->
                    <div class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon">
                        <div class="listivo-input-v2__icon listivo-icon-v2">
                            <i class="fas fa-globe"></i>
                        </div>
                        <input type="url" name="website_url" class="listivo-extra-field" placeholder="Website (full url with http)">
                    </div>

                </div>
            </template>

            <?php if (tdf_settings()->isCompanyInformationEnabled() && (tdf_settings()->requireCompanyInformation() || tdf_settings()->showCompanyInformationFieldOnRegisterForm())) : ?>
                <template>
                    <div v-if="registerForm.accountType === 'business'" class="listivo-login-form__field">
                        <div
                                class="listivo-textarea"
                            <?php if (tdf_settings()->requireCompanyInformation()) : ?>
                                :class="{
                                    'listivo-textarea--error': registerForm.showErrors && (registerForm.errors.companyInformation && !registerForm.errors.companyInformation.required)
                                }"
                            <?php endif; ?>
                        >
                            <textarea
                                    @input="registerForm.setCompanyInformation($event.target.value)"
                                    :value="registerForm.companyInformation"
                                    cols="30"
                                    rows="10"
                                <?php if (tdf_settings()->requireCompanyInformation()) : ?>
                                    placeholder="More information...*"
                                <?php else : ?>
                                    placeholder="More information..."
                                <?php endif; ?>
                            ></textarea>

                            <?php if (tdf_settings()->requireCompanyInformation()) : ?>
                                <div
                                        v-if="registerForm.showErrors && (registerForm.errors.companyInformation && !registerForm.errors.companyInformation.required)"
                                        class="listivo-textarea__error listivo-field-error"
                                >
                                    <div class="listivo-field-error__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9"
                                                fill="none">
                                            <path
                                                    d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                                    fill="#FDFDFE"/>
                                            <path
                                                    d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                                    fill="#F09965"/>
                                        </svg>
                                    </div>

                                    <template v-if="registerForm.errors.companyInformation && !registerForm.errors.companyInformation.required">
                                        <?php echo esc_html(tdf_string('field_is_required')); ?>
                                    </template>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </template>
            <?php endif; ?>

            <?php if (tdf_settings()->isFullNameEnabledForPrivateAccount() && (tdf_settings()->isFullNameRequiredForPrivateAccount() || tdf_settings()->showFullNameFieldOnRegisterFormForPrivateAccount())) : ?>
                <template>
                    <div
                            v-if="registerForm.accountType === 'regular'"
                            class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon"
                            :class="{
                                'listivo-input-v2--error': registerForm.showErrors && (registerForm.errors.firstName && !registerForm.errors.firstName.required)
                            }"
                    >
                        <div class="listivo-input-v2__icon listivo-icon-v2">
                            <i class="far fa-id-card"></i>
                        </div>

                        <input
                                name="email"
                                @input="registerForm.setFirstName($event.target.value)"
                                :value="registerForm.firstName"
                                type="text"
                            <?php if (tdf_settings()->isFullNameRequiredForPrivateAccount()) : ?>
                                placeholder="<?php echo esc_attr(tdf_string('first_name')); ?>*"
                            <?php else : ?>
                                placeholder="<?php echo esc_attr(tdf_string('first_name')); ?>"
                            <?php endif; ?>
                        >

                        <div
                                v-if="registerForm.showErrors && (registerForm.errors.firstName && !registerForm.errors.firstName.required)"
                                class="listivo-input-v2__error listivo-field-error"
                        >
                            <div class="listivo-field-error__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9"
                                     fill="none">
                                    <path
                                            d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                            fill="#FDFDFE"/>
                                    <path
                                            d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                            fill="#F09965"/>
                                </svg>
                            </div>

                            <template v-if="registerForm.errors.firstName && !registerForm.errors.firstName.required">
                                <?php echo esc_html(tdf_string('field_is_required')); ?>
                            </template>
                        </div>
                    </div>

                    <div
                            v-if="registerForm.accountType === 'regular'"
                            class="listivo-login-form__field listivo-input-v2 listivo-input-v2--with-icon"
                            :class="{
                                'listivo-input-v2--error': registerForm.showErrors && (registerForm.errors.lastName && !registerForm.errors.lastName.required)
                            }"
                    >
                        <div class="listivo-input-v2__icon listivo-icon-v2">
                            <i class="far fa-id-card"></i>
                        </div>

                        <input
                                name="email"
                                @input="registerForm.setLastName($event.target.value)"
                                :value="registerForm.lastName"
                                type="text"
                            <?php if (tdf_settings()->isFullNameRequiredForPrivateAccount()) : ?>
                                placeholder="<?php echo esc_attr(tdf_string('last_name')); ?>*"
                            <?php else : ?>
                                placeholder="<?php echo esc_attr(tdf_string('last_name')); ?>"
                            <?php endif; ?>
                        >

                        <div
                                v-if="registerForm.showErrors && (registerForm.errors.lastName && !registerForm.errors.lastName.required)"
                                class="listivo-input-v2__error listivo-field-error"
                        >
                            <div class="listivo-field-error__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9"
                                     fill="none">
                                    <path
                                            d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                            fill="#FDFDFE"/>
                                    <path
                                            d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                            fill="#F09965"/>
                                </svg>
                            </div>

                            <template v-if="registerForm.errors.lastName && !registerForm.errors.lastName.required">
                                <?php echo esc_html(tdf_string('field_is_required')); ?>
                            </template>
                        </div>
                    </div>
                </template>
            <?php endif; ?>

            <?php if (!empty(tdf_settings()->getPolicyLabel()) || tdf_settings()->isMarketingConsentsEnabled()) : ?>
                <div class="listivo-login-form__bottom">
                    <?php if (!empty(tdf_settings()->getPolicyLabel())) : ?>
                        <div class="listivo-login-form__policy">
                            <div
                                    @click.stop.prevent="registerForm.setTermsAccept"
                                    class="listivo-login-form__checkbox listivo-checkbox"
                                    :class="{'listivo-checkbox--checked': registerForm.termsAccept}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                     fill="none">
                                    <path
                                            d="M11.7142 0.779513L10.6378 0.103783C10.3399 -0.0824758 9.93186 -0.011004 9.73252 0.261887L4.45585 7.44801L2.03093 5.20858C1.77765 4.97467 1.3649 4.97467 1.11162 5.20858L0.18996 6.05974C-0.06332 6.29364 -0.06332 6.67482 0.18996 6.9109L3.91881 10.3545C4.12753 10.5473 4.45585 10.6945 4.75135 10.6945C5.04684 10.6945 5.34468 10.5235 5.53698 10.2657L11.8877 1.61335C12.0894 1.34046 12.012 0.965772 11.7142 0.779513Z"
                                            fill="#FDFDFE"/>
                                </svg>
                            </div>

                            <?php echo wp_kses_post(tdf_settings()->getPolicyLabel()); ?>

                            <template>
                                <div v-if="registerForm.showErrors">
                                    <div
                                            class="listivo-login-form__checkbox-error"
                                            v-if="!registerForm.errors.termsAccept.sameAs"
                                    >
                                        <?php echo esc_html(tdf_string('must_accept_privacy_policy')); ?>
                                    </div>
                                </div>
                            </template>
                        </div>
                    <?php endif; ?>

                    <?php if (tdf_settings()->isMarketingConsentsEnabled()) : ?>
                        <div class="listivo-login-form__marketing-consent">
                            <div class="listivo-login-form__marketing-consent-checkbox">
                                <div
                                        @click.stop.prevent="registerForm.setMarketingConsent"
                                        class="listivo-login-form__checkbox listivo-checkbox"
                                        :class="{'listivo-checkbox--checked': registerForm.marketingConsent}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                         fill="none">
                                        <path
                                                d="M11.7142 0.779513L10.6378 0.103783C10.3399 -0.0824758 9.93186 -0.011004 9.73252 0.261887L4.45585 7.44801L2.03093 5.20858C1.77765 4.97467 1.3649 4.97467 1.11162 5.20858L0.18996 6.05974C-0.06332 6.29364 -0.06332 6.67482 0.18996 6.9109L3.91881 10.3545C4.12753 10.5473 4.45585 10.6945 4.75135 10.6945C5.04684 10.6945 5.34468 10.5235 5.53698 10.2657L11.8877 1.61335C12.0894 1.34046 12.012 0.965772 11.7142 0.779513Z"
                                                fill="#FDFDFE"/>
                                    </svg>
                                </div>
                            </div>

                            <div>
                                <div
                                        class="listivo-login-form__marketing-consent-text"
                                        @click.stop.prevent="registerForm.setMarketingConsent"
                                >
                                    <?php echo wp_kses_post(tdf_settings()->getMarketingConsentsLabel()); ?>
                                </div>
                            </div>
                        </div>

                        <?php if (tdf_settings()->isMarketingConsentsRequired()) : ?>
                            <template>
                                <div v-if="registerForm.showErrors">
                                    <div
                                            class="listivo-login-form__checkbox-error"
                                            v-if="!registerForm.errors.marketingConsent.sameAs"
                                    >
                                        <?php echo esc_html(tdf_string('must_accept_marketing_consents')); ?>
                                    </div>
                                </div>
                            </template>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="listivo-login-form__button">
                <button
                    <?php if (tdf_current_kit()->get_settings_for_display('login_button_type') === 'primary_1') : ?>
                        class="listivo-simple-button listivo-simple-button--background-primary-1 listivo-button-primary-1-selector listivo-simple-button--full-width listivo-simple-button--height-60"
                    <?php else : ?>
                        class="listivo-simple-button listivo-simple-button--background-primary-2 listivo-button-primary-2-selector listivo-simple-button--full-width listivo-simple-button--height-60"
                    <?php endif; ?>
                        :class="{'listivo-simple-button--loading': registerForm.inProgress}"
                        :disabled="registerForm.inProgress"
                >
                    <span v-if="!registerForm.inProgress">
                        <?php echo esc_html(tdf_string('register')); ?>
                    </span>

                    <template>
                        <svg
                                v-if="registerForm.inProgress"
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
                <?php echo esc_html__("Already have an account?", 'listivo'); ?>
                <a href="<?php echo esc_url(wp_login_url()); ?>" class="listivo-login-form__login-link" style="font-weight: 600;">
                    <?php echo esc_html__('Login', 'listivo'); ?>
                </a>
            </div>
        </form>
    </div>
</lst-register>
<script type="text/javascript">
    jQuery(function($) {
        $.ajaxPrefilter(function(options, originalOptions, jqXHR) {
            if (options.url && options.url.indexOf('listivo/user/register') !== -1) {
                var extraData = {};
                $('.listivo-extra-field').each(function() {
                    // Only include if visible (business account selected)
                    if ($(this).is(':visible')) {
                        extraData[$(this).attr('name')] = $(this).val();
                    }
                });
                
                if (!$.isEmptyObject(extraData)) {
                     var extraStr = $.param(extraData);
                     if (typeof options.data === 'string') {
                         options.data += '&' + extraStr;
                     } else if (typeof options.data === 'object') {
                         $.extend(options.data, extraData);
                     }
                }
            }
        });
    });
</script>

