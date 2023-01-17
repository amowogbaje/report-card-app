<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary btn-lg btn-block  focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
