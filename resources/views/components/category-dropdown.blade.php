<x-dropdown>
    <x-slot name="trigger">
        <button class="py-2 pl-3 pr-9 w-full lg:w-32 text-sm font-semibold text-left lg:inline-flex">
            {{ isset($currentCategory) ? ucwords($currentCategory->name) : 'Categories' }}
            <x-icon name="down-arrow" class="pointer-events-none inline-flex" style="right: 12px;"/>
        </button>
    </x-slot>

    <x-dropdown-item href="/?{{ http_build_query(request()->except('category', 'page')) }}">All</x-dropdown-item>

    @foreach ($categories as $category)
        <a href="/?category={{ $category->slug }}&{{ http_build_query(request()->except('category', 'page')) }}"
           class="block text-sm text-left px-3 hover:bg-blue-500 focus:bg-blue-500 hover:text-white focus:text-white leading-6">
            {{ ucwords($category->name) }}
        </a>
    @endforeach
</x-dropdown>
