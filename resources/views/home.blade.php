@extends('layout.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/glide.core.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/glide.theme.min.css') }}">
@endsection

@section('content')
    <div class="w-full h-full overflow-auto">

        <div class="w-[90%] mx-auto md:w-1/2 py-5 text-black dark:text-white">

            {{-- Carousel --}}
            <div class="glide text-center">

                <h1 class="dark:text-white text-black mb-10 text-2xl font-semibold">Featured Products</h1>
                <div class="glide__track md:text-left" data-glide-el="track">
                    <ul class="glide__slides">
                        @foreach ($featured_products as $product)
                            <li class="glide__slide">
                                <a href="{{ route('product', ['id' => $product->id]) }}">
                                    <div class="min-w-0 w-3/4 md:w-2/3 mx-auto flex flex-col items-center gap-10">

                                        <div class="w-full rounded-md">
                                            @if (str_starts_with($product->image, 'https:'))
                                                <img src="{{ $product->image }}" alt=""
                                                    class="object-cover w-full h-full">
                                            @else
                                                <img src="{{ asset("images/$product->image") }}" alt=""
                                                    class="object-cover w-full h-full">
                                            @endif
                                        </div>
                                        <div
                                            class="flex flex-col md:flex-row space-y-4 space-x-16 text-black dark:text-gray-50">
                                            <div class="md:flex-[70%] flex flex-col gap-3">

                                                <h1>{{ $product->title }}</h1>
                                                <span>$ {{ $product->price }}</span>
                                                <p class="hidden md:block">
                                                    {{ $product->description }}</p>
                                            </div>
                                            <div
                                                class="grid grid-cols-1 md:grid-cols-2 text-left gap-x-10 md:gap-y-4 md:flex-[30%]">
                                                <span><i class="fa-regular fa-calendar"></i> Added:
                                                    {{ $product->created_at->diffForHumans() }}</span>
                                                <span><i class="fa-solid fa-star"></i> Rating:
                                                    {{ $product->average_rating }}</span>
                                                <span><i class="fa-solid fa-star"></i> Reviews:
                                                    {{ $product->reviews->count() }}</span>
                                                <span><i class="fa-solid fa-box"></i> Quantity in stock:
                                                    {{ $product->quantity_in_stock }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div data-glide-el="controls">
                    <button class="glide__arrow bg-white glide__arrow--left" data-glide-dir="<">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            class="fill-black dark:fill-white">
                            <path d="M0 12l10.975 11 2.848-2.828-6.176-6.176H24v-3.992H7.646l6.176-6.176L10.975 1 0 12z">
                            </path>
                        </svg>
                    </button>

                    <button class="glide__arrow bg-white glide__arrow--right" data-glide-dir=">">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            class="fill-black dark:fill-white">
                            <path
                                d="M13.025 1l-2.847 2.828 6.176 6.176h-16.354v3.992h16.354l-6.176 6.176 2.847 2.828 10.975-11z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex justify-between mt-20">
                <h1 class="text-2xl font-bold">Recommended for you</h1>
                <a href="/"
                    class="py-2 px-6 text-sm text-white dark:bg-blue-600 bg-black shadow-lg rounded-xl transition duration-200 hover:bg-blue-800 dark:hover:bg-blue-800"><i
                        class="fa-solid fa-shop"></i> Shop
                    now</a>
            </div>
        </div>

        <div id="recommended-products"></div>

        @viteReactRefresh
        @vite('resources/js/HomePageProducts.jsx')
    </div>
@endsection

@section('js')
    <script>
        const bladeBookmarkedProducts = @json($bookmarked_products);
        const bladeRecommendedProducts = @json($recommended_products);
        bladeCart = @json($cart);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
    <script>
        const config = {
            type: 'carousel',
            startAt: 0,
            perView: 1,
            hoverpause: true,
            autoplay: 3000,
        }
        new Glide('.glide', config).mount()
    </script>
    <script>
        @if (session()->has('success'))

            Toastify({
                text: "{{ session('success') }}",
                duration: 2000,

                newWindow: true,
                close: true,
                gravity: "bottom",
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
