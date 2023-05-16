<button {{ $attributes->merge(['type' => 'button', 'class' => ' items-center px-4 py-2
    bg-yellow-300 border border-gray-300 rounded-md font-medium font-semibold text-sm text-gray-700
    tracking-widest shadow-sm hover:bg-teal-100 focus:outline-none focus:ring-2 focus:ring-indigo-500
    focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 text-center']) }}>
    {{ $slot }}
</button>

