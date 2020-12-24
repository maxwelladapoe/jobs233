@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="columns justify-content-center">
                <div class="column is-4-desktop is-offset-4-desktop">


                    <div class="has-text-centered mb-5">
                        <img src="/images/LOGO@2x.png" alt="" width="200px"/>

                    </div>
                    <div class="card">
                        <div class="card-header">

                            <p class="card-header-title">
                                {{ __('Reset Password') }}
                            </p>
                            </div>

                        <div class="card-content">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="field ">
                                    <label for="email" class="label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <input id="email" type="email" class="input @error('email') is-invalid @enderror"
                                           name="email" value="{{ $email ?? old('email') }}" required
                                           autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>

                                <div class="field row">
                                    <label for="password" class="label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="input @error('password')
                                            is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="field row">
                                    <label for="password-confirm" class="label text-md-right">{{ __('Confirm Password')
                            }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="input"
                                               name="password_confirmation"
                                               required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="field  mb-2 mt-5">
                                        <button type="submit" class="button is-primary">
                                            {{ __('Reset Password') }}
                                        </button>

                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
