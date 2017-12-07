@extends('default.layouts.frame')

@section('button')

@endsection


@section('content')
    <div class="login-container">
        <div class="p-l-50 m-l-10 p-r-50 m-r-10 m-t-40 sm-p-l-15 sm-p-r-15 sm-p-t-40 text-center">
            <div class="clearfix"></div>
            <form class="p-t-50 text-left col-md-push-1 col-md-10" role="form" method="POST" action="{{ url('/login') }}" autocomplete="off">
                {{ csrf_field() }}
                <div class="form-group text-white">
                    <label style="font-weight: 400;text-transform: none;font-size: 12px;font-family: 'Lato', sans-serif;">Username</label>
                    <div class="controls">
                        <input class="form-control custom-control text-bold-ter" name="username" value="{{ old('username') }}"  placeholder="Username" required="" type="name" autocomplete="off">
                    </div>
                </div>
                @if ($errors->has('username'))
                    <label class="error help-block">
                        <small>{{ $errors->first('username') }}</small>
                    </label>
                @endif
                <div class="form-group text-white">
                    <label style="font-weight: 400;text-transform: none;font-size: 12px;font-family: 'Lato', sans-serif;">Password</label>
                    <div class="controls">
                        <input class="form-control custom-control text-bold-ter" name="password" placeholder="Credentials" required="" type="password" autocomplete="off">
                    </div>
                </div>
                @if ($errors->has('password'))
                    <label class="error help-block">
                        <small>{{ $errors->first('password') }}</small>
                    </label>
                @endif
                <div class="row text-white hidden">
                    <div class="col-md-12 no-padding">
                        <div class="checkbox check-success">
                            <input id="checkbox-agree" type="checkbox" name="remember" required checked> <label for="checkbox-agree" style="font-family: 'Lato', sans-serif;">Keep Me Signed in</label>
                        </div>
                    </div>
                </div>

                <button class="btn btn-success btn-block m-t-30" style="background: #2432d5; border-color: #2432d5;font-family: 'Lato', sans-serif;font-weight: 600;color: #FFF;border-radius: 20px;" type="submit">LOG IN</button>
            </form>


        </div>
    </div>
@endsection
