@extends('layout.master')

@section('content')
    <div class="min-w-0 p-4 m-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 text-2xl font-bold text-gray-600 dark:text-gray-300">
            Order id {{ $order->id }}
        </h4>
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-4 mb-4">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">
                                image
                            </th>
                            <th class="px-4 py-3">product name</th>
                            <th class="px-4 py-3">price</th>
                            <th class="px-4 py-3">quantity</th>
                            <th class="px-4 py-3">total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($order->orderItems as $order_item)
                            <tr class="text-gray-700 dark:text-gray-400 user-row">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm w-[120px]">
                                        @if (str_starts_with($order_item->product->image, 'https:'))
                                            <img src="{{ $order_item->product->image }}"
                                                alt="{{ $order_item->product->image }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="{{ asset('images/' . $order_item->product->image) }}" alt="">
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-wrap">
                                    {{ $order_item->product->title }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    ${{ $order_item->product->price }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $order_item->quantity }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    ${{ $order_item->quantity * $order_item->product->price }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>


        <div
            class="w-full overflow-hidden rounded-lg shadow-xs mt-4 mb-4 p-4 flex md:justify-around md:items-start flex-col md:flex-row">

            <div>
                <h4 class="mb-4 text-2xl font-bold text-gray-600 dark:text-gray-300">
                    Shipping
                </h4>
                <div class="text-black text-md dark:text-white">
                    <span class="text-purple-600 font-semibold">Order: </span>
                    {{ $order->id }}
                </div>
                <div class="text-black text-md dark:text-white">
                    <span class="text-purple-600 font-semibold">Name: </span>
                    {{ $order->user->name }}
                </div>
                <div class="text-black text-md dark:text-white">
                    <span class="text-purple-600 font-semibold">Email: </span>
                    {{ $order->payment->email }}
                </div>
                <div class="text-black text-md dark:text-white">
                    <span class="text-purple-600 font-semibold">Shipping Address: </span>
                    {{ $order->payment->shipping_address }}
                </div>
                <div class="text-black text-md dark:text-white">
                    <span class="text-purple-600 font-semibold">Zip Code: </span>
                    {{ $order->payment->zip_code }}
                </div>
                <div class="text-black text-md dark:text-white">
                    <span class="text-purple-600 font-semibold">City: </span>
                    {{ $order->payment->city }}
                </div>
                <div class="text-black text-md dark:text-white">
                    <span class="text-purple-600 font-semibold">Method: </span>
                    {{ $order->payment->payment_type }}
                </div>
            </div>


            <div class="overflow-hidden rounded-lg shadow-xs">
                <h4 class="mb-4 text-2xl font-bold text-gray-600 dark:text-gray-300 mt-6">
                    Order Summary
                </h4>
                <div class="text-black text-md flex gap-2 w-[50%] dark:text-white">
                    <span class="text-black dark:text-white font-semibold">Items: </span>
                    ${{ $order->payment->total_items_price }}
                </div>
                <div class="text-black text-md flex gap-2 w-[50%] dark:text-white">
                    <span class="text-black dark:text-white font-semibold">Shipping: </span>
                    ${{ $order->payment->shipping_fees }}
                </div>
                <div class="text-black text-md flex gap-2 w-[50%] dark:text-white">
                    <span class="text-black dark:text-white font-semibold">Tax: </span>
                    ${{ $order->payment->tax_fees }}
                </div>
                <hr class="my-4">
                <div class="text-black text-md flex gap-2 w-[50%] dark:text-white">
                    <span class="text-black dark:text-white font-semibold">Total: </span>
                    ${{ $order->payment->final_amount }}
                </div>

                @if ($order->payment->payment_status !== 'paid')
                    <form action="{{ route('paypal.processTransaction') }}" class="mt-4 ml-4" method="POST"
                        id="paypal-form">
                        @csrf
                        <input type="hidden" name="total_amount" value="{{ $order->total_price }}">
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <button type="submit"
                            class="bg-[#F7BE38] hover:bg-[#F7BE38]/90 focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-lg text-sm px-5 py-2 text-center inline-flex items-center dark:focus:ring-[#F7BE38]/50 me-2 mb-2">

                            <img src="{{ asset('paypal.png') }}" alt="paypal logo" class="w-20">
                        </button>
                    </form>
                @endif

            </div>
        </div>

        @if ($order->payment->payment_status === 'paid')
            <div class="w-full bg-green-500 text-sm rounded-md flex items-center text-white p-2">Paid on
                {{ $order->payment->updated_at }}</div>
        @else
            <div class="w-full text-sm bg-red-500 rounded-md flex items-center text-white p-2">Haven't paid yet.</div>
        @endif

    </div>
@endsection

@section('js')
    <script>
        const bladeBookmarkedProducts = @json($bookmarked_products);
        bladeCart = @json($cart);

        // Loading after clicking paypal
        const paypalForm = document.getElementById('paypal-form');

        if (paypalForm) {
            paypalForm.addEventListener('submit', () => {
                document.getElementById('loading').classList.remove('hidden', 'opacity-0');
                document.getElementById('loading').classList.add('flex', 'opacity-100');
            });
        }
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
