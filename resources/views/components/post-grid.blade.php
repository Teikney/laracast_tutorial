@props(['posts'])
<x-post-featured-card :post="$posts[0]"/>

@if ($posts->count() > 1)
    <div class="lg:grid lg:grid-cols-6">
        @foreach ($posts->skip(1) as $post)
            {{-- Laracast's way of getting the pretended result --}}
                <x-post-card
                    :post="$post"
                    class="{{ $loop->iteration < 3 ? 'col-span-3' : 'col-span-2' }}"
                />
            {{-- Teikney's way of getting the pretended result --}}
            {{-- @if ($loop->iteration < 3)
                <x-post-card :post="$post" class="col-span-3"/>
            @else
                <x-post-card :post="$post" class="col-span-2"/>
            @endif --}}
        @endforeach
    </div>
@endif
