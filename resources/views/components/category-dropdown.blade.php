<x-dropdown>
    <x-slot name="trigger">
        <button class="py-2 pl-3 pr-9 text-sm font-semibold w-full lg:w-32 text-left flex lg:inline-flex">

            {{ isset($currentCategory) ? ucwords($currentCategory->name) : "Categories" }}

            <x-icon name="down-arrow" class="absolute pointer-events-none" style="right: 12px;" />
        </button>
    </x-slot>


    <x-dropdown-item href="/" :active="isset($currentCategory) ? false : request()->routeIs('home')">All</x-dropdown-item>

    @foreach ($categories as $category)
    {{-- {{  ? 'bg-blue-500 text-white' : '' }} --}}
        <x-dropdown-item
            href="/?category={{ $category->slug }}"
            :active="isset($currentCategory) && $currentCategory->is($category)"
            {{-- Another way of doing
                    :active="request()->is('?category={$category->slug}')" --}}
        >

            {{ ucwords( $category->name ) }}

        </x-dropdown-item>
    @endforeach

</x-dropdown>