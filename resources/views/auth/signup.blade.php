<x-base-layout title='Sign Up'>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/signup.css') }}">
        |
    @endpush



    <form class="form" action="{{ route('signup') }}" method="POST">
        @csrf
        <p class="title">Register </p>
        <div>
            <!-- validation errors -->
            @if ($errors->any())
                <ul class="bg-red-100">
                    @foreach ($errors->all() as $error)
                        <li class="my-2-text-red-500">{{ $error }} </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="flex">
            <label>
                <input required="" placeholder="" name="first_name" type="text" class="input"
                    value="{{ old('first_name') }}">
                <span>Firstname</span>
            </label>

            <label>
                <input required="" placeholder="" name="last_name" type="text" class="input"
                    value="{{ old('last_name') }}">
                <span>Lastname</span>
            </label>
        </div>

        <label>
            <input required="" placeholder="" name="email" type="email" class="input"
                value="{{ old('email') }}">
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
            <input required="" placeholder="" name="phone" type="text" class="input"
                value="{{ old('phone') }}">
            <span>Phone Number</span>
        </label>
        <button class="submit">Submit</button>
        <div class="flex-row">
            <x-google-button />
            <x-fb-button />
        </div>
        <p class="signin">Already have an acount ? <a href="{{ route('login.show') }}">Click here to login</a> </p>
    </form>

</x-base-layout>
