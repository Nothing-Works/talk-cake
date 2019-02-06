@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is-mobile is-centered">
            <div class="column is-half">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Verify Your Email Address
                        </p>
                    </header>

                    <div class="card-content">
                        @if (session('resent'))
                            <div class="notification is-success" role="alert">
                                A fresh verification link has been sent to your email address.
                            </div>
                        @endif
                        Before proceeding, please check your email for a verification link.
                        If you did not receive the email, <a href="{{ route('verification.resend') }}">click here to
                            request another</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection