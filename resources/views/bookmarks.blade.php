@extends('layout.master')

@section('content')
    <div class="w-[80%] mx-auto text-black dark:text-white my-10">
        @guest
            <h2 class="font-semibold text-2xl mb-10">Please login first to see your bookmarks.</h2>
            <a href="{{ route('login') }}"
                class="py-2 px-6 text-sm text-white dark:bg-blue-600 bg-black shadow-lg rounded-xl transition duration-200 hover:bg-blue-800 dark:hover:bg-blue-800">Login</a>
        @endguest
        @auth

            <h2 class="font-semibold text-2xl mb-10">Bookmarked Products</h2>
            <div id="bookmarked__products"></div>
            @viteReactRefresh
            @vite('resources/js/BookmarkedProducts.jsx')
        @endauth
    </div>
@endsection

@section('js')
    <script>
        const bladeBookmarkedProducts = @json($bookmarked_products);
        bladeCart = @json($cart);
    </script>
@endsection
