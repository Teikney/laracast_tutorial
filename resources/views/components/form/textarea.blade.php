@props(['name'])
<x-form.field>
    <x-form.label name="{{ $name }}"/>
    <textarea class="border border-gray-700 p-2 w-full" name="{{ $name }}" id="{{ $name }}" value="{{ old( $name) }}" required></textarea>
    <x-form.error name="{{ $name }}"/>
</x-form.field>
