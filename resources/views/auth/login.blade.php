<x-base-layout title='Log In'>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    @endpush


    {{-- <x-search-form>
    <x-slot:title>card1</x-slot>{{-- title and footer converted in a variable in my component
    {{-- value of default slot
    <x-slot:footer>footer1</x-slot>
</x-search-form> --}}



    <form class="form" action="{{ route('login') }}" method="POST">
        @csrf
        <p class="title">Login </p>
        @if (session('message'))
            <div class="alert alert-warning">
                {{ session('message') }}
            </div>
        @endif
        <p class="message">Log in now to access your account </p>
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

        <label>
            <input required="" placeholder="" name="password" type="password" class="input">
            <span>Password</span>
            <p class="signin1"> <a href="/forgot-password">Forgot Password</a> </p>
        </label>

        <button class="submit">Login</button>

        <div class="flex-row">
            <x-google-button />
            <x-fb-button />
        </div>


        <p class="signin">Don't have an account? <a href="{{ route('signup.show') }}">Click here to create one</a> </p>
    </form>
</x-base-layout>
