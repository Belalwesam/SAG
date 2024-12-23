<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" data-theme="theme-default"
    data-assets-path="/dashboard/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login To Client Portal</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">


    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendor/css/rtl/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('/dashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('/dashboard/assets/vendor/js/helpers.js') }}"></script>

    <script src="{{ asset('/dashboard/assets/js/config.js') }}"></script>
    <style>
        body,
        html,
        * {
            font-family: "Tajawal", serif !important;
        }

        .authentication-inner::before,
        .authentication-inner::after {
            display: none;
        }
    </style>
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="" class="app-brand-link gap-2">
                                <img src="{{ asset('icon.png') }}" alt="" width="160px">
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">@lang('auth.welcome') 🚀</h4>
                        <p class="mb-4">@lang('auth.welcome_sub')</p>

                        <form id="formAuthentication" class="mb-3" action="{{ route('client.login') }}"
                            method="POST">

                            @if (session('processFail'))
                                <div class="alert alert-solid-danger alert-dismissible d-flex align-items-center pe-0"
                                    role="alert">
                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                                    @lang('auth.login_failed')
                                </div>
                            @endif
                            @csrf
                            <div class="mb-3">
                                <input type="text" class="form-control" id="email" name="login_field"
                                    placeholder="@lang('auth.login_field')" />
                                @error('login_field')
                                    <small class="fw-bold text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">@lang('auth.password')</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                    <small class="fw-bold text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <button class="btn btn-primary d-grid w-100" type="submit">@lang('auth.login')</button>

                            <p class="mt-4 px-4">@lang('auth.working_hours')</p>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('/dashboard/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('/dashboard/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('/dashboard/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/dashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('/dashboard/assets/vendor/libs/hammer/hammer.js') }}"></script>

    <script src="{{ asset('/dashboard/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('/dashboard/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ asset('/dashboard/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Notifications js function -->
    <script src="{{ asset('dashboard/js/notifications-helper.js') }}"></script>
    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('/dashboard/assets/js/main.js') }}"></script>
</body>

</html>
