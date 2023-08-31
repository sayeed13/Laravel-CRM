<x-admin-layout>

    <x-slot name="header">
        <h3 class="page-title">
            Welcome {{ auth()->user()->name }}
        </h3>
    </x-slot>

    @include('profile.partials.personal-info')

    @include('profile.partials.profile-tab')



</x-admin-layout>

