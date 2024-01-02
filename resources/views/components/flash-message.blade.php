@if (session()->has('success'))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show"
         class="fixed bg-blue-500 bottom-3 right-3 py-2 px-4 text-white text-sm rounded-xl">
        <p>{{ session()->get('success') }}</p>
    </div>
@endif
