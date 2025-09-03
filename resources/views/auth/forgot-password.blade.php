<x-base-layout title='Forgot Password'>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    @endpush

    <form class="form" action="/forgot-password" method="POST">
        @csrf
        <p class="title">Forgot Password</p>
        <p class="message">Please enter your email address to receive a password reset link.</p>
        @if ($errors->any())
            <ul class="bg-red-100">
                @foreach ($errors->all() as $error)
                    <li class="my-2-text-red-500">{{ $error }} </li>
                @endforeach
            </ul>
        @endif
        @if (session('status'))
        <ul class="bg-green-100">
           <li class="my-2-text-green-500"> {{ session('status') }}</li>
        </ul>
        @endif
        <label>
            <input required="" placeholder="" name="email" type="email" class="input"
                value="{{ old('email') }}">{{-- old() protect the old value --}}
            <span>Email</span>
        </label>

        <button class="submit">Send</button>
    </form>
</x-base-layout>
