@extends('layout.master')

@section('content')
    <div id="product" class="w-full h-full overflow-auto"></div>
    @viteReactRefresh
    @vite('resources/js/ProductPage.jsx')
@endsection

@section('js')
    <script>
        const bladeBookmarkedProducts = @json($bookmarked_products);
        bladeCart = @json($cart);
        const bladeProduct = @json($product);
        const diffForHuman = @json($product->created_at->diffForHumans());
        const bladeReviews = @json($reviews);
        const bladeRelatedProducts = @json($related_products);
    </script>
    <script>
        @if (session()->has('success'))

            Toastify({
                text: "{{ session('success') }}",
                duration: 2000,

                newWindow: true,
                close: true,
                gravity: "top",
                position: "center",
                stopOnFocus: true,
                style: {
                    background: "green",
                    color: "#fff",
                    fontSize: "16px",
                    textAlign: "center"
                },
            }).showToast();
        @endif
    </script>
@endsection
