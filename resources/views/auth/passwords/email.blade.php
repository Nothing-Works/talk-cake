@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="columns is-mobile is-centered">
            <div class="column is-half">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Reset Password
                        </p>
                    </header>

                    <div class="card-content">
                        @if (session('status'))
                            <div class="notification is-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="field">
                                <label for="email" class="label">E-Mail Address</label>

                                <div class="control">
                                    <input id="email" type="email" class="input{{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}"
                                           required> @if ($errors->has('email'))
                                        <p class="help is-danger" role="alert">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <button type="submit" class="button is-primary">
                                        Send Password Reset Link
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection