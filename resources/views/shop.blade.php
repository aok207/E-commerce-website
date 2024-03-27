@extends('layout.master')

@section('content')
    <div id="shop" class="overflow-hidden h-full"></div>
    @viteReactRefresh
    @vite('resources/js/Shop.jsx')
@endsection

@section('js')
    <script>
        const bladeBookmarkedProducts = @json($bookmarked_products);
        bladeCart = @json($cart);
        const bladeCategories = @json($categories);
    </script>
@endsection
