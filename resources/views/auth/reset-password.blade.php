<x-base-layout title='Reset Password'>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    @endpush

    <form class="form" action="/reset-password" method="POST">
        @csrf
        <p class="title">Reset Password</p>
        <p class="message">Please enter your new password below to complete the reset process.</p>
        @if ($errors->any())
            <ul class="bg-red-100">
                @foreach ($errors->all() as $error)
                    <li class="my-2-text-red-500">{{ $error }} </li>
                @endforeach
            </ul>
        @endif
        <label>
            <input required="" placeholder="" name="email" type="email" class="input"
                value="{{ old('email') }}">{{-- old() protect the old value --}}
            <span>Email</span>
        </label>
        <label>
            <input required="" placeholder="" name="password" type="password" class="input">
            <span>Password</span>
        </label>
        <label>
            <input required="" placeholder="" name="password_confirmation" type="password" class="input">
            <span>Confirm password</span>
        </label>
        <label>
            <input required="" placeholder="" name="token" type="hidden" class="input" value="{{ $token }}">
        </label>

        <button class="submit">Send</button>
    </form>
</x-base-layout>
