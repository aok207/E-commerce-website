@extends('layout.master')

@section('content')
    <div class="w-full h-full overflow-auto">
        <div class="w-[80%] mx-auto text-black text-center lg:text-left dark:text-white my-10">
            @guest
                <h2 class="font-semibold text-2xl mb-10">Log in first to see your cart</h2>
                <a href="{{ route('login') }}"
                    class="py-2 px-6 text-sm text-white dark:bg-blue-600 bg-black shadow-lg rounded-xl transition duration-200 hover:bg-blue-800 dark:hover:bg-blue-800">Login</a>
            @endguest

            @auth
                <h2 class="font-semibold text-2xl mb-10">Your shopping cart</h2>
                @if ($cart)
                    <div id="cart"></div>
                    @viteReactRefresh
                    @vite('resources/js/Cart.jsx')
                @else
                    <p class="text-md font-bold text-slate-500">There is nothing in your cart right now.</p>
                @endif
            @endauth
        </div>
    </div>
@endsection

@section('js')
    <script>
        bladeCart = @json($cart);

        const bladeCartItems = @json($cart_items);
    </script>

    <script>
        @if (session()->has('error'))

            Toastify({
                text: "{{ session('error') }}",
                duration: 2000,

                newWindow: true,
                close: true,
                gravity: "bottom",
                position: "center",
                stopOnFocus: true,
                style: {
                    background: "red",
                    color: "#fff",
                    fontSize: "16px",
                    textAlign: "center"
                },
            }).showToast();
        @endif
    </script>
@endsection
