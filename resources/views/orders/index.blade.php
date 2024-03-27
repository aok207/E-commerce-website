@extends('layout.master')

@section('content')
    <div class="min-w-0 p-4 m-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="flex justify-between items-center">

            <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                Your Orders
            </h4>
        </div>
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-4 mb-4">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Image</th>
                            <th class="px-4 py-3">Total Products</th>
                            <th class="px-4 py-3">Total Amounts</th>
                            <th class="px-4 py-3">Payment Status</th>
                            <th class="px-4 py-3">Order Status</th>
                            <th class="px-4 py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($orders as $order)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm w-[120px]">
                                        @if (str_starts_with($order->orderItems[0]->image, 'https:'))
                                            <img src="{{ $order->orderItems[0]->product->image }}"
                                                alt="{{ $order->orderItems[0]->product->title }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <img src="{{ asset('images/' . $order->orderItems[0]->product->image) }}"
                                                alt="{{ $order->orderItems[0]->product->title }}"
                                                class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $order->total_items }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    $ {{ $order->total_price }}
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    @if ($order->payment->payment_status === 'unpaid')
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                            {{ $order->payment->payment_status }}
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                            {{ $order->payment->payment_status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    @if ($order->order_status === 'delivered')
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                            {{ $order->order_status }}
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                            {{ $order->order_status }}
                                        </span>
                                    @endif

                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ date('d-M-y', strtotime($order->created_at)) }}
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('orders.show', ['id' => $order->id]) }}"
                                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple">View
                                        details</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        {{ $orders->links() }}
    </div>
@endsection

@section('js')
    <script>
        const bladeBookmarkedProducts = @json($bookmarked_products);
        bladeCart = @json($cart);
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
