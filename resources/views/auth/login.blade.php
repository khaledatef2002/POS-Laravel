@section('title', __('site.sign-in'))
<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
    @include('partials.dashboard._head')
    <body>

        <div class="auth-page-wrapper pt-5">
            <!-- auth page bg -->
            <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
                <div class="bg-overlay"></div>
    
                <div class="shape">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                        <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                    </svg>
                </div>
            </div>
    
            <!-- auth page content -->
            <div class="auth-page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center mt-sm-5 mb-4 text-white-50">
                                <div>
                                    <a href="index.php" class="d-inline-block auth-logo">
                                        <img src="{{ asset('assets/dashboard') }}/images/logo-light.png" alt="" height="20">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
    
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card mt-4">
    
                                <div class="card-body p-4">
                                    <div class="text-center mt-2">
                                        <h5 class="text-primary">@lang('site.welcome-back') !</h5>
                                        <p class="text-muted">@lang('site.sign-in-to-continue')</p>
                                    </div>
                                    <div class="p-2 mt-3">
                                        <form action="{{ route('login') }}" method="post">
                                            @csrf
                                            <div class="mb-3 @if($errors->has('email')){{ 'has-error' }}@endif">
                                                <label for="email" class="form-label">@lang('site.email')</label>
                                                <input type="email" class="form-control" value="{{ old('email') }}" name="email" id="email" placeholder="@lang('site.email-placeholder')">
                                                @if($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
    
                                            <div class="mb-3 @if($errors->has('password')){{ 'has-error' }}@endif">
                                                <label class="form-label" for="password-input">@lang('site.password')</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="password" class="form-control pe-5 password-input" placeholder="@lang('site.password-placeholder')" id="password-input" name="password">
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                    @if($errors->has('password'))
                                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                                    @endif
                                                </div>
                                            </div>
    
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" value="1" id="auth-remember-check">
                                                <label class="form-check-label" for="auth-remember-check">@lang('site.remember-me')</label>
                                            </div>
    
                                            <div class="mt-4">
                                                <button class="btn btn-success w-100" type="submit">@lang('site.sign-in')</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end auth page content -->
    
            <!-- footer -->
            <footer class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <p class="mb-0 text-muted">&copy;
                                    <script>document.write(new Date().getFullYear())</script> Velzon. Crafted with by Themesbrand
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->
        </div>

        @include('partials.dashboard._jslibs')
    </body>

</html>