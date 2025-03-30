@props(['title' => 'Plateforme Tourisme Maroc'])

<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
    
    {{ $slot }}
</x-layout>