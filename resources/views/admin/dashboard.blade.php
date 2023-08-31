<x-admin-layout>
    <x-slot name="header">
        <h1 class="page-title text-center h1">
            Welcome Back, {{ auth()->user()->name }}!
        </h1>
    </x-slot>

    
</x-admin-layout>