@props(['title'=>'','homepage'=>false])

<x-base-layout :title="$title" :homepage="$homepage">
    {{-- header --}}

   <x-layouts.header :homepage="$homepage"  />
    {{-- end header --}}

    <!-- home page slider -->
    {{ $firstpage }}
    <!-- end home page slider -->


    {{ $slot }}

    {{-- footer --}}

    <x-layouts.footer />

    {{-- end footer --}}



</x-base-layout>
