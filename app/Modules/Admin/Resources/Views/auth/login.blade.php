@extends('admin::layouts.layout')

@section('content')
    <!-- Login Background -->
    <div id="login-background">
        <!-- For best results use an image with a resolution of 2560x400 pixels (prefer a blurred image for smaller file size) -->
        <img src="{{ asset(config('admin.login_background_image')) }}" alt="Login Background" class="animation-pulseSlow">
    </div>
    <!-- END Login Background -->

    <!-- Login Container -->
    <div id="login-container">
        <!-- Login Title -->
        <div class="login-title text-center">
            <h1><i class="gi gi-flash"></i> <strong>{{ config('admin.project_name') }}</strong><br>
                <small>გთხოვთ, გაიაროთ <strong>ავტორიზაცია</strong></small>
            </h1>
        </div>
        <!-- END Login Title -->

        <!-- Login Block -->
        <div class="block push-bit">
            <!-- Login Form -->
            <form class="form-horizontal form-bordered form-control-borderless" id="form-login" method="POST"
                  action="{{ route('admin.login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                            <input type="text" id="login-email" name="email" value="{{ old('email') }}" class="form-control input-lg" placeholder="ელ. ფოსტა">
                        </div>

                        @if ($errors->has('email'))
                            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                            <input type="password" id="login-password" name="password" class="form-control input-lg"
                                   placeholder="პაროლი">
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-xs-4">
                        <label class="switch switch-primary" data-toggle="tooltip" title="დამიმახსოვრე">
                            <input type="checkbox" id="login-remember-me" name="remember"{{ old('remember') ? ' checked' : '' }}>
                            <span></span>
                        </label>
                    </div>
                    <div class="col-xs-8 text-right">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> ავტორიზაცია
                        </button>
                    </div>
                </div>

            </form>
            <!-- END Login Form -->
        </div>
        <!-- END Login Block -->

        <!-- Footer -->
        <footer class="text-muted text-center">
            <small><span id="year-copy"></span> &copy; <a href="{{ config('admin.handcrafted_by_url') }}" target="_blank">Handcrafted by {{ config('admin.handcrafted_by') }}</a>
            </small>
        </footer>
        <!-- END Footer -->
    </div>
    <!-- END Login Container -->
@endsection

@section('footer_scripts')
    <!-- Load and execute javascript code used only in this page -->
    <script src="{{ asset('admin_resources/js/pages/login.js')}}"></script>
    <script>
        $(function () {
            Login.init();
        });
    </script>
@endsection
