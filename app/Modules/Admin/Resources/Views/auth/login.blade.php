@extends('admin::layouts.layout')

@section('content')
    <img src="{{ asset(config('admin.login_background_image')) }}" alt="Login Background" class="full-bg">

    <div class="dk-container">
        <!-- Login Container -->
        <div id="login-container">
            <!-- Login Title -->

            <div class="login-title text-center">
                <img src="{{asset('img/baza-logo-white-cms.svg')}}" alt="" style="width: 100px;">

                <div>
                    <h1><strong class="title-bold">WEB</strong></h1>
                    <ul class="page-list regular">
                        <li><a href="#" target="_blank">Home</a></li>
                        <li><a href="#" target="_blank">Projects</a></li>
                        <li><a href="#" target="_blank">Media</a></li>
                        <li><a href="#" target="_blank">About</a></li>
                    </ul>

                </div>
                <h1><strong class="title-black">{{ config('admin.project_name') }} v.0</strong></h1>
            </div>

            <!-- END Login Title -->

            <!-- Login Block -->
            <div class="block push-bit">
                <div>
                    <h1 class="title-black cms"><strong>CMS <br/>login</strong></h1>
                    <!-- Login Form -->
                    <form class="form-horizontal form-bordered form-control-borderless" id="form-login" method="POST"
                          action="{{ route('admin.login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                    <input type="text" id="login-email" name="email" value="{{ old('email') }}" class="form-control" placeholder="mail">
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
                                    <input type="password" id="login-password" name="password" class="form-control"
                                           placeholder="password">
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
                                    <small style="font-size: 10px;font-weight: normal;">Remember Me</small>
                                </label>
                            </div>
                            <div class="col-xs-8 text-right">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Login to dashboard
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- END Login Form -->
            </div>
            <!-- END Login Block -->

            <!-- Footer -->
        <!-- <footer class="text-muted text-center">
            <small><span id="year-copy"></span> &copy; <a href="{{ config('admin.handcrafted_by_url') }}" target="_blank">Handcrafted by {{ config('admin.handcrafted_by') }}</a>
            </small>
        </footer> -->
            <!-- END Footer -->
        </div>
        <!-- END Login Container -->
    </div>
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
